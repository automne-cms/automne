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
// $Id: mod_cms_forms_header.php,v 1.17 2010/03/08 16:44:52 sebastien Exp $

/**
  * Template CMS_forms_header
  *
  * Represent a header template for module cms_forms
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
$mod_cms_forms["pageID"] = $parameters['pageID'] = '{{pageID}}';

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
		'cache'		=> false,
		'public'	=> true,
		'pageID'	=> $mod_cms_forms["pageID"],
		'language'	=> $language
	);
	return $definition->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
}

// Detect and parse mail string vars, if present
function detectAndParseString($string){

	$pattern = '/##([a-zA-Z0-9]+)##/';
	preg_match_all($pattern, $string, $aMatches);
	
	if(!empty($aMatches)){
		foreach($aMatches as $aValues){
			foreach($aValues as $key => $val){
				if(isset($_POST[$aMatches[1][$key]])) {
					$string = str_replace($aMatches[0][$key], $_POST[$aMatches[1][$key]], $string);
				}
				else {
					$string = str_replace($aMatches[0][$key], '', $string);	
				}				
			}
		}
	}

	return $string;
}

$separator = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? "\xa7\xa7" : "\xc2\xa7\xc2\xa7";

//if page has forms
if (is_array($mod_cms_forms["usedforms"]) && $mod_cms_forms["usedforms"]) {
	$sender = CMS_forms_sender::getSenderForContext();
	foreach($mod_cms_forms["usedforms"] as $formID) {
		$form = new CMS_forms_formular($formID);
		$cms_forms_msg[$form->getID()] = $cms_forms_error_msg[$form->getID()] = $cms_forms_token[$form->getID()] = '';
		//if form exists and is public
		if ($form->getID() && $form->isPublic()) {
			/***********************************************************
			*                     LOGIN ATTEMPT                        *
			***********************************************************/
			//check for authentification action in form
			if ($form->getActionsByType(CMS_forms_action::ACTION_AUTH)) {
				//check for valid session / logout attempt
				if (io::request('logout') == 'true' || io::request('logout') == 1) {
					// Disconnect user
					CMS_session::authenticate(array('disconnect'=> true));
					//then reload current page (to load public user)
					CMS_view::redirect($_SERVER["SCRIPT_NAME"]);
				} elseif (isset($cms_user) && $cms_user->getUserId() != ANONYMOUS_PROFILEUSER_ID) {
					//declare form ok action
					$cms_forms_okAction[$form->getID()] = true;
				} else {
					//launch authentification process (for modules which can use it)
					CMS_session::authenticate(array('authenticate' => true));
					//load current user if exists
					$cms_user = CMS_session::getUser();
					if ($cms_user) {
						$cms_language = $cms_user->getLanguage();
						//declare form ok action
						if ($cms_user->getUserId() != ANONYMOUS_PROFILEUSER_ID) {
							$cms_forms_okAction[$form->getID()] = true;
						}
					} else {
						unset($cms_user);
					}
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
						//analyse url to get page if any
						$redirectPage = CMS_tree::analyseURL($url);
						if ($redirectPage) {
							//if page found, check existence and rights
							$pageID = $redirectPage->getID();
							if ($redirectPage->hasError() || !CMS_tree::pagesExistsInUserSpace($pageID) || 
									(APPLICATION_ENFORCES_ACCESS_CONTROL && (!isset($cms_user) || !$cms_user->hasPageClearance($pageID, CLEARANCE_PAGE_VIEW)))
								) {
								$url = PATH_FORBIDDEN_WR;
							}
						}
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
				if (!isset($_POST["atm-token"]) || !CMS_session::checkToken(MOD_CMS_FORMS_CODENAME, $_POST["atm-token"])) {
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
											case 'url':
												//check if value start with http
												if ($_POST[$aField->getAttribute('name')] && substr($_POST[$aField->getAttribute('name')], 0, 4) != 'http') {
													$cms_forms_malformed[$form->getID()][] = $aField->getAttribute('name');
												}
											case 'textarea':
											case 'text':
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
												//move uploaded file
												$fileDatas = CMS_file::uploadFile($aField->getAttribute('name'), PATH_TMP_FS);
												if ($fileDatas['error']) {
													$filename = '';
												}
												if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $filepath."/".$filename)) {
													$filename = '';
												}
												$_FILES[$aField->getAttribute('name')]['atm_name'] = $filename;
												
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
								$texts = explode($separator, $action->getString("text"));
								//create email body
								$body = '';
								$bodyHtml = '';
								foreach ($fields as $aField) {
									if ((($aField->getAttribute('type') != 'file' && isset($_POST[$aField->getAttribute('name')]) && $_POST[$aField->getAttribute('name')]) || ($aField->getAttribute('type') == 'file' && $_FILES[$aField->getAttribute('name')]['name']))
										&& $aField->getAttribute('type') != 'submit' ) {
										//insert datas of each field
										if ($aField->getAttribute('type') == 'file') {
											$filepath = PATH_MODULES_FILES_WR.'/'.MOD_CMS_FORMS_CODENAME;
											$mainurl = CMS_websitesCatalog::getMainURL();
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $mainurl.$filepath.'/'.$_FILES[$aField->getAttribute('name')]['atm_name']."\n\n";
											$bodyHtml .= ($aField->getAttribute('label')) ? '<strong>'.$aField->getAttribute('label').' : </strong>' : '';
											$bodyHtml .= $mainurl.$filepath.'/'.$_FILES[$aField->getAttribute('name')]['atm_name']."<br />";
										} elseif ($aField->getAttribute('type') != 'checkbox' && $aField->getAttribute('type') != 'select') {
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $_POST[$aField->getAttribute('name')]."\n\n";
											$bodyHtml .= ($aField->getAttribute('label')) ? '<strong>'.$aField->getAttribute('label').' : </strong>' : '';
											$bodyHtml .= $_POST[$aField->getAttribute('name')]."<br />";
										} elseif ($aField->getAttribute('type') == 'select') {
											$optionsLabels = $aField->getAttribute('options');
											$body .= ($aField->getAttribute('label')) ? $aField->getAttribute('label').' : ' : '';
											$body .= $optionsLabels[$_POST[$aField->getAttribute('name')]]."\n\n";
											$bodyHtml .= ($aField->getAttribute('label')) ? '<strong>'.$aField->getAttribute('label').' : </strong>' : '';
											$bodyHtml .= $optionsLabels[$_POST[$aField->getAttribute('name')]]."<br />";
										} else {
											$body .= ' - '.$aField->getAttribute('label')."\n\n";
											$bodyHtml .= ' - '.$aField->getAttribute('label')."<br />";
										}
									}
								}
								//append header and footer texts if any to body text
								if (isset($texts[1])) { // header
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$header = evalPolymodVars($texts[1], $form_language->getCode());
									$header = detectAndParseString($header);

									$body = $header."\n\n".$body;
									$bodyHtml = '<div class="important">'.nl2br($header)."</div>".$bodyHtml;
								}
								if (isset($texts[2])) { //footer
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$footer = evalPolymodVars($texts[2], $form_language->getCode());
									$footer = detectAndParseString($footer);

									$body = $body."\n\n". $footer;
									$bodyHtml = $bodyHtml.'<div class="important">'.nl2br($footer)."</div>";
								}
								$email->setBody($body);
								
								//create subject
								if ($texts[0]) { //from DB if any
									//needed in case of vars in text. Simple and double quotes are not welcome in this case !
									$subject = evalPolymodVars($texts[0], $form_language->getCode());
									$subject = detectAndParseString($subject);

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
								// set template
								if (isset($texts[4]) && is_file(PATH_TEMPLATES_FS. '/mail/' . $texts[4])) {
									$email->setEmailHTML($bodyHtml);
									$email->setTemplate(PATH_TEMPLATES_FS . '/mail/' . $texts[4]);
								}
								//and send emails
								if ($action->getInteger('type') == CMS_forms_action::ACTION_EMAIL) {
									$emailAddresses = array_map('trim',explode(';',io::decodeEntities($action->getString("value"))));
								} elseif ($action->getInteger('type') == CMS_forms_action::ACTION_FIELDEMAIL) {
									$emailAddresses = array_map('trim',explode(';',$_POST[$fields[$action->getString("value")]->getAttribute('name')]));
								}
								if ($emailAddresses) {
									foreach ($emailAddresses as $emailAddress) {
										$emailAddress = evalPolymodVars($emailAddress, $form_language->getCode());
										if (sensitiveIO::isValidEmail($emailAddress)) {
											$email->setEmailTo($emailAddress);
											$email->sendEmail();
										}
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
										
										//Auth parameters
										$params = array(
											'login'		=> $login,
											'password'	=> $password,
											'remember'	=> ($permanent ? true : false)
										);
										CMS_session::authenticate($params);
										$user = CMS_session::getUser();
										if ($user && $user->getUserId() != ANONYMOUS_PROFILEUSER_ID) {
											$cms_user = $user;
											$cms_language = $cms_user->getLanguage();
										} else {
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
							case CMS_forms_action::ACTION_SPECIFIC_PHP :
								//load specific PHP code
								if ($action->getString("value") && file_exists(PATH_TEMPLATES_FS.'/'.$action->getString("value"))) {
									include(PATH_TEMPLATES_FS.'/'.$action->getString("value"));
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
