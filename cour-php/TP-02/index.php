<?php

    require_once'database.php';

    // insertion des donnees

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);

        $mdp = $_POST['mdp'];
        $mdp2 = $_POST['mdp2'];

        

        function register($pseudo, $mail, $mail2, $mdp, $mdp2){
            global $pdo;

            // verification des champs
            if(empty($pseudo) || empty($mail) ||empty($mail2) || empty($mdp) || empty($mdp2)){
               return "Tout les champs doivent etre remplis"; 
            }

            // verifier le pseudo
            if (strlen($pseudo) > 255){
               return "Le pseudo est trop long"; 
            }

            $sql = "SELECT * FROM membre WHERE pseudo = :pseudo";
            $reqpseudo = $pdo->prepare($sql);
            $reqpseudo->execute(compact('pseudo'));
            $pseudoExist = $reqpseudo->fetch();
            // var_dump($pseudoExist);

            if($pseudoExist){
              return "pseudo deja utiliser";
            }
            // verifier le mail
           if ($mail != $mail2){
              return "Les mails ne correspondent pas"; 
           } 
           if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
              return "Le mail n'est pas valide";
           }

           $sql = "SELECT * FROM membre WHERE mail = :mail";
           $reqmail = $pdo->prepare($sql);
           $reqmail->execute(compact('mail'));
           $mailExist = $reqmail->fetch();
           // var_dump($mailExist);

           if($mailExist){
            return "mail deja utiliser";
          }

          // verifier le mdp existant deja dans la base de donnees
          $sql = "SELECT * FROM membre WHERE mdp = :mdp";
          $reqmdp = $pdo->prepare($sql);
          $reqmdp->execute(compact('mdp'));
          $mdpExist = $reqmdp->fetch();
          // var_dump($mdpExist);

          if($mdpExist){
            return "mdp deja utiliser";
          }

          // verifier le mdp
          if ($mdp!= $mdp2){
            return "Les mots de passe ne correspondent pas"; 
          }
          $mdp = sha1($mdp);


          $sql = "INSERT INTO membre(pseudo, mail, mdp) VALUES (:pseudo, :mail, :mdp)";
          $req = $pdo->prepare($sql);
          $req->execute(compact('pseudo', 'mail', 'mdp'));
          return "Inscription reussie";

          
         
      } 
      $error = register($pseudo, $mail, $mail2, $mdp, $mdp2);
    }     
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Espace Membre</title>
</head>

<body>
  <div align="center">
    <h2>Inscription prof</h2>
    <br /><br />
    <form method="POST" action="">

    <?php
      if(isset($error)){
         echo"<p style = 'background: red; color:white; width:300px; padding:12px;'>".$error."</p>"; 
      }
    ?>
      <table>
        <tr>
          <td align="right">
            <label for="pseudo">Pseudo :</label>
          </td>
          <td>
            <input type="text" placeholder="Votre pseudo" value="<?= $pseudo ?? ''?>" id="pseudo" name="pseudo" />

          </td>
        </tr>
        <tr>
          <td align="right">
            <label for="mail">Mail :</label>
          </td>
          <td>
            <input type="text" placeholder="Votre mail" value="<?= $mail ?? ''?>"  id="mail" name="mail" />
          </td>
        </tr>
        <tr>
          <td align="right">
            <label for="mail2">Confirmation du mail :</label>
          </td>
          <td>
            <input type="text" placeholder="Confirmez votre mail" value="<?= $mail2 ??''?>"  id="mail2" name="mail2" />
          </td>
        </tr>
        <tr>
          <td align="right">
            <label for="mdp">Mot de passe :</label>
          </td>
          <td>
            <input type="password" placeholder="Votre mot de passe" value="<?= $mdp ?? '' ?>" id="mdp" name="mdp" />
          </td>
        </tr>
        <tr>
          <td align="right">
            <label for="mdp2">Confirmation du mot de passe :</label>
          </td>
          <td>
            <input type="password" placeholder="Confirmez votre mdp" value="<?= $mdp ?? '' ?>" id="mdp2" name="mdp2" />
          </td>
        </tr>
        <tr>
          <td></td>
          <td align="center">
            <br />

            <input type="submit" name="forminscription" value="Je m'inscris" /> Déjà un compte ?<a
              href="connexion.php">Se connecter</a>
          </td>
        </tr>
      </table>
    </form>

  </div>
</body>

</html>