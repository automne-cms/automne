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
// $Id: poly_module_structure.php,v 1.4 2010/03/08 16:43:30 sebastien Exp $

/**
  * static Class CMS_poly_module_structure
  *
  * Recursive structure of polymorphic modules
  * /!\ All these methods are really hard to explain and are very important. Be careful if modifying them!
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_module_structure
{
	/**
	  * Polymod Messages
	*/
	const MESSAGE_PAGE_OBJECT_NAME = 121;
	const MESSAGE_PAGE_OBJECT_VARS = 122;
	const MESSAGE_PAGE_OBJECT_FUNCTIONS = 123;
	const MESSAGE_PAGE_OBJECT_OPERATORS = 378;
	const MESSAGE_PAGE_OBJECT_OPERATORS_DESCRIPTION = 379;
	const MESSAGE_PAGE_OBJECT_ATM_INPUT_OPERATORS = 391;
  	const MESSAGE_PAGE_OBJECT_ATM_INPUT_OPERATORS_DESCRIPTION = 392;
	/**
	  * Return a recursive structure for all objects of a given module based on objects definition
	  *
	  * @param string $module the module codename
	  * @param boolean $withObjectInfos returned structure contain objects infos (default false)
	  * @return multidimensionnal array : the recursive structure of all objects of the given module
	  * @access public
	  * @static
	  */
	function getModuleStructure($module, $withObjectInfos = false) {
		$sql = "select
					object_id_mof as objectID,
					type_mof as fieldType,
					id_mof as fieldID
				from
					mod_object_definition,
					mod_object_field
				where
					module_mod='".sensitiveIO::sanitizeSQLString($module)."'
					and id_mod = object_id_mof
				order by objectID, order_mof
		";
		$q = new CMS_query($sql);
		$flatStructure = array();
		if ($q->getNumRows()) {
			while($r = $q->getArray()) {
				$flatStructure['object'.$r['objectID']]['field'.$r['fieldID']] = $r['fieldType'];
			}
		}
		if ($withObjectInfos) {
			$objectInfos = array();
		}
		$structure = CMS_poly_module_structure::_createRecursiveStructure($flatStructure, $flatStructure, $objectInfos);
		if ($withObjectInfos) {
			 $structure['objectInfos'] = $objectInfos;
		}
		return $structure;
	}

	/**
	  * Return a recursive structure of all objects of a given module
	  *
	  * @param array $structure the flat structure of all objects (function recurse on this value)
	  * @param array $structure the flat structure reference of all objects
	  * @param mixed $infos if array : reference of objects infos else nothing
	  * @return multidimensionnal array : the recursive structure of all objects of the given module
	  * @access private
	  * @static
	  */
	protected function _createRecursiveStructure($structure, $flatStructure, &$infos) {
		if ($structure) {
			foreach($structure as $key => $value) {
				if (is_array($value)) {
					$structure[$key] = CMS_poly_module_structure::_createRecursiveStructure($value, $flatStructure, $infos);
				} elseif (io::strpos($value,"multi|") !== false) {
					$structure[$key] = array('multiobject'.io::substr($value,6) => CMS_poly_module_structure::_createRecursiveStructure($flatStructure['object'.io::substr($value,6)], $flatStructure, $infos));
				} elseif (sensitiveIO::isPositiveInteger($value)) {
					$structure[$key] = array('object'.$value => CMS_poly_module_structure::_createRecursiveStructure($flatStructure['object'.$value], $flatStructure, $infos));
				}
				if (is_array($infos) && !isset($infos[$key])) {
					if (io::strpos($key,"field") !== false) {
						$infos[$key] = new CMS_poly_object_field(io::substr($key,5));
						if (!sensitiveIO::isPositiveInteger($value) && io::strpos($value,"multi|") === false && class_exists($value)) {
							$infos[$value] = new $value(array(), $infos[$key]);
						}
					} elseif (io::strpos($key,"object") !== false) {
						$infos[$key] = new CMS_poly_object_definition(io::substr($key,6));
					}
				}
			}
		}
		return $structure;
	}

	/**
	  * Return a variable conversion table of a given module (human readable to machine readable)
	  *
	  * @param string $module the module codename
	  * @return array : the converstion table of all objects of the given module
	  * @access public
	  * @static
	  */
	function getModuleTranslationTable($module, &$language) {
		if (!is_a($language, 'CMS_language')) {
			CMS_grandFather::raiseError("Language must be a valid CMS_langage object");
			return false;
		}
		$moduleDetailledStructure = CMS_poly_module_structure::getModuleDetailledStructure($module, $language);
		return $moduleDetailledStructure['translationtable'];
	}

	/**
	  * Return a recursive structure of all objects of a given module
	  *
	  * @param string $module the module codename
	  * @param mixed $language if is a CMS_language object, then load translated path for given language (default : false)
	  * @return multidimensionnal array : the recursive structure of all objects of the given module
	  * @access public
	  * @static
	  */
	function getModuleDetailledStructure($module, $language = false) {
		$moduleStructure = CMS_poly_module_structure::getModuleStructure($module, true);
		$objectInfos = $moduleStructure['objectInfos'];
		unset($moduleStructure['objectInfos']);
		$translationtable = array();
		foreach ($moduleStructure as $object => $objectStructure) {
			$moduleDetailledStructure[$object] = $objectInfos[$object]->getStructure();
			$moduleDetailledStructure[$object]['path'] = '[\''.$object.'\']';
			if ($language && is_a($language, 'CMS_language')) {
				$moduleDetailledStructure[$object]['translatedpath'] = sensitiveIO::sanitizeAsciiString($objectInfos[$object]->getLabel($language));
				CMS_poly_module_structure::_updateTranslationTable($translationtable, $moduleDetailledStructure[$object]);
			}
			$moduleDetailledStructure[$object]['fields'] = CMS_poly_module_structure::_createRecursiveDetailledStructure($objectStructure, $objectInfos, $language, $translationtable, $moduleDetailledStructure[$object]['path']."['fields']", $moduleDetailledStructure[$object]['translatedpath']);
		}
		if ($language && is_a($language, 'CMS_language')) {
			$moduleDetailledStructure = (isset($moduleDetailledStructure) && is_array($moduleDetailledStructure)) ? array_merge($moduleDetailledStructure, array('translationtable' => $translationtable)) : array('translationtable' => $translationtable);
		}
		return $moduleDetailledStructure;
	}
	//private function of getModuleDetailledStructure
	protected function _createRecursiveDetailledStructure($objectsStructure, &$objectInfos, &$language, &$translationtable, $path, $translatedpath) {
		$structure = array();
		foreach ($objectsStructure as $fieldID => $field) {
			if (!is_array($field)) { //Field
				if (class_exists($field)) {
					$object = new $field(array(), $objectInfos[$fieldID]);
					//get object structure infos
					$structure[io::substr($fieldID,5)] = $object->getStructure();
					//create path and translated path
					$structure[io::substr($fieldID,5)]['path'] = $path.'['.io::substr($fieldID,5).']';
					$structure[io::substr($fieldID,5)]['fieldID'] = io::substr($fieldID,5);
					if ($language && is_a($language, 'CMS_language')) {
						$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectInfos[$fieldID]->getLabel($language));
						$count = 1;
						while (isset($translationtable[$structure[io::substr($fieldID,5)]['translatedpath']])) {
							$count++;
							$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectInfos[$fieldID]->getLabel($language)).$count;
						}
						CMS_poly_module_structure::_updateTranslationTable($translationtable, $structure[io::substr($fieldID,5)]);
					}
				}
			} else {
				$object = array_shift(array_keys($field));
				if (io::strpos($object, 'object') === 0) { //poly_object
					//get object structure infos
					$structure[io::substr($fieldID,5)] = $objectInfos[$object]->getStructure();
					//create path and translated path
					$structure[io::substr($fieldID,5)]['path'] = $path.'['.io::substr($fieldID,5).']';
					$structure[io::substr($fieldID,5)]['fieldID'] = io::substr($fieldID,5);
					if ($language && is_a($language, 'CMS_language')) {
						$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectInfos[$object]->getLabel($language));
						$count = 1;
						while (isset($translationtable[$structure[io::substr($fieldID,5)]['translatedpath']])) {
							$count++;
							$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectInfos[$object]->getLabel($language)).$count;
						}
						CMS_poly_module_structure::_updateTranslationTable($translationtable, $structure[io::substr($fieldID,5)]);
					}
					//recurse on fields
					$structure[io::substr($fieldID,5)]['fields'] = CMS_poly_module_structure::_createRecursiveDetailledStructure($field[$object], $objectInfos, $language, $translationtable, $structure[io::substr($fieldID,5)]['path']."['fields']", $structure[io::substr($fieldID,5)]['translatedpath']);
				} elseif (io::strpos($object, 'multiobject') === 0) { //multi poly_object
					$objectDef = new CMS_multi_poly_object(io::substr($object,11), $datas = array(), $objectInfos[$fieldID]);
					//get object structure infos
					$structure[io::substr($fieldID,5)] = $objectDef->getStructure();
					//create path and translated path
					$structure[io::substr($fieldID,5)]['path'] = $path.'['.io::substr($fieldID,5).']';
					$structure[io::substr($fieldID,5)]['fieldID'] = io::substr($fieldID,5);
					if ($language && is_a($language, 'CMS_language')) {
						$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectDef->getFieldLabel($language));
						$count = 1;
						while (isset($translationtable[$structure[io::substr($fieldID,5)]['translatedpath']])) {
							$count++;
							$structure[io::substr($fieldID,5)]['translatedpath'] = $translatedpath.':'.sensitiveIO::sanitizeAsciiString($objectDef->getFieldLabel($language)).$count;
						}
						CMS_poly_module_structure::_updateTranslationTable($translationtable, $structure[io::substr($fieldID,5)]);
					}
					//recurse on fields
					$subobjectsDef = array('fieldn' => array('object'.io::substr($object,11) => $field[$object]));
					$structure[io::substr($fieldID,5)]['fields'] = CMS_poly_module_structure::_createRecursiveDetailledStructure($subobjectsDef, $objectInfos, $language, $translationtable, $structure[io::substr($fieldID,5)]['path']."['fields']", $structure[io::substr($fieldID,5)]['translatedpath']);
				}
			}
		}
		return $structure;
	}
	//private function of _createRecursiveDetailledStructure
	protected function _updateTranslationTable(&$translationtable, &$datas) {
		$levelkeys = array();
		$levelkeys = $datas;
		if ($datas['path']) {
			$path = $datas['path'];
			unset($levelkeys['path']);
		}
		if ($datas['translatedpath']) {
			$translatedpath = $datas['translatedpath'];
			unset($levelkeys['translatedpath']);
		}
		if (isset($datas['fieldID']) && !$datas['fieldID']) {
			//unset fieldID if it is on a top level object (not a field of another object)
			unset($levelkeys['fieldID']);
		}

		foreach ($levelkeys as $levelkey => $levelvalue) {
			if (is_array($levelvalue)) {
				if ($translatedpath && $path) {
					if ($levelkey != 'n') {
						$translationtable[$translatedpath] = $path;
						$levelvalue['path'] = $path.'[\''.$levelkey.'\']';
						$levelvalue['translatedpath'] = $translatedpath.':'.$levelkey;
						$translationtable[$levelvalue['translatedpath']] = $levelvalue['path'];
					} else {
						$levelvalue['path'] = $path.'['.$levelkey.']';
						$levelvalue['translatedpath'] = $translatedpath;
					}
					CMS_poly_module_structure::_updateTranslationTable($translationtable, $levelvalue);
				}
			} else {
				if ($translatedpath && $path) {
					//here we do not want to overwrite existing translation (by example, path which end by an 'n' value is not necessary)
					if (!isset($translationtable[$translatedpath])) {
						$translationtable[$translatedpath] = $path;
					}
					$translationtable[$translatedpath.':'.$levelkey] = $path.'[\''.$levelkey.'\']';
				}
			}
		}
		return true;
	}

	/**
	  * Return an options tag list (for select tag) of all module objects infos
	  *
	  * @param string $codename the module codename
	  * @param CMS_language $language : current language
	  * @param string $selectedValue : the current selected value of the list
	  * @param integer $objectID : the module object ID to restrict the list (default false : all objects of the module)
	  * @return string : the options tag list
	  * @access public
	  * @static
	  */
	function viewObjectInfosList($codename, &$language, $selectedValue, $objectID = false) {
		//get module structure
		$objectsStructure = CMS_poly_module_structure::getModuleStructure($codename, true);
		if ($objectID && isset($objectsStructure['object'.$objectID])) {
			$currentPath = '[\'object'.$objectID.'\']';
			$selected = ($currentPath == $selectedValue) ? ' selected="selected"':'';
			$list = '<option value="'.$currentPath.'" style="font-weight: bold;"'.$selected.'>'.$objectsStructure['objectInfos']['object'.$objectID]->getObjectLabel($language).'</option>';
			$list .= CMS_poly_module_structure::_viewObjectInfosList($objectID, $language, $objectsStructure, $selectedValue, '[object'.$objectID.']');
		} else {
			$list = '';
			foreach ($objectsStructure as $objectID => $objectStructure) {
				if ($objectID != 'objectInfos') {
					$currentPath = '[\''.$objectID.'\']';
					$selected = ($currentPath == $selectedValue) ? ' selected="selected"':'';
					$list .= '<option value="'.$currentPath.'" style="font-weight: bold;"'.$selected.'>'.$objectsStructure['objectInfos'][$objectID]->getObjectLabel($language).'</option>';
					$list .= CMS_poly_module_structure::_viewObjectInfosList(io::substr($objectID,6), $language, $objectsStructure, $selectedValue, $currentPath);
				}
			}
		}
		return $list;
	}
	//private function of viewObjectInfosList
	protected function _viewObjectInfosList($objectID, &$language, &$objectsStructure, $selectedValue, $path = '') {
		static $level;
		$level++;
		$space = str_replace(' ', '|&nbsp;&nbsp;',sprintf("%".($level-1)."s",  '')).'|-&nbsp;';
		$style = ($level <= 2) ? 'color: black;':'color: grey;';
		$style .= 'font:11px Fixed, monospace;';
		$html = '';
		if ($objectsStructure['object'.$objectID]) {
			foreach ($objectsStructure['object'.$objectID] as $objectFieldID => $objectField) {
				if (!is_array($objectField) && class_exists($objectField)) {
					$currentPath = $path.'[\''.$objectFieldID.'\']';
					$selected = ($currentPath == $selectedValue) ? ' selected="selected"':'';
					$html .= '<option value="'.$currentPath.'" style="'.$style.'"'.$selected.'>'.$space.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($language).'</option>'."\n";
				} elseif (is_array($objectField)) {
					$object = array_shift(array_keys($objectField));
					//$currentPath = $path.'[\''.$objectFieldID.'\'][\''.$object.'\']';
					$currentPath = $path.'[\''.$objectFieldID.'\']';
					$selected = ($currentPath == $selectedValue) ? ' selected="selected"':'';
					if (io::strpos($object, 'object') === 0) {
						$html .= '<option value="'.$currentPath.'" style="'.$style.'"'.$selected.'>'.$space.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($language).'</option>'."\n";
						$html .= CMS_poly_module_structure::_viewObjectInfosList(io::substr($object,6), $language, $objectsStructure, $selectedValue, $currentPath);
					} elseif (io::strpos($object, 'multiobject') === 0) {
						$html .= '<option value="'.$currentPath.'" style="'.$style.'"'.$selected.'>'.$space.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($language).' ('.$objectsStructure['objectInfos']['object'.io::substr($object,11)]->getObjectLabel($language).')</option>'."\n";
						$currentPath = $path.'[\''.$objectFieldID.'\'][\''.$object.'\']';
						$html .= CMS_poly_module_structure::_viewObjectInfosList(io::substr($object,11), $language, $objectsStructure, $selectedValue, $currentPath);
					}
				}
			}
		}
		$level--;
		return $html;
	}

	/**
	  * Return all infos for selected object
	  *
	  * @param string $codename the module codename
	  * @param CMS_language $language : current language
	  * @param string $selectedValue : the current select value of the list
	  * @param integer $objectID : the module object ID to restrict the list (default false : all objects of the module)
	  * @return string : the options tag list
	  * @access public
	  * @static
	  */
	function viewObjectRowInfos($codename, &$language, $selectedValue) {
		$return = '<div class="rowComment">';
		//first, need to convert the $selectedValue which is a moduleStructurePath format into a moduleDetailledStructurePath format
		$convertedSelectedValue = CMS_poly_module_structure::moduleStructure2moduleDetailledStructure($selectedValue);
		//then get module detailledStructure
		$objectsDetailledStructure = CMS_poly_module_structure::getModuleDetailledStructure($codename, $language);
		//get seleted detailledInfos
		$detailledInfos = @eval(sensitiveIO::sanitizeExecCommand('return $objectsDetailledStructure'.$convertedSelectedValue.';'));
		//get object for this detailled structure path
		$object = CMS_poly_module_structure::getObjectForDetailledStructurePath($convertedSelectedValue);
		//then create corresponding object Infos
		if (is_array($detailledInfos) && $detailledInfos) {
			//pr(get_class($object));
			$objectLabels = $object->getLabelsStructure($language, $detailledInfos['translatedpath']);
			$return .= '
			<h2>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_NAME,false,MOD_POLYMOD_CODENAME).' : {'.$detailledInfos['translatedpath'].'}</h2>
			<div class="retrait">';
			if (isset($objectLabels['structure']) && is_array($objectLabels['structure']) && $objectLabels['structure']) {
				$return .= '<h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_VARS,false,MOD_POLYMOD_CODENAME).' :</h3><ul>';
				foreach ($objectLabels['structure'] as $name => $label) {
					$return .= '<li><span class="vertclair">{'.$detailledInfos['translatedpath'].':'.$name.'}</span> : '.$label.'</li>';
				}
				$return .= '</ul>';
			}
			if (isset($objectLabels['function']) && is_array($objectLabels['function']) && $objectLabels['function']) {
				$return .= '<h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_FUNCTIONS,false,MOD_POLYMOD_CODENAME).' :</h3><ul>';
				foreach ($objectLabels['function'] as $name => $label) {
					$return .= '<li><span class="keyword">'.$name.'</span> : '.$label.'</li>';
				}
				$return .= '</ul>';
			}
			if (isset($objectLabels['operator']) && is_array($objectLabels['operator']) && $objectLabels['operator']) {
				$return .= '<h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_OPERATORS,false,MOD_POLYMOD_CODENAME).' :</h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_OPERATORS_DESCRIPTION,false,MOD_POLYMOD_CODENAME).'<ul>';
				foreach ($objectLabels['operator'] as $name => $label) {
					$return .= '<li><span class="keyword">'.$name.'</span> : '.$label.'</li>';
				}
				$return .= '</ul>';
			}
			if (isset($objectLabels['atmInputOperator']) && is_array($objectLabels['atmInputOperator']) && $objectLabels['atmInputOperator']) {
				$return .= '<h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_ATM_INPUT_OPERATORS,false,MOD_POLYMOD_CODENAME).' :</h3>'.$language->getMessage(self::MESSAGE_PAGE_OBJECT_ATM_INPUT_OPERATORS_DESCRIPTION,false,MOD_POLYMOD_CODENAME).'<ul>';
				foreach ($objectLabels['atmInputOperator'] as $name => $label) {
					$return .= '<li><span class="keyword">'.$name.'</span> : '.$label.'</li>';
				}
				$return .= '</ul>';
			}
			$return .= '</div></div>';
		}
		return $return;
	}

	/**
	  * Convert a moduleStructurePath into a moduleDetailledStructurePath
	  *
	  * @param string $value : the value to convert
	  * @return string : the converted value
	  * @access public
	  * @static
	  */
	function moduleStructure2moduleDetailledStructure($value) {
		$replace = array();
		$replace["#\['field([0-9]+)'\]#U"] = '[\'fields\'][\1]';
		$replace["#\['multiobject[0-9]+'\]#U"] = '[\'fields\'][\'n\']';
		return preg_replace(array_keys($replace), $replace, $value);
	}

	/**
	  * Get an object for a given moduleDetailledStructurePath
	  *
	  * @param string $value : the value to convert
	  * @return string : the converted value
	  * @access public
	  * @static
	  */
	function getObjectForDetailledStructurePath($detailledPath) {
		if (io::strpos($detailledPath, 'fields') !== false) {
			$replace = array("#\[([0-9]+)\]$#U" => '\1');
			if (preg_match("#\[([0-9]+)\]$#U", $detailledPath, $match)) {
				$field = new CMS_poly_object_field($match[1]);
				return $field->getTypeObject();
			} else {
				CMS_grandFather::raiseError("Malformed detailledStructurePath : ".$detailledPath);
				return false;
			}
		} elseif (io::strpos($detailledPath, '[\'object') === 0) {
			return new CMS_poly_object(io::substr($detailledPath,8,-2));
		} else {
			CMS_grandFather::raiseError("Malformed detailledStructurePath : ".$detailledPath);
			return false;
		}
	}
}
?>
