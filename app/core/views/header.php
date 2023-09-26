<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../../webfiles/css/style.css"> -->
    <link rel="shortcut icon" href="./app/public/src/maxwell.png" type="image/x-icon">
    <link rel="stylesheet" href="./app/public/css/style.css">
    <link rel="stylesheet" href="./app/public/css/pauseMenu.css">
    <link rel="stylesheet" href="./app/public/css/bubble.css">
    <script src="./app/public/js/script.js" defer></script>
    <!-- <script src="../../webfiles/js/bubbleText.js" defer></script> -->
    <script src="./app/public/js/inputVerification.js" defer></script>
</head>

<body>
    <header>
        <section class="header">
            <div class="logo">
                <a href="./index.php?controller=home&action=Accueil">
                    <img src="./app/public/src/maxwell.png" alt="Image de Maxwell">
                    <p>Maxwell</p>
                </a>
            </div>

           
                <menu class="navMenu">
                    <li>
                        <a href="./index.php?controller=article&action=all">articles</a>
                    </li>
                </menu>

          

            <div class="connexion">
                <?php
                if (isset($_COOKIE["connected"]) && $_COOKIE["connected"] === "1") {
                    $userInfo =json_decode($_COOKIE["userInfo"], true);
                ?>
                    <a href="./index.php?controller=user&action=showUpdateForm" class="connected">
                        <img src="<?= "./app/public/uploads/profilePictures/".$userInfo["pfp"] ?>" class="userImg" alt="Image d'utilisateur">
                        <span><?= $userInfo["username"] ?></span>
                    </a>

                <?php
                } 
                else {
                ?>
                    <a href="./index.php?controller=user&action=showLoginForm">Connexion</a>
                    <a href="./index.php?controller=user&action=showRegisterForm">inscription</a>

                <?php
                }


                ?>
            </div>
        </section>
    </header>
    <main>