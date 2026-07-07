@props([
    'name',
    'label',
    'placeholder' => null,
    'required' => false,
    'wrapperClass' => '',
])

<label class="grid gap-2 {{ $wrapperClass }}">
    <span class="text-sm font-semibold text-slate-200">
        {{ $label }}
        @if ($required)
            <span class="text-cyan-300">*</span>
        @endif
    </span>
    <textarea
        name="{{ $name }}"
        rows="4"
        placeholder="{{ $placeholder ?? $label }}"
        @required($required)
        class="rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-white outline-none placeholder:text-slate-500 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20"
    >{{ old($name) }}</textarea>
</label>
