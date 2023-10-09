<?php

class Cabana {
    private $id;
    private $capacidad;
    private $tipo;
    private $costoPorDia;
    private $estado; // Agregamos un atributo para el estado de la cabaña

    // Array para almacenar IDs únicos e irrepetibles
    private static $idsUnicos = [];

    public function __construct($id, $capacidad, $tipo, $costoPorDia) {
        // Verificar si el ID es único antes de crear la cabaña
        if ($this->esIdUnico($id)) {
            $this->id = $id;
            $this->capacidad = $capacidad;
            $this->tipo = $tipo;
            $this->costoPorDia = $costoPorDia;
            $this->estado = 'activo'; // Inicializamos el estado como activo
            // Agregar el ID a la lista de IDs únicos
            self::$idsUnicos[] = $id;
        } else {
            // Manejar el caso en el que el ID no es único
            throw new Exception("El ID '$id' ya existe en la base de datos.");
        }
    }

    public function getId() {
        return $this->id;
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

    public function toJSON() {
        return [
            'id' => $this->id,
            'capacidad' => $this->capacidad,
            'tipo' => $this->tipo,
            'costoPorDia' => $this->costoPorDia,
            'estado' => $this->estado // Incluimos el estado en la representación JSON
        ];
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
    private function esIdUnico($id) {
        return !in_array($id, self::$idsUnicos);
    }
}

?>

