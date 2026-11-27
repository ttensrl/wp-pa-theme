# WP Digital Italia - ASL (child theme)

Child theme di `wp-pa-theme` (`Template: wp-pa-theme`) per le Aziende Sanitarie Locali, allineato al prototipo AGID "ASL - Modello sito (Community)" (Figma). Palette e font del profilo sono in `assets/css/asl.css` (variabili `--asl-*`).

## Struttura
- `style.css`: intestazione del tema (la versione fa da cache-buster per CSS e JS).
- `functions.php`: carica CSS/JS, varianti header/footer, default del Customizer, archivio dei servizi, indice della pagina, helper (`asl_set_page_index`, `asl_map_url`, `asl_servizio_strutture`).
- `page-templates/page-home.php`: home (ricerca, in evidenza, servizi, FSE, come fare per, tutto per, ASL comunica, bandi). Filtri: `asl_quick_searches`, `asl_targets`, `asl_fse_url`.
- `archive-servizio.php`, `archive-dipartimento.php`: liste "Servizi e prestazioni" e "Strutture".
- `single-servizio.php`, `single-dipartimento.php`: pagine di dettaglio con indice laterale.
- `sidebar.php`: sidebar unica "Indice della pagina" (ancore nei dettagli, navigazione di sezione negli archivi).
- `template-parts/`: `header/` e `footer/` (varianti ASL), `list/hero.php`, `detail/head.php`, `home/quick-access.php` (disattivato).
- `assets/js/asl.js`: "Condividi" e voce attiva dell'indice.

## Note
- Il tipo `servizio` del parent non ha archivio: lo attiva `functions.php`. Dopo il primo deploy salvare i permalink (o `wp rewrite flush`).
- Lora e` distribuito dal parent senza `@font-face`: lo dichiara `asl.css`, con percorso relativo `../../../wp-pa-theme/dist/fonts/Lora/`.
- Per sovrascrivere un altro template del parent, copiarlo qui con lo stesso percorso.
