<?php

include "Models/ArticleModel.php";
include "Views/ArticleView.php";

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->model = new ArticleModel();
        $this->view = new ArticleView();
    }


    public function displayMainPage(){
        $this->view->displayHome();
    }
    
    public function displayListarticle(){
        $this->model->getArticleList();
        $this->view->displayHome();
    }
}