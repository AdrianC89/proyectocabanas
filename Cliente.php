<?php
class Cliente {
    private $dni;
    private $nombre;
    private $direccion;
    private $telefono;
    private $email;

    public function __construct($dni, $nombre, $direccion, $telefono, $email) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
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

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function toJson() {
        return [
            'dni' => $this->dni,
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email
        ];
    }

    public static function fromJson($data) {
        return new Cliente($data['dni'], $data['nombre'], $data['direccion'], $data['telefono'], $data['email']);
    }
}
