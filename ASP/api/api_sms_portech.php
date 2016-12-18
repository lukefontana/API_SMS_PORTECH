<?php


function mySql_inserto($host,$db,$user,$pass,$tabla,$insData)
{
    //Conecto a la db
    $link = mysqli_connect($host,$user,$pass) or die(mysql_error());
    //Desarmo el array, capturando las cabeceras
    $columns = implode(", ",array_keys($insData));
    //limpio los valores
    //Esta funcion permite que pueda utilizar el saneamiento de mysqli, pasando el array de valores
    $escaped_values = array_map(
        function($value)
        use ($link)
        {
            return mysqli_real_escape_string($link, $value);
        },
        array_values($insData));
    $values  = implode("', '", $escaped_values);
    //inserto valores en la tabla
    $sql = "INSERT INTO $tabla($columns) VALUES ('$values')";
//    echo $sql;




    if($link === false)
    {
        die("ERROR: No pude conectarme a la base de datos. " . mysqli_connect_error());
    }
    mysqli_select_db($link,$db) or die(mysql_error());

    if(mysqli_query($link, $sql))
    {
//        echo "Insercion realizada";
    }
    else
    {
        echo "ERROR: No se pudo realizar la insercion. Error: " . mysqli_error($link);
    }


    $ultimo_id = mysqli_insert_id($link);

//    echo $ultimo_id;

    mysqli_close($link);

    return $ultimo_id ;
}





function EnviarSMS ($telefono,$texto,$nombre_campaña,$puerto_gsm,$modulo)
{
/* Permite ejecutar el script sin limite de tiempo. */
set_time_limit(0);

/* Modo debug*/
/*
Si esta en "on", imprimira en pantalla los comandos enviados a la central.
*/
$debug = 'on';

/* Modificaciones necesarias para adaptarse a requerimientos de la central*/
$telefono = '"'.$telefono.'"';
$modulo = 'module'.$modulo;


//Conexion a terminal GSM
//Aca se cargan los parametros de acceso
$host   = '172.27.0.38';  
$username = 'voip';  
$password = '1234';  
$fp    = fsockopen("$host", $puerto_gsm, $errno, $errstr, 30); 
		if (!$fp) {  
		 $error = "$errstr ($errno)<br />\n";  
		 return $error;
		 die;  
		}  

sleep(2);  

/*
Aca comienza el envio de los distintos parametros que recibe la central.
Mediante comandos via telnet podemos usar las capacidades de envio de SMS.
*/
$cmd = "$username\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000); 
if ($debug == 'on') {echo fread($fp, 8192)."<br>";}
 
$cmd = "$password\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000) ;
if ($debug == 'on') {echo fread($fp, 8192)."<br>"; } 
 
$cmd = "$modulo\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000) ;
if ($debug == 'on') {echo fread($fp, 8192)."<br>";  }

$cmd = "ate1\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000);
if ($debug == 'on') {echo fread($fp, 8192)."<br>";  }

$cmd = "at+cmgf=1\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000) ;
if ($debug == 'on') {echo fread($fp, 8192)."<br>";  }

if ($debug == 'on') {echo 'SMS TEXTO:' . $texto."<br>";
echo "------ comienzo carga del telefono ------"."<br>";}
$cmd = "at+cmgs=" . $telefono ."\r";  
fputs($fp, $cmd, strlen($cmd));  
usleep(250000) ;
if ($debug == 'on') {echo fread($fp,8192)."<br>";  
echo " ------ fin carga del telefono ------"."<br>";}

if ($debug == 'on') {echo "------ comienzo carga del mensaje ------"."<br>";}
$cmd =  "$texto";
fputs($fp, $cmd); 
usleep(250000);
if ($debug == 'on') {echo fread($fp,8192)."<br>";   
echo "------ fin carga del mensaje ------"."<br>";}
 
if ($debug == 'on') { echo "------ comienzo send ------"."<br>";}
$cmd =  "\x1a \r";
fputs($fp, $cmd); 
usleep(250000);
if ($debug == 'on') {echo fread($fp,8192)."<br>";   
echo "------ fin send ------"."<br>";}


$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    echo "Process Time: {$time}";

fclose($fp); //Cierro conexion

}















?>