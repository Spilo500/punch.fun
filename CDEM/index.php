<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Past date

//On inclue d'abord les fichiers nécessaires et on initialise la logique de routes
include("includes/routing.php");
$fmk = new Routes();
include("includes/routes.php");

//Si la route est définie, on récupère la route en question
if (isset($_GET["url"])) {
    $route = htmlentities(trim($_GET["url"]));
} else {
    $route = "";
}

$fmkRoute = $fmk->getControlleur($route);

if ($fmk->isError404()) {
    require_once('errors/404.php');
    exit;
}

$controller = 'controllers/' . $fmkRoute[0];

include($controller);

$class = explode('.', $fmkRoute[0]);
$class = ucfirst($class[0]);

$actions = explode('/', $fmkRoute[1]);
$methodName = $actions[0];
array_shift($actions);

if ($class == 'HomeController') {
    $object = new HomeController();
} else if ($class == 'GameController') {
    $object = new GameController();
} else if ($class == 'PlayerController') {
    $object = new PlayerController();
} else if ($class == 'MiniGameController') {
    $object = new MiniGameController();
}

if (isset($actions) and !empty($actions)) {
    $methodVariable = array(array($object, $methodName), array($actions));
    call_user_func_array(array($object, $methodName), array($actions));
} else {
    $methodVariable = array($object, $methodName);
    if (is_callable($methodVariable, true, $callable_name)) {
        call_user_func(array($object, $methodName));
    } else {
        header('Location: /CDEM');
        exit;
    }
}
