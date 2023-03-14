<?php
// 1- Connexion à la BDD
require_once 'inc/init.inc.php';


// Deconnexion
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
    //je vérifie que je récupère action = deconnexion
    session_destroy(); // détruire  toutes traces de la session
    // header('location:index.php');
    $message .= '<div class="alert alert-success">Vous avez bien été déconecté. <a href="connexion.php">Se reconnecter</a></div>';
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

    <link rel="stylesheet" href="css/style.css">
    <title></title>
</head>


    <?php require_once 'inc/nav.inc.php'; ?>
    <main>
        <?php echo $message; ?>
        

        <div class="w-75 mx-auto mt-5">
            <?php if(estConnecte()):?>
                <a class="btn btn-success" href="interface.php">Entrer dans le salon</a>
            <?php endif ?>
            <div class="row">
                <img src="img/tchat.png" alt="tchat">
                
            </div>
            <p class="alert alert-info fs-1 text-center fw-bold">Bienvenu de mon TCHAT</p>
            <p>Envie de discuter ??   <a href="connexion.php">Connectez-vous</a> ou <a href="inscription.php">créez votre compte</a></p>

        </div>


    </main>


    <?php require_once 'inc/footer.inc.php' ?>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>