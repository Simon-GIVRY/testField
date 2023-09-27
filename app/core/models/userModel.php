<?php

/**
 * Undocumented function
 *
 * @return void
 */
function findAll()
{
    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "SELECT * FROM users";

        $exec = $pdoConn->query($query);

        if ($exec) {
            $results = $exec->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return $results;
}

/**
 * Get all info of a user by searching with it's ID
 *
 * @param int $id
 * @return void
 */
function findBy(int $id)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $query = "SELECT * FROM users WHERE id=$id";

        $exec = $pdoConn->query($query);

        if ($exec) {
            $user = $exec->fetch(PDO::FETCH_ASSOC);
        } else {
            // header('Location: ../error.php')
            echo "Erreur";
        }
    }
    return $user;
}

/**
 * Update hte username and profile picture of an user by using the ID
 *
 * @param string $username
 * @param string $profilePicture
 * @param integer $userID
 * @return void
 */
function updateUserById(string $username, string $profilePicture, int $userID)
{
    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "UPDATE users SET username='$username', profile_picture='$profilePicture' WHERE id='$userID'";

        
        $exec = $pdoConn->query($query);

        if ($exec) {
            // header('Location: index.php?controller=home&action=Accueil');
        } else {
            // header('Location: index.php?controller=user&action=showUpdateForm');
        }
    }
}

/**
 * Delete an user by using it's Id
 *
 * @param integer $id
 * @return void
 */
function deleteBy(int $id)
{
    require_once('dbConnect.php');

    // Contrôle de l'état de la connexion à la base de données
    if ($pdoConn) {


        // Stockage de la requête SQL au sein de la variable $query.
        $query = "DELETE FROM users WHERE id=$id";

        // Execution de la requête sur la base de données.
        // Stockage du résultat de l'exécution dans la variable $execution.
        $exec = $pdoConn->query($query);

        if ($exec) {
            // Si la requête de suppression s'est exécutée sans accrocs :
            // Redirection vers la page sur laquelle figurent l'ensemble des livres
            header('Location: index.php?controller=user&action=all');
        }
        // Si la requête a rencontré une erreur lors de son execution
        else {
            header('Location: ../error.php');
        }
    } // Fin du contrôle de la connexion à PDO

    else {
        header('Location: ../error.php');
    }
}

/**
 * Verify if the inputted email hasn't been used already
 *
 * @param string $email
 * @return void
 */
function ifAlreadyExists(string $email)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $check = $pdoConn->prepare('SELECT COUNT(*) FROM users WHERE email = :email');

        $check->bindParam(':email', $email, PDO::PARAM_STR);

        $check->execute();

        $result = $check->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}

/**
 * Create a new user
 *
 * @param string $username
 * @param string $email
 * @param string $password
 * @return void
 */
function addOne(string $username, string $email, string $password)
{
    // Récupération de la connexion à la base de données
    require("dbConnect.php");

    // Si la connexion à la base de données est effective
    if ($pdoConn) {

        // Stockage de la requête d'ajout au sein de la variable $query.
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email' ,'$password')";

        // Execution de la requête sur la base de données.
        // Stockage du résultat de l'exécution dans la variable $execution.

        $exec = $pdoConn->query($query);

        if ($exec) {
            // Si la requête s'est exécutée sans accrocs :
            // Redirection vers la page qui affiche l'ensemble des livres
            header("Location: .//index.php?controller=user&action=showLoginForm");
        }
    }
}

/**
 * verify if a user already exists to make a connexion 
 *
 * @param string $email
 * @return void
 */
function connexion(string $email)
{
    require_once("dbConnect.php");

    if ($pdoConn) {
        $query = "SELECT * FROM users WHERE email='$email'";

        $exec = $pdoConn->query($query);

        if ($exec) {
            $user = $exec->fetch(PDO::FETCH_ASSOC);
            return [1, $user];
        } else {
            var_dump("error model");
        }
    }
};
