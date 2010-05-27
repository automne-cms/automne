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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: resourcevalidationscatalog.php,v 1.2 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_resourceValidationsCatalog
  *
  * Manages the catalog of resourceValidations
  *
  * @package Automne
  * @subpackage workflow
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_resourceValidationsCatalog extends CMS_grandFather
{
	/**
	  * Returns a resourceValidation object instance from a DB id or from GetValidationByID function if exists.
	  * Static function.
	  *
	  * @param integer $id the id of the saved object
	  * @return resourceValidation the instance unserialized, false if not found.
	  * @access public
	  */
	function getValidationInstance($id,$user=false)
	{
		if (!SensitiveIO::isPositiveInteger($id) && base64_decode($id) && $user) {
			//load validation form encoded ID (new validations system)
			$decodedID = explode('||',base64_decode($id));
			$module = CMS_modulesCatalog::getByCodename($decodedID[0]);
			$editions = $decodedID[1];
			$resourceID = $decodedID[2];
			if (isset($module) && isset($editions) && isset($resourceID)) {
				return $module->getValidationByID($resourceID, $user, $editions);
			}
		}
		
		$sql = "
			select
				serializedObject_rv as data
			from
				resourceValidations
			where
				id_rv='".$id."'
		";
		$q = new CMS_query($sql);
		
		if ($q->getNumRows()) {
			$instance = unserialize(stripslashes($q->getValue("data")));
			$instance->setID($id);
			return $instance;
		} else {
			parent::raiseError("Unknown id : ".$id);
			return false;
		}
	}
	
	/**
	  * Returns all the resource validations the user can do
	  * Static function.
	  *
	  * @param CMS_user $user The user we want the validations of
	  * @param string $module_codebame The module codename we want the validations of, if ommitted, validations for all the modules will be returned
	  * @return array(string=>CMS_resourceValidation) The validations to do, indexed by module codename
	  * @access public
	  */
	function getValidations(&$user, $module_codename = false)
	{
		if (!is_a($user, "CMS_user")) {
			parent::raiseError("User is not a valid CMS_user object");
			return;
		}
		if ($module_codename) {
			if (!$module = CMS_resourceModulesCatalog::getByCodename($codename)) {
				return;
			}
		}
		
		if ($module) {
			$modules = array($module);
		} else {
			$modules = CMS_modulesCatalog::getAll();
		}
		
		$validations = array();
		foreach ($modules as $aModule) {
			if (!$user->hasValidationClearance($aModule->getID())) {
				continue;
			}
			$validations_to_add = $aModule->getValidations($user);
			if ($validations_to_add) {
				$validations[$aModule->getCodename()] = $validations_to_add;
			}
		}
		
		return $validations;
	}
}

?>