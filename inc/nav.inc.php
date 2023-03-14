<body>

    <header>
        <div class="bg bg-dark">
            <h1><a href="index.php" class="text-decoration-none mx-5 mt-5 text-light">My Tchat</a></h1>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                </li>
                <?php if(!estConnecte()):?>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">S'inscrire</a>
                </li>
                
                <?php else : ?>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#">Profil</a> -->
                    <a type="button" href="profil.php" class="btn btn-primary position-relative">
                        Profil
                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=deconnexion" class="nav-link text-danger">Me déconnecter</a>
                    <!-- <a class="nav-link">Se déconnecter</a> -->
                </li>
                <?php endif ?>
            </ul>
        </div>
    </header>