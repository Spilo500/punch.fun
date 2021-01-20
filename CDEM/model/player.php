<?php

require_once 'model/model.php';

class Player extends Model
{

    // Register a player in the database
    public function newPlayer($email, $pwd)
    {
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = 'SELECT email FROM player';
        $result = $this->executeQuery($sql);

        while ($emailPlayer = $result->fetch()) {
            if (strcmp($emailPlayer['email'], $email) == 0) {
                return false;
            }
        }

        $sql = 'INSERT INTO player(idPlayer, email, pwd) VALUES(:idPlayer, :email, :pwd)';
        $params = array(
            'idPlayer' => trim(com_create_guid(), '{}'),
            'email' => $email,
            'pwd' => $hash
        );

        $this->executeQuery($sql, $params);
        $this->connectPlayer($email, $pwd);
        return true;
    }

    // Connect a player
    public function connectPlayer($email, $pwd)
    {
        $sql = 'SELECT * FROM player';
        $players = $this->executeQuery($sql);
        while ($Player = $players->fetch()) {
            if (strcmp($Player['email'], $email) == 0) {
                if (password_verify($pwd, $Player['pwd'])) {
                    $_SESSION['isConnected'] = true;
                    $_SESSION['idPlayer'] = $Player['idPlayer'];
                    return true;
                }
                return false;
            }
        }
    }

    // Disconnect a player
    public function disconnectPlayer()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected'])) {
            unset($_SESSION['isConnected']);
        }
        if (isset($_SESSION['idPlayer']) and !empty($_SESSION['idPlayer'])) {
            unset($_SESSION['idPlayer']);
        }
    }

    // Check if a player is connected
    public function isConnected()
    {
        if (isset($_SESSION['isConnected']) and !empty($_SESSION['isConnected'])) {
            return $_SESSION['isConnected'];
        }
        return false;
    }

    /* Fonction qui enregistre un joueur dans une partie
    */
    public function registerPlayer($code, $username, $isHost)
    {
        if ($this->isConnected()) {
            $idPlayer =  $_SESSION['idPlayer'];
        } else {
            $idPlayer = trim(com_create_guid(), '{}');
            $_SESSION['idPlayer'] =  $idPlayer;
        }

        $sql = 'INSERT INTO play(code, idPlayer, username, isHost)
            VALUES(:code, :idPlayer, :username, :isHost)';

        $params = array(
            'code' => $code,
            'idPlayer' => $idPlayer,
            'username' => $username,
            'isHost' => intval($isHost)
        );
        $this->executeQuery($sql, $params);
        return $this->getPlayerFromPlay($idPlayer, $code);
    }

    /* Fonction qui vérifie si un joueur est déjà dans une partie
    */
    public function isRegister($code, $username)
    {
        $sql = 'SELECT * FROM play WHERE username=:username AND code=:code';
        $params = array(
            'username' => $username,
            'code' => $code
        );
        $result = $this->executeQuery($sql, $params)->fetch();

        return $result;
    }

    /* Fonction qui supprime un joueur d'une partie
    */
    public function deletePlayer($idPlayer, $code)
    {
        $sql = 'DELETE FROM play WHERE idPlayer =:idPlayer AND code =:code';

        $params = array(
            'idPlayer' => $idPlayer,
            'code' => $code
        );
        $this->executeQuery($sql, $params);
    }

    public function getPlayerFromPlay(string $guid, string $code)
    {
        $sql = 'SELECT * FROM play WHERE idPlayer=:idPlayer AND code=:code';
        $params = array(
            'idPlayer' => $guid,
            'code' => $code
        );
        $result = $this->executeQuery($sql, $params)->fetch();
        $result['account'] = $this->getPlayer($guid);
        return $result;
    }

    public function getPlayer($guid)
    {
        $sql = 'SELECT * FROM player WHERE idPlayer=:idPlayer';
        $params = array('idPlayer' => $guid);
        $result = $this->executeQuery($sql, $params)->fetch();
        return $result;
    }
}
