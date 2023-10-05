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
        else {
            $results = false;
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
        $find = $pdoConn->prepare("SELECT * FROM users WHERE id=:id");

        $find->bindParam(':id',$id, PDO::PARAM_INT).

        $exec = $pdoConn->query($query);

        if ($exec) {
            $result = $exec->fetch(PDO::FETCH_ASSOC);
        } else {
            // header('Location: ../error.php')
           $result = false; 
        }
    }
    return $result;
}

/**
 * Update hte username and profile picture of an user by using the ID
 *
 * @param string $username
 * @param string $profilePicture
 * @param integer $userID
 * @return void
 */
function updateUserById(int $userID, string $username, string $profilePicture)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $update = $pdoConn->prepare("UPDATE users SET username=:username, profile_picture=:profilePicture WHERE id=:userID");

        $update->bindParam(':username', $username, PDO::PARAM_STR);
        $update->bindParam(':profilePicture',$profilePicture, PDO::PARAM_STR);
        $update->bindParam(':userID',$userID, PDO::PARAM_INT);

        $exec = $update->execute();

        if ($exec) {
           $result = true;
        } else {
           $result = false;
        }
        return $result;
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

        $create = $pdoConn->prepare('DELETE FROM users WHERE id=:id');

        $create->bindParam(':id', $id, PDO::PARAM_INT);

        $exec = $create->execute();
        
        if ($exec) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    } 

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
    
    require("dbConnect.php");


    if ($pdoConn) {

        $query = $pdoConn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email ,:password)");

        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->bindParam(":password", $password, PDO::PARAM_STR);
 
        $exec = $query->execute();

        if ($exec) {
            $result = true;
        }
        else {
            $result = false;
        }

        return $result;
    }
    header('Location: ./index.php?controller=home&action=error');
}

/**
 * Checks if email match in database
 *
 * @param string $email
 * @return PDOStatement|false
 */
function connexion(string $email)
{
    require_once("dbConnect.php");

    if ($pdoConn) {

        $verify = $pdoConn->prepare("SELECT * FROM users WHERE email=:email");

        $verify->bindParam(':email', $email, PDO::PARAM_STR);

        $exec = $verify->execute();


        if ($exec) {
            $result = $verify->fetch(PDO::FETCH_ASSOC);

        } else {
            $result = false;
        }
        return $result;
    }
    else {
        header('Location: ./index.php?controller=home&action=error');
        
    }
};
