<?php
  require_once'database.php';
    function handlerpostRequest($pdo){
 
  // verification du type de request
  if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  return "ok";  
  }

  // reception des donnees du formulaire
  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = $_POST['mdpconnect'];
  
  if(empty($mailconnect) || empty($mdpconnect)){
   return "les champs doivent etre remplire";  
  }

  return authentificateUser($pdo, $mailconnect, $mdpconnect);
} 

  function authentificateUser($pdo, $mailconnect, $mdpconnect){
  
  // verification du mail

  $sql = "SELECT * FROM membre WHERE mail = :mailconnect";
  $reqmail = $pdo->prepare($sql);
  $reqmail->execute(compact('mailconnect'));
  $mailExist = $reqmail->rowCount();

  if (!$mailExist) {
    return "L'Email n'existe pas";
  }

  $userinfo =$reqmail->fetch();
  var_dump($userinfo);

  echo "<pre>";
  print_r($userinfo ['mdp']);
  echo "</pre>";

  if (!password_verify($mdpconnect,$userinfo['mdp'])){
    return 'Mauvais mot de pass !';
  }
  return 'succes!';
}

  $erreur = handlerpostRequest($pdo);

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
      E-mail : <input type="email" name="mailconnect" value="<?=$mailconnect??''?>" placeholder="Mail" /> <br><br>
      PassWord : <input type="password" name="mdpconnect" value="<?=$mdpconnect??''?>" placeholder="Mot de passe" />
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