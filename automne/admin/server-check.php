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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: server-check.php,v 1.1 2008/11/27 17:27:48 sebastien Exp $

/**
  * PHP controler : Receive actions on server
  * Used accross an Ajax request to process one server action
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//Controler vars
$action = sensitiveIO::request('action', array('check-files', 'check-htaccess'));

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) { //templates
	CMS_grandFather::raiseError('User has no administration rights');
	$view->setActionMessage('Vous n\'avez pas les droits d\'administrateur ...');
	$view->show();
}

$cms_message = '';
$content = '';

switch ($action) {
	case 'check-files':
		set_time_limit(600);
		$path = realpath($_SERVER['DOCUMENT_ROOT']);
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
		$countFile = 0;
		$countDir = 0;
		$countSize = 0;
		$countError = 0;
		$content = '';
		foreach($objects as $name => $object){
		    if (!$object->isWritable()) {
				$countError++;
				if ($countError < 1000) {
					$content .= '<li class="atm-pic-cancel">'.$name.'</li>';
				} elseif ($countError == 1000) {
					$content .= '<li class="atm-pic-cancel"> ... Il y a plus de 1000 fichiers inaccessible en écriture ...</li>';
				}
			}
			if ($object->isFile()) {
				$countFile++;
			} else {
				$countDir++;
			}
			$countSize += $object->getSize();
		}
		if ($content) {
			$cms_message = 'Erreur lors de la vérification ...';
			$content = '<span class="atm-red">Erreur : les fichiers et dossiers suivants ne sont pas accessibles en écriture :</span><ul class="atm-server">'.$content.'</ul>';
		} else {
			$cms_message = 'Vérification terminée !';
		}
		$filesize = ($countSize < 1073741824) ? round(($countSize/1048576),2).' M' : round(($countSize/1073741824),2).' G';
		$content = 'Nombre de dossiers : <strong>'.$countDir.'</strong><br />
		Nombre de Fichiers : <strong>'.$countFile.'</strong><br />
		Espace disque employé : <strong>'.$filesize.'</strong><br /><br />'.$content;
	break;
	case 'check-htaccess':
		$automnePatch = new CMS_patch($cms_user);
		if ($automnePatch->automneGeneralScript()) {
			$cms_message = 'Vérification terminée !';
		} else {
			$cms_message = 'Erreur lors de la vérification ...';
		}
		$return = $automnePatch->getReturn();
		$content = '<ul class="atm-server">';
		foreach ($return as $line) {
			switch($line['type']) {
				case 'verbose':
					$content .= '<li>'.$line['text'].'</li>';
				break;
				case 'report':
					switch ($line['error']) {
						case 0:
							$content .= '<li class="atm-pic-ok">'.$line['text'].'</li>';
						break;
						case 1:
							$content .= '<li class="atm-pic-cancel">'.$line['text'].'</li>';
						break;
					}
				break;
			}
		}
		$content .= '</ul>';
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
if ($content) {
	$view->setContent($content);
}
$view->show();
?>