# wp-pa-theme

Monorepo con due temi WordPress per la Pubblica Amministrazione, da clonare direttamente in `wp-content/themes/`.

| Cartella | Tema |
|---|---|
| [`wp-pa-theme/`](wp-pa-theme/README.md) | **WP Digital Italia** (parent): Bootstrap Italia, Titillium Web, layout portale sanitario |
| [`wp-pa-theme-asl/`](wp-pa-theme-asl/README.md) | **WP Digital Italia - ASL** (child): eredita tutto dal parent e ospita le personalizzazioni delle ASL |

## Installazione

```bash
cd wp-content/themes
git clone git@github.com:ttensrl/wp-pa-theme.git .
```

Poi, da Aspetto → Temi, attivare **WP Digital Italia - ASL** (il parent deve restare installato). Gli asset compilati sono già inclusi: non serve alcuna build per usare i temi.

## Sviluppo

La build riguarda solo il parent (`cd wp-pa-theme && npm install && npm run build`); dopo ogni modifica a `src/` committare anche `dist/`. Dettagli nel README del parent.

## Contenuti demo

Per provare i temi con dati realistici di una ASL (strutture, persone, servizi, bandi, news, menu) si usa la cartella `demo-content/` nella radice del progetto WordPress, fuori da questo repository:

```bash
wp eval-file demo-content/import-all.php   # crea/aggiorna i contenuti e attiva il child ASL
wp eval-file demo-content/reset-all.php    # elimina solo i contenuti demo
```
