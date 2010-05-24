<?php //Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-3-presentation.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Présentation</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Présentation</h1>
<h3>

		&raquo;&nbsp;Présentation
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Bienvenue sur AUTOMNE 4 </h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_96a6c46934465a34453284178ef3a435 = new CMS_cache('96a6c46934465a34453284178ef3a435', 'polymod', 'auto', true);
if ($cache_96a6c46934465a34453284178ef3a435->exist()):
	//Get content from cache
	$cache_96a6c46934465a34453284178ef3a435_content = $cache_96a6c46934465a34453284178ef3a435->load();
else:
	$cache_96a6c46934465a34453284178ef3a435->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '35',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '3';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//SEARCH mediaresult TAG START 44_30afec
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_44_30afec = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_30afec);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_45_e914b9 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_45_e914b9['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_e914b9['type'] == 'publication date after' || $values_45_e914b9['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_45_e914b9['value']);
			$values_45_e914b9['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_e914b9)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 46_f91bae
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
		$object_46_f91bae = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_f91bae = $replace; //save previous replace vars if any
		$count_46_f91bae = 0;
		$content_46_f91bae = $content; //save previous content var if any
		$maxPages_46_f91bae = $search_mediaresult->getMaxPages();
		$maxResults_46_f91bae = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_46_f91bae) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_f91bae == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_f91bae+1),
				"{maxpages}"    => $maxPages_46_f91bae,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_46_f91bae,
				"{altclass}"    => (($count_46_f91bae+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 47_3f24c1
			$ifcondition_47_3f24c1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_47_3f24c1) {
				$func_47_3f24c1 = create_function("","return (".$ifcondition_47_3f24c1.");");
				if ($func_47_3f24c1()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 48_c6a84e
					$ifcondition_48_c6a84e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_48_c6a84e) {
						$func_48_c6a84e = create_function("","return (".$ifcondition_48_c6a84e.");");
						if ($func_48_c6a84e()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_48_c6a84e);
					}
					unset($ifcondition_48_c6a84e);
					//IF TAG END 48_c6a84e
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 49_5f3021
					$ifcondition_49_5f3021 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_49_5f3021) {
						$func_49_5f3021 = create_function("","return (".$ifcondition_49_5f3021.");");
						if ($func_49_5f3021()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_49_5f3021);
					}
					unset($ifcondition_49_5f3021);
					//IF TAG END 49_5f3021
				}
				unset($func_47_3f24c1);
			}
			unset($ifcondition_47_3f24c1);
			//IF TAG END 47_3f24c1
			//IF TAG START 50_d498d4
			$ifcondition_50_d498d4 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_50_d498d4) {
				$func_50_d498d4 = create_function("","return (".$ifcondition_50_d498d4.");");
				if ($func_50_d498d4()) {
					//IF TAG START 51_9c208f
					$ifcondition_51_9c208f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_51_9c208f) {
						$func_51_9c208f = create_function("","return (".$ifcondition_51_9c208f.");");
						if ($func_51_9c208f()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_51_9c208f);
					}
					unset($ifcondition_51_9c208f);
					//IF TAG END 51_9c208f
					//IF TAG START 52_27be27
					$ifcondition_52_27be27 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_52_27be27) {
						$func_52_27be27 = create_function("","return (".$ifcondition_52_27be27.");");
						if ($func_52_27be27()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_52_27be27);
					}
					unset($ifcondition_52_27be27);
					//IF TAG END 52_27be27
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_50_d498d4);
			}
			unset($ifcondition_50_d498d4);
			//IF TAG END 50_d498d4
			//IF TAG START 53_01c479
			$ifcondition_53_01c479 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_53_01c479) {
				$func_53_01c479 = create_function("","return (".$ifcondition_53_01c479.");");
				if ($func_53_01c479()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 54_9a3c89
					$ifcondition_54_9a3c89 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_54_9a3c89) {
						$func_54_9a3c89 = create_function("","return (".$ifcondition_54_9a3c89.");");
						if ($func_54_9a3c89()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_54_9a3c89);
					}
					unset($ifcondition_54_9a3c89);
					//IF TAG END 54_9a3c89
				}
				unset($func_53_01c479);
			}
			unset($ifcondition_53_01c479);
			//IF TAG END 53_01c479
			//IF TAG START 55_b63d8f
			$ifcondition_55_b63d8f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_55_b63d8f) {
				$func_55_b63d8f = create_function("","return (".$ifcondition_55_b63d8f.");");
				if ($func_55_b63d8f()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 56_c297de
					$ifcondition_56_c297de = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_56_c297de) {
						$func_56_c297de = create_function("","return (".$ifcondition_56_c297de.");");
						if ($func_56_c297de()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_56_c297de);
					}
					unset($ifcondition_56_c297de);
					//IF TAG END 56_c297de
					//IF TAG START 57_2f3a7e
					$ifcondition_57_2f3a7e = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_57_2f3a7e) {
						$func_57_2f3a7e = create_function("","return (".$ifcondition_57_2f3a7e.");");
						if ($func_57_2f3a7e()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_57_2f3a7e);
					}
					unset($ifcondition_57_2f3a7e);
					//IF TAG END 57_2f3a7e
					$content .="
					</div>
					";
				}
				unset($func_55_b63d8f);
			}
			unset($ifcondition_55_b63d8f);
			//IF TAG END 55_b63d8f
			$count_46_f91bae++;
			//do all result vars replacement
			$content_46_f91bae.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_46_f91bae; //retrieve previous content var if any
		unset($content_46_f91bae);
		$replace = $replace_46_f91bae; //retrieve previous replace vars if any
		unset($replace_46_f91bae);
		$object[$objectDefinition_mediaresult] = $object_46_f91bae; //retrieve previous object search if any
		unset($object_46_f91bae);
	}
	//RESULT mediaresult TAG END 46_f91bae
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 44_30afec
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
	<?php $cache_96a6c46934465a34453284178ef3a435_content = $cache_96a6c46934465a34453284178ef3a435->endSave();
endif;
unset($cache_96a6c46934465a34453284178ef3a435);
echo $cache_96a6c46934465a34453284178ef3a435_content;
unset($cache_96a6c46934465a34453284178ef3a435_content);
   ?>

	</div>
	
		<div class="text"><h3>Bienvenue sur le site de d&eacute;monstration de la <strong>nouvelle version d&rsquo;Automne 4.</strong></h3><p>Vous trouverez ici <strong>toutes les informations</strong> n&eacute;cessaires &agrave; la d&eacute;couverte de cette version ainsi que les <strong>notions essentielles</strong> pour bien appr&eacute;hender l&rsquo;outil.</p><p>&nbsp;</p></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>&nbsp;</p> <h2>Vos droits sur ce site</h2></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h3>Que pouvez-vous faire ?</h3> <p>Vous disposez d&rsquo;un compte utilisateur <strong>&laquo; R&eacute;dacteur &raquo;</strong> qui vous permet d&rsquo;avoir acc&egrave;s &agrave; l&rsquo;interface d'administration d&rsquo;Automne 4 et donc d&rsquo;op&eacute;rer certaines modifications. <strong><br /> </strong></p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_7545d3c9c0af717c5b7dfb772cdc503e = new CMS_cache('7545d3c9c0af717c5b7dfb772cdc503e', 'polymod', 'auto', true);
if ($cache_7545d3c9c0af717c5b7dfb772cdc503e->exist()):
	//Get content from cache
	$cache_7545d3c9c0af717c5b7dfb772cdc503e_content = $cache_7545d3c9c0af717c5b7dfb772cdc503e->load();
else:
	$cache_7545d3c9c0af717c5b7dfb772cdc503e->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '36',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '3';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//SEARCH mediaresult TAG START 58_2de81c
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_58_2de81c = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_2de81c);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_59_3d0d28 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_59_3d0d28['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_3d0d28['type'] == 'publication date after' || $values_59_3d0d28['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_59_3d0d28['value']);
			$values_59_3d0d28['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_3d0d28)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 60_8fb646
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
		$object_60_8fb646 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_8fb646 = $replace; //save previous replace vars if any
		$count_60_8fb646 = 0;
		$content_60_8fb646 = $content; //save previous content var if any
		$maxPages_60_8fb646 = $search_mediaresult->getMaxPages();
		$maxResults_60_8fb646 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_60_8fb646) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_8fb646 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_8fb646+1),
				"{maxpages}"    => $maxPages_60_8fb646,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_60_8fb646,
				"{altclass}"    => (($count_60_8fb646+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 61_07e85b
			$ifcondition_61_07e85b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_61_07e85b) {
				$func_61_07e85b = create_function("","return (".$ifcondition_61_07e85b.");");
				if ($func_61_07e85b()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 62_e86a64
					$ifcondition_62_e86a64 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_62_e86a64) {
						$func_62_e86a64 = create_function("","return (".$ifcondition_62_e86a64.");");
						if ($func_62_e86a64()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_62_e86a64);
					}
					unset($ifcondition_62_e86a64);
					//IF TAG END 62_e86a64
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 63_e5ee9b
					$ifcondition_63_e5ee9b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_63_e5ee9b) {
						$func_63_e5ee9b = create_function("","return (".$ifcondition_63_e5ee9b.");");
						if ($func_63_e5ee9b()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_63_e5ee9b);
					}
					unset($ifcondition_63_e5ee9b);
					//IF TAG END 63_e5ee9b
				}
				unset($func_61_07e85b);
			}
			unset($ifcondition_61_07e85b);
			//IF TAG END 61_07e85b
			//IF TAG START 64_ecc1a3
			$ifcondition_64_ecc1a3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_64_ecc1a3) {
				$func_64_ecc1a3 = create_function("","return (".$ifcondition_64_ecc1a3.");");
				if ($func_64_ecc1a3()) {
					//IF TAG START 65_d8eeb0
					$ifcondition_65_d8eeb0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_65_d8eeb0) {
						$func_65_d8eeb0 = create_function("","return (".$ifcondition_65_d8eeb0.");");
						if ($func_65_d8eeb0()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_65_d8eeb0);
					}
					unset($ifcondition_65_d8eeb0);
					//IF TAG END 65_d8eeb0
					//IF TAG START 66_e92f26
					$ifcondition_66_e92f26 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_66_e92f26) {
						$func_66_e92f26 = create_function("","return (".$ifcondition_66_e92f26.");");
						if ($func_66_e92f26()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_66_e92f26);
					}
					unset($ifcondition_66_e92f26);
					//IF TAG END 66_e92f26
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_64_ecc1a3);
			}
			unset($ifcondition_64_ecc1a3);
			//IF TAG END 64_ecc1a3
			//IF TAG START 67_c9ff50
			$ifcondition_67_c9ff50 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_67_c9ff50) {
				$func_67_c9ff50 = create_function("","return (".$ifcondition_67_c9ff50.");");
				if ($func_67_c9ff50()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 68_9a7237
					$ifcondition_68_9a7237 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_68_9a7237) {
						$func_68_9a7237 = create_function("","return (".$ifcondition_68_9a7237.");");
						if ($func_68_9a7237()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_68_9a7237);
					}
					unset($ifcondition_68_9a7237);
					//IF TAG END 68_9a7237
				}
				unset($func_67_c9ff50);
			}
			unset($ifcondition_67_c9ff50);
			//IF TAG END 67_c9ff50
			//IF TAG START 69_89b64b
			$ifcondition_69_89b64b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_69_89b64b) {
				$func_69_89b64b = create_function("","return (".$ifcondition_69_89b64b.");");
				if ($func_69_89b64b()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 70_9821e0
					$ifcondition_70_9821e0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_70_9821e0) {
						$func_70_9821e0 = create_function("","return (".$ifcondition_70_9821e0.");");
						if ($func_70_9821e0()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_70_9821e0);
					}
					unset($ifcondition_70_9821e0);
					//IF TAG END 70_9821e0
					//IF TAG START 71_c225e9
					$ifcondition_71_c225e9 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_71_c225e9) {
						$func_71_c225e9 = create_function("","return (".$ifcondition_71_c225e9.");");
						if ($func_71_c225e9()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_71_c225e9);
					}
					unset($ifcondition_71_c225e9);
					//IF TAG END 71_c225e9
					$content .="
					</div>
					";
				}
				unset($func_69_89b64b);
			}
			unset($ifcondition_69_89b64b);
			//IF TAG END 69_89b64b
			$count_60_8fb646++;
			//do all result vars replacement
			$content_60_8fb646.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_60_8fb646; //retrieve previous content var if any
		unset($content_60_8fb646);
		$replace = $replace_60_8fb646; //retrieve previous replace vars if any
		unset($replace_60_8fb646);
		$object[$objectDefinition_mediaresult] = $object_60_8fb646; //retrieve previous object search if any
		unset($object_60_8fb646);
	}
	//RESULT mediaresult TAG END 60_8fb646
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 58_2de81c
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
	<?php $cache_7545d3c9c0af717c5b7dfb772cdc503e_content = $cache_7545d3c9c0af717c5b7dfb772cdc503e->endSave();
endif;
unset($cache_7545d3c9c0af717c5b7dfb772cdc503e);
echo $cache_7545d3c9c0af717c5b7dfb772cdc503e_content;
unset($cache_7545d3c9c0af717c5b7dfb772cdc503e_content);
   ?>

	</div>
	
		<div class="text"><ul><li>modifier, cr&eacute;er et copier des pages.</li><li>g&eacute;rer votre compte utilisateur.</li><li>g&eacute;rer des &eacute;l&eacute;ments des modules.</li><li>&hellip;</li></ul></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_cdda59b5c32ac656d628f9b4253eafc8 = new CMS_cache('cdda59b5c32ac656d628f9b4253eafc8', 'polymod', 'auto', true);
if ($cache_cdda59b5c32ac656d628f9b4253eafc8->exist()):
	//Get content from cache
	$cache_cdda59b5c32ac656d628f9b4253eafc8_content = $cache_cdda59b5c32ac656d628f9b4253eafc8->load();
else:
	$cache_cdda59b5c32ac656d628f9b4253eafc8->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '40',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '3';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//SEARCH mediaresult TAG START 72_85ddff
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_72_85ddff = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_85ddff);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_73_7eebc2 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_73_7eebc2['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_7eebc2['type'] == 'publication date after' || $values_73_7eebc2['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_73_7eebc2['value']);
			$values_73_7eebc2['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_7eebc2)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 74_f21a3a
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
		$object_74_f21a3a = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_f21a3a = $replace; //save previous replace vars if any
		$count_74_f21a3a = 0;
		$content_74_f21a3a = $content; //save previous content var if any
		$maxPages_74_f21a3a = $search_mediaresult->getMaxPages();
		$maxResults_74_f21a3a = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_74_f21a3a) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_f21a3a == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_f21a3a+1),
				"{maxpages}"    => $maxPages_74_f21a3a,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_74_f21a3a,
				"{altclass}"    => (($count_74_f21a3a+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 75_e04e41
			$ifcondition_75_e04e41 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_75_e04e41) {
				$func_75_e04e41 = create_function("","return (".$ifcondition_75_e04e41.");");
				if ($func_75_e04e41()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 76_a0e9fd
					$ifcondition_76_a0e9fd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_76_a0e9fd) {
						$func_76_a0e9fd = create_function("","return (".$ifcondition_76_a0e9fd.");");
						if ($func_76_a0e9fd()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_76_a0e9fd);
					}
					unset($ifcondition_76_a0e9fd);
					//IF TAG END 76_a0e9fd
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 77_7f0aa3
					$ifcondition_77_7f0aa3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_77_7f0aa3) {
						$func_77_7f0aa3 = create_function("","return (".$ifcondition_77_7f0aa3.");");
						if ($func_77_7f0aa3()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_77_7f0aa3);
					}
					unset($ifcondition_77_7f0aa3);
					//IF TAG END 77_7f0aa3
				}
				unset($func_75_e04e41);
			}
			unset($ifcondition_75_e04e41);
			//IF TAG END 75_e04e41
			//IF TAG START 78_a45108
			$ifcondition_78_a45108 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_78_a45108) {
				$func_78_a45108 = create_function("","return (".$ifcondition_78_a45108.");");
				if ($func_78_a45108()) {
					//IF TAG START 79_298ae5
					$ifcondition_79_298ae5 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_79_298ae5) {
						$func_79_298ae5 = create_function("","return (".$ifcondition_79_298ae5.");");
						if ($func_79_298ae5()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_79_298ae5);
					}
					unset($ifcondition_79_298ae5);
					//IF TAG END 79_298ae5
					//IF TAG START 80_14ea94
					$ifcondition_80_14ea94 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_80_14ea94) {
						$func_80_14ea94 = create_function("","return (".$ifcondition_80_14ea94.");");
						if ($func_80_14ea94()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_80_14ea94);
					}
					unset($ifcondition_80_14ea94);
					//IF TAG END 80_14ea94
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_78_a45108);
			}
			unset($ifcondition_78_a45108);
			//IF TAG END 78_a45108
			//IF TAG START 81_c5cf9a
			$ifcondition_81_c5cf9a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_81_c5cf9a) {
				$func_81_c5cf9a = create_function("","return (".$ifcondition_81_c5cf9a.");");
				if ($func_81_c5cf9a()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 82_655080
					$ifcondition_82_655080 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_82_655080) {
						$func_82_655080 = create_function("","return (".$ifcondition_82_655080.");");
						if ($func_82_655080()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_82_655080);
					}
					unset($ifcondition_82_655080);
					//IF TAG END 82_655080
				}
				unset($func_81_c5cf9a);
			}
			unset($ifcondition_81_c5cf9a);
			//IF TAG END 81_c5cf9a
			//IF TAG START 83_d873bf
			$ifcondition_83_d873bf = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_83_d873bf) {
				$func_83_d873bf = create_function("","return (".$ifcondition_83_d873bf.");");
				if ($func_83_d873bf()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 84_c746e9
					$ifcondition_84_c746e9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_84_c746e9) {
						$func_84_c746e9 = create_function("","return (".$ifcondition_84_c746e9.");");
						if ($func_84_c746e9()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_84_c746e9);
					}
					unset($ifcondition_84_c746e9);
					//IF TAG END 84_c746e9
					//IF TAG START 85_44aa8c
					$ifcondition_85_44aa8c = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_85_44aa8c) {
						$func_85_44aa8c = create_function("","return (".$ifcondition_85_44aa8c.");");
						if ($func_85_44aa8c()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_85_44aa8c);
					}
					unset($ifcondition_85_44aa8c);
					//IF TAG END 85_44aa8c
					$content .="
					</div>
					";
				}
				unset($func_83_d873bf);
			}
			unset($ifcondition_83_d873bf);
			//IF TAG END 83_d873bf
			$count_74_f21a3a++;
			//do all result vars replacement
			$content_74_f21a3a.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_74_f21a3a; //retrieve previous content var if any
		unset($content_74_f21a3a);
		$replace = $replace_74_f21a3a; //retrieve previous replace vars if any
		unset($replace_74_f21a3a);
		$object[$objectDefinition_mediaresult] = $object_74_f21a3a; //retrieve previous object search if any
		unset($object_74_f21a3a);
	}
	//RESULT mediaresult TAG END 74_f21a3a
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 72_85ddff
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
	<?php $cache_cdda59b5c32ac656d628f9b4253eafc8_content = $cache_cdda59b5c32ac656d628f9b4253eafc8->endSave();
endif;
unset($cache_cdda59b5c32ac656d628f9b4253eafc8);
echo $cache_cdda59b5c32ac656d628f9b4253eafc8_content;
unset($cache_cdda59b5c32ac656d628f9b4253eafc8_content);
   ?>

	</div>
	
		<div class="text"><h3>Vous ne pouvez pas:</h3> <ul>     <li>administrer les modules.</li>     <li>valider la modification des pages.</li>     <li>ou encore cr&eacute;er de nouveaux comptes utilisateurs.</li>     <li>...</li> </ul> <p>Ces fonctionnalit&eacute;s sont r&eacute;serv&eacute;es &agrave; un compte utilisateur de type&nbsp;  <strong>&laquo; Administrateur &raquo;.</strong></p></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h2>Un acc&eacute;s<strong> </strong>TOTAL</h2></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d'information, consultez les pages suivantes :</p> <ul>     <li><a href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne 4</a>.</li>     <li><a href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveaut&eacute;s</a>.</li>     <li><a href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pr&eacute;-requis</a>.</li>     <li><a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalit&eacute;s</a>.</li> </ul></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Présentation" (http://127.0.0.1/web/demo/3-presentation.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>