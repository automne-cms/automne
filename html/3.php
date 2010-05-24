<?php //Generated on Mon, 24 May 2010 16:59:48 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/3-presentation.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Présentation</title>
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
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_open CMS_current"><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveautés</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pré-requis</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
				</div>
				<div id="content" class="page3">
					<div id="breadcrumbs">
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; 
					</div>
					<div id="title">
						<h1>Présentation</h1>
					</div>
					<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Bienvenue sur AUTOMNE 4 </h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_78bdfccbed02c43d004345dfb16c25f2 = new CMS_cache('78bdfccbed02c43d004345dfb16c25f2', 'polymod', 'auto', true);
if ($cache_78bdfccbed02c43d004345dfb16c25f2->exist()):
	//Get content from cache
	$cache_78bdfccbed02c43d004345dfb16c25f2_content = $cache_78bdfccbed02c43d004345dfb16c25f2->load();
else:
	$cache_78bdfccbed02c43d004345dfb16c25f2->start();
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
	//SEARCH mediaresult TAG START 2_39bbe9
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_2_39bbe9 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_39bbe9);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_3_ebab1e = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_3_ebab1e['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_ebab1e['type'] == 'publication date after' || $values_3_ebab1e['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_3_ebab1e['value']);
			$values_3_ebab1e['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_ebab1e)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 4_60fa55
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
		$object_4_60fa55 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_60fa55 = $replace; //save previous replace vars if any
		$count_4_60fa55 = 0;
		$content_4_60fa55 = $content; //save previous content var if any
		$maxPages_4_60fa55 = $search_mediaresult->getMaxPages();
		$maxResults_4_60fa55 = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_4_60fa55) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_60fa55 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_60fa55+1),
				"{maxpages}"    => $maxPages_4_60fa55,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_4_60fa55,
				"{altclass}"    => (($count_4_60fa55+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 5_bd0fa3
			$ifcondition_5_bd0fa3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_5_bd0fa3) {
				$func_5_bd0fa3 = create_function("","return (".$ifcondition_5_bd0fa3.");");
				if ($func_5_bd0fa3()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 6_f74197
					$ifcondition_6_f74197 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_6_f74197) {
						$func_6_f74197 = create_function("","return (".$ifcondition_6_f74197.");");
						if ($func_6_f74197()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_6_f74197);
					}
					unset($ifcondition_6_f74197);
					//IF TAG END 6_f74197
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 7_b6c337
					$ifcondition_7_b6c337 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_7_b6c337) {
						$func_7_b6c337 = create_function("","return (".$ifcondition_7_b6c337.");");
						if ($func_7_b6c337()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_7_b6c337);
					}
					unset($ifcondition_7_b6c337);
					//IF TAG END 7_b6c337
				}
				unset($func_5_bd0fa3);
			}
			unset($ifcondition_5_bd0fa3);
			//IF TAG END 5_bd0fa3
			//IF TAG START 8_33a9ee
			$ifcondition_8_33a9ee = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_8_33a9ee) {
				$func_8_33a9ee = create_function("","return (".$ifcondition_8_33a9ee.");");
				if ($func_8_33a9ee()) {
					//IF TAG START 9_af05be
					$ifcondition_9_af05be = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_9_af05be) {
						$func_9_af05be = create_function("","return (".$ifcondition_9_af05be.");");
						if ($func_9_af05be()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_9_af05be);
					}
					unset($ifcondition_9_af05be);
					//IF TAG END 9_af05be
					//IF TAG START 10_b5a50e
					$ifcondition_10_b5a50e = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_10_b5a50e) {
						$func_10_b5a50e = create_function("","return (".$ifcondition_10_b5a50e.");");
						if ($func_10_b5a50e()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_10_b5a50e);
					}
					unset($ifcondition_10_b5a50e);
					//IF TAG END 10_b5a50e
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_8_33a9ee);
			}
			unset($ifcondition_8_33a9ee);
			//IF TAG END 8_33a9ee
			//IF TAG START 11_223ee6
			$ifcondition_11_223ee6 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_11_223ee6) {
				$func_11_223ee6 = create_function("","return (".$ifcondition_11_223ee6.");");
				if ($func_11_223ee6()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 12_5e6a8d
					$ifcondition_12_5e6a8d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_12_5e6a8d) {
						$func_12_5e6a8d = create_function("","return (".$ifcondition_12_5e6a8d.");");
						if ($func_12_5e6a8d()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_12_5e6a8d);
					}
					unset($ifcondition_12_5e6a8d);
					//IF TAG END 12_5e6a8d
				}
				unset($func_11_223ee6);
			}
			unset($ifcondition_11_223ee6);
			//IF TAG END 11_223ee6
			//IF TAG START 13_3b65ba
			$ifcondition_13_3b65ba = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_13_3b65ba) {
				$func_13_3b65ba = create_function("","return (".$ifcondition_13_3b65ba.");");
				if ($func_13_3b65ba()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 14_c1da7e
					$ifcondition_14_c1da7e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_14_c1da7e) {
						$func_14_c1da7e = create_function("","return (".$ifcondition_14_c1da7e.");");
						if ($func_14_c1da7e()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_14_c1da7e);
					}
					unset($ifcondition_14_c1da7e);
					//IF TAG END 14_c1da7e
					//IF TAG START 15_b01603
					$ifcondition_15_b01603 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_15_b01603) {
						$func_15_b01603 = create_function("","return (".$ifcondition_15_b01603.");");
						if ($func_15_b01603()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_15_b01603);
					}
					unset($ifcondition_15_b01603);
					//IF TAG END 15_b01603
					$content .="
					</div>
					";
				}
				unset($func_13_3b65ba);
			}
			unset($ifcondition_13_3b65ba);
			//IF TAG END 13_3b65ba
			$count_4_60fa55++;
			//do all result vars replacement
			$content_4_60fa55.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_4_60fa55; //retrieve previous content var if any
		unset($content_4_60fa55);
		$replace = $replace_4_60fa55; //retrieve previous replace vars if any
		unset($replace_4_60fa55);
		$object[$objectDefinition_mediaresult] = $object_4_60fa55; //retrieve previous object search if any
		unset($object_4_60fa55);
	}
	//RESULT mediaresult TAG END 4_60fa55
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 2_39bbe9
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
	<?php $cache_78bdfccbed02c43d004345dfb16c25f2_content = $cache_78bdfccbed02c43d004345dfb16c25f2->endSave();
endif;
unset($cache_78bdfccbed02c43d004345dfb16c25f2);
echo $cache_78bdfccbed02c43d004345dfb16c25f2_content;
unset($cache_78bdfccbed02c43d004345dfb16c25f2_content);
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
		<?php $cache_310b8e03478cb3c45f207c7248ba7f1e = new CMS_cache('310b8e03478cb3c45f207c7248ba7f1e', 'polymod', 'auto', true);
if ($cache_310b8e03478cb3c45f207c7248ba7f1e->exist()):
	//Get content from cache
	$cache_310b8e03478cb3c45f207c7248ba7f1e_content = $cache_310b8e03478cb3c45f207c7248ba7f1e->load();
else:
	$cache_310b8e03478cb3c45f207c7248ba7f1e->start();
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
	//SEARCH mediaresult TAG START 16_41eb2a
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_16_41eb2a = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_16_41eb2a);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_17_9bb5a1 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_17_9bb5a1['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_17_9bb5a1['type'] == 'publication date after' || $values_17_9bb5a1['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_17_9bb5a1['value']);
			$values_17_9bb5a1['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_17_9bb5a1)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 18_49e70c
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
		$object_18_49e70c = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_18_49e70c = $replace; //save previous replace vars if any
		$count_18_49e70c = 0;
		$content_18_49e70c = $content; //save previous content var if any
		$maxPages_18_49e70c = $search_mediaresult->getMaxPages();
		$maxResults_18_49e70c = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_18_49e70c) ? 1 : 0,
				"{lastresult}" 	=> ($count_18_49e70c == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_18_49e70c+1),
				"{maxpages}"    => $maxPages_18_49e70c,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_18_49e70c,
				"{altclass}"    => (($count_18_49e70c+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 19_588d55
			$ifcondition_19_588d55 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_19_588d55) {
				$func_19_588d55 = create_function("","return (".$ifcondition_19_588d55.");");
				if ($func_19_588d55()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 20_78bccd
					$ifcondition_20_78bccd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_20_78bccd) {
						$func_20_78bccd = create_function("","return (".$ifcondition_20_78bccd.");");
						if ($func_20_78bccd()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_20_78bccd);
					}
					unset($ifcondition_20_78bccd);
					//IF TAG END 20_78bccd
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 21_1681fd
					$ifcondition_21_1681fd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_21_1681fd) {
						$func_21_1681fd = create_function("","return (".$ifcondition_21_1681fd.");");
						if ($func_21_1681fd()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_21_1681fd);
					}
					unset($ifcondition_21_1681fd);
					//IF TAG END 21_1681fd
				}
				unset($func_19_588d55);
			}
			unset($ifcondition_19_588d55);
			//IF TAG END 19_588d55
			//IF TAG START 22_f6140f
			$ifcondition_22_f6140f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_22_f6140f) {
				$func_22_f6140f = create_function("","return (".$ifcondition_22_f6140f.");");
				if ($func_22_f6140f()) {
					//IF TAG START 23_a44cc7
					$ifcondition_23_a44cc7 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_23_a44cc7) {
						$func_23_a44cc7 = create_function("","return (".$ifcondition_23_a44cc7.");");
						if ($func_23_a44cc7()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_23_a44cc7);
					}
					unset($ifcondition_23_a44cc7);
					//IF TAG END 23_a44cc7
					//IF TAG START 24_a4fb57
					$ifcondition_24_a4fb57 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_24_a4fb57) {
						$func_24_a4fb57 = create_function("","return (".$ifcondition_24_a4fb57.");");
						if ($func_24_a4fb57()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_24_a4fb57);
					}
					unset($ifcondition_24_a4fb57);
					//IF TAG END 24_a4fb57
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_22_f6140f);
			}
			unset($ifcondition_22_f6140f);
			//IF TAG END 22_f6140f
			//IF TAG START 25_34cd51
			$ifcondition_25_34cd51 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_25_34cd51) {
				$func_25_34cd51 = create_function("","return (".$ifcondition_25_34cd51.");");
				if ($func_25_34cd51()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 26_669957
					$ifcondition_26_669957 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_26_669957) {
						$func_26_669957 = create_function("","return (".$ifcondition_26_669957.");");
						if ($func_26_669957()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_26_669957);
					}
					unset($ifcondition_26_669957);
					//IF TAG END 26_669957
				}
				unset($func_25_34cd51);
			}
			unset($ifcondition_25_34cd51);
			//IF TAG END 25_34cd51
			//IF TAG START 27_926616
			$ifcondition_27_926616 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_27_926616) {
				$func_27_926616 = create_function("","return (".$ifcondition_27_926616.");");
				if ($func_27_926616()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 28_41ca18
					$ifcondition_28_41ca18 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_28_41ca18) {
						$func_28_41ca18 = create_function("","return (".$ifcondition_28_41ca18.");");
						if ($func_28_41ca18()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_28_41ca18);
					}
					unset($ifcondition_28_41ca18);
					//IF TAG END 28_41ca18
					//IF TAG START 29_bd9741
					$ifcondition_29_bd9741 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_29_bd9741) {
						$func_29_bd9741 = create_function("","return (".$ifcondition_29_bd9741.");");
						if ($func_29_bd9741()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_29_bd9741);
					}
					unset($ifcondition_29_bd9741);
					//IF TAG END 29_bd9741
					$content .="
					</div>
					";
				}
				unset($func_27_926616);
			}
			unset($ifcondition_27_926616);
			//IF TAG END 27_926616
			$count_18_49e70c++;
			//do all result vars replacement
			$content_18_49e70c.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_18_49e70c; //retrieve previous content var if any
		unset($content_18_49e70c);
		$replace = $replace_18_49e70c; //retrieve previous replace vars if any
		unset($replace_18_49e70c);
		$object[$objectDefinition_mediaresult] = $object_18_49e70c; //retrieve previous object search if any
		unset($object_18_49e70c);
	}
	//RESULT mediaresult TAG END 18_49e70c
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 16_41eb2a
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
	<?php $cache_310b8e03478cb3c45f207c7248ba7f1e_content = $cache_310b8e03478cb3c45f207c7248ba7f1e->endSave();
endif;
unset($cache_310b8e03478cb3c45f207c7248ba7f1e);
echo $cache_310b8e03478cb3c45f207c7248ba7f1e_content;
unset($cache_310b8e03478cb3c45f207c7248ba7f1e_content);
   ?>

	</div>
	
		<div class="text"><ul><li>modifier, cr&eacute;er et copier des pages.</li><li>g&eacute;rer votre compte utilisateur.</li><li>g&eacute;rer des &eacute;l&eacute;ments des modules.</li><li>&hellip;</li></ul></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_c44ca687be883570b4e24e7b3d67aa0b = new CMS_cache('c44ca687be883570b4e24e7b3d67aa0b', 'polymod', 'auto', true);
if ($cache_c44ca687be883570b4e24e7b3d67aa0b->exist()):
	//Get content from cache
	$cache_c44ca687be883570b4e24e7b3d67aa0b_content = $cache_c44ca687be883570b4e24e7b3d67aa0b->load();
else:
	$cache_c44ca687be883570b4e24e7b3d67aa0b->start();
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
	//SEARCH mediaresult TAG START 30_be9367
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_30_be9367 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_30_be9367);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_31_7abd23 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_31_7abd23['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_31_7abd23['type'] == 'publication date after' || $values_31_7abd23['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_31_7abd23['value']);
			$values_31_7abd23['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_31_7abd23)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 32_c4a46e
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
		$object_32_c4a46e = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_32_c4a46e = $replace; //save previous replace vars if any
		$count_32_c4a46e = 0;
		$content_32_c4a46e = $content; //save previous content var if any
		$maxPages_32_c4a46e = $search_mediaresult->getMaxPages();
		$maxResults_32_c4a46e = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_32_c4a46e) ? 1 : 0,
				"{lastresult}" 	=> ($count_32_c4a46e == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_32_c4a46e+1),
				"{maxpages}"    => $maxPages_32_c4a46e,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_32_c4a46e,
				"{altclass}"    => (($count_32_c4a46e+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 33_6fa1a5
			$ifcondition_33_6fa1a5 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_33_6fa1a5) {
				$func_33_6fa1a5 = create_function("","return (".$ifcondition_33_6fa1a5.");");
				if ($func_33_6fa1a5()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 34_6fd013
					$ifcondition_34_6fd013 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_34_6fd013) {
						$func_34_6fd013 = create_function("","return (".$ifcondition_34_6fd013.");");
						if ($func_34_6fd013()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
						unset($func_34_6fd013);
					}
					unset($ifcondition_34_6fd013);
					//IF TAG END 34_6fd013
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 35_576400
					$ifcondition_35_576400 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_35_576400) {
						$func_35_576400 = create_function("","return (".$ifcondition_35_576400.");");
						if ($func_35_576400()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_35_576400);
					}
					unset($ifcondition_35_576400);
					//IF TAG END 35_576400
				}
				unset($func_33_6fa1a5);
			}
			unset($ifcondition_33_6fa1a5);
			//IF TAG END 33_6fa1a5
			//IF TAG START 36_cb443b
			$ifcondition_36_cb443b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_36_cb443b) {
				$func_36_cb443b = create_function("","return (".$ifcondition_36_cb443b.");");
				if ($func_36_cb443b()) {
					//IF TAG START 37_20d626
					$ifcondition_37_20d626 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_37_20d626) {
						$func_37_20d626 = create_function("","return (".$ifcondition_37_20d626.");");
						if ($func_37_20d626()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_37_20d626);
					}
					unset($ifcondition_37_20d626);
					//IF TAG END 37_20d626
					//IF TAG START 38_0f0331
					$ifcondition_38_0f0331 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_38_0f0331) {
						$func_38_0f0331 = create_function("","return (".$ifcondition_38_0f0331.");");
						if ($func_38_0f0331()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_38_0f0331);
					}
					unset($ifcondition_38_0f0331);
					//IF TAG END 38_0f0331
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_36_cb443b);
			}
			unset($ifcondition_36_cb443b);
			//IF TAG END 36_cb443b
			//IF TAG START 39_b4bddd
			$ifcondition_39_b4bddd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_39_b4bddd) {
				$func_39_b4bddd = create_function("","return (".$ifcondition_39_b4bddd.");");
				if ($func_39_b4bddd()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 40_fc5e2c
					$ifcondition_40_fc5e2c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_40_fc5e2c) {
						$func_40_fc5e2c = create_function("","return (".$ifcondition_40_fc5e2c.");");
						if ($func_40_fc5e2c()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_40_fc5e2c);
					}
					unset($ifcondition_40_fc5e2c);
					//IF TAG END 40_fc5e2c
				}
				unset($func_39_b4bddd);
			}
			unset($ifcondition_39_b4bddd);
			//IF TAG END 39_b4bddd
			//IF TAG START 41_1f6f56
			$ifcondition_41_1f6f56 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_41_1f6f56) {
				$func_41_1f6f56 = create_function("","return (".$ifcondition_41_1f6f56.");");
				if ($func_41_1f6f56()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 42_7ff760
					$ifcondition_42_7ff760 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_42_7ff760) {
						$func_42_7ff760 = create_function("","return (".$ifcondition_42_7ff760.");");
						if ($func_42_7ff760()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
						unset($func_42_7ff760);
					}
					unset($ifcondition_42_7ff760);
					//IF TAG END 42_7ff760
					//IF TAG START 43_20ab11
					$ifcondition_43_20ab11 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_43_20ab11) {
						$func_43_20ab11 = create_function("","return (".$ifcondition_43_20ab11.");");
						if ($func_43_20ab11()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
						unset($func_43_20ab11);
					}
					unset($ifcondition_43_20ab11);
					//IF TAG END 43_20ab11
					$content .="
					</div>
					";
				}
				unset($func_41_1f6f56);
			}
			unset($ifcondition_41_1f6f56);
			//IF TAG END 41_1f6f56
			$count_32_c4a46e++;
			//do all result vars replacement
			$content_32_c4a46e.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_32_c4a46e; //retrieve previous content var if any
		unset($content_32_c4a46e);
		$replace = $replace_32_c4a46e; //retrieve previous replace vars if any
		unset($replace_32_c4a46e);
		$object[$objectDefinition_mediaresult] = $object_32_c4a46e; //retrieve previous object search if any
		unset($object_32_c4a46e);
	}
	//RESULT mediaresult TAG END 32_c4a46e
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 30_be9367
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
	<?php $cache_c44ca687be883570b4e24e7b3d67aa0b_content = $cache_c44ca687be883570b4e24e7b3d67aa0b->endSave();
endif;
unset($cache_c44ca687be883570b4e24e7b3d67aa0b);
echo $cache_c44ca687be883570b4e24e7b3d67aa0b_content;
unset($cache_c44ca687be883570b4e24e7b3d67aa0b_content);
   ?>

	</div>
	
		<div class="text"><h3>Vous ne pouvez pas:</h3> <ul>     <li>administrer les modules.</li>     <li>valider la modification des pages.</li>     <li>ou encore cr&eacute;er de nouveaux comptes utilisateurs.</li>     <li>...</li> </ul> <p>Ces fonctionnalit&eacute;s sont r&eacute;serv&eacute;es &agrave; un compte utilisateur de type&nbsp;  <strong>&laquo; Administrateur &raquo;.</strong></p></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h2>Un acc&eacute;s<strong> </strong>TOTAL</h2></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?>
	
	
		<div class="text"><h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d'information, consultez les pages suivantes :</p> <ul>     <li><a href="http://127.0.0.1/web/demo/29-automne-v4.php">Automne 4</a>.</li>     <li><a href="http://127.0.0.1/web/demo/33-nouveautes.php">Nouveaut&eacute;s</a>.</li>     <li><a href="http://127.0.0.1/web/demo/30-notions-essentielles.php">Pr&eacute;-requis</a>.</li>     <li><a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalit&eacute;s</a>.</li> </ul></div>
	
<?php /* End row [210 Texte et Image Droite - r45_210_Texte__image_droite.xml] */   ?><?php /* End clientspace [first] */   ?>
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