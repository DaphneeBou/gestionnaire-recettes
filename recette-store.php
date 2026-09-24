<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$crud = new CRUD;

$categorieId = $_POST['categorie_id'] ?? '';
$nouvelleCategorie = trim($_POST['nouvelle_categorie'] ?? '');

if ($nouvelleCategorie !== '') {
    // Verifier si cette categorie existe deja (eviter les doublons)
    $sql = "SELECT id FROM categorie WHERE nom = :nom";
    $stmt = $crud->prepare($sql);
    $stmt->bindValue(':nom', $nouvelleCategorie);
    $stmt->execute();
    $existante = $stmt->fetch();

    if ($existante) {
        $categorieId = $existante['id'];
    } else {
        $categorieId = $crud->insert('categorie', [
            'nom' => $nouvelleCategorie,
        ]);
    }
}

if ($categorieId === '') {
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
        <p class="message-erreur">Erreur : vous devez choisir une categorie existante ou en taper une nouvelle.</p>
        <a href="recette-create.php" class="btn">Retour</a>
    </div>
</body>
</html>
<?php
    exit;
}

$data = [
    'titre' => $_POST['titre'],
    'description' => $_POST['description'],
    'categorie_id' => $categorieId,
    'temps_preparation' => $_POST['temps_preparation'],
    'portions' => $_POST['portions'],
];

$insert = $crud->insert('recette', $data);

if ($insert) {
    header('location:recette-show.php?id=' . $insert);
} else {
    header('location:recette-index.php');
}
