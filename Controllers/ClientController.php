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

    public function displayMainPage() {
        $this->model->displayMainPage();
    }

    public function addFormClient() {
        $this->model->addFormClient();
    }

    public function addClientToDB() {
        $client = $this->model->addClientToDB();
    }

    public function deleteClientFromDB() {
        $this->model->deleteClientFromDB();
    }

    public function updateFormClient() {

    }

    public function updateClientToDB() {
        
    }
}
