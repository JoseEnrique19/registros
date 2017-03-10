<?php require_once('Connections/registros.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_GET['id_producto'])) && ($_GET['id_producto'] != "")) {
  $deleteSQL = sprintf("DELETE FROM productos WHERE id_producto=%s",
                       GetSQLValueString($_GET['id_producto'], "int"));

  mysql_select_db($database_registros, $registros);
  $Result1 = mysql_query($deleteSQL, $registros) or die(mysql_error());

  $deleteGoTo = "index.php";
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_registros, $registros);
$query_consulta1 = "SELECT * FROM productos";
$consulta1 = mysql_query($query_consulta1, $registros) or die(mysql_error());
$row_consulta1 = mysql_fetch_assoc($consulta1);
$totalRows_consulta1 = mysql_num_rows($consulta1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inicio</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-sacale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.min.css">
<style type="text/css">
#apDiv1 {
	position: absolute;
	width: 200px;
	height: 115px;
	z-index: 1;
	left: 63px;
	top: 230px;
}
</style>
</head>
<body>
<div class="container">
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Registro de Productos</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Inicio</a></li>
            <li class="active"><a href="agregar.php">Agregar Nuevo</a></li>
            <li class="active"><a href="editar.php">Editar</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<h1>&nbsp;</h1>
<h1>Inicio</h1>
<div class="btn-lg" id="apDiv1">
  <table width="1267" height="105" border="1">
    <tr>
      <td height="58">ID</td>
      <td>Producto</td>
      <td>Descripcion</td>
      <td>Existencia</td>
      <td>Precio de Compra</td>
      <td>Precio de Venta</td>
      <td>Accion</td>
      </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_consulta1['id_producto']; ?></td>
        <td><?php echo $row_consulta1['producto']; ?></td>
        <td><?php echo $row_consulta1['descripcion']; ?></td>
        <td><?php echo $row_consulta1['existencias']; ?></td>
        <td><?php echo $row_consulta1['precio_compra']; ?></td>
        <td><?php echo $row_consulta1['precio_venta']; ?></td>
        <td><a href="index.php?id_producto=<?php echo $row_consulta1['id_producto']; ?>">Eliminar</a></td>
        </tr>
      <?php } while ($row_consulta1 = mysql_fetch_assoc($consulta1)); ?>
  </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="//assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</div>
</body>
</html>
<?php
mysql_free_result($consulta1);
?>
