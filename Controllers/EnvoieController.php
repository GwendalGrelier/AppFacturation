<?php

    include "Models/EnvoieModel.php";

    class MailController extends Controller
    {
        public function __construct()
        {
            $this->model = new ClientModel();
            $this->view = new ClientView();
        }


        public function envoie(){
            
            $mail = new PHPMailer();
            /*
                Tentative d’envoi de mail
            */
            try {
                // Ajout des attributs
                $mail->From = $client['adresse_electonique'];
                $mail->FromName = $client['nom_societe'];
                $mail->Subject = 'Devis';
                $mail->Body = "Votre devis n° ".$devis['id'] ."est en cours de validation. <br>
                           Article commandé: <br>
                           ".$article['qty']." " . $article['nom']."  pour le prix de ".$article['prix_u']." l'unité. <br>
                           Pour voire valider votre devis: <br>
                           <a href='http://localhost/Test/projet_groupe/AppFacturation/index.php?controller=devis&action=validationDevis&id=3'>Cliquez ici!</a>
                           ";
            
            }
            
            /*
                Traitement de l’exception levée en cas d’erreur
            */
            catch (Exception $e) {
                echo 'Message non envoyé';
                echo 'Erreur: ' . $mail->ErrorInfo;
            }
            // Envoi du mail
            $envoiOK= $mail->Send();
            
            /*
                message de confirmation d'envoie du mail
            */
            
            if($envoiOK){
                echo"Votre mail est bien partit";
            }
            else{
                echo "Erreur, Votre mail n'est pas partit";
            }
            echo"<pre>";
            //var_dump($mail);
            
        }


    }