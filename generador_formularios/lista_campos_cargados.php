<?php //lista_campos_cargados_v01a.php


/*
Recibe los datos del formulario para una lista de campos
*/

/*
Cambios
v 0.1a
	Añadimos los valores de los campos en los campos HTML
	Los valores llegan como un array asociado a los nombres de campo
*/


/*
Control de errores
*/
ini_set("display_errors", 1);
error_reporting(15);

/*
Establecemos los campos a recibir
*/

$_S_separador=" ";
$_S_campos = "id idk grupo descripcion cliente_nombre cliente_direccion cliente_cif proveedor_nombre proveedor_direccion proveedor_cif numero importe_base tipo_iva iva importe_total fecha_factura fecha_alta";
$_A_campos = explode($_S_separador, $_S_campos);

//campos a ignorar
$_S_campos_ignorar = "id idk";
$_A_campos_ignorar = explode($_S_separador, $_S_campos_ignorar);



// print is_array($_A_campos);
// print is_array($_A_campos_ignorar);

//campos de datos = todos los campos - campos a ignorar
//usamos //array_diff ( array $array1 , array $array2 [, array $... ] ) : array
$_A_campos_datos = array_diff($_A_campos, $_A_campos_ignorar);//calcula la resta de los arrays

$_A_valores = array();
$_A_rotulos = array();
$_A_nombres = array();
$_A_ids = array();
$_A_ids = array();
$_A_titulos = array();

$_A_codigo_html_campos = array();
foreach($_A_campos_datos as $_campo){
	//print "<br>$_campo";
	//recuperamos un valor para ese campo desde REQUEST
	if(isset($_REQUEST[$_campo])){
		$_A_valores[$_campo] = $_REQUEST[$_campo];	
	}else{
		$_A_valores[$_campo] = "";
	}
	$_valor = $_A_valores[$_campo];

	if(isset($_A_rotulos[$_campo])){
		$_rotulo = $_A_rotulos[$_campo];
	}else{
		$_rotulo = ucfirst($_campo);
	}

	if(isset($_A_nombres[$_campo])){
		$_nombre = $_A_nombres[$_campo];
	}else{
		$_nombre = ucfirst($_campo);
	}	

	if(isset($_A_ids[$_campo])){
		$_id = $_A_ids[$_campo];
	}else{
		$_id = $_campo;
	}

	if(isset($_A_titulos[$_campo])){
		$_titulo = $_A_titulos[$_campo];
	}else{
		$_titulo = ucfirst($_campo);
	}

	//generamos un campo html con ese valor
	$_A_codigo_html_campos[$_campo]=<<<fin
	$_rotulo <input type="text" name="$_nombre" id="$_id" value="$_valor" title="$_titulo">
fin;
}

$_S_codigo_html_campos = implode("<br>\n", $_A_codigo_html_campos);
//print $_S_codigo_html_campos;
$_codigo_sin_caracteres_html = htmlentities($_S_codigo_html_campos, ENT_QUOTES);


header("Content-type: text/html; charset=UTF-8");

print <<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Generador: listado de campos</title>
</head>
<body>
	<textarea onclick="this.select();">
		$_codigo_sin_caracteres_html
	</textarea>
	<br>
	$_S_codigo_html_campos
</body>
</html>
fin;

?>