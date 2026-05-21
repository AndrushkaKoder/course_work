@php
    use App\Enums\Car\CarColor;
    use App\Enums\Car\CarType;

    $colorEnum = CarColor::tryFrom($car->color);
    $hex = $colorEnum?->getHex() ?? '#94a3b8';
    $colorName = $colorLabels[$car->color] ?? $car->color;
    $isUsed = $car->type === CarType::USED;
@endphp
<article class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-slate-900/60 shadow-lg shadow-black/20 transition hover:border-amber-500/40 hover:shadow-amber-500/5">
    <div class="relative aspect-[16/10] overflow-hidden bg-slate-800">
        <div class="absolute inset-0">
            @include('pages::partials.car-image-slider', compact('car'))
        </div>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-lg font-semibold leading-tight">
            {{ $car->mark }} {{ $car->model }}
        </h3>
        <p class="mt-1 text-sm text-slate-400">{{ $car->year }} год@if($car->class) · {{ $car->class }}@endif</p>

        <p class="mt-4 text-2xl font-bold text-amber-400">
            {{ $car->getViewPrice() }}
        </p>

        <ul class="mt-4 flex flex-wrap gap-2 text-xs text-slate-400">
            <li class="inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-slate-800/80 px-2.5 py-1">
                <span class="h-3 w-3 rounded-full border border-white/20" style="background-color: {{ $hex }}"></span>
                {{ $colorName }}
            </li>
            @if ($isUsed && $car->mileage)
                <li class="rounded-full border border-white/10 bg-slate-800/80 px-2.5 py-1">
                    {{ number_format($car->mileage, 0, '', ' ') }} км
                </li>
            @endif
            <li class="rounded-full border border-white/10 bg-slate-800/80 px-2.5 py-1">
                В наличии: {{ $car->count }}
            </li>
        </ul>
    </div>
</article>
