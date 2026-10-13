#!/usr/bin/env python3
"""Ottimizzazione immagini del sito (richiede Pillow: pip3 install Pillow).

  python3 scripts/ottimizza-immagini.py converti ORIGINALE DESTINAZIONE.webp
      Raddrizza secondo l'EXIF, riduce a 1440px di larghezza e salva in WebP.

  python3 scripts/ottimizza-immagini.py varianti
      Crea le versioni -400.webp e -800.webp di ogni foto in source/assets/images
      (usate dal srcset in config.php). Rigenera solo quelle mancanti o più vecchie.
"""
import re
import sys
from pathlib import Path

from PIL import Image, ImageOps

CARTELLA_IMMAGINI = Path(__file__).resolve().parent.parent / "source/assets/images"
LARGHEZZA_MASSIMA = 1440
LARGHEZZE_VARIANTI = (400, 800)
QUALITA = 82
VARIANTE = re.compile(r"-\d+$")


def ridimensiona(img, larghezza):
    if img.width <= larghezza:
        return img
    return img.resize((larghezza, round(img.height * larghezza / img.width)), Image.LANCZOS)


def converti(origine, destinazione):
    img = ImageOps.exif_transpose(Image.open(origine)).convert("RGB")
    ridimensiona(img, LARGHEZZA_MASSIMA).save(destinazione, "WEBP", quality=QUALITA, method=6)
    print(f"{origine} -> {destinazione}")


def varianti():
    foto = [
        p for p in sorted(CARTELLA_IMMAGINI.rglob("*"))
        if p.suffix.lower() in (".webp", ".jpg", ".jpeg") and not VARIANTE.search(p.stem)
    ]
    for sorgente in foto:
        img = None
        for larghezza in LARGHEZZE_VARIANTI:
            destinazione = sorgente.with_name(f"{sorgente.stem}-{larghezza}.webp")
            if destinazione.exists() and destinazione.stat().st_mtime >= sorgente.stat().st_mtime:
                continue
            if img is None:
                img = ImageOps.exif_transpose(Image.open(sorgente)).convert("RGB")
            if img.width <= larghezza:
                continue
            ridimensiona(img, larghezza).save(destinazione, "WEBP", quality=QUALITA, method=6)
            print(destinazione.relative_to(CARTELLA_IMMAGINI))


if __name__ == "__main__":
    if len(sys.argv) == 4 and sys.argv[1] == "converti":
        converti(sys.argv[2], sys.argv[3])
    elif len(sys.argv) == 2 and sys.argv[1] == "varianti":
        varianti()
    else:
        sys.exit(__doc__)
