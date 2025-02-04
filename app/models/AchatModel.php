<?php

namespace app\models;

use Flight;
use PDO;

class AchatModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function achatAnimalTransaction(
        $nom,
        $poids_actuel,
        $date_achat,
        $est_vivant,
        $utilisateur_id,
        $type_animal_id,
        $vendeur_id,
        $animal_id,
        $prix,
        $quantite
    ) {
            $this->db->beginTransaction();

            // 1. Mettre à jour le propriétaire de l'animal
            $sql1 = "UPDATE elevage_animal 
SET utilisateur_id = :new_user_id 
WHERE id = :animal_id AND utilisateur_id = :vendeur_id";

            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute([
                ':new_user_id' => $utilisateur_id,
                ':animal_id' => $animal_id,
                ':vendeur_id' => $vendeur_id
            ]);

            // 2. Mettre à jour les capitaux
            $sql2 = "UPDATE elevage_utilisateur SET capital = capital + :prix WHERE id = :vendeur_id";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([
                ':prix' => $prix,
                ':vendeur_id' => $vendeur_id
            ]);

            $sql3 = "UPDATE elevage_utilisateur SET capital = capital - :prix WHERE id = :acheteur_id";
            $stmt3 = $this->db->prepare($sql3);
            $stmt3->execute([
                ':prix' => $prix,
                ':acheteur_id' => $utilisateur_id
            ]);

            // 3. Enregistrer la transaction
            $sql4 = "INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite)
VALUES ('vente', :montant, :date_transaction, :utilisateur_id, :animal_id, :quantite)";
            $stmt4 = $this->db->prepare($sql4);
            $stmt4->execute([
                ':montant' => $prix,
                ':date_transaction' => date('Y-m-d'),
                ':utilisateur_id' => $vendeur_id,
                ':animal_id' => $animal_id,
                ':quantite' => $quantite
            ]);

            $this->db->commit();
            return true;
        }
}
