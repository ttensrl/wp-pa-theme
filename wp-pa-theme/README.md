# WP Digital Italia (`wp-pa-theme`)

Tema WordPress per siti istituzionali e della Pubblica Amministrazione, basato su [Bootstrap Italia](https://italia.github.io/bootstrap-italia/) (font Titillium Web, componenti accessibili, linee guida AgID).
Include un layout "portale sanitario" (home con slider news, organigramma, strutture, bandi, sidebar a box) pensato per ASL e enti analoghi.

> Questo tema è il **parent**. Il child theme per le ASL è `../wp-pa-theme-asl` (vedi il [README del repository](../README.md)).

## Requisiti

- WordPress 5.0+ e PHP 7.4+
- Node.js solo se si modificano gli stili/script: **gli asset compilati sono già in `dist/`** e vengono versionati nel repository.

## Installazione

1. Clonare il repository in `wp-content/themes/` (contiene sia questo tema sia il child ASL).
2. Aspetto → Temi → attivare *WP Digital Italia* (o il child *WP Digital Italia - ASL*).
3. Configurare Aspetto → Personalizza (vedi sotto).

## Sviluppo e build

Sorgenti in `src/` (SCSS e JS), compilati con Vite in `dist/`:

```bash
npm install
npm run build   # produce dist/css/main.css, dist/js/main.js, font e icone
npm run dev     # build in watch
```

**Dopo ogni modifica a `src/` eseguire `npm run build` e committare anche `dist/`**: il tema in produzione non compila nulla.

| Percorso | Contenuto |
|---|---|
| `src/scss/main.scss` | Entry point: importa i moduli Bootstrap Italia usati e `_layouts.scss` |
| `src/scss/_custom-colors.scss` | Palette (HSB) da modificare per cambiare il colore primario |
| `src/scss/_layouts.scss` | Stili del layout (boxed/full, slider, sidebar a box, liste, `@font-face` Titillium) |
| `src/js/main.js` | Entry JS: moduli Bootstrap Italia, slider news, cookie consent |

## Opzioni tema

Aspetto → Personalizza → **Layout e Home**:

| Opzione | Default | Note |
|---|---|---|
| Larghezza del sito | Boxed | *Boxed*: sfondi a tutta larghezza, contenuti centrati in 1200px. *Full*: contenitori fluidi. Classe `layout-boxed` / `layout-full` sul `<body>` |
| Slider news in home | Attivo | Numero di news (1-10), categoria, scorrimento automatico |
| Sidebar: titolo e orari del box contatti | vuoto | Il telefono è quello di *Site Contact* |

Altre sezioni del Customizer: **Site Contact** (email, telefono, indirizzo, P.IVA, città, URP, Amministrazione Trasparente), **Site Socials**, **Cookies Settings**, **Loghi** (principale, ente di appartenenza, chiaro per il footer). Senza logo l'header mostra il nome del sito.

## Layout

- **Home** (`page-templates/page-home.php`, parti in `template-parts/home/`): fascia "Scopri come fare per", hero slider delle news, ricerca, tab Informa (notizie / bandi), strutture, guida ai servizi. Senza sidebar.
- **Pagine interne**: sidebar **sempre a sinistra** (`sidebar.php`) con box colorati derivati dal colore primario: navigazione di sezione (contestuale), contatti, "Scopri come fare per", accordion *Guida ai servizi* e *Strutture*, area widget `sidebar-1`. Nel DOM il contenuto precede la sidebar (ordine di tabulazione corretto) e viene riordinato con `order-lg-*`.
- **Organigramma** (`page-templates/page-organigramma.php`): accordion per struttura di primo livello con persone, ruoli e unità collegate.
- **Strutture** (`archive-dipartimento.php`), **Bandi** (`archive-bando.php`, filtro per anno, stato *In corso*/*Scaduto*), **Persone** (`archive-persona.php`).
- **Altri template di pagina**: `page-full.php` (larghezza piena), `page-booking.php` (prenotazioni).

Accessibilità: skip link, landmark etichettati, `aria-*` su tab/accordion/slider, slider con pausa, stop su hover/focus e rispetto di `prefers-reduced-motion`, focus visibile.

## Contenuti (Custom Post Type)

| CPT | Slug / archivio | Campi principali |
|---|---|---|
| `dipartimento` (gerarchico) | `/dipartimento/` | contatti, mappa (lat/lng), responsabile, organigramma, servizi collegati |
| `persona` | `/persona/` | nome, cognome, email, telefono, ruolo, storico incarichi |
| `servizio` | single | descrizione, prenotazione opzionale |
| `bando` | `/bandi/{anno}/{slug}/` | tipo, importo, CIG, CPV, date, allegati, termini, aggiudicatari |
| `appuntamento` | admin | prenotazioni (dati richiedente, data, servizio) |

I metabox usano CMB2 (inclusa in `wp-digital-italia-extension/`).

## Prenotazione appuntamenti

Gestione slot (singoli e generazione per intervallo di date), giorni di chiusura, calendario guidato lato cittadino (mese → giorno → orario), email di conferma. Crea le tabelle `wp_booking_slots`, `wp_booking_reservations`, `wp_booking_closed_days` all'attivazione. Endpoint AJAX pubblici: `get_available_appointments`, `submit_booking`; admin: `swb_*` (slot, giorni di chiusura).

## Cookie consent (GDPR)

Banner e modale preferenze con consensi granulari (analytics, marketing, social, YouTube). Ogni categoria ha un oggetto in `cookiesDispatcher` con `activate` e `fallback`; per personalizzarlo in un child theme caricare il proprio script dopo `cookies-dispatcher` e ridefinire le callback.

## Integrazioni

Elementor (breadcrumb e ottimizzazione risorse), Jetpack, override del blocco *Ultimi articoli* con le card Bootstrap Italia. Breadcrumb con microdata Schema.org (`wpdi_breadcrumbs()`, filtro `wpdi_breadcrumbs_defaults`).

## Struttura

```
wp-pa-theme/
├── assets/            # immagini (placeholder slider/news), CSS e JS non compilati (booking, cookie)
├── classes/           # walker dei menu (Bootstrap 5)
├── dist/              # asset compilati (versionati)
├── inc/               # helper, opzioni tema, customizer, booking, breadcrumb
├── page-templates/    # home, organigramma, full, booking
├── src/               # sorgenti SCSS/JS
├── template-parts/    # parti di template (home, contenuti, cookie, prenotazione)
├── wp-digital-italia-extension/   # CPT e CMB2
└── *.php              # template principali
```

## Licenza e contatti

GPL v2 o successiva. Assistenza: luca.terribili@tten.it
