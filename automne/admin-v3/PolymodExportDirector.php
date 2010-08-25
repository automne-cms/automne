<?php
/**
 * PolymodExportDirector
 **/
class PolymodExportDirector
{
	protected $_aErrors = array();
	
	/**
	 * @var DOMDocument	$oXmlModule	The modules definitions.
	 */
	function __construct($oXmlModule)
	{
		$this->oXmlModule = $oXmlModule;
		$this->oXpath = new DOMXPath($oXmlModule);
	}

	/**
	 * Construct polymod modules.
	 *
	 * @var		PolymodModuleBuilder $oBuilder	The polymod module builder.
	 * @return	bool							True if successfull. False otherwise.
	 */
	public function construct($oBuilder)
	{
		$this->oBuilder = $oBuilder;
		$oModules = $this->oXmlModule->getElementsByTagName('module');
		foreach ($oModules as $oModule) {
			$iModuleId = $this->constructModule($oModule);
			if (!$iModuleId) {
				$this->_aErrors[] = '!construct module';
				//TODO remove all created modules.
			}
		}
		if ($this->_aErrors) {
			return $this->_aErrors;
		} else {
			return true;
		}
	}

	/**
	 * Construct a module.
	 *
	 * @var		DOMNode	$oModule	The module Node.
	 * @return	int					The module id if successfull. False otherwise.
	 */
	protected function constructModule($oModule)
	{
		//get module info
		if (!$oModule->hasAttribute('codename')) {
			$this->_aErrors[] = '!module codename';
			return false;
		}
		$sModuleCodename = $oModule->getAttribute('codename');

		//get module labels
		$aLabels = $this->getLocalisedText('label', $oModule);
		if (!$aLabels) {
			$this->_aErrors[] = '!module label';
			return false;
		}

		//build module
		$iModuleId = $this->oBuilder->buildModule($sModuleCodename, $aLabels);
		if (!$iModuleId) {
			$this->_aErrors[] = '!module build';
			return false;
		}

		$errors = false;
		//build classes
		$oClasses = $this->oXpath->query('class', $oModule);
		if (!$oClasses) {
			$this->_aErrors[] = '!'.$sModuleCodename.' class';
			$errors = true;
		}
		$aDeferedFields = array();
		foreach ($oClasses as $oClass) {
			$iClassId = $this->constructClass($sModuleCodename, $oClass);
			if (!$iClassId) {
				$this->_aErrors[] = '!'.$sModuleCodename.' class build';
				$errors = true;
				break;
			}
			//keep track of new classes ids for defered fields creations
			$aNewClassIds[$oClass->getAttribute('id')] = $iClassId;

			//build fields
			$oFields = $this->oXpath->query('field', $oClass);
			if (!$oFields) {
				$this->_aErrors[] = '!'.$sModuleCodename.' field';
				$errors = true;
				break;
			}
			foreach ($oFields as $oField) {
				if ($oField->hasAttribute('type')) {
					if (io::isPositiveInteger($oField->getAttribute('type'))) {
						//these fields will be construct at the end off all classes builds
						$aDeferedFields[] = array(
							'iClassId'	=> $iClassId,
							'oField'	=> $oField
						);
					} else {
						$iFieldId = $this->constructField($iClassId, $oField);
						if (!$iFieldId) {
							$this->_aErrors[] = '!'.$sModuleCodename.' field build';
							$errors = true;
							break 2;
						}
					}
				} else {
					$this->_aErrors[] = '!'.$sModuleCodename.' field build missing type';
					$errors = true;
					break 2;
				}
			}
		}
		foreach ($aDeferedFields as $aRow) {
			//replace old class id
			$aRow['oField']->setAttribute('type', $aNewClassIds[$aRow['oField']->getAttribute('type')]);
			//construct field
			$iFieldId = $this->constructField($aRow['iClassId'], $aRow['oField']);
			if (!$iFieldId) {
				$this->_aErrors[] = '!'.$sModuleCodename.' defered field build';
				$errors = true;
			}
		}

		if ($errors) {
			//TODO supprimer le module
			return false;
		} else {
			return $iModuleId;
		}
	}

	/**
	 * Construct a module class.
	 *
	 * @var		string	$sModuleCodename	The module's codename which class belong to.
	 * @var		DOMNode	$oClass				The class Node.
	 * @return	void						The build result value. See PolymodModuleBuilder::buildClass.
	 */
	protected function constructClass($sModuleCodename, $oClass)
	{
		$aClass = array();

		//get class labels
		$aClass['labels'] = $this->getLocalisedText('label', $oClass);
		if (!$aClass['labels']) {
			$this->_aErrors[] = '!class label';
			return false;
		}
		//get class descriptions
		$aClass['descriptions'] = $this->getLocalisedText('description', $oClass);

		//get class params
		$oPolymod = new CMS_polymod($this->_objectValues['module']);
		$aClass['params'] = $this->getParams($oClass);
		foreach ($aClass['params'] as $sParamName=>$mParamValue) {
			if ((	$sParamName == 'composedLabel'
					|| $sParamName == 'previewURL'
					|| $sParamName == 'indexURL'
					|| $sParamName == 'resultsDefinition')
				&& !empty($mParamValue)
			) {
				$aClass['params'][$sParamName] = $oPolymod->convertDefinitionString($mParamValue);
			}
		}

		//build
		return $this->oBuilder->buildClass($sModuleCodename, $aClass);
	}

	/**
	 * Construct a module field.
	 *
	 * @var		int		$iClassId	The module's codename which field belong to.
	 * @var		DOMNode	$oField		The field Node.
	 * @return	void				The build result value. See PolymodModuleBuilder::buildField.
	 */
	protected function constructField($iClassId, $oField)
	{
		$aField = array(
			'type' => $oField->getAttribute('type')
		);

		//get field labels
		$aField['labels'] = $this->getLocalisedText('label', $oField);
		if (!$aField['labels']) {
			$this->_aErrors[] = '!field label';
			return false;
		}
		//get field descriptions
		$aField['descriptions'] = $this->getLocalisedText('description', $oField);

		//get field params
		$aField['params'] = $this->getParams($oField);

		//build
		return $this->oBuilder->buildField($iClassId, $aField);
	}

	/**
	 * Get class or field params. <param name="$PARAM_NAME">$PARAM_VALUE</param>
	 * Where $PARAM_VALUE can be a set of serialized data. <item name="$NAME" type="$TYPE">$VALUE</item>
	 *
	 * @var		DomNode	$oContext	Node whose params will be searched.
	 * @return	array				An associative array of the form: $NAME => $PARAM_VALUE
	 *								If $PARAM_VALUE is serialized data, it is unserialised.
	 */
	protected function getParams($oContext)
	{
		$aParams = array();
		$oParams = $this->oXpath->query('param', $oContext);
		if (!$oParams) {
			$this->_aErrors[] = '!param';
			continue;
		}
		foreach ($oParams as $oParam) {
			if (!$oParam->hasAttribute('name')) {
				$this->_aErrors[] = '!name';
				continue;
			}
			$sName = $oParam->getAttribute('name');

			$oParamDatas = $this->oXpath->evaluate('child::text()',$oParam);
			if ($oParamDatas) {
				$sParamDatas = '';
				foreach ($oParamDatas as $oParamData) {
					$sParamDatas .= $oParamData->wholeText;
				}
				$aParams[$sName] = $sParamDatas;
			}
		}
		pr($aParams);
		return $aParams;
	}

	/**
	 * Get a set of localised text. <$TAGNAME language="$LOCALE">$TEXT</$TAGNAME>
	 *
	 * @var		string	$sTagname	The name of the localised text tag.
	 * @var		DomNode	$oContext	Node whose children will be searched.
	 * @return	array				An associative array of the form: $LOCAL => $TEXT
	 */
	protected function getLocalisedText($sTagname, $oContext)
	{
		$aTexts = array();
		$oTags = $this->oXpath->query($sTagname, $oContext);
		if (!$oTags) {
			$this->_aErrors[] = array('!'.$sTagname, $oTags);
			continue;
		}
		foreach ($oTags as $oTag) {
			if (!$oTag->hasAttribute('language')) {
				$this->_aErrors[] = array('!'.$sTagname.' language');
				continue;
			}
			$sLanguageCode = $oTag->getAttribute('language');
			$oTagTexts = $this->oXpath->evaluate('child::text()',$oTag);
			if ($oTagTexts) {
				$sText = '';
				foreach ($oTagTexts as $oTagText) {
					$sText .= $oTagText->wholeText;
				}
				$aTexts[$sLanguageCode] = $sText;
			}
		}
		return $aTexts;
	}
}
?>
