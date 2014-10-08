<?php
	require_once('modules/user/model/user.php');
	class userController{
		var $user = NULL;
		
		public function __construct(){
			$this->user = new user();
		}
				
		public function home(){
			$this->user->home();
		}

		public function usuario(){
			$idu = (isset($_GET['id'])) ? $_GET['id'] : 3 ; //3 es mi id en la bd 
			if($idu != 0 && $idu != NULL){
				$this->user->usuario($idu);
			}else{
				header("Location: /404.html");
			}
		}

		public function preguntas(){
			$this->user->preguntas();
		}
	}
?>