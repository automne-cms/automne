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
// | Author: Frederico Caldeira Knabben (fredck@fckeditor.net)            |
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cms_forms.php,v 1.5 2010/03/08 16:44:19 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create cms_forms module wizard
  *
  * @package Modules
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//for this page, HTML output compression is not welcome.
define("ENABLE_HTML_COMPRESSION", false);
require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);
require_once(PATH_MODULES_FS."/cms_forms.php");
//add polymod requirement
require_once(PATH_MODULES_FS."/polymod.php");

define("MESSAGE_PAGE_TITLE", 932);
define("MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION", 1705);

$step = (isset($_POST["step"])) ? $_POST["step"]:1;

$content = '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Forms Wizard</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo APPLICATION_DEFAULT_ENCODING; ?>" />
		<meta name="robots" content="noindex, nofollow" />
		<script src="../../editor/dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="cms_forms.js" type="text/javascript"></script>
		<style type="text/css">
			th span {
				font-size:12px;
			}
			ul.sortable {
				padding:			0px 0px 0px 0px;
				margin:				0px;
			}
			ul.sortable li {
				padding:			0px 0px 0px 0px;
				margin:				0px;
				list-style: 		none;
				position: 			relative;
			}
			.handle {
				cursor: move;
			}
			/* ROW COMMENTS */
			.rowComment{
				font-size:			12px;
				font-weight:		normal;
				color:				#000000;
			}
			.rowComment h1{
				font-size:			15px;
				font-weight:		bold;
				color:				#9FD143;
				padding:			5px 0 5px 0;
				text-decoration:	underline;
			}
			.rowComment h2{
				font-size:			14px;
				font-weight:		bold;
				color:				#9DD03E;
				padding:			5px 0 5px 0;
				text-decoration:	underline;
			}
			.rowComment h3{
				font-size:			13px;
				font-weight:		bold;
				color:				#333333;
				padding:			5px 0 5px 0;
				text-decoration:	underline;
			}
			.rowComment .code{
				display:			block;
				width:				95%;
				font-size:			12px;
				font-weight:		normal;
				color:				#000000;
				background-color:	#EEEEEE;
				border:				solid 1px #CCCCCC;
				padding:			10px;
				white-space:		nowrap;
				overflow:			auto;
				
			}
			.keyword{
				font-size:			12px;
				font-weight:		bold;
				color:				#BB1111;
			}
			.code .keyword{
				font-size:			12px;
				font-weight:		normal;
				font-style:			italic;
				color:				#BB1111;
			}
			.rowComment ul{
				padding:			10px 0 0 0;
				margin:				10px 0 0 10px;
			}
			.rowComment li{
				padding:			0 0 3px 10px;
			}
			.vertclair{
				color:				#339900;
			}
			.retrait{
				margin:				0 0 0 10px;
			}
		</style>
	</head>
	<body>
		<!--<script language="JavaScript" type="text/javascript">window.name = "cms_forms";</script>-->
<?php
// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($step) {
	case 2:
		//analyse the form from his xhtml code
		if (!($formTags = CMS_forms_field::analyseForm($_POST))) {
			$errorMsg = 'DlgCMSFormsCopyError';
			//then go to error window
			$step = 5;
			break;
		}
	break;
	case 3:
		//analyse the form from his posted values
		$formTags = array();
		$formTags['form'] = new CMS_forms_formular($_POST["formId"]);
		$fieldIds = explode(',',$_POST["fieldIds"]);
		$count = 0;
		if (sizeof($fieldIds) && $fieldIds[0]) {
			foreach ($fieldIds as $aFieldId) {
				$formTags[$aFieldId] = new CMS_forms_field($aFieldId,$_POST["formId"]);
				$formTags[$aFieldId]->setAttribute("type",$_POST["type_".$aFieldId]);
				$formTags[$aFieldId]->setAttribute("name",$_POST["name_".$aFieldId]);
				$formTags[$aFieldId]->setAttribute("label",$_POST["label_".$aFieldId]);
				$formTags[$aFieldId]->setAttribute("value",$_POST["defaultValue_".$aFieldId]);
				$formTags[$aFieldId]->setAttribute("required",$_POST["required_".$aFieldId]);
				
				//Set params
				$params = array();
				if(isset($_POST['fileParamsExtensions_'.$aFieldId]) && $_POST['fileParamsExtensions_'.$aFieldId]){
				    $params['extensions'] = $_POST['fileParamsExtensions_'.$aFieldId];
				}
				if(isset($_POST['fileParamsWeight_'.$aFieldId]) && $_POST['fileParamsWeight_'.$aFieldId]){
				    $params['weight'] = $_POST['fileParamsWeight_'.$aFieldId];
				}
				$formTags[$aFieldId]->setAttribute("params", $params);
				
				$options = array();
				$optionsValues = explode ('||',$_POST["selectValues_".$aFieldId]);
				$optionsLabels = explode ('||',$_POST["selectLabels_".$aFieldId]);
				if (sizeof($optionsValues) && sizeof($optionsLabels)) {
					foreach ($optionsValues as $key => $value) {
						$options[$value] = $optionsLabels[$key];
					}
				}
				$formTags[$aFieldId]->setAttribute("options",$options);
				$formTags[$aFieldId]->setAttribute("order",$count);
				$formTags[$aFieldId]->writeToPersistence();
				$count++;
			}
		}
		
		switch ($_POST["cms_action"]) {
			case "deleteField":
				if (is_a($formTags[$_POST["deleteField"]],"CMS_forms_field")) {
					$formTags[$_POST["deleteField"]]->desactivate();
					$formTags[$_POST["deleteField"]]->writeToPersistence();
					unset($formTags[$_POST["deleteField"]]);
				}
			break;
			case "addField":
				$newField = new CMS_forms_field('',$_POST["formId"]);
				$newField->setAttribute("type",$_POST["type_new"]);
				$newField->setAttribute("label",$_POST["label_new"]);
				if (isset($_POST["required_new"])) {
					$newField->setAttribute("required",$_POST["required_new"]);
				}
				$newField->writeToPersistence();
				//generate unique name
				$newField->setAttribute("name",md5($_POST["label_new"].$_POST["type_new"].@$_POST["required_new"].microtime()));
				$aFieldId = $newField->getID();
				$formTags[$aFieldId] = $newField;
				$formTags[$aFieldId]->setAttribute("order",$count++);
				$formTags[$aFieldId]->writeToPersistence();
			break;
			case "validate" :
				//generate form xhtml code
				$xhtmlFieldMask = 
					'<tr>'."\n".
					'<td style="text-align:right;">{{label}}</td>'."\n".
					'<td>{{input}}</td>'."\n".
					'</tr>';
				$xhtml = '<form id="cms_forms_'.$formTags['form']->getID().'">';
				//hidden form fields on top
				foreach ($formTags as $aFormField) {
					if (is_a($aFormField,"CMS_forms_field")) {
						//generate field id datas
						$fieldIDDatas = $aFormField->generateFieldIdDatas();
						switch ($aFormField->getAttribute("type")) {
							case 'hidden':
								list($label, $input) = $aFormField->getFieldXHTML($formTags['form']->getLanguage());
								$xhtml .= $input;
							break;
						}
					}
				}
				$xhtml .= 
				'<table cellspacing="1" cellpadding="1" width="100%" align="center" border="0">';
				foreach ($formTags as $aFormField) {
					if ($aFormField->getAttribute("type") != 'hidden') {
						$label = $input = '&nbsp;';
						if (is_a($aFormField,"CMS_forms_field")) {
							list($label, $input) = $aFormField->getFieldXHTML($formTags['form']->getLanguage());
							//put the label after the input for the checkbox
							if ($aFormField->getAttribute("type") == 'checkbox') {
								$input .= $label;
								$label = '&nbsp;';
							}
							if ($input) {
								$xhtml .= str_replace(array('{{label}}','{{input}}'),array($label,$input),$xhtmlFieldMask);
							}else{ 
								$xhtml .= '<tr class="fieldset"><td colspan="2">'.$label.'</td></tr>'; 
							}
						}
					}
				}
				$xhtml .= '</table>'."\n".
				'</form>';
				//then go to next step (send xhtml to wysiwyg)
				$step = 4;
			break;
		}
	break;
}

// +----------------------------------------------------------------------+
// | Rendering                                                            |
// +----------------------------------------------------------------------+
switch ($step) {
	case 1:
		// used to send wysiwyg form content to server before analysis
		$content = '
			<div id="divInfo" style="DISPLAY: none">
				<form id="analyseForm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
					<input id="step" type="hidden" name="step" value="2" />
					<input id="formCode" name="formCode" value="" type="hidden" />
					<input id="formId" name="formId" value="" type="hidden" />
				</form>
				<script type="text/javascript">
					<!--
						getFormCode();
					//-->
				</script>
			</div>';
	break;
	case 2:
	case 3:
		$fieldTypes = array (
			"fieldset"	=> "<span fckLang=\"DlgCMSFormsFieldset\">Groupe de champs</span>",
			"text"		=> "<span fckLang=\"DlgCMSFormsText\">Texte</span>",
			"email" 	=> "<span fckLang=\"DlgCMSFormsTextEmail\">Texte (Email)</span>",
			"integer" 	=> "<span fckLang=\"DlgCMSFormsTextInteger\">Texte (Chiffres)</span>",
			"url" 		=> "<span fckLang=\"DlgCMSFormsTextURL\">Texte (URL)</span>",
			"pass" 		=> "<span fckLang=\"DlgCMSFormsTextPass\">Texte (Mot de passe)</span>",
			"file" 		=> "<span fckLang=\"DlgCMSFormsFile\">Fichier joint</span>",
			"textarea" 	=> "<span fckLang=\"DlgCMSFormsTextarea\">Zone de texte</span>",
			"select" 	=> "<span fckLang=\"DlgCMSFormsSelect\">Selection multiple</span>",
			"checkbox" 	=> "<span fckLang=\"DlgCMSFormsCheckbox\">Case &agrave; cocher</span>",
			"hidden" 	=> "<span fckLang=\"DlgCMSFormsHidden\">Champ cach&eacute;</span>",
			"submit" 	=> "<span fckLang=\"DlgCMSFormsSubmit\">Bouton valider</span>",
		);
		$content = '
			<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/coordinates.js"></script>
			<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/drag.js"></script>
			<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/dragsort.js"></script>
			<script language="JavaScript" type="text/javascript">
				<!--
				function sortList() {
					if(document.getElementById("sortField")) {
						DragSort.makeListSortable(document.getElementById("sortField"));
						//set Handle (only for gecko)
						if (document.getElementById("sortField").hasAttribute) {
							var sortableItems = document.getElementById("sortField").getElementsByTagName("li");
							for (var i = 0; i < sortableItems.length; i++) {
								DragSort.makeItemSortable(sortableItems[i]);
								sortableItems[i].setDragHandle(findHandle(sortableItems[i]));
							}
						}
					}
				};
				function stopDragging() {
					getNewOrder();
					return true;
				}
				function getNewOrder() {
					var sortField = document.getElementById("sortField");
					fieldArray = sortField.getElementsByTagName("li");
					var newOrder;
					for (var i=0; i<fieldArray.length; i++) {
						var fid = fieldArray[i].id.substr(2);
						newOrder = (newOrder) ? newOrder + "," + fid : fid;
					}
					GetE(\'fieldIds\').value=newOrder;
					return true;
				}
				function findHandle(item) {
					var children = item.getElementsByTagName("span");
					for (var i = 0; i < children.length; i++) {
						var child = children[i];
							if (!child.hasAttribute("class")) continue;
							
							if (child.getAttribute("class").indexOf("handle") >= 0)
								return child;
					}
					return null;
				}
				//-->
			</script>
			<div id="divInfo" style="DISPLAY: none">
				<form id="modifyForm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
					<input id="step" type="hidden" name="step" value="3" />
					<input id="cms_action" type="hidden" name="cms_action" value="validate" />
					<input id="deleteField" type="hidden" name="deleteField" value="" />
					<input id="formId" type="hidden" name="formId" value="'.$formTags['form']->getID().'" />';
		$countFields=0;
		$fieldIdsValues = '';
		foreach ($formTags as $aFormField) {
			if (is_a($aFormField,"CMS_forms_field")) {
				if (!$countFields) {
					$content .= '
					<table border="0" cellspacing="1" cellpadding="0" width="100%">
						<tr>
							<th align="right"><span fckLang="DlgCMSFormsRequire">Requis</span></th>
							<th width="130"><span fckLang="DlgCMSFormsLabel">Libell&eacute;</span></th>
							<th width="130"><span fckLang="DlgCMSFormsType">Type</span></th>
							<th width="60"><span fckLang="DlgCMSFormsOptions">Options</span></th>
							<th width="50"><span fckLang="DlgCMSFormsActions">Actions</span></th>
						</tr>
					</table>
					<ul id="sortField" class="sortable">';
				}
				$content .= '
				<li id="f_'.$aFormField->getID().'">
				<table border="0" cellspacing="1" cellpadding="0" width="100%">
					<tr>';
				$required = ($aFormField->getAttribute("required")) ? ' checked="checked"':'';
				$content .= '
						<td align="right"><input type="checkbox" name="required_'.$aFormField->getID().'" value="1"'.$required.' /></td>
						<td align="center" width="130"><input type="text" name="label_'.$aFormField->getID().'" value="'.htmlspecialchars(io::decodeEntities($aFormField->getAttribute("label"))).'" /><input type="hidden" name="name_'.$aFormField->getID().'" value="'.$aFormField->getAttribute("name").'" /></td>
						<td align="center" width="130">
							<select name="type_'.$aFormField->getID().'" onchange="viewHideOptionsButton(this,\'options_'.$aFormField->getID().'\');">';
						foreach ($fieldTypes as $aFieldType => $aFieldTypeLabel) {
							$selected = ($aFormField->getAttribute("type") == $aFieldType) ? ' selected="selected"':'' ;
							$content .= '<option value="'.$aFieldType.'"'.$selected.'>'.$aFieldTypeLabel.'</option>';
						}
				$content .= '
							</select>
						</td>
						<td align="center" width="60">';
				
				$selectValues = '';
				$selectLabels = '';
				$countOptions=0;
				if (sizeof($aFormField->getAttribute("options"))) {
					foreach ($aFormField->getAttribute("options") as $aSelectValue => $aSelectValueLabel) {
						$selectValues .= ($countOptions) ? "||".$aSelectValue : $aSelectValue;
						$selectLabels .= ($countOptions) ? "||".$aSelectValueLabel : $aSelectValueLabel ;
						$countOptions++;
					}
				}
				$displaySelect = ($aFormField->getAttribute("type") == 'select') ? 'block':'none';
				$displayDefault = ($aFormField->getAttribute("type") != 'select' 
									&& $aFormField->getAttribute("type") != 'submit'
									&& $aFormField->getAttribute("type") != 'file'
									&& $aFormField->getAttribute("type") != 'pass'
									&& $aFormField->getAttribute("type") != 'fieldset') ? 'block':'none';
			    $displayParams = ($aFormField->getAttribute("type") == 'file') ? 'block' : 'none';
				
				$content .= '
							<input type="hidden" name="selectValues_'.$aFormField->getID().'" id="selectValues_'.$aFormField->getID().'" value="'.$selectValues.'" />
							<input type="hidden" name="selectLabels_'.$aFormField->getID().'" id="selectLabels_'.$aFormField->getID().'" value="'.$selectLabels.'" />
							<input type="hidden" name="defaultValue_'.$aFormField->getID().'" id="defaultValue_'.$aFormField->getID().'" value="'.$aFormField->getAttribute("value").'" />
							<input id="options_'.$aFormField->getID().'" type="button" style="display:'.$displaySelect.';" fckLang="DlgCMSFormsValues" value="Valeurs" onclick="manageSelectOptions(\''.$aFormField->getID().'\');" />
							<input id="options_'.$aFormField->getID().'" type="button" style="display:'.$displayDefault.';" fckLang="DlgCMSFormsValue" value="Valeur" onclick="manageDefaultOptions(\''.$aFormField->getID().'\');" />
						    ';
				    switch($aFormField->getAttribute("type")){
				        case 'file':
				            $params = $aFormField->getAttribute("params");
				            $currentFileExtensions = (isset($params['extensions']) && $params['extensions']) ? $params['extensions'] : '';
				            $currentFileWeight = (isset($params['weight']) && $params['weight']) ? $params['weight'] : '';
				            $content .= '
				            <input type="hidden" name="fileParamsExtensions_'.$aFormField->getID().'" id="fileParamsExtensions_'.$aFormField->getID().'" value="'.$currentFileExtensions.'" />
				            <input type="hidden" name="fileParamsWeight_'.$aFormField->getID().'" id="fileParamsWeight_'.$aFormField->getID().'" value="'.$currentFileWeight.'" />
				            <input id="options_'.$aFormField->getID().'" type="button" style="display:'.$displayParams.';" fckLang="DlgCMSFormsParams" value="Parametres" onclick="manageFileParamsOptions(\''.$aFormField->getID().'\');" />';
				        break;
				    }
			    $content .= '
						</td>
						<td align="center" width="50" align="center">
							<input type="image" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/delete.gif" alt="Effacer" title="Effacer" name="delete_'.$aFormField->getID().'" value="X" onclick="removeField(\''.$aFormField->getID().'\');" />
							<span class="handle"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/drag.gif" alt="D&eacute;placer" title="D&eacute;placer" border="0" /></span>
						</td>
					</tr>
				</table>
				</li>';
				$fieldIdsValues .= ($countFields) ? ",".$aFormField->getID():$aFormField->getID();
				$countFields++;
			}
		}
		if ($countFields) {
			$content .= '</ul><hr />';
		}
		$content .= '
			<input type="hidden" name="fieldIds" id="fieldIds" value="'.$fieldIdsValues.'" />
			<span fckLang="DlgCMSFormsNew">Nouveau champ :</span>
			<table border="0" cellspacing="1" cellpadding="0" width="100%">
				<tr>
					<th align="right"><span fckLang="DlgCMSFormsRequire">Requis</span></th>
					<th width="130"><span fckLang="DlgCMSFormsLabel">Libell&eacute;</span></th>
					<th width="130"><span fckLang="DlgCMSFormsType">Type</span></th>
					<th width="110"><span fckLang="DlgCMSFormsActions">Actions</span></th>
				</tr>
				<tr>
					<td align="right"><input type="checkbox" name="required_new" value="1" /></td>
					<td width="130"><input type="text" name="label_new" value="" /></td>
					<td width="130">
							<select name="type_new">';
					foreach ($fieldTypes as $aFieldType => $aFieldTypeLabel) {
						$content .= '<option value="'.$aFieldType.'">'.$aFieldTypeLabel.'</option>';
					}
					$content .= '
						</select>
					</td>
					<td width="110" align="center"><input type="button" name="add_new" fckLang="DlgCMSFormsAdd" value="Ajouter" onclick="addField();" /></td>
				</tr>
			</table>
			</form>
		</div>
		<div id="divSelect" style="DISPLAY: none">
			<span fckLang="DlgSelectOpAvail">Available Options</span>
			<input id="fieldIDValue" type="hidden" name="formIDValue" value="" />
			<table width="100%">
				<tr>
					<td width="50%"><span fckLang="DlgSelectOpText">Text</span><br>
						<input id="txtText" style="WIDTH: 100%" type="text" name="txtText">
					</td>
					<td width="50%"><span fckLang="DlgSelectOpValue">Value</span><br>
						<input id="txtValue" style="WIDTH: 100%" type="text" name="txtValue">
					</td>
					<td vAlign="bottom"><input onclick="Add();" type="button" fckLang="DlgSelectBtnAdd" value="Add"></td>
					<td vAlign="bottom"><input onclick="Modify();" type="button" fckLang="DlgSelectBtnModify" value="Modify"></td>
				</tr>
				<tr>
					<td rowSpan="2"><select id="cmbText" style="WIDTH: 100%" onchange="GetE(\'cmbValue\').selectedIndex = this.selectedIndex;Select(this);"
							size="5" name="cmbText"></select>
					</td>
					<td rowSpan="2"><select id="cmbValue" style="WIDTH: 100%" onchange="GetE(\'cmbText\').selectedIndex = this.selectedIndex;Select(this);"
							size="5" name="cmbValue"></select>
					</td>
					<td vAlign="top" colSpan="2">
					</td>
				</tr>
				<tr>
					<td vAlign="bottom" colSpan="2"><input style="WIDTH: 100%" onclick="Move(-1);" type="button" fckLang="DlgSelectBtnUp" value="Up">
						<br>
						<input style="WIDTH: 100%" onclick="Move(1);" type="button" fckLang="DlgSelectBtnDown"
							value="Down">
					</td>
				</tr>
				<TR>
					<TD vAlign="bottom" colSpan="4"><INPUT onclick="SetSelectedValue();" type="button" fckLang="DlgSelectBtnSetValue" value="Set as selected value">&nbsp;&nbsp;
						<input onclick="Delete();" type="button" fckLang="DlgSelectBtnDelete" value="Delete"></TD>
				</TR>
				<tr>
					<td nowrap width="100%" colSpan="4"><span fckLang="DlgCMSFormsDefault">Valeur par d&eacute;faut :</span>&nbsp;<input id="txtSelValue" type="text"></td>
				</tr>
			</table>
			<br />
			<input onclick="manageFormFromSelect();" type="button" fckLang="DlgCMSFormsReturn" value="Retour au formulaire"><br />
			'.$cms_language->getMessage(MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($cms_language->getDateFormatMask(),$cms_language->getDateFormatMask(),$cms_language->getDateFormatMask())).'
		</div>
	    <div id="divDefault" style="DISPLAY: none">
		    <span fckLang="DlgCMSFormsDefaultAvail">Saisissez la valeur par d&eacute;faut du champ :</span>
		    <input id="fieldIDDefaultValue" type="hidden" name="formIDValue" value="" />
		    <table width="100%">
			    <tr>
				    <td nowrap width="100%" colSpan="4"><span fckLang="DlgCMSFormsDefault">Valeur par d&eacute;faut :</span>&nbsp;<input style="WIDTH: 80%" id="defaultValue" type="text"></td>
			    </tr>
		    </table>
		    <br />
		    <input onclick="manageFormFromDefault();" type="button" fckLang="DlgCMSFormsReturn" value="Retour au formulaire"><br />
		    '.$cms_language->getMessage(MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($cms_language->getDateFormatMask(),$cms_language->getDateFormatMask(),$cms_language->getDateFormatMask())).'
	    </div>
	    <div id="divFileParams" style="display: none">
		    <strong><span fckLang="DlgCMSFormsFileParamsTitle">Modifiez ici les parametres :</span></strong>
		    <input id="fieldIDFileParamValue" type="hidden" name="formIDValue" value="" />
		    <input id="serverMaxFileSize" type="hidden" name="serverMaxFileSize" value="'.CMS_file::getMaxUploadFileSize('K').'" />
		    <div style="display:none;" id="fileParamsError"><span style="color:red;" fckLang="DlgCMSFormsFileParamsError">Erreur</span></div>
		    <table width="100%">
			    <tr>
				    <td nowrap width="100%" colSpan="4"><span fckLang="DlgCMSFormsAllowedExtensions">Extensions autorisees :</span>&nbsp;<input style="WIDTH: 50%" id="fileParamsExtensions" type="text"> <span fckLang="allowedExtensionsHelp">Separees par des points-virgules</span></td>
			    </tr>
			    <tr>
				    <td nowrap width="100%" colSpan="4"><span fckLang="DlgCMSFormsMaxWeight">Poids maximum :</span>&nbsp;<input style="WIDTH: 20%" id="fileParamsWeight" type="text"> <span fckLang="DlgCMSFormsMaxWeightHelp">ko (1Mo = 1024Ko)</span>
				        <br/><span fckLang="DlgCMSFormsMaxServerFileSize">Max server file size</span>'.CMS_file::getMaxUploadFileSize('K').'Ko ('.CMS_file::getMaxUploadFileSize('M').'Mo)
				    </td>
			    </tr>
		    </table>
		    <br />
		    <input onclick="manageFormFromFileParams();" type="button" fckLang="DlgCMSFormsReturn" value="Retour au formulaire"><br />
		    '.$cms_language->getMessage(MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($cms_language->getDateFormatMask(),$cms_language->getDateFormatMask(),$cms_language->getDateFormatMask())).'
	    </div>';
	break;
	case 4:
		// used to send server form content to wysiwyg after analyse
		$replace = array(
			"\n" => "",
			"\r" => "",
			"'" => "\'",
		);
		//pr($xhtml);
		$content = '
			<div id="divInfo" style="DISPLAY: none">
				<input id="codeSent" name="codeSent" value="" type="hidden" />
				<script type="text/javascript">
					<!--
					sendFormCode(\''.str_replace(array_keys($replace), $replace, $xhtml).'\');
					//-->
				</script>
			</div>';
	break;
	case 5:
		// used to send an error to user then close window
		$content = '
			<div id="divInfo" style="DISPLAY: none">
				<script type="text/javascript">
					<!--
					displayError(FCKLang[\''.$errorMsg.'\']);
					//-->
				</script>
			</div>';
	break;
}
echo $content;
/*
pr("Step : ".$step);
pr($_POST);
pr($formTags);
*/
?>
	</body>
</html>
