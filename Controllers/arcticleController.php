<?php

include "Models/ArticleModel.php";
include "Views/ArticleView.php";

class articleController extends Controller
{
    public function __construct()
    {
        $this->model = new articleModel();
        $this->view = new articleView();
    }

    
}