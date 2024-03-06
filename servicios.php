<?php
include('conexion.php');

function login($user, $pass) {
    global $mysqli; 
    $token= 'NULL';
    $pass = md5($pass);
    $query = "SELECT * FROM usuarios WHERE usuario='$user' AND contrasenia='$pass'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $token = sha1($fila['usuario'].$fila['contrasenia'].$fila['fecha_sesion']);
        $query2 = "UPDATE usuarios SET token='$token' WHERE id=".$fila['id'];
        $resultado=$mysqli->query($query2);

        return $token;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}



function consulta($token){
    global $mysqli; 
    $query = "SELECT * FROM usuarios WHERE token='$token'";
    $result = $mysqli->query($query);
    if ($result && $result->num_rows > 0) {
        return $result;
    } else {
        echo "Error";
    }

}


$token=login('bel', '123');
$prueba =consulta($token);
if ($prueba) {
    $fila = $prueba->fetch_assoc();
    // echo ($fila['usuario'].$fila['contrasenia'].$fila['fecha_sesion']);
    echo "Bienvenido, {$fila['usuario']}";
    echo "</br><button onclick=\"window.location.href='servicioLogout.php?token={$fila['token']}'\">Cerrar sesión</button>";
    }



    function logout($token){
        global $mysqli; 
        if ($token) {
            $query = "SELECT * FROM usuarios WHERE token=$token";
            $result = $mysqli->query($query);
            }
        if ($result && $result->num_rows > 0) {
    
            $query2 = "UPDATE usuarios SET token='NULL' WHERE token=$token";
            $resultado=$mysqli->query($query2);
    
            return $resultado;
        } else {
            echo "Error al salir.";
        }
    }
    



?>