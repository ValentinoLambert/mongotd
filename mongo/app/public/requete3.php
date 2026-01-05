<?php
// 3. Liste des produits dont le tarif en taille normale est <= 3.0

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

echo "<h1>Produits avec tarif normal &lt;= 3.0 €</h1>";
echo "<table border='1'>";
echo "<tr><th>Numéro</th><th>Libellé</th><th>Catégorie</th><th>Tarif normal</th></tr>";

$produits = $collection->find([
    'tarifs' => [
        '$elemMatch' => [
            'taille' => 'normale',
            'tarif' => ['$lte' => 3.0]
        ]
    ]
]);

foreach ($produits as $produit) {
    // Trouver le tarif normal
    $tarifNormal = null;
    foreach ($produit['tarifs'] as $tarif) {
        if ($tarif['taille'] === 'normale') {
            $tarifNormal = $tarif['tarif'];
            break;
        }
    }
    
    echo "<tr>";
    echo "<td>" . $produit['numero'] . "</td>";
    echo "<td>" . $produit['libelle'] . "</td>";
    echo "<td>" . $produit['categorie'] . "</td>";
    echo "<td>" . $tarifNormal . " €</td>";
    echo "</tr>";
}

echo "</table>";
