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
        $articlelist = $this->model->getArticleList();
        $this->view->displayHome($articlelist);
    }
    
   
    public function deleteArticle(){

        $this->model->deleteArticle();
        header('location:index.php?controller=article');
    }

    public function addArticle(){

        $this->view->addArticle();
    }

    public function addBDD(){

        $this->model->addBDD();
        header('location:index.php?controller=article');
    }

    public function displayUpdateArticle(){

        $article = $this->model->getArticle();
        $this->view->displayUpdateArticle($article);
    }

    public function updateBDD(){

        $this->model->updateBDD();
    }
}