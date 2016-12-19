<?php  
error_reporting(E_ALL);

include 'api/api_sms_portech.php';

EnviarSMS('1131241300','Testing metodos 1a','2954','1301','1');
EnviarSMS('1131241321','Testing metodos 1b','2954','1301','2');
EnviarSMS('1131212544','Testing metodos 2a','2954','1302','1');
EnviarSMS('1131244455','Testing metodos 2b','2954','1302','2');
EnviarSMS('1131245554','Testing metodos 2b','2954','1302','2');


//Parametros de la funcion EnviarSMS:
/*
1) Celular destino
2) Mensaje a enviar
3) Nombre de la campaña (Identificador)
4) Puerto de la central que usaremos
5) GSM Slot del puerto (1 y 2)
*/

?>  