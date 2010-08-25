<?php
/**
 * PolymodModuleBuilder
 **/
class PolymodModuleBuilder
{
	/**
	 * Builder for polymod module.
	 *
	 * @var		string	$sCodename	The module's codename.
	 * @var		array	$aLabels	The module name labels. Format $sLanguageCode => $sLabel.
	 * @return	void				The created module id if successfull. False otherwise.
	 */
	public function buildModule($sCodename, $aLabels)
	{
		$iModuleId = $this->registerModule($sCodename, $aLabels);
		if ($iModuleId) {
			return $iModuleId;
		} else {
			return false;
		}
	}

	/**
	 * Builder for module's classes.
	 *
	 * @var		string	$sModuleCodename	The module's codename which class belong to.
	 * @var		array	$aClass				The class definition.
	 * @return	void						The created class id if successfull. False otherwise.
	 */
	public function buildClass($sModuleCodename, $aClass)
	{
		//create labels
		$iLabelId = $this->createI18nm($aClass['labels']);
		echo '<p>Class label id '.$iLabelId.'<p/>';

		//create descriptions
		$iDescriptionId = $this->createI18nm($aClass['descriptions']);
		echo '<p>Class description id '.$iDescriptionId.'</p>';

		$aClassDefinition = array_merge(array(
				'label_id' 			=> $iLabelId,
				'description_id'	=> $iDescriptionId,
				'module' 			=> $sModuleCodename,
			),
			$aClass['params']
		);
		foreach ($aClassDefinition as $key=>$value) {
			$aClassDefinition[$key.'_mod'] = $value;
			unset($aClassDefinition[$key]);
		}

		//create definition
		$oPolymodDefinition = new CMS_poly_object_definition(0, $aClassDefinition);

		if ($oPolymodDefinition->writeToPersistence()) {
			return $oPolymodDefinition->getID();
		} else {
			return false;
		}
	}

	/**
	 * Builder for class's fields
	 *
	 * @var		int		$iPolymodDefinitionId	The class's id which the field belong to.
	 * @var		array	$aField					The field definition.
	 * @return	void							The created field id if successfull. False otherwise.
	 */
	public function buildField($iPolymodDefinitionId, $aField)
	{
		//create labels
		$iLabelId = $this->createI18nm($aField['labels']);
		echo '<p>Field label id '.$iLabelId.'<p/>';

		//create descriptions
		$iDescriptionId = $this->createI18nm($aField['descriptions']);
		echo '<p>Field description id '.$iDescriptionId.'</p>';

		$aDefaultParams = array(
			'required'		=> 0,
			'indexable'		=> 0,
			'searchlist'	=> 0,
			'searchable'	=> 0,
		);
		$aFieldDefinition = array_merge(array(
				'object_id'	=> $iPolymodDefinitionId,
				'label_id' 	=> $iLabelId,
				'desc_id'  	=> $iDescriptionId,
				'type'		=> $aField['type']
			),
			$aField['params']
		);
		//unserialize params
		if (isset($aField['params']['params'])) {
			$aUnserialisedParams = unserialize($aField['params']['params']);
			if ($aUnserialisedParams !== false) {
				$aField['params']['params'] = $aUnserialisedParams;
			} else {
				$this->_aErrors[] = array('!field params params unserialize error', $aField['params']['params']);
			}
		}
		$aFieldDefinition['params'] = serialize($aFieldDefinition['params']);
		foreach ($aFieldDefinition as $key=>$value) {
			$aFieldDefinition[$key.'_mof'] = $value;
			unset($aFieldDefinition[$key]);
		}

		//create field
		$oField = new CMS_poly_object_field(0, $aFieldDefinition);

		if ($oField->writeToPersistence()) {
			return $oField->getID();
		} else {
			return false;
		}
	}

	/**
	 * Create a new polymod module if its codename does not already exists.
	 * @var		string	$sCodename	The module codename.
	 * @var		array	$aLabels	The module name labels. Format $sLanguageCode => $sLabel.
	 * @return	bool				True if successfull. False otherwise.
	 */
	public function registerModule($sCodename, $aLabels)
	{
		//check if codename already used
		if (in_array($sCodename, CMS_modulesCatalog::getAllCodenames())) {
			return false;
		}

		//create labels
		$iLabelId = $this->createMessage($sCodename, $aLabels);
		echo '<p>Module label id '.$iLabelId.'</p>';

		//create module
		$oModule = new CMS_module();
		$oModule->setCodename($sCodename);
		$oModule->setPolymod(true);
		$oModule->setLabel($iLabelId);
		if ($oModule->writeToPersistence()) {
			return $oModule->getID();
		} else {
			return false;
		}
	}

	/**
	 * Return the next module message id
	 * @return	the highest module message id + 1
	 */
	public function getNextMessageId($sCodename)
	{
		$oQuery = new CMS_query("
			SELECT DISTINCT id_mes
			FROM messages
			WHERE module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."'
			ORDER BY id_mes DESC
			LIMIT 0,1
		");
		if ($oQuery->getNumRows() > 0) {
			$aResults = $oQuery->getAll();
			return $aResults[0] + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Create messages.
	 * @var	string	$sCodename	Module's codname.
	 * @var	array	$aMessage	Localised message. $sLanguageCode => $sMessage
	 * @return					Id of the inserted message.
	 */
	public function createMessage($sCodename, $aMessage)
	{
		$iId = $this->getNextMessageId($sCodename);
		foreach ($aMessage as $sLanguageCode=>$sMessage) {
			$oQuery = new CMS_query("
				INSERT INTO
					messages
				SET
					id_mes = ".SensitiveIO::sanitizeSQLString($iId).",
					module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."',
					language_mes = '".SensitiveIO::sanitizeSQLString($sLanguageCode)."',
					message_mes = '".SensitiveIO::sanitizeSQLString($sMessage)."'
			");
		}
		return $iId;
	}

	/**
	 * Create objects definitions i18nm messages.
	 * @var		array	$aI18nm	Objects i18nm localised message. $sLanguageCode => $sValue
	 * @return	int				Id of the inserted message.
	 */
	public function createI18nm($aI18nm)
	{
		$oI18Label = new CMS_object_i18nm();
		foreach ($aI18nm as $sLanguageCode=>$sLabel) {
			$oI18Label->setValue($sLanguageCode, $sLabel);
		}
		if ($oI18Label->writeToPersistence()) {
			return $oI18Label->getID();
		} else {
			return false;
		}
	}
}
?>
