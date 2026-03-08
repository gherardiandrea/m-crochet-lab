@extends('_layouts.main')

@section('body')
    <section id="home-section" class="scroll-mt-32 mb-10 md:mb-14">
        <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6 md:p-10 lg:p-12">
            <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-5">Home</p>
            <div class="max-w-3xl">
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-[#7f5539] mb-4 md:mb-5">Borse crochet fatte a mano, una per una</h2>
                <p class="text-stone-600 leading-relaxed mb-6 md:mb-7">Benvenuta in M Crochet Lab: qui trovi creazioni artigianali con uno stile caldo, naturale e curato nei dettagli. Ogni modello e pensato per accompagnarti tutti i giorni con originalita.</p>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="/#modelli" class="w-full sm:w-auto text-center py-3 px-4 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">Scopri i modelli</a>
                    <a href="/#chi-sono" class="w-full sm:w-auto text-center py-3 px-4 rounded-xl border-2 border-stone-100 font-semibold text-stone-700 hover:bg-stone-50 transition">Leggi la mia storia</a>
                </div>
            </div>
        </div>
    </section>

    <section id="modelli" class="scroll-mt-32">
        <div class="text-center mb-10 md:mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">I Nostri Modelli</h2>
            <p class="text-stone-500 max-w-xl mx-auto">Ogni borsa è un pezzo unico, realizzato interamente a mano con materiali di prima qualità.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            
            @foreach ($borse->sortBy('ordine') as $borsa)
                @php
                    $isVisible = method_exists($borsa, 'get') ? (bool) $borsa->get('visibile', true) : true;
                @endphp
                @continue(!$isVisible)

                <div class="group w-full max-w-sm mx-auto md:max-w-none bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col">
                    
                    @php
                        $path = (string) $borsa->getPath();
                        $useLowerCropFocus = str_contains($path, 'm-bag-small') || str_contains($path, 'm-bag-extra-large') || str_contains($path, 'e-bag') || str_contains($path, 's-bag');
                    @endphp
                    <a href="{{ $borsa->getPath() }}" class="block aspect-[4/3] sm:aspect-[4/5] overflow-hidden bg-stone-100">
                        <img src="{{ $borsa->copertina }}" 
                             alt="{{ $borsa->nome }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             style="{{ $useLowerCropFocus ? 'object-position: center 72%;' : '' }}">
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
                            
                            <a href="https://ig.me/m/m_crochet_lab"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-full text-center py-3 px-4 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">
                                Contattami su Instagram
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <section id="chi-sono" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center bg-white rounded-3xl shadow-sm p-6 md:p-10">
            <div class="aspect-[4/3] sm:aspect-[4/5] -mx-6 -mt-6 sm:mx-0 sm:mt-0 rounded-t-2xl sm:rounded-2xl overflow-hidden bg-stone-100">
                <img src="/assets/images/homepage/homepage.jpg"
                     alt="Dettaglio artigianale di una borsa crochet"
                     class="w-full h-full object-cover object-[center_38%] md:object-[center_30%]">
            </div>

            <div>
                <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-5">Chi sono</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-5">Creativita, filati e passione artigianale</h2>
                <p class="text-stone-600 mb-4 leading-relaxed">Mi chiamo Mara e ho creato M Crochet Lab per trasformare il crochet in accessori da indossare ogni giorno. Ogni borsa nasce da un'idea, viene realizzata a mano e rifinita con attenzione ai dettagli.</p>
                <p class="text-stone-600 mb-6 leading-relaxed">Lavoro con materiali selezionati, piccoli lotti e tanta cura: cosi ogni pezzo resta speciale, autentico e unico. Se hai in mente un colore o una variante, possiamo personalizzarla insieme.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 text-sm">
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">100% handmade</div>
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">Pezzi unici</div>
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">Personalizzabili</div>
                </div>
            </div>
        </div>
    </section>

    <section id="contatti" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="bg-[#e6ccb2] rounded-3xl p-6 md:p-10 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">Contatti</h2>
            <p class="text-[#7f5539] max-w-2xl mx-auto mb-8">Scrivimi per disponibilita, colori personalizzati o tempi di realizzazione. Ti rispondo volentieri su Instagram.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://ig.me/m/m_crochet_lab"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">
                    Contattami su Instagram
                </a>
                <a href="https://www.instagram.com/m_crochet_lab/"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-[#f4e7db] transition">
                    Seguimi su Instagram
                </a>
            </div>
        </div>
    </section>
@endsection