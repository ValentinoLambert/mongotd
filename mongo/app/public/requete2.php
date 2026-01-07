<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;
$produit = $collection->findOne(['numero' => 6]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requête 2</title>
</head>
<body>
    <h1>Requête 2 - Produit #6</h1>
    <?php if ($produit): ?>
        <h2><?= $produit['libelle'] ?></h2>
        <p><b>Catégorie :</b> <?= $produit['categorie'] ?></p>
        <p><?= $produit['description'] ?></p>
        <p><b>Tarifs :</b></p>
        <ul>
            <?php foreach ($produit['tarifs'] as $t): ?>
                <li><?= ucfirst($t['taille']) ?> : <?= $t['tarif'] ?> €</li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Produit non trouvé</p>
    <?php endif; ?>
</body>
</html>
