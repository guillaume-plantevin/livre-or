<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    // $maxLength = 255;

    // DEBUG
    var_dump_pre($_POST, '$_POST');

    // CANCEL -> goto deco, init $_SESSION
    if (isset($_POST['cancel'])) {
        header('Location: deconnexion.php');
    }

    if (isset($_POST['submit']))  {
        // NO LOGIN
        if (empty($_POST['login'])) {
            // if (verifyLength($_POST['login'], $maxLength))
            $_SESSION['error'] = 'Vous devez choisir un login.';
            header('Location: inscription.php');
            return;
        }
        // NO PASSWORD
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = 'Vous devez choisir un mot de passe.';
            header('Location: inscription.php');
            return;
        }
        // NO PASSWORD CONFIRM
        elseif (empty($_POST['passwordConfirm'])) {
            $_SESSION['error'] = 'Vous devez répéter votre mot de passe.';
            header('Location: inscription.php');
            return;
        }
        // DIFFERENT PASS & CONFIRM
        elseif ($_POST['password'] !== $_POST['passwordConfirm']) {
            $_SESSION['error'] = 'Votre mot de passe et sa confirmation ne sont pas similaires.';
            header('Location: inscription.php');
            return;
        }
        // EVERYTHING'S  OK
        else {
            $qry = "SELECT * FROM utilisateurs WHERE login = :login";
            // DEBUG query
            echo "<p>$qry</p>";

            $stmt = $pdo->prepare($qry);
            $stmt->execute( array( ':login' => htmlentities( $_POST['login'] ) ) );
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // DEBUG
            print_r_pre($row, '$row');

            // LOGIN ALREADY EXISTS
            if (!empty($row)) {
                $_SESSION['error'] = 'Votre login est déjà utilisé, Veuillez en choisir un autre.';
                header('Location: inscription.php');
                return;
            }
            // INSERT INTO DB
            else {
                $rgt = "INSERT INTO utilisateurs (login, password) VALUES (:login, :password)";
                
                // DEBUG
                echo "<pre>\n" . $rgt . "</pre>";
    
                // sanitizing input query
                $stmt = $pdo->prepare($rgt);
    
                $stmt->execute([
                    ':login' => htmlentities($_POST['login']), 
                    ':password' => password_hash( htmlentities( $_POST['password']), PASSWORD_DEFAULT)
                ]);
                // GOTO
                header('Location: connexion.php');
                return;
            }
        }
    }
    $title = 'Inscription';
    // $visible = true;
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
                if (isset($rows))
                    print_r_pre($rows, 'in DB: users');
                if ($_SESSION)
                    print_r_pre($_SESSION, '$_SESSION:<br>');
            ?>

        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>