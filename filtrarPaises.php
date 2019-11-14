<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Selecciona el país</h1>

    <?php


      # (1.1) Connectem a MySQL (host,usuari,contrassenya)
      $conn = mysqli_connect('localhost','mateo','mateo123');
      # (1.2) Triem la base de dades amb la que treballarem
      mysqli_select_db($conn, 'world');

      $consulta = "select code, name from country order by name;";

      $resultat = mysqli_query($conn, $consulta);

      if (!$resultat) {
            $message  = 'Consulta invàlida: ' . mysqli_error() . "\n";
            $message .= 'Consulta realitzada: ' . $consulta;
            die($message);
      }
    ?>
    <form method="get">
      <select name="pais">

        <?php
        echo "<option value='' selected disabled hidden>Elige un país</option>";
        while( $registre = mysqli_fetch_assoc($resultat) ){

          echo "<option value='".$registre['code']."'>".$registre['name']."</option>";

        }

        ?>
      </select>
          <input type="submit" value="Send"></input>

    </form>

    <?php

      if (isset($_GET['pais'])) {
        $pais = $_GET['pais'];
        $consulta =  "select * from city where CountryCode='".$pais."' order by Name;";
        $consulta2= "select country.Name as pais, city.Name, city.District, city.Population from city inner join country where country.code=city.countryCode and CountryCode='".$pais."'";
        $resultat = mysqli_query($conn, $consulta2);

        echo "<br><table border='1'>";
        echo "<thead><th colspan='4' align='center' bgcolor='cyan'>Llistat de ciutats de ".$pais."</th></thead>";

        while( $registre = mysqli_fetch_assoc($resultat) )
     		{
        echo "<tr>";
        echo "<td align='center'>".$registre["pais"]."</td>";
        echo "<td align='center'>".$registre["Name"]."</td>";
        echo "<td align='center'>".$registre["District"]."</td>";
        echo "<td align='center'>".$registre["Population"]."</td>";
        echo "</tr>";
        }
        echo "</table>";

      }

    ?>

    <h2>Crear ciudad</h2>

    <form method="post" action="">
      País:
      <select name="pais" style="display: block; margin-bottom: 10px">
        <?php
        $consulta = "select code, name from country order by name;";
        $resultat = mysqli_query($conn, $consulta);
        echo "<option value='' selected disabled hidden>Elige un país</option>";
        while( $registre = mysqli_fetch_assoc($resultat) ){
          echo "<option value='".$registre['code']."'>".$registre['name']."</option>";
        }
        ?>
      </select>
      Nueva Ciudad:
      <input type="text" name="newCity" value="" style="display: block; margin-bottom: 10px">
      Poblacion:
      <input type="text" name="Population" value="" style="display: block; margin-bottom: 10px">
      <input type="submit" value="Crear">
    </form>

    <?php

        if (isset($_POST['newCity']) && isset($_POST['pais']) && isset($_POST['Population'])) {

          $crearCiudad = "insert into city (name, countryCode, Population) values('".$_POST['newCity']."', '".$_POST['pais']."', ".$_POST['Population'].");";
          echo $crearCiudad;

          mysqli_query($conn, $crearCiudad);

          unset($_POST['newCity']);
          unset($_POST['pais']);
          unset($_POST['Population']);
        }

    ?>

  </body>
</html>
