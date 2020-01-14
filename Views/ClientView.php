<?php
    

    /**
     * undocumented class
     */
    class ClientView extends View {


        public function displayMainPage() {
            $this->page .= "<h1>Liste des clients</h1>";

            foreach ($clientList as $client) {

            }

            $this->displayPage();
        }
    }
    

