<?php
function myErrorHandler($errno, $errstr, $errfile, $errline){

	global $debug_mode;

	$str = "THIS IS OUR CUSTOM ERROR HANDLER<br>";
	$str .= "ERROR NUMBER: " . $errno . "<br>ERROR MSG: " . $errstr . "<br>FILE: " . $errfile . "<br>LINE NUMBER: " . $errline . "<br><br>";
	
	if($debug_mode){
		echo($str);
	}else{
		// You might want to send all the super globals with the error message 
		//$str .= print_r($_POST);
		//$str .= print_r($_GET);
		//$str .= print_r($_SERVER);
		//$str .= print_r($_FILES);
		//$str .= print_r($_COOKIE);
		//$str .= print_r($_SESSION);
		//$str .= print_r($_REQUEST);
		//$str .= print_r($_ENV);
		
		//TODO: send email to web admin
		//TODO: echo a nice message to the user, or redirect to an error page

		//die();
	}
}

set_error_handler("myErrorHandler");

function myExceptionHandler($exception) {
    if(DEBUG_MODE){
		echo($exception->getMessage());
	}else{
		//How to handle exceptions???
		
		//TODO: send email to web admin
		//TODO: echo a nice message to the user, or redirect to an error page
	}
}

set_exception_handler("myExceptionHandler");

// WHAT'S THE DIFFERENCE BETWEEN EXCEPTIONS AND ERRORS?
// Exceptions are thrown, and intended to be caught
// Errors are generally not recoverable



?>