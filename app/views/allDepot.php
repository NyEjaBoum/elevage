<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Dépôts</title>
    <link rel="stylesheet" href="css/accueil.css">
    <style>

    </style>
</head>
<body>

    <div class="main-content">
        <div class="container">
            <h1>Historique des Dépôts</h1>
            <h1>Bonjour <?php echo $_SESSION['user']; ?></h1>

            <div class="child-category">
                <h2>Liste des dépôts effectués</h2>
                
                <?php 
                if (!empty($depots)): 
                ?>
                    <table class="deposit-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Montant (€)</th>
                                <th>Statut</th>
                                <th>Validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($depots as $depot): ?>
                                <tr>
                                    <td><?php echo $depot['id']; ?></td>
                                    <td><?php echo ($depot['Valeur']); ?> €</td>
                                    <td>
                                        <span class="status <?php echo $depot['is_valide'] ? 'status-valid' : 'status-pending'; ?>">
                                            <?php echo $depot['is_valide'] ? 'Validé' : 'En attente'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!$depot['is_valide']): ?>
                                            <a href="validate?id=<?php echo $depot['id']; ?>&iduser=<?php echo $depot['idUser']; ?>" class="validate-btn">Valider</a>
                                            <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun dépôt n'a été effectué pour le moment.</p>
                <?php endif; ?>
            </div>

            <a href="liste" class="back-button">Retour</a>
        </div>
    </div>
</body>
</html>