# Formation PHP
## Contexte
Création d'un site e-commerce, avec gestion des produits et commandes.
## Pré-requis
* Linux
* Php
* MySQL
* Git/Github
* Bootstrap
## Session N°1 : Mise en place du projet
<sub><sup>(environ 1h30)</sup></sub>
### Git et Github
* Création d'un nouveau repository sur [github](http://github.com)
* Création du répertoire du projet `mkdir e-boutik`, suivi d'un `cd e-boutik` pour se rendre dans le répertoire
* Intialisation de git `git init`
* On ajoute notre `remote` : `git remote add origin lien-du-repository-github`
* Création du fichier `.gitignore` pour ignorer les fichiers et dossiers qui ne doivent pas être indexés
```ignore
#Si vous utilisez PhpStorm, ne pas oublier d'ignorer le dossier configuration
.idea/
```
Nous venons d'initiliaser notre projet sous `git`, nous allons notre fichier `README.md`, ce fichier permet de documenter son projet.
* On crée le fichier `README.md`
* On ne saisi pour le moment que le nom de notre projet, mais à l'avenir il faudra régulièrement le tenir à jour, avec l'installation et la configuration du projet, ainsi que le `changelog`.
```markdown
# e-boutik
```
On peut maintenant effectuer notre premier commit :
```git
#On indexe les fichiers créés ou modifiés
git add .

#On commit nos fichiers indéxes avec un message
git commit -m "Premier commit"

#On pousse notre commit sur notre repository github
git push origin master
```
#### Méthodologie
Lorsque l'on travail avec git et github en équipe, on utilise généralement le notion d'`issues` et de `pull request`.

On découpe chaque étape du projet en `issue` puis lorsque l'on veut travailler sur une nouvelle feature, on crée une nouvelle branche. Généralement le nom de cette branche porte le nom de notre feature.
```git
git checkout -b nom-de-la-branche
```
La commande git `checkout` permet de basculer sur la branche souhaité, mais avec l'option `-b`, avant de basculer, git crée cette branche.

Après l'implémentation de notre feature, on peut donc pousser nos commits sur la branche nouvellement créée :

```git
git push origin nom-de-la-branche
```

Si vous pensez que cette branche est terminée, vous pouvez la soumettre à validation en créant une `pull request` sur `github`. Le chef de projet ou la personne en charge de la qualité, aura la charge de vérifier et de valider ou invalider votre `pull request`, ans le cas ou c'est validé, il va effectuer un `merge` sur la branche master, celui revient à pousser les modifications de votre features sur la branche principale.

Vous devez maintenant basculer sur la branche `master` et récupérer les modifications apportées par la `pull request` validée :

```git
git checkout master
git pull origin master
```
## Composer
### Initialisation
Maintenant que nous avons effectué notre premier commit, jouer un peu les notions d'issues et de pull request, on va maintenant s'attarder sur l'initialisation de composer. 

*Vous devez au préalable avoir installer [composer](https://getcomposer.org/download/).*
```
composer init
                                            
  Welcome to the Composer config generator  

This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [root/formation-php]: 
Description []: 
Author [TBoileau <t-boileau@email.com>, n to skip]: 
Minimum Stability []: 
Package Type []: 
License []: 

Define your dependencies.

Would you like to define your dependencies (require) interactively [yes]? no
Would you like to define your dev dependencies (require-dev) interactively [yes]? no

{
    "name": "root/formation-php",
    "authors": [
        {
            "name": "TBoileau",
            "email": "t-boileau@email.com"
        }
    ],
    "require": {}
}

Do you confirm generation [yes]? 
Would you like the vendor directory added to your .gitignore [yes]?
```
### Installation des dépendances
Voici la liste des librairies que nous allons utiliser pour notre projet *(je reviendrai sur l'utilisation de chacun d'elles plus tard)* :
```
composer require symfony/routing
composer require symfony/http-foundation
composer require symfony/http-kernel
composer require symfony/debug
composer require twig/twig
composer require doctrine/orm
```
La commande de composer `require` permet d'installer facilement les dépendances (librairies) et de les placer dans le dossier `vendor`.
### Autoload
Maintenant que nous avons installé les dépendances, on va maintenant créer la structure de notre projet, et cela passe par la création de l'arborescence mais aussi dela gestion de l'`autoload` facilité par `composer`.
```
mkdir app
mkdir src
mkdir web
```
* `app` : Ce dossier sera composé d'un ensemble de classes et de fichiers de configuration, c'est le coeur de notre framework. D'un projet à un autre, il nous suffira de les utiliser sans modification.
* `src` : Ce dossier sera composé d'un ensemble de classes et de fichiers pour concevoir notre architecture `MVC`, soit les controleurs, les modèles et les vues de notre projet, ainsi que tous les classes de services.
* `web` : Ce dossier sera composé des fichiers publiques, comme les fichiers `javascript`,`css`,`images`...ainsi que notre fichier `index.php` qui sera la porte d'entrée de notre application.
Il faut maintenant passer à l'`autoload`, et `composer` permet de simplifier grandement la tâche, il suffit simplement de modifier notre `composer.json` :
```json
{
    "name": "root/formation-php",
    "authors": [
        {
            "name": "TBoileau",
            "email": "t-boileau@email.com"
        }
    ],
    "require": {
        "symfony/routing": "^3.3",
        "symfony/http-foundation": "^3.3",
        "symfony/http-kernel": "^3.3",
        "symfony/debug": "^3.3",
        "twig/twig": "^2.4",
        "doctrine/orm": "^2.5"
    },
    "autoload": {
        "psr-4": {
            "": "src/",
            "Framework\\": "app/"
        }
    }
}
```
Vous l'avez sans doute remarqué, mais nous venons d'ajouter une nouvelle entrée à notre objet `json` : `autoload` et dedans `psr-4`. A l'intérieur de cette objet `psr-4`, nous avons préciser à `composer` que lorsque qu'un `namespace` comporte le prefix `Framework` alors la classe se trouve forcément dans le dossier `app`, à l'inverse, si le `namespace` ne commence par rien, alors il pointe sur `src`. L'`autloader` de `composer` est suffisamment intelligent pour aller sur le bon dossier. Mais je vous invite à regarder le fichier généré par `composer`.
 
Mais pour cela, il faut d'abord le mettre à jour en tapant la commande suivante : `composer update`. Regardons de plus prêt le fichier généré :

```php
#vendor/composer/autload_psr4.php
$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Twig\\' => array($vendorDir . '/twig/twig/src'),
    'Symfony\\Polyfill\\Mbstring\\' => array($vendorDir . '/symfony/polyfill-mbstring'),
    'Symfony\\Component\\Routing\\' => array($vendorDir . '/symfony/routing'),
    'Symfony\\Component\\HttpKernel\\' => array($vendorDir . '/symfony/http-kernel'),
    'Symfony\\Component\\HttpFoundation\\' => array($vendorDir . '/symfony/http-foundation'),
    'Symfony\\Component\\EventDispatcher\\' => array($vendorDir . '/symfony/event-dispatcher'),
    'Symfony\\Component\\Debug\\' => array($vendorDir . '/symfony/debug'),
    'Symfony\\Component\\Console\\' => array($vendorDir . '/symfony/console'),
    'Psr\\Log\\' => array($vendorDir . '/psr/log/Psr/Log'),
    'Framework\\' => array($baseDir . '/app'),
    'Doctrine\\Instantiator\\' => array($vendorDir . '/doctrine/instantiator/src/Doctrine/Instantiator'),
    'Doctrine\\Common\\Inflector\\' => array($vendorDir . '/doctrine/inflector/lib/Doctrine/Common/Inflector'),
    'Doctrine\\Common\\Cache\\' => array($vendorDir . '/doctrine/cache/lib/Doctrine/Common/Cache'),
    'Doctrine\\Common\\Annotations\\' => array($vendorDir . '/doctrine/annotations/lib/Doctrine/Common/Annotations'),
    'Doctrine\\Common\\' => array($vendorDir . '/doctrine/common/lib/Doctrine/Common'),
    '' => array($baseDir . '/src'),
);
```
On va surtout se concentrer sur 2 choses :
* `'Framework\\' => array($baseDir . '/app'),`
* `'' => array($baseDir . '/src'),`
Ces lignes parlent pour elles même, on comprend de suite que selon le prefixe, ce dernier pointe sur un répertoire en particulier.

## Hello world ! et VirutalHost

Vous l'aurez compris, on va faire notre premier `Hello world !`. Pour cela on crée un fichier PHP qui se trouvera dans le dossier `web` :
```php
echo "Hello world !";
```
C'est simple mais ce chapitre est surtout pour mettre en place notre `virtualhost` !

Dans un premier temps, on va d'abord se placer dans le dossier d'`apache`, puis nous allons créer la configuration de notre site, l'activer et dire à notre PC que lorsque l'on va sur l'url `e-boutik.dev` cela pointe en local :
```
cd /etc/apache2/sites-available
sudo nano e-boutik.conf
```

```
#/etc/apache2/sites-available/e-boutik.conf
<VirtualHost *:80>
    ServerName e-boutik.dev

    DocumentRoot /dossier/du/projet/web
    <Directory /dossier/du/projet/web>
	    Require all granted
        AllowOverride All
        Order Allow,Deny
        Allow from All
        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>
```
Pour la petite explication :
* `ServerName` : Cette option permet de préciser le nom de domaine d'application.
* `DocumentRoot` : Cette option permet de préciser le dossier du projet, en ajoutant le dossier `web` car l'entrée de notre application web par le fichier `index.php` qui se trouve dans le répertoire `web`.

Pour le reste, je vous invite à lire un peu la [documention d'apache](https://httpd.apache.org/docs/2.2/fr/vhosts/examples.html) sur la question.

Nous allons maintenant activer notre site, puis le mode `rewrite` *(nécessaire pour la réecriture d'url)*, et enfin gérer l'`hosts` de notre machine :
```
sudo a2ensite e-boutik
sudo a2enmod rewrite
sudo nano /etc/hosts
```
```
127.0.0.1       localhost
127.0.0.1       e-boutik.dev


# The following lines are desirable for IPv6 capable hosts
::1     ip6-localhost ip6-loopback
fe00::0 ip6-localnet
ff00::0 ip6-mcastprefix
ff02::1 ip6-allnodes
ff02::2 ip6-allrouters
```

On termine par relancer `apache` avec la commande suivante : `sudo service apache2 reload` et normalement en allant sur [l'url de votre application](http://e-boutik.dev) vous devirez voir notre `Hello world !`, sinon c'est que vous avez loupé une étape.

