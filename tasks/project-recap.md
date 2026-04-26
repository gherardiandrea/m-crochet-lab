# M Crochet Lab — Project Recap

> Documento di riferimento per ricaricare rapidamente il contesto del progetto.
> Aggiornato al 2026-04-26.

## 1. Cos'è

Sito **vetrina** (non e-commerce) di **M Crochet Lab**, brand artigianale di Mara
che produce borse all'uncinetto fatte a mano. Le vendite NON avvengono sul sito:
ogni CTA porta su Instagram DM (`https://ig.me/m/m_crochet_lab`).

- Pubblicato su: `https://m-crochet-lab.netlify.app`
- Account IG: `@m_crochet_lab`
- Sviluppatore: Andrea Gherardi (LinkedIn + GitHub linkati nel footer)

## 2. Stack tecnologico

- **Generatore statico:** Jigsaw 1.7 (Tighten) — Blade + Markdown collections
- **Backend build:** PHP 8.2 + Composer
- **Frontend build:** Laravel Mix 6 + Tailwind CSS 3 + PostCSS
- **Interazioni:** Alpine.js 3 (CDN)
- **Hosting:** Netlify (build su `build_production/`)
- **Analytics:** Google Analytics 4 (`G-4T9M96K0MF`), caricato SOLO dopo consenso

## 3. Struttura del repo

```
source/
├── _layouts/
│   ├── main.blade.php         # Layout globale (header, nav, cookie banner, footer, SEO meta)
│   └── prodotto.blade.php     # Pagina prodotto con gallery Alpine + lightbox
├── _borse/                    # Collection prodotti (uno .md per borsa)
│   ├── e-bag.md  m-bag-{small,medium,large,extra-large}.md  s-bag.md
├── _assets/{css,js}/          # Sorgenti compilati da Mix
├── assets/
│   ├── images/                # WebP ottimizzate (servite)
│   └── raw-images/            # Originali (non deployate, gitignore?)
├── index.blade.php            # Homepage one-page (sezioni: home, modelli, chi-sono, spedizioni, contatti)
├── privacy.blade.php          # Privacy Policy (GDPR)
├── cookie.blade.php           # Cookie Policy con tabella cookie
├── spedizioni.blade.php       # Tempi/costi/tracking
├── 404.blade.php
├── sitemap.xml.blade.php      # Generata dinamicamente da staticPaths + collection borse
├── robots.txt.blade.php       # Allow in prod, Disallow in dev
└── favicon.png / favicon.svg / site.webmanifest

config.php                     # Config sito (titolo, descrizione, shipping, promoAttiva, collections)
config.production.php          # Override produzione
bootstrap.php                  # Hook afterBuild: trasforma /robots.txt/index.html → /robots.txt piano
netlify.toml                   # Build command + publish dir
```

## 4. Convenzioni e pattern

- **Aggiungere prodotto:** creare `source/_borse/<slug>.md` con frontmatter `extends: _layouts.prodotto` + `nome`, `prezzo`, `dimensioni`, `dettagli[]`, `copertina`, `gallery[]`, `visibile: true`, `ordine`.
- **Filtro visibilità:** `config.php` filtra la collection `borse` per `visibile == true`.
- **URL prodotti:** `modelli/<filename>` (es. `/modelli/e-bag`).
- **Crop immagini in homepage:** `m-bag-small`, `m-bag-extra-large`, `e-bag`, `s-bag` usano `object-position: center 72%` per inquadrare la borsa.
- **Promo banner:** `promoAttiva: true` in `config.php` attiva sia la barra in alto sia il modale `promo-banner.svg` (mostrato 1x per sessione, sessionStorage `promo_seen`).
- **Cookie consent:** `localStorage.cookie_consent = accepted|declined`. `loadGA()` viene chiamato solo se `accepted`.
- **SEO:** title/description costruiti dinamicamente in `main.blade.php` con fallback intelligenti per pagine prodotto. OG/Twitter card già presenti. `canonical` solo se `baseUrl` configurato.

## 5. Build e deploy

- **Locale watch:** `npm run watch:site` → Jigsaw build + serve su `localhost:8000` + Mix watch.
- **Produzione:** `npm run prod && ./vendor/bin/jigsaw build production` → `build_production/`.
- **Netlify:** Command già configurato in `netlify.toml` (`PHP_VERSION=8.2`, `NODE_VERSION=20`).

## 6. Stato prodotti (al recap)

- e-bag — visibile (35€)
- m-bag-small — visibile
- m-bag-medium — **visibile: false** (foto da rifare)
- m-bag-large — visibile
- m-bag-extra-large — visibile
- s-bag — visibile

## 7. Palette / design system

Colori chiave (hardcoded nel template):
- `#7f5539` marrone scuro (testi importanti, CTA primaria)
- `#9c6644` marrone medio (accenti, hover)
- `#e6ccb2` beige (header, contatti card)
- `#f4e7db` beige chiaro (badge, hover secondari)
- `stone-*` (Tailwind) per neutri

Componenti ricorrenti:
- Card bianche `rounded-3xl shadow-sm`, hover `shadow-2xl`
- Badge sezione: pill uppercase `tracking-[0.2em] text-[#9c6644] bg-[#f4e7db]`
- CTA primaria: `bg-[#7f5539] hover:bg-[#9c6644]` con shadow
- CTA secondaria: bordo + `text-[#7f5539]`

## 8. Workflow obbligatori (da CLAUDE.md)

- Pianificare prima per task da 3+ step → scrivere in `tasks/todo.md`
- Aggiornare `tasks/lessons.md` dopo ogni correzione utente
- Prima la semplicità, zero pigrizia, impatto minimo
- Verificare prima di considerare completato

## 9. Quirks / cose da ricordare

- `bootstrap.php` rimedia al fatto che Jigsaw genera `robots.txt/index.html` invece di `robots.txt` piano: hook `afterBuild` lo appiana.
- Inline styles nel modale promo e nel cookie banner (non Tailwind) — scelta voluta per essere indipendenti dal CSS compilato.
- Gallery prodotto: lightbox custom con frecce, ESC e click-outside via Alpine `x-teleport`.
- Nessun form server-side: tutto passa per Instagram DM.
