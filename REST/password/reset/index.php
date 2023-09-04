<?php
require("Mail.php");
require("Mail/mime.php");

echo "Sending mail";
$to="micorreo@midominio.com";
$from = "info@hostalia.com";
$host = 'smtp.ejemplo.com';
$username = 'origen@ejemplo.com';
$password = 'P4ssw0rd';
$subject="Prueba envío de correos con adjuntos con PEAR::Mail";
$mensajeTexto="Aquí iría el texto del cuerpo del mensaje";
$adjunto = "fichero_adjunto.zip";
$headers=array();
$headers['From']=$from;
$headers['To']=$to;
$headers['Subject']=$subject;
$headers['Return-Path']="no-reply@midominio.com";
$message = new Mail_mime();
$message->setTXTBody($messageTEXT);
$message->addAttachment($adjunto, mime_content_type($adjunto));
$mimeparams=array();
$mimeparams['text_encoding']="7bit";
$mimeparams['text_charset']="UTF-8";
$body = $message->get($mimeparams);
$headers = $message->headers($headers);
$smtp = Mail::factory('smtp',
array ('host' => $host,
'auth' => true,
'username' => $username,
'password' => $password));
$mail=$smtp->send($to, $headers, $body);
