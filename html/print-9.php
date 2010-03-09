<?php //Generated on Tue, 09 Mar 2010 15:58:46 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://automne4.401/web/demo/print-9-contact.php', true, 301);
}
 ?>
<?php $mod_cms_forms = array();
$mod_cms_forms["module"] = 'cms_forms';
$mod_cms_forms["id"] = 'cms_forms_header';
$mod_cms_forms["type"] = 'header';
$mod_cms_forms["usedforms"] = array (
  0 => '2',
);
 ?>
<?php // +----------------------------------------------------------------------+
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
// $Id: mod_cms_forms_header.php,v 1.17 2010/03/08 16:44:52 sebastien Exp $

/**
  * Template CMS_forms_header
  *
  * Represent a header template for module cms_forms
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
//Requirements
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

//force loading module cms_forms
if (!class_exists('CMS_module_cms_forms')) {
	die('Cannot find cms_forms module ...');
}

//set current page ID
$mod_cms_forms["pageID"] = $parameters['pageID'] = '9';

//little function to enclose PHP vars with curly braces to avoid errors with array indexes
function curlyBracesVars($text) {
	return preg_replace('#(\s)(\$[a-zA-Z0-9_\[\]\'-]*)#','\\1".\\2."',$text);
}
//eval polymod vars in all forms actions
function evalPolymodVars($text, $language){
	global $mod_cms_forms;
	$definition = new CMS_polymod_definition_parsing($text, true);
	$parameters = array(
		'module'	=> MOD_CMS_FORMS_CODENAME,
		'public'	=> true,
		'pageID'	=> $mod_cms_forms["pageID"],
		'language'	=> $language
	);
	return $definition->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
}

$separator = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? "\xa7\xa7" : "\xc2\xa7\xc2\xa7";

//if page has forms
if (is_array($mod_cms_forms["usedforms"]) && $mod_cms_forms["usedforms"]) {
	$sender = CMS_forms_sender::getSenderForContext((isset($_SESSION["cms_context"]) ? $_SESSION["cms_context"] : false));
	foreach($mod_cms_forms["usedforms"] as $formID) {
		$form = new CMS_forms_formular($formID);
		$cms_forms_msg[$form->getID()] = $cms_forms_error_msg[$form->getID()] = $cms_forms_token[$form->getID()] = '';
		//if form exists and is public
		if ($form->getID() && $form->isPublic()) {
			/***********************************************************
			*                   AUTOLOGIN ATTEMPT                      *
			***********************************************************/
			//check for authentification action in form
			if ($form->getActionsByType(CMS_forms_action::ACTION_AUTH)) {
				//check for valid session / logout attempt / and autologin
				//CMS_grandFather::log('Forms ok1');
				if (!isset($_SESSION["cms_context"]) || (isset($_SESSION["cms_context"]) && !is_a($_SESSION["cms_context"], 'CMS_context')) || (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == 'true')) {
					/*@session_destroy();
					start_atm_session();*/
					//CMS_grandFather::log('Forms ok2');
					if ((!isset($_REQUEST["logout"]) || (isset($_REQUEST["logout"]) && $_REQUEST["logout"] != 'true')) && CMS_context::autoLoginSucceeded()) {
						//declare form ok action
						$cms_forms_okAction[$form->getID()] = true;
						//CMS_grandFather::log('Forms ok3');
					} elseif (isset($_REQUEST["logout"]) && $_REQUEST["logout"] == 'true') {
						// Reset cookie
						CMS_context::resetSessionCookies();
						//then reload current page (to load public user)
						//CMS_grandFather::log('Forms ok4');
						CMS_view::redirect($_SERVER["SCRIPT_NAME"]);
					}
				}
				//CMS_grandFather::log('Forms ok5');
				if (isset($_SESSION["cms_context"]) && is_a($_SESSION["cms_context"], 'CMS_context') && (!isset($_REQUEST["logout"]) || (isset($_REQUEST["logout"]) && $_REQUEST["logout"] != 'true')) && CMS_context::autoLoginSucceeded()) {
					//CMS_grandFather::log('Forms ok6');
					//declare form ok action
					$cms_forms_okAction[$form->getID()] = true;
				}
				//get form ok action
				$actions = $form->getActionsByType(CMS_forms_action::ACTION_FORMOK);
				$action = array_shift($actions);
				//check if form ok send to a page and if user has rights for this page
				if (isset($cms_user) && is_object($cms_user) && $action->getString("value") == "page") {
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
						} else {
							//declare form not action
							$cms_forms_okAction[$form->getID()] = false;
						}
					}
				}
				//then launch form ok action if needed
				if (isset($cms_forms_okAction[$form->getID()]) && $cms_forms_okAction[$form->getID()]) {
					//if we have an encoded referer, use it
					if (isset($_REQUEST['referer']) && $_REQUEST['referer'] && ($url = base64_decode($_REQUEST['referer']))) {
						CMS_view::redirect($url);
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
								CMS_view::redirect($href);
							}
						}
					} else { //append message to form message
						$cms_forms_msg[$form->getID()] .= nl2br($action->getString("text")).'<br />';
					}
				}
			}
			/***********************************************************
			*                    FORM SUBMISSION                       *
			***********************************************************/
			//if form has been submited
			if (isset($_POST["formID"]) && $_POST["formID"] == $formID && $_POST["cms_action"] == 'validate') {
				$form_language = $form->getLanguage();
				//check form token
				if (!isset($_POST["atm-token"]) || !CMS_context::checkToken(MOD_CMS_FORMS_CODENAME, $_POST["atm-token"])) {
					$cms_forms_token[$form->getID()] = true;
				}
				//check for required fields
				$fields = $form->getFields(true);
				//Proceed actions
				$actions = $form->getActions();
				if (!$cms_forms_token[$form->getID()] && is_array($actions) && $actions) {
					foreach ($actions as $action) {
						switch ($action->getInteger('type')) {
							case CMS_forms_action::ACTION_ALREADY_FOLD:
								//check if form is already folded by sender
								if (isset($sender) && $form->isAlreadyFolded($sender)) { 
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
													CMS_view::redirect($href);
												}
											}
										} else {
											if ($alreadyFoldAction->getString("text")) {
												$cms_forms_msg[$form->getID()] .= nl2br($alreadyFoldAction->getString("text"));
											}
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
									if(($aField->getAttribute('type') != 'file' && isset($_POST[$aField->getAttribute('name')]) && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name'])) {
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
												if (!in_array(io::decodeEntities($_POST[$aField->getAttribute('name')]), array_keys($aField->getAttribute('options')))) {
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
												} else {
												    // Check by params
												    $fileParams = $aField->getAttribute('params');
												    $fileInfo = pathinfo($_FILES[$aField->getAttribute('name')]['name']);
												    $badParam = false;
												    if(!$badParam && isset($fileParams['extensions']) && $fileParams['extensions']){
												        $allowedExtensions = explode(',', $fileParams['extensions']);
												        $allowedExtensions = array_map('trim', $allowedExtensions);
												        if(!$fileInfo['extension'] || !in_array($fileInfo['extension'], $allowedExtensions)){
												            $badParam = true;
												            $cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												        }
												    }
												    if(!$badParam && isset($fileParams['weight']) && $fileParams['weight']){
												        if($_FILES[$aField->getAttribute('name')]['size'] >= ($fileParams['weight'] * 1024)){
												            $badParam = true;
												            $cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												        }
												    }
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
												CMS_view::redirect($href);
											}
										}
									} else { //append message to form error message
										if ($action->getString("text")) {
											$cms_forms_error_msg[$form->getID()] .= nl2br($action->getString("text")).'<br />';
										}
									}
									break 2; //then quit actions loop
								}
							break;
							case CMS_forms_action::ACTION_DB:
								//create id for sender if not already have one
								if (isset($sender) && !$sender->getID()) {
									$sender->writeToPersistence();
								}
								if (isset($sender) && $sender->getID()) {
									foreach ($fields as $aField) {
										//insert datas of each field
										if ((($aField->getAttribute('type') != 'file' && isset($_POST[$aField->getAttribute('name')]) && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name']))
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
													//check uploaded file
													$tmp = new CMS_file($filepath.'/'.$filename);
													if (!$tmp->checkUploadedFile()) {
														$tmp->delete();
														$filename = '';
													}
													unset($tmp);
													$_FILES[$aField->getAttribute('name')]['atm_name'] = $filename;
												}
												$fieldRecord->setAttribute('value', @$_FILES[$aField->getAttribute('name')]['atm_name']);
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
								$texts = explode($separator, $action->getString("text"));
								//create email body
								$body = '';
								foreach ($fields as $aField) {
									if ((($aField->getAttribute('type') != 'file' && isset($_POST[$aField->getAttribute('name')]) && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name']))
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
								if (isset($texts[1])) { // header
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$body = evalPolymodVars($texts[1], $form_language->getCode())."\n\n".$body;
								}
								if (isset($texts[2])) { //footer
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$body = $body."\n\n". evalPolymodVars($texts[2], $form_language->getCode());
								}
								$email->setBody($body);
								
								//create subject
								if ($texts[0]) { //from DB if any
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$subject = evalPolymodVars($texts[0], $form_language->getCode());
								} else { // or default subject
									$subject = $form_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_EMAIL_SUBJECT, array($form->getAttribute('name'), APPLICATION_LABEL), MOD_CMS_FORMS_CODENAME);
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
									$emailAddresses = array_map('trim',explode(';',io::decodeEntities($action->getString("value"))));
									foreach ($emailAddresses as $emailAddress) {
										$emailAddress = evalPolymodVars($emailAddress, $form_language->getCode());
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
								if (isset($values[0]) && isset($fields[$values[0]]) && is_object($fields[$values[0]])) {
									$login = $_POST[$fields[$values[0]]->getAttribute('name')];
								}
								if (isset($values[1]) && isset($fields[$values[1]]) && is_object($fields[$values[1]])) {
									$password = $_POST[$fields[$values[1]]->getAttribute('name')];
								}
								if (isset($values[2]) && isset($fields[$values[2]]) && is_object($fields[$values[2]])) {
									$permanent = @$_POST[$fields[$values[2]]->getAttribute('name')];
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
											if ($action->getString("text")) {
												$cms_forms_error_msg[$form->getID()] .= nl2br($action->getString("text")).'<br />';
											}
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
									CMS_view::redirect($url);
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
											CMS_view::redirect($href);
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
				if (isset($sender) && $form->isAlreadyFolded($sender)) { 
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
									CMS_view::redirect($href);
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
 ?>
<?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Contact</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Contact</h1>
<h3>

		&raquo;&nbsp;Contact
		
</h3>


<div class="text"><p>Ce formulaire vous permet d'envoyer une demande de contact. Pour le transformer (Champs, actions, email de destination), modifiez le dans les propri&eacute;t&eacute;s du module &quot;Formulaire&quot;.</p><p>&nbsp;</p></div>


<div class="cms_forms">
	<?php $mod_cms_forms = array();
$mod_cms_forms["module"] = 'cms_forms';
$mod_cms_forms["id"] = 'cms_forms';
$mod_cms_forms["type"] = 'formular';
$mod_cms_forms["formID"] = '2';
   ?>
<?php // +----------------------------------------------------------------------+
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
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Requirements
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
//force loading module cms_forms
if (!class_exists('CMS_module_cms_forms')) {
	die('Cannot find cms_forms module ...');
}

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
	if (isset($cms_forms_token[$form->getID()]) && $cms_forms_token[$form->getID()]) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_TOKEN_EXPIRED, false, MOD_CMS_FORMS_CODENAME);
	}
	//Create or append (from header) form required message
	if (isset($cms_forms_required[$form->getID()]) && $cms_forms_required[$form->getID()] && is_array($cms_forms_required[$form->getID()])) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_REQUIRED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_required[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
		}
		$cms_forms_error_msg[$form->getID()] .= '</ul>';
	}
	//Create or append (from header) form malformed message
	if (isset($cms_forms_malformed[$form->getID()]) && $cms_forms_malformed[$form->getID()] && is_array($cms_forms_malformed[$form->getID()])) {
		$cms_forms_error_msg[$form->getID()] .= $cms_language->getMessage(CMS_forms_formular::MESSAGE_CMS_FORMS_MALFORMED_FIELDS, false, MOD_CMS_FORMS_CODENAME).'<ul>';
		foreach ($cms_forms_malformed[$form->getID()] as $fieldName) {
			$field = $form->getFieldByName($fieldName, true);
			$cms_forms_error_msg[$form->getID()] .= '<li>'.$field->getAttribute('label').'</li>';
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
			echo $form->getContent(CMS_forms_formular::ALLOW_FORM_SUBMIT);
		}
	}
	if (isset($cms_forms_msg[$form->getID()]) && $cms_forms_msg[$form->getID()]) {
		echo '<div class="cms_forms_msg">'.evalPolymodVars($cms_forms_msg[$form->getID()], $cms_language->getCode()).'</div>';
	}
}
   ?>
</div>
<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Contact" (http://automne4.401/web/demo/9-contact.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>