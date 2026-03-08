@extends('_layouts.main')

@section('body')

<div class="mb-8">
    <a href="/" class="inline-flex items-center flex-row gap-2 w-fit text-stone-500 hover:text-[#7f5539] font-medium transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 transform group-hover:-translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        <span class="whitespace-nowrap">Torna ai modelli</span>
    </a>
</div>

{{-- Inizializziamo lo stato della gallery con Alpine.js aggiungendo la logica per le frecce --}}
<div x-data="{ 
    open: false, 
    currentImg: '{{ $page->copertina }}',
    images: {{ json_encode($page->gallery) }},
    next() {
        let index = this.images.indexOf(this.currentImg);
        this.currentImg = index === this.images.length - 1 ? this.images[0] : this.images[index + 1];
    },
    prev() {
        let index = this.images.indexOf(this.currentImg);
        this.currentImg = index === 0 ? this.images[this.images.length - 1] : this.images[index - 1];
    }
}" class="flex flex-col md:flex-row gap-12">
    
    <div class="md:w-1/2">
        <div class="relative group cursor-zoom-in" @click="open = true">
            <img :src="currentImg" class="w-full rounded-2xl shadow-lg mb-4 object-contain md:object-cover aspect-square bg-stone-100">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors rounded-2xl flex items-center justify-center">
                <span class="text-white opacity-0 group-hover:opacity-100 transition-opacity bg-black/50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach($page->gallery as $foto)
                <img src="{{ $foto }}" 
                     @click="currentImg = '{{ $foto }}'"
                     :class="currentImg === '{{ $foto }}' ? 'ring-2 ring-[#7f5539] scale-95' : 'opacity-70 hover:opacity-100'"
                     class="cursor-pointer rounded-lg transition-all duration-200 aspect-square object-cover w-full">
            @endforeach
        </div>
    </div>

    <div class="md:w-1/2">
        <h1 class="text-4xl font-bold text-[#7f5539] mb-4">{{ $page->nome }}</h1>
        <p class="text-2xl font-semibold mb-6 text-stone-700">{{ $page->prezzo }}</p>
        
        <div class="prose text-stone-600 mb-8">
            @yield('content')
        </div>

        <div class="mb-8">
            <h3 class="font-bold mb-3 text-stone-800">Colori disponibili:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($page->colori as $colore)
                    <span class="px-4 py-1.5 bg-stone-200 text-stone-700 rounded-full text-sm font-medium">{{ $colore }}</span>
                @endforeach
            </div>
        </div>

        @php
            // With Jigsaw page data, empty($page->field) can be unreliable on dynamic properties.
            $dimensioni = method_exists($page, 'get') ? $page->get('dimensioni') : null;
            $dettagli = method_exists($page, 'get') ? $page->get('dettagli') : null;
            $shipping = method_exists($page, 'get') ? (array) $page->get('shipping', []) : [];
            $shippingPreparation = (string) ($shipping['preparationTime'] ?? '3-7 giorni lavorativi');
            $shippingDelivery = (string) ($shipping['deliveryTime'] ?? '24-72 ore dopo la spedizione');
        @endphp

        @if ($dimensioni)
            <div class="mb-8">
                <h3 class="font-bold mb-3 text-stone-800">Dimensioni:</h3>
                <p class="inline-flex items-center px-4 py-2 bg-stone-100 text-stone-700 rounded-lg text-sm font-medium">{{ $dimensioni }}</p>
            </div>
        @endif

        @if (is_array($dettagli) && count($dettagli) > 0)
            <div class="mb-8">
                <h3 class="font-bold mb-3 text-stone-800">Dettagli:</h3>
                <ul class="space-y-2 text-stone-700 text-sm">
                    @foreach($dettagli as $dettaglio)
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-2 w-2 rounded-full bg-[#9c6644] shrink-0"></span>
                            <span>{{ $dettaglio }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif (is_string($dettagli) && $dettagli)
            <div class="mb-8">
                <h3 class="font-bold mb-3 text-stone-800">Dettagli:</h3>
                <p class="text-stone-700 text-sm">{{ $dettagli }}</p>
            </div>
        @endif

        <div class="mb-8 rounded-xl border border-stone-200 bg-stone-50 p-4">
            <p class="text-sm font-semibold text-stone-800 mb-1">Spedizione</p>
            <p class="text-sm text-stone-600">Preparazione in {{ $shippingPreparation }}. Consegna in Italia in {{ $shippingDelivery }}.</p>
            <a href="/spedizioni" class="inline-flex mt-3 text-sm font-semibold text-[#7f5539] hover:text-[#9c6644] transition-colors">Leggi tempi e dettagli</a>
        </div>

        <a href="https://ig.me/m/m_crochet_lab"
           target="_blank"
           rel="noopener noreferrer"
           class="inline-flex w-full justify-center items-center gap-2 bg-[#7f5539] hover:bg-[#9c6644] text-white py-4 rounded-xl font-bold shadow-lg transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0C5.826 0 5.555.01 4.703.048 3.85.088 3.27.222 2.762.42a5.06 5.06 0 0 0-1.83 1.191A5.06 5.06 0 0 0 .42 3.44c-.198.507-.332 1.087-.372 1.94C.01 6.232 0 6.503 0 8.677c0 2.174.01 2.445.048 3.297.04.853.174 1.433.372 1.94.22.56.513 1.036.93 1.453.417.417.893.71 1.453.93.507.198 1.087.332 1.94.372.852.038 1.123.048 3.297.048 2.174 0 2.445-.01 3.297-.048.853-.04 1.433-.174 1.94-.372a5.06 5.06 0 0 0 1.453-.93c.417-.417.71-.893.93-1.453.198-.507.332-1.087.372-1.94.038-.852.048-1.123.048-3.297 0-2.174-.01-2.445-.048-3.297-.04-.853-.174-1.433-.372-1.94a5.06 5.06 0 0 0-.93-1.453 5.06 5.06 0 0 0-1.453-.93c-.507-.198-1.087-.332-1.94-.372C10.445.01 10.174 0 8 0zm0 1.441c2.137 0 2.39.008 3.232.046.778.036 1.2.166 1.48.275.37.144.633.316.91.593.277.277.45.54.594.91.109.28.239.702.275 1.48.038.842.046 1.095.046 3.232 0 2.137-.008 2.39-.046 3.232-.036.778-.166 1.2-.275 1.48a3.62 3.62 0 0 1-.593.91 3.62 3.62 0 0 1-.91.594c-.28.109-.702.239-1.48.275-.842.038-1.095.046-3.232.046-2.137 0-2.39-.008-3.232-.046-.778-.036-1.2-.166-1.48-.275a3.62 3.62 0 0 1-.91-.593 3.62 3.62 0 0 1-.594-.91c-.109-.28-.239-.702-.275-1.48-.038-.842-.046-1.095-.046-3.232 0-2.137.008-2.39.046-3.232.036-.778.166-1.2.275-1.48.144-.37.316-.633.593-.91.277-.277.54-.45.91-.594.28-.109.702-.239 1.48-.275.842-.038 1.095-.046 3.232-.046zm0 2.456A4.103 4.103 0 1 0 8 12.103 4.103 4.103 0 0 0 8 3.897zm0 6.765A2.662 2.662 0 1 1 8 5.338a2.662 2.662 0 0 1 0 5.324zm5.224-6.927a.959.959 0 1 1-1.918 0 .959.959 0 0 1 1.918 0z"/>
            </svg>
            Contattami per personalizzazioni
        </a>
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
             @keydown.right.window="next()"
             @keydown.left.window="prev()"
             style="display: none;">
            
            <button @click="open = false" class="absolute top-4 right-4 md:top-8 md:right-8 text-white/70 hover:text-white transition-colors z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <button @click.stop="prev()" class="absolute left-2 md:left-8 text-white/70 hover:text-white transition-colors z-50 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-14 md:w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <img :src="currentImg" @click.outside="open = false" class="max-w-full max-h-[90vh] rounded shadow-2xl relative z-40 object-contain">

            <button @click.stop="next()" class="absolute right-2 md:right-8 text-white/70 hover:text-white transition-colors z-50 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-14 md:w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </template>
</div>
@endsection