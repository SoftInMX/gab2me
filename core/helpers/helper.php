<?php
class helper
{
	
	function __construct(){
		//
	}

	public static function sanitize($dato){
		$dato = trim($dato); //eliminar espacion en blando inicio y final de cadena
		$dato = strip_tags($dato); //quita etiquetas html
		$dato = htmlentities($dato); //convierte etiquetas html
		return $dato;
	}

	public static function arrayToSql($type,$data,$table){
		$query = '';
		$total = count($data);
		$keys = array_keys($data);
		$i = 0;
		$first_key = $keys[0];
		
		if ($type == 'insert') {
			$query .= "INSERT INTO $table (". implode(',', $keys) . ') VALUES(';
			foreach ($data as $value) {
				$query .= "'$value'";
				$query .= $i+1 >= $total?');':',';
				$i++;
			}
			
		}else if ($type == 'update') {
			$query = "UPDATE $table SET ";
			for ($j=1; $j < $total; $j++) {
				$query .= $keys[$j] . '=' . "'" . $data["$keys[$j]"] . "'";
				$query .= isset($keys[$j + 1])?', ':' ';
			}				
			$query .= "WHERE $first_key = " . $data["$first_key"] . ';';
		}else if ($type == 'delete') {
			$query = "DELETE FROM $table WHERE $first_key = " . $data["$first_key"] . ';';
		}else if ($type == 'select') {
			$query .= 'SELECT ' . implode(',', $data['select']) . " FROM $table WHERE $first_key = " . $data["$first_key"] . ';';
		}
		
		return $query;
	}
}
?>