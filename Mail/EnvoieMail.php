<?php
define('SERVER' ,"localhost");
define('USER' ,"root");
define('PASSWORD' ,"");
define('BASE' ,"appfactures");

try
{
    $connexion = new PDO("mysql:host=".SERVER.";dbname=".BASE, USER, PASSWORD);
    $connexion-> exec("SET NAMES 'UTF8'");
}

catch (Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}

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
    $mail->From = $client['adresse_electonique'];
    $mail->FromName = $client['nom_societe'];
    $mail->Subject = 'Devis';
    $mail->Body = "Votre devis n° ".$devis['id'] ."est en cours de validation. <br>
               Article commandé: <br>
               ".$article['qty']." " . $article['nom']."  pour le prix de ".$article['prix_u']." l'unité.
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
var_dump($mail);


