

-- Table Département
CREATE TABLE Departement (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Code VARCHAR(10) UNIQUE NOT NULL,
    Nom VARCHAR(100) NOT NULL,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Description TEXT
);

-- Table Étudiant
CREATE TABLE Etudiant (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NumeroDA VARCHAR(20) UNIQUE,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    DateNaissance DATE NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Avatar VARCHAR(255),  -- Stocke le chemin de l'image
    DateInscription DATE NOT NULL DEFAULT CURRENT_DATE,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Password VARCHAR(255) NOT NULL
);

-- Table Professeur
CREATE TABLE Professeur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(50) NOT NULL,
    Prenom VARCHAR(50) NOT NULL,
    DateNaissance DATE NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    DateEmbauche DATE NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Coordonnateur BOOLEAN DEFAULT FALSE,
    ID_Departement INT,
    DateCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    DateModification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Departement) REFERENCES Departement(ID) ON DELETE SET NULL
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
);

CREATE TABLE Groupe_Professeur (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Professeur INT NOT NULL,
    ID_Groupe INT NOT NULL,
    FOREIGN KEY (ID_Professeur) REFERENCES Professeur(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Groupe) REFERENCES Groupe(ID) ON DELETE CASCADE
);


