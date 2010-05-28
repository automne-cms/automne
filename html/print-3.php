<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 17:37:50 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:29 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/print-3-presentation.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/print-3-presentation.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?>
<<<<<<< TREE
<?php require_once(PATH_REALROOT_FS.'/automne/classes/polymodFrontEnd.php');  ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
=======
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 44_04dcb7
=======
	//SEARCH mediaresult TAG START 44_0d8652
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 44_30afec
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_44_04dcb7 = isset($public_search) ? $public_search : false;
=======
	$public_44_0d8652 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_44_30afec = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_04dcb7);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_0d8652);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_30afec);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_45_c1163c = array (
=======
		$values_45_9d90f3 = array (
>>>>>>> MERGE-SOURCE
=======
		$values_45_e914b9 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_45_c1163c['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_c1163c['type'] == 'publication date after' || $values_45_c1163c['type'] == 'publication date before') {
=======
		$values_45_9d90f3['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_9d90f3['type'] == 'publication date after' || $values_45_9d90f3['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_45_e914b9['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_e914b9['type'] == 'publication date after' || $values_45_e914b9['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_45_c1163c['value']);
			$values_45_c1163c['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_45_9d90f3['value']);
			$values_45_9d90f3['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_45_e914b9['value']);
			$values_45_e914b9['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_c1163c)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_9d90f3)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_e914b9)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 46_2ee493
=======
	//RESULT mediaresult TAG START 46_36a9ac
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 46_f91bae
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
<<<<<<< TREE
		$object_46_2ee493 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_2ee493 = $replace; //save previous replace vars if any
		$count_46_2ee493 = 0;
		$content_46_2ee493 = $content; //save previous content var if any
		$maxPages_46_2ee493 = $search_mediaresult->getMaxPages();
		$maxResults_46_2ee493 = $search_mediaresult->getNumRows();
=======
		$object_46_36a9ac = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_36a9ac = $replace; //save previous replace vars if any
		$count_46_36a9ac = 0;
		$content_46_36a9ac = $content; //save previous content var if any
		$maxPages_46_36a9ac = $search_mediaresult->getMaxPages();
		$maxResults_46_36a9ac = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_46_f91bae = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_f91bae = $replace; //save previous replace vars if any
		$count_46_f91bae = 0;
		$content_46_f91bae = $content; //save previous content var if any
		$maxPages_46_f91bae = $search_mediaresult->getMaxPages();
		$maxResults_46_f91bae = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_46_2ee493) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_2ee493 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_2ee493+1),
				"{maxpages}"    => $maxPages_46_2ee493,
=======
				"{firstresult}" => (!$count_46_36a9ac) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_36a9ac == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_36a9ac+1),
				"{maxpages}"    => $maxPages_46_36a9ac,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_46_f91bae) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_f91bae == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_f91bae+1),
				"{maxpages}"    => $maxPages_46_f91bae,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_46_2ee493,
=======
				"{maxresults}"  => $maxResults_46_36a9ac,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_46_f91bae,
				"{altclass}"    => (($count_46_f91bae+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 47_089072
=======
			//IF TAG START 47_7887db
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 47_3f24c1
			$ifcondition_47_3f24c1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_47_3f24c1) {
				$func_47_3f24c1 = create_function("","return (".$ifcondition_47_3f24c1.");");
				if ($func_47_3f24c1()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 48_e27170
=======
					//IF TAG START 48_d16320
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 48_c6a84e
					$ifcondition_48_c6a84e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_48_c6a84e) {
						$func_48_c6a84e = create_function("","return (".$ifcondition_48_c6a84e.");");
						if ($func_48_c6a84e()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 48_e27170
=======
					}//IF TAG END 48_d16320
>>>>>>> MERGE-SOURCE
=======
						unset($func_48_c6a84e);
					}
					unset($ifcondition_48_c6a84e);
					//IF TAG END 48_c6a84e
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 49_e2727e
=======
					//IF TAG START 49_148f0e
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 49_5f3021
					$ifcondition_49_5f3021 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_49_5f3021) {
						$func_49_5f3021 = create_function("","return (".$ifcondition_49_5f3021.");");
						if ($func_49_5f3021()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 49_e2727e
=======
					}//IF TAG END 49_148f0e
>>>>>>> MERGE-SOURCE
=======
						unset($func_49_5f3021);
					}
					unset($ifcondition_49_5f3021);
					//IF TAG END 49_5f3021
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 47_089072
			//IF TAG START 50_eb2a1d
=======
			}//IF TAG END 47_7887db
			//IF TAG START 50_bb7b15
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 51_f72d17
=======
					//IF TAG START 51_919d0c
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
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
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 51_f72d17
					//IF TAG START 52_ae4c73
=======
					}//IF TAG END 51_919d0c
					//IF TAG START 52_10ab2e
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_51_9c208f);
					}
					unset($ifcondition_51_9c208f);
					//IF TAG END 51_9c208f
					//IF TAG START 52_27be27
					$ifcondition_52_27be27 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_52_27be27) {
						$func_52_27be27 = create_function("","return (".$ifcondition_52_27be27.");");
						if ($func_52_27be27()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 52_ae4c73
=======
					}//IF TAG END 52_10ab2e
>>>>>>> MERGE-SOURCE
=======
						unset($func_52_27be27);
					}
					unset($ifcondition_52_27be27);
					//IF TAG END 52_27be27
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 50_eb2a1d
			//IF TAG START 53_b08b0f
=======
			}//IF TAG END 50_bb7b15
			//IF TAG START 53_9fb9b4
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_50_d498d4);
			}
			unset($ifcondition_50_d498d4);
			//IF TAG END 50_d498d4
			//IF TAG START 53_01c479
			$ifcondition_53_01c479 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_53_01c479) {
				$func_53_01c479 = create_function("","return (".$ifcondition_53_01c479.");");
				if ($func_53_01c479()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 54_d01944
=======
					//IF TAG START 54_0d9ceb
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 54_9a3c89
					$ifcondition_54_9a3c89 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_54_9a3c89) {
						$func_54_9a3c89 = create_function("","return (".$ifcondition_54_9a3c89.");");
						if ($func_54_9a3c89()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 54_d01944
=======
					}//IF TAG END 54_0d9ceb
>>>>>>> MERGE-SOURCE
=======
						unset($func_54_9a3c89);
					}
					unset($ifcondition_54_9a3c89);
					//IF TAG END 54_9a3c89
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 53_b08b0f
			//IF TAG START 55_c92a38
=======
			}//IF TAG END 53_9fb9b4
			//IF TAG START 55_d79868
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_53_01c479);
			}
			unset($ifcondition_53_01c479);
			//IF TAG END 53_01c479
			//IF TAG START 55_b63d8f
			$ifcondition_55_b63d8f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_55_b63d8f) {
				$func_55_b63d8f = create_function("","return (".$ifcondition_55_b63d8f.");");
				if ($func_55_b63d8f()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 56_c6620f
=======
					//IF TAG START 56_b2c6c4
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 56_c297de
					$ifcondition_56_c297de = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_56_c297de) {
						$func_56_c297de = create_function("","return (".$ifcondition_56_c297de.");");
						if ($func_56_c297de()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 56_c6620f
					//IF TAG START 57_6dfd7c
=======
					}//IF TAG END 56_b2c6c4
					//IF TAG START 57_58b085
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_56_c297de);
					}
					unset($ifcondition_56_c297de);
					//IF TAG END 56_c297de
					//IF TAG START 57_2f3a7e
					$ifcondition_57_2f3a7e = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_57_2f3a7e) {
						$func_57_2f3a7e = create_function("","return (".$ifcondition_57_2f3a7e.");");
						if ($func_57_2f3a7e()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 57_6dfd7c
=======
					}//IF TAG END 57_58b085
>>>>>>> MERGE-SOURCE
=======
						unset($func_57_2f3a7e);
					}
					unset($ifcondition_57_2f3a7e);
					//IF TAG END 57_2f3a7e
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 55_c92a38
			$count_46_2ee493++;
=======
			}//IF TAG END 55_d79868
			$count_46_36a9ac++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_55_b63d8f);
			}
			unset($ifcondition_55_b63d8f);
			//IF TAG END 55_b63d8f
			$count_46_f91bae++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_46_2ee493.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_46_36a9ac.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_46_f91bae.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_46_2ee493; //retrieve previous content var if any
		$replace = $replace_46_2ee493; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_46_2ee493; //retrieve previous object search if any
=======
		$content = $content_46_36a9ac; //retrieve previous content var if any
		$replace = $replace_46_36a9ac; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_46_36a9ac; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_46_f91bae; //retrieve previous content var if any
		unset($content_46_f91bae);
		$replace = $replace_46_f91bae; //retrieve previous replace vars if any
		unset($replace_46_f91bae);
		$object[$objectDefinition_mediaresult] = $object_46_f91bae; //retrieve previous object search if any
		unset($object_46_f91bae);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 46_2ee493
=======
	//RESULT mediaresult TAG END 46_36a9ac
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 46_f91bae
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 44_04dcb7
=======
	//SEARCH mediaresult TAG END 44_0d8652
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
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
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><h3><?php $parameters = array (
  'itemID' => 39,
  'pageID' => '3',
  'public' => false,
  'selection' => '',
);

//Generated by : $Id: automne4.sql,v 1.24 2010/02/01 16:16:39 sebastien Exp $
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pmedia', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
	$parameters['objectID'] = 2;
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = (isset($parameters['public'])) ? $parameters['public'] : true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	//PLUGIN TAG START 2_b782ed
	if (!sensitiveIO::isPositiveInteger($parameters['itemID']) || !sensitiveIO::isPositiveInteger($parameters['objectID'])) {
		CMS_grandFather::raiseError('Error into atm-plugin tag : can\'t found object infos to use into : $parameters[\'itemID\'] and $parameters[\'objectID\']');
	} else {
		//search needed object (need to search it for publications and rights purpose)
		if (!isset($objectDefinitions[$parameters['objectID']])) {
			$objectDefinitions[$parameters['objectID']] = new CMS_poly_object_definition($parameters['objectID']);
		}
		$search_2_b782ed = new CMS_object_search($objectDefinitions[$parameters['objectID']], $parameters['public']);
		$search_2_b782ed->addWhereCondition('item', $parameters['itemID']);
		$results_2_b782ed = $search_2_b782ed->search();
		if (isset($results_2_b782ed[$parameters['itemID']]) && is_object($results_2_b782ed[$parameters['itemID']])) {
			$object[$parameters['objectID']] = $results_2_b782ed[$parameters['itemID']];
		} else {
			$object[$parameters['objectID']] = new CMS_poly_object($parameters['objectID'], 0, array(), $parameters['public']);
		}
		$parameters['has-plugin-view'] = true;
		//PLUGIN-VALID TAG START 3_15941c
		if ($object[$parameters['objectID']]->isInUserSpace() && !(@$parameters['plugin-view'] && @$parameters['has-plugin-view']) ) {
			//IF TAG START 4_1d4ffa
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 5_afe99d
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
					}//IF TAG END 5_afe99d
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
				}
			}//IF TAG END 4_1d4ffa
			//IF TAG START 6_fa9c46
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					//IF TAG START 7_4e7c4c
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<script type=\"text/javascript\" src=\"/js/modules/pmedia/swfobject.js\"></script>
							<script type=\"text/javascript\">
							swfobject.addLoadEvent(function(){
								swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							});
							</script>
							";
						}
					}//IF TAG END 7_4e7c4c
					//IF TAG START 8_a8dd30
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<script type=\"text/javascript\" src=\"/js/modules/pmedia/swfobject.js\"></script>
							<script type=\"text/javascript\">
							swfobject.addLoadEvent(function(){
								swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							});
							</script>
							";
						}
					}//IF TAG END 8_a8dd30
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
			}//IF TAG END 6_fa9c46
			//IF TAG START 9_718960
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<script type=\"text/javascript\" src=\"/js/modules/pmedia/swfobject.js\"></script>
					<script type=\"text/javascript\">
					swfobject.addLoadEvent(function(){
						swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					});
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
			}//IF TAG END 9_718960
			//IF TAG START 10_60b179
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					//IF TAG START 11_061857
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
					}//IF TAG END 11_061857
					//IF TAG START 12_374135
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
					}//IF TAG END 12_374135
				}
			}//IF TAG END 10_60b179
		}
		//PLUGIN-VALID END 3_15941c
		//PLUGIN-VIEW TAG START 13_734c7e
		if ($object[$parameters['objectID']]->isInUserSpace() && isset($parameters['plugin-view'])) {
			//IF TAG START 14_afafea
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 15_7d08a2
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
					}//IF TAG END 15_7d08a2
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
				}
			}//IF TAG END 14_afafea
			//IF TAG START 16_5b2d81
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					//IF TAG START 17_d4d7e0
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
					}//IF TAG END 17_d4d7e0
					//IF TAG START 18_54d419
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
					}//IF TAG END 18_54d419
				}
			}//IF TAG END 16_5b2d81
		}
		//PLUGIN-VIEW END 13_734c7e
		$content .="
		";
	}
	//PLUGIN TAG END 2_b782ed
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
  ?>Bienvenue sur le site de <a href="http://test-folder/trunk/web/demo/2-accueil.php">Automne version 4, goûter à la simplicité (2)</a>démonstration de la <strong>nouvelle version d’Automne 4.</strong></h3>
<p>Vous trouverez ici <strong>toutes les informations</strong> nécessaires à la découverte de cette version ainsi que les <strong>notions essentielles</strong> pour bien appréhender l’outil.</p>
<p>&#160;</p></div>
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
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 58_db40ea
=======
	//SEARCH mediaresult TAG START 58_cd6363
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 58_2de81c
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_58_db40ea = isset($public_search) ? $public_search : false;
=======
	$public_58_cd6363 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_58_2de81c = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_db40ea);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_cd6363);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_2de81c);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_59_4e4c72 = array (
=======
		$values_59_69c8fe = array (
>>>>>>> MERGE-SOURCE
=======
		$values_59_3d0d28 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_59_4e4c72['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_4e4c72['type'] == 'publication date after' || $values_59_4e4c72['type'] == 'publication date before') {
=======
		$values_59_69c8fe['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_69c8fe['type'] == 'publication date after' || $values_59_69c8fe['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_59_3d0d28['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_3d0d28['type'] == 'publication date after' || $values_59_3d0d28['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_59_4e4c72['value']);
			$values_59_4e4c72['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_59_69c8fe['value']);
			$values_59_69c8fe['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_59_3d0d28['value']);
			$values_59_3d0d28['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_4e4c72)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_69c8fe)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_3d0d28)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 60_d7480a
=======
	//RESULT mediaresult TAG START 60_a33ad5
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 60_8fb646
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
<<<<<<< TREE
		$object_60_d7480a = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_d7480a = $replace; //save previous replace vars if any
		$count_60_d7480a = 0;
		$content_60_d7480a = $content; //save previous content var if any
		$maxPages_60_d7480a = $search_mediaresult->getMaxPages();
		$maxResults_60_d7480a = $search_mediaresult->getNumRows();
=======
		$object_60_a33ad5 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_a33ad5 = $replace; //save previous replace vars if any
		$count_60_a33ad5 = 0;
		$content_60_a33ad5 = $content; //save previous content var if any
		$maxPages_60_a33ad5 = $search_mediaresult->getMaxPages();
		$maxResults_60_a33ad5 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_60_8fb646 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_8fb646 = $replace; //save previous replace vars if any
		$count_60_8fb646 = 0;
		$content_60_8fb646 = $content; //save previous content var if any
		$maxPages_60_8fb646 = $search_mediaresult->getMaxPages();
		$maxResults_60_8fb646 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_60_d7480a) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_d7480a == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_d7480a+1),
				"{maxpages}"    => $maxPages_60_d7480a,
=======
				"{firstresult}" => (!$count_60_a33ad5) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_a33ad5 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_a33ad5+1),
				"{maxpages}"    => $maxPages_60_a33ad5,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_60_8fb646) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_8fb646 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_8fb646+1),
				"{maxpages}"    => $maxPages_60_8fb646,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_60_d7480a,
=======
				"{maxresults}"  => $maxResults_60_a33ad5,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_60_8fb646,
				"{altclass}"    => (($count_60_8fb646+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 61_0a9aa1
=======
			//IF TAG START 61_450bb3
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 61_07e85b
			$ifcondition_61_07e85b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_61_07e85b) {
				$func_61_07e85b = create_function("","return (".$ifcondition_61_07e85b.");");
				if ($func_61_07e85b()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 62_d77842
=======
					//IF TAG START 62_c25d8e
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 62_e86a64
					$ifcondition_62_e86a64 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_62_e86a64) {
						$func_62_e86a64 = create_function("","return (".$ifcondition_62_e86a64.");");
						if ($func_62_e86a64()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 62_d77842
=======
					}//IF TAG END 62_c25d8e
>>>>>>> MERGE-SOURCE
=======
						unset($func_62_e86a64);
					}
					unset($ifcondition_62_e86a64);
					//IF TAG END 62_e86a64
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 63_e9b8ea
=======
					//IF TAG START 63_1335d7
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 63_e5ee9b
					$ifcondition_63_e5ee9b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_63_e5ee9b) {
						$func_63_e5ee9b = create_function("","return (".$ifcondition_63_e5ee9b.");");
						if ($func_63_e5ee9b()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 63_e9b8ea
=======
					}//IF TAG END 63_1335d7
>>>>>>> MERGE-SOURCE
=======
						unset($func_63_e5ee9b);
					}
					unset($ifcondition_63_e5ee9b);
					//IF TAG END 63_e5ee9b
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 61_0a9aa1
			//IF TAG START 64_2d3e1f
=======
			}//IF TAG END 61_450bb3
			//IF TAG START 64_4b91ec
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 65_2a001d
=======
					//IF TAG START 65_db4c11
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
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
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 65_2a001d
					//IF TAG START 66_1b051d
=======
					}//IF TAG END 65_db4c11
					//IF TAG START 66_041c0b
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_65_d8eeb0);
					}
					unset($ifcondition_65_d8eeb0);
					//IF TAG END 65_d8eeb0
					//IF TAG START 66_e92f26
					$ifcondition_66_e92f26 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_66_e92f26) {
						$func_66_e92f26 = create_function("","return (".$ifcondition_66_e92f26.");");
						if ($func_66_e92f26()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 66_1b051d
=======
					}//IF TAG END 66_041c0b
>>>>>>> MERGE-SOURCE
=======
						unset($func_66_e92f26);
					}
					unset($ifcondition_66_e92f26);
					//IF TAG END 66_e92f26
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 64_2d3e1f
			//IF TAG START 67_669fcc
=======
			}//IF TAG END 64_4b91ec
			//IF TAG START 67_f17942
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_64_ecc1a3);
			}
			unset($ifcondition_64_ecc1a3);
			//IF TAG END 64_ecc1a3
			//IF TAG START 67_c9ff50
			$ifcondition_67_c9ff50 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_67_c9ff50) {
				$func_67_c9ff50 = create_function("","return (".$ifcondition_67_c9ff50.");");
				if ($func_67_c9ff50()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 68_0a36df
=======
					//IF TAG START 68_d93e11
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 68_9a7237
					$ifcondition_68_9a7237 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_68_9a7237) {
						$func_68_9a7237 = create_function("","return (".$ifcondition_68_9a7237.");");
						if ($func_68_9a7237()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 68_0a36df
=======
					}//IF TAG END 68_d93e11
>>>>>>> MERGE-SOURCE
=======
						unset($func_68_9a7237);
					}
					unset($ifcondition_68_9a7237);
					//IF TAG END 68_9a7237
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 67_669fcc
			//IF TAG START 69_2e5f75
=======
			}//IF TAG END 67_f17942
			//IF TAG START 69_275e11
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_67_c9ff50);
			}
			unset($ifcondition_67_c9ff50);
			//IF TAG END 67_c9ff50
			//IF TAG START 69_89b64b
			$ifcondition_69_89b64b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_69_89b64b) {
				$func_69_89b64b = create_function("","return (".$ifcondition_69_89b64b.");");
				if ($func_69_89b64b()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 70_6fe8d0
=======
					//IF TAG START 70_c0289c
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 70_9821e0
					$ifcondition_70_9821e0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_70_9821e0) {
						$func_70_9821e0 = create_function("","return (".$ifcondition_70_9821e0.");");
						if ($func_70_9821e0()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 70_6fe8d0
					//IF TAG START 71_efaf1e
=======
					}//IF TAG END 70_c0289c
					//IF TAG START 71_a9bd79
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_70_9821e0);
					}
					unset($ifcondition_70_9821e0);
					//IF TAG END 70_9821e0
					//IF TAG START 71_c225e9
					$ifcondition_71_c225e9 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_71_c225e9) {
						$func_71_c225e9 = create_function("","return (".$ifcondition_71_c225e9.");");
						if ($func_71_c225e9()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 71_efaf1e
=======
					}//IF TAG END 71_a9bd79
>>>>>>> MERGE-SOURCE
=======
						unset($func_71_c225e9);
					}
					unset($ifcondition_71_c225e9);
					//IF TAG END 71_c225e9
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 69_2e5f75
			$count_60_d7480a++;
=======
			}//IF TAG END 69_275e11
			$count_60_a33ad5++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_69_89b64b);
			}
			unset($ifcondition_69_89b64b);
			//IF TAG END 69_89b64b
			$count_60_8fb646++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_60_d7480a.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_60_a33ad5.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_60_8fb646.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_60_d7480a; //retrieve previous content var if any
		$replace = $replace_60_d7480a; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_60_d7480a; //retrieve previous object search if any
=======
		$content = $content_60_a33ad5; //retrieve previous content var if any
		$replace = $replace_60_a33ad5; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_60_a33ad5; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_60_8fb646; //retrieve previous content var if any
		unset($content_60_8fb646);
		$replace = $replace_60_8fb646; //retrieve previous replace vars if any
		unset($replace_60_8fb646);
		$object[$objectDefinition_mediaresult] = $object_60_8fb646; //retrieve previous object search if any
		unset($object_60_8fb646);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 60_d7480a
=======
	//RESULT mediaresult TAG END 60_a33ad5
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 60_8fb646
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 58_db40ea
=======
	//SEARCH mediaresult TAG END 58_cd6363
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
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
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 72_ff6e03
=======
	//SEARCH mediaresult TAG START 72_9acac5
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 72_85ddff
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_72_ff6e03 = isset($public_search) ? $public_search : false;
=======
	$public_72_9acac5 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_72_85ddff = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_ff6e03);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_9acac5);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_85ddff);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_73_df6e33 = array (
=======
		$values_73_92178e = array (
>>>>>>> MERGE-SOURCE
=======
		$values_73_7eebc2 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_73_df6e33['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_df6e33['type'] == 'publication date after' || $values_73_df6e33['type'] == 'publication date before') {
=======
		$values_73_92178e['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_92178e['type'] == 'publication date after' || $values_73_92178e['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_73_7eebc2['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_7eebc2['type'] == 'publication date after' || $values_73_7eebc2['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_73_df6e33['value']);
			$values_73_df6e33['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_73_92178e['value']);
			$values_73_92178e['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_73_7eebc2['value']);
			$values_73_7eebc2['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_df6e33)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_92178e)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_7eebc2)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 74_e790bd
=======
	//RESULT mediaresult TAG START 74_177afc
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 74_f21a3a
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
<<<<<<< TREE
		$object_74_e790bd = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_e790bd = $replace; //save previous replace vars if any
		$count_74_e790bd = 0;
		$content_74_e790bd = $content; //save previous content var if any
		$maxPages_74_e790bd = $search_mediaresult->getMaxPages();
		$maxResults_74_e790bd = $search_mediaresult->getNumRows();
=======
		$object_74_177afc = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_177afc = $replace; //save previous replace vars if any
		$count_74_177afc = 0;
		$content_74_177afc = $content; //save previous content var if any
		$maxPages_74_177afc = $search_mediaresult->getMaxPages();
		$maxResults_74_177afc = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_74_f21a3a = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_f21a3a = $replace; //save previous replace vars if any
		$count_74_f21a3a = 0;
		$content_74_f21a3a = $content; //save previous content var if any
		$maxPages_74_f21a3a = $search_mediaresult->getMaxPages();
		$maxResults_74_f21a3a = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_74_e790bd) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_e790bd == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_e790bd+1),
				"{maxpages}"    => $maxPages_74_e790bd,
=======
				"{firstresult}" => (!$count_74_177afc) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_177afc == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_177afc+1),
				"{maxpages}"    => $maxPages_74_177afc,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_74_f21a3a) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_f21a3a == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_f21a3a+1),
				"{maxpages}"    => $maxPages_74_f21a3a,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_74_e790bd,
=======
				"{maxresults}"  => $maxResults_74_177afc,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_74_f21a3a,
				"{altclass}"    => (($count_74_f21a3a+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 75_55da9e
=======
			//IF TAG START 75_fc6a58
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 75_e04e41
			$ifcondition_75_e04e41 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_75_e04e41) {
				$func_75_e04e41 = create_function("","return (".$ifcondition_75_e04e41.");");
				if ($func_75_e04e41()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 76_19148a
=======
					//IF TAG START 76_2e8d59
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 76_a0e9fd
					$ifcondition_76_a0e9fd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_76_a0e9fd) {
						$func_76_a0e9fd = create_function("","return (".$ifcondition_76_a0e9fd.");");
						if ($func_76_a0e9fd()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 76_19148a
=======
					}//IF TAG END 76_2e8d59
>>>>>>> MERGE-SOURCE
=======
						unset($func_76_a0e9fd);
					}
					unset($ifcondition_76_a0e9fd);
					//IF TAG END 76_a0e9fd
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 77_3651ad
=======
					//IF TAG START 77_1bf0f7
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 77_7f0aa3
					$ifcondition_77_7f0aa3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_77_7f0aa3) {
						$func_77_7f0aa3 = create_function("","return (".$ifcondition_77_7f0aa3.");");
						if ($func_77_7f0aa3()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 77_3651ad
=======
					}//IF TAG END 77_1bf0f7
>>>>>>> MERGE-SOURCE
=======
						unset($func_77_7f0aa3);
					}
					unset($ifcondition_77_7f0aa3);
					//IF TAG END 77_7f0aa3
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 75_55da9e
			//IF TAG START 78_55055d
=======
			}//IF TAG END 75_fc6a58
			//IF TAG START 78_4fe63d
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 79_923298
=======
					//IF TAG START 79_166d15
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
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
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 79_923298
					//IF TAG START 80_814593
=======
					}//IF TAG END 79_166d15
					//IF TAG START 80_cfadf1
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_79_298ae5);
					}
					unset($ifcondition_79_298ae5);
					//IF TAG END 79_298ae5
					//IF TAG START 80_14ea94
					$ifcondition_80_14ea94 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_80_14ea94) {
						$func_80_14ea94 = create_function("","return (".$ifcondition_80_14ea94.");");
						if ($func_80_14ea94()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 80_814593
=======
					}//IF TAG END 80_cfadf1
>>>>>>> MERGE-SOURCE
=======
						unset($func_80_14ea94);
					}
					unset($ifcondition_80_14ea94);
					//IF TAG END 80_14ea94
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 78_55055d
			//IF TAG START 81_db504d
=======
			}//IF TAG END 78_4fe63d
			//IF TAG START 81_62f495
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_78_a45108);
			}
			unset($ifcondition_78_a45108);
			//IF TAG END 78_a45108
			//IF TAG START 81_c5cf9a
			$ifcondition_81_c5cf9a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_81_c5cf9a) {
				$func_81_c5cf9a = create_function("","return (".$ifcondition_81_c5cf9a.");");
				if ($func_81_c5cf9a()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 82_a244c8
=======
					//IF TAG START 82_b0dcd4
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 82_655080
					$ifcondition_82_655080 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_82_655080) {
						$func_82_655080 = create_function("","return (".$ifcondition_82_655080.");");
						if ($func_82_655080()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 82_a244c8
=======
					}//IF TAG END 82_b0dcd4
>>>>>>> MERGE-SOURCE
=======
						unset($func_82_655080);
					}
					unset($ifcondition_82_655080);
					//IF TAG END 82_655080
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 81_db504d
			//IF TAG START 83_a3492e
=======
			}//IF TAG END 81_62f495
			//IF TAG START 83_eef7f1
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_81_c5cf9a);
			}
			unset($ifcondition_81_c5cf9a);
			//IF TAG END 81_c5cf9a
			//IF TAG START 83_d873bf
			$ifcondition_83_d873bf = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_83_d873bf) {
				$func_83_d873bf = create_function("","return (".$ifcondition_83_d873bf.");");
				if ($func_83_d873bf()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 84_ed5808
=======
					//IF TAG START 84_e627e8
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 84_c746e9
					$ifcondition_84_c746e9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_84_c746e9) {
						$func_84_c746e9 = create_function("","return (".$ifcondition_84_c746e9.");");
						if ($func_84_c746e9()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 84_ed5808
					//IF TAG START 85_2e0c9f
=======
					}//IF TAG END 84_e627e8
					//IF TAG START 85_929b3a
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_84_c746e9);
					}
					unset($ifcondition_84_c746e9);
					//IF TAG END 84_c746e9
					//IF TAG START 85_44aa8c
					$ifcondition_85_44aa8c = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_85_44aa8c) {
						$func_85_44aa8c = create_function("","return (".$ifcondition_85_44aa8c.");");
						if ($func_85_44aa8c()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 85_2e0c9f
=======
					}//IF TAG END 85_929b3a
>>>>>>> MERGE-SOURCE
=======
						unset($func_85_44aa8c);
					}
					unset($ifcondition_85_44aa8c);
					//IF TAG END 85_44aa8c
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 83_a3492e
			$count_74_e790bd++;
=======
			}//IF TAG END 83_eef7f1
			$count_74_177afc++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_83_d873bf);
			}
			unset($ifcondition_83_d873bf);
			//IF TAG END 83_d873bf
			$count_74_f21a3a++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_74_e790bd.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_74_177afc.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_74_f21a3a.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_74_e790bd; //retrieve previous content var if any
		$replace = $replace_74_e790bd; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_74_e790bd; //retrieve previous object search if any
=======
		$content = $content_74_177afc; //retrieve previous content var if any
		$replace = $replace_74_177afc; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_74_177afc; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_74_f21a3a; //retrieve previous content var if any
		unset($content_74_f21a3a);
		$replace = $replace_74_f21a3a; //retrieve previous replace vars if any
		unset($replace_74_f21a3a);
		$object[$objectDefinition_mediaresult] = $object_74_f21a3a; //retrieve previous object search if any
		unset($object_74_f21a3a);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 74_e790bd
=======
	//RESULT mediaresult TAG END 74_177afc
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 74_f21a3a
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 72_ff6e03
=======
	//SEARCH mediaresult TAG END 72_9acac5
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
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
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><h3>Vous ne pouvez pas:</h3> <ul>     <li>administrer les modules.</li>     <li>valider la modification des pages.</li>     <li>ou encore cr&eacute;er de nouveaux comptes utilisateurs.</li>     <li>...</li> </ul> <p>Ces fonctionnalit&eacute;s sont r&eacute;serv&eacute;es &agrave; un compte utilisateur de type&nbsp;  <strong>&laquo; Administrateur &raquo;.</strong></p></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h2>Un acc&eacute;s<strong> </strong>TOTAL</h2></div>

<<<<<<< TREE

	
	
		<div class="text"><h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d'information, consultez les pages suivantes :</p> <ul>     <li><a href="http://test-folder/trunk/web/demo/29-automne-v4.php">Automne 4</a>.</li>     <li><a href="http://test-folder/trunk/web/demo/33-nouveautes.php">Nouveaut&eacute;s</a>.</li>     <li><a href="http://test-folder/trunk/web/demo/30-notions-essentielles.php">Pr&eacute;-requis</a>.</li>     <li><a href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalit&eacute;s</a>.</li> </ul></div>
	
<br />
=======
<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d'information, consultez les pages suivantes :</p> <ul>     <li><a href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne 4</a>.</li>     <li><a href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveaut&eacute;s</a>.</li>     <li><a href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pr&eacute;-requis</a>.</li>     <li><a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalit&eacute;s</a>.</li> </ul></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* End clientspace [first] */   ?><br />
>>>>>>> MERGE-SOURCE
<hr />
<div align="center">
	<small>
<<<<<<< TREE
		Derni&egrave;re mise &agrave; jour le 11/03/2010<br />
		
				Page  "Présentation" (http://test-folder/trunk/web/demo/3-presentation.php)
=======
		
		
				Page  "Présentation" (http://127.0.0.1/web/demo/3-presentation.php)
>>>>>>> MERGE-SOURCE
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>