<?php

function findAll($offset)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $offset = ($offset-1)*5;

        $query = "SELECT * FROM article ORDER BY created_at desc LIMIT $offset, 5";

        $exec = $pdoConn->query($query);

        if ($exec) {
            $results = $exec->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    return $results;
}

function pageNumbers()
{
    require('dbConnect.php');


    if ($pdoConn) {

        $query = "SELECT COUNT(*) FROM article";


        $exec = $pdoConn->query($query);

        if ($exec) {
            $results = $exec->fetch(PDO::FETCH_ASSOC);
        }
    }
    return $results;

}

function findBy(int $id){
    
        require('dbConnect.php');
   
    if(isset($pdoConn)){
        $query = "SELECT article.id, article.Titre, article.Contenue, article.created_at, article.id_user ,users.username FROM article INNER JOIN users ON article.id_user = users.ID WHERE article.id = $id";

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
        $query = "INSERT INTO article (Titre, Contenue, created_at, id_user) VALUES ('$title', '$content', '$created_at', '$idUser')";
        
        $execution = $pdoConn->query($query);
        
        if($execution){
            header('Location: ./index.php?controller=article&action=all');
        }

        else{
            header('Location: ./index.php?controller=article&action=showCreateForm');
        }
    }
}

function updateById($title, $content, $id){

    require_once('dbConnect.php');

    if ($pdoConn) {
        $query = "UPDATE article SET Titre='$title', Contenue='$content' WHERE id='$id'";

        
        $exec = $pdoConn->query($query);

        if ($exec) {
            header('Location: index.php?controller=article&action=single&n='.$id);
        } else {
            header('Location: index.php?controller=user&action=showUpdateForm');
        }
    }


}

function deleteById($id){
    require_once('dbConnect.php');

    if ($pdoConn) {

    $query = "DELETE FROM article WHERE article.id = $id";

    $exec = $pdoConn->query($query);

    if ($exec) {
        header('Location: index.php?controller=article&action=all');
    } else {
        // header('Location: index.php?controller=user&action=showUpdateForm');

    }
}

}