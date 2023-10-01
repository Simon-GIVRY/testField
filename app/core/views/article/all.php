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
        <div>
            <a href="./index.php?controller=article&action=single&n=<?= $value['id']?>">
                <div>

                <h2><?= $value["Titre"] ?></h2>
                <time> <?= $value["created_at"] ?> </time>
            
            </div>
            </a>
        </div>
        <?php
    }
?>
</section>

<div class="pageSelection">

<?php

for ($i= 1; $i <= $pageNumbers; $i++) { 
    ?>
    <span>
        <a href="index.php?controller=article&action=all&page=<?= $i ?>">
            <?= $i ?>
        </a>
    </span>
<?php
}
?>
</div>
</div>