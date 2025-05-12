<?php 
require_once("autoloader.php");

$lista = new Model;
//$lista->init(); // Inicializa la base de datos y carga los datos desde el JSON

//Paginador
$productsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page-1) * $productsPerPage;
$totalProducts = $lista->countProducts();
$totalPages = ceil($totalProducts / $productsPerPage); // Total de páginas
$paginado = $lista->getPaginatedTasks($productsPerPage, $offset); // Obtiene las tareas paginadas

?>

<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos.css" type="text/css">
</head>
<body>
<table class= "greenTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>TÍTULO</th>
            <th colspan ="2">ACCIONES</th>
        </tr>
        <tr>
            <td><a href="nueva.php">Añadir</a></td>
            <td colspan = "3"></td>
        </tr>
    </thead>
    <tbody>
        <?= $lista->showPaginatedTasks($productsPerPage, $offset) ?>
    </tbody>
</table>
<div>
            <?php if ($page > 1): ?>
                <a href="?page=1"><<</a>
                <a href="?page=<?php echo $page - 1; ?>"><</a>
            <?php endif; ?>
            <span>Página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>">></a>
                <a href="?page=<?php echo $totalPages; ?>">>></a>
            <?php endif; ?>
        </div>
</body>
</html>
