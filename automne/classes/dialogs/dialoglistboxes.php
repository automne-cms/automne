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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_dialog_listboxes
  *
  * Class to manage XHTML formulars relative to an CMS_href object
  *
  * @package Automne
  * @subpackage dialogs
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
 */
class CMS_dialog_listboxes extends CMS_grandFather
{
	/**
	  * Create XHTML select boxes XHTML
	  *
	  * Example :
	  * Array (
	  * // Mandatory
	  *     'field_name' => '',								// Name of selecte field
	  *     'items_possible' => array(integer => string),	// First is the value, second the label of Options
	  * // Optional
	  *     'default_value' => integer,						// Current category to show as selected
	  *     'attributes' => ' class="input_admin_text"',			// A string completing "select" tag with optionnal attributes
	  * )
	  *
	  * USAGE :
	  * Add this javascript and HTML to your form
	  * and such event to your form :
	  *     <form onSubmit="getSelectedOptions_${hidden field name}();">
	  * if your hioden field is "IDS", the function to call will be : getSelectedOptions_IDS()
	  * To retrieve selected values from $_POST form use :
	  *     $my_values = @array_unique(@explode(';', $_POST["ids"]));
	  *
	  * @param mixed array() $args, This array contains all parameters.
	  * @return string, XHTML formated
	  */
	function getListBox($args) {
		if (!$args || !$args['items_possible']) {
			return '';
		}
		// Rewritre HTML tag attributes
		$attributes = '';
		if (trim($args["attributes"]) != '') {
			if (io::strpos($args["attributes"], 'size') === false) {
				$attributes = 'size="1" ';
			}
			$attributes .= trim($args["attributes"]);
		}
		$s = '
		<select name="'.$args["field_name"].'" '.$attributes.'>
			<option value="0"></option>';
		if (is_array($args['items_possible'])) {
			@reset($args['items_possible']);
			while (list($id, $lbl) = each($args['items_possible'])) {
				$sel = ($id == $args["default_value"]) ? ' selected="selected"' : '' ;
				$s .= '
				<option value="'.$id.'"'.$sel.'>'.$lbl.'</option>';
			}
		}
		$s .= '
		</select>';

		return $s;
	}

	/**
	  * Create 2 listboxes XHTML exchanging their values through javascript
	  * An hidden field will contain choosen categories values concatenated with semicolon (;)
	  * (The field you need to read from $_POST at the end to get user's selection)
	  *
	  * Example :
	  * Array (
	  * // Mandatory
	  *     'field_name' => '',								// Hidden field name to get value in
	  *     'items_possible' => array(integer => string),	// First is the value, second the label of Options
	  * // Optional
	  *     'items_selected' => array(integer),				// Only array of values
	  *     'select_width' => '200px',						// Width of selects, default 200px
	  *     'select_height' => '140px',						// Height of selects, default 140px
	  *     'separator' => ';',								// Separator between values in hidden field, default ;
	  *     'form_name' => '',								// Javascript form name
	  *     'no_admin' => false,							// Remove all admin class reference (default = false)
	  *		'leftTitle' => '',								// Add title ahead left select box
	  *		'rightTitle' => '',								// Add title ahead right select box
	  *		'position' => '',								// vertical or horizontal (default)
	  *		'disableIDs' => array(integer)					// Array of values to disable some items
	  *		'description' => array(integer => string)		// Array of description for items (title tags)
	  *		'selectIDFrom' => string						// Tag id of the first listBox (optional)
	  *		'selectIDTo' => string							// Tag id of the second listBox
	  *		'keepOrder' => string							// Keep the order specified on items_selected
	  * )
	  *
	  * USAGE :
	  * Add this javascript and HTML to your form
	  * and such event to your form :
	  *     <form onSubmit="getSelectedOptions_${hidden field name}();">
	  * if your hioden field is "IDS", the function to call will be : getSelectedOptions_IDS()
	  * To retrieve selected values from $_POST form use :
	  *     $my_values = @array_unique(@explode(';', $_POST["ids"]));
	  *
	  * @param mixed array() $args, This array contains all parameters.
	  * @return string, XHTML formated
	  */
	function getListBoxes($args) {

		// Prepare arguments
		$s_hiddenField = $args['field_name'];
		if (trim($s_hiddenField) == '') {
			return '';
		}
		$a_all_categoriesIDs =& $args['items_possible'];
		if (!$a_all_categoriesIDs) {
			return '';
		}
		if (is_array($args['items_selected'])) {
			if(isset($args['keepOrder']) && $args['keepOrder']){
				$a_selected_categoriesIDs = array_intersect($args['items_selected'], array_keys($args['items_possible']));
			} else {
				$a_selected_categoriesIDs = array_intersect(array_keys($args['items_possible']), $args['items_selected']);
			}
			$a_keeped_categoriesIDs = array_diff($args['items_selected'], $a_selected_categoriesIDs);
		} else {
			$a_selected_categoriesIDs = array();
			$a_keeped_categoriesIDs = array();
		}

		$s_formName = ($args['form_name'] != '') ? $args['form_name'] : 'forms[0]' ;
		$s_separator = (isset($args['separator']) && trim(io::substr($args['separator'], 0, 1)) != '') ? trim(io::substr($args['separator'], 0, 1)) : ';' ;
		$s_width = ($args['select_width'] != '') ? $args['select_width'] : '200px' ;
		$s_height = ($args['select_height'] != '') ? $args['select_height'] : '140px' ;
		$s_noadmin = (isset($args['no_admin']) && $args['no_admin'] == true) ? true : false ;
		$s_classname = ($s_noadmin) ? '': ' class="admin"';
		$s_inputClassname = ($s_noadmin) ? '': ' class="admin_input_text"';
		// js names of listboxes
		$s_listboxFrom = 'listFrom_'.$s_hiddenField;
		$s_listboxTo = 'listTo_'.$s_hiddenField;
		if(!isset($args['position']) || ($args['position'] != 'vertical' && $args['position'] != 'horizontal')) {
			$args['position'] = 'horizontal';
		}
		// Start rendered string
		$s = '
		<script type="text/javascript">
		<!--

		var a_itemsFromPositions'.$s_hiddenField.' = new Array();';
		$count = 0;
		@reset($a_all_categoriesIDs);
		while (list($option_value, $label) = each($a_all_categoriesIDs)) {
			$s .= '
		a_itemsFromPositions'.$s_hiddenField.'[\''.$option_value.'\'] = '.$count.';';
			$count++;
		}
		$s .= '

		/**
		  * Update Disabled attribute to an Option got by its position in a listbox
		  *
		  * @param Select o_listBox, listbox to get an option from
		  * @param integer i_position, represents the position in listbox options array
		  * @return true if succeeded, false otherwise
		  */
		function enableOption_'.$s_hiddenField.'(o_listBox, i_position) {
			o_listBox.options[i_position].style.color = "black";
			return true;
		}

		/**
		  * Test presence of given option in destination list
		  *
		  * @param Select o_toList, listbox to get an option from
		  * @param integer i_value, the Option value to compare
		  * @return boolean true if alreay in list
		  */
		function isInList_'.$s_hiddenField.'(o_toList, i_value) {
			if (o_toList.options.length > 0) {
				for (var i=0; i < o_toList.options.length; i++) {
					if (o_toList.options[i].value == i_value) {
						return true;
					}
				}
			}
			return false;
		}

		/**
		  * Pass value(s) from a listbox to another
		  *
		  * @param Select s_fromList, listbox to get an option from
		  * @param Select s_toList, listbox to get an option from
		  */
		function copyFromListBoxToAnother_'.$s_hiddenField.'(s_fromList, s_toList) {
			formular = eval("document.'.$s_formName.'");
			o_fromList = eval("formular." + s_fromList);
			o_toList = eval("formular." + s_toList);
			var i_lastIndexSelected = -1;
			var a_indexToRemove = new Array();
			for (var i = 0; i < o_fromList.options.length; i++) {
				var current = o_fromList.options[i];
				if(current.disabled==false){
					if (current.selected) {
						current.selected = false;
						// If transfer from "possibles" to "selected", need to keep
						// option order in listBox
						if (o_toList.name == \''.$s_listboxFrom.'\') {
							var i_position = a_itemsFromPositions'.$s_hiddenField.'[current.value];
							if (enableOption_'.$s_hiddenField.'(o_toList, i_position)) {
								//o_fromList.options[i] = null;
								a_indexToRemove[a_indexToRemove.length] = i;
								i_lastIndexSelected = i;
							}
						} else {
							if (!isInList_'.$s_hiddenField.'(o_toList, current.value)) {
								//o_toList.options[o_toList.length] = new Option(cleanLabel_'.$s_hiddenField.'(current.text), current.value);
								var oOption = document.createElement("OPTION");
								oOption.text = current.text;
								oOption.value= current.value;
								if (navigator.userAgent.toLowerCase().indexOf(\'msie\') != -1) {
									o_toList.add(oOption);
								} else {
									o_toList.add(oOption,null);
								}
								o_fromList.options[i].style.color = "red";
								i_lastIndexSelected = i;
							}
						}
					}
				}
			}
			//remove all needed index
			if (a_indexToRemove.length) {
				a_indexToRemove.reverse();
				for (var i = 0; i < a_indexToRemove.length; i++) {
					o_fromList.options[a_indexToRemove[i]] = null;
				}
			}

			// Reset focus in list values are passed from
			if (o_fromList.name == \''.$s_listboxFrom.'\' && i_lastIndexSelected > -1) {
				resetListBoxFocus_'.$s_hiddenField.'(o_fromList, i_lastIndexSelected);
			} else {
				resetListBoxFocus_'.$s_hiddenField.'(o_fromList, 0);
			}
			//then recalc selected categories
			getSelectedOptionsInField_'.$s_hiddenField.'();
		}

		/**
		  * Set the focus inlistbox options to given index
		  * if exists or its next
		  *
		  * @param Select o_toList, listbox to get an option from
		  * @param integer i_index, index to set
		  * @return void
		  */
		function resetListBoxFocus_'.$s_hiddenField.'(o_toList, i_index) {
			if (i_index > -1) {
				if (o_toList.options.length &&
					o_toList.options.length > i_index) {
					if (!o_toList.options[i_index].disabled) {
						o_toList.options[i_index].selected = true;
					} else if (o_toList.options[i_index + 1] != \'undefined\') {
						if (!o_toList.options[i_index + 1].disabled) {
							o_toList.options[i_index + 1].selected = true;
						}
					}
				} else if (o_toList.options.length > 0) {
					o_toList.options[0].selected = true;
				}
			}
		}

		/**
		  * Pass value(s) from a listbox to another
		  *
		  * @param string s_form, form containing listboxes
		  * @param Select s_toList, listbox to get an option from
		  * @return void
		  */
		function getSelectedOptionsInField_'.$s_hiddenField.'() {
			var s = "";
			o_form = eval("document." + "'.$s_formName.'");
			o_hiddenField = eval("o_form." + "'.$s_hiddenField.'");
			o_keepedField = eval("o_form." + "keep_'.$s_hiddenField.'");
			o_toList = eval("o_form.'.$s_listboxTo.'");
			for (var i=0; i < o_toList.length; i++) {
				s += o_toList.options[i].value + "'.$s_separator.'";
			}
			o_hiddenField.value = s.substr(0, (s.length - 1));
			if (o_keepedField.value) {
				if (o_hiddenField.value) {
					o_hiddenField.value += ";" + o_keepedField.value;
				} else {
					o_hiddenField.value = o_keepedField.value;
				}
			}
			return true;
		}
		//-->
		</script>
		<input type="hidden" id="hidden_'.$s_hiddenField.'" name="'.$s_hiddenField.'" value="'.@implode($s_separator, array_merge($a_selected_categoriesIDs,$a_keeped_categoriesIDs)).'" />
		<input type="hidden" id="hidden_keep_'.$s_hiddenField.'" name="keep_'.$s_hiddenField.'" value="'.@implode($s_separator, $a_keeped_categoriesIDs).'" />
		<table>';
		$fromID = (isset($args['selectIDFrom'])) ? ' id="'.io::htmlspecialchars($args['selectIDFrom']).'"' : '';
		$toID = (isset($args['selectIDTo'])) ? ' id="'.io::htmlspecialchars($args['selectIDTo']).'"' : '';
		if($args['position'] == 'horizontal'){
			if (isset($args['leftTitle']) || isset($args['rightTitle'])) {
				$s .= '
				<tr>
					<td'.$s_classname.'>'.$args['leftTitle'].'</td>
					<td>&nbsp;</td>
					<td'.$s_classname.'>'.$args['rightTitle'].'</td>
				</tr>';
			}
			$s .= '
			<tr>
				<td'.$s_classname.'>
					<select'.$fromID.' ondblclick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxFrom.'\', \''.$s_listboxTo.'\');" name="'.$s_listboxFrom.'" size="7" multiple="multiple"'.$s_inputClassname.' style="width:'.$s_width.';height:'.$s_height.';">';
			@reset($a_all_categoriesIDs);
			if (is_array($a_all_categoriesIDs) && $a_all_categoriesIDs) {
				while (list($id, $lbl) = each($a_all_categoriesIDs)) {
					$description = (isset($args['description'][$id])) ? ' title="'.io::htmlspecialchars($args['description'][$id]).'"' : '';
					if (isset($args['disableIDs']) && is_array($args['disableIDs']) && in_array($id,$args['disableIDs'])){
						$s .= '
						<option id="'.$id.'" value="'.$id.'" style="color:#CCCCCC;" disabled="true"'.$description.'>'.$lbl.'</option>';
					} elseif (!in_array($id, $a_selected_categoriesIDs)) {
						$s .= '
						<option value="'.$id.'"'.$description.'>'.$lbl.'</option>';
					} else {
						$s .= '
						<option value="'.$id.'" style="color: red;"'.$description.'>'.$lbl.'</option>';
					}
				}
			}
			$s .= '
					</select>
				</td>
				<td'.$s_classname.'>
					<input type="button" name="rpass" value="&gt;&gt;"'.$s_inputClassname.' onCLick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxFrom.'\', \''.$s_listboxTo.'\');"/>
					<br /><br />
					<input type="button" name="lpass" value="&lt;&lt;"'.$s_inputClassname.' onCLick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxTo.'\', \''.$s_listboxFrom.'\');"/>
				</td>
				<td'.$s_classname.'>
					<select'.$toID.' ondblclick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxTo.'\', \''.$s_listboxFrom.'\');" name="'.$s_listboxTo.'" multiple="multiple"'.$s_inputClassname.' style="width:'.$s_width.';height:'.$s_height.';">';
				@reset($a_selected_categoriesIDs);
				if (is_array($a_selected_categoriesIDs) && $a_selected_categoriesIDs) {
					foreach ($a_selected_categoriesIDs as $id) {
						$s .= '<option value="'.$id.'">'.trim($a_all_categoriesIDs[$id]).'</option>';
					}
				}
			$s .= '
					</select>
				</td>
			</tr>';
		} elseif($args['position'] == 'vertical'){
			if ($args['leftTitle']) {
				$s .= '
				<tr>
					<td'.$s_classname.'>'.$args['leftTitle'].'</td>
				</tr>';
			}
			$s .= '
			<tr>
				<td'.$s_classname.'>
					<select'.$fromID.' ondblclick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxFrom.'\', \''.$s_listboxTo.'\');" name="'.$s_listboxFrom.'" multiple="multiple"'.$s_inputClassname.' style="width:'.$s_width.';height:'.$s_height.';">';
			@reset($a_all_categoriesIDs);
			if (is_array($a_all_categoriesIDs) && $a_all_categoriesIDs) {
				while (list($id, $lbl) = each($a_all_categoriesIDs)) {
					$description = (isset($args['description'][$id])) ? ' title="'.io::htmlspecialchars($args['description'][$id]).'"' : '';
					if (is_array($args['disableIDs']) && in_array($id,$args['disableIDs'])){
						$s .= '
						<option id="'.$id.'" value="'.$id.'" style="color:#CCCCCC;" disabled="true"'.$description.'>'.$lbl.'</option>';
					} elseif (!in_array($id, $a_selected_categoriesIDs)) {
						$s .= '
						<option value="'.$id.'"'.$description.'>'.$lbl.'</option>';
					} else {
						$s .= '
						<option value="'.$id.'" style="color: red;"'.$description.'>'.$lbl.'</option>';
					}
				}
			}
			$s .= '
					</select>
				</td>
			</tr>';
			$s .= '
			<tr>
				<td'.$s_classname.' style="text-align:center;">
					<input type="button" name="rpass" value="&#8744;&#8744;&#8744;"'.$s_inputClassname.' onCLick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxFrom.'\', \''.$s_listboxTo.'\');"/>&nbsp;&nbsp;
					<input type="button" name="lpass" value="&#8743;&#8743;&#8743;"'.$s_inputClassname.' onCLick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxTo.'\', \''.$s_listboxFrom.'\');"/>
				</td>
			</tr>';
			if ($args['rightTitle']) {
				$s .= '
				<tr>
					<td'.$s_classname.'>'.$args['rightTitle'].'</td>
				</tr>';
			}
			$s .= '
			<tr>
				<td'.$s_classname.'>
					<select'.$toID.' ondblclick="copyFromListBoxToAnother_'.$s_hiddenField.'(\''.$s_listboxTo.'\', \''.$s_listboxFrom.'\');" name="'.$s_listboxTo.'" multiple="multiple"'.$s_inputClassname.' style="width:'.$s_width.';height:'.$s_height.';">';
				@reset($a_selected_categoriesIDs);
				if (is_array($a_selected_categoriesIDs) && $a_selected_categoriesIDs) {
					foreach ($a_selected_categoriesIDs as $id) {
						$s .= '<option value="'.$id.'">'.trim($a_all_categoriesIDs[$id]).'</option>';
					}
				}
			$s .= '
					</select>
				</td>
			</tr>';
		}
		$s .= '
		</table>';
		return $s;
	}
}
?>