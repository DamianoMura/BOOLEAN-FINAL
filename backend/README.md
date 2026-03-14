# Backend — Laravel 11

Backoffice e API REST del progetto JDWDEV.it.

## Stack

- Laravel 11 (PHP)
- Laravel Breeze (autenticazione)
- SQLite (database default, nessuna configurazione aggiuntiva)
- Eloquent ORM
- Alpine.js + Tailwind CSS (Blade views)
- HTMLPurifier (sanitizzazione HTML)
- Vite (build frontend Blade)

## Avvio

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve    # http://localhost:8000
```

> L'URL principale (`/`) reindirizza al login. La SPA React è il punto di ingresso per i visitatori non autenticati.

## Sistema di Ruoli

Ogni utente ha esattamente un ruolo (tabella pivot `role_user` con `user_id` UNIQUE).

| Ruolo | Permessi |
|---|---|
| `dev` | Gestione utenti e assegnazione ruoli |
| `admin` | CRUD progetti (propri), assegnazione editor, gestione pubblicazione |
| `user` | Modifica sezioni sui progetti assegnati |
| `nau` | Solo accesso in lettura (come guest) |

Il **Middleware `RoleCheck`** inietta il componente Blade corretto nella dashboard in base al ruolo.

## Route Principali

### Autenticazione (`/`)
Login, registrazione, reset password — gestite da Laravel Breeze.

### Dashboard (`/dashboard`)
Componente dinamico in base al ruolo:
- DEV → lista utenti + modifica ruoli
- ADMIN → lista propri progetti + gestione editor
- USER → lista progetti assegnati

### Progetti (`/projects`)
CRUD completo per gli admin (solo sui propri progetti). Slug auto-generato dal titolo.

### Sezioni (`/project-sections`)
Creazione, modifica, eliminazione sezioni HTML. Tracciamento autore e ultimo editor.

### Profilo (`/profile`)
Ogni utente può aggiornare nome, email e password.

## API Pubblica

Base URL: `/api` — nessuna autenticazione richiesta.

| Endpoint | Descrizione |
|---|---|
| `GET /api/projects` | Lista paginata (max 5/pagina) con filtri: search, category, technology, author, sort_by, sort_order |
| `GET /api/projects/{slug}` | Dettaglio progetto con relazioni complete |
| `GET /api/categories` | Lista categorie |
| `GET /api/technologies` | Lista tecnologie con classe FontAwesome |

## Sicurezza HTML

Il contenuto HTML (sezioni e descrizioni progetti) passa attraverso tre livelli:
1. Middleware `SanitizeHtmlInput` — sanitizza prima del controller
2. Cast `HtmlCasts` — sanitizza prima della scrittura su DB
3. Service `HtmlSanitizer` — HTMLPurifier con whitelist di tag consentiti

## Seeding

```bash
php artisan migrate --seed
```

Crea automaticamente:
- Ruoli: `dev`, `admin`, `user`
- 13 tecnologie con classi FontAwesome
- 4 categorie: NDC, Front End, Back End, Full Stack
- Utente DEV predefinito (credenziali da cambiare al primo accesso)
- Progetto di esempio con 10 sezioni documentate

## Struttura Chiave

```
app/
├── Casts/HtmlCasts.php
├── Http/
│   ├── Controllers/api/          ← ProjectController, CategoryController, TechnologyController
│   ├── Middleware/RoleCheck.php
│   ├── Middleware/SanitizeHtmlInput.php
│   └── Requests/                 ← Validazione form
├── Models/                       ← User, Project, Role, Category, Technology, ProjectSection
└── Services/HtmlSanitizer.php

database/
├── migrations/
├── factories/
└── seeders/

config/tech-list.php              ← Definizione 13 tecnologie

routes/
├── api.php    ← API pubbliche
├── web.php    ← Route autenticate
└── auth.php   ← Route Breeze
```
