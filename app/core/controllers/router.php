<?php 

    $ctrlName = 'home';
    $fonction = 'accueil';

    if(isset($_GET["controller"])){
        $ctrlName = $_GET["controller"];
    }

    if(isset($_GET["action"])){
        $fonction = $_GET["action"];
    }

    require_once('./app/core/controllers/'.$ctrlName.'Controller.php');

    $fonction();    
?>
