<?php
include('conexion.php');


if(isset($_GET['token'])) {
    $token = $_GET['token'];
    logout($token);
} else {
    echo "Token no proporcionado.";
}

function logout($token) {
    global $mysqli; 
    if ($token) {
        $query = "SELECT * FROM usuarios WHERE token='$token'";
        $result = $mysqli->query($query);
    }
    if ($result && $result->num_rows > 0) {
        $query2 = "UPDATE usuarios SET token='NULL' WHERE token='$token'";
        $resultado = $mysqli->query($query2);
        if ($resultado) {
            echo "Sesión cerrada exitosamente";
        } else {
            echo "Error al cerrar sesión.";
        }
    } else {
        echo "Error al salir.";
    }
}
?>

