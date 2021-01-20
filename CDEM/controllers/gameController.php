<?php

require_once('model/player.php');
require_once('views/view.php');

class GameController
{
  public function __construct()
  {
  }

  // generate createGame view
  public function create($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);
    $_SESSION['username'] = $username;
    $view = new View("createGame");
    $view->generate(null);
  }

  // generate joinGame view
  public function join($username)
  {
    $this->isUsername($username);
    $username = $username[0];
    setcookie('username', $username, time() + 365 * 24 * 3600, '/', null, false, true);
    $_SESSION['username'] = $username;

    $view = new View("joinGame");
    $view->generate(null);
  }

  // return true if the username exist
  private function isUsername($username)
  {
    if (!isset($username[0]) or empty($username[0])) {
      $this->deleteUsername();
    }
  }

  // delete usersname cookie
  public function deleteUsername()
  {
    if (isset($_COOKIE['username'])) {
      setcookie('username', '', time(), '/', null, false, true);
    }
    header('Location: /CDEM');
    exit;
  }

  // create a new waiting room
  // generate room view
  public function createRoom()
  {
    if (isset($_POST['boolParty']) and !empty($_POST['boolParty']) and isset($_POST['Players']) and !empty($_POST['Players']) and isset($_POST['Score']) and !empty($_POST['Score'])) {

      $_POST['boolParty'] = htmlspecialchars($_POST['boolParty']);
      $_POST['Players'] = htmlspecialchars($_POST['Players']);
      $_POST['Score'] = htmlspecialchars($_POST['Score']);

      $isPublic = 0;

      if (($_POST['boolParty'] == 'Privé')) {
        $isPublic = 0;
      } else if ($_POST['boolParty'] == 'Public') {
        $isPublic = 1;
      }

      require_once('model/game.php');
      require_once('model/player.php');
      $Game = new Game();
      $Player = new Player();

      $code = $this->generateRandomString();

      $params = array(
        'code' => $code,
        'scoreMax' => $_POST['Score'],
        'isPublic' => $isPublic,
        'nbMaxPlayers' => $_POST['Players']
      );
      $myGame = $Game->createGame($params);

      $Player->registerPlayer($myGame['code'], $_COOKIE['username'], 1);

      header('Location: room/' . $code);
    } else {
      $view = new View("createGame");
      $view->generate(null);
    }
  }

  // generate a game code
  public function generateRandomString($length = 6)
  {
    require_once('model/game.php');
    $Game = new Game();

    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    do {
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
    } while (!$Game->isAvailable($randomString));
    return $randomString;
  }

  // join an already existing game
  // generate room view
  public function joinRoom($ParamCode = null)
  {
    require_once('model/game.php');
    $Game = new Game();
    $Player = new Player();
    $code = null;

    if (isset($_POST['code'])) {
      $code = htmlspecialchars($_POST['code']);
    }

    if (isset($code) and !empty($code)) {

      $myGame = $Game->getGame($code);
      // Est-ce que la partie existe ?
      if (!$myGame) {
        $this->_viewOnError('Partie introuvable');
        // A-t-elle commencé ?
      } else if ($myGame['isInProgress'] == 1) {
        $this->_viewOnError('La partie a déjà commencé');
        // Arrivé ici, la partie existe
      } else {
        $players = $Game->getPlayers($code);
        // Est-elle pleine ?
        if (intval(count($players)) >= intval($myGame['nbMaxPlayers'])) {
          $this->_viewOnError('La partie est complète');
          // Si non, c'est OK on continue
        } else {
          $code = $myGame['code'];
          $Player->registerPlayer($code, $_COOKIE['username'], 0);
          header('Location: room/' . $code);
        }
      }
    } elseif ($ParamCode != null and isset($_COOKIE['username'])) {
      if ($Player->isRegister($ParamCode, $_COOKIE['username']) == null) {
        require_once('errors/404.php');
        exit;
      };
      $myGame = $Game->getGame($ParamCode);
      if (!$myGame) {
        $this->_viewOnError('Aucune partie n\'est disponible');
      }
      $view = new View("room");
      $view->generate($myGame);
    } elseif ($ParamCode == null) {
      $myGame = $Game->getRandomGame();
      if ($myGame) {
        $code = $myGame['code'];
        $Player->registerPlayer($code, $_COOKIE['username'], 0);
        header('Location: room/' . $code);
      } else {
        $this->_viewOnError('Aucune partie n\'est disponible');
      };
    } else {
      require_once('errors/404.php');
      exit;
    }
  }

  // Affichage des vues en erreur
  private function _viewOnError($errorMessage)
  {
    $_SESSION['joinError'] = $errorMessage;
    $view = new View("joinGame");
    $view->generate(null);
    exit();
  }

  public function getPlayers($code)
  {
    require_once('model/game.php');
    $Game = new Game();
    $players = $Game->getPlayers($code[0]);
    $json = json_encode($players);
    echo $json;
  }

  public function playGame()
  {
    require_once('model/game.php');
    $Game = new Game();

    if (isset($_POST['code'])) {
      $code = htmlspecialchars($_POST['code']);
    }

    if (isset($code) and !empty($code)) {
      $myGame = $Game->getGame($code);
    } else {
      require_once('errors/404.php');
      exit;
    }
    $Game->started($code);
    $view = new View("game");
    $view->generate($myGame);
  }

  public function isInProgress($code)
  {
    require_once('model/game.php');
    $Game = new Game();
    if (isset($code[0]) and !empty($code[0])) {
      echo $Game->isInProgress($code[0]);
    }
  }

  public function upMiniGame($params)
  {
    require_once('model/game.php');
    $Game = new Game();
    if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1])) {
      echo $Game->upMiniGame($params[0], $params[1]);
    }
  }

  public function getCurrentMG($code)
  {
    require_once('model/game.php');
    $Game = new Game();
    if (isset($code[0]) and !empty($code[0])) {
      $result = $Game->getCurrentMG($code[0]);
      $json = json_encode($result);
      echo $json;
    }
  }

  public function deletePlayer($params)
  {
    if (isset($params[0]) and !empty($params[0]) and isset($params[1]) and !empty($params[1])) {
      $Player = new Player();
      $Player->deletePlayer($params[0], $params[1]);
    }
  }

  public function deleteGame($params)
  {
    if (isset($params[0]) and !empty($params[0])) {
      require_once('model/game.php');
      $Game = new Game();
      $Game->deleteGame($params[0]);
    }
  }

  // Sélection d'un nouvel hôte
  public function newHost($params)
  {
    if (isset($params[0]) and !empty($params[0])) {
      require_once('model/game.php');
      $Game = new Game();
      $Game->newHost($params[0]);
    }
  }

  public function room($code)
  {
    if (isset($code[0]) and !empty($code[0])) {
      $this->joinRoom($code[0]);
    }
  }
}
