---
title: Privacy Policy
description: Informativa sul trattamento dei dati personali
---
@extends('_layouts.main')

@section('body')
    <section class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-10">
        <h2 class="text-3xl md:text-4xl font-bold text-[#7f5539] mb-6">Privacy Policy</h2>

        <div class="space-y-5 text-stone-700 leading-relaxed">
            <p>
                Questa informativa descrive come vengono trattati i dati personali degli utenti che visitano il sito.
            </p>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Titolare del trattamento</h3>
                <p>M Crochet Lab (contatto: Instagram <a class="underline" href="https://www.instagram.com/m_crochet_lab/" target="_blank" rel="noopener noreferrer">@m_crochet_lab</a>).</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Tipi di dati trattati</h3>
                <p>
                    Durante la navigazione possono essere raccolti dati tecnici necessari al funzionamento del sito (ad esempio indirizzo IP,
                    dati di connessione, log di accesso) da parte del provider hosting Netlify.
                </p>
                <p>
                    Se contatti il titolare via Instagram, i dati condivisi nel messaggio saranno trattati solo per rispondere alla tua richiesta.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Hosting</h3>
                <p>
                    Il sito e ospitato su Netlify, che puo trattare dati tecnici necessari all'erogazione del servizio
                    (ad esempio log e dati di traffico) in qualita di fornitore tecnico.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Finalita e base giuridica</h3>
                <p>
                    I dati sono trattati per: funzionamento e sicurezza del sito, gestione delle richieste ricevute, adempimento di obblighi legali.
                    La base giuridica e il legittimo interesse del titolare e, quando necessario, l'esecuzione di misure precontrattuali.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Conservazione dei dati</h3>
                <p>
                    I dati sono conservati per il tempo strettamente necessario alle finalita indicate e secondo i tempi previsti dal provider hosting
                    o da obblighi di legge.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Diritti dell'interessato</h3>
                <p>
                    Hai diritto di chiedere accesso, rettifica, cancellazione, limitazione, opposizione e portabilita dei dati, nei limiti previsti
                    dal Regolamento UE 2016/679 (GDPR). Puoi anche proporre reclamo al Garante Privacy.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Aggiornamenti</h3>
                <p>
                    Questa informativa puo essere aggiornata nel tempo. Data ultimo aggiornamento: {{ date('d/m/Y') }}.
                </p>
            </div>
        </div>
    </section>
@endsection
