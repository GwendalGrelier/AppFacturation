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
           $request = "SELECT d.*, l.id_article, 
                        a.nom as nom_article, a.qty, a.prix_u, 
                        c.nom_societe as nom_client, c.id as id_client, c.adresse_postale, c.adresse_electronique, 
                        c.n_tva, c.siret, c.notes 
                        FROM `devis` as d 
                        JOIN liste_article as l ON d.id = l.id 
                        JOIN client as c ON d.`id_client` = c.id 
                        JOIN article as a ON a.id = l.id_article ";

           $request = $this->connexion->query($request);
           $result = $request->fetchAll(PDO::FETCH_ASSOC);
           
           $devisList = [];
           $devisIdList = array_unique(array_column($result, "id"));
           foreach ($devisIdList as $id) {
               foreach ($result as $line) {
                   if ($line["id"] == $id) {
                        $devisList[$id]['devis']['id'] = $id; 
                        $devisList[$id]['devis']['remise_com'] = $line['remise_com']; 
                        $devisList[$id]['devis']['taux_retard'] = $line['taux_retard']; 
                        $devisList[$id]['devis']['num_facture'] = $line['num_facture']; 
                        $devisList[$id]['devis']['date_echeance'] = $line['date_echeance']; 
                        $devisList[$id]['devis']['date_creation'] = $line['date_creation']; 
                        $devisList[$id]['devis']['date_validation'] = $line['date_validation']; 
                        $devisList[$id]['devis']['statut_valider'] = $line['statut_valider']; 

                        $devisList[$id]['client']['id_client'] = $line['id_client'];
                        $devisList[$id]['client']['nom_client'] = $line['nom_client'];
                        $devisList[$id]['client']['adresse_postale'] = $line['adresse_postale'];
                        $devisList[$id]['client']['adresse_electronique'] = $line['adresse_electronique'];
                        $devisList[$id]['client']['n_tva'] = $line['n_tva'];
                        $devisList[$id]['client']['siret'] = $line['siret'];
                        $devisList[$id]['client']['notes'] = $line['notes'];

                        $devisList[$id]['liste_articles'][$line['nom_article']] = [ "qty" => $line['qty'],
                                                                            "prix_u" => $line['prix_u']];
                    }                    
                }
            }
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

       /**
        * Récupération de la liste des clients à partir de la base de données
        *
        * @return void
        */
       public function getClientsList() {
        $request = "SELECT * FROM client";
        $request = $this->connexion->query($request);
        $clientsList = $request->fetchAll(PDO::FETCH_ASSOC);
        return $clientsList;

    }
   
}
