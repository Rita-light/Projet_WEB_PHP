-- Table Département
CREATE TABLE Departement (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Code VARCHAR(10) UNIQUE NOT NULL,
    Nom VARCHAR(100) NOT NULL,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Description TEXT
);

-- Table Utilisateur (tous les utilisateurs : étudiant, enseignant, coordonnateur, administrateur)
CREATE TABLE Utilisateur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    DateNaissance DATE NOT NULL,
    Email VARCHAR(75) UNIQUE NOT NULL,
    Password VARCHAR(255) NOT NULL,  -- Hashé + salé
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table Rôle (liste des rôles possibles)
CREATE TABLE Role (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) UNIQUE NOT NULL
);

-- Table Utilisateur_Role (relation plusieurs rôles par utilisateur)
CREATE TABLE Utilisateur_Role (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT NOT NULL,
    ID_Role INT NOT NULL,
    UNIQUE (ID_Utilisateur, ID_Role),
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateur(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Role) REFERENCES Role(ID) ON DELETE CASCADE
);


-- Table Professeur (lié à Utilisateur)
CREATE TABLE Professeur (
    ID INT PRIMARY KEY,  -- Correspond à Utilisateur(ID)
    DateEmbauche DATE NOT NULL,
    ID_Departement INT,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID) REFERENCES Utilisateur(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Departement) REFERENCES Departement(ID) ON DELETE SET NULL
);

-- Table Étudiant (lié à Utilisateur)
CREATE TABLE Etudiant (
    ID INT PRIMARY KEY,  -- Correspond à Utilisateur(ID)
    NumeroDA VARCHAR(20) UNIQUE,
    Avatar VARCHAR(255),
    DateInscription DATE NOT NULL DEFAULT CURRENT_DATE,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID) REFERENCES Utilisateur(ID) ON DELETE CASCADE
);

-- Table Cours
CREATE TABLE Cours (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Numero VARCHAR(20) UNIQUE NOT NULL,
    Nom VARCHAR(100) NOT NULL,
    Description TEXT,
    ID_Departement INT NOT NULL,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Departement) REFERENCES Departement(ID) ON DELETE CASCADE
);

-- Table Groupe (Un groupe correspond à un seul cours)
CREATE TABLE Groupe (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Numero VARCHAR(20) UNIQUE NOT NULL,
    Nom VARCHAR(100) NOT NULL,
    Description TEXT,
    ID_Cours INT NOT NULL,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Cours) REFERENCES Cours(ID) ON DELETE CASCADE
);

-- Table Groupe_Etudiant (relation entre Groupe et Étudiant)
CREATE TABLE Groupe_Etudiant (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Groupe INT NOT NULL,
    ID_Etudiant INT NOT NULL,
    FOREIGN KEY (ID_Groupe) REFERENCES Groupe(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Etudiant) REFERENCES Etudiant(ID) ON DELETE CASCADE,
    -- Un étudiant ne peut pas appartenir à deux groupes du même cours
    CONSTRAINT unique_etudiant_par_cours UNIQUE (ID_Etudiant, ID_Groupe)
);

-- Table Cours_Etudiant (relation entre Cours et Étudiant)
CREATE TABLE Cours_Etudiant (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Cours INT NOT NULL,
    ID_Etudiant INT NOT NULL,
    FOREIGN KEY (ID_Cours) REFERENCES Cours(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Etudiant) REFERENCES Etudiant(ID) ON DELETE CASCADE
);

-- Table Cours_Enseignant (relation entre Cours et Professeur)
CREATE TABLE Cours_Enseignant (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Professeur INT NOT NULL,
    ID_Cours INT NOT NULL,
    FOREIGN KEY (ID_Professeur) REFERENCES Professeur(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Cours) REFERENCES Cours(ID) ON DELETE CASCADE
    UNIQUE (ID_Professeur, ID_Cours)
);

CREATE TABLE Groupe_Professeur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Professeur INT NOT NULL,
    ID_Groupe INT NOT NULL,
    FOREIGN KEY (ID_Professeur) REFERENCES Professeur(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Groupe) REFERENCES Groupe(ID) ON DELETE CASCADE
);

CREATE TABLE TentativesConnexion (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL,
    AdresseIP VARCHAR(45),
    TentativeLe DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE JournalConnexion (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Utilisateur INT,
    AdresseIP VARCHAR(45),
    TypeEvenement ENUM('connexion', 'deconnexion', 'echec', 'erreur_securite') NOT NULL,
    Description TEXT,
    Moment DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Utilisateur) REFERENCES Utilisateur(ID) ON DELETE SET NULL
);



