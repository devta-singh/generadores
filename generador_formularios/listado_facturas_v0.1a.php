<?php //listado_facturas_v0.1a.php

/*
Genera un listado de registros de una tabla mostrando una serie de campos
para una lista de campos
*/


require_once("inc/config.inc.php");


/*
v0.1a
	Tenemos una serie de listas de campos:
	campos_a_mostrar (lista de campos que aparecen listados)
	campos_a_ordenar (para mostrar criterior de ordenacion por ese campo)
	campos a buscar (para mostrar una busqueda interactiva por valores de esos campos)

	$_S_campos = "id idk grupo descripcion cliente_nombre cliente_direccion cliente_cif proveedor_nombre proveedor_direccion proveedor_cif numero importe_base tipo_iva iva importe_total fecha_factura fecha_alta fecha_ultimo";
*/

//cargamos estos datos del config.inc.php
// $_S_separador = " ";
// $_S_separador_sql_campos = ", ";
// $__tabla__ = "facturas";
// $__mostrar_enlaces_orden = TRUE;

//recibimos los campos de la URL par ala ordenacion
//nombre de campo
// if(isset($_REQUEST["c"])){
// 	$c = $_REQUEST["c"];
// }else{
// 	$c = null;
// }
// //orden ASC o DESC
// if(isset($_REQUEST["o"])){
// 	if($_REQUEST["o"] == "ASC"){
// 		$o = "ASC";
// 	}else{
// 		$o = "DESC";
// 	}	
// }else{
// 	$o = null;
// }


if(isset($_REQUEST["c"])){

	//si lleva coma, es una lista de campos
	if(strstr(",", $_REQUEST["c"])){
		//hay varios campos de ordenación

		$_cc = $_REQUEST["c"];
		$c = "";
		$Ac = array();
		//separamos los campos y los ordenes por la ,

		$_oo = explode(",", $_REQUEST["o"]);

		foreach((explode(",", $_cc)) as $n => $_c){
			$o = $__o[$n];
			$Ac[] = "$_c $o";
		}
		$c = implode(",", $Ac);

	}else{
		$c = $_REQUEST["c"];
		
		//orden ASC o DESC
		if(isset($_REQUEST["o"])){
			if($_REQUEST["o"] == "ASC"){
				$o = "ASC";
			}else{
				$o = "DESC";
			}	
		}else{
			$o = null;
		}
	}
}else{
	$c = null;
	$o = null;
}

$_S_campos_a_sql = "id idk cliente_nombre proveedor_nombre numero fecha_factura importe_base tipo_iva iva importe_total";

$_S_campos_a_mostrar = "cliente_nombre proveedor_nombre numero fecha_factura importe_base tipo_iva iva importe_total";
$_S_campos_a_ordenar = "cliente_nombre proveedor_nombre numero fecha_factura importe_total";
$_S_campos_a_buscar = "cliente_nombre proveedor_nombre numero importe_total";
$_S_campos_a_enlazar = "numero importe_total";

$_A_campos_a_sql = explode($_S_separador, $_S_campos_a_sql);
$_A_campos_a_mostrar = explode($_S_separador, $_S_campos_a_mostrar);
$_A_campos_a_ordenar = explode($_S_separador, $_S_campos_a_ordenar);
$_A_campos_a_buscar = explode($_S_separador, $_S_campos_a_buscar);
$_A_campos_a_enlazar = explode($_S_separador, $_S_campos_a_enlazar);

//$_sql_lista_campos_mostrar = implode($_S_separador_sql_campos, $_A_campos_a_mostrar);
$_sql_lista_campos_mostrar = implode($_S_separador_sql_campos, $_A_campos_a_sql);
$condicion = "";
$ordenacion = "";


if($c && $o){
	//si hay varios campos de orden
	//nada

	//si hay un campo orden

	$campos_orden = "$c $o";

	$ordenacion = "ORDER BY $campos_orden";
}

//SELECT * FROM facturas WHERE importe_total = 50 ORDER BY fecha_factura ASC
//SELECT * FROM facturas ORDER BY fecha_factura DESC
$sql = "SELECT $_sql_lista_campos_mostrar FROM $__tabla__ $condicion $ordenacion ";
print "SQL: $sql";

$resultados = $__Mysqli->query($sql);
$num_filas = $resultados->num_rows;
$campos = $resultados->num_rows;

//Obtenemos los campos para generar la cabecera de la tabla
$datos_cabecera = array_keys($resultados->fetch_assoc());

$html_cabecera="\t<tr>";
foreach($datos_cabecera as $campo){
	if($__mostrar_enlaces_orden){
		$enlace_orden_asc = "?c=$campo&o=ASC";
		$enlace_orden_desc = "?c=$campo&o=DESC";
		$enlaces_orden=<<<fin
	<span>
	<table style="float:left">
	<tr><td style="vertical_align:middle;">
	\t\t<a href="$enlace_orden_asc"><img src="img/arriba.gif"/></a>
	</td></tr>
	</td></tr>
	<tr><td style="vertical_align:bottom;"> 
	\t\t<a href="$enlace_orden_desc" ><img src="img/abajo.gif"/></a>
	</td></tr>
	</table>
	</span>
fin;
	}else{
		 $enlaces_orden="";
	}

	$Campo=ucfirst($campo);
	$html_cabecera.=<<<fin
	\t\t<th>$Campo $enlaces_orden</th>
fin;
}
$html_cabecera.="\t</tr>";





$resultados->data_seek(0);
print "Filas: $num_filas";
$html_datos = "";
while($datos = $resultados->fetch_assoc()){
	// print_r($datos);
	// print "<br>";

	//leemos los datos de los campos a mostrar	

	$html_datos.="\t<tr>";

	foreach($datos as $campo => $valor){
		$id = $datos["id"];
		if(in_array($campo, $_A_campos_a_enlazar)){
		$texto =<<<fin
			<a href="formulario_factura.php?id=$id">$valor</a>
fin;
		}else{
			$texto = $valor;
		}


		$html_datos.="\t\t<td>";
		$html_datos.="\t\t$texto";		
		$html_datos.="\t\t</td>";
	}

	$html_datos.="\t</tr>";
}

$html_tabla=<<<fin
	<table style="border:3px dashed red; margin:3px; padding:3px;">
		$html_cabecera
		$html_datos
	</table>
fin;

print $html_tabla;



?>