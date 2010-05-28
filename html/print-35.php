<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:28 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:50 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 17:00:10 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/print-35-gestion-des-droits.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/print-35-gestion-des-droits.php', true, 301);
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
	<title>Automne 4 : Gestion des droits</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Gestion des droits</h1>
<h3>

		&raquo;&nbsp;Fonctionnalités
		
		&raquo;&nbsp;Gestion des droits
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Principe de gestion des droits</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_00fd983f39bf12667ea9a2dc99802b67 = new CMS_cache('00fd983f39bf12667ea9a2dc99802b67', 'polymod', 'auto', true);
if ($cache_00fd983f39bf12667ea9a2dc99802b67->exist()):
	//Get content from cache
	$cache_00fd983f39bf12667ea9a2dc99802b67_content = $cache_00fd983f39bf12667ea9a2dc99802b67->load();
else:
	$cache_00fd983f39bf12667ea9a2dc99802b67->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:10 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '28',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '35';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 16_a1683d
=======
	//SEARCH mediaresult TAG START 16_8d1809
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 16_c587e5
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_16_a1683d = isset($public_search) ? $public_search : false;
=======
	$public_16_8d1809 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_16_c587e5 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_a1683d);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_8d1809);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_c587e5);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_17_e2a6ca = array (
=======
		$values_17_77810d = array (
>>>>>>> MERGE-SOURCE
=======
		$values_17_8f9950 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_17_e2a6ca['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_e2a6ca['type'] == 'publication date after' || $values_17_e2a6ca['type'] == 'publication date before') {
=======
		$values_17_77810d['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_77810d['type'] == 'publication date after' || $values_17_77810d['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_17_8f9950['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_8f9950['type'] == 'publication date after' || $values_17_8f9950['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_17_e2a6ca['value']);
			$values_17_e2a6ca['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_17_77810d['value']);
			$values_17_77810d['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_17_8f9950['value']);
			$values_17_8f9950['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_e2a6ca)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_77810d)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_8f9950)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 18_cc91a3
=======
	//RESULT mediaresult TAG START 18_3c625d
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 18_98863c
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
		$object_18_cc91a3 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_cc91a3 = $replace; //save previous replace vars if any
		$count_18_cc91a3 = 0;
		$content_18_cc91a3 = $content; //save previous content var if any
		$maxPages_18_cc91a3 = $search_mediaresult->getMaxPages();
		$maxResults_18_cc91a3 = $search_mediaresult->getNumRows();
=======
		$object_18_3c625d = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_3c625d = $replace; //save previous replace vars if any
		$count_18_3c625d = 0;
		$content_18_3c625d = $content; //save previous content var if any
		$maxPages_18_3c625d = $search_mediaresult->getMaxPages();
		$maxResults_18_3c625d = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_18_98863c = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_98863c = $replace; //save previous replace vars if any
		$count_18_98863c = 0;
		$content_18_98863c = $content; //save previous content var if any
		$maxPages_18_98863c = $search_mediaresult->getMaxPages();
		$maxResults_18_98863c = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_18_cc91a3) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_cc91a3 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_cc91a3+1),
				"{maxpages}"    => $maxPages_18_cc91a3,
=======
				"{firstresult}" => (!$count_18_3c625d) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_3c625d == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_3c625d+1),
				"{maxpages}"    => $maxPages_18_3c625d,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_18_98863c) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_98863c == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_98863c+1),
				"{maxpages}"    => $maxPages_18_98863c,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_18_cc91a3,
=======
				"{maxresults}"  => $maxResults_18_3c625d,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_18_98863c,
				"{altclass}"    => (($count_18_98863c+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 19_054b08
=======
			//IF TAG START 19_2b7cbe
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 19_85c712
			$ifcondition_19_85c712 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_19_85c712) {
				$func_19_85c712 = create_function("","return (".$ifcondition_19_85c712.");");
				if ($func_19_85c712()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 20_102675
=======
					//IF TAG START 20_f881e2
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 20_d606e9
					$ifcondition_20_d606e9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_20_d606e9) {
						$func_20_d606e9 = create_function("","return (".$ifcondition_20_d606e9.");");
						if ($func_20_d606e9()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 20_102675
=======
					}//IF TAG END 20_f881e2
>>>>>>> MERGE-SOURCE
=======
						unset($func_20_d606e9);
					}
					unset($ifcondition_20_d606e9);
					//IF TAG END 20_d606e9
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 21_e69df6
=======
					//IF TAG START 21_ea4456
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 21_8d7c2b
					$ifcondition_21_8d7c2b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_21_8d7c2b) {
						$func_21_8d7c2b = create_function("","return (".$ifcondition_21_8d7c2b.");");
						if ($func_21_8d7c2b()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 21_e69df6
=======
					}//IF TAG END 21_ea4456
>>>>>>> MERGE-SOURCE
=======
						unset($func_21_8d7c2b);
					}
					unset($ifcondition_21_8d7c2b);
					//IF TAG END 21_8d7c2b
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 19_054b08
			//IF TAG START 22_c0df48
=======
			}//IF TAG END 19_2b7cbe
			//IF TAG START 22_19f621
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 23_fed75d
=======
					//IF TAG START 23_cb1b67
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
				unset($func_19_85c712);
			}
			unset($ifcondition_19_85c712);
			//IF TAG END 19_85c712
			//IF TAG START 22_5ad94f
			$ifcondition_22_5ad94f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_22_5ad94f) {
				$func_22_5ad94f = create_function("","return (".$ifcondition_22_5ad94f.");");
				if ($func_22_5ad94f()) {
					//IF TAG START 23_81dc50
					$ifcondition_23_81dc50 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_23_81dc50) {
						$func_23_81dc50 = create_function("","return (".$ifcondition_23_81dc50.");");
						if ($func_23_81dc50()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 23_fed75d
					//IF TAG START 24_0f3918
=======
					}//IF TAG END 23_cb1b67
					//IF TAG START 24_32cb77
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_23_81dc50);
					}
					unset($ifcondition_23_81dc50);
					//IF TAG END 23_81dc50
					//IF TAG START 24_8f5ef6
					$ifcondition_24_8f5ef6 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_24_8f5ef6) {
						$func_24_8f5ef6 = create_function("","return (".$ifcondition_24_8f5ef6.");");
						if ($func_24_8f5ef6()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 24_0f3918
=======
					}//IF TAG END 24_32cb77
>>>>>>> MERGE-SOURCE
=======
						unset($func_24_8f5ef6);
					}
					unset($ifcondition_24_8f5ef6);
					//IF TAG END 24_8f5ef6
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 22_c0df48
			//IF TAG START 25_f1ac37
=======
			}//IF TAG END 22_19f621
			//IF TAG START 25_25bdd1
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_22_5ad94f);
			}
			unset($ifcondition_22_5ad94f);
			//IF TAG END 22_5ad94f
			//IF TAG START 25_273942
			$ifcondition_25_273942 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_25_273942) {
				$func_25_273942 = create_function("","return (".$ifcondition_25_273942.");");
				if ($func_25_273942()) {
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
					//IF TAG START 26_84ad62
=======
					//IF TAG START 26_cdfe9c
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 26_290fa3
					$ifcondition_26_290fa3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_26_290fa3) {
						$func_26_290fa3 = create_function("","return (".$ifcondition_26_290fa3.");");
						if ($func_26_290fa3()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 26_84ad62
=======
					}//IF TAG END 26_cdfe9c
>>>>>>> MERGE-SOURCE
=======
						unset($func_26_290fa3);
					}
					unset($ifcondition_26_290fa3);
					//IF TAG END 26_290fa3
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 25_f1ac37
			//IF TAG START 27_ef1cfa
=======
			}//IF TAG END 25_25bdd1
			//IF TAG START 27_193858
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_25_273942);
			}
			unset($ifcondition_25_273942);
			//IF TAG END 25_273942
			//IF TAG START 27_963d86
			$ifcondition_27_963d86 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_27_963d86) {
				$func_27_963d86 = create_function("","return (".$ifcondition_27_963d86.");");
				if ($func_27_963d86()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 28_dfff14
=======
					//IF TAG START 28_c7cc32
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 28_00d126
					$ifcondition_28_00d126 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_28_00d126) {
						$func_28_00d126 = create_function("","return (".$ifcondition_28_00d126.");");
						if ($func_28_00d126()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 28_dfff14
					//IF TAG START 29_8715ca
=======
					}//IF TAG END 28_c7cc32
					//IF TAG START 29_629dea
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_28_00d126);
					}
					unset($ifcondition_28_00d126);
					//IF TAG END 28_00d126
					//IF TAG START 29_59c8ca
					$ifcondition_29_59c8ca = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_29_59c8ca) {
						$func_29_59c8ca = create_function("","return (".$ifcondition_29_59c8ca.");");
						if ($func_29_59c8ca()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 29_8715ca
=======
					}//IF TAG END 29_629dea
>>>>>>> MERGE-SOURCE
=======
						unset($func_29_59c8ca);
					}
					unset($ifcondition_29_59c8ca);
					//IF TAG END 29_59c8ca
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 27_ef1cfa
			$count_18_cc91a3++;
=======
			}//IF TAG END 27_193858
			$count_18_3c625d++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_27_963d86);
			}
			unset($ifcondition_27_963d86);
			//IF TAG END 27_963d86
			$count_18_98863c++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_18_cc91a3.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_18_3c625d.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_18_98863c.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_18_cc91a3; //retrieve previous content var if any
		$replace = $replace_18_cc91a3; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_18_cc91a3; //retrieve previous object search if any
=======
		$content = $content_18_3c625d; //retrieve previous content var if any
		$replace = $replace_18_3c625d; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_18_3c625d; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_18_98863c; //retrieve previous content var if any
		unset($content_18_98863c);
		$replace = $replace_18_98863c; //retrieve previous replace vars if any
		unset($replace_18_98863c);
		$object[$objectDefinition_mediaresult] = $object_18_98863c; //retrieve previous object search if any
		unset($object_18_98863c);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 18_cc91a3
=======
	//RESULT mediaresult TAG END 18_3c625d
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 18_98863c
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 16_a1683d
=======
	//SEARCH mediaresult TAG END 16_8d1809
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
	//SEARCH mediaresult TAG END 16_c587e5
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
	<?php $cache_00fd983f39bf12667ea9a2dc99802b67_content = $cache_00fd983f39bf12667ea9a2dc99802b67->endSave();
endif;
unset($cache_00fd983f39bf12667ea9a2dc99802b67);
echo $cache_00fd983f39bf12667ea9a2dc99802b67_content;
unset($cache_00fd983f39bf12667ea9a2dc99802b67_content);
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><p>Il existe<strong> trois types de droits fondamentaux</strong> :</p> <ul>     <li>Droit d'&eacute;criture &rArr; &eacute;quivaut au <strong>droit d'administration.</strong></li>     <li>Droit de lecture &rArr; &eacute;quivaut au <strong>droit de visibilit&eacute;.</strong></li>     <li>Aucun droit &rArr; l'utilisateur ne peut voir le contenu.</li> </ul></div>
		<div class="spacer"></div>
	
<<<<<<< TREE


<div class="text"><p>Automne 4 dispose d'un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d'appliquer l'ensemble de ces droits sur tout types d'&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d'administration... L'ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d'utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <a href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">droit de validation.</a></h3> <p>Ce droit permet de donner &agrave; l'utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L'utilisateur A peut avoir des droits d'administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu'il peut utiliser.</em></li>     <li><em>L'utilisateur B peut avoir les droits d'administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L'utilisateur C peut avoir les droits d'administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d'autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d'utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d'utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d'administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p></div>

<br />
=======
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>Automne 4 dispose d'un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d'appliquer l'ensemble de ces droits sur tout types d'&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d'administration... L'ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d'utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">droit de validation.</a></h3> <p>Ce droit permet de donner &agrave; l'utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L'utilisateur A peut avoir des droits d'administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu'il peut utiliser.</em></li>     <li><em>L'utilisateur B peut avoir les droits d'administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L'utilisateur C peut avoir les droits d'administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d'autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d'utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d'utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d'administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* End clientspace [first] */   ?><br />
>>>>>>> MERGE-SOURCE
<hr />
<div align="center">
	<small>
		
		
<<<<<<< TREE
				Page  "Gestion des droits" (http://test-folder/trunk/web/demo/35-gestion-des-droits.php)
=======
				Page  "Gestion des droits" (http://127.0.0.1/web/demo/35-gestion-des-droits.php)
>>>>>>> MERGE-SOURCE
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>