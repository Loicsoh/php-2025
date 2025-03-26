<?php
$message = "";
if (isset($_POST['create']))
{
       $name = $_POST['nom'];
       $lastname = $_POST['prenom'];
       $email = $_POST['mail'];
       $passwork = $_POST['pass'];
       $hash = password_hash($passwork, PASSWORD_DEFAULT);
       
       echo "votre nom est : $name <br>";
       echo "votre prenom est : $lastname <br>";
       echo "votre email est : $email <br>";
       echo "votre mot de pass est : $passwork <br>";
}

// verification de champ de saisie vide

if (isset($_POST['create'])){
  if (empty($name) || empty($lastname) || empty($email) || empty($passwork)){
   $message = "veuillez remplire tout les champs";
   $hash = password_hash($passwork, PASSWORD_DEFAULT);
  }
  else{
    echo "votre nom est : $name <br>";
    echo "votre prenom est : $lastname <br>";
    echo "votre email est : $email <br>";
    echo "votre mot de passe est : $hash <br>";
  }
}

$mailstudent = $_POST['mail'];
if (!filter_var(value: $mailstudent, filter: FILTER_VALIDATE_EMAIL)){
  $message = "veuillez saisir un email valide";
}else{
  echo "Email: $mailstudent<br>";
}

  $errors = [];
  if (isset($_POST['create'])){
   $errors[] = "le champ nom est obligatoire";

  }
  if (!empty($errors)) {
    session_start();
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
    exit();
    }
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./output.css" rel="stylesheet">
  <title>Formulaire</title>
  
</head>
<body>

  <form action="" method="post" class="bg-white p-6 rounded shadow max-w-md mx-auto">
    <div class="bg-red-200 p-5 text-red-600 mb-4">
      <?php
        echo "$message"
      ?>
    </div>
    <div class="mb-4">
      <input type="text" name="nom" placeholder="Nom"
        class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500">
    </div>
    <div class="mb-4">
      <input type="text" name="prenom" placeholder="Prénom"
        class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500">
    </div>
    <div class="mb-4">
      <input type="email" name="mail" placeholder="Email"
        class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500">
    </div>
    <div class="mb-4">
      <input type="passwork" name="pass" placeholder="entrez votre mot de passe"
        class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500">
    </div>
    <div class="text-center">
      <input type="submit" name="create" value="Créer"
        class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
    </div>
  </form>
  
</body>
</html>