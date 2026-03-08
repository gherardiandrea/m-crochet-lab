---
title: Pagina non trovata
description: La pagina richiesta non e disponibile.
permalink: 404.html
---
@extends('_layouts.main')

@section('body')
    <section class="max-w-2xl mx-auto bg-white rounded-3xl shadow-sm p-8 md:p-12 text-center">
        <p class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#9c6644] bg-[#f4e7db] px-3 py-2 rounded-full mb-5">Errore 404</p>
        <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-4">Questa pagina non esiste</h2>
        <p class="text-stone-600 mb-8 leading-relaxed">Il link potrebbe essere cambiato o non piu disponibile. Torna alla home oppure scrivimi su Instagram e ti aiuto subito.</p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="/" class="py-3 px-6 rounded-xl bg-[#7f5539] text-white font-semibold hover:bg-[#9c6644] transition shadow-md">Torna alla Home</a>
            <a href="https://ig.me/m/m_crochet_lab"
               target="_blank"
               rel="noopener noreferrer"
               class="py-3 px-6 rounded-xl border border-[#7f5539] text-[#7f5539] font-semibold hover:bg-[#f4e7db] transition">
                Contattami su Instagram
            </a>
        </div>
    </section>
@endsection
