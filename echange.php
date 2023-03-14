<?php
//1- Connexion BDD
require_once 'inc/init.inc.php';

// Requête pour reccupérer les utilisateurs connectés
if(isset($_GET['id_users'])){
    $user = $pdoChat->prepare("SELECT * FROM users WHERE id_users = :id_users");
    $user->execute(array(
        ':id_users' => $_GET['id_users'],

    ));
    // 3- Si la personne arrive sur la page avec un id_article dans l'url qui n'existe pas // redirection vers la page articles.php
    if($user->rowCount() == 0){
        header('location:articles.php');
        exit();
    }

    $oneUser = $user->fetch(PDO::FETCH_ASSOC);
}else{
    // Si la personne arrive sans id_article dans l'url //redirection vers la page articles.php
    header('location:interface.php');
    exit();
}

$tchat = $pdoChat->query("SELECT * FROM message ORDER BY id_message ASC");

// debug($tchat);

if (!empty($_POST)) // Je verifie que mon formulaire n'est pas vide (not empty)
{
    // $echange = $_POST['message'];
    if(!empty($_POST['message'])){
    $texte = htmlspecialchars($_POST['message']);

    $resultat = $pdoChat->prepare("INSERT INTO message (contenu, id_users) VALUES (:contenu, :id_users)");

    $resultat->execute(array(
        ':contenu' => $texte,
        ':id_users' => $_SESSION['users']['id_users'],
    ));
        // $message .= 'Envoyé';
        // debug($resultat);
        header('location:echange.php');

    }else{
        $message .= 'Veuillez ecrire un message';
    
    }

    debug($_POST);
    echo $_POST['message'];


    // header('location:articles.php');
    // exit();
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
        <div class="w-75 mx-auto mt-5">
            <p class="text-center alert alert-info fs-3">Echange avec <?php echo '<span class="text-light fst-italic">'. $oneUser['pseudo'] . '</span>'; ?></p>

            <div class="row">
                <!-- Affichage de tous les utilisateurs -->
                <div class="messageUser alert alert-tertiary border border-primary col-12">

                        <?php
                            while($echange = $tchat->fetch(PDO::FETCH_ASSOC)){
                                // debug($echange);
                                echo '<p class="text-dark">'. $echange['contenu'] . '</p>'; 
                        }
                        ?>
                </div>
            </div>
            <form action="#" method="POST">
                <textarea name="message" id="message" rows="2" class="w-100"></textarea>
                <?php echo $message; ?>
                <input type="submit" name="envoyer" class="btn btn-success w-100 mt-3">
            </form>


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