<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Livre d\'Or';

    $stmt = "SELECT commentaires.commentaire, utilisateurs.login, commentaires.date
            FROM `commentaires` JOIN `utilisateurs` 
            WHERE utilisateurs.id = commentaires.id_utilisateur ORDER BY DATE DESC";

	if (! $result = $pdo->query($stmt) ) 
		$_SESSION['error'] = 'Les messages enregistrés ne peuvent pas être récupérés.';
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
            <p>Tous les derniers commentaires:</p>
            <?php
                // IF ERROR MSG
				if (isset($_SESSION['error'])) {
					echo '<p class="error">' . $_SESSION['error'] . '</p>';
					unset($_SESSION['error']);
				}
				// PRINT PREVIOUS MSG
				while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$orgDate = $row['date'];  
					$newDate = date("d-m-Y", strtotime($orgDate));  
					echo '<article class="commentaires">';
						echo '<h6>Posté le ' . $newDate . ' par ' . $row['login'] . ':</h6>';
						echo '<p>' . $row['commentaire'] . '</p>';
					echo '</article>';
				}	
            ?>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>