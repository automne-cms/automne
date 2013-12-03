<?php
/**
  * Class CMS_polymod_oembed_definition
  * Represent an Oembed definition for an object
  *
  */

class CMS_polymod_oembed_definition extends CMS_grandFather
{
	public $id               = null;
	public $objectdefinition = null;
	public $codename         = null;
	public $json             = null;
	public $xml              = null;
	public $uuid             = null;
	public $validationFailures = array();

	function __construct() {

	}

	public function validate() {
		// codename must not already be in use
		if(!$this->checkCodenameUnicity()) {
			$this->validationFailures[] = "Ce codename est déjà utilisé par une autre définition Oembed";
		}
		// XML definition must be valid
		if(!$this->checkDefinition($this->xml)) {
			$this->validationFailures[] = "La définition XML n'est pas valide.";
			$this->validationFailures[] = $this->checkDefinition($this->xml,true);
		}
		// JSON definition must be valid
		if(!$this->checkDefinition($this->json)) {
			$this->validationFailures[] = "La définition Json n'est pas valide.";
			$this->validationFailures[] = $this->checkDefinition($this->json,true);
		}
		// definitions must be valid
		return empty($this->validationFailures);
	}

	public function getValidationFailures() {
		return $this->validationFailures;
	}

	public function checkCodenameUnicity() {
		return 0 === CMS_polymod_oembed_definition_catalog::countByCodename($this->codename,$this->id);
	}

	public function checkDefinition($value, $returnErrors = false) {
		global $cms_language;
		//check definition parsing
		$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->objectdefinition);
		$parsing = new CMS_polymod_definition_parsing($value, true, CMS_polymod_definition_parsing::CHECK_PARSING_MODE, $module);
		$errors = $parsing->getParsingError();
		if ($errors) {
			return $returnErrors ? $errors : false;
		}
		return true;
	}

	public function writeToPersistence() {
		if (empty($this->uuid)) {
			$this->uuid = io::uuid();
		}

		$fields = array(
			'objectdefinition',
			'codename',
			'json',
			'xml',
			'uuid'
		);

		$sql_fields = '';
		foreach ($fields as $field) {
			$sql_fields .= (empty($sql_fields)) ? '' :', ';
			$sql_fields .= $field.'_mood="'. $this->$field . '"';
		}
		if($this->id) {
			$sql = 'UPDATE mod_object_oembed_definition SET '.$sql_fields . ' WHERE id_mood = '.$this->id;
		}
		else {
			$sql = 'INSERT INTO mod_object_oembed_definition SET '.$sql_fields;
		}

		$q = new CMS_query($sql);
		if ($q->hasError()) {
			$this->raiseError("Can't save object");
			return false;
		} elseif (!$this->id) {
			$this->id = $q->getLastInsertedID();
		}
	}

	/**
	 * This method return the id
	 * @return
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * This method sets the id
	 * @return  the current object
	 */
	public function setId($id) {
		$this->id = (int) $id;
		return $this;
	}

	/**
	 * This method return the objectdefinition
	 * @return
	 */
	public function getObjectdefinition() {
		return $this->objectdefinition;
	}

	/**
	 * This method sets the objectdefinition
	 * @return  the current object
	 */
	public function setObjectdefinition($objectdefinition) {
		$this->objectdefinition = (int) $objectdefinition;
		return $this;
	}

	/**
	 * This method return the codename
	 * @return
	 */
	public function getCodename() {
		return $this->codename;
	}

	/**
	 * This method sets the codename
	 * @return  the current object
	 */
	public function setCodename($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->codename = $v;

		return $this;
	}

	/**
	 * This method return the XML
	 * @return
	 */
	public function getXML() {
		return $this->xml;
	}

	/**
	 * This method sets the XML
	 * @return  the current object
	 */
	public function setXML($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->xml = $v;

		return $this;
	}

	/**
	 * This method return the Json
	 * @return
	 */
	public function getJson() {
		return $this->json;
	}

	/**
	 * This method sets the Json
	 * @return  the current object
	 */
	public function setJson($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->json = $v;

		return $this;
	}

	/**
	 * This method return the UUID
	 * @return
	 */
	public function getUUID() {
		return $this->uuid;
	}

	/**
	 * This method sets the UUID
	 * @return  the current object
	 */
	public function setUUID($UUID) {
	 	$this->uuid = $UUID;
		return $this;
	}

}