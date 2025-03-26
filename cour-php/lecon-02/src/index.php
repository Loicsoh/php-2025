<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>welcome</h1>

    <?php
    include 'header.php';
    include 'page1.php';
    require 'page2.php';
    include_once 'page3.php';
    include_once 'footer.php';

    
    require_once 'database.php';

    $sql = "SELECT * FROM student";

    $result = $conn->query($sql);

    echo"<pre>";
    var_dump(value:$result);
    echo"</pre>";
    foreach ($result as $row){
        if ($result->num_rows > 0){
            echo "il y a des donnees";
        }else{
            echo "il n'y a pas de donnees";
        }
        echo $row['nom']."<br>";
        echo $row['prenom']."<br>";
        echo $row['email']."<br>";
        echo $row['password']."<br>";
    }



    ?>
</body>
</html>