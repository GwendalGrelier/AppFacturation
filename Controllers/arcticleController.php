<?php

include "Models/articleModel.php";
include "Views/articleView.php";

class articleController extends Controller
{
    public function __construct()
    {
        $this->model = new articleModel();
        $this->view = new articleView();
    }

    
}