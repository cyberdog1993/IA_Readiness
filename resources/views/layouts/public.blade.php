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
    <main class="mx-auto max-w-7xl px-6 py-10">
        <div class="mb-8 flex items-center gap-4">
            <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-14 w-14 rounded-2xl bg-white/90 object-cover p-1 shadow-lg shadow-slate-950/30" loading="eager">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-200">Consultores IT</p>
                <p class="text-sm text-slate-300">Plataforma de diagnóstico y consultoría</p>
            </div>
        </div>
        @yield('content')

        <footer class="mt-12 rounded-3xl border border-cyan-400/20 bg-gradient-to-r from-slate-900 via-slate-900 to-slate-950 px-6 py-5 text-sm text-slate-300 shadow-lg shadow-slate-950/20">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.28em] text-cyan-200">Consultores IT</p>
                    <p class="font-semibold text-white">Plataforma de diagnóstico, preventa y consultoría</p>
                    <div class="flex flex-wrap gap-3 text-sm">
                        <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 transition hover:border-cyan-300/40 hover:bg-white/10">
                            consultores-it.pe
                        </a>
                        <a href="mailto:julio.valdez@consultores.it" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 transition hover:border-cyan-300/40 hover:bg-white/10">
                            julio.valdez@consultores.it
                        </a>
                        <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 transition hover:border-cyan-300/40 hover:bg-white/10">
                            WhatsApp +51 941 108 521
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3 text-xs uppercase tracking-[0.22em] text-slate-400">
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">Formulario v1.0.0</span>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">Diagnóstico de automatización</span>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
