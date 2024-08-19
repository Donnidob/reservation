<?php
$servername = "localhost"; // Nom du serveur de base de données
$username = "root";        // Nom d'utilisateur pour la base de données
$password = "";            // Mot de passe pour la base de données
$dbname = "reservation";   // Nom de la base de données

try {
    // Créer la connexion avec mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        throw new Exception("La connexion a échoué : " . $conn->connect_error);
    }

    // Définir le jeu de caractères pour l'encodage en utf8
    if (!$conn->set_charset("utf8")) {
        throw new Exception("Erreur lors du chargement du jeu de caractères utf8 : " . $conn->error);
    }
    
} catch (Exception $e) {
    // En cas d'erreur de connexion, afficher un message
    die($e->getMessage());
}
?>
