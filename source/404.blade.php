---
title: Pagina non trovata
description: La pagina richiesta non è disponibile.
permalink: 404.html
---
@extends('_layouts.main')

@section('body')
    <section class="grid grid-cols-1 md:grid-cols-[minmax(0,5fr)_minmax(0,6fr)] gap-8 md:gap-12 items-center bg-[#f4e7db] rounded-3xl p-6 sm:p-10 md:p-14">
        {{-- Gomitolo con il filo che si srotola: il disegno del filo parte una volta al caricamento --}}
        <svg viewBox="24 44 412 216" class="w-full max-w-sm md:max-w-none mx-auto" role="img" aria-label="Un gomitolo con il filo srotolato">
            <defs>
                <clipPath id="gomitolo">
                    <circle cx="130" cy="150" r="88"/>
                </clipPath>
            </defs>
            <g stroke-linecap="round" stroke-linejoin="round" fill="none">
                <path class="filo-animato" pathLength="1" stroke="#7f5539" stroke-width="3.5"
                      d="M200 184 C 240 204, 250 250, 294 242 C 340 234, 352 170, 314 160 C 276 150, 270 214, 320 226 C 354 234, 392 212, 428 222"/>
                <circle cx="130" cy="150" r="88" fill="#e6ccb2"/>
                <g clip-path="url(#gomitolo)" stroke="#9c6644" stroke-width="2.5">
                    {{-- fascia sotto --}}
                    <path d="M150 40 C 100 100, 92 190, 132 270"/>
                    <path d="M170 44 C 120 104, 112 194, 152 274"/>
                    <path d="M190 50 C 140 110, 132 200, 172 280"/>
                    <path d="M210 58 C 160 118, 152 208, 192 288"/>
                    {{-- fascia sopra: il riempimento copre i fili della fascia sotto --}}
                    <path stroke="none" fill="#e6ccb2" d="M30 104 C 96 62, 196 82, 240 146 L 240 202 C 196 138, 96 118, 30 160 Z"/>
                    <path d="M30 104 C 96 62, 196 82, 240 146"/>
                    <path d="M30 122 C 96 80, 196 100, 240 164"/>
                    <path d="M30 141 C 96 99, 196 119, 240 183"/>
                    <path d="M30 160 C 96 118, 196 138, 240 202"/>
                    {{-- fascia in basso a sinistra --}}
                    <path d="M36 186 C 66 216, 104 234, 150 240"/>
                    <path d="M44 204 C 72 228, 104 242, 140 246"/>
                </g>
                <circle cx="130" cy="150" r="88" stroke="#9c6644" stroke-width="3"/>
            </g>
        </svg>

        <div>
            <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl font-bold text-[#7f5539] leading-tight text-balance mb-5">Qui si è perso il filo</h1>
            <p class="text-stone-700 text-lg leading-relaxed max-w-md mb-8">
                Questa pagina non esiste (errore 404): il link potrebbe essere sbagliato o la pagina è stata spostata.
                Riparti dalla home o scegli una borsa qui sotto.
            </p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/" class="py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md text-center">Torna alla home</a>
                <a href="https://ig.me/m/m_crochet_lab"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-white/60 transition text-center">
                    Scrivimi su Instagram
                </a>
            </div>
        </div>
    </section>

    @if ($borse->count() > 0)
        <section class="mt-12 md:mt-16">
            <h2 class="font-serif text-2xl md:text-3xl font-bold text-[#7f5539] mb-6">Forse cercavi una di queste borse</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
                @foreach ($borse as $borsa)
                    <a href="{{ $borsa->getPath() }}" class="group block">
                        <div class="aspect-square overflow-hidden rounded-2xl bg-stone-100 mb-3">
                            <img src="{{ $borsa->copertina }}"
                                 alt="{{ $borsa->nome }}"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <p class="font-semibold text-stone-800 group-hover:text-[#7f5539] transition-colors">{{ $borsa->nome }}</p>
                        <p class="text-sm text-[#9c6644]">{{ $borsa->prezzo }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
