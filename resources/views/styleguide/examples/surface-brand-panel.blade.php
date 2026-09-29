<div class="grid max-w-lg grid-cols-3 gap-3">
    @foreach([['Standard', '19%'], ['Reduced', '7%'], ['Currency', 'EUR']] as [$label, $value])
        <dl class="app-brand-panel flex flex-col-reverse p-3 text-center">
            <dt class="text-[0.6875rem] font-semibold tracking-[0.08em] text-white/70 uppercase">{{ $label }}</dt>
            <dd class="tabular text-2xl font-bold text-white">{{ $value }}</dd>
        </dl>
    @endforeach
</div>
