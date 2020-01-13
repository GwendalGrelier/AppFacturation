<?php
    

    /**
     * undocumented class
     */
    class ArticleView extends View {

        public function displayHome() {
            $this->page .= "<h1>Welcome Here Article </h1>";
            
            $this->displayPage();
        }
    }
    
