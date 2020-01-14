<?php
    

    /**
     * undocumented class
     */
    class ClientView extends View {


        /**
         * Affichage de la page d'accueil
         * Liste des clients issues de la BDD
         *
         * @param array $clientsList
         * @return void
         */
        public function displayMainPage($clientsList) {
            $this->page .= "<h1>Liste des clients</h1>";
            // if (isset($_SESSION['user'])) {
            $this->page .= "<p><a href='index.php?controller=client&action=addFormClient'><button class='btn btn-primary'>Ajouter</button></a></p>";
            // }
            $this->page .= "<table class='table'>";
            $this->page .= "<tr style='background-color: #e3f2fd'>";
            $this->page .= "<th>ID</th>";
            $this->page .= "<th class='text-center'>Adresse postale</th>";
            $this->page .= "<th class='text-center'>Email</th>";
            $this->page .= "<th class='text-center'>N° TVA</th>";
            $this->page .= "<th class='text-center'>N° SIRET</th>";
            $this->page .= "<th class='text-center'>Notes</th>";
            $this->page .= "<th class='text-center'>Nom de la société</th>";
            // if (isset($_SESSION['user'])) {
                $this->page .= "<th class='text-center'>Modifier</th>";
                $this->page .= "<th class='text-center'>Supprimer</th>";
            // }
            $this->page .= "</tr>";
            
            // if (isset($_SESSION['user'])) {
                foreach($clientsList as $client) {
                    $this->page .= "<tr>" 
                    . "<td>" . $client['id'] . "</td>"
                    . "<td>" . $client['adresse_postale'] . "</td>"
                    . "<td>" . $client['adresse_electronique'] . "</td>"
                    . "<td>" . $client['n_tva'] . "</td>"
                    . "<td>" . $client['siret'] . "</td>"
                    . "<td>" . $client['notes'] . "</td>"
                    . "<td>" . $client['nom_societe'] . "</td>"
                    . "<td class='text-center'><a href='index.php?controller=client&action=updateFormClient&id="
                    . $client['id']
                    . "' class='btn btn-warning' title='mise à jour' ><i class='fas fa-pen'></i></a>"  
                    . "</td>"
                    . "<td class='text-center'><a href='index.php?controller=client&action=deleteClientFromDB&id="
                    . $client['id']
                    . "' class='btn btn-danger' title='supprimer' ><i class='fas fa-trash-alt'></i></a>"  
                    . "</td>"
                    . "</tr>";
                    
                }
            // } else {
                // foreach($clientsList as $client) {
                //     $this->page .= "<tr>" 
                //     . "<td>" . $client['id'] . "</td>"
                //     . "<td>" . $client['adresse_postale'] . "</td>"
                //     . "<td>" . $client['adresse_electronique'] . "</td>"
                //     . "<td class='text-center'><a href='index.php?controller=client&action=detailClient&id="
                //     . $client['id']
                //     . "' class='btn btn-success' title='Lire' ><i class='fas fa-eye'></i></a>"  
                //     . "</td>"
                //     . "</tr>";
                // }
            // }
            $this->page .= "</table>";
            $this->displayPage();
        }
    }
    

