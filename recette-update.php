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
    // Aucun choix fait: on garde la categorie actuelle de la recette
    $recetteActuelle = $crud->selectId('recette', $_POST['id']);
    $categorieId = $recetteActuelle['categorie_id'];
}

$data = [
    'id' => $_POST['id'],
    'titre' => $_POST['titre'],
    'description' => $_POST['description'],
    'categorie_id' => $categorieId,
    'temps_preparation' => $_POST['temps_preparation'],
    'portions' => $_POST['portions'],
];

$update = $crud->update('recette', $data);

if ($update) {
    header('location:recette-show.php?id=' . $_POST['id']);
} else {
    echo "Erreur lors de la mise a jour.";
}
