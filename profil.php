<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    controlData($_SESSION, '$_SESSION');
    $title = 'Profil';

    // IF form send
    if (isset($_POST['submit'])) {
        // IF login & password set
        if ( isset($_POST['login']) && isset($_POST['password'])  ) {

            $sql = "UPDATE utilisateurs SET login = ?, password = ? WHERE utilisateurs.id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(array(
                ':log' => $_POST['login'], 
                ':pw' => $_POST['password'],
                ':id' => $_SESSION['id']));
            
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
    if ($_SESSION['logged'])
        $visible = false;
    else
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
            <h1>Page de Profil</h1>
            <p>Ici, vous pouvez changer votre identifiant - s'il est disponible - et/ou votre mot de passe:</p>
            <form action="" method="post">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" value=<?=$_SESSION['login'];?>><br />
                
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" value=<?=$_SESSION['password'];?>><br />

                <input type="submit" id="submitButton" value="Valider">
            </form>


        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>