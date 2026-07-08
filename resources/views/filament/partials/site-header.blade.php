<div class="ci-shell-header">
    <div class="mx-auto flex max-w-7xl flex-col gap-3 rounded-[1.75rem] border border-sky-400/15 bg-slate-950/92 px-5 py-4 shadow-2xl shadow-slate-950/35 backdrop-blur sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/consultores-it-logo.jpeg') }}" alt="Consultores IT" class="h-12 w-12 rounded-2xl bg-white/90 object-cover p-1 shadow-lg shadow-slate-950/20">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-cyan-200">Consultores IT</p>
                <p class="text-sm text-slate-300">Plataforma de diagnóstico y consultoría</p>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="https://www.consultores-it.pe" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                Web principal
            </a>
            <a href="mailto:julio.valdez@consultores.it" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                julio.valdez@consultores.it
            </a>
            <a href="https://wa.me/51941108521" target="_blank" rel="noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                WhatsApp +51 941 108 521
            </a>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm font-semibold text-slate-100 transition hover:border-cyan-300/40 hover:bg-white/10">
                        Salir
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
