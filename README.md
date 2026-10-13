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

- **Titolo e descrizione** del sito
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
2. Aggiungere le immagini ottimizzate in `source/assets/images/<nome-borsa>/`
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

Convertire i JPEG in WebP con rotazione EXIF corretta (richiede Pillow):

```bash
pip3 install Pillow
python3 -c "
from PIL import Image, ImageOps
img = Image.open('originale.jpeg')
img = ImageOps.exif_transpose(img)
img = img.resize((1200, int(img.height * 1200 / img.width)))
img.save('ottimizzata.webp', 'WEBP', quality=82)
"
```

## Note

- `sitemap.xml` e `robots.txt` vengono corretti da un hook `afterBuild` in `bootstrap.php` (Jigsaw li genera come cartelle, l'hook li converte in file piani).
- La collection `borse` è filtrata dal flag `visibile` nel frontmatter.
- Google Analytics 4 viene caricato solo dopo il consenso cookie dell'utente.
