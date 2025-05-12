<?php
require_once "Conection.php";


class Model extends Conection
//ejercicio2 
{
    private function getAllProducts()
    {
        $query = 'SELECT * FROM PRODUCTO';
        $result = $this->getConn()->query($query); 

        $producto = []; 

        if($result->rowCount() > 0) { // para obtener el número de filas afectadas por una consulta SELECT
            while($fila = $result->fetch(PDO::FETCH_ASSOC)) {   //  convertiro a array asociativo con fetch 
                $producto[] = $fila;
            }
        }
        
        return $producto;
    }

    public function showAllProducts()
    {
        $productos = $this->getAllProducts();

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo '<div class="divTableRow">';
                echo '  <div class="divTableCell">' . $producto['PROD_NUM'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['DESCRIPCION'] . '</div>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron productos.";
        }
        
    }

//  Ejercio 3

    public function getAllEmp()
    {
        $query = ' SELECT EMP_NO, APELLIDOS, DEPT_NO, SALARIO, FECHA_ALTA FROM EMP';
        $result = $this->getConn()->query($query); 

        $producto = []; 

        if($result->rowCount() > 0) { // para obtener el número de filas afectadas por una consulta SELECT
            while($fila = $result->fetch(PDO::FETCH_ASSOC)) {   //  convertiro a array asociativo con fetch 
                $producto[] = $fila;
            }
        }
        
        return $producto;
    }

    private function moneyFormat($valor)
    {
        return number_format($valor,2 ,",", ".") ."€";
    }

    public function showAllEmp()
    {
        $productos = $this->getAllEmp(); 

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $color = $this->getColorByDeptNo($producto['DEPT_NO']); // Obtener el color primero
                echo '<div class="divTableRow">';
                
                echo '  <div class="divTableCell">' . $producto['EMP_NO'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['APELLIDOS'] . '</div>';
                echo '  <div class="divTableCell" style="background-color: ' . $color . ';">'. '</div>';
                echo '  <div class="divTableCell">' . $this->moneyFormat($producto['SALARIO']) . '</div>';
                $fecha_alta = date('d/m/Y', strtotime($producto['FECHA_ALTA']));
                echo '  <div class="divTableCell">' . $fecha_alta . '</div>';
                echo '</div>';

                
            }
        } else {
            echo "No se encontraron productos.";
        }      
    }
    function getColorByDeptNo($deptNo) {
        $colores = [
            10 => '#FF0000',
            20 => '#00FF00',
            30 => '#0000FF',
            40 => '#FFFF00',
        ];
    
        return isset($colores[$deptNo]) ? $colores[$deptNo] : '#FFFFFF';
    }

// Ejercicio 4
    

    public function getAllClients($order)
    {
        $order = ($order == 'DESC') ? 'DESC' : 'ASC'; //COPIADO DEL WEBINAR, SI NO LE PASO NADA SERA ASC 
        $query = 'SELECT CLIENTE_COD, NOMBRE , CIUDAD FROM CLIENTE ORDER BY NOMBRE ' . $order ;
        $result = $this->getConn()->query($query); 

        $producto = []; 

        if($result->rowCount() > 0) { // para obtener el número de filas afectadas por una consulta SELECT
            while($fila = $result->fetch(PDO::FETCH_ASSOC)) {   //  convertiro a array asociativo con fetch 
                $producto[] = $fila;
            }
        }
        return $producto;
    }

    public function showAllCLients($order)
    {
        $productos = $this->getAllClients($order);

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo '<div class="divTableRow">';
                echo '  <div class="divTableCell">' . $producto['CLIENTE_COD'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['NOMBRE'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['CIUDAD'] . '</div>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron productos.";
        }
    }
    
//Ejercicio 5 

    public function getOrder($total)
    {
        $total = (is_numeric($total) ? $total : 0);
        $query = 'SELECT PEDIDO_NUM, CLIENTE_COD , TOTAL FROM PEDIDO WHERE TOTAL >= '. $total ;
        $result = $this->getConn()->query($query); 

        $producto = []; 

        if($result->rowCount() > 0) { // para obtener el número de filas afectadas por una consulta SELECT
            while($fila = $result->fetch(PDO::FETCH_ASSOC)) {   //  convertiro a array asociativo con fetch 
                $producto[] = $fila;
            }
        }
        return $producto;
    }

    public function showOrder($total)
    {
        $productos = $this->getOrder($total);

        if (!empty($productos)) {
            foreach ($productos as $producto) {
                echo '<div class="divTableRow">';
                echo '  <div class="divTableCell">' . $producto['PEDIDO_NUM'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['CLIENTE_COD'] . '</div>';
                echo '  <div class="divTableCell">' . $producto['TOTAL'] . '</div>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron productos.";
        }
    }

//Ejercicio 6 , hasta aqui no llege, solucion del profesor

    private function getOrderLines($pedido)
    {
        $pedido = (is_numeric($pedido) ? $pedido : 0);
        $sql ="SELECT PEDIDO_NUM , DETALLE_NUM, IMPORTE FROM DETALLE WHERE PEDIDO_NUM = " . $pedido;
        return $this->conn->query($sql);
    }

    private function getOrderLinesHigh($pedido)
    {
        $sql="SELECT PEDIDO_NUM , DETALLE_NUM, IMPORTE FROM DETALLE WHERE PEDIDO_NUM = " . $pedido ." ORDER BY IMPORTE DESC";
        $result= $this->conn->query($sql);
        if ($result->rowCount() > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);    // Obtiene la primera fila (que será la de mayor importe debido al ORDER BY IMPORTE DESC)
            return $row['DETALLE_NUM'];
        }else {
            return 0; // si no hay nada devuelve 0
        }
    }

    public function showOrderLines($pedido)
    {
        $result = $this->getOrderLines($pedido);
        if ($result->rowCount() > 0 ) {
            $mayor = $this->getOrderLinesHigh($pedido);
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='divTableRow'>
                <div class='divTableCell'>" . $row['PEDIDO_NUM'] . "</div>
                <div class='divTableCell'>" . $row['DETALLE_NUM'] . "</div>
                <div class='divTableCell'>" . $this->moneyFormat($row['IMPORTE']);
                if($row['DETALLE_NUM'] == $mayor){
                    echo "<img src='star-256.png' class='star'>"; 
                }
                echo "</div>
                </div>";
            }
        }else {
            echo "0 results";
        }
    }
    
//Ejercicio 7
    public function getPaginatedProducts($limit, $offset)
    {
            $sql = "SELECT * FROM PRODUCTO LIMIT $limit OFFSET $offset"; //LIMIT cuantos elementos quieres mostrar, OFFSET a partir de que elemento quieres mostrar
            $result = $this->conn->query($sql);
            return $result;
    }

    public function showPaginatedProducts($limit, $offset)
    {
        $result = $this->getPaginatedProducts($limit, $offset);
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='divTableRow'>
                <div class='divTableCell'>" . $row['PROD_NUM'] . "</div>
                <div class='divTableCell'>" . $row['DESCRIPCION'] . "</div>
                </div> ";
            }
        } else {
            echo "0 results";
        }
    }

    public function countProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM PRODUCTO";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}