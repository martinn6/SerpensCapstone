<!DOCTYPE html>
<HTML>
<BODY>
<?php
	echo "Email Test Start.";
	// using SendGrid's PHP Library
	// https://github.com/sendgrid/sendgrid-php

	$from = new SendGrid\Email("Example User", "test@example.com");
	$subject = "Sending with SendGrid is Fun";
	$to = new SendGrid\Email("Nick Martin", "martinn6@oregonstate.edu");
	$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
	$mail = new SendGrid\Mail($from, $subject, $to, $content);

	$apiKey = "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";
	$sg = new \SendGrid($apiKey);

	$response = $sg->client->mail()->send()->post($mail);
	echo $response->statusCode();
	echo $response->headers();
	echo $response->body();
	
	echo "Email Test End.";
?>
</BODY>
</HTML>