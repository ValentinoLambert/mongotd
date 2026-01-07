<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

// Récupérer les catégories distinctes
$categories = $collection->distinct('categorie');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        a { margin: 10px; }
    </style>
</head>
<body>
    <h1>Catalogue</h1>
    <p><a href="ajout_produit.php">Ajouter un produit</a></p>
    <h2>Catégories</h2>
    <?php foreach ($categories as $cat): ?>
        <p><a href="produits.php?categorie=<?= urlencode($cat) ?>"><?= $cat ?></a></p>
    <?php endforeach; ?>
</body>
</html>
