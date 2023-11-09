<?php
session_start();
$response = array();
if(isset($_SESSION['usuario'])){
    session_destroy();
    echo "se destruyo todo";
    $response['success'] = true;
    $response['message'] = "La sesión se ha destruido correctamente.";
} else {
    $response['success'] = false;
    $response['message'] = "Ha ocurrido un error al destruir la sesión.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>