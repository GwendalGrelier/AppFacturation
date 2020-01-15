<?php
/*
define('SERVER' ,"localhost");
define('USER' ,"root");
define('PASSWORD' ,"");
define('BASE' ,"appfactures");
*/
define('SERVER' ,"sqlprive-pc2372-001.privatesql.ha.ovh.net");
define('USER' ,"cefiidev961");
define('PASSWORD' ,"9iGaAi88");
define('BASE' ,"cefiidev961");

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
$client = $request->fetch(PDO::FETCH_ASSOC);
//var_dump($client);

$request2 = $connexion->prepare("SELECT id FROM devis");
$result2 = $request2->execute();
$devis = $request2->fetch(PDO::FETCH_ASSOC);
//var_dump($devis);

$request3 = $connexion->prepare("SELECT * FROM article");
$result3 = $request3->execute();
$article = $request3->fetch(PDO::FETCH_ASSOC);
//var_dump($article);

$adresse_electronique = $client['adresse_electronique'];
$nom_societe = $client['nom_societe'];
$id = $devis['id'];
$qty = $article['qty'];
$nom = $article['nom'];    
$prix_u = $article['prix_u']; 


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
    $mail->From = $adresse_electronique;
    $mail->FromName = $nom_societe;
    $mail->Subject = 'Devis';
    $mail->Body = "Votre devis n° ".$id ."est en cours de validation. <br>
               Article commandé: <br>
               ".$qty." " . $nom."  pour le prix de ".$prix_u." l'unité. <br>
               Pour valider votre devis: <br>
               <a href='http://localhost/Test/projet_groupe/AppFacturation/index.php?controller=devis&action=validationDevis&id=$id'> Cliquez ici !</a>
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

