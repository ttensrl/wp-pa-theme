# wp-pa-theme (monorepo)

Questo repository va clonato direttamente in `wp-content/themes/` e contiene due temi WordPress:

| Cartella | Descrizione |
|---|---|
| `wp-pa-theme/` | Tema **parent** "WP Digital Italia" (Bootstrap Italia, Titillium Web). Documentazione completa in [`wp-pa-theme/README.md`](wp-pa-theme/README.md). |
| `wp-pa-theme-asl/` | **Child theme** per le ASL (`Template: wp-pa-theme`). Eredita layout, font e colori del parent; ospita le personalizzazioni specifiche ASL (`assets/css/asl.css`, `functions.php`). |

```bash
cd wp-content/themes
git clone git@github.com:ttensrl/wp-pa-theme.git .   # oppure nella cartella themes esistente
```

Attivare `WP Digital Italia - ASL` da Aspetto → Temi (il parent deve restare installato).

## Build del parent

```bash
cd wp-pa-theme && npm install && npm run build
```

## Contenuti demo

Per popolare un sito con dati dimostrativi (strutture, persone, servizi, bandi, news, menu) esiste la cartella `demo-content/` nella radice del progetto WordPress (fuori da questo repository): `wp eval-file demo-content/import-all.php`.
