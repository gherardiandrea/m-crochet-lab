---
title: Spedizioni
description: Tempi, costi e modalità di consegna
---
@extends('_layouts.main')

@section('body')
    @php
        // I testi vengono da "shipping" in config.php: (array) sull'oggetto di Jigsaw perdeva le chiavi
        $shipping = collect($page->get('shipping', []));
        $shippingPreparation = (string) $shipping->get('preparationTime');
        $shippingDelivery = (string) $shipping->get('deliveryTime');
        $shippingTracking = (string) $shipping->get('tracking');
        $shippingCustomOrders = (string) $shipping->get('customOrders');
        $shippingCosts = (string) $shipping->get('costs');
    @endphp

    <section class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-10">
        <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-6">Spedizioni</h1>

        <div class="space-y-6 text-stone-700 leading-relaxed">
            <p>
                Ogni borsa viene realizzata a mano. Per questo i tempi possono cambiare in base alla disponibilità del modello
                e ad eventuali personalizzazioni.
            </p>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Tempi di preparazione</h2>
                <p>
                    In media: {{ $shippingPreparation }} dalla conferma ordine.
                    Per richieste personalizzate: {{ strtolower($shippingCustomOrders) }}.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Tempi di consegna</h2>
                <p>
                    Dopo la spedizione, la consegna in Italia avviene indicativamente in {{ $shippingDelivery }},
                    in base alla zona e al corriere.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Costi di spedizione</h2>
                <p>
                    {{ $shippingCosts }}
                    Eventuali promozioni o spedizioni gratuite saranno comunicate nei canali ufficiali.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-3">InPost — Locker e InPost Point</h2>
                <p class="mb-4">
                    Un metodo comodo ed economico: ritiri il pacco quando vuoi, senza aspettare il corriere a casa.
                    Puoi scegliere tra migliaia di locker e punti di ritiro in tutta Italia.
                </p>
                <div class="grid grid-cols-3 gap-3">
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-4 text-center">
                        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1">Small</p>
                        <p class="text-2xl font-bold text-[#7f5539]">4,99€</p>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-4 text-center">
                        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1">Medium</p>
                        <p class="text-2xl font-bold text-[#7f5539]">5,99€</p>
                    </div>
                    <div class="rounded-xl border border-stone-200 bg-stone-50 p-4 text-center">
                        <p class="text-xs font-semibold uppercase tracking-wide text-stone-500 mb-1">Large</p>
                        <p class="text-2xl font-bold text-[#7f5539]">6,99€</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Tracciamento</h2>
                <p>
                    {{ $shippingTracking }}.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Supporto</h2>
                <p>
                    Per aggiornamenti su tempi e disponibilità puoi scrivermi direttamente su Instagram.
                </p>
            </div>

            <div class="pt-2">
                <a href="https://ig.me/m/m_crochet_lab"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">
                    Contattami su Instagram
                </a>
            </div>
        </div>
    </section>
@endsection
