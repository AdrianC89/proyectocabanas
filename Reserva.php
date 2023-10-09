<?php

class Reserva {
    private $id;
    private $cliente;
    private $cabana;
    private $fechaInicio;
    private $fechaFin;

    public function __construct($id, $cliente, $cabana, $fechaInicio, $fechaFin) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->cabana = $cabana;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function getId() {
        return $this->id;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getCabana() {
        return $this->cabana;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function setCabana($cabana) {
        $this->cabana = $cabana;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }


    public function calcularCosto()
    {
        $inicio = new DateTime($this->fechaInicio);
        $fin = new DateTime($this->fechaFin);
        $diferencia = $inicio->diff($fin);
        $diasReserva = $diferencia->days;

        return $diasReserva * $this->cabana->getCostoPorDia();
    }

    public function getDiasReserva()
    {
        $inicio = new DateTime($this->fechaInicio);
        $fin = new DateTime($this->fechaFin);
        $diferencia = $inicio->diff($fin);
        return $diferencia->days;
    }

    public function toJSON()
    {
        return [
            'id' => $this->id,
            'cliente' => $this->cliente->toJSON(),
            'cabana' => $this->cabana->toJSON(),
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'costo' => $this->calcularCosto(),
            'diasReserva' => $this->getDiasReserva()
        ];
    }

    public function modificarReserva($nuevoCliente, $nuevaCabana, $nuevaFechaInicio, $nuevaFechaFin)
    {
        $this->cliente = $nuevoCliente;
        $this->cabana = $nuevaCabana;
        $this->fechaInicio = $nuevaFechaInicio;
        $this->fechaFin = $nuevaFechaFin;
    }

    public static function fromJson($data) {
        $cliente = Cliente::fromJson($data['cliente']);
        $cabana = Cabana::fromJson($data['cabana']);
        return new Reserva($data['id'], $cliente, $cabana, $data['fechaInicio'], $data['fechaFin']);
    }
}
