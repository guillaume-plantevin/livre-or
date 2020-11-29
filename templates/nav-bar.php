<nav>
    <h1>Livre d'Or</h1>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php if ($visible):
            echo '<li><a href="inscription.php">Inscription</a></li>';
            echo '<li><a href="connexion.php">Connexion</a></li>';
            endif
        ?>
        <li><a href="profil.php">Votre profil</a></li>
        <li><a href="livre-or.php">Le livre d'or</a></li>
        <li><a href="commentaire.php">Rajouter un commentaire</a></li>
    </ul>
</nav>