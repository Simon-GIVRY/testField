<?php

function all()
{
    require_once('./app/core/models/userModel.php');
    $results = findAll();
    // require_once('./app/core/views/user/all.php');
}

function update()
{
    require_once('./app/core/models/userModel.php');

    var_dump($_COOKIE);

    $errorArray = ["usernameError" => "", "profilePictureError"=>""];


    $username = htmlentities(trim($_POST["username"]));
    $pfp = $_FILES["profilePicture"];

    if (strlen($username) > 30) {
        $errUserName = "Non d'utilisateur trop long. 30 Charactères max.";
    }

    if (!preg_match("/^[a-zA-Z0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð_'-]{1,30}$/", $username)) {
        $errUserName = "Le nom d'utilisateur peut seulement contenir des lettres, des nombres et des underscores";
    }

    if (empty($username)) {
        $errUserName = "Ce champ doit etre rempli.";
    }

    if (isset($errUserName)) {
        $errorArray["usernameError"] = $errUserName;
    }

    if ($pfp['size'] > 1000000) {
        var_dump("Erreur, le fichier est trop volumineux");
    }
    var_dump($_FILES);


    // file control
    if (!empty($_FILES) && $_FILES['error']>=1) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($pfp['tmp_name']),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            $errorPfp = "mauvais format d'image.";
        }

        $newFileName = sha1_file($pfp['tmp_name']);
    
        if (!move_uploaded_file(
            $pfp['tmp_name'],
            sprintf('./app/public/uploads/profilePictures/%s.%s',
                $newFileName,
                $ext
            )
        )) {
            $errorPfp = "erreur! Une erreur est survenue lors de l'envoie du fichier";
        }
    }
    else {
        $errorPfp = "Aucun fichier n'a été envoyer.";
        
    }

    if (isset($errorPfp)) {
        $errorArray["profilePictureError"] = $errUserName;
    }

    if (!isset($errUserName) && !isset($errorPfp)) {
        updateUserById(htmlentities($username), $newFileName.".".$ext,htmlentities($_POST['id']));

    }else{
        session_start();
        $_SESSION["UpdateErrors"]=$errorArray; 
        header("Location: index.php?controller=user&action=showUpdateForm");
    }
}

function showUpdateForm()
{
    require_once('./app/core/models/userModel.php');
    require_once('./app/core/views/user/update.php');
}

function delete()
{
    require_once('./app/core/models/userModel.php');
    deleteBy($_POST["deleteID"]);
}

function showRegisterForm()
{
    require_once('./app/core/views/user/inscription.php');
}

function register()
{

    require_once('./app/core/models/userModel.php');


    $errorArray = ["usernameError" => "", "emailError" => "", "passwordError" => "", "confirmErrorPassword" => ""];


    foreach ($_POST as $fields => $value) {
        if ($fields === "username") {
            $username = htmlentities(trim($value));


            if (strlen($username) > 30) {
                $errUserName = "Non d'utilisateur trop long. 30 Charactères max.";
            }

            if (!preg_match("/^[a-zA-Z0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð_'-]{1,30}$/", $username)) {
                $errUserName = "Le nom d'utilisateur peut seulement contenir des lettres, des nombres et des underscores";
            }

            if (empty($username)) {
                $errUserName = "Ce champ doit etre rempli.";
            }

            if (isset($errUserName)) {
                $errorArray["usernameError"] = $errUserName;
            }
        }

        if ($fields === "email") {
            $email = trim($value);

            if (empty($email)) {
                $errMail = "Ce champ doit être rempli";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errMail = "Votre adresse email n'est pas conforme.";
            }

            if (ifAlreadyExists($email)["COUNT(*)"] >= 1) {
                $errMail = "L'email saisie est déjà utilisé";
            }



            if (isset($errMail)) {
                $errorArray["emailError"] = $errMail;
            }
        }

        if ($fields === "password") {

            $password = trim($value);

            if (empty($password)) {
                $errPassword = "Ce champ doit être rempli.";
            }

            if (strlen($password) <= 8) {
                $errPassword = "Votre mot de passe doit au moins faire 8 charactère de long.";
            }


            if (strlen($password) > 30) {
                $errPassword = "Mot de passe trop long.";
            }


            if (!preg_match('/[A-Z]/', $password)  || !preg_match('/\d/', $password) || !preg_match("/[$&+,:;=?@#|'<>.-^*()%!]/", $password)) {
                $errPassword = "Votre mot de passe doit contenir au moins une majuscule, un chiffre et un charactère special.";
            }

            if (isset($errPassword)) {
                $errorArray["passwordError"] = $errMail;
            }

            if (empty($errPassword)) {
                $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
            }
        };

        if ($fields === "confirmPassword") {

            $confirmPassword = trim($value);

            if (empty($confirmPassword)) {
                $errConfirmPassword = "Ce champ doit être rempli.";
            } elseif ($password != $confirmPassword) {
                $errConfirmPassword = "Vos mots de passes ne correspondent pas.";
            }

            if (isset($errConfirmPassword)) {
                $errorArray["confirmErrorPassword"] = $errConfirmPassword;
            }
        }
    }

    if (!isset($errUserName) && !isset($errMail) && !isset($errPassword) && !isset($errConfirmPassword)) {
        addOne($username, $email, $hashedPassword);
    } else {
        session_start();
        $_SESSION["registerError"] = $errorArray;

        header("Location: ./index.php?controller=user&action=showRegisterForm");
    }
}

function showLoginForm()
{
    require_once('./app/core/views/user/connexion.php');
}

function login()
{
    require_once('./app/core/models/userModel.php');
    $email = $_POST["email"];
    $mdp = $_POST["password"];
    $connexionVerif = conn($email, $mdp);

    if ($connexionVerif['0'] === 1 && password_verify($mdp, $connexionVerif['1']['password'])) {

        $userId = $connexionVerif[1]['ID'];
        $username = $connexionVerif[1]['username'];
        $userEmail = $connexionVerif[1]['email'];
        $userPfp = $connexionVerif[1]['profile_picture'];

        $userInfo = ["id" => "$userId", "username" => "$username", "email" => "$userEmail", "pfp" => "$userPfp"];

        setcookie("connected", true, time() + 2629800);
        setcookie("userInfo", json_encode($userInfo), time() + 2629800);

        header("Location: ./index.php?controller=home&action=Accueil");
    } else {
        var_dump("error controller");
        // La connexion a échoué, vous pouvez gérer cela ici (par exemple, afficher un message d'erreur).
    }
}

function showConnForm()
{
    require_once('./app/core/views/user/connexion.php');
}

function deconnexion()
{
    setcookie("connected", "", time() - 2629800);
    setcookie("userInfo", "", time() - 2629800);

    header("Location: ./index.php?controller=home&action=Accueil");
}