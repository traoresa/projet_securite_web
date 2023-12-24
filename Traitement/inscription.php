<?php
require 'bd.php';
// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$poste = $_POST['poste'];
$grade = $_POST['grade'];
$mot_de_passe = $_POST['mot_de_passe'];
$conf_mot_de_passe = $_POST['conf_mot_de_passe'];

// Vérifier si les mots de passe correspondent
if ($mot_de_passe != $conf_mot_de_passe) {
    die("Les mots de passe ne correspondent pas.");
}

// Appliquer les règles de complexité du mot de passe
if (strlen($mot_de_passe) < 8 ||
    !preg_match("#[0-9]+#", $mot_de_passe) ||
    !preg_match("#[a-zA-Z]+#", $mot_de_passe) ||
    !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $mot_de_passe)) {
    die("Le mot de passe ne respecte pas les règles de complexité.");
}

// Hasher le mot de passe
$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

// Insérer les données dans la base de données
$stmt = $mysqli->prepare("INSERT INTO utilisateurs (nom, prenom, email, telephone, poste_travail, grade, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $nom, $prenom, $email, $telephone, $poste, $grade, $mot_de_passe_hash);

if ($stmt->execute()) {
    #echo "Inscription réussie.";

    header("Location: ../login.php");
} else {
    echo "Erreur lors de l'inscription : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$mysqli->close();
?>
