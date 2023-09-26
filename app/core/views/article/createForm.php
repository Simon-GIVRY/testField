<div>
<?php
if (isset($_COOKIE["connected"]) && $_COOKIE["connected"] === "1") {
    ?>

<form action="./index.php?controller=article&action=createArticle" method="POST">

    <div>
        <label for="title">Titre</label>
        <input type="text" name="title" id="title">
    </div>

    <div>
        <label for="content">Contenue</label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
    </div>

    <input type="submit" value="Créer" id="submit">

    
</form>
<?php
}
?>
</div>
