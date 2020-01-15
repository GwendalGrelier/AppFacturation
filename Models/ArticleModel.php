<?php
    
    class ArticleModel extends Model {

        

            /*
            Delete in table Article
             
            @return void

            */
        public function deleteArticle() {

            $id = $_GET['id'];

            $requete = $this->connexion->prepare("DELETE FROM article WHERE id=:id");
            $requete->bindParam(':id',$id);
            $result = $requete->execute();
            var_dump($result);
        }

        /*
            add in table Article
             
            @return void

            */

        public function addBDD() {

            $name = $_POST['name'];
            $qty = $_POST['qty'];
            $prix_u = $_POST['prix_u'];

            $requete = $this->connexion->prepare("INSERT INTO article VALUES (NULL, :name, :qty, :prix_u )");
            $requete->bindParam(':name',$name);
            $requete->bindParam(':qty',$qty);
            $requete->bindParam(':prix_u',$prix_u);
            $result = $requete->execute();
            
        }
        /*
            extraction de la  table Article
             
            @return array $result

            */
        public function getArticle(){
            $id = $_GET['id'];

            $requete = $this->connexion->prepare("SELECT * FROM article WHERE id=:id");
            $requete->bindParam(':id',$id);
            $result = $requete->execute();
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
/*
            update in table article 
             
            @return void

            */
        public function updateBDD(){
            $name = $_POST['name'];
            $id = $_POST['id'];
            $qty = $_POST['qty'];
            $prix_u = $_POST['prix_u'];

            $requete = $this->connexion->prepare("UPDATE article SET nom = :name, qty = :qty, prix_u = :prix_u WHERE id = :id");
            $requete->bindParam(':name',$name);
            $requete->bindParam(':qty',$qty);
            $requete->bindParam(':id',$id);
            $requete->bindParam(':prix_u',$prix_u);
            $result = $requete->execute();
           
        }
    }
