<?php
session_start();

if (isset($_SESSION) && isset($_SESSION["LoginError"])) {
    $registerErrors = $_SESSION["LoginError"];
}


?>


<form action="/index.php?controller=user&action=login" method="post">

    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email">

    </div>

    <div>
        <label for="password">Password :</label>
        <input type="password" name="password" id="password">
    </div>

    <?php if (isset($registerErrors)) { ?>
        <p> <?= $registerErrors["wrongCredentials"]; ?> </p>
    <?php } ?>


    <input type="submit" value="submit" id="submit">

    <p>Pas encore de compte? <a href="../inscription/inscription.php">Insccrivez vous!</a></p>
</form>