<?php
    
    class DevisModel extends Model {

        /**
         * Get one Devis from the DB
         * 
         * @param int $devisID
         * @return array $devis
         */
       public function getDevis($devisID)
       {
            $request = $this->connexion->prepare("SELECT d.*, l.id_article, 
            a.nom as nom_article, a.qty, a.prix_u, 
            c.nom_societe as nom_client, c.id as id_client, c.adresse_postale, c.adresse_electronique, 
            c.n_tva, c.siret, c.notes 
            FROM `devis` as d 
            JOIN liste_article as l ON d.id = l.id 
            JOIN client as c ON d.`id_client` = c.id 
            JOIN article as a ON a.id = l.id_article 
            WHERE d.id = :id");

            $request->bindParam(':id', $devisID);
            
            $result = $request->execute();
            $result = $request->fetchAll(PDO::FETCH_ASSOC);
            $devisList = [];

            foreach ($result as $line) {
                    $devisList['devis']['id'] = $line['id']; 
                    $devisList['devis']['remise_com'] = $line['remise_com']; 
                    $devisList['devis']['taux_retard'] = $line['taux_retard']; 
                    $devisList['devis']['num_facture'] = $line['num_facture']; 
                    $devisList['devis']['date_echeance'] = $line['date_echeance']; 
                    $devisList['devis']['date_creation'] = $line['date_creation']; 
                    $devisList['devis']['date_validation'] = $line['date_validation']; 
                    $devisList['devis']['statut_valider'] = $line['statut_valider']; 

                    $devisList['client']['id_client'] = $line['id_client'];
                    $devisList['client']['nom_client'] = $line['nom_client'];
                    $devisList['client']['adresse_postale'] = $line['adresse_postale'];
                    $devisList['client']['adresse_electronique'] = $line['adresse_electronique'];
                    $devisList['client']['n_tva'] = $line['n_tva'];
                    $devisList['client']['siret'] = $line['siret'];
                    $devisList['client']['notes'] = $line['notes'];

                    $devisList['liste_articles'][$line['nom_article']] = [ "qty" => $line['qty'],
                                                                        "prix_u" => $line['prix_u']];
                                    
            }
           
            return $devisList;
        }




       

     
        /**
        * Deletes devis form the database
        *
        * @param int $devisID
        * @return void
        */
        public function deleteDevis($devisID)
       {
           $request = $this->connexion->prepare("DELETE FROM devis WHERE id=:id");
           $request->bindParam(':id', $devisID);
           
           $result = $request->execute();
       }

       /**
        * Adds a the list of articles to each devis
        *
        * @param array $devisList
        * @param array $articleList
        * @param array $associationTable
        * @return void
        */
       public function parseArticleListToDevis($devisList, $articleList, $associationTable)
       {
           foreach ($devisList as $devis) {
               $devis['articleList'] = array();
               
               foreach ($associationTable as $key => $link) {
                   foreach ($articleList as $article) {
                       if ($article["id"] == $link['id_article']) {
                           var_dump($article["nom"]);
                           $devis['articleList'] = $article; 
                       }
                   }
               }
           }
       }
       
    }