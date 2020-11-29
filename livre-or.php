<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Livre d\'Or';
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
            <h1>Livre d'Or</h1>
            <p>Tous les derniers commentaires</p>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>