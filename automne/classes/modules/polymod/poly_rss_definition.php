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
// $Id: poly_rss_definition.php,v 1.3 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_poly_rss_definitions
  * Represent an RSS definition for an object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_rss_definitions extends CMS_grandFather
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
								 "link"					=> '',
								 "author"				=> '',
								 "copyright"			=> '',
								 "categories"			=> '',
								 "ttl"					=> 1440,
								 "email"				=> '',
								 "definition"			=> '',
					 			 "compiledDefinition"	=> '',
					 			 "lastCompilation"		=> '',
								 "uuid"					=> '',
								 "namespaces"			=> '',
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
	public function __construct($id = 0, $dbValues=array())
	{
		$datas = array();
		if ($id && !$dbValues) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer : ".$id);
				return;
			}
			$sql = "
				select
					*
				from
					mod_object_rss_definition
				where
					id_mord='".$id."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$datas = $q->getArray();
			} else {
				$this->setError("Unknown ID :".$id);
				return;
			}
		} elseif (is_array($dbValues) && $dbValues) {
			$datas = $dbValues;
		}
		if (is_array($datas) && $datas) {
			$this->_ID = (int) $datas['id_mord'];
			$this->_objectValues["objectID"] = (int) $datas['object_id_mord'];
			$this->_objectValues["labelID"] = (int) $datas['label_id_mord'];
			$this->_objectValues["descriptionID"] = (int) $datas['description_id_mord'];
			$this->_objectValues["link"] = $datas['link_mord'];
			$this->_objectValues["author"] = $datas['author_mord'];
			$this->_objectValues["copyright"] = $datas['copyright_mord'];
			$this->_objectValues["namespaces"] = $datas['namespaces_mord'];
			$this->_objectValues["categories"] = $datas['categories_mord'];
			$this->_objectValues["ttl"] = (int) $datas['ttl_mord'];
			$this->_objectValues["email"] = $datas['email_mord'];
			$this->_objectValues["definition"] = $datas['definition_mord'];
			$this->_objectValues["compiledDefinition"] = $datas['compiled_definition_mord'];
			$this->_objectValues["lastCompilation"] = new CMS_date();
			$this->_objectValues["lastCompilation"]->setFromDBValue($datas['last_compilation_mord']);
			$this->_objectValues["uuid"] = isset($datas['uuid_mord']) ? $datas['uuid_mord'] : '';
		} else {
			$this->_objectValues["lastCompilation"] = new CMS_date();
		}

		//check for last compilation date (recompile Feed each day)
		if ($this->_objectValues["compiledDefinition"]) {
			$lastCompilation = $this->_objectValues["lastCompilation"];
			$lastCompilation->moveDate('+1 day');
			$today = new CMS_date();
			$today->setNow();
			if (CMS_date::compare($today, $lastCompilation, '>')) {
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
	public function getID()
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
	public function setValue($valueName, $value)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->setError("Unknown valueName to set :".$valueName);
			return false;
		}
		if ($valueName == 'uuid') {
			$this->setError("Cannot change UUID");
			return false;
		}
		if ($valueName == 'definition') {
			global $cms_language;
			//check definition parsing
			$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'));
			$parsing = new CMS_polymod_definition_parsing($value, true, CMS_polymod_definition_parsing::CHECK_PARSING_MODE, $module);
			$errors = $parsing->getParsingError();
			if ($errors) {
				return $errors;
			}
		} elseif ($valueName == 'email') {
			if (!sensitiveIO::isValidEmail($value)) {
				$this->setError("Email value must be a valid email :".$value);
				return false;
			}
		} elseif ($valueName == 'link') {
			if ($value && io::substr($value, 0, 4) != "http") {
				$value = strip_tags('http://'.$value);
			}
		} else {
			$value = strip_tags(trim($value));
		}
		$this->_objectValues[$valueName] = $value;
		if ($valueName == 'definition') {
			$this->compileDefinition();
		}
		return true;
	}

	/**
	  * Compile the RSS definition
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function compileDefinition() {
		$parameters = array();
		$parameters['module'] = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'));
		$parameters['objectID'] = $this->getValue('objectID');
		$parameters['public'] = true;
		$definitionParsing = new CMS_polymod_definition_parsing($this->_objectValues['definition'], true, CMS_polymod_definition_parsing::PARSE_MODE, $parameters['module']);
		$compiledDefinition = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_PHP, $parameters);
		$this->_objectValues['compiledDefinition'] = $compiledDefinition;
		$date = new CMS_date();
		$date->setNow();
		$this->_objectValues['lastCompilation'] = $date;
		return true;
	}

	/**
	  * get an object value.
	  *
	  * @param string $valueName the name of the value to get
	  * @return mixed, the value
	  * @access public
	  */
	public function getValue($valueName)
	{
		if (!in_array($valueName,array_keys($this->_objectValues))) {
			$this->setError("Unknown valueName to get :".$valueName);
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
	public function getLabel($language = '') {
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
	public function getDescription($language) {
		$description = new CMS_object_i18nm($this->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			return $description->getValue($language->getCode());
		} else {
			return $description->getValue($language);
		}
	}

	/**
	  * Writes object into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence()
	{
		if (!$this->_objectValues["uuid"]) {
			$this->_objectValues["uuid"] = io::uuid();
		}
		//save data
		$sql_fields = "
			object_id_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["objectID"])."',
			label_id_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["labelID"])."',
			description_id_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["descriptionID"])."',
			link_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["link"])."',
			author_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["author"])."',
			copyright_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["copyright"])."',
			namespaces_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["namespaces"])."',
			categories_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["categories"])."',
			ttl_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["ttl"])."',
			email_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["email"])."',
			definition_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["definition"])."',
			compiled_definition_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["compiledDefinition"])."',
			last_compilation_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["lastCompilation"]->getDBValue())."',
			uuid_mord='".SensitiveIO::sanitizeSQLString($this->_objectValues["uuid"] ? $this->_objectValues["uuid"] : io::uuid())."'
		";
		if ($this->_ID) {
			$sql = "
				update
					mod_object_rss_definition
				set
					".$sql_fields."
				where
					id_mord='".$this->_ID."'
			";
		} else {
			$sql = "
				insert into
					mod_object_rss_definition
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->setError("Can't save object");
			return false;
		} elseif (!$this->_ID) {
			$this->_ID = $q->getLastInsertedID();
		}

		//Clear polymod cache
		//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'))));
		CMS_cache::clearTypeCache('polymod');

		//unset polymod structure in cache
		CMS_cache::clearTypeCache('atm-polymod-structure');
		return true;
	}

	/**
	  * Destroy this object in DB
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function destroy() {
		if ($this->_ID) {
			//first delete definition
			$sql = "
				delete from
					mod_object_rss_definition
				where
					id_mord = '".$this->_ID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->setError("Can't delete datas of table mod_object_polyobjects for object : ".$this->_ID);
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
			//CMS_cache::clearTypeCacheByMetas('polymod', array('module' => CMS_poly_object_catalog::getModuleCodenameForObjectType($this->getValue('objectID'))));
			CMS_cache::clearTypeCache('polymod');

			//unset polymod structure in cache
			CMS_cache::clearTypeCache('atm-polymod-structure');
		}
		$this->__destroy();
		return true;
	}

	/**
	  * Get rss object as an array structure used for export
	  *
	  * @param array $params The export parameters. Not used here
	  * @param array $files The reference to the found files used by object
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
				'link'				=> $this->getValue('link'),
				'author'			=> $this->getValue('author'),
				'copyright'			=> $this->getValue('copyright'),
				'namespaces'			=> $this->getValue('namespaces'),
				'categories'		=> $this->getValue('categories'),
				'ttl'				=> $this->getValue('ttl'),
				'email'				=> $this->getValue('email'),
				'definition'		=> $this->getValue('definition')
			)
		);
		if ($aClass['params']['definition']) {
			$aClass['params']['definition'] = $module->convertDefinitionString($aClass['params']['definition'], true);
		}
		return $aClass;
	}

	/**
	  * Import rss feed from given array datas
	  *
	  * @param array $data The rss feed datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				module	=> false|true : the module to create rss feed (required)
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
	public function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		if (!isset($params['module'])) {
			$infos .= 'Error : missing module codename for rss feed importation ...'."\n";
			return false;
		}
		$module = CMS_modulesCatalog::getByCodename($params['module']);
		if ($module->hasError()) {
			$infos .= 'Error : invalid module for rss feed importation : '.$params['module']."\n";
			return false;
		}
		if (!$this->getID() && CMS_poly_object_catalog::rssUuidExists($data['uuid'])) {
			//check imported uuid. If rss does not have an Id, the uuid must be unique or must be regenerated
			$uuid = io::uuid();
			//store old uuid relation
			$idsRelation['rss-uuid'][$data['uuid']] = $uuid;
			$data['uuid'] = $uuid;
		}
		//set object uuid if not exists
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
		if (isset($data['params']['link'])) {
			$this->setValue("link", $data['params']['link']);
		}
		if (isset($data['params']['author'])) {
			$this->setValue("author", $data['params']['author']);
		}
		if (isset($data['params']['copyright'])) {
			$this->setValue("copyright", $data['params']['copyright']);
		}
		if (isset($data['params']['namespaces'])) {
			$this->setValue("namespaces", $data['params']['namespaces']);
		}
		if (isset($data['params']['categories'])) {
			$this->setValue("categories", $data['params']['categories']);
		}
		if (isset($data['params']['ttl'])) {
			$this->setValue("ttl", $data['params']['ttl']);
		}
		if (isset($data['params']['email'])) {
			$this->setValue("email", $data['params']['email']);
		}
		if (isset($data['params']['definition'])) {
			//do not use set value for this because it try to compile definition and fail
			//$this->setValue("definition", $module->convertDefinitionString($data['params']['definition'], false));
			$this->_objectValues['definition'] = $module->convertDefinitionString($data['params']['definition'], false);
		}

		//write object
		if (!$this->writeToPersistence()) {
			$infos .= 'Error : can not write object ...'."\n";
			return false;
		}
		//if current object id has changed from imported id, set relation
		if (isset($data['id']) && $data['id'] && $this->getID() != $data['id']) {
			$idsRelation['rss'][$data['id']] = $this->getID();
		}
		//set this object into definition to convert array so it can be converted again at end of import process
		$idsRelation['definitionToConvert'][] = $this;
		return true;
	}

	/**
	  * Convert all definitions used by this object from human format to Automne format.
	  * This method is usually used at end of module import process, when all objects are imported
	  *
	  * @param CMS_module $module The current object module
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	public function convertDefinitions($module) {
		$this->setValue("definition", $module->convertDefinitionString($this->_objectValues['definition'], false, true));
		return $this->writeToPersistence();
	}

	public static function exists($id) {
		if (!SensitiveIO::isPositiveInteger($id)) {
			return false;
		}
		$sql = 'SELECT count(*) as c from mod_object_rss_definition where id_mord = "'.$id.'"';
		$query = new CMS_query($sql);
		$res = $query->getAll();
		return $res[0]['c'] > 0;
	}
}
?>