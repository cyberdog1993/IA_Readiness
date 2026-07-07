<x-filament-panels::page.simple>
    <div class="grid gap-8 lg:grid-cols-[1.08fr_0.92fr] lg:items-stretch">
        <section class="relative overflow-hidden rounded-[2rem] border border-sky-200 bg-gradient-to-br from-sky-700 via-blue-700 to-slate-900 p-8 text-white shadow-2xl shadow-sky-100/20">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,.16),_transparent_30%),radial-gradient(circle_at_bottom_left,_rgba(125,211,252,.18),_transparent_28%)]"></div>
            <div class="relative space-y-6">
                <div class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-white">
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
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-sky-100">Ingreso</p>
                        <p class="mt-2 text-lg font-semibold text-white">Seguro</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-sky-100">Salida</p>
                        <p class="mt-2 text-lg font-semibold text-white">Markdown / Word</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs uppercase tracking-[0.22em] text-sky-100">Base</p>
                        <p class="mt-2 text-lg font-semibold text-white">Laravel + Filament</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/15 bg-white/10 p-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-100">Consejo rápido</p>
                    <p class="mt-2 text-sm leading-6 text-sky-50">
                        Si tu navegador autocompleta una dirección vieja, bórrala manualmente antes de entrar.
                    </p>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-sky-100 bg-white p-8 shadow-2xl shadow-sky-100/50">
            <div class="mb-6 space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-700">Acceso</p>
                <h2 class="text-2xl font-semibold text-slate-900">Ingresa a tu cuenta</h2>
                <p class="text-sm leading-6 text-slate-600">Usa tu correo corporativo autorizado para acceder al panel.</p>
            </div>

            <div class="mb-6 rounded-2xl border border-sky-100 bg-sky-50 p-4 text-sm leading-6 text-sky-900">
                <p class="font-semibold text-sky-900">Correo autorizado</p>
                <p class="mt-1">Usa exactamente <span class="font-semibold">admin@consultores-it.pe</span>. Si el navegador te propone otra dirección, elimínala antes de continuar.</p>
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
