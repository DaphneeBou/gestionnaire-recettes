<?php
if (!isset($_GET['id']) || $_GET['id'] == null) {
    header('location:categorie-index.php');
    exit;
}
$id = $_GET['id'];

require_once('Classe/CRUD.php');

$crud = new CRUD;
$categorie = $crud->selectId('categorie', $id);

if (!$categorie) {
    header('location:categorie-index.php');
    exit;
}

$sql = "SELECT * FROM recette WHERE categorie_id = :id ORDER BY titre ASC";
$stmt = $crud->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$recettes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categorie['nom']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?>
    <div class="container">
        <a href="categorie-index.php" class="btn-special">Retour aux categories</a>
        <h1 class="recettes"><?= $categorie['nom']; ?></h1>

        <?php if (count($recettes) > 0) { ?>
        <ul class="categories">
            <?php foreach ($recettes as $recette) { ?>
            <li>
                <a href="recette-show.php?id=<?= $recette['id']; ?>"><?= $recette['titre']; ?></a>
            </li>
            <?php } ?>
        </ul>
        <?php } else { ?>
        <p>Aucune recette dans cette categorie pour le moment.</p>
        <?php } ?>
    </div>
</body>
</html>
