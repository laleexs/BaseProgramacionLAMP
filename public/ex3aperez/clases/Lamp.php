<?php
require_once 'Connection.php';

class Lamp
{
    private $id;
    private $nombre;
    private $encendida;
    private $modelo;
    private $potencia;
    private $zona;

    public function __construct($id, $nombre, $encendida, $modelo, $potencia, $zona)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->encendida = $encendida;
        $this->modelo = $modelo;
        $this->potencia = $potencia;
        $this->zona = $zona;
    }


    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEncendida() {
        return $this->encendida;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getPotencia() {
        return $this->potencia;
    }

    public function getZona() {
        return $this->zona;
    }
}