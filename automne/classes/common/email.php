<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: email.php,v 1.6 2009/07/22 12:23:38 sebastien Exp $

/**
  * Class CMS_email
  *
  *  Creates email with Sender, receiver, subject and body
  *  Also has the ability to send an email
  *  Correct input assumed
  * 
  * @package CMS
  * @subpackage common
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  *
  * Methods EncodeHeader, EncodeQP, EncodeQ, FixEOL are based on phpmailer version 2.0.0RC1
  * See phpmailer.sourceforge.net for license (LGPL) informations and authors.
  * @author: Andy Prevost (project admininistrator)
  * @author: Brent R. Matzelle (original founder)
  */

class CMS_email extends CMS_grandFather
{
	/**
	  * Subject of email
	  *
	  * @var string
	  * @access private
	  */
	protected $_subject;
	
	/**
	  * Body of email
	  *
	  * @var string
	  * @access private
	  */
	protected $_body;
	
	/**
	  * Footer of email
	  *
	  * @var string
	  * @access private
	  */
	protected $_footer;
	
	/**
	  * HTML Template of email
	  *
	  * @var string
	  * @access private
	  */
	protected $_template;
	
	/**
	  * Email destination address(')
	  *
	  * @var string or array(String)
	  * @access private
	  */
	protected $_emailTo;
	
	/**
	  * Email sender address
	  * default value = APPLICATION_POSTMASTER_EMAIL
	  * @var string
	  * @access private
	  */
	protected $_emailFrom = APPLICATION_POSTMASTER_EMAIL;
	
	/**
	  * Email encoding char
	  * default value = APPLICATION_DEFAULT_ENCODING
	  * @var string
	  * @access private
	  */
	  
  	protected $_emailEncoding = APPLICATION_DEFAULT_ENCODING;
	
	/**
	  * HTML Email value
	  * default value = false
	  * @var mixed
	  * @access private
	  */
	  
  	protected $_emailHTML = false;
	
	/**
	  * email error return
	  * @var string
	  * @access private
	  */
	protected $_error;
	
	/**
	  * email files attachement
	  * @var array
	  * @access private
	  */
	protected $_files=array();
	
	/**
	  * from Name
	  * @var string
	  * @access private
	  */
	protected $_fromName;
	
	/**
	  * to Name
	  * @var string
	  * @access private
	  */
	protected $_toName;
	
	/**
  	  * Line ending used
  	  * @var string
  	  * @access private
  	  */
	protected $LE = "\n";
	
	/**
  	  * drop email list : drop emails from or to these emails
      * @var array
      * @access private
      */
  	protected $_drop = array('automne@votredomain.com', 'root@localhost', 'nobody@localhost', 'postmaster@localhost');
	
	/**
	  * Constructor.
	  * use internal functions setBody, setSubject, 
	  *  				setEmailTo and setEmailFrom instead
	  *  
	  * @return void
	  * @access public
	  * 
	  */
	function __construct()
	{
		//Do Nothing
	}
	
	/**
	  * Sets email for the errors return
	  *
	  * @param string $error The email to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setErrorReturn($error)
	{
		$this->_error = $error;
		return true;
	}
	
	/**
	  * Sets the Attach File of the mail
	  *
	  * @param string $to The To to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setFile($file)
	{
		if (file_exists($file)) {
			$this->_files[] = $file;
			return true;
		} else {
			return false;
		}
	}
	/**
	  * Sets Email subject
	  *
	  * @param (array)String $subjectParameters 
	  * @param String $subject 
	  * @return void
	  * @access public
	  * 
	  */
	function setSubject($subject)
	{
		$this->_subject = html_entity_decode($subject);
	}
	
	/**
	  * Gets Email subject 
	  * @return String
	  * @access public
	  */
	function getSubject()
	{
		return $this->_subject;
	}
	
	/**
	  * Sets Email body
	  *
	  * @param String $body 
	  * @param String $bodyParameters 
	  * @return void
	  * @access public
	  * 
	  */
	function setBody($body)
	{
		$this->_body = html_entity_decode($body);
	}
	
	/**
	  * Gets Email body
	  * @return String
	  * @access public
	  */
	function getBody()
	{
		return $this->_body;
	}
	
	/**
	  * Sets Email footer
	  *
	  * @param String $footer 
	  * @return void
	  * @access public
	  * 
	  */
	function setFooter($footer)
	{
		$this->_footer = html_entity_decode($footer);
	}
	
	/**
	  * Gets Email footer
	  * @return String
	  * @access public
	  */
	function getFooter()
	{
		return $this->_footer;
	}
	
	/**
	  * Sets Email template
	  *
	  * @param String $template path (relative to FS) 
	  * @return boolean
	  * @access public
	  * 
	  */
	function setTemplate($template)
	{
		if (is_file($template)) {
			$this->_template = $template;
			return true;
		} else {
			$this->raiseError('Cannot get template file : '.$template);
			return false;
		}
	}
	
	/**
	  * Gets Email template (relative to FS)
	  * @return String
	  * @access public
	  */
	function getTemplate()
	{
		return $this->_template;
	}
	
	/**
	  * Sets Email recipient
	  *
	  * @param mixed $emailTo string or array of emails
	  * @return boolean
	  * @access public
	  */
	function setEmailTo($emailTo)
	{
		if (!is_array($emailTo)) {
			if (!sensitiveIO::isValidEmail($emailTo)) {
				//$this->raiseError('Invalid emailTo : '.$emailTo);
				return false;
			}
		} else {
			foreach ($emailTo as $email) {
				if (!sensitiveIO::isValidEmail($email)) {
					$this->raiseError('Invalid emailTo : '.$email);
					return false;
				}
			}
		}
		$this->_emailTo = $emailTo;
		return true;
	}
	
	/**
	  * Gets Email recipient
	  * @return String
	  * @access public
	  */
	function getEmailTo()
	{
		return $this->_emailTo;
	}
	
	/**
	  * Sets Email sender
	  *
	  * @param String $emailFrom 
	  * @return void
	  * @access public
	  * 
	  */
	function setEmailFrom($emailFrom = APPLICATION_POSTMASTER_EMAIL)
	{
		$this->_emailFrom = $emailFrom;
	}
	
	/**
	  * Gets Email encoding
	  * @return String
	  * @access public
	  */
	function getEmailEncoding()
	{
		return $this->_emailEncoding;
	}
	
	/**
	  * Sets the From Name of the mail
	  *
	  * @param string $from The from name to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setFromName($from)
	{
		$this->_fromName = $from;
		return true;
	}
	
	/**
	  * Sets the To Name of the mail
	  *
	  * @param string $to The to name to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setToName($to)
	{
		$this->_toName = $to;
		return true;
	}
	
	/**
	  * Sets Email encoding
	  *
	  * @param String $emailEncoding 
	  * @return void
	  * @access public
	  * 
	  */
	function setEmailEncoding($emailEncoding = APPLICATION_DEFAULT_ENCODING)
	{
		$this->_emailEncoding = $emailEncoding;
	}

	
	/**
	  * Gets Email HTML
	  * @return mixed (false if no html set, html string otherwise)
	  * @access public
	  */
	function getEmailHTML()
	{
		return $this->_emailHTML;
	}
	
	
	/**
	  * Sets Email HTML
	  *
	  * @param mixed $emailHTML : false if no html content set, html string otherwise
	  * @return void
	  * @access public
	  * 
	  */
	function setEmailHTML($emailHTML = false)
	{
		$this->_emailHTML = $emailHTML;
	}
	
	/**
	  * Gets Email sender
	  * @return String
	  * @access public
	  */
	function getEmailFrom()
	{
		return $this->_emailFrom;
	}
	
	/**
	  * Convert textBody to HTMLBody, convert all links and \n tags
	  *
	  * @param string $body The body to convert
	  * @return string, the body converted in html
	  * @access public
	  */
	function convertTextToHTML($body)
	{
		$HTMLBody = preg_replace(
				array(
					'/(?(?=<a[^>]*>.+<\/a>)
					(?:<a[^>]*>.+<\/a>)
					|
					([^="\']?)((?:https?|ftp|bf2|):\/\/[^<> \n\r]+)
					)/iex',
					'/<a([^>]*)target="?[^"\']+"?/i',
					'/<a([^>]+)>/i',
					'/(^|\s)(www.[^<> \n\r]+)/iex',
					'/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)
					(\\.[A-Za-z0-9-]+)*)/iex'
				),
				array(
					"stripslashes((strlen('\\2')>0?'\\1<a href=\"\\2\">\\2</a>\\3':'\\0'))",
					'<a\\1',
					'<a\\1 target="_blank">',
					"stripslashes((strlen('\\2')>0?'\\1<a href=\"http://\\2\">\\2</a>\\3':'\\0'))",
					"stripslashes((strlen('\\2')>0?'<a href=\"mailto:\\0\">\\0</a>':'\\0'))"
				),$body);
		return nl2br($HTMLBody);
	}
	
	/**
	  * Send the mail
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function sendEmail(){
		if ($this->hasError()) {
			$this->raiseError('Cannot send email, error appened');
			return false;
		}
		$emailSent = true;
		if (NO_APPLICATION_MAIL) {
			return $emailSent;
		}
		if (!$this->_emailTo) {
			$this->raiseError('emailTo can not be null');
			return false;
		}
		
		$OB="----=_OuterBoundary_000";
		$IB="----=_InnerBoundery_001";
		
		if ($this->_emailHTML) { //if HTML content is provided for email, use it
			//if this mail contain relative link, append default website address
			if (strpos($this->_emailHTML, 'href="/') !== false || strpos($this->_emailHTML, 'src="/') !== false) {
				$url = CMS_websitesCatalog::getMainURL();
				$this->_emailHTML = str_replace(array('href="/', 'src="/'), array('href="'.$url.'/', 'src="'.$url.'/'), $this->_emailHTML);
			}
			$Html = $this->_emailHTML;
		} elseif ($this->_template) { //else if template is provided for email HTML, use it
			$template = new CMS_file($this->_template);
			$templateContent = $template->getContent();
			$replace = array(
				'{{subject}}' 	=> $this->_subject,
				'{{body}}' 		=> $this->convertTextToHTML($this->_body),
				'{{footer}}' 	=> $this->convertTextToHTML($this->_footer),
				'{{href}}'		=> CMS_websitesCatalog::getMainURL(),
			);
			$Html = str_replace(array_keys($replace), $replace, $templateContent);
		} else { //else use text content converted to HTML
			$Html = $this->convertTextToHTML($this->_body.($this->_footer ? "\n\n".$this->_footer : ''));
		}
		$Text = $this->_body ? $this->_body.($this->_footer ? "\n\n".$this->_footer : '') : "Sorry, but you need an HTML compatible mailer to read this mail...";
		$From = ($this->_emailFrom) ? $this->_emailFrom : APPLICATION_POSTMASTER_EMAIL;
		$FromName = ($this->_fromName) ? $this->_fromName : '';
		$toUsers = (is_array($this->_emailTo) && $this->_emailTo) ? $this->_emailTo : array($this->_emailTo);
		$toNames = (is_array($this->_toName) && $this->_toName) ? $this->_toName : array($this->_toName);
		$Error = ($this->_error) ? $this->_error : '';
		$Subject = "[".APPLICATION_LABEL."] ".$this->_subject;
		$AttmFiles = $this->_files;
		$encoding = ($this->_emailEncoding) ? $this->_emailEncoding : APPLICATION_DEFAULT_ENCODING;
		
		//Messages start with text/html alternatives in OB
		$Msg ="This is a multi-part message in MIME format.\n";
		$Msg.="\n--".$OB."\n";
		
		$Msg.="Content-Type: multipart/alternative;\n\tboundary=\"".$IB."\"\n\n";
		
		//plaintext section 
		$Msg.="\n--".$IB."\n";
		$Msg.="Content-Type: text/plain;\n\tcharset=\"".$encoding."\"\n";
		$Msg.="Content-Transfer-Encoding: 8bit\n\n";
		// plaintext goes here
		$Msg.=$Text."\n\n";
		
		// html section 
		$Msg.="\n--".$IB."\n";
		$Msg.="Content-Type: text/html;\n\tcharset=\"".$encoding."\"\n";
		$Msg.="Content-Transfer-Encoding: base64\n\n";
		// html goes here 
		$Msg.=chunk_split(base64_encode($Html),76,"\n")."\n\n";
		
		// end of IB
		$Msg.="\n--".$IB."--\n";
		
		 // attachments
		if (is_array($AttmFiles) && $AttmFiles) {
			foreach($AttmFiles as $AttmFile){
				$patharray = explode ("/", $AttmFile); 
				$FileName=$patharray[count($patharray)-1];
				$Msg.= "\n--".$OB."\n";
				$Msg.="Content-Type: application/octet-stream;\n\tname=\"".$FileName."\"\n";
				$Msg.="Content-Transfer-Encoding: base64\n";
				$Msg.="Content-Disposition: attachment;\n\tfilename=\"".$FileName."\"\n\n";
				
				//file goes here
				$fd=fopen ($AttmFile, "r");
				$FileContent=fread($fd,filesize($AttmFile));
				fclose ($fd);
				$FileContent=chunk_split(base64_encode($FileContent),76,"\n");
				$Msg.=$FileContent;
				$Msg.="\n\n";
			}
		}
		if (LOG_SENDING_MAIL) {
			global $cms_user;
			$user = ($cms_user) ? $cms_user : CMS_profile_usersCatalog::getById(ROOT_PROFILEUSER_ID);
		}
		//message ends
		$Msg.="\n--".$OB."--\n";
		foreach ($toUsers as $key => $to) {
			if (sensitiveIO::isValidEmail($to)) {
				$headers ="MIME-Version: 1.0\n";
				if ($FromName) {
					$headers.="From: ".$this->EncodeHeader($FromName)." <".$From.">\n";
					$headers.="Reply-To: ".$this->EncodeHeader($FromName)." <".$From.">\n";
					$headers.="Return-Path: ".$this->EncodeHeader($FromName)." <".$From.">\n";
					$headers.="X-Sender: ".$this->EncodeHeader($FromName)." <".$From.">\n";
				} else {
					$headers.="From: ".$From."\n";
					$headers.="Reply-To: ".$From."\n";
					$headers.="Return-Path: ".$From."\n";
					$headers.="X-Sender: ".$From."\n";
				}
				if ($toNames[$key]) {
					$to = $this->EncodeHeader($toNames[$key])." <".$to.">"; 
				}
				if ($Error) {
					$headers.="Errors-To: ".$Error."\n";
				}
				
				$headers.="User-Agent: Automne (TM)\n";
				$headers.="X-Mailer: Automne (TM)\n";
				$headers.="X-Priority: 3\n";
				$headers.="Content-Type: multipart/mixed;\n\tboundary=\"".$OB."\"\n";
				//Check drop emails list (Automne default emails)
				if (!in_array($to, $this->_drop) && !in_array($From, $this->_drop)) {
					//send emails
					$sent = @mail($to,$this->EncodeHeader($Subject),$Msg,$headers);
					$emailSent = $emailSent && $sent;
					if (LOG_SENDING_MAIL) {
						$log = new CMS_log();
						$log->logMiscAction(CMS_log::LOG_ACTION_SEND_EMAIL, $user, 'Email To '.$to.', From : '.$From.', Subject : '.$Subject.', Sent : '.($sent ? 'Yes' : 'Error'));
					}
				} else {
					if (LOG_SENDING_MAIL) {
						$log = new CMS_log();
						$log->logMiscAction(CMS_log::LOG_ACTION_SEND_EMAIL, $user, 'Email To '.$to.', From : '.$From.', Subject : '.$Subject.', Sent : No, Dropped because sender or receiver address is under Automne drop address list');
					} else {
						$this->raiseError('Email to '.$to.', from : '.$From.' (subject : '.$Subject.'), Dropped because sender or receiver address is under Automne drop address list');
					}
				}
			} else {
				if (LOG_SENDING_MAIL) {
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_SEND_EMAIL, $user, 'Email To '.$to.', From : '.$From.', Subject : '.$Subject.', Sent : No, Dropped because receiver address is not valid');
				} else {
					$this->raiseError('Email to '.$to.', from : '.$From.' (subject : '.$Subject.'), Dropped because receiver address is not valid');
				}
			}
		}
		if (!$emailSent) {
			$this->raiseError('Email was not sent, please check your sendmail configuration or SMTP connection in php.ini');
		}
		return $emailSent;
	}
	
	/* Encode a header string to best of Q, B, quoted or none.
	 * @access private
	 * @return string
	 */
	function EncodeHeader ($str, $position = 'text') {
		$x = 0;
		switch (strtolower($position)) {
			case 'phrase':
				if (!preg_match('/[\200-\377]/', $str)) {
					/* Can't use addslashes as we don't know what value has magic_quotes_sybase. */
					$encoded = addcslashes($str, "\0..\37\177\\\"");
					if (($str == $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
						return ($encoded);
					} else {
						return ("\"$encoded\"");
					}
				}
				$x = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
			break;
			case 'comment':
				$x = preg_match_all('/[()"]/', $str, $matches);
			/* Fall-through */
			case 'text':
			default:
				$x += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
			break;
		}
		if ($x == 0) {
			return ($str);
		}
		$maxlen = 75 - 7 - strlen($this->_emailEncoding);
		/* Try to select the encoding which should produce the shortest output */
		if (strlen($str)/3 < $x) {
			$encoding = 'B';
			$encoded = base64_encode($str);
			$maxlen -= $maxlen % 4;
			$encoded = trim(chunk_split($encoded, $maxlen, "\n"));
		} else {
			$encoding = 'Q';
			$encoded = $this->EncodeQ($str, $position);
			//$encoded = $this->WrapText($encoded, $maxlen, true);
			$encoded = str_replace('='.$this->LE, "\n", trim($encoded));
		}
		
		$encoded = preg_replace('/^(.*)$/m', " =?".$this->_emailEncoding."?$encoding?\\1?=", $encoded);
		$encoded = trim(str_replace("\n", $this->LE, $encoded));
		
		return $encoded;
	}

	/** Encode string to quoted-printable.
	 * @access private
	 * @return string
	 */
	function EncodeQP ($str) {
		$encoded = $this->FixEOL($str);
		if (substr($encoded, -(strlen($this->LE))) != $this->LE) {
			$encoded .= $this->LE;
		}
		
		/* Replace every high ascii, control and = characters */
		$encoded = preg_replace('/([\000-\010\013\014\016-\037\075\177-\377])/e', "'='.sprintf('%02X', ord('\\1'))", $encoded);
		/* Replace every spaces and tabs when it's the last character on a line */
		$encoded = preg_replace("/([\011\040])".$this->LE."/e", "'='.sprintf('%02X', ord('\\1')).'".$this->LE."'", $encoded);
		
		/* Maximum line length of 76 characters before CRLF (74 + space + '=') */
		//$encoded = $this->WrapText($encoded, 74, true);
		
		return $encoded;
	}
	
	/** Encode string to q encoding.
	 * @access private
	 * @return string
	 */
	function EncodeQ ($str, $position = 'text') {
		/* There should not be any EOL in the string */
		$encoded = preg_replace("[\r\n]", '', $str);
		
		switch (strtolower($position)) {
				case 'phrase':
				$encoded = preg_replace("/([^A-Za-z0-9!*+\/ -])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
			break;
				case 'comment':
				$encoded = preg_replace("/([\(\)\"])/e", "'='.sprintf('%02X', ord('\\1'))", $encoded);
				case 'text':
				default:
				/* Replace every high ascii, control =, ? and _ characters */
				$encoded = preg_replace('/([\000-\011\013\014\016-\037\075\077\137\177-\377])/e',
			      "'='.sprintf('%02X', ord('\\1'))", $encoded);
			break;
		}
		
		/* Replace every spaces to _ (more readable than =20) */
		$encoded = str_replace(' ', '_', $encoded);
		
		return $encoded;
	}
	
	/* Changes every end of line from CR or LF to CRLF.
	 * @access private
	 * @return string
	 */
	function FixEOL($str) {
		$str = str_replace("\r\n", "\n", $str);
		$str = str_replace("\r", "\n", $str);
		$str = str_replace("\n", $this->LE, $str);
		return $str;
	}
}
?>