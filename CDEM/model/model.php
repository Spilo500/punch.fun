<?php
session_start();

abstract class Model
{
    // Object PDO access to the DB
    private $bdd;

    // Executes a SQL query that may be parameterized
    protected function executeQuery($sql, $params = null)
    {
        if ($params == null) {
            $resultat = $this->getBdd()->query($sql);    // direct execution
        } else {
            $resultat = $this->getBdd()->prepare($sql);  // prepared query
            $resultat->execute($params);
        }

        return $resultat;
    }

    // Returns a connection object to the DB by initializing the connection
    private function getBdd()
    {
        if ($this->bdd == null) {
            try {
                $this->bdd = new PDO('mysql:host=localhost;dbname=cdem_database;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {
                die('Erreur :' . $e->getMessage());
            }
        }
        return $this->bdd;
    }
}
