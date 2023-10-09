<?php
require 'Complejo.php';
require 'Cabana.php';
require 'Cliente.php';
require 'Reserva.php';

// Crear objetos para el complejo
$complejo = new Complejo("Complejo Ejemplo", "Calle Ejemplo 123");

// Crear cabañas
$cabana1 = new Cabana(1, 4, "Doble", 120); // ID: 1, Capacidad: 4, Tipo: Doble, Costo por Día: 120
$cabana2 = new Cabana(2, 2, "Individual", 90); // ID: 2, Capacidad: 2, Tipo: Individual, Costo por Día: 90
$cabana3 = new Cabana(3, 6, "Familiar", 150); // ID: 3, Capacidad: 6, Tipo: Familiar, Costo por Día: 150

// Agregar cabañas al complejo
$complejo->agregarCabana($cabana1);
$complejo->agregarCabana($cabana2);
$complejo->agregarCabana($cabana3);

// Crear clientes
$cliente3 = new Cliente("654321987", "Cliente 3", "Calle Principal 456", "+123456789", "cliente3@example.com");
$cliente4 = new Cliente("789123456", "Cliente 4", "Avenida Secundaria 789", "+987654321", "cliente4@example.com");
$cliente5 = new Cliente("135792468", "Cliente 5", "Ruta Principal 123", "+555555555", "cliente5@example.com");

// Agregar clientes al complejo
$complejo->agregarCliente($cliente3);
$complejo->agregarCliente($cliente4);
$complejo->agregarCliente($cliente5);

// Fechas de inicio y fin para las reservas
$fechaInicioReserva1 = "2023-10-15";
$fechaFinReserva1 = "2023-10-20";
$fechaInicioReserva2 = "2023-11-10";
$fechaFinReserva2 = "2023-11-15";

// Realizar dos reservas
$complejo->hacerReserva(4, $cliente3, $cabana1, $fechaInicioReserva1, $fechaFinReserva1);
$complejo->hacerReserva(5, $cliente4, $cabana2, $fechaInicioReserva2, $fechaFinReserva2);


// Convertir a JSON
$jsonData = $complejo->toJSON();

// Guardar en un archivo JSON
$archivo = 'complejo.json';
file_put_contents($archivo, $jsonData);

echo "Los datos se han guardado en el archivo '$archivo'.\n";

// Leer y mostrar los datos desde el archivo JSON
$jsonDataLeido = file_get_contents($archivo);

// Mostrar los datos JSON de forma legible
echo "Datos guardados en el archivo JSON:\n";
echo "<pre>" . json_encode(json_decode($jsonDataLeido), JSON_PRETTY_PRINT) . "</pre>";
