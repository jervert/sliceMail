<?
session_start();

include('_inc/deteccion.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="ficheros/CSS_principal_v1.css" media="all" type="text/css" rel="stylesheet"/>
<link href="ficheros/CSS_anchos.php" media="all" type="text/css" rel="stylesheet"/>

<script type="text/javascript" src="ficheros/JS_jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="ficheros/JS_comportamientos.js"></script>

<title>Envío de Newsletter</title>
</head>

<body class="<?=$claseNav;?>">

<div id="contenedor">

<h1>Envío de Newsletter</h1>
<?
if (isset($_GET['msg'])) {
?>
	<? if ($_GET['msg']=='si') {$mensaje='El mensaje se ha enviado correctamente';$claseMensaje='mensaje_exito';}?>
	<? if ($_GET['msg']=='no') {$mensaje='No ha sido posible enviar el mensaje: '.$_GET['error'];$claseMensaje='mensaje_error';}?>
<div class="mensaje <?=$claseMensaje;?>">
	<p><?=$mensaje;?></p>
</div>
<?
}
?>
<form action="mail.php" method="post">
	<p>Los campos con asterisco (*) son obligatorios</p>
	
	
	<fieldset>
		<legend>Datos del usuario</legend>
		<p><label for="c_de"><span>Nombre:</span><input class="ancho_256" type="text" name="de" id="c_de" value="<?=$_SESSION['ses_de'];?>" /></label><em class="ayuda">Tu nombre.</em></p>
		<p><label for="c_desde"><span>Correo:*</span><input class="ancho_256 obligatorio" type="text" name="desde" id="c_desde" value="<?=$_SESSION['ses_desde'];?>" /></label><em class="ayuda">Tu dirección de e-mail.</em></p>
	</fieldset>
	
	<fieldset>
		<legend>Datos de servidor SMTP</legend>
		<p><label for="c_servidor"><span>Servidor:</span><input class="obligatorio ancho_256" type="text" name="servidor" id="c_servidor" value="<?=$_SESSION['ses_servidor'];?>" /></label><em class="ayuda">Servidor SMTP, por ejemplo <strong>smtp.gmail.com</strong>.</em></p>
		<p><label for="c_puerto"><span>Puerto:</span><input class="obligatorio ancho_26" type="text" name="puerto" id="c_puerto" value="<?=$_SESSION['ses_puerto'];?>" /></label><em class="ayuda">Puerto del servidor SMTP: el predeterminado es el <strong>25</strong>, aunque Gmail y otros proveedores utilizan el <strong>587</strong>.</em></p>
		<?
		$checkedSeguridad='';
		if ($_SESSION['ses_seguridad']==1) {$checkedSeguridad=' checked="checked"';}
		?>
		<p class="campoCheck"><label for="c_seguridad"><input type="checkbox" name="seguridad" id="c_seguridad" value="1"<?=$checkedSeguridad;?> /><span>Conexión segura TLS</span></label></p>
		<p><label for="c_usuario"><span>Usuario:*</span><input class="obligatorio ancho_256" type="text" name="usuario" id="c_usuario" value="<?=$_SESSION['ses_usuario'];?>" /></label></p>
		<p><label for="c_clave"><span>Clave:*</span><input class="obligatorio ancho_256" type="password" name="clave" id="c_clave" value="<?=$_SESSION['ses_clave'];?>" /></label></p>
	</fieldset>
	
	<fieldset>
		<legend>Datos del mensaje</legend>
		<p><label for="c_destinatario"><span>Destinatario/s:*</span><textarea class="obligatorio ancho_420" cols="60" rows="2" name="destinatario" id="c_destinatario"><?=$_SESSION['ses_destino'];?></textarea></label><em class="ayuda">Separar mediante comas en el caso de añadir varios destinatarios.</em></p>
		<p><label for="c_asunto"><span>Asunto:*</span><input class="obligatorio ancho_420" type="text" name="asunto" id="c_asunto" value="<?=$_SESSION['ses_asunto'];?>" /></label></p>
		<p><label for="c_html"><span>Mensaje:*</span><textarea class="obligatorio ancho_420" cols="60" rows="12" name="html" id="c_html"></textarea></label><em class="ayuda">Pegar solo el contenido bajo la etiqueta <code>BODY</code>.</em></p>
	</fieldset>
	<p class="botonera"><input type="submit" value="Enviar" /></p>
</form>

</div>
</body>
</html>