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

// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cms_aliases.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_module_cms_aliases
  *
  * represent the standard module.
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */


/**
  * Codename of the agenram module
  */
define("MOD_CMS_ALIAS_CODENAME", "cms_aliases");

//standard module includes
//clientspace, rows and blocks
require_once(PATH_MODULES_FS."/".MOD_CMS_ALIAS_CODENAME."/resource.php");

class CMS_module_cms_aliases extends CMS_moduleValidation
{
	/**
	  * Array of resources infos
	  * The first record is the primary resource of the module.
	  * All other key field of other resources defined need to correspond to the first resource field and does not necessary represent the table key.
	  * For module who does not use Automne resource, leave array empty.
	  * @var multidimentional array (tableName => array ('key' => keyFielname, 'resource' => resourceFieldname))
	  * @access private
	  */
	protected $_resourceInfo	= array();
	
	/**
	  * Method to get the item label
	  * @var string
	  * @access private
	  */
	protected $_resourceNameMethod 	= '';
	
	/**
	  * File name to be queried for the item previzualisation
	  * A param "item" is passed to this file with the ID of the resource to previz.
	  * @var string
	  * @access private
	  */
	protected $_resourcePrevizFile 	= "";
	
	/**
	  * Constructor.
	  * initializes the module object
	  *
	  * @return void
	  * @access public
	  */
	function __construct()
	{
		//Initialize object.
		parent::__construct(MOD_CMS_ALIAS_CODENAME);
	}
	
	/**
	  * Gets resource by its internal ID (not the resource table DB ID)
	  * This function need to stay here because sometimes it is directly queried
	  *
	  * @param integer $resourceID The DB ID of the resource in the module table(s)
	  * @return CMS_resource The CMS_resource subclassed object
	  * @access public
	  */
	function getResourceByID($resourceID)
	{
		parent::getResourceByID($resourceID);
		return new CMS_resource_cms_aliases($resourceID);
	}
}
?>