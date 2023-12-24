<?php
require 'bd.php';

// Récupérer les données du formulaire
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Ajoutez des messages de débogage ici
echo "Email saisi : " . $email . "<br>";
echo "Mot de passe saisi : " . $mot_de_passe . "<br>";

// Rechercher l'utilisateur dans la base de données
$stmt = $mysqli->prepare("SELECT id, email, mot_de_passe,role FROM utilisateurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $email, $mot_de_passe_hash, $role);
    $stmt->fetch();

    // Vérifier le mot de passe
    if (password_verify($mot_de_passe, $mot_de_passe_hash)) {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role'] = $role;
        $_SESSION["connecter"]=1;

        // Rediriger en fonction du rôle
        if ($role == 'directeur') {
            header("Location: ../Directeur.php");
            
        } else {
            header("Location: ../Employe.php");
            
        }
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Utilisateur non trouvé.";
}

// Fermer la connexion
$stmt->close();
$mysqli->close();
?>

