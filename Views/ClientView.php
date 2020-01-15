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
            $this->page .= "<th class='text-center'>Nom de la société</th>";
            $this->page .= "<th class='text-center'>Adresse postale</th>";
            $this->page .= "<th class='text-center'>Email</th>";
            $this->page .= "<th class='text-center'>N° TVA</th>";
            $this->page .= "<th class='text-center'>N° SIRET</th>";
            $this->page .= "<th class='text-center'>Notes</th>";
            
            // if (isset($_SESSION['user'])) {
                $this->page .= "<th class='text-center'>Modifier</th>";
                $this->page .= "<th class='text-center'>Supprimer</th>";
            // }
            $this->page .= "</tr>";
            
            // if (isset($_SESSION['user'])) {
                foreach($clientsList as $client) {
                    $this->page .= "<tr>" 
                    . "<td>" . $client['id'] . "</td>"
                    . "<td><a href=index.php?controller=client&action=displayDetailClient&id=". $client['id'] . "'>" . $client['nom_societe'] . "</a></td>"
                    . "<td>" . $client['adresse_postale'] . "</td>"
                    . "<td>" . $client['adresse_electronique'] . "</td>"
                    . "<td>" . $client['n_tva'] . "</td>"
                    . "<td>" . $client['siret'] . "</td>"
                    . "<td>" . $client['notes'] . "</td>"
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
            //     foreach($clientsList as $client) {
            //         $this->page .= "<tr>" 
            //         . "<td>" . $client['id'] . "</td>"
            //         . "<td>" . $client['nom_societe'] . "</td>"
            //         . "<td>" . $client['adresse_postale'] . "</td>"
            //         . "<td>" . $client['adresse_electronique'] . "</td>"
            //         . "<td>" . $client['n_tva'] . "</td>"
            //         . "<td>" . $client['siret'] . "</td>"
            //         . "<td>" . $client['notes'] . "</td>"
            //         . "<td class='text-center'><a href='index.php?controller=client&action=detailClient&id="
            //         . $client['id']
            //         . "' class='btn btn-success' title='Lire' ><i class='fas fa-eye'></i></a>"  
            //         . "</td>"
            //         . "</tr>";
            //     }
            // }
            $this->page .= "</table>";
            $this->displayPage();
        }

        /**
         * Affichage du formulaire d'ajout de client
         *
         * @param array $devisList
         * @return void
         */
        public function displayAddFormClient() {
            $this->page .= "<h1>Ajout d'un client</h1>";
            $this->page .= "<p>J'ajoute un client via un formulaire</p>";
            
            $this->page .= file_get_contents('pages/forms/formAddClient.html');
            
            $this->page = str_replace('{action}', 'addClientToDB', $this->page);
            $this->page = str_replace('{id}', '', $this->page);
            $this->page = str_replace('{nom_societe}', '', $this->page);
            $this->page = str_replace('{adresse_postale}', '', $this->page);
            $this->page = str_replace('{adresse_electronique}', '', $this->page);
            $this->page = str_replace('{n_tva}', '', $this->page);
            $this->page = str_replace('{siret}', '', $this->page);
            $this->page = str_replace('{notes}', '', $this->page);
            
            $this->displayPage();
        }

        /**
         * Affichage du formulaire de mise à jour du client
         *
         * @param array $client
         * @return void
         */
        public function displayUpdateFormClient($client) {
            
            $this->page .= "<h1>Mis à jour d'un client</h1>";
            $this->page .= "<p>Je mets à jour un client via un formulaire</p>";
            
            $this->page .= file_get_contents('pages/forms/formAddClient.html');
            
            $this->page = str_replace('{action}', 'updateClientToDB', $this->page);
            $this->page = str_replace('{id}', $client['id'], $this->page);
            $this->page = str_replace('{nom_societe}', $client['nom_societe'], $this->page);
            $this->page = str_replace('{adresse_postale}', $client['adresse_postale'], $this->page);
            $this->page = str_replace('{adresse_electronique}', $client['adresse_electronique'], $this->page);
            $this->page = str_replace('{n_tva}', $client['n_tva'], $this->page);
            $this->page = str_replace('{siret}', $client['siret'], $this->page);
            $this->page = str_replace('{notes}', $client['notes'], $this->page);

            $this->displayPage();
        }

        public function displayDetailClient($client) {
            $this->page .= "<h1>Détail du client</h1>";
            $this->page .= "<table class='table'>";
            $this->page .= "<tr style='background-color: #e3f2fd'>";
            $this->page .= "<th class='text-center'>Nom de la société</th>";
            $this->page .= "<th class='text-center'>Adresse postale</th>";
            $this->page .= "<th class='text-center'>Email</th>";
            $this->page .= "<th class='text-center'>N° TVA</th>";
            $this->page .= "<th class='text-center'>N° SIRET</th>";
            $this->page .= "<th class='text-center'>Notes</th>";
            $this->page .= "</tr>";
            $this->page .= "<tr>" 
                    . "<td>" . $client['nom_societe'] . "</td>"
                    . "<td>" . $client['adresse_postale'] . "</td>"
                    . "<td>" . $client['adresse_electronique'] . "</td>"
                    . "<td>" . $client['n_tva'] . "</td>"
                    . "<td>" . $client['siret'] . "</td>"
                    . "<td>" . $client['notes'] . "</td>"
                    . "</tr>";
            $this->page .= "</table>";
            $this->page .= "<p><a href='index.php?controller=client'><button class='btn btn-primary justify-content-center'>Retour à la liste</button></a></p>";
        
            // var_dump($new);

            $this->displayPage();
        }
    }
    

