<?php

class Connection
{
    private $host;
    private $userName;
    private $password;
    private $db;
    protected $conn;
    private $configFile = "conf.json";

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn=null;
        }
    }

    public function connect()
    {
        if (!file_exists($this->configFile)) { // Verifica si el archivo de configuración existe
            die("No se puede abrir!");
        }

        $configData = file_get_contents($this->configFile); // Lee el contenido del archivo JSON
        $config = json_decode($configData, true); // true para convertir a array asociativo

        $this->host = $config['host'];  
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->db = $config['db'];
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db",$this->userName, $this->password); // Crea una nueva conexión PDO a la base de datos
    }

    public function getConn()
    {
        return $this->conn;
    }
}
