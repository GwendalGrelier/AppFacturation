<?php
/*
    Import des classes PHPMailer dans l’espace de nommage
*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
/*
    Instanciation de la variable
*/
$mail = new PHPMailer();
/*
    Tentative d’envoi de mail
*/
try {
// Ajout des attributs
$mail->From = "$client['adresse_mail']";
$mail->FromName = "$client['nom_societe']";
$mail->Subject = 'Devis';
$mail->Body = "Lorem ipsum dolor sit, amet consectetur adipisicing elit.
               Qui libero error odio dolorum quisquam minima! Suscipit qui labore obcaecati libero doloribus
               odio nulla facere eveniet consequuntur esse! Fugiat, reprehenderit velit.";

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
var_dump($mail);


