<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Simulation élevage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1>Simulation de l'élevage</h1>
<form action="simulation" method="GET">
    <label for="dateSimulation">Date de simulation :</label>
    <input type="date" id="dateSimulation" name="date">
    <button id="simuler">Simuler</button>
</form>

<h1>Résultats de la simulation pour le <?= $date_simulation ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nom de l'animal</th>
                <th>Poids actuel (kg)</th>
                <th>Nourriture consommée (kg)</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultats as $resultat) : ?>
                <tr>
                    <td><?= $resultat['nom'] ?></td>
                    <td><?= number_format($resultat['poids_actuel'], 2) ?></td>
                    <td><?= number_format($resultat['nourriture_consommee'], 2) ?></td>
                    <td><?= $resultat['statut'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
</body>
</html>