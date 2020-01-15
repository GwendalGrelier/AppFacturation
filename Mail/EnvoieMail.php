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
$id= 2;
$request = $connexion->prepare("SELECT adresse_electronique , nom_societe  FROM client WHERE id=:id");
$request->bindParam(':id', $id);
$result = $request->execute();
$client = $request->fetchAll(PDO::FETCH_ASSOC);

$request2 = $connexion->prepare("SELECT id=2 FROM devis");
$result2 = $request2->execute();
$devis = $request2->fetchAll(PDO::FETCH_ASSOC);

$request3 = $connexion->prepare("SELECT * FROM article");
$result3 = $request3->execute();
$article = $request3->fetchAll(PDO::FETCH_ASSOC);


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
    $mail->From = $_POST['adresse_electronique'];
    $mail->FromName = $_POST['nom_societe'];
    $mail->Subject = 'Devis';
    $mail->Body = "Votre devis n° ".$_POST['id'] ."est en cours de validation. <br>
               Article commandé: <br>
               ".$_POST['qty']." " . $_POST['nom']."  pour le prix de ".$_POST['prix_u']." l'unité.
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


