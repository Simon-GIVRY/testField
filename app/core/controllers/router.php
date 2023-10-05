<?php 

    $ctrlName = 'article';
    $fonction = 'all';

    if(isset($_GET["controller"])){
        $ctrlName = $_GET["controller"];
    }

    if(isset($_GET["action"])){
        $fonction = $_GET["action"];
    }

    require_once('./app/core/controllers/'.$ctrlName.'Controller.php');

    $fonction();    
?>
