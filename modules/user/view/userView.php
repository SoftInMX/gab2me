<?php
class userViews{
	var $path = '';
	
	public function __construct(){
		$this->path = HTML . 'user/';
	}
	
	public function showHome($user=array(), $paginas=array()){
		$lng = count($paginas);
		$html = file_get_contents($this->path.'index.html');
		$pag = '';

		$tabla = explode('<!--Paginas-->', $html);
		$tabla = explode('<!--Paginas-->', $tabla[1]);
		$tabla = $tabla[0];

		if($lng > 0){
			for ($i=0; $i < $lng; $i++) { 
				$pag .= str_replace(array_keys($paginas[$i]), array_values($paginas[$i]), $tabla);
			}
		}else{
			$pag = '<li><a href="#">No hay info</a></li>';	
		}
		$html = str_replace(array($tabla,'{TOP_USUARIOS}'), array($pag,$user), $html);
		echo $html;
	}

	public function showPerfil($perfil=array(), $preguntas=0, $siguiendo=0, $pag='', $amg){
		$lng = count($perfil);
		$html = file_get_contents($this->path.'perfil.html');
		$usr = '';

		$template = file_get_contents(TEMPLATE);
		$tabla = explode('<!--Perfil-->', $html);
		$tabla = explode('<!--Perfil-->', $tabla[1]);
		$tabla = $tabla[0];

		if($lng > 0){
			for ($i=0; $i < $lng; $i++) { 
				$usr .= str_replace(array_keys($perfil[$i]), array_values($perfil[$i]), $tabla);
			}
		}

		$html = str_replace(array($tabla, '{FOLLOWERS}','{PREGUNTAS}', '{TOP_USUARIOS}'), array($usr, $siguiendo, $preguntas, $amg), $html);
		
		$content = array(
			'{TITLE}' 		=> 'Perfil | Gab2me',
			'{PAGINAS}'		=> $pag,
			'{CONTENIDO}' 	=> $html
		);

		$html = str_replace(array_keys($content), array_values($content), $template);

		echo $html;
	}

	public function showPreguntas($info=array(), $preguntas=array(), $pag=''){
		//$lng = count($perfil);
		$html = file_get_contents($this->path.'preguntas.html');
		$usr = '';

		$template = file_get_contents(TEMPLATE);
		//$tabla = explode('<!--Perfil-->', $html);
		//$tabla = explode('<!--Perfil-->', $tabla[1]);
		//$tabla = $tabla[0];

		//if($lng > 0){
		//	for ($i=0; $i < $lng; $i++) { 
		//		$usr .= str_replace(array_keys($perfil[$i]), array_values($perfil[$i]), $tabla);
		//	}
		//}

		//$html = str_replace(array($tabla, '{FOLLOWERS}','{PREGUNTAS}', '{TOP_USUARIOS}'), array($usr, $siguiendo, $preguntas, $amg), $html);
		
		$content = array(
			'{TITLE}' 		=> 'Preguntas | Gab2me',
			'{CONTENIDO}' 	=> $html
		);

		$html = str_replace(array_keys($content), array_values($content), $template);
		echo $html;
	}

}
?>