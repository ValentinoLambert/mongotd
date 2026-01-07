<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;
$produits = $collection->find(['tarifs' => ['$elemMatch' => ['taille' => 'normale', 'tarif' => ['$lte' => 3.0]]]]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requête 3</title>
</head>
<body>
    <h1>Requête 3 - Tarif normal ≤ 3€</h1>
    <table border="1">
        <tr><th>Numéro</th><th>Libellé</th><th>Catégorie</th><th>Tarif</th></tr>
        <?php foreach ($produits as $p): ?>
            <?php $tarif = null; foreach ($p['tarifs'] as $t) if ($t['taille'] === 'normale') $tarif = $t['tarif']; ?>
            <tr>
                <td><?= $p['numero'] ?></td>
                <td><?= $p['libelle'] ?></td>
                <td><?= $p['categorie'] ?></td>
                <td><?= $tarif ?> €</td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
