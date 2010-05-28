<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:25 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:56 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 17:00:15 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/print-38-aide-aux-utilisateurs.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/print-38-aide-aux-utilisateurs.php', true, 301);
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
	<title>Automne 4 : Aide aux utilisateurs</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Aide aux utilisateurs</h1>
<h3>

		&raquo;&nbsp;Fonctionnalités
		
		&raquo;&nbsp;Aide utilisateurs
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><p>Les utilisateurs d'Automne 4 peuvent parfois &ecirc;tre confront&eacute;s &agrave; des questions sur l'utilisation de l'outil. &quot;<em>Que ce passe t'il si je clique sur ce bouton ?</em>&quot; &quot;<em>comment dois je r&eacute;aliser telle modification ?</em>&quot;.</p> <h3>Pour r&eacute;pondre &agrave; ces questions courantes, nous avons mis en place un&nbsp; NOUVEAU syst&egrave;me d'aide complet int&eacute;gr&eacute; &agrave; toutes les interfaces d'administration :</h3></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Aide contextuelle</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?>
	<div class="imgLeft">
		<?php $cache_018d3e635121ab4bf3cfc9a01220474f = new CMS_cache('018d3e635121ab4bf3cfc9a01220474f', 'polymod', 'auto', true);
if ($cache_018d3e635121ab4bf3cfc9a01220474f->exist()):
	//Get content from cache
	$cache_018d3e635121ab4bf3cfc9a01220474f_content = $cache_018d3e635121ab4bf3cfc9a01220474f->load();
else:
	$cache_018d3e635121ab4bf3cfc9a01220474f->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:15 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '38',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '38';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 44_abf404
=======
	//SEARCH mediaresult TAG START 44_e67c87
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 44_a7fade
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_44_abf404 = isset($public_search) ? $public_search : false;
=======
	$public_44_e67c87 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_44_a7fade = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_abf404);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_e67c87);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_44_a7fade);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_45_5bcf9b = array (
=======
		$values_45_f2fd03 = array (
>>>>>>> MERGE-SOURCE
=======
		$values_45_c3a7e5 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_45_5bcf9b['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_5bcf9b['type'] == 'publication date after' || $values_45_5bcf9b['type'] == 'publication date before') {
=======
		$values_45_f2fd03['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_f2fd03['type'] == 'publication date after' || $values_45_f2fd03['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_45_c3a7e5['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_45_c3a7e5['type'] == 'publication date after' || $values_45_c3a7e5['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_45_5bcf9b['value']);
			$values_45_5bcf9b['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_45_f2fd03['value']);
			$values_45_f2fd03['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_45_c3a7e5['value']);
			$values_45_c3a7e5['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_5bcf9b)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_f2fd03)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_45_c3a7e5)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 46_782a21
=======
	//RESULT mediaresult TAG START 46_af7bbb
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 46_eb8f48
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
		$object_46_782a21 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_782a21 = $replace; //save previous replace vars if any
		$count_46_782a21 = 0;
		$content_46_782a21 = $content; //save previous content var if any
		$maxPages_46_782a21 = $search_mediaresult->getMaxPages();
		$maxResults_46_782a21 = $search_mediaresult->getNumRows();
=======
		$object_46_af7bbb = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_af7bbb = $replace; //save previous replace vars if any
		$count_46_af7bbb = 0;
		$content_46_af7bbb = $content; //save previous content var if any
		$maxPages_46_af7bbb = $search_mediaresult->getMaxPages();
		$maxResults_46_af7bbb = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_46_eb8f48 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_46_eb8f48 = $replace; //save previous replace vars if any
		$count_46_eb8f48 = 0;
		$content_46_eb8f48 = $content; //save previous content var if any
		$maxPages_46_eb8f48 = $search_mediaresult->getMaxPages();
		$maxResults_46_eb8f48 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_46_782a21) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_782a21 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_782a21+1),
				"{maxpages}"    => $maxPages_46_782a21,
=======
				"{firstresult}" => (!$count_46_af7bbb) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_af7bbb == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_af7bbb+1),
				"{maxpages}"    => $maxPages_46_af7bbb,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_46_eb8f48) ? 1 : 0,
				"{lastresult}" 	=> ($count_46_eb8f48 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_46_eb8f48+1),
				"{maxpages}"    => $maxPages_46_eb8f48,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_46_782a21,
=======
				"{maxresults}"  => $maxResults_46_af7bbb,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_46_eb8f48,
				"{altclass}"    => (($count_46_eb8f48+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 47_1da32e
=======
			//IF TAG START 47_929a80
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 47_61d9fd
			$ifcondition_47_61d9fd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_47_61d9fd) {
				$func_47_61d9fd = create_function("","return (".$ifcondition_47_61d9fd.");");
				if ($func_47_61d9fd()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 48_5acf06
=======
					//IF TAG START 48_6fb89c
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 48_7d1687
					$ifcondition_48_7d1687 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_48_7d1687) {
						$func_48_7d1687 = create_function("","return (".$ifcondition_48_7d1687.");");
						if ($func_48_7d1687()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 48_5acf06
=======
					}//IF TAG END 48_6fb89c
>>>>>>> MERGE-SOURCE
=======
						unset($func_48_7d1687);
					}
					unset($ifcondition_48_7d1687);
					//IF TAG END 48_7d1687
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 49_654dbd
=======
					//IF TAG START 49_f15e9b
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 49_f7ae6d
					$ifcondition_49_f7ae6d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_49_f7ae6d) {
						$func_49_f7ae6d = create_function("","return (".$ifcondition_49_f7ae6d.");");
						if ($func_49_f7ae6d()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 49_654dbd
=======
					}//IF TAG END 49_f15e9b
>>>>>>> MERGE-SOURCE
=======
						unset($func_49_f7ae6d);
					}
					unset($ifcondition_49_f7ae6d);
					//IF TAG END 49_f7ae6d
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 47_1da32e
			//IF TAG START 50_d0f13c
=======
			}//IF TAG END 47_929a80
			//IF TAG START 50_7981bf
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 51_cd0fcd
=======
					//IF TAG START 51_f8e270
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
				unset($func_47_61d9fd);
			}
			unset($ifcondition_47_61d9fd);
			//IF TAG END 47_61d9fd
			//IF TAG START 50_7e6116
			$ifcondition_50_7e6116 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_50_7e6116) {
				$func_50_7e6116 = create_function("","return (".$ifcondition_50_7e6116.");");
				if ($func_50_7e6116()) {
					//IF TAG START 51_3d88cd
					$ifcondition_51_3d88cd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_51_3d88cd) {
						$func_51_3d88cd = create_function("","return (".$ifcondition_51_3d88cd.");");
						if ($func_51_3d88cd()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 51_cd0fcd
					//IF TAG START 52_8a92fe
=======
					}//IF TAG END 51_f8e270
					//IF TAG START 52_bea4e5
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_51_3d88cd);
					}
					unset($ifcondition_51_3d88cd);
					//IF TAG END 51_3d88cd
					//IF TAG START 52_ac47b3
					$ifcondition_52_ac47b3 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_52_ac47b3) {
						$func_52_ac47b3 = create_function("","return (".$ifcondition_52_ac47b3.");");
						if ($func_52_ac47b3()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 52_8a92fe
=======
					}//IF TAG END 52_bea4e5
>>>>>>> MERGE-SOURCE
=======
						unset($func_52_ac47b3);
					}
					unset($ifcondition_52_ac47b3);
					//IF TAG END 52_ac47b3
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 50_d0f13c
			//IF TAG START 53_55c659
=======
			}//IF TAG END 50_7981bf
			//IF TAG START 53_352094
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_50_7e6116);
			}
			unset($ifcondition_50_7e6116);
			//IF TAG END 50_7e6116
			//IF TAG START 53_6dc148
			$ifcondition_53_6dc148 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_53_6dc148) {
				$func_53_6dc148 = create_function("","return (".$ifcondition_53_6dc148.");");
				if ($func_53_6dc148()) {
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
					//IF TAG START 54_5d7c96
=======
					//IF TAG START 54_a72503
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 54_8aa308
					$ifcondition_54_8aa308 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_54_8aa308) {
						$func_54_8aa308 = create_function("","return (".$ifcondition_54_8aa308.");");
						if ($func_54_8aa308()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 54_5d7c96
=======
					}//IF TAG END 54_a72503
>>>>>>> MERGE-SOURCE
=======
						unset($func_54_8aa308);
					}
					unset($ifcondition_54_8aa308);
					//IF TAG END 54_8aa308
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 53_55c659
			//IF TAG START 55_5acc51
=======
			}//IF TAG END 53_352094
			//IF TAG START 55_9dfa9c
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_53_6dc148);
			}
			unset($ifcondition_53_6dc148);
			//IF TAG END 53_6dc148
			//IF TAG START 55_9d241b
			$ifcondition_55_9d241b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_55_9d241b) {
				$func_55_9d241b = create_function("","return (".$ifcondition_55_9d241b.");");
				if ($func_55_9d241b()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 56_2b4add
=======
					//IF TAG START 56_bcdeb3
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 56_ce8ea9
					$ifcondition_56_ce8ea9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_56_ce8ea9) {
						$func_56_ce8ea9 = create_function("","return (".$ifcondition_56_ce8ea9.");");
						if ($func_56_ce8ea9()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 56_2b4add
					//IF TAG START 57_5688fe
=======
					}//IF TAG END 56_bcdeb3
					//IF TAG START 57_3c9c15
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_56_ce8ea9);
					}
					unset($ifcondition_56_ce8ea9);
					//IF TAG END 56_ce8ea9
					//IF TAG START 57_84cb47
					$ifcondition_57_84cb47 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_57_84cb47) {
						$func_57_84cb47 = create_function("","return (".$ifcondition_57_84cb47.");");
						if ($func_57_84cb47()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 57_5688fe
=======
					}//IF TAG END 57_3c9c15
>>>>>>> MERGE-SOURCE
=======
						unset($func_57_84cb47);
					}
					unset($ifcondition_57_84cb47);
					//IF TAG END 57_84cb47
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 55_5acc51
			$count_46_782a21++;
=======
			}//IF TAG END 55_9dfa9c
			$count_46_af7bbb++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_55_9d241b);
			}
			unset($ifcondition_55_9d241b);
			//IF TAG END 55_9d241b
			$count_46_eb8f48++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_46_782a21.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_46_af7bbb.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_46_eb8f48.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_46_782a21; //retrieve previous content var if any
		$replace = $replace_46_782a21; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_46_782a21; //retrieve previous object search if any
=======
		$content = $content_46_af7bbb; //retrieve previous content var if any
		$replace = $replace_46_af7bbb; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_46_af7bbb; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_46_eb8f48; //retrieve previous content var if any
		unset($content_46_eb8f48);
		$replace = $replace_46_eb8f48; //retrieve previous replace vars if any
		unset($replace_46_eb8f48);
		$object[$objectDefinition_mediaresult] = $object_46_eb8f48; //retrieve previous object search if any
		unset($object_46_eb8f48);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 46_782a21
=======
	//RESULT mediaresult TAG END 46_af7bbb
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 46_eb8f48
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 44_abf404
=======
	//SEARCH mediaresult TAG END 44_e67c87
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
	//SEARCH mediaresult TAG END 44_a7fade
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
	<?php $cache_018d3e635121ab4bf3cfc9a01220474f_content = $cache_018d3e635121ab4bf3cfc9a01220474f->endSave();
endif;
unset($cache_018d3e635121ab4bf3cfc9a01220474f);
echo $cache_018d3e635121ab4bf3cfc9a01220474f_content;
unset($cache_018d3e635121ab4bf3cfc9a01220474f_content);
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><p>L'aide contextuelle vous permet d<strong>'obtenir des informations</strong> sur les &eacute;l&eacute;ments que vous pointez avec votre curseur.</p> <h3>PLUS aucun bouton n'aura de secret pour vous !</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>L&#039;aide à la syntaxe XML (pour les utilisateurs avancés)</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_b87b76c9ef8812a91d85f30505ab1409 = new CMS_cache('b87b76c9ef8812a91d85f30505ab1409', 'polymod', 'auto', true);
if ($cache_b87b76c9ef8812a91d85f30505ab1409->exist()):
	//Get content from cache
	$cache_b87b76c9ef8812a91d85f30505ab1409_content = $cache_b87b76c9ef8812a91d85f30505ab1409->load();
else:
	$cache_b87b76c9ef8812a91d85f30505ab1409->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:15 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '37',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '38';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 58_f4a2d2
=======
	//SEARCH mediaresult TAG START 58_220f3e
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 58_d0cc4c
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_58_f4a2d2 = isset($public_search) ? $public_search : false;
=======
	$public_58_220f3e = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_58_d0cc4c = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_f4a2d2);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_220f3e);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_58_d0cc4c);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_59_3be669 = array (
=======
		$values_59_1bad05 = array (
>>>>>>> MERGE-SOURCE
=======
		$values_59_57f6f3 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_59_3be669['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_3be669['type'] == 'publication date after' || $values_59_3be669['type'] == 'publication date before') {
=======
		$values_59_1bad05['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_1bad05['type'] == 'publication date after' || $values_59_1bad05['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_59_57f6f3['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_59_57f6f3['type'] == 'publication date after' || $values_59_57f6f3['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_59_3be669['value']);
			$values_59_3be669['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_59_1bad05['value']);
			$values_59_1bad05['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_59_57f6f3['value']);
			$values_59_57f6f3['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_3be669)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_1bad05)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_59_57f6f3)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 60_67a89d
=======
	//RESULT mediaresult TAG START 60_163de4
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 60_6dc04b
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
		$object_60_67a89d = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_67a89d = $replace; //save previous replace vars if any
		$count_60_67a89d = 0;
		$content_60_67a89d = $content; //save previous content var if any
		$maxPages_60_67a89d = $search_mediaresult->getMaxPages();
		$maxResults_60_67a89d = $search_mediaresult->getNumRows();
=======
		$object_60_163de4 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_163de4 = $replace; //save previous replace vars if any
		$count_60_163de4 = 0;
		$content_60_163de4 = $content; //save previous content var if any
		$maxPages_60_163de4 = $search_mediaresult->getMaxPages();
		$maxResults_60_163de4 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_60_6dc04b = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_60_6dc04b = $replace; //save previous replace vars if any
		$count_60_6dc04b = 0;
		$content_60_6dc04b = $content; //save previous content var if any
		$maxPages_60_6dc04b = $search_mediaresult->getMaxPages();
		$maxResults_60_6dc04b = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_60_67a89d) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_67a89d == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_67a89d+1),
				"{maxpages}"    => $maxPages_60_67a89d,
=======
				"{firstresult}" => (!$count_60_163de4) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_163de4 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_163de4+1),
				"{maxpages}"    => $maxPages_60_163de4,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_60_6dc04b) ? 1 : 0,
				"{lastresult}" 	=> ($count_60_6dc04b == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_60_6dc04b+1),
				"{maxpages}"    => $maxPages_60_6dc04b,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_60_67a89d,
=======
				"{maxresults}"  => $maxResults_60_163de4,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_60_6dc04b,
				"{altclass}"    => (($count_60_6dc04b+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 61_305b08
=======
			//IF TAG START 61_435822
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 61_38ec3c
			$ifcondition_61_38ec3c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_61_38ec3c) {
				$func_61_38ec3c = create_function("","return (".$ifcondition_61_38ec3c.");");
				if ($func_61_38ec3c()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 62_d21d00
=======
					//IF TAG START 62_a2d94a
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 62_1a9e4c
					$ifcondition_62_1a9e4c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_62_1a9e4c) {
						$func_62_1a9e4c = create_function("","return (".$ifcondition_62_1a9e4c.");");
						if ($func_62_1a9e4c()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 62_d21d00
=======
					}//IF TAG END 62_a2d94a
>>>>>>> MERGE-SOURCE
=======
						unset($func_62_1a9e4c);
					}
					unset($ifcondition_62_1a9e4c);
					//IF TAG END 62_1a9e4c
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 63_6c7fdd
=======
					//IF TAG START 63_883c37
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 63_7fcfad
					$ifcondition_63_7fcfad = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_63_7fcfad) {
						$func_63_7fcfad = create_function("","return (".$ifcondition_63_7fcfad.");");
						if ($func_63_7fcfad()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 63_6c7fdd
=======
					}//IF TAG END 63_883c37
>>>>>>> MERGE-SOURCE
=======
						unset($func_63_7fcfad);
					}
					unset($ifcondition_63_7fcfad);
					//IF TAG END 63_7fcfad
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 61_305b08
			//IF TAG START 64_4f7b99
=======
			}//IF TAG END 61_435822
			//IF TAG START 64_a6ab2f
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 65_e407e3
=======
					//IF TAG START 65_0786fc
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
				unset($func_61_38ec3c);
			}
			unset($ifcondition_61_38ec3c);
			//IF TAG END 61_38ec3c
			//IF TAG START 64_21e8d8
			$ifcondition_64_21e8d8 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_64_21e8d8) {
				$func_64_21e8d8 = create_function("","return (".$ifcondition_64_21e8d8.");");
				if ($func_64_21e8d8()) {
					//IF TAG START 65_becbc9
					$ifcondition_65_becbc9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_65_becbc9) {
						$func_65_becbc9 = create_function("","return (".$ifcondition_65_becbc9.");");
						if ($func_65_becbc9()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 65_e407e3
					//IF TAG START 66_3543af
=======
					}//IF TAG END 65_0786fc
					//IF TAG START 66_819432
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_65_becbc9);
					}
					unset($ifcondition_65_becbc9);
					//IF TAG END 65_becbc9
					//IF TAG START 66_6f53e1
					$ifcondition_66_6f53e1 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_66_6f53e1) {
						$func_66_6f53e1 = create_function("","return (".$ifcondition_66_6f53e1.");");
						if ($func_66_6f53e1()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 66_3543af
=======
					}//IF TAG END 66_819432
>>>>>>> MERGE-SOURCE
=======
						unset($func_66_6f53e1);
					}
					unset($ifcondition_66_6f53e1);
					//IF TAG END 66_6f53e1
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 64_4f7b99
			//IF TAG START 67_c0ab01
=======
			}//IF TAG END 64_a6ab2f
			//IF TAG START 67_f8f9b1
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_64_21e8d8);
			}
			unset($ifcondition_64_21e8d8);
			//IF TAG END 64_21e8d8
			//IF TAG START 67_45f4fe
			$ifcondition_67_45f4fe = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_67_45f4fe) {
				$func_67_45f4fe = create_function("","return (".$ifcondition_67_45f4fe.");");
				if ($func_67_45f4fe()) {
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
					//IF TAG START 68_b83344
=======
					//IF TAG START 68_279788
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 68_4e25ed
					$ifcondition_68_4e25ed = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_68_4e25ed) {
						$func_68_4e25ed = create_function("","return (".$ifcondition_68_4e25ed.");");
						if ($func_68_4e25ed()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 68_b83344
=======
					}//IF TAG END 68_279788
>>>>>>> MERGE-SOURCE
=======
						unset($func_68_4e25ed);
					}
					unset($ifcondition_68_4e25ed);
					//IF TAG END 68_4e25ed
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 67_c0ab01
			//IF TAG START 69_e14f02
=======
			}//IF TAG END 67_f8f9b1
			//IF TAG START 69_c258ce
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_67_45f4fe);
			}
			unset($ifcondition_67_45f4fe);
			//IF TAG END 67_45f4fe
			//IF TAG START 69_9aa1e9
			$ifcondition_69_9aa1e9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_69_9aa1e9) {
				$func_69_9aa1e9 = create_function("","return (".$ifcondition_69_9aa1e9.");");
				if ($func_69_9aa1e9()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 70_d30afc
=======
					//IF TAG START 70_9a227c
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 70_de6af0
					$ifcondition_70_de6af0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_70_de6af0) {
						$func_70_de6af0 = create_function("","return (".$ifcondition_70_de6af0.");");
						if ($func_70_de6af0()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 70_d30afc
					//IF TAG START 71_04f33c
=======
					}//IF TAG END 70_9a227c
					//IF TAG START 71_c87f5f
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_70_de6af0);
					}
					unset($ifcondition_70_de6af0);
					//IF TAG END 70_de6af0
					//IF TAG START 71_474e8d
					$ifcondition_71_474e8d = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_71_474e8d) {
						$func_71_474e8d = create_function("","return (".$ifcondition_71_474e8d.");");
						if ($func_71_474e8d()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 71_04f33c
=======
					}//IF TAG END 71_c87f5f
>>>>>>> MERGE-SOURCE
=======
						unset($func_71_474e8d);
					}
					unset($ifcondition_71_474e8d);
					//IF TAG END 71_474e8d
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 69_e14f02
			$count_60_67a89d++;
=======
			}//IF TAG END 69_c258ce
			$count_60_163de4++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_69_9aa1e9);
			}
			unset($ifcondition_69_9aa1e9);
			//IF TAG END 69_9aa1e9
			$count_60_6dc04b++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_60_67a89d.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_60_163de4.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_60_6dc04b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_60_67a89d; //retrieve previous content var if any
		$replace = $replace_60_67a89d; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_60_67a89d; //retrieve previous object search if any
=======
		$content = $content_60_163de4; //retrieve previous content var if any
		$replace = $replace_60_163de4; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_60_163de4; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_60_6dc04b; //retrieve previous content var if any
		unset($content_60_6dc04b);
		$replace = $replace_60_6dc04b; //retrieve previous replace vars if any
		unset($replace_60_6dc04b);
		$object[$objectDefinition_mediaresult] = $object_60_6dc04b; //retrieve previous object search if any
		unset($object_60_6dc04b);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 60_67a89d
=======
	//RESULT mediaresult TAG END 60_163de4
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 60_6dc04b
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 58_f4a2d2
=======
	//SEARCH mediaresult TAG END 58_220f3e
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
	//SEARCH mediaresult TAG END 58_d0cc4c
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
	<?php $cache_b87b76c9ef8812a91d85f30505ab1409_content = $cache_b87b76c9ef8812a91d85f30505ab1409->endSave();
endif;
unset($cache_b87b76c9ef8812a91d85f30505ab1409);
echo $cache_b87b76c9ef8812a91d85f30505ab1409_content;
unset($cache_b87b76c9ef8812a91d85f30505ab1409_content);
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><p>Cette aide vous apporte <strong>l'ensemble des points essentiels pour la d&eacute;finition de vos propres rang&eacute;es de contenu.</strong></p> <p>Elle d&eacute;taille les tags XML et les variables pouvant &ecirc;tre utilis&eacute;es ainsi que leurs fonctions.</p> <p>L'insertion des modules dans vos rang&eacute;es est document&eacute;e de la m&ecirc;me mani&egrave;re.</p> <h3>Cr&eacute;er ses propres rang&eacute;es de contenu devient extr&ecirc;mement simple !</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Moteur de recherche interne</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?>
	<div class="imgLeft">
		<?php $cache_7cc114b81d09f58532d9e9c5356aefe9 = new CMS_cache('7cc114b81d09f58532d9e9c5356aefe9', 'polymod', 'auto', true);
if ($cache_7cc114b81d09f58532d9e9c5356aefe9->exist()):
	//Get content from cache
	$cache_7cc114b81d09f58532d9e9c5356aefe9_content = $cache_7cc114b81d09f58532d9e9c5356aefe9->load();
else:
	$cache_7cc114b81d09f58532d9e9c5356aefe9->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 17:00:15 +0200 by Automne (TM) 4.0.2 */
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
				'item' => '39',
			),
		),
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '38';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 72_f54b41
=======
	//SEARCH mediaresult TAG START 72_2fe1e5
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 72_5ddf3c
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_72_f54b41 = isset($public_search) ? $public_search : false;
=======
	$public_72_2fe1e5 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_72_5ddf3c = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_f54b41);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_2fe1e5);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_72_5ddf3c);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_73_2e789d = array (
=======
		$values_73_a6ccdc = array (
>>>>>>> MERGE-SOURCE
=======
		$values_73_260595 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_73_2e789d['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_2e789d['type'] == 'publication date after' || $values_73_2e789d['type'] == 'publication date before') {
=======
		$values_73_a6ccdc['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_a6ccdc['type'] == 'publication date after' || $values_73_a6ccdc['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_73_260595['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_73_260595['type'] == 'publication date after' || $values_73_260595['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_73_2e789d['value']);
			$values_73_2e789d['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_73_a6ccdc['value']);
			$values_73_a6ccdc['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_73_260595['value']);
			$values_73_260595['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_2e789d)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_a6ccdc)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_73_260595)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 74_a3d223
=======
	//RESULT mediaresult TAG START 74_5de158
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 74_de87aa
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
		$object_74_a3d223 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_a3d223 = $replace; //save previous replace vars if any
		$count_74_a3d223 = 0;
		$content_74_a3d223 = $content; //save previous content var if any
		$maxPages_74_a3d223 = $search_mediaresult->getMaxPages();
		$maxResults_74_a3d223 = $search_mediaresult->getNumRows();
=======
		$object_74_5de158 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_5de158 = $replace; //save previous replace vars if any
		$count_74_5de158 = 0;
		$content_74_5de158 = $content; //save previous content var if any
		$maxPages_74_5de158 = $search_mediaresult->getMaxPages();
		$maxResults_74_5de158 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_74_de87aa = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_74_de87aa = $replace; //save previous replace vars if any
		$count_74_de87aa = 0;
		$content_74_de87aa = $content; //save previous content var if any
		$maxPages_74_de87aa = $search_mediaresult->getMaxPages();
		$maxResults_74_de87aa = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_74_a3d223) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_a3d223 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_a3d223+1),
				"{maxpages}"    => $maxPages_74_a3d223,
=======
				"{firstresult}" => (!$count_74_5de158) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_5de158 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_5de158+1),
				"{maxpages}"    => $maxPages_74_5de158,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_74_de87aa) ? 1 : 0,
				"{lastresult}" 	=> ($count_74_de87aa == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_74_de87aa+1),
				"{maxpages}"    => $maxPages_74_de87aa,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_74_a3d223,
=======
				"{maxresults}"  => $maxResults_74_5de158,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_74_de87aa,
				"{altclass}"    => (($count_74_de87aa+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 75_7dcdc4
=======
			//IF TAG START 75_2731f0
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 75_f06515
			$ifcondition_75_f06515 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_75_f06515) {
				$func_75_f06515 = create_function("","return (".$ifcondition_75_f06515.");");
				if ($func_75_f06515()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 76_16df6e
=======
					//IF TAG START 76_89a376
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 76_79804c
					$ifcondition_76_79804c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_76_79804c) {
						$func_76_79804c = create_function("","return (".$ifcondition_76_79804c.");");
						if ($func_76_79804c()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 76_16df6e
=======
					}//IF TAG END 76_89a376
>>>>>>> MERGE-SOURCE
=======
						unset($func_76_79804c);
					}
					unset($ifcondition_76_79804c);
					//IF TAG END 76_79804c
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 77_013f6e
=======
					//IF TAG START 77_80f8f4
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 77_e564f5
					$ifcondition_77_e564f5 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_77_e564f5) {
						$func_77_e564f5 = create_function("","return (".$ifcondition_77_e564f5.");");
						if ($func_77_e564f5()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 77_013f6e
=======
					}//IF TAG END 77_80f8f4
>>>>>>> MERGE-SOURCE
=======
						unset($func_77_e564f5);
					}
					unset($ifcondition_77_e564f5);
					//IF TAG END 77_e564f5
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 75_7dcdc4
			//IF TAG START 78_170fd3
=======
			}//IF TAG END 75_2731f0
			//IF TAG START 78_7b03ba
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 79_6a6b77
=======
					//IF TAG START 79_c61f2f
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
				unset($func_75_f06515);
			}
			unset($ifcondition_75_f06515);
			//IF TAG END 75_f06515
			//IF TAG START 78_62d83d
			$ifcondition_78_62d83d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_78_62d83d) {
				$func_78_62d83d = create_function("","return (".$ifcondition_78_62d83d.");");
				if ($func_78_62d83d()) {
					//IF TAG START 79_e9b831
					$ifcondition_79_e9b831 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_79_e9b831) {
						$func_79_e9b831 = create_function("","return (".$ifcondition_79_e9b831.");");
						if ($func_79_e9b831()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 79_6a6b77
					//IF TAG START 80_3dcd1a
=======
					}//IF TAG END 79_c61f2f
					//IF TAG START 80_e16863
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_79_e9b831);
					}
					unset($ifcondition_79_e9b831);
					//IF TAG END 79_e9b831
					//IF TAG START 80_482ab2
					$ifcondition_80_482ab2 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_80_482ab2) {
						$func_80_482ab2 = create_function("","return (".$ifcondition_80_482ab2.");");
						if ($func_80_482ab2()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 80_3dcd1a
=======
					}//IF TAG END 80_e16863
>>>>>>> MERGE-SOURCE
=======
						unset($func_80_482ab2);
					}
					unset($ifcondition_80_482ab2);
					//IF TAG END 80_482ab2
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 78_170fd3
			//IF TAG START 81_7435b3
=======
			}//IF TAG END 78_7b03ba
			//IF TAG START 81_98d5c9
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_78_62d83d);
			}
			unset($ifcondition_78_62d83d);
			//IF TAG END 78_62d83d
			//IF TAG START 81_bda97f
			$ifcondition_81_bda97f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_81_bda97f) {
				$func_81_bda97f = create_function("","return (".$ifcondition_81_bda97f.");");
				if ($func_81_bda97f()) {
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
					//IF TAG START 82_97aed0
=======
					//IF TAG START 82_58d430
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 82_36a65c
					$ifcondition_82_36a65c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_82_36a65c) {
						$func_82_36a65c = create_function("","return (".$ifcondition_82_36a65c.");");
						if ($func_82_36a65c()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 82_97aed0
=======
					}//IF TAG END 82_58d430
>>>>>>> MERGE-SOURCE
=======
						unset($func_82_36a65c);
					}
					unset($ifcondition_82_36a65c);
					//IF TAG END 82_36a65c
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 81_7435b3
			//IF TAG START 83_9cd21c
=======
			}//IF TAG END 81_98d5c9
			//IF TAG START 83_287abe
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_81_bda97f);
			}
			unset($ifcondition_81_bda97f);
			//IF TAG END 81_bda97f
			//IF TAG START 83_505a46
			$ifcondition_83_505a46 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_83_505a46) {
				$func_83_505a46 = create_function("","return (".$ifcondition_83_505a46.");");
				if ($func_83_505a46()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 84_6df9c7
=======
					//IF TAG START 84_fa9238
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 84_8cd1b7
					$ifcondition_84_8cd1b7 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_84_8cd1b7) {
						$func_84_8cd1b7 = create_function("","return (".$ifcondition_84_8cd1b7.");");
						if ($func_84_8cd1b7()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 84_6df9c7
					//IF TAG START 85_54bef0
=======
					}//IF TAG END 84_fa9238
					//IF TAG START 85_4998db
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_84_8cd1b7);
					}
					unset($ifcondition_84_8cd1b7);
					//IF TAG END 84_8cd1b7
					//IF TAG START 85_ede65d
					$ifcondition_85_ede65d = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_85_ede65d) {
						$func_85_ede65d = create_function("","return (".$ifcondition_85_ede65d.");");
						if ($func_85_ede65d()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 85_54bef0
=======
					}//IF TAG END 85_4998db
>>>>>>> MERGE-SOURCE
=======
						unset($func_85_ede65d);
					}
					unset($ifcondition_85_ede65d);
					//IF TAG END 85_ede65d
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 83_9cd21c
			$count_74_a3d223++;
=======
			}//IF TAG END 83_287abe
			$count_74_5de158++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_83_505a46);
			}
			unset($ifcondition_83_505a46);
			//IF TAG END 83_505a46
			$count_74_de87aa++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_74_a3d223.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_74_5de158.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_74_de87aa.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_74_a3d223; //retrieve previous content var if any
		$replace = $replace_74_a3d223; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_74_a3d223; //retrieve previous object search if any
=======
		$content = $content_74_5de158; //retrieve previous content var if any
		$replace = $replace_74_5de158; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_74_5de158; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_74_de87aa; //retrieve previous content var if any
		unset($content_74_de87aa);
		$replace = $replace_74_de87aa; //retrieve previous replace vars if any
		unset($replace_74_de87aa);
		$object[$objectDefinition_mediaresult] = $object_74_de87aa; //retrieve previous object search if any
		unset($object_74_de87aa);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 74_a3d223
=======
	//RESULT mediaresult TAG END 74_5de158
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 74_de87aa
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 72_f54b41
=======
	//SEARCH mediaresult TAG END 72_2fe1e5
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
	//SEARCH mediaresult TAG END 72_5ddf3c
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
	<?php $cache_7cc114b81d09f58532d9e9c5356aefe9_content = $cache_7cc114b81d09f58532d9e9c5356aefe9->endSave();
endif;
unset($cache_7cc114b81d09f58532d9e9c5356aefe9);
echo $cache_7cc114b81d09f58532d9e9c5356aefe9_content;
unset($cache_7cc114b81d09f58532d9e9c5356aefe9_content);
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><p>Enfin, si vous cherchez comment modifier tel contenu ou &eacute;l&eacute;ment g&eacute;r&eacute; par Automne 4et que vous ne savez pas comment l'atteindre dans l'interface d'administration, <strong>un puissant moteur de recherche</strong> <strong>vous permet de rechercher sur l'ensemble des contenus et des &eacute;l&eacute;ments, </strong>quel que soit leurs type : Contenu des pages, contenu des modules, utilisateurs, mod&egrave;les de pages et de rang&eacute;es, etc.</p> <h3>Les r&eacute;sultats fournis par ce moteur s'adapteront m&ecirc;me au niveau de droit de l'utilisateur pour ne lui proposer que les &eacute;l&eacute;ments sur lesquels il peut agir.</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
<<<<<<< TREE
				Page  "Aide utilisateurs" (http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php)
=======
				Page  "Aide utilisateurs" (http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php)
>>>>>>> MERGE-SOURCE
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>