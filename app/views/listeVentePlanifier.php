<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ventes Planifiées</title>
    <style>
        .ventes-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .dashboard-button {
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-button:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .dashboard-button i {
            font-size: 1rem;
        }

        .dashboard-button a {
            text-decoration: none;
            color: inherit;
        }

        .user-menu {
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .dashboard {
                padding: 1rem;
            }

            .stats-container {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .table-container {
                margin: 1rem;
                overflow-x: auto;
            }

            .user-menu {
                gap: 0.5rem;
            }

            .dashboard-button {
                padding: 0.5rem 1rem;
            }
        }

        .dashboard {
            width: 100%;
            padding: 1rem 2rem;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: bold;
        }

        /* Adjust main content to account for fixed dashboard */
        .ventes-container {
            margin-top: 80px;
            /* Height of dashboard + some spacing */
        }

        .pending {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="dashboard-content">
            <div class="user-menu">
                <button class="dashboard-button">
                    <i class="fas fa-user-shield"></i>
                    <a href="admin">Admin</a>
                </button>
                <button class="dashboard-button">
                    <i class="fas fa-shopping-cart"></i>
                    <a href="food">Acheter Nourriture</a>
                </button>
                <button class="dashboard-button">
                    <i class="fas fa-shopping-cart"></i>
                    <a href="listeAnimal">Acheter Animal</a>
                </button>
                <button class="dashboard-button">
                    <i class="fas fa-shopping-cart"></i>
                    <a href="depot">Faire un depot</a>
                </button>
                <button class="dashboard-button">
                    <i class="fas fa-shopping-cart"></i>
                    <a href="listeVente">Liste Vente Planifier</a>
                </button>
                <button class="dashboard-button">
                    <i class="fas fa-shopping-cart"></i>
                    <a href="dashboard">Tableau de Bord</a>
                </button>

            </div>
        </div>
    </div>

    <div class="ventes-container">
        <h2>Ventes Planifiées</h2>
        <table>
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Poids Actuel</th>
                    <th>Poids Min. Vente</th>
                    <th>Prix/kg</th>
                    <th>Date Prévue</th>
                    <th>Quantité</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ventes)): ?>
                    <?php foreach ($ventes as $vente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vente['nom_animal']); ?></td>
                            <td><?php echo number_format($vente['poids_actuel'], 2); ?> kg</td>
                            <td><?php echo number_format($vente['poids_minimal_vente'], 2); ?> kg</td>
                            <td><?php echo number_format($vente['prix_vente_kg'], 2); ?> €</td>
                            <td><?php echo date('d/m/Y', strtotime($vente['date_prevue'])); ?></td>
                            <td><?php echo $vente['quantite']; ?></td>
                            <td>
                                <span class="status pending">
                                    En attente
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;">Aucune vente planifiée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<?php include('footer.php'); ?>

</html>