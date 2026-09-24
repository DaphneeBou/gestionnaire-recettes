<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$crud = new CRUD;
$recetteId = $_POST['recette_id'];
$ingredientId = $_POST['ingredient_id'];

$sql = "DELETE FROM recette_ingredient WHERE recette_id = :recette_id AND ingredient_id = :ingredient_id";
$stmt = $crud->prepare($sql);
$stmt->bindValue(':recette_id', $recetteId);
$stmt->bindValue(':ingredient_id', $ingredientId);
$stmt->execute();

header('location:recette-show.php?id=' . $recetteId);
