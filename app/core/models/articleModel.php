<?php

function findAll()
{
    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "SELECT * FROM article ORDER BY created_at desc";

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

function create($title, $content, $created_at, $idUser){
    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "INSERT INTO article (id, Titre, Contenue, created_at, idUsers) VALUES (3,'$title', '$content', '$created_at', '$idUser')";
        
        var_dump($query);
        $execution = $pdoConn->query($query);
        
        if($execution){
            header('Location: ./index.php?controller=article&action=all');
        }

        else{
            header('Location: ./index.php?controller=article&action=showCreateForm');
        }
    }
}