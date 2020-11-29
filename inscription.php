<?php
    require_once('functions/functions.php');
    $title = 'Inscription';
    $visible = true;
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main>
            <h1>Inscription</h1>
            <p>Pour vous inscrire il vous suffit de rentrer un identifiant, un mot de passe et sa confirmation:</p>

            <form action="inscription.php" method="POST">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" required><br />

                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" required><br />

                <label for="passwordConfirm">Confirmation du mot de passe:</label>
                <input type="password" name="passwordConfirm" required><br />

                <input type="submit" id="submitButton" name="submit" value="Inscription">
            </form>

        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>