<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Dépôt d'Argent</title>
    <link rel="stylesheet" href="css/accueil.css">
</head>
<body>
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
<div class="main-content">
    <div class="container">
        <h1>Formulaire de Dépôt d'Argent</h1>
        <h1>Bonjour <?php echo $_SESSION['user']; ?></h1>

        <!-- Affichage du message de statut -->
        <?php if (isset($_GET['depot'])): ?>
            <?php if ($_GET['depot'] == 'success'): ?>
                <div class="alert alert-success">Dépôt effectué avec succès !</div>
            <?php elseif ($_GET['depot'] == 'error'): ?>
                <div class="alert alert-error">Une erreur est survenue lors du dépôt.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="child-category">
            <h2>Dépôt d'argent</h2>
            <form action="insertDepot" method="POST">
                <div class="form-group">
                    <label for="montant">Montant à déposer (en €):</label>
                    <input type="number" id="montant" name="montant" placeholder="Entrez le montant" required min="1" step="0.01">
                </div>
                <div class="form-group">
                    <button type="submit" class="back-button">Déposer</button>
                </div>
            </form>
        </div>

        <a href="liste" class="back-button">Retour</a>
    </div>
</div>
<?php include('footer.php'); ?>

</body>
</html>
