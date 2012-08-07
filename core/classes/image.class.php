<?php
/* -=================== PRIZES PROJECT ===================-
 * IMAGE MANAGER CLASS
 * -======================================================-
 */

class image {
	private $_img;
	
	function __construct() {
	}
	
	function open($filename) {
		if(!strstr($filename, "http")) {
			if(!is_file($filename)) {
				erro("O arquivo de imagem solicitado não existe");
				return false;
			}
		}
		
		$fileExt = end(explode(".", $filename));
		
		switch($fileExt) {
			case "gif":
				$this->_img = imagecreatefromgif($filename);
			break;
			case "jpg": case "jpeg":
				$this->_img = imagecreatefromjpeg($filename);
			break;
			case "png":
				$this->_img = imagecreatefrompng($filename);
			break;
			default:
				erro("Extensão de imagem não suportada.");
				return false;
		}
		
		return true;
	}
	
	function flip($type = '') {
	    $width  = imagesx($this->_img);
	    $height = imagesy($this->_img);
	    $dest   = imagecreatetruecolor($width, $height);
	    
	    switch($type){
	        case '':
	            $dest = $this->_img;
	        break;
	        case 'vert':
	            for($i=0;$i<$height;$i++){
	                imagecopy($dest, $this->_img, 0, ($height - $i - 1), 0, $i, $width, 1);
	            }
	        break;
	        case 'horiz':
	            for($i=0;$i<$width;$i++){
	                imagecopy($dest, $this->_img, ($width - $i - 1), 0, $i, 0, 1, $height);
	            }
	        break;
	        case 'both':
	            for($i=0;$i<$width;$i++){
	                imagecopy($dest, $this->_img, ($width - $i - 1), 0, $i, 0, 1, $height);
	            
	            }
	            $buffer = imagecreatetruecolor($width, 1);
	            for($i=0;$i<($height/2);$i++){
	                imagecopy($buffer, $dest, 0, 0, 0, ($height - $i -1), $width, 1);
	                imagecopy($dest, $dest, 0, ($height - $i - 1), 0, $i, $width, 1);
	                imagecopy($dest, $buffer, 0, $i, 0, 0, $width, 1);
	            }
	            imagedestroy($buffer);
	        break;
	    }
	    $this->_img = $dest;
	    
	    return true;
	}
	
	function render() {
		if(headers_sent()) {
			erro("Erro: Os cabeçalhos da imagem não puderam ser criados.");
			return false;
		}
		
		header('Content-type: image/png');
		if(imagepng($this->_img)) {
			imagedestroy($this->_img);
			return true;
		} else {
			erro("Erro ao criar a imagem.");
			return false;
		}
	}
	
	function save($filename, $destroy = true) {
		if(imagepng($this->_img, $filename)) {
			if($destroy) imagedestroy($this->_img);
			return true;
		} else {
			erro("Erro ao criar a imagem.");
			return false;
		}
	}
}
?>