<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations Saisonnières</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/liste2.css">
</head>
<body>
    <!-- Navigation -->
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
            <div class="category">
                <i class="fas fa-swimming-pool"></i>
                <span>Piscines</span>
            </div>
            <div class="category">
                <i class="fas fa-umbrella-beach"></i>
                <span>Plage</span>
            </div>
            <div class="category">
                <i class="fas fa-mountain"></i>
                <span>Montagne</span>
            </div>
            <div class="category">
                <i class="fas fa-campground"></i>
                <span>Camping</span>
            </div>
            <div class="category">
                <i class="fas fa-house"></i>
                <span>Villas</span>
            </div>
            <div class="category">
                <i class="fas fa-building"></i>
                <span>Appartements</span>
            </div>
        </div>
    </div>

    <!-- Listings -->
    <div class="listings-container">
        <div class="listings-grid">
            <?php foreach($AllAchat as $test) { ?>
                <div class="listing-image-container">
                    <img src="<?php echo $test['image']; ?>" alt="Villa moderne" class="listing-image">
                    <button class="favorite-button">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <div class="listing-info">
                    <div class="listing-header">
                        <div class="listing-title"> <?php echo $test['nom']; ?></div>
                    </div>
                    <div class="listing-details"> <?php echo $test['lieux']; ?></div>
                    <div class="listing-details">20-25 jan.</div>
                    <div class="listing-price">
                        <span class="price-amount">prix: <?php echo $test['prix']; ?></span>

                    </div>
                </div>
            </a>
           <?php  } ?>
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