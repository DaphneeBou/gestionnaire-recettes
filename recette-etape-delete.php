<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$crud = new CRUD;
$id = $_POST['id'];
$recetteId = $_POST['recette_id'];

$crud->delete('etape', $id);

header('location:recette-show.php?id=' . $recetteId);
