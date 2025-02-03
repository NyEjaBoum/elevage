<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImmoLoc - Ajouter une location</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/liste.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #484848;
        }

        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-btn {
            background-color: #FF5A5F;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #e6505a;
        }

        .form-title {
            text-align: center;
            color: #FF5A5F;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<nav class="nav-container">
        <div class="nav-content">
            <a href="#" class="logo">
                <i class="fab fa-airbnb"></i>
                ImmoLoc
            </a>

            <div class="search-bar">
                <div class="search-item">N'importe où</div>
                <div class="search-item">Une semaine</div>
                <div class="search-item">
                    Ajouter des voyageurs
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div class="user-menu">
                <button class="host-button">Admin</button>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="form-title">Ajouter une location</h2>
        <form action="traitement.php" method="POST">
            <div class="form-group">
                <label for="type">Type d'habitation</label>
                <select id="type" name="type" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="chambre">Chambre</option>
                    <option value="villa">Villa</option>
                    <option value="appartement">Appartement</option>
                    <option value="camping">Camping</option>
                </select>
            </div>

            <div class="form-group">
                <label for="quartier">Quartier</label>
                <input type="text" id="quartier" name="quartier" required placeholder="Ex: Centre-ville, Plage">
            </div>

            <div class="form-group">
                <label for="chambres">Nombre de chambres</label>
                <input type="number" id="chambres" name="chambres" min="1" max="10" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix par nuit</label>
                <input type="number" id="prix" name="prix" min="10" step="1" required placeholder="En euros">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Décrivez votre logement..."></textarea>
            </div>

            <div class="form-group">
                <label for="image">URL de l'image</label>
                <input type="url" id="image" name="image" required placeholder="https://exemple.com/image.jpg">
            </div>

            <div class="form-group">
                <label for="disponibilite">Dates de disponibilité</label>
                <div style="display:flex; gap:10px;">
                    <input type="date" id="date_debut" name="date_debut" required>
                    <input type="date" id="date_fin" name="date_fin" required>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-plus"></i> Ajouter la location
            </button>
        </form>
    </div>
</body>
</html>