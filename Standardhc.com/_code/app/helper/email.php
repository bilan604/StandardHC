<?php

class EmailSendException extends Exception {}
/**
 * 定义邮件发送类 
 *
 * @param
 *
 * @return
 */

require_once('phpmailer/class.phpmailer.php');

class Helper_Email
{
	private $_config = array();
	
	function __construct() {
		$this->_config = Q::ini ( 'appini/email' );
		
		if (!is_array($this->_config) )
		{
			throw new EmailSendException( _T('Please set up the config file first') );
		}
	}
	
	public function send($receiver,$subject,$content)
	{
		if ( empty($receiver) || !$this->isEmail($receiver) )
		{

			throw new EmailSendException( _T('Invalid Email address') );
		}
		if ( empty($subject) )
		{

			throw new EmailSendException(_T('Please enter Email subject') );
		}
		if ( empty($content) )
		{

			throw new EmailSendException(_T('Please enter Email body') );
		}
		
		$mail  = new PHPMailer();
		
		try
		{
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPDebug  = 0;              // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
			$mail->CharSet    = "UTF-8"; 
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			if ($this->_config['ssl'] == true)
			{
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			}
			$mail->Host       = $this->_config['server'];      // sets GMAIL as the SMTP server
			$mail->Port       = isset($this->_config['port']) ? $this->_config['port'] : 25;   // set the SMTP port for the GMAIL server
			$mail->Username   = isset($this->_config['username']) ? $this->_config['username'] : '';  // GMAIL username
			$mail->Password   = isset($this->_config['password']) ? $this->_config['password'] : '';            // GMAIL password
			
			$from = $this->_config['mail'];
			
			$mail->SetFrom($from,  $from );
	
			$mail->AddReplyTo($from, $from );
	
			$mail->Subject    = $subject;
			//'?UTF-8?B?' . base64_encode($subject) .'?=';  
	
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	
			$mail->MsgHTML($content);
			
			$mail->AddAddress($receiver, $receiver);
			/*$address = "whoto@otherdomain.com";
			
			
			$mail->AddAttachment("images/phpmailer.gif");      // attachment
			$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
			*/
	
			if( !$mail->Send() ) {
			  QLog::log("Mailer Error: " . $mail->ErrorInfo , Qlog::DEBUG);
			  return false;
			} else {
			  return true;
			}
		} catch (phpmailerException $e) {
		  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
		  QLog::log("Mailer Error: " . $e->errorMessage() , Qlog::DEBUG);
		} catch (Exception $e) {
		  //echo $e->getMessage(); //Boring error messages from anything else!
		  QLog::log("Mailer Error: " . $e->errorMessage() , Qlog::WARNING);
		}

	}
	
	//校验邮箱格式
	private function isEmail($val)
	{
		return ( preg_match('/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9-]+\.)+[A-Za-z0-9]+$/', $val) != 0 );
	}
}
