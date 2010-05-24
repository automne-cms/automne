<?php //Generated on Mon, 24 May 2010 17:00:15 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Aide aux utilisateurs</title>
	<?php echo CMS_view::getCSS(array('/css/reset.css','/css/demo/common.css','/css/demo/interieur.css','/css/modules/pmedia.css'), 'all');  ?>

	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/demo/ie6.css" media="all" />
	<![endif]-->
	<?php echo CMS_view::getCSS(array('/css/demo/print.css'), 'print');  ?>

	<?php echo CMS_view::getJavascript(array('','/js/CMS_functions.js','/js/modules/pmedia/jquery-1.2.6.min-demo.js','/js/modules/pmedia/pmedia-demo.js','/js/modules/pmedia/swfobject.js'));  ?>

	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
						
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
				</div>
				<div id="content" class="page38">
					<div id="breadcrumbs">
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a> &gt; 
					</div>
					<div id="title">
						<h1>Aide aux utilisateurs</h1>
					</div>
					<?php /* Start clientspace [first] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><p>Les utilisateurs d'Automne 4 peuvent parfois &ecirc;tre confront&eacute;s &agrave; des questions sur l'utilisation de l'outil. &quot;<em>Que ce passe t'il si je clique sur ce bouton ?</em>&quot; &quot;<em>comment dois je r&eacute;aliser telle modification ?</em>&quot;.</p> <h3>Pour r&eacute;pondre &agrave; ces questions courantes, nous avons mis en place un&nbsp; NOUVEAU syst&egrave;me d'aide complet int&eacute;gr&eacute; &agrave; toutes les interfaces d'administration :</h3></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Aide contextuelle</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?>
	<div class="imgLeft">
		<?php $cache_48ca6d1b8ec9cbfea71dc643cd890ffa = new CMS_cache('48ca6d1b8ec9cbfea71dc643cd890ffa', 'polymod', 'auto', true);
if ($cache_48ca6d1b8ec9cbfea71dc643cd890ffa->exist()):
	//Get content from cache
	$cache_48ca6d1b8ec9cbfea71dc643cd890ffa_content = $cache_48ca6d1b8ec9cbfea71dc643cd890ffa->load();
else:
	$cache_48ca6d1b8ec9cbfea71dc643cd890ffa->start();
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
	//SEARCH mediaresult TAG START 2_f7661c
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_2_f7661c = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_f7661c);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_3_fe7be6 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_3_fe7be6['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_fe7be6['type'] == 'publication date after' || $values_3_fe7be6['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_3_fe7be6['value']);
			$values_3_fe7be6['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_fe7be6)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 4_fb4c1e
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
		$object_4_fb4c1e = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_fb4c1e = $replace; //save previous replace vars if any
		$count_4_fb4c1e = 0;
		$content_4_fb4c1e = $content; //save previous content var if any
		$maxPages_4_fb4c1e = $search_mediaresult->getMaxPages();
		$maxResults_4_fb4c1e = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_4_fb4c1e) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_fb4c1e == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_fb4c1e+1),
				"{maxpages}"    => $maxPages_4_fb4c1e,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_4_fb4c1e,
				"{altclass}"    => (($count_4_fb4c1e+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 5_ce044f
			$ifcondition_5_ce044f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_5_ce044f) {
				$func_5_ce044f = create_function("","return (".$ifcondition_5_ce044f.");");
				if ($func_5_ce044f()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 6_e427ca
					$ifcondition_6_e427ca = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_6_e427ca) {
						$func_6_e427ca = create_function("","return (".$ifcondition_6_e427ca.");");
						if ($func_6_e427ca()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_6_e427ca);
					}
					unset($ifcondition_6_e427ca);
					//IF TAG END 6_e427ca
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 7_a07ae2
					$ifcondition_7_a07ae2 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_7_a07ae2) {
						$func_7_a07ae2 = create_function("","return (".$ifcondition_7_a07ae2.");");
						if ($func_7_a07ae2()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_7_a07ae2);
					}
					unset($ifcondition_7_a07ae2);
					//IF TAG END 7_a07ae2
				}
				unset($func_5_ce044f);
			}
			unset($ifcondition_5_ce044f);
			//IF TAG END 5_ce044f
			//IF TAG START 8_2b1d3b
			$ifcondition_8_2b1d3b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_8_2b1d3b) {
				$func_8_2b1d3b = create_function("","return (".$ifcondition_8_2b1d3b.");");
				if ($func_8_2b1d3b()) {
					//IF TAG START 9_988458
					$ifcondition_9_988458 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_9_988458) {
						$func_9_988458 = create_function("","return (".$ifcondition_9_988458.");");
						if ($func_9_988458()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_9_988458);
					}
					unset($ifcondition_9_988458);
					//IF TAG END 9_988458
					//IF TAG START 10_9763e5
					$ifcondition_10_9763e5 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_10_9763e5) {
						$func_10_9763e5 = create_function("","return (".$ifcondition_10_9763e5.");");
						if ($func_10_9763e5()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_10_9763e5);
					}
					unset($ifcondition_10_9763e5);
					//IF TAG END 10_9763e5
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_8_2b1d3b);
			}
			unset($ifcondition_8_2b1d3b);
			//IF TAG END 8_2b1d3b
			//IF TAG START 11_b8f025
			$ifcondition_11_b8f025 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_11_b8f025) {
				$func_11_b8f025 = create_function("","return (".$ifcondition_11_b8f025.");");
				if ($func_11_b8f025()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 12_b225ec
					$ifcondition_12_b225ec = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_12_b225ec) {
						$func_12_b225ec = create_function("","return (".$ifcondition_12_b225ec.");");
						if ($func_12_b225ec()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_12_b225ec);
					}
					unset($ifcondition_12_b225ec);
					//IF TAG END 12_b225ec
				}
				unset($func_11_b8f025);
			}
			unset($ifcondition_11_b8f025);
			//IF TAG END 11_b8f025
			//IF TAG START 13_0f61e8
			$ifcondition_13_0f61e8 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_13_0f61e8) {
				$func_13_0f61e8 = create_function("","return (".$ifcondition_13_0f61e8.");");
				if ($func_13_0f61e8()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 14_4de96f
					$ifcondition_14_4de96f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_14_4de96f) {
						$func_14_4de96f = create_function("","return (".$ifcondition_14_4de96f.");");
						if ($func_14_4de96f()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_14_4de96f);
					}
					unset($ifcondition_14_4de96f);
					//IF TAG END 14_4de96f
					//IF TAG START 15_3266e6
					$ifcondition_15_3266e6 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_15_3266e6) {
						$func_15_3266e6 = create_function("","return (".$ifcondition_15_3266e6.");");
						if ($func_15_3266e6()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_15_3266e6);
					}
					unset($ifcondition_15_3266e6);
					//IF TAG END 15_3266e6
					$content .="
					</div>
					";
				}
				unset($func_13_0f61e8);
			}
			unset($ifcondition_13_0f61e8);
			//IF TAG END 13_0f61e8
			$count_4_fb4c1e++;
			//do all result vars replacement
			$content_4_fb4c1e.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_4_fb4c1e; //retrieve previous content var if any
		unset($content_4_fb4c1e);
		$replace = $replace_4_fb4c1e; //retrieve previous replace vars if any
		unset($replace_4_fb4c1e);
		$object[$objectDefinition_mediaresult] = $object_4_fb4c1e; //retrieve previous object search if any
		unset($object_4_fb4c1e);
	}
	//RESULT mediaresult TAG END 4_fb4c1e
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 2_f7661c
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
	<?php $cache_48ca6d1b8ec9cbfea71dc643cd890ffa_content = $cache_48ca6d1b8ec9cbfea71dc643cd890ffa->endSave();
endif;
unset($cache_48ca6d1b8ec9cbfea71dc643cd890ffa);
echo $cache_48ca6d1b8ec9cbfea71dc643cd890ffa_content;
unset($cache_48ca6d1b8ec9cbfea71dc643cd890ffa_content);
   ?>

	</div>
	
		<div class="text"><p>L'aide contextuelle vous permet d<strong>'obtenir des informations</strong> sur les &eacute;l&eacute;ments que vous pointez avec votre curseur.</p> <h3>PLUS aucun bouton n'aura de secret pour vous !</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>L&#039;aide à la syntaxe XML (pour les utilisateurs avancés)</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_34fe05b6cae1a5e871258ef7bd5cfb83 = new CMS_cache('34fe05b6cae1a5e871258ef7bd5cfb83', 'polymod', 'auto', true);
if ($cache_34fe05b6cae1a5e871258ef7bd5cfb83->exist()):
	//Get content from cache
	$cache_34fe05b6cae1a5e871258ef7bd5cfb83_content = $cache_34fe05b6cae1a5e871258ef7bd5cfb83->load();
else:
	$cache_34fe05b6cae1a5e871258ef7bd5cfb83->start();
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
	//SEARCH mediaresult TAG START 16_e97c35
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_16_e97c35 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_e97c35);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_17_d825de = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_17_d825de['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_d825de['type'] == 'publication date after' || $values_17_d825de['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_17_d825de['value']);
			$values_17_d825de['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_d825de)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 18_9e3727
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
		$object_18_9e3727 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_9e3727 = $replace; //save previous replace vars if any
		$count_18_9e3727 = 0;
		$content_18_9e3727 = $content; //save previous content var if any
		$maxPages_18_9e3727 = $search_mediaresult->getMaxPages();
		$maxResults_18_9e3727 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_18_9e3727) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_9e3727 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_9e3727+1),
				"{maxpages}"    => $maxPages_18_9e3727,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_18_9e3727,
				"{altclass}"    => (($count_18_9e3727+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 19_a036a2
			$ifcondition_19_a036a2 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_19_a036a2) {
				$func_19_a036a2 = create_function("","return (".$ifcondition_19_a036a2.");");
				if ($func_19_a036a2()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 20_be7722
					$ifcondition_20_be7722 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_20_be7722) {
						$func_20_be7722 = create_function("","return (".$ifcondition_20_be7722.");");
						if ($func_20_be7722()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_20_be7722);
					}
					unset($ifcondition_20_be7722);
					//IF TAG END 20_be7722
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 21_f6cbde
					$ifcondition_21_f6cbde = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_21_f6cbde) {
						$func_21_f6cbde = create_function("","return (".$ifcondition_21_f6cbde.");");
						if ($func_21_f6cbde()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_21_f6cbde);
					}
					unset($ifcondition_21_f6cbde);
					//IF TAG END 21_f6cbde
				}
				unset($func_19_a036a2);
			}
			unset($ifcondition_19_a036a2);
			//IF TAG END 19_a036a2
			//IF TAG START 22_7e4939
			$ifcondition_22_7e4939 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_22_7e4939) {
				$func_22_7e4939 = create_function("","return (".$ifcondition_22_7e4939.");");
				if ($func_22_7e4939()) {
					//IF TAG START 23_b67578
					$ifcondition_23_b67578 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_23_b67578) {
						$func_23_b67578 = create_function("","return (".$ifcondition_23_b67578.");");
						if ($func_23_b67578()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_23_b67578);
					}
					unset($ifcondition_23_b67578);
					//IF TAG END 23_b67578
					//IF TAG START 24_40bcae
					$ifcondition_24_40bcae = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_24_40bcae) {
						$func_24_40bcae = create_function("","return (".$ifcondition_24_40bcae.");");
						if ($func_24_40bcae()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_24_40bcae);
					}
					unset($ifcondition_24_40bcae);
					//IF TAG END 24_40bcae
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_22_7e4939);
			}
			unset($ifcondition_22_7e4939);
			//IF TAG END 22_7e4939
			//IF TAG START 25_c1b3c0
			$ifcondition_25_c1b3c0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_25_c1b3c0) {
				$func_25_c1b3c0 = create_function("","return (".$ifcondition_25_c1b3c0.");");
				if ($func_25_c1b3c0()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 26_8ebe60
					$ifcondition_26_8ebe60 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_26_8ebe60) {
						$func_26_8ebe60 = create_function("","return (".$ifcondition_26_8ebe60.");");
						if ($func_26_8ebe60()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_26_8ebe60);
					}
					unset($ifcondition_26_8ebe60);
					//IF TAG END 26_8ebe60
				}
				unset($func_25_c1b3c0);
			}
			unset($ifcondition_25_c1b3c0);
			//IF TAG END 25_c1b3c0
			//IF TAG START 27_624099
			$ifcondition_27_624099 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_27_624099) {
				$func_27_624099 = create_function("","return (".$ifcondition_27_624099.");");
				if ($func_27_624099()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 28_aa4b0d
					$ifcondition_28_aa4b0d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_28_aa4b0d) {
						$func_28_aa4b0d = create_function("","return (".$ifcondition_28_aa4b0d.");");
						if ($func_28_aa4b0d()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_28_aa4b0d);
					}
					unset($ifcondition_28_aa4b0d);
					//IF TAG END 28_aa4b0d
					//IF TAG START 29_0a6227
					$ifcondition_29_0a6227 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_29_0a6227) {
						$func_29_0a6227 = create_function("","return (".$ifcondition_29_0a6227.");");
						if ($func_29_0a6227()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_29_0a6227);
					}
					unset($ifcondition_29_0a6227);
					//IF TAG END 29_0a6227
					$content .="
					</div>
					";
				}
				unset($func_27_624099);
			}
			unset($ifcondition_27_624099);
			//IF TAG END 27_624099
			$count_18_9e3727++;
			//do all result vars replacement
			$content_18_9e3727.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_18_9e3727; //retrieve previous content var if any
		unset($content_18_9e3727);
		$replace = $replace_18_9e3727; //retrieve previous replace vars if any
		unset($replace_18_9e3727);
		$object[$objectDefinition_mediaresult] = $object_18_9e3727; //retrieve previous object search if any
		unset($object_18_9e3727);
	}
	//RESULT mediaresult TAG END 18_9e3727
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 16_e97c35
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
	<?php $cache_34fe05b6cae1a5e871258ef7bd5cfb83_content = $cache_34fe05b6cae1a5e871258ef7bd5cfb83->endSave();
endif;
unset($cache_34fe05b6cae1a5e871258ef7bd5cfb83);
echo $cache_34fe05b6cae1a5e871258ef7bd5cfb83_content;
unset($cache_34fe05b6cae1a5e871258ef7bd5cfb83_content);
   ?>

	</div>
	
		<div class="text"><p>Cette aide vous apporte <strong>l'ensemble des points essentiels pour la d&eacute;finition de vos propres rang&eacute;es de contenu.</strong></p> <p>Elle d&eacute;taille les tags XML et les variables pouvant &ecirc;tre utilis&eacute;es ainsi que leurs fonctions.</p> <p>L'insertion des modules dans vos rang&eacute;es est document&eacute;e de la m&ecirc;me mani&egrave;re.</p> <h3>Cr&eacute;er ses propres rang&eacute;es de contenu devient extr&ecirc;mement simple !</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Moteur de recherche interne</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?>
	<div class="imgLeft">
		<?php $cache_95d28e26a208033dc9d74ca45ee697f9 = new CMS_cache('95d28e26a208033dc9d74ca45ee697f9', 'polymod', 'auto', true);
if ($cache_95d28e26a208033dc9d74ca45ee697f9->exist()):
	//Get content from cache
	$cache_95d28e26a208033dc9d74ca45ee697f9_content = $cache_95d28e26a208033dc9d74ca45ee697f9->load();
else:
	$cache_95d28e26a208033dc9d74ca45ee697f9->start();
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
	//SEARCH mediaresult TAG START 30_8c82d7
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_30_8c82d7 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_30_8c82d7);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_31_e4bfde = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_31_e4bfde['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_31_e4bfde['type'] == 'publication date after' || $values_31_e4bfde['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_31_e4bfde['value']);
			$values_31_e4bfde['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_31_e4bfde)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 32_bb1bc3
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
		$object_32_bb1bc3 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_32_bb1bc3 = $replace; //save previous replace vars if any
		$count_32_bb1bc3 = 0;
		$content_32_bb1bc3 = $content; //save previous content var if any
		$maxPages_32_bb1bc3 = $search_mediaresult->getMaxPages();
		$maxResults_32_bb1bc3 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_32_bb1bc3) ? 1 : 0,
				"{lastresult}" 	=> ($count_32_bb1bc3 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_32_bb1bc3+1),
				"{maxpages}"    => $maxPages_32_bb1bc3,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_32_bb1bc3,
				"{altclass}"    => (($count_32_bb1bc3+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 33_5c792f
			$ifcondition_33_5c792f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_33_5c792f) {
				$func_33_5c792f = create_function("","return (".$ifcondition_33_5c792f.");");
				if ($func_33_5c792f()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 34_8fcaa2
					$ifcondition_34_8fcaa2 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_34_8fcaa2) {
						$func_34_8fcaa2 = create_function("","return (".$ifcondition_34_8fcaa2.");");
						if ($func_34_8fcaa2()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_34_8fcaa2);
					}
					unset($ifcondition_34_8fcaa2);
					//IF TAG END 34_8fcaa2
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 35_0d93c8
					$ifcondition_35_0d93c8 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_35_0d93c8) {
						$func_35_0d93c8 = create_function("","return (".$ifcondition_35_0d93c8.");");
						if ($func_35_0d93c8()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_35_0d93c8);
					}
					unset($ifcondition_35_0d93c8);
					//IF TAG END 35_0d93c8
				}
				unset($func_33_5c792f);
			}
			unset($ifcondition_33_5c792f);
			//IF TAG END 33_5c792f
			//IF TAG START 36_d414c6
			$ifcondition_36_d414c6 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_36_d414c6) {
				$func_36_d414c6 = create_function("","return (".$ifcondition_36_d414c6.");");
				if ($func_36_d414c6()) {
					//IF TAG START 37_50db0a
					$ifcondition_37_50db0a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_37_50db0a) {
						$func_37_50db0a = create_function("","return (".$ifcondition_37_50db0a.");");
						if ($func_37_50db0a()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_37_50db0a);
					}
					unset($ifcondition_37_50db0a);
					//IF TAG END 37_50db0a
					//IF TAG START 38_b23b13
					$ifcondition_38_b23b13 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_38_b23b13) {
						$func_38_b23b13 = create_function("","return (".$ifcondition_38_b23b13.");");
						if ($func_38_b23b13()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_38_b23b13);
					}
					unset($ifcondition_38_b23b13);
					//IF TAG END 38_b23b13
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_36_d414c6);
			}
			unset($ifcondition_36_d414c6);
			//IF TAG END 36_d414c6
			//IF TAG START 39_262ac2
			$ifcondition_39_262ac2 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_39_262ac2) {
				$func_39_262ac2 = create_function("","return (".$ifcondition_39_262ac2.");");
				if ($func_39_262ac2()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 40_c9e5f4
					$ifcondition_40_c9e5f4 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_40_c9e5f4) {
						$func_40_c9e5f4 = create_function("","return (".$ifcondition_40_c9e5f4.");");
						if ($func_40_c9e5f4()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_40_c9e5f4);
					}
					unset($ifcondition_40_c9e5f4);
					//IF TAG END 40_c9e5f4
				}
				unset($func_39_262ac2);
			}
			unset($ifcondition_39_262ac2);
			//IF TAG END 39_262ac2
			//IF TAG START 41_fcb868
			$ifcondition_41_fcb868 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_41_fcb868) {
				$func_41_fcb868 = create_function("","return (".$ifcondition_41_fcb868.");");
				if ($func_41_fcb868()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 42_353297
					$ifcondition_42_353297 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_42_353297) {
						$func_42_353297 = create_function("","return (".$ifcondition_42_353297.");");
						if ($func_42_353297()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_42_353297);
					}
					unset($ifcondition_42_353297);
					//IF TAG END 42_353297
					//IF TAG START 43_e720b8
					$ifcondition_43_e720b8 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_43_e720b8) {
						$func_43_e720b8 = create_function("","return (".$ifcondition_43_e720b8.");");
						if ($func_43_e720b8()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_43_e720b8);
					}
					unset($ifcondition_43_e720b8);
					//IF TAG END 43_e720b8
					$content .="
					</div>
					";
				}
				unset($func_41_fcb868);
			}
			unset($ifcondition_41_fcb868);
			//IF TAG END 41_fcb868
			$count_32_bb1bc3++;
			//do all result vars replacement
			$content_32_bb1bc3.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_32_bb1bc3; //retrieve previous content var if any
		unset($content_32_bb1bc3);
		$replace = $replace_32_bb1bc3; //retrieve previous replace vars if any
		unset($replace_32_bb1bc3);
		$object[$objectDefinition_mediaresult] = $object_32_bb1bc3; //retrieve previous object search if any
		unset($object_32_bb1bc3);
	}
	//RESULT mediaresult TAG END 32_bb1bc3
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 30_8c82d7
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
	<?php $cache_95d28e26a208033dc9d74ca45ee697f9_content = $cache_95d28e26a208033dc9d74ca45ee697f9->endSave();
endif;
unset($cache_95d28e26a208033dc9d74ca45ee697f9);
echo $cache_95d28e26a208033dc9d74ca45ee697f9_content;
unset($cache_95d28e26a208033dc9d74ca45ee697f9_content);
   ?>

	</div>
	
		<div class="text"><p>Enfin, si vous cherchez comment modifier tel contenu ou &eacute;l&eacute;ment g&eacute;r&eacute; par Automne 4et que vous ne savez pas comment l'atteindre dans l'interface d'administration, <strong>un puissant moteur de recherche</strong> <strong>vous permet de rechercher sur l'ensemble des contenus et des &eacute;l&eacute;ments, </strong>quel que soit leurs type : Contenu des pages, contenu des modules, utilisateurs, mod&egrave;les de pages et de rang&eacute;es, etc.</p> <h3>Les r&eacute;sultats fournis par ce moteur s'adapteront m&ecirc;me au niveau de droit de l'utilisateur pour ne lui proposer que les &eacute;l&eacute;ments sur lesquels il peut agir.</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [240 Texte et Média à Gauche - r70_240_Texte_et_Media_a_Gauche.xml] */   ?><?php /* End clientspace [first] */   ?>
					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
				<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>