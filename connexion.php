<?php
//1- Connexion BDD
require_once 'inc/init.inc.php';

// 2- Traitement du formulaire
if(!empty($_POST)){
    if(empty($_POST['pseudo']) || empty($_POST['mdp'])){
        // On verifie que pseudo et mdp sont vides // s'ils sont vides, on met un message d'erreur grâce à la variable $message
        $message .= '<div class="alert alert-warning">Le pseudo et le mot de passe sont requis !</div>';
    }

    if(empty($message)){ // si la variable $message est vide c'est que je n'ai pas d'erreur, je peux donc lancer
        $resultat = $pdoChat->prepare("SELECT * FROM users WHERE pseudo = :pseudo"); // je selectionne toutes les infos de l'utilisateur dont le pseudo correspond à celui du formulaire

        $resultat->execute(array(
            ':pseudo' =>  $_POST['pseudo'],

        ));

        if($resultat->rowCount() == 1) { // si le programme renvoie une ligne c'est que le membre (pseudo) existe

            $membre = $resultat->fetch(PDO::FETCH_ASSOC);

            if(password_verify($_POST['mdp'], $membre['mdp'])){
                /* password_verify prend deux arguments : 
                    1- Le mot de passe du formulaire
                    2- Le mot de passe de la BDD
                    password_verify permet de vérifier que le premier correspond au deuxième
                */
                $_SESSION['users'] = $membre;

                // debug($membre);
                // debug($_SESSION);

                header('location:interface.php');
                exit();
            }else { // Le mot de passe
                $message .= '<div class="alert alert-warning">Vous n\'avez pas le bon mot de passe !</div>';
            }

        }else{
            // Le pseudo n'est pas bon
            $message .= '<div class="alert alert-warning">Ce pseudo n\'existe pas !</div>';
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


    <title>MonBlog - Connexion</title>
</head>

<body>

    <?php require_once 'inc/nav.inc.php'; ?>


    <header class="p-5 mb-4 bg-light rounded-3">
        <section class="container-fluid py-5">
            <h1 class="display-5 fw-bold">MonBlog - Connexion</h1>
            <p class="col-md-8 fs-4">Connectez-vous à votre compte !</p>
        </section>
    </header>

    <main class="container">
        <section class="row">
            <div class="col-12 col-md-7 mx-auto">
                <?php echo $message; ?>

                <form action="#" method="POST" class="alert alert-secondary">

                    <div class="mb-3">
                        <label for="pseudo">Pseudonyme</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" name="mdp" id="mdp" class="form-control">
                    </div>

                    <input type="submit" value="Se connecter" class="btn btn-outline-light">

                </form>
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