<?php
    session_start();

    require_once('pdo.php');
    require_once('functions/functions.php');

    $title = 'Profil';

    // DEBUG
    print_r_pre($_SESSION, '$_SESSION:');
    print_r_pre($_POST, '$_POST:');

    // var_dump_pre($_POST['login'], '$_POST[login]: ');
    // var_dump_pre(trim($_POST['login']), 'trim($_POST[login]): ');
    // var_dump_pre($_SESSION['login'], '$_SESSION[login]: ');
    // var_dump_pre(trim($_SESSION['login']), 'trim($_SESSION[login]): ');

    // IF form send
    if (isset($_POST['submit'])) {
        // IF login & password set
        // if ( isset($_POST['login']) && isset($_POST['password'])  ) {
            var_dump_pre($_POST['login'], '$_POST[login]');
            var_dump_pre($_SESSION['login'], '$_SESSION[login]');

            // VERIFYING AVAILABILITY OF NEW LOGIN
            if ($_POST['login'] !== $_SESSION['login']) {
                // DEBUG
                echo 'different loggin';

                $verify = "SELECT * FROM utilisateurs WHERE login = :login";
                $stmt = $pdo->prepare($verify);
                $stmt->execute([':login' => htmlentities($_POST['login'])]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!empty($row)) {
                    if ($_SESSION['id'] !== $row['id']) {
                        $_SESSION['error'] = 'Votre nouveau login est déjà utilisée, veuillez en choisir un autre.';
                        header('Location: profil.php');
                        return;
                    }
                }
            }
            // OK => UPDATE PROFIL
            else {
                $sql = "UPDATE utilisateurs SET login = ?, password = ? WHERE utilisateurs.id = :id";
    
                $stmt = $pdo->prepare($sql);
    
                $stmt->execute(array(
                    ':log' => htmlentities($_POST['login']), 
                    ':pw' => htmlentities($_POST['password']),
                    ':id' => $_SESSION['id']));
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

            }
            if (isset($row))
                // DEBUG
                print_r_pre($row, '$row:');

            if ( !$row )
                $_SESSION['error'] = 'Votre compte n\'existe pas ou vous avez fait une erreur dans la saisie de vos identifiants.';
            else { 
                // faire le tour des infos de l'utilisateur dans la DB et les copier dans $_SESSION
                foreach($row as $k=>$v) {
                    $_SESSION[$k] = $v;
                }
                // creer une variable pour savoir si un utilisateur est logged-in
                $_SESSION['logged'] = true;
                header('location: profil.php');
            }
        // }
    }
    // if (isset($_SESSION))
        // print_r_pre($_SESSION, '$_SESSION');
    // if (isset($row))
    //     print_r_pre($row, '$row');

    $title = 'Connexion';
    // $visible = true;
    // if ($_SESSION['logged'])
    //     $visible = false;
    // else
    //     $visible = true;
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once('templates/head.php');?>
    <body>
        <header>
            <?php require_once('templates/nav-bar.php');?>
        </header>
        <main class="container">
            <?php
                if (isset($_SESSION['error'])) {
                    echo '<p class="error">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);
                }
                if (!isset($_SESSION['logged']) || !$_SESSION['logged']) :
                    echo '<p class="error">Cette partie du site où vous pourrez modifier vos informations, ne sera visible qu\'une fois connecté</p>';
                else :
            ?>
                    <h1>Page de Profil</h1>
                    <p>Ici, vous pouvez changer votre identifiant - s'il est disponible - et/ou votre mot de passe:</p>
                    <form action="" method="post">
                        <label for="login">Login:</label>
                        <input type="text" name="login" id="login" 
                            value='<?php 
                                        if (isset($_SESSION['login']))
                                            echo trim($_SESSION['login']);
                                    ?>
                                    ' /> <br />
                        
                        <label for="password">Mot de passe:</label>
                        <input type="text" name="password" id="password" 
                            value='<?php 
                                        if (isset($_SESSION['password']))
                                            echo trim($_SESSION['password']);
                                    ?>
                                '/> <br />

                        <input type="submit" id="submitButton" name='submit' value="Valider">
                    </form>
            <?php
                endif;
            ?>
        </main>
        <?php require_once('templates/footer.php');?>
    </body>
</html>