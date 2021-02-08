<?php

/******************************************************/
/* Validation methods */
/******************************************************/
	

    /* Typology */
	function validateTipology($tipology, $min_length) {
		$error_text = "#";
		$len = mb_strlen($tipology, 'UTF-8');
		return ($len < $min_length) ? $error_text : "valid";
	}


    /* Apartment */
	function validateApartment_name($apartment_name, $min_length) {
		$error_text = "#";
		$len = mb_strlen($apartment_name, 'UTF-8');
		return ($len < $min_length) ? $error_text : "valid";
	}





    /* Name */
	function validateName($name, $min_length) {
		$error_text = "Ingrese su nombre";
		$len = mb_strlen($name, 'UTF-8');
		return ($len < $min_length) ? $error_text : "valid";
	}

    /* Rut */
//	function validateRut($rut, $min_length) {
//		$error_text = "Ingrese su Rut";
//		$len = mb_strlen($rut, 'UTF-8');
//		return ($len < $min_length) ? $error_text : "valid";
//	}

	/* Email */
	function validateEmail($email){
		$error_text = "Incorrect email format";
		$email_template = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
		return (preg_match($email_template, $email) !== 1) ? $error_text : "valid";
	}

	/* Phone */
	function validatePhone($phone) {
		$error_text = "Phone format: (xxxaa) xxx-xxxx";
		$phone_template = "/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/";
		return (preg_match($phone_template, $phone) !== 1) ? $error_text : "valid";
	}

	/* Message */
	function validateMessage($message, $min_length) {
		$error_text = "The message is too short - min " . $min_length . " characters";
		$len = mb_strlen($message, 'UTF-8');
		return ($len < $min_length) ? $error_text : "valid";
	}
?>