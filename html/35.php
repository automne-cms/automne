<?php //Generated on Mon, 18 Jan 2010 16:11:28 +0100 by Automne (TM) 4.0.0
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/35-gestion-des-droits.php', true, 301);
}
 ?><?php if (!is_object($cms_user) || !$cms_user->hasPageClearance(35, CLEARANCE_PAGE_VIEW)) {
	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
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

	<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

</head>
<body>
	<div id="main">
		<div id="container">
			<div id="header">
				<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '
							<a id="lienAccueil" href="http://127.0.0.1/web/demo/2-accueil.php" title="Retour &agrave; l\'accueil">Retour &agrave; l\'accueil</a>
						';
}
?>
			</div>
			<div id="backgroundBottomContainer">
				<div id="menuLeft">
					<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '<ul class="CMS_lvl2">';  if ($cms_user->hasPageClearance(3, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/3-presentation.php">Présentation</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(24, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_open "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a><ul class="CMS_lvl3">';  if ($cms_user->hasPageClearance(25, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/25-modeles.php">Modèles</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(26, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/26-rangees.php">Rangées</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(27, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/27-modules.php">Modules</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(28, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/28-administration.php">Gestion des utilisateurs</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(35, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub CMS_current"><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/35-gestion-des-droits.php">Gestion des droits</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(37, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/37-droit-de-validation.php">Workflow de publication</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(38, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/38-aide-aux-utilisateurs.php">Aide utilisateurs</a></li>';
}
 echo '';  if ($cms_user->hasPageClearance(34, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl3 CMS_nosub "><a class="CMS_lvl3" href="http://127.0.0.1/web/demo/34-fonctions-avancees.php">Fonctions avancées</a></li>';
}
 echo '</ul></li>';
}
 echo '';  if ($cms_user->hasPageClearance(31, CLEARANCE_PAGE_VIEW)) {
echo '<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/demo/31-exemples-de-modules.php">Exemples de modules</a></li>';
}
 echo '</ul>';
}
?>
				</div>
				<div id="content" class="page35">
					<div id="breadcrumbs">
						<?php if ($cms_user->hasPageClearance(2, CLEARANCE_PAGE_VIEW)) {
echo '<a href="http://127.0.0.1/web/demo/2-accueil.php">Accueil</a> &gt; ';
}
?><?php if ($cms_user->hasPageClearance(24, CLEARANCE_PAGE_VIEW)) {
echo '<a href="http://127.0.0.1/web/demo/24-documentation.php">Fonctionnalités</a> &gt; ';
}
?>
					</div>
					<div id="title">
						<h1>Gestion des droits</h1>
					</div>
					<atm-toc />
					

<h2>Principe de gestion des droits</h2>


	<div class="imgRight">
		<?php //Generated by : $Id: 35.php,v 1.6 2010/01/18 15:20:09 sebastien Exp $
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
	//SEARCH mediaresult TAG START 2_13630f
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_2_13630f = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_2_13630f);
	$launchSearch_mediaresult = true;
	//add search conditions if any
	if (isset($blockAttributes['search']['mediaresult']['item'])) {
		$values_3_299891 = array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => 'block',
			'mandatory' => 'true',
		);
		$values_3_299891['value'] = $blockAttributes['search']['mediaresult']['item'];
		if ($values_3_299891['type'] == 'publication date after' || $values_3_299891['type'] == 'publication date before') {
			//convert DB format to current language format
			$dt = new CMS_date();
			$dt->setFromDBValue($values_3_299891['value']);
			$values_3_299891['value'] = $dt->getLocalizedDate($cms_language->getDateFormat());
		}
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, $values_3_299891)) ? $launchSearch_mediaresult : false;
	} elseif (true == true) {
		//search parameter is mandatory and no value found
		$launchSearch_mediaresult = false;
	}
	//RESULT mediaresult TAG START 4_715daa
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
		$object_4_715daa = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_4_715daa = $replace; //save previous replace vars if any
		$count_4_715daa = 0;
		$content_4_715daa = $content; //save previous content var if any
		$maxPages_4_715daa = $search_mediaresult->getMaxPages();
		$maxResults_4_715daa = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_4_715daa) ? 1 : 0,
				"{lastresult}" 	=> ($count_4_715daa == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_4_715daa+1),
				"{maxpages}"    => $maxPages_4_715daa,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_4_715daa,
			);
			//IF TAG START 5_99fe77
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 6_cf6417
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
					}//IF TAG END 6_cf6417
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 7_a5ad5d
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
					}//IF TAG END 7_a5ad5d
				}
			}//IF TAG END 5_99fe77
			//IF TAG START 8_f6ba52
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					//IF TAG START 9_c23d1e
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
					}//IF TAG END 9_c23d1e
					//IF TAG START 10_c076ce
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
					}//IF TAG END 10_c076ce
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
			}//IF TAG END 8_f6ba52
			//IF TAG START 11_440589
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
					//IF TAG START 12_05ea7b
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
					}//IF TAG END 12_05ea7b
				}
			}//IF TAG END 11_440589
			//IF TAG START 13_3f1a68
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"shadow\">
					";
					//IF TAG START 14_27c52f
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
					}//IF TAG END 14_27c52f
					//IF TAG START 15_37df64
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
					}//IF TAG END 15_37df64
					$content .="
					</div>
					";
				}
			}//IF TAG END 13_3f1a68
			$count_4_715daa++;
			//do all result vars replacement
			$content_4_715daa.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_4_715daa; //retrieve previous content var if any
		$replace = $replace_4_715daa; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_4_715daa; //retrieve previous object search if any
	}
	//RESULT mediaresult TAG END 4_715daa
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 2_13630f
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
   ?>
	</div>
	
		<div class="text"><p>Il existe<strong> trois types de droits fondamentaux</strong> :</p> <ul>     <li>Droit d'&eacute;criture &rArr; &eacute;quivaut au <strong>droit d'administration.</strong></li>     <li>Droit de lecture &rArr; &eacute;quivaut au <strong>droit de visibilit&eacute;.</strong></li>     <li>Aucun droit &rArr; l'utilisateur ne peut voir le contenu.</li> </ul></div>
		<div class="spacer"></div>
	

<p>Automne 4 dispose d'un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d'appliquer l'ensemble de ces droits sur tout types d'&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d'administration... L'ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d'utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <?php if ($cms_user->hasPageClearance(37, CLEARANCE_PAGE_VIEW)) {
echo '<a href="http://127.0.0.1/web/demo/37-droit-de-validation.php">droit de validation.</a>';
}
?></h3> <p>Ce droit permet de donner &agrave; l'utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L'utilisateur A peut avoir des droits d'administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu'il peut utiliser.</em></li>     <li><em>L'utilisateur B peut avoir les droits d'administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L'utilisateur C peut avoir les droits d'administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d'autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d'utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d'utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d'administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p>

					<a href="#header" id="top" title="haut de la page">Haut</a>
				</div>
				<div class="spacer"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div id="menuBottom">
			<ul>
				<?php if ($cms_user->hasPageClearance(8, CLEARANCE_PAGE_VIEW)) {
echo '<li><a href="http://127.0.0.1/web/demo/8-plan-du-site.php">Plan du site</a></li>';
}
?><?php if ($cms_user->hasPageClearance(9, CLEARANCE_PAGE_VIEW)) {
echo '<li><a href="http://127.0.0.1/web/demo/9-contact.php">Contact</a></li>';
}
?>
			</ul>
			<div class="spacer"></div>
		</div>
	</div>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>