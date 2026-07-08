@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-blue-950/30 backdrop-blur">
        <div class="mb-6 space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Portal cliente</p>
            <h1 class="text-3xl font-semibold text-white">Ingresa para continuar tu consultoría</h1>
            <p class="text-sm leading-6 text-slate-300">Usa el usuario y contraseña que te entregó el consultor para completar tu formulario paso a paso.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-400/30 bg-rose-500/10 p-4 text-sm text-rose-100">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('portal.login.store') }}" class="space-y-5">
            @csrf
            <label class="grid gap-2">
                <span class="text-sm font-medium text-slate-200">Correo electrónico</span>
                <input name="email" type="email" value="{{ old('email') }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" placeholder="cliente@empresa.com">
            </label>
            <label class="grid gap-2">
                <span class="text-sm font-medium text-slate-200">Contraseña</span>
                <input name="password" type="password" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400" placeholder="Tu contraseña">
            </label>
            <label class="flex items-center gap-3 text-sm text-slate-300">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-white/20 bg-slate-900 accent-cyan-400">
                Recordarme
            </label>
            <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-5 py-3 font-bold text-slate-950 shadow-xl shadow-cyan-950/30">
                Entrar al portal
            </button>
        </form>
    </div>
</div>
@endsection
