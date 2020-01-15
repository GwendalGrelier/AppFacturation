<?php

include "Models/SecurityModel.php";
include "Views/SecurityView.php";

class SecurityController extends Controller
{
    /**
     * Constructor for the Security controller
     */
    public function __construct()
    {
        $this->model = new SecurityModel();
        $this->view = new SecurityView();
    }


    /**
     * Display the login page for the admin
     *
     * @return void
     */
    public function displayMainPage()
    {
        $this->view->displayMainPage();
    }


    /**
     * Tries to login the admin
     *
     * @return void
     */
    public function login()
    {   
        $loggedIn = $this->model->login();

        if ($loggedIn) {
            header("Location: index.php?controller=devis");
        } else {
            header("Location: index.php?controller=security");
        }
    }

    public function logout()
    {
        $this->model->logout();
        header("Location: index.php");
    }


}
