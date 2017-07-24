# Formation PHP avancée en 10 heures
## Sommaire et déroulement de la formation
|  N° |                                   Description                                  | Durée |
|:---:|:------------------------------------------------------------------------------:|:-----:|
|  1  | [Session N°1 : Initialisation du projet](#session-n1--mise-en-place-du-projet) |  1h15 |
| 1-1 | [Git et Github](#git-et-github)                                                |   -   |
| 1-2 | [Composer](#composer)                                                          |   -   |
| 1-3 | [Hello world et VitualHost](#hello-world--et-virutalhost)                      |   -   |
|  2  | [Session N°2 : Analyse et intégration](#session-n2--analyse-et-integration)    |  2h00 |
| 2-1 | [Kernel](#kernel)                                                              |   -   |
| 2-2 | [Controleur frontal](#controleur-frontal)                                      |   -   |
| 2-3 | [Notre premier controleur](#notre-premier-controleur)                          |   -   |
|  3  | Gestion des produits                                                           |  0h45 |
|  4  | Prise de commandes                                                             |  2h00 |
|  5  | Aller plus loin...                                                             |  2h00 |
|  6  | Mise en ligne                                                                  |  0h45 |
## Contexte
Création d'un site e-commerce, avec gestion des produits et commandes.
## Pré-requis
* Linux
* Php
* MySQL
* Git/Github
* Bootstrap
## Session N°1 : Initialisation du projet
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
### Composer
#### Initialisation
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
#### Installation des dépendances
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
#### Autoload
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

### Hello world ! et VirutalHost

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
## Session N°2 : Analyse et intégration
### Kernel
La classe `Kernel` est le centre névralgique du framekwork, sont boulot est de faire correspondre une requête HTTP à une action d'un controleur, et de renvoyer une réponse.

Nous utiliserons les composants phares de Symfony : 
* `Routing`
* `HttpFoundation`
* `HttpKernel`

L'association de ces trois composant permet de gérer notre problématique très simplement en une vingtaine de ligne.

Nous allons détailler ligne par ligne le fonctionnement du `Kernel` :

```php
$request = Request::createFromGlobals();
```
Cette méthode statique renvoie un objet hydraté `Request`, basé sur les [variables superglobales PHP](http://php.net/manual/fr/language.variables.superglobals.php). Cette objet `Request` nous servira pour plus tard, lorsque l'on voudra faire correspondre une route à une action d'un controleur.

```php
$requestStack = new RequestStack();
```
L'objet `RequestStack` est un service, à l'inverse `Request` est simplement un objet de valeur, c'est simplement une façade de notre variables superglobales, il est d'ailleurs assez proche du patron de concaption `Facade`. Par conséquent, nous utiliserons `RequestStack` pour être en accord avec l'injection de dépendance (encore un autre patron de conception).

```php
$routes = new RouteCollection();
$routes->add("test", new Route("/test", [
  "_controller" => "Controller\DefaultController::testAction"
]));
$routes->add("index", new Route("/{loop}", [
  "_controller" => "Controller\DefaultController::indexAction"
]));
```
Les lignes précédentes permettent simplement de gérer notre liste de route, ou chacune d'entre-elle se compose d'un chemin et du couple controleur/action.


```php
$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);
```
L'objet `RequestContext` contient les informations courantes de notre `Request`, en gros c'est un échantillon de notre `Request`, qui permet de cibler plus facilement des données importantes. Mais le plus simple reste de lire la [documentation](http://api.symfony.com/3.3/Symfony/Component/Routing/RequestContext.html).
`UrlMatcher` quant à lui est assez transparent, c'est un outil qui nous permettra de faire la correspondance entre une URL et une route.

Pour le moment nous avons vu un petit échantillon des composants `Routing` et `HttpFoundation`, mais le plus compliqué est à suivre avec `HttpKernel`.
```php
$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();
```
Qu'est ce qu'un `Resolver` ? Comme son nom l'indique, il permet de résoudre une problématique, et dans notre cas, il nous servira pour déterminer le bon controleur à executer et les bons arguments à passer à notre action.

```php
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));
```
Cela devient de plus en plus débuleux. Dans une premier temps, nous allons déjà parler de la notion d'événement. Il y a 3 notions importantes :
* Un `Event` est un événement par définition, c'est un objet qui permet simplement de donner des informations sur lui même et de contenir un certain nombre de données.
* Un `Listener` est un écouteur, c'est un service qui aura pour rôle d'observer un événement et d'effectuer une (ou plusieurs) tâche lorsque l'évenement est déclenché.
* Un `Dispatcher` est très simple, c'est l'outil pour déclencher un événement (je vous ai fait la version simplifié, pour plus d'infos la [documentation](https://symfony.com/doc/current/components/event_dispatcher.html) est faire pour ça).

Donc dans notre cas ci-dessus, nous allons déclencher l'écoute d'un événement, et notre écouteur `RouteListener` va donc prendre la relève et son rôle est d'initialiser le contexte de notre requête.

```php
$kernel = new HttpKernel($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
$response = $kernel->handle($request);
$response->send();
```
Voici la partie la plus intéressante, mais aussi la plus simple. Tout d'abord on instance un nouvel objet `HttpKernel`, puis on fait un simple `handle` avec pour argument notre fameuse `Request`, et cette méthode nous retourne un objet `Response`. En fait, cette méthode va effectuer tout le travail de correspondance entre notre requête et l'action du contrôleur que nous souhaitons appeler.

Vous avez maintenant quelque chose de fonctionnel, il faut maintenant intégrer `Twig` et `Doctrine`, et pour cela nous allons créer un controleur frontal.

### Contrôleur frontal
Pour rappel, notre framework est basé principalement sur le patron de conception MVC (Modèle Vue Controleur), et pour faciliter le traitement de nos modèles et nos vues, nous allons implémenter des méthodes dans notre contrôleur frontal.

*Voici un cours OpenClassrooms sur [Doctrine](https://openclassrooms.com/courses/apprendre-a-utiliser-doctrine/presentation-et-installation-2) pour mieux comprendre son utilité, et sur [Twig](https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/le-moteur-de-templates-twig-1).*

```php
public function __construct()
{
    $loader = new \Twig_Loader_Filesystem([__DIR__.'/../src/View']);
    $this->twig = new \Twig_Environment($loader, array(
        'cache' => false,
    ));

    $dbParams = array(
        'driver'   => 'pdo_mysql',
        'user'     => "root",
        'password' => "*****",
        'dbname'   => "formation-php",
    );
    $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/../src/Entity"], false);
    $this->doctrine = EntityManager::create($dbParams, $config);
}
```
Comme vous pouvez le voir, l'intégration de `Twig` et de `Doctrine` tient en une dizaine de ligne. Nous allons détailler chaque bout de code :
* `new \Twig_Loader_Filesystem([__DIR__.'/../src/View']);` : On instance un objet en lui précisant le ou les dossiers dans lesquels nous allons y mettre nos vues `Twig`.
* `new \Twig_Environment($loader, array('cache' => false));` : C'est ici que nous initialisons `Twig`, en lui passant en paramètre 2 choses, notre `loader` précédemment créé, et nos options. Dans notre cas, on lui précise simplement que nous ne souhaitons pas utiliser la mise en cache des vues.
* `$dbParams = array(...);` : Je pense que le nom de la variable parle pour elle même, c'est simplement un tableau contenant les informations de connexion à notre base de données.
* `$config = Setup::createAnnotationMetadataConfiguration([__DIR__."/../src/Entity"], false);` : On arrive sur quelque chose d'un peu plus compliqué, c'est ici que l'on crée la configuration de `Doctrine`. Pour être plus précis, nous lui expliquons que nous souhaitons déjà utiliser les annotations pour mapper notre base de données dans notre entité. Tout en lui expliquant le ou les dossiers contenant nos entités.
* `$this->doctrine = EntityManager::create($dbParams, $config);` : La méthode `create` nous renverra une instance de la classe `EntityManager`, qui nous permettra de manipuler notre base de données avec `Doctrine`.

Il ne nous reste plus qu'à créer notre première méthode qui nous simplifiera la vie :

```php
protected function render($filename, $data)
{
    $template = $this->twig->load($filename);
    return new Response($template->render($data));
}
```
Cette méthode sera appelé dans nos contrôleurs pour renvoyer une vue à l'utilisateur. Mai spour être précis, elle renvoie une `Response`. La méthode `load` va charger notre vue `Twig`, et la méthode `render` permet de renvoyer le contenu de cette vue, avec comme argument `$data`. Cette variable est un tableau contenant les données que nous souhaitons passer à notre vue.

### Notre premier contrôleur
Dans un premier temps, on crée notre classe :
```php
// src/Controleur/DefaultController.php

namespace Controller;

use Framework\Controller;

class DefaultController extends Controller
{}
```
Très important, ne pas oublier d'étendre notre contrôleur frontal, sinon nous n'aurons pas accès à Doctrine ou notre méthode pour renvoyer une vue.

On implémente ensuite notre première action :
```php
public function indexAction()
{
    $prenom = "Thomas";
    return $this->render("index.html.twig", ["prenom" => $prenom]);
}
```
Ici pour l'exemple, nous avons créé une variable `$prenom` que nous passerons à notre vue. Et la ligne intéressante est la méthode `render` qui permettra de renvoyer une réponse à l'utilisateur.
#### Twig
Voyons maintenant comment est construit notre vue `Twig` :
```twig
{% extends 'layout.html.twig' %}

{% block title %}{{ parent() }} - Page d'accueil{% endblock %}

{% block content %}
    Bonjour {{ prenom }} !
{% endblock %}
```
Nous allons d'abord nous attarder sur la ligne suivante `{{ prenom }}` : celle-ci permet d'afficher la variable `prenom` précédemment passer par notre contrôleur.

Passons maintenant à ce qui fait de `Twig` l'un des meilleurs moteur de template : `{% extends 'layout.html.twig' %}`. Cette fonction permet d'étendre le fichier `layout.html.twig`. Ce fichier est un template, et nous l'étendrons pour éviter d'avoir à saisir de nouvau toutes les structures du document HTML.

Voici un exemple du fichier `layout.html.twig` : 
```twig
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{% block title %}Formation PHP{% endblock %}</title>
    </head>
    <body>
        {% block content %}{% endblock %}
    </body>
</html>
```
Quand on utilise la fonction `extends`, dans une vue, on ne peut saisir du code que dans des `block`, et ces derniers doivent évidemment être au préalable présent dans la vue que l'on étend. 
Ici nous avons les blocs `content` et `title`. Regardons de plus prêt l'utilisation du bloc `title` dans notre vue :

```twig
{% block title %}{{ parent() }} - Page d'accueil{% endblock %}
```
On lui explique que nous souhaitons afficher le contenu du bloc parent grace à l'instruction `{{ parent() }}` et lui ajouter du texte en plus. Par conséquent, on se retoruvera au final avec comme `title` : **Formation PHP - Page d'accueil**.
#### Doctrine
Je ne vais pas revenir sur l'utilisation poussée de Doctrine, le cours sur OpenClassrooms se suffit à lui-même. L'intérêt de Doctrine, est de créer des classe métier, appelé `Entité`, que nous manipulerons pour modifier notre base de données.

Voici un petit exemple d'une entité :
```php
namespace Entity;

/**
 * Class User
 * @package Entity
 *
 * @Entity
 * @Table(name="user")
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="username", type="string")
     */
    private $username;

    /**
     * @var string
     *
     * @Column(name="password", type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @Column(name="email", type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="firstname", type="string")
     */
    private $firstname;

    /**
     * @var string
     *
     * @Column(name="lastname", type="string")
     */
    private $lastname;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }
}
```
Ce qui nous intéresse, ce sont les annotations qui permettent de cartographier notre base de données. On peut donc définir notre table et les champs qui la compose.

Maintenant, un exemple d'un ajout d'un `user` en base de données avec Doctrine :

```php
$user = new User();
$user->setUsername("mon-username");
$user->setPassword("mon-password");
$user->setEmail("thomas@email.com");
$user->setFirstname("Thomas");
$user->setLastname("Boileau");
$this->getDoctrine()->persist($user);
$this->getDoctrine()->flush();
```
Ce sont les deux dernières lignes qui nous intéressent :
* `$this->getDoctrine()->persist($user);` : La méthode `persist` permet de dire à Doctrine que nous souhaitons ajouter notre objet `$user` dans notre base de données. Mais la requête ne sera pas executée tant que nous ne le dirons pas explicitement.
* `$this->getDoctrine()->persist($user);` : c'est justement le rôle de `flush` de valider notre transaction et donc de modifier notre base de données en conséquence.

Au final, nous pourrons très effectuer plusieurs actions, comme des ajouts, des suppressions et des modifications, mais tant que nous n'appelons pas la méthode `flush`, la base de données ne sera pas impactée.
Doctrine se base avant sur le notion de transaction, une transaction à un début et une fin, et si aucune erreur n'est survenue entre temps, nous validons la transaction. 

## Session N°3 : Gestion des produits
## Session N°4 : Prise de commandes
## Session N°5 : Aller plus loin...
## Session N°6 : Mise en ligne