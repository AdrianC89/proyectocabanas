<?php

class Cabana {
    private $numeroCabana;
    private $capacidad;
    private $tipo;
    private $costoPorDia;
    private $estado;

    // Array para almacenar IDs únicos e irrepetibles
    private static $idsUnicos = [];

    public function __construct($numeroCabana, $capacidad, $tipo, $costoPorDia) {
        if ($this->esNumeroCabanaUnico($numeroCabana)) {
            $this->numeroCabana = $numeroCabana;
            $this->capacidad = $capacidad;
            $this->tipo = $tipo;
            $this->costoPorDia = $costoPorDia;
            $this->estado = 'activo';
        } else {
            throw new Exception("El número de cabaña '$numeroCabana' ya existe en la base de datos.");
        }
    }
    public function getNumeroCabana() {
        return $this->numeroCabana;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getCostoPorDia() {
        return $this->costoPorDia;
    }

    public function toJson() {
        return [
            'numeroCabana' => $this->numeroCabana,
            'capacidad' => $this->capacidad,
            'tipo' => $this->tipo,
            'costoPorDia' => $this->costoPorDia,
            'estado' => $this->estado
        ];
    }
    public static function fromJson($data) {
        return new Cabana($data['numeroCabana'], $data['capacidad'], $data['tipo'], $data['costoPorDia']);
    }
    public function modificarCabana($nuevaCapacidad, $nuevoTipo, $nuevoCostoPorDia) {
        $this->capacidad = $nuevaCapacidad;
        $this->tipo = $nuevoTipo;
        $this->costoPorDia = $nuevoCostoPorDia;
    }

    public function eliminarCabana() {
        // Cambiamos el estado de la cabaña a "inactivo" en lugar de eliminarla físicamente
        $this->estado = 'inactivo';
    }

    // Función para verificar si un ID es único
    private function esNumeroCabanaUnico($numeroCabana) {
        return !in_array($numeroCabana, self::$idsUnicos);
    }
    
    public function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setCostoPorDia($costoPorDia) {
        $this->costoPorDia = $costoPorDia;
    }
}

?>