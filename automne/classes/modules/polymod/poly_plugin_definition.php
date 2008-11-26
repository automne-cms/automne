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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: poly_plugin_definition.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_poly_plugin_definitions
  * Represent a plugin definition for a poly_object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */


class CMS_poly_plugin_definitions extends CMS_grandFather
{
	/**
	  * Integer ID
	  * @var integer
	  * @access private
	  */
	protected $_ID;
	
	/**
	  * all values for object
	  * @var array	()
	  * @access private
	  */
	protected $_objectValues = array	("objectID"				=> 0,
	  							 "labelID" 				=> 0,
								 "descriptionID"		=> 0,
								 "query"				=> array(),
								 "definition"			=> '',
					 			 "definition"			=> '',
								 "compiledDefinition"	=> '',
					 			 );
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $id DB id
	  * @param array $dbValues DB values
	  * @return void
	  * @access public
	  */
	function __construct($id = 0, $dbValues=array())
	{
		$datas = array();
		if ($id && !$dbValues) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer : ".$id);
				return;
			}
			$sql = "
				select
					*
				from
					mod_object_plugin_definition
				where
					id_mowd='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$datas = $q->getArray();
			} else {
				$this->raiseError("Unknown ID :".$id);
				return;
			}
		} elseif (is_array($dbValues) && $dbValues) {
			$datas = $dbValues;
		}
		if (is_array($datas) && $datas) {
			$this->_ID = (int) $datas['id_mowd'];
			$this->_objectValues["objectID"] = (int) $datas['object_id_mowd'];
			$this->_objectValues["labelID"] = (int) $datas['label_id_mowd'];
			$this->_objectValues["descriptionID"] = (int) $datas['description_id_mowd'];
			$this->_objectValues["query"] = ($datas['query_mowd']) ? unserialize($datas['query_mowd']) : array();
			$this->_objectValues["definition"] = $datas['definition_mowd'];
			$this->_objectValues["compiledDefinition"] = $datas['compiled_definition_mowd'];
			//for compatibility with version < 0.97
			if ($this->_objectValues["definition"] && !$this->_objectValues["compiledDefinition"]) {
				$this->compileDefinition();
				$this->writeToPersistence();
			}
		}
	}
	
	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getID()
	{
		return $this->_ID;
	}
	
	/**
	  * Sets an object value.
	  *
	  * @param string $valueName the name of the value to set
	  * @param mixed $value the value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValue($valueName, $value)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->raiseError("Unknown valueName to set :".$valueName);
			return false;
		}
		if ($valueName == 'definition') {
			global $cms_language;
			//check definition parsing
			$parameters['object'] = new CMS_poly_object($this->getValue('objectID'));
			$parsing = new CMS_polymod_definition_parsing($value, $parameters, true, false, CMS_polymod_definition_parsing::CHECK_PARSING_MODE);
			$errors = $parsing->getParsingError();
			if ($errors) {
				return $errors;
			}
		}
		$this->_objectValues[$valueName] = $value;
		if ($valueName == 'definition') {
			$this->compileDefinition();
		}
		return true;
	}
	
	/**
	  * get an object value.
	  *
	  * @param string $valueName the name of the value to get
	  * @return mixed, the value
	  * @access public
	  */
	function getValue($valueName)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->raiseError("Unknown valueName to get :".$valueName);
			return false;
		}
		return $this->_objectValues[$valueName];
	}
	
	/**
	  * get object label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getLabel($language = '') {
		$label = new CMS_object_i18nm($this->getValue("labelID"));
		if (is_a($language, "CMS_language")) {
			return $label->getValue($language->getCode());
		} else {
			return $label->getValue($language);
		}
	}
	
	/**
	  * get object description
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for description
	  * @return string, the description
	  * @access public
	  */
	function getDescription($language) {
		$description = new CMS_object_i18nm($this->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			return $description->getValue($language->getCode());
		} else {
			return $description->getValue($language);
		}
	}
	
	/**
	  * is this plugin need a selection
	  *
	  * @return boolean
	  * @access public
	  */
	function needSelection() {
		if (strpos($this->getValue('definition'), '{plugin:selection}') !== false) {
			return true;
		}
		return false;
	}
	
	/**
	  * Compile the Plugin definition
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function compileDefinition() {
		$parameters = array();
		$parameters['module'] = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'));
		$parameters['objectID'] = $this->getValue('objectID');
		$definitionParsing = new CMS_polymod_definition_parsing($this->_objectValues['definition'], true, CMS_polymod_definition_parsing::PARSE_MODE);
		$compiledDefinition = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_PHP, $parameters);
		$this->_objectValues['compiledDefinition'] = $compiledDefinition;
		return true;
	}
	
	/**
	  * Writes object into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		//save data
		$sql_fields = "
			object_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["objectID"])."',
			label_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["labelID"])."',
			description_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["descriptionID"])."',
			query_mowd='".SensitiveIO::sanitizeSQLString(serialize($this->_objectValues["query"]))."',
			definition_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["definition"])."',
			compiled_definition_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["compiledDefinition"])."'
		";
		/*
		$sql_fields = "
			object_id_mowd = :object,
			label_id_mowd = :label,
			description_id_mowd = :desc,
			query_mowd = :query,
			definition_mowd = :definition,
			compiled_definition_mowd = :compiled
		";
		$parameters = array(
			':object' 				=> $this->_objectValues["objectID"],
			':label' 				=> $this->_objectValues["labelID"],
			':desc' 				=> $this->_objectValues["descriptionID"],
			':query' 				=> serialize($this->_objectValues["query"]),
			':definition' 			=> $this->_objectValues["definition"],
			':compiled' 			=> $this->_objectValues["compiledDefinition"],
		);*/
		if ($this->_ID) {
			$sql = "
				update
					mod_object_plugin_definition
				set
					".$sql_fields."
				where
					id_mowd='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					mod_object_plugin_definition
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		//$q->executePreparedQuery($sql, $parameters);
		if ($q->hasError()) {
			$this->raiseError("Can't save object");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}
		//unset all SESSIONS values
		unset($_SESSION["polyModule"]);
		return true;
	}
	
	/**
	  * Destroy this object in DB
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function destroy() {
		if ($this->_ID) {
			//first delete definition
			$sql = "
				delete from
					mod_object_plugin_definition
				where
					id_mowd = '".$this->_ID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->raiseError("Can't delete datas of table mod_object_polyobjects for object : ".$this->_ID);
				return false;
			}
			
			//second delete object label and description
			if (sensitiveIO::IsPositiveInteger($this->getValue("labelID"))) {
				$label = new CMS_object_i18nm($this->getValue("labelID"));
				$label->destroy();
			}
			if (sensitiveIO::IsPositiveInteger($this->getValue("descriptionID"))) {
				$description = new CMS_object_i18nm($this->getValue("labelID"));
				$description->destroy();
			}
		}
		unset($this);
		return true;
	}
	
}
?>