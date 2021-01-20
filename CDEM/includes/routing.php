<?php

/**
 * Classe permettant le routing
 */
class Routes
{
    /**
     * un tableau contenant toutes les données de chaque route
     * @var array 
     */
    private $routes = array();

    /**
     * un tableau ayant le nom de la route comme clef, qui a comme valeur l'id de la route
     * @var array 
     */
    private $routesName = array();

    /**
     * un tableau ayant le chemin (URL)) de la route comme clef, qui a comme valeur l'id de la route
     * @var array 
     */
    private $routesPath = array();

    /**
     * un tableau ayant le contrôleur de la route comme clef, qui a comme valeur l'id de la route
     * @var array 
     */
    private $routesControlleur = array();

    /**
     * un tableau ayant l'id de la page de la route comme clef, qui a comme valeur l'id de la route
     * @var array 
     */
    private $routesAction = array();

    /**
     * compteur de routes
     * @var integer 
     */
    private $idRoutes = 0;

    /**
     * Nom de la route de la page d'accueil
     * @var string 
     */
    private $routeIndexName;

    /**
     * Chemin de la route de la page d'accueil
     * @var string 
     */
    private $routeIndexPath;

    /**
     * Contrôleur de la route de la page d'accueil
     * @var string
     */
    private $routeIndexControlleur;

    /**
     * Action de la page d'accueil
     * @var type 
     */
    private $routeIndexAction;

    /**
     * Booléen pour déclarer une URL comme erreur 404
     * @var boolean 
     */
    private $error404 = false;

    /**
     * 
     * @param string $routeName
     * @param string $urlPath
     * @param string $controller
     * @param string $action
     */
    public function initRoute($routeName, $urlPath, $controller, $action)
    {
        // On remplit les attributs de la class par des tableaux associatifs qui correspondent à l'id d'une route
        $this->routesName[$routeName] = $this->idRoutes;
        $this->routesPath[$urlPath] = $this->idRoutes;
        $this->routesControlleur[$controller] = $this->idRoutes;
        $this->routesAction[$action] = $this->idRoutes;

        // On remplit un tableau qui à comme clef l'id de la route et comme valeurs les données de la route
        $this->routes[$this->idRoutes] = array("name" => $routeName, "path" => $urlPath, "controlleur" => $controller, "action" => $action);

        // Le nombre de routes augmente, on met à jour notre id
        $this->idRoutes++;
    }

    /**
     * 
     * @param string $routeName
     * @return string
     */
    public function urlFor($routeName)
    {
        // Si la route existe, on retourne son URL
        if (array_key_exists($routeName, $this->routesName)) {
            return "/" . $this->routes[$this->routesName[$routeName]]["path"];
        } elseif ($routeName == $this->routeIndexName) { // Sinon, on test si la route correspond à la page d'accueil
            return "/" . $this->routeIndexPath;
        } else { // Sinon, on retourne une chaîne vide
            return "";
        }
    }

    /**
     * 
     * @param string $urlPath
     * @return array|bool
     */
    public function getControlleur($urlPath)
    {
        // Si l'URL existe, on retourne le contrôleur et l'action associés
        $existe = false;
        $keys = array_keys($this->routesPath);
        $url = '';

        foreach ($keys as $key) {
            if (strncmp($urlPath, $key, strlen($key)) === 0 and (strlen($urlPath) >= strlen($key))) {
                $existe = true;
                $url = $key;
            }
        }

        if ($existe) {
            $urlPath = explode('/', $urlPath);
            array_shift($urlPath);
            $urlPath = implode("/", $urlPath);
            return array($this->routes[$this->routesPath[$url]]["controlleur"], $this->routes[$this->routesPath[$url]]["action"] . $urlPath);
        } elseif ($urlPath == null || $urlPath == "" || $urlPath == $this->routeIndexName) { // Si l'URL correspond à la page d'accueil, on retourne son template
            return array($this->routeIndexControlleur, $this->routeIndexAction);
        } else { // Sinon on déclare une erreur 404
            return $this->error404 = true;
        }
    }

    /**
     * 
     * @param string $routeName
     * @param string $urlPath
     * @param string $template
     */
    public function initIndexRoute($routeName, $urlPath, $template)
    {
        $this->routeIndexName = $routeName;
        $this->routeIndexPath = $urlPath;
        $this->routeIndexControlleur = $template;
        $this->routeIndexAction = 'index';
    }

    /**
     * Retourne true s'il y a une erreur 404
     * @return boolean
     */
    public function isError404()
    {
        if ($this->error404 == true) {
            return true;
        }
        return false;
    }
}
