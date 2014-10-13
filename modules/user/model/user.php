<?php
	require_once('core/dao/user/userDAO.php');
	require_once('modules/user/view/userView.php');

	class user{
		
		var $view = NULL;
		var $userDAO = NULL;
		
		public function __construct(){
			$this->view 	= new userViews();
			$this->userDAO 	= new userDAO();
		}

		public function home(){
			$usuarios = $this->userDAO->topUsuarios();
			$paginas  = $this->userDAO->getFooter();
			$user = '';
			foreach ($usuarios as $usuario) {
				$user .= '<a href="/'.$usuario['id_user'].'"><img src="/static/img/avatars/'.$usuario['avatar'].'" alt="'.$usuario['user'].'"></a>';
			}
			$this->view->showHome($user, $paginas);
		}

		public function registrar($user, $email, $clave){
			$response = $this->userDAO->registrar($user, $email, $clave);
			if($response['estatus'] == 'true'){
				$res = 'registrado';
			}else{
				$res = $response['estatus'];
			}

			echo $res;
		}

		public function usuario($idu){
			$perfil 	= $this->userDAO->getPerfil($idu);
			$preguntas 	= $this->userDAO->numPreguntas($idu);
			$siguiendo 	= $this->userDAO->numSeguiendo($idu);
			$amigos 	= $this->userDAO->dataSeguidores($idu);
			$paginas  = $this->userDAO->getFooter();

			$pag = '';
			$amg = '';
			foreach ($paginas as $pagina) {
				$pag .= '<li><a href="/paginas/'.$pagina['id_page'].'">'.$pagina['title'].'</a></li>';
			}
			if($amigos != NULL){
				foreach ($amigos as $amigo) {
					$amg .= '<a href="/user/usuario?id='.$amigo['id_user'].'"><img src="/static/img/avatars/'.$amigo['avatar'].'" ></a>';
				}
			}else{
				$amg .= '<p style="text-align:center">No tienes amigos busca algunos...</p>';
			}

			$this->view->showPerfil($perfil, $preguntas, $siguiendo, $pag, $amg);
		}

		public function preguntas(){
			//$info = $this->userDAO->getDataBasic($idu);
			//$preguntas = $this->userDAO->getPreguntas($idu);
			//$paginas  = $this->userDAO->getFooter();

			//$pag = '';
			/*foreach ($paginas as $pagina) {
				$pag .= '<li><a href="/paginas/'.$pagina['id_page'].'">'.$pagina['title'].'</a></li>';
			}*/
			
			$this->view->showPreguntas();
		}

		public function configuracion(){
			//$info = $this->userDAO->getDataBasic($idu);
			//$preguntas = $this->userDAO->getPreguntas($idu);
			//$paginas  = $this->userDAO->getFooter();

			//$pag = '';
			/*foreach ($paginas as $pagina) {
				$pag .= '<li><a href="/paginas/'.$pagina['id_page'].'">'.$pagina['title'].'</a></li>';
			}*/
			
			$this->view->showConfiguracion();
		}

	}
?>