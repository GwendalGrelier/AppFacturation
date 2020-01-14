<?php
    
    class ArticleModel extends Model {

   
        public function deleteArticle() {

            $id = $_GET['id'];

            $requete = $this->connexion->prepare("DELETE FROM article WHERE id=:id");
            $requete->bindParam(':id',$id);
            $result = $requete->execute();
            var_dump($result);
        }

        public function addArticle() {
            
        }
        
    }
