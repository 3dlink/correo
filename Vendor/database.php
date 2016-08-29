<?php
$host="localhost";
$user="root";
$password="";
$database="correspondencia";

$conexion = mysqli_connect($host,$user,$password);
mysqli_select_db($conexion,$database);
?>