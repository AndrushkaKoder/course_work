@php
    use App\Enums\Car\CarColor;
    use App\Enums\Car\CarType;
    use Illuminate\Support\Facades\Storage;

    $colorEnum = CarColor::tryFrom($car->color);
    $hex = $colorEnum?->getHex() ?? '#94a3b8';
    $colorName = $colorLabels[$car->color] ?? $car->color;
    $isUsed = $car->type === CarType::USED;
    $imageUrl = $car->preview ? Storage::url($car->preview) : null;
@endphp
<article class="group flex flex-col overflow-hidden rounded-2xl border border-white/10 bg-slate-900/60 shadow-lg shadow-black/20 transition hover:border-amber-500/40 hover:shadow-amber-500/5">
    <div class="relative aspect-[16/10] overflow-hidden bg-slate-800">
        @if ($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $car->getViewName() }}"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            >
        @else
            <div class="flex h-full w-full flex-col items-center justify-center gap-2 bg-gradient-to-br from-slate-800 to-slate-900 text-slate-500">
                <svg class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                </svg>
                <span class="text-xs">Фото скоро</span>
            </div>
        @endif
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

        <p class="mt-auto border-t border-white/5 pt-4 font-mono text-[10px] uppercase tracking-wider text-slate-500">
            VIN {{ $car->vin_code }}
        </p>
    </div>
</article>
