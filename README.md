# Evaluation d'entrainement en cours de formation: développer la partie back-end d'une application web

## Utilisation en local

Pour installer le projet sur votre machine, vous devez le cloner depuis le dépôt Github en utilisant la commande
<br/>
  `git clone https://github.com/Brunod32/eva_back_trtconseil.git`  
<br/>
  Rendez vous deans le dossier ou vous avez cloner le projet en tapant `cd eva_back_trtconseil`.
  Ensuite, tapez la commande `composer install` pour installer toutes les dépendances nécessaires au bon focntionnement du projet.
<br/>
  Un fichier .env est présent à la racine du projet. Pour des raisons de sécurité, créez parallèlement un fichier .env.local en y copiant le contenu du fichier .env modifié avec les informations propres au projet.
<br/>
  Créez la base de données avec `php bin/console doctrine:database:create`
<br/>
  Faites la migration avec `php bin/console make:migration`
<br/>
  Lancez le serveur Symfony `symfony serve`


## Online usage

The project have been deploy on heroku at  


## Création d'un administrateur

Rendez-vous à l'adresse https://127.0.0.1:8000/register/admin et remplissez le formulaire.