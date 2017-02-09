<!DOCTYPE html>
<HTML>
<BODY>
<?php
	echo "Email test start...V1.12<BR>";
	
	 require_once "Mail.php";
 
	// $from = "Serpens <serpenscapstone@gmail.com>";
	// $to = "Nick Martin <martinn6@oregonstate.edu>";
	// $subject = "Hi!";
	// $body = "Hi,\n\nHow are you?";

	// $host = "smtp.gmail.com";
	// $username = "serpenscapstone";
	// $password = "T3amSerpin$!";

	// $headers = array ('From' => $from,
	//   'To' => $to,
	//   'Subject' => $subject);
	// $smtp = Mail::factory('smtp',
	//   array ('host' => $host,
	//     'auth' => true,
	//     'username' => $username,
	//     'password' => $password));

	// $mail = $smtp->send($to, $headers, $body);

	// if (PEAR::isError($mail)) {
	//   echo("<p>" . $mail->getMessage() . "</p>");
	//  } else {
	//   echo("<p>Message successfully sent!</p>");
	//  }

	
	echo "Email test end.<BR>";
?>
</BODY>
</HTML>