<?php

function all()
{
    require_once('./app/core/models/articleModel.php');

    if (isset($_GET['page'])) {
        $offset = $_GET['page'];
    }else{
        $offset = 1;
    }

    $results = findAll($offset);
    
    $pageNumbers = pageNumbers();
    $pageNumbers = $pageNumbers["COUNT(*)"]/5;

    require_once('./app/core/views/article/all.php');
}

function single()
{
    require_once('./app/core/models/articleModel.php');
    require_once('commentaireController.php');

    $comments = allCommentForArticle();

    $results = findBy($_GET["n"]);
    $userId = json_decode($_COOKIE["userInfo"], true)["id"];
    $articleId = $results['id'];
    $articleTitle = $results['Titre'];
    $articleContent = $results['Contenue'];
    $articleDate = $results['created_at'];

    require_once('./app/core/views/article/single.php');
}

function showCreateForm(){
    require_once('./app/core/views/article/createForm.php');
}

function createArticle(){
    require_once('./app/core/models/articleModel.php');

    $title = htmlentities(trim($_POST["title"]));
    $content =nl2br(htmlentities(trim($_POST["content"])));

    $errorArray = ["title"=>"","content"=>""];

    if (empty($title)) {
        $titleError = "Le champ doit etre remplie";
    }

    if (strlen($title) > 250) {
        $titleError = "Le titre ne doit pas dépasser 100 charactères";
    }

    if (isset($titleError)) {
        $errorArray["title"] = $titleError;
    }

    if (empty($content)) {
        $contentError = "Le champ doit etre remplie";
    }

    if (isset($contentError)) {
        $errorArray["content"] = $contentError;
    }
    $user = json_decode($_COOKIE["userInfo"], true);

    if (!isset($titleError) && !isset($contentError)) {
        create($title, $content, date("Y-m-d H:i:s"), json_decode($_COOKIE["userInfo"], true)["id"]);
    }
}

function showUpdateForm(){
    require_once('./app/core/models/articleModel.php');
    $articleInfo = findBy($_POST['id']);
    
    require_once('./app/core/views/article/updateForm.php');
}

function update(){
    require_once('./app/core/models/articleModel.php');

    $errorArray = [];
    
    $id = $_POST['id'];
    $title = htmlentities(trim($_POST['title']));
    $content = htmlentities(trim($_POST['content']));

    if (empty($title)) {
        $titleError = "Le champ doit etre remplie";
    }

    if (strlen($title) > 250) {
        $titleError = "Le titre ne doit pas dépasser 100 charactères";
    }

    if (isset($titleError)) {
        $errorArray["title"] = $titleError;
    }

    if (empty($content)) {
        $contentError = "Le champ doit etre remplie";
    }

    if (isset($contentError)) {
        $errorArray["content"] = $contentError;
    }

    if (!isset($titleError) && !isset($contentError)) {
        updateById($title, $content, $id);
    }
}

function delete(){
    require_once('./app/core/models/articleModel.php');

    $articleId = intval($_POST['id']);

    if (is_int($articleId)) {
        deleteById($articleId);
    }
    else {
        header('Location: index.php?controller=article&action=all');
    }
}