@extends('_layouts.main')

@section('body')
    @php
        $promoAttiva = (bool) $page->promoAttiva;
        $promoMessaggio = (string) ($page->promoMessaggio ?? '');
        $promoScadenza = (string) ($page->promoScadenza ?? '');
        $promoGiorni = '';
        if ($promoAttiva && $promoScadenza) {
            $diff = (new DateTime($promoScadenza))->diff(new DateTime())->days;
            $promoGiorni = $diff > 0 ? $diff . ' giorni' : '';
        }
    @endphp

    @if ($promoAttiva)
    <div
        x-data="{
            show: false,
            init() {
                if (!sessionStorage.getItem('promo_seen')) {
                    setTimeout(() => { this.show = true; }, 1500);
                }
            },
            close() {
                sessionStorage.setItem('promo_seen', '1');
                this.show = false;
            }
        }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        role="dialog"
        aria-modal="true"
        aria-label="Promozione di lancio"
        style="position:fixed;inset:0;z-index:60;display:flex;align-items:center;justify-content:center;padding:12px;background:rgba(41,24,14,0.6);"
        @click.self="close()"
    >
        <div style="position:relative;width:100%;max-width:680px;border-radius:16px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,0.35);">

            <button
                @click="close()"
                aria-label="Chiudi"
                style="position:absolute;top:10px;right:10px;z-index:10;width:32px;height:32px;border-radius:50%;background:rgba(0,0,0,0.45);border:none;cursor:pointer;color:#fff;font-size:1rem;line-height:1;display:flex;align-items:center;justify-content:center;"
                onmouseover="this.style.background='rgba(0,0,0,0.7)'"
                onmouseout="this.style.background='rgba(0,0,0,0.45)'"
            >✕</button>

            <a
                href="https://ig.me/m/m_crochet_lab"
                target="_blank"
                rel="noopener noreferrer"
                @click="close()"
                style="display:block;line-height:0;"
            >
                <img
                    src="/assets/images/promo-banner.svg"
                    alt="Offerta di lancio M Crochet Lab"
                    loading="lazy"
                    decoding="async"
                    style="display:block;width:100%;height:auto;"
                >
            </a>

        </div>
    </div>
    @endif

    @php
        $shipping = method_exists($page, 'get') ? (array) $page->get('shipping', []) : [];
        $shippingPreparation = (string) ($shipping['preparationTime'] ?? '5-8 giorni lavorativi');
        $shippingDelivery = (string) ($shipping['deliveryTime'] ?? '24-72 ore dopo la spedizione');
        $shippingTracking = (string) ($shipping['tracking'] ?? 'Codice inviato appena parte il pacco');
        $shippingCustomOrders = (string) ($shipping['customOrders'] ?? 'Tempi comunicati prima della conferma');
    @endphp

    <section id="home-section" class="scroll-mt-32 mb-10 md:mb-14">
        <div class="bg-white rounded-3xl shadow-sm p-5 sm:p-6 md:p-10 lg:p-12">
            <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-5">Home</p>
            <div class="max-w-3xl">
                <h2 class="font-serif text-2xl sm:text-3xl md:text-5xl font-bold text-[#7f5539] mb-4 md:mb-5">Borse crochet fatte a mano, una per una</h2>
                <p class="text-stone-600 leading-relaxed mb-6 md:mb-7">Ti do il benvenuto in M Crochet Lab: qui trovi creazioni artigianali con uno stile caldo, naturale e curato nei dettagli. Ogni modello è pensato per accompagnarti tutti i giorni con originalità.</p>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="/#modelli" class="w-full sm:w-auto text-center py-3 px-4 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">Scopri i modelli</a>
                    <a href="/#chi-sono" class="w-full sm:w-auto text-center py-3 px-4 rounded-xl border-2 border-stone-100 font-semibold text-stone-700 hover:bg-stone-50 transition">Leggi la mia storia</a>
                </div>
            </div>
        </div>
    </section>

    <section id="modelli" class="scroll-mt-32">
        <div class="text-center mb-10 md:mb-12">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">I Modelli</h2>
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
                             loading="lazy"
                             decoding="async"
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

    @php
        $prontaConsegna = json_decode(json_encode($page->get('prontaConsegna', [])), true) ?? [];
    @endphp
    @if(count($prontaConsegna) > 0)
    <section id="pronte-per-te" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-10">
            <div class="mb-8 md:mb-10">
                <p class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-[0.2em] text-emerald-700 bg-emerald-50 px-3 py-2 rounded-full mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    @if(count($prontaConsegna) == 1)
                        Disponibile ora
                    @else
                        Disponibili ora
                    @endif
                </p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-3">Pronte per te</h2>
                <p class="text-stone-500 leading-relaxed max-w-lg">Pezzi unici, già pronti per essere indossati. Basta scegliere il tuo.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($prontaConsegna as $borsa)
                @php $galleryJson = json_encode(array_values((array)($borsa['gallery'] ?? []))); @endphp
                <div x-data="{ foto: 0, gallery: {{ $galleryJson }} }"
                     class="group bg-stone-50 border border-stone-100 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300">

                    <div class="relative aspect-square overflow-hidden bg-stone-100 cursor-pointer" @click="foto = (foto + 1) % gallery.length">
                        <img :src="gallery[foto]"
                             alt="{{ $borsa['nome'] }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                        <div class="absolute top-3 left-3 flex flex-col items-start gap-1.5">
                            <span class="inline-flex items-center gap-1.5 bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Disponibile
                            </span>
                            @if(!empty($borsa['novita']))
                            <span class="inline-flex items-center bg-[#7f5539] text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Novità assoluta
                            </span>
                            @endif
                            @if(!empty($borsa['prezzoOriginale']))
                            <span class="inline-flex items-center text-xs font-bold px-3 py-1.5 rounded-full shadow-sm" style="background:#f4e7db;color:#7f5539;">
                                In sconto per la festa della mamma
                            </span>
                            @endif
                        </div>

                        @if(count($borsa['gallery'] ?? []) > 1)
                        <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5">
                            @foreach($borsa['gallery'] as $idx => $f)
                            <button @click.stop="foto = {{ $idx }}"
                                    :class="foto === {{ $idx }} ? 'bg-white w-4' : 'bg-white/50 w-1.5'"
                                    class="h-1.5 rounded-full transition-all duration-300"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-bold text-stone-800 text-lg leading-tight">{{ $borsa['nome'] }}</p>
                                @if(!empty($borsa['colore']))
                                <p class="text-xs text-stone-400 mt-0.5">{{ $borsa['colore'] }}</p>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                @if(!empty($borsa['prezzoOriginale']))
                                <p class="text-xs text-stone-400 line-through">{{ $borsa['prezzoOriginale'] }}</p>
                                @endif
                                <p class="font-bold text-xl" style="color:#7f5539;">{{ $borsa['prezzo'] }}</p>
                            </div>
                        </div>
                        <a href="https://ig.me/m/m_crochet_lab"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="mt-4 w-full text-center block py-2.5 px-4 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition text-sm shadow-sm">
                            Scrivimi per prenotare
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section id="chi-sono" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center bg-white rounded-3xl shadow-sm p-6 md:p-10">
            <div class="aspect-[4/3] sm:aspect-[4/5] -mx-6 -mt-6 sm:mx-0 sm:mt-0 rounded-t-2xl sm:rounded-2xl overflow-hidden bg-stone-100">
                <img src="/assets/images/homepage/homepage.jpg"
                     alt="Dettaglio artigianale di una borsa crochet"
                     loading="lazy"
                     decoding="async"
                     class="w-full h-full object-cover object-[center_38%] md:object-[center_30%]">
            </div>

            <div>
                <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-5">Chi sono</p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-5">Creatività, filati e passione artigianale</h2>
                <p class="text-stone-600 mb-4 leading-relaxed">Mi chiamo Mara, ho 27 anni e, se qualche anno fa mi avessero detto che avrei creato borse all'uncinetto, probabilmente avrei riso. Non mi sono mai considerata una persona particolarmente creativa... e forse è proprio per questo che quello che faccio oggi mi sembra ancora più magico.</p>
                <p class="text-stone-600 mb-4 leading-relaxed">L'uncinetto mi ha insegnato qualcosa di importante: che dal nulla può nascere qualcosa di bello. Un filo, un uncino, un po' di pazienza... e piano piano prende forma una borsa unica.</p>
                <p class="text-stone-600 mb-4 leading-relaxed">Mi ha insegnato anche che non sempre le cose riescono al primo tentativo. A volte bisogna fermarsi, disfare qualche punto e ricominciare. Ma in fondo è proprio così che si impara, e forse è anche così che funziona la vita.</p>
                <p class="text-stone-600 mb-4 leading-relaxed">Ogni borsa che realizzo è diversa, imperfetta nel modo più bello possibile, perché fatta a mano e con il suo carattere. Un po' come noi.</p>
                <p class="text-stone-600 mb-4 leading-relaxed">Ah, e non sono sola in questa avventura: il mio assistente ufficiale è Simba, il mio gattino rosso, grande esperto nel controllare gomitoli, fili in movimento e momenti di pausa.</p>
                <p class="text-stone-600 mb-6 leading-relaxed">Se sei qui, probabilmente anche tu credi che le cose fatte con calma, pazienza e un pizzico di magia abbiano qualcosa di speciale.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6 text-sm">
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">100% fatte a mano</div>
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">Pezzi unici</div>
                    <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-3 font-medium text-stone-700">Personalizzabili</div>
                </div>
            </div>
        </div>
    </section>

    <section id="spedizioni" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-10">
            <div class="text-center mb-8">
                <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-4">Spedizioni</p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-3">Tempi e consegna</h2>
                <p class="text-stone-600 max-w-2xl mx-auto">Ogni borsa viene realizzata a mano: i tempi possono variare in base al modello e alle personalizzazioni richieste.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 text-sm">
                <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-4">
                    <p class="font-semibold text-stone-800 mb-1">Preparazione</p>
                    <p class="text-stone-600">{{ $shippingPreparation }}</p>
                </div>
                <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-4">
                    <p class="font-semibold text-stone-800 mb-1">Consegna Italia</p>
                    <p class="text-stone-600">{{ $shippingDelivery }}</p>
                </div>
                <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-4">
                    <p class="font-semibold text-stone-800 mb-1">Tracciamento</p>
                    <p class="text-stone-600">{{ $shippingTracking }}</p>
                </div>
                <div class="bg-stone-50 border border-stone-200 rounded-xl px-4 py-4">
                    <p class="font-semibold text-stone-800 mb-1">Personalizzazioni</p>
                    <p class="text-stone-600">{{ $shippingCustomOrders }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="/spedizioni" class="py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md text-center">Leggi dettagli spedizioni</a>
                <a href="https://ig.me/m/m_crochet_lab"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-[#f4e7db] transition text-center">
                    Chiedi info su Instagram
                </a>
            </div>
        </div>
    </section>

    <section id="contatti" class="mt-10 md:mt-14 scroll-mt-32">
        <div class="bg-[#e6ccb2] rounded-3xl p-6 md:p-10 text-center">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">Contatti</h2>
            <p class="text-[#7f5539] max-w-2xl mx-auto mb-8">Scrivimi per disponibilità, colori personalizzati o tempi di realizzazione. Ti rispondo volentieri su Instagram.</p>
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