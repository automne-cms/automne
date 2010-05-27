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
// $Id: polymod_admin.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : poly modules admin
  * Used to manage poly modules. This file is included by modules_admin.php
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

/*
 * Polymod messages
 */
define("MESSAGE_PAGE_PLUGIN_DEFINITIONS", 275);
define("MESSAGE_PAGE_ACTION_DELETEPLUGINCONFIRM", 279);
define("MESSAGE_PAGE_RSS_DEFINITIONS", 290);
define("MESSAGE_PAGE_ACTION_DELETERSSCONFIRM", 291);
define("MESSAGE_PAGE_FIELD_OBJECT_INDEXABLE", 322);

if(sensitiveIO::IsPositiveInteger($objectID)) {
	$object = new CMS_poly_object_definition($objectID);
}

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case 'deleteObject' :
	if ($object->destroy()) {
		unset($object);
		unset($objectID);
		//unset field catalog in session
		unset($_SESSION["polyModule"]["objectFields"][$objectID]);
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_DELETE_OBJECT_ERROR);
	}
	break;
case "delete":
	$field = new CMS_poly_object_field($_POST["field"]);
	if (!$field->hasError() && $field->destroy()) {
		//then reload object
		if(sensitiveIO::IsPositiveInteger($objectID)) {
			$object = new CMS_poly_object_definition($objectID);
		}
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_DELETE_FIELD_ERROR);
	}
	break;
case 'deleteRSS':
	$RSSDefinition = new CMS_poly_rss_definitions($_POST['RSSDefinition']);
	$RSSDefinition->destroy();
	$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
break;
case 'deletePlugin':
	$pluginDefinition = new CMS_poly_plugin_definitions($_POST['pluginDefinition']);
	$pluginDefinition->destroy();
	$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
break;
case "change_order";
	if (is_object($object)) {
		$fields =  CMS_poly_object_catalog::getFieldsDefinition($object->getID());
		$count = 0;
		//construct array of new fields orders
		$newPagesOrder = array();
		$tmpPagesOrder = explode(',',$_POST["new_order"]);
		if (sizeof($tmpPagesOrder)) {
			foreach ($tmpPagesOrder as $tmpPage) {
				$fieldID = substr($tmpPage,1);
				$count++;
				if (sensitiveIO::isPositiveInteger($fieldID) && is_object($fields[$fieldID])) {
					$fields[$fieldID]->setValue('order',$count);
					$fields[$fieldID]->writeToPersistence();
				}
			}
		}
		$cms_message .= $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	break;
}

$objects = $module->getObjects();
$content .= '
<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_APPLICATION).' :: '.$module->getLabel($cms_language).' :</dialog-title>
<br />
<dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_OBJECTS).' :</dialog-title>';
if (!sizeof($objects)) {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
	$content .= '
	<form action="polymod_object.php" method="post">
	<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form><br />';
} else {
	$resourceStatus = array(
		0 => MESSAGE_PAGE_FIELD_RESOURCE_NONE,
		1 => MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY,
		2 => MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY
	);
	$adminEditableStatus = array(
		0 => MESSAGE_PAGE_FIELD_YES,
		1 => MESSAGE_PAGE_FIELD_NO,
		2 => MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN,
	);
	$adminIndexableStatus = array(
		0 => MESSAGE_PAGE_FIELD_YES,
		1 => MESSAGE_PAGE_FIELD_NO,
	);
	$content .= '
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
		'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE_OBJECTS).' :
		<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
		<select name="object" class="admin_input_text" onchange="submit();">
			<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
			foreach ($objects as $anObject) {
				$selected = (is_object($object) && $object->getID() == $anObject->getID()) ? ' selected="selected"':'';
				$content .= '<option value="'.$anObject->getID().'"'.$selected.'>'.$anObject->getLabel($cms_language).'</option>';
			}
		$content .= '
		</select>
	</form>
	<table border="0" cellpadding="2" cellspacing="2">
	<tr>';
	if (is_object($object)) {
		$objectUseage = CMS_poly_object_catalog::getObjectUsage($object->getID(), true);
		if (!sizeof($objectUseage)) {
			$objectUseageLabel = $cms_language->getMessage(MESSAGE_PAGE_FIELD_NO).'<br />';
		} else {
			$objectUseageLabel = $cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_USED).' : <ul>';
			foreach ($objectUseage as $anObjectWhichUse) {
				$objectUseageLabel .= '<li>'.$anObjectWhichUse->getLabel().'</li>';
			}
			$objectUseageLabel .='</ul>';
		}
		$fields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
		$content .= '
		<strong>ID :</strong> '.$object->getID().'<br />
		<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).' :</strong> '.$object->getDescription($cms_language).'<br />
		<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE).' :</strong> '.$cms_language->getMessage($resourceStatus[$object->getValue("resourceUsage")]).'<br />
		<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITABLE).' :</strong> '.$cms_language->getMessage($adminEditableStatus[$object->getValue("admineditable")]).'<br />
		<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMPOSED_LABEL).' :</strong> '.$cms_language->getMessage($adminEditableStatus[($object->getValue("composedLabel")) ? 0 : 1]).'<br />
		<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_USEAGE).' :</strong> '.$objectUseageLabel;
		if (class_exists('CMS_module_ase')) {
			$content .= '<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_INDEXABLE, false, MOD_POLYMOD_CODENAME).' :</strong> '.$cms_language->getMessage($adminIndexableStatus[($object->getValue("indexable")) ? 0 : 1]).'<br />';
		}
		$content .= '
		<form action="polymod_object.php" method="post">
		<td class="admin">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<input type="hidden" name="object" value="'.$object->getID().'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" />
		</td>
		</form>';
		if (!sizeof($fields)) {
			$content .= '
			<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_OBJECT_CONFIRM, array($object->getLabel($cms_language)))) . '\')">
			<td class="admin">
				<input type="hidden" name="cms_action" value="deleteObject" />
				<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
				<input type="hidden" name="object" value="'.$object->getID().'" />
				<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" />
			</td>
			</form>';
		}
		$content .= '
		<form action="polymod_object_infos.php" method="post">
		<td class="admin">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<input type="hidden" name="object" value="'.$object->getID().'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_ACTION_OBJECT_STRUCTURE).'" />
		</td>
		</form>
		';
	}
	$content .= '<br />
		<form action="polymod_object.php" method="post">
		<td class="admin">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</td>
		</form>
	</tr>
	</table>
	<br />
	';
}
if (is_object($object)) {
	$content .= '<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_OBJECT).' :: '.$object->getLabel($cms_language).' :</dialog-title>
	<br />
	<dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_FIELDS).' :</dialog-title>';
	if (!sizeof($fields)) {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
		$content .= '
		<form action="polymod_field.php" method="post">
		<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
		<input type="hidden" name="object" value="'.$object->getID().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
	} else {
		$content .= '
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/coordinates.js"></script>
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/drag.js"></script>
		<script language="JavaScript" type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/dragsort.js"></script>
		<script language="JavaScript" type="text/javascript">
			<!--
			function sortList() {
				DragSort.makeListSortable(document.getElementById("fields"));
			};
			function startDragging() {
				if (document.getElementById("validateDrag").className=="hideit") {
					document.getElementById("validateDrag").className="showit";
				}
				return true;
			}
			function getNewOrder() {
				var fields = document.getElementById("fields");
				fieldsArray = fields.getElementsByTagName("li");
				var newOrder;
				for (var i=0; i<fieldsArray.length; i++) {
					newOrder = (newOrder) ? newOrder + "," + fieldsArray[i].id : fieldsArray[i].id;
				}
				document.change_order.new_order.value=newOrder;
				return true;
			}
			//-->
		</script>
		<table border="0" cellpadding="2" cellspacing="2">
		<tr>
			<th width="150" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</th>
			<th width="150" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TYPE).'</th>
			<th width="200" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</th>
			<th width="150" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			<th width="36" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER).'</th>
		</tr>
		</table>
		<ul id="fields" class="sortable">
		';
		
		$count = 0;
		foreach ($fields as $field) {
			$count++;
			$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
			$type = $field->getValue("type");
			$label = new CMS_object_i18nm($field->getValue("labelID"));
			$typeObject = $field->getTypeObject(true);
			$content .= '
			<li id="f'.$field->getID().'" alt="ID : '.$field->getID().'" title="ID : '.$field->getID().'">
				<table border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td width="150" class="'.$td_class.'">'.$label->getValue($cms_language->getCode());
					if (POLYMOD_DEBUG) {
						$content .= ' <span class="admin_text_alert"><small>(FieldID : '.$field->getID().')</small></span>';
					}
					$content .= '
					</td>
					<td width="150" class="'.$td_class.'">'.$typeObject->getObjectLabel($cms_language).'</td>
					<td width="200" class="'.$td_class.'">'.$typeObject->getDescription($cms_language).'</td>
					<td width="150" class="'.$td_class.'">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>';
							//a field can't be deleted if it's the last one of the object and if it is used by another object
							if (sizeof($objectUseage) && sizeof($fields) == 1) {
								$canBeDeleted = false;
							} else {
								$canBeDeleted = true;
							}
							if ($canBeDeleted) {
								$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array(htmlspecialchars($label->getValue($cms_language->getCode()))))) . ' ?\')">
								<input type="hidden" name="cms_action" value="delete" />
								<input type="hidden" name="field" value="'.$field->getID().'" />
								<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
								</form>';
							}
							$content .= '
							<form action="polymod_field.php" method="post">
							<input type="hidden" name="field" value="'.$field->getID().'" />
							<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
							<input type="hidden" name="object" value="'.$object->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
							</form>
							</tr>
						</table>
					</td>
					<td width="36" align="center" class="'.$td_class.'" style="cursor:move;"><img src="'.PATH_ADMIN_IMAGES_WR.'/drag.gif" border="0" /></td>
				</tr>
				</table>
			</li>';
		}
		$content .= '
		</ul>
		<div id="validateDrag" class="hideit">
		<form name="change_order" onsubmit="return getNewOrder();" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
		<input type="hidden" name="cms_action" value="change_order" />
		<input type="hidden" name="new_order" value="" />
		<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
		<input type="hidden" name="object" value="'.$object->getID().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_SAVE_NEWORDER).'" />
		</form>
		</div>
		
		<form action="polymod_field.php" method="post">
		<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
		<input type="hidden" name="object" value="'.$object->getID().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
	}
	
	//RSS
	if (sizeof($fields)) {
		$content .= '
		<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_RSS_DEFINITIONS, false, MOD_POLYMOD_CODENAME).' :</dialog-title>
		<br />';
		//get all RSS def for object
		$RRSDefinitions = CMS_poly_object_catalog::getAllRSSDefinitionsForObject($object->getID());
		if (sizeof($RRSDefinitions)) {
			$content .= '<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			</tr>';
			$copunt = 0;
			foreach ($RRSDefinitions as $RRSDefinition) {
				$count++;
				$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
				$content .= '<tr alt="ID : '.$RRSDefinition->getID().'" title="ID : '.$RRSDefinition->getID().'">
					<td class="'.$td_class.'">'.$RRSDefinition->getLabel($cms_language).'</td>
					<td class="'.$td_class.'">'.$RRSDefinition->getDescription($cms_language).'</td>
					<td class="'.$td_class.'">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>';
							$canBeDeleted = true;
							if ($canBeDeleted) {
								$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETERSSCONFIRM, array($RRSDefinition->getLabel($cms_language)), MOD_POLYMOD_CODENAME)) . ' ?\')">
								<input type="hidden" name="cms_action" value="deleteRSS" />
								<input type="hidden" name="RSSDefinition" value="'.$RRSDefinition->getID().'" />
								<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
								</form>';
							}
							$content .= '
							<form action="polymod_rss_definition.php" method="post">
							<input type="hidden" name="RSSDefinition" value="'.$RRSDefinition->getID().'" />
							<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
							<input type="hidden" name="object" value="'.$object->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
							</form>
							</tr>
						</table>
					</td>
				</tr>';
			}
			$content .= '</table>';
		} else {
			$content .= $cms_language->getmessage(MESSAGE_PAGE_EMPTY_SET);
		}
		$content .= '<br /><br />
		<form action="polymod_rss_definition.php" method="post">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<input type="hidden" name="object" value="'.$object->getID().'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
	}
	
	//WYSIWYG
	if ($object->getID()) {
		$content .= '
		<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_PLUGIN_DEFINITIONS, false, MOD_POLYMOD_CODENAME).' :</dialog-title>
		<br />';
		//get all plugin def for object
		$pluginDefinitions = CMS_poly_object_catalog::getAllPluginDefinitionsForObject($object->getID());
		if (sizeof($pluginDefinitions)) {
			$content .= '<table border="0" cellpadding="2" cellspacing="2">
			<tr>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</th>
				<th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ACTIONS).'</th>
			</tr>';
			$copunt = 0;
			foreach ($pluginDefinitions as $pluginDefinition) {
				$count++;
				$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
				$content .= '<tr alt="ID : '.$pluginDefinition->getID().'" title="ID : '.$pluginDefinition->getID().'">
					<td class="'.$td_class.'">'.$pluginDefinition->getLabel($cms_language).'</td>
					<td class="'.$td_class.'">'.$pluginDefinition->getDescription($cms_language).'</td>
					<td class="'.$td_class.'">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>';
							$canBeDeleted = true;
							if ($canBeDeleted) {
								$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETEPLUGINCONFIRM, array($pluginDefinition->getLabel($cms_language)), MOD_POLYMOD_CODENAME)) . ' ?\')">
								<input type="hidden" name="cms_action" value="deletePlugin" />
								<input type="hidden" name="pluginDefinition" value="'.$pluginDefinition->getID().'" />
								<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
								</form>';
							}
							$content .= '
							<form action="polymod_plugin_definition.php" method="post">
							<input type="hidden" name="pluginDefinition" value="'.$pluginDefinition->getID().'" />
							<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
							<input type="hidden" name="object" value="'.$object->getID().'" />
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
							</form>
							</tr>
						</table>
					</td>
				</tr>';
			}
			$content .= '</table>';
		} else {
			$content .= $cms_language->getmessage(MESSAGE_PAGE_EMPTY_SET);
		}
		$content .= '<br /><br />
		<form action="polymod_plugin_definition.php" method="post">
			<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
			<input type="hidden" name="object" value="'.$object->getID().'" />
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form><br />';
	}
}
?>