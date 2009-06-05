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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: module-parameters.php,v 1.2 2009/06/05 15:01:04 sebastien Exp $

/**
  * PHP page : Load module parameters window.
  * Used accross an Ajax request render module properties window.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$winId = sensitiveIO::request('winId', '', 'moduleParametersWindow');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no administration rights.');
	$view->show();
}
$module = CMS_modulesCatalog::getByCodename($codename);
if (!is_a($module, "CMS_module")) {
	CMS_grandFather::raiseError('Module '.$codename.' does not exists');
	$view->show();
}
if (!$module->hasParameters()) {
	CMS_grandFather::raiseError('Module '.$codename.' has no parameters');
	$view->show();
}

//get module parameters
$parameters = $module->getParameters(false, true);
$pageLabel = sensitiveIO::sanitizeJSString(($codename != MOD_STANDARD_CODENAME) ? 'Paramètres du module '.$module->getLabel() : 'Paramètres Automne');

$paramFields = '';
foreach ($parameters as $labelCode => $parameter) {
	if (is_array($parameter)) {
		$type = $parameter[1];
		$value = $parameter[0];
	} else {
		$type = 'text';
		$value = $parameter;
	}
	if (defined(get_class($module).'::MESSAGE_PARAM_'.$labelCode)) {
		$label = $cms_language->getMessage(constant(get_class($module).'::MESSAGE_PARAM_'.$labelCode), false, $codename);
	} else {
		$label = str_replace('_', ' ', $labelCode);
	}
	if (defined(get_class($module).'::MESSAGE_PARAM_'.$labelCode.'_DESC')) {
		$description = $cms_language->getMessage(constant(get_class($module).'::MESSAGE_PARAM_'.$labelCode.'_DESC'), false, $codename);
		$fieldLabel = '<span ext:qtip="'.sensitiveIO::sanitizeJSString($description).'" class="atm-help">'.sensitiveIO::sanitizeJSString($label).'</span>';
	} else {
		$fieldLabel = sensitiveIO::sanitizeJSString($label);
	}
	$value = sensitiveIO::sanitizeJSString($value);
	switch ($type) {
		case 'email':
			$paramFields .= "{
				fieldLabel: '{$fieldLabel}',
				name: 		'params[{$labelCode}]',
				value:		'{$value}',
				vtype:		'email'
			},";
		break;
		case 'integer':
			$paramFields .= "{
				xtype:		'numberfield',
				fieldLabel: '{$fieldLabel}',
				name: 		'params[{$labelCode}]',
				value:		'{$value}'
			},";
		break;
		case 'boolean':
			$checked = $value ? 'checked:true,':'';
			$paramFields .= "{
				".$checked."
				boxLabel: 		'{$fieldLabel}',
				name: 			'params[{$labelCode}]',
				xtype:			'checkbox',
				inputValue:		'1',
				fieldLabel: 	'',
				hideLabel:		true,
				labelSeparator:	''
			},";
		break;
		case 'text':
		default:
			$paramFields .= "{
				fieldLabel: '{$fieldLabel}',
				name: 		'params[{$labelCode}]',
				value:		'{$value}'
			},";
		break;
	}
}

$paramFields = substr($paramFields, 0, -1);

$jscontent = <<<END
	var moduleParamWindow = Ext.getCmp('{$winId}');
	//set window title
	moduleParamWindow.setTitle('{$pageLabel}');
	//set help button on top of page
	moduleParamWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		moduleParamWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'Cette page vous permet de paramétrer diverses fonctionnalités d\'Automne. Référez vous à l\'aide disponible sur chaque paramètre pour en connaitre l\'usage.',
		dismissDelay:	0
    });
	
	//create center panel
	var center = new Automne.FormPanel({
		id:				'moduleParamPanel-{$codename}',
		region:			'center',
		layout: 		'form',
		url:			'module-controler.php',
		autoScroll:		true,
		defaultType:	'textfield',
		bodyStyle: 		'padding:10px',
		border:			false,
		labelWidth:		160,
		defaults: {
			xtype:			'textfield',
			anchor:			'97%'
		},
		items:[{
			xtype:			'panel',
			bodyStyle: 		'padding:0 0 10px 0',
			html:			'<strong>Vous pouvez modifier les {$pageLabel}. Référez vous à l\'aide disponible sur chaque paramètre pour en connaitre l\'utilité.<br /><br />Ces paramètres sont aussi directement accessible dans le fichier : /automne/classes/modules/{$codename}_rc.xml</strong>',
			border:			false
		},{$paramFields}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			xtype:			'button',
			name:			'submitParams',
			handler:		function() {
				var form = Ext.getCmp('moduleParamPanel-{$codename}').getForm();
				if (form.isValid()) {
					form.submit({params:{
						action:		'submit-parameters',
						module:		'{$codename}'
					}});
				} else {
					Automne.message.show('Le formulaire est incomplet ou possède des valeurs incorrectes ...', '', moduleParamWindow);
				}
			}
		}]
	});
	
	moduleParamWindow.add(center);
	//redo windows layout
	moduleParamWindow.doLayout();
	if (Ext.isIE7) {
		center.syncSize();
	}
END;

$view->addJavascript($jscontent);
$view->show();
?>