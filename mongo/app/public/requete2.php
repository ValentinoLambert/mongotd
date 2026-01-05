<?php
// 2. Afficher le produit numéro 6: libellé, catégorie, description, tarifs

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

echo "<h1>Produit numéro 6</h1>";

$produit = $collection->findOne(['numero' => 6]);

if ($produit) {
    echo "<p><strong>Libellé:</strong> " . $produit['libelle'] . "</p>";
    echo "<p><strong>Catégorie:</strong> " . $produit['categorie'] . "</p>";
    echo "<p><strong>Description:</strong> " . $produit['description'] . "</p>";
    echo "<p><strong>Tarifs:</strong></p>";
    echo "<ul>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "<li>" . $tarif['taille'] . ": " . $tarif['tarif'] . " €</li>";
    }
    echo "</ul>";
} else {
    echo "<p>Produit non trouvé</p>";
}
