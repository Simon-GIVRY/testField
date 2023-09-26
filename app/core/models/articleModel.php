<?php

function findAll()
{
    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "SELECT * FROM article";

        $exec = $pdoConn->query($query);

        if ($exec) {
            $results = $exec->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return $results;
}

function findBy(int $id){
    require_once('dbConnect.php');
   
    if($pdoConn){

        $query = "SELECT *, users.username FROM article INNER JOIN users ON article.idUsers = users.ID WHERE article.id = $id";

        $execution = $pdoConn->query($query);

        if($execution){

            $book = $execution->fetch(PDO::FETCH_ASSOC);
        }

        else{
            header('Location: ../error.php');
        }
    }
    return $book;
}