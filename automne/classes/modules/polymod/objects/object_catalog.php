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
// $Id: object_catalog.php,v 1.3 2010/03/08 16:43:33 sebastien Exp $

/**
  * static Class CMS_object_catalog
  *
  * catalog of simple objects
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_catalog
{
	/**
	  * Gets all objects
	  *
	  * @param CMS_poly_object_field $field, the reference field which will be used by those objects
	  * @param boolean $sort, sort objects list (alphabetically by name). Use global $cms_language. Default false (unsorted).
	  * @return array(string "CMS_object_{type}" => object CMS_object_{type})
	  * @access public
	  * @static
	  */
	function getObjects(&$field, $sort=false) {
		$objectsNames = CMS_object_catalog::getObjectsNames();
		$return = array();
		foreach($objectsNames as $anObjectName) {
			$return[$anObjectName] = new $anObjectName(array(),$field);
		}
		if ($sort) {
			global $cms_language;
			if (is_object($cms_language)) {
				$labels = array();
				foreach ($return as $key => $object) {
					$labels[$key] = $object->getObjectLabel($cms_language);
				}
				//natural sort of objects
				natcasesort($labels);
				$returnSorted = array();
				foreach ($labels as $key => $label) {
					$returnSorted[$key] = $return[$key];
				}
				$return = $returnSorted;
			}
		}
		return $return;
	}
	
	/**
	  * Gets all available objects class names
	  *
	  * @return array(string "CMS_object_{type}")
	  * @access public
	  * @static
	  */
	function getObjectsNames() {
		//Automatic listing
		$excludedFiles = array(
			'object_catalog.php', //this file
			'object_common.php',  //objects common file
		);
		$packages_dir = dir(PATH_MODULES_FS.'/'.MOD_POLYMOD_CODENAME.'/objects/');
		while (false !== ($file = $packages_dir->read())) {
			if (io::substr($file, - 4) == ".php" && !in_array($file, $excludedFiles) && class_exists('CMS_'.io::substr($file, 0, -4))) {
				$objectsCatalog[] = 'CMS_'.io::substr($file, 0, -4);
			}
		}
		return $objectsCatalog;
	}
}

?>