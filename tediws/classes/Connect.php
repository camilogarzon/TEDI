<?php

/**
 * Clase que contiene la configuracion general para conexion a mysql
 * @author Camilo Garzon Calle
 * @version 1.0
 */
class Connect {

    private $sqlconnect;

    public function Connect() {
        
    }

    /**
     * Establece la conexion con la base de datos 
     */
    public function openConnect() {
        $this->sqlconnect = null;
        $url = "97.74.31.18";
        $user = "salud*primero";
        $passwd = "p4ss4l_R1M3*68";
        $db = "saludprimero";

        // Conexion y captura de errores	
        $this->sqlconnect = mysql_connect($url, $user, $passwd);
        if (!$this->sqlconnect) {
            echo "No fue posible conectarse al servidor MySQL $url <br/>\n";
            // throw new Exception("No fue posible conectarse a $url");
        }
        if (!mysql_select_db($db, $this->sqlconnect)) {
            echo "No se puede seleccionar la base de datos $db <br/>\n";
            // throw new Exception("No se puede seleccionar la base de datos $db");
        }
        return $this->sqlconnect;
        // En este punto la configuracion esta lista para comenzar a ejecutar comandos sql
    }

    /**
     * Cierra la conexion establecida con el metodo openConnect
     */
    public function closeConnect() {
        mysql_close($this->sqlconnect);
    }

}

?>
