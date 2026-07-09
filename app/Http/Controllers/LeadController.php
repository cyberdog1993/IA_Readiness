<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Services\LeadAutomationDispatcher;
use App\Services\DiagnosisExportService;
use App\Services\MaturityCalculator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function create(): View
    {
        return view('landing', [
            'lead' => new Lead(),
        ]);
    }

    public function store(StoreLeadRequest $request, MaturityCalculator $calculator, LeadAutomationDispatcher $dispatcher): RedirectResponse
    {
        $validated = $request->validated();
        $lead = $calculator->updateLead(new Lead(), array_merge($validated, [
            'contact_name' => $validated['contact_name'] ?? '',
            'contact_role' => $validated['contact_role'] ?? '',
            'email' => $validated['email'] ?? '',
            'phone' => $validated['phone'] ?? '',
        ]));
        $lead->update([
            'status' => 'new',
            'consulting_requested_at' => Carbon::now(),
        ]);

        $dispatcher->dispatch($lead);

        return redirect()->route('diagnosis.show', $lead);
    }

    public function show(Lead $lead): View
    {
        return view('diagnosis.show', compact('lead'));
    }

    public function updateContact(Request $request, Lead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'contact_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'contact_role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'privacy_consent' => ['accepted'],
        ]);

        $lead->update([
            'contact_name' => $validated['contact_name'],
            'company_name' => $validated['company_name'],
            'contact_role' => $validated['contact_role'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'privacy_consent' => true,
        ]);

        return redirect()->route('diagnosis.show', $lead)->with('status', 'datos-completados');
    }

    public function clientPdf(Lead $lead, DiagnosisExportService $exports): Response
    {
        abort_unless($lead->contactDetailsComplete(), 403);

        return $exports->downloadClientPdf($lead);
    }

    public function proposal(Lead $lead, LeadAutomationDispatcher $dispatcher): RedirectResponse
    {
        $dispatcher->dispatch($lead);

        return redirect()->route('diagnosis.show', $lead)->with('status', 'propuesta-generada');
    }
}
