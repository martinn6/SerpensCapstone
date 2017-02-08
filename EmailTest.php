<!DOCTYPE html>
<HTML>
<BODY>
<?php
	echo "Email Test Start.";
	$sendgrid = new SendGrid('serpenscapstone', 'T3amSerpin$!');
	$mail = new SendGridMail();
	$mail->addTo('martinn6@oregonstate.edu')->
		   setFrom('serpenscapstone@gmail.com')->
		   setSubject('Email Test')->
		   setText('Hello World!')->
		   setHtml('<strong>Hello World!</strong>');
	$sendgrid->smtp->send($mail);
	echo "Email Test End.";
?>
</BODY>
</HTML>