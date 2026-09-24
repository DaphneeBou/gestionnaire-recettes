<?php
if (!isset($_GET['id']) || $_GET['id'] == null) {
    header('location:recette-index.php');
    exit;
}
$id = $_GET['id'];

require_once('Classe/CRUD.php');

$crud = new CRUD;
$recette = $crud->selectId('recette', $id);

if ($recette) {
    extract($recette);
} else {
    header('location:recette-index.php');
    exit;
}

$categories = $crud->select('categorie', 'nom', 'ASC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la recette</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?> 
    <div class="container">
    <a href="recette-show.php?id=<?= $id; ?>" class="btn-special">Retour à la recette</a>
        <form action="recette-update.php" method="post">
            <input type="hidden" name="id" value="<?= $id; ?>">
            <h2>Modifier la recette</h2>
            <label>Titre
                <input type="text" name="titre" value="<?= $titre; ?>" required>
            </label>
            <label>Description
                <input type="text" name="description" value="<?= $description; ?>">
            </label>
            <label>Catégorie existante
                <select name="categorie_id">
                    <option value="">-- Ne pas changer --</option>
                    <?php foreach ($categories as $categorie) { ?>
                    <option value="<?= $categorie['id']; ?>" <?= ($categorie['id'] == $categorie_id) ? 'selected' : ''; ?>><?= $categorie['nom']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label>Ou une nouvelle catégorie
                <input type="text" name="nouvelle_categorie" placeholder="Nom de la nouvelle categorie">
            </label>
            <label>Temps de préparation (minutes)
                <input type="number" name="temps_preparation" value="<?= $temps_preparation; ?>">
            </label>
            <label>Portions
                <input type="number" name="portions" value="<?= $portions; ?>">
            </label>
            <input type="submit" class="btn" value="Enregistrer">
        </form>
        
    </div>
</body>
</html>
