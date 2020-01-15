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

    /**
     * liste d'information
     *
     * @return void
     */
    public function displayMainPage(){
        $articlelist = $this->model->getArticleList();
        $this->view->displayHome($articlelist);
    }
   /**
    * Delete BDD article

    @return void
    */


    public function deleteArticle(){

        $this->model->deleteArticle();
        header('location:index.php?controller=article');
    }
     /**
      * affichage article
      *
      * @return void
      */
    public function addArticle(){

        $this->view->addArticle();
    }

    /**
      * add bdd
      *
      * @return void
      */

    public function addBDD(){

        $this->model->addBDD();
        header('location:index.php?controller=article');
    }

     /**
      * update affichage article
      *
      * @return void
      */

    public function displayUpdateArticle(){

        $article = $this->model->getArticle();
        $this->view->displayUpdateArticle($article);
    }

 /**
      * update  article
      *
      * @return void
      */
    public function updateBDD(){

        $this->model->updateBDD();
        header('location:index.php?controller=article');
    }
}