<?php

    include "Views/View.php";
    include "Models/Model.php";
    include "Controllers/Controller.php";
    include "Controllers/ArticleController.php";
    include "Controllers/DevisController.php";
    include "Controllers/ClientController.php";
    include "Controllers/SecurityController.php";

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
    // Default is ArticleController
    $requested_controller = "DevisController";
    if (isset($_GET) && !empty($_GET["controller"])) {
        foreach ($controller_list as $controller) {
            if ($_GET["controller"] == $controller['name']) {
                $requested_controller = $_GET["controller"] . "Controller";
                $requested_controller = ucfirst($requested_controller);
            }
        }
    }

    // Get requested action
    $requested_action = "displayMainPage";
    if (isset($_GET) && !empty($_GET["action"])) {
        foreach ($controller_list as $controller) {
            if (in_array($_GET["action"], $controller['methodList'])) {
                $requested_action = $_GET["action"];
            }
        }      
    }
    
    // Set Action for visitors
    $authorizedVisitorActions = [
        "SecurityController" => ['displayMainPage', 'login']
    ];

    // Set Action for Clients
    $authorizedClientActions = [
        "SecurityController" => ["logout"],
        "DevisController" => ["displayMainPage"],
    ];

    // Deal with authorizations
   if (isset($_SESSION) && !empty($_SESSION["user"])) {
       $rank = $_SESSION["user"]['rank'];

        if ($rank != 1) {
            // Check Controller
            $final_controller = "DevisController";
            $final_action = "displayMainPage";
            if (in_array($requested_controller, array_keys($authorizedClientActions)) && in_array($requested_action, $authorizedClientActions[$requested_controller])) {
                $final_controller = $requested_controller;
                $final_action = $requested_action;    
            }            
        } else {
            // if admin
            $final_controller = $requested_controller;
            $final_action = $requested_action;    
        }
    } else {
        $final_controller = "SecurityController";
        $final_action = "displayMainPage";
        if (in_array($requested_controller, array_keys($authorizedVisitorActions)) && in_array($requested_action, $authorizedVisitorActions[$requested_controller])) {
            $final_controller = $requested_controller;
            $final_action = $requested_action;    
        } 
   }
   
    $controller = new $final_controller();
    $controller->$final_action();





