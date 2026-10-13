@extends('_layouts.main')

@section('body')
    @php
        $shipping = method_exists($page, 'get') ? (array) $page->get('shipping', []) : [];
        $shippingPreparation = (string) ($shipping['preparationTime'] ?? '5-8 giorni lavorativi');
        $shippingDelivery = (string) ($shipping['deliveryTime'] ?? '24-72 ore dopo la spedizione');
        $shippingTracking = (string) ($shipping['tracking'] ?? 'Codice inviato appena parte il pacco');
        $shippingCustomOrders = (string) ($shipping['customOrders'] ?? 'Tempi comunicati prima della conferma');
        $prontaConsegna = json_decode(json_encode($page->get('prontaConsegna', [])), true) ?? [];
    @endphp

    <section class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-12 items-center mb-12 md:mb-16">
        {{-- Foto indossata: fa capire subito com'è la borsa e quanto è grande --}}
        <figure class="md:col-span-5 md:order-2">
            <a href="/modelli/m-bag-extra-large">
                <img src="/assets/images/m-bag-extra-large/4.webp"
                     srcset="{{ $page->srcset('/assets/images/m-bag-extra-large/4.webp') }}"
                     sizes="(min-width: 1152px) 440px, (min-width: 768px) 40vw, 100vw"
                     alt="MBag Extra Large color tortora tenuta in mano"
                     fetchpriority="high"
                     decoding="async"
                     class="w-full aspect-square md:aspect-[4/5] object-cover object-[center_62%] rounded-3xl">
            </a>
            <figcaption class="mt-3 text-sm text-stone-500">
                Nella foto: <a href="/modelli/m-bag-extra-large" class="font-semibold text-[#7f5539] underline underline-offset-2 hover:text-[#9c6644]">MBag Extra Large</a>, color tortora
            </figcaption>
        </figure>

        <div class="md:col-span-7 md:order-1">
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-[#7f5539] leading-[1.05] text-balance">Borse crochet fatte a mano, una per una</h1>
            <p class="mt-5 text-lg text-stone-600 leading-relaxed max-w-xl">Borse all'uncinetto in filato di cotone, realizzate da Mara. Scegli il modello: il colore lo decidiamo insieme.</p>
            <div class="mt-7 flex flex-col sm:flex-row gap-3">
                <a href="/#modelli" class="py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md text-center">Scopri i modelli</a>
                @if (count($prontaConsegna) > 0)
                    <a href="/#pronte-per-te" class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-[#f4e7db] transition text-center">Disponibili subito</a>
                @else
                    <a href="/#chi-sono" class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-[#f4e7db] transition text-center">Leggi la mia storia</a>
                @endif
            </div>
        </div>
    </section>

    <section id="modelli" class="scroll-mt-32">
        <div class="mb-8">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-3">I modelli</h2>
            <p class="text-stone-600 leading-relaxed max-w-xl">Scegli il modello e il colore: la realizzo a mano dopo il tuo ordine, in {{ $shippingPreparation }}.</p>
        </div>

        @php
            // Le borse con la stessa "famiglia" nel frontmatter (le misure della MBag) stanno in un blocco unico
            $famiglie = $borse->filter(fn ($borsa) => $borsa->famiglia)->groupBy(fn ($borsa) => $borsa->famiglia);
            $singole = $borse->reject(fn ($borsa) => $borsa->famiglia);
            $numeri = [2 => 'due', 3 => 'tre', 4 => 'quattro', 5 => 'cinque'];
            $colonne = [2 => 'grid-cols-2', 3 => 'grid-cols-3', 4 => 'grid-cols-2 md:grid-cols-4'];
        @endphp

        @foreach ($famiglie as $famiglia => $misure)
            @php
                $descrizione = (string) $page->get('famiglie')?->get($famiglia)?->get('descrizione');
                $quante = $numeri[$misure->count()] ?? $misure->count();
            @endphp
            <div class="bg-white rounded-3xl p-4 md:p-8 mb-4 md:mb-6">
                <div class="mb-5 md:mb-6">
                    <h3 class="font-serif text-2xl md:text-3xl font-bold text-[#7f5539] mb-1">{{ $famiglia }}</h3>
                    <p class="text-stone-600 leading-relaxed max-w-xl">
                        {{ $descrizione !== '' ? $descrizione . ', in ' . $quante . ' misure.' : 'In ' . $quante . ' misure.' }}
                        Qui le vedi indossate, per confrontarle.
                    </p>
                </div>
                <ul class="grid {{ $colonne[$misure->count()] ?? 'grid-cols-2 md:grid-cols-3' }} gap-3 md:gap-6">
                    @foreach ($misure as $borsa)
                        @php $foto = $borsa->indossata ?: $borsa->copertina; @endphp
                        <li>
                            <a href="{{ $borsa->getPath() }}" class="group block">
                                {{-- Indossata per confrontare le misure; al passaggio del mouse la borsa da sola --}}
                                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-stone-100">
                                    <img src="{{ $foto }}"
                                         srcset="{{ $page->srcset($foto, 800) }}"
                                         sizes="(min-width: 1024px) 340px, 30vw"
                                         alt="{{ $borsa->nome }}{{ $borsa->indossata ? ' indossata' : '' }}"
                                         loading="lazy"
                                         decoding="async"
                                         class="absolute inset-0 w-full h-full object-cover {{ $borsa->indossata ? 'transition-opacity duration-500 group-hover:opacity-0' : '' }}">
                                    @if ($borsa->indossata)
                                        <img src="{{ $borsa->copertina }}"
                                             srcset="{{ $page->srcset($borsa->copertina, 800) }}"
                                             sizes="(min-width: 1024px) 340px, 30vw"
                                             alt=""
                                             loading="lazy"
                                             decoding="async"
                                             class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                                    @endif
                                </div>
                                <div class="mt-2 md:mt-3 md:flex md:items-baseline md:justify-between md:gap-3">
                                    <h4 class="font-semibold text-stone-800 group-hover:text-[#7f5539] transition-colors">{{ $borsa->misura ?: $borsa->nome }}</h4>
                                    <p class="text-sm md:text-base font-medium text-[#9c6644]">{{ $borsa->prezzo }}</p>
                                </div>
                                @if ($borsa->dimensioniBrevi)
                                    <p class="text-xs md:text-sm text-stone-500">{{ $borsa->dimensioniBrevi }}</p>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        @if ($singole->count() > 0)
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                @foreach ($singole as $borsa)
                    <li>
                        <a href="{{ $borsa->getPath() }}" class="group grid grid-cols-5 gap-4 md:gap-6 items-center h-full bg-white rounded-3xl p-3 md:p-4">
                            {{-- Copertina; al passaggio del mouse compare la foto indossata --}}
                            <div class="col-span-2 relative aspect-[3/4] rounded-2xl overflow-hidden bg-stone-100">
                                <img src="{{ $borsa->copertina }}"
                                     srcset="{{ $page->srcset($borsa->copertina, 800) }}"
                                     sizes="(min-width: 768px) 210px, 40vw"
                                     alt="{{ $borsa->nome }}"
                                     loading="lazy"
                                     decoding="async"
                                     class="absolute inset-0 w-full h-full object-cover {{ $borsa->indossata ? 'transition-opacity duration-500 group-hover:opacity-0' : '' }}">
                                @if ($borsa->indossata)
                                    <img src="{{ $borsa->indossata }}"
                                         srcset="{{ $page->srcset($borsa->indossata, 800) }}"
                                         sizes="(min-width: 768px) 210px, 40vw"
                                         alt=""
                                         loading="lazy"
                                         decoding="async"
                                         class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                                @endif
                            </div>
                            <div class="col-span-3 pr-2">
                                <h3 class="font-serif text-2xl md:text-3xl font-bold text-[#7f5539]">{{ $borsa->nome }}</h3>
                                <p class="mt-1 font-medium text-[#9c6644]">{{ $borsa->prezzo }}</p>
                                <p class="mt-3 text-sm md:text-base text-stone-600 leading-relaxed line-clamp-3">{{ $borsa->getExcerpt(200) }}</p>
                                @if ($borsa->dimensioniBrevi)
                                    <p class="mt-2 text-sm text-stone-500">{{ $borsa->dimensioniBrevi }}</p>
                                @endif
                                <p class="mt-4 text-sm font-semibold text-[#7f5539] underline underline-offset-2 group-hover:text-[#9c6644]">Vedi il modello</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    @if(count($prontaConsegna) > 0)
    <section id="pronte-per-te" class="mt-10 md:mt-14 scroll-mt-32 bg-[#f4e7db] rounded-3xl p-6 md:p-10">
        <div class="md:flex md:items-end md:justify-between md:gap-12 mb-6 md:mb-8">
            <div>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-3">Pronte per te</h2>
                <p class="text-stone-700 leading-relaxed max-w-lg">
                    @if(count($prontaConsegna) == 1)
                        Questa borsa è già pronta: la spedisco appena la prenoti.
                    @else
                        Queste {{ count($prontaConsegna) }} borse sono già pronte: le spedisco appena le prenoti.
                    @endif
                </p>
            </div>
            <a href="https://ig.me/m/m_crochet_lab"
               target="_blank"
               rel="noopener noreferrer"
               class="mt-5 md:mt-0 inline-block shrink-0 py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md text-center">
                Scrivimi per prenotare
            </a>
        </div>

        {{-- Su mobile la fila scorre in orizzontale; da desktop è una griglia da 6 --}}
        <ul class="flex lg:grid lg:grid-cols-6 gap-3 md:gap-4 overflow-x-auto snap-x pb-1">
            @foreach($prontaConsegna as $borsa)
            @php
                $gallery = array_values((array) ($borsa['gallery'] ?? []));
                $srcsets = array_map(fn ($foto) => $page->srcset($foto, 800), $gallery);
                $descrizione = trim($borsa['nome'] . ' ' . ($borsa['colore'] ?? ''));
            @endphp
            {{-- Foto sovrapposte con dissolvenza: il mouse mostra la seconda, clic e pallini le sfogliano tutte --}}
            <li x-data="{ foto: 0, n: {{ count($gallery) }} }"
                class="shrink-0 w-32 sm:w-44 lg:w-auto snap-start">
                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-stone-100 cursor-pointer"
                     @click="foto = (foto + 1) % n"
                     @pointerenter="if ($event.pointerType === 'mouse' && n > 1 && foto === 0) foto = 1"
                     @pointerleave="if ($event.pointerType === 'mouse') foto = 0">
                    @foreach($gallery as $idx => $f)
                    <img src="{{ $f }}"
                         srcset="{{ $srcsets[$idx] }}"
                         sizes="(min-width: 1024px) 170px, (min-width: 640px) 176px, 128px"
                         alt="{{ $idx === 0 ? $descrizione : '' }}"
                         loading="lazy"
                         decoding="async"
                         style="{{ $idx > 0 ? 'opacity: 0' : '' }}"
                         :style="{ opacity: foto === {{ $idx }} ? 1 : 0 }"
                         class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500">
                    @endforeach

                    @if(!empty($borsa['novita']) || !empty($borsa['prezzoOriginale']))
                    <div class="absolute top-2 left-2 flex flex-col items-start gap-1">
                        @if(!empty($borsa['novita']))
                        <span class="bg-[#7f5539] text-white text-xs font-bold px-2.5 py-1 rounded-full">Novità</span>
                        @endif
                        @if(!empty($borsa['prezzoOriginale']))
                        <span class="bg-white text-[#7f5539] text-xs font-bold px-2.5 py-1 rounded-full">In sconto</span>
                        @endif
                    </div>
                    @endif

                    @if(count($gallery) > 1)
                    <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5">
                        @foreach($gallery as $idx => $f)
                        <button type="button"
                                aria-label="{{ $descrizione }}, foto {{ $idx + 1 }} di {{ count($gallery) }}"
                                @click.stop="foto = {{ $idx }}"
                                :class="foto === {{ $idx }} ? 'bg-white w-4' : 'bg-white/60 w-1.5'"
                                class="h-1.5 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
                <p class="mt-2 text-sm font-semibold text-stone-800 leading-tight">{{ $borsa['nome'] }}</p>
                @if(!empty($borsa['colore']))
                <p class="text-xs text-stone-600">{{ $borsa['colore'] }}</p>
                @endif
                <p class="text-sm text-[#9c6644]">
                    @if(!empty($borsa['prezzoOriginale']))
                    <span class="line-through text-stone-500 mr-1">{{ $borsa['prezzoOriginale'] }}</span>
                    @endif
                    {{ $borsa['prezzo'] }}
                </p>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    <section id="chi-sono" class="mt-12 md:mt-16 scroll-mt-32 grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-14 items-start">
        <figure class="md:col-span-5">
            <img src="/assets/images/homepage/homepage.jpg"
                 srcset="{{ $page->srcset('/assets/images/homepage/homepage.jpg') }}"
                 sizes="(min-width: 1152px) 440px, (min-width: 768px) 40vw, 100vw"
                 alt="Simba accanto a una borsa all'uncinetto fucsia"
                 loading="lazy"
                 decoding="async"
                 class="w-full aspect-[4/3] md:aspect-[4/5] object-cover object-[center_40%] rounded-3xl">
            <figcaption class="mt-3 text-sm text-stone-500">Simba, il mio assistente ufficiale, al lavoro.</figcaption>
        </figure>

        {{-- Il testo è di Mara: si legge come una lettera, con il primo paragrafo in evidenza e la firma --}}
        <div class="md:col-span-7 max-w-[62ch]">
            <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-5">Chi sono</h2>
            <p class="font-serif text-xl md:text-2xl leading-snug text-stone-800 mb-6">Mi chiamo Mara, ho 27 anni e, se qualche anno fa mi avessero detto che avrei creato borse all'uncinetto, probabilmente avrei riso. Non mi sono mai considerata una persona particolarmente creativa... e forse è proprio per questo che quello che faccio oggi mi sembra ancora più magico.</p>
            <div class="space-y-4 text-stone-600 leading-relaxed">
                    <p>L'uncinetto mi ha insegnato qualcosa di importante: che dal nulla può nascere qualcosa di bello. Un filo, un uncino, un po' di pazienza... e piano piano prende forma una borsa unica.</p>
                    <p>Mi ha insegnato anche che non sempre le cose riescono al primo tentativo. A volte bisogna fermarsi, disfare qualche punto e ricominciare. Ma in fondo è proprio così che si impara, e forse è anche così che funziona la vita.</p>
                    <p>Ogni borsa che realizzo è diversa, imperfetta nel modo più bello possibile, perché fatta a mano e con il suo carattere. Un po' come noi.</p>
                    <p>Ah, e non sono sola in questa avventura: il mio assistente ufficiale è Simba, il mio gattino rosso, grande esperto nel controllare gomitoli, fili in movimento e momenti di pausa.</p>
                    <p>Se sei qui, probabilmente anche tu credi che le cose fatte con calma, pazienza e un pizzico di magia abbiano qualcosa di speciale.</p>
            </div>
            <p class="mt-8 font-serif text-2xl font-bold text-[#7f5539]">Mara</p>
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