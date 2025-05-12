<?php
require_once("autoloader.php");

$lista = new Model;
$lista->deleteTarea(isset($_GET['id']) ? $_GET['id'] : null); // Eliminar la tarea con el ID proporcionado
header("Location: index.php"); // Redirige a index.php después de eliminar  