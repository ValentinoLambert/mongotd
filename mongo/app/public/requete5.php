<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$produitsCollection = $client->pizzashop->produits;
$recettesCollection = $client->pizzashop->recettes;
$produit = $produitsCollection->findOne(['numero' => 6]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requête 5</title>
</head>
<body>
    <h1>Requête 5 - Produit #6 avec recettes</h1>
    <?php if ($produit): ?>
        <h2><?= $produit['libelle'] ?></h2>
        <p><?= $produit['description'] ?></p>
        <p><b>Tarifs :</b>
            <?php foreach ($produit['tarifs'] as $t): ?>
                <?= ucfirst($t['taille']) ?> : <?= $t['tarif'] ?> € &nbsp;
            <?php endforeach; ?>
        </p>
        <h3>Recettes associées</h3>
        <table border="1">
            <tr><th>Nom</th><th>Difficulté</th></tr>
            <?php foreach ($produit['recettes'] as $recetteId): ?>
                <?php $r = $recettesCollection->findOne(['_id' => $recetteId]); ?>
                <?php if ($r): ?>
                    <tr>
                        <td><?= $r['nom'] ?></td>
                        <td><?= $r['difficulte'] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Produit non trouvé</p>
    <?php endif; ?>
</body>
</html>
