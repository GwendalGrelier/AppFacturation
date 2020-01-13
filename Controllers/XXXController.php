<?php

include "Models/XXXModel.php";
include "Views/XXXView.php";

class XXXController extends Controller
{
    public function __construct()
    {
        $this->model = new XXXModel();
        $this->view = new XXXView();
    }

    
}
