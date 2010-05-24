<?php //Generated on Mon, 24 May 2010 17:00:01 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-28-administration.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Gestion des utilisateurs</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Gestion des utilisateurs</h1>
<h3>

		&raquo;&nbsp;Fonctionnalités
		
		&raquo;&nbsp;Gestion des utilisateurs
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><h2>Principe de gestion d'utilisateur</h2><p>Lors de la cr&eacute;ation d&rsquo;un site avec Automne 4, un utilisateur privil&eacute;gi&eacute; dit <a href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">&laquo; Super Administrateur &raquo;</a> poss&egrave;de <strong>tous les droits sur l&rsquo;application.</strong></p> <p>Ce super administrateur a alors la possibilit&eacute; de cr&eacute;er des utilisateurs ainsi que des groupes d&rsquo;utilisateurs. Chacun dispose de droits sur certaines fonctionnalit&eacute;s de l&rsquo;application. Les groupes par d&eacute;faut sont : administrateur, validateur et r&eacute;dacteur.&nbsp;</p><p>Les r&eacute;dacteurs n'auront alors &agrave; leurs disposition que les outils qui leurs sont n&eacute;cessaires. Leurs interventions seront ainsi limit&eacute;s &agrave; leurs besoins.</p><p>Il est aussi possible, gr&acirc;ce au <a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">processus de workflow</a> de soumettre les donn&eacute;es saisies &agrave; la validation d'une autorit&eacute; sup&eacute;rieure. Ainsi le contenu pourra &ecirc;tre v&eacute;rifi&eacute; avant sa mise en ligne.</p></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_c7ef610e5c65575fb977756dd2bdeefd = new CMS_cache('c7ef610e5c65575fb977756dd2bdeefd', 'polymod', 'auto', true);
if ($cache_c7ef610e5c65575fb977756dd2bdeefd->exist()):
	//Get content from cache
	$cache_c7ef610e5c65575fb977756dd2bdeefd_content = $cache_c7ef610e5c65575fb977756dd2bdeefd->load();
else:
	$cache_c7ef610e5c65575fb977756dd2bdeefd->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:01 +0200 by Automne (TM) 4.0.2 */
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pmedia', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
	$atmIfResults = array();
	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
	$blockAttributes = array (
		'search' =>
		array (
			'mediaresult' =>
			array (
				'item' => '27',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '28';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//SEARCH mediaresult TAG START 16_f39ddd
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_16_f39ddd = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_f39ddd);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_17_70e043 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_17_70e043['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_70e043['type'] == 'publication date after' || $values_17_70e043['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_17_70e043['value']);
			$values_17_70e043['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_70e043)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 18_8d3e24
	//launch search mediaresult if not already done
	if($launchSearch_mediaresult && !isset($results_mediaresult)) {
		if (isset($search_mediaresult)) {
			$results_mediaresult = $search_mediaresult->search();
		} else {
			CMS_grandFather::raiseError("Malformed atm-result tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
			$results_mediaresult = array();
		}
	} elseif (!$launchSearch_mediaresult) {
		$results_mediaresult = array();
	}
	if ($results_mediaresult) {
		$object_18_8d3e24 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_8d3e24 = $replace; //save previous replace vars if any
		$count_18_8d3e24 = 0;
		$content_18_8d3e24 = $content; //save previous content var if any
		$maxPages_18_8d3e24 = $search_mediaresult->getMaxPages();
		$maxResults_18_8d3e24 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_18_8d3e24) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_8d3e24 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_8d3e24+1),
				"{maxpages}"    => $maxPages_18_8d3e24,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_18_8d3e24,
				"{altclass}"    => (($count_18_8d3e24+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 19_83f91e
			$ifcondition_19_83f91e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_19_83f91e) {
				$func_19_83f91e = create_function("","return (".$ifcondition_19_83f91e.");");
				if ($func_19_83f91e()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 20_67f45b
					$ifcondition_20_67f45b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_20_67f45b) {
						$func_20_67f45b = create_function("","return (".$ifcondition_20_67f45b.");");
						if ($func_20_67f45b()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_20_67f45b);
					}
					unset($ifcondition_20_67f45b);
					//IF TAG END 20_67f45b
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 21_555e66
					$ifcondition_21_555e66 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_21_555e66) {
						$func_21_555e66 = create_function("","return (".$ifcondition_21_555e66.");");
						if ($func_21_555e66()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_21_555e66);
					}
					unset($ifcondition_21_555e66);
					//IF TAG END 21_555e66
				}
				unset($func_19_83f91e);
			}
			unset($ifcondition_19_83f91e);
			//IF TAG END 19_83f91e
			//IF TAG START 22_a28f8c
			$ifcondition_22_a28f8c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_22_a28f8c) {
				$func_22_a28f8c = create_function("","return (".$ifcondition_22_a28f8c.");");
				if ($func_22_a28f8c()) {
					//IF TAG START 23_7d33ed
					$ifcondition_23_7d33ed = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_23_7d33ed) {
						$func_23_7d33ed = create_function("","return (".$ifcondition_23_7d33ed.");");
						if ($func_23_7d33ed()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_23_7d33ed);
					}
					unset($ifcondition_23_7d33ed);
					//IF TAG END 23_7d33ed
					//IF TAG START 24_80736b
					$ifcondition_24_80736b = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_24_80736b) {
						$func_24_80736b = create_function("","return (".$ifcondition_24_80736b.");");
						if ($func_24_80736b()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_24_80736b);
					}
					unset($ifcondition_24_80736b);
					//IF TAG END 24_80736b
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_22_a28f8c);
			}
			unset($ifcondition_22_a28f8c);
			//IF TAG END 22_a28f8c
			//IF TAG START 25_0fcf5b
			$ifcondition_25_0fcf5b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_25_0fcf5b) {
				$func_25_0fcf5b = create_function("","return (".$ifcondition_25_0fcf5b.");");
				if ($func_25_0fcf5b()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 26_c6384b
					$ifcondition_26_c6384b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_26_c6384b) {
						$func_26_c6384b = create_function("","return (".$ifcondition_26_c6384b.");");
						if ($func_26_c6384b()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_26_c6384b);
					}
					unset($ifcondition_26_c6384b);
					//IF TAG END 26_c6384b
				}
				unset($func_25_0fcf5b);
			}
			unset($ifcondition_25_0fcf5b);
			//IF TAG END 25_0fcf5b
			//IF TAG START 27_5ac91b
			$ifcondition_27_5ac91b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_27_5ac91b) {
				$func_27_5ac91b = create_function("","return (".$ifcondition_27_5ac91b.");");
				if ($func_27_5ac91b()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 28_20994c
					$ifcondition_28_20994c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_28_20994c) {
						$func_28_20994c = create_function("","return (".$ifcondition_28_20994c.");");
						if ($func_28_20994c()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_28_20994c);
					}
					unset($ifcondition_28_20994c);
					//IF TAG END 28_20994c
					//IF TAG START 29_457e64
					$ifcondition_29_457e64 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_29_457e64) {
						$func_29_457e64 = create_function("","return (".$ifcondition_29_457e64.");");
						if ($func_29_457e64()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_29_457e64);
					}
					unset($ifcondition_29_457e64);
					//IF TAG END 29_457e64
					$content .="
					</div>
					";
				}
				unset($func_27_5ac91b);
			}
			unset($ifcondition_27_5ac91b);
			//IF TAG END 27_5ac91b
			$count_18_8d3e24++;
			//do all result vars replacement
			$content_18_8d3e24.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_18_8d3e24; //retrieve previous content var if any
		unset($content_18_8d3e24);
		$replace = $replace_18_8d3e24; //retrieve previous replace vars if any
		unset($replace_18_8d3e24);
		$object[$objectDefinition_mediaresult] = $object_18_8d3e24; //retrieve previous object search if any
		unset($object_18_8d3e24);
	}
	//RESULT mediaresult TAG END 18_8d3e24
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 16_f39ddd
	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);
	$content .= '<!--{elements:'.base64_encode(serialize(array (
		'module' =>
		array (
			0 => 'pmedia',
		),
	))).'}-->';
	echo $content;
	unset($content);}
	   ?>
	<?php $cache_c7ef610e5c65575fb977756dd2bdeefd_content = $cache_c7ef610e5c65575fb977756dd2bdeefd->endSave();
endif;
unset($cache_c7ef610e5c65575fb977756dd2bdeefd);
echo $cache_c7ef610e5c65575fb977756dd2bdeefd_content;
unset($cache_c7ef610e5c65575fb977756dd2bdeefd_content);
   ?>

	</div>
	
		<div class="text"><h3>Les utilisateurs peuvent cr&eacute;er d'autres utilisateurs ou groupes d'utilisateurs si et seulement si ils en ont les droits.</h3> <h3>Les utilisateurs appartenant &agrave; un groupe disposent des droits attribu&eacute;s au groupe.</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Gestion des utilisateurs" (http://127.0.0.1/web/demo/28-administration.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>