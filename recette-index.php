<?php
require_once('Classe/CRUD.php');
$crud = new CRUD;
$sql = "SELECT recette.*, categorie.nom AS categorie_nom FROM recette JOIN categorie ON recette.categorie_id = categorie.id ORDER BY recette.titre ASC";
$recettes = $crud->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?> 
    <h1>Mes recettes</h1>
    <table>
        <thead>
            <tr>
                <th>Recettes</th>
                <th>Catégories</th>
                <th>Temps de préparation</th>
                <th>Portions</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recettes as $recette) { ?>
            <tr>
                <td><a href="recette-show.php?id=<?= $recette['id']; ?>"><?= $recette['titre']; ?></a></td>
                <td><?= $recette['categorie_nom']; ?></td>
                <td><?= $recette['temps_preparation']; ?> min</td>
                <td><?= $recette['portions']; ?></td>
                <td><a href="recette-show.php?id=<?= $recette['id']; ?>" class="btn more">en savoir plus</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="recette-create.php" class="btn add">Ajouter une nouvelle recette</a>
</body>
</html>
