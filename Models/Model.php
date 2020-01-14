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
           $request = "SELECT d.*, l.id_article FROM `devis` as d JOIN liste_article as l ON d.id = l.id ";
           $request = $this->connexion->query($request);
           $result = $request->fetchAll(PDO::FETCH_ASSOC);
           
           $devisList = [];
           $devisIdList = array_unique(array_column($result, "id"));

           foreach ($devisIdList as $id) {
               foreach ($result as $line) {
                   if ($line["id"] == $id) {
                        $devisList[$id]['remise_com'] = $line['remise_com']; 
                        $devisList[$id]['taux_retard'] = $line['taux_retard']; 
                        $devisList[$id]['num_facture'] = $line['num_facture']; 
                        $devisList[$id]['date_echeance'] = $line['date_echeance']; 
                        $devisList[$id]['date_creation'] = $line['date_creation']; 
                        $devisList[$id]['date_validation'] = $line['date_validation']; 
                        $devisList[$id]['statut_valider'] = $line['statut_valider']; 
                        $devisList[$id]['id_client'] = $line['id_client'];

                        $devisList[$id]['liste_articles'][] = $line['id_article'];
                        
                    }                    
                     
               }
               
           }
        //    var_dump($devisList);
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

           return $articlelist;
       }

       public function getAssociationTable()
       {
           $request = "SELECT * FROM liste_article";
           $request = $this->connexion->query($request);
           $assoc_table = $request->fetchAll(PDO::FETCH_ASSOC);

           return $assoc_table;
       }
        //    var_dump($articlelist);
      
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
