<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion";

// Connexion à la base de données
$mysqli= new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($mysqli->connect_error) {
    die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
}else{
    echo  "ok";
}
?>