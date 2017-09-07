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
// $Id: loadingDialog.php,v 1.2 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_LoadingDialog
  *
  * Interface generation : send texts in real-time to user navigator.
  *
  * @package Automne
  * @subpackage deprecated
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_LoadingDialog extends CMS_dialog
{
	static function startLoadingMode()
	{
		@set_time_limit(0);
		@ini_set('output_buffering','Off');
		@ob_end_flush();
		CMS_LoadingDialog::sendToUser('<div style="margin-left:15px;">');
	}
	
	/**
	  * Send a text and flush
	  *
	  * @var string $text : the text to send
	  * @access public
	  */
	static function sendToUser($text)
	{
		echo $text;
		@ob_start();
		@ob_end_clean();
		@flush();
		@ob_end_flush();
		@usleep(1);
	}
	
	/**
	  * Send a text, flush and close dialog
	  *
	  * @var string $text : the text to send
	  * @access public
	  */
	function sendAndClose($text)
	{
		CMS_LoadingDialog::sendToUser($text);
		CMS_LoadingDialog::closeDialog();
	}
	
	/**
	  * Close dialog
	  *
	  * @access public
	  */
	static function closeDialog()
	{
		echo '</div></body></html>';
		exit;
	}
}
?>