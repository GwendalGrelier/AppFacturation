<?php
    

    /**
     * undocumented class
     */
    class ArticleView extends View {

        public function displayHome($articlelist) {
            $this->page .= "<h1>Welcome Here Article </h1>";
            // if (isset($_SESSION['user'])) {
                $this->page .= "<p><a href='index.php?controller=article&action=addArticle' class='btn btn-primary'>Ajouter</a></p>";
            // }
            $this->page .= "<table class='table'>";
            $this->page .= "<tr>";
            $this->page .= "<th>Nom de l'article</td>";
            $this->page .= "<th>Quantité </td>";
            $this->page .= "<th>prix unité</td>";
            $this->page .= "<th>Action </td>";
            $this->page .= "<th></td>";
            $this->page .= "<th></td>";
            $this->page .= "<th></td>";
            $this->page .= "</tr>";
            foreach ($articlelist as $list) {
                $lienUpdate = "";
                $lienDelete = "";
                // if (isset($_SESSION['user'])) {
                    $lienUpdate = "<a href='index.php?controller=article&action=updateForm&id="
                        . $list['id']
                        . "' class='btn btn-primary' title='Mise à jour'><i class='fas fa-pen'></i></a>";
                    $lienDelete = "<a href='index.php?controller=article&action=deleteArticle&id="
                        . $list['id']
                        . "' class='btn btn-danger' title='supprimer'><i class='fas fa-trash'></i></a>";
                // }
                
                $this->page .= "<tr>"
                    . "<td><strong>" . $list['nom'] . "</strong>"
                    . "<br>" . $list['id'] . "</td>"
                    . "<td>" . $list['qty'] . "</td>"
                    . "<td>" . $list['prix_u'] . "</td>"
                    . "<td>" . $lienUpdate
                    . "</td>"
                    . "<td>" . $lienDelete
                    . "</td>"
                    . "</tr>";
            }
            $this->page .= "</table>";
            $this->displayPage();
        }

        public function addArticle() {
            $this->page .= "<h1>J'ajoute un Article dans le stock via le formulaire</h1>";
            $this->page .= file_get_contents('pages/forms/formAddArticle.html');
            $this->page = str_replace('{action}','addBDD',$this->page);
            $this->page = str_replace('{name}','',$this->page);
            $this->page = str_replace('{qty}','',$this->page);
            $this->page = str_replace('{prix_u}','',$this->page);
            $this->displayPage();
        }
    }
    
