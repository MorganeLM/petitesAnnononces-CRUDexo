<?php
session_start();

require_once 'functions.php';

define('URL', 'http://localhost/CRUD');


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>
    <link rel="stylesheet" href="<?=URL.'/css/styles.css'?>">
</head>
<body>
    <nav>
        <h1><a href="<?=URL?>">LeBonEndroit</a></h1>
        <div>
            <a href="<?=URL.'/annonces/ajout.php'?>">Nouvelle Annonce</a>|

            <a href="<?=URL.'/categories/ajout.php'?>">Catégories</a>|

            <a href="<?=URL.'/annonces/parDepartement.php'?>">Régions</a>|

            <?php   
            if(isset($_SESSION['user'])){
                echo "<a href='".URL."/user/deconnexion.php'>Déconnexion</a>";
            }else{
                echo '<a href="'.URL.'/user/connexion.php">Connexion</a>| <a href="'.URL.'/inscription.php">Inscription</a>';
            }
            ?>
        </div>
    </nav>