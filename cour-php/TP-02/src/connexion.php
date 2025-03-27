<?php
  require_once'database.php';
  function handlerpostRequest($pdo);

  // verification du type de request
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
  return Register($pdo);  
  }

  // reception des donnees du formulaire
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>TUTO PHP</title>
  <meta charset="utf-8">
</head>

<body>
  <div align="center">
    <h2>Connexion</h2>
    <br /><br />
    <form method="POST" action="">
      E-mail : <input type="email" name="mailconnect" placeholder="Mail" /> <br><br>
      PassWord : <input type="password" name="mdpconnect" placeholder="Mot de passe" />
      <br /><br />
      <input type="submit" value="Se connecter !" />
    </form>
    <?php
         if (isset($erreur)) {
            echo '<font color="red">' . $erreur . "</font>";
         }
         ?>
  </div>
</body>

</html>