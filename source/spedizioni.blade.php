---
title: Spedizioni
description: Tempi, costi e modalità di consegna
---
@extends('_layouts.main')

@section('body')
    @php
        // I testi vengono da "shipping" in config.php
        $shipping = collect($page->get('shipping', []));
        $shippingPreparation = (string) $shipping->get('preparationTime');
        $shippingDelivery = (string) $shipping->get('deliveryTime');
        $shippingTracking = (string) $shipping->get('tracking');
        $shippingCustomOrders = (string) $shipping->get('customOrders');
        $shippingCosts = (string) $shipping->get('costs');
        $tariffe = collect($shipping->get('inpost', []));
    @endphp

    <div class="max-w-3xl mx-auto">
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-[#7f5539]">Spedizioni</h1>
        <p class="mt-4 text-lg text-stone-600 leading-relaxed max-w-2xl">
            Ogni borsa viene realizzata a mano. Per questo i tempi possono cambiare in base alla disponibilità del modello
            e ad eventuali personalizzazioni.
        </p>

        <dl class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-5 border-y border-stone-200 py-6">
            <div>
                <dt class="text-sm font-semibold text-stone-800">Realizzazione</dt>
                <dd class="mt-1 text-stone-600">{{ $shippingPreparation }} dalla conferma dell'ordine</dd>
            </div>
            <div>
                <dt class="text-sm font-semibold text-stone-800">Consegna</dt>
                <dd class="mt-1 text-stone-600">{{ $shippingDelivery }}, con codice di tracciamento</dd>
            </div>
            @if ($tariffe->isNotEmpty())
                <div>
                    <dt class="text-sm font-semibold text-stone-800">Costo</dt>
                    <dd class="mt-1 text-stone-600">Con InPost da {{ $tariffe->first() }}, in base al formato del pacco</dd>
                </div>
            @endif
            <div>
                <dt class="text-sm font-semibold text-stone-800">Dove</dt>
                <dd class="mt-1 text-stone-600">Spedisco solo in Italia</dd>
            </div>
        </dl>

        {{-- Domande con <details>: si aprono e chiudono anche senza JavaScript --}}
        <section class="mt-10">
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#7f5539] mb-2">Domande frequenti</h2>
            <div class="border-t border-stone-200">
                @php
                    $domande = [
                        ['Quanto costa la spedizione?', 'costi'],
                        ['Quanto tempo ci vuole per riceverla?', 'tempi'],
                        ['Posso seguire il pacco?', 'tracciamento'],
                        ["Spedisci anche all'estero?", 'estero'],
                    ];
                @endphp
                @foreach ($domande as [$domanda, $risposta])
                    <details class="group border-b border-stone-200 py-5" @if ($loop->first) open @endif>
                        <summary class="flex items-center justify-between gap-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden font-semibold text-lg text-stone-800">
                            {{ $domanda }}
                            <span class="shrink-0 w-8 h-8 rounded-full bg-[#f4e7db] text-[#7f5539] flex items-center justify-center text-xl leading-none transition-transform group-open:rotate-45" aria-hidden="true">+</span>
                        </summary>
                        <div class="mt-4 text-stone-700 leading-relaxed">
                            @if ($risposta === 'costi')
                                <p>
                                    Spedisco con <strong>InPost</strong>: ritiri il pacco quando vuoi in uno dei locker o punti di ritiro
                                    in tutta Italia, senza aspettare il corriere a casa.
                                </p>
                                @if ($tariffe->isNotEmpty())
                                    <div class="grid grid-cols-3 gap-3 my-5">
                                        @foreach ($tariffe as $formato => $prezzo)
                                            <div class="rounded-2xl bg-white p-4 text-center">
                                                <p class="text-sm text-stone-500">{{ $formato }}</p>
                                                <p class="mt-1 text-2xl font-bold text-[#7f5539]">{{ $prezzo }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <p>{{ $shippingCosts }} Eventuali promozioni o spedizioni gratuite saranno comunicate nei canali ufficiali.</p>
                            @elseif ($risposta === 'tempi')
                                <p>
                                    In media la realizzo in {{ $shippingPreparation }} dalla conferma dell'ordine.
                                    Per le richieste personalizzate: {{ strtolower($shippingCustomOrders) }}.
                                </p>
                                <p class="mt-3">La consegna in Italia avviene indicativamente in {{ $shippingDelivery }}, in base alla zona e al corriere.</p>
                            @elseif ($risposta === 'tracciamento')
                                <p>Sì. {{ $shippingTracking }} Per aggiornamenti su tempi e disponibilità puoi scrivermi quando vuoi.</p>
                            @else
                                <p>No, per ora le spedizioni sono solo in Italia.</p>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        </section>
    </div>
@endsection
