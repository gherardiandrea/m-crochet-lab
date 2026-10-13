@extends('_layouts.main')

@section('body')

<nav aria-label="Percorso di navigazione" class="mb-6 md:mb-8">
    <ol class="flex flex-wrap items-center gap-2 text-sm text-stone-500">
        <li class="flex items-center">
            <a href="/" class="hover:text-[#7f5539] transition-colors font-medium">Home</a>
        </li>
        <li aria-hidden="true" class="text-stone-300">/</li>
        <li class="flex items-center">
            <a href="/#modelli" class="hover:text-[#7f5539] transition-colors font-medium">Modelli</a>
        </li>
        <li aria-hidden="true" class="text-stone-300">/</li>
        <li aria-current="page" class="text-[#7f5539] font-semibold truncate max-w-[60vw] sm:max-w-none">{{ $page->nome }}</li>
    </ol>
</nav>

@php
    $gallery = collect($page->get('gallery', []))->values()->all();
    $startIndex = array_search($page->copertina, $gallery, true);
    $current = $startIndex === false ? 0 : $startIndex;

    // With Jigsaw page data, empty($page->field) can be unreliable on dynamic properties.
    $dimensioni = method_exists($page, 'get') ? $page->get('dimensioni') : null;
    $dettagli = method_exists($page, 'get') ? $page->get('dettagli') : null;
    // I testi vengono da "shipping" in config.php: (array) sull'oggetto di Jigsaw perdeva le chiavi
    $shipping = collect($page->get('shipping', []));
    $shippingPreparation = (string) $shipping->get('preparationTime');
    $shippingDelivery = (string) $shipping->get('deliveryTime');

    // Misure dello stesso modello (campo "famiglia" nel frontmatter) e colori già realizzati
    $famiglia = (string) $page->famiglia;
    $misure = $famiglia !== '' ? $borse->filter(fn ($borsa) => $borsa->famiglia === $famiglia) : collect();
    $colori = collect($page->colori ?: ($famiglia !== '' ? $page->get('famiglie')?->get($famiglia)?->get('colori') : []))->values()->all();

    // Borse uguali già pronte da spedire, collegate per nome a "Pronte per te"
    $pronte = collect(json_decode(json_encode($page->get('prontaConsegna', [])), true) ?? [])->where('nome', $page->nome)->values();

    $altriModelli = $borse->reject(fn ($borsa) => $borsa->getPath() === $page->getPath() || ($famiglia !== '' && $borsa->famiglia === $famiglia));
@endphp

<div x-data="{
    open: false,
    current: {{ $current }},
    images: {{ json_encode($gallery) }},
    get currentImg() { return this.images[this.current]; },
    next() { this.current = (this.current + 1) % this.images.length; },
    prev() { this.current = (this.current - 1 + this.images.length) % this.images.length; },
    apri(indice) { this.current = indice; this.open = true; },
    {{-- Su mobile la galleria scorre: la foto al centro è quella corrente --}}
    aggiornaIndice(lista) {
        const centro = lista.scrollLeft + lista.clientWidth / 2;
        let migliore = 0, distanza = Infinity;
        [...lista.children].forEach((foto, indice) => {
            const d = Math.abs(foto.offsetLeft + foto.offsetWidth / 2 - centro);
            if (d < distanza) { distanza = d; migliore = indice; }
        });
        this.current = migliore;
    }
}" class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 items-start">

    {{-- Un'unica lista di foto: su mobile scorre in orizzontale, da desktop è una griglia --}}
    <div class="md:col-span-7 relative">
        <ul class="flex md:grid md:grid-cols-2 gap-2 md:gap-3 overflow-x-auto md:overflow-visible snap-x snap-mandatory -mx-4 px-4 md:mx-0 md:px-0"
            @scroll.debounce.60ms="aggiornaIndice($el)">
            @foreach ($gallery as $foto)
                <li class="shrink-0 w-[88%] md:w-auto snap-center {{ $loop->first ? 'md:col-span-2' : '' }}">
                    <button type="button" class="block w-full cursor-zoom-in {{ $loop->first ? 'rounded-3xl' : 'rounded-2xl' }} focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#7f5539]" @click="apri({{ $loop->index }})" aria-label="Ingrandisci la foto {{ $loop->iteration }} di {{ count($gallery) }}">
                        {{-- Solo la prima foto a piena risoluzione: le altre (fino a 800 px) restano nitide anche su mobile e pesano molto meno --}}
                        <img src="{{ $foto }}"
                             srcset="{{ $page->srcset($foto, $loop->first ? null : 800) }}"
                             sizes="{{ $loop->first ? '(min-width: 1152px) 650px, (min-width: 768px) 58vw, 88vw' : '(min-width: 1152px) 320px, (min-width: 768px) 29vw, 88vw' }}"
                             alt="{{ $page->nome }} — foto {{ $loop->iteration }}"
                             @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                             decoding="async"
                             class="w-full object-cover aspect-[4/5] {{ $loop->first ? 'rounded-3xl' : 'md:aspect-[3/4] rounded-2xl' }}">
                    </button>
                </li>
            @endforeach
        </ul>
        @if (count($gallery) > 1)
            <span class="md:hidden absolute bottom-3 left-1/2 -translate-x-1/2 bg-black/70 text-white text-xs font-semibold px-2.5 py-1 rounded-full pointer-events-none" aria-hidden="true">
                <span x-text="current + 1">1</span> / {{ count($gallery) }}
            </span>
        @endif
    </div>

    {{-- Su desktop la colonna resta ferma mentre scorrono le foto --}}
    <div class="md:col-span-5 md:sticky md:top-16 lg:top-28">
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-[#7f5539]">{{ $page->nome }}</h1>
        <p class="mt-2 text-2xl font-semibold text-stone-800">{{ $page->prezzo }}</p>

        <div class="mt-5 text-stone-600 leading-relaxed">
            @yield('content')
        </div>

        @if ($misure->count() > 1)
            <div class="mt-7">
                <p class="text-sm font-semibold text-stone-800 mb-2">Misura</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach ($misure as $borsa)
                        @php $attuale = $borsa->getPath() === $page->getPath(); @endphp
                        <a href="{{ $page->conBarra($borsa->getPath()) }}"
                           @if ($attuale) aria-current="page" @endif
                           class="rounded-xl px-2 py-2.5 text-center transition {{ $attuale ? 'border-2 border-[#7f5539] bg-[#f4e7db]' : 'border border-stone-300 hover:border-[#7f5539]' }}">
                            <span class="block font-semibold text-stone-800 leading-tight">{{ $borsa->misura ?: $borsa->nome }}</span>
                            <span class="block text-sm text-stone-600">{{ $borsa->prezzo }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($dimensioni)
            <p class="{{ $misure->count() > 1 ? 'mt-2' : 'mt-7' }} text-sm text-stone-500"><span class="sr-only">Dimensioni: </span>{{ $dimensioni }}</p>
        @endif

        @if (is_array($dettagli) && count($dettagli) > 0)
            <ul class="mt-2 space-y-1 text-sm text-stone-500">
                @foreach ($dettagli as $dettaglio)
                    <li>{{ $dettaglio }}</li>
                @endforeach
            </ul>
        @elseif (is_string($dettagli) && $dettagli)
            <p class="mt-2 text-sm text-stone-500">{{ $dettagli }}</p>
        @endif

        <div class="mt-7">
            <p class="text-sm font-semibold text-stone-800">Colore</p>
            @if (count($colori) > 1)
                <p class="mt-1 text-sm text-stone-600">Lo scegliamo insieme. Alcuni colori già realizzati:</p>
                <ul class="mt-3 flex flex-wrap gap-2">
                    @foreach ($colori as $foto)
                        <li>
                            <img src="{{ $foto }}" srcset="{{ $page->srcset($foto, 400) }}" sizes="56px" alt="" loading="lazy" decoding="async" class="w-14 h-[4.5rem] object-cover rounded-lg">
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-1 text-sm text-stone-600">Lo scegliamo insieme: scrivimi quale ti piace.</p>
            @endif
        </div>

        <a href="https://ig.me/m/m_crochet_lab"
           target="_blank"
           rel="noopener noreferrer"
           class="mt-8 flex w-full items-center justify-center gap-2 bg-[#7f5539] hover:bg-[#9c6644] text-white py-4 rounded-xl font-bold shadow-lg transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M8 0C5.826 0 5.555.01 4.703.048 3.85.088 3.27.222 2.762.42a5.06 5.06 0 0 0-1.83 1.191A5.06 5.06 0 0 0 .42 3.44c-.198.507-.332 1.087-.372 1.94C.01 6.232 0 6.503 0 8.677c0 2.174.01 2.445.048 3.297.04.853.174 1.433.372 1.94.22.56.513 1.036.93 1.453.417.417.893.71 1.453.93.507.198 1.087.332 1.94.372.852.038 1.123.048 3.297.048 2.174 0 2.445-.01 3.297-.048.853-.04 1.433-.174 1.94-.372a5.06 5.06 0 0 0 1.453-.93c.417-.417.71-.893.93-1.453.198-.507.332-1.087.372-1.94.038-.852.048-1.123.048-3.297 0-2.174-.01-2.445-.048-3.297-.04-.853-.174-1.433-.372-1.94a5.06 5.06 0 0 0-.93-1.453 5.06 5.06 0 0 0-1.453-.93c-.507-.198-1.087-.332-1.94-.372C10.445.01 10.174 0 8 0zm0 1.441c2.137 0 2.39.008 3.232.046.778.036 1.2.166 1.48.275.37.144.633.316.91.593.277.277.45.54.594.91.109.28.239.702.275 1.48.038.842.046 1.095.046 3.232 0 2.137-.008 2.39-.046 3.232-.036.778-.166 1.2-.275 1.48a3.62 3.62 0 0 1-.593.91 3.62 3.62 0 0 1-.91.594c-.28.109-.702.239-1.48.275-.842.038-1.095.046-3.232.046-2.137 0-2.39-.008-3.232-.046-.778-.036-1.2-.166-1.48-.275a3.62 3.62 0 0 1-.91-.593 3.62 3.62 0 0 1-.594-.91c-.109-.28-.239-.702-.275-1.48-.038-.842-.046-1.095-.046-3.232 0-2.137.008-2.39.046-3.232.036-.778.166-1.2.275-1.48.144-.37.316-.633.593-.91.277-.277.54-.45.91-.594.28-.109.702-.239 1.48-.275.842-.038 1.095-.046 3.232-.046zm0 2.456A4.103 4.103 0 1 0 8 12.103 4.103 4.103 0 0 0 8 3.897zm0 6.765A2.662 2.662 0 1 1 8 5.338a2.662 2.662 0 0 1 0 5.324zm5.224-6.927a.959.959 0 1 1-1.918 0 .959.959 0 0 1 1.918 0z"/>
            </svg>
            Scrivimi per ordinarla
        </a>

        @if ($pronte->count() > 0)
            @php $primaFoto = $pronte[0]['gallery'][0] ?? null; @endphp
            <a href="/#pronte-per-te" class="mt-3 flex items-center gap-4 rounded-2xl bg-[#f4e7db] p-3 hover:bg-[#e6ccb2] transition-colors">
                @if ($primaFoto)
                    <img src="{{ $primaFoto }}" srcset="{{ $page->srcset($primaFoto, 400) }}" sizes="56px" alt="" loading="lazy" decoding="async" class="w-14 h-[4.5rem] object-cover rounded-lg shrink-0">
                @endif
                <span class="text-sm text-stone-700">
                    <strong class="text-[#7f5539]">Pronta da spedire:</strong>
                    @if ($pronte->count() == 1)
                        una {{ $page->nome }} è già disponibile, senza attesa.
                    @else
                        {{ $pronte->count() }} {{ $page->nome }} sono già disponibili, senza attesa.
                    @endif
                    <span class="font-semibold text-[#7f5539] underline underline-offset-2">{{ $pronte->count() == 1 ? 'Guardala' : 'Guardale' }}</span>
                </span>
            </a>
        @endif

        <div class="mt-8 border-t border-stone-200 pt-6">
            <h2 class="font-semibold text-stone-800 mb-4">Come si ordina</h2>
            <ol class="space-y-3 text-sm text-stone-600 leading-relaxed">
                <li class="flex gap-3">
                    <span class="shrink-0 w-6 h-6 rounded-full bg-[#7f5539] text-white text-xs font-bold flex items-center justify-center" aria-hidden="true">1</span>
                    <span>Scrivimi su Instagram il modello{{ $misure->count() > 1 ? ', la misura' : '' }} e il colore che ti piace.</span>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 w-6 h-6 rounded-full bg-[#7f5539] text-white text-xs font-bold flex items-center justify-center" aria-hidden="true">2</span>
                    <span>Ti confermo prezzo e spedizione; paghi con PayPal o bonifico.</span>
                </li>
                <li class="flex gap-3">
                    <span class="shrink-0 w-6 h-6 rounded-full bg-[#7f5539] text-white text-xs font-bold flex items-center justify-center" aria-hidden="true">3</span>
                    <span>La realizzo in {{ $shippingPreparation }}, poi te la spedisco (consegna in Italia: {{ $shippingDelivery }}).</span>
                </li>
            </ol>
            <a href="/spedizioni/" class="mt-4 inline-block text-sm font-semibold text-[#7f5539] underline underline-offset-2 hover:text-[#9c6644]">Costi e dettagli di spedizione</a>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 p-4 md:p-10 select-none"
             @keydown.escape.window="open = false"
             @keydown.right.window="open && next()"
             @keydown.left.window="open && prev()"
             style="display: none;">
            
            <button type="button" aria-label="Chiudi" @click="open = false" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/70 hover:text-white transition-colors z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <button type="button" aria-label="Foto precedente" @click.stop="prev()" class="absolute left-2 md:left-8 text-white/70 hover:text-white transition-colors z-50 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-14 md:w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            {{-- src solo a lightbox aperto: anche nascosta, l'immagine a piena risoluzione verrebbe scaricata --}}
            <img :src="open ? currentImg : null" alt="{{ $page->nome }}" decoding="async" @click.outside="open = false" class="max-w-full max-h-[90vh] rounded shadow-2xl relative z-40 object-contain">

            <button type="button" aria-label="Foto successiva" @click.stop="next()" class="absolute right-2 md:right-8 text-white/70 hover:text-white transition-colors z-50 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-14 md:w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </template>
</div>

@if ($altriModelli->count() > 0)
    <section class="mt-14 md:mt-20">
        <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#7f5539] mb-5">Altri modelli</h2>
        <ul class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @foreach ($altriModelli as $borsa)
                <li>
                    <a href="{{ $page->conBarra($borsa->getPath()) }}" class="group block">
                        <img src="{{ $borsa->copertina }}"
                             srcset="{{ $page->srcset($borsa->copertina, 800) }}"
                             sizes="(min-width: 1024px) 260px, 45vw"
                             alt="{{ $borsa->nome }}"
                             loading="lazy"
                             decoding="async"
                             class="w-full aspect-[3/4] object-cover rounded-2xl">
                        <p class="mt-2 font-semibold text-stone-800 group-hover:text-[#7f5539] transition-colors">{{ $borsa->nome }}</p>
                        <p class="text-sm text-[#9c6644]">{{ $borsa->prezzo }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
@endif
@endsection
