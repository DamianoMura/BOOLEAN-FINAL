<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Backend - IT

Per il backend del mio progetto finale ho deciso di utilizzare Laravel 12 con tutti i suoi pacchetti standard incluso il database di default (SQLITE) in quanto non richiede connessioni e impostazioni aggiuntive nel file .env.

In sostanza la pagina principale dell'applicazione non risiede in questo progetto ma nell'applicazione react che fà da "guest access" per gli utenti non registrati, infatti se si prova ad accedere al route della index del progetto ("/") ci ridireziona alla pagina di login.

### Autenticazione e Ruoli

Il pacchetto utilizzato per l'autenticazione è Laravel Breeze, che una volta intallato aggiunge tutti i suoi Route e lo scaffolding principale inclusi i Middleware e le "viste" (views o pagine) relative (login, register e dashboard).

Questo progetto prevede 3 ruoli, dove:
(considerando che possiamo scegliere le risorse crud da utilizzare, ho deciso di creare un sistema di ruoli e permessi in modo da lavorare in profondità sulle relazioni tra modelli, in questo caso user e role, ma anche Role e Permission che per ora non implementiamo)

per l'assegnazione di ruoli useremo la relazione Eloquent Many to Many

### Gerarchia dei ruoli

-   3 = dev
-   2 = admin
-   1 = user
-   0 = nau (not authorised user)

#### DEV:amministratore del sito.

In quanto amministratore del sito, il DEV può decidere se promuovere (ad ADMIN) o degradare ( da ADMIN a USER) gli utenti che decide di approvare.<br>
Nonostante possa gestire gli utenti, non può in alcuna maniera gestire altre risorse nel sistema.<br>

##### - NotaBene :

Questo è un Ruolo assegnato all'utente di default che viene inserito automaticamente nel database al momento del seeding e una volta effettuato il primo accesso, verrà obbligatoriamente richiesto un cambio username,email e password per motivi di sicurezza in quanto questa è una repo pubblica e chiunque potrà accedere con tutti i permessi del caso.

#### ADMIN:amministratore dei progetti.

L'admin in sostanza decide cosa può venire pubblicato o no, quindi quando un utente crea un Progetto, viene inviata una notifica agli admin che dalla propria dashboard decidono se pubblicarlo o meno, nel caso l'admin non approvasse la pubblicazione, è possibile allegare un messaggio con la motivazione per il rifiuto dando modo all'utente di editare o eliminare il Progetto creato.
Per questo non si dà l'opportunità di eliminare i progetti di qualsiasi altro user in quanto l'user può modificare il suo progetto indefinitamente affinchè raggiunga un livello accettabile per gli Admin per approvarlo

#### USER: utente base

Gli user hanno permessi soltanto sui propri post,
quindi ne possono creare di nuovi, e modificare o eliminare solamente il proprio Progetto

#### NAU : Not Authorised User

ho deciso di restringere le possibilità a chi si registra al sito.<br>
finchè questi utenti non vengono approvati da un DEV user, l'unica cosa che potranno fare è modificare il proprio profilo e vedere l'applicazione react come i guest

<hr>

DEV - gestione user roles  
ADMIN - creazione(CRUD solo se owner), gestione , approvazione pubblicazioni
USER - creazione (CRUD solo se owner)
NAU - guest access

##### a tutti gli utenti viene data la possibilità di aggiornare username email e password

<hr>

## Backend - EN-UK

For our backend part of the Final Project, i decided to use Laravel 12 with his default packages included the default db settings (SQLITE) as it doesn't require connections and additional settings on the .wnv file

Practically the index page of my application doesn't reside in this project, but rather will be in the React application that functions as "guest access" fou unregistered users, in fact if you try to get to the index route, it will redirect you to th login page.

### Authentication and Roles

The package in use for the authentication is Laravel Breeze , once installed it will add all its Routes and the main scaffolding including Middlewares and the relative views (login, register e dashboard).

==============================================
linee guida per la documentazione e lo sviluppo

Documentazione Tecnica - Portfolio Backoffice Laravel

1. Sistema di Ruoli e Autorizzazioni
   1.1 Struttura Database
   php
   // Tabella pivot role_user (one-to-one effettivo)
   Schema::create('role_user', function (Blueprint $table) {
   $table->id();
   $table->foreignId('user_id')->constrained()->unique(); // Un solo ruolo per utente
   $table->foreignId('role_id')->constrained();
   $table->timestamps();
   });
   1.2 Middleware RoleCheck
   Il middleware RoleCheck determina dinamicamente quale componente Vue/React mostrare nella dashboard in base al ruolo:

php
// App\Http\Middleware\RoleCheck.php
class RoleCheck
{
public function handle($request, Closure $next)
{
$user = Auth::user();
$roleComponentMap = [
'dev' => 'user-list',
'admin' => 'admin-dashboard', // Contiene lista utenti e progetti
'user' => 'assigned-projects'
];

        $request->merge(['dashboardComponent' => $roleComponentMap[$user->role->name]]);
        return $next($request);
    }

} 2. Componenti Dashboard per Ruolo
2.1 Dev (user-list)
Gestione completa degli utenti

Assegnazione/modifica ruoli

Accesso amministrativo totale

2.2 Admin (admin-dashboard)
javascript
// Struttura componente Admin
{
sections: [
{
name: 'user-assignment',
data: {
availableUsers: [], // Lista di user/admin da assegnare
createdProjects: [] // Progetti creati dall'admin
}
},
{
name: 'project-list',
data: [] // Progetti creati dall'admin
}
]
}
2.3 User (assigned-projects)
Lista progetti assegnati

Possibilità di aggiungere/modificare sezioni

Solo visualizzazione dei progetti assegnati

3. Gestione Progetti
   3.1 Struttura Sezioni Progetto
   Raccomandazione: Creare tabella separata per le sezioni:

php
// Opzione consigliata - Tabella separata
Schema::create('project_sections', function (Blueprint $table) {
$table->id();
$table->foreignId('project_id')->constrained()->onDelete('cascade');
$table->string('title');
$table->text('content');
$table->integer('order')->default(0);
$table->foreignId('created_by')->constrained('users'); // User che ha creato la sezione
$table->timestamps();
});
Vantaggi:

Migliore normalizzazione del database

Tracciamento delle modifiche per sezione

Ordinamento flessibile delle sezioni

Query più efficienti per sezioni specifiche

Storage separato per storico/versioni

3.2 Pubblicazione Progetti
php
// Campo published nella tabella projects
$table->boolean('published')->default(false);

// Scope nel modello Project
public function scopePublished($query)
{
return $query->where('published', true);
}
3.3 Generazione Slug
php
// Nel modello Project
protected static function boot()
{
parent::boot();

    static::creating(function ($project) {
        $project->slug = Str::slug($project->title);
    });

    // Slug non modificabile dopo la creazione
    static::updating(function ($project) {
        if ($project->isDirty('title')) {
            throw new \Exception('Il titolo non può essere modificato dopo la creazione');
        }
    });

} 4. API e Frontend
4.1 Struttura API
php
// routes/api.php
Route::middleware(['auth:sanctum'])->group(function () {
// API per backoffice
Route::apiResource('projects', ProjectController::class);
Route::post('projects/{project}/assign', [ProjectController::class, 'assignUser']);
Route::apiResource('project-sections', ProjectSectionController::class);

    // API per frontend React (guest)
    Route::middleware(['role:guest'])->group(function () {
        Route::get('public-projects', [PublicProjectController::class, 'index']);
        Route::get('public-projects/{slug}', [PublicProjectController::class, 'show']);
    });

});
4.2 Comandi Artisan Personalizzati
php
// app/Console/Commands/CreateSuperUser.php
class CreateSuperUser extends Command
{
protected $signature = 'dev:create';

    public function handle()
    {
        // Creazione primo superuser (dev)
        $user = User::create([...]);
        $devRole = Role::where('name', 'dev')->first();
        $user->roles()->attach($devRole);

        $this->info('Superuser creato con successo!');
    }

} 5. Workflow e Flussi Utente
5.1 Flusso Creazione Progetto (Admin)
Admin accede a dashboard

Clicca "Nuovo Progetto"

Compila form con titolo, categoria, descrizione

Slug generato automaticamente

Progetto creato come bozza (published = false)

Admin può assegnare editor dal pannello progetti

5.2 Flusso Assegnazione Editor
javascript
// Componente Admin - Assegnazione Editor
methods: {
async assignEditor(projectId, userId) {
await axios.post(`/api/projects/${projectId}/assign`, {
user_id: userId
});
// Notifica utente assegnato (da implementare)
this.sendNotification(userId, 'Sei stato assegnato a un nuovo progetto');
}
}
5.3 Flusso Aggiunta Sezioni (User)
User accede a dashboard

Visualizza lista progetti assegnati

Seleziona progetto

Aggiunge nuova sezione con titolo e contenuto

Sezione salvata con created_by = user.id

6. Schema Database Completo
   sql
   -- Tabelle principali
   users
   id, name, email, email_verified_at, password, remember_token, created_at, updated_at

roles
id, name (dev, admin, user), created_at, updated_at

role_user
id, user_id (UNIQUE), role_id, created_at, updated_at

projects
id, title, slug (UNIQUE), category_id, author_id, description, published, created_at, updated_at

categories
id, name, slug, created_at, updated_at

technologies
id, name, created_at, updated_at

project_technology
project_id, technology_id

project_user (editori assegnati)
project_id, user_id, created_at

project_sections (raccomandata)
id, project_id, title, content, order, created_by, created_at, updated_at 7. Security e Best Practices
7.1 Controlli Accessi
php
// Policy per Project
class ProjectPolicy
{
public function update(User $user, Project $project)
{
// Admin può modificare solo i propri progetti
return $user->hasRole('admin') && $project->author_id === $user->id;
}

    public function addSection(User $user, Project $project)
    {
        // User può aggiungere sezioni solo se assegnato
        return $user->hasRole('user') && $project->hasUserAssigned($user->id);
    }

}
7.2 Validazioni
php
// Form request per Project
class StoreProjectRequest extends FormRequest
{
public function rules()
{
return [
'title' => 'required|string|max:255|unique:projects',
'category_id' => 'required|exists:categories,id',
'description' => 'required|string|min:100'
];
}
} 8. Roadmap e Funzionalità Future
Da Implementare:
Notifiche: Sistema di notifiche per assegnazioni progetti

Ricerca: Filtri avanzati per progetti

Versioning: Storico modifiche per le sezioni

Media Upload: Gestione immagini per progetti

Export: Esportazione progetti in PDF/JSON

da rettificare:
Implementare soft delete per progetti

Aggiungere campo excerpt per descrizione breve

Creare sistema di tag oltre alle categorie

Implementare cache per progetti pubblici

Aggiungere statistiche di visualizzazione

Prossimi passi: Sviluppare le interfacce specifiche per ogni componente dashboard e implementare il sistema di notifiche per completare il workflow di assegnazione progetti.
