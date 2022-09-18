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

## Mettre en place GIT

Creez un compte si ce n'est pas déja fait sur github.com

Installez [Github CLI](https://github.com/cli/cli#installation)

Authentifiez-vous avec [gh auth login](https://cli.github.com/manual/gh_auth_login)

`git add .` pour ajouter toutes les modifications au projet

`git commit -m 'Initialisation du projet'` pour le premier commit

`gh repo create` pour créer un repo sur Github et push le projet sur Github

```
$ gh repo create
? What would you like to do? Push an existing local repository to GitHub
? Path to local repository .
? Repository name simplecrud
? Description 
? Visibility Public
✓ Created repository lozit/simplecrud on GitHub
? Add a remote? Yes
? What should the new remote be called? origin
✓ Added remote git@github.com:lozit/simplecrud.git
? Would you like to push commits from the current branch to "origin"? Yes
✓ Pushed commits to git@github.com:lozit/simplecrud.git
```

## Commandes de bases

Liste des commandes du make bundle :
`symfony console list make`

Créer un contrôleur :
`symfony console make:controller BibliothequeController`
Va créer :
`src/Controller/BibliothequeController.php`

Créer des classe d'entités
`symfony console make:entity Livre`

```
titre : string / 255 / no
resume : text / yes
nbpages : integer / no
genre : string / 255 / no
```

Migrer la base de données
`symfony console make:migration`

Mettre à jour la base de données locale
`symfony console doctrine:migrations:migrate`

Générer un formulaire
`symfony console make:form LivreFormType Livre`
