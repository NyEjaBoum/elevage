<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations Saisonnières</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset and base styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navigation Styles */
        .nav-container {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #FF5A5F;
            font-weight: bold;
        }

        .logo i {
            margin-right: 10px;
            font-size: 24px;
        }

        /* Search Bar Styles */
        .search-bar {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 30px;
            padding: 10px;
        }

        .search-item {
            margin: 0 10px;
            color: #484848;
        }

        .search-button {
            background-color: #FF5A5F;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px;
        }

        /* Categories Styles */
        .categories-container {
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .categories {
            display: flex;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .category {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            color: #717171;
            padding: 10px;
            transition: color 0.3s;
        }

        .category:hover, .category.active {
            color: #FF5A5F;
        }

        .category i {
            margin-bottom: 5px;
            font-size: 20px;
        }

        /* Listings Styles */
        .listings-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .listing-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            text-decoration: none;
            color: #484848;
            transition: transform 0.3s;
        }

        .listing-card:hover {
            transform: scale(1.03);
        }

        .listing-image-container {
            position: relative;
        }

        .listing-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .favorite-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .listing-info {
            padding: 15px;
        }

        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .listing-title {
            font-weight: bold;
        }

        .listing-rating {
            color: #FF5A5F;
        }

        .listing-details {
            color: #717171;
            margin-bottom: 5px;
        }

        .listing-price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navigation -->

    <h1><?php echo $_SESSION['user'] ?></h1>

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
                <button class="host-button"><a href="admin">Admin</a></button>
            </div>
        </div>
    </nav>

    <!-- Categories -->
    <div class="categories-container">
        <div class="categories">
            <div class="category active">
                <i class="fas fa-hotel"></i>
                <span>Chambres</span>
            </div>
        </div>
    </div>

<!-- Listings -->
<div class="listings-container">
    <div class="listings-grid">
        <?php if (!empty($listings)): ?>
            <?php foreach ($listings as $listing): ?>
                <a href="#" class="listing-card">
                    <div class="listing-image-container">
                        <img src="<?php echo ($listing['image']); ?>" alt="Listing" class="listing-image">
                        <button class="favorite-button">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                    <div class="listing-info">
                        <div class="listing-header">
                            <div class="listing-title"><?php echo ($listing['nom']); ?></div>
                        </div>
                        <div class="listing-details"><?php echo ($listing['poids_actuel']); ?></div>
                        <div class="listing-details"><?php echo ($listing['date_achat']); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun listing trouvé.</p>
        <?php endif; ?>
    </div>
</div>
    </div>

    <script>
        // Category selection
        const categories = document.querySelectorAll('.category');
        categories.forEach(category => {
            category.addEventListener('click', () => {
                categories.forEach(c => c.classList.remove('active'));
                category.classList.add('active');
            });
        });

        // Favorite button toggle
        const favoriteButtons = document.querySelectorAll('.favorite-button');
        favoriteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                button.classList.toggle('active');
                const icon = button.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
            });
        });
    </script>
</body>
</html>