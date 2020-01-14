<?php


abstract class Model
{

    // const SERVER = 'sqlprive-pc2372-001.privatesql.ha.ovh.net:3306';
    // const USER = 'cefiidev957';
    // const PASSWORD = '4iC9Ze6t';
    // const BASE = 'cefiidev957';
    
    const SERVER = 'localhost';
    const USER = 'root';
    const PASSWORD = '';
    const BASE = 'appfactures';

    protected $connexion;

    public function __construct()
    {
        //connexion
        try {
            $this->connexion = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::BASE, self::USER, self::PASSWORD);
            $this->connexion->exec("SET NAMES 'UTF8'");
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
            echo $e->getCode();
        }
    }

    /**
     * Gets the list of every Quote
     *
     * @return array
     */
    public function getDevisList()
       {
           $request = "SELECT * FROM devis";
           $request = $this->connexion->query($request);
           $devisList = $request->fetchAll(PDO::FETCH_ASSOC);
           
           return $devisList;
       }
    /**
     * Gets the list of every Quote
     *
     * @return array
     */
    public function getArticleList()
       {
           $request = "SELECT * FROM article";
           $request = $this->connexion->query($request);
           $articlelist = $request->fetchAll(PDO::FETCH_ASSOC);
           var_dump($articlelist);
           return $articlelist;
       }

       /**
        * Récupération de la liste des clients à partir de la base de données
        *
        * @return void
        */
       public function getClientsList() {
        $request = "SELECT * FROM client";
        $request = $this->connexion->query($request);
        $clientsList = $request->fetchAll(PDO::FETCH_ASSOC);
        var_dump($clientsList);
        return $clientsList;

    }
   
}
