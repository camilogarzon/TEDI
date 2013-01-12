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
	$this->conexion=$conexion->openConnect();
	$rqst = $_REQUEST;
	$this->op=$this->UTILITY->remove_special_char($rqst['op']);
		header("Content-type: application/javascript; charset=utf-8");
		header("Cache-Control: max-age=15, must-revalidate");
		// con esto se evade la restriccion: Same origin policy
		//header('Access-Control-Allow-Origin: http://localhost');
		//para la app de phonegap, se habilita cualquier dominio
		header('Access-Control-Allow-Origin: *');
			
	if($this->op=='login'){
	    $this->email=$this->UTILITY->remove_special_char($rqst['email']);
	    $this->hashpass=$this->UTILITY->remove_special_char($rqst['hashpass']);
	    $this->login();
	} else if($this->op=='save_alert'){
	    $this->alerta=$this->UTILITY->remove_special_char($rqst['alerta']);
	    $this->descripcion=$this->UTILITY->remove_special_char($rqst['descripcion']);
	    $this->redsocial=$this->UTILITY->remove_special_char($rqst['redsocial']);
	    $this->id_ubicacion=$this->UTILITY->remove_special_char($rqst['id_ubicacion']);
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
	    $this->save_alert();
	} else if ($this->op=='save_search'){
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
	    $this->palabras=$this->UTILITY->remove_special_char($rqst['palabras']);
	    $this->ipusuario=$this->UTILITY->remove_special_char($rqst['ipusuario']);
		$this->save_search();
	} else if ($this->op=='save_calification'){
	    $this->satisfaccion=$this->UTILITY->remove_special_char($rqst['satisfaccion']);
	    $this->confianza=$this->UTILITY->remove_special_char($rqst['confianza']);
	    $this->recomienda=$this->UTILITY->remove_special_char($rqst['recomienda']);
	    $this->redsocial=$this->UTILITY->remove_special_char($rqst['redsocial']);
	    $this->id_ubicacion=$this->UTILITY->remove_special_char($rqst['id_ubicacion']);
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
		$this->save_calification();
	} else if ($this->op=='save_location'){
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
	    $this->latitud=$this->UTILITY->remove_special_char($rqst['latitud']);
	    $this->longitud=$this->UTILITY->remove_special_char($rqst['longitud']);
	    $this->formatted_address=$this->UTILITY->remove_special_char($rqst['formatted_address']);
		$this->save_location();
	} else if ($this->op=='delete_location'){
	    $this->id_ubicacion=$this->UTILITY->remove_special_char($rqst['id_ubicacion']);
		$this->delete_location();
	} else if ($this->op=='get_location'){
		$this->get_location();
	} else if ($this->op=='get_location_details'){
	    $this->id_ubicacion=$this->UTILITY->remove_special_char($rqst['id_ubicacion']);
		$this->get_location_details();
	} else if ($this->op=='save_opinion'){
	    $this->opinion=$this->UTILITY->remove_special_char($rqst['opinion']);
	    $this->redsocial=$this->UTILITY->remove_special_char($rqst['redsocial']);
	    $this->id_ubicacion=$this->UTILITY->remove_special_char($rqst['id_ubicacion']);
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
		$this->save_opinion();
	} else if ($this->op=='save_user'){
	    $this->nombres=$this->UTILITY->remove_special_char($rqst['nombres']);
	    $this->apellidos=$this->UTILITY->remove_special_char($rqst['apellidos']);
	    $this->email=$this->UTILITY->remove_special_char($rqst['email']);
	    $this->birthday=$this->UTILITY->remove_special_char($rqst['birthday']);
	    $this->telefono=$this->UTILITY->remove_special_char($rqst['telefono']);
	    $this->genero=$this->UTILITY->remove_special_char($rqst['genero']);
	    $this->nickname=$this->UTILITY->remove_special_char($rqst['nickname']);
	    $this->hashpass=$this->UTILITY->remove_special_char($rqst['hashpass']);
	    $this->redsocial=$this->UTILITY->remove_special_char($rqst['redsocial']);
	    $this->pais=$this->UTILITY->remove_special_char($rqst['pais']);
	    $this->depto=$this->UTILITY->remove_special_char($rqst['depto']);
	    $this->ciudad=$this->UTILITY->remove_special_char($rqst['ciudad']);
	    $this->idfacebook=$this->UTILITY->remove_special_char($rqst['idfacebook']);
	    $this->idtwitter=$this->UTILITY->remove_special_char($rqst['idtwitter']);
		$this->save_user();
	} else if ($this->op=='get_user'){
		$this->get_user();
	} else if ($this->op=='get_user_details'){
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
		$this->get_user_details();
	} else if ($this->op=='delete_user'){
	    $this->id_usuario=$this->UTILITY->remove_special_char($rqst['id_usuario']);
		$this->delete_user();
	}
	}
	
	public function redondear_dos_decimal($valor) { 
		$float_redondeado=round($valor * 100) / 100; 
		return $float_redondeado; 
	}

	public function redondeado ($numero, $decimales) { 
		$factor = pow(10, $decimales); 
		return (round($numero*$factor)/$factor); 
	} 	
    //////////////////////////////////////////////////////////////////////////////////
    //// OPERACIONES DEL WEBSERVICE  /////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////
    /**
    * Mensaje de error cuando se llama una metodo no valido
    */
    private function invalid_method_called() { $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'1001','content'=>'Invalid method called.'))); echo json_encode($arrjson);}
    
    /**
	 * Metodo para encriptar password
	 */
    public function make_hash_pass($param1, $param2){
    	$r = sha1($param1.$param2.'asdf');
		return $r;
    }
    /**
     * Metodo para loguearse
	 * http://www.qsystems.com.co/saludpws/ws.php?op=login&email=micorreo@gmail.com&hashpass=micorreo
     */
    public function login(){
		if($this->email=="" || $this->hashpass==""){$arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
		}else{
			$resultado = 0;
			$hashpass = $this->make_hash_pass($this->email, $this->hashpass);
			$q=$this->UTILITY->make_query_select("qas_usuario", $where = " usr_email = '$this->email' and usr_hash = '$hashpass' ", $fields = "");
			$con = mysql_query($q, $this->conexion) or die(mysql_error());
			$resultado = mysql_num_rows($con);
			
			while($obj = mysql_fetch_object($con)){
				$arrjson=array('output'=>array('valid'=>true, 'id'=>$obj->usr_id, 'nombres'=>$obj->usr_nombres, 'apellidos'=>$obj->usr_apellidos,
								'email'=>$obj->usr_email, 'telefono'=>$obj->usr_telefono, 'genero'=>$obj->usr_genero,
								'pais'=>$obj->usr_pais,'depto'=>$obj->usr_depto,'ciudad'=>$obj->usr_ciudad, 'fechanacimiento'=>$obj->usr_birthday ));
			}
			
			if ($resultado == 0) {
				$arrjson=array('output'=>array('valid'=>false, 'error'=>"error en usuario o contraseña."));
			}
		}
		echo json_encode($arrjson);
	}
	
    // private function save_search(){
	// if($this->usuario=="" || $this->passhash==""){$arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	// }else{
	// }
	// }


    public function save_search(){
	if($this->palabras==""){
	    $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	} else{
		$table = "qas_busquedas";
		$arrfieldscomma = array('usr_id_qas_usuario' => $this->id_usuario, 'bsq_palabras' => $this->palabras,'bsq_ipusuario' => $this->ipusuario); 
		$arrfieldsnocomma = array('bsq_tscreado' => $this->DATE_NOW);
		$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		mysql_query($q, $this->conexion) or die(mysql_error());
		$id=mysql_insert_id();
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
	}
	echo json_encode($arrjson);
    }

    public function save_calification(){
	if($this->satisfaccion==""){
	    $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	} else{
		$table = "qas_calificacion";
		$arrfieldscomma = array('usr_id_qas_usuario' => $this->id_usuario, 'cal_satisfaccion' => $this->satisfaccion, 'cal_confianza' => $this->confianza,'cal_recomienda' => $this->recomienda,'cal_redsocial' => $this->redsocial); 
		$arrfieldsnocomma = array('cal_tscreado' => $this->DATE_NOW, 'ubi_id_qas_ubicacion' => $this->id_ubicacion);
		$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		mysql_query($q, $this->conexion) or die(mysql_error());
		$id=mysql_insert_id();
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
	}
	echo json_encode($arrjson);
    }

    public function save_alert(){
	if($this->alerta==""){
	    $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	} else{
		$table = "qas_alerta";
		$arrfieldscomma = array('usr_id_qas_usuario' => $this->id_usuario, 'alr_alerta' => $this->alerta, 'alr_descripcion' => $this->descripcion,'alr_redsocial' => $this->redsocial); 
		$arrfieldsnocomma = array('alr_tscreado' => $this->DATE_NOW, 'ubi_id_qas_ubicacion' => $this->id_ubicacion);
		$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		mysql_query($q, $this->conexion) or die(mysql_error());
		$id=mysql_insert_id();
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
	}
	echo json_encode($arrjson);
    }

    public function save_opinion(){
	if($this->opinion==""){
	    $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	} else{
		$table = "qas_opinion";
		$arrfieldscomma = array('usr_id_qas_usuario' => $this->id_usuario, 'opn_opinion' => $this->opinion, 'opn_redsocial' => $this->redsocial); 
		$arrfieldsnocomma = array('opn_tscreado' => $this->DATE_NOW, 'ubi_id_qas_ubicacion' => $this->id_ubicacion);
		$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
		mysql_query($q, $this->conexion) or die(mysql_error());
		$id=mysql_insert_id();
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
	}
	echo json_encode($arrjson);
    }

    public function save_location(){
	if($this->formatted_address==""){
	    $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'2001','content'=>' Missing parameters.')));
	} else{
		$q = "SELECT ubi_id FROM qas_ubicacion WHERE (ubi_latitud = '$this->latitud') AND (ubi_longitud = '$this->longitud')";
		$con = mysql_query($q, $this->conexion);
		$resultado = mysql_num_rows($con);
		while($obj=  mysql_fetch_object($con)){ $id = $obj->ubi_id; }
		if ($resultado == 0) {
			$table = "qas_ubicacion";
			$arrfieldscomma = array('usr_id_qas_usuario' => $this->id_usuario, 'ubi_latitud' => $this->latitud, 'ubi_longitud' => $this->longitud, 'ubi_formatted_address' => $this->formatted_address); 
			$arrfieldsnocomma = array('ubi_tscreado' => $this->DATE_NOW);
			$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
			mysql_query($q, $this->conexion) or die(mysql_error());
			$id=mysql_insert_id();
		}
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
	}
	echo json_encode($arrjson);
    }

    public function delete_location(){
		$q = "DELETE FROM qas_ubicacion WHERE ubi_id = ".$this->id_ubicacion; $con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_alerta WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion; $con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_calificacion WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion; $con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_opinion WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion; $con = mysql_query($q, $this->conexion);
		
		$arrjson=array('output'=>array('valid'=>true,'response'=>'ok'));
	echo json_encode($arrjson);
    }

	//http://www.qsystems.com.co/saludpws/ws.php?op=get_location
    public function get_location(){
		$q = "SELECT * FROM qas_ubicacion";
		$con = mysql_query($q, $this->conexion);
		$resultado = mysql_num_rows($con);
		$arr = array();
		while($obj=  mysql_fetch_object($con)){
			$arr[] = array(
				'id'=>$obj->ubi_id,
				'latitud'=>$obj->ubi_latitud,
				'longitud'=>$obj->ubi_longitud,
				'formatted_address'=>utf8_encode($obj->ubi_formatted_address)
			);
		}
		$arrjson=array('output'=>array('valid'=>true,'response'=>$arr));
	echo json_encode($arrjson);
    }
	//http://www.qsystems.com.co/saludpws/ws.php?op=get_location_details&id_ubicacion=1
    public function get_location_details(){
		$q = "SELECT * FROM qas_ubicacion WHERE ubi_id = ".$this->id_ubicacion;
		$con = mysql_query($q, $this->conexion);
		$resultado = mysql_num_rows($con);
		$arrCalifica = array(); $arrOpina = array(); $arrAlerta = array();
		while($obj=  mysql_fetch_object($con)){
			$q2 = "SELECT * FROM qas_calificacion WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion;
			$con2 = mysql_query($q2, $this->conexion);
			$satisfaccion = 0;
			$confianza = 0;
			$recomienda = 0;
						
			while($obj2=  mysql_fetch_object($con2)){
				$satisfaccion += $obj2->cal_satisfaccion;
				$confianza += $obj2->cal_confianza;
				if ($obj2->cal_recomienda == "si") {
					$recomienda++;
				}
				$arrCalifica[] = array(
					'id'=>$obj2->cal_id,
					'id_usuario'=>$obj2->usr_id_qas_usuario,
					'satisfaccion'=>$obj2->cal_satisfaccion,
					'confianza'=>$obj2->cal_confianza,
					'recomienda'=>$obj2->cal_recomienda,
					'fecha'=>$obj3->cal_tscreado
					);
			}
			$totalCalifica = count($arrCalifica);
			if ($totalCalifica > 0){
				$satisfaccion = $satisfaccion/$totalCalifica;
				$satisfaccion = $this->redondeado($satisfaccion, 1);
				$confianza = $confianza/$totalCalifica;
				$confianza = $this->redondeado($confianza, 1);
				$recomienda = ($recomienda*100)/$totalCalifica;
				$recomienda = $this->redondeado($recomienda, 1);
			}

			$q3 = "SELECT * FROM qas_opinion WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion." order by opn_tscreado DESC";
			$con3 = mysql_query($q3, $this->conexion);
			while($obj3=  mysql_fetch_object($con3)){
				$q31 = "SELECT * FROM qas_usuario WHERE usr_id = '".$obj3->usr_id_qas_usuario."'";
				$con31 = mysql_query($q31, $this->conexion);
				while($obj31=  mysql_fetch_object($con31)){
					$usr_nombres = utf8_encode($obj31->usr_nombres);
					$usr_apellidos = utf8_encode($obj31->usr_apellidos);
				}
				
				$arrOpina[] = array(
					'id'=>$obj3->opn_id,
					'usuario_nombre'=>$usr_nombres,
					'usuario_apellido'=>$usr_apellidos,
					'opinion'=>utf8_encode($obj3->opn_opinion),
					'fecha'=>$obj3->opn_tscreado
					);
			}
			$q4 = "SELECT * FROM qas_opinion WHERE ubi_id_qas_ubicacion = ".$this->id_ubicacion;
			$con4 = mysql_query($q4, $this->conexion);
			while($obj4=  mysql_fetch_object($con4)){
				$arrAlerta[] = array(
					'id'=>$obj4->alr_id,
					'id_usuario'=>$obj4->usr_id_qas_usuario,
					'alerta'=>utf8_encode($obj4->alr_alerta),
					'descripcion'=>utf8_encode($obj4->alr_descripcion),
					'fecha'=>$obj4->alr_tscreado
					);
			}
			$response = array(
				'id'=>$obj->ubi_id,
				'latitud'=>$obj->ubi_latitud,
				'longitud'=>$obj->ubi_longitud,
				'formatted_address'=>utf8_encode($obj->ubi_formatted_address),
				'prom_satisfaccion' => $satisfaccion,
				'prom_confianza' => $confianza,
				'porcent_si_recomienda' => $recomienda,
				'calificaciones' => $arrCalifica,
				'opiniones' => $arrOpina,
				'alertas' => $arrAlerta
			);
		}
		$arrjson=array('output'=>array('valid'=>true,'response'=>$response));
	echo json_encode($arrjson);
    }
	
    public function save_user(){
    	//PRIMERO SE VERIFICA SI EL USUARIO QUE SE LOGUEA EN FACEBOOK YA EXISTE.
    	$resultado = 0;
    	if($this->idfacebook != '') {
    		$q = "SELECT usr_id FROM qas_usuario WHERE usr_idfacebook = '$this->idfacebook'";
			$con = mysql_query($q, $this->conexion);
			$resultado = mysql_num_rows($con);
			while($obj=  mysql_fetch_object($con)){ $id = $obj->usr_id; }
    	//LUEGO SE VERIFICA SI EL USUARIO QUE SE LOGUEA EN TWITTER YA EXISTE.
    	} else if($this->idtwitter != '') {
    		$q = "SELECT usr_id FROM qas_usuario WHERE usr_idtwitter = '$this->idtwitter'";
			$con = mysql_query($q, $this->conexion);
			$resultado = mysql_num_rows($con);
			while($obj=  mysql_fetch_object($con)){ $id = $obj->usr_id; }
		//EL USUARIO QUE NO SE LOGUEA CON LAS ANTERIORES, USA EMAIL, SE VERIFICA SI YA EXISTE
    	} else {
    		if(strlen($this->email > 3)){
				$q="SELECT usr_id FROM qas_usuario WHERE usr_email = '".$this->email."' ";
				$con = mysql_query($q, $this->conexion) or die(mysql_error());
				$resultado = mysql_num_rows($con);
				while($obj=  mysql_fetch_object($con)){ $id = $obj->usr_id; }
				$hashpass = $this->make_hash_pass($this->email, $this->hashpass);
				$table = "qas_usuario";
				$arrfieldscomma = array('usr_nombres' => $this->nombres, 'usr_apellidos' => $this->apellidos, 'usr_email' => $this->email, 
										'usr_telefono' => $this->telefono, 'usr_genero' => $this->genero, 'usr_nickname' => $this->nickname, 
										'usr_hash' => $hashpass, 'usr_redsocial' => $this->redsocial, 
										'usr_pais' => $this->pais, 'usr_depto' => $this->depto, 'usr_ciudad' => $this->ciudad, 
										'usr_idfacebook' => $this->idfacebook, 'usr_idtwitter' => $this->idtwitter, 'usr_birthday' => $this->birthday); 
				$arrfieldsnocomma = array();
				$q=$this->UTILITY->make_query_update($table, "usr_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
				mysql_query($q, $this->conexion) or die(mysql_error());
				
				//make_query_update($table, $where, $arrfieldscomma, $arrfieldsnocomma)
			}
		//SI NO EXISTE UN USUARIO, ENTONCES SE CREA
    	} 
		if($resultado==0){
			$idhash = strtoupper(md5(rand(1000,9999).date("Y-m-d H:i:s")));
			$table = "qas_usuario";
			$hashpass = $this->make_hash_pass($this->email, $this->hashpass);
			$arrfieldscomma = array('usr_id' => $idhash, 'usr_nombres' => $this->nombres, 'usr_apellidos' => $this->apellidos, 'usr_email' => $this->email, 'usr_telefono' => $this->telefono, 'usr_genero' => $this->genero, 'usr_nickname' => $this->nickname, 'usr_hash' => $hashpass, 'usr_redsocial' => $this->redsocial, 'usr_pais' => $this->pais, 'usr_depto' => $this->depto, 'usr_ciudad' => $this->ciudad, 'usr_idfacebook' => $this->idfacebook, 'usr_idtwitter' => $this->idtwitter, 'usr_birthday' => $this->birthday); 
			$arrfieldsnocomma = array('usr_tscreado' => $this->DATE_NOW);
			$q=$this->UTILITY->make_query_insert($table, $arrfieldscomma, $arrfieldsnocomma);
			mysql_query($q, $this->conexion) or die(mysql_error());
			$id=$idhash;//mysql_insert_id();
		} else { $arrjson=array('output'=>array('valid'=>false,'response'=>array('code'=>'3002','content'=>'Account already exists.')));}
		$arrjson=array('output'=>array('valid'=>true,'id'=>$id));
		echo json_encode($arrjson);
    }
	
    public function get_user(){
		$q = "SELECT * FROM qas_usuario order by usr_nombres";
		$con = mysql_query($q, $this->conexion);
		$resultado = mysql_num_rows($con);
		$arr = array();
		while($obj=  mysql_fetch_object($con)){
			$arr[] = array(
				'id'=>$obj->usr_id,
				'idfacebook'=>$obj->usr_idfacebook,
				'idtwitter'=>$obj->usr_idtwitter,
				'redsocial'=>$obj->usr_redsocial,
				'nombres'=>utf8_encode($obj->usr_nombres),
				'apellidos'=>utf8_encode($obj->usr_apellidos),
				'email'=>utf8_encode($obj->usr_email),
				'nickname'=>utf8_encode($obj->usr_nickname),
				'pais'=>utf8_encode($obj->usr_pais),
				'depto'=>utf8_encode($obj->usr_depto),
				'ciudad'=>utf8_encode($obj->usr_ciudad),
				'telefono'=>$obj->usr_telefono,
				'genero'=>$obj->usr_genero,
				'tscreado'=>$obj->usr_tscreado,
				'fechanacimiento'=>$obj->usr_birthday
			);
		}
		$arrjson=array('output'=>array('valid'=>true,'response'=>$arr));
	echo json_encode($arrjson);
    }
	
    public function get_user_details(){
		$q = "SELECT * FROM qas_usuario WHERE usr_id = '".$this->id_usuario."'";
		$con = mysql_query($q, $this->conexion);
		$resultado = mysql_num_rows($con);
		$arr = array();
		while($obj=  mysql_fetch_object($con)){
			$arr[] = array(
				'id'=>$obj->usr_id,
				'idfacebook'=>$obj->usr_idfacebook,
				'idtwitter'=>$obj->usr_idtwitter,
				'redsocial'=>$obj->usr_redsocial,
				'nombres'=>utf8_encode($obj->usr_nombres),
				'apellidos'=>utf8_encode($obj->usr_apellidos),
				'email'=>utf8_encode($obj->usr_email),
				'nickname'=>utf8_encode($obj->usr_nickname),
				'pais'=>utf8_encode($obj->usr_pais),
				'depto'=>utf8_encode($obj->usr_depto),
				'ciudad'=>utf8_encode($obj->usr_ciudad),
				'telefono'=>$obj->usr_telefono,
				'genero'=>$obj->usr_genero,
				'tscreado'=>$obj->usr_tscreado,
				'fechanacimiento'=>$obj->usr_birthday
			);
		}
		$arrjson=array('output'=>array('valid'=>true,'response'=>$arr));
	echo json_encode($arrjson);
    }
	
	public function delete_user(){
		$q = "DELETE FROM qas_usuario WHERE usr_id = '".$this->id_usuario."'"; 
		$con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_alerta WHERE usr_id_qas_usuario = '".$this->id_usuario."'"; 
		$con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_calificacion WHERE usr_id_qas_usuario = '".$this->id_usuario."'"; 
		$con = mysql_query($q, $this->conexion);
		$q = "DELETE FROM qas_opinion WHERE usr_id_qas_usuario = '".$this->id_usuario."'"; 
		$con = mysql_query($q, $this->conexion);
		
		$arrjson=array('output'=>array('valid'=>true,'response'=>'ok'));
	echo json_encode($arrjson);
    }
	
}
new WS();
?>