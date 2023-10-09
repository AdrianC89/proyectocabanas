<?php

class Cliente {
    private $dni;
    private $nombre;
    private $direccion;
    private $telefono;
    private $email;

    // Array para almacenar DNIs únicos y garantizar la unicidad
    private static $dnisUnicos = [];

    public function __construct($dni, $nombre, $direccion, $telefono, $email) {
        // Verificar si el DNI es único antes de crear el cliente
        if ($this->esDniUnico($dni)) {
            $this->dni = $dni;
            $this->nombre = $nombre;
            $this->direccion = $direccion;
            $this->telefono = $telefono;
            $this->email = $email;
            // Agregar el DNI a la lista de DNIs únicos
            self::$dnisUnicos[] = $dni;
        } else {
            // Manejar el caso en el que el DNI no es único
            throw new Exception("El DNI '$dni' ya existe en la base de datos.");
        }
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function toJSON() {
        return [
            'dni' => $this->dni,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email
        ];
    }

    public function modificarCliente($nuevoNombre, $nuevaDireccion, $nuevoTelefono, $nuevoEmail) {
        $this->nombre = $nuevoNombre;
        $this->direccion = $nuevaDireccion;
        $this->telefono = $nuevoTelefono;
        $this->email = $nuevoEmail;
    }

    public function eliminarCliente() {
        // Implementa aquí la lógica para eliminar el cliente si es necesario
        // Puedes cambiar el estado del cliente o eliminarlo físicamente de tu sistema
        // Además, asegúrate de eliminar el DNI de la lista de DNIs únicos
        $dni = $this->dni;
        if (($key = array_search($dni, self::$dnisUnicos)) !== false) {
            unset(self::$dnisUnicos[$key]);
        }
    }

    // Función para verificar si un DNI es único
    private function esDniUnico($dni) {
        return !in_array($dni, self::$dnisUnicos);
    }
}

?>