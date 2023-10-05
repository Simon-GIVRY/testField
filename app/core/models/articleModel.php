<?php

/**
 * Gets all article
 *
 * @param integer $offset
 * @return void
 */
function findAll(int $offset)
{
    require_once('dbConnect.php');

    if ($pdoConn) {
        $offset = ($offset-1)*5;

        $all = $pdoConn->prepare("SELECT * FROM article ORDER BY created_at desc LIMIT :offset, 5"); 

        $all->bindParam(":offset", $offset, PDO::PARAM_INT);

        $exec = $all->execute();

        if ($exec) {
            $results = $all->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            $results = false;
        }
        return $results;
    }
}

/**
 * Gets the number of article stored in database
 *
 * @return PDOStatement
 */
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

/**
 * Gets a specific article using Id
 *
 * @param integer $id
 * @return PDOStatement|false
 */
function findBy(int $id){
    require('dbConnect.php');
   
    if(isset($pdoConn)){
        $find = $pdoConn->prepare("SELECT article.id, article.Titre, article.Contenue, article.created_at, article.id_user ,users.username FROM article INNER JOIN users ON article.id_user = users.ID WHERE article.id = :id");
        
        $find->bindParam(':id', $id, PDO::PARAM_INT);

        $exec = $find->execute();

        if($exec){
            $result = $find->fetch(PDO::FETCH_ASSOC);
        }
        else{
            $result = false;
        }
    }
    return $result;
}

/**
 * Creates a new article
 *
 * @param string $title
 * @param string $content
 * @param string $created_at
 * @param integer $idUser
 * @return bool
 */
function create(string $title,string $content,string $created_at,int $idUser){
    require_once('dbConnect.php');

    if ($pdoConn) {
        $create = $pdoConn->prepare("INSERT INTO article (Titre, Contenue, created_at, id_user) VALUES (:title, :content, :created_at, :idUser)");

        $create->bindParam(":title", $title, PDO::PARAM_STR);
        $create->bindParam(":content", $content,PDO::PARAM_STR);
        $create->bindParam(":created_at", $created_at,PDO::PARAM_STR);
        $create->bindParam(":idUser", $idUser,PDO::PARAM_INT);

        $exec = $create->execute();

        if($exec){
            $result = true;
        }
        else{
            $result = false;
        }

        return $result;
    }
}

/**
 * Update article using ID
 *
 * @param string $title
 * @param string $content
 * @param integer $id
 * @return bool
 */
function updateById(string $title,string $content,int $id){
    require_once('dbConnect.php');

    if ($pdoConn) {
        $update = $pdoConn->prepare("UPDATE article SET Titre=:title, Contenue=:content WHERE id=:id");

        $update->bindParam(":title", $title, PDO::PARAM_STR);
        $update->bindParam(":content", $content, PDO::PARAM_STR);
        $update->bindParam(":id", $id,  PDO::PARAM_INT);

        $exec = $update->execute();
        
        if ($exec) {
            $result = true;
        } else {
            $result = false;
        }

        return  $result;
    }
}

/**
 * Deletes article using Id
 *
 * @param integer $id
 * @return bool
 */
function deleteById(int $id){
    require_once('dbConnect.php');

    if ($pdoConn) {
        $delete = $pdoConn->prepare("DELETE FROM article WHERE article.id = :id");
        $delete->bindParam(":id", $id, PDO::PARAM_INT);
        $exec = $delete->execute();

    if ($exec) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}
}