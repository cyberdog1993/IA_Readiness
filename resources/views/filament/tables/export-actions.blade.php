@php
    use App\Filament\Resources\ClientResource;
    use App\Models\Client;
    use App\Models\Lead;
    use App\Models\ProcessModel;

    $record = $record ?? ($getRecord() ?? null);
    $buttons = [];

    if ($record instanceof Lead) {
        $buttons = [
            ['label' => 'PDF cliente', 'url' => route('exports.client-pdf', $record)],
            ['label' => 'Markdown', 'url' => route('exports.markdown', $record)],
            ['label' => 'JSON', 'url' => route('exports.json', $record)],
            ['label' => 'Excel', 'url' => route('exports.excel', $record)],
            ['label' => 'Word', 'url' => route('exports.word', $record)],
            ['label' => 'Payload IA / n8n', 'url' => route('exports.payload', $record)],
            ['label' => 'PDF interno', 'url' => route('exports.internal-pdf', $record)],
        ];
    } elseif ($record instanceof Client) {
        if ($record->lead) {
            $buttons[] = ['label' => 'PDF diagnóstico', 'url' => route('exports.client-pdf', $record->lead)];
            $buttons[] = ['label' => 'Markdown', 'url' => route('exports.markdown', $record->lead)];
            $buttons[] = ['label' => 'JSON', 'url' => route('exports.json', $record->lead)];
            $buttons[] = ['label' => 'Excel', 'url' => route('exports.excel', $record->lead)];
            $buttons[] = ['label' => 'Word', 'url' => route('exports.word', $record->lead)];
            $buttons[] = ['label' => 'Payload IA / n8n', 'url' => route('exports.payload', $record->lead)];
        }

        $process = $record->processes()->latest()->first();
        if ($process) {
            $buttons[] = ['label' => 'PDF proceso', 'url' => route('consulting-intake.pdf', $process)];
            $buttons[] = ['label' => 'Markdown proceso', 'url' => route('consulting-intake.markdown', $process)];
            $buttons[] = ['label' => 'JSON proceso', 'url' => route('consulting-intake.json', $process)];
        }
    } elseif ($record instanceof ProcessModel) {
        $buttons = [
            ['label' => 'PDF', 'url' => route('consulting-intake.pdf', $record)],
            ['label' => 'Markdown', 'url' => route('consulting-intake.markdown', $record)],
            ['label' => 'JSON', 'url' => route('consulting-intake.json', $record)],
        ];

        if ($record->client) {
            $buttons[] = ['label' => 'Ir al cliente', 'url' => ClientResource::getUrl('edit', ['record' => $record->client])];
        }
    }
@endphp

<div class="flex flex-wrap gap-2">
    @forelse ($buttons as $button)
        <a
            href="{{ $button['url'] }}"
            target="_blank"
            rel="noreferrer"
            class="inline-flex items-center rounded-full border border-cyan-300/20 bg-cyan-500/10 px-3 py-1.5 text-xs font-semibold text-cyan-50 transition hover:border-cyan-300/50 hover:bg-cyan-500/20"
        >
            {{ $button['label'] }}
        </a>
    @empty
        <span class="text-xs text-slate-500">Sin exportaciones</span>
    @endforelse
</div>
