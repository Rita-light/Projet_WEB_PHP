<?php

define('HASH_COST', 12);

class Security {
    /**
     * Vérifier si l'utilisateur est connecté
     * @return bool True si l'utilisateur est connecté, sinon false
     */
    public static function isAuthenticated() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Hacher un mot de passe
     * @param string $password Le mot de passe en clair
     * @return string Le mot de passe haché
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => HASH_COST]);
    }
    
    /**
     * Vérifier un mot de passe
     * @param string $password Le mot de passe en clair
     * @param string $hash Le hash stocké dans la DB
     * @return bool True si le mot de passe correspond, sinon false
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Générer un jeton aléatoire
     * @param int $length Longueur du jeton
     * @return string Le jeton généré
     */
    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }
    
    /**
     * Générer un jeton CSRF et le stocker dans le session cookie
     * @return string Le jeton CSRF généré
     */
    public static function generateCSRFToken() {
        $token = self::generateToken();
        $_SESSION[CSRF_TOKEN_NAME] = $token;
        return $token;
    }
    
    /**
     * Vérifier un jeton CSRF
     * @param string $token Le jeton à vérifier
     * @return bool True si le jeton est valide, sinon false
     */
    public static function verifyCSRFToken($token) {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            return false;
        }
        
        $stored = $_SESSION[CSRF_TOKEN_NAME];
        
        return hash_equals($stored, $token);
    }
    
    /**
     * Nettoyer les entrées utilisateur
     * @param mixed $data Les données à nettoyer
     * @return mixed Les données nettoyées
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitize($value);
            }
            return $data;
        }
        
        // Convertir les caractères spéciaux en entités HTML
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Vérifier si une requête est une requête AJAX
     * @return bool True si c'est une requête AJAX, sinon false
     */
    public static function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Obtenir l'adresse IP du client
     * @return string L'adresse IP
     */
    public static function getClientIp() {
        $ip = '';
        
        // Récupérer l'IP via les headers pour les clients derrière un proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        }
        
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
    
    /**
     * Enregistrer une action de sécurité dans les logs
     * @param string $action L'action effectuée
     * @param string|null $details Détails supplémentaires
     * @param int|null $userId ID de l'utilisateur concerné
     */
    public static function logSecurityAction($action, $details = null, $userId = null) {
        $db = Database::getInstance();
        
        $data = [
            'utilisateur_id' => $userId,
            'ip_address' => self::getClientIp(),
            'action' => $action,
            'details' => $details
        ];
        
        $db->insert('securite_logs', $data);
    }
    
    /**
     * Valider les données soumises par l'utilisateur
     * @param array $data Les données à valider
     * @param array $rules Les règles de validation (champ => règle)
     * @return array Tableau des erreurs de validation (vide si aucune erreur)
     */
    public static function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            // Vérifier si le champ existe
            if (!isset($data[$field])) {
                $errors[$field] = "Le champ est requis";
                continue;
            }
            
            $value = $data[$field];
            
            // Vérifier les règles
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "Le champ est requis";
            }
            
            if (strpos($rule, 'email') !== false && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "L'adresse email n'est pas valide";
            }
            
            if (preg_match('/min:(\d+)/', $rule, $matches) && strlen($value) < $matches[1]) {
                $errors[$field] = "Le champ doit contenir au moins {$matches[1]} caractères";
            }
            
            if (preg_match('/max:(\d+)/', $rule, $matches) && strlen($value) > $matches[1]) {
                $errors[$field] = "Le champ ne doit pas dépasser {$matches[1]} caractères";
            }
        }
        
        return $errors;
    }
    
    /**
     * Générer un mot de passe aléatoire sécurisé
     * @param int $length Longueur du mot de passe
     * @return string Le mot de passe généré
     */
    public static function generateRandomPassword($length = 16) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        return $password;
    }
    
    /**
     * Générer un token API
     * @return string Le token API généré
     */
    public static function generateApiToken() {
        return self::generateToken(64);
    }
    
    /**
     * Valider un token API
     * @param string $token Le token à valider
     * @return array|false Les données de l'utilisateur si le token est valide, sinon false
     */
    public static function validateApiToken($token) {
        $db = Database::getInstance();
        
        $sql = "SELECT a.*, u.* FROM api_tokens a 
                JOIN utilisateurs u ON a.utilisateur_id = u.id 
                WHERE a.token = :token AND a.actif = 1 
                AND (a.date_expiration IS NULL OR a.date_expiration > NOW())";
        
        $result = $db->fetchOne($sql, ['token' => $token]);
        
        return $result ? $result : false;
    }
}