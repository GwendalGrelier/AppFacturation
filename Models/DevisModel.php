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
       
        public function envoie() {

            $request = $connexion->prepare("SELECT adresse_mail,nom_societe  FROM client WHERE id=:id");
            $request->bindParam(':id', $id);
            $result = $request->execute();
            $envoiMail = $request->fetchAll(PDO::FETCH_ASSOC);
        
            $request2 = $connexion->prepare("SELECT id FROM devis");
            $request2->bindParam(':id', $id);
            $result2 = $request2->execute();
            $envoiMail2 = $request2->fetchAll(PDO::FETCH_ASSOC);
        
            $request3 = $connexion->prepare("SELECT * FROM article");
            $request3->bindParam(':id', $id);
            $result3 = $request3->execute();
            $envoiMail3 = $request3->fetchAll(PDO::FETCH_ASSOC);

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;
            require 'PHPMailer-master/src/PHPMailer.php';
            require 'PHPMailer-master/src/Exception.php';

        }
       
    }