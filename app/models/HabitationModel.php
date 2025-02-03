<?php
namespace app\models;
use flight;
use PDO;

class HabitationModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllType(){
        $sql =  "SELECT * FROM immo_types";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getAll() {
        $sql =  "SELECT h.*, (SELECT i.images FROM immo_images i WHERE i.idHabitation = h.idHabitation LIMIT 1) AS images,t.typehHabitation FROM immo_habitations h
        JOIN immo_types t ON h.idType = t.idType";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllImagesById($id){
        $sql = "SELECT * FROM immo_images WHERE IDHABITATION = $id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }



    public function uploadImg($files){
        $dossier = 'assets/images/';
        $fileName = time() . basename($files['name']);
        $fileName = strtr(
            $fileName,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
        );
        $fileName = preg_replace('/([^.a-z0-9]+)/i', '-', $fileName);
        $path = $dossier . $fileName;
        if (move_uploaded_file($files['tmp_name'], $path)) {
            return $path;
        }
    }
////ajout
    public function addImage($idHabitation, $images){
        foreach($images as $img){
            $pathImg = $this->uploadImg($img);
            $stmt = $this->conn->prepare("INSERT INTO immo_images (idHabitation,images) VALUES (?,?)");
            $stmt->execute([$idHabitation,$pathImg]);
        }
    }

    public function addHabitation($data) {
        $stmt = $this->conn->prepare("INSERT INTO immo_habitations (idType, nombreChambre, loyerJournalier, quartier, descriptions) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['type'], $data['chambres'], $data['loyer'], $data['quartier'], $data['description']]);
    }

    public function ajouterHabitation($data,$images) {
        $this->addHabitation($data);
        $idHabitation = $this->conn->lastInsertId();
    
        $this->addImage($idHabitation, $images);
        
        return true;
    }

/////modif
public function modifierHabitation($id,$data,$images,$idImage) {
    // $id = $_GET['id'];
    // $idImage = $_POST['idImage'];
    $data = array_filter([
        'type' => $_POST['type'] ?? null,
        'quartier' => $_POST['quartier'] ?? null,
        'chambres' => $_POST['chambres'] ?? null,
        'loyer' => $_POST['loyer'] ?? null,
        'description' => $_POST['description'] ?? null
    ]);

    $images = [];
    if (!empty($_FILES['image']['tmp_name'])) {
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            if (!empty($tmp_name)) {
                $images[] = [
                    'name' => $_FILES['image']['name'][$key],
                    'tmp_name' => $tmp_name
                ];
            }
        }
    }

    $habitationModel = new HabitationModel(Flight::db());
    $result = $habitationModel->updateHabitation($id, $data, $images,$idImage);

    $result ? Flight::redirect('../../modif?success=suc&&id='.$id) : Flight::halt(500, "Erreur de modification");
}

public function updateHabitation($idHabitation, $data, $images,$idImage) {
    $updateResult = true;
    $imageResult = true;

    if (!empty($data)) {
        $set = [];
        $params = [];
        $mapping = [
            'type' => 'idType',
            'chambres' => 'nombreChambre',
            'loyer' => 'loyerJournalier',
            'quartier' => 'quartier',
            'description' => 'descriptions'
        ];

        foreach ($mapping as $key => $column) {
            if (isset($data[$key])) {
                $set[] = "$column = ?";
                $params[] = $data[$key];
            }
        }

        $params[] = $idHabitation;
        $sql = "UPDATE immo_habitations SET " . implode(', ', $set) . " WHERE idHabitation = ?";
        $updateResult = $this->conn->prepare($sql)->execute($params);
    }

    if (!empty($images)) {
        foreach ($images as $img) {
            $pathImg = $this->uploadImg($img);
            //$stmt = $this->conn->prepare("INSERT INTO images (idHabitation, images) VALUES (?, ?)");
            $stmt = $this->conn->prepare("UPDATE images set images = ? WHERE idImage = ?");
            $imageResult = $stmt->execute([$pathImg, $idImage]);
        }
    }

    return $updateResult && $imageResult;
}
    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM immo_habitations WHERE idHabitation = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE immo_habitations SET typehHabitation = ?, nombreChambre = ?, loyerJournalier = ?, images = ?, quartier = ?, descriptions = ? WHERE idHabitation = ?");
        return $stmt->execute([$data['typehHabitation'], $data['nombreChambre'], $data['loyerJournalier'], $data['images'], $data['quartier'], $data['descriptions'], $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM immo_habitations WHERE idHabitation = ?");
        return $stmt->execute([$id]);
    }

////reservation 

public function isReserver($idHabitation, $dateArrivee, $dateDepart) {
    $sql = "SELECT * FROM immo_reservations 
            WHERE idHabitation = ? 
            AND (
                (dateArrivee BETWEEN ? AND ?) 
                OR (dateDepart BETWEEN ? AND ?)
                OR (? <= dateArrivee AND ? >= dateDepart)
            )";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        $idHabitation, 
        $dateArrivee, $dateDepart, 
        $dateArrivee, $dateDepart,
        $dateArrivee, $dateDepart
    ]);
    
    return $stmt->rowCount() > 0;
 }

    public function reservationHabitation($idHabitation,$userId,$dateDebut,$dateFin){
        $sql = "INSERT INTO immo_reservations (idUtilisateur,idHabitation,dateArrivee,dateDepart) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$userId,$idHabitation,$dateDebut,$dateFin]);
    }

}



?>