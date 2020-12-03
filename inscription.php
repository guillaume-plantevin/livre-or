<?php
    require_once('pdo.php');
    require_once('functions/functions.php');
    // Si on vient d'une des pages
    if ( !isset($_POST)) 
        unset($_SESSION);

    if ( isset($_POST['submit']) ) {
        // les deux mdp sont similaires
        if ( isset($_POST['password']) && ($_POST['password'] === $_POST['passwordConfirm']) ) {

            // Vérifier si le login existe déjà
            $sql = "SELECT login FROM utilisateurs WHERE login = :login";
            // DEBUG query
            echo "<p>$sql</p>\n";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':login' => $_POST['login']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // le login est déjà enregistré dans la DB
            if ( $_POST['login'] === $row['login'] ) {
                $errorMsg = "Attention: Le login existe déjà. Merci d'en choisir un autre.";
            }
            // nouveau login => nouvel utilisateur
            else {
                $sql = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                
                // DEBUG
                echo("<pre>\n" . $sql . "\n</pre>\n");
    
                // sanitizing input query
                $stmt = $pdo->prepare($sql);
    
                $stmt->execute( array(
                    ':login' => $_POST['login'], 
                    ':password' => $_POST['password']));
                // GOTO connexion.php
                header('location: connexion.php');
            }
        }
        // les mdp sont différents
        else {
            $errorMsg = "Attention: Votre mot de passe et sa confirmation ne sont pas similaires.";
        }
    }

    $stmt = $pdo->query("SELECT * FROM utilisateurs");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    controlData($rows, 'in DB: users');



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
            <?php 
                if (isset($errorMsg)):
                    echo '<p class="error">' . $errorMsg . '</p>';
                else: 
            ?>
                <p>Pour vous inscrire il vous suffit de rentrer un identifiant, un mot de passe et sa confirmation:</p>

                <form action="" method="POST">
                    <label for="login">Login:</label>
                    <input type="text" name="login" id="login" required><br />

                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password" required><br />

                    <label for="passwordConfirm">Confirmation du mot de passe:</label>
                    <input type="password" name="passwordConfirm" required><br />

                    <input type="submit" id="submitButton" name="submit" value="Inscription">
                </form>
            <?php 
                endif;
            ?>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>