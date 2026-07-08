<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,.22),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(16,185,129,.16),_transparent_35%)]"></div>
    <main class="mx-auto max-w-7xl px-6 py-10 pb-32">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-14 w-14 rounded-2xl bg-white/90 object-cover p-1 shadow-lg shadow-slate-950/30" loading="eager">
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Consultores IT</p>
                    <p class="text-sm text-slate-300">Plataforma de diagnóstico y consultoría</p>
                </div>
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Salir
                    </button>
                </form>
            @endauth
        </div>
        @yield('content')

        <footer class="fixed inset-x-0 bottom-0 z-40 border-t border-cyan-400/20 bg-slate-950/95 px-4 py-3 shadow-[0_-12px_40px_rgba(2,6,23,0.45)] backdrop-blur">
            <div class="mx-auto flex max-w-7xl flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-3 text-sm">
                    <span class="text-xs uppercase tracking-[0.28em] text-cyan-200">Consultores IT</span>
                    <span class="text-slate-300">Plataforma de diagnóstico, preventa y consultoría</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Web principal
                    </a>
                    <a href="mailto:julio.valdez@consultores.it" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        julio.valdez@consultores.it
                    </a>
                    <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        WhatsApp +51 941 108 521
                    </a>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs uppercase tracking-[0.22em] text-slate-300">Formulario v1.0.1</span>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
