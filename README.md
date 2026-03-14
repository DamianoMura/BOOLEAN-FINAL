# JDWDEV.it — Progetto Finale Boolean

Portfolio web application full-stack composta da un **backoffice Laravel** per la gestione dei contenuti e un **frontend React** per la visualizzazione pubblica dei progetti.

---

## Indice

- [Stack Tecnologico](#stack-tecnologico)
- [Architettura del Progetto](#architettura-del-progetto)
- [Installazione e Avvio](#installazione-e-avvio)
- [Backend — Laravel](#backend--laravel)
  - [Autenticazione e Ruoli](#autenticazione-e-ruoli)
  - [Gestione Progetti](#gestione-progetti)
  - [Sezioni di Progetto](#sezioni-di-progetto)
  - [API REST Pubblica](#api-rest-pubblica)
  - [Schema del Database](#schema-del-database)
  - [Sicurezza e Sanitizzazione HTML](#sicurezza-e-sanitizzazione-html)
- [Frontend — React](#frontend--react)
  - [Pagine](#pagine)
  - [Sistema di Filtri](#sistema-di-filtri)
  - [Componenti Principali](#componenti-principali)
- [Struttura delle Directory](#struttura-delle-directory)
- [Variabili d'Ambiente](#variabili-dambiente)
- [Seeding del Database](#seeding-del-database)

---

## Stack Tecnologico

| Layer | Tecnologia |
|---|---|
| Backend framework | Laravel 11 (PHP) |
| Autenticazione | Laravel Breeze |
| Frontend backend (Blade) | Alpine.js, Tailwind CSS |
| Frontend guest | React 19 + Vite 7 |
| Router SPA | React Router DOM 7 |
| UI Kit SPA | Bootstrap 5.3 + FontAwesome |
| HTTP Client SPA | Axios |
| ORM | Eloquent |
| Database | SQLite (default) |
| Build tool backend | Vite + Laravel plugin |

---

## Architettura del Progetto

```
BOOLEAN-FINAL/
├── backend/    → Applicazione Laravel (backoffice + API)
└── frontend/   → Applicazione React (SPA pubblica guest)
```

Il backend espone sia le pagine Blade autenticate (backoffice) sia un set di endpoint API REST pubblici. Il frontend React consuma esclusivamente le API pubbliche tramite chiamate Axios.

---

## Installazione e Avvio

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve          # avvia su http://localhost:8000
```

### Frontend

```bash
cd frontend
npm install
npm run dev                # avvia su http://localhost:5174
```

---

## Backend — Laravel

### Autenticazione e Ruoli

Il sistema usa **Laravel Breeze** per l'autenticazione con sessione. Ogni utente ha esattamente un ruolo (relazione Many-to-Many con vincolo `unique` su `user_id` nella tabella pivot `role_user`).

#### Gerarchia dei Ruoli

| Ruolo | Valore | Permessi |
|---|---|---|
| `dev` | 3 | Gestione utenti e assegnazione ruoli |
| `admin` | 2 | Creazione e gestione progetti, assegnazione editor |
| `user` | 1 | Modifica sezioni sui progetti assegnati |
| `nau` | 0 | Solo accesso in lettura (come guest) |

#### Comportamento per Ruolo

**DEV**
- Visualizza la lista di tutti gli utenti nella dashboard
- Può promuovere un utente a `admin` o degradarlo a `user`
- Non può gestire i contenuti dei progetti
- Il primo account DEV viene creato automaticamente dal seeder (con obbligo di cambio credenziali al primo accesso)

**ADMIN**
- Può creare nuovi progetti, modificarli e eliminarli (solo i propri)
- Può assegnare/rimuovere editor (utenti con ruolo `user`) ai propri progetti
- Gestisce la pubblicazione dei progetti (draft / published)
- Vede tutti i progetti nella sua dashboard con le sezioni relative

**USER**
- Vede solo i progetti ai quali è stato assegnato come editor
- Può aggiungere, modificare e eliminare sezioni nei progetti assegnati
- Non può creare o eliminare progetti

**Middleware `RoleCheck`**
Determina dinamicamente quale componente Blade iniettare nella dashboard in base al ruolo dell'utente corrente.

---

### Gestione Progetti

#### Operazioni CRUD

| Azione | Route | Accesso |
|---|---|---|
| Lista progetti | `GET /projects` | auth (paginazione 12/pagina) |
| Dettaglio | `GET /projects/{slug}` | auth |
| Crea progetto | `GET/POST /projects/create` | admin |
| Modifica | `GET/PUT /projects/{slug}/edit` | admin (solo owner) |
| Gestione editor | `PUT /projects` | admin (solo owner) |

#### Campi del Progetto

- `title` — obbligatorio
- `slug` — generato automaticamente dal titolo, aggiornato se il titolo cambia, garantito univoco
- `description` — HTML arricchito (con sanitizzazione)
- `github_url` — URL opzionale al repository
- `category_id` — relazione 1-N con tabella `categories`
- `published` — booleano (draft/published)
- `author_id` — utente che ha creato il progetto

#### Relazioni

- **Category** (1-N): ogni progetto appartiene a una categoria
- **Technologies** (N-N): ogni progetto può avere più tecnologie tramite tabella pivot `project_technology`
- **Editors** (N-N): ogni progetto può avere più editor tramite tabella pivot `project_user`
- **Sections** (1-N): ogni progetto ha più sezioni con contenuto HTML

---

### Sezioni di Progetto

Le sezioni permettono di strutturare il contenuto di un progetto in blocchi ordinati.

| Azione | Route | Accesso |
|---|---|---|
| Crea sezione | `POST /project-sections` | admin o user assegnato |
| Aggiorna sezione | `PUT /project-sections/{id}` | autore della sezione o admin owner |
| Elimina sezione | `DELETE /project-sections/{id}` | autore della sezione o admin owner |

#### Campi della Sezione

- `title` — titolo della sezione
- `content` — contenuto HTML (sanitizzato)
- `order` — posizione nell'ordinamento
- `published` — visibilità pubblica
- `user_id` — utente che ha creato la sezione
- `last_edited_by` — utente che ha effettuato l'ultima modifica

---

### API REST Pubblica

Base URL: `http://localhost:8000/api`

Tutti gli endpoint sono pubblici (nessuna autenticazione richiesta) e accessibili in sola lettura.

#### `GET /api/projects`

Restituisce la lista paginata dei progetti pubblicati.

**Query Parameters:**

| Parametro | Tipo | Descrizione |
|---|---|---|
| `search` | string (max 25) | Ricerca in titolo e descrizione |
| `category` | string | Filtra per nome categoria |
| `technology` | integer | Filtra per ID tecnologia |
| `author` | string/integer | Filtra per ID o nome autore |
| `sort_by` | string | Colonna di ordinamento (`created_at`, `title`, `updated_at`, `id`) |
| `sort_order` | string | Direzione (`asc`, `desc`) |
| `per_page` | integer (max 5) | Elementi per pagina |

**Struttura risposta:**
```json
{
  "success": true,
  "data": [ { "id": 1, "slug": "...", "title": "...", "category": "...", "author": "...", "technologies": [...], "stats": { "sections_count": 5, "technologies_count": 3 } } ],
  "meta": { "total": 10, "per_page": 5, "current_page": 1, "last_page": 2 },
  "links": { "first": "...", "last": "...", "prev": null, "next": "..." }
}
```

#### `GET /api/projects/{slug}`

Restituisce il dettaglio di un singolo progetto con tutte le relazioni (categoria, tecnologie, sezioni pubblicate, editor).

#### `GET /api/categories`

Restituisce tutte le categorie disponibili (`id`, `name`, `label`).

#### `GET /api/technologies`

Restituisce tutte le tecnologie disponibili (`id`, `name`, `label`, `fontawesome_class`).

---

### Schema del Database

```
users               → id, name, email, password, timestamps
roles               → id, name, label, timestamps
role_user           → id, user_id (UNIQUE), role_id, timestamps
projects            → id, title, slug (UNIQUE), description, github_url, category_id, author_id, published, timestamps
categories          → id, name, label, timestamps
technologies        → id, name, label, fontawesome_class, timestamps
project_technology  → id, project_id, technology_id, timestamps
project_user        → id, project_id, user_id, timestamps  (editors)
project_sections    → id, project_id, user_id, last_edited_by, title, content, published, order, timestamps
sessions            → Laravel session storage
password_reset_tokens
```

---

### Sicurezza e Sanitizzazione HTML

Il contenuto HTML immesso dagli utenti passa attraverso tre livelli di protezione:

1. **Middleware `SanitizeHtmlInput`** — applicato a tutte le richieste di creazione/modifica di progetti e sezioni; sanitizza i campi `content`, `description`, `body`, `html_content` prima che raggiungano il controller.

2. **Cast `HtmlCasts`** — cast Eloquent personalizzato sul modello; sanitizza il valore prima della scrittura su database e decodifica le entità HTML in lettura.

3. **Service `HtmlSanitizer`** — usa la libreria HTMLPurifier con una whitelist di tag consentiti, rimuovendo script, handler di eventi e qualsiasi markup pericoloso.

---

## Frontend — React

La SPA React funge da portale pubblico (guest). Non richiede autenticazione e consuma solo le API pubbliche del backend.

### Pagine

| Componente | Route | Descrizione |
|---|---|---|
| `Landing` | `/` | Pagina di benvenuto con hero section |
| `Home` | `/home` | Presenta il progetto d'esame come progetto in evidenza |
| `ProjectsPage` | `/projects` | Lista dei progetti con filtri avanzati e paginazione |
| `ProjectDetail` | `/projects/:slug` | Dettaglio completo di un progetto con sezioni |
| `About` | `/about` | Pagina informativa |
| `NotFound` | `*` | Pagina 404 |

### Sistema di Filtri

Il `FiltersContext` gestisce lo stato globale dei filtri e li sincronizza con i query parameter dell'URL.

**Filtri disponibili:**
- Ricerca testuale (titolo + descrizione)
- Filtro per categoria (select popolato dinamicamente via API)
- Filtro per tecnologia (select popolato dinamicamente via API)
- Ordinamento: per data di creazione, titolo, data di aggiornamento
- Direzione: crescente / decrescente

I filtri applicati vengono riflessi nell'URL e persistono al refresh della pagina.

**Paginazione:** 5 risultati per pagina con link di navigazione fissi in fondo alla pagina.

### Componenti Principali

| Componente | Ruolo |
|---|---|
| `DefaultLayout` | Layout wrapper con Navbar e Breadcrumbs |
| `Navbar` | Barra di navigazione sticky con link alle sezioni principali |
| `Breadcrumbs` | Navigazione contestuale |
| `ProjectSnap` | Card riassuntiva di un progetto (titolo, categoria, tecnologie, stats) |
| `ProjectSection` | Rendering di una sezione di progetto con contenuto HTML |
| `Filters` | Interfaccia completa per la ricerca, i filtri e l'ordinamento |

---

## Struttura delle Directory

```
backend/
├── app/
│   ├── Casts/HtmlCasts.php                    ← Cast Eloquent per HTML
│   ├── Http/
│   │   ├── Controllers/api/                   ← ProjectController, CategoryController, TechnologyController
│   │   ├── Middleware/RoleCheck.php            ← Routing dashboard per ruolo
│   │   ├── Middleware/SanitizeHtmlInput.php    ← Sanitizzazione input HTML
│   │   └── Requests/                          ← Form Requests con validazione
│   ├── Models/                                ← User, Project, Role, Category, Technology, ProjectSection
│   ├── Services/HtmlSanitizer.php             ← Servizio sanitizzazione con HTMLPurifier
│   └── View/Components/                       ← Blade components per dashboard
├── database/
│   ├── migrations/                            ← Schema del database
│   ├── factories/                             ← Factory per test
│   └── seeders/                              ← DatabaseSeeder, FakeUsers, FakeProject
├── resources/views/                           ← Template Blade per backoffice
├── routes/
│   ├── api.php                               ← Endpoint API pubblici
│   ├── web.php                               ← Route autenticate backoffice
│   └── auth.php                              ← Route autenticazione Breeze
└── config/tech-list.php                      ← Definizione delle 13 tecnologie

frontend/
├── src/
│   ├── context/FiltersContext.jsx             ← Stato globale filtri
│   ├── layouts/
│   │   ├── DefaultLayout.jsx
│   │   └── components/ (Navbar, Breadcrumbs)
│   ├── pages/
│   │   ├── Landing.jsx
│   │   ├── Home.jsx
│   │   ├── ProjectsPage.jsx
│   │   ├── ProjectDetail.jsx
│   │   ├── About.jsx
│   │   ├── NotFound.jsx
│   │   └── components/ (ProjectSnap, ProjectSection, Filters)
│   ├── App.jsx                               ← Routing principale
│   └── main.jsx
└── vite.config.js
```

---

## Variabili d'Ambiente

### Backend (`.env`)

```env
APP_NAME=JDWDEV.it
APP_ENV=local
APP_KEY=                    # generata con artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost

GUEST_APP_PORT=5174         # porta del frontend React

BCRYPT_ROUNDS=12

DB_CONNECTION=sqlite        # nessuna configurazione aggiuntiva necessaria

SESSION_DRIVER=database
SESSION_LIFETIME=120

MAIL_MAILER=log             # le email vengono loggate in storage/logs
```

### Frontend

La base URL delle API è configurata direttamente in `FiltersContext.jsx`:
```js
// http://localhost:8000
```

---

## Seeding del Database

Il seeder (`php artisan migrate --seed`) crea automaticamente:

- **Ruoli**: `dev`, `admin`, `user`
- **Categorie**: NDC (Undefined), Front End, Back End, Full Stack
- **Tecnologie**: PHP, JavaScript, Alpine.js, Node.js, React, MySQL, SQLite, Laravel, HTML, CSS, SASS, Bootstrap, Tailwind CSS (con relative classi FontAwesome)
- **Utente DEV predefinito** con credenziali da cambiare al primo accesso
- **Progetto di esempio** (`boolean-exam-final-project`) con 10 sezioni che documentano le funzionalità del progetto stesso

---

## Rotte di Autenticazione

| Metodo | Route | Descrizione |
|---|---|---|
| GET | `/register` | Form di registrazione |
| POST | `/register` | Registra nuovo utente |
| GET | `/login` | Form di login |
| POST | `/login` | Autentica l'utente |
| POST | `/logout` | Termina la sessione |
| GET | `/forgot-password` | Richiesta reset password |
| POST | `/forgot-password` | Invia email di reset |
| GET | `/reset-password/{token}` | Form reset password |
| POST | `/reset-password` | Aggiorna la password |
| GET/PATCH/DELETE | `/profile` | Gestione profilo utente |
