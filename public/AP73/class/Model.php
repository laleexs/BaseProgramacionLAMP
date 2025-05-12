<?php
require_once("Conection.php");

class Model extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

//ejercicio 2
    public function import()
    {
        $conn = $this->getConn();
        $tareasFile = file_get_contents("tareas.json");
        $tareas = json_decode($tareasFile, true); // true para convertir a array asociativo

        if (!$tareas)  {
            die("Error al decodificar el JSON: ");
        }

        //dejando el stmt preparado para la inserción
        $stmt = $conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento) VALUES (?,?,?,?)");
    
        foreach ($tareas as $tarea) {

            //pasando las fechas a formato Y-m-d
            $dateCreacion = date('Y-m-d', strtotime($tarea['fecha_creacion']));
            $dateVencimiento = date('Y-m-d', strtotime($tarea['fecha_vencimiento']));

            //ejecutando la inserción de cada tarea por cada iteración del foreach pone los valores dentro de los ? de la consulta "Values "  
            $stmt->execute([$tarea['titulo'],
                            $tarea['descripcion'], 
                            $dateCreacion,
                            $dateVencimiento
            ]);
        }
    
    return true; // Retorna true si la importación fue exitosa
    }

    
    public function deleteList()
    {
        $conn = $this->getConn();
        $stmt = $conn->prepare("DELETE FROM tareas");
        $stmt->execute();
    }

    public function init()
    {
        $this->deleteList(); // Elimina las tareas existentes
        $this->import(); // Importa las nuevas tareas desde el archivo JSON
    }

//ejercicio 3
    public function getPaginatedTasks($limit, $offset)
    {
        $sql = "SELECT * FROM tareas LIMIT $limit OFFSET $offset"; // LIMIT y OFFSET para paginación
        $result = $this->conn->query($sql); // Ejecuta la consulta
        return $result; //

    }

    public function countProducts() // Contar el total de productos para la paginación
    {
        $sql = "SELECT COUNT(*) as total FROM tareas"; // Contar el total de tareas
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }


    private function fechaFormateada($fecha)
    {
        $date = new DateTime($fecha);
        return $date->format('d/m/Y');
    }

    public function showPaginatedTasks($limit, $offset)
    {
        $result = $this->getPaginatedTasks($limit, $offset);
        if ($result->rowCount() > 0) { // Verifica si hay resultados
            $output = "";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $output .= "<tr>";
                $output .= "<td>" . $row['id'] . "</td>";
                $output .= "<td><a href='detalle.php?id=" . $row['id'] . "'>" . $row['titulo'] . "</td>";
                $output .= "<td>" . $row['descripcion'] . "</td>";
                $output .= "<td>" . $this->fechaFormateada($row['fecha_creacion']) . "</td>";
                $output .= "<td>" . $this->fechaFormateada($row['fecha_vencimiento']) . "</td>";
                $output .= "<td><a href='modifica.php?id=" . $row['id'] . "'>Editar</a></td>";
                $output .= "<td><a href='borrar.php?id=" . $row['id'] . "'>Borrar</a></td>";
                $output .= "</tr>";
            }
            return $output; // Retorna las filas de la tabla
        } else {
            return "<tr><td colspan='4'>No hay tareas disponibles.</td></tr>";
        }
    }

// Ejercicio 5

    public function addTarea($request)
    {
        $titulo = $request['title'];
        $descripcion = $request['description'];
        $dueDate = $request['dueDate']; // Fecha de vencimiento
        $dueDate = date('Y-m-d', strtotime($dueDate)); // Formato de fecha Y-m-d
        $stmt = $this->conn->prepare("INSERT INTO tareas (titulo, descripcion, fecha_creacion, fecha_vencimiento ) VALUES (?, ?, NOW(), ? )"); // La fecha de creación se establece automáticamente en el servidor
        $stmt->execute([$titulo, $descripcion, $dueDate]); // Ejecuta la consulta con los parámetros
    }

//ejercicio 6
    public function updateTarea($request)
    {
        $id = $request['id'];
        $titulo = $request['titulo'];
        $descripcion = $request['descripcion'];
        $dueDate = $request['fecha_vencimiento']; // Fecha de vencimiento
        $dueDate = date('Y-m-d', strtotime($dueDate)); // Formato de fecha Y-m-d
        $stmt = $this->conn->prepare("UPDATE tareas SET titulo = ?, descripcion = ?, fecha_vencimiento = ? WHERE id = ?"); // Actualiza la tarea con el ID correspondiente
        $stmt->execute([$titulo, $descripcion,$dueDate, $id]); // Ejecuta la consulta con los parámetros
    }


//ejercicio 7
    public function deleteTarea($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tareas WHERE id = ?"); // Prepara la consulta para eliminar la tarea
        $stmt->execute([$id]); // Ejecuta la consulta con el ID de la tarea a eliminar
    }
}

    