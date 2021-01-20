<?php

require_once('model/player.php');
require_once('views/view.php');

class HomeController
{
  public function __construct()
  {
  }

  public function index()
  {
    $view = new View("home");
    $username = '';

    if (isset($_COOKIE['username'])) {
      $username = $_COOKIE['username'];
    }

    $view->generate(array('username' => $username));
  }
}
