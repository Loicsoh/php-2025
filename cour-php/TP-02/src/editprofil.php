<?php
session_start();
require_once "database.php";
if(isset($_SESSION['id']) AND $_SESSION['id']>0){
    $requser = $pdo->prepare('SELECT * FROM membres WHERE id =?');
    $requser->execute([$_SESSION['id']]);
    $user = $requser->fetch();
    // echo "<pre>";
    // var_dump($user);
    // echo "</pre>";

    // die();

    if(!empty($_POST['newpseudo']) && $_POST['newpseudo'] !== $user['pseudo']){
     
          $newpseudo = htmlspecialchars($_POST['newpseudo']);

          if(strlen($newpseudo)<255){
              $reqpseudo = $pdo->prepare("SELECT *FROM  membres WHERE pseudo = ?");
              $reqpseudo->execute([$newpseudo]);
              $pseudoexist = $reqpseudo->rowCount();

              if($pseudoexist == 0){
                  $requpdate = $pdo->prepare("UPDATE membres SET pseudo =? WHERE id = ?");
                  $requpdate->execute([$newpseudo, $_SESSION['id']]);
                  $_SESSION['pseudo'] = $newpseudo;
                  header("Location: profil.php?id=".$_SESSION['id']);
              }else{
                  $erreur = "ce pseudo est deja utiliser";
              }
          }else{
              $erreur = "votre pseudo ne doit pas depasser 255 caracteres!";
          }
      }


//mise a jour de l'email

        if(!empty($_POST['newmail']) && $_POST['newmail'] !== $user['mail']){
            
              $newmail = htmlspecialchars($_POST['newmail']);

                  if(filter_var($newmail, FILTER_VALIDATE_EMAIL)){
                      $reqmail = $pdo->prepare("SELECT *FROM  membres WHERE mail = ?");
                      $reqmail->execute([$newmail]);
                      $mailexist = $reqmail->rowCount();

                      if($mailexist == 0){
                          $requpdate = $pdo->prepare("UPDATE membres SET mail =? WHERE id = ?");
                          $requpdate->execute([$newmail, $_SESSION['id']]);
                          $_SESSION['mail'] = $newmail;
                          header("Location: profil.php?id=".$_SESSION['id']);
                      }else{
                        $erreur="cet email est deja utiliser!";
                      }
                }else{
                  $erreur= "votre mail n'est pas valide!";
                }
            }


      
 //mise a jour du mot du mdp
 
 if(!empty($_POST['newmdp1']) &&!empty($_POST['newmdp2'])){
  if($_POST['newmdp1'] === $_POST['newmdp2']){
    $newMdp = password_hash($_POST['newmdp1'],PASSWORD_DEFAULT);
    $requpdate = $pdo->prepare("UPDATE membres SET mdp =? WHERE id = ?");
    $requpdate->execute([$newMdp, $_SESSION['id']]);
  }else{
    $erreur = "vos mots de passe ne corespondent pas!";
  }
 
 }else{
   $erreur= "veillez remplir les champs de mot de passe";
 }



 //mise a jour de l'avatar
 


 //verification de la presence d'un fichier uploade
        if(!empty($_FILES['avatar']['name'])){
            $maxIze= 2*1024*1024;
            $validExt=['jpg','jpeg','gif','png'];

            //verification de la taille de limage

            if($_FILES['avatar']['size']<=$maxIze){
              //recuperation de l'extension du fichier
              $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
              //verification de l'extension  du fichier autoriser
              if(in_array($ext,$validExt)){
                //renomer limage uploade(id de l'utilisateur. l'extension de l'image)
                $newFilename = $_SESSION['id'] . "." .$ext;
                $destination = "membres/" .$newFilename;

                if(move_uploaded_file($_FILES['avatar']['tmp_name'],$destination)){
                  $requpdate = $pdo->prepare("UPDATE membres SET avatar = ?WHERE id=?");
                  $requpdate->execute([$newFilename,$_SESSION['id']]);
                  header("Location:profil.php?id=".$_SESSION['id']);
                  exit();
                }else{
                  $erreur= "erreur lor de l'uploade de limage";
                }

              }else{
                $erreur ="format d'image non autoriser('jpg','jpeg','gif','png' requis)!";
              }

            }else{
              $erreur = "la taille de limage ne doit pas depasser 2 Mo";
            }
        }else{
          $erreur = "veillez selectionner une image !";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>TUTO PHP</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-green-100 pt-[100px] font-family-Poppins">
  <div align="center">
    <h2 class="text-4xl font-bold text-green-900 text-center mb-6">Edition de mon profil</h2>
    <?php
if (isset($erreur)) {
echo '<font color="red">' . $erreur . "</font>";
}
?>
<div class="flex flex-col gap-[7px] pt-[7px]">

  <form method="POST" action="" enctype="multipart/form-data"  class="bg-white p-6 rounded shadow max-w-lg mx-auto">



<label>Pseudo :</label>

<!-- E-mail : <input type="email" name="mailconnect" placeholder="Mail" /> <br><br> -->
<input type="text" placeholder="pseudo" id="mailconnect" name="newpseudo" value="<?= $user['pseudo'] ?? "" ?>"  class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" /> <br /><br />

<label>Mail :</label>

<input type="text" placeholder="mail" id="mdpconnect" name="newmail" value="<?= $user['mail'] ?? "" ?>" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
<!-- PassWord : <input type="password" name="mdpconnect" placeholder="Mot de passe" /> -->
<br /><br />
<label for="mdp">Mot de passe :</label>
<input type="password" placeholder="mot de passe" id="mdp" name="newmdp1" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
<br /><br />
<label for="mdp">confirmation Mot de passe:</label>
<input type="password" placeholder="confirmation du mot de passe" id="newmdp2" name="newmdp1" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
<br /><br />

<label for="">Avatar :</label>
<input type="file" name="avatar" /><br /><br />
<input type="submit" value="Mettre à jour mon profil !" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500 bg-green-100 cursor-pointer"/>
</form>





        <!-- <label>Pseudo :</label>
        <input type="text" name="newpseudo" placeholder="Pseudo" value=">" /><br /><br />
        <label>Mail :</label>
        <input type="text" name="newmail" placeholder="Mail" value="" /><br /><br />
        <label>Mot de passe :</label>
        <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
        <label>Confirmation - mot de passe :</label>
        <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
        <label for="">Avatar :</label>
        <input type="file" name="avatar" /><br /><br />
        <input type="submit" value="Mettre à jour mon profil !" />

      </form>
     
    </div>
  </div>
</body>

</html>