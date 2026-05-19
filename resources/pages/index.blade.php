@php
    use App\Enums\Car\CarType;

    $colorLabels = [
        'white' => 'Белый',
        'black' => 'Чёрный',
        'silver' => 'Серебристый',
        'gray' => 'Серый',
        'red' => 'Красный',
        'blue' => 'Синий',
        'yellow' => 'Жёлтый',
        'green' => 'Зелёный',
        'orange' => 'Оранжевый',
        'anthracite' => 'Антрацит',
        'burgundy' => 'Бордовый',
        'navy' => 'Тёмно-синий',
        'brown' => 'Коричневый',
        'beige' => 'Бежевый',
        'gold' => 'Золотой',
        'purple' => 'Фиолетовый',
        'cyan' => 'Голубой',
        'bronze' => 'Бронза',
    ];

    $totalCount = $cars->count();
    $defaultTab = $newCars->isNotEmpty() ? 'new' : ($usedCars->isNotEmpty() ? 'used' : 'new');
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Автосалон — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 antialiased">
    <header class="border-b border-white/10 bg-slate-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-slate-950">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-tight">DriveLine</p>
                    <p class="text-xs text-slate-400">Официальный дилер</p>
                </div>
            </div>
            <a href="#catalog" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-amber-400">
                Каталог
            </a>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden border-b border-white/10">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-500/20 via-slate-950 to-slate-950"></div>
            <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
                <p class="mb-3 inline-flex items-center rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-xs font-medium text-amber-300">
                    {{ $totalCount }} {{ $totalCount === 1 ? 'автомобиль' : ($totalCount < 5 ? 'автомобиля' : 'автомобилей') }} в наличии
                </p>
                <h1 class="max-w-2xl text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Найдите автомобиль<br>
                    <span class="text-amber-400">вашей мечты</span>
                </h1>
                <p class="mt-4 max-w-xl text-lg text-slate-400">
                    Новые и подержанные автомобили с прозрачной ценой, проверенным VIN и гарантией качества.
                </p>
            </div>
        </section>

        <section id="catalog" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight">Каталог</h2>
                    <p class="mt-1 text-slate-400">Актуальные предложения из нашего склада</p>
                </div>

                <nav
                    class="catalog-tabs inline-flex w-full rounded-xl border border-white/10 bg-slate-900/60 p-1 sm:w-auto"
                    role="tablist"
                    aria-label="Тип автомобиля"
                    data-default-tab="{{ $defaultTab }}"
                >
                    <button
                        type="button"
                        role="tab"
                        id="tab-new"
                        aria-controls="panel-new"
                        aria-selected="true"
                        data-tab="new"
                        class="catalog-tab flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition sm:flex-initial sm:px-6"
                    >
                        {{ CarType::getLabels()[CarType::NEW->value] }}
                        <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs tabular-nums text-slate-300">{{ $newCars->count() }}</span>
                    </button>
                    <button
                        type="button"
                        role="tab"
                        id="tab-used"
                        aria-controls="panel-used"
                        aria-selected="false"
                        data-tab="used"
                        class="catalog-tab flex flex-1 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition sm:flex-initial sm:px-6"
                    >
                        {{ CarType::getLabels()[CarType::USED->value] }}
                        <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs tabular-nums text-slate-300">{{ $usedCars->count() }}</span>
                    </button>
                </nav>
            </div>

            @if ($totalCount === 0)
                @include('pages::partials.catalog-empty', [
                    'title' => 'Сейчас нет автомобилей в наличии',
                    'message' => 'Загляните позже — каталог обновляется регулярно',
                ])
            @else
                <div
                    id="panel-new"
                    role="tabpanel"
                    aria-labelledby="tab-new"
                    data-panel="new"
                    class="catalog-panel"
                >
                    @if ($newCars->isEmpty())
                        @include('pages::partials.catalog-empty', [
                            'title' => 'Новых автомобилей нет в наличии',
                            'message' => 'Посмотрите раздел «Б/У» или загляните позже',
                        ])
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($newCars as $car)
                                @include('pages::partials.car-card', compact('car', 'colorLabels'))
                            @endforeach
                        </div>
                    @endif
                </div>

                <div
                    id="panel-used"
                    role="tabpanel"
                    aria-labelledby="tab-used"
                    data-panel="used"
                    class="catalog-panel hidden"
                >
                    @if ($usedCars->isEmpty())
                        @include('pages::partials.catalog-empty', [
                            'title' => 'Автомобилей с пробегом нет в наличии',
                            'message' => 'Посмотрите раздел «Новый» или загляните позже',
                        ])
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($usedCars as $car)
                                @include('pages::partials.car-card', compact('car', 'colorLabels'))
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </section>
    </main>

    <footer class="border-t border-white/10 py-8 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} DriveLine. Все права защищены.</p>
    </footer>

    <script>
        (() => {
            const root = document.querySelector('.catalog-tabs');
            if (!root) return;

            const tabs = root.querySelectorAll('[data-tab]');
            const panels = document.querySelectorAll('[data-panel]');
            const activeClasses = ['bg-amber-500', 'text-slate-950', 'shadow-sm'];
            const inactiveClasses = ['text-slate-400', 'hover:text-slate-200'];

            const setActive = (name) => {
                tabs.forEach((tab) => {
                    const isActive = tab.dataset.tab === name;
                    tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                    tab.classList.remove(...activeClasses, ...inactiveClasses);
                    tab.classList.add(...(isActive ? activeClasses : inactiveClasses));
                });

                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.panel !== name);
                });

                history.replaceState(null, '', `#${name}`);
            };

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => setActive(tab.dataset.tab));
            });

            const hashTab = location.hash.replace('#', '');
            const initialTab = ['new', 'used'].includes(hashTab) ? hashTab : root.dataset.defaultTab;
            setActive(initialTab);
        })();

        (() => {
            if (window.__carSlidersInit) return;
            window.__carSlidersInit = true;

            const showSlide = (slider, index) => {
                const slides = slider.querySelectorAll('[data-slide]');
                const dots = slider.querySelectorAll('[data-car-slider-dot]');
                const total = slides.length;

                if (total === 0) return;

                const next = ((index % total) + total) % total;

                slides.forEach((slide, i) => {
                    const active = i === next;
                    slide.classList.toggle('opacity-100', active);
                    slide.classList.toggle('opacity-0', !active);
                    slide.classList.toggle('z-[1]', active);
                    slide.classList.toggle('z-0', !active);
                    slide.classList.toggle('pointer-events-none', !active);
                });

                dots.forEach((dot, i) => {
                    const active = i === next;
                    dot.classList.toggle('w-4', active);
                    dot.classList.toggle('bg-amber-400', active);
                    dot.classList.toggle('w-1.5', !active);
                    dot.classList.toggle('bg-white/50', !active);
                });

                slider.dataset.activeSlide = String(next);
            };

            document.addEventListener('click', (event) => {
                const target = event.target.closest('[data-car-slider-prev], [data-car-slider-next], [data-car-slider-dot]');
                if (!target) return;

                const slider = target.closest('[data-car-slider]');
                if (!slider) return;

                event.preventDefault();
                event.stopPropagation();

                const current = Number(slider.dataset.activeSlide ?? 0);
                const slides = slider.querySelectorAll('[data-slide]');
                const total = slides.length;

                if (total <= 1) return;

                if (target.hasAttribute('data-car-slider-dot')) {
                    showSlide(slider, Number(target.dataset.carSliderDot));
                    return;
                }

                const step = target.hasAttribute('data-car-slider-prev') ? -1 : 1;
                showSlide(slider, current + step);
            });
        })();
    </script>
</body>
</html>
