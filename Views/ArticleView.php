<?php
    

    /**
     * undocumented class
     */
    class articleView extends View {

        public function displayHome() {
            $this->page .= "<h1>Welcome Here</h1>";
            
            $this->displayPage();
        }
    }
    