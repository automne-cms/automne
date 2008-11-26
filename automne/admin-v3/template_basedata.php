<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: template_basedata.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page template base data
  * Used to edit the templates base data.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 830);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_FILE", 831);
define("MESSAGE_PAGE_FIELD_EDITFILE", 832);
define("MESSAGE_PAGE_FIELD_IMAGE", 833);
define("MESSAGE_PAGE_FIELD_EDITIMAGE", 834);
define("MESSAGE_PAGE_EXISTING_IMAGE", 835);
define("MESSAGE_PAGE_EXISTING_IMAGE_NONE", 836);
define("MESSAGE_PAGE_FIELD_GROUPS", 837);
define("MESSAGE_PAGE_FIELD_GROUPS_NEW", 838);
define("MESSAGE_PAGE_FILE_ERROR", 839);
define("MESSAGE_PAGE_MALFORMED_DEFINITION_FILE", 840);
define("MESSAGE_PAGE_FIELD_COPY_FROM_TEMPLATE",948);
define("MESSAGE_PAGE_FIELD_NO_RIGHTS_ON_NEW_GROUPS", 1442);

//RIGHTS CHECK
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}

//in case of clone, get corresponding templarte
$templateID = CMS_pageTemplatesCatalog::getTemplateIDForCloneID($_REQUEST["template"]);
if ($_REQUEST["template"] != $templateID && sensitiveIO::isPositiveInteger($templateID)) {
	$_REQUEST["template"] = $templateID;
}
$template = CMS_pageTemplatesCatalog::getByID($_REQUEST["template"]);
$all_groups = CMS_pageTemplatesCatalog::getAllGroups();

//Action management	
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	$cms_message = "";
	if (!$_POST["label"] || (!$template->getID() && !$_FILES["file"]["name"] && !$_POST["templateToCopy"]) ) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		//we note that we are inserting a new template if it's the case
		$insertion = ($_REQUEST["template"]) ? false : true;
		$image_file = false;
		$definition_file = false;
		
        // Either a copy of a given template
        // or only changes in existing or new template
        if ($_POST["templateToCopy"] >= 1) {
			//Dupplicate selected template with given label
			$l = (trim($_POST["label"])) ? trim($_POST["label"]) : $cms_language->getMessage(949) ;
			$template = CMS_pageTemplatesCatalog::getCloneFromID($_POST["templateToCopy"], $l);
			
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$l." (edit base data)");
			
			header("Location: templates.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id() . '&' . $_SERVER["QUERY_STRING"]);
			exit;
        } else {
                //image upload management
                if ($_POST["edit_image"]) {
                     //remove the old file if any
                     if (is_file(PATH_TEMPLATES_IMAGES_FS."/".$template->getImage())) {
                             unlink(PATH_TEMPLATES_IMAGES_FS."/".$template->getImage());
                     }
                     if ($_FILES["image"]["name"]) {
                             //must write to persistence to get the article ID if insertion of an article
                             $template->writeToPersistence();
                             
                             $path = PATH_TEMPLATES_IMAGES_FS;
                             $filename = "pt".$template->getID()."_".SensitiveIO::sanitizeAsciiString($_FILES["image"]["name"]);
                             $image_file = $path."/".$filename;
                             if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_file)) {
                                     $cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
                                     $filename = '';
                             } else {
								 @chmod ($image_file, octdec(FILES_CHMOD));
							 }
                     } else {
                             $filename = '';
                     }
                     $template->setImage($filename);
                }
                //definition file upload management
                if ( ($_FILES["file"]["name"] && !$insertion && !$template->hasPages())
                        || ($insertion) ) {
                        //remove the old file if any
                        if (is_file(PATH_TEMPLATES_FS."/".$template->getDefinitionFile())) {
                                unlink(PATH_TEMPLATES_FS."/".$template->getDefinitionFile());
                        }
                        
                        //must write to persistence to get the article ID if insertion of an article
                        $template->writeToPersistence();
                        
                        $path = PATH_TEMPLATES_FS;
                        $filename = "pt".$template->getID()."_".SensitiveIO::sanitizeAsciiString($_FILES["file"]["name"]);
                        
                        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $path."/".$filename)) {
                                $cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
                                $filename = '';
                        } else {
							@chmod ($path."/".$filename, octdec(FILES_CHMOD));
						}
                        $template->setDebug(false);
                        $template->setLog(false);
                        $definition_file = $path."/".$filename;
                        if ($error = $template->setDefinitionFile($filename)) {
                                $cms_message = $cms_language->getMessage(MESSAGE_PAGE_MALFORMED_DEFINITION_FILE)."\n\n".$error;
                        }
                }
        }
		if ($cms_message) {
			//template edition missed ! Must delete uploaded files
			if ($image_file) {
				@unlink($image_file);
			}
			if ($definition_file) {
				@unlink($definition_file);
			}
			
			//if it's insertion time, must even delete the record
			if ($insertion) {
				$template->destroy();
				$template = CMS_pageTemplatesCatalog::getByID(0);
			}
		} else {
			//groups
			$template->delAllGroups();
			foreach ($all_groups as $aGroup) {
				if ($_POST["group_".$aGroup]) {
					$template->addGroup($aGroup);
				}
			}
			if ($_POST["newgroups"]) {
				$new_groups = array_map('trim',explode(";", $_POST["newgroups"]));
				foreach ($new_groups as $ng) {
					$template->addGroup($ng);
				}
				if ($_POST['nouserrights']) {
					CMS_profile_usersCatalog::denyTemplateGroupsToUsers($new_groups);
				}
			}
			
			//if it's an insertion set the label, else we rename the template and all of same type
			if ($insertion || $template->hasError()) {
				$template->setLabel($_POST["label"]);
			} else {
				$template->renameTemplate($_POST["label"]);
			}
			if (!$template->hasError()) {
				$template->writeToPersistence();
			}
			$log = new CMS_log();
			$log->logMiscAction(CMS_log::LOG_ACTION_TEMPLATE_EDIT, $cms_user, "Template : ".$template->getLabel()." (edit base data)");
			header("Location: templates.php?cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id() . '&' . $_SERVER["QUERY_STRING"]);
			exit;
		}
	}
	break;
}

$dialog = new CMS_dialog();
$dialog->setBackLink("templates.php?template=".$template->getID() . '&' . $_SERVER["QUERY_STRING"]);
$title = $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$dialog->setTitle($title);
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content = '
	<table border="0" cellpadding="3" cellspacing="2">
	<form action="'.$_SERVER["SCRIPT_NAME"].'?' . $_SERVER["QUERY_STRING"] . '" method="post" enctype="multipart/form-data">
	<input type="hidden" name="cms_action" value="validate" />
	<input type="hidden" name="template" value="'.$template->getID().'" />
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
		<td class="admin"><input type="text" size="30" class="admin_input_text" name="label" value="'.htmlspecialchars($template->getLabel()).'" /></td>
	</tr>
        ';

if ($template->getDefinitionFile()) {
	$content .= '
                <tr valign="top">
		        <td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE).'</td>
                        <td class="admin">'.$template->getDefinitionFile().'
                        <br />
                        <br /></td>
                </tr>';
} else {
	//Adding possibility to create a template from a copy of a published one
        $content .= '
	        <tr valign="top">
                        <td colspan="2"><br /></td>
                </tr>
                <tr valign="top">
		        <td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COPY_FROM_TEMPLATE).'</td>
                        <td class="admin">';
        $allTemplates = array() ;
        $allTemplates = CMS_pageTemplatesCatalog::getAll($includingNotUseables=true);
        if( sizeof($allTemplates)>0 ) {
                $content .= '
                        <select name="templateToCopy" size="1" class="admin_input_text">
                                <option value="0"> - </option>';
                        
                foreach($allTemplates as $tpl) {
                        $sel = ($_POST["templateToCopy"] === $tpl->getID()) ? ' selected="selected"' : '' ;
                        $content .= '<option value="'.$tpl->getID().'"'.$sel.'>'.$tpl->getLabel().'</option>';
                }
                $content .= '
                        </select>';
        }
        $content .= '</td>
               </tr>
               <tr colspan="2">
                       <td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
               </tr>';
        
        //Uploading a template file
        $content .= '
               <tr valign="top">
                        <td colspan="2"><br /></td>
               </tr>
               <tr valign="top">
		        <td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE).'</td>
                        <td class="admin"><input type="file" size="30" class="admin_input_text" name="file" /></td>
               </tr>';
        
}
//template groups
$content .= '
	<tr valign="top">
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_IMAGE).'</td>
		<td class="admin">
			<input type="file" size="30" class="admin_input_text" name="image" /><br />
			<input type="checkbox" class="admin_input_checkbox" name="edit_image" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITIMAGE).'
		</td>
	</tr>
	<tr valign="top">
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUPS).'</td>
		<td class="admin">
';
foreach ($all_groups as $aGroup) {
	$checked = ($template->belongsToGroup($aGroup)) ? ' checked="checked"' : '';
	$content .= '<input type="checkbox" class="admin_input_checkbox" name="group_'.$aGroup.'" id="group_'.$aGroup.'" value="1"'.$checked.' />&nbsp;<label for="group_'.$aGroup.'">'.$aGroup.'</label><br />';
}
$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_GROUPS_NEW).' : <input type="text" class="admin_input_text" size="30" name="newgroups" />
			&nbsp;<label for="noUserRights"><input type="checkbox" class="admin_input_checkbox" name="nouserrights" value="1" id="noUserRights" />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_NO_RIGHTS_ON_NEW_GROUPS).'</label>
		</td>
	</tr>
	<tr colspan="2">
		<td class="admin"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';
//Image
if ($template->getID()) {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE).'<br />';
	if ($img = $template->getImage()) {
		$content .= '<img src="'.PATH_TEMPLATES_IMAGES_WR."/".$img.'" border="0" />';
	} else {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_EXISTING_IMAGE_NONE);
	}
}
$content .= "<br />";

$dialog->setContent($content);
$dialog->show();
?>