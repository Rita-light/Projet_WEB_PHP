


INSERT INTO Departement (Code, Nom, Description)
VALUES
('INFO', 'Informatique', 'Département d\'Informatique, offrant des cours sur les langages de programmation, l\'algorithmique, et la gestion de projets informatiques.'),
('MATH', 'Mathématiques', 'Département de Mathématiques, offrant des cours en mathématiques pures et appliquées, avec une spécialisation en analyse et algèbre.'),
('PHYS', 'Physique', 'Département de Physique, abordant les concepts de la mécanique, de la thermodynamique et de la physique quantique.'),
('CHIM', 'Chimie', 'Département de Chimie, comprenant des cours sur la chimie organique, inorganique et les sciences des matériaux.'),
('BIO', 'Biologie', 'Département de Biologie, couvrant des domaines tels que la biologie cellulaire, la génétique et l\'écologie.'),
('GEN', 'Génie', 'Département de Génie, avec des cours sur l\'électronique, les systèmes mécaniques, et les projets de génie civil.'),
('ECO', 'Economie', 'Département d\'Economie, avec des cours sur la microéconomie, la macroéconomie et les politiques économiques.'),
('MEC', 'Mécanique', 'Département de Mécanique, offrant des cours sur la dynamique, la statique et la thermodynamique appliquées.'),
('SOCI', 'Sociologie', 'Département de Sociologie, proposant des cours sur les théories sociologiques, la recherche sociale et les inégalités sociales.'),
('PHIL', 'Philosophie', 'Département de Philosophie, couvrant l\'épistémologie, l\'éthique, et l\'histoire de la philosophie.');



INSERT INTO Professeur (Nom, Prenom, DateNaissance, Email, DateEmbauche, Password, Coordonnateur, ID_Departement, DateCreation, DateModification)
VALUES
('Lemoine', 'Alice', '1980-05-15', 'alice.lemoine1@example.com', '2015-08-01', 'password123', FALSE, 1, NOW(), NOW()),
('Martin', 'Pierre', '1975-12-10', 'pierre.martin2@example.com', '2010-01-12', 'password123', FALSE, 2, NOW(), NOW()),
('Dupont', 'Jean', '1982-11-25', 'jean.dupont3@example.com', '2016-09-19', 'password123', TRUE, 3, NOW(), NOW()),
('Dufresne', 'Chantal', '1984-06-20', 'chantal.dufresne4@example.com', '2017-03-30', 'password123', FALSE, 4, NOW(), NOW()),
('Girard', 'Luc', '1980-09-05', 'luc.girard5@example.com', '2013-02-11', 'password123', FALSE, 1, NOW(), NOW()),
('Benoit', 'Sophie', '1990-03-25', 'sophie.benoit6@example.com', '2019-07-18', 'password123', TRUE, 2, NOW(), NOW()),
('Lefevre', 'Marc', '1978-10-22', 'marc.lefevre7@example.com', '2014-11-08', 'password123', FALSE, 3, NOW(), NOW()),
('Mercier', 'Sylvie', '1983-01-15', 'sylvie.mercier8@example.com', '2015-06-21', 'password123', FALSE, 4, NOW(), NOW()),
('Leclerc', 'François', '1977-07-30', 'francois.leclerc9@example.com', '2011-09-03', 'password123', FALSE, 1, NOW(), NOW()),
('Bertrand', 'Isabelle', '1987-04-19', 'isabelle.bertrand10@example.com', '2018-05-10', 'password123', TRUE, 2, NOW(), NOW()),
('Durand', 'Thierry', '1985-03-12', 'thierry.durand11@example.com', '2016-01-17', 'password123', FALSE, 3, NOW(), NOW()),
('Robert', 'Claire', '1991-02-07', 'claire.robert12@example.com', '2020-08-24', 'password123', FALSE, 4, NOW(), NOW()),
('Thomas', 'Sébastien', '1979-06-04', 'sebastien.thomas13@example.com', '2012-04-23', 'password123', FALSE, 1, NOW(), NOW()),
('Rousseau', 'Jacques', '1983-09-28', 'jacques.rousseau14@example.com', '2014-01-05', 'password123', TRUE, 2, NOW(), NOW()),
('Muller', 'Éric', '1989-11-17', 'eric.muller15@example.com', '2018-02-22', 'password123', FALSE, 3, NOW(), NOW()),
('Faure', 'Élise', '1986-12-30', 'elise.faure16@example.com', '2017-09-09', 'password123', FALSE, 4, NOW(), NOW()),
('Boucher', 'Bernard', '1981-03-14', 'bernard.boucher17@example.com', '2012-05-10', 'password123', FALSE, 1, NOW(), NOW()),
('Jacques', 'Nadine', '1988-06-01', 'nadine.jacques18@example.com', '2019-10-15', 'password123', TRUE, 2, NOW(), NOW()),
('Blanc', 'Gérard', '1980-02-25', 'gerard.blanc19@example.com', '2013-11-22', 'password123', FALSE, 3, NOW(), NOW()),
('Simon', 'Marie', '1987-08-18', 'marie.simon20@example.com', '2015-04-14', 'password123', FALSE, 4, NOW(), NOW()),
('Renard', 'Pierre', '1975-10-30', 'pierre.renard21@example.com', '2010-01-10', 'password123', FALSE, 1, NOW(), NOW()),
('Perrot', 'Jacqueline', '1984-04-23', 'jacqueline.perrot22@example.com', '2016-12-19', 'password123', TRUE, 2, NOW(), NOW()),
('Lemoine', 'Michel', '1976-11-06', 'michel.lemoine23@example.com', '2011-02-13', 'password123', FALSE, 3, NOW(), NOW()),
('Charpentier', 'Lucie', '1990-07-17', 'lucie.charpentier24@example.com', '2020-04-11', 'password123', FALSE, 4, NOW(), NOW()),
('Meyer', 'Henri', '1983-12-03', 'henri.meyer25@example.com', '2014-06-25', 'password123', FALSE, 1, NOW(), NOW()),
('Lemoine', 'Pierre', '1979-09-22', 'pierre.lemoine26@example.com', '2011-10-09', 'password123', FALSE, 2, NOW(), NOW()),
('Faure', 'Sophie', '1985-05-10', 'sophie.faure27@example.com', '2016-03-29', 'password123', FALSE, 3, NOW(), NOW()),
('Girard', 'Vincent', '1988-09-02', 'vincent.girard28@example.com', '2019-02-17', 'password123', TRUE, 4, NOW(), NOW()),
('Lemoine', 'Patricia', '1982-08-14', 'patricia.lemoine29@example.com', '2015-05-25', 'password123', FALSE, 1, NOW(), NOW()),
('Martin', 'Jacques', '1977-01-29', 'jacques.martin30@example.com', '2010-08-16', 'password123', FALSE, 2, NOW(), NOW());


INSERT INTO Cours (Numero, Nom, Description, ID_Departement)
VALUES
('INF1001', 'Introduction à la programmation', 'Ce cours introduit les bases de la programmation informatique, y compris les algorithmes, les structures de données et les langages de programmation.', 1),
('MAT1002', 'Mathématiques Discrètes', 'Ce cours porte sur les concepts fondamentaux des mathématiques discrètes, y compris la logique, les ensembles, les graphes, et la théorie des nombres.', 2),
('INF1003', 'Bases de données', 'Ce cours couvre les bases de données relationnelles, la conception des bases de données, le langage SQL, et la gestion des données.', 1),
('INF1004', 'Algorithmique avancée', 'Ce cours traite des algorithmes avancés, de la complexité des algorithmes et des structures de données avancées.', 1),
('PHY1001', 'Physique 1', 'Introduction aux principes fondamentaux de la physique, y compris la mécanique, la thermodynamique et l\'optique.', 3),
('CHM1001', 'Chimie générale', 'Les bases de la chimie générale, y compris les atomes, les molécules, les réactions chimiques et les lois fondamentales.', 3),
('COM1001', 'Communication scientifique', 'Ce cours enseigne comment communiquer efficacement dans le domaine scientifique, y compris la rédaction et la présentation orale.', 2),
('ECO1001', 'Introduction à l\'économie', 'Ce cours introduit les principes fondamentaux de l\'économie, y compris l\'offre, la demande, les marchés, et les mécanismes économiques.', 4),
('PSY1001', 'Psychologie 1', 'Ce cours explore les bases de la psychologie, y compris les théories, les modèles comportementaux et la psychologie cognitive.', 5),
('DRO1001', 'Introduction au droit', 'Ce cours présente les principes de base du droit, y compris le droit civil, le droit pénal, et le droit constitutionnel.', 6),
('MKT1001', 'Marketing', 'Les principes du marketing, y compris l\'analyse du marché, la segmentation et la stratégie marketing.', 4),
('GEP1001', 'Gestion de projet', 'Ce cours enseigne les bases de la gestion de projet, y compris la planification, l\'exécution et le suivi des projets.', 4),
('ECO2001', 'Économie internationale', 'Une introduction à l\'économie internationale, y compris les échanges commerciaux, les politiques économiques internationales et la mondialisation.', 2),
('ECO2002', 'Analyse des systèmes économiques', 'Ce cours analyse les systèmes économiques, en se concentrant sur les économies de marché et les systèmes économiques planifiés.', 2),
('ART1001', 'Histoire de l\'art', 'Introduction à l\'histoire de l\'art, des périodes classiques aux mouvements contemporains, et étude des œuvres d\'art célèbres.', 7),
('MUS1001', 'Musique et culture', 'Étude des liens entre musique et culture à travers les âges, en explorant l\'évolution des genres musicaux.', 7),
('SOC1001', 'Sociologie 1', 'Introduction à la sociologie, y compris l\'étude des structures sociales, des institutions et des comportements humains.', 5),
('GEO1001', 'Géographie physique', 'Ce cours explore les éléments fondamentaux de la géographie physique, y compris les phénomènes naturels et les paysages.', 3),
('BIO1001', 'Biologie cellulaire', 'Introduction à la biologie cellulaire, y compris la structure des cellules, leur fonction et leur reproduction.', 3),
('STA1001', 'Statistiques pour les sciences sociales', 'Ce cours couvre les bases des statistiques appliquées aux sciences sociales, y compris l\'analyse des données et les tests statistiques.', 5),
('INF2001', 'Introduction à l\'intelligence artificielle', 'Ce cours offre une introduction aux concepts et techniques de l\'intelligence artificielle, y compris les algorithmes de machine learning.', 1),
('PHI1001', 'Philosophie 1', 'Introduction à la philosophie, avec un accent particulier sur la pensée grecque antique et les grands courants philosophiques.', 6),
('ETH1001', 'Ethique et responsabilité', 'Étude de l\'éthique et des responsabilités dans les différents contextes professionnels et sociaux.', 6),
('ECO3001', 'Microéconomie', 'Ce cours explore la microéconomie, en se concentrant sur les décisions des consommateurs et des producteurs et l\'équilibre du marché.', 2),
('ECO3002', 'Macroéconomie', 'Ce cours traite des principes de la macroéconomie, y compris le produit intérieur brut, l\'inflation, et les politiques économiques globales.', 2),
('INF3001', 'Sécurité informatique', 'Ce cours aborde les principes de la sécurité informatique, les menaces et les stratégies de défense contre les attaques.', 1),
('GRH1001', 'Gestion des ressources humaines', 'Ce cours couvre les bases de la gestion des ressources humaines, y compris le recrutement, la formation, et la gestion des performances des employés.', 4),
('MAT2001', 'Mathématiques pour économistes', 'Les mathématiques appliquées aux problèmes économiques, y compris les fonctions, les dérivées et les équations différentielles.', 2),
('FIN1001', 'Introduction à la gestion financière', 'Ce cours couvre les principes de la gestion financière, y compris l\'analyse financière, les décisions d\'investissement et la gestion des risques.', 4),
('DRO1002', 'Droit des affaires', 'Introduction au droit des affaires, y compris les contrats, les sociétés commerciales, et la réglementation des entreprises.', 6);


INSERT INTO Groupe (Numero, Nom, Description, ID_Cours)
VALUES
('G1-INF1001', 'Groupe 1 - Introduction à la programmation', 'Premier groupe pour le cours d\'Introduction à la programmation.', 1),
('G2-INF1001', 'Groupe 2 - Introduction à la programmation', 'Deuxième groupe pour le cours d\'Introduction à la programmation.', 1),
('G1-MAT1002', 'Groupe 1 - Mathématiques Discrètes', 'Premier groupe pour le cours de Mathématiques Discrètes.', 2),
('G2-MAT1002', 'Groupe 2 - Mathématiques Discrètes', 'Deuxième groupe pour le cours de Mathématiques Discrètes.', 2),
('G1-INF1003', 'Groupe 1 - Bases de données', 'Premier groupe pour le cours de Bases de données.', 3),
('G2-INF1003', 'Groupe 2 - Bases de données', 'Deuxième groupe pour le cours de Bases de données.', 3),
('G1-INF1004', 'Groupe 1 - Algorithmique avancée', 'Premier groupe pour le cours d\'Algorithmique avancée.', 4),
('G2-INF1004', 'Groupe 2 - Algorithmique avancée', 'Deuxième groupe pour le cours d\'Algorithmique avancée.', 4),
('G1-PHY1001', 'Groupe 1 - Physique 1', 'Premier groupe pour le cours de Physique 1.', 5),
('G2-PHY1001', 'Groupe 2 - Physique 1', 'Deuxième groupe pour le cours de Physique 1.', 5),
('G1-CHM1001', 'Groupe 1 - Chimie générale', 'Premier groupe pour le cours de Chimie générale.', 6),
('G2-CHM1001', 'Groupe 2 - Chimie générale', 'Deuxième groupe pour le cours de Chimie générale.', 6),
('G1-COM1001', 'Groupe 1 - Communication scientifique', 'Premier groupe pour le cours de Communication scientifique.', 7),
('G2-COM1001', 'Groupe 2 - Communication scientifique', 'Deuxième groupe pour le cours de Communication scientifique.', 7),
('G1-ECO1001', 'Groupe 1 - Introduction à l\'économie', 'Premier groupe pour le cours d\'Introduction à l\'économie.', 8),
('G2-ECO1001', 'Groupe 2 - Introduction à l\'économie', 'Deuxième groupe pour le cours d\'Introduction à l\'économie.', 8),
('G1-PSY1001', 'Groupe 1 - Psychologie 1', 'Premier groupe pour le cours de Psychologie 1.', 9),
('G2-PSY1001', 'Groupe 2 - Psychologie 1', 'Deuxième groupe pour le cours de Psychologie 1.', 9),
('G1-DRO1001', 'Groupe 1 - Introduction au droit', 'Premier groupe pour le cours d\'Introduction au droit.', 10),
('G2-DRO1001', 'Groupe 2 - Introduction au droit', 'Deuxième groupe pour le cours d\'Introduction au droit.', 10),
('G1-MKT1001', 'Groupe 1 - Marketing', 'Premier groupe pour le cours de Marketing.', 11),
('G2-MKT1001', 'Groupe 2 - Marketing', 'Deuxième groupe pour le cours de Marketing.', 11),
('G1-GEP1001', 'Groupe 1 - Gestion de projet', 'Premier groupe pour le cours de Gestion de projet.', 12),
('G2-GEP1001', 'Groupe 2 - Gestion de projet', 'Deuxième groupe pour le cours de Gestion de projet.', 12),
('G1-ECO2001', 'Groupe 1 - Économie internationale', 'Premier groupe pour le cours d\'Économie internationale.', 13),
('G2-ECO2001', 'Groupe 2 - Économie internationale', 'Deuxième groupe pour le cours d\'Économie internationale.', 13),
('G1-ECO2002', 'Groupe 1 - Analyse des systèmes économiques', 'Premier groupe pour le cours d\'Analyse des systèmes économiques.', 14),
('G2-ECO2002', 'Groupe 2 - Analyse des systèmes économiques', 'Deuxième groupe pour le cours d\'Analyse des systèmes économiques.', 14),
('G1-ART1001', 'Groupe 1 - Histoire de l\'art', 'Premier groupe pour le cours d\'Histoire de l\'art.', 15),
('G2-ART1001', 'Groupe 2 - Histoire de l\'art', 'Deuxième groupe pour le cours d\'Histoire de l\'art.', 15),
('G1-MUS1001', 'Groupe 1 - Musique et culture', 'Premier groupe pour le cours de Musique et culture.', 16),
('G2-MUS1001', 'Groupe 2 - Musique et culture', 'Deuxième groupe pour le cours de Musique et culture.', 16),
('G1-SOC1001', 'Groupe 1 - Sociologie 1', 'Premier groupe pour le cours de Sociologie 1.', 17),
('G2-SOC1001', 'Groupe 2 - Sociologie 1', 'Deuxième groupe pour le cours de Sociologie 1.', 17),
('G1-GEO1001', 'Groupe 1 - Géographie physique', 'Premier groupe pour le cours de Géographie physique.', 18),
('G2-GEO1001', 'Groupe 2 - Géographie physique', 'Deuxième groupe pour le cours de Géographie physique.', 18),
('G1-BIO1001', 'Groupe 1 - Biologie cellulaire', 'Premier groupe pour le cours de Biologie cellulaire.', 19),
('G2-BIO1001', 'Groupe 2 - Biologie cellulaire', 'Deuxième groupe pour le cours de Biologie cellulaire.', 19),
('G1-STA1001', 'Groupe 1 - Statistiques pour les sciences sociales', 'Premier groupe pour le cours de Statistiques pour les sciences sociales.', 20),
('G2-STA1001', 'Groupe 2 - Statistiques pour les sciences sociales', 'Deuxième groupe pour le cours de Statistiques pour les sciences sociales.', 20),
('G1-INF2001', 'Groupe 1 - Introduction à l\'intelligence artificielle', 'Premier groupe pour le cours d\'Introduction à l\'intelligence artificielle.', 21),
('G2-INF2001', 'Groupe 2 - Introduction à l\'intelligence artificielle', 'Deuxième groupe pour le cours d\'Introduction à l\'intelligence artificielle.', 21),
('G1-PHI1001', 'Groupe 1 - Philosophie 1', 'Premier groupe pour le cours de Philosophie 1.', 22),
('G2-PHI1001', 'Groupe 2 - Philosophie 1', 'Deuxième groupe pour le cours de Philosophie 1.', 22),
('G1-ETH1001', 'Groupe 1 - Ethique et responsabilité', 'Premier groupe pour le cours d\'Ethique et responsabilité.', 23),
('G2-ETH1001', 'Groupe 2 - Ethique et responsabilité', 'Deuxième groupe pour le cours d\'Ethique et responsabilité.', 23),
('G1-ECO3001', 'Groupe 1 - Microéconomie', 'Premier groupe pour le cours de Microéconomie.', 24),
('G2-ECO3001', 'Groupe 2 - Microéconomie', 'Deuxième groupe pour le cours de Microéconomie.', 24),
('G1-ECO3002', 'Groupe 1 - Macroéconomie', 'Premier groupe pour le cours de Macroéconomie.', 25),
('G2-ECO3002', 'Groupe 2 - Macroéconomie', 'Deuxième groupe pour le cours de Macroéconomie.', 25),
('G1-INF3001', 'Groupe 1 - Sécurité informatique', 'Premier groupe pour le cours de Sécurité informatique.', 26),
('G2-INF3001', 'Groupe 2 - Sécurité informatique', 'Deuxième groupe pour le cours de Sécurité informatique.', 26),
('G1-GRH1001', 'Groupe 1 - Gestion des ressources humaines', 'Premier groupe pour le cours de Gestion des ressources humaines.', 27),
('G2-GRH1001', 'Groupe 2 - Gestion des ressources humaines', 'Deuxième groupe pour le cours de Gestion des ressources humaines.', 27),
('G1-MAT2001', 'Groupe 1 - Mathématiques pour économistes', 'Premier groupe pour le cours de Mathématiques pour économistes.', 28),
('G2-MAT2001', 'Groupe 2 - Mathématiques pour économistes', 'Deuxième groupe pour le cours de Mathématiques pour économistes.', 28),
('G1-FIN1001', 'Groupe 1 - Introduction à la gestion financière', 'Premier groupe pour le cours d\'Introduction à la gestion financière.', 29),
('G2-FIN1001', 'Groupe 2 - Introduction à la gestion financière', 'Deuxième groupe pour le cours d\'Introduction à la gestion financière.', 29),
('G1-DRO1002', 'Groupe 1 - Droit des affaires', 'Premier groupe pour le cours de Droit des affaires.', 30),
('G2-DRO1002', 'Groupe 2 - Droit des affaires', 'Deuxième groupe pour le cours de Droit des affaires.', 30);




INSERT INTO Cours_Enseignant (ID_Professeur, ID_Cours)
VALUES 
(1, 1),
(1, 4),
(15, 5),
(23, 6),
(27, 19),
(11, 18),
(2, 2),
(2, 28),
(14, 13),
(22, 14);



INSERT INTO Groupe_Professeur (ID_Professeur, ID_Groupe)
VALUES 
(1, 1),
(1, 2),
(1, 7),
(15, 9),
(15, 10),
(27, 37),
(19, 38),
(2, 3),
(2, 4),
(2, 55),
(22, 27);




