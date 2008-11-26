<?php //Generated on Tue, 25 Nov 2008 16:53:37 +0100 by Automne (TM) 4.0.0a
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://automne4/web/fr/9-contact.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?>
<?php $mod_cms_forms = array();
$mod_cms_forms["usedforms"] = array (
  0 => '2',
);
$mod_cms_forms["type"] = 'header';
$mod_cms_forms["id"] = 'cms_forms_header';
$mod_cms_forms["module"] = 'cms_forms';
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
// $Id: 9.php,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

/**
  * Template CMS_forms_header
  *
  * Represent a header template for module cms_forms
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//start session (needed for form validation count)
@session_start();

//Requirements
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
require_once(PATH_PACKAGES_FS."/workflow.php");
require_once(PATH_PACKAGES_FS."/common.php");
require_once(PATH_MODULES_FS."/super_resource.php");
require_once(PATH_PACKAGES_FS."/pageContent/xml2Array.php");
require_once(PATH_PACKAGES_FS."/tree/page.php");
require_once(PATH_PACKAGES_FS."/tree/pagetemplatescatalog.php");
require_once(PATH_PACKAGES_FS."/tree/tree.php");
require_once(PATH_PACKAGES_FS."/tree/website.php");
require_once(PATH_PACKAGES_FS."/tree/websitescatalog.php");
require_once(PATH_MODULES_FS."/module.php");
require_once(PATH_MODULES_FS."/moduleValidation.php");
require_once(PATH_MODULES_FS."/moduleclientspace.php");
require_once(PATH_MODULES_FS."/standard/block.php");
require_once(PATH_MODULES_FS."/cms_forms.php");
require_once(PATH_PACKAGES_FS."/workflow/resource.php");
require_once(PATH_PACKAGES_FS."/workflow/resourcestatus.php");
require_once(PATH_PACKAGES_FS."/user.php");
require_once(PATH_PACKAGES_FS.'/polymodFrontEnd.php');
//set current page ID
$mod_cms_forms["pageID"] = $parameters['pageID'] = '9';

//little function to enclose PHP vars with curly braces to avoid errors with array indexes
function curlyBracesVars($text) {
	return preg_replace('#(\s)(\$[a-zA-Z0-9_\[\]\'-]*)#','\\1".\\2."',$text);
}

//if page has forms
if (is_array($mod_cms_forms["usedforms"]) && $mod_cms_forms["usedforms"]) {
	$sender = CMS_forms_sender::getSenderForContext($_SESSION["cms_context"]);
	foreach($mod_cms_forms["usedforms"] as $formID) {
		$form = new CMS_forms_formular($formID);
		//if form exists and is public
		if ($form->getID() && $form->isPublic()) {
			/***********************************************************
			*                   AUTOLOGIN ATTEMPT                      *
			***********************************************************/
			//check for authentification action in form
			if ($form->getActionsByType(CMS_forms_action::ACTION_AUTH)) {
				//check for valid session / logout attempt / and autologin
				if (!is_a($_SESSION["cms_context"], 'CMS_context') || $_REQUEST["logout"] == 'true') {
					@session_destroy();
					@session_start();
					if ($_REQUEST["logout"] != 'true' && CMS_context::autoLoginSucceeded()) {
						//declare form ok action
						$cms_forms_okAction[$form->getID()] = true;
					} elseif ($_REQUEST["logout"] == 'true') {
						// Reset cookie
						CMS_context::resetSessionCookies();
						//then reload current page (to load public user)
						header('Location: '.$_SERVER["SCRIPT_NAME"]);
						exit;
					}
				}
				if (is_a($_SESSION["cms_context"], 'CMS_context') && $_REQUEST["logout"] != 'true' && CMS_context::autoLoginSucceeded()) {
					//declare form ok action
					$cms_forms_okAction[$form->getID()] = true;
				}
				//get form ok action
				$actions = $form->getActionsByType(CMS_forms_action::ACTION_FORMOK);
				$action = array_shift($actions);
				//check if form ok send to a page and if user has rights for this page
				if (is_object($cms_user) && $action->getString("value") == "page") {
					//for compatibility with old versions of module
					if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
						$redirect = new CMS_href();
						$redirect->setInternalLink($action->getString('text'));
						$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
					} else {
						$redirect = new CMS_href($action->getString('text'));
					}
					if ($redirect->hasValidHREF()) {
						if (($redirect->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL && $cms_user->hasPageClearance($redirect->getInternalLink(), CLEARANCE_PAGE_VIEW)) || $redirect->getLinkType() == RESOURCE_LINK_TYPE_EXTERNAL) {
							//declare form ok action
							$cms_forms_okAction[$form->getID()] = true;
						}
					}
				}
				//then launch form ok action if needed
				if ($cms_forms_okAction[$form->getID()]) {
					//if we have an encoded referer, use it
					if ($_REQUEST['referer'] && ($url = base64_decode($_REQUEST['referer']))) {
						header("Location: ".$url);
						exit;
					}
					//in case of OK for this form, do action
					if ($action->getString("value") == "page") { //go to given page
						//for compatibility with old versions of module
						if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
							$redirect = new CMS_href();
							$redirect->setInternalLink($action->getString('text'));
							$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
						} else {
							$redirect = new CMS_href($action->getString('text'));
						}
						if ($redirect->hasValidHREF()) {
							$href = $redirect->getHTML(false, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
							$href = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($href)).'";');
							if ($href) {
								header("Location: ".$href);
								exit;
							}
						}
					} else { //append message to form message
						$text = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($action->getString("text"))).'";');
						$cms_forms_msg[$form->getID()] .= nl2br($text).'<br />';
					}
				}
			}
			/***********************************************************
			*                    FORM SUBMISSION                       *
			***********************************************************/
			//if form has been submited
			if (isset($_POST["formID"]) && $_POST["formID"] == $formID && $_POST["cms_action"] == 'validate') {
				$form_language = $form->getLanguage();
				//check for required fields
				$fields = $form->getFields(true);
				//Proceed actions
				$actions = $form->getActions();
				if (is_array($actions) && $actions) {
					foreach ($actions as $action) {
						switch ($action->getInteger('type')) {
							case CMS_forms_action::ACTION_ALREADY_FOLD:
								//check if form is already folded by sender
								if ($form->isAlreadyFolded($sender)) { 
									//get form CMS_forms_action::ACTION_ALREADY_FOLD action
									$alreadyFoldAction = array_shift($form->getActionsByType(CMS_forms_action::ACTION_ALREADY_FOLD));
									if (is_object($alreadyFoldAction)) {
										if ($action->getString("value") == "page") { //go to given page
											//for compatibility with old versions of module
											if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
												$redirect = new CMS_href();
												$redirect->setInternalLink($action->getString('text'));
												$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
											} else {
												$redirect = new CMS_href($action->getString('text'));
											}
											if ($redirect->hasValidHREF()) {
												$href = $redirect->getHTML(false, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
												//needed in case of vars in redirection. Simple and double quotes are not welcome in this case !
												//$href = (strpos($href, '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$href).'";') : $href;
												$href = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($href)).'";');
												if ($href) {
													header("Location: ".$href);
													exit;
												}
											}
										} else {
											$text = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($alreadyFoldAction->getString("text"))).'";');
											$cms_forms_msg[$form->getID()] .= nl2br($text);
										}
									}
									break 2; //then quit actions loop
								}
							break;
							case CMS_forms_action::ACTION_FORMNOK:
								$cms_forms_required = array();
								$cms_forms_malformed = array();
								foreach ($fields as $aField) {
									//check if field is required and has datas
									if ($aField->getAttribute('required') == 1 
										&& $aField->getAttribute('type') != 'file' 
										&& (!isset($_POST[$aField->getAttribute('name')]) || trim($_POST[$aField->getAttribute('name')]) === '')) {
										
										$cms_forms_required[$form->getID()][] = $aField->getAttribute('name');
									} elseif ($aField->getAttribute('required') == 1 && $aField->getAttribute('type') == 'file' && !$_FILES[$aField->getAttribute('name')]['name']) {
										$cms_forms_required[$form->getID()][] = $aField->getAttribute('name');
									}
									//check if field data is correct and clean datas if needed
									if(($aField->getAttribute('type') != 'file' && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name'])) {
										switch($aField->getAttribute('type')) {
											case 'email':
												if (!sensitiveIO::isValidEmail($_POST[$aField->getAttribute('name')])) {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											break;
											case 'textarea':
											case 'text':
											case 'url':
												//if field has html tags, it is malformed
												if (strip_tags($_POST[$aField->getAttribute('name')]) != $_POST[$aField->getAttribute('name')]) {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											break;
											case 'select':
												//if value is not in possible values then it is maformed
												if (!in_array(html_entity_decode($_POST[$aField->getAttribute('name')]), array_keys($aField->getAttribute('options')))) {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											break;
											case 'integer':
												//if value is not in possible values then it is maformed
												if (!is_numeric($_POST[$aField->getAttribute('name')]) || intval($_POST[$aField->getAttribute('name')]) != $_POST[$aField->getAttribute('name')]) {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											break;
											case 'file':
												//if error or no tmp file then it is malformed
												if ($_FILES[$aField->getAttribute('name')]['error'] || !$_FILES[$aField->getAttribute('name')]['tmp_name']) {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											break;
											case 'submit':
											default:
												//nothing needed on this one
											break;
										}
									}
								}
								if (isset($cms_forms_malformed[$form->getID()]) || isset($cms_forms_required[$form->getID()])) {
									//in case of NOK for this form, do action
									if ($action->getString("value") == "page") { //go to given page
										//for compatibility with old versions of module
										if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
											$redirect = new CMS_href();
											$redirect->setInternalLink($action->getString('text'));
											$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
										} else {
											$redirect = new CMS_href($action->getString('text'));
										}
										if ($redirect->hasValidHREF()) {
											$href = $redirect->getHTML(false, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
											//needed in case of vars in redirection. Simple and double quotes are not welcome in this case !
											//$href = (strpos($href, '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$href).'";') : $href;
											$href = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($href)).'";');
											if ($href) {
												header("Location: ".$href);
												exit;
											}
										}
									} else { //append message to form error message
										$text = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($action->getString("text"))).'";');
										$cms_forms_error_msg[$form->getID()] .= nl2br($text).'<br />';
									}
									break 2; //then quit actions loop
								}
							break;
							case CMS_forms_action::ACTION_DB:
								//create id for sender if not already have one
								if (!$sender->getID()) {
									$sender->writeToPersistence();
								}
								if ($sender->getID()) {
									foreach ($fields as $aField) {
										//insert datas of each field
										if ((($aField->getAttribute('type') != 'file' && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name']))
											&& $aField->getAttribute('type') != 'submit' ) {
											$fieldRecord = new CMS_forms_record();
											$fieldRecord->setAttribute('fieldID', $aField->getID());
											$fieldRecord->setAttribute('senderID', $sender->getID());
											if ($aField->getAttribute('type') == 'pass') {
												//do not store users passwords
												$fieldRecord->setAttribute('value', '---');
											} elseif ($aField->getAttribute('type') == 'file') {
												//do file upload management
												$filename = sensitiveIO::sanitizeAsciiString($_FILES[$aField->getAttribute('name')]['name']);
												$filepath = PATH_MODULES_FILES_FS.'/'.MOD_CMS_FORMS_CODENAME;
												$count=0;
												while(@file_exists($filepath.'/'.$filename)) {
													$count++;
													$filename = $count.'_'.sensitiveIO::sanitizeAsciiString($_FILES[$aField->getAttribute('name')]['name']);
												}
												if (@move_uploaded_file($_FILES[$aField->getAttribute('name')]['tmp_name'], $filepath.'/'.$filename)) {
													$_FILES[$aField->getAttribute('name')]['atm_name'] = $filename;
												}
												$fieldRecord->setAttribute('value', $_FILES[$aField->getAttribute('name')]['atm_name']);
											} else {
												$fieldRecord->setAttribute('value', $_POST[$aField->getAttribute('name')]);
											}
											$fieldRecord->writeToPersistence();
										}
									}
								}
							break;
							case CMS_forms_action::ACTION_EMAIL:
							case CMS_forms_action::ACTION_FIELDEMAIL:
								//generate email content
								$email = new CMS_email();
								//get email texts
								$texts = explode(chr(167).chr(167), $action->getString("text"));
								//create email body
								$body = '';
								foreach ($fields as $aField) {
									if ((($aField->getAttribute('type') != 'file' && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name']))
										&& $aField->getAttribute('type') != 'submit' ) {
										//insert datas of each field
										if ($aField->getAttribute('type') == 'file') {
											$filepath = PATH_MODULES_FILES_WR.'/'.MOD_CMS_FORMS_CODENAME;
											$mainurl = CMS_websitesCatalog::getMainURL();
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $mainurl.$filepath.'/'.$_FILES[$aField->getAttribute('name')]['atm_name']."\n\n";
										} elseif ($aField->getAttribute('type') != 'checkbox' && $aField->getAttribute('type') != 'select') {
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $_POST[$aField->getAttribute('name')]."\n\n";
										} elseif ($aField->getAttribute('type') == 'select') {
											$optionsLabels = $aField->getAttribute('options');
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $optionsLabels[$_POST[$aField->getAttribute('name')]]."\n\n";
										} else {
											$body .= ' - '.$aField->getAttribute('label')."\n\n";
										}
									}
								}
								//append header and footer texts if any to body text
								if ($texts[1]) { // header
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									//$texts[1] = (strpos($texts[1], '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$texts[1]).'";') : $texts[1];
									$texts[1] = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($texts[1])).'";');
									$body = $texts[1]."\n\n".$body;
								}
								if ($texts[2]) { //footer
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									//$texts[2] = (strpos($texts[2], '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$texts[2]).'";') : $texts[2];
									$texts[2] = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($texts[2])).'";');
									$body = $body."\n\n".$texts[2];
								}
								$email->setBody($body);
								
								//create subject
								if ($texts[0]) { //from DB if any
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									//$texts[0] = (strpos($texts[0], '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$texts[0]).'";') : $texts[0];
									$subject = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($texts[0])).'";');
								} else { // or default subject
									$subject = $form_language->getMessage(MESSAGE_CMS_FORMS_EMAIL_SUBJECT, array($form->getAttribute('name'), APPLICATION_LABEL), MOD_CMS_FORMS_CODENAME);
								}
								$email->setSubject($subject);
								
								//set email from
								if (!isset($texts[3]) || !sensitiveIO::isValidEmail($texts[3])) {
									$email->setEmailFrom(APPLICATION_POSTMASTER_EMAIL);
								} else {
									$email->setEmailFrom($texts[3]);
								}
								$email->setFromName(APPLICATION_LABEL);
								
								//and send emails
								if ($action->getInteger('type') == CMS_forms_action::ACTION_EMAIL) {
									$emailAddresses = array_map('trim',explode(';',html_entity_decode($action->getString("value"))));
									foreach ($emailAddresses as $emailAddress) {
										$emailAddress = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($emailAddress)).'";');
										if (sensitiveIO::isValidEmail($emailAddress)) {
											$email->setEmailTo($emailAddress);
											$email->sendEmail();
										}
									}
								} elseif ($action->getInteger('type') == CMS_forms_action::ACTION_FIELDEMAIL) {
									if (sensitiveIO::isValidEmail($_POST[$fields[$action->getString("value")]->getAttribute('name')])) {
										$email->setEmailTo($_POST[$fields[$action->getString("value")]->getAttribute('name')]);
										$email->sendEmail();
									}
								}
							break;
							case CMS_forms_action::ACTION_AUTH :
								$login = $password = $permanent = '';
								$values = explode(';',$action->getString('value'));
								if (is_object($fields[$values[0]])) {
									$login = $_POST[$fields[$values[0]]->getAttribute('name')];
								}
								if (is_object($fields[$values[1]])) {
									$password = $_POST[$fields[$values[1]]->getAttribute('name')];
								}
								if (is_object($fields[$values[2]])) {
									$permanent = $_POST[$fields[$values[2]]->getAttribute('name')];
								}
								if ($login && $password) {
									// Vérification données obligatoires
									if (trim($login) != '' && trim($password) != '') {
										$cms_context = new CMS_context(trim($login), trim($password), $permanent);
										if (!$cms_context->hasError()) {
											//user is ok so create session
											$_SESSION["cms_context"] = $cms_context;
											$cms_user = $_SESSION["cms_context"]->getUser();
											$cms_language = $cms_user->getLanguage();
										} else {
											unset($_SESSION["cms_context"]);
											//append message to form error message
											$text = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($action->getString("text"))).'";');
											$cms_forms_error_msg[$form->getID()] .= nl2br($text).'<br />';
											break 2; //quit actions loop
										}
									} else {
										break 2; //quit actions loop
									}
								}
							break;
							case CMS_forms_action::ACTION_FORMOK:
								//if we have an encoded referer, use it
								if ($_REQUEST['referer'] && ($url = base64_decode($_REQUEST['referer']))) {
									header("Location: ".$url);
									exit;
								}
								//in case of OK for this form, do action
								if ($action->getString("value") == "page") { //go to given page
									//for compatibility with old versions of module
									if (sensitiveIO::isPositiveInteger($action->getString('text'))) {
										$redirect = new CMS_href();
										$redirect->setInternalLink($action->getString('text'));
										$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
									} else {
										$redirect = new CMS_href($action->getString('text'));
									}
									if ($redirect->hasValidHREF()) {
										$href = $redirect->getHTML(false, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
										//needed in case of vars in redirection. Simple and double quotes are not welcome in this case !
										//$href = (strpos($href, '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$href).'";') : $href;
										$href = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($href)).'";');
										if ($href) {
											header("Location: ".$href);
											exit;
										}
									}
								} else { //append message to form message
									if (isset($cms_forms_msg[$form->getID()])) {
										$cms_forms_msg[$form->getID()] .= nl2br($action->getString("text")).'<br />';
									} else {
										$cms_forms_msg[$form->getID()] = nl2br($action->getString("text")).'<br />';
									}
								}
							break;
						}
					}
				}
			} else {
				/***********************************************************
				*                  FORM ALREADY FOLDED                     *
				***********************************************************/
				//check if form is already folded by sender and if it need page redirection
				if ($form->isAlreadyFolded($sender)) { 
					//get form CMS_forms_action::ACTION_ALREADY_FOLD action
					$alreadyFoldAction = array_shift($form->getActionsByType(CMS_forms_action::ACTION_ALREADY_FOLD));
					if (is_object($alreadyFoldAction)) {
						if ($alreadyFoldAction->getString("value") == "page") { //go to given page
							//for compatibility with old versions of module
							if (sensitiveIO::isPositiveInteger($alreadyFoldAction->getString('text'))) {
								$redirect = new CMS_href();
								$redirect->setInternalLink($alreadyFoldAction->getString('text'));
								$redirect->setLinkType(RESOURCE_LINK_TYPE_INTERNAL);
							} else {
								$redirect = new CMS_href($alreadyFoldAction->getString('text'));
							}
							if ($redirect->hasValidHREF()) {
								$href = $redirect->getHTML(false, MOD_CMS_FORMS_CODENAME, RESOURCE_DATA_LOCATION_PUBLIC, false, true);
								//needed in case of vars in redirection. Simple and double quotes are not welcome in this case !
								//$href = (strpos($href, '$') !== false) ? eval('return "'.str_replace(array('"',"'"),'',$href).'";') : $href;
								$href = eval('return "'.CMS_polymod_definition_parsing::preReplaceVars(curlyBracesVars($href)).'";');
								if ($href) {
									header("Location: ".$href);
									exit;
								}
							}
						} else {
							$cms_forms_msg[$form->getID()] .= $alreadyFoldAction->getString("text");
						}
					}
				}
			}
		}
	}
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<title>Automne 4 : Contact</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<?php echo CMS_view::getCSS(array('/css/common.css','/css/interieur.css'), 'screen');  ?>

	<!--[if lte IE 6]> 
	<link rel="stylesheet" type="text/css" href="/css/ie6.css" media="screen" />
	<![endif]-->
	<?php echo CMS_view::getJavascript(array('/js/sifr.js','/js/common.js','/js/CMS_functions.js'));  ?>

	<link rel="icon" type="image/x-icon" href="http://automne4/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://automne4" />
	<!-- load the style of cms_forms module -->
	<link rel="stylesheet" type="text/css" href="/css/modules/cms_forms.css" />

</head>
<body>
 <div id="main">
  <div id="container">
   <div id="header">
    
       
<a id="lienAccueil" href="http://automne4/web/fr/2-accueil.php" title="Retour à l'accueil">Retour à l'accueil</a>

      

   </div>
   <div id="backgroundBottomContainer">
    <div id="menuLeft">
     <ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_open "><a class="CMS_lvl1" href="http://automne4/web/fr/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_nosub "><a class="CMS_lvl2" href="http://automne4/web/fr/3-presentation.php">Présentation</a></li>
<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://automne4/web/fr/4-fonctionnalites.php">Fonctionnalités</a></li>
<li class="CMS_lvl2 CMS_nosub "><a class="CMS_lvl2" href="http://automne4/web/fr/5-actualite.php">Actualités</a></li>
<li class="CMS_lvl2 CMS_nosub "><a class="CMS_lvl2" href="http://automne4/web/fr/6-mediatheque.php">Médiathèque</a></li>
</ul>
</li>
</ul>

    </div>
    <div id="content" class="page9">
     <div id="breadcrumbs">
      <a href="http://automne4/web/fr/2-accueil.php">Accueil</a>
 &gt; 

     </div>
     <div id="title">
      <h1>Contact</h1>
     </div>
     
<div class="cms_forms">
	<?php $mod_cms_forms = array();
$mod_cms_forms["formID"] = '2';
$mod_cms_forms["type"] = 'formular';
$mod_cms_forms["id"] = 'cms_forms';
$mod_cms_forms["module"] = 'cms_forms';
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
// $Id: 9.php,v 1.1.1.1 2008/11/26 17:12:35 sebastien Exp $

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
$mod_cms_forms["pageID"] = '9';
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
</div>

     <a href="#header" id="top" title="haut de la page">Haut</a>
    </div>
    <div class="spacer"></div>
   </div>
  </div>
 </div>
 <div id="footer">
  <div id="menuBottom">
   <ul>
    <li><a href="http://automne4/web/fr/8-plan-du-site.php">Plan du site</a></li>
<li><a href="http://automne4/web/fr/9-contact.php">Contact</a></li>

   </ul>
   <div class="spacer"></div>
  </div>
 </div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat(); if (VIEW_SQL && isset($_SESSION["cms_context"]) && is_object($_SESSION["cms_context"])) {save_stat();}}  ?>
</body>
</html>