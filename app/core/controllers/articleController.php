<?php

/**
 * Gets all article
 *
 * @return void
 */
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

/**
 * gets a single article
 *
 * @return void
 */
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

/**
 * requires article create form
 *
 * @return void
 */
function showCreateForm(){
    require_once('./app/core/views/article/createForm.php');
}

/**
 * Creates a new article
 *
 * @return void
 */
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
        $resultQuery = create($title, $content, date("Y-m-d H:i:s"), json_decode($_COOKIE["userInfo"], true)["id"]);

        if ($resultQuery) {
            header('Location: ./index.php?controller=article&action=all');
            
        }
        else{
            header('Location: ./index.php?controller=article&action=showCreateForm');

        }
    }
}

/**
 * requires update form for articles
 *
 * @return void
 */
function showUpdateForm(){
    require_once('./app/core/models/articleModel.php');
    $articleInfo = findBy($_POST['id']);
    
    require_once('./app/core/views/article/updateForm.php');
}

/**
 * Updates an article
 *
 * @return void
 */
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
        $resultQuery = updateById($title, $content, $id);

        if ($resultQuery) {
            header('Location: index.php?controller=article&action=single&n='.$id);
        }
        else {
            header('Location: index.php?controller=user&action=showUpdateForm');
        }
    }
}

/**
 * Deletes an article
 *
 * @return void
 */
function delete(){
    require_once('./app/core/models/articleModel.php');

    $articleId = intval($_POST['id']);

    if (is_int($articleId)) {
        $resultQuery = deleteById($articleId);
        if ($resultQuery) {
            header('Location: index.php?controller=article&action=all');
        }
        else{
            header('Location: index.php?controller=user&action=showUpdateForm');
        }
    }
    else {
        header('Location: index.php?controller=article&action=all');
    }
}