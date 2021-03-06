<?php
	header("Content-Type: text/html; charset=utf-8");

	if (!$_POST) exit;

	require dirname(__FILE__)."/validation.php";
	require dirname(__FILE__)."/csrf.php";

/************************************************/
/* Your data */
/************************************************/
	/* Your email goes here */
	$your_email = "martinbrignone@gmail.com";

	/* Your name or your company name goes here */
	$your_name = "ME";

	/* Message subject */
	$your_subject = "Formulario de iMOD ME";

/************************************************/
/* Settings */
/************************************************/
	/* Select validation for fields */
	/* If you want to validate field - true, if you don't - false */
    $validate_tipology	         	= false;
    $validate_apartment_name		= false;
	$validate_name	            	= false;
//    $validate_rut                 = false;
	$validate_email		            = true;
	$validate_phone	               	= false;
	$validate_message              	= false;

	/* Select the action */
	/* If you want to do the action - true, if you don't - false */
	$send_letter = true;

/************************************************/
/* Variables */
/************************************************/
	/* Error variables */
	$error_text		= array();
	$error_message	= '';

	/* POST data */

	$tipology       = (isset($_POST["tipology"]))        ? strip_tags(trim($_POST["tipology"]))	           	 : false;
	$apartment_name = (isset($_POST["apartment_name"]))  ? strip_tags(trim($_POST["apartment_name"]))		 : false;

	$name	 = (isset($_POST["name"]))		        	 ? strip_tags(trim($_POST["name"]))			 : false;
    //$rut	 = (isset($_POST["rut"]))					 ? strip_tags(trim($_POST["rut"]))			 : false;
	$email	 = (isset($_POST["email"]))					 ? strip_tags(trim($_POST["email"]))		 : false;
	$phone	 = (isset($_POST["phone"]))					 ? strip_tags(trim($_POST["phone"]))		 : false;
	$message = (isset($_POST["message"]))				 ? strip_tags(trim($_POST["message"]))		 : false;
	$token	 = (isset($_POST["token_contact"]))			 ? strip_tags(trim($_POST["token_contact"])) : false;



	$tipology		 = htmlspecialchars($tipology, ENT_QUOTES, 'UTF-8');
	$apartment_name	 = htmlspecialchars($apartment_name, ENT_QUOTES, 'UTF-8');

	$name	 = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    //$rut	 = htmlspecialchars($rut, ENT_QUOTES, 'UTF-8');
	$email	 = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
	$phone	 = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
	$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
	$token	 = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');



	$tipology       = substr($tipology, 0, 50);
	$apartment_name	= substr($apartment_name, 0, 50);

	$name	 = substr($name, 0, 50);
    //$rut	 = substr($rut, 0, 50);
	$email	 = substr($email, 0, 40);
	$phone	 = substr($phone, 0, 25);
	$message = substr($message, 0, 1000);

/************************************************/
/* CSRF protection */
/************************************************/


	/*$new_token = new CSRF('contact');
	if (!$new_token->check_token($token)) {
		echo '<div class="error-message unit"><i class="fa fa-close"></i>Incorrect token. Please reload this webpage</div>';
		exit;
	}*/

/************************************************/
/* Validation */
/************************************************/
	
    /* Typology */
	if ($validate_tipology){
		$result = validateTipology($name, 1);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}


    /* Apartment */
	if ($validate_apartment_name){
		$result = validateApartment_name($name, 1);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}


    /* Name */
	if ($validate_name){
		$result = validateName($name, 1);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}

    /* RUT */
//	if ($validate_rut){
//		$result = validateRut($rut, 1);
//		if ($result !== "valid") {
//			$error_text[] = $result;
//		}
//	}

	/* Email */
	if ($validate_email){
		$result = validateEmail($email);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}

	/* Phone */
	if ($validate_phone){
		$result = validatePhone($phone);
		if ($result !== "valid") {
				$error_text[] = $result;
			}
	}

	/* Message */
	if ($validate_message){
		$result = validateMessage($message, 20);
		if ($result !== "valid") {
			$error_text[] = $result;
		}
	}

	/* If validation error occurs */
	if ($error_text) {
		foreach ($error_text as $val) {
			$error_message .= '<li>' . $val . '</li>';
		}
		echo '<div class="error-message unit"><i class="fa fa-close"></i>Oops! The following errors occurred:<ul>' . $error_message . '</ul></div>';
		exit;
	}

/************************************************/
/* Sending email */
/************************************************/
	if ($send_letter) {

		/* Send email using sendmail function */
		/* If you want to use sendmail - true, if you don't - false */
		/* If you will use sendmail function - do not forget to set '$smtp' variable to 'false' */
		$sendmail = true;
		if ($sendmail) {
			require dirname(__FILE__)."/phpmailer/PHPMailerAutoload.php";
			require dirname(__FILE__)."/message.php";
			$mail = new PHPMailer;
			$mail->isSendmail();
			$mail->IsHTML(true);
			$mail->From = $email;
			$mail->CharSet = "UTF-8";
			$mail->FromName = "J-forms";
			$mail->Encoding = "base64";
			$mail->ContentType = "text/html";
			$mail->addAddress($your_email, $your_name);
			$mail->Subject = $your_subject;
			$mail->Body = $letter;
			$mail->AltBody = "Use an HTML compatible email client";
		}

		/* Send email using smtp function */
		/* If you want to use smtp - true, if you don't - false */
		/* If you will use smtp function - do not forget to set '$sendmail' variable to 'false' */
		$smtp = false;
		if ($smtp) {
			require dirname(__FILE__)."/phpmailer/PHPMailerAutoload.php";
			require dirname(__FILE__)."/message.php";
			$mail = new PHPMailer;
			$mail->isSMTP();											// Set mailer to use SMTP
			$mail->Host = "smtp1.example.com;smtp2.example.com";		// Specify main and backup server
			$mail->SMTPAuth = true;										// Enable SMTP authentication
			$mail->Username = "your-username";							// SMTP username
			$mail->Password = "your-password";							// SMTP password
			$mail->SMTPSecure = "tls";									// Enable encryption, 'ssl' also accepted
			$mail->Port = 465;											// SMTP Port number e.g. smtp.gmail.com uses port 465
			$mail->IsHTML(true);
			$mail->From = $email;
			$mail->CharSet = "UTF-8";
			$mail->FromName = "J-forms";
			$mail->Encoding = "base64";
			$mail->Timeout = 200;
			$mail->SMTPDebug = 0;
			$mail->ContentType = "text/html";
			$mail->addAddress($your_email, $your_name);
			$mail->Subject = $your_subject;
			$mail->Body = $letter;
			$mail->AltBody = "Use an HTML compatible email client";
		}

		/* Multiple email recepients */
		/* If you want to add multiple email recepients - true, if you don't - false */
		/* Enter email and name of the recipients */
		$recipients = false;
		if ($recipients) {
			$recipients = array("email@domain.com" => "name of recipient",
								"email@domain.com" => "name of recipient",
								"email@domain.com" => "name of recipient"
								);
			foreach ($recipients as $email => $name) {
				$mail->AddBCC($email, $name);
			}
		}

		/* if error occurs while email sending */
		if(!$mail->send()) {
			echo '<div class="error-message unit"><i class="fa fa-close"></i>Mailer Error: ' . $mail->ErrorInfo . '</div>';
			exit;
		}
	}

/************************************************/
/* Success message */
/************************************************/
	echo '<div class="success-message unit"><i class="fa fa-check"></i>Su mensaje ha sido enviado correctamente</div>';
?>