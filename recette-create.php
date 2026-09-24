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
    <title>Nouvelle recette</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?> 
    <div class="container">
        <form action="recette-store.php" method="post">
            <h2>Nouvelle recette</h2>
            <label>Titre de la recette
                <input type="text" name="titre" required>
            </label>
            <label>Description
                <input type="text" name="description">
            </label>
            <label>Catégorie existante
                <select name="categorie_id">
                    <option value="">-- Choisir --</option>
                    <?php foreach ($categories as $categorie) { ?>
                    <option value="<?= $categorie['id']; ?>"><?= $categorie['nom']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label>Ou une nouvelle categorie
                <input type="text" name="nouvelle_categorie" placeholder="Nom de la nouvelle categorie">
            </label>
            <label>Temps de préparation (en minutes)
                <input type="number" name="temps_preparation" min="1">
            </label>
            <label>Portions
                <input type="number" name="portions" min="1">
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
        <p>*Les étapes de préparation pourront être ajoutées une fois la recette créée.</p>
    </div>
</body>
</html>
