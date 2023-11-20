<?php
class Receta
{
    private $id;
    private $consulta;
    private $medicamento;
    private $cantidad;

    public function __construct($id, $consulta, $medicamento, $cantidad)
    {
        $this->id = $id;
        $this->consulta = $consulta;
        $this->medicamento = $medicamento;
        $this->cantidad = $cantidad;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getConsulta()
    {
        return $this->consulta;
    }

    public function getMedicamento()
    {
        return $this->medicamento;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
}