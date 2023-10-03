<?php
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
    <?php

    if (isset($_COOKIE["connected"]) && $_COOKIE["connected"] === "1") {
        ?>
        <div class="yourComment">
            <h2>Laisser un commentaire</h2>
            
            <form action="index.php?controller=commentaire&action=newComment" method="post">
            
                <input type="hidden" name="id" value="<?= $articleId ?>">  
        
                <div>
                    <label for="comment">Votre commentaire</label>
                    <textarea name="comment" id="" cols="30" rows="10"></textarea>
                </div>

                <input type="submit" value="Envoyer">
            </form>

        </div>


        <?php
    }else{
        ?>
            <a href="" title="Connexion">Connecter vous pour laisser un commentaire</a>
        <?php
    }



    if (isset($comments) && !empty($comments)) {
        ?>
        <div class="commentContainer">

            <?php
            foreach ($comments as $value) {
            ?>
            <div class="singleComment">

                <div>
                    <div class="commentMeta">
                        <p class="username"><?= $value['username'] ?></p>
                        <time><?= $value['created_at'] ?></time>
                    </div>

                    <div class="commentAction">
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
                </div>

                <p class="content">
                    <?= $value['contenue'] ?>
                </p>

            </div>
            <?php
        }
        ?>
        </div>
        <?php
    }
    
    ?>

   

</section>
