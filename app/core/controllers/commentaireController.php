<?php

function allCommentForArticle(){
    require_once('./app/core/models/commentaireModel.php');
    $articleId = $_GET['n'];

    
    return getAllByIdArticle($articleId);
}


function newComment(){
    require_once('./app/core/models/commentaireModel.php');

    $articleId = intval(trim($_POST["id"]));

    $commentContent = htmlentities(trim($_POST["comment"]));

    $idUser = json_decode($_COOKIE["userInfo"], true)['id'];

    $errorArray = [];

    if (empty($articleId)) {
    $errorArray[''] = [];
        
    }

    if (!is_int($articleId)) {
        $errorArray[''] = [];
        
    }

    if (empty($commentContent)) {
        $errorArray[''] = [];
    }

    if (empty($errorArray)) {
        createComment(date("Y-m-d H:i:s"),$commentContent, $idUser, $articleId);
    }

}