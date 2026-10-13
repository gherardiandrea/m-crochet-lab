# M Crochet Lab

Sviluppato da [Andrea Gherardi](https://www.linkedin.com/in/andrea-gherardi-0b99b1b7/) · [GitHub](https://github.com/gherardiandrea)

Sito vetrina di **M Crochet Lab**, realizzato con [Jigsaw](https://jigsaw.tighten.com/) (PHP) e asset pipeline tramite **Laravel Mix** + **Tailwind CSS**.

Pubblicato su: [m-crochet-lab.netlify.app](https://m-crochet-lab.netlify.app/)

## Stack

- PHP + Composer
- Jigsaw (`tightenco/jigsaw`)
- Node.js + npm
- Laravel Mix
- Tailwind CSS
- Alpine.js (interazioni frontend)

## Requisiti

- PHP 8.2+
- Composer
- Node.js 20+
- npm

## Installazione

```bash
composer install
npm install
```

## Sviluppo locale

Avvia il sito in locale con watch su asset e Jigsaw:

```bash
npm run watch:site
```

Il sito sarà disponibile su `http://localhost:8000`.

Per compilare solo gli asset:

```bash
npm run dev       # sviluppo
npm run watch     # sviluppo con watch
npm run prod      # produzione
```

## Build

Build produzione completa:

```bash
npm run prod && ./vendor/bin/jigsaw build production
```

Output in `build_production/`.

## Deploy (Netlify)

Configurazione in `netlify.toml`:

- Command: `npm install && npm run prod && ./vendor/bin/jigsaw build production`
- Publish directory: `build_production`
- Environment: `PHP_VERSION=8.2`, `NODE_VERSION=20`

## Struttura progetto

```
source/
├── _layouts/        # Layout Blade (main, prodotto)
├── _borse/          # Prodotti in Markdown (collection "borse")
├── assets/
│   ├── images/      # Immagini ottimizzate (WebP)
│   └── raw-images/  # Originali non ottimizzati
├── index.blade.php  # Homepage
├── privacy.blade.php
├── cookie.blade.php
├── spedizioni.blade.php
├── 404.blade.php
├── sitemap.xml.blade.php
├── robots.txt.blade.php
└── favicon.png
```

## Configurazione sito

Tutto in `config.php`:

- **Nome e slogan** del sito (`siteName`, `tagline`): compaiono nell'header e nei `<title>`
- **Dati spedizioni** (tempi, costi, tracking)
- **Barra promozionale** — per attivarla/disattivarla:

```php
'promoAttiva' => true,           // false per disattivare
'promoScadenza' => '2026-05-19', // ultimo giorno incluso; '' = nessuna scadenza
'promoBarra' => '...',           // testo della barra in cima
```

Dopo `promoScadenza` la barra sparisce da sola, anche senza un nuovo deploy.

## Aggiungere un prodotto

1. Creare un file `.md` in `source/_borse/`
2. Aggiungere le immagini ottimizzate in `source/assets/images/<nome-borsa>/` e generare le varianti (vedi [Ottimizzazione immagini](#ottimizzazione-immagini))
3. Impostare `visibile: true` nel frontmatter

Struttura frontmatter prodotto:

```yaml
---
extends: _layouts.prodotto
section: content
nome: Nome Borsa
ordine: 1
prezzo: 35€
dimensioni: "L 34 cm x H 25 cm"
dettagli:
  - "Dettaglio 1"
copertina: /assets/images/nome-borsa/1.webp
gallery:
  - /assets/images/nome-borsa/1.webp
  - /assets/images/nome-borsa/2.webp
visibile: true
---
Descrizione della borsa.
```

## Ottimizzazione immagini

Script in `scripts/ottimizza-immagini.py` (richiede Pillow: `pip3 install Pillow`).

Convertire un originale (da `raw-images/`) in WebP, con rotazione EXIF corretta e larghezza massima 1440px:

```bash
python3 scripts/ottimizza-immagini.py converti source/assets/raw-images/borsa/foto.jpg source/assets/images/borsa/1.webp
```

Dopo aver aggiunto o sostituito foto, generare le versioni ridotte (`-400.webp`, `-800.webp`) usate dal `srcset`.
Se mancano il sito funziona lo stesso, ma scarica le foto a piena risoluzione:

```bash
python3 scripts/ottimizza-immagini.py varianti
```

## Note

- `sitemap.xml` e `robots.txt` vengono corretti da un hook `afterBuild` in `bootstrap.php` (Jigsaw li genera come cartelle, l'hook li converte in file piani).
- La collection `borse` è filtrata dal flag `visibile` nel frontmatter.
- Google Analytics 4 viene caricato solo dopo il consenso cookie dell'utente.
