<?php
    session_start();
    session_destroy();
    // ABOVE: might be DEBUG

    require_once('functions/functions.php');
    $title = 'Livre d\'Or: Acceuil';
    // $visible = true;

?>
<!-- ===============  VIEW  ================== -->
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class='container'>
            <h1>Livre d'or du mariage de Sarah & Mathias</h1>
            <h3>Bienvenue!</h3>
            <p>Des trucs et des bidules</p>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>