<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Livre d\'Or';
    // if ($_SESSION['logged'])
    //     $visible = false;
    // else
    //     $visible = true;
    /*
        PSEUDO-CODE:
        -Aller chercher tous les commentaires déjà enregistré
        -si aucunmessage:
            créer un message pour la situation où il n'y a aucun message
                "ce site est nouveau, etc, n'hétisez pas à rajouter un commentaire pour le remplir
        -afficher tous les messages du plus récent au plus ancien
        -mettre dans la première ligne la date et l'auteur
            -> FAIRE UN JOIN TABLES pour récupérer le nom de l'auteur du post
            
    /*
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class='container'>
            <h1>Livre d'Or</h1>
            <p>Tous les derniers commentaires</p>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>