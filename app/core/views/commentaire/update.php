
<div class="panel">
    <a href="index.php?controller=article&action=single&n=<?= $_POST['id']?>"><- Retour aux articles</a>
</div>

<div>
    <form action="./index.php?controller=article&action=update" method="POST">
        <input type="hidden" name="id" value="<?= $articleInfo['id']?>">

        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= $articleInfo['Titre']?>">
            <?php
                if (isset($updateErrors) && !empty($updateErrors["titleError"])) {
                    echo $updateErrors["titleError"];
                }
            ?>
        </div>

        <div>
            <label for="content">Contenue d'article</label>
            <textarea name="content" id="content" cols="30" rows="10"><?= $articleInfo["Contenue"] ?></textarea>
        </div>

        <input type="submit" value="Modifier">

        <a href="">Modifier mot de passe</a>
    </form>
</div>