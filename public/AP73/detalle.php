<?php
require_once("autoloader.php");
$lista = new Model;
$conn = $lista->getConn(); // Obtener la conexión a la base de datos
$id = $_GET['id']; // Obtener el ID de la tarea desde la URL
$sql = "SELECT * FROM tareas WHERE id = ". $id ." ;" ;
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC); //  Obtener el resultado (la fila de la tarea)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<table class="greenTable">
    <thead>
        <tr>
            <th><?php echo $row['titulo']; ?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td>La tarea <?php echo $row['id']; ?> vence en <?php echo $row['fecha_vencimiento']; ?></td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>fecha de creación: <?php echo $row['fecha_creacion']; ?></td>
        </tr>
        <tr>
            <td>descripción: <?php echo $row['descripcion']; ?></td>
        </tr>
    </tbody>
</table>
<a href="index.php">Volver</a>
</body>
</html>
