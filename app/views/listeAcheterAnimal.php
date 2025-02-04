<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Élevage</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Ajoutez le CSS ci-dessus ici -->
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
        }

        /* Dashboard Header */
        .dashboard {
            background-color: #ffffff;
            padding: 1.25rem 2rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .dashboard-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a56db;
            text-decoration: none;
        }

        .logo i {
            color: #2563eb;
            font-size: 1.75rem;
        }

        .user-menu {
            display: flex;
            gap: 1rem;
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

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-title {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            color: #16a34a;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin: 0 2rem 2rem;
            overflow: hidden;
            max-width: 1400px;
            margin: 2rem auto;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #f9fafb;
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        tbody td {
            padding: 1rem 1.5rem;
            color: #374151;
            font-size: 0.875rem;
        }

        .action-button {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-button:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }

        .action-button a {
            text-decoration: none;
            color: inherit;
        }

        .no-listings {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
            font-size: 1rem;
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
    </style>
</head>

<body>
    <!-- Dashboard -->
    <div class="dashboard">
        <div class="dashboard-content">
            <div class="logo">
                <i class="fas fa-paw"></i>
                Élevage <?php echo ($_SESSION['user']); ?>
            </div>
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
                    <a href="list">Liste des Animal</a>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-title">Total Animaux</div>
            <div class="stat-value">12</div>
            <div class="stat-change">
                <i class="fas fa-arrow-up"></i>
                +2.5% ce mois
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Poids Moyen</div>
            <div class="stat-value">245 kg</div>
            <div class="stat-change">
                <i class="fas fa-arrow-up"></i>
                +4.7% ce mois
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Âge Moyen</div>
            <div class="stat-value">14 mois</div>
            <div class="stat-change">
                <i class="fas fa-arrow-up"></i>
                +1.2% ce mois
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-header">
            <h2 class="table-title">Liste des Animaux</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Poids Actuel</th>
                    <th>Date d'Achat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($listings)): ?>
                    <?php foreach ($listings as $listing): ?>
                        <tr>
                            <td><?php echo ($listing['nom']); ?></td>
                            <td><?php echo ($listing['poids_actuel']); ?></td>
                            <td><?php echo ($listing['date_achat']); ?></td>
                            <td>
                                <form method="POST" action="achat">
                                    <input type="hidden" name="nom" value="<?php echo $listing['nom']; ?>">
                                    <input type="hidden" name="poids_actuel" value="<?php echo $listing['poids_actuel']; ?>">
                                    <input type="hidden" name="type_animal_id" value="<?php echo $listing['type_animal_id']; ?>">
                                    <input type="hidden" name="vendeur_id" value="<?php echo $listing['utilisateur_id']; ?>">
                                    <input type="hidden" name="animal_id" value="<?php echo $listing['id']; ?>">
                                    <input type="hidden" name="quantite" value="1">
                                    <?php
                                    $prix = $listing['poids_actuel'] * $listing['prix_vente_kg'];
                                    ?>
                                    <input type="hidden" name="prix" value="<?php echo $prix; ?>">
                                    <button type="submit" class="action-button">Acheter</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="no-listings">Aucun animal disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

<?php include('footer.php'); ?>

</html>