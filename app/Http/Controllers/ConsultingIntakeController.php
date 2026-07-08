<?php

namespace App\Http\Controllers;

use App\Models\AutomationOpportunity;
use App\Models\BacklogItem;
use App\Models\Client;
use App\Models\CurrentProblem;
use App\Models\DocumentEvidence;
use App\Models\InternalEvaluation;
use App\Models\Lead;
use App\Models\ProcessModel;
use App\Models\ProcessStep;
use App\Models\SystemIntegration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ConsultingIntakeController extends Controller
{
    private const SECTIONS = [
        'cliente',
        'proceso',
        'as-is',
        'documentos',
        'automatizacion',
        'tareas',
    ];

    public function section(Request $request, string $section): View|RedirectResponse
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);

        if ($section !== 'cliente' && ! $this->currentClient()) {
            return redirect()->route('consulting-intake.section', ['section' => 'cliente']);
        }

        if (in_array($section, ['as-is', 'documentos', 'automatizacion', 'tareas'], true) && ! $this->currentProcess()) {
            return redirect()->route('consulting-intake.section', ['section' => 'proceso']);
        }

        $client = $this->currentClient();
        $process = $this->currentProcess();
        $leads = collect();
        $selectedLead = null;

        if ($section === 'cliente') {
            $leadId = trim((string) $request->query('lead', ''));
            $ruc = trim((string) $request->query('ruc', ''));
            $leads = Lead::latest()->limit(25)->get();

            if ($leadId !== '') {
                $selectedLead = Lead::with('client.processes')->find($leadId);
                if ($selectedLead?->client) {
                    $client = $selectedLead->client->loadCount('processes');
                }
            }

            if (! $selectedLead && $ruc !== '') {
                $client = Client::withCount('processes')->with('lead')->where('ruc', $ruc)->first() ?: $client;
                $selectedLead = $client?->lead;
            }

            if (! $selectedLead) {
                $selectedLead = $client?->lead;
            }
        }

        if ($process) {
            $process->load(['steps', 'systems', 'documents', 'problems', 'opportunities', 'evaluations', 'backlogItems']);
        }

        return view('intake.create', compact('section', 'client', 'process', 'leads', 'selectedLead'));
    }

    public function store(Request $request, string $section): RedirectResponse
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);

        return match ($section) {
            'cliente' => $this->storeClient($request),
            'proceso' => $this->storeProcess($request),
            'as-is' => $this->storeAsIs($request),
            'documentos' => $this->storeDocuments($request),
            'automatizacion' => $this->storeAutomation($request),
            'tareas' => $this->storeBacklog($request),
            default => abort(404),
        };
    }

    public function show(ProcessModel $process): View
    {
        $process->load([
            'client',
            'steps',
            'systems',
            'documents',
            'problems',
            'opportunities',
            'evaluations',
            'backlogItems',
        ]);

        return view('intake.show', compact('process'));
    }

    private function storeClient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lead_id' => ['nullable', 'string', 'exists:leads,id'],
            'business_name' => ['required', 'string', 'max:255'],
            'ruc' => ['required', 'string', 'max:20'],
            'industry' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'main_contact' => ['nullable', 'string', 'max:255'],
            'contact_role' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'client_notes' => ['nullable', 'string'],
        ]);

        $lead = ! empty($validated['lead_id']) ? Lead::find($validated['lead_id']) : null;
        $client = $this->currentClient();
        $payload = [
            'lead_id' => $lead?->id,
            'business_name' => $validated['business_name'],
            'industry' => $validated['industry'],
            'address' => $validated['address'] ?? null,
            'main_contact' => $validated['main_contact'] ?? null,
            'contact_role' => $validated['contact_role'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
            'notes' => $validated['client_notes'] ?? null,
        ];

        if ($client) {
            $client->update($payload + ['ruc' => $validated['ruc']]);
        } else {
            $client = Client::updateOrCreate(
                ['ruc' => $validated['ruc']],
                $payload
            );
        }

        session([
            'consulting_intake_client_id' => $client->id,
            'consulting_intake_process_id' => null,
        ]);

        return redirect()->route('consulting-intake.section', ['section' => 'proceso']);
    }

    private function storeProcess(Request $request): RedirectResponse
    {
        $client = $this->currentClientOrFail();

        $validated = $request->validate([
            'process_name' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'owner' => ['nullable', 'string', 'max:255'],
            'frequency' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'expected_result' => ['nullable', 'string'],
            'trigger_event' => ['nullable', 'string'],
            'validation_method' => ['nullable', 'string'],
        ]);

        $process = DB::transaction(function () use ($client, $validated): ProcessModel {
            $process = new ProcessModel();
            $process->fill([
                'name' => $validated['process_name'],
                'area' => $validated['area'] ?? null,
                'owner' => $validated['owner'] ?? null,
                'frequency' => $validated['frequency'] ?? null,
                'objective' => $validated['objective'] ?? null,
                'expected_result' => $validated['expected_result'] ?? null,
                'trigger_event' => $validated['trigger_event'] ?? null,
                'validation_method' => $validated['validation_method'] ?? null,
                'status' => 'intake',
            ]);
            $process->client()->associate($client);
            if ($client->lead_id) {
                $process->lead()->associate($client->lead_id);
            }
            $process->save();

            return $process;
        });

        session(['consulting_intake_process_id' => $process->id]);

        return redirect()->route('consulting-intake.section', ['section' => 'as-is']);
    }

    private function storeAsIs(Request $request): RedirectResponse
    {
        $process = $this->currentProcessOrFail();
        $client = $this->currentClientOrFail();

        $validated = $request->validate([
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['nullable', 'string'],
            'steps.*.owner' => ['nullable', 'string', 'max:255'],
            'steps.*.system_used' => ['nullable', 'string', 'max:255'],
            'steps.*.input' => ['nullable', 'string'],
            'steps.*.output' => ['nullable', 'string'],
            'steps.*.estimated_minutes' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'steps.*.evidence_generated' => ['nullable', 'string'],
            'steps.*.problems' => ['nullable', 'string'],
            'steps.*.automatable' => ['nullable', 'in:si,no,parcial'],
            'systems' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($process, $client, $validated, $request): void {
            $process->steps()->delete();
            $process->systems()->delete();

            foreach ($request->input('steps', []) as $index => $step) {
                if (! filled(Arr::get($step, 'description'))) {
                    continue;
                }

                ProcessStep::create([
                    'process_id' => $process->id,
                    'step_number' => $index + 1,
                    'description' => Arr::get($step, 'description'),
                    'owner' => Arr::get($step, 'owner'),
                    'system_used' => Arr::get($step, 'system_used'),
                    'input' => Arr::get($step, 'input'),
                    'output' => Arr::get($step, 'output'),
                    'estimated_minutes' => (int) Arr::get($step, 'estimated_minutes', 0),
                    'evidence_generated' => Arr::get($step, 'evidence_generated'),
                    'problems' => Arr::get($step, 'problems'),
                    'automatable' => Arr::get($step, 'automatable', 'parcial'),
                    'comments' => Arr::get($step, 'comments'),
                ]);
            }

            foreach ($request->input('systems', []) as $system) {
                if (! filled(Arr::get($system, 'name'))) {
                    continue;
                }

                SystemIntegration::create([
                    'client_id' => $client->id,
                    'process_id' => $process->id,
                    'name' => Arr::get($system, 'name'),
                    'url' => Arr::get($system, 'url'),
                    'system_type' => Arr::get($system, 'system_type'),
                    'has_api' => (bool) Arr::get($system, 'has_api', false),
                    'auth_type' => Arr::get($system, 'auth_type'),
                    'access_owner' => Arr::get($system, 'access_owner'),
                    'access_status' => Arr::get($system, 'access_status', 'pending'),
                    'notes' => Arr::get($system, 'notes'),
                ]);
            }
        });

        return redirect()->route('consulting-intake.section', ['section' => 'documentos']);
    }

    private function storeDocuments(Request $request): RedirectResponse
    {
        $process = $this->currentProcessOrFail();

        $request->validate([
            'documents' => ['nullable', 'array'],
            'problems' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($process, $request): void {
            $process->documents()->delete();
            $process->problems()->delete();

            foreach ($request->input('documents', []) as $document) {
                if (! filled(Arr::get($document, 'name'))) {
                    continue;
                }

                DocumentEvidence::create([
                    'process_id' => $process->id,
                    'name' => Arr::get($document, 'name'),
                    'type' => Arr::get($document, 'type'),
                    'format' => Arr::get($document, 'format'),
                    'location' => Arr::get($document, 'location'),
                    'owner' => Arr::get($document, 'owner'),
                    'mandatory' => (bool) Arr::get($document, 'mandatory', false),
                    'notes' => Arr::get($document, 'notes'),
                ]);
            }

            foreach ($request->input('problems', []) as $problem) {
                if (! filled(Arr::get($problem, 'description'))) {
                    continue;
                }

                CurrentProblem::create([
                    'process_id' => $process->id,
                    'description' => Arr::get($problem, 'description'),
                    'impact' => Arr::get($problem, 'impact'),
                    'frequency' => Arr::get($problem, 'frequency'),
                    'risk' => Arr::get($problem, 'risk'),
                    'comments' => Arr::get($problem, 'comments'),
                ]);
            }
        });

        return redirect()->route('consulting-intake.section', ['section' => 'automatizacion']);
    }

    private function storeAutomation(Request $request): RedirectResponse
    {
        $process = $this->currentProcessOrFail();

        $request->validate([
            'opportunities' => ['nullable', 'array'],
            'evaluation' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($process, $request): void {
            $process->opportunities()->delete();
            $process->evaluations()->delete();

            foreach ($request->input('opportunities', []) as $opportunity) {
                if (! filled(Arr::get($opportunity, 'activity'))) {
                    continue;
                }

                $current = (int) Arr::get($opportunity, 'current_time_minutes', 0);
                $expected = (int) Arr::get($opportunity, 'expected_time_minutes', 0);

                AutomationOpportunity::create([
                    'process_id' => $process->id,
                    'activity' => Arr::get($opportunity, 'activity'),
                    'current_time_minutes' => $current,
                    'expected_time_minutes' => $expected,
                    'estimated_savings_minutes' => max(0, $current - $expected),
                    'suggested_technology' => Arr::get($opportunity, 'suggested_technology'),
                    'priority' => Arr::get($opportunity, 'priority', 'media'),
                    'complexity' => (int) Arr::get($opportunity, 'complexity', 3),
                    'status' => 'draft',
                    'notes' => Arr::get($opportunity, 'notes'),
                ]);
            }

            $evaluation = $request->input('evaluation', []);
            if (collect($evaluation)->filter(fn ($value) => filled($value))->isNotEmpty()) {
                InternalEvaluation::create([
                    'process_id' => $process->id,
                    'complexity' => (int) Arr::get($evaluation, 'complexity', 3),
                    'risk' => (int) Arr::get($evaluation, 'risk', 3),
                    'impact' => (int) Arr::get($evaluation, 'impact', 3),
                    'requires_mcp' => (bool) Arr::get($evaluation, 'requires_mcp', false),
                    'requires_hermes_skill' => (bool) Arr::get($evaluation, 'requires_hermes_skill', false),
                    'requires_n8n' => (bool) Arr::get($evaluation, 'requires_n8n', false),
                    'requires_ai' => (bool) Arr::get($evaluation, 'requires_ai', false),
                    'requires_ocr' => (bool) Arr::get($evaluation, 'requires_ocr', false),
                    'estimated_hours' => (int) Arr::get($evaluation, 'estimated_hours', 0),
                    'technical_notes' => Arr::get($evaluation, 'technical_notes'),
                ]);
            }
        });

        return redirect()->route('consulting-intake.section', ['section' => 'tareas']);
    }

    private function storeBacklog(Request $request): RedirectResponse
    {
        $process = $this->currentProcessOrFail();

        $request->validate([
            'backlog' => ['nullable', 'array'],
        ]);

        DB::transaction(function () use ($process, $request): void {
            $process->backlogItems()->delete();

            foreach ($request->input('backlog', []) as $item) {
                if (! filled(Arr::get($item, 'title'))) {
                    continue;
                }

                BacklogItem::create([
                    'process_id' => $process->id,
                    'type' => Arr::get($item, 'type', 'historia de usuario'),
                    'title' => Arr::get($item, 'title'),
                    'description' => Arr::get($item, 'description'),
                    'acceptance_criteria' => Arr::get($item, 'acceptance_criteria'),
                    'priority' => Arr::get($item, 'priority', 'media'),
                    'responsible' => Arr::get($item, 'responsible'),
                    'status' => 'draft',
                    'estimated_hours' => (int) Arr::get($item, 'estimated_hours', 0),
                ]);
            }
        });

        session()->forget(['consulting_intake_client_id', 'consulting_intake_process_id']);

        return redirect()->route('consulting-intake.show', $process);
    }

    private function currentClient(): ?Client
    {
        $clientId = session('consulting_intake_client_id') ?: auth()->user()?->client_id;

        return $clientId ? Client::withCount('processes')->find($clientId) : null;
    }

    private function currentProcess(): ?ProcessModel
    {
        $processId = session('consulting_intake_process_id');

        return $processId ? ProcessModel::with(['steps', 'systems', 'documents', 'problems', 'opportunities', 'evaluations', 'backlogItems'])->find($processId) : null;
    }

    private function currentClientOrFail(): Client
    {
        $client = $this->currentClient();

        abort_unless($client, 404);

        return $client;
    }

    private function currentProcessOrFail(): ProcessModel
    {
        $process = $this->currentProcess();

        abort_unless($process, 404);

        return $process;
    }
}
