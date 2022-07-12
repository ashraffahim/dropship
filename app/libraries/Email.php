<?php

namespace libraries;

class Email {
	public function wrapMail($html) {
		$logo = LOGO;
		$eof = <<< EOF
		<div align="center" style="font-family: sans-serif">
		  <div style="max-width: 500px;width: 100%;display: inline-block">
			<div style="background-color: #fafafa;border-radius: .25rem;border: 2px solid #ddd;padding: 2rem 0">
			  <div style="display: flex;align-items: center;justify-content: start">
				<img src="$logo" style="height: 34px;width: 64px;border-radius: .25rem;margin-left: 2rem;">
				<span style="margin-left: 2rem;font-size: 2rem;font-weight: 900;color: #6e4e9e"></span>
			  </div>
			  <div style="margin: 2rem 0;border: .4px solid #ccc"></div>
			  <div>
				$html
			  </div>
			</div>
		  </div>
		</div>
EOF;
		return $eof;
	}
	
	public function send($to, $subject, $html, $text, $wrap = true, $from = false) {
	
		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/Exception.php';
		require 'PHPMailer/src/SMTP.php';
	
		$mail = new \PHPMailer\PHPMailer\PHPMailer;
	
		$mail->isSMTP();
		$mail->Host = SMTP;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = false;
		$mail->Port = SMTP_PORT;
	
		if (is_array($from)) {
			$mail->Username = $from['username'];
			$mail->Password = $from['password'];
			$mail->setFrom($from['username'], $from['name']);
		} else {
			$mail->Username = 'no-reply@grap.store';
			$mail->Password = 'Grap2022';
			$mail->setFrom('no-reply@grap.store', 'Grap Store No Reply');
		}
	
		if (is_array($to)) {
			foreach ($to as $a) {
				$mail->addAddress($a);
			}
		} else {
			$mail->addAddress($to);
		}
	
		$mail->isHTML(true);
	
		$mail->Subject = $subject;
		$mail->Body = $wrap ? $this->wrapMail($html) : $html;
		$mail->AltBody = $text;
	
		if(!$mail->send()){
			return true;
		}else{
			return false;
		}
	
	}
}

?>