<?php

// var_dump($results);

$articleId = $results['id'];
$articleTitle = $results['Titre'];
$articleContent = $results['Contenue'];
$articleDate = $results['created_at'];

?>

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
