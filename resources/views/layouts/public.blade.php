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
        @yield('content')
    </main>
</body>
</html>
