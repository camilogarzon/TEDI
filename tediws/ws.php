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
    public $id = "";

    function __construct() {
        $conexion = new Connect();
        $this->UTILITY = new Util();
        $this->conexion = $conexion->openConnect();
        $rqst = $_REQUEST;
        $this->op = $rqst['op'];
        $this->id = intval($rqst['id']);
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
            $this->objetivo_dieta = $rqst['objetivo_dieta'];
            $this->nivel_actividad = $rqst['nivel_actividad'];
            $this->save_user();
        } else if ($this->op == 'save_seguimiento') {
            $this->nivel_actividad = $rqst['nivel_actividad'];
            $this->calorias = $rqst['calorias'];
            $this->peso = $rqst['peso'];
            $this->save_seguimiento();
        } else if ($this->op == 'get_seguimiento') {
            $this->get_seguimiento();
        } else if ($this->op == 'get_tipo_menu') {
            $this->tipo_menu = $rqst['tipo_menu'];
            $this->get_menu_type();
        } else if ($this->op == 'get_elementos_menu') {
            $this->id_menu = $rqst['id_menu'];
            $this->get_menu_elements();
        } else if ($this->op == 'save_alimento_consumido') {
            $this->id_menu = $rqst['menu_id'];
            $this->id_dieta = $rqst['dieta_id'];
            $this->id_alimento = $rqst['alimento_id'];
            $this->numero_porciones = $rqst['porciones'];
            $this->save_alimento_consumido();
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
        if (strlen($param1) > 3 && strlen($param2) > 3) {
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
            $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
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
                        'peso_actual' => ($obj->peso_actual),
                        'nivel_actividad' => ($obj->nivel_actividad),
                        'estatura' => $obj->estatura));
            }
            if ($resultado == 0) {
                $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' error en usuario o contraseña.')));
            }
        }
        echo json_encode($arrjson);
    }

    /**
     * Metodo para guardar y actualizar usuarios
     * http://www.qsystems.com.co/tediws/ws.php?op=save_user&nombre=camilo&pass=camilo1&email=camilo@camilo.com&sexo=masculino&edad=27&nickname=caminick&pais_residencia=Colombia&estatura=180
     */
    public function save_user() {
        $id = 0;
        //consulta la existencia del usuario
        $q = "SELECT idUSUARIO FROM tedi_usuario WHERE email = '" . $this->email . "' ";
        $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
        $resultado = mysql_num_rows($con);
        if (($this->id) > 0) {
            //actualiza la informacion
            if (strlen($this->email) > 3) {
                $q = "SELECT idUSUARIO FROM tedi_usuario WHERE idUSUARIO = $this->id ";
                $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                while ($obj = mysql_fetch_object($con)) {
                    $id = $obj->idUSUARIO;
                    if (strlen($this->pass) > 0) {
                        $pass = $this->make_hash_pass($this->email, $this->pass);
                    } else {
                        $pass = '';
                    }
                    $table = "tedi_usuario";
                    $arrfieldscomma = array('nombre' => $this->nombre,
                        'pass' => $pass,
                        'nickname' => $this->nickname,
                        'email' => $this->email,
                        'sexo' => $this->sexo,
                        'peso_actual' => $this->peso_actual,
                        'objetivo_dieta' => $this->objetivo_dieta,
                        'nivel_actividad' => $this->nivel_actividad,
                        'pais_residencia' => $this->pais_residencia);
                    $arrfieldsnocomma = array('edad' => $this->edad,
                        'estatura' => $this->estatura);
                    $q = $this->UTILITY->make_query_update($table, "idUSUARIO = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                    mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                }
            } else {
                $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Faltan datos.')));
            }
        } else {
            if ($resultado == 0) {
                //crea el nuevo usuario
                $pass = $this->make_hash_pass($this->email, $this->pass);
                $q = "INSERT INTO tedi_usuario (nombre, pass, nickname, email, sexo, edad, pais_residencia, estatura, nivel_actividad, objetivo_dieta) VALUES ('$this->nombre', '$pass', '$this->nickname', '$this->email', '$this->sexo', $this->edad, '$this->pais_residencia', $this->estatura, '$this->nivel_actividad', '$this->objetivo_dieta')";
                mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                $id = mysql_insert_id();
            } else {
                $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '3002', 'content' => 'ya existe.')));
            }
        }
        $arrjson = array('output' => array('valid' => true, 'id' => $id));
        echo json_encode($arrjson);
    }

    /**
     * Metodo para guardar el seguimiento del usuario
     */
    private function save_seguimiento() {
        if ($this->id == 0) {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $q = "INSERT INTO tedi_seguimiento_pesonal (tedi_usuario_idUSUARIO, nivel_actividad, calorias_reportadas, peso, fecha) VALUES ($this->id, '$this->nivel_actividad', $this->calorias, $this->peso, NOW())";
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            if ($this->calorias == 0){
                $q = "UPDATE tedi_usuario SET `peso_actual` = '$this->peso', `nivel_actividad` = '$this->nivel_actividad' WHERE idUSUARIO = $this->id";
                mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            }
            $id = mysql_insert_id();
            $arrjson = array('output' => array('valid' => true, 'id' => $id, 'query' => $q));
        }
        echo json_encode($arrjson);
    }

    /**
     * Metodo para guardar el evento de alimentacion
     * ej. a continuacion se almacena un alimento consumido (una arepa), perteneciente al menu 1 (arepa con jugo de naranja y queso crema).
     * http://www.qsystems.com.co/tediws/ws.php?op=save_alimento_consumido&menu_id=1&dieta_id=1&alimento_id=1&porciones=1     
     */
    private function save_alimento_consumido() {
        if ($this->id == 0) {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $q = "INSERT INTO tedi_historial_dieta VALUES (NULL, '$this->menu_id', $this->dieta_id, $this->alimento_id, NOW(), $this->porciones )";
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            //dudas here
            //$q = "UPDATE tedi_historial SET `tedi_menu_idmenu` = '$this->menu_id', `tedi_dieta_iddieta` = '$this->dieta_id', `tedi_alimentos_idalimentos` = '$this->alimento_id' WHERE idUSUARIO = $this->id";
            //mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $id = mysql_insert_id();
            $arrjson = array('output' => array('valid' => true, 'id' => $id, 'query' => $q));
        }
        echo json_encode($arrjson);
    }

    /**
     * Metodo para consultar el seguimiento de un usuario
     */
    public function get_seguimiento() {
        if ($this->id == 0) {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $q = "SELECT * FROM tedi_seguimiento_pesonal WHERE tedi_usuario_idUSUARIO = " . $this->id . " ORDER BY fecha DESC";
            $con = mysql_query($q, $this->conexion);
            $arr = array();
            while ($obj = mysql_fetch_object($con)) {
                $arr[] = array(
                    'nivel_actividad' => $obj->nivel_actividad,
                    'calorias_reportadas' => $obj->calorias_reportadas,
                    'peso' => $obj->peso,
                    'fecha' => ($obj->fecha)
                );
            }
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        }
        echo json_encode($arrjson);
    }

    /**
     * Metodo para seleccionar tipos de menus (desayunos, almuerzos y comidas, meriendas, etc)
     * http://www.qsystems.com.co/tediws/ws.php?op=get_tipo_menu&tipo_menu=desayuno     
     */
    public function get_menu_type() {
        if ($this->tipo_menu == "") {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $q = "SELECT * FROM `tedi_menu` WHERE tipo_menu = '" . $this->tipo_menu . "' ORDER BY nombre_menu ASC";
            $con = mysql_query($q, $this->conexion);
            $arr = array();
            while ($obj = mysql_fetch_object($con)) {
                $arr[] = array(
                    'id' => $obj->idmenu,
                    'nombre_menu' => $obj->nombre_menu,
                    'tipo_menu' => $obj->tipo_menu,
                );
            }
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        }
        echo json_encode($arrjson);
    }

    /**
     * Metodo para seleccionar los alimentos que conforman un menu seleccionado
     * http://www.qsystems.com.co/tediws/ws.php?op=get_elementos_menu&id_menu=1, este ultimo menu 1 es por ej. arepa con queso crema y jugo naranja     
     */
    public function get_menu_elements() {
        if ($this->id_menu == "") {
            $arrjson = array('output' => array('valid' => false, 'response' => array('code' => '2001', 'content' => ' Missing parameters.')));
        } else {
            $q = "SELECT * FROM `tedi_alimentos` WHERE idalimentos IN ( SELECT tedi_alimentos_idalimentos FROM `tedi_menu_has_tedi_alimentos` WHERE  tedi_menu_idmenu = " . $this->id_menu . ")";
            $con = mysql_query($q, $this->conexion);
            $arr = array();
            while ($obj = mysql_fetch_object($con)) {
                $arr[] = array(
                    'id' => $obj->idalimentos,
                    'nombre' => $obj->nombre,
                    'porcion_tipo' => $obj->porcion_tipo,
                    'porcion_gramos' => $obj->porcion_gramos,
                    'categoria' => $obj->categoria,
                    'calorias_porcion' => $obj->calorias_porcion,
                    'es_bebida' => $obj->es_bebida,
                    'unidad_medida' => $obj->unidad_medida,
                    'porcion_popular' => $obj->porcion_popular,
                );
            }
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        }
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