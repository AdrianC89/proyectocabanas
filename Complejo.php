<?php

class Complejo {
    private $nombre;
    private $direccion;
    private $cabanas;
    private $clientes;
    private $reservas;

    public function __construct($nombre, $direccion) {
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
        $this->cabanas = [];
        $this->clientes = [];
        $this->reservas = [];
    }

    public function agregarCabana($cabana) {
        $this->cabanas[] = $cabana;
    }

    public function modificarCabana($cabanaId, $nuevoNumero, $nuevoTipo, $nuevoCostoPorDia) {
        foreach ($this->cabanas as &$cabana) {
            if ($cabana->getId() == $cabanaId) {
                $cabana->setNumero($nuevoNumero);
                $cabana->setTipo($nuevoTipo);
                $cabana->setCostoPorDia($nuevoCostoPorDia);
            }
        }
    }

    public function eliminarCabana($cabanaId) {
        foreach ($this->cabanas as $key => $cabana) {
            if ($cabana->getId() == $cabanaId) {
                unset($this->cabanas[$key]);
            }
        }
    }

    public function agregarCliente($cliente) {
        $this->clientes[] = $cliente;
    }

    public function modificarCliente($clienteDni, $nuevoNombre) {
        foreach ($this->clientes as &$cliente) {
            if ($cliente->getDni() == $clienteDni) {
                $cliente->setNombre($nuevoNombre);
            }
        }
    }

    public function eliminarCliente($clienteDni) {
        foreach ($this->clientes as $key => $cliente) {
            if ($cliente->getDni() == $clienteDni) {
                unset($this->clientes[$key]);
            }
        }
    }

    public function hacerReserva($idReserva, $cliente, $cabana, $fechaInicio, $fechaFin) {
        $reserva = new Reserva($idReserva, $cliente, $cabana, $fechaInicio, $fechaFin);
        $this->reservas[] = $reserva;
    }

    public function modificarReserva($idReserva, $nuevoCliente, $nuevaCabana, $nuevaFechaInicio, $nuevaFechaFin) {
        foreach ($this->reservas as &$reserva) {
            if ($reserva->getId() == $idReserva) {
                $reserva->setCliente($nuevoCliente);
                $reserva->setCabana($nuevaCabana);
                $reserva->setFechaInicio($nuevaFechaInicio);
                $reserva->setFechaFin($nuevaFechaFin);
            }
        }
    }

    public function eliminarReserva($idReserva) {
        foreach ($this->reservas as $key => $reserva) {
            if ($reserva->getId() == $idReserva) {
                unset($this->reservas[$key]);
            }
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function toJSON() {
        $data = [
            'nombre' => $this->getNombre(),
            'direccion' => $this->getDireccion(),
            'cabanas' => [],
            'clientes' => [],
            'reservas' => []
        ];

        foreach ($this->cabanas as $cabana) {
            $data['cabanas'][] = $cabana->toJSON();
        }

        foreach ($this->clientes as $cliente) {
            $data['clientes'][] = $cliente->toJSON();
        }

        foreach ($this->reservas as $reserva) {
            $data['reservas'][] = $reserva->toJSON();
        }

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function buscarClientePorDni($dni) {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getDni() === $dni) {
                return $cliente;
            }
        }
        return null; // Cliente no encontrado
    }

    public function buscarCabanaPorId($id) {
        foreach ($this->cabanas as $cabana) {
            if ($cabana->getId() === $id) {
                return $cabana;
            }
        }
        return null; // Cabaña no encontrada
    }
}

?>
