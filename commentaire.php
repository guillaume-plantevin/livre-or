<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Commentaire';

    // DEBUG
    print_r_pre($_SESSION, '$_SESSION:');
    print_r_pre($_POST, '$_POST:');

    if (! isset($_SESSION['logged'])) {
		$_SESSION['error'] = 'Le fil de discussion n\'est visible que par les utilisateurs qui sont connectés.';
		header('Location: connexion.php');
		return;
	}


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
                ':date' => $timestamp = date('y-m-d H:i:s')
            ]);

            $_SESSION['success'] = 'Votre commentaire a été rajouté avec succès!';
            header('Location: commentaire.php');
            return;
        }
    }
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
                elseif (isset($_SESSION['success']) ) 
                {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
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