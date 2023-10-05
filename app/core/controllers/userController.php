<?php

function all()
{
    require_once('./app/core/models/userModel.php');
    $results = findAll();
    // require_once('./app/core/views/user/all.php');
}

/**
 * Controller to verify user's input in the update form
 * and will call to 'updateUserById' function if input is valid
 *
 * @return void
 */
function update()
{
    require_once('./app/core/models/userModel.php');

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
        $errorPfp = "Erreur, le fichier est trop volumineux";
    }

        if (!empty($_FILES) && $_FILES['profilePicture']["error"] != 4) {
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
            ))) {
                $errorPfp = "erreur! Une erreur est survenue lors de l'envoie du fichier";
            }
            else{
                $filename = $newFileName.".".$ext;
            }
        }
        else{
            $filename = json_decode($_COOKIE['userInfo'], true)["pfp"];
        }

    if (isset($errorPfp)) {
        $errorArray["profilePictureError"] = $errorPfp;
        
    }

    if (!isset($errUserName) && !isset($errorPfp)) {


        $queryResult = updateUserById(intval($_POST['id']), htmlentities($username), $filename);

        if ($queryResult) {
            $userInfo = json_decode($_COOKIE['userInfo'], true);
            $userInfo['username'] = $username;
            $userInfo["pfp"] = $filename;

            setcookie("connected", true, time() + 2629800);
            setcookie("userInfo", json_encode($userInfo), time() + 2629800);

            header('Location: index.php?controller=article&action=all');   
        }
        else {
            header('Location: index.php?controller=home&action=error');   
        }

    }else{
        session_start();
        $_SESSION["UpdateErrors"]=$errorArray; 
        header("Location: index.php?controller=user&action=showUpdateForm");
    }
}

/**
 * Will require and display the form for changing the username and profile pcture
 *
 * @return void
 */
function showUpdateForm()
{
    require_once('./app/core/models/userModel.php');
    require_once('./app/core/views/user/update.php');
}

/**
 * Function do delete user
 *
 * @return void
 */
function delete()
{
    require_once('./app/core/models/userModel.php');
    $result = deleteBy($_POST["deleteID"]);

    if ($result) {
        deconnexion();
        header('Location: index.php?controller=article&action=all');   
    }
    else{
        header('Location: index.php?controller=home&action=error');
    }
}

/**
 * Will require and display the form for user registration
 *
 * @return void
 */
function showRegisterForm()
{
    require_once('./app/core/views/user/inscription.php');
}

/**
 * Controller to verify user's input in the register form
 * and will call to 'addOne' function if input is valid 
 *
 * @return void
 */
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
        $result = addOne($username, $email, $hashedPassword);

        if ($result) {
            header("Location: .//index.php?controller=user&action=showLoginForm");
        }
        else {
            header('Location: ./index.php?controller=home&action=error');
        }
    } else {
        session_start();
        $_SESSION["registerError"] = $errorArray;

        header("Location: ./index.php?controller=user&action=showRegisterForm");
    }
}

/**
 * Will require and display the form for user login
 * 
 *
 * @return void
 */
function showLoginForm()
{
    require_once('./app/core/views/user/connexion.php');
}

/**
* Controller to verify user's input in the login form
 * and will call to 'connexion' function if input is valid 
 * and will create connexion coookies
 *
 * @return void
 */
function login()
{
    require_once('./app/core/models/userModel.php');
    $email = htmlentities(trim($_POST["email"]));
    $mdp = htmlentities(trim($_POST["password"]));
    $connexionVerif = connexion($email);
    
    if ($connexionVerif != false && password_verify($mdp, $connexionVerif['password'])) {

        $userId = $connexionVerif['id'];
        $username = $connexionVerif['username'];
        $userEmail = $connexionVerif['email'];
        $userPfp = $connexionVerif['profile_picture'];

        $userInfo = ["id" => "$userId", "username" => "$username", "email" => "$userEmail", "pfp" => "$userPfp"];


        setcookie("connected", true, time() + 2629800);
        setcookie("userInfo", json_encode($userInfo), time() + 2629800);

        header("Location: ./index.php?controller=article&action=all");
    } else {
        session_start();
        $_SESSION["LoginError"] = ["wrongCredentials"=>"L'email ou le mot de passe saisie est invalide."];

        header("Location: ./index.php?controller=user&action=showLoginForm");
    }
}

/**
 * Controller to disconnect a user and destroy connexion cookies
 *
 * @return void
 */
function deconnexion()
{
    setcookie("connected", "", time() - 2629800);
    setcookie("userInfo", "", time() - 2629800);

    header("Location: ./index.php?controller=article&action=all");
}
