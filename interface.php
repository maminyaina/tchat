<?php
//1- Connexion BDD
require_once 'inc/init.inc.php';

// Requête pour reccupérer les utilisateurs connectés
$requete = $pdoChat->query("SELECT * FROM users");

$tchat = $pdoChat->query("SELECT * FROM message LEFT JOIN users ON message.id_users = users.id_users ORDER BY id_message ASC");

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
        header('location:interface.php');

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
            <p class="text-center alert alert-info fs-3">Bienvenue <?php echo '<span class="text-light fst-italic">'. $_SESSION['users']['pseudo'] . '</span>'; ?> Vous êtes connecté</p>
            <div class="row">
                <!-- Affichage de tous les utilisateurs -->
                <div class="listeUser alert alert-light border border-secondary mx-4 col-2">
                    <ul>
                    <?php
                    while ($utilisateur = $requete->fetch(PDO::FETCH_ASSOC)) {
                        // if(estConnecte() == $_SESSION['users']){
                            echo '<li><a type="button" href="echange.php?id_users=' . $utilisateur['id_users'] . '" class="position-relative">' . $utilisateur['pseudo'];
                            if($utilisateur['id_users'] == $_SESSION['users']['id_users']){     
                                echo '<span class="position-absolute top-50 start-0 translate-middle p-2 bg-success border border-light rounded-circle ms-5">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>';
                            }else{
                                echo '<span class="position-absolute top-50 start-0 translate-middle p-2 bg-secondary border border-light rounded-circle ms-5">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>';
                            }
                    
                     
                    }
                    
                    ?>
                    </a></li>
                    </ul>
                </div>
                <div class="messageUser alert alert-tertiary border border-primary mx-4 col-9">

                        <?php
                            while($echange = $tchat->fetch(PDO::FETCH_ASSOC)){
                                // debug($echange);
                                echo '<p class="text-dark"><span class="fst-italic text-info">'. $echange['pseudo'] . ' a écrit : </span>'. $echange['contenu'] . '</p>'; 
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