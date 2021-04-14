<?php

class MailController extends Controller {

	public function send()
	{

		$mail = new Email(true);
		$mail->sendTo('tonicucoz <tonicucoz@gmail.com>');
		$mail->subject('conferma registrazione');
		$mail->cc('tonicucoz@yahoo.com');
// 		$mail->bcc('asdasd@qweqwe.it,aSA <dsaf@sdfds.sdfsd.it>');
// 		$mail->charset('sadasd');
// 		$mail->ctencoding('asdasdd');
		$mail->from(" EasyGiant <info@easygiant.org>");
		$mail->body('Conferma messaggio!!');
		
// 		$mail->addressRegExp('/aaa/');
		
// 		$addr = array("'asas%%d' <sdfds.sdfdsf@sdfsdf.it>","'qweqwe' <asdas@werew.it>");
// 		var_dump($mail->checkAddresses($addr));
		
		var_dump($mail->send());
		
		print_r($mail->errorsArray);
		
// 		echo "It works!";

	}

}