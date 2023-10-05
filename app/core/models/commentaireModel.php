<?php
function getAllByIdArticle($idArticle)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $query = "SELECT username, created_at, contenue, id_article FROM commentaire INNER JOIN users ON commentaire.id_user = users.id WHERE id_article = $idArticle ORDER BY commentaire.created_at DESC";

        $execution = $pdoConn->query($query);

        $article = $execution->fetchAll(PDO::FETCH_ASSOC);
        
        if($execution){
        $result = $article;
        }
        else{
            $result = false;
        }
        return $result;

    }
}


function createComment($createdAt, $content, $idUser, $idArticle)
{
    require_once('dbConnect.php');

    if ($pdoConn) {

        $query = "INSERT INTO commentaire (created_at, contenue, id_user, id_article) VALUE ('$createdAt', '$content', '$idUser', '$idArticle')";

        $execution = $pdoConn->query($query);
        
        if($execution){
            header('Location: ./index.php?controller=article&action=single&n='.$idArticle);
        }

        else{
            header('Location: ./index.php?controller=article&action=showCreateForm');
        }

    }
}

