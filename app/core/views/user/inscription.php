<?php
    session_start();

    if (isset($_SESSION) && isset($_SESSION["registerError"])) {
        $registerErrors = $_SESSION["registerError"];
    }


    ?>

    <form action="./index.php?controller=user&action=register" method="post">

        <div>
            <label for="username">Username :</label>
            <input type="text" name="username" id="username">
            <?php if (isset($registerErrors)) { ?>
                <p> <?= $registerErrors["usernameError"]; ?> </p>
            <?php } ?>
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email">
            <?php if (isset($registerErrors)) { ?>
                <p> <?= $registerErrors["emailError"]; ?> </p>
            <?php } ?>
        </div>

        <div class="passwordDiv">
            <label for="password">Password :</label>
            <input type="password" name="password" id="password">
            <?php if (isset($registerErrors)) { ?>
                <p> <?= $registerErrors["passwordError"]; ?> </p>
            <?php } ?>
        </div>

        <div class="confirmationPassword">
            <label for="confirmPassword">Confirm Password :</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
            <?php if (isset($registerErrors)) { ?>
                <p> <?= $registerErrors["confirmErrorPassword"]; ?> </p>
            <?php } ?>
        </div>

        <input type="submit" value="submit" id="submit">

    </form>

    <?php
    unset($registerErrors);

    session_destroy();
?>