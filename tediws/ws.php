<?php

include 'classes/Connect.php';
include 'classes/Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas en SaludPrimero
 * @author Camilo Garzon Calle
 * @version 1.0
 * @copyright QSystems
 */
class WS {

    private $conexion, $op, $idhash;
    private $UTILITY;
    private $DATE_NOW = 'DATE_ADD(NOW(),INTERVAL 2 HOUR)';

    function __construct() {
        $conexion = new Connect();
        $this->UTILITY = new Util();
        $this->conexion = $conexion->openConnect();
        $rqst = $_REQUEST;
        $this->op = $rqst['op'];
        header("Content-type: application/javascript; charset=utf-8");
        header("Cache-Control: max-age=15, must-revalidate");
        // con esto se evade la restriccion: Same origin policy
        //header('Access-Control-Allow-Origin: http://localhost');
        //para la app de phonegap, se habilita cualquier dominio
        header('Access-Control-Allow-Origin: *');

        if ($this->op == 'login') {
            $this->email = $rqst['email'];
            $this->pass = $rqst['pass'];
            $this->login();
        } else if ($this->op == 'save_user') {
            $this->nombre = $rqst['nombre'];
            $this->pass = $rqst['pass'];
            $this->email = $rqst['email'];
            $this->edad = $rqst['edad'];
            $this->sexo = $rqst['sexo'];
            $this->nickname = $rqst['nickname'];
            $this->pais_residencia = $rqst['pais_residencia'];
            $this->estatura = $rqst['estatura'];
            $this->save_user();
        } else {
            $this->invalid_method_called();
        }
    }

    public function redondear_dos_decimal($valor) {
        $float_redondeado = round($valor * 100) / 100;
        return $float_redondeado;
    }

    public function redondeado($numero, $decimales) {
        $factor = pow(10, $decimales);
        return (round($numero * $factor) / $factor);
    }

    //////////////////////////////////////////////////////////////////////////////////
    //// OPERACIONES DEL WEBSERVICE DE TEDI  /////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    /**
     * Mensaje de error cuando se llama una metodo no valido
     */
    private function invalid_method_called() {
        $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '1001', 'content' => 'Invalid method called.')));
        echo json_encode($arrjson);
    }

    /**
     * Metodo para encriptar password
     */
    public function make_hash_pass($param1, $param2) {
        if (strlen($param1) > 3 && strlen($param2) > 3){
            $r = sha1($param1 . $param2 . 'asdf');
        } else {
            $r = sha1($param1 . '0000' . 'asdf');
        }
        return $r;
    }

    /**
     * Metodo para loguearse
     * http://www.qsystems.com.co/tediws/ws.php?op=login&email=camilo@camilo.com&pass=camilo1
     */
    public function login() {
        $resultado = 0;
        if ($this->email == "" || $this->pass == "") {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $pass = $this->make_hash_pass($this->email, $this->pass);
            $q = "SELECT * FROM tedi_usuario WHERE email = '$this->email' and pass = '$pass' ";
            $con = mysql_query($q, $this->conexion) or die(mysql_error()."***ERROR: ".$q);
            $resultado = mysql_num_rows($con);
            while ($obj = mysql_fetch_object($con)) {
                $arrjson = array('output' => array(
                        'valid' => true,
                        'id' => $obj->idUSUARIO,
                        'nombre' => ($obj->nombre),
                        'pass' => $obj->pass,
                        'nickname' => $obj->nickname,
                        'email' => $obj->email,
                        'sexo' => $obj->sexo,
                        'edad' => $obj->edad,
                        'pais_residencia' => ($obj->pais_residencia),
                        'estatura' => $obj->estatura));
            }
            if ($resultado == 0) {
                $arrjson = array('output' => array('valid' => false, 'error' => "error en usuario o contraseña."));
            }
        }
        echo json_encode($arrjson);
    }
    
    /**
     * Metodo para guardar y actualizar usuarios
     * http://www.qsystems.com.co/tediws/ws.php?op=save_user&nombre=camilo&pass=camilo1&email=camilo@camilo.com&sexo=masculino&edad=27&nickname=caminick&pais_residencia=Colombia&estatura=180
     */
    public function save_user() {
        //PRIMERO SE VERIFICA SI EL USUARIO QUE SE LOGUEA YA EXISTE.
        $resultado = 0;
        $id = 0;
        if (strlen($this->email) > 3) {
            $q = "SELECT idUSUARIO FROM tedi_usuario WHERE email = '" . $this->email . "' ";
            $con = mysql_query($q, $this->conexion) or die(mysql_error()."***ERROR: ".$q);
            $resultado = mysql_num_rows($con);
            while ($obj = mysql_fetch_object($con)) {
                $id = $obj->idUSUARIO;
            }
            $pass = $this->make_hash_pass($this->email, $this->pass);
            $table = "tedi_usuario";
            $arrfieldscomma = array('nombre' => $this->nombre,
                        'pass' => $pass,
                        'nickname' => $this->nickname,
                        'email' => $this->email,
                        'sexo' => $this->sexo,
                        'pais_residencia' => $this->pais_residencia);
            
            $arrfieldsnocomma = array('edad' => $this->edad, 
                        'estatura' => $this->estatura);
            $q = $this->UTILITY->make_query_update($table, "idUSUARIO = '$id'", $arrfieldscomma, $arrfieldsnocomma);
            mysql_query($q, $this->conexion) or die(mysql_error()."***ERROR: ".$q);
        } else {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        }
        //SI NO EXISTE UN USUARIO, ENTONCES SE CREA
        if ($id == 0) {
            $pass = $this->make_hash_pass($this->email, $this->pass);
            $q = "INSERT INTO tedi_usuario (nombre, pass, nickname, email, sexo, edad, pais_residencia, estatura) VALUES ('$this->nombre', '$pass', '$this->nickname', '$this->email', '$this->sexo', $this->edad, '$this->pais', $this->estatura)";
            mysql_query($q, $this->conexion) or die(mysql_error()."***ERROR: ".$q);
            $id = mysql_insert_id();
        } else {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '3002', 'content' => 'Account already exists.')));
        }
        $arrjson = array('output' => array('valid' => true, 'id' => $id));
        echo json_encode($arrjson);
    }
    
    //////////////////////////////////////////////////////////////////////////////////
    //// OPERACIONES DEL EJEMPLO DE SALUDPRIMERO  ////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////

    //http://www.qsystems.com.co/saludpws/ws.php?op=get_location
    public function get_location() {
        $q = "SELECT * FROM qas_ubicacion";
        $con = mysql_query($q, $this->conexion);
        $resultado = mysql_num_rows($con);
        $arr = array();
        while ($obj = mysql_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->ubi_id,
                'latitud' => $obj->ubi_latitud,
                'longitud' => $obj->ubi_longitud,
                'formatted_address' => utf8_encode($obj->ubi_formatted_address)
            );
        }
        $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        echo json_encode($arrjson);
    }

    //http://www.qsystems.com.co/saludpws/ws.php?op=get_location_details&id_ubicacion=1
    public function get_location_details() {
        $q = "SELECT * FROM qas_ubicacion WHERE ubi_id = " . $this->id_ubicacion;
        $con = mysql_query($q, $this->conexion);
        $resultado = mysql_num_rows($con);
        $arrCalifica = array();
        $arrOpina = array();
        $arrAlerta = array();
        while ($obj = mysql_fetch_object($con)) {
            $q2 = "SELECT * FROM qas_calificacion WHERE ubi_id_qas_ubicacion = " . $this->id_ubicacion;
            $con2 = mysql_query($q2, $this->conexion);
            $satisfaccion = 0;
            $confianza = 0;
            $recomienda = 0;

            while ($obj2 = mysql_fetch_object($con2)) {
                $satisfaccion += $obj2->cal_satisfaccion;
                $confianza += $obj2->cal_confianza;
                if ($obj2->cal_recomienda == "si") {
                    $recomienda++;
                }
                $arrCalifica[] = array(
                    'id' => $obj2->cal_id,
                    'id_usuario' => $obj2->usr_id_qas_usuario,
                    'satisfaccion' => $obj2->cal_satisfaccion,
                    'confianza' => $obj2->cal_confianza,
                    'recomienda' => $obj2->cal_recomienda,
                    'fecha' => $obj3->cal_tscreado
                );
            }
            $totalCalifica = count($arrCalifica);
            if ($totalCalifica > 0) {
                $satisfaccion = $satisfaccion / $totalCalifica;
                $satisfaccion = $this->redondeado($satisfaccion, 1);
                $confianza = $confianza / $totalCalifica;
                $confianza = $this->redondeado($confianza, 1);
                $recomienda = ($recomienda * 100) / $totalCalifica;
                $recomienda = $this->redondeado($recomienda, 1);
            }

            $q3 = "SELECT * FROM qas_opinion WHERE ubi_id_qas_ubicacion = " . $this->id_ubicacion . " order by opn_tscreado DESC";
            $con3 = mysql_query($q3, $this->conexion);
            while ($obj3 = mysql_fetch_object($con3)) {
                $q31 = "SELECT * FROM qas_usuario WHERE usr_id = '" . $obj3->usr_id_qas_usuario . "'";
                $con31 = mysql_query($q31, $this->conexion);
                while ($obj31 = mysql_fetch_object($con31)) {
                    $usr_nombres = utf8_encode($obj31->usr_nombres);
                    $usr_apellidos = utf8_encode($obj31->usr_apellidos);
                }

                $arrOpina[] = array(
                    'id' => $obj3->opn_id,
                    'usuario_nombre' => $usr_nombres,
                    'usuario_apellido' => $usr_apellidos,
                    'opinion' => utf8_encode($obj3->opn_opinion),
                    'fecha' => $obj3->opn_tscreado
                );
            }
            $q4 = "SELECT * FROM qas_opinion WHERE ubi_id_qas_ubicacion = " . $this->id_ubicacion;
            $con4 = mysql_query($q4, $this->conexion);
            while ($obj4 = mysql_fetch_object($con4)) {
                $arrAlerta[] = array(
                    'id' => $obj4->alr_id,
                    'id_usuario' => $obj4->usr_id_qas_usuario,
                    'alerta' => utf8_encode($obj4->alr_alerta),
                    'descripcion' => utf8_encode($obj4->alr_descripcion),
                    'fecha' => $obj4->alr_tscreado
                );
            }
            $response = array(
                'id' => $obj->ubi_id,
                'latitud' => $obj->ubi_latitud,
                'longitud' => $obj->ubi_longitud,
                'formatted_address' => utf8_encode($obj->ubi_formatted_address),
                'prom_satisfaccion' => $satisfaccion,
                'prom_confianza' => $confianza,
                'porcent_si_recomienda' => $recomienda,
                'calificaciones' => $arrCalifica,
                'opiniones' => $arrOpina,
                'alertas' => $arrAlerta
            );
        }
        $arrjson = array('output' => array('valid' => true, 'response' => $response));
        echo json_encode($arrjson);
    }

    public function get_user() {
        $q = "SELECT * FROM qas_usuario order by usr_nombres";
        $con = mysql_query($q, $this->conexion);
        $resultado = mysql_num_rows($con);
        $arr = array();
        while ($obj = mysql_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->usr_id,
                'idfacebook' => $obj->usr_idfacebook,
                'idtwitter' => $obj->usr_idtwitter,
                'redsocial' => $obj->usr_redsocial,
                'nombres' => utf8_encode($obj->usr_nombres),
                'apellidos' => utf8_encode($obj->usr_apellidos),
                'email' => utf8_encode($obj->usr_email),
                'nickname' => utf8_encode($obj->usr_nickname),
                'pais' => utf8_encode($obj->usr_pais),
                'depto' => utf8_encode($obj->usr_depto),
                'ciudad' => utf8_encode($obj->usr_ciudad),
                'telefono' => $obj->usr_telefono,
                'genero' => $obj->usr_genero,
                'tscreado' => $obj->usr_tscreado,
                'fechanacimiento' => $obj->usr_birthday
            );
        }
        $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        echo json_encode($arrjson);
    }

    public function get_user_details() {
        $q = "SELECT * FROM qas_usuario WHERE usr_id = '" . $this->id_usuario . "'";
        $con = mysql_query($q, $this->conexion);
        $resultado = mysql_num_rows($con);
        $arr = array();
        while ($obj = mysql_fetch_object($con)) {
            $arr[] = array(
                'id' => $obj->usr_id,
                'idfacebook' => $obj->usr_idfacebook,
                'idtwitter' => $obj->usr_idtwitter,
                'redsocial' => $obj->usr_redsocial,
                'nombres' => utf8_encode($obj->usr_nombres),
                'apellidos' => utf8_encode($obj->usr_apellidos),
                'email' => utf8_encode($obj->usr_email),
                'nickname' => utf8_encode($obj->usr_nickname),
                'pais' => utf8_encode($obj->usr_pais),
                'depto' => utf8_encode($obj->usr_depto),
                'ciudad' => utf8_encode($obj->usr_ciudad),
                'telefono' => $obj->usr_telefono,
                'genero' => $obj->usr_genero,
                'tscreado' => $obj->usr_tscreado,
                'fechanacimiento' => $obj->usr_birthday
            );
        }
        $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        echo json_encode($arrjson);
    }

}

new WS();
?>