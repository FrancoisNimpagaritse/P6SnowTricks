Projet 6 - Développez de A à Z le site communautaire SnowTricks
===============================================================
Dans mon parcours de Développeur d'application PHP/Symfony chez OpenClassrooms j'ai créé une application avec lle framework Symfony. 

Informations sur l'environnement et outils utilisés durant le développement
--------------------------------------------------------------------------- 
* Symfony 5.1
* PHP 7.2.8
* PHPUnit 8.5
* MySQL 5.7.19 

Installation
-------------- 

1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
    git clone https://github.com/sorha/P6-SnowTricks.git
2. Configurez vos variables d'environnement tel que la connexion à la base de données ou votre serveur SMTP ou adresse mail dans le fichier .env.local qui devra être crée à la racine du projet en réalisant une copie du fichier .env.

3. Téléchargez et installez les dépendances de l'application avec Composer :

    composer install

4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
    php bin/console doctrine:database:create
    
5. Créez les différentes tables de la base de données en appliquant les migrations :
    php bin/console doctrine:migrations:migrate

6. L'application est installé, vous pouvez commencer à travailler dessus !

Bon travail
-------------