<?php
$hostname="127.0.0.1";
$database="students";
$dsn="mysql:host=$hostname;dbname=$database";
$username ="root";
$password="";

try {
  $conn= new PDO($dsn,$username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Succès : Connexion à la base de données avec succès !";
} catch (Exception $e) {
  echo "Erreur de connection : " . $e->getMessage();
}
?>