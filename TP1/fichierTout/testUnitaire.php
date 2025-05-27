<?php
require_once '../lib/Security.php';
require_once '../lib/Validation.php';
session_start();





// -------------------------------
// SECTION 1 : TEST DU HACHAGE ET DE LA VÉRIFICATION DE MOT DE PASSE
// -------------------------------

echo "==== Tests sur les mots de passe ====\n" . "<br>\n";

// Cas 1 : Mot de passe valide
$password = "MonMot2PasseSecurisé!";
$hash = Security::hashPassword($password);
echo "<br>\n- Hash généré : $hash\n";

// Vérification correcte
if (Security::verifyPassword($password, $hash)) {
    echo "<br>\n[O] Vérification mot de passe correcte : OK\n";
} else {
    echo "<br>\n[X] Vérification mot de passe correcte : ÉCHEC\n";
}

// Vérification incorrecte
if (Security::verifyPassword("mauvaismotdepasse", $hash)) {
    echo "<br>\n[O] Vérification mot de passe incorrect : OK\n";
} else {
    echo "<br>\n[X] Vérification mot de passe incorrect : ÉCHEC <br>\n";
}

// -------------------------------
// SECTION 2 : TEST DU JETON CSRF
// -------------------------------

echo "<br>\n\n==== Tests sur les jetons CSRF ====<br>\n";

// Cas 1 : Génération du jeton
define('CSRF_TOKEN_NAME', 'csrf_token'); // si non défini ailleurs
$token = Security::generateCSRFToken();
echo "<br>\n- Jeton généré : $token\n";

// Vérification correcte
if (Security::verifyCSRFToken($token)) {
    echo "<br>\n[O] Vérification CSRF correcte : OK\n";
} else {
    echo "<br>\n[X] Vérification CSRF correcte : ÉCHEC\n";
}

// Vérification avec jeton incorrect
$fauxToken = "token_invalide";
if (Security::verifyCSRFToken($fauxToken)) {
    echo "<br>\n[O] Vérification CSRF incorrecte : OK\n";
} else {
    echo "<br>\n[X] Vérification CSRF incorrecte : ÉCHEC<br>\n";
}


// -------------------------------
// SECTION 3 : TEST VALIDATION
// -------------------------------


$val = new Validation();

echo "<br>\n==== Tests manuels de la classe Validation ====<br>\n";


// Nettoyage des données 
$dirty = "  <script>alert('xss')</script>Bonjour  ";
$clean = $val->sanitizeInput($dirty);
if ($clean === "Bonjour") {
    echo "<br>\n[O] Nettoyage des données : Le script XSS et les espaces ont été correctement supprimés.\n";
} else {
    echo "<br>\n[X] Nettoyage des données : Résultat inattendu après nettoyage (\"$clean\").\n";
}


$result = $val->validEmail("pas-un-email", "email");
if (!$result && isset($val->getErrors()["email"])) {
    echo "<br>\n[O] Validation email : Email invalide correctement détecté.\n";
} else {
    echo "<br>\n[X] Validation email : Email invalide non détecté.\n";
}


$result = $val->validEmail("test@example.com", "email");
if ($result && !isset($val->getErrors()["email"])) {
    echo "<br>\n[O] Validation email : Email valide correctement accepté.\n";
} else {
    echo "<br>\n[X] Validation email : Email valide rejeté à tort.\n";
}

// Test Longueur minimale non respectée
$result = $val->minLength("abc", "mdp", 5);
if (!$result && isset($val->getErrors()["mdp"])) {
    echo "<br>\n[O] Longueur minimale : Mot de passe trop court correctement détecté.\n";
} else {
    echo "<br>\n[X] Longueur minimale : Mot de passe trop court non détecté.\n";
}

// Test  Longueur minimale respectée
$result = $val->minLength("abcdef", "mdp", 5);
if ($result && !isset($val->getErrors()["mdp"])) {
    echo "<br>\n[O] Longueur minimale : Mot de passe valide correctement accepté.\n";
} else {
    echo "<br>\n[X] Longueur minimale : Mot de passe valide rejeté à tort.\n";
}
