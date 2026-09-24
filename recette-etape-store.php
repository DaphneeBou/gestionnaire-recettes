<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:recette-index.php');
    exit;
}
require_once('Classe/CRUD.php');

$crud = new CRUD;
$crud->insert('etape', $_POST);

header('location:recette-show.php?id=' . $_POST['recette_id']);
