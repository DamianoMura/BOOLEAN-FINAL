# Frontend — React SPA

SPA pubblica (guest) del progetto JDWDEV.it. Consuma le API REST del backend Laravel per visualizzare i progetti senza richiedere autenticazione.

## Stack

- React 19 + Vite 7
- React Router DOM 7
- Bootstrap 5.3
- FontAwesome (brands + solid + regular)
- Axios
- React Context API

## Avvio

```bash
npm install
npm run dev     # http://localhost:5174
```

## Struttura

```
src/
├── context/FiltersContext.jsx   ← Stato globale filtri + chiamate API categorie/tecnologie
├── layouts/
│   ├── DefaultLayout.jsx        ← Layout con Navbar e Breadcrumbs
│   └── components/
│       ├── Navbar.jsx
│       └── Breadcrumbs.jsx
├── pages/
│   ├── Landing.jsx              ← Hero page
│   ├── Home.jsx                 ← Progetto in evidenza
│   ├── ProjectsPage.jsx         ← Lista progetti + paginazione
│   ├── ProjectDetail.jsx        ← Dettaglio progetto con sezioni
│   ├── About.jsx
│   ├── NotFound.jsx
│   └── components/
│       ├── ProjectSnap.jsx      ← Card riassuntiva progetto
│       ├── ProjectSection.jsx   ← Sezione con rendering HTML
│       └── Filters.jsx          ← Filtri, ricerca e ordinamento
├── App.jsx                      ← Routing
└── main.jsx
```

## Pagine e Route

| Route | Componente | Descrizione |
|---|---|---|
| `/` | Landing | Pagina di benvenuto |
| `/home` | Home | Progetto in evidenza |
| `/projects` | ProjectsPage | Lista con filtri e paginazione |
| `/projects/:slug` | ProjectDetail | Dettaglio progetto |
| `/about` | About | Informazioni |
| `*` | NotFound | 404 |

## Sistema di Filtri

I filtri sono gestiti globalmente da `FiltersContext` e sincronizzati con i query parameter dell'URL.

- Ricerca testuale (titolo + descrizione)
- Filtro per categoria
- Filtro per tecnologia
- Ordinamento per: data creazione, titolo, data aggiornamento
- Direzione: asc / desc
- Paginazione: 5 risultati per pagina

## API consumate

Base URL: `http://localhost:8000/api`

- `GET /api/projects` — lista paginata con filtri
- `GET /api/projects/:slug` — dettaglio progetto
- `GET /api/categories` — lista categorie (per i filtri)
- `GET /api/technologies` — lista tecnologie (per i filtri)
