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
