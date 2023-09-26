<?php 

    // Initialise le controlleur et la fonction a executer avec des valeurs 
    // par défaut (si les paramètres "controlleur" et "action" ne sont pas 
    // renseignés dans l'URL.

    $ctrlName = 'home';
    $fonction = 'accueil';

    // Vérifie qu'un paramètre "controlleur" existe dans l'URL
    // et qu'il n'est pas vide
    if(isset($_GET["controller"])){
        $ctrlName = $_GET["controller"];
    }

    // Idem mais pour l'action (qui permettra d'executer une fonction).
    if(isset($_GET["action"])){
        $fonction = $_GET["action"];
    }

    // Requisitionne le controlleur passé dans l'URL
    require_once('./app/core/controllers/'.$ctrlName.'Controller.php');

    // Execute la fonction passée dans l'URL (issue du contrôleur chargé).
    $fonction();

    // Exemple : 
    // https://mon-joli-site.test/index.php?controller=book&action=all
    // Requisitionne le fichier "bookController.php" tel qui suit :
    // require_once('app/core/controller/bookController.php')
    // Execute la fonction all() provenant du bookController
    
?>
