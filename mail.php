<?php
session_start();

if (get_magic_quotes_gpc()) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
					unset($process[$key][$k]);
					if (is_array($v)) {
							$process[$key][stripslashes($k)] = $v;
							$process[] = &$process[$key][stripslashes($k)];
					} else {
							$process[$key][stripslashes($k)] = stripslashes($v);
					}
			}
	}
	unset($process);
}

require('_inc/phpMailer_v2.3/class.phpmailer.php');
//require('_inc/phpMailer_5.2.0/class.phpmailer.php');

$seguro = '';$sesionSeguro = 0;
if ($_POST['seguridad']==1) {$seguro = 'ssl://';$sesionSeguro = 1;}

$mailer = new PHPMailer();
//$mailer->IsSMTP();
$mailer->IsSendmail();
//$mailer->Host = $seguro.$_POST['servidor'].':'.$_POST['puerto']; // Datos de servidor SMTP
//$mailer->Host = $_POST['servidor']; // Datos de servidor SMTP
//$mailer->Port = $_POST['puerto'];
if ($_POST['seguridad']==1) {$mailer->SMTPSecure = "tls";}
//$mailer->Host = 'smtp.adesis.com:587'; // Datos de servidor SMTP
//$mailer->SMTPAuth = TRUE;

//$mailer->Username = $_POST['usuario']; // Usuario smtp
//$mailer->Password = $_POST['clave']; // Clave smtp
$mailer->From = $_POST['desde']; // Correo del usuario
$mailer->FromName = $_POST['de']; // Nombre del usuario

$mailer->MsgHTML($_POST['html']); // HTML del mensaje
$mail->AltBody  = 'MENSAJE EN TEXTO PLANO (ALTERNATIVA A HTML) --- '.strip_tags($_POST['html']); // Este es el contenido alternativo sin html
$mailer->Subject = $_POST['asunto']; // Asunto del mensaje

// Se añaden los destinatarios separados por comas
$destinos = explode(',',$_POST['destinatario']);
$i=0;
while ($i<count($destinos)) {
	$mailer->AddAddress($destinos[$i]); 
	$i++;
}

// Se establecen las sesiones
$_SESSION['ses_usuario'] = $_POST['usuario'];
$_SESSION['ses_clave'] = $_POST['clave'];
$_SESSION['ses_asunto'] = $_POST['asunto'];
$_SESSION['ses_destino'] = $_POST['destinatario'];
$_SESSION['ses_desde'] = $_POST['desde'];
$_SESSION['ses_de'] = $_POST['de'];
$_SESSION['ses_servidor'] = $_POST['servidor'];
$_SESSION['ses_puerto'] = $_POST['puerto'];
$_SESSION['ses_seguridad'] = $sesionSeguro;

//echo $_POST['html'];

// Y se redirige según haya habido éxito o fracaso
if(!$mailer->Send()) {header("Location: index.php?msg=no&error=".$mailer->ErrorInfo."");}
else {header("Location: index.php?msg=si");}

// mas info
# http://www.wanderingbit.com/2008/07/28/envio-de-mails-desde-php-con-smtp-autenticacion-ssl-y-otros/
?>