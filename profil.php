<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    controlData($_SESSION, '$_SESSION');
    $title = 'Profil';
    if ($_SESSION['logged'])
        $visible = false;
    else
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
            <h1>Page de Profil</h1>
            <p>Ici, vous pouvez changer votre identifiant et/ou votre mot de passe:</p>
            <form action="" method="post">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" value=<?=$_SESSION['login'];?>><br />
                
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" value=<?=$_SESSION['password'];?>><br />

                <input type="submit" id="submitButton" value="Valider">
            </form>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>