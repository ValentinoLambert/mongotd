<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;
$produits = $collection->find(['recettes' => ['$size' => 4]]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requête 4</title>
</head>
<body>
    <h1>Requête 4 - Produits avec 4 recettes</h1>
    <table border="1">
        <tr><th>Numéro</th><th>Libellé</th><th>Catégorie</th><th>Recettes</th></tr>
        <?php foreach ($produits as $p): ?>
            <tr>
                <td><?= $p['numero'] ?></td>
                <td><?= $p['libelle'] ?></td>
                <td><?= $p['categorie'] ?></td>
                <td>4</td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
