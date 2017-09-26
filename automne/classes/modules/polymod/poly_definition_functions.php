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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: poly_definition_funtions.php,v 1.8 2010/03/08 16:43:30 sebastien Exp $

/**
  * static Class CMS_poly_definition_functions
  * Represent a collection of poly_definition functions
  *
  * @package Automne
  * @subpackage polymod
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_poly_definition_functions
{
	/**
	  * Return a list of all pages (for atm-search tag)
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	maxpages : the numer of pages
	  *		currentpage : the current page number
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag
	  * 	<pages>...{n}...</pages>
	  *		<currentpage>...{n}...</currentpage>
	  * @return string : the page list
	  * @access public
	  * @static
	  */
	public static function pages($values, $tags) {
		if (!sensitiveIO::isPositiveInteger($values['maxpages'])) {
			//no pages to display so return
			return '';
		}
		$xml2Array = new CMS_xml2Array();
		$pagesPattern = $xml2Array->getXMLInTag($tags, 'pages');
		$currentPagePattern = $xml2Array->getXMLInTag($tags, 'currentpage');
		$startPagePattern = $xml2Array->getXMLInTag($tags, 'start');
		$endPagePattern = $xml2Array->getXMLInTag($tags, 'end');
		$nextPagePattern = $xml2Array->getXMLInTag($tags, 'next');
		$previousPagePattern = $xml2Array->getXMLInTag($tags, 'previous');
		
		/*if (!$pagesPattern) {
			CMS_grandFather::raiseError("No 'pages' tag found or tag empty");
			return false;
		}*/
		if (!$currentPagePattern) {
			$currentPagePattern = $pagesPattern;
		}
		$return = '';
		//add start and previous content if any
		if ($values['currentpage'] != 1) {
			if ($startPagePattern) {
				$replace = array('{n}' => 1);
				$return .= str_replace(array_keys($replace), $replace, $startPagePattern);
			}
			if ($previousPagePattern) {
				$replace = array('{n}' => $values['currentpage']-1);
				$return .= str_replace(array_keys($replace), $replace, $previousPagePattern);
			}
		}
		//get pages to and from to loop on
		if (!isset($values['displayedpage']) || !sensitiveIO::isPositiveInteger($values['displayedpage'])) {
			$from = 1;
			$to = $values['maxpages'];
		} else {
			//remove current page
			$values['displayedpage'] = $values['displayedpage']-1;
			$half = round(($values['displayedpage'])/2);
			if ($values['currentpage']-$half < 1) {
				$from = 1;
			} else {
				$from = $values['currentpage']-$half;
			}
			if ($values['displayedpage'] + $from > $values['maxpages']) {
				$to = $values['maxpages'];
			} else {
				$to = $values['displayedpage'] + $from;
			}
			while ($to - $from < $values['displayedpage'] && $from > 1) {
				$from--;
			}
		}
		//loop on pages to display
		for($i=$from; $i <= $to; $i++) {
			$replace = array('{n}' => $i);
			if ($i == $values['currentpage']) {
				$return .= str_replace(array_keys($replace), $replace, $currentPagePattern);
			} else {
				$return .= str_replace(array_keys($replace), $replace, $pagesPattern);
			}
		}
		//add next and end content if any
		if ($values['currentpage'] != $values['maxpages']) {
			if ($nextPagePattern) {
				$replace = array('{n}' => $values['currentpage']+1);
				$return .= str_replace(array_keys($replace), $replace, $nextPagePattern);
			}
			if ($endPagePattern) {
				$replace = array('{n}' => $values['maxpages']);
				$return .= str_replace(array_keys($replace), $replace, $endPagePattern);
			}
		}
		return $return;
	}
	
	/**
	  * Return a request value of a given name and check it for a given type
	  *
	  * @param string $name : the request name to get
	  * @param string $type : the type of value to check
	  * @return mixed : the request value
	  * @access public
	  * @static
	  */
	public static function getRequest($name, $type) {
		if ($type == 'string') {
			$type = 'safestring'; //To avoid XSS
		}
		return CMS_poly_definition_functions::getVarContent('request', $name, $type);
	}
	
	/**
	  * Return a session value of a given name and check it for a given type
	  *
	  * @param string $name : the session name to get
	  * @param string $type : the type of value to check
	  * @return mixed : the session value
	  * @access public
	  * @static
	  */
	public static function getSession($name, $type) {
		return CMS_poly_definition_functions::getVarContent('session', $name, $type);
	}
	
	/**
	  * Return a PHP variable value of a given name and check it for a given type
	  *
	  * @param string $name : the variable name to get
	  * @param string $type : the type of value to check
	  * @return mixed : the variable value
	  * @access public
	  * @static
	  */
	public static function getVar($name, $type) {
		return CMS_poly_definition_functions::getVarContent('var', $name, $type);
	}
	
	/**
	  * Return a PHP constant value of a given name and check it for a given type
	  *
	  * @param string $name : the constant name to get
	  * @param string $type : the type of value to check
	  * @return mixed : the constant value
	  * @access public
	  * @static
	  */
	public static function getConstant($name, $type) {
		return CMS_poly_definition_functions::getVarContent('constant', $name, $type);
	}
	
	/**
	  * Return a PHP constant value of a given name and check it for a given type
	  *
	  * @param string $name : the constant name to get
	  * @param string $type : the type of value to check
	  * @return mixed : the constant value
	  * @access public
	  * @static
	  */
	public static function getServer($name, $type) {
		return CMS_poly_definition_functions::getVarContent('server', $name, $type);
	}
	
	/**
	  * Return a variable value of a given name and check it for a given dataType
	  *
	  * @param string $varType : the variable type to get between var, request, session
	  * @param string $name : the variable name to get
	  * @param string $dataType : the type of value to check
	  * @param mixed $varValue : the var value (optionnal to avoid global problems if vars are declared in previous PHP codes)
	  * @return mixed : the variable value
	  * @access public
	  * @static
	  */
	public static function getVarContent($varType, $name, $dataType, $varValue = '') {
		if (!$name || !$dataType) {
			return false;
		}
		switch ($varType) {
			case 'request':
				if ($dataType == 'string') {
					$dataType = 'safestring'; //Force safestring to avoid XSS
				}
				$varContent = isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
			break;
			case 'session':
				$varContent = isset($_SESSION[$name]) ? $_SESSION[$name] : null;
			break;
			case 'var':
				global ${$name};
				$varContent = (isset(${$name}) && ${$name} !== null) ? ${$name} : $varValue;
			break;
			case 'constant':
				$varContent = defined($name) ? constant($name) : null;
			break;
			case 'server':
				$varContent = isset($_SERVER[$name]) ? $_SERVER[$name] : null;
			break;
			default:
				CMS_grandFather::raiseError('Unknown var type to get : '.$varType);
				return false;
			break;
		}
		//pr('Vartype : '.$varType.' - Name : '.$name.' - Datatype : '.$dataType.' - Content : '.$varContent);
		switch ($dataType) {
			case 'int':
				return (int) $varContent;
			break;
			case 'date':
			case 'datetime':
			case 'localisedDate':
				if ($varContent){
					global $cms_language;
					$date = new CMS_date();
					$date->setDebug(false);
					$date->setFormat($cms_language->getDateFormat());
					$date->setLocalizedDate($varContent);
					if ($date->hasError()) {
						return '';
					}
					switch ($dataType) {
						case 'date' :
							return $date->getDBValue(true);
						break;
						case 'datetime':
							return $date->getDBValue(false);
						break;
						case 'localisedDate':
							return $date->getLocalizedDate();
						break;
					}
				} else {
					return '';
				}
			break;
			case 'string':
			case 'unsafestring':
				return (string) $varContent;
			break;
			case 'safestring': //safestring return string without any XSS vector
                return SensitiveIO::sanitizeHTMLString( (string) $varContent );
            break;
			case 'array':
				if (is_array($varContent)) {
					return $varContent;
				} else {
					return array();//false
				}
			break;
			case 'bool':
			case 'boolean':
				if ($varContent === 'true') {
					return true;
				} elseif ($varContent === 'false') {
					return false;
				} else {
					return (bool) $varContent;
				}
			break;
			case 'email':
				if (sensitiveIO::IsValidEmail($varContent)) {
					return $varContent;
				}
			break;
			default:
				CMS_grandFather::raiseError('Unknown data type to get : '.$dataType);
				return '';
			break;
		}
		return '';
	}
	
	/**
	  * Return a wysiwyg plugin output for given parameters
	  *
	  * @param integer $pluginID : the plugin id to use
	  * @param integer $itemID : the item id to use
	  * @param string $selection : the selected wysiwyg text if any
	  * @param boolean $public : the data status
	  * @param boolean $pluginView : is this plugin is intended to be shown in wysiwyg view ? (default false)
	  * @return string : the plugin output
	  * @access public
	  * @static
	  */
	public static function pluginCode($pluginID, $itemID, $selection, $public = false, $pluginView = false) {
		global $cms_user;
		//then create the code to paste for the current selected object if any
		if (sensitiveIO::isPositiveInteger($itemID) && sensitiveIO::isPositiveInteger($pluginID)) {
			//get plugin
			$plugin = new CMS_poly_plugin_definitions($pluginID);
			//set execution parameters
			$parameters = array();
			$parameters['itemID'] = $itemID;
			$parameters['public'] = $public;
			if ($pluginView) {
				$parameters['plugin-view'] = true;
			}
			//get originaly selected text
			if (!$plugin->needSelection()) {
				$parameters['selection'] = '';
			} else {
				$parameters['selection'] = io::decodeEntities($selection);
			}
			//this line is used to optimise text fields (see CMS_object_text) which use a lot of plugin codes.
			//in this case, items are searched before then put in this global var so it is not necessary to do one search for each of them
			if (isset($GLOBALS['polymod']['preparedItems'][$plugin->getValue('objectID')][$itemID])) {
				$parameters['item'] = $GLOBALS['polymod']['preparedItems'][$plugin->getValue('objectID')][$itemID];
			}
			//eval item content
			ob_start();
			eval(sensitiveIO::sanitizeExecCommand(sensitiveIO::stripPHPTags($plugin->getValue('compiledDefinition'))));
			$data = ob_get_contents();
			ob_end_clean();
			return $data;
		}
	}
	
	/**
	  * This function is called to catch and launch all FE forms actions
	  *
	  * @param array $formIDs : the forms ids to check for actions
	  * @param integer $pageID : the current page id
	  * @param boolean $public : the data status
	  * @param string $languageCode : the language code used
	  * @param reference array $polymodFormsError : the forms error status to return
	  * @param reference array $polymodFormsItem : reference to the forms item
	  * @return boolean : true on success, false on failure
	  * @access public
	  * @static
	  */
	public static function formActions($formIDs, $pageID, $languageCode, $public, &$polymodFormsError, &$polymodFormsItems) {
		global $cms_language, $cms_user;
		
		if (!is_array($formIDs)) {
			return false;
		}
		foreach ($formIDs as $formID) {
			if (io::request('formID') && io::request('formID') == $formID) {
				if (!isset($cms_language) || $cms_language->getCode() != $languageCode) {
					$cms_language = new CMS_language($languageCode);
				}
				//instanciate item
				$item = '';
				if (io::request('object', 'io::isPositiveInteger', '')) {
					//check user rights on module
					$module = CMS_poly_object_catalog::getModuleCodenameForObjectType(io::request('object'));
					//Check user rights
					//here assume than user should only need the view right on module, because admin right allow Automne administration access
					if (!is_object($cms_user) || !$cms_user->hasModuleClearance($module, CLEARANCE_MODULE_VIEW)) {
						CMS_grandFather::raiseError('No user found or user has no administration rights on module '.$module);
						return false;
					}
					//instanciate object
					$object = CMS_poly_object_catalog::getObjectDefinition(io::request('object'));
					if ($object && io::request('item', 'io::isPositiveInteger', '')) {
						$search = new CMS_object_search($object,false);
						$search->addWhereCondition('item', io::request('item'));
						$items = $search->search();
						if (isset($items[io::request('item')])) {
							$item = $items[io::request('item')];
						} else {
							$item = new CMS_poly_object($object->getID());
						}
					} else {
						$item = new CMS_poly_object($object->getID());
					}
				}
				if (is_object($item) && !$item->hasError()) {
					//get item fieldsObjects
					$fieldsObjects = &$item->getFieldsObjects();
					//checks and assignments
					$item->setDebug(false);
					
					//first, check mandatory values
					foreach ($fieldsObjects as $fieldID => $aFieldObject) {
						//if field is part of formular
						if (isset($_REQUEST['polymodFields'][$fieldID])) {
							if (!$item->checkMandatory($fieldID, $_REQUEST,'')) {
								$polymodFormsError[$formID]['required'][$fieldID] = $fieldID;
							}
						}
					}
					//second, set values for all fields
					foreach ($fieldsObjects as $fieldID => $aFieldObject) {
						//if field is part of formular
						if (isset($_REQUEST['polymodFields'][$fieldID])) {
							//if form use a callback, call it
							//do not use call_user_function here
							$funcName = 'form_'.$formID.'_'.$fieldID;
							if (!$item->setValues($fieldID, $_REQUEST,'')) {
								$polymodFormsError[$formID]['malformed'][] = $fieldID;
							} elseif (!isset($polymodFormsError[$formID]['required'][$fieldID]) && function_exists('form_'.$formID.'_'.$fieldID)
										&& !$funcName($formID, $fieldID, $item)) {
								$polymodFormsError[$formID]['malformed'][] = $fieldID;
							}
						}
					}
					//set publication dates if needed
					if (isset($_REQUEST['polymodFields']) && $_REQUEST['polymodFields']) {
						if ($object->isPrimaryResource()) {
							// Dates management
							$dt_beg = new CMS_date();
							$dt_beg->setDebug(false);
							$dt_beg->setFormat($cms_language->getDateFormat());
							$dt_end = new CMS_date();
							$dt_end->setDebug(false);
							$dt_end->setFormat($cms_language->getDateFormat());
							if (!$dt_set_1 = $dt_beg->setLocalizedDate(@$_REQUEST["pub_start"], true)) {
								$polymodFormsError[$formID]['malformed'][] = 'pub_start';
							} 
							if (!$dt_set_2 = $dt_end->setLocalizedDate(@$_REQUEST["pub_end"], true)) {
								$polymodFormsError[$formID]['malformed'][] = 'pub_end';
							}
							//if $dt_beg && $dt_end, $dt_beg must be lower than $dt_end
							if (!$dt_beg->isNull() && !$dt_end->isNull()) {
								if (CMS_date::compare($dt_beg, $dt_end, '>')) {
									$polymodFormsError[$formID]['malformed'][] = 'pub_start';
									$polymodFormsError[$formID]['malformed'][] = 'pub_end';
									$dt_set_1 = $dt_set_2 = false;
								}
							}
							if ($dt_set_1 && $dt_set_2) {
								$item->setPublicationDates($dt_beg, $dt_end);
							}
						}
					}
					//Check form token
					if (!isset($_POST["atm-token"]) || !CMS_session::checkToken(MOD_POLYMOD_CODENAME.'-'.$formID, $_POST["atm-token"])) {
						$polymodFormsError[$formID]['error'][] = 'form-token';
						return false;
					} else {
						//Token is used so expire it
						CMS_session::expireToken(MOD_POLYMOD_CODENAME.'-'.$formID);
					}
					if (!$polymodFormsError[$formID]) {
						//save the data
						if (!$item->writeToPersistence()) {
							$polymodFormsError[$formID]['error'][] = 'write';
							$polymodFormsError[$formID]['filled'] = 0;
						} else {
							$polymodFormsError[$formID]['filled'] = 1;
							//if form use a callback, call it
							//do not use call_user_function here
							$funcName = 'form_'.$formID;
							if (function_exists('form_'.$formID) && !$funcName($formID, $item)) {
								$polymodFormsError[$formID]['filled'] = 0;
								$polymodFormsError[$formID]['error'][] = 'callback';
							}
						}
						//if item is a primary resource, unlock it
						if ($object->isPrimaryResource()) {
							$item->unlock();
						}
					} else {
						$polymodFormsError[$formID]['filled'] = 0;
					}
					//save item for later use
					$polymodFormsItems[$formID] = $item;
				} else {
					$polymodFormsError[$formID]['filled'] = 0;
					$polymodFormsError[$formID]['error'][] = 'right';
					CMS_grandFather::raiseError('No item found or user has no administration rights on item... ');
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	  * 
	  *
	  * @param string $helper : 
	  * @param mixed $string : 
	  * @return mixed : 
	  * @access public
	  * @static
	  */
	public static function helper($helper, $value) {
		//split params if any
		$params = (io::strpos($value, '|') !== false) ? explode('|', $value) : array($value);
		if (is_callable($helper, false)) {//check if function/method name exists. false to adress bug 1389
			if (io::strpos($helper, '::') !== false) {//static method call
				$method = explode('::', $helper);
				return call_user_func_array(array($method[0], $method[1]), $params);
			} else { //function call
				return call_user_func_array($helper, $params);
			}
		}
		CMS_grandFather::raiseError('Unknown function '.$helper);
		return $value;
	}
}
?>
