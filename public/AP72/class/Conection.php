<?php
class Conection{

    private $host;
    private $userName;
    private $password;
    private $db; // aceso a nonbre de la base de datos
    protected $conn; // cinexion con la base de datos 
    private $configFile = "conf.json"; // ruta de acceso a datos de configuracion en json 
    
    public function __construct()
    {
        $this->connect(); // llama a connect
    }

    public function __destruct() //sirve para poner la conexion a null
    {
        if($this->conn){
            $this->conn = null;
        }
    }

    public function connect()
    {
        if (!file_exists($this->configFile)) { // comprueba que existe el fichero de configuracion
            die("Unable to open file");  // si no existe cierra
        }

        $configData = file_get_contents($this->configFile); // convierte el json a string
        $config = json_decode($configData, true);  // en config tengo el array asociativo con el string anterior

        $this->host = $config['host']; // escribimos en estas propiedades lo que extraemos del json
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->db = $config['db'];
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db", $this->userName, $this->password); // nuevo objeto PDO clase nativa de PHP
            // sirve para manejar conexiones a bases de datos
    }

    public function getConn() //getter porque esta protected y de otra manera no se puede acceder a ella
    {
        return $this->conn; // devuelve la conexión
    }
}