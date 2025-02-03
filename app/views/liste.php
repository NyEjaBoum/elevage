<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion d'Élevage - Tableau de bord</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/liste.css">
</head>
<body>
    <nav class="nav-container">
        <div class="nav-content">
            <a href="index.php" class="logo">
                <i class="fas fa-cow"></i>
                FarmTracker
            </a>
            <div class="nav-links">
                <a href="animaux.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvel Animal
                </a>
                <a href="#" class="user-info">
                    <?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Utilisateur'; ?>
                </a>
            </div>
            <div class="nav-links">
                <a href="animaux.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvel Animal
                </a>
                <a href="#" class="user-info">
                    <?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Utilisateur'; ?>
                </a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- En-tête du tableau de bord -->
        <div class="dashboard-header">
            <h1>Tableau de bord</h1>
            <div class="date-selector">
                <input type="date" id="dateSelection" class="form-input" 
                       value="<?php echo date('Y-m-d'); ?>">
                <button class="btn btn-primary" onclick="updateDashboard()">
                    <i class="fas fa-sync"></i> Actualiser
                </button>
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="cards-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Total Animaux</span>
                    <div class="stat-card-icon">
                        <i class="fas fa-cow"></i>
                    </div>
                </div>
                <div class="stat-card-value" id="totalAnimaux">0</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Capital Actuel</span>
                    <div class="stat-card-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="stat-card-value" id="capitalActuel">0 €</div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-title">Stock Aliments</span>
                    <div class="stat-card-icon">
                        <i class="fas fa-wheat-awn"></i>
                    </div>
                </div>
                <div class="stat-card-value" id="stockAliments">0 kg</div>
            </div>
        </div>

        <!-- Liste des animaux -->
        <div class="table-container">
            <div class="table-header">
                <h2>Liste des Animaux</h2>
                <div class="table-actions">
                    <button class="btn btn-success" onclick="nourrir()">
                        <i class="fas fa-utensils"></i> Nourrir
                    </button>
                    <button class="btn btn-warning" onclick="acheterNourriture()">
                        <i class="fas fa-cart-shopping"></i> Acheter Nourriture
                    </button>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Poids Actuel</th>
                        <th>Dernier Repas</th>
                        <th>État</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="listeAnimaux">
                    <!-- Les données seront chargées dynamiquement -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts JS -->
    <script>
        // Fonction pour mettre à jour le tableau de bord
        function updateDashboard() {
            const date = document.getElementById('dateSelection').value;
            
            // Appel AJAX pour récupérer les données
            fetch(`api/dashboard.php?date=${date}`)
                .then(response => response.json())
                .then(data => {
                    // Mise à jour des statistiques
                    document.getElementById('totalAnimaux').textContent = data.totalAnimaux;
                    document.getElementById('capitalActuel').textContent = data.capital + ' €';
                    document.getElementById('stockAliments').textContent = data.stockAliments + ' kg';
                    
                    // Mise à jour de la liste des animaux
                    const tbody = document.getElementById('listeAnimaux');
                    tbody.innerHTML = ''; // Vider le tableau
                    
                    data.animaux.forEach(animal => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${animal.id}</td>
                            <td>${animal.type}</td>
                            <td>${animal.poids} kg</td>
                            <td>${animal.dernierRepas}</td>
                            <td>
                                <span class="status-badge ${getStatusClass(animal.etat)}">
                                    ${animal.etat}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-primary" onclick="voirDetails(${animal.id})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-danger" onclick="vendreAnimal(${animal.id})">
                                    <i class="fas fa-money-bill"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                });
        }

        // Fonction pour déterminer la classe CSS du statut
        function getStatusClass(etat) {
            switch(etat.toLowerCase()) {
                case 'sain': return 'status-healthy';
                case 'attention': return 'status-warning';
                case 'critique': return 'status-danger';
                default: return '';
            }
        }

        // Initialisation du tableau de bord
        document.addEventListener('DOMContentLoaded', () => {
            updateDashboard();
        });

        // Fonctions d'action (à implémenter)
        function voirDetails(id) {
            window.location.href = `details.php?id=${id}`;
        }

        function vendreAnimal(id) {
            if(confirm('Êtes-vous sûr de vouloir vendre cet animal ?')) {
                // Appel AJAX pour vendre l'animal
            }
        }

        function nourrir() {
            // Implémenter la logique de nourrissage
        }

        function acheterNourriture() {
            // Implémenter la logique d'achat de nourriture
        }
    </script>
</body>
</html>