<?php
// 1- Connexion à la BDD
$pdoChat = new PDO(
    'mysql:host=localhost;
    dbname=chat',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    )
    );

    // 2- Ouverture de session
    session_start();

    // 3- Une variable pour afficher les messages de réussite ou d'erreur
    $message = '';
    /* Cette variable sera utilisée exclusivementpour afficher les erreurs et les messages de réussites. On la laisse vide et on la concatènera avec les symboles suivants : .= pour afficher les messages */


    require_once 'fonctions.inc.php';

    