<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    // IF form send
    if (isset($_POST['submit'])) {
        // IF login & password set
        if ( isset($_POST['login']) && isset($_POST['password'])  ) {

            $sql = "SELECT id, login, password FROM utilisateurs WHERE login = :log AND password = :pw";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(array(
                ':log' => $_POST['login'], 
                ':pw' => $_POST['password']));
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (isset($row))
                controlData($row, '$row');

            if ( !$row )
                $errorMsg = 'Votre compte n\'existe pas ou vous avez fait une erreur dans la saisie de vos identifiants.';
            else { 
                // faire le tour des infos de l'utilisateur dans la DB et les copier dans $_SESSION
                foreach($row as $k=>$v) {
                    $_SESSION[$k] = $v;
                }
                // creer une variable pour savoir si un utilisateur est logged-in
                $_SESSION['logged'] = true;
                header('location: profil.php');
            }
        }
    }
    if (isset($_SESSION))
        controlData($_SESSION, '$_SESSION');
    if (isset($row))
        controlData($row, '$row');

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
        <main>
            <h1>Connexion</h1>
            <?php 
                if (isset($errorMsg)):
                    echo '<p class="error">' . $errorMsg . '</p>';
            ?>
                <p>Retourner sur <a href="connexion.php">connexion</a></p>
            <?php
                else: 
            ?>
                <p>Pour vous connecter, il vous suffit de rentrer votre identifiant et votre mot de passe:</p>
                <form action="" method="post">
                    <label for="login">Login:</label>
                    <input type="text" name="login" id="login"><br />
                    
                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" id="password"><br />

                    <input type="submit" id="submitButton" name="submit" value="Valider">
                </form>
            <?php
                endif;
            ?>

        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>