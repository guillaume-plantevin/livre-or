<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php if ($visible):
            echo '<li><a href="inscription.php">Inscription</a></li>';
            echo '<li><a href="connexion.php">Connexion</a></li>';
            endif
        ?>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="livre-or.php">Livre d'Or</a></li>
        <li><a href="commentaire.php">Commentaires</a></li>
    </ul>
</nav>