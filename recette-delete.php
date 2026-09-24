<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$id = $_POST['id'];
$crud = new CRUD;
$delete = $crud->delete('recette', $id);

if ($delete) {
    header('location:recette-index.php');
} else {
    echo "Erreur lors de la suppression.";
}
