<?php

require_once("../dbConnect.php");

if ($conn) {

    $check = $conn->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
    $query = $conn->prepare('INSERT INTO users (username, email, password, profile_picture) VALUES(:username, :email, :password, :profilePicture)');

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $profilePicture = $_POST["profilePicture"];

    foreach ($_POST as $fields => $value) {
        var_dump($value);

        if ($fields === "username") {
            $username = trim($value);

            if (empty($username)) {
            }

            if (strlen($username) > 30) {
                $errUserName = "Non d'utilisateur trop long. 30 Charactères max.";
            } 
            
            elseif (!preg_match("/^[a-zA-Z0-9àáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð_'-]{1,30}$/", $username)) {
                $errUserName = "Le nom d'utilisateur peut seulement contenir des lettres, des nombres et des underscores";
            }

            $check->bindParam(':username', $username, PDO::PARAM_STR);


            if ($check->execute()) {

                header("Location: ./inscription.php");
            }
            else{
                $query->bindParam(':username', $username, PDO::PARAM_STR);
            }
        }

        if ($fields === "email") {

            $email = trim($value);

            if (empty($mail)) {
                $errMail = "Ce champ doit être rempli";
            } 

            elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL))  {
                $errMail = "Votre adresse email n'est pas conforme.";
            }

            var_dump($value);

            $query->bindParam(':email', $email, PDO::PARAM_STR);
        };

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

            
            if (!preg_match('/[A-Z]/', $password)  || !preg_match('/\d/', $password) || !preg_match("/[$&+,:;=?@#|'<>.-^*()%!]/", $password) ) {
                $errPassword = "Votre mot de passe doit contenir au moins une majuscule, un chiffre et un charactère special.";
            }

            if (empty($errPassword)) {
                $hashedPassword =hash('sha512', htmlspecialchars($password) );
            }

            var_dump($value);

            $query->bindParam(':password', $password, PDO::PARAM_STR);
        };


        if ($fields === "confirmPassword") {
                
            $confirmPassword = trim($value);

            if (empty($confirmPassword)) {
                $confirmPassword = "Ce champ doit être rempli.";
            } 
            
            elseif ($password != $confirmPassword) {
                $confirmPassword = "Vos mots de passes ne correspondent pas.";
            }
        }

        if ($fields === "profilePicture") {

            $profilePicture = trim($value);
            var_dump($value);


            $query->bindParam(':profilePicture', $profilePicture, PDO::PARAM_STR);

        };
    }

    // $query->execute();
} 

else {
    ?>
    <h1>Erreur de connexion</h1>

<?php
}

?>