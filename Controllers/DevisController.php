<?php

include "Models/DevisModel.php";
include "Views/DevisView.php";

class DevisController extends Controller
{
    public function __construct()
    {
        $this->model = new DevisModel();
        $this->view = new DevisView();
    }

    public function displayMainPage()
    {
        $this->view->displayMainPage();
    }
}
