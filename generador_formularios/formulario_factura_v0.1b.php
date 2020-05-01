<?php //formulario_factura_v0.1a.php

/*
Recibe los datos del formulario para una lista de campos
*/

require_once("inc/config.inc.php");

/*
Control de errores
*/
// ini_set("display_errors", 1);
// error_reporting(15);

/*
Establecemos los campos a recibir
*/

$_S_separador=" ";
$_S_campos = "id idk grupo descripcion cliente_nombre cliente_direccion cliente_cif proveedor_nombre proveedor_direccion proveedor_cif numero importe_base tipo_iva iva importe_total fecha_factura fecha_alta fecha_ultimo";
$_A_campos = explode($_S_separador, $_S_campos);

//campos a ignorar
$_S_campos_ignorar = "id idk";
$_A_campos_ignorar = explode($_S_separador, $_S_campos_ignorar);

$__ahora = date("Ymd H:i:s", time());


// print is_array($_A_campos);
// print is_array($_A_campos_ignorar);

//campos de datos = todos los campos - campos a ignorar
//usamos //array_diff ( array $array1 , array $array2 [, array $... ] ) : array
$_A_campos_datos = array_diff($_A_campos, $_A_campos_ignorar);//calcula la resta de los arrays

$_S_lista_campos_codificada = strrev(base64_encode(implode($_S_separador, $_A_campos_datos)));
//$_S_lista_campos_codificada = implode($_S_separador, $_A_campos_datos);





/////////
/////////

//recogemos el id
if(isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];

	//creamos la consulta SQL
	$sql = "SELECT * FROM $__tabla__ WHERE id='$id'";

	print "<br>SQL: $sql";

	//ahora recuperamos los datos
	$resultados = $__Mysqli->query($sql);

	//$_A_valores_recibidos = array();
	$_A_valores_recibidos = $resultados->fetch_assoc();

	$_accion = "modificar";

	// $_A_valores_recibidos["id"]="";
	// $_A_valores_recibidos["idk"]="";
	// $_A_valores_recibidos["grupo"]="combustible";
	// $_A_valores_recibidos["descripcion"]="gasolina";
	// $_A_valores_recibidos["cliente_nombre"]="Unamente GRD, SL";
	// $_A_valores_recibidos["cliente_direccion"]="Cantarranas, 2";
	// $_A_valores_recibidos["cliente_cif"]="B84747302";
	// $_A_valores_recibidos["proveedor_nombre"]="Alameda SL";
	// $_A_valores_recibidos["proveedor_direccion"]="";
	// $_A_valores_recibidos["proveedor_cif"]="";
	// $_A_valores_recibidos["numero"]="";
	// $_A_valores_recibidos["importe_base"]="50";
	// $_A_valores_recibidos["tipo_iva"]="21";
	// $_A_valores_recibidos["iva"]="";
	// $_A_valores_recibidos["importe_total"]="";
	// $_A_valores_recibidos["fecha_factura"]="$__ahora";
	// $_A_valores_recibidos["fecha_alta"]="";
	// $_A_valores_recibidos["fecha_ultimo"]="";


}else{
	$_A_valores_recibidos = array();

	$_A_valores_recibidos["id"]="";
	$_A_valores_recibidos["idk"]="";
	$_A_valores_recibidos["grupo"]="combustible";
	$_A_valores_recibidos["descripcion"]="gasolina";
	$_A_valores_recibidos["cliente_nombre"]="Unamente GRD, SL";
	$_A_valores_recibidos["cliente_direccion"]="Cantarranas, 2";
	$_A_valores_recibidos["cliente_cif"]="B84747302";
	$_A_valores_recibidos["proveedor_nombre"]="Alameda SL";
	$_A_valores_recibidos["proveedor_direccion"]="";
	$_A_valores_recibidos["proveedor_cif"]="";
	$_A_valores_recibidos["numero"]="";
	$_A_valores_recibidos["importe_base"]="50";
	$_A_valores_recibidos["tipo_iva"]="21";
	$_A_valores_recibidos["iva"]="";
	$_A_valores_recibidos["importe_total"]="";
	$_A_valores_recibidos["fecha_factura"]="$__ahora";
	$_A_valores_recibidos["fecha_alta"]="";
	$_A_valores_recibidos["fecha_ultimo"]="";

	$_accion = "grabar";

}



/*
$_A_valores_recibidos[""]="";
$_A_valores_recibidos[""]="";
$_A_valores_recibidos[""]="";
$_A_valores_recibidos[""]="";

id
idk
grupo
descripcion
cliente_nombre
cliente_direccion
cliente_cif
proveedor_nombre
proveedor_direccion
proveedor_cif
numero
importe_base
tipo_iva
iva
importe_total
fecha_factura
fecha_alta
fecha_ultimo

*/
/////////
/////////



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
	if(isset($_A_valores_recibidos[$_campo])){
		//Si está en los valores recibidos (un arraya tal efecto)
		$_A_valores[$_campo] = $_A_valores_recibidos[$_campo];	
	}elseif(isset($_REQUEST[$_campo])){
		//Si está en la lista de valores recibidos por POST o GET o COOKIES o SESION -de esto no muy seguro-
		$_A_valores[$_campo] = $_REQUEST[$_campo];	
	}else{
		//Asignamos un valor vacío
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
	<!--
	<textarea onclick="this.select();">
		$_codigo_sin_caracteres_html
	</textarea>
	<br>
	-->
	<form action="recibe_campos.php" method="post">
	$_S_codigo_html_campos
	<input type="hidden" name="__accion__" value="$_accion"/>
	<input type="hidden" name="__lista_campos__" value="$_S_lista_campos_codificada"/>
	<br>
	<input type="submit" value="Enviar datos"/>
	</form>
</body>
</html>
fin;

?>