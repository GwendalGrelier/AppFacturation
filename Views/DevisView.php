<?php
    

    /**
     * undocumented class
     */
    class DevisView extends View {

        public function displayMainPage($devisList) {
            $this->page .= "<h1>Welcome Here</h1>";
           
            $this->page .= '<table>'; 


            foreach ($devisList as $devis) {
                $this->page .= '';
            }


            $this->displayPage();
        }
    }
    

