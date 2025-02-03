CREATE DATABASE elevage;
USE elevage;

CREATE TABLE elevage_utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom TEXT,
    mdp TEXT,
    capital DECIMAL(10, 2) NOT NULL
);

CREATE TABLE elevage_typeAnimal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    poids_minimal_vente DECIMAL(10, 2) NOT NULL,
    poids_maximal DECIMAL(10, 2) NOT NULL,
    prix_vente_kg DECIMAL(10, 2) NOT NULL,
    jours_sans_manger INT NOT NULL,
    pourcentage_perte_poids DECIMAL(5, 2) NOT NULL
);

CREATE TABLE elevage_animal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(100),
    nom VARCHAR(50),
    poids_actuel DECIMAL(10, 2) NOT NULL,
    date_achat DATE NOT NULL,
    est_vivant BOOLEAN DEFAULT TRUE,
    utilisateur_id INT,
    type_animal_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES elevage_utilisateur(id),
    FOREIGN KEY (type_animal_id) REFERENCES elevage_typeAnimal(id)
);


CREATE TABLE elevage_transactionAnimal (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type_transaction ENUM('achat', 'vente', 'achat_nourriture') NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    date_transaction DATE NOT NULL,
    utilisateur_id INT,
    animal_id INT,
    quantite DECIMAL(10, 2),
    FOREIGN KEY (utilisateur_id) REFERENCES elevage_utilisateur(id),
    FOREIGN KEY (animal_id) REFERENCES elevage_animal(id)
);

CREATE TABLE elevage_nourriture (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL, -- Nom de la nourriture (ex: "Foin", "Granulés pour lapins")
    type_animal_id INT NOT NULL, -- Type d'animal associé à cette nourriture
    pourcentage_gain_poids DECIMAL(5, 2) NOT NULL, -- % de gain de poids par jour
    prix_kg DECIMAL(10, 2) NOT NULL, -- Prix au kg de la nourriture
    stock DECIMAL(10, 2) NOT NULL DEFAULT 0, -- Stock disponible en kg
    utilisateur_id INT NOT NULL, -- Utilisateur propriétaire de la nourriture
    FOREIGN KEY (type_animal_id) REFERENCES elevage_typeAnimal(id),
    FOREIGN KEY (utilisateur_id) REFERENCES elevage_utilisateur(id)
);