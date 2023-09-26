<div>

<?php 
if (isset($_COOKIE["connected"]) && $_COOKIE["connected"] === "1") {
    ?>
    <div class="createArticle">
        <a href="./index.php?controller=article&action=showCreateForm">Créer un nouvel article</a>
    </div>
    <?php
}
?>
<section class="articleList">

<?php
    foreach ($results as $value) {
        ?>
        <a href="./index.php?controller=article&action=single&n=<?= $value['id']?>">
            <h2><?= $value["Titre"] ?></h2>
            <time> <?= $value["created_at"] ?> </time>
        </a>
        <?php
    }
?>
</section>

</div>