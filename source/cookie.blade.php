---
title: Cookie Policy
description: Informativa sull'uso dei cookie
---
@extends('_layouts.main')

@section('body')
    <section class="max-w-3xl mx-auto bg-white rounded-3xl shadow-sm p-6 md:p-10">
        <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#7f5539] mb-6">Cookie Policy</h1>

        <div class="space-y-5 text-stone-700 leading-relaxed">
            <p>
                Questa pagina spiega come il sito utilizza i cookie e tecnologie simili, ai sensi del D.Lgs. 196/2003,
                del Provvedimento del Garante Privacy del 10 giugno 2021 e del Regolamento UE 2016/679 (GDPR).
            </p>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Titolare del trattamento</h2>
                <p>
                    <strong>Mara Benintendi</strong> &mdash; Paladina (BG), Italia.<br>
                    Email: <a class="underline" href="mailto:marabenintendi00@gmail.com">marabenintendi00@gmail.com</a>
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Cosa sono i cookie</h2>
                <p>
                    I cookie sono piccoli file di testo che i siti possono salvare sul dispositivo dell'utente per migliorare la navigazione
                    e abilitare alcune funzionalità.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Cookie tecnici</h2>
                <p>
                    Il sito utilizza una preferenza tecnica salvata nel <strong>localStorage</strong> del browser
                    (chiave <code class="bg-stone-100 px-1 rounded text-sm">cookie_consent</code>) per ricordare la tua scelta sul consenso ai cookie analitici.
                    Questa memorizzazione è strettamente necessaria al funzionamento del banner e non richiede consenso preventivo.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Cookie analitici di terze parti (Google Analytics 4)</h2>
                <p class="mb-3">
                    Previo tuo consenso esplicito, il sito utilizza <strong>Google Analytics 4</strong> (fornito da Google LLC)
                    per analizzare il traffico in forma anonima e aggregata. L'IP viene anonimizzato e non sono raccolti dati identificativi diretti.
                    Google Analytics installa i seguenti cookie:
                </p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-stone-100 text-stone-800">
                                <th class="text-left px-3 py-2 font-semibold border border-stone-200">Cookie</th>
                                <th class="text-left px-3 py-2 font-semibold border border-stone-200">Scopo</th>
                                <th class="text-left px-3 py-2 font-semibold border border-stone-200">Durata</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-3 py-2 border border-stone-200 font-mono">_ga</td>
                                <td class="px-3 py-2 border border-stone-200">Distingue gli utenti unici</td>
                                <td class="px-3 py-2 border border-stone-200">2 anni</td>
                            </tr>
                            <tr class="bg-stone-50">
                                <td class="px-3 py-2 border border-stone-200 font-mono">_ga_*</td>
                                <td class="px-3 py-2 border border-stone-200">Mantiene lo stato della sessione</td>
                                <td class="px-3 py-2 border border-stone-200">2 anni</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="mt-3">
                    I dati raccolti sono anonimi e non consentono l'identificazione personale dell'utente.
                    I dati possono essere trasferiti verso server Google negli Stati Uniti, nel rispetto delle garanzie
                    previste dal GDPR (Standard Contractual Clauses).
                    Puoi consultare la
                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="underline">Privacy Policy di Google</a>
                    per maggiori dettagli.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Servizi di terze parti</h2>
                <p>
                    I link verso piattaforme esterne (ad esempio Instagram) possono portare a siti o app che applicano proprie politiche cookie e privacy,
                    indipendenti da questo sito.
                </p>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Come gestire o revocare il consenso</h2>
                <p>Puoi modificare la tua scelta in qualsiasi momento:</p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Cliccando sul link <strong>"Gestisci preferenze cookie"</strong> presente nel footer del sito (riapre il banner)</li>
                    <li>Cancellando i cookie e il localStorage dal tuo browser (la scelta verrà azzerata e il banner riapparirà)</li>
                    <li>Installando il
                        <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer" class="underline">Google Analytics Opt-out Add-on</a>
                    </li>
                    <li>Disattivando i cookie di terze parti dalle impostazioni del tuo browser</li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-stone-800 mb-2">Aggiornamenti</h2>
                <p>
                    Questa policy può essere aggiornata in caso di modifiche tecniche o normative. Ultimo aggiornamento: <strong>13 ottobre 2026</strong>.
                </p>
            </div>
        </div>
    </section>
@endsection
