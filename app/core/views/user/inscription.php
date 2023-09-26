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
        <p> 
            <?php if (isset($registerErrors)) {
                echo $registerErrors["usernameError"];
            } ?> 
        </p>
    </div>

    <div>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email">
        <p> 
            <?php if (isset($registerErrors)) {
                echo $registerErrors["emailError"];
            } ?> 
        </p>
    </div>

    <div class="passwordDiv">
        <label for="password">Password :</label>
        <input type="password" name="password" id="password">
        <p> 
            <?php if (isset($registerErrors)) {
                echo $registerErrors["passwordError"];
            } ?> 
        </p>
    </div>

    <div class="confirmationPassword">
        <label for="confirmPassword">Confirm Password :</label>
        <input type="password" name="confirmPassword" id="confirmPassword">
        <p> 
            <?php if (isset($registerErrors)) {
                echo $registerErrors["confirmErrorPassword"];
            } ?> 
        </p>
    </div>

    <input type="submit" value="submit" id="submit">

</form>

<?php
unset($registerErrors);

session_destroy();
?>