<?php
require_once "autoload.php";

$id = $_GET['id'];
$status = $_GET['status'] === 'on' ? 1 : 0; // Cambia el estado a 1 si es 'on', de lo contrario a 0

$lighting = new Lighting();

$lighting->changeStatus($id, $status);
$filtro = $_GET['filter'] ?? 'all';

// Redirige de nuevo al panel principal
header("Location: index.php?filter=$filtro");
exit;
