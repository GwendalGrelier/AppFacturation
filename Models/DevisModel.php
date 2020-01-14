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
            WHERE id = :id");

            $request->bindParam(':id', $id);
            
            $result = $request->execute();
            $devisList = $request->fetchAll(PDO::FETCH_ASSOC);

           $devisList = [];
           $devisIdList = array_unique(array_column($devisList, "id"));
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
            var_dump($devisIdList);
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