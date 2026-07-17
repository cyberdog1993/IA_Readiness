@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-6xl space-y-8">
    <div class="rounded-[2rem] border border-cyan-400/20 bg-cyan-500/10 p-8 shadow-2xl shadow-cyan-950/20">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Portal cliente</p>
        <div class="mt-3 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="text-4xl font-semibold tracking-tight text-white md:text-5xl">
                    {{ $client->business_name }}
                </h1>
                <p class="mt-3 max-w-3xl text-lg leading-8 text-cyan-50/80">
                    Aquí puedes revisar los procesos levantados, abrir su ficha y descargar la información lista para analizarla con ChatGPT o compartirla con tu equipo.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-center sm:grid-cols-4 lg:min-w-[420px]">
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Cliente</p>
                    <p class="mt-2 text-lg font-semibold text-white">{{ $client->business_name }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Procesos</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $client->processes_count }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">RUC</p>
                    <p class="mt-2 text-lg font-semibold text-white">{{ $client->ruc }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-slate-950/40 px-4 py-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Estado</p>
                    <p class="mt-2 text-lg font-semibold text-white">{{ $client->status }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('consulting-intake.section', ['section' => 'cliente']) }}" class="rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-cyan-300/40 hover:bg-white/10">
            <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Continuar</p>
            <h2 class="mt-2 text-2xl font-semibold text-white">Nuevo proceso o actualización</h2>
            <p class="mt-2 text-sm leading-6 text-slate-300">Abre el formulario por secciones para registrar otro proceso dentro del mismo cliente.</p>
        </a>
        @if ($client->lead)
            <a href="{{ route('diagnosis.show', $client->lead) }}" class="rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-cyan-300/40 hover:bg-white/10">
                <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Diagnóstico</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Ver el resultado comercial</h2>
                <p class="mt-2 text-sm leading-6 text-slate-300">Muestra puntaje, oportunidades y recomendaciones para la consultoría.</p>
            </a>
        @else
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Diagnóstico</p>
                <h2 class="mt-2 text-2xl font-semibold text-white">Aún sin diagnóstico asociado</h2>
                <p class="mt-2 text-sm leading-6 text-slate-300">Cuando se vincule un lead podrás ver aquí el resultado comercial completo.</p>
            </div>
        @endif
        <a href="{{ route('portal.login') }}" class="rounded-3xl border border-white/10 bg-white/5 p-6 transition hover:border-cyan-300/40 hover:bg-white/10">
            <p class="text-sm uppercase tracking-[0.2em] text-cyan-200">Acceso</p>
            <h2 class="mt-2 text-2xl font-semibold text-white">Cambiar de cuenta</h2>
            <p class="mt-2 text-sm leading-6 text-slate-300">Si necesitas entrar con otro cliente, vuelve al acceso y autentícate de nuevo.</p>
        </a>
    </div>

    <div class="rounded-[2rem] border border-cyan-400/15 bg-gradient-to-br from-slate-900 to-slate-950 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Menú de exportación</p>
                <h2 class="mt-2 text-3xl font-semibold text-white">Descarga la información del cliente en el formato que necesites</h2>
                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-400">
                    Usa estos accesos para revisar con el equipo, cargar a IA o compartir con el cliente sin perder estructura.
                </p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">
                Formatos recomendados: Markdown y JSON para IA, PDF para lectura, Excel para control.
            </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            @if ($client->lead)
                <a href="{{ route('diagnosis.client-pdf', $client->lead) }}" class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-100">
                    PDF diagnóstico
                </a>
                <a href="{{ route('exports.markdown', $client->lead) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Markdown
                </a>
                <a href="{{ route('exports.json', $client->lead) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    JSON
                </a>
                <a href="{{ route('exports.excel', $client->lead) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Excel
                </a>
                <a href="{{ route('exports.payload', $client->lead) }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10">
                    Payload IA / n8n
                </a>
            @else
                <span class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm text-slate-400">
                    Aún no hay un lead asociado para habilitar exportaciones.
                </span>
            @endif
        </div>
    </div>

    <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Procesos registrados</p>
                <h2 class="mt-2 text-3xl font-semibold text-white">Ficha lista para revisar y exportar</h2>
                <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-400">
                    Desde aquí puedes abrir cada proceso, revisar sus pasos AS-IS y descargar Markdown o JSON para compartirlo con ChatGPT, Claude o un agente interno.
                </p>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            @forelse ($processes as $process)
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-400">{{ $process->area ?: 'Sin área' }}</p>
                            <h3 class="mt-2 text-2xl font-semibold text-white">{{ $process->name }}</h3>
                            <p class="mt-2 text-sm text-slate-300">{{ $process->objective ?: 'Sin objetivo definido.' }}</p>
                            <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-200">
                                <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-1">{{ $process->steps_count }} pasos</span>
                                <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-1">{{ $process->systems_count }} sistemas</span>
                                <span class="rounded-full border border-white/10 bg-slate-950/40 px-3 py-1">{{ $process->backlog_items_count }} tareas</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('portal.process.show', $process) }}" class="rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-4 py-2.5 font-semibold text-slate-950">
                                Ver proceso
                            </a>
                            <a href="{{ route('consulting-intake.pdf', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 font-semibold text-white">
                                PDF
                            </a>
                            <a href="{{ route('consulting-intake.markdown', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 font-semibold text-white">
                                Markdown
                            </a>
                            <a href="{{ route('consulting-intake.json', $process) }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 font-semibold text-white">
                                JSON
                            </a>
                            <button
                                type="button"
                                data-copy-prompt
                                data-prompt="{{ e('Analiza este proceso, resume la situación actual, identifica oportunidades de automatización, estima ROI, propone un roadmap inicial y redacta una propuesta preliminar comercial y técnica para '.$client->business_name.' / '.$process->name.'.') }}"
                                class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 font-semibold text-white transition hover:border-cyan-300/40 hover:bg-white/10"
                            >
                                Copiar prompt
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-white/10 bg-white/5 p-8 text-center text-slate-300">
                    Todavía no hay procesos registrados para este cliente.
                </div>
            @endforelse
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('[data-copy-prompt]').forEach((button) => {
        button.addEventListener('click', async () => {
            const text = button.getAttribute('data-prompt') || '';
            try {
                await navigator.clipboard.writeText(text);
                const original = button.textContent;
                button.textContent = 'Prompt copiado';
                setTimeout(() => {
                    button.textContent = original;
                }, 1800);
            } catch (error) {
                console.error(error);
            }
        });
    });
</script>
@endsection
