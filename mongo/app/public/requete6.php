<?php

use MongoDB\Client;

require_once __DIR__ . "/../src/vendor/autoload.php";

function getProduitByNumeroAndTaille($numero, $taille) {
    $client = new Client("mongodb://mongo");
    $collection = $client->pizzashop->produits;
    
    $produit = $collection->findOne(['numero' => $numero]);
    
    if (!$produit) {
        return null;
    }
    
    $tarif = null;
    foreach ($produit['tarifs'] as $t) {
        if ($t['taille'] === $taille) {
            $tarif = $t['tarif'];
            break;
        }
    }
    
    if ($tarif === null) {
        return null;
    }
    
    return [
        'numero' => $produit['numero'],
        'libelle' => $produit['libelle'],
        'categorie' => $produit['categorie'],
        'taille' => $taille,
        'tarif' => $tarif
    ];
}

$numero = isset($_GET['numero']) ? (int)$_GET['numero'] : 6;
$taille = isset($_GET['taille']) ? $_GET['taille'] : 'normale';

$resultat = getProduitByNumeroAndTaille($numero, $taille);

header('Content-Type: application/json');
echo json_encode($resultat, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
