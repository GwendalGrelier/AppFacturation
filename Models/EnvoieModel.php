<?php
    
    class ArticleModel extends Model {

   
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
