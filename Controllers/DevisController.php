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

    public function addToDB()
    {
        $this->model->addToDB();
        // header('location:index.php?controller=devis');
    }
    
    public function validationDevis(){
            $id = $_GET['id'];
            $devisID = $this->model->getDevis($id);
            // $this->view->validationDevis($devisID);

    }
}
