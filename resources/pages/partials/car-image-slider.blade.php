@php
    use App\Models\Car;use Illuminate\Support\Facades\Storage;

    /**
    * @var Car $car
     */

    $rawFiles = $car->getFiles() ?? [];
    if (is_string($rawFiles)) {
        $rawFiles = json_decode($rawFiles, true) ?? [];
    }

    $files = array_values(array_filter(
        $rawFiles,
        fn ($path) => is_string($path) && $path !== '',
    ));

    $slides = array_map(fn (string $path) => Storage::url($path), $files);

    if ($slides === []) {
        $fallback = $car->preview ?: ($files[0] ?? null);

        if (is_string($fallback) && $fallback !== '') {
            $slides = [Storage::url($fallback)];
        }
    }

    $slideCount = count($slides);
@endphp

@if ($slideCount > 0)
    <div
        class="car-slider relative h-full w-full"
        data-car-slider
        data-active-slide="0"
    >
        <div class="relative h-full w-full overflow-hidden">
            @foreach ($slides as $index => $url)
                <img
                    src="{{ $url }}"
                    alt="{{ $car->getViewName() }} — фото {{ $index + 1 }}"
                    class="car-slider__slide absolute inset-0 h-full w-full object-cover transition-opacity duration-300 {{ $index === 0 ? 'opacity-100 z-[1]' : 'pointer-events-none opacity-0 z-0' }}"
                    data-slide="{{ $index }}"
                    @if ($index > 0) loading="lazy" @endif
                >
            @endforeach
        </div>

        @if ($slideCount > 1)
            <button
                type="button"
                class="absolute left-2 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-slate-950/80 text-white shadow-lg backdrop-blur hover:bg-amber-500 hover:text-slate-950"
                data-car-slider-prev
                aria-label="Предыдущее фото"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                </svg>
            </button>
            <button
                type="button"
                class="absolute right-2 top-1/2 z-20 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full border border-white/10 bg-slate-950/80 text-white shadow-lg backdrop-blur hover:bg-amber-500 hover:text-slate-950"
                data-car-slider-next
                aria-label="Следующее фото"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                </svg>
            </button>

            <div
                class="absolute bottom-2 left-1/2 z-20 flex -translate-x-1/2 gap-1.5 rounded-full border border-white/10 bg-slate-950/60 px-2 py-1 backdrop-blur">
                @foreach ($slides as $index => $url)
                    <button
                        type="button"
                        class="car-slider__dot h-1.5 rounded-full transition-all {{ $index === 0 ? 'w-4 bg-amber-400' : 'w-1.5 bg-white/50' }}"
                        data-car-slider-dot="{{ $index }}"
                        aria-label="Фото {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        @endif
    </div>
@else
    <div
        class="flex h-full w-full flex-col items-center justify-center gap-2 bg-gradient-to-br from-slate-800 to-slate-900 text-slate-500">
        <svg class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
        </svg>
    </div>
@endif
