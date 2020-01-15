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

    /*
     Construction de la page d'accueil
     liste d'information de la BDD
     
     @return void
    

    */
    public function displayMainPage(){
        $articlelist = $this->model->getArticleList();
        $this->view->displayHome($articlelist);
    }
    
   

     /*
     delete in BDD
     
     @return void
    

    */


    public function deleteArticle(){

        $this->model->deleteArticle();
        header('location:index.php?controller=article');
    }
     /*
     Construction de la page d'ajout des article
     liste d'information de la BDD
     
     @return void
    

    */
    public function addArticle(){

        $this->view->addArticle();
    }

     /*
     Add in BDD
     
     @return void
    

    */

    public function addBDD(){

        $this->model->addBDD();
        header('location:index.php?controller=article');
    }

     /*
     Construction de la page de modification
     liste d'information de la BDD
     
     @return void
    

    */

    public function displayUpdateArticle(){

        $article = $this->model->getArticle();
        $this->view->displayUpdateArticle($article);
    }


     /*
     modif in BDD
     
     
     @return void
    

    */
    public function updateBDD(){

        $this->model->updateBDD();
    }
}