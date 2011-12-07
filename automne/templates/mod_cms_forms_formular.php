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
// $Id: mod_cms_forms_formular.php,v 1.6 2010/03/08 16:44:52 sebastien Exp $

/**
  * Template CMS_forms_formular
  *
  * Represent a formular template for module cms_forms
  *
  * @package Automne
  * @subpackage cms_forms
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//force loading module cms_forms
if (!class_exists('CMS_module_cms_forms')) {
	die('Cannot find cms_forms module ...');
}

//set current page ID
$mod_cms_forms["pageID"] = '{{pageID}}';
//Instanciate Form
$form = new CMS_forms_formular($mod_cms_forms["formID"]);
//Instanciate language
$cms_language = $form->getLanguage();
//Instanciate field error Ids
$cms_forms_error_ids = array();
//Form actions treatment
if ($form->getID() && $form->isPublic()) {
	echo '<a name="formAnchor'.$form->getID().'"></a>';
	//Create or append (from header) form required message
	if (isset($cms_forms_token[$form->getID()]) && $cms_forms_token[$form->getID()]) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_TOKEN_EXPIRED, false, MOD_CMS_FORMS_CODENAME);
	}
	//Create or append (from header) form required message
	if (isset($cms_forms_required[$form->getID()]) && $cms_forms_required[$form->getID()] && is_array($cms_forms_required[$form->getID()])) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_REQUIRED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_required[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
			$cms_forms_error_ids[] .= $field->generateFieldIdDatas();
		}
		$cms_forms_error_msg[$form->getID()] .= '</ul>';
	}
	//Create or append (from header) form malformed message
	if (isset($cms_forms_malformed[$form->getID()]) && $cms_forms_malformed[$form->getID()] && is_array($cms_forms_malformed[$form->getID()])) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_MALFORMED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_malformed[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
			$cms_forms_error_ids[] .= $field->generateFieldIdDatas();
		}
		$cms_forms_error_msg[$form->getID()] .= '</ul>';
	}
	//Create or append (from header) form error message
	if (isset($cms_forms_error_msg[$form->getID()]) && $cms_forms_error_msg[$form->getID()]) {
		echo '<div class="cms_forms_error_msg">'.evalPolymodVars($cms_forms_error_msg[$form->getID()], $cms_language->getCode()).'</div>';
	}
	//display form or form message
	if (!isset($cms_forms_msg[$form->getID()]) || !$cms_forms_msg[$form->getID()]) {
		//check if form is already folded by sender
		if (isset($sender) && !$form->isAlreadyFolded($sender)) { 
			echo $form->getContent(CMS_forms_formular::ALLOW_FORM_SUBMIT, $cms_forms_error_ids);
		}
	}
	if (isset($cms_forms_msg[$form->getID()]) && $cms_forms_msg[$form->getID()]) {
		echo '<div class="cms_forms_msg">'.evalPolymodVars($cms_forms_msg[$form->getID()], $cms_language->getCode()).'</div>';
	}
}
?>