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

    /**
     * Displays the add Quote form
     *
     * @return void
     */
    public function displayAddNewForm()
    {
        $clientList = $this->model->getClientsList();
        $articleList = $this->model->getArticleList();

        $this->view->displayAddForm($clientList, $articleList);
    }
    
    
    /**
     * Displays the form to edit a quote
     *
     * @return void
     */
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

    /**
     * Deletes an item from the DB
     *
     * @return void
     */
    public function deleteFromDB()
    {
        $devisId = $_GET['id'];
        $this->model->deleteDevis($devisId);
        header("Location: index.php?controller=devis");
    }

    /**
     * Adds a Quote to the database
     * 
     * The Quote is created, added to the database and calls
     * model->createDevisHTML() which returns the HTML code for the quote
     * 
     * This text is then send by email to the client.
     *
     * @return void
     */
    public function addToDB()
    {
        $idDevis = $this->model->addToDB();
        $textDevis = $this->model->createDevisHTML($idDevis);
        header('location:index.php?controller=devis');
    }
    public function validationDevis(){
            $id = $_GET['id'];
            $devis = $this->model->getDevis($id);
            $this->view->validationDevis($devis);
    }

        public function valid(){

        $this->model->updateStatus();
        $this->model->updateDevis();
        
        header('location:index.php?controller=devis');
    }
}
