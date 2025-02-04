<?php
namespace app\controllers;

use Flight;
use PDO;

class AutoVenteController {
    private $db;
    public function __construct() {
          // Change to Flight::db() instead of Flight::get('db')
    }

    public function updateAutoVente() {
        $this->db = Flight::db();

            if(isset($_POST['animal_id']) && isset($_POST['autoVente'])) {
                $animalId = $_POST['animal_id'];
                $autoVente = $_POST['autoVente'];
                
                $sql = "UPDATE elevage_animal 
                        SET autoVente = :autoVente 
                        WHERE id = :id";
                        
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([
                    ':autoVente' => $autoVente,
                    ':id' => $animalId
                ]);

                if($result) {
                    Flight::redirect('/elevage/list?success=update_success');
                } else {
                    Flight::redirect('/elevage/list?error=update_failed');
                }
            }
        }
}

?>