This project is in french, because I used it at school. 

I'm not the only one author of this code. I only wrote the PHP.

# Projet: MVC
Le projet reprend la structure du Framework Symfony (recodée à la main)
**PHP 8 obligatoire** *-> Pour la structure match*
## Controllers

### Créer un controller :
Il y a à disposition le **make_controller.sh** qui crée un controller vierge.

### Ajouter une page :
Dans un controller, on ajoute dans le constructeur le chemin vers la page et la méthode qui correspond  :
```php
$this->routes["/page2/"] = "methodePage2";
```

La méthode **methodePage2** doit renvoyer obligatoirement un objet de type **Reponse**
````php
    public function methodePage2(): Response {
        return new Response("contenu brut");
    }
````

### Système d'auto-injection de dépendences
Toutes les méthodes des controllers peuvent recevoir en paramètres :
* La requête de type **Request**
* N'importe quel service (dossier **services**).

Il suffit d'ajouter un paramètre (penser au type du paramètre), et le framework vous donnera seul les éléments.
```php
    public function autreMethode(Request $request): Response {
        // Traitement request
        return new Response("...");
    }
```

Exemple avec un service :
```php
    public function register(Request $request, SessionManager $session): Response {
        if($session->isLogged())
            $this->redirect("//"); // Redirection vers la page index
        $response = new Response();
        $response->render("register.html", array("t" => var_export($request->getURIParam("id"), true)));
        return $response;
    }
```

## Vues
Un mini système de template a été mis en place. Les vues sont mises dans le dossier "vues".
Il est possible de faire le rendu de ce template depuis un controller grâce à la méthode **render** sur une requête.
Comme vu dans l'exemple ci-dessus. On fait le rendu de la vue **register.html** et on lui passe en paramètre un 
t qui contient le retour de var_export (pour des tests...)
### Afficher une variable
Pour affiche le t passer en paramètre, on utilise dans l'html :
````html
<p>{{ t }}</p>
````

### Inclure des fichiers
Il est également possible d'include des vues dans d'autres grâces au bloc : 
````html
{% include(components/header.html) %}
````
Qui ajoutera le header.html à l'endroit où cette ligne ce trouve.

### includes
Il existe également le bloc : 
```js
<script src="{% assets(js/jquery.js) %}"></script>
```

Qui permet où qu'on soit de faire le lien vers le bon fichier.

### Route
Pour préciser une url (dans une requête AJAX par exemple),
il est possible d'utiliser la méthode route:
```js
    $("button").click(function() {
        $.ajax( {
            type: "POST",
            url: "{% route(deleteTest) %}", // <---
            data: {"id": this.id.split("_")[1]},
            success: (response) => {
                console.log(response)
            },
            error: (response) => {
                console.log(response)
            },
        });
    });
```
Cela permet de préciser la route depuis le début. Cela devient indépendant d'où on se trouve: on part de la racine.


## Modèles
### Récupérer des données
Pour charger les modèles en mémoire, il faut commencer par charger le dépôt concerné, exemple pour lister les comptes :
```php
$accounts = $this->getRepository(AccountRepository::class)->findAll();
```
La variable `$accounts` contient une liste d'`Account` qui seront ceux chercher en mémoire.
Les méthodes de recherche mises à disposition sont :
* findAll() -> Renvoie tout
* findById() -> Cherche une entité par son identifiant
* findOneBy() -> Renvoie l'entité qui valide les conditions
* findBy -> Renvoie tous les modèles qui valident les conditions
Exemple :
```php
$account = $this->getRepository(AccountRepository::class)->findOneBy(
    array("login" => "admin", "email" => "admin@localhost")
);
```
`$account` contiendra l'utilisateur qui a pour login **admin** et pour email **admin@localhost**

### Ajouter dans la base de données
On peut ajouter des données en créant un objet, par exemple **Account** et en utilisant la méthode :
```php
$this->getDBManager()->add($entity);
```

### Modifier
On peut modifier une entité déjà existante en utilisant la méthode :
```php
$this->getDBManager()->update($entity);
```

### Supprimer
Pour supprimer une entité dans la base de donnée, on utilise la méthode :

```php
$this->getDBManager()->remove($entity);
```

### Envoyer les modifications
Une fois toutes les modifications enregistrées, on peut les envoyer dans la base avec la méthode :
```php
$this->getDBManager()->flush();
```

## Service
Le framework met également à disposition des Services. 

Ils permettent de regrouper des méthodes utilisées par plusieurs controllers (gérer les sessions par exemple).
On peut les récupérer grâce à l'auto-injection de dépendances.

## Authors
 * Tout le PHP vient de moi (Nicolas Coudert).
 * Le CSS, la majorité du JS et l'html ne vient pas de moi.
