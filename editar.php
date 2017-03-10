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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE productos SET descripcion=%s, existencias=%s, precio_compra=%s, precio_venta=%s WHERE producto=%s",
                       GetSQLValueString($_POST['txt_descrip'], "text"),
                       GetSQLValueString($_POST['txt_exist'], "int"),
                       GetSQLValueString($_POST['txt_pComp'], "double"),
                       GetSQLValueString($_POST['txt_pVent'], "double"),
                       GetSQLValueString($_POST['txt_producto'], "text"));

  mysql_select_db($database_registros, $registros);
  $Result1 = mysql_query($updateSQL, $registros) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_modificar = 1;
$pageNum_modificar = 0;
if (isset($_GET['pageNum_modificar'])) {
  $pageNum_modificar = $_GET['pageNum_modificar'];
}
$startRow_modificar = $pageNum_modificar * $maxRows_modificar;

mysql_select_db($database_registros, $registros);
$query_modificar = "SELECT * FROM productos";
$query_limit_modificar = sprintf("%s LIMIT %d, %d", $query_modificar, $startRow_modificar, $maxRows_modificar);
$modificar = mysql_query($query_limit_modificar, $registros) or die(mysql_error());
$row_modificar = mysql_fetch_assoc($modificar);

if (isset($_GET['totalRows_modificar'])) {
  $totalRows_modificar = $_GET['totalRows_modificar'];
} else {
  $all_modificar = mysql_query($query_modificar);
  $totalRows_modificar = mysql_num_rows($all_modificar);
}
$totalPages_modificar = ceil($totalRows_modificar/$maxRows_modificar)-1;

$queryString_modificar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificar") == false && 
        stristr($param, "totalRows_modificar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificar = sprintf("&totalRows_modificar=%d%s", $totalRows_modificar, $queryString_modificar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inicio</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-sacale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.min.css">
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
          <a class="navbar-brand" href="#">Editar datos</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Inicio</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </nav>

<h1>&nbsp;</h1>

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>"><table width="200" border="1">
  <?php do { ?>
    <tr>
      <td><?php echo $row_modificar['id_producto']; ?></td>
      <td><label for="txt_producto"></label>
        <input name="txt_producto" type="text" id="txt_producto" value="<?php echo $row_modificar['producto']; ?>" /></td>
      <td><label for="txt_descrip"></label>
        <input name="txt_descrip" type="text" id="txt_descrip" value="<?php echo $row_modificar['descripcion']; ?>" /></td>
      <td><label for="txt_exist"></label>
        <input name="txt_exist" type="text" id="txt_exist" value="<?php echo $row_modificar['existencias']; ?>" /></td>
      <td><label for="txt_pComp"></label>
        <input name="txt_pComp" type="text" id="txt_pComp" value="<?php echo $row_modificar['precio_compra']; ?>" /></td>
      <td><label for="txt_pVent"></label>
        <input name="txt_pVent" type="text" id="txt_pVent" value="<?php echo $row_modificar['precio_venta']; ?>" /></td>
    </tr>
    <tr>
      <td>ID</td>
      <td>Producto</td>
      <td>Descripcion</td>
      <td>Existencia</td>
      <td>Precio de Compra</td>
      <td>Precio de Venta</td>
    </tr>
    <?php } while ($row_modificar = mysql_fetch_assoc($modificar)); ?>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, 0, $queryString_modificar); ?>"><img src="images/First.gif" /></a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, max(0, $pageNum_modificar - 1), $queryString_modificar); ?>"><img src="images/Previous.gif" /></a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, min($totalPages_modificar, $pageNum_modificar + 1), $queryString_modificar); ?>"><img src="images/Next.gif" /></a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, $totalPages_modificar, $queryString_modificar); ?>"><img src="images/Last.gif" /></a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
</table>

  <input type="submit" name="btn_editar" id="btn_editar" value="Editar" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="//assets/js/vendor/jquery.min.js"><\/script>')</script>
  <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="js/ie10-viewport-bug-workaround.js"></script>
</div>
</body>
</html>
<?php
mysql_free_result($modificar);
?>
