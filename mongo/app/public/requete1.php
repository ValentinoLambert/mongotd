<?php
// 1. Afficher la liste des produits: numero, categorie, libelle

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

echo "<h1>Liste des produits</h1>";
echo "<table border='1'>";
echo "<tr><th>Numéro</th><th>Catégorie</th><th>Libellé</th></tr>";

$produits = $collection->find();

foreach ($produits as $produit) {
    echo "<tr>";
    echo "<td>" . $produit['numero'] . "</td>";
    echo "<td>" . $produit['categorie'] . "</td>";
    echo "<td>" . $produit['libelle'] . "</td>";
    echo "</tr>";
}

echo "</table>";
