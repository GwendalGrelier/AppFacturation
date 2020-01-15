<?php

    include "Views/View.php";
    include "Models/Model.php";
    include "Controllers/Controller.php";
    include "Controllers/ArticleController.php";
    include "Controllers/DevisController.php";
    include "Controllers/ClientController.php";
    include "Controllers/EnvoieController.php";

    session_start();


    // Get class controller list
    $controller_list = [];
    foreach (get_declared_classes() as $class) {
        if (preg_match("/^([A-Za-z]+)Controller$/", $class, $match)) {
            $controller_list[] = [
                "className" => $match[0],
                "name" => strtolower($match[1])
            ];
        }
    }
    
    // Get controller/action table
    for ($i=0; $i < count($controller_list); $i++) { 
        $controller_list[$i]['methodList'] = get_class_methods($controller_list[$i]["className"]);
    }
      
    


    // Get requested controller
    // Default is NewsController
    $requested_controller = "ArticleController";
    if (isset($_GET) && !empty($_GET["controller"])) {
        foreach ($controller_list as $controller) {
            if ($_GET["controller"] == $controller['name']) {
                $requested_controller = $_GET["controller"] . "Controller";
                $requested_controller = ucfirst($requested_controller);
            }
        }
    }

    // Get requested action
    $action = "displayMainPage";
    if (isset($_GET) && !empty($_GET["action"])) {
        foreach ($controller_list as $controller) {
            if (in_array($_GET["action"], $controller['methodList'])) {
                $action = $_GET["action"];
            }
        }      
    }
    
    
    
   

    $controller = new $requested_controller();
    $controller->$action();





