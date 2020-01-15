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
                $this->page .= '<td class="text-center">';
                $this->page .= '<a href=index.php?controller=client&action=displayClient&client='.$devis['client']['id_client'].'>';
                $this->page .= $devis['client']['nom_client'];
                $this->page .= '</a>';
                $this->page .= '<p><a href=index.php?controller=client&action=displayClient&client='.$devis['client']['id_client'].'>';
                $this->page .= '<i class="fas fa-eye"></i>';
                $this->page .= '</a></p>';
                $this->page .= '</td>';

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
                    $this->page .= "<a class='btn btn-primary text-light' href='index.php?controller=devis&action=creationFacture". $devis['devis']['id'] ."'>Créer facture</a>";
                } else {
                    $this->page .= "<p class='btn btn-secondary bg-secondary btn-wait-custom'>En attente de validation</p>";
                    $this->page .= "<p><a class='btn btn-warning text-light' href='index.php?controller=devis&action=displayEditForm&devis=". $devis['devis']['id'] ."'>Editer</a>";
                    $this->page .= "<a class='btn btn-primary text-light ml-1' target='_blank' href='devis/devis_n_". $devis['devis']['id'] .".html'>Voir Devis</a></p>";
                    $this->page .= "<a class='btn btn-danger text-light' href='index.php?controller=devis&action=deleteFromDB&id=". $devis['devis']['id'] ."'>Supprimer Devis</a>";
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
            $this->page .= file_get_contents("pages/forms/formDevis.html");

            $this->page = str_replace('{action}' ,'addToDB' ,$this->page);
            $this->page = str_replace('{display_ID}' ,'hidden' ,$this->page);
            $this->page = str_replace('{date_du_jour}' ,date('Y-m-d') ,$this->page);
            $this->page = str_replace('{remise_value}' ,'' ,$this->page);
            $this->page = str_replace('{taux_retard}' ,'' ,$this->page);
            $this->page = str_replace('{date_echeance}' ,'' ,$this->page);
            

            // Ajout de la liste des clients
            $text = "<option selected disabled>Choisir une option</option>";
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

        /**
         * Display the Edition Form for a Quote
         *
         * @param array $devis
         * @return void
         */
        public function displayEditForm($devis, $articleList)
        {
            $this->page .= "<h1>Edition d'un devis</h1>";
            $this->page .= file_get_contents("pages/forms/formDevis.html");

            $this->page = str_replace('{action}' ,'editToDB' ,$this->page);
            $this->page = str_replace('{display_ID}' ,'' ,$this->page);
            $this->page = str_replace('{id_devis}' ,$devis["devis"]['id'] ,$this->page);

            // Choix client
            $text = "<option selected  value='". $devis['client']['id_client'] ."'>";
            $text .= $devis['client']['nom_client'];
            $text .= "</option>";
            $this->page = str_replace('{client_list}' ,$text ,$this->page);
            
            // var_dump($devis);
            // Choix Remise Commerciale
            $this->page = str_replace('{remise_value}' ,$devis['devis']['remise_com'] ,$this->page);
            
            $this->page = str_replace('{taux_retard}' ,$devis['devis']['taux_retard'] ,$this->page);
            $this->page = str_replace('{date_echeance}' ,$devis['devis']['date_echeance'] ,$this->page);

            // Ajout de la liste d'articles'
            $text = "";

            foreach ($articleList as $article) {
                if (in_array($article['nom'], array_keys($devis['liste_articles']))) {
                    $text .= "<p class='my-0'><input type='checkbox' checked id='article_".$article['id']."' name='articles[]' value='". $article['id'] ."'> <label for='article_".$article['id']."'>".$article['nom']." (Qté =". $article['qty'] .")"."</label></p>";
                } else {
                    $text .= "<p class='my-0'><input type='checkbox' id='article_".$article['id']."' name='articles[]' value='". $article['id'] ."'> <label for='article_".$article['id']."'>".$article['nom']." (Qté =". $article['qty'] .")"."</label></p>";
                }
            }
            $this->page = str_replace('{article_list}' ,$text ,$this->page);
            
            $this->displayPage();
        }

        public function validationDevis($devis) {
            $this->page .="<h1>Validation de votre devis</h1>";
            $this->page .= file_get_contents("pages/forms/validationdevis.html");
            $this->page = str_replace('{action}' ,'valid' ,$this->page);
            $this->page = str_replace('{societe}' ,$devis['client']['nom_client'] ,$this->page);
            $this->page = str_replace('{numero}' ,$devis['devis']['id'] ,$this->page);
            $this->page = str_replace('{id}' ,$devis['devis']['id'] ,$this->page);

            $this->displayPage();
        }
    }
    

