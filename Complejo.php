<?php
require_once 'cabana.php';
require_once 'cliente.php';
require_once 'reserva.php';

class Complejo
{
    private $nombre;
    private $direccion;
    private $cabanas;
    private $clientes;
    private $reservas;

    public function __construct($nombre, $direccion)
    {
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
        $this->cabanas = [];
        $this->clientes = [];
        $this->reservas = [];
    }

    public function agregarCabana($cabana)
    {
        $this->cabanas[] = $cabana;
    }

    public function modificarCabana($cabanaId, $nuevoNumero, $nuevoTipo, $nuevoCostoPorDia)
    {
        foreach ($this->cabanas as &$cabana) {
            if ($cabana->getNumeroCabana() == $cabanaId) {
                $cabana->setNumeroCabana($nuevoNumero);
                $cabana->setTipo($nuevoTipo);
                $cabana->setCostoPorDia($nuevoCostoPorDia);
            }
        }
    }

    public function eliminarCabana($cabanaId)
    {
        foreach ($this->cabanas as $key => $cabana) {
            if ($cabana->getNumeroCabana() == $cabanaId) {
                unset($this->cabanas[$key]);
            }
        }
    }

    public function agregarCliente($cliente)
    {
        $this->clientes[] = $cliente;
    }

    public function modificarCliente($clienteDni, $nuevoNombre)
    {
        foreach ($this->clientes as &$cliente) {
            if ($cliente->getDni() == $clienteDni) {
                $cliente->setNombre($nuevoNombre);
            }
        }
    }

    public function eliminarCliente($clienteDni)
    {
        foreach ($this->clientes as $key => $cliente) {
            if ($cliente->getDni() == $clienteDni) {
                unset($this->clientes[$key]);
            }
        }
    }

// Reemplazar la función hacerReserva con esta
public function hacerReserva($idReserva, $cliente, $cabana, $fechaInicio, $fechaFin) {
    // Verificar si la reserva ya existe por ID
    $reservaExistente = $this->buscarReservaPorId($idReserva);

    if ($reservaExistente !== null) {
        // La reserva ya existe, actualiza sus datos
        $reservaExistente->modificarReserva($cliente, $cabana, $fechaInicio, $fechaFin);
    } else {
        // La reserva no existe, crea una nueva reserva
        $reserva = new Reserva($idReserva, $cliente, $cabana, $fechaInicio, $fechaFin);
        $this->reservas[] = $reserva;
    }
}

    // Agregar esta función para buscar una reserva por ID
    public function buscarReservaPorId($idReserva)
    {
        foreach ($this->reservas as $reserva) {
            if ($reserva->getId() === $idReserva) {
                return $reserva;
            }
        }
        return null; // Reserva no encontrada
    }
    public function modificarReserva($idReserva, $nuevoCliente, $nuevaCabana, $nuevaFechaInicio, $nuevaFechaFin)
    {
        foreach ($this->reservas as &$reserva) {
            if ($reserva->getId() == $idReserva) {
                $reserva->setCliente($nuevoCliente);
                $reserva->setCabana($nuevaCabana);
                $reserva->setFechaInicio($nuevaFechaInicio);
                $reserva->setFechaFin($nuevaFechaFin);
            }
        }
    }

    public function eliminarReserva($idReserva)
    {
        foreach ($this->reservas as $key => $reserva) {
            if ($reserva->getId() == $idReserva) {
                unset($this->reservas[$key]);
            }
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public static function fromJson($data)
    {
        $nombre = $data['nombre'];
        $direccion = $data['direccion'];
        $complejo = new Complejo($nombre, $direccion);

        // Agregar clientes desde el JSON
        if (isset($data['clientes']) && is_array($data['clientes'])) {
            foreach ($data['clientes'] as $clienteData) {
                $cliente = Cliente::fromJson($clienteData);
                $complejo->agregarCliente($cliente);
            }
        }

        // Agregar reservas desde el JSON
        if (isset($data['reservas']) && is_array($data['reservas'])) {
            foreach ($data['reservas'] as $reservaData) {
                // Necesitas obtener el cliente y la cabaña correspondientes para la reserva
                // Puedes usar el DNI del cliente y el número de cabaña para buscarlos en el complejo
                $clienteDni = $reservaData['cliente']['dni'];
                $cabanaNumero = $reservaData['cabana']['numeroCabana'];
                $cliente = $complejo->buscarClientePorDni($clienteDni);
                $cabana = $complejo->buscarCabanaPorNumero($cabanaNumero);

                // Verifica si el cliente y la cabaña se encontraron antes de crear la reserva
                if ($cliente !== null && $cabana !== null) {
                    // Actualiza la llamada a hacerReserva con los parámetros adecuados
                    $idReserva = $reservaData['id'];
                    $fechaInicio = $reservaData['fechaInicio'];
                    $fechaFin = $reservaData['fechaFin'];

                    // Aquí llama a la función hacerReserva de Complejo
                    $complejo->hacerReserva($idReserva, $cliente, $cabana, $fechaInicio, $fechaFin);
                } else {
                    echo "cabaña o cliente no encontrados";
                }
            }
        }

        return $complejo;
    }
    
    public function toJSON()
{
    $data = [
        'nombre' => $this->getNombre(),
        'direccion' => $this->getDireccion(),
        'cabanas' => array_map(function ($cabana) {
            return $cabana->toJSON();
        }, $this->cabanas),
        'clientes' => array_map(function ($cliente) {
            return $cliente->toJSON();
        }, $this->clientes),
        'reservas' => array_map(function ($reserva) {
            return $reserva->toJSON();
        }, $this->reservas)
    ];

    return $data;
}

    // Función para buscar un cliente por su DNI
    public function buscarClientePorDni($dni)
    {
        foreach ($this->clientes as $cliente) {
            if ($cliente->getDni() === $dni) {
                return $cliente;
            }
        }
        return null; // Cliente no encontrado
    }

    // Función para buscar una cabaña por su número
    public function buscarCabanaPorNumero($numeroCabana) {
        foreach ($this->cabanas as $cabana) {
            if ($cabana->getNumeroCabana() === $numeroCabana) {
                return $cabana;
            }
        }
        return null; // Cabaña no encontrada
    }
}