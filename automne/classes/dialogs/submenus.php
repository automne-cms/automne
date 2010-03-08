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
// $Id: submenus.php,v 1.2 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_subMenus
  *
  * Utility class : used to show a pack of menus,  which are post forms
  *
  * @package CMS
  * @subpackage common
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_subMenus extends CMS_grandFather
{
	/**
	  * Array of CMS_action
	  *
	  * @var array(string=>CMS_action) The Actions possible indexed by action group label
	  * @access private
	  */
	protected $_actions = array();
	
	/**
	  * Adds an action defined by its group, label and form action attribute
	  *
	  * @param string $group The action group
	  * @param string $label The action label
	  * @param string $formAction The action form action atribute
	  * @return CMS_action The added action.
	  * @access public
	  */
	function &addAction($group, $label, $formAction, $picto=false)
	{
		$added_action = new CMS_subMenu($label, $formAction, $picto);
		$this->_actions[$group][] =& $added_action;
		return $added_action;
	}
	
	/**
	  * Return HTML code for the Menu
	  *
	  * @param boolean $withlabel with group menu label on top
	  * @return string The Menu HTML code.
	  * @access public
	  */
	function getContent($withlabel=false)
	{
		if (is_array($this->_actions) && $this->_actions) {
			if ($withlabel) {
				$content = '
					<table width="100%" height="52" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="100%" height="52" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond_topSubMenu.gif" nowrap="nowrap" align="center">
								<table border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td>
											<table border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td width="1" height="17" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/demi_tireth.gif" border="0" /></td>
												</tr>
												<tr>
													<td width="1" height="35" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>
												</tr>
											</table>
										</td>
								';
								foreach ($this->_actions as $group=>$group_actions) {
									$content .= '
									<td>
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td height="17" colspan="'.sizeof($group_actions).'" class="admin_SubMenuTopTitle" align="center">' .$group. '</td>
												<td width="1" height="17" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/demi_tireth.gif" border="0" /></td>
											</tr>
											<tr>
									';
									foreach ($group_actions as $action) {
										$content .= $action->getContent();
									}
									$content .= '
												<td width="1" height="35" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>
											</tr>
										</table>
									</td>';
								}
						$content .= '</tr>
								</table>
							</td>
						</tr>
					</table>';
			} else {
				$content = '<table border="0" cellpadding="0" cellspacing="0"><tr>';
				//DHTML link
				$content .= '<td width="61" height="35" onMouseOver="button=true;showMenu(\'CMS_actionMenu\');" onMouseOut="hideMenu(\'CMS_actionMenu\');" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/menu_off.gif" style="cursor: pointer;" name="image_CMS_actionMenu" border="0" /></td>';
				foreach ($this->_actions as $group=>$group_actions) {
					foreach ($group_actions as $action) {
						$content .= $action->getContent();
					}
					$content .= '<td width="1" height="35" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
				}
				$content .= '</tr></table>';
			}
			return $content;
		}
	}
	
	function getDHTMLMenu($popup=false)
	{
		if (is_array($this->_actions) && $this->_actions) {
			$content = '
			<div class="admin_divMenu" id="CMS_actionMenu"';
			$content .= (!$popup) ? ' onMouseOver="showMenu(\'CMS_actionMenu\');" onMouseOut="hideMenu(\'CMS_actionMenu\');">' : '>';
			$content .= '
				<table border="0" cellpadding="0" cellspacing="0">
				<tr><td width="100%" height="1" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tiret.gif"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td></tr>';
			foreach ($this->_actions as $group=>$group_actions) {
				foreach ($group_actions as $action) {
					$content .= (!$popup) ? $action->getContent('DHTML') : $action->getContent('popup');
				}
				$content .= '<tr><td width="100%" height="1" background="'.PATH_ADMIN_IMAGES_WR.'/tiret.gif"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td></tr>';
			}
			$content .= '
				</table>
			</div>';
			return $content;
		}
	}
}

?>