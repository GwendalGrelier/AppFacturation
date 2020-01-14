<?php
    

    /**
     * undocumented class
     */
    class DevisView extends View {

        /**
         * Displays the main page list
         *
         * @param array $devisList
         * @return void
         */
        public function displayMainPage($devisList) {
            $this->page .= "<h1>Welcome Here</h1>";
           

            $this->page .= '<a href="index.php?controller=devis&action=displayAddNewForm" class="btn btn-primary">Créer un nouveau devis</a>'; 
            $this->page .= '<table class="table"><thead><tr>'; 
            $this->page .= '<th scope="col">Ref</th><th scope="col">Client</th><th scope="col">Nb d\'article</th><th scope="col">Prix Tot.</th><th scope="col">Dates</th><th scope="col">Status</th><th scope="col">Créer facture</th></tr></thead>'; 
            $this->page .= "<tbody>";
            
            foreach ($devisList as $devis) {
                $this->page .= '<tr>';
                
                // Id
                $this->page .= '<th>';
                $this->page .= $devis['devis']['id'];
                $this->page .= '</th>';
                
                // Nom Client
                $this->page .= '<td><a href=index.php?controller=client&action=displayClient&client='.$devis['client']['id_client'].'>';
                $this->page .= $devis['client']['nom_client'];
                $this->page .= '</a></td>';

                // Nbr items
                $nbr_articles = count($devis['liste_articles']);
                $this->page .= '<td>';
                $this->page .= $nbr_articles;
                $this->page .= '</td>';
                
                // Prix Total
                $prix_total = 0;
                foreach ($devis['liste_articles'] as $article) {
                    $prix_total += $article['qty'] * $article['prix_u'];
                }
                $this->page .= '<td>';
                $this->page .= $prix_total . "€";
                $this->page .= '</td>';
                
                // Dates
                $this->page .= '<td>';
                $this->page .= "<table><tr>";
                $this->page .= "<td>Creation:\n". $devis['devis']['date_creation'] ."</td>";
                $this->page .= "</tr>";
                $this->page .= "<tr>";
                $this->page .= "<td>Validation: \n". $devis['devis']['date_validation'] ."</td>";
                $this->page .= "</tr></table> ";
                $this->page .= '</td>';
                
                // Status Devis
                $this->page .= '<td>';
                if ($devis['devis']['statut_valider']) {
                    $this->page .= "<i class='fas fa-check'></i>";
                } else {
                    $this->page .= "<i class='far fa-clock'></i>";
                }

                // Btn creation facture
                $this->page .= '<td>';
                if ($devis['devis']['statut_valider']) {
                    $this->page .= "<a class='btn btn-primary text-light'>Créer facture</a>";
                } else {
                    $this->page .= "<p class='btn btn-secondary bg-secondary btn-wait-custom'>En attente de validation</p>";
                }


                $this->page .= '</td>';

                $this->page .= '</tr>';
            }
            $this->page .= "</tbody>";

            $this->displayPage();
        }

        /**
         * Displays the form to create a new Quote
         *
         * A client needs to be selected as well as a list of articles
         * 
         * @param array $clientList
         * @param array $articleList
         * @return void
         */
        public function displayAddForm($clientList, $articleList)
        {
            $this->page .= "<h1>Creation d'un devis</h1>";
            $this->page .= file_get_contents("pages/forms/formAddDevis.html");

            $this->page = str_replace('{action}' ,'addToDB' ,$this->page);
            $this->page = str_replace('{display_ID}' ,'hidden' ,$this->page);
            $this->page = str_replace('{date_du_jour}' ,date('Y-m-d') ,$this->page);
            
            // Ajout de la liste des clients
            $text = "";
            foreach ($clientList as $client) {
                $text .= "<option value='". $client['id'] ."'>";
                $text .= $client['nom_societe'];
                $text .= "</option>";
            }
            $this->page = str_replace('{client_list}' ,$text ,$this->page);
            
            // Ajout de la liste d'articles'
            $text = "";
            foreach ($articleList as $article) {
                $text .= "<p class='my-0'><input type='checkbox' id='article_".$article['id']."' name='articles[]' value='". $article['id'] ."'> <label for='article_".$article['id']."'>".$article['nom']." (Qté =". $article['qty'] .")"."</label></p>";
            }
            $this->page = str_replace('{article_list}' ,$text ,$this->page);

            $this->displayPage();
        }

       
    }
    

