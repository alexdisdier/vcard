===========================
| vcard Alexandre DISDIER |
===========================
** Ce readme est en français, le reste de l'application sera en anglais **

Objectif
--------

Construire une vcard (Carte de visite digitale) qui permettra à un employeur d'avoir accès à l'essentiel de mon profil professionnel.

Le lien "view portfolio" vous amenera sur d'autres projets que j'ai déjà realisés au cours de l'année 2017/2018 en sortant de l'école.

les fonctionnalités
-------------------

- Portail de connexion
- Modification du contenu
- Récupération du mot de passe oublié
- Construction d'un package d'installation du site (install-vcard.php + vcard_archive.zip) dans le dossier dist
- Si vous désirez accéder au backend, envoyez-moi un message à alex@onze.digital avec l'adresse email de votre choix. Je vous enverrai un mot de passe temporaire.
- Ensuite, pour accéder au backend, veuillez cliquer sur le smily emoji dans le footer du site. Bonne navigation.

Ce que j'ai appris grâce à ce projet
------------------------------------

- Consolider mes connaissances déjà acquises avec la 3W
  + html
  + css - SCSS
  + JavaScript
  + php - MVC
  + mySQL
- Utiliser sass selon le 7-1 pattern de Hugo Giraudel pour ma stylesheet
- Mettre en place une automatisation avec Gulp
- Constuire un package d'installation

--------------------------------------------
 |                                        |
 |  Organisation des dossiers et fichiers |
 |																				|
--------------------------------------------

Description du MVC utilisé (basé sur le framework 3W utilisé pour le projet restaurant)
-------------------------------------------

- Les "./classes" dont UserSession permet de gérer une session de l'utilisateur
- Le "./config" permet la configuration avec sa base de données
- Les "./controllers" gèrent les requêtes http
- Les "./forms" gèrent les forms comme son nom l'indique
- Les "./Models" gèrent l'accès à la base de données et ses tables. Elles utilisent plusieurs fonctions utiles que nous utilisons dans les controllers.
- ".www" contient toutes les views (l'affichage de l'application dans le navigateur), les styles et médias utilisés.

Description de la base de données
-------------------------------------------

- about          =>  id | content_short | content_long | residence | email |
(Contenu principal)  job_type | job_availability | portfolio_url

- cover          =>  id | cover_img
(l'image cover)

- password_reset =>  ID | email | selector | token | expires
(rénitialisation du mot de passe)

- profile        =>  id | profile_img
(l'image de profile)

- quotes         =>  id | quote_content
(les phrases qui  apparaissent en dessous du titre)

- site_description =>         id | first_name | last_name |
(l'identité de l'utilisateur) profile_img | background_img

- social_media    =>  id | social_name | social_url

- User            =>  Id | FirstName   | LastName | Email | Password

- meta            =>  id | site_title  | site_description | site_icon |
                      google_analytics

Structure du répertoire
-------------------------------------------

├── application
│   ├── classes
│   ├── config
│   ├── controllers
│   ├── forms
│   ├── models
│   ├── www
│   │   ├── about
│   │   ├── admin
│   │   ├── assets
│   │   │   ├── scss
│   │   │   │   │
│   │   │   ├── fonts
│   │   │   │   │
│   │   │   ├── images
│   │   │   │   └── raw
│   │   │   └──js
│   │   ├── node_modules
│   │   ├── quotes
│   │   ├── site
│   │   ├── social
│   │   ├── user
│   │   │   ├── login
│   │   ├── .htaccess
│   │   ├── footer.phtml
│   │   ├── header.phtml
│   │   ├── HomeView.phtml
│   │   ├── index.php
│   │   ├── style.css
│   │   ├── style.css.map
│   │   └── style.min.css
├── library
├── node_modules
├── dist
├── test
├── .htaccess
├── gulpfile.js
├── index.php
├── install-card.php
├── package-lock.json
├── package.json
├── README_3W.txt
├── README_GITHUB.md
├── vcard.sql
└── version2.txt

Ce que je prépare pour ma version 2 (version2.txt)
================================================================================

* Create a customizer so the user can choose:
  -color:
    -the primary and secondary color of the text
    -the button color
    -the background color
  -font:
    -the primary and secondary font of the text

* Combine content_long and content_short.
  -Rearrange table 'about', model, controller and views.
  -Make a read-more button which will automatically separate the content where the user decides.
    source:https://www.plus2net.com/javascript_tutorial/textarea-counter.php
    initial trial work:

    ***
    $content = $abouts[0]['content_short'];
    $stringLength = strlen($content);
    $excerpt = substr($content, 0, $stringLength/2);
    $readMore = substr($content, $stringLength/2, $stringLength);

    echo $excerpt;
    ***

* Build a drag image once inside the cover image div.

* build the different sizes for favicon - automatically reformat the photo for the user.
source: https://stackoverflow.com/questions/10130915/how-to-auto-resize-uploaded-image-using-php

* add an expiration date to reset password.

* Remove index.php from navigation for cleaner url
