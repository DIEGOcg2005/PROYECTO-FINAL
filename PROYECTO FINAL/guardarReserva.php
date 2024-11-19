<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "DIEGO";
$password = "1234";
$dbname = "hotel_madrono";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde el formulario (JSON)
$data = json_decode(file_get_contents("php://input"));

// Verificar que los datos no estén vacíos
if (isset($data->nombre) && isset($data->apellidos) && isset($data->telefono) && isset($data->correo) && isset($data->fechaReserva) && isset($data->horaLlegada) && isset($data->cabana)) {

    $nombre = $conn->real_escape_string($data->nombre);
    $apellidos = $conn->real_escape_string($data->apellidos);
    $telefono = $conn->real_escape_string($data->telefono);
    $correo = $conn->real_escape_string($data->correo);
    $fechaReserva = $conn->real_escape_string($data->fechaReserva);
    $horaLlegada = $conn->real_escape_string($data->horaLlegada);
    $cabana = $conn->real_escape_string($data->cabana);

    // Consultar la base de datos para insertar la nueva reserva
    $sql = "INSERT INTO reservas (nombre, apellidos, telefono, correo, fecha_reserva, hora_llegada, cabana) 
            VALUES ('$nombre', '$apellidos', '$telefono', '$correo', '$fechaReserva', '$horaLlegada', '$cabana')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Reserva guardada con éxito."]);
    } else {
        echo json_encode(["message" => "Error al guardar la reserva: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Todos los campos son necesarios."]);
}

// Cerrar la conexión
$conn->close();
?>
