@extends('layouts.public')

@section('title', 'Aviso de tratamiento de datos')
@section('meta_description', 'Aviso de tratamiento de datos personales para el diagnóstico y consultoría de Consultores IT.')

@section('content')
<div class="mx-auto max-w-4xl space-y-6 rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-blue-950/30">
    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-cyan-200">Datos personales</p>
    <h1 class="text-3xl font-semibold text-white">Aviso de tratamiento de datos</h1>
    <div class="space-y-4 text-sm leading-7 text-slate-300">
        <p>Los datos enviados mediante los formularios se usan para: diagnóstico, elaboración de propuesta, seguimiento comercial, levantamiento de procesos y generación de entregables.</p>
        <p>El tratamiento se realiza bajo medidas de seguridad razonables y con acceso restringido al equipo autorizado.</p>
        <p>Al marcar la casilla de consentimiento, autorizas el contacto comercial y técnico relacionado con la consultoría solicitada.</p>
    </div>
</div>
@endsection
