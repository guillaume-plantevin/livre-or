<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Commentaire';
    if ($_SESSION['logged'])
        $visible = false;
    else
        $visible = true;
    $errorMsg = 'Vous devez etre connecter pour pouvoir rajouter un commentaire'
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class='container'>
            <h1>Commentaires</h1>
            <p>Si vous voulez rajouter un commentaire, si vous suffit de l'écrire et de le valider:</p>
            <p class="note">Note: vous pouvez en rajouter autant que vous le souhaitez.</p>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>