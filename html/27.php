<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:39 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:40 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 17:00:00 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/27-modules.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/27-modules.php', true, 301);
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
	<title>Automne 4 : Modules</title>
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
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://test-folder/trunk/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://test-folder/trunk/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
=======
					<ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li><li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3"><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li><li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li><li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li></ul></li><li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li></ul>
>>>>>>> MERGE-SOURCE
				</div>
				<div id="content" class="page27">
					<div id="breadcrumbs">
<<<<<<< TREE
						<a href="http://test-folder/trunk/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://test-folder/trunk/web/demo/24-documentation.php">Fonctionnalités</a> &gt; 
=======
						<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; <a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a> &gt; 
>>>>>>> MERGE-SOURCE
					</div>
					<div id="title">
						<h1>Modules</h1>
					</div>
					<?php /* Start clientspace [first] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><p>Il est possible d'ajouter au noyau logiciel un ensemble de modules pour ajouter des fonctionnalit&eacute;s propres aux besoins de chaque site.</p><p>Par d&eacute;faut Automne 4 contient les modules les plus courants : <strong>M&eacute;diath&egrave;que, Gestion des Actualit&eacute;s, Cr&eacute;ation de formulaires, Cr&eacute;ation d'Alias de pages. </strong></p><h3>Il vous est cependant possible d'ajouter autant de modules suppl&eacute;mentaires que vous le souhaitez !</h3> <h2>G&eacute;n&eacute;rateur de modules&nbsp; POLYMOD</h2></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* Start row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?>
	<div class="imgRight">
		<?php $cache_36801857027b47701d751a340c237e42 = new CMS_cache('36801857027b47701d751a340c237e42', 'polymod', 'auto', true);
if ($cache_36801857027b47701d751a340c237e42->exist()):
	//Get content from cache
	$cache_36801857027b47701d751a340c237e42_content = $cache_36801857027b47701d751a340c237e42->load();
else:
	$cache_36801857027b47701d751a340c237e42->start();
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
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG START 2_e10cd5
=======
	//SEARCH mediaresult TAG START 2_773af2
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG START 2_c35331
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_2_e10cd5 = isset($public_search) ? $public_search : false;
=======
	$public_2_773af2 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_2_c35331 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_e10cd5);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_773af2);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_c35331);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
<<<<<<< TREE
<<<<<<< TREE
		$values_3_0e51a3 = array (
=======
		$values_3_e8fa1c = array (
>>>>>>> MERGE-SOURCE
=======
		$values_3_92ab3d = array (
>>>>>>> MERGE-SOURCE
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
<<<<<<< TREE
<<<<<<< TREE
		$values_3_0e51a3['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_0e51a3['type'] == 'publication date after' || $values_3_0e51a3['type'] == 'publication date before') {
=======
		$values_3_e8fa1c['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_e8fa1c['type'] == 'publication date after' || $values_3_e8fa1c['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
=======
		$values_3_92ab3d['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_92ab3d['type'] == 'publication date after' || $values_3_92ab3d['type'] == 'publication date before') {
>>>>>>> MERGE-SOURCE
			//convert DB format to current language format
			$dt = new CMS_date();
<<<<<<< TREE
<<<<<<< TREE
			$dt->setFromDBValue($values_3_0e51a3['value']);
			$values_3_0e51a3['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
=======
			$dt->setFromDBValue($values_3_e8fa1c['value']);
			$values_3_e8fa1c['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
=======
			$dt->setFromDBValue($values_3_92ab3d['value']);
			$values_3_92ab3d['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_0e51a3)) ? $launchSearch_mediaresult : false;
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_e8fa1c)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
=======
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_92ab3d)) ? $launchSearch_mediaresult : false;
>>>>>>> MERGE-SOURCE
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 4_86d3f8
=======
	//RESULT mediaresult TAG START 4_16dba5
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 4_e5e7d2
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
		$object_4_86d3f8 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_86d3f8 = $replace; //save previous replace vars if any
		$count_4_86d3f8 = 0;
		$content_4_86d3f8 = $content; //save previous content var if any
		$maxPages_4_86d3f8 = $search_mediaresult->getMaxPages();
		$maxResults_4_86d3f8 = $search_mediaresult->getNumRows();
=======
		$object_4_16dba5 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_16dba5 = $replace; //save previous replace vars if any
		$count_4_16dba5 = 0;
		$content_4_16dba5 = $content; //save previous content var if any
		$maxPages_4_16dba5 = $search_mediaresult->getMaxPages();
		$maxResults_4_16dba5 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_4_e5e7d2 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_e5e7d2 = $replace; //save previous replace vars if any
		$count_4_e5e7d2 = 0;
		$content_4_e5e7d2 = $content; //save previous content var if any
		$maxPages_4_e5e7d2 = $search_mediaresult->getMaxPages();
		$maxResults_4_e5e7d2 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_4_86d3f8) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_86d3f8 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_86d3f8+1),
				"{maxpages}"    => $maxPages_4_86d3f8,
=======
				"{firstresult}" => (!$count_4_16dba5) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_16dba5 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_16dba5+1),
				"{maxpages}"    => $maxPages_4_16dba5,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_4_e5e7d2) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_e5e7d2 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_e5e7d2+1),
				"{maxpages}"    => $maxPages_4_e5e7d2,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_4_86d3f8,
=======
				"{maxresults}"  => $maxResults_4_16dba5,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_4_e5e7d2,
				"{altclass}"    => (($count_4_e5e7d2+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 5_42fea0
=======
			//IF TAG START 5_5db279
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 5_cc4268
			$ifcondition_5_cc4268 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_5_cc4268) {
				$func_5_cc4268 = create_function("","return (".$ifcondition_5_cc4268.");");
				if ($func_5_cc4268()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 6_24d536
=======
					//IF TAG START 6_2a4072
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 6_14fca1
					$ifcondition_6_14fca1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_6_14fca1) {
						$func_6_14fca1 = create_function("","return (".$ifcondition_6_14fca1.");");
						if ($func_6_14fca1()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 6_24d536
=======
					}//IF TAG END 6_2a4072
>>>>>>> MERGE-SOURCE
=======
						unset($func_6_14fca1);
					}
					unset($ifcondition_6_14fca1);
					//IF TAG END 6_14fca1
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 7_13c5a2
=======
					//IF TAG START 7_32957a
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 7_e6d1ff
					$ifcondition_7_e6d1ff = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_7_e6d1ff) {
						$func_7_e6d1ff = create_function("","return (".$ifcondition_7_e6d1ff.");");
						if ($func_7_e6d1ff()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 7_13c5a2
=======
					}//IF TAG END 7_32957a
>>>>>>> MERGE-SOURCE
=======
						unset($func_7_e6d1ff);
					}
					unset($ifcondition_7_e6d1ff);
					//IF TAG END 7_e6d1ff
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 5_42fea0
			//IF TAG START 8_65dfe2
=======
			}//IF TAG END 5_5db279
			//IF TAG START 8_43e9e8
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 9_96fabe
=======
					//IF TAG START 9_6ee0be
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
				unset($func_5_cc4268);
			}
			unset($ifcondition_5_cc4268);
			//IF TAG END 5_cc4268
			//IF TAG START 8_13c643
			$ifcondition_8_13c643 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_8_13c643) {
				$func_8_13c643 = create_function("","return (".$ifcondition_8_13c643.");");
				if ($func_8_13c643()) {
					//IF TAG START 9_3c9c60
					$ifcondition_9_3c9c60 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_9_3c9c60) {
						$func_9_3c9c60 = create_function("","return (".$ifcondition_9_3c9c60.");");
						if ($func_9_3c9c60()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 9_96fabe
					//IF TAG START 10_6878e6
=======
					}//IF TAG END 9_6ee0be
					//IF TAG START 10_10f05a
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_9_3c9c60);
					}
					unset($ifcondition_9_3c9c60);
					//IF TAG END 9_3c9c60
					//IF TAG START 10_9572c1
					$ifcondition_10_9572c1 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_10_9572c1) {
						$func_10_9572c1 = create_function("","return (".$ifcondition_10_9572c1.");");
						if ($func_10_9572c1()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 10_6878e6
=======
					}//IF TAG END 10_10f05a
>>>>>>> MERGE-SOURCE
=======
						unset($func_10_9572c1);
					}
					unset($ifcondition_10_9572c1);
					//IF TAG END 10_9572c1
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 8_65dfe2
			//IF TAG START 11_3e329b
=======
			}//IF TAG END 8_43e9e8
			//IF TAG START 11_f01301
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_8_13c643);
			}
			unset($ifcondition_8_13c643);
			//IF TAG END 8_13c643
			//IF TAG START 11_5c9c8d
			$ifcondition_11_5c9c8d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_11_5c9c8d) {
				$func_11_5c9c8d = create_function("","return (".$ifcondition_11_5c9c8d.");");
				if ($func_11_5c9c8d()) {
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
					//IF TAG START 12_44ad28
=======
					//IF TAG START 12_9ccde9
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 12_2faa83
					$ifcondition_12_2faa83 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_12_2faa83) {
						$func_12_2faa83 = create_function("","return (".$ifcondition_12_2faa83.");");
						if ($func_12_2faa83()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 12_44ad28
=======
					}//IF TAG END 12_9ccde9
>>>>>>> MERGE-SOURCE
=======
						unset($func_12_2faa83);
					}
					unset($ifcondition_12_2faa83);
					//IF TAG END 12_2faa83
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 11_3e329b
			//IF TAG START 13_ccd92c
=======
			}//IF TAG END 11_f01301
			//IF TAG START 13_0198c8
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
				unset($func_11_5c9c8d);
			}
			unset($ifcondition_11_5c9c8d);
			//IF TAG END 11_5c9c8d
			//IF TAG START 13_f78579
			$ifcondition_13_f78579 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_13_f78579) {
				$func_13_f78579 = create_function("","return (".$ifcondition_13_f78579.");");
				if ($func_13_f78579()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div class=\"shadow\">
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 14_1c0009
=======
					//IF TAG START 14_e0ab71
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 14_705fcc
					$ifcondition_14_705fcc = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_14_705fcc) {
						$func_14_705fcc = create_function("","return (".$ifcondition_14_705fcc.");");
						if ($func_14_705fcc()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 14_1c0009
					//IF TAG START 15_919fef
=======
					}//IF TAG END 14_e0ab71
					//IF TAG START 15_23b8e0
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
						unset($func_14_705fcc);
					}
					unset($ifcondition_14_705fcc);
					//IF TAG END 14_705fcc
					//IF TAG START 15_75908f
					$ifcondition_15_75908f = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_15_75908f) {
						$func_15_75908f = create_function("","return (".$ifcondition_15_75908f.");");
						if ($func_15_75908f()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 15_919fef
=======
					}//IF TAG END 15_23b8e0
>>>>>>> MERGE-SOURCE
=======
						unset($func_15_75908f);
					}
					unset($ifcondition_15_75908f);
					//IF TAG END 15_75908f
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 13_ccd92c
			$count_4_86d3f8++;
=======
			}//IF TAG END 13_0198c8
			$count_4_16dba5++;
>>>>>>> MERGE-SOURCE
=======
				unset($func_13_f78579);
			}
			unset($ifcondition_13_f78579);
			//IF TAG END 13_f78579
			$count_4_e5e7d2++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
<<<<<<< TREE
			$content_4_86d3f8.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_4_16dba5.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
=======
			$content_4_e5e7d2.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
<<<<<<< TREE
		$content = $content_4_86d3f8; //retrieve previous content var if any
		$replace = $replace_4_86d3f8; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_4_86d3f8; //retrieve previous object search if any
=======
		$content = $content_4_16dba5; //retrieve previous content var if any
		$replace = $replace_4_16dba5; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_4_16dba5; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
=======
		$content = $content_4_e5e7d2; //retrieve previous content var if any
		unset($content_4_e5e7d2);
		$replace = $replace_4_e5e7d2; //retrieve previous replace vars if any
		unset($replace_4_e5e7d2);
		$object[$objectDefinition_mediaresult] = $object_4_e5e7d2; //retrieve previous object search if any
		unset($object_4_e5e7d2);
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG END 4_86d3f8
=======
	//RESULT mediaresult TAG END 4_16dba5
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG END 4_e5e7d2
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 2_e10cd5
=======
	//SEARCH mediaresult TAG END 2_773af2
>>>>>>> MERGE-SOURCE
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
=======
	//SEARCH mediaresult TAG END 2_c35331
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
	<?php $cache_36801857027b47701d751a340c237e42_content = $cache_36801857027b47701d751a340c237e42->endSave();
endif;
unset($cache_36801857027b47701d751a340c237e42);
echo $cache_36801857027b47701d751a340c237e42_content;
unset($cache_36801857027b47701d751a340c237e42_content);
>>>>>>> MERGE-SOURCE
   ?>

	</div>
	
		<div class="text"><p>Une des particularit&eacute;s d&rsquo;Automne est le<strong> g&eacute;n&eacute;rateur de module appel&eacute; POLYMOD. </strong></p><p>Il permet de g&eacute;rer des &eacute;l&eacute;ments contenant des donn&eacute;es de types textes, fichiers, images &hellip; Ces donn&eacute;es sont organis&eacute;es entre elles tel que vous le souhaitez et cela sans qu&rsquo;aucune comp&eacute;tence technique ne soit requise.</p><p>Exemple :&nbsp; les modules Actualit&eacute;s et M&eacute;diath&egrave;que fourni dans cette d&eacute;monstration sont enti&egrave;rement <strong>cr&eacute;&eacute;s &agrave; partir de l'interface d'administration</strong> d'Automne 4. Ils peuvent &ecirc;tre modifi&eacute;s pour &ecirc;tre ajust&eacute;s &agrave; ce que vous souhaitez sans aucune difficult&eacute;.</p><p>Le polymod permet aussi de <strong>cr&eacute;er simplement</strong> des flux RSS, des moteurs de recherche c&ocirc;t&eacute; client&hellip;</p><p>Exemple : module de gestion de produits, actualit&eacute;s, m&eacute;diath&egrave;que, annuaire, &hellip;</p> <h3>Il est possible de cr&eacute;er ses propres modules pour r&eacute;aliser des op&eacute;rations bien sp&eacute;cifiques.</h3></div>
		<div class="spacer"></div>
	
<?php /* End row [230 Texte et Média à Droite - r69_Texte_-_Media_a_droite.xml] */   ?><?php /* Start row [200 Texte - r44_200_Texte.xml] */   ?>

<div class="text"><h2>Modules sp&eacute;cifiques</h2> <h3>Automne 4 permet aussi de g&eacute;rer des modules sp&eacute;cifiques que le Polymod ne saurai traiter.</h3><p>Ces modules, cr&eacute;&eacute;s en PHP peuvent alors <strong>r&eacute;aliser tout type d'op&eacute;ration m&eacute;tier complexe </strong>en s'int&eacute;grant parfaitement &agrave; l'interface d'Automne 4. </p><p>Vous pouvez ainsi lier Automne &agrave; vos bases de donn&eacute;es m&eacute;tier ou encore cr&eacute;er des modules de mailing, d'e-commerce, interroger des web services distant et ajouter bien d'autres fonctionnalit&eacute;s encore ...</p></div>

<?php /* End row [200 Texte - r44_200_Texte.xml] */   ?><?php /* End clientspace [first] */   ?>
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