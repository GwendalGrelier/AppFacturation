<?php

include "Models/DevisModel.php";
include "Views/DevisView.php";

class DevisController extends Controller
{
    /**
     * Creates an instance of the Controler
     * 
     * @return void
     */
    public function __construct()
    {
        $this->model = new DevisModel();
        $this->view = new DevisView();
    }

    /**
     * Display the main devis list
     *
     * @return void
     */
    public function displayMainPage()
    {
        $articleList = $this->model->getArticleList();
        // $associationTable = $this->model->getAssociationTable(); 
        $devisList = $this->model->getDevisList();

        // $this->model->parseArticleListToDevis($devisList, $articleList, $associationTable);

        $this->view->displayMainPage($devisList);
    }

    public function displayAddNewForm()
    {
        $clientList = $this->model->getClientsList();
        $articleList = $this->model->getArticleList();

        $this->view->displayAddForm($clientList, $articleList);
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

    public function displayEditForm()
    {
        if (isset($_GET) && !empty($_GET["devis"])) {
            $devisId = $_GET['devis'];
            $devis = $this->model->getDevis($devisId);
            $articleList = $this->model->getArticleList();
            $this->view->displayEditForm($devis, $articleList);
        } else {
            header("Location: index.php?controller=devis");
        }

    }



    public function addToDB()
    {
        $this->model->addToDB();
        $this->model->createDevisPDF();
        // header('location:index.php?controller=devis');
    }
    
    public function validationDevis(){
            $id = $_GET['id'];
            $devis = $this->model->getDevis($id);
            $this->view->validationDevis($devis);

    }

    public function valid(){

        $this->model->updateStatus();
        header('location:index.php?controller=devis');
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

    
}
