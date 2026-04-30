---
title: Spedizioni
description: Tempi, costi e modalita di consegna
---
@extends('_layouts.main')

@section('body')
    @php
        $shipping = method_exists($page, 'get') ? (array) $page->get('shipping', []) : [];
        $shippingPreparation = (string) ($shipping['preparationTime'] ?? '5-8 giorni lavorativi');
        $shippingDelivery = (string) ($shipping['deliveryTime'] ?? '24-72 ore dopo la spedizione');
        $shippingTracking = (string) ($shipping['tracking'] ?? 'Codice inviato appena parte il pacco');
        $shippingCustomOrders = (string) ($shipping['customOrders'] ?? 'Tempi comunicati prima della conferma');
        $shippingCosts = (string) ($shipping['costs'] ?? 'I costi vengono indicati prima della conferma ordine in base al peso, al volume e alla destinazione.');
    @endphp

    <section class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-10">
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-6">Spedizioni</h2>

        <div class="space-y-6 text-stone-700 leading-relaxed">
            <p>
                Ogni borsa viene realizzata a mano. Per questo i tempi possono cambiare in base alla disponibilita del modello
                e ad eventuali personalizzazioni.
            </p>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Tempi di preparazione</h3>
                <p>
                    In media: {{ $shippingPreparation }} dalla conferma ordine.
                    Per richieste personalizzate: {{ strtolower($shippingCustomOrders) }}.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Tempi di consegna</h3>
                <p>
                    Dopo la spedizione, la consegna in Italia avviene indicativamente in {{ $shippingDelivery }},
                    in base alla zona e al corriere.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Costi di spedizione</h3>
                <p>
                    {{ $shippingCosts }}
                    Eventuali promozioni o spedizioni gratuite saranno comunicate nei canali ufficiali.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Tracciamento</h3>
                <p>
                    {{ $shippingTracking }}.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Supporto</h3>
                <p>
                    Per aggiornamenti su tempi e disponibilita puoi scrivermi direttamente su Instagram.
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
