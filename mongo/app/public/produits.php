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
    <title><?= htmlspecialchars($categorie) ?></title>
    <style>
        body { font-family: Arial; padding: 20px; }
    </style>
</head>
<body>
    <p><a href="catalogue.php">Retour</a></p>
    <h1><?= htmlspecialchars($categorie) ?></h1>
    <?php foreach ($produits as $p): ?>
        <hr>
        <h3><?= $p['libelle'] ?> (#<?= $p['numero'] ?>)</h3>
        <p><?= $p['description'] ?></p>
        <p>
            <?php foreach ($p['tarifs'] as $t): ?>
                <b><?= ucfirst($t['taille']) ?>:</b> <?= $t['tarif'] ?> € &nbsp;
            <?php endforeach; ?>
        </p>
    <?php endforeach; ?>
</body>
</html>
