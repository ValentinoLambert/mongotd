<?php

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$produitsCollection = $client->pizzashop->produits;
$recettesCollection = $client->pizzashop->recettes;

echo "<h1>Produit numéro 6 avec recettes</h1>";

$produit = $produitsCollection->findOne(['numero' => 6]);

if ($produit) {
    echo "<h2>" . $produit['libelle'] . "</h2>";
    echo "<p><strong>Catégorie:</strong> " . $produit['categorie'] . "</p>";
    echo "<p><strong>Description:</strong> " . $produit['description'] . "</p>";
    
    echo "<h3>Tarifs:</h3>";
    echo "<ul>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "<li>" . $tarif['taille'] . ": " . $tarif['tarif'] . " €</li>";
    }
    echo "</ul>";
    
    echo "<h3>Recettes associées:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Nom</th><th>Difficulté</th></tr>";
    
    foreach ($produit['recettes'] as $recetteId) {
        $recette = $recettesCollection->findOne(['_id' => $recetteId]);
        if ($recette) {
            echo "<tr>";
            echo "<td>" . $recette['nom'] . "</td>";
            echo "<td>" . $recette['difficulte'] . "</td>";
            echo "</tr>";
        }
    }
    
    echo "</table>";
} else {
    echo "<p>Produit non trouvé</p>";
}
