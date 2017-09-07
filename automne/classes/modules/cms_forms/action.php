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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: action.php,v 1.3 2010/03/08 16:43:26 sebastien Exp $

/**
  * Class CMS_forms_action
  * 
  * Represents an action attributed to a formular.
  * Content of formular can be send by email, stored into a file, and user 
  * redirectied to given URL, etc.
  * In any case form values are always recorded in database.
  * 
  * Some predefined types are determined :
  *   - db						(Only one expected)
  *   - formnok					(Only one expected)
  *   - formok					(Only one expected)
  *   - email 					(Many of them accepted)
  *   - emailfield 				(Many of them accepted)
  *   - auth 					(Only one expected)
  * 
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_forms_action extends CMS_superResource
{
	/**
	 * Form destination type : action if form is already folded
	 */
	const ACTION_ALREADY_FOLD = 0;
	
	/**
	 * Form destination type : action if form validation is not OK
	 */
	const ACTION_FORMNOK = 1;
	
	/**
	 * Form destination type : File (Stores content of a form in database)
	 */
	const ACTION_DB = 2;
	
	/**
	 * Form destination type : Email (Send form results to email(s))
	 */
	const ACTION_EMAIL = 3;
	
	/**
	 * Form destination type : Email (Send form results to email(s) in given field)
	 */
	const ACTION_FIELDEMAIL = 4;
	
	/**
	 * Form destination type : Authenticate user
	 */
	const ACTION_AUTH = 5;
	
	/**
	 * Execute specific PHP code
	 */
	const ACTION_SPECIFIC_PHP = 6;
	
	/**
	 * Form destination type : action if form validation is OK
	 * (high id because it must be the last action done)
	 */
	const ACTION_FORMOK = 99;

	const MESSAGE_CMS_FORMS_ACTION_ALREADY_FOLD = 52;
	const MESSAGE_CMS_FORMS_ACTION_DB = 39;
	const MESSAGE_CMS_FORMS_ACTION_FORMNOK = 40;
	const MESSAGE_CMS_FORMS_ACTION_FORMOK = 41;
	const MESSAGE_CMS_FORMS_ACTION_EMAIL = 42;
	const MESSAGE_CMS_FORMS_ACTION_FIELDEMAIL = 43;
	const MESSAGE_CMS_FORMS_ACTION_AUTH = 75;
	const MESSAGE_CMS_FORMS_ACTION_SPECIFIC_PHP = 94;
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_ID;
	
	/**
	  * Class Name for errors display
	  * @var string
	  * @access private
	  */
	protected $_className;
	
	/**
	  * Table name for sql queries 
	  * if class use resource, Table name must be without _edited, _deleted or _public, only the prefix
	  * @var string
	  * @access private
	  */
	protected $_tableName = 	'mod_cms_forms_actions';
	
	/**
	  * Columns name suffix
	  * @var string
	  * @access private
	  */
	protected $_tableSufix =	'_act';
	
	/**
	  * the module codename
	  * @var string
	  * @access private
	  */
	protected $_moduleCodename ='cms_forms';
	
	/**
	  * Table(s) fieldname and type
	  * /!\ MUST BE IN THE SAME ORDER OF DATABASE COLUMNS /!\
	  * @var multidimentional array (fieldname => array (field_type, field_default_value))
	  *  - fieldname is the database columns name WITHOUT SUFFIX
	  *  - fieldtype can be : 
	  *		resource : internal useage, Automne Resource.
	  *		string : use with getString and setString
	  *		html : use with getString and setString
	  *		email : use with getString and setString
	  *		integer : use with getInteger and setInteger
	  *		positiveInteger : use with getInteger and setInteger
	  *		boolean : use with getBoolean and SetBoolean
	  *		date : use with getTheDate and setDate. Create a CMS_date object. Default value can be used to launch a method of the object.
	  *		image : use with getImagePath and setImage
	  *		file : use with getFilePath and setFile
	  *		order : use with getOrder, setOrder, getOrderMax, moveUp, moveDown, moveTo
	  *		internalLink : use with getLinkType, getLink, setLink 	/!\ fieldname must be internalSomething /!\
	  *		externalLink : use with getLinkType, getLink, setLink 	/!\ fieldname must be externalSomething /!\
	  *		linkType : use with getLinkType, getLink, setLink 		/!\ fieldname must be somethingType 	/!\
	  *		CMS_className : use with getObject and setObject. Default value can be used to launch a method of the object.
	  *  - fielvalue is the default value
	  * @access private
	  */
	  
	protected $_tableData = array(
							'form' 			=> array("integer"	,""),
							'value' 		=> array("string"	,""),
							'type'			=> array("integer"	,""),
							'text'			=> array("html"		,""),
							);
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @param integer $id
	 * @return void 
	 */
	function __construct($id = 0) {
		//set class name
		$this->_className = get_class($this);
		//initialize super-class
		parent::__construct($id);
	}
	
	/**
	 * Returns an array of all CMS_forms_action associated to a given formular ID and ordered by type
	 */
	function getAll($formularID = false, $returnObject = false, $actionType = false) {
		$items = array();
		$type = ($actionType) ? " and type_act='".$actionType."'":'';
		$sql = "
			select
				id_act as id
			from
				mod_cms_forms_actions
			where
				form_act='".$formularID."'
				".$type."
			order by
				type_act asc
		";
		$q = new CMS_query($sql);
		while ($data  = $q->getArray()) {
			if ($returnObject) {
				$items[$data['id']] = new CMS_forms_action($data['id']);
			} else {
				$items[$data['id']] = $data['id'];
			}
		}
		return $items;
	}
	
	/**
	  * Gets the array of all the type of destinations for a formular
	  *
	  * @return array(integer=>integer) All the destination types indexed by their message DB ID
	  * @access public
	  * @static
	  */
	static function getAllTypes()
	{
		return array(
			self::ACTION_ALREADY_FOLD	=> self::MESSAGE_CMS_FORMS_ACTION_ALREADY_FOLD,
			self::ACTION_DB				=> self::MESSAGE_CMS_FORMS_ACTION_DB,
			self::ACTION_FORMNOK		=> self::MESSAGE_CMS_FORMS_ACTION_FORMNOK,
			self::ACTION_FORMOK			=> self::MESSAGE_CMS_FORMS_ACTION_FORMOK,
			self::ACTION_EMAIL			=> self::MESSAGE_CMS_FORMS_ACTION_EMAIL,
			self::ACTION_FIELDEMAIL		=> self::MESSAGE_CMS_FORMS_ACTION_FIELDEMAIL,
			self::ACTION_AUTH			=> self::MESSAGE_CMS_FORMS_ACTION_AUTH,
			self::ACTION_SPECIFIC_PHP	=> self::MESSAGE_CMS_FORMS_ACTION_SPECIFIC_PHP,
		);
	}
}
?>