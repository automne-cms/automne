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
// $Id: xmlparser.php,v 1.2 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_XMLParser
  *
  * Shadow class, only for backward compatibility with Automne below V4
  *
  * @package Automne
  * @subpackage deprecated
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_XMLParser extends CMS_grandFather
{
	function __construct()
	{
		$this->raiseError(__CLASS__.' class is no longer available in this version of Automne');
		return false;
	}
	function __call($name, $parameters)
	{
		$this->raiseError(__CLASS__.' : method '.$name.' is no longer available in this version of Automne');
		return false;
	}
}
?>