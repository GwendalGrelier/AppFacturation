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

        public function displayAddForm()
        {
            $this->page .= "<h1>Welcome Here</h1>";
            
        }
    }
    

