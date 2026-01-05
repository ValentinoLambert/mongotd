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
        body { font-family: Arial; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: inline-block; width: 150px; font-weight: bold; }
        input[type="text"], textarea, select { width: 300px; padding: 5px; }
        .taille-group { margin-left: 155px; }
        .taille-item { margin: 5px 0; }
        button { padding: 10px 20px; background: #4CAF50; color: white; 
                 border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
        .message { padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; 
                   border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <p><a href="catalogue.php">Retour au catalogue</a></p>
    
    <h1>Ajouter un produit</h1>
    
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Libellé :</label>
            <input type="text" name="libelle" required>
        </div>
        
        <div class="form-group">
            <label>Description :</label>
            <textarea name="description" rows="3" required></textarea>
        </div>
        
        <div class="form-group">
            <label>Catégorie :</label>
            <select name="categorie" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat ?>"><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Tailles et tarifs :</label>
            <div class="taille-group">
                <div class="taille-item">
                    <input type="checkbox" name="taille_normale" id="tn" value="1" checked>
                    <label for="tn" style="width: auto;">Normale</label>
                    <input type="number" name="tarif_normale" step="0.01" value="9.99" style="width: 100px;">€
                </div>
                <div class="taille-item">
                    <input type="checkbox" name="taille_grande" id="tg" value="1" checked>
                    <label for="tg" style="width: auto;">Grande</label>
                    <input type="number" name="tarif_grande" step="0.01" value="12.99" style="width: 100px;">€
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <button type="submit">Ajouter le produit</button>
        </div>
    </form>
</body>
</html>
