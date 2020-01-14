<?php

include "Models/ClientModel.php";
include "Views/ClientView.php";

class ClientController extends Controller
{
    public function __construct()
    {
        $this->model = new ClientModel();
        $this->view = new ClientView();
    }

    /**
     * Affiche la page d'accueil avec la liste des clients
     *
     * @return void
     */
    public function displayMainPage() {
        $clientsList = $this->model->getClientsList();
        $this->view->displayMainPage($clientsList);
    }

    /**
     * Affichage du formulaire pour l'ajout d'un client
     *
     * @return void
     */
    public function addFormClient() {
        $this->view->displayAddFormClient();
    }

    /**
     * Ajout d'un nouveau client à la BDD
     *
     * @return void
     */
    public function addClientToDB() {
        $this->model->addClientToDB();
        header('location: index.php?controller=client');
    }

    /**
     * Affichage du formulaire pour la suppression d'un client
     *
     * @return void
     */
    public function deleteClientFromDB() {
        $this->model->deleteClientFromDB();
        header('location: index.php?controller=client');
    }

    /**
     * Affichage du formulaire pour la mise à jour d'un client
     *
     * @return void
     */
    public function updateFormClient() {
        $client = $this->model->getClient();
        $this->view->displayUpdateFormClient($client);
    }

    /**
     * Mise à jour d'un client dans la BDD
     *
     * @return void
     */
    public function updateClientToDB() {
        $this->model->updateClientToDB();
        header('location: index.php?controller=client');
    }

    /**
         * Affichage du détail du client sélectionné
         *
         * @return void
         */
        public function detailClient() {
            $client = $this->model->getClient();
            $this->view->displayDetailClient($client);
        }
}
