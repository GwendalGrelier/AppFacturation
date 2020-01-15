<?php
    

    /**
     * undocumented class
     */
    class SecurityView extends View {

        public function displayMainPage() {
            $this->page .= "<h1>Welcome to the Login Page</h1>";
            $this->page .= file_get_contents("pages/forms/formLogin.html");
            
            $this->page = str_replace("{action}", "login", $this->page);

            $this->displayPage();
        }
    }
    

