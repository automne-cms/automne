<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:28 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:50 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/35-gestion-des-droits.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/35-gestion-des-droits.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?>
<<<<<<< TREE
<?php require_once(PATH_REALROOT_FS.'/automne/classes/polymodFrontEnd.php');  ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
=======
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php /* Template [Intérieur Démo - pt58_Interieur.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
>>>>>>> MERGE-SOURCE
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne 4 : Gestion des droits</title>
	<?php echo CMS_view::getCSS(array('/css/reset.css','/css/demo/common.css','/css/demo/interieur.css','/css/modules/pmedia.css'), 'all');  ?>

	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/demo/ie6.css" media="all" />
	<![endif]-->
	<?php echo CMS_view::getCSS(array('/css/demo/print.css'), 'print');  ?>

	<?php echo CMS_view::getJavascript(array('','/js/CMS_functions.js','/js/modules/pmedia/jquery-1.2.6.min-demo.js','/js/modules/pmedia/pmedia-demo.js','/js/modules/pmedia/swfobject.js'));  ?>

<<<<<<< TREE
	<link rel="icon" type="image/x-icon" href="http://test-folder/trunk/favicon.ico" />
=======
	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
>>>>>>> MERGE-SOURCE
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
<<<<<<< TREE
	<meta name="identifier-url" content="http://test-folder/trunk" />
	<base href="http://test-folder/trunk/" />
=======
	<meta name="identifier-url" content="http://127.0.0.1" />

>>>>>>> MERGE-SOURCE
</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				
<<<<<<< TREE
							<a id="lienAccueil" href="http://test-folder/trunk/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
=======
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l'accueil">Retour &agrave; l'accueil</a>
>>>>>>> MERGE-SOURCE
						
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
<<<<<<< TREE
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
=======
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
>>>>>>> MERGE-SOURCE
				</div>
				<div id="content" class="page35">
					<div id="breadcrumbs">
<<<<<<< TREE
						<a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a> &gt; 
=======
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a> &gt; 
>>>>>>> MERGE-SOURCE
					</div>
					<div id="title">
						<h1>Gestion des droits</h1>
					</div>
					<atm-toc />
					<?php /* Start clientspace [first] */   ?><?php /* Start row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?>

<h2>Principe de gestion des droits</h2>

<?php /* End row [110 Sous Titre (niveau 2) - r43_100_Sous_Titre.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php /*Generated on Fri, 19 Mar 2010 15:24:50 +0100 by Automne (TM) 4.0.1 */
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pmedia', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
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
	//SEARCH mediaresult TAG START 2_8ba095
=======
	//SEARCH mediaresult TAG START 2_8e2aa5
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
	$public_2_8ba095 = isset($public_search) ? $public_search : false;
=======
	$public_2_8e2aa5 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_8ba095);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_8e2aa5);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
		$values_3_61c997 = array (
=======
		$values_3_a4d4a3 = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
		$values_3_61c997['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_61c997['type'] == 'publication date after' || $values_3_61c997['type'] == 'publication date before') {
=======
		$values_3_a4d4a3['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_a4d4a3['type'] == 'publication date after' || $values_3_a4d4a3['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
			$dt->setFromDBValue($values_3_61c997['value']);
			$values_3_61c997['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_3_a4d4a3['value']);
			$values_3_a4d4a3['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_61c997)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_a4d4a3)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
	//RESULT mediaresult TAG START 4_195c79
=======
	//RESULT mediaresult TAG START 4_980fe4
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
		$object_4_195c79 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_195c79 = $replace; //save previous replace vars if any
		$count_4_195c79 = 0;
		$content_4_195c79 = $content; //save previous content var if any
		$maxPages_4_195c79 = $search_mediaresult->getMaxPages();
		$maxResults_4_195c79 = $search_mediaresult->getNumRows();
=======
		$object_4_980fe4 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_980fe4 = $replace; //save previous replace vars if any
		$count_4_980fe4 = 0;
		$content_4_980fe4 = $content; //save previous content var if any
		$maxPages_4_980fe4 = $search_mediaresult->getMaxPages();
		$maxResults_4_980fe4 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
				"{firstresult}" => (!$count_4_195c79) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_195c79 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_195c79+1),
				"{maxpages}"    => $maxPages_4_195c79,
=======
				"{firstresult}" => (!$count_4_980fe4) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_980fe4 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_980fe4+1),
				"{maxpages}"    => $maxPages_4_980fe4,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
				"{maxresults}"  => $maxResults_4_195c79,
=======
				"{maxresults}"  => $maxResults_4_980fe4,
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
			//IF TAG START 5_93b3cc
=======
			//IF TAG START 5_5d22f3
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
					//IF TAG START 6_b83ff6
=======
					//IF TAG START 6_992a46
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
					}//IF TAG END 6_b83ff6
=======
					}//IF TAG END 6_992a46
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
					//IF TAG START 7_d0699d
=======
					//IF TAG START 7_51fbac
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
					}//IF TAG END 7_d0699d
=======
					}//IF TAG END 7_51fbac
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
			}//IF TAG END 5_93b3cc
			//IF TAG START 8_05b502
=======
			}//IF TAG END 5_5d22f3
			//IF TAG START 8_023c16
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 9_8e9c2f
=======
					//IF TAG START 9_effe64
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
					}//IF TAG END 9_8e9c2f
					//IF TAG START 10_c5060a
=======
					}//IF TAG END 9_effe64
					//IF TAG START 10_4bc411
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
					}//IF TAG END 10_c5060a
=======
					}//IF TAG END 10_4bc411
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
			}//IF TAG END 8_05b502
			//IF TAG START 11_45f600
=======
			}//IF TAG END 8_023c16
			//IF TAG START 11_03ba1e
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
<<<<<<< TREE
					//IF TAG START 12_4bbadc
=======
					//IF TAG START 12_ceb18b
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
					}//IF TAG END 12_4bbadc
=======
					}//IF TAG END 12_ceb18b
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
			}//IF TAG END 11_45f600
			//IF TAG START 13_27d220
=======
			}//IF TAG END 11_03ba1e
			//IF TAG START 13_373f77
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
					//IF TAG START 14_ebd693
=======
					//IF TAG START 14_8779bf
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
					}//IF TAG END 14_ebd693
					//IF TAG START 15_817fcf
=======
					}//IF TAG END 14_8779bf
					//IF TAG START 15_756fbc
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
					}//IF TAG END 15_817fcf
=======
					}//IF TAG END 15_756fbc
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
			}//IF TAG END 13_27d220
			$count_4_195c79++;
=======
			}//IF TAG END 13_373f77
			$count_4_980fe4++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
			$content_4_195c79.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_4_980fe4.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		$content = $content_4_195c79; //retrieve previous content var if any
		$replace = $replace_4_195c79; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_4_195c79; //retrieve previous object search if any
=======
		$content = $content_4_980fe4; //retrieve previous content var if any
		$replace = $replace_4_980fe4; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_4_980fe4; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
	//RESULT mediaresult TAG END 4_195c79
=======
	//RESULT mediaresult TAG END 4_980fe4
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
	//SEARCH mediaresult TAG END 2_8ba095
=======
	//SEARCH mediaresult TAG END 2_8e2aa5
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
   ?>
	</div>
	
		<div class="text"><p>Il existe<strong> trois types de droits fondamentaux</strong> :</p> <ul>     <li>Droit d'&eacute;criture &rArr; &eacute;quivaut au <strong>droit d'administration.</strong></li>     <li>Droit de lecture &rArr; &eacute;quivaut au <strong>droit de visibilit&eacute;.</strong></li>     <li>Aucun droit &rArr; l'utilisateur ne peut voir le contenu.</li> </ul></div>
		<div class="spacer"></div>
	
<<<<<<< TREE


<div class="text"><p>Automne 4 dispose d'un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d'appliquer l'ensemble de ces droits sur tout types d'&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d'administration... L'ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d'utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <a href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">droit de validation.</a></h3> <p>Ce droit permet de donner &agrave; l'utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L'utilisateur A peut avoir des droits d'administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu'il peut utiliser.</em></li>     <li><em>L'utilisateur B peut avoir les droits d'administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L'utilisateur C peut avoir les droits d'administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d'autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d'utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d'utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d'administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p></div>


=======
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>Automne 4 dispose d'un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d'appliquer l'ensemble de ces droits sur tout types d'&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d'administration... L'ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d'utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">droit de validation.</a></h3> <p>Ce droit permet de donner &agrave; l'utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L'utilisateur A peut avoir des droits d'administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu'il peut utiliser.</em></li>     <li><em>L'utilisateur B peut avoir les droits d'administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L'utilisateur C peut avoir les droits d'administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d'autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d'utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d'utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d'administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* End clientspace [first] */   ?>
>>>>>>> MERGE-SOURCE
					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
<<<<<<< TREE
				<li><a href="http://test-folder/trunk/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://test-folder/trunk/web/demo/9-contact.php">Contact</a></li>
=======
				<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li><li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>
>>>>>>> MERGE-SOURCE
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>