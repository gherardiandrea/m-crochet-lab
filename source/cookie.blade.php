---
title: Cookie Policy
description: Informativa sull'uso dei cookie
---
@extends('_layouts.main')

@section('body')
    <section class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-10">
        <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-6">Cookie Policy</h2>

        <div class="space-y-5 text-stone-700 leading-relaxed">
            <p>
                Questa pagina spiega come il sito utilizza i cookie e tecnologie simili.
            </p>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Cosa sono i cookie</h3>
                <p>
                    I cookie sono piccoli file di testo che i siti possono salvare sul dispositivo dell'utente per migliorare la navigazione
                    e abilitare alcune funzionalita.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Cookie utilizzati da questo sito</h3>
                <p>
                    Al momento questo sito non utilizza cookie di profilazione o marketing propri.
                    Eventuali cookie tecnici possono essere usati solo per il funzionamento essenziale del sito e dei servizi di hosting (Netlify).
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Servizi di terze parti</h3>
                <p>
                    I link verso piattaforme esterne (ad esempio Instagram) possono portare a siti o app che applicano proprie politiche cookie e privacy.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Gestione dei cookie</h3>
                <p>
                    Puoi gestire o disattivare i cookie dalle impostazioni del browser. La disattivazione dei cookie tecnici potrebbe influire
                    sul corretto funzionamento di alcune pagine.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Aggiornamenti</h3>
                <p>
                    Questa policy puo essere aggiornata in caso di modifiche tecniche o normative. Data ultimo aggiornamento: {{ date('d/m/Y') }}.
                </p>
            </div>
        </div>
    </section>
@endsection
