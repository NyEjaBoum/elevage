<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Simulation élevage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
        }
        .resume {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Simulation de l'élevage</h1>
    
    <form action="simulation" method="GET">
        <label for="dateSimulation">Date de simulation :</label>
        <input type="date" id="dateSimulation" name="date" required>
        <button type="submit" id="simuler">Simuler</button>
    </form>

    <?php if(!empty($resultats)) : ?>
        <h2>Résultats de la simulation pour le <?= htmlspecialchars($date_simulation) ?></h2>
        
        <?php foreach ($resultats as $resultat) : ?>
            <h3>Animal : <?= htmlspecialchars($resultat['nom']) ?></h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Date</th>
                        <th>Poids (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($resultat['error'])) : ?>
                        <tr>
                            <td colspan="3"><?= htmlspecialchars($resultat['error']) ?></td>
                        </tr>
                    <?php else : 
                        foreach ($resultat as $jour) : 
                            if (is_array($jour) && isset($jour['jour'])) : ?>
                            <tr>
                                <td><?= htmlspecialchars($jour['jour']) ?></td>
                                <td><?= htmlspecialchars($jour['date']) ?></td>
                                <td><?= number_format($jour['poids'], 2) ?></td>
                            </tr>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>