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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cms_forms_add.php,v 1.5 2010/03/08 16:44:19 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create cms_forms module wizard
  *
  * @package Modules
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
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
		$form = new CMS_forms_formular($_POST["formId"]);
		//analyse the form from his xhtml code
		if (!$form->checkFormCode($_POST["formCode"])) {
			$errorMsg = 'DlgCMSFormsCopyError';
			//then go to error window
			$step = 5;
			break;
		}
		$field = new CMS_forms_field('',$form->getID());
		if (!is_object($field)) {
			$errorMsg = 'DlgCMSFormsFieldError';
			//then go to error window
			$step = 5;
			break;
		}
		switch ($_POST["cms_action"]) {
			case "validate" :
				//modify needed field values
				$field->setAttribute("type",$_POST["type_new"]);
				$field->setAttribute("name",$_POST["name_new"]);
				$field->setAttribute("label",$_POST["label_new"]);
				$field->setAttribute("value",$_POST["defaultValue_new"]);
				$field->setAttribute("required",$_POST["required_new"]);
				
				//Set params
				$params = array();
				if(isset($_POST['fileParamsExtensions_new']) && $_POST['fileParamsExtensions_new']){
				    $params['extensions'] = $_POST['fileParamsExtensions_new'];
				}
				if(isset($_POST['fileParamsWeight_new']) && $_POST['fileParamsWeight_new']){
				    $params['weight'] = $_POST['fileParamsWeight_new'];
				}
				$field->setAttribute("params", $params);
				
				$options = array();
				$optionsValues = explode ('||',$_POST["selectValues_new"]);
				$optionsLabels = explode ('||',$_POST["selectLabels_new"]);
				if (sizeof($optionsValues) && sizeof($optionsLabels)) {
					foreach ($optionsValues as $key => $value) {
						$options[$value] = $optionsLabels[$key];
					}
				}
				$field->setAttribute("options",$options);
				//generate unique name
				$field->setAttribute("name",md5($_POST["label_new"].$_POST["type_new"].$_POST["required_new"].microtime()));
				$field->writeToPersistence();
				//then replace field in XHTML source
				$xhtml = $form->addField($_POST['formCode'], $field);
				
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
					<input id="formId" name="formId" value="" type="hidden" />
					<input id="formCode" name="formCode" value="" type="hidden" />
				</form>
				<script type="text/javascript">
					<!--
						getFieldPosition();
						getFormCode();
					//-->
				</script>
			</div>';
	break;
	case 2:
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
			<div id="divInfo" style="DISPLAY: none">
				<form id="modifyForm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
					<input id="step" type="hidden" name="step" value="2" />
					<input id="cms_action" type="hidden" name="cms_action" value="validate" />
					<input name="formCode" value="'.htmlspecialchars($_POST['formCode']).'" type="hidden" />
					<input id="formId" type="hidden" name="formId" value="'.$form->getID().'" />
				<table border="0" cellspacing="1" cellpadding="0" width="100%">
					<tr>
						<th align="right"><span fckLang="DlgCMSFormsRequire">Requis</span></th>
						<th width="130"><span fckLang="DlgCMSFormsLabel">Libell&eacute;</span></th>
						<th width="130"><span fckLang="DlgCMSFormsType">Type</span></th>
						<th width="60"><span fckLang="DlgCMSFormsOptions">Options</span></th>
					</tr>
					<tr>';
		$required = ($field->getAttribute("required")) ? ' checked="checked"':'';
		$content .= '
						<td align="right"><input type="checkbox" name="required_new" value="1"'.$required.' /></td>
						<td align="center" width="130"><input type="text" name="label_new" value="'.htmlspecialchars(io::decodeEntities($field->getAttribute("label"))).'" /><input type="hidden" name="name_new" value="'.$field->getAttribute("name").'" /></td>
						<td align="center" width="130">
							<select name="type_new" onchange="viewHideOptionsButton(this,\'options_new\');">';
						foreach ($fieldTypes as $aFieldType => $aFieldTypeLabel) {
							$selected = ($field->getAttribute("type") == $aFieldType) ? ' selected="selected"':'' ;
							$content .= '<option value="'.$aFieldType.'"'.$selected.'>'.$aFieldTypeLabel.'</option>';
						}
		$content .= '
							</select>
						</td>
						<td align="center" width="60">';
		$selectValues = '';
		$selectLabels = '';
		$countOptions=0;
		if (sizeof($field->getAttribute("options"))) {
			foreach ($field->getAttribute("options") as $aSelectValue => $aSelectValueLabel) {
				$selectValues .= ($countOptions) ? "||".$aSelectValue : $aSelectValue;
				$selectLabels .= ($countOptions) ? "||".$aSelectValueLabel : $aSelectValueLabel ;
				$countOptions++;
			}
		}
		$displaySelect = ($field->getAttribute("type") == 'select') ? 'block':'none';
		$displayDefault = ($field->getAttribute("type") != 'select' 
							&& $field->getAttribute("type") != 'submit'
							&& $field->getAttribute("type") != 'file'
							&& $field->getAttribute("type") != 'pass'
							&& $field->getAttribute("type") != 'fieldset') ? 'block':'none';
	    $displayParams = ($field->getAttribute("type") == 'file') ? 'block' : 'none';
		$content .= '
							<input type="hidden" name="selectValues_new" id="selectValues_new" value="'.$selectValues.'" />
							<input type="hidden" name="selectLabels_new" id="selectLabels_new" value="'.$selectLabels.'" />
							<input type="hidden" name="defaultValue_new" id="defaultValue_new" value="'.$field->getAttribute("value").'" />
							<input id="options_new" type="button" style="display:'.$displaySelect.';" fckLang="DlgCMSFormsValues" value="Valeurs" onclick="manageSelectOptions(\'new\');" />
							<input id="options_new_value" type="button" style="display:'.$displayDefault.';" fckLang="DlgCMSFormsValue" value="Valeur" onclick="manageDefaultOptions(\'new\');" />
						    ';
				            $params = $field->getAttribute("params");
				            $currentFileExtensions = (isset($params['extensions']) && $params['extensions']) ? $params['extensions'] : '';
				            $currentFileWeight = (isset($params['weight']) && $params['weight']) ? $params['weight'] : '';
				            $content .= '
				            <input type="hidden" name="fileParamsExtensions_new" id="fileParamsExtensions_new" value="'.$currentFileExtensions.'" />
				            <input type="hidden" name="fileParamsWeight_new" id="fileParamsWeight_new" value="'.$currentFileWeight.'" />
				            <input id="paramsButton" type="button" style="display:'.$displayParams.';" fckLang="DlgCMSFormsParams" value="Parametres" onclick="manageFileParamsOptions(\'new\');" />';
				    $content .= '
						</td>
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
				    <td nowrap width="100%" colSpan="4"><span fckLang="DlgCMSFormsMaxWeight">Poids maximum :</span>&nbsp;<input style="WIDTH: 10%" id="fileParamsWeight" type="text"> <span fckLang="DlgCMSFormsMaxWeightHelp">ko (1Mo = 1024Ko)</span>
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
?>
	</body>
</html>
