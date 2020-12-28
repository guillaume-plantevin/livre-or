<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    if (isset($_POST['cancel'])) {
        // Redirect the browser to index.php
        header("Location: index.php");
        return;
    }
    // IF form send
    if (isset($_POST['submit'])) {
        // IF login & password set
        if ( isset($_POST['login']) && isset($_POST['password']) ) {

            $sql = "SELECT * FROM utilisateurs WHERE login = :log";

            $stmt = $pdo->prepare($sql);

            // $stmt->execute([':log' => $_POST['login'], 
            //     ':pw' => $_POST['password']
            // ]);
            $stmt->execute([':log' => $_POST['login']]);
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // synthaxe merdique , à revoir
            if (isset($row)) {
                // DEBUG
                print_r_pre($row, '$row');

                if (!password_verify($_POST['password'], $row['password'])) {
                    $_SESSION['error'] = 'Votre mot de passe n\'est pas similaire à celui enregistré.';
                    header('Location: connexion.php');
                    return;
                }
            }
            elseif ( !$row ) {
                $_SESSION['error'] = 'Votre compte n\'existe pas ou vous avez fait une erreur dans la saisie de votre identifiant.';
                header('Location: connexion.php');
                return;
            }
            else { 
                // faire le tour des infos de l'utilisateur dans la DB et les copier dans $_SESSION
                foreach($row as $k => $v) {
                    $_SESSION[$k] = $v;
                }
                // creer une variable pour savoir si un utilisateur est logged-in
                $_SESSION['logged'] = TRUE;

                header('Location: connexion.php');
                return;
                // header('location: profil.php');
            }
        }
    }
    // DEBUG
    if (isset($_SESSION))
        print_r_pre($_SESSION, '$_SESSION');
    if (isset($row))
        print_r_pre($row, '$row');

    $title = 'Connexion';
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
            <h1>Connexion</h1>
            <?php 
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                    echo '<p>Retourner sur <a href="connexion.php">connexion</a></p>';
                }
            ?>
            <?php
                else {
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
            <?php
                }
            ?>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>