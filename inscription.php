<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    if (isset($_POST['cancel'])) {
        // Redirect the browser to deconnexion.php who destroy the session and redirect to index.php
        header("Location: deconnexion.php");
        return;
    }
    // DEBUG
    // $_SESSION['error'] = "Connerie de merde.";
    print_r_pre($_SESSION, '$_SESSION');
    
    if ( isset($_POST['submit']) ) {
        if (empty($_POST['login'])) {
            $_SESSION['error'] = "Attention: Vous devez rentrer un login pour vous inscrire.";
            header('location: inscription.php');
            return;
        }
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = "Attention: Vous devez rentrer un mot de passe pour vous inscrire.";
            header('location: inscription.php');
            return;
        }
        elseif (empty($_POST['passwordConfirm'])) {
            $_SESSION['error'] = "Attention: Vous devez rentrer une deuxième fois votre mot de passe pour vous inscrire.";
            header('location: inscription.php');
            return;
        }
        else if ($_POST['password'] !== $_POST['passwordConfirm']) {
            $_SESSION['error'] = "Attention: vous devez répéter le même mot de passe dans la case \"confirmation\".";
            header('location: inscription.php');
            return;
        }
        else {
            // Vérifier si le login existe déjà
            $sql = "SELECT login FROM utilisateurs WHERE login = :login";

            // DEBUG query
            echo "<p>$sql</p>\n";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':login' => $_POST['login']]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // login already in DB
            if ( $_POST['login'] === $row['login'] ) {
                $_SESSION['error'] = "Attention: Le login existe déjà. Merci d'en choisir un autre.";
                header('Location: inscription.php');
            }
            // new login => nouvel user
            else {
                echo '<p>tout c\'est bien passé et normalement un nouvel utilisateur est ajoutee à la DB</p>';
                $sql = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                
                // DEBUG
                print_r_pre($sql, '$sql');
    
                // sanitizing input query
                $stmt = $pdo->prepare($sql);
    
                $stmt->execute([
                    ':login' => htmlentities($_POST['login']), 
                    ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ]);
                // $_SESSION['login'] = $_POST['login'];
                // $_SESSION['password'] = $_POST['password'];
                // $_SESSION['passwordConfirm'] = $_POST['passwordConfirm'];

                // GOTO connexion.php
                header('location: connexion.php');
            }
        }
    }
    // DEBUG
    $stmt = $pdo->query("SELECT * FROM utilisateurs");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
        <main class='container'>
            <h1>Inscription</h1>
            <p>Pour vous inscrire, il vous suffit de rentrer un identifiant, un mot de passe et sa confirmation:</p>
            <?php 
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
            ?>

            <form action="inscription.php" method="POST">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" /><br />

                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" /><br />

                <label for="passwordConfirm">Confirmation du mot de passe:</label>
                <input type="password" name="passwordConfirm" /><br />

                <input type="submit" id="submitButton" name="submit" value="Inscription" />
                <input type='submit' name='cancel' value='annuler' />
            </form>
            <?php 
                // DEBUG
                print_r_pre($rows, 'in DB: users');
                print_r_pre($_SESSION, '$_SESSION:<br>');
            ?>

        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>