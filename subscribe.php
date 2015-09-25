<?php
	require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';
	require_once 'vendor/pelago/emogrifier/Classes/Emogrifier.php';

	if($_SERVER['REQUEST_METHOD'] === 'POST' AND isset($_POST['email'])){
		$email_input = $_POST['email'];
		if(filter_var($email_input, FILTER_VALIDATE_EMAIL)){
			$jsonStr = file_get_contents("config.json");
			$config = json_decode($jsonStr);

			// Create the SMTP configuration
			$transport = Swift_SmtpTransport::newInstance($config->email->host, $config->email->port, $config->email->encryption);
			$transport->setUsername($config->email->username);
			$transport->setPassword($config->email->password);

			// Create the message
			$message = Swift_Message::newInstance();
			$message->setEncoder(Swift_Encoding::get8BitEncoding());
			$message->setTo(array(
		  		$email_input => $email_input,
			  	$config->subscribe->email => $config->subscribe->name
			));
			$message->setSubject($config->subscribe->subject);
			
			$email_content = file_get_contents("email_tpl/_email_.html");			
			$css_email = file_get_contents("email_tpl/_email.css");

			$emogrify = new \Pelago\Emogrifier();
			$emogrify->setCSS($css_email);
			$emogrify->setHTML($email_content);
			$email_content = @$emogrify->emogrify();

			$message->setBody($email_content, "text/html");
			$message->setFrom($config->subscribe->email, $config->subscribe->name);

			// Send the email
			$mailer = Swift_Mailer::newInstance($transport);
			if($mailer->send($message)){
				echo "3";
				return;
			} else {
				echo "0";
				return;
			}
		} else {
			echo "1";
			return;
		}
	} else{
		echo "2";
		return;
	}
?>