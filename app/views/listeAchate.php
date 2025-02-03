<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations Saisonnières</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/liste2.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">InfHotel</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="AffichageAchat">Liste des achat</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>


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
                    <div class="listing-details"> <?php echo $test['poids_actuel']; ?></div>
                    <div class="listing-details">20-25 jan.</div>
                    <div class="listing-price">
                        <span class="price-amount">Date d'achate: <?php echo $test['date_achat']; ?></span>

                    </div>
                </div>
            </a>
           <?php  } ?>
        </div>
    </div>
</body>
</html>