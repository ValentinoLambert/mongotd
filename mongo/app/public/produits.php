<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

$categorie = $_GET['categorie'] ?? '';
$produits = $collection->find(['categorie' => $categorie]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produits - <?= htmlspecialchars($categorie) ?></title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .produit { border: 1px solid #ddd; padding: 15px; margin: 10px 0; 
                   border-radius: 5px; background: #f9f9f9; }
        .tarif { display: inline-block; margin-right: 15px; padding: 5px 10px; 
                 background: #fff; border: 1px solid #ccc; border-radius: 3px; }
    </style>
</head>
<body>
    <p><a href="catalogue.php">Retour aux catégories</a></p>
    
    <h1>Catégorie : <?= htmlspecialchars($categorie) ?></h1>
    
    <?php foreach ($produits as $p): ?>
        <div class="produit">
            <h3>N°<?= $p['numero'] ?> - <?= $p['libelle'] ?></h3>
            <p><?= $p['description'] ?></p>
            <div>
                <strong>Tarifs :</strong>
                <?php foreach ($p['tarifs'] as $t): ?>
                    <span class="tarif"><?= $t['taille'] ?> : <?= $t['tarif'] ?> €</span>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
