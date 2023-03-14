<?php
//1- Connexion BDD
require_once 'inc/init.inc.php';

// 2- Traitement du formulaire
if (!empty($_POST)) {
    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $message .= '<div class="alert alert-warning">Votre prenom doit faire entre 2 et 20 caractères.</div>';
    }

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $message .= '<div class="alert alert-warning">Votre nom doit faire entre 2 et 20 caractères.</div>';
    }

    if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $message .= '<div class="alert alert-warning">Votre mail n\'est pas conforme !</div>';
        // Ici, je vérifie que le mail n'est pas vide et je passe en revue le mail entré en disant de le vérifier grâce au filtre et au paramètre FILTER_VALIDATE_EMAIL. Le premier, filter_var est une fonction prédéfinie qui prendra en paramètre la chaine de caractère que l'on veut vérifier et en second paramètre la constante FILTER_VALIDATE_EMAIL qui vérifie sur le même principe qu'un REGEX l'email entré par la personne.
    }

    if (!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {
        $message .= '<div class="alert alert-warning">Votre pseudo doit faire entre 4 et 20 caractères.</div>';
    }

    if (empty($message)) { // si la variable $contenu est vide, alors la personne a rempli correctement le formulaire, on peut entrer les infos en BDD
        // Je veux que le pseudo soit unique dans la BDD

        $membre = $pdoChat->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
        $membre->execute(array(
            ':pseudo' => $_POST['pseudo']
        )); // Je demande à mon exécuteur de PHP de vérifier que le pseudo entré par l'utilisateur n'est pas déjà existant dans la BDD

        if ($membre->rowCount() > 0) {
            // Je demande à l'utilisateur exécuter si la requête précédente renvoie des résultats. Si elle renvoie des résultats, ça signifie que l'utilisateur doit choisir un autre pseudo car celui-ci existe déjà

            $message .= '<div class="alert alert-warning">Ce pseudo est indisponible, choisissez-en un autre</div>';
        } else { // sinon : le pseudo est disponible, on rentre les informations en BDD
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Grâce à la fonction prédéfinie password_hash, je dis à mon code de hascher le mdp et lui précise ensuite selon quelle méthode, ici grâce à la constante PASSWORD_DEFAULT. Vous pouvez aussi définir vous même votre algorythme à la place d'utiliser la  PASSWORD_DEFAULT.

            $insertion = $pdoChat->prepare("INSERT INTO users (prenom, nom, genre, pseudo, mail, mdp) VALUES (:prenom, :nom, :genre, :pseudo, :mail, :mdp)");
            // Je prépare ma requête avec mes marqueurs vides qui vont correspondre à ce que mon utilisateur va mettre dans le formulaire.
            // Le seul champ différent est le statut, qui va être automatiquement  0 (utilisateur lambda)

            $insertion->execute(array(
                ':prenom' => $_POST['prenom'],
                ':nom' => $_POST['nom'],
                ':genre' => $_POST['genre'],
                ':pseudo' => $_POST['pseudo'],
                ':mail' => $_POST['mail'],
                ':mdp' => $mdp, // ici on réccupère le mdp qu'on a hashé un peu plus haut dans le code

            ));

            if ($insertion) {
                $message .= '<div class="alert alert-success">
                                Vous êtes inscrit sur le site.
                                <a href="connexion.php">
                                    Cliquez ici pour vous connecter.
                                </a>
                            </div>';
            } else {
                $message .= '<div class="alert alert-success">
                                Erreur lors de l\'inscription. 
                            </div>';
            }
        }
    }
}


?>



<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.1/litera/bootstrap.min.css" integrity="sha512-VytuSEcywyOk3/TgzUvYclfS5MrwPLUhVZHMGpN4O81Cu/LguN+MxiFUZOkem4VkRVAPC8BVqaGziJ+xUz2BZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>MonBlog - inscription</title>
</head>

<body>

    <?php require_once 'inc/nav.inc.php'; ?>
    <div class="p-5 mb-4 bg-secondary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">MonBlog - Inscription</h1>
            <p class="col-md-8 fs-4">Inscrivez-vous sur le blog !</p>
        </div>
    </div>


    <!-- main.container>section.row>.col-12.col-md-7.mx-auto -->
    <main class="container">
        <section class="row">
            <div class="col-12 col-md-7 mx-auto">
                <?php echo $message; ?>

                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="genre">Genre</label>
                        <select name="genre" id="genre" class="form-select">
                            <option value="f">Femme</option>
                            <option value="m">Homme</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pseudo">Pseudonyme</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="mail">Courriel</label>
                        <input type="text" name="mail" id="mail" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" name="mdp" id="mdp" class="form-control">
                    </div>

                    <div class="mb-3">
                        <input type="submit" name="submit" value="S'inscrire" class="btn btn-primary">
                    </div>
                </form>
                <div class="alert alert-secondary">
                    <p style="font-size: 1.2em;">Si vous êtes déjà inscrit.e, <a href="connexion.php">connectez-vous !</a></p>
                </div>
            </div>
        </section>
    </main>



    <?php require_once 'inc/footer.inc.php' ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>