<?php
require_once('core/dao/conection.php');
require_once('core/helpers/helper.php');

class userDAO {	
	var $conection;
	var $mysqli;
	var $helper;
	
	function __construct() {
		$this->conection = new Conection();
		$this->helper = new helper();
		$this->mysqli = $this->conection->conect();
	}
	
	public function login($user,$pass){
		$response = false;
		$sql = "SELECT pf_dfiscales.id_datos 
		FROM  pf_dfiscales, pf_acceso 
		WHERE pf_acceso.correo = '$user' 
		AND pf_acceso.contrasena = AES_ENCRYPT('$pass', SHA2('B3st3cUr1ti_', 512)) 
		AND pf_dfiscales.id_acceso = pf_acceso.id_acceso 
		OR pf_acceso.usuario = '$user' 
		AND pf_acceso.contrasena = AES_ENCRYPT('$pass', SHA2('B3st3cUr1ti_', 512)) 
		AND pf_dfiscales.id_acceso = pf_acceso.id_acceso 
		LIMIT 1;";
		
		$sql2 = 'SELECT pf_instalacion.logo, pf_dfiscales.nombre 
				FROM pf_instalacion, pf_dfiscales 
				WHERE pf_dfiscales.id_datos = '.$response['id_datos'].' 
				AND pf_instalacion.id_datos = pf_dfiscales.id_datos 
				LIMIT 1;';
		
		$u = $this->mysqli->query($sql);
		if($u){
			if($u->num_rows > 0){
				$response = $u->fetch_assoc();
				$response['nombre'] = '';
				$response['logo'] = '';
				$response['install'] = $this->isInstall($response['id_datos']);
				$sql2 = 'SELECT pf_instalacion.logo, pf_dfiscales.nombre 
				FROM pf_instalacion, pf_dfiscales 
				WHERE pf_dfiscales.id_datos = '.$response['id_datos'].' 
				AND pf_instalacion.id_datos = pf_dfiscales.id_datos 
				LIMIT 1;';
				
				$datos = $this->mysqli->query($sql2);
				
				if($datos && $datos->num_rows > 0){
					$datos = $datos->fetch_assoc();
					$response['nombre'] = $datos['nombre'];
					$response['logo'] = $datos['logo'];
				}
			}
		}
		
		return $response;
	}
	
	public function checkMail($mail){
		$response = false;
		$sql = "SELECT email
				FROM  g2m_user
				WHERE email = '$mail'  
				LIMIT 1";
		$u = $this->mysqli->query($sql);
		if($u){
			if($u->num_rows > 0){
				$response = true;
			}
		}
		
		return $response;
	}

	public function registrar($user, $email, $clave){
		$res['estatus'] = 'false';
		$this->userDAO = new userDAO();
		$vm = $this->userDAO->checkMail($email);
		if(!$vm){
			$q = "INSERT INTO g2m_user VALUES(NULL, 0, '$user', '$email', md5('$clave'), 'avatar_default.png', 0)";
			$v = $this->mysqli->query($q);
			if($v){
				$idu = $this->mysqli->insert_id;
				$q = "INSERT INTO g2m_profile VALUES(NULL, $idu, 'default.jpg', '#Nombre', '', '', 'Aquí coloca una breve descripción tuya, <br /> &nbsp;', 'Tu localidad')";
				$v = $this->mysqli->query($q);
				if($v){
					$res['estatus'] = 'true';
				}
			}else{
				$res['estatus'] = 'false';
			}
		}else{
			$res['estatus'] = 'badMail';
		}

		return $res;
	}
	
	public function resetPass($m,$pass){
		$response = false;
		$sql = "UPDATE pf_acceso 
				SET contrasena = AES_ENCRYPT('$pass', SHA2('B3st3cUr1ti_', 512)) 
				WHERE correo = '$m';";
		$u = $this->mysqli->query($sql);
		
		if($u){
			$response = true;
		}
		
		return $response;
	}

	public function topUsuarios(){
		$top = array();
		$c = "SELECT * FROM g2m_user";
		$l = $this->mysqli->query($c);
		$lng = $l->num_rows;
		$p = '';
		for ($i=0; $i < 12; $i++) { $p .= rand(1, $lng) . ',';}
		$p = substr($p, 0,-1);
		$c = "SELECT id_user, user, avatar  FROM g2m_user WHERE id_user IN ($p)  LIMIT 12";
		$v = $this->mysqli->query($c);
		if($v){
			while ($row = $v->fetch_assoc()) {
				$top[] = $row;
			}
		}
		return $top;
	}

	public function getFooter(){
		$pages = array();
		$c = "SELECT id_page, title FROM g2m_page WHERE id_page IN (1,2,3,4,5,6)";
		$v = $this->mysqli->query($c);
		if($v){
			while ($row = $v->fetch_assoc()) {
				$pages[] = $row;
			}
		}
		return $pages;
	}

	public function numSeguiendo($idu){
		$num = 0;
		$c = "SELECT * FROM g2m_follow WHERE id_following = $idu";
		$v = $this->mysqli->query($c);
		if($v){
			$num = $v->num_rows;
		}
		return $num;
	}

	public function dataSeguidores($idu){
		$data = array();
		$ids = array();
		$string = '';
		$c = "SELECT id_follower FROM g2m_follow WHERE id_following = $idu";
		$v = $this->mysqli->query($c);
		if($v){
			$num = $v->num_rows;
			if($num > 0){
				while ($row = $v->fetch_assoc()) {
					$ids[] = $row;
				}

				foreach ($ids as $val) {
					$string .= $val['id_follower'] . ",";
				}

				$s = substr($string, 0, -1);

				$c = "SELECT id_user, avatar FROM g2m_user WHERE id_user IN ($s)";
				$v = $this->mysqli->query($c);

				while ($rows = $v->fetch_assoc()) {
					$data[] = $rows;
				}
			}
		}
		return $data;
	}

	public function numPreguntas($idu){
		$num = 0;
		$c = "SELECT * FROM g2m_ask WHERE idu_questionado = $idu";
		$v = $this->mysqli->query($c);
		if($v){
			$num = $v->num_rows;
		}
		return $num;
	}

	public function getPerfil($idu){
		$data = array();
		$c = "SELECT g2m_user.id_user, g2m_user.avatar AS '{AVATAR}', g2m_profile.cover AS '{COVER}' , g2m_profile.name AS '{NAME}', g2m_profile.desc AS '{DESC}', g2m_profile.city AS '{CITY}' FROM g2m_user, g2m_profile WHERE g2m_user.id_user = $idu AND g2m_user.id_user = g2m_profile.id_user ";
		$v = $this->mysqli->query($c);
		if($v){
			while ($row = $v->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}

	public function getDataBasic($idu){
		$data = array();
		$c = "SELECT g2m_user.id_user, g2m_user.avatar, g2m_profile.name FROM g2m_user, g2m_profile WHERE g2m_user.id_user = $idu AND g2m_profile.id_user = $idu AND g2m_user.id_user = g2m_profile.id_user";
		$v = $this->mysqli->query($c);
		if($v){
			while ($row = $v->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}

	public function getPreguntas($idu){
		$data = array();
		$c = "SELECT g2m_ask.id_ask, g2m_ask.question, g2m_user.avatar, g2m_profile.name FROM g2m_ask, g2m_user, g2m_profile WHERE idu_questionado = $idu AND status = '0' AND g2m_user.id_user = g2m_ask.idu_questioner AND g2m_profile.id_user = g2m_ask.idu_questioner AND g2m_user.id_user = g2m_profile.id_user";
		$v = $this->mysqli->query($c);
		if($v){
			while ($row = $v->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}

}	
?>