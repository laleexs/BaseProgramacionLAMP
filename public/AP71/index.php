<?php
require_once "autoloader.php";
$connection = new Conection(); // creando objeto de nombre connection 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome to LAMP infraestructure</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src ="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class = "container-fluid">
        <?php
        echo "<h1>Hello, Welcome DAW Student! </h1>";
        echo "<h2>pdo example </h2>";

        //ejemplo de inserción directa
        $insert = "INSERT INTO Person(id,name) VALUES (33, 'NombrePrueba2')";
        $result = $connection->getConn()->exec($insert);

        // Ejemplo de prepared statement
        $stmt = $connection->getConn()->prepare('INSERT INTO Person(id, name) VALUES (?,?)');
        $id = 444;
        $name = "nombrePrueba4";
        $stmt->execute([$id,$name]);  

        //consulta de datos 

        $query = 'SELECT * From Person';
        $result = $connection->getConn()->query($query); // ejecutamos una consulta almacenada previamente

        echo '<table class="table "table-striped">';
        echo '<thead><tr><th>id</th></tr></thead>';
        while ($value = $result->fetch(PDO::FETCH_ASSOC)) {  // convertiro a array asociativo con fetch
            echo '<tr>';
            foreach($value as $element) {
                echo '<td>' . $element . '</td>';
            }

            echo '</tr>';
        }
        echo '</table>';
        ?>
    </div>
</body>
</html>