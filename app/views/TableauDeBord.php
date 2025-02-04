<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Simulation élevage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Simulation de l'élevage</h1>
    <label for="dateSimulation">Date de simulation :</label>
    <input type="date" id="dateSimulation" name="dateSimulation">
    <button id="simuler">Simuler</button>

    <div id="resultatSimulation">
        <!-- Les résultats de la simulation seront affichés ici -->
    </div>

    <script>
        $(document).ready(function() {
            $('#simuler').click(function() {
                var dateSimulation = $('#dateSimulation').val();

                if (dateSimulation) {
                    $.ajax({
                        url: 'simulerElevage.php',
                        type: 'POST',
                        data: { dateSimulation: dateSimulation },
                        success: function(response) {
                            $('#resultatSimulation').html(response);
                        },
                        error: function() {
                            alert('Une erreur s\'est produite lors de la simulation.');
                        }
                    });
                } else {
                    alert('Veuillez sélectionner une date.');
                }
            });
        });
    </script>
</body>
</html>