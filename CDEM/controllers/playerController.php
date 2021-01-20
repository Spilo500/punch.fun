<?php

require_once('model/player.php');
require_once('views/view.php');

class PlayerController
{
  public function __construct()
  {
  }

  public function connect()
  {
    $view = new View("connect");
    $view->generate(null);
  }

  public function disconnect()
  {
    $player = new Player();
    $player->disconnectPlayer();
    header('Location: /CDEM');
    exit;
  }

  public function forgottenPassword()
  {
    $view = new View("forgottenPwd");
    $view->generate(null);
  }
}
