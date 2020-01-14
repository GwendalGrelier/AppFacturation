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
            $this->page .= "<p><a href='index.php?controller=client&action=addFormClient'><button class='btn btn-primary'>Ajouter</button></a></p>";

            foreach ($clientsList as $client) {

            }

            $this->displayPage();
        }
    }
    

