# Simple projet en Symfony 6

Nous allons créer un CRUD simple pour une bibliothèque.

Pour le moment, nous allons gérer uniquement des livres.
Un livre est composé des éléments suivants : Un titre, un résumé, un nombre de pages, un genre (Narratif, Poétique, Théâtral, Épistolaire, Argumentatif)

Bien entendu, c'est très simplifié pour l'exercice.

## Démarrage du projet

Créer le projet
`symfony new simplecrud --version=6.0 --php=8.1 --webapp --docker --cloud`

Aller dans le dossier du projet
`cd simplecrud`

Démarrer le serveur web
`symfony server:start -d`

Consulter les log
`symfony server:log`

## Configuration de la base de données avec Docker

Configurer un nom de Base de données, de User et de Mot de passe dans `/docker-compose.yml`

Modifier `DATABASE_URL` dans le fichier `.env`
Vous pouvez aussi créer un fichier `.env.local` qui correspond à votre config locale (et qui sera ignorer dans Git).

Démarrer Docker Compose
`docker-compose up -d`

Voir l'état des conteneurs
`docker-compose ps`

Voir les logs des conteneurs
`docker-compose logs`

Accéder à la base de données locales PostgreSQL en executer `psql` dans le conteneur
`docker-compose exec database psql app app`

## Commandes de bases

Liste des commandes du make bundle :
`symfony console list make`

Créer un contrôleur :
`symfony console make:controller BibliothequeController`
Va créer :
`src/Controller/BibliothequeController.php`

Créer des classe d'entités
`symfony console make:entity Livre`
