<?php
if (!isset($_GET['id']) || $_GET['id'] == null) {
    header('location:recette-index.php');
    exit;
}
$id = $_GET['id'];

require_once('Classe/CRUD.php');

$crud = new CRUD;

$sql = "SELECT recette.*, categorie.nom AS categorie_nom FROM recette JOIN categorie ON recette.categorie_id = categorie.id WHERE recette.id = :id";
$stmt = $crud->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$recette = $stmt->fetch();

if (!$recette) {
    header('location:recette-index.php');
    exit;
}
extract($recette);

$sqlEtapes = "SELECT * FROM etape WHERE recette_id = :id ORDER BY numero_ordre ASC";
$stmtEtapes = $crud->prepare($sqlEtapes);
$stmtEtapes->bindValue(':id', $id);
$stmtEtapes->execute();
$etapes = $stmtEtapes->fetchAll();
$prochainNumero = 1;
if (count($etapes) > 0) {
    $derniereEtape = end($etapes);
    $prochainNumero = $derniereEtape['numero_ordre'] + 1;
}

$sqlIngredients = "SELECT ingredient.id, ingredient.nom, recette_ingredient.quantite, recette_ingredient.unite
                    FROM recette_ingredient
                    JOIN ingredient ON recette_ingredient.ingredient_id = ingredient.id
                    WHERE recette_ingredient.recette_id = :id";
$stmtIng = $crud->prepare($sqlIngredients);
$stmtIng->bindValue(':id', $id);
$stmtIng->execute();
$ingredients = $stmtIng->fetchAll();

$ingredientsDisponibles = $crud->select('ingredient', 'nom', 'ASC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?> 
    <div class="container">
        <div class="container-mini">  
            <a href="recette-index.php" class="btn-special">Retour à la liste de recettes</a>  
            <form action="recette-delete.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $id; ?>">
                <button type="submit" class="btn red">Supprimer la recette</button>
            </form>  
        </div>

        <h1 class="recettes"><?= $titre; ?></h1>
        <p><strong>Catégorie : </strong><?= $categorie_nom; ?></p>
        <p><strong>Description : </strong><?= $description; ?></p>
        <p><strong>Temps de preparation : </strong><?= $temps_preparation; ?> min</p>
        <p><strong>Portions : </strong><?= $portions; ?></p>
        <a href="recette-edit.php?id=<?= $id; ?>" class="btn">Modifier</a>

        <h2>Étapes de préparation</h2>
        <ol class="etapes">
            <?php foreach ($etapes as $etape) { ?>
            <li>
                <span class="etape-texte"><?= $etape['description']; ?></span>
                <form action="recette-etape-delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $etape['id']; ?>">
                    <input type="hidden" name="recette_id" value="<?= $id; ?>">
                    <button type="submit" class="btn red">Retirer</button>
                </form>
            </li>
            <?php } ?>
        </ol>

        <h3>Ajouter une étape:</h3>
        <form action="recette-etape-store.php" method="post">
            <input type="hidden" name="recette_id" value="<?= $id; ?>">
            <input type="hidden" name="numero_ordre" value="<?= $prochainNumero; ?>">
            <div class="form-row">
                <input type="text" name="description" required placeholder="Description de l'étape...">
                <input type="submit" class="btn" value="Ajouter">
            </div>
        </form>

        <h2>Ingredients</h2>
        <ul class="ingredients">
            <?php foreach ($ingredients as $ing) { ?>
            <li>
                <span class="ingredient-texte"><?= $ing['nom']; ?> - <?= $ing['quantite']; ?> <?= $ing['unite']; ?></span>
                <form action="recette-ingredient-delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="recette_id" value="<?= $id; ?>">
                    <input type="hidden" name="ingredient_id" value="<?= $ing['id']; ?>">
                    <button type="submit" class="btn red">Retirer</button>
                </form>
            </li>
            <?php } ?>
        </ul>

        <details class="ajout-ingredient">
            <summary class="btn">Ajouter un ingredient</summary>
            <form action="recette-ingredient-store.php" method="post">
                <fieldset>
                    <legend>Ajouter un ingredient</legend>
                    <input type="hidden" name="recette_id" value="<?= $id; ?>">
                    <label>Ingrédient existant
                        <select name="ingredient_id">
                            <option value="">-- Choisir --</option>
                            <?php foreach ($ingredientsDisponibles as $ingDispo) { ?>
                            <option value="<?= $ingDispo['id']; ?>"><?= $ingDispo['nom']; ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label>Ou un nouvel ingrédient
                        <input type="text" name="nouvel_ingredient" placeholder="Nom du nouvel ingredient">
                    </label>
                    <label>Quantité
                        <input type="number" step="0.01" name="quantite" min="0.01" required>
                    </label>
                    <label>Unité
                        <input type="text" name="unite">
                    </label>
                    <input type="submit" class="btn" value="Ajouter">
                </fieldset>
            </form>
        </details>

    
    </div>
    

</body>
</html>
