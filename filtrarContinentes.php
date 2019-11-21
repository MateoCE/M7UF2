<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <?php

        try {
            $hostname = "localhost";
            $dbname = "world";
            $username = "mateo";
            $pw = "mateo123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        $query = $pdo->prepare("select distinct(continent) FROM country");
        $query->execute();

        
//         unset($pdo); 
//   unset($query)

    ?>

    <form method="get">
        <select name="continent">
            <?php
                echo "<option value='' selected disabled hidden>Elige un continente</option>";
                $row = $query->fetch();
                while ( $row ) {
                    echo "<option value='".$row['continent']."'>".$row['continent']."</option>";
                    $row = $query->fetch();
                }
            ?>
        </select>
        <input type="submit" value="Send"></input>
    </form>

    <?php

        if(isset($_GET['continent'])){
            $continente = $_GET['continent'];
            unset($query);
            $query = $pdo->prepare("select sum(population) as suma from country where continent='".$continente ."'");
            $query->execute();
            echo "<br><table border='1'>";
            echo "<thead><th colspan='4' align='center' bgcolor='cyan'>Lista de paises de ".$continente ."</th></thead>";

            $row = $query->fetch();
            while ( $row ) {
                echo "<tr>";
                echo "<td align='center' colspan='2'>Poblacion total: ".$row["suma"]."</td>";
                echo "</tr>";
                $row = $query->fetch();
            }
            
            unset($query);

            $query = $pdo->prepare("select name, population FROM country where continent='".$continente ."' order by population desc");
            $query->execute();

            $row = $query->fetch();
            while ( $row ) {
                echo "<tr>";
                echo "<td align='center'>".$row["name"]."</td>";
                echo "<td align='center'>".$row["population"]."</td>";
                echo "</tr>";
                $row = $query->fetch();
            }

            echo "</table>";
        }

    ?>
    
</body>
</html>