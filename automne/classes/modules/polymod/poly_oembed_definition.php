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
	public $label            = null;
	public $parameter        = null;
	public $html             = null;
	public $uuid             = null;
	public $validationFailures = array();

	function __construct() {

	}

	public function validate() {
		// codename must not already be in use
		if(!$this->checkCodenameUnicity()) {
			$this->validationFailures[] = "Ce codename est déjà utilisé par une autre définition Oembed";
		}
		// HTML definition must be valid
		if(!$this->checkDefinition()) {
			$this->validationFailures[] = "La définition n'est pas valide.";
			$this->validationFailures[] = $this->checkDefinition(true);
		}

		return empty($this->validationFailures);
	}

	public function getValidationFailures() {
		return $this->validationFailures;
	}

	public function checkCodenameUnicity() {
		return 0 === CMS_polymod_oembed_definition_catalog::countByCodename($this->codename,$this->id);
	}

	public function checkDefinition($returnErrors = false) {
		global $cms_language;

		//check definition parsing
		$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($this->objectdefinition);

		$polymod = CMS_modulesCatalog::getByCodename($module);

		$convertedDefinition = $polymod->convertDefinitionString($this->html, false);
		$parsing = new CMS_polymod_definition_parsing($convertedDefinition, true, CMS_polymod_definition_parsing::CHECK_PARSING_MODE, $module);
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
			'html',
			'label',
			'parameter',
			'uuid'
		);

		$sql_fields = '';
		foreach ($fields as $field) {
			$sql_fields .= (empty($sql_fields)) ? '' :', ';
			$sql_fields .= $field.'_mood="'. CMS_query::echap($this->$field) . '"';
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
	 * This method return the label
	 * @return
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * This method sets the label
	 * @return  the current object
	 */
	public function setLabel($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->label = $v;

		return $this;
	}

	/**
	 * This method return the parameter
	 * @return
	 */
	public function getParameter() {
		return $this->parameter;
	}

	/**
	 * This method sets the parameter
	 * @return  the current object
	 */
	public function setParameter($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->parameter = $v;

		return $this;
	}

	/**
	 * This method return the HTML
	 * @return
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * This method sets the HTML
	 * @return  the current object
	 */
	public function setHtml($v) {
		if($v !== null && is_numeric($v)) {
			$v = (string) $v;
		}

		$this->html = $v;

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

	public static function getServiceUrl() {
		return CMS_websitesCatalog::getCurrentDomain().'/embed/oembed'.(!STRIP_PHP_EXTENSION ? '.php' : '').
					'?url='.
					rawurlencode(CMS_websitesCatalog::getCurrentDomain().$_SERVER['REQUEST_URI']);
	}

	public static function getObjectName() {
		$page = CMS_tree::getPageByID(CURRENT_PAGE);

		$oembedDefinition = CMS_polymod_oembed_definition_catalog::getByCodename($page->getCodename());
		$parameterName = $oembedDefinition->getParameter();

		$embededObject = CMS_poly_object_catalog::getObjectByID(io::get($parameterName), false,true);
		if($embededObject) {
			return $embededObject->getLabel();
		}
		return '';
	}

	public static function getDiscoveryEndpoint() {
		$modes = array(
			'json' => 'application/json+oembed',
			'xml' => 'application/xml+oembed'
			);
		$links = '';
		foreach ($modes as $mode => $mimeType) {
			$links .= '<link rel="alternate" type="'.$mimeType.'" href="'.self::getServiceUrl().'&format='.$mode.'"  title="'.self::getObjectName().'"/>';
		}

		return $links;
	}

	public static function getResults($props) {
	  $defaults = array(
	    'type' => 'rich',
	    'version' => '1.0',
	    'provider_name' => 'automne',
	    'width' => 0,
	    'height' => 0,
	  );
	  $result = array_merge($defaults, $props);
	  return $result;
	}

	public static function format_xml_elements($array) {
	  $output = '';
	  foreach ($array as $key => $value) {
	    if (is_numeric($key)) {
	      if ($value['key']) {
	        $output .= ' <' . $value['key'];
	        if (isset($value['attributes']) && is_array($value['attributes'])) {
	          $output .= drupal_attributes($value['attributes']);
	        }

	        if (isset($value['value']) && $value['value'] != '') {
	          $output .= '>' . (is_array($value['value']) ? self::format_xml_elements($value['value']) : self::check_plain($value['value'])) . '</' . $value['key'] . ">\n";
	        }
	        else {
	          $output .= " />\n";
	        }
	      }
	    }
	    else {
	      $output .= ' <' . $key . '>' . (is_array($value) ? self::format_xml_elements($value) : self::check_plain($value)) . "</$key>\n";
	    }
	  }
	  return $output;
	}

	public static function check_plain($text) {
  	return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}

}