<?php
require_once "database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //recuperation des donnees du formulaires
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];

    function register($pseudo, $mail, $mail2, $mdp, $mdp2)
    {
        global  $pdo;
        //verification des champs
        if (empty($pseudo) || empty($mail) || empty($mail2) || empty($mdp) || empty($mdp2)) {
            return "Tous les champs doivent etre remplis";
        }
        //verification de la longueur du pseudo
        if (strlen($pseudo) > 255) {
            return "Votre pseudo ne doit pas depasser 255 caracteres";
        }
        $sql = "SELECT * FROM membres WHERE pseudo = :pseudo";
        $reqPseudo = $pdo->prepare($sql);
        $reqPseudo->execute(compact('pseudo'));
        $pseudoExist = $reqPseudo->fetch();
        if ($pseudoExist) {
            return "Ce pseudo est deja utilisé";
        }
        //verification du mail
        if($mail != $mail2){
            return"les mails ne corespondent pas";
        }
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            return "le mail n'est pas valide";
        }
        $sql = "SELECT*FROM membres WHERE mail = :mail";
        $reqMail = $pdo->prepare($sql);
        $reqMail->execute(compact('mail'));
        $mailExist = $reqMail->fetch();
        if($mailExist){
            return "le mail est deja utiliser";
        }
    if(strlen($mdp<8) ||!preg_match("#[0-9]+#",$mdp) ||!preg_match("#[a-zA-Z]+#",$mdp)){
        return"le mot de passe doit contenir au moins 8caracteres,une lettre et un chiffre";
    }
    if($mdp != $mdp2){
        return "les mots de passe ne sont pas similaire";

    }
    //crytage du mot de passe
    $mdp = password_hash($mdp,PASSWORD_DEFAULT);
    //insertion des donnee dans la base de donnee
    $sql = "INSERT INTO membres(pseudo,mail,mdp)VALUES (:pseudo, :mail, :mdp)";
    $req = $pdo->prepare($sql);
    $req->execute(compact('pseudo','mail','mdp'));
    return "votre compte a bien ete cree !<a style= 'color:white;' href = \"conexion.php\">  Me connecter</a>";
    }
    //verification de la validité de l'adresse mail
    $error = register($pseudo, $mail, $mail2, $mdp, $mdp2);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Italianno&family=Parkinsans:wght@300..800&family=Playwrite+HU:wght@100..400&family=Playwrite+PE+Guides&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>tp-02-espace-membre-2025</title>
</head>

<body class="bg-green-100 pt-[100px] font-family-Poppins">

<div align="center">
    <h2 class="text-4xl font-bold text-green-900 text-center mb-6">Inscription prof</h2>

    <form method="POST" action="" class="bg-white p-6 rounded shadow max-w-lg mx-auto">
        <div class="flex flex-col gap-[7px] pt-[7px]">
            <?php
            if (isset($error)) {
                echo '<p class="bg-red-500 w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500 text-white font-bold">' . $error . '</p>';
            }

            ?>
            <div class="text-left flex flex-col gap-[7px]">
                <label for="pseudo" class="">Pseudo :</label>

                <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo"
                
                 class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
            </div>
            <div class="text-left flex flex-col gap-[7px]">
                <label for="mail">Mail :</label>

                <input type="text" placeholder="Votre mail" id="mail" name="mail"  class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
            </div>
            <div class="text-left flex flex-col gap-[7px]">
                <label for="mail2">Confirmation du mail :</label>

                <input type="text" placeholder="Confirmez votre mail" id="mail2" name="mail2" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
            </div>
            <div class="text-left flex flex-col gap-[7px]">
                <label for="mdp">Mot de passe :</label>

                <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
            </div>
            <div class="text-left flex flex-col gap-[7px]">
                <label for="mdp2">Confirmation du mot de passe :</label>

                <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500" />
            </div>
            <div class="text-left flex flex-col gap-[7px]">
                <input type="submit" name="forminscription" value="S'inscrire" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-green-500 bg-green-100" />
            </div>
        </div>
        Déjà un compte ?<a
            href="connexion.php">Se connecter</a>
        <a href="profil.php"></a>

    </form>

</div>
</body>
</html>
