<?php

require_once 'cabana.php';
require_once 'cliente.php';
require_once 'reserva.php';
require_once 'complejo.php';

// Cargar datos del complejo desde el archivo JSON o crear un nuevo complejo si no existe
if (file_exists('complejo.json')) {
    $complejoData = json_decode(file_get_contents('complejo.json'), true);
    if ($complejoData === null && json_last_error() !== JSON_ERROR_NONE) {
        // Error en la lectura del JSON
        echo "Error en la lectura del archivo JSON.\n";
        exit;
    }
    $complejo = new Complejo($complejoData['nombre'], $complejoData['direccion']);
    // Cargar las cabañas, clientes y reservas desde $complejoData
} else {
    $nombreComplejo = readline("Ingrese el nombre del complejo: ");
    $direccionComplejo = readline("Ingrese la dirección del complejo: ");
    $complejo = new Complejo($nombreComplejo, $direccionComplejo);
    guardarComplejoEnJSON($complejo);
}

// Función para guardar los datos del complejo en el archivo JSON
function guardarComplejoEnJSON($complejo)
{
    $complejoData = json_encode($complejo->toJSON(), JSON_PRETTY_PRINT);
    file_put_contents('complejo.json', $complejoData);
}

// Función para gestionar cabañas
function gestionarCabanas($complejo)
{
    while (true) {
        echo "Menu de Gestion de Cabanas:\n";
        echo "1. Agregar Cabana\n";
        echo "2. Modificar Cabana\n";
        echo "3. Eliminar Cabana\n";
        echo "4. Volver al Menu Principal\n";

        $opcion = readline("Seleccione una opcion: ");

        switch ($opcion) {
            case 1:                
                agregarCabana($complejo);
                break;
            case 2:
                modificarCabana($complejo, readline("Ingrese el ID de la cabana a modificar: "));
                break;
            case 3:
                $id = readline("Ingrese el ID de la cabana a eliminar: ");
                // Implementar la logica para eliminar la cabana
                break;
            case 4:
                return; // Volver al Menu Principal
            default:
                echo "Opcion no valida. Intente nuevamente.\n";
                break;
        }
    }
}

// Función para gestionar clientes
function gestionarClientes($complejo)
{
    while (true) {
        echo "Menu de Gestion de Clientes:\n";
        echo "1. Agregar Cliente\n";
        echo "2. Modificar Cliente\n";
        echo "3. Eliminar Cliente\n";
        echo "4. Volver al Menu Principal\n";

        $opcion = readline("Seleccione una opcion: ");

        switch ($opcion) {
            case 1:
                agregarCliente($complejo);
                break;
            case 2:
                $dni = readline("Ingrese el DNI del cliente a modificar: ");
                modificarCliente($complejo, $dni);
                break;
            case 3:
                $dni = readline("Ingrese el DNI del cliente a eliminar: ");
                eliminarCliente($complejo, $dni);
                break;
            case 4:
                return; // Volver al Menu Principal
            default:
                echo "Opcion no valida. Intente nuevamente.\n";
                break;
        }
    }
}

// Función para gestionar reservas
function gestionarReservas($complejo)
{
    while (true) {
        echo "Menu de Gestion de Reservas:\n";
        echo "1. Hacer Reserva\n";
        echo "2. Modificar Reserva\n";
        echo "3. Eliminar Reserva\n";
        echo "4. Volver al Menu Principal\n";

        $opcion = readline("Seleccione una opcion: ");

        switch ($opcion) {
            case 1:
                // Implementar la logica para hacer una reserva
                break;
            case 2:
                $idReserva = readline("Ingrese el ID de la reserva a modificar: ");
                // Implementar la logica para modificar la reserva
                break;
            case 3:
                $idReserva = readline("Ingrese el ID de la reserva a eliminar: ");
                // Implementar la logica para eliminar la reserva
                break;
            case 4:
                return; // Volver al Menu Principal
            default:
                echo "Opcion no valida. Intente nuevamente.\n";
                break;
        }
    }
}

function menuPrincipal($complejo)
{
    while (true) {
        echo "Menu Principal:\n";
        echo "1. Gestionar Cabanas\n";
        echo "2. Gestionar Clientes\n";
        echo "3. Gestionar Reservas\n";
        echo "4. Salir\n";

        $opcion = readline("Seleccione una opcion: ");

        switch ($opcion) {
            case 1:
                gestionarCabanas($complejo);
                break;
            case 2:
                gestionarClientes($complejo);
                break;
            case 3:
                gestionarReservas($complejo);
                break;
            case 4:
                // Guardar los datos y salir
                guardarComplejoEnJSON($complejo);
                exit;
            default:
                echo "Opcion no valida. Intente nuevamente.\n";
                break;
        }
    }
}

function agregarCabana($complejo)
{
    $numeroCabana = readline("Ingrese el número de la cabaña: ");
    $capacidad = readline("Ingrese la capacidad de la cabaña: ");
    $tipo = readline("Ingrese el tipo de la cabaña: ");
    $costoPorDia = readline("Ingrese el costo por día de la cabaña: ");
    $estado = readline("Ingrese el estado de la cabaña: ");

    try {
        $complejo->agregarCabana(new Cabana($numeroCabana, $capacidad, $tipo, $costoPorDia));
        echo "Cabaña agregada con éxito.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}


// Función para modificar una cabaña existente
function modificarCabana($complejo, $id)
{
    $nuevaCapacidad = readline("Ingrese la nueva capacidad: ");
    $nuevoTipo = readline("Ingrese el nuevo tipo: ");
    $nuevoCostoPorDia = readline("Ingrese el nuevo costo por día: ");

    try {
        $complejo->modificarCabana($id, $nuevaCapacidad, $nuevoTipo, $nuevoCostoPorDia);
        echo "Cabaña modificada con éxito.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Función para agregar un nuevo cliente
function agregarCliente($complejo)
{
    $dni = readline("Ingrese el DNI del nuevo cliente: ");
    $nombre = readline("Ingrese el nombre del cliente: ");
    $direccion = readline("Ingrese la dirección del cliente: ");
    $telefono = readline("Ingrese el teléfono del cliente: ");
    $email = readline("Ingrese el correo electrónico del cliente: ");

    try {
        $complejo->agregarCliente(new Cliente($dni, $nombre, $direccion, $telefono, $email));
        echo "Cliente agregado con éxito.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Función para modificar un cliente existente
function modificarCliente($complejo, $dni)
{
    $cliente = $complejo->buscarClientePorDni($dni);
    if ($cliente) {
        $nuevoNombre = readline("Ingrese el nuevo nombre: ");
        $nuevaDireccion = readline("Ingrese la nueva dirección: ");
        $nuevoTelefono = readline("Ingrese el nuevo teléfono: ");
        $nuevoEmail = readline("Ingrese el nuevo correo electrónico: ");

        try {
            $complejo->modificarCliente($dni, $nuevoNombre, $nuevaDireccion, $nuevoTelefono, $nuevoEmail);
            echo "Cliente modificado con éxito.\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Cliente no encontrado.\n";
    }
}
// Función para eliminar un cliente existente
function eliminarCliente($complejo, $dni)
{
    try {
        $complejo->eliminarCliente($dni);
        echo "Cliente eliminado con éxito.\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Llamar la función del menú principal
menuPrincipal($complejo);
