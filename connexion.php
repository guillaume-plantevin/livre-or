<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    if (isset($_POST['cancel'])) {
        // Redirect the browser to deconnexion.php
        header("Location: deconnexion.php");
        return;
    }
    // DEBUG
    // print_r_pre($_POST, '$_POST');

    // FORM POST SEND
    if (isset($_POST['submit'])) {
        if (empty($_POST['login'])) {
            // if (verifyLength($_POST['login'], $maxLength))
            $_SESSION['error'] = 'Vous devez rentrer votre login pour vous connecter.';
            header('Location: connexion.php');
            return;
        }
        // NO PASSWORD
        elseif (empty($_POST['password'])) {
            $_SESSION['error'] = 'Vous devez rentrer votre mot de passe pour vous connecter.';
            header('Location: connexion.php');
            return;
        }
        if ( isset($_POST['login']) && isset($_POST['password']) ) {

            $sql = "SELECT * FROM utilisateurs WHERE login = :login";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([':login' => $_POST['login']]);
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // DEBUG
            print_r_pre($row, '$row');

            if (empty($row)) {
                $_SESSION['error'] = 'Ce Login n\'existe pas dans notre base de donnée.';
                header('Location: connexion.php');
                return;
            }
            else { 
                // NOT THE SAME PASSWORD
                if (!password_verify($_POST['password'], $row['password'])) {
                    $_SESSION['error'] = 'Votre mot de passe n\'est pas similaire à celui enregistré lors de votre inscription.';
                    header('Location: connexion.php');
                    return;
                }
                // OK
                // faire le tour des infos de l'utilisateur dans la DB et les copier dans $_SESSION
                foreach($row as $k => $v) {
                    $_SESSION[$k] = $v;
                }
                // BOOL LOGGED
                $_SESSION['logged'] = TRUE;
                // CHARGING PASSWORD, NOT THE HASH
                $_SESSION['password'] = htmlentities($_POST['password']);

                // GOTO
                header('location: profil.php');
                return;
            }
        }
    }
    // DEBUG
    // if (isset($_SESSION))
    //     print_r_pre($_SESSION, '$_SESSION');
    // if (isset($row))
    //     print_r_pre($row, '$row');
    // $visible = true;
    $title = 'Connexion';
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class='container'>
            <h1>Connexion</h1>
            <?php 
                if ( isset($_SESSION['success']) ) 
                {
                    echo '<p class="success">' . $_SESSION['success'] . '</p>';
                    unset($_SESSION['success']);
                }
                if ( isset($_SESSION['error']) ) 
                {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
            ?>
                    <p>Pour vous connecter, il vous suffit de rentrer votre identifiant et votre mot de passe:</p>
                    <form action="" method="post">
                        <label for="login">Login:</label>
                        <input type="text" name="login" id="login" /><br />
                        
                        <label for="password">Mot de passe:</label>
                        <input type="password" name="password" id="password" /><br />

                        <input type="submit" id="submitButton" name="submit" value="Valider" />
                        <input type='submit' name='cancel' value='annuler' />
                    </form>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>