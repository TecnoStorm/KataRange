<?php
include "UsuariosRegistrados.php";
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$usuariosRegistrados=new UsuariosRegistrados();
echo $usuariosRegistrados->comparar($usuario,$clave);
?>