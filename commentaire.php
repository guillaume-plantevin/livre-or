<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Commentaire';

    print_r_pre($_SESSION, '$_SESSION:');
    print_r_pre($_POST, '$_POST:');
    if (isset($_POST['submit'])) {
        if (empty($_POST['comm'])) {
            $_SESSION['error'] = 'Vous ne pouvez pas sauvegarder un commentaire vide.';
            header('Location: commentaire.php');
            return;
        }
        else {
            $sql = "INSERT INTO commentaires 
                    (commentaire, id_utilisateur, date) 
                    VALUES 
                    (:commentaire, :id_utilisateur, :date)";
            var_dump_pre($sql, '$sql');
    
            // sanitizing input query
            $stmt = $pdo->prepare($sql);


            // PAS FINI!!!!
            $stmt->execute([
                ':commentaire' => htmlentities($_POST['comm']), 
                ':id_utilisateur' => $_SESSION['id'],
                ':date' => //TODO
            ]);

            $_SESSION['success'] = 'Votre a été rajouté avec succès!';
            header('Location: commentaire.php');
            return;
        }
    }
    /*
        PSEUDO-CODE:
        si le texte est vide
            l'utilisateur ne peut pas sauvegarder le commentaire
            lui envoyer un message lui disant qu'il ne pouvait pas laisser un commentaire vide
        sinon
            nettoyer le message - si besoin est
            faire une insertion dans table commentaires
            avec les $_SESSION POUR utiliser l'id de l'utilisateur
            faire une requete avec pdo et preparation de la requete
            envoyer
            mettre un message $_SESSION['success'] pour informer l'utilisateur que son message a été enregistré.
    */
    // $_SESSION['error'] = 'Vous devez etre connecter pour pouvoir rajouter un commentaire'
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

            <?php 
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                elseif ( isset($_SESSION['success']) ) 
                {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
                    // echo '<p>Retourner sur <a href="connexion.php">connexion</a></p>';
                }
            ?>
            <form action="" method="POST">
                <label for="commentary" class='block'>Votre commentaire:</label>
                    <textarea name="comm" id="commentary" cols="50" rows="10"></textarea>
                <br />
                <input class='button' type="submit" name='submit' value="enregistrer">
            </form>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>