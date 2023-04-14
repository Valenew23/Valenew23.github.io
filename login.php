<?php require_once('Connections/conexione.php'); ?>
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

mysql_select_db($database_conexione, $conexione);
$query_Recordset1 = "SELECT * FROM usuarios";
$Recordset1 = mysql_query($query_Recordset1, $conexione) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['correo'])) {
  $loginUsername=$_POST['correo'];
  $password=$_POST['Password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.html";
  $MM_redirectLoginFailed = "Denegado.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexione, $conexione);
  
  $LoginRS__query=sprintf("SELECT email, password FROM usuarios WHERE email=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexione) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login</title>
<style type="text/css">
a:link {
	color: #BE9641;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #BE9641;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
</style>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<table width="1340" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#E9E4D8">
<tr>
<td width="1182" align="right" bgcolor="#D6D6D6" ><font color="#BE9641"><a href="login.php">Iniciar sesion</a></font></td>
<td width="67" align="right" bgcolor="#D6D6D6"><font color="#BE9641"><a href="registro.php">Registrarse</a></font></td>

</tr>

</table>
<table  width="1340" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
<tr>
<td>&nbsp;</td>
</tr>
</table>
<table width="1340" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#FFE1F0">
  <tr>
    <td width="249"><img src="imagenes/My project-1.png" width="184" height="92" /></td>
    <td width="25">&nbsp;</td>
    <td width="1018"><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="index.html">INICIO</a>        </li>
      <li><a href="presentacion.html">QUI&Eacute;NES SOMOS</a></li>
      <li><a href="flores.html">CAT&Aacute;LOGO</a>        </li>
      <li><a href="terminos.html">T&Eacute;RMINOS</a></li>
      <li><a href="contactos.php">CONT&Aacute;CTANOS</a></li>
    </ul></td>
  </tr>
</table>
</table>
<table width="1340" border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td width="639" bgcolor="#FFFFFF"><font face="Century Gothic" size="3"><center>
          <p align="center">&nbsp;</p>
          <p align="center"><a href="index.html">INICIO</a></p>
          <p align="center">&nbsp;</p>
    
    </center>
    </font></td>
    
</table>
<table width="1340" border="0" cellspacing="0" cellpadding="8" bgcolor="#E9E4D8">
  <tr>
    <td align="center" bgcolor="#FFE1F0"><font color="#BE9641" face="Century Gothic" size="4" >Iniciar Sesión</font></td>
  </tr>
  <tr>
    <td align="center"><form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
      <table width="525" height="200" border="0" cellpadding="8" cellspacing="0">
        <tr>
          <td bgcolor="#E9E4D8"><font color="#BE9641" face="Century Gothic" size="3" >Correo Electronico</font></td>
          <td bgcolor="#E9E4D8"><label for="correo"></label>
            <input name="correo" type="text" id="correo" size="55" /></td>
        </tr>
        <tr>
          <td bgcolor="#E9E4D8"><font color="#BE9641" face="Century Gothic" size="3" >Password</font></td>
          <td bgcolor="#E9E4D8">
            <input name="Password" type="text" id="Password" size="55" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" bgcolor="#E9E4D8"><input type="submit" name="login" id="login" value="Iniciar Sesión" />
          </td>
          </tr>
      </table>
    </form>
    
    </td>
  </tr>
</table>
<table width="1340" border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td align="center" bgcolor="#E9E4D8"><a href="registro.php">¿No tienes una cuenta? Cree una aquí</a></td>
  </tr>
</table>
<table width="1340" border="0" cellspacing="0" cellpadding="8">
  
  <tr>
  <td colspan="3" bgcolor="#FFE1F0"><center>
      <p>&nbsp;</p>
      <p><img src="imagenes/My project-1.png" width="184" height="92" /></p>
    </center></td>
    
  </tr>
  <tr>
    <td colspan="3" bgcolor="#FFE1F0"><center>
      <p><font face="Century Gothic">Tu eres nuestra razón de ser</font></p>
      <p>&nbsp;</p>
    </center></td>
  </tr>
  <tr>
    <td width="178" bgcolor="#FFE1F0">&nbsp;</td>
     <td width="1018" bgcolor="#FFE1F0"><ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="index.html">INICIO</a>        </li>
      <li><a href="presentacion.html">QUI&Eacute;NES SOMOS</a></li>
      <li><a href="flores.html">CAT&Aacute;LOGO</a>        </li>
      <li><a href="terminos.html">T&Eacute;RMINOS</a></li>
      <li><a href="contactos.php">CONT&Aacute;CTANOS</a></li>
    </ul></td>
    <td width="38" bgcolor="#FFE1F0">&nbsp;</td>
    
  </tr>
</table>
<table width="1340" border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td bgcolor="#D6D6D6"><font face="Century Gothic"><p>Copyright &copy; 2023 La flor de Cervantes.</p>
    <p>C.P♡</p></font></td>
  </tr>
</table>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
