<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: sender.php,v 1.6 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_sender
  * 
  * Represents any user's browser and session infos that have
  * submited one formular
  * Foreach formular, a new sender is created, even if user's datas
  * where recorder once (Session changes)
  * 
  * @package Automne
  * @subpackage cms_forms
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_sender extends CMS_grandFather {

	/**
	 * Unique db ID
	 * @var integer
	 * @access private
	 */
	protected $_senderID;
	
	/**
	 * CMS_profile_user ID got from context if exists
	 * @var integer
	 * @access private
	 */
	protected $_userID;
	
	/**
	 * Client IP address (value of $_SERVER["REMOTE_ADDR"])
	 * 
	 * @var string
	 * @access private
	 */
	protected $_clientIP;

	/**
	 * Languages (value of $_SERVER["HTTP_ACCEPT_LANGUAGE"])
	 * @var CMS_language
	 * @access private
	 */
	protected $_languages;
	
	/**
	 * Browser (value of $_SERVER["HTTP_USER_AGENT"])
	 * 
	 * @var string
	 * @access private
	 */
	protected $_userAgent;
	
	/**
	 * Session ID (value of session_id())
	 * @var string
	 * @access private
	 */
	protected $_sessionID;
	
	/**
	 * Date sender submited its form
	 * @var CMS_date
	 * @access private
	 */
	protected $_dateInserted;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param integer $id
	 * @return void 
	 */
	function __construct($id = 0) {
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					mod_cms_forms_senders
				where
					id_snd='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_senderID = $id;
				$this->_userID = $data["userID_snd"];
				$this->_clientIP = $data["clientIP_snd"];
				$this->_sessionID = $data["sessionID_snd"];
				$this->_languages= $data["languages_snd"];
				$this->_userAgent = $data["userAgent_snd"];
				if ($data["dateInserted_snd"] != '') {
					$this->_dateInserted = new CMS_date(date("m-d-Y H:m:s", $data["dateInserted_snd"]));
				}
			} else {
				$this->setError("Unknown ID :".$id);
			}
		} else {
			$this->_dateInserted = new CMS_date();
			$this->_dateInserted->setNow();
		}
	}
	
	/**
	  * Getter for the ID
	 * @access public
	 * @return integer
	 */
	function getID() {
		return $this->_senderID;
	}
	
	/**
	 * Getter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name
	 * @return string
	 */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	 * Setter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name name of attribute to set
	 * @param $value , the value to give
	 */
	function setAttribute($name, $value) {
		$name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	  * Writes the news into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			languages_snd='".SensitiveIO::sanitizeSQLString($this->_languages)."',
			userID_snd='".SensitiveIO::sanitizeSQLString($this->_userID)."',
			clientIP_snd='".SensitiveIO::sanitizeSQLString($this->_clientIP)."',
			sessionID_snd='".SensitiveIO::sanitizeSQLString($this->_sessionID)."',
			userAgent_snd='".SensitiveIO::sanitizeSQLString($this->_userAgent)."'";
		// Date
		if (is_a($this->_dateInserted, 'CMS_date')) {
			$sql_fields .= ",
			dateInserted_snd='".$this->_dateInserted->getDBValue()."'";
		}
		if ($this->_senderID) {
			$sql = "
				update
					mod_cms_forms_senders
				set
					".$sql_fields."
				where
					id_snd='".$this->_senderID."'
			";
		} else {
			$sql = "
				insert into
					mod_cms_forms_senders
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->setError("Failed to write");
			return false;
		} elseif (!$this->_senderID) {
			$this->_senderID = $q->getLastInsertedID();
		}
		return true;
	}
	
	/**
	 * Factory, instanciate a sender from current context
	 * 
	 * @return CMS_forms_sender 
	 */
	public static function getSenderForContext() {
		//sender does not exists in DB so create a new one*/
		$obj = new CMS_forms_sender();
		$obj->setAttribute('sessionID', Zend_Session::getId());
		if (io::isPositiveInteger(CMS_session::getUserID())) {
			$obj->setAttribute('userID', CMS_session::getUserID());
		}
		$obj->setAttribute('clientIP', @$_SERVER["REMOTE_ADDR"]);
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
			$obj->setAttribute('languages', @$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		}
		$obj->setAttribute('userAgent', @$_SERVER["HTTP_USER_AGENT"]);
		return $obj;
	}
	
	function getNumberOfresponseForForm($formID) {
		
	}
}
?>