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
    <title>Catalogue de produits</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .category { display: inline-block; margin: 10px; padding: 15px; 
                    background: #f0f0f0; border-radius: 5px; }
        .category a { text-decoration: none; color: #333; font-weight: bold; }
        .category:hover { background: #e0e0e0; }
    </style>
</head>
<body>
    <h1>Catalogue de produits</h1>
    
    <p><a href="ajout_produit.php">Ajouter un produit</a></p>
    
    <h2>Catégories</h2>
    <?php foreach ($categories as $cat): ?>
        <div class="category">
            <a href="produits.php?categorie=<?= urlencode($cat) ?>"><?= $cat ?></a>
        </div>
    <?php endforeach; ?>
</body>
</html>
