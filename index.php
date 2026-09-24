<?php
require_once("Classe/CRUD.php");

$crud = new CRUD;

$nbRecettes = $crud->query("SELECT COUNT(*) AS total FROM recette")->fetch()['total'];
$nbCategories = $crud->query("SELECT COUNT(*) AS total FROM categorie")->fetch()['total'];
$nbIngredients = $crud->query("SELECT COUNT(*) AS total FROM ingredient")->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Gestionnaire de recette</title>
</head>
<body>
    <?php require 'partials/nav.php'; ?>    

<div class="container-large">
    <img src="img/image2.svg" class="image2" >
    <div>
        <h2>Bienvenue</h2>
        <p>Toutes tes recettes réunies au même endroit, sans avoir à fouiller dans une pile de cahiers ou de captures d'écran. Ajoute, modifie et organise tes plats comme un vrai chef!</p>
        <p>Ce système contient présentement :</p>
        <p>
            <strong><?= $nbRecettes; ?></strong> recettes,  
            <strong><?= $nbCategories; ?></strong> catégories et 
            <strong><?= $nbIngredients; ?></strong> ingrédients
        </p>
        <a href="recette-create.php" class="btn">Ajouter une nouvelle recette</a>
    </div>
</div>
</body>
</html>
