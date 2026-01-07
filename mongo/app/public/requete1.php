<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;
$produits = $collection->find();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Requête 1</title>
</head>
<body>
    <h1>Requête 1 - Tous les produits</h1>
    <table border="1">
        <tr><th>Numéro</th><th>Catégorie</th><th>Libellé</th></tr>
        <?php foreach ($produits as $p): ?>
            <tr>
                <td><?= $p['numero'] ?></td>
                <td><?= $p['categorie'] ?></td>
                <td><?= $p['libelle'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
