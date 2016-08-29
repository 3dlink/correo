<?php 

require_once ('../../Vendor/nusoap.php');
//require_once ('../../Vendor/database.php');
// Create server object
$server = new soap_server();

$endpoint = 'http://correspondenciaestatal.gob.pa/correspondencia/services/getServices?wsdl';

//initialize WSDL support
$server->configureWSDL('Correspondencia', 'urn:Correspondencia', $endpoint);

// Register the method to expose
$server->register('RecuperaDocumento',          // method
		array('file' => 'xsd:string'),          // input parameters
		array('return' => 'xsd:string'),        // output parameters
		'urn:getServices',                      // namespace
		'urn:getServices#RecuperarDocumento',   // soapaction
		'rpc',                                  // style
		'encoded',                              // use
		'Download the file content from the server'
);

// Register the method to expose
$server->register('EnviaDocumento',                               // method
		array('file' => 'xsd:string','content' => 'xsd:string' , 'hash' => 'xsd:string'),  // input parameters
		array('return' => 'xsd:string'),                          // output parameters
		'urn:getServices',                                        // namespace
		'urn:getServices#EnviaDocumento',                         // soapaction
		'rpc',                                                    // style
		'encoded',                                                // use
		'Update file content to the server'
);


/**
 * Se obtiene el documento segun el ID suministrado
 * @param string $idDocumento
 */
function RecuperaDocumento($idDocumento = NULL) {
	
	require_once ('../../Vendor/database.php');
	$contents = 'File not found!';
	$file = "../files/".urldecode($idDocumento);

	if(file_exists($file)){
		
		$date = date('Y-m-d H:i:s');
		$method = 'RecuperaDocumento'; 
		$message = "$date - $method: Enviando el archivo '$idDocumento'";
		error_log("$message\n", 3, "../../tmp/logs/info_services.log");
		
		//$this->log("$date -- Enviando documento ($file)", LOG_INFO);
		
		$handle = fopen($file, "rb");
		$contents = (base64_encode(fread($handle, filesize($file))));
		fclose($handle);

		$date = date('Y-m-d H:i:s');
		$method = 'RecuperaDocumento';
		$message = "$date - $method: Archivo enviado con exito.";
		error_log("$message\n", 3, "../../tmp/logs/info_services.log");
		$nombre=explode("/",$file);
		mysqli_query($conexion,"UPDATE acknowledgments SET status = 'enviado' where document = '".$idDocumento."'");
		
	}

	return $contents;

}


/**
 * Se reemplaza el contenido del documento con el ID suministrado.
 * @param string $idDocumento
 * @param string $contentDocumento
 */
function EnviaDocumento($idDocumento = NULL, $contentDocumento = NULL , $hash = NULL){
	
	require_once ('../../Vendor/database.php');
	$file = "../files/".urldecode($idDocumento);
	$date = date('Y-m-d H:i:s');
	$method = 'EnviaDocumento';
	$message = "$date - $method: Recibiendo archivo firmado '$idDocumento'...";
	error_log("$message\n", 3, "../../tmp/logs/info_services.log");
	
	if(file_exists($file)){

		
		$current = base64_decode($contentDocumento);            // Now decode the content which was sent by the client
		file_put_contents($file, $current); 					// Write the decoded content in the file mentioned at particular location

		$date = date('Y-m-d H:i:s');
		$method = 'EnviaDocumento';
		$message = "$date - $method: Se recibio el contenido del archivo y fue reemplazado.";
		error_log("$message\n", 3, "../../tmp/logs/info_services.log");
		
		$ext = explode(".", $file);
		$ext = end($ext);
		if($ext != "pdf"){
			mysqli_query($conexion,"UPDATE uploads SET hashnopdf = '".$hash."' where name = '".$idDocumento."'");
		}
		
		mysqli_query($conexion,"UPDATE acknowledgments SET status = 'recibido' where document = '".$idDocumento."'");
		
		return "OK";                 						    // Output success message
	}
	else
	{
		$date = date('Y-m-d H:i:s');
		$method = 'EnviaDocumento';
		$message = "$date - $method: ERROR: Error procesando el requerimiento";
		error_log("$message\n", 3, "../../tmp/logs/info_services.log");
		
		return "ERROR";
	}

}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>