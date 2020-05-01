<?php // inc/config.inc.php
/*
Control de errores
*/
ini_set("display_errors", 1);
error_reporting(15);


//variables básicas compartidas
$_S_separador = " ";
$_S_separador_sql_campos = ", ";
$__tabla__ = "facturas";
$__mostrar_enlaces_orden = TRUE;


/*
Conexión a la BBDD
*/
$__Mysqli = new Mysqli('localhost', 'root','root','grabacion_facturas');

?>