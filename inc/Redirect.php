<?php

	class Redirect {
	
		static function go($url,$message) {
			$_SESSION['message'] = $message;
			header( 'Location: '.$url );
			exit;
		}
		
	}

?>