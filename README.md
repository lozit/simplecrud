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

Quelques commandes psql : 
`\l` : liste toutes les bases de données
`\c app` : se connecte à la BDD app
`\dt` : liste toutes les tables
`\d admin` : voir la structure de la table admin

## Mettre en place GIT

Creez un compte si ce n'est pas déja fait sur github.com

Installez [Github CLI](https://github.com/cli/cli#installation)

Authentifiez-vous avec [gh auth login](https://cli.github.com/manual/gh_auth_login)

`git add .` pour ajouter toutes les modifications au projet

`git commit -m 'Initialisation du projet'` pour le premier commit

`gh repo create` pour créer un repo sur Github et push le projet sur Github

```bash
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

```bash
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

## Sécuriser l'interface d'administration

`symfony console make:user Admin` pour créer une entité user

Puis suivre : <https://symfony.com/doc/current/security.html>

Créer un contrôleur :
`symfony console make:controller Login`

Ajouter un user :

Créer un hash de votre mot de passe : `symfony console security:hash-password`

executer la requete SQL suivante dans psql ou avec un logiciel comme DBeaver :

```SQL
INSERT INTO admin (id, username, roles, password) VALUES (nextval('admin_id_seq'), 'admin', '["ROLE_ADMIN"]','$argon2id$v=19$m=65536,t=4,p=1$BQG+jovPcunctc30xG5PxQ$TiGbx451NKdo+g9vLtfkMy4KjASKSOcnNxjij4gTX1s');
```

Vous venez de créer un administrateur avec les identifiants admin/admin si vous avez copiez coller le code. Sinon vous pouvez remplacer le password par le hash créé plus haut.
