<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Achats de Nourriture</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

h1 {
    text-align: center;
    color: #333;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert.error {
    background-color: #f8d7da;
    color: #721c24;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group select,
.form-group input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}

.purchases-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.purchases-table th,
.purchases-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.purchases-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.capital-info {
    margin-bottom: 20px;
    font-size: 1.2em;
    color: #333;
}
     </style>
</head>
<body>
    <div class="container">
        <h1>Achat de Nourriture</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if (isset($message)): ?>
            <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="food-purchase-form">
            <input type="hidden" name="action" value="purchase_food">
            
            <div class="form-group">
                <label for="animal_id">Animal</label>
                <select name="animal_id" id="animal_id" required>
                    <?php foreach ($animals as $animal): ?>
                        <option value="<?php echo $animal->id; ?>">
                            <?php echo htmlspecialchars($animal->nom); ?> 
                            (Poids actuel: <?php echo $animal->poids_actuel; ?> kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="food_id">Nourriture</label>
                <select name="food_id" id="food_id" required>
                    <?php foreach ($foods as $food): ?>
                        <option value="<?php echo $food['id']; ?>">
                            <?php echo htmlspecialchars($food['nom']); ?> 
                            (Stock: <?php echo $food['stock']; ?> kg, Prix: <?php echo $food['prix_kg']; ?> €/kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantité (kg)</label>
                <input type="number" name="quantity" id="quantity" step="0.1" min="0" required>
            </div>

            <button type="submit" class="btn">Acheter Nourriture</button>
        </form>
    </div>
</body>
</html>