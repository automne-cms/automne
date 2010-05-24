<?php //Generated on Mon, 24 May 2010 17:00:00 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-27-modules.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Modules</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Modules</h1>
<h3>

		&raquo;&nbsp;Fonctionnalités
		
		&raquo;&nbsp;Modules
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>Il est possible d'ajouter au noyau logiciel un ensemble de modules pour ajouter des fonctionnalit&eacute;s propres aux besoins de chaque site.</p><p>Par d&eacute;faut Automne 4 contient les modules les plus courants : <strong>M&eacute;diath&egrave;que, Gestion des Actualit&eacute;s, Cr&eacute;ation de formulaires, Cr&eacute;ation d'Alias de pages. </strong></p><h3>Il vous est cependant possible d'ajouter autant de modules suppl&eacute;mentaires que vous le souhaitez !</h3> <h2>G&eacute;n&eacute;rateur de modules&nbsp; POLYMOD</h2></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_4c4911906536fec981521756952ac735 = new CMS_cache('4c4911906536fec981521756952ac735', 'polymod', 'auto', true);
if ($cache_4c4911906536fec981521756952ac735->exist()):
	//Get content from cache
	$cache_4c4911906536fec981521756952ac735_content = $cache_4c4911906536fec981521756952ac735->load();
else:
	$cache_4c4911906536fec981521756952ac735->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:00 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '26',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '27';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//SEARCH mediaresult TAG START 16_cc3c46
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_16_cc3c46 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_cc3c46);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_17_e41c5d = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_17_e41c5d['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_e41c5d['type'] == 'publication date after' || $values_17_e41c5d['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_17_e41c5d['value']);
			$values_17_e41c5d['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_e41c5d)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 18_a4aa49
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
		$object_18_a4aa49 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_a4aa49 = $replace; //save previous replace vars if any
		$count_18_a4aa49 = 0;
		$content_18_a4aa49 = $content; //save previous content var if any
		$maxPages_18_a4aa49 = $search_mediaresult->getMaxPages();
		$maxResults_18_a4aa49 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_18_a4aa49) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_a4aa49 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_a4aa49+1),
				"{maxpages}"    => $maxPages_18_a4aa49,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_18_a4aa49,
				"{altclass}"    => (($count_18_a4aa49+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 19_b00035
			$ifcondition_19_b00035 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_19_b00035) {
				$func_19_b00035 = create_function("","return (".$ifcondition_19_b00035.");");
				if ($func_19_b00035()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 20_86d7d8
					$ifcondition_20_86d7d8 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_20_86d7d8) {
						$func_20_86d7d8 = create_function("","return (".$ifcondition_20_86d7d8.");");
						if ($func_20_86d7d8()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_20_86d7d8);
					}
					unset($ifcondition_20_86d7d8);
					//IF TAG END 20_86d7d8
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 21_d33c86
					$ifcondition_21_d33c86 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_21_d33c86) {
						$func_21_d33c86 = create_function("","return (".$ifcondition_21_d33c86.");");
						if ($func_21_d33c86()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_21_d33c86);
					}
					unset($ifcondition_21_d33c86);
					//IF TAG END 21_d33c86
				}
				unset($func_19_b00035);
			}
			unset($ifcondition_19_b00035);
			//IF TAG END 19_b00035
			//IF TAG START 22_942f14
			$ifcondition_22_942f14 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_22_942f14) {
				$func_22_942f14 = create_function("","return (".$ifcondition_22_942f14.");");
				if ($func_22_942f14()) {
					//IF TAG START 23_710902
					$ifcondition_23_710902 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_23_710902) {
						$func_23_710902 = create_function("","return (".$ifcondition_23_710902.");");
						if ($func_23_710902()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_23_710902);
					}
					unset($ifcondition_23_710902);
					//IF TAG END 23_710902
					//IF TAG START 24_4fecce
					$ifcondition_24_4fecce = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_24_4fecce) {
						$func_24_4fecce = create_function("","return (".$ifcondition_24_4fecce.");");
						if ($func_24_4fecce()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_24_4fecce);
					}
					unset($ifcondition_24_4fecce);
					//IF TAG END 24_4fecce
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_22_942f14);
			}
			unset($ifcondition_22_942f14);
			//IF TAG END 22_942f14
			//IF TAG START 25_8e14c0
			$ifcondition_25_8e14c0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_25_8e14c0) {
				$func_25_8e14c0 = create_function("","return (".$ifcondition_25_8e14c0.");");
				if ($func_25_8e14c0()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 26_1fa049
					$ifcondition_26_1fa049 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_26_1fa049) {
						$func_26_1fa049 = create_function("","return (".$ifcondition_26_1fa049.");");
						if ($func_26_1fa049()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_26_1fa049);
					}
					unset($ifcondition_26_1fa049);
					//IF TAG END 26_1fa049
				}
				unset($func_25_8e14c0);
			}
			unset($ifcondition_25_8e14c0);
			//IF TAG END 25_8e14c0
			//IF TAG START 27_68fafa
			$ifcondition_27_68fafa = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_27_68fafa) {
				$func_27_68fafa = create_function("","return (".$ifcondition_27_68fafa.");");
				if ($func_27_68fafa()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 28_40f4f1
					$ifcondition_28_40f4f1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_28_40f4f1) {
						$func_28_40f4f1 = create_function("","return (".$ifcondition_28_40f4f1.");");
						if ($func_28_40f4f1()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_28_40f4f1);
					}
					unset($ifcondition_28_40f4f1);
					//IF TAG END 28_40f4f1
					//IF TAG START 29_f07ae2
					$ifcondition_29_f07ae2 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_29_f07ae2) {
						$func_29_f07ae2 = create_function("","return (".$ifcondition_29_f07ae2.");");
						if ($func_29_f07ae2()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_29_f07ae2);
					}
					unset($ifcondition_29_f07ae2);
					//IF TAG END 29_f07ae2
					$content .="
					</div>
					";
				}
				unset($func_27_68fafa);
			}
			unset($ifcondition_27_68fafa);
			//IF TAG END 27_68fafa
			$count_18_a4aa49++;
			//do all result vars replacement
			$content_18_a4aa49.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_18_a4aa49; //retrieve previous content var if any
		unset($content_18_a4aa49);
		$replace = $replace_18_a4aa49; //retrieve previous replace vars if any
		unset($replace_18_a4aa49);
		$object[$objectDefinition_mediaresult] = $object_18_a4aa49; //retrieve previous object search if any
		unset($object_18_a4aa49);
	}
	//RESULT mediaresult TAG END 18_a4aa49
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 16_cc3c46
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
	<?php $cache_4c4911906536fec981521756952ac735_content = $cache_4c4911906536fec981521756952ac735->endSave();
endif;
unset($cache_4c4911906536fec981521756952ac735);
echo $cache_4c4911906536fec981521756952ac735_content;
unset($cache_4c4911906536fec981521756952ac735_content);
   ?>

	</div>
	
		<div class="text"><p>Une des particularit&eacute;s d&rsquo;Automne est le<strong> g&eacute;n&eacute;rateur de module appel&eacute; POLYMOD. </strong></p><p>Il permet de g&eacute;rer des &eacute;l&eacute;ments contenant des donn&eacute;es de types textes, fichiers, images &hellip; Ces donn&eacute;es sont organis&eacute;es entre elles tel que vous le souhaitez et cela sans qu&rsquo;aucune comp&eacute;tence technique ne soit requise.</p><p>Exemple :&nbsp; les modules Actualit&eacute;s et M&eacute;diath&egrave;que fourni dans cette d&eacute;monstration sont enti&egrave;rement <strong>cr&eacute;&eacute;s &agrave; partir de l'interface d'administration</strong> d'Automne 4. Ils peuvent &ecirc;tre modifi&eacute;s pour &ecirc;tre ajust&eacute;s &agrave; ce que vous souhaitez sans aucune difficult&eacute;.</p><p>Le polymod permet aussi de <strong>cr&eacute;er simplement</strong> des flux RSS, des moteurs de recherche c&ocirc;t&eacute; client&hellip;</p><p>Exemple : module de gestion de produits, actualit&eacute;s, m&eacute;diath&egrave;que, annuaire, &hellip;</p> <h3>Il est possible de cr&eacute;er ses propres modules pour r&eacute;aliser des op&eacute;rations bien sp&eacute;cifiques.</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h2>Modules sp&eacute;cifiques</h2> <h3>Automne 4 permet aussi de g&eacute;rer des modules sp&eacute;cifiques que le Polymod ne saurai traiter.</h3><p>Ces modules, cr&eacute;&eacute;s en PHP peuvent alors <strong>r&eacute;aliser tout type d'op&eacute;ration m&eacute;tier complexe </strong>en s'int&eacute;grant parfaitement &agrave; l'interface d'Automne 4. </p><p>Vous pouvez ainsi lier Automne &agrave; vos bases de donn&eacute;es m&eacute;tier ou encore cr&eacute;er des modules de mailing, d'e-commerce, interroger des web services distant et ajouter bien d'autres fonctionnalit&eacute;s encore ...</p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Modules" (http://127.0.0.1/web/demo/27-modules.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>