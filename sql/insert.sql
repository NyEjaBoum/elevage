INSERT INTO elevage_animal(image, nom, poids_actuel, date_achat, est_vivant, utilisateur_id, type_animal_id) VALUES
('assets/images/vache1.jpg', 'Vache Tachetée', 45.5, '2025-01-01', TRUE, 1, 1),
('assets/images/vache2.jpg', 'Vache Brune', 47.0, '2025-01-02', TRUE, 1, 1),
('assets/images/cochon1.jpg', 'Cochon Gris', 22.1, '2025-01-03', TRUE, 1, 2),
('assets/images/cochon2.jpg', 'Cochon Rose', 24.5, '2025-01-04', TRUE, 1, 2),
('assets/images/lapin1.jpg', 'Lapin Beige', 1.8, '2025-01-05', TRUE, 1, 3),
('assets/images/lapin2.jpg', 'Lapin Blanc', 2.0, '2025-01-06', TRUE, 1, 3),
('assets/images/mouton1.jpg', 'Mouton Blanc', 20.5, '2025-01-07', TRUE, 1, 4),
('assets/images/mouton2.jpg', 'Mouton Marron', 18.3, '2025-01-08', TRUE, 1, 4),
('assets/images/cheval1.jpg', 'Cheval Noir', 35.2, '2025-01-09', TRUE, 1, 5),
('assets/images/cheval2.jpg', 'Cheval Blanc', 37.8, '2025-01-10', TRUE, 1, 5),
('assets/images/poule1.jpg', 'Poule Rousse', 2.3, '2025-01-11', TRUE, 1, 6),
('assets/images/poule2.jpg', 'Poule Blanche', 2.8, '2025-01-12', TRUE, 1, 6);

INSERT INTO elevage_typeAnimal (nom, poids_minimal_vente, poids_maximal, prix_vente_kg, jours_sans_manger, pourcentage_perte_poids) VALUES
('Poulet', 1.5, 3.0, 5.00, 2, 10.00),
('Bœuf', 200.0, 600.0, 4.00, 5, 5.00),
('Mouton', 30.0, 80.0, 6.00, 3, 7.50);


INSERT INTO elevage_animal (nom, poids_actuel, date_achat, est_vivant, utilisateur_id, type_animal_id) VALUES
('Coco', 2.0, '2025-01-10', TRUE, 1, 1),
('Brutus', 250.0, '2025-01-05', TRUE, 2, 2),
('Dolly', 40.0, '2025-01-12', TRUE, 3, 3),
('Rocky', 500.0, '2025-01-08', TRUE, 1, 2),
('Plume', 1.8, '2025-01-15', TRUE, 2, 1);


INSERT INTO elevage_transactionAnimal (type_transaction, montant, date_transaction, utilisateur_id, animal_id, quantite) VALUES
('achat', 10.00, '2025-01-10', 1, 1, 1),
('achat', 1000.00, '2025-01-05', 2, 2, 1),
('achat', 150.00, '2025-01-12', 3, 3, 1),
('achat', 2000.00, '2025-01-08', 1, 4, 1),
('vente', 9.00, '2025-01-20', 1, 1, 1),
('achat_nourriture', 50.00, '2025-01-18', 2, NULL, 10.0);
