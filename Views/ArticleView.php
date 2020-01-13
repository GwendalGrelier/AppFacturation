<?php
    

    /**
     * undocumented class
     */
    class ArticleView extends View {

        public function displayHome() {
            $this->page .= "<h1>Welcome Here</h1>";
            
            $this->displayPage();
        }
    }
    
