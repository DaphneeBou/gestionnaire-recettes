<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$crud = new CRUD;

$ingredientId = $_POST['ingredient_id'] ?? '';
$nouvelIngredient = trim($_POST['nouvel_ingredient'] ?? '');

if ($nouvelIngredient !== '') {
    // Verifier si cet ingredient existe deja (eviter les doublons)
    $sql = "SELECT id FROM ingredient WHERE nom = :nom";
    $stmt = $crud->prepare($sql);
    $stmt->bindValue(':nom', $nouvelIngredient);
    $stmt->execute();
    $existant = $stmt->fetch();

    if ($existant) {
        $ingredientId = $existant['id'];
    } else {
        $ingredientId = $crud->insert('ingredient', [
            'nom' => $nouvelIngredient,
            'unite_par_defaut' => $_POST['unite'],
        ]);
    }
}

if ($ingredientId === '') {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'partials/nav.php'; ?>
    <div class="container">
        <p class="message-erreur">Erreur : vous devez choisir un ingredient existant ou en taper un nouveau.</p>
        <a href="recette-show.php?id=<?= $_POST['recette_id']; ?>" class="btn">Retour</a>
    </div>
</body>
</html>
<?php
    exit;
}

$data = [
    'recette_id' => $_POST['recette_id'],
    'ingredient_id' => $ingredientId,
    'quantite' => $_POST['quantite'],
    'unite' => $_POST['unite'],
];
$crud->insert('recette_ingredient', $data);

header('location:recette-show.php?id=' . $_POST['recette_id']);
