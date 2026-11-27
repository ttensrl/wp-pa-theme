# WP Digital Italia - Scuole (child theme)

Child theme di `wp-pa-theme` per il profilo **scuola**, allineato al modello [Design Scuole](https://italia.github.io/design-scuole-pagine-statiche/) di Designers Italia. Per ora sono realizzati **header, footer e home**; le pagine interne usano i template del parent con la palette del profilo.

## Struttura
- `style.css`: intestazione del tema (la versione fa da cache-buster per il CSS).
- `functions.php`: carica `assets/css/scuola.css`, varianti header/footer, ente (Ministero), etichetta "Accedi", helper (`scuola_school_year`, `scuola_topics`, `scuola_logo_url`, `scuola_page_url`).
- `template-parts/header/site-scuola.php`: fascia del Ministero con "Accedi", marchio a tre righe, ricerca e social, menu a colori per sezione (Scuola rosso, Servizi viola, Novità verde, Didattica blu) e argomenti a destra.
- `template-parts/footer/site-scuola.php`: marchio, quattro colonne di link, link legali con social, dati dell'istituto, credito a Designers Italia.
- `page-templates/page-home.php`: hero, Notizie e Circolari, Servizi, La didattica (offerta formativa ad accordion), risorse didattiche.
- `assets/css/scuola.css`, `assets/images/` (pattern e ornamenti dell'hero).

## Opzioni (Customizer / filtri)
- Theme mod: `scuola_hero_title`, `scuola_hero_label` (testi dell'hero), `scuola_codice_meccanografico`, `scuola_ipa`, `scuola_cuf` (riga dei codici nel footer); `site_contact_*` per indirizzo, telefono, email, PEC, codice fiscale.
- Filtri: `scuola_topics` (argomenti in alto a destra, di default le categorie piu' usate), `scuola_resources` (card "Progetti" e "Schede didattiche"), `scuola_footer_columns`.

## Note
- La colonna "Circolari" usa la categoria `circolari`; se non esiste mostra gli ultimi bandi ("Avvisi e bandi").
- "Offerta formativa" elenca le strutture di primo livello (`dipartimento`); le card "Progetti" e "Schede didattiche" puntano per ora alla pagina delle notizie.
- Il menu principale va impostato con quattro voci per rispettare i colori di sezione (assegnati per posizione).
- Nei template del parent non usare variabili globali di WordPress (`$posts`, `$post`, `$wp_query`): `load_template()` le dichiara globali e sovrascriverle rompe la query principale.
- Contenuti demo: `demo-content/profiles/scuole.json` e `demo-content/import-all.php scuole`.
