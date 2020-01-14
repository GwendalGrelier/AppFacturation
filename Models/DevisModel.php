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
           $request = $this->connexion->prepare("SELECT * FROM devis WHERE id=:id");
           $request->bindParam(':id', $devisID);
           
           $result = $request->execute();
           $devis = $request->fetch(PDO::FETCH_ASSOC);
           return $devis;
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
               
               var_dump('Devis: ' . $devis["id"]);
               foreach ($associationTable as $key => $link) {
                   foreach ($articleList as $article) {
                       if ($article["id"] == $link['id_article']) {
                           var_dump($article["nom"]);
                           $devis['articleList'] = $article; 
                       }
                   }
               }
           }
           var_dump($devisList);
       }
       
    }