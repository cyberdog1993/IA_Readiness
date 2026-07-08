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

        <footer class="mt-12 rounded-3xl border border-white/10 bg-white/5 px-6 py-5 text-sm text-slate-300">
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="space-y-1">
                    <p class="font-semibold text-white">Consultores IT</p>
                    <p>consultores-it.pe · julio.valdez@consultores.it · WhatsApp +51 941 108 521</p>
                </div>
                <div class="flex flex-wrap gap-3 text-xs uppercase tracking-[0.22em] text-slate-400">
                    <span>Formulario v1.0.0</span>
                    <span>Diagnóstico de automatización</span>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
