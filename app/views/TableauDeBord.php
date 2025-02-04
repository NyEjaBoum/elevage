<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Élevage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #34495e;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #c0392b;
            --light: #ecf0f1;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f6fa;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: var(--primary);
            color: white;
            padding: 2rem;
        }

        .main-content {
            padding: 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .simulation-form {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .warning-card {
            border-left: 4px solid var(--warning);
        }

        .danger-card {
            border-left: 4px solid var(--danger);
        }

        .success-card {
            border-left: 4px solid var(--success);
        }

        .stat-card h3 {
            margin: 0;
            color: var(--secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin: 1rem 0;
            color: var(--primary);
        }

        .animal-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
        }

        .animal-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .animal-header {
            background: var(--primary);
            color: white;
            padding: 1rem;
            font-weight: bold;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th,
        .results-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .results-table th {
            background: #f8f9fa;
            font-weight: 500;
        }

        .gain-positive {
            color: var(--success);
            font-weight: bold;
        }

        .gain-zero {
            color: var(--warning);
        }

        .stock-warning {
            color: var(--warning);
            font-weight: bold;
        }

        .stock-critical {
            color: var(--danger);
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }

            .animal-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="logo">🐄 Élevage Manager</div>
        </div>
        
        <div class="main-content">
            <div class="simulation-form">
                <form action="simulation" method="GET">
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem">Date de simulation</label>
                        <input type="date" name="date" required style="width:100%; padding:0.75rem; border:1px solid #ddd; border-radius:5px;">
                    </div>
                    <button type="submit" style="background:var(--primary); color:white; padding:0.75rem 1.5rem; border:none; border-radius:5px; cursor:pointer; margin-top:1rem;">
                        Lancer la simulation
                    </button>
                </form>
            </div>

            <?php if(!empty($resultats)): ?>
                <div class="stats-grid">
                    <?php 
                    $totalAnimaux = count($resultats);
                    $stockInitial = 0;
                    $stockRestant = 0;
                    $gainTotal = 0;
                    
                    foreach($resultats as $animal) {
                        if (!empty($animal['simulations'])) {
                            $stockInitial = $animal['simulations'][0]['stock_initial'];
                            $derniereSim = end($animal['simulations']);
                            $stockRestant = $derniereSim['stock_restant'];
                            foreach($animal['simulations'] as $sim) {
                                $gainTotal += ($sim['poids_final'] - $sim['poids_initial']);
                            }
                        }
                    }
                    ?>
                    
                    <div class="stat-card">
                        <h3>Total Animaux</h3>
                        <div class="stat-value"><?= $totalAnimaux ?></div>
                    </div>

                    <div class="stat-card warning-card">
                        <h3>Stock Initial</h3>
                        <div class="stat-value"><?= number_format($stockInitial, 2) ?> kg</div>
                    </div>

                    <div class="stat-card <?= ($stockRestant > 20 ? '' : ($stockRestant > 10 ? 'warning-card' : 'danger-card')) ?>">
                        <h3>Stock Restant</h3>
                        <div class="stat-value"><?= number_format($stockRestant, 2) ?> kg</div>
                    </div>

                    <div class="stat-card success-card">
                        <h3>Gain Total</h3>
                        <div class="stat-value"><?= number_format($gainTotal, 2) ?> kg</div>
                    </div>
                </div>

                <div class="animal-cards">
                    <?php foreach ($resultats as $animalId => $animal): ?>
                        <div class="animal-card">
                            <div class="animal-header">
                                <?= htmlspecialchars($animal['nom']) ?>
                            </div>
                            <div style="padding:1.5rem">
                                <table class="results-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Poids</th>
                                            <th>Gain</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($animal['simulations'] as $simulation): ?>
                                            <tr>
                                                <td><?= $simulation['date'] ?></td>
                                                <td><?= number_format($simulation['poids_final'], 2) ?> kg</td>
                                                <td class="<?= ($simulation['poids_final'] - $simulation['poids_initial'] > 0) ? 'gain-positive' : 'gain-zero' ?>">
                                                    <?= number_format($simulation['poids_final'] - $simulation['poids_initial'], 2) ?> kg
                                                </td>
                                                <td class="<?= ($simulation['stock_restant'] > 20 ? '' : ($simulation['stock_restant'] > 10 ? 'stock-warning' : 'stock-critical')) ?>">
                                                    <?= number_format($simulation['stock_restant'], 2) ?> kg
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
<?php include('footer.php'); ?>

</html>