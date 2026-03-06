@extends('_layouts.main')

@section('body')
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">I Nostri Modelli</h2>
        <p class="text-stone-500 max-w-xl mx-auto">Ogni borsa è un pezzo unico, realizzato interamente a mano con materiali di prima qualità.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        
        @foreach ($borse as $borsa)
            <div class="group bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col">
                
                <a href="{{ $borsa->getPath() }}" class="block aspect-[4/5] overflow-hidden bg-stone-100">
                    <img src="{{ $borsa->copertina }}" 
                         alt="{{ $borsa->nome }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                </a>
                
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-stone-800">
                            <a href="{{ $borsa->getPath() }}" class="hover:text-[#7f5539] transition-colors">
                                {{ $borsa->nome }}
                            </a>
                        </h3>
                        <span class="text-lg font-medium text-[#9c6644]">{{ $borsa->prezzo }}</span>
                    </div>
                    
                    <p class="text-stone-500 text-sm line-clamp-2 mb-6 flex-grow">
                        {{-- Estrae automaticamente le prime righe dal file Markdown --}}
                        {{ $borsa->getExcerpt(120) }}
                    </p>
                    
                    <div class="flex flex-col gap-3">
                        <a href="{{ $borsa->getPath() }}" 
                           class="w-full text-center py-3 px-4 rounded-xl border-2 border-stone-100 font-semibold text-stone-700 hover:bg-stone-50 transition">
                            Vedi Dettagli
                        </a>
                        
                        @php
                            $waMsg = urlencode("Ciao! Ho visto sul sito la borsa " . $borsa->nome . " e vorrei saperne di più.");
                        @endphp
                        <a href="https://wa.me/390000000000?text={{ $waMsg }}" 
                           class="w-full text-center py-3 px-4 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">
                            Ordina Ora
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection