<?php

// var_dump($results);

$userId = json_decode($_COOKIE["userInfo"], true)['id'];
$articleId = $results['id'];
$articleTitle = $results['Titre'];
$articleContent = $results['Contenue'];
$articleDate = $results['created_at'];

?>
<div class="panel">
    <a href="index.php?controller=article&action=all"><- Retour aux articles</a>

    <?php

    if ($results['id_user'] == $userId) {
        ?>
        <div class="action">
            <form action="index.php?controller=article&action=showUpdateForm" method="post">
                <input type="hidden" name="id" value="<?=$_GET['n']?>">
                <input type="submit" value="Modifier Article">
            </form>
    
            <form action="index.php?controller=article&action=delete" method="post">
                <input type="hidden" name="id" value="<?=$_GET['n']?>">
                <input type="submit" value="Supprimer Article">
            </form>
        </div>
        <?php
    }

    ?>  


</div>

<section class="article">

    <div class="meta">
        <h1><?= $articleTitle?></h1>
        <time><?= $articleDate ?></time>
    </div>

    <p>
        <?= $articleContent ?>
    </p>

</section>


<section class="comments">

</section>
