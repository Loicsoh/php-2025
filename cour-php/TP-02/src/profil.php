<?php
session_start();
require_once "database.php";
// if(isset($_GET['id'] ) AND $_GET['id']>0){

if(isset($_GET['id'] )){
  // Si la variable est bien un nombre entier et positive
  $getid = intval($_GET['id']);
  $requser = $pdo->prepare('SELECT * FROM membres WHERE id =?');
  $requser->execute([$getid]);
  $userinfo = $requser->fetch();
    

}

?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Espace Membre -Profil</title>
</head>

<body>
  <div align="center">
    <h2>Profil de angel<?= $userinfo['pseudo']; ?></h2>
    <br />

    <?php if(!empty($userinfo['avatar'])){?>
    <img src="membres/<?= $userinfo['avatar']; ?>" width="222">
    <?php  }?>

    <h3><?= $userinfo['mail']; ?></h3>
    <br />

    <?php
    if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']){
      ?>
    <br />
    <a href="editprofil.php">Editer mon profil</a>
    <a href="deconnexion.php">Se déconnecter</a>

    <?php
    }else{
      echo '<br />Vous ne pouvez pas accéder à ce profil';
    }
    ?>

  </div>
</body>

</html>