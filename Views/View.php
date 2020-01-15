<?php
    
    abstract class View {

        protected $page;

        /**
         * View constructor
         */
        public function __construct() {
        
            $this->page = file_get_contents('pages/parts/head.html');
            $this->page .= file_get_contents('pages/parts/nav.html');

            
            // Set the login/logout btn
            if (isset($_SESSION) && !empty($_SESSION["user"])) {
                $text = "<a class='nav-link' href='index.php?controller=security&action=logout'>Logout</a>";
            } else {
                $text = "<a class='nav-link' href='index.php?controller=security'>Login</a>";
            }
            $this->page = str_replace("{login_button}", $text, $this->page);


            // Set active class for the nav
            // ! Has to be set at the end of the constructor to avoir overwriting tags !
            $query_string = $_SERVER["QUERY_STRING"];
            if (preg_match("/controller=([a-z]+)/", $query_string, $matches)) {
                $result = $matches[1];
            } else {
                $result = 'news';
            }
            $matched_str = '{active-' .$result .'}';
            $this->page = str_replace($matched_str, "active", $this->page);
            $this->page = preg_replace("/{active-[a-z]+}/", "", $this->page);



            // if (preg_match_all("/controller\=([a-z]+)&?/", $query_string, $matches)) {
            //     $result = $matches[1][0];
            // } else {
            //     $result = "news";
            // }
            // $matched_str = "{" . $result . "}";
            // $this->page = str_replace($matched_str, "active", $this->page);
            // $this->page = preg_replace("/{.+}/", "", $this->page);
            


        }
        
        /**
         * Display the content of the page
         * Single echo of the view
         * 
         * @return void
         */
        protected function displayPage()
        {
            $this->page .= file_get_contents("pages/parts/footer.html");
            echo $this->page;
        }
    }