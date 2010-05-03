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
// $Id: update-definitions.php,v 1.5 2010/03/08 16:42:07 sebastien Exp $

/**
  * Update all stored definitions for polymod modules
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

CMS_polymod::compileDefinitions();

echo "Objects definitions recompilations is done.<br />";
?>