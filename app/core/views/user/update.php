<?php
    $userInfo =json_decode($_COOKIE["userInfo"], true);

    session_start();
    var_dump($_SESSION["UpdateErrors"]);
    $updateErrors = $_SESSION["UpdateErrors"];
?>

<div>
    <a href="./index.php?controller=user&action=deconnexion">Se déconnecter</a>
</div>

<div>
    <form action="./index.php?controller=user&action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $userInfo['id']?>">

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= $userInfo['username']?>">
            <?php
                if (isset($updateErrors) && !empty($updateErrors["usernameError"])) {
                    echo $updateErrors["usernameError"];
                }
            ?>
        </div>

        <div>
            <label for="profilePicture">Profile Picture</label>
            <input type="file" name="profilePicture" id="profilePicture" >
        </div>

        <input type="submit" value="Modifier">

        <a href="">Modifier mot de passe</a>
    </form>
</div>