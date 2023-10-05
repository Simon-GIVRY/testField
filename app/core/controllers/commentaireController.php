<?php

/**
 * Will get all comments from a comment by using the article ID
 *
 * @return void
 */
function allCommentForArticle(){
    require_once('./app/core/models/commentaireModel.php');
    $articleId = $_GET['n'];
    
    return getAllByIdArticle($articleId);
}

/**
 * Creates a new comment
 *
 * @return void
 */
function newComment(){
    require_once('./app/core/models/commentaireModel.php');

    $errorArray = ['emptyId'=> '','wrondIdType' => '','emptyComment'=> ''];

    $articleId = intval(trim($_POST["id"]));

    $commentContent = htmlentities(trim($_POST["comment"]));

    $idUser = json_decode($_COOKIE["userInfo"], true)['id'];

    $errorArray = [];

    if (empty($articleId)) {
        $errorArray['emptyId'] = "L'id n'est pas valide";
    }

    if (!is_int($articleId)) {
        $errorArray['wrondIdType'] = "L'id n'est pas valide";
    }

    if (empty($commentContent)) {
        $errorArray['emptyComment'] = 'Le champ commentaire est vide.';
    }

    if (empty($errorArray)) {
        createComment(date("Y-m-d H:i:s"),$commentContent, $idUser, $articleId);
    }
    else{
        header('Location: ./index.php?controller=article&action=single&n='.$_POST["id"]);
        session_start();
        $_SESSION['CommentErrors'] = $errorArray;
        // gerer erreurs
    }

}