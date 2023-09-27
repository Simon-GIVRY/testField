<?php

function all()
{
    require_once('./app/core/models/articleModel.php');
    $results = findAll();
    require_once('./app/core/views/article/all.php');
}

function single()
{
    require_once('./app/core/models/articleModel.php');
    $results = findBy($_GET["n"]);

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

    if (!isset($titleError) && !isset($contentError)) {
        create($title, $content, date("Y-m-d H:i:s"), json_decode($_COOKIE["userInfo"], true)["id"]);
    }
}