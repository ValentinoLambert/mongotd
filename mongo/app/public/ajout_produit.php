<?php
use MongoDB\Client;
require_once __DIR__ . "/../src/vendor/autoload.php";

$client = new Client("mongodb://mongo");
$collection = $client->pizzashop->produits;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer dernier numéro
    $dernier = $collection->findOne([], ['sort' => ['numero' => -1]]);
    $numero = ($dernier ? $dernier['numero'] : 0) + 1;
    
    // tarifs
    $tarifs = [];
    if (!empty($_POST['taille_normale'])) {
        $tarifs[] = ['taille' => 'normale', 'tarif' => (float)$_POST['tarif_normale']];
    }
    if (!empty($_POST['taille_grande'])) {
        $tarifs[] = ['taille' => 'grande', 'tarif' => (float)$_POST['tarif_grande']];
    }
    
    // Insérer le produit
    $collection->insertOne([
        'numero' => $numero,
        'libelle' => $_POST['libelle'],
        'description' => $_POST['description'],
        'categorie' => $_POST['categorie'],
        'tarifs' => $tarifs,
        'recettes' => []
    ]);
    
    $message = "Produit ajouté avec succès (N°$numero)";
}

// Récupérer catégories
$categories = $collection->distinct('categorie');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, textarea, select { margin: 5px 0; }
    </style>
</head>
<body>
    <p><a href="catalogue.php">Retour</a></p>
    <h1>Ajouter un produit</h1>
    <?php if ($message): ?>
        <p><b><?= $message ?></b></p>
    <?php endif; ?>
    
    <form method="POST">
        <p><label>Libellé</label><br>
        <input type="text" name="libelle" required></p>
        
        <p><label>Description</label><br>
        <textarea name="description" rows="3" required></textarea></p>
        
        <p><label>Catégorie</label><br>
        <select name="categorie" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>"><?= $cat ?></option>
            <?php endforeach; ?>
        </select></p>
        
        <p><label>Tarifs</label><br>
        <input type="checkbox" name="taille_normale" id="tn" value="1" checked>
        <label for="tn">Normale</label>
        <input type="number" name="tarif_normale" step="0.01" value="9.99"> €<br>
        <input type="checkbox" name="taille_grande" id="tg" value="1" checked>
        <label for="tg">Grande</label>
        <input type="number" name="tarif_grande" step="0.01" value="12.99"> €</p>
        
        <p><button type="submit">Ajouter</button></p>
    </form>
</body>
</html>
