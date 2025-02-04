<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Planifier la Vente</title>
    <style>
        .planning-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .animal-details {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .planning-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="planning-container">
        <h2>Planifier la Vente</h2>

        <div class="animal-details">
            <h3>Détails de l'Animal</h3>
            <p>Nom: <?php echo htmlspecialchars($animal['nom']); ?></p>
            <p>Poids actuel: <?php echo htmlspecialchars($animal['poids_actuel']); ?> kg</p>
            <p>Poids minimal de vente: <?php echo htmlspecialchars($animal['poids_minimal_vente']); ?> kg</p>
        </div>

        <form class="planning-form" method="POST" action="/elevage/planifier">
            <input type="hidden" name="animal_id" value="<?php echo $animal['id']; ?>">
            <div class="form-group">
                <label for="date_vente">Date de vente prévue:</label>
                <input type="date" id="date_vente" name="date_vente" required
                    min="<?php echo date('Y-m-d'); ?>">
            </div>
            <button type="submit" class="submit-btn">Planifier la Vente</button>
        </form>
    </div>
</body>
<?php include('footer.php'); ?>

</html>