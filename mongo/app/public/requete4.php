<?php

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

echo "<h1>Produits associés à 4 recettes</h1>";
echo "<table border='1'>";
echo "<tr><th>Numéro</th><th>Libellé</th><th>Catégorie</th><th>Nombre de recettes</th></tr>";

$produits = $collection->find([
    'recettes' => ['$size' => 4]
]);

foreach ($produits as $produit) {
    echo "<tr>";
    echo "<td>" . $produit['numero'] . "</td>";
    echo "<td>" . $produit['libelle'] . "</td>";
    echo "<td>" . $produit['categorie'] . "</td>";
    echo "<td>4</td>";
    echo "</tr>";
}

echo "</table>";
