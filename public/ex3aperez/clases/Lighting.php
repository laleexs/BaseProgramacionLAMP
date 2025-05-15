<?php
require_once("Connection.php");
require_once("Lamp.php");

class Lighting extends Connection
{
    private $currentFilter = 'all'; // Variable para almacenar el filtro actual

    public function __construct()
    {
        parent::__construct();
    }

    public function setFilter($zone) // Establece el filtro actual según la zona seleccionada
{
    $this->currentFilter = $zone;
}

    public function getAllLamps()
    {
        if ($this->currentFilter === 'all') {
            $sql = "SELECT lamps.lamp_id, lamps.lamp_name, lamp_on, lamp_models.model_part_number, lamp_models.model_wattage, zones.zone_name
                    FROM lamps
                    INNER JOIN lamp_models ON lamps.lamp_model = lamp_models.model_id
                    INNER JOIN zones ON lamps.lamp_zone = zones.zone_id
                    ORDER BY lamps.lamp_id";
            $stmt = $this->conn->prepare($sql);
        } else {
            $sql = "SELECT lamps.lamp_id, lamps.lamp_name, lamp_on, lamp_models.model_part_number, lamp_models.model_wattage, zones.zone_name
                    FROM lamps
                    INNER JOIN lamp_models ON lamps.lamp_model = lamp_models.model_id
                    INNER JOIN zones ON lamps.lamp_zone = zones.zone_id
                    WHERE zones.zone_id = :zone_id
                    ORDER BY lamps.lamp_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':zone_id', $this->currentFilter);
        }
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Obtiene todos los resultados de la consulta como un array asociativo

        $lamps = [];
        foreach ($resultado as $fila) {
            $lamp = new Lamp(    // Crea una nueva instancia de la clase Lamp
                $fila['lamp_id'],
                $fila['lamp_name'],
                $fila['lamp_on'],
                $fila['model_part_number'],
                $fila['model_wattage'],
                $fila['zone_name']
            );

            $lamps[] = $lamp; // Agrega la lámpara al array de lámparas
        }

        return $lamps; // Devuelve el array de lámparas
    }

    public function drawLampsList()
    {
        $lamps = $this->getAllLamps(); // Obtiene todas las lámparas
        $html = "";

        foreach ($lamps as $lamp) {
            $id = $lamp->getId();
            $nombre = $lamp->getNombre();
            $potencia = $lamp->getPotencia();
            $zona = $lamp->getZona();
            $encendida = $lamp->getEncendida(); // lamp_on es 1 o 0
        
            // Cambia el icono e id del enlace según el estado
            $icono = $encendida ? "bulb-icon-on.png" : "bulb-icon-off.png";
            $status = $encendida ? "off" : "on";
            $clase = $encendida ? "element on" : "element off";
        
            $html .= "<div class='$clase'>";
            $html .= "<h4><a href='changestatus.php?id=$id&status=$status'>";
            $html .= "<img src='img/$icono'></a> $nombre</h4>";
            $html .= "<h1>$potencia W.</h1>";
            $html .= "<h4>$zona</h4>";
            $html .= "</div>";
        }
        
        return $html;
    }  
    

    public function drawMonitor()
    {
        if ($this->currentFilter === 'all') {
            $sql = "SELECT SUM(lamp_models.model_wattage) as power 
                    FROM `lamps` 
                    INNER JOIN lamp_models 
                    ON lamp_model=lamp_models.model_id 
                    WHERE lamp_on = 1 ;" ;
            $stmt = $this->conn->prepare($sql);
        } else {
            $sql = "SELECT SUM(lamp_models.model_wattage) as power 
                    FROM `lamps` 
                    INNER JOIN lamp_models 
                    ON lamp_model=lamp_models.model_id 
                    INNER JOIN zones 
                    ON lamps.lamp_zone = zones.zone_id
                    WHERE zones.zone_id = :zone_id AND lamp_on = 1 ;" ;   // Prepara la consulta SQL para obtener la potencia total de las lámparas encendidas en la zona seleccionada
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':zone_id', $this->currentFilter); // Vincula el parámetro :zone_id con el valor del filtro actual
        }
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);  // Obtiene el resultado de la consulta como un array asociativo
        $power = 0;
        
        $power = $resultado['power'] ?? 0; // Inicializa la potencia a 0 si no hay resultados
    
        
        return $power; // Devuelve la potencia total de las lámparas encendidas
    }

    public function changeStatus($id, $status) // Cambia el estado de la lámpara según el ID y el nuevo estado ON/OFF 1-0
    {
        $sql = "UPDATE lamps SET lamp_on = $status WHERE lamp_id = $id"; // Prepara la consulta SQL para actualizar el estado de la lámpara
        $stmt = $this->conn->prepare($sql); // Prepara la consulta
        $stmt->execute(); // Ejecuta la consulta
    }

    public function drawZonesOptions()
    {
        $seleccion = $this->currentFilter; // Obtiene el filtro actual
        $options = [
            'all' => 'All',
            '1' => 'Fondo Norte',
            '2' => 'Fondo Sur',
            '3' => 'Grada Este',
            '4' => 'Grada Oeste'
        ];
        $html = ""; // Inicializa la variable HTML
        
        foreach ($options as $value => $label) {
            if ($value == $seleccion) {
                $html .= "<option value='$value' selected>$label</option>"; // Marca la opción seleccionada
            } else {
                $html .= "<option value='$value'>$label</option>"; // Muestra las demás opciones
            }
        }
        return $html; // Devuelve el HTML de las opciones
    }

    public function currentFilter()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Verifica si se ha enviado un formulario) {
                if(isset($_POST['submit']))
                {
                    $this->setFilter($_POST['filter']); // Establece el filtro actual según la opción seleccionada
                }
            }
        }
}

    