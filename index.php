<?php
    session_start();
    require_once('functions/functions.php');

    $title = 'Livre d\'Or: Acceuil';
?>
<!-- ===============  VIEW  ================== -->
<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class='container' id=indexMain>
            <h1>Livre d'or du mariage de Sarah & Mathias:<br />
                Bienvenue!
            </h1>
            <p>En souvenir de ce moment unique dans la vie de Sarah et Mathias - et aussi dans la notre - 
                nous avons décidé de créer ce site pour permettre à tous les participants de poster leurs souvenirs ou pensées.<br />
                Pour ça, il vous suffit de vous inscrire et de vous connecter.
            </p>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>