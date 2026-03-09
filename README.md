# M Crochet Lab

Sito statico di **M Crochet Lab**, realizzato con [Jigsaw](https://jigsaw.tighten.com/) (PHP) e asset pipeline tramite **Laravel Mix** + **Tailwind CSS**.

## Stack

- PHP + Composer
- Jigsaw (`tightenco/jigsaw`)
- Node.js + npm
- Laravel Mix
- Tailwind CSS

## Requisiti

- PHP 8.2+ (allineato al deploy Netlify)
- Composer
- Node.js 20+
- npm

## Installazione

```bash
composer install
npm install
```

## Sviluppo locale

Compila gli asset in modalita` sviluppo:

```bash
npm run dev
```

Avvia build Jigsaw locale:

```bash
./vendor/bin/jigsaw build
```

Se vuoi lavorare con watch sugli asset:

```bash
npm run watch
```

## Build

Build staging (usa `NODE_ENV=staging`):

```bash
npm run staging
./vendor/bin/jigsaw build
```

Build produzione:

```bash
npm run prod
./vendor/bin/jigsaw build production
```

Output principali:

- `build_local/` per build locale
- `build_production/` per build produzione

## Deploy (Netlify)

Configurazione da `netlify.toml`:

- Command: `npm install && npm run prod && ./vendor/bin/jigsaw build production`
- Publish directory: `build_production`
- Environment:
  - `PHP_VERSION=8.2`
  - `NODE_VERSION=20`

## Struttura progetto

- `source/` template Blade, pagine e contenuti
- `source/_borse/` contenuti Markdown per la collection `borse`
- `source/_assets/` sorgenti CSS/JS
- `source/assets/` asset statici (immagini, ecc.)
- `build_local/` output build locale
- `build_production/` output build produzione

## Configurazione sito

Le impostazioni principali stanno in:

- `config.php` (titolo, descrizione, collection, dati spedizioni)
- `config.production.php` (flag produzione e `baseUrl`)

## Note utili

- La collection `borse` è filtrata dal flag `visibile` nei file Markdown.
- Gli excerpt vengono generati automaticamente se non specificati nei contenuti.
