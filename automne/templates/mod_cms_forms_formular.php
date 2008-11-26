<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2006 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | or (at your discretion) to version 3.0 of the PHP license.           |
// | The first is bundled with this package in the file LICENSE-GPL, and  |
// | is available at through the world-wide-web at                        |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | The later is bundled with this package in the file LICENSE-PHP, and  |
// | is available at through the world-wide-web at                        |
// | http://www.php.net/license/3_0.txt.                                  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: mod_cms_forms_formular.php,v 1.1.1.1 2008/11/26 17:12:16 sebastien Exp $

/**
  * Template CMS_forms_formular
  *
  * Represent a formular template for module cms_forms
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Requirements
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
require_once(PATH_PACKAGES_FS."/workflow.php");
require_once(PATH_PACKAGES_FS."/common/language.php");
require_once(PATH_PACKAGES_FS."/common/date.php");
require_once(PATH_MODULES_FS."/super_resource.php");
require_once(PATH_PACKAGES_FS."/pageContent/xml2Array.php");
require_once(PATH_MODULES_FS."/module.php");
require_once(PATH_MODULES_FS."/moduleValidation.php");
require_once(PATH_MODULES_FS."/moduleclientspace.php");
require_once(PATH_MODULES_FS."/standard/block.php");
require_once(PATH_MODULES_FS."/cms_forms.php");
//set current page ID
$mod_cms_forms["pageID"] = '{{pageID}}';
//Instanciate Form
$form = new CMS_forms_formular($mod_cms_forms["formID"]);
//Instanciate language
$cms_language = $form->getLanguage();
//Form actions treatment
if ($form->getID() && $form->isPublic()) {
	echo '<a name="formAnchor'.$form->getID().'"></a>';
	//Create or append (from header) form required message
	if (isset($cms_forms_required[$form->getID()]) && is_array($cms_forms_required[$form->getID()]) && $cms_forms_required[$form->getID()]) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(MESSAGE_CMS_FORMS_REQUIRED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_required[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
		}
		$cms_forms_error_msg[$form->getID()] .= '</ul>';
	}
	//Create or append (from header) form malformed message
	if (isset($cms_forms_malformed[$form->getID()]) && is_array($cms_forms_malformed[$form->getID()]) && $cms_forms_malformed[$form->getID()]) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(MESSAGE_CMS_FORMS_MALFORMED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_malformed[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
		}
		$cms_forms_error_msg[$form->getID()] .= '</ul>';
	}
	//Create or append (from header) form error message
	if (isset($cms_forms_error_msg[$form->getID()]) && $cms_forms_error_msg[$form->getID()]) {
		echo '<div class="cms_forms_error_msg">'.$cms_forms_error_msg[$form->getID()].'</div>';
	}
	//display form or form message
	if (!isset($cms_forms_msg[$form->getID()])) {
		//check if form is already folded by sender
		if (!$form->isAlreadyFolded($sender)) { 
			echo $form->getContent(CMS_forms_formular::ALLOW_FORM_SUBMIT);
		}
	}
	if (isset($cms_forms_msg[$form->getID()])) {
		echo '<div class="cms_forms_msg">'.$cms_forms_msg[$form->getID()].'</div>';
	}
}
?>