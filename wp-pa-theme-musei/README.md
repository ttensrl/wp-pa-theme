# WP Digital Italia - Musei (child theme)

Child theme di `wp-pa-theme` per i musei civici, allineato al prototipo "Musei civici - Modello sito (Community)" (Figma). Per ora e` realizzata solo la **homepage**; il resto del sito (liste, dettagli, pagine di servizio) verra` in seguito. Palette e font sono in `assets/css/musei.css` (variabili `--mu-*`, primario `#5a768a`).

## Struttura
- `style.css`: intestazione del tema (la versione fa da cache-buster per CSS e JS).
- `functions.php`: carica CSS/JS, varianti header/footer, default del Customizer, helper (`musei_date_range`, `musei_format_date`, `musei_alert_text`).
- `inc/post-types.php`: tipi di contenuto **Sedi** (`sede`: orari e indirizzo), **Mostre ed eventi** (`mostra`: tipo, dal/al) e **Opere** (`opera`: artista), con i campi CMB2.
- `page-templates/page-home.php`: home (hero con le sedi, orari e dove siamo, in evidenza, opere, notizie, newsletter, social, sostegno al museo).
- `template-parts/header/site-musei.php`, `template-parts/footer/site-musei.php`: header (fascia ente, testata, menu con sottomenu, "Acquista biglietti", avviso chiudibile) e footer.
- `assets/js/musei.js`: avviso chiudibile e conferma della newsletter (demo).

## Opzioni (Customizer / filtri)
- `musei_alert_text` (theme mod o filtro): testo dell'avviso sotto l'header; vuoto = nessun avviso.
- `musei_tickets_url`, `musei_hero_title`, `musei_hero_text`: link "Acquista biglietti" e testi dell'hero.
- Filtri: `musei_newsletter_action` (URL del form newsletter, di default demo senza invio), `musei_support_url`, `musei_footer_columns`.

## Note
- Il form della newsletter e` dimostrativo: senza il filtro `musei_newsletter_action` non invia dati.
- I link di "Educazione e ricerca" e quelli di trasparenza nel footer sono segnaposto (`#`) fino alla realizzazione delle pagine.
- Il blocco "Dai nostri social" mostra i collegamenti ai profili: il feed dei post del prototipo non e` implementato.
- Contenuti demo: `demo-content/profiles/musei.json` e `demo-content/import-musei.php`.
- Lora e` distribuito dal parent senza `@font-face`: lo dichiara `musei.css` con percorso relativo `../../../wp-pa-theme/dist/fonts/Lora/`.
