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
            <img :src="currentImg" class="w-full rounded-2xl shadow-lg mb-4 object-cover aspect-square">
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

        <a href="https://wa.me/390000000000?text={{ urlencode('Ciao! Vorrei info su ' . $page->nome) }}" 
           target="_blank"
           class="inline-flex w-full justify-center items-center gap-2 bg-[#7f5539] hover:bg-[#9c6644] text-white py-4 rounded-xl font-bold shadow-lg transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
            </svg>
            Ordina su WhatsApp
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