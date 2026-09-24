<?php
require_once('Classe/CRUD.php');

$crud = new CRUD;
$categories = $crud->select('categorie', 'nom', 'ASC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?>
    <div class="container">
        <a href="index.php" class="btn-special">Retour a l'accueil</a>
        <h1 class="recettes">Catégories</h1>
        <ul class="categories">
            <?php foreach ($categories as $categorie) { ?>
            <li>
                <a href="categorie-show.php?id=<?= $categorie['id']; ?>"><?= $categorie['nom']; ?></a>
            </li>
            <?php } ?>
        </ul>
        
    </div>
</body>
</html>
