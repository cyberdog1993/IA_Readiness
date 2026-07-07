<x-filament-panels::page.simple>
    <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-stretch">
        <section class="relative overflow-hidden rounded-[2rem] border border-sky-400/15 bg-slate-950/80 p-8 shadow-2xl shadow-slate-950/40">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(34,211,238,.16),_transparent_30%),radial-gradient(circle_at_bottom_left,_rgba(16,185,129,.14),_transparent_28%)]"></div>
            <div class="relative space-y-6">
                <div class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-sky-100">
                    Consultores IT
                </div>

                <div class="space-y-4">
                    <h1 class="max-w-md text-4xl font-semibold tracking-tight text-white">
                        Panel interno para diagnóstico, preventa y automatización.
                    </h1>
                    <p class="max-w-xl text-base leading-7 text-slate-300">
                        Accede para gestionar leads, clientes, procesos, exportaciones y backlog técnico desde una sola plataforma.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Ingreso</p>
                        <p class="mt-2 text-lg font-semibold text-white">Seguro</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Salida</p>
                        <p class="mt-2 text-lg font-semibold text-white">Markdown / Word</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Base</p>
                        <p class="mt-2 text-lg font-semibold text-white">Laravel + Filament</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-cyan-400/15 bg-cyan-500/10 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-100">Consejo rápido</p>
                    <p class="mt-2 text-sm leading-6 text-cyan-50/90">
                        Si tu navegador autocompleta una contraseña vieja, bórrala manualmente antes de entrar.
                    </p>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-blue-950/30 backdrop-blur">
            <div class="mb-6 space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Acceso</p>
                <h2 class="text-2xl font-semibold text-white">Ingresa a tu cuenta</h2>
                <p class="text-sm leading-6 text-slate-400">Usa tu correo corporativo autorizado para acceder al panel.</p>
            </div>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

            <x-filament-panels::form id="form" wire:submit="authenticate" class="space-y-6">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </section>
    </div>
</x-filament-panels::page.simple>
