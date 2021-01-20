<?php

require_once 'model/model.php';

class MiniGame extends Model
{
    /*
    Fonction qui renvoie l'id et le nom mini-jeu choisi au hasard*/
    public function getMinigame()
    {
        $sql = 'SELECT COUNT(*) FROM minigame';
        $max = intval($this->executeQuery($sql)->fetch()[0]);
        $number = rand(1, $max);

        $sql = 'SELECT * FROM minigame';
        $results = $this->executeQuery($sql);
        for($i = 0; $i < $number; $i++) {
            $result = $results->fetch();
        }
        
        return $result;
    }

    // Fonction qui attribue un minigame à tous les joueurs présents dans une partie
    public function playMinigame($code, $idMinigame, $num)
    {
        require_once 'model/game.php';
        $Game = new Game();
        $players = $Game->getPlayers($code);
        for ($i = 0; $i < count($players); $i++) {
            $sql = 'INSERT INTO play_minigame(idPlay, idMinigame, score, startDate, endDate, num)
                VALUES (:idPlay, :idMinigame, :score, :startDate, :endDate, :num)';
            $params = array(
                'idPlay' => $players[$i]['idPlay'],
                'idMinigame' => $idMinigame,
                'score' => 0,
                'startDate' => null,
                'endDate' => null,
                'num' => $num
            );
            $this->executeQuery($sql, $params);
        }
    }

    /*
    Fonction qui met à jour le startDate du joueur dès qu'il commence son mini-jeu*/
    public function playerStartMG($idPlay, $num)
    {
        $sql = 'UPDATE play_minigame SET startDate =:startDate WHERE idPlay =:idPlay AND num =:num';
        $params = array(
            'startDate' => date("Y-m-d H:i:s"),
            'idPlay' => $idPlay,
            'num' => $num
        );
        $this->executeQuery($sql, $params);
    }

    /*
    Fonction qui met à jour le endDate du joueur dès qu'il a finit son mini-jeu*/
    public function playerEndMG($idPlay, $num)
    {
        $sql = 'UPDATE play_minigame SET endDate =:endDate WHERE idPlay =:idPlay AND num =:num';
        $params = array(
            'endDate' => date("Y-m-d H:i:s"),
            'idPlay' => $idPlay,
            'num' => $num
        );
        $this->executeQuery($sql, $params);
    }

    /**
     * Fonction qui, une fois le mini jeux fini par tous les joueurs ou le temps écoulé,
     * nous donne le classement en fonction de la difference entre le temps du début et le temps de la fin.
     */
    public function getRankMiniGame($code, $num)
    {
        // 1 recuperer les joueurs, classés en fonction de leur temps
        $sql = 'SELECT username, idPlayMinigame, TIMESTAMPDIFF(SECOND,startDate,endDate) 
            FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num
            Order BY TIMESTAMPDIFF(SECOND,startDate,endDate)';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $results = $this->executeQuery($sql, $params);

        // 2 attribuer les points
        $sqlCount = 'SELECT count(*) as nb FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $resultCount = $this->executeQuery($sqlCount, $params)->fetch();

        for ($i = 0; $i < $resultCount['nb']; $i++) {
            $player = $results->fetch();

            switch ($i) {
                case 0:
                    $score = 5;
                    break;
                case 1:
                    $score = 3;
                    break;
                case 2:
                    $score = 1;
                    break;
                default:
                    $score = 0;
                    break;
            }
            $sql = 'UPDATE play_minigame SET score = :score WHERE idPlayMinigame =:idPlayMinigame';
            $params = array(
                'idPlayMinigame' => $player['idPlayMinigame'],
                'score' => $score
            );
            $this->executeQuery($sql, $params);
        }


        // 3 retourner les joueurs et leur score à ce mini-jeu dans l'ordre du classement
        $sql = 'SELECT username, score
            FROM play_minigame, play WHERE play_minigame.idPlay = play.idPlay AND play.code = :code AND num =:num
            Order BY score DESC';
        $params = array(
            'code' => $code,
            'num' => $num
        );
        $results = $this->executeQuery($sql, $params)->fetchAll();
        return $results;
    }
}
