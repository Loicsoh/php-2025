

<!-- les variables -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>rio</h1>

    <?php
    echo "<pre>";
        $nom = "rio <b><br>";
        var_dump(value: $nom);

        $age =25;

        var_dump(value: $age);

        $taille = 1.75;

        var_dump(value: $taille);

        $revure = null;
        var_dump(value: $revure);

        $isMale = true;

        var_dump(value: $isMale);

    echo "<pre>";

    echo "<pre>";
        var_dump($age, $nom, $taille, $revure, $isMale);

        echo "<br>";
        echo "<pre>";

        $nom = 20;
        var_dump($nom);

        define('pays', 'japon');

        define('ville', 'tokyo');

        var_dump( pays, ville);

// les operations

echo "<h1>les operations</h1>";
        $num1 = 10;

        $num2 = 20;

        $result = $num1 + $num2;
        echo $result;
        echo "<br><br>";

        $result = $num1 - $num2;
        echo $result;   
        echo "<br><br>";

        $result = $num1 * $num2;
        echo $result;
        echo "<br><br>";

        $result = $num1 / $num2;
        echo $result;
        echo "<br><br>";

        $result = $num1 % $num2;
        echo $result;
        echo "<br><br>";

        // echo "division flottante avec fdiv: " .fdiv(num: $num1 , num: $num2);

        //formulaire

        echo "<h1>formulaire</h1>";
        echo "<form action='section-01.php' method='post'>";
        echo "<input type='text' name='nom' placeholder='votre nom'><br><br>";
        echo "<input type='text' name='prenom' placeholder='votre prenom'><br><br>";
        echo "<input type='submit' value='envoyer'>";

        
        echo "</form>";

        //recuperation des donnees

        echo "<h1>recuperation des donnees</h1>";
        if(isset($_POST['nom']) && isset($_POST['prenom'])){
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            echo "votre nom est : <u>$nom</u><br> et votre prenom est: <u>$prenom</u>";
        }

        echo "<h1 color>Verifiez votre statuts</h1>";
        echo "<form method='post'>";
        echo "<input type='text' name='age' placeholder='entrez votre age'><br><br>";
        echo "<input type='text' name='nom' placeholder='Entrez votre nom'><br><br>";
        echo "<input type='submit' value='envoyer'>";
        echo "</form>"; 

        if(isset($_POST['age'], $_POST['nom'])){
            $age = $_POST['age'];
            $nom = $_POST['nom'];
            if($age >= 18){
                echo "vous etes majeur : <u>$nom</u><br><br>";
            }
            else{
                echo"vous etes mineur : <u>$nom</u><br><br>";
            }
        }

        function sum($num1, $num2){
            return $num1 + $num2;
        }
        echo sum(10, 20);
        echo "<br><br>";



        //les conditions

        // echo "<h1>les conditions</h1>";
        // $age = 18;

        // if($age >= 18){
        //     echo "vous etes majeur";  
        // }
        // else{
        //    echo "vous etes mineur"; 
        // }

    ?>
</body>
</html>