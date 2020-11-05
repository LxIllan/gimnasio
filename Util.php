<?php

    require_once 'Membresia.php';
	
	date_default_timezone_set('America/Mexico_City');
	
	class DatosInvalidosException extends Exception {
		
		function __construct($mensaje) {
			parent::__construct($mensaje, 1);
		}
	}

	class Util {
		public const FOTO_SOCIO = 0;
		public const FOTO_USUARIO = 1;
		public const FOTO_PRODUCTO = 2;
		public const FOTO_EJERCICIO = 3;
		public const STR_FOOTER = 'Copyright © SoftGym 2018';
		public const SEXOS = ['Femenino', 'Masculino'];
		public const MUSCULOS = ['Abdomen', 'Antebrazo', 'Bicep', 'Bicep femoral', 'Cuadricep',
			'Espalda', 'Femoral', 'Hombro', 'Gluteo', 'Pantorrilla', 'Pecho', 'Tricep'];
		public const LESIONES = ['Ninguna', 'GRADO 1', 'GRADO 2', 'GRADO 3'];
		public const MEMBRESIAS = ['Mensual', 'Trimestral', 'Semestral', 'Anual', 'Semanal'];
		public static $datosInvalidos = "Ningún dato ingresado es válido";
		public static $strNull = "";

		public static function diasSobrantes($fecha) {
	        $ahora = date("Y-m-d", strtotime($fecha));
	        $segundos = strtotime($ahora) - strtotime('now');
	        $diasSobrantes = intval($segundos/60/60/24);
	        $diasSobrantes++;
	        return $diasSobrantes;
    	}        						

		public static function obtenerPeso($peso, $lesion) {
			$peso = preg_replace("/[^0-9.]/", '', $peso);
			$peso = floatval($peso);
			if ($lesion == 1) {
				$peso *= .75;
			} else if ($lesion == 2) {
				$peso *= .50;
			} else if ($lesion == 3) {
				$peso *= .25;
			}
			return round($peso);
		}

		public static function load_video(array $video, int $id_ejercicio)
		{
			$path_default = 'video/default.mp4';
			$name_video = 'video/video_' . $id_ejercicio . '.mp4';
			if ((isset($video)) && (end((explode(".", $video['name']))) == 'mp4')) {
				$source = $video['tmp_name'];
				$destiny = 'video/' . $video['name'];
				$name_video = 'video/video_' . $id_ejercicio . '.mp4';
				if (!is_uploaded_file($source)) {
					echo "Error: El fichero encontrado no fue procesado por la subida correctamente";
					return $path_default;
				}
				if (@move_uploaded_file($source, $destiny)) {
					if (rename($destiny, $name_video)) {
						return $name_video;
					} else {
						unlink($name_video);
						return $path_default;
					}
				} else {
					return $path_default;
				}
			}
			return (file_exists($name_video)) ? $name_video : $path_default;
		}

		public static function cargarImagen(array $foto, int $idUsuario, int $tipoUsuario = 0) {
			$fotosDefault = ['img/Socios/default.jpg', 'img/Usuarios/default.jpg', 'img/Productos/default.jpg', 'img/Ejercicios/default.jpg'];
			switch ($tipoUsuario) {
				case self::FOTO_SOCIO:
					$carpeta = 'Socios';
					break;
				case self::FOTO_USUARIO:
					$carpeta = 'Usuarios';
					break;
				case self::FOTO_PRODUCTO:
					$carpeta = 'Productos';
					break;
				case self::FOTO_EJERCICIO:
					$carpeta = 'Ejercicios';
					break;
			}
			$nombreFoto = 'img/' . $carpeta . '/' . 'IMG_' . $idUsuario . '.jpeg';
			if ((isset($foto)) && (($foto["type"] == "image/jpeg") || ($foto["type"] == "image/jpg") || ($foto["type"] == "image/png"))) {	
				$origen = $foto['tmp_name'];
				$destino = 'img/' . $carpeta . '/' . $foto['name'];
				$nombreFoto = 'img/' . $carpeta . '/' . 'IMG_' . $idUsuario . '.' . end((explode(".", $foto['name'])));
				
				if (!is_uploaded_file($origen)) {
					echo "Error: El fichero encontrado no fue procesado por la subida correctamente";
					return $fotosDefault[$tipoUsuario];
				}
				if (@move_uploaded_file($origen, $destino)) {
					if (rename($destino, $nombreFoto)) {
						return $nombreFoto;
					} else {
						unlink($nombreFoto);
						return $fotosDefault[$tipoUsuario];
					}
				} else {
					return $fotosDefault[$tipoUsuario];
				}
			}
			return (file_exists($nombreFoto)) ? $nombreFoto : $fotosDefault[$tipoUsuario];
		}    

    	public static function fechaFinMembresia($tipoMembresia, $fecha) {    		
    		switch ($tipoMembresia) {
    			case Membresia::MENSUAL:
    				return date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
    			case Membresia::TRIMESTRAL:
    				return date('Y-m-d', strtotime('+3 month', strtotime($fecha)));
    			case Membresia::SEMESTRAL:
    				return date('Y-m-d', strtotime('+6 month', strtotime($fecha)));
    			case Membresia::ANUAL:
    				return date('Y-m-d', strtotime('+1 year', strtotime($fecha)));
    			case Membresia::SEMANAL:
    				return date('Y-m-d', strtotime('+1 week', strtotime($fecha)));
    		}
    		return 0;
    	}

    	public static function formatearFecha($fecha) {
    		return date('d/F/Y', strtotime($fecha));
    	}

    	public static function formatearDinero($dinero) {
			$dinero = floatval($dinero);
            return '$' . money_format('%i', $dinero) . ' M.X.N';
        }

        public static function generarClave(int $numChars = 8) : string {
            $str = "0123456789abcdefghijklmnopqrstuvwxyz0123456789"
            . "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $lenStr = strlen($str);
            $clave = '';
            $i = 0;        
            while ($i++ < $numChars) {
                $clave .= $str[rand(0, $lenStr)];
            }
            return $clave;
		}
		
		public static function limpiarCadena($str) {
            $inyecciones = array(
                '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
                '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
                '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
				'@<![\s\S]*?--[ \t\n\r]*>@',         // Elimina los comentarios multi-línea
				'/[^a-zA-ZáéíóúñÁÉÍÓÚÑ ]/'		// Elimina números y todo tipo de signo
                );        
            $str = preg_replace($inyecciones, '', $str);
            return $str;
        }
        
        public static function sanitizar($str) {
            if (is_array($str)) {
                foreach($str as $var=>$val) {
                    $salida[$var] = self::sanitizar($val);
                }
            } else {
                if (get_magic_quotes_gpc()) {
                    $str = stripslashes($str);
                }
                $salida  = self::limpiarCadena($str);
                //$salida = mysqli::real_escape_string ($str);
            }
            return $salida;
		}
		
		public static function validarEmail($email) {
			return (filter_var($email, FILTER_VALIDATE_EMAIL));
		}
	}
	
	class ArrayList {
		
		private $list = array();

		public function add($obj) {
		    array_push($this->list, $obj);
		}

		public function get($key) {
		    if(array_key_exists($key, $this->list)) {
		        return $this->list[$key];
		    } else {
		        return null;
		    }
		}

		public function isEmpty() {
		    return empty($this->list);
		}

		public function remove($key) {
		    if(array_key_exists($key, $this->list)) {
		        unset($this->list[$key]);
		        return True;
		    } else {
		    	return False;
		    }
		}		

		public function size() {
		    return count($this->list);
		}

		public function sort() {
			sort($this->list);
		}
	}

	/*
	<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!</strong> Better check yourself, you're not looking too good.
    </div>
	*/
?>