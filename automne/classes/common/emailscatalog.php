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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: emailscatalog.php,v 1.2 2009/03/02 11:28:06 sebastien Exp $

/**
  * Class CMS_emailsCatalog
  *
  * Class to send group emails
  *
  * @package CMS
  * @subpackage common
  * @author Andre Haynes <andre.haynes@ws-interactive.fr>
  */

class CMS_emailsCatalog extends CMS_grandFather
{
	const MESSAGE_EMAIL_BODY_URLS = 912;
	
	/**
	  *
	  * @vare array(CMS_email)
	  * @access private
	  */
	protected $_messages = array();
	
	/**
	  * @param array(CMS_users) $users users to send message to
	  * @param array(CMS_profile_user) $users
	  * @param array($language=>$subject) $messages indexed by languages code
	  * @param array($language=>$subject) $subjects indexed by languages code
	  * @param integer $alertLevel
	  * @return void
	  * @access public
	  */
	function setUserMessages($users, $messages, $subjects, $alertLevel = ALERT_LEVEL_VALIDATION, $module = MOD_STANDARD_CODENAME) {
		$mainURL = CMS_websitesCatalog::getMainURL();
		$template = (is_file(PATH_MAIL_TEMPLATES_FS)) ? PATH_MAIL_TEMPLATES_FS : '';
		foreach ($users as $user) {
			//if is integer create user object
			if (!is_a($user,"CMS_user_profile") && SensitiveIO::isPositiveInteger($user)) {
			    $user = CMS_profile_usersCatalog::getByID($user);
			}
			//if user hasn't alert level for this module, skip it
			if (!$user->hasAlertLevel($alertLevel, $module)) {
				//CMS_grandFather::raiseError('user '.$user->getFullName().' has no alerts for level '.$alertLevel.' for module '.$module);
				continue;
			}
			$userLang = $user->getLanguage();
			$email = new CMS_email();
			if ($user->getEmail()) {
				if ($email->setEmailTo($user->getEmail())) {
					$email->setSubject($subjects[$userLang->getCode()]);
					$email->setBody($messages[$userLang->getCode()]);
					$email->setFooter($userLang->getMessage(self::MESSAGE_EMAIL_BODY_URLS, array(APPLICATION_LABEL, $mainURL."/", $mainURL.PATH_ADMIN_WR."/")));
					$email->setTemplate($template);
					$this->_messages[] = $email;
				} else {
					$this->raiseError("Email Catalog: email invalid (".$user->getEmail().") for user : ".$user->getFullName());
				}
			}
		}
	}
	
	/**
	  * @param array(string) addresses to send message to
	  * @param message string
	  * @param messageParam array(string)
	  * @param message subject
	  * @param message subjParam
	  * @return void
	  * @access public
	  */
	function CMS_setMessages($addresses, $message, $subject) {
		// loop through addresses and create email message
		foreach ($addresses as $address) {
			$email = new CMS_email();
			if ($email->setEmailTo($address)) {
				$email->setSubject($subject);
				$email->setBody($message);
				$this->_messages[] = $email;
			} else {
				$this->raiseError("Email Catalog: mail not registered:".$address);
			}
		}
	}
	
	/**
	  * Send emails
	  * @return void
	  * @access public
	  */
	function sendMessages() {
		foreach($this->_messages as $message) {
			$message->sendEmail();
		}
	}
}
?>