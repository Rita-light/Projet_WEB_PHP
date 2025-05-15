<?php

class Validation { 
    private $errors = []; 

    // Vérifie si une valeur est non vide
    public function required($value, $field) { 
        if (empty(trim($value))) { 
            $this->errors[$field] = "Le champ $field est obligatoire."; 
            return false; 
        } 
        return true; 
    }

    // Nettoie une valeur pour prévenir les injections XSS
    public function sanitizeInput($value) { 
        $value = trim($value);
        $value = strip_tags($value); // Supprime les balises HTML
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); 
    }

    // Vérifie la longueur maximale d'une entrée
    public function maxLength($value, $field, $maxLength) {
        if (strlen($value) > $maxLength) {
            $this->errors[$field] = "Le champ $field ne peut pas dépasser $maxLength caractères.";
            return false;
        }
        return true;
    }

    // Vérifie si un email est valide
    public function validEmail($value, $field) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Le champ $field doit être une adresse email valide.";
            return false;
        }
        return true;
    }

    // Vérifie la longueur minimale du mot de passe
    public function minLength($value, $field, $minLength) {
        if (strlen($value) < $minLength) {
            $this->errors[$field] = "Le champ $field doit contenir au moins $minLength caractères.";
            return false;
        }
        return true;
    }

    // Gestion des erreurs
    public function fails() {
        return !empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }




    public function estBloque($dbConnection, $email, $ip) {
        $sqlTentatives = "SELECT COUNT(*) FROM TentativesConnexion 
                        WHERE Email = :email 
                            AND AdresseIP = :ip 
                            AND TentativeLe > (NOW() - INTERVAL 5 MINUTE)";
        
        $stmtTentatives = $dbConnection->prepare($sqlTentatives);
        $stmtTentatives->execute([
            ':email' => $email, 
            ':ip' => $ip
        ]);
        
        $nbTentatives = $stmtTentatives->fetchColumn();

        return $nbTentatives >= 3;
    }


    // Enregistre une tentative échouée
    public function enregistrerTentative($db, $email, $ip) {
        $sql = "INSERT INTO TentativesConnexion (Email, AdresseIP) VALUES (:email, :ip)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':ip' => $ip
        ]);
    }


    // Réinitialise les tentatives après une connexion réussie
    public function reinitialiserTentatives() {
        $sql = "DELETE FROM TentativesConnexion WHERE Email = :email AND AdresseIP = :ip";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $this->email,
            ':ip' => $this->ip
        ]);
    }



}








