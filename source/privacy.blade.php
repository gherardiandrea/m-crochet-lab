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
                Questa informativa descrive come vengono trattati i dati personali degli utenti che visitano il sito,
                ai sensi del Regolamento UE 2016/679 (GDPR).
            </p>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Titolare del trattamento</h3>
                <p>M Crochet Lab (contatto: Instagram <a class="underline" href="https://www.instagram.com/m_crochet_lab/" target="_blank" rel="noopener noreferrer">@m_crochet_lab</a>).</p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Tipi di dati trattati</h3>
                <p>
                    Durante la navigazione possono essere raccolti dati tecnici necessari al funzionamento del sito
                    (ad esempio indirizzo IP, dati di connessione, log di accesso) da parte del provider hosting Netlify.
                </p>
                <p class="mt-2">
                    Se l'utente acconsente all'uso dei cookie analitici, Google Analytics raccoglie dati anonimi sulla
                    navigazione: pagine visitate, durata della sessione, tipo di dispositivo e paese di provenienza.
                    L'indirizzo IP viene anonimizzato e non sono raccolti dati identificativi diretti.
                </p>
                <p class="mt-2">
                    Se contatti il titolare via Instagram, i dati condivisi nel messaggio saranno trattati solo per rispondere alla tua richiesta.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Hosting</h3>
                <p>
                    Il sito è ospitato su Netlify, che puo trattare dati tecnici necessari all'erogazione del servizio
                    (ad esempio log e dati di traffico) in qualità di fornitore tecnico.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Strumenti di analisi</h3>
                <p>
                    Previo consenso dell'utente, il sito utilizza <strong>Google Analytics 4</strong> (Google LLC) per analizzare
                    il traffico in forma aggregata e anonima, al fine di migliorare i contenuti e l'esperienza di navigazione.
                </p>
                <p class="mt-2">
                    I dati possono essere trasferiti verso server Google negli Stati Uniti, nel rispetto delle garanzie
                    previste dal GDPR (Standard Contractual Clauses).
                    Base giuridica del trattamento: consenso dell'utente (art. 6, par. 1, lett. a GDPR).
                </p>
                <p class="mt-2">
                    Puoi revocare il consenso in qualsiasi momento tramite il banner cookie oppure cancellando i cookie
                    dal tuo browser. Maggiori informazioni:
                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="underline">Privacy Policy di Google</a>.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Finalita e base giuridica</h3>
                <p>
                    I dati sono trattati per: funzionamento e sicurezza del sito, analisi statistica del traffico (solo previo consenso),
                    gestione delle richieste ricevute, adempimento di obblighi legali.
                    La base giuridica è il legittimo interesse del titolare e, quando necessario, il consenso dell'utente o l'esecuzione di misure precontrattuali.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Conservazione dei dati</h3>
                <p>
                    I dati sono conservati per il tempo strettamente necessario alle finalita indicate e secondo i tempi previsti
                    dal provider hosting, da Google Analytics (massimo 14 mesi per i dati analitici) o da obblighi di legge.
                </p>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-stone-800 mb-2">Diritti dell'interessato</h3>
                <p>
                    Hai diritto di chiedere accesso, rettifica, cancellazione, limitazione, opposizione e portabilita dei dati,
                    nei limiti previsti dal GDPR. Puoi revocare il consenso ai cookie in qualsiasi momento.
                    Puoi anche proporre reclamo al Garante per la Protezione dei Dati Personali (<a href="https://www.garanteprivacy.it" target="_blank" rel="noopener noreferrer" class="underline">garanteprivacy.it</a>).
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
