<?php
	if(isset($_POST['email'])){
		require('lib/Mailchimp.php');

		$API_KEY = '0a7ab4c0b3c62d0b26f29ccd4ff552cd-us11';
		$LIST_ID = 'cd3a54116c';

		$Mailchimp = new Mailchimp($API_KEY);
		$Mailchimp_Lists = new Mailchimp_Lists($Mailchimp);
		$subscriber = null;

		try{
			$subscriber = $Mailchimp_Lists->subscribe(
				$LIST_ID, 
				array('email' => htmlentities($_POST['email']))
			);
		} catch (Mailchimp_Error $e) {
			if($e->getCode())
				echo "2";
			return;
		}

		try{
			$subscriber = $Mailchimp_Lists->subscribe(
				$LIST_ID, 
				array('email' => htmlentities($_POST['email']), 'double_optin' => false),
				array('FNAME' => '','LNAME' => ''),
				'html',
				false
			);
		} catch (Mailchimp_Error $e) {
			if($e->getCode())
				echo "2";
			return;
		}

		if(!empty($subscriber['leid'])){
		   echo "success";
		   return;
		} else {
		    echo "0";
		    return;
		}

	} else{
		echo "1";
		return;
	}
?>