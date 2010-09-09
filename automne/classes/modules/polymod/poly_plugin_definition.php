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
// $Id: poly_plugin_definition.php,v 1.3 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_poly_plugin_definitions
  * Represent a plugin definition for a poly_object
  *
  * @package Automne
  * @subpackage polymod
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
	protected $_objectValues = array("objectID"				=> 0,
	  							 "labelID" 				=> 0,
								 "descriptionID"		=> 0,
								 "query"				=> array(),
								 "definition"			=> '',
					 			 "compiledDefinition"	=> '',
					 			 "uuid"					=> '',
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
			$this->_objectValues["uuid"]			= isset($datas['uuid_mowd']) ? $datas['uuid_mowd'] : '';
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
		if ($valueName == 'uuid') {
			$this->raiseError("Cannot change UUID");
			return false;
		}
		if ($valueName == 'definition') {
			global $cms_language;
			//check definition parsing
			$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'));
			$parsing = new CMS_polymod_definition_parsing($value, true, CMS_polymod_definition_parsing::CHECK_PARSING_MODE, $module);
			//$parsing = new CMS_polymod_definition_parsing($value, $parameters, true, false, CMS_polymod_definition_parsing::CHECK_PARSING_MODE);
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
		if (io::strpos($this->getValue('definition'), '{plugin:selection}') !== false) {
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
		if (!$this->_objectValues["uuid"]) {
			$this->_objectValues["uuid"] = io::uuid();
		}
		//save data
		$sql_fields = "
			object_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["objectID"])."',
			label_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["labelID"])."',
			description_id_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["descriptionID"])."',
			query_mowd='".SensitiveIO::sanitizeSQLString(serialize($this->_objectValues["query"]))."',
			definition_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["definition"])."',
			compiled_definition_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["compiledDefinition"])."',
			uuid_mowd='".SensitiveIO::sanitizeSQLString($this->_objectValues["uuid"])."'
		";
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
		if ($q->hasError()) {
			$this->raiseError("Can't save object");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}
		
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('module' => CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'))));
		
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
			//Clear polymod cache
			CMS_cache::clearTypeCacheByMetas('polymod', array('module' => CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'))));
			//unset all SESSIONS values
			unset($_SESSION["polyModule"]);
		}
		unset($this);
		return true;
	}
	
	/**
	  * Get rss object as an array structure used for export
	  *
	  * @param array $params The export parameters. Not used here
	  * @param array $files The reference to the founded files used by object
	  * @return array : the object array structure
	  * @access public
	  */
	public function asArray($params = array(), &$files) {
		$module = CMS_modulesCatalog::getByCodename(CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID')));
		$aClass = array(
			'id'			=> $this->getID(),
			'uuid'			=> $this->getValue('uuid'),
			'labels'		=> CMS_object_i18nm::getValues($this->getValue('labelID')),
			'descriptions'	=> CMS_object_i18nm::getValues($this->getValue('descriptionID')),
			'objectID'		=> $this->getValue('objectID'),
			'params'		=> array(
				'query'				=> $this->getValue('query'),
				'definition'		=> $this->getValue('definition')
			)
		);
		if ($aClass['params']['definition']) {
			$aClass['params']['definition'] = $module->convertDefinitionString($aClass['params']['definition'], true);
		}
		return $aClass;
	}
	
	/**
	  * Import plugin from given array datas
	  *
	  * @param array $data The plugin datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				module	=> false|true : the module to create plugin (required)
	  *				create	=> false|true : create missing objects (default : true)
	  *				update	=> false|true : update existing objects (default : true)
	  *				files	=> false|true : use files from PATH_TMP_FS (default : true)
	  *			)
	  * @param CMS_language $cms_language The CMS_langage to use
	  * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	  * @param string $infos : Reference : The import infos returned
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for rss feed importation ...'."\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for rss feed importation : '.$params['module']."\n";
			return false;
		}
		if (!$this->getID() && CMS_poly_object_catalog::pluginUuidExists($data['uuid'])) {
			//check imported uuid. If plugin does not have an Id, the uuid must be unique or must be regenerated
			$uuid = io::uuid();
			//store old uuid relation
			$idsRelation['plugins-uuid'][$data['uuid']] = $uuid;
			$data['uuid'] = $uuid;
		}
		//set plugin uuid if not exists
		if (!$this->_objectValues["uuid"]) {
			$this->_objectValues["uuid"] = $data['uuid'];
		}
		if (isset($data['labels'])) {
			$label = new CMS_object_i18nm($this->getValue("labelID"));
			$label->setValues($data['labels']);
			$label->writeToPersistence();
			$this->setValue("labelID", $label->getID());
		}
		if (isset($data['descriptions'])) {
			$description = new CMS_object_i18nm($this->getValue("descriptionID"));
			$description->setValues($data['descriptions']);
			$description->writeToPersistence();
			$this->setValue("descriptionID", $description->getID());
		}
		//if current object id has changed from imported id, set relation
		if (isset($idsRelation['objects'][$data['objectID']]) && $idsRelation['objects'][$data['objectID']]) {
			$this->setValue("objectID", $idsRelation['objects'][$data['objectID']]);
		} else {
			$this->setValue("objectID", $data['objectID']);
		}
		//values
		if (isset($data['params']['query'])) {
			//translate ids if needed
			$query = array();
			foreach ($data['params']['query'] as $objectId => $value) {
				if (isset($idsRelation['objects'][$objectId])) {
					//object exists with a translated id
					$query[$idsRelation['objects'][$objectId]] = $value;
				} else {
					$query[$objectId] = $value;
				}
			}
			$this->setValue("query", $query);
		}
		if (isset($data['params']['definition'])) {
			$this->setValue("definition", $module->convertDefinitionString($data['params']['definition'], false));
		}
		
		//write object
		if (!$this->writeToPersistence()) {
			$infos .= 'Error : can not write object ...'."\n";
			return false;
		}
		//if current object id has changed from imported id, set relation
		if (isset($data['id']) && $data['id'] && $this->getID() != $data['id']) {
			$idsRelation['plugins'][$data['id']] = $this->getID();
		}
		return true;
	}
}
?>