<?php
/**
 * Clase que contiene varios métodos útiles
 * @author Camilo Garzon Calle
 * @version 1.0
 */

class Util{
	/**
	    * Valor de un KB = 1024 bytes
	    * @var int 
	    */
	public $KB_BYTE = 1024;
	/**
	    * Valor de un MB = 1024 KB
	    * @var int 
	    */
	public $MB_BYTE = 1048576;
	/**
	 * Url de la raiz de la aplicación
	 * @var string 
	 */
	public $URL_ROOT_HOST = "http://127.0.0.1/web/";
	/**
	 * Url de la ubicacion del web service
	 * @var string 
	 */
	public $URL_WS = "http://127.0.0.1/web/ws.php";
	
	public function __construct() {
	    //contructor que no tiene ninguna funcion, por ahora
	}

	/**
	 * Método para capturar la Ip del cliente
	 * @return string Ip del cliente
	 */
	public static function get_real_ipaddress() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP']; //check ip from share internet
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR']; //to check ip is pass from proxy
		} else {
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	/**
	 * Método para hacer POST desde PHP
	 * @param string $url
	 * @param array $data
	 * @param string $referer
	 * @return array ['status', 'header', 'content']
	 */
	public static function post_request($url, $data, $referer='') {
		// Convert the data array into URL Parameters like a=b&foo=bar etc.
		$data = http_build_query($data);
		// parse the given URL
		$url = parse_url($url);
		if ($url['scheme'] != 'http') { 
			die('Error: Only HTTP request are supported !');
		}
		// extract host and path:
		$host = $url['host'];
		$path = $url['path'];
//		echo '<br/>';
//		echo '<br/>'.$host;
//		echo '<br/>'.$path;
//		echo '<br/>';
		if( function_exists( 'fsockopen' ) )
		{
		//echo 'open a socket connection on port 80 - timeout: 30 sec';
		$fp = fsockopen($host, 80, $errno, $errstr, 30);
		if ($fp){
			// send the request headers:
			fputs($fp, "POST $path HTTP/1.1\r\n");
			fputs($fp, "Host: $host\r\n");

			if ($referer != '') { fputs($fp, "Referer: $referer\r\n");}

			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ". strlen($data) ."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $data);

			$result = ''; 
			while(!feof($fp)) {
				// receive the results of the request
				$result .= fgets($fp, 128);
			}
		} else {
			return array(
				'status' => 'err', 
				'error' => '$errstr ($errno)'
			);
		}
		}else {echo "No fsockopen, please config php.ini <br />\n" ;}

		// close the socket connection:
		fclose($fp);

		// split the result header from the content
		$result = explode("\r\n\r\n", $result, 2);

		$header = isset($result[0]) ? $result[0] : '';
		$content = isset($result[1]) ? $result[1] : '';

		// return as structured array:
		return array(
			'status' => 'ok',
			'header' => $header,
			'content' => $content
		);
	}
	
	/**
	 * Mètodo para eliminar caracteres especiales que puedan modificar las consultas SQL.
	 * Una función para evitar SQL Injection.
	 * @param string $str
	 * @return string Cadena de carateres segura
	 */
	public static function remove_special_char($str) {
		if ($str == null || strlen($str) < 1) { return $str;}
		$realstr = str_replace("'","",$str);
		$realstr = str_replace("&","",$realstr);
		//$realstr = str_replace("\n","",$realstr);
		//$realstr = str_replace("\r","",$realstr);
		$realstr = str_replace("<","",$realstr);
		$realstr = str_replace(">","",$realstr);
		$realstr = str_replace("\"","",$realstr);
		// ESTOS SE INHABILITAN PARA PODER ALMACENAR DIRECCIONES EN LA BASE DE DATOS
		// $realstr = str_replace("/","",$realstr);
		// $realstr = str_replace("/\/","",$realstr);
		//$realstr = str_replace("|","",$realstr);
		return $realstr;
	}
	
	public static function remove_weird_char($str) {
		if ($str == null || strlen($str) < 1) { return $str;}
		$realstr = str_replace("Ã¡","a",$str);
		$realstr = str_replace("Ã©","e",$realstr);
		$realstr = str_replace("Ã­","i",$realstr);
		$realstr = str_replace("Ã³","o",$realstr);
		$realstr = str_replace("Ãº","u",$realstr);
		return $realstr;
	}
	
	public static function convert_special_char($str) {
		if ($str == null || strlen($str) < 1) { return $str;}
		$realstr = htmlspecialchars($str, ENT_QUOTES);
		return $realstr;
	}

	public static function convert_pathtourl($str) {
		if ($str == null || strlen($str) < 1) { return $str;}
		$realstr = str_replace(DIRECTORY_SEPARATOR, "/",$str);
		return $realstr;
	}

	public static function remove_repeatslash($str) {
		if ($str == null || strlen($str) < 1) { return $str;}
		$realstr = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR,$str);
		for ($i = 0; $i < 2; $i++) {
		    $realstr = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR,$realstr);
		}
		return $realstr;
	}

	/**
	 * Metodo para generar el hash de un password en una serie de encriptaciones del Blast24
	 * @param string $type
	 * @param string $data1
	 * @param string $data2
	 * @return string hash del password
	 */
	public static function create_passhash($type="", $data1="", $data2="") {
	    if ($type == 'send') {
		$hash = sha1($data1.$data2);
//		echo '<br/>send '.$data1.' - '.$data2;
	    } else if ($type == 'receive') {
		$hash = strtoupper(sha1($data1."unabobada"));
//		echo '<br/>receive '.$data1;
	    } else if ($type == 'store') {
		$hash = strtoupper(sha1(sha1($data1.$data2)."unabobada"));
		//echo '<br/>store '.$data1.' - '.$data2;
	    }
	    return $hash;
	}
	
	/**
	 * Metodo para escribir sobre archivos.
	 * @param string $data El dato a escribir en el archivo.
	 * @param string $pathFile La ubicacion fisica del archivo.
	 * @param int $isNew 0 es para escribir sobre un archivo existente. 1 para crear uno nuevo.
	 */
	public static function make_file($data, $pathFile, $isNew=0){
	    $filesize = 0;
	    if (file_exists ($pathFile)) {
		if ($isNew) { unlink($pathFile); }
		$filesize = filesize($pathFile);//bytes
	    }
	    //$maxSize = 1 * 1024;//KB
	    $maxSize = 1 * 1048576;//MB
	    if ($filesize > $maxSize) { rename($pathFile, $pathFile.date("YmdHis")); }
	    $fh = fopen($pathFile, 'a+') or die("Can't use file.<BR/>Need to apply read-write permissions.<BR/>$ sudo chmod 777 /var/www/s24/blast24/web/log/debug_file.txt or ".$pathFile);
	    $arrStr = explode(";", $data);
	    foreach ($arrStr as $str) {
		$str = date("Y-m-d H:i:s")." # ".$str."\n";
		fwrite($fh, $str);
	    }
	    fclose($fh);
	}
	
	/**
	 * Metodo para escribir sobre archivos.
	 * @param string $str El dato a escribir en el archivo.
	 * @param int $isNew 0 es para escribir sobre un archivo existente. 1 para crear uno nuevo.
	 * @param string $pathFile La ubicacion fisica del archivo.
	 */
	public static function make_debug_file($str, $file, $line, $isNew=0, $pathFile="log/debug_file.txt"){
	    $filesize = 0;
	    if (file_exists ($pathFile)) {
		if ($isNew) { unlink($pathFile); }
		$filesize = filesize($pathFile);//bytes
	    }
	    //$maxSize = 1 * 1024;//KB
	    $maxSize = 1 * 1048576;//MB
	    if ($filesize > $maxSize) { rename($pathFile, $pathFile.date("YmdHis")); }
	    $fh = fopen($pathFile, 'a+') or die("Can't use file.<BR/>Need to apply read-write permissions.<BR/>$ sudo chmod 777 /var/www/s24/blast24/web/log/debug_file.txt or ".$pathFile);
//	    $str = date("Y-m-d H:i:s")." # ".__FILE__." Linea: ".__LINE__."\n".$str."\n";
	    //$str = date("H:i:s.m")." # ".__FILE__." Linea: ".__LINE__."\n--->".$str."\n\n";
	    $str = date("H:i:s.m")." # Linea: ".$line." # ".$file."\n--->".$str."\n\n";
	    fwrite($fh, $str);fclose($fh);
	    
	}
	
	/**
	 * Metodo para construir un SELECT.
	 * @param string $tables nombres de la tabla a consultar. si son varias se separa por comma
	 * @param string $where condiciones de la consulta. lo que se escribe despues de WHERE, no es obligatorio
	 * @param string $fields campos especificos de la tabla, no es obligatorio
	 * @return string consulta construida
		<code>
			include 'classes/Util.php';
			$tables = "mi_tabla, tabla_dos";
			$where = "(id = 0) and (tipo='cadena')";
			$fields = "usr_nombre, usr_apellido";
			echo Util::make_query_select($tables,$where,$fields);
		</code>
	 *  tipo STRING
	 */
	public static function make_query_select($tables, $where = "", $fields = ""){
		$query = "SELECT * FROM "; if ($tables == null || strlen($tables) < 1) { return "***Falta nombre de la tabla***";} $f = (strlen($fields) > 2) ? $fields : "*"; $query = "SELECT ".$f." FROM ".$tables." "; if (strlen($where) > 2) { $query .= " WHERE ".$where." ";} return $query;
	}
	
	/**
	 * Metodo para construir un INSERT.
	 * @param string $table nombre de la tabla a escribir
	 * @param array $arrfieldscomma campos y valores tipo STRING, que requieren comma
	 * @param array $arrfieldsnocomma campos y valores que no requieren comma
	 * @return string consulta construida
		<code>
			include 'classes/Util.php';
			$table = "mi_tabla";
			$arrfieldscomma = array('campo1' => 'valor1', 'campo2' => 'valor2', 'campo3' => 'valor3');
			$arrfieldsnocomma = array('campoA' => 'NOW()', 'campoB' => '2', 'campoC' => 'GET');
			echo Util::make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		</code>
	 * 
	 */
	public static function make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma){
		$query = "INSERT INTO ";
		if ($table == null || strlen($table) < 1) { return "***Falta nombre de la tabla***";}
		$query .= $table;
		$fields = " ("; $values = " VALUES (";
		foreach ($arrfieldscomma as $f => $v) {
			$fields .= " ".$f.","; $values .= " '".$v."',";
		}
		foreach ($arrfieldsnocomma as $f2 => $v2) {
			$fields .= " ".$f2.","; $values .= " ".$v2.",";
		}
		$fields = rtrim($fields, ","); $values = rtrim($values, ",");
		$fields .= ") "; $values .= ") ";
		$query .= $fields.$values;
		return $query;
	}
	
	/**
	 * Metodo para construir un UPDATE.
	 * @param string $table nombre de la tabla a escribir
	 * @param string $where condicion para actualizar
	 * @param array $arrfieldscomma campos y valores tipo STRING, que requieren comma
	 * @param array $arrfieldsnocomma campos y valores que no requieren comma
	 * @return string consulta construida
		<code>
			include 'classes/Util.php';
			$table = "mi_tabla";
			$where = "(id = 0) and (tipo='cadena')";
			$arrfieldscomma = array('campo1' => 'valor1', 'campo2' => 'valor2', 'campo3' => 'valor3');
			$arrfieldsnocomma = array('campoA' => 'NOW()', 'campoB' => '2', 'campoC' => 'GET');
			echo Util::make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		</code>
	 * 
	 */
	public static function make_query_update($table, $where, $arrfieldscomma, $arrfieldsnocomma){
		$query = "UPDATE ";
		if ($table == null || strlen($table) < 1) { return "***Falta nombre de la tabla***";}
		if ($where == null || strlen($where) < 1) { return "***Falta WHERE id=?? del registro***";}
		$query .= $table." SET ";
		$fields = ""; 
		foreach ($arrfieldscomma as $f => $v) {
			$fields .= " ".$f." = '".$v."',";
		}
		foreach ($arrfieldsnocomma as $f2 => $v2) {
			$fields .= " ".$f2." = ".$v2.",";
		}
		$fields = rtrim($fields, ",");
		$query .= $fields." WHERE ".$where;
		return $query;
	}
	
	 	 
	/**
	 * Metodo para construir un DELTE.
	 * @param string $table nombres de la tabla a consultar
	 * @param string $where condiciones de la consulta. lo que se escribe despues de WHERE, es obligatorio. "all" para borrar todos los registros
	 * @return string consulta construida
		<code>
			include 'classes/Util.php';
			$tables = "mi_tabla, tabla_dos";
			$where = "(id = 0) and (tipo='cadena')";
			echo Util::make_query_select($tables,$where,$fields);
		</code>
	 *  tipo STRING
	 */
	public static function make_query_delete($table, $where){
	    $query = "DELETE FROM ";
		if ($table == null || strlen($table) < 1) { return "***Falta nombre de la tabla***";}
		$query .= $table;
		if (strlen($where) > 2) {
			if ($where != "all") {
				$query .= " WHERE $where ";
			} else {
				return "***Falta WHERE no valido***";
			}
		}
		return $query;
	}
	
}

?>