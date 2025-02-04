-- Insérer des utilisateurs dans la table elevage_utilisateur
INSERT INTO elevage_utilisateur (nom, mdp, capital) VALUES
('Utilisateur1', 'motdepasse1', 1000.00),
('Utilisateur2', 'motdepasse2', 1500.00),
('Utilisateur3', 'motdepasse3', 2000.00);

INSERT INTO elevage_typeAnimal (nom, poids_minimal_vente, poids_maximal, prix_vente_kg, jours_sans_manger, pourcentage_perte_poids) VALUES
('Vache', 40.0, 60.0, 5.00, 7, 2.5),
('Cochon', 20.0, 30.0, 3.50, 5, 3.0),
('Lapin', 1.5, 2.5, 10.00, 3, 1.5),
('Mouton', 15.0, 25.0, 4.00, 6, 2.0),
('Cheval', 30.0, 50.0, 8.00, 10, 1.0),
('Poule', 1.0, 2.0, 12.00, 2, 1.0);

-- Insérer des animaux dans la table elevage_animal
INSERT INTO elevage_animal (nom, poids_actuel, date_achat, est_vivant, utilisateur_id, type_animal_id,quantite) VALUES
('Vache Tachetée', 45.5, '2025-01-01', TRUE, 1, 1,1),
('Vache Brune', 47.0, '2025-01-02', TRUE, 1, 1,5),
('Cochon Gris', 22.1, '2025-01-03', TRUE, 1, 2,3),
('Cochon Rose', 24.5, '2025-01-04', TRUE, 1, 2,4),
('Lapin Beige', 1.8, '2025-01-05', TRUE, 1, 3,1),
('Lapin Blanc', 2.0, '2025-01-06', TRUE, 1, 3,1),
('Mouton Blanc', 20.5, '2025-01-07', TRUE, 1, 4,2),
('Mouton Marron', 18.3, '2025-01-08', TRUE, 1, 4,4),
('Cheval Noir', 35.2, '2025-01-09', TRUE, 1, 5,1),
('Cheval Blanc', 37.8, '2025-01-10', TRUE, 1, 5,1),
('Poule Rousse', 2.3, '2025-01-11', TRUE, 1, 6,2),
('Poule Blanche', 2.8, '2025-01-12', TRUE, 1, 6,3);

-- Insérer des transactions dans la table elevage_transactionAnimal
INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite) VALUES
('achat', 10.00, '2025-01-10', 1, 1, 1),
('achat', 1000.00, '2025-01-05', 2, 2, 1),
('achat', 150.00, '2025-01-12', 3, 3, 1),
('achat', 2000.00, '2025-01-08', 1, 4, 1),
('vente', 9.00, '2025-01-20', 1, 1, 1),
('achat_nourriture', 50.00, '2025-01-18', 2, NULL, 10.0);

-- Nourriture pour les vaches (type_animal_id = 1)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Foin pour vaches', 1, 1.5, 0.50, 100.0), -- Foin pour vaches = 1)
('Aliment concentré pour vaches', 1, 2.0, 1.20, 50.0); -- Aliment concentré pour vaches = 2)

-- Nourriture pour les cochons (type_animal_id = 2)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Mélange pour cochons', 2, 1.8, 0.80, 80.0), -- Mélange pour cochons = 1)
('Granulés pour cochons', 2, 2.2, 1.50, 40.0); -- Granulés pour cochons = 3)

-- Nourriture pour les lapins (type_animal_id = 3)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Granulés pour lapins', 3, 2.0, 1.20, 30.0), -- Granulés pour lapins = 1)
('Foin pour lapins', 3, 1.0, 0.40, 60.0); -- Foin pour lapins = 2)

-- Nourriture pour les moutons (type_animal_id = 4)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Foin pour moutons', 4, 1.2, 0.60, 70.0), -- Foin pour moutons = 1)
('Aliment pour moutons', 4, 1.5, 1.00, 50.0); -- Aliment pour moutons = 3)

-- Nourriture pour les chevaux (type_animal_id = 5)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Foin pour chevaux', 5, 1.0, 0.70, 90.0), -- Foin pour chevaux = 1)
('Granulés pour chevaux', 5, 1.8, 1.50, 40.0); -- Granulés pour chevaux = 2)

-- Nourriture pour les poules (type_animal_id = 6)
INSERT INTO elevage_nourriture (nom, type_animal_id, pourcentage_gain_poids, prix_kg, stock) VALUES
('Mélange pour poules', 6, 1.0, 0.80, 50.0), -- Mélange pour poules = 1)
('Graines pour poules', 6, 1.2, 1.00, 30.0); -- Graines pour poules = 3)