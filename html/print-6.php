<<<<<<< TREE
<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:28:49 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:31 +0100 by Automne (TM) 4.0.1
=======
<?php //Generated on Mon, 24 May 2010 16:59:51 +0200 by Automne (TM) 4.0.2
>>>>>>> MERGE-SOURCE
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/print-6-mediatheque.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/print-6-mediatheque.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?>
<<<<<<< TREE
<?php require_once(PATH_REALROOT_FS.'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {

$content = "";
$replace = "";
if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
$blockAttributes = array (
  'module' => 'pmedia',
  'language' => 'fr',
);
$parameters['pageID'] = '6';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
$parameters['module'] = 'pmedia';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
<<<<<<< TREE
		//AJAX TAG START 3_d4dcfb
		//SEARCH mediaresult TAG START 4_8b8ade
=======
		//AJAX TAG START 3_989692
		//SEARCH mediaresult TAG START 4_70c271
>>>>>>> MERGE-SOURCE
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
<<<<<<< TREE
		$public_4_8b8ade = isset($public_search) ? $public_search : false;
=======
		$public_4_70c271 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
		//get search params
<<<<<<< TREE
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_8b8ade);
=======
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_70c271);
>>>>>>> MERGE-SOURCE
		$launchSearch_mediaresult = true;
		//add search conditions if any
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 8,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$search_mediaresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_mediaresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_mediaresult->addOrderCondition("objectID", "desc");
<<<<<<< TREE
		//RESULT mediaresult TAG START 5_d24c99
=======
		//RESULT mediaresult TAG START 5_ae68e1
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
			$object_5_d24c99 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_5_d24c99 = $replace; //save previous replace vars if any
			$count_5_d24c99 = 0;
			$content_5_d24c99 = $content; //save previous content var if any
			$maxPages_5_d24c99 = $search_mediaresult->getMaxPages();
			$maxResults_5_d24c99 = $search_mediaresult->getNumRows();
=======
			$object_5_ae68e1 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_5_ae68e1 = $replace; //save previous replace vars if any
			$count_5_ae68e1 = 0;
			$content_5_ae68e1 = $content; //save previous content var if any
			$maxPages_5_ae68e1 = $search_mediaresult->getMaxPages();
			$maxResults_5_ae68e1 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
					"{firstresult}" => (!$count_5_d24c99) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_d24c99 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_d24c99+1),
					"{maxpages}"    => $maxPages_5_d24c99,
=======
					"{firstresult}" => (!$count_5_ae68e1) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_ae68e1 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_ae68e1+1),
					"{maxpages}"    => $maxPages_5_ae68e1,
>>>>>>> MERGE-SOURCE
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
					"{maxresults}"  => $maxResults_5_d24c99,
=======
					"{maxresults}"  => $maxResults_5_ae68e1,
>>>>>>> MERGE-SOURCE
				);
<<<<<<< TREE
				//IF TAG START 6_ada38a
=======
				//IF TAG START 6_c811fe
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 6_ada38a
=======
				}//IF TAG END 6_c811fe
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
<<<<<<< TREE
				//IF TAG START 7_2e1a70
=======
				//IF TAG START 7_5e38c6
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
<<<<<<< TREE
				}//IF TAG END 7_2e1a70
=======
				}//IF TAG END 7_5e38c6
>>>>>>> MERGE-SOURCE
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
<<<<<<< TREE
				//IF TAG START 8_daaa21
=======
				//IF TAG START 8_1ac47f
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
						//IF TAG START 9_7cc8f3
=======
						//IF TAG START 9_478f0f
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
<<<<<<< TREE
						}//IF TAG END 9_7cc8f3
=======
						}//IF TAG END 9_478f0f
>>>>>>> MERGE-SOURCE
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
<<<<<<< TREE
						//IF TAG START 10_919363
=======
						//IF TAG START 10_90bec3
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
<<<<<<< TREE
						}//IF TAG END 10_919363
=======
						}//IF TAG END 10_90bec3
>>>>>>> MERGE-SOURCE
					}
<<<<<<< TREE
				}//IF TAG END 8_daaa21
				//IF TAG START 11_a8f352
=======
				}//IF TAG END 8_1ac47f
				//IF TAG START 11_c077c0
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
<<<<<<< TREE
						//IF TAG START 12_1a3cf9
=======
						//IF TAG START 12_c60feb
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
						}//IF TAG END 12_1a3cf9
						//IF TAG START 13_c482b2
=======
						}//IF TAG END 12_c60feb
						//IF TAG START 13_ab7d70
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
						}//IF TAG END 13_c482b2
=======
						}//IF TAG END 13_ab7d70
>>>>>>> MERGE-SOURCE
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 11_a8f352
				//IF TAG START 14_54ecbd
=======
				}//IF TAG END 11_c077c0
				//IF TAG START 14_053f39
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
						//IF TAG START 15_a48368
=======
						//IF TAG START 15_a349d8
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
<<<<<<< TREE
						}//IF TAG END 15_a48368
=======
						}//IF TAG END 15_a349d8
>>>>>>> MERGE-SOURCE
					}
<<<<<<< TREE
				}//IF TAG END 14_54ecbd
				//IF TAG START 16_a7c722
=======
				}//IF TAG END 14_053f39
				//IF TAG START 16_284102
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadow\">
						";
<<<<<<< TREE
						//IF TAG START 17_ecae38
=======
						//IF TAG START 17_d214a1
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
						}//IF TAG END 17_ecae38
						//IF TAG START 18_bb8e88
=======
						}//IF TAG END 17_d214a1
						//IF TAG START 18_66f3d4
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
						}//IF TAG END 18_bb8e88
=======
						}//IF TAG END 18_66f3d4
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 16_a7c722
=======
				}//IF TAG END 16_284102
>>>>>>> MERGE-SOURCE
				$content .="
				</div>
				<div class=\"mediadesc\">
				Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
<<<<<<< TREE
				//IF TAG START 19_f6d255
=======
				//IF TAG START 19_754d51
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
<<<<<<< TREE
				}//IF TAG END 19_f6d255
=======
				}//IF TAG END 19_754d51
>>>>>>> MERGE-SOURCE
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
<<<<<<< TREE
				//IF TAG START 20_c9314c
=======
				//IF TAG START 20_856f20
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
<<<<<<< TREE
						//FUNCTION TAG START 21_ef0397
						$parameters_21_ef0397 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
						//FUNCTION TAG START 21_13aba9
						$parameters_21_13aba9 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_ef0397, array (
=======
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_13aba9, array (
>>>>>>> MERGE-SOURCE
								0 =>
								array (
									'textnode' => '
									',
								),
								1 =>
								array (
									'nodename' => 'pages',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'textnode' => '{n}',
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								2 =>
								array (
									'textnode' => '
									',
								),
								3 =>
								array (
									'nodename' => 'currentpage',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'strong',
											'attributes' =>
											array (
											),
											'childrens' =>
											array (
												0 =>
												array (
													'textnode' => '{n}',
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								4 =>
								array (
									'textnode' => '
									',
								),
								5 =>
								array (
									'nodename' => 'previous',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => 'img/demo/interieur/newsPrevious.gif',
														'alt' => 'Page pr&eacute;c&eacute;dente',
														'title' => 'Page pr&eacute;c&eacute;dente',
													),
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								6 =>
								array (
									'textnode' => '
									',
								),
								7 =>
								array (
									'nodename' => 'next',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => 'img/demo/interieur/newsNext.gif',
														'alt' => 'Page suivante',
														'title' => 'Page suivante',
													),
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								8 =>
								array (
									'textnode' => '
									',
								),
							)), $replace);
						} else {
							CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
						}
<<<<<<< TREE
						//FUNCTION TAG END 21_ef0397
=======
						//FUNCTION TAG END 21_13aba9
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 20_c9314c
				$count_5_d24c99++;
=======
				}//IF TAG END 20_856f20
				$count_5_ae68e1++;
>>>>>>> MERGE-SOURCE
				//do all result vars replacement
<<<<<<< TREE
				$content_5_d24c99.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
				$content_5_ae68e1.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
			}
<<<<<<< TREE
			$content = $content_5_d24c99; //retrieve previous content var if any
			$replace = $replace_5_d24c99; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_5_d24c99; //retrieve previous object search if any
=======
			$content = $content_5_ae68e1; //retrieve previous content var if any
			$replace = $replace_5_ae68e1; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_5_ae68e1; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		//RESULT mediaresult TAG END 5_d24c99
		//NO-RESULT mediaresult TAG START 22_faed1b
=======
		//RESULT mediaresult TAG END 5_ae68e1
		//NO-RESULT mediaresult TAG START 22_0e9451
>>>>>>> MERGE-SOURCE
		//launch search mediaresult if not already done
		if($launchSearch_mediaresult && !isset($results_mediaresult)) {
			if (isset($search_mediaresult)) {
				$results_mediaresult = $search_mediaresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
				$results_mediaresult = array();
			}
		} elseif (!$launchSearch_mediaresult) {
			$results_mediaresult = array();
		}
		if (!$results_mediaresult) {
			$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
		}
<<<<<<< TREE
		//NO-RESULT mediaresult TAG END 22_faed1b
=======
		//NO-RESULT mediaresult TAG END 22_0e9451
>>>>>>> MERGE-SOURCE
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
<<<<<<< TREE
		//SEARCH mediaresult TAG END 4_8b8ade
		//AJAX TAG END 3_d4dcfb
=======
		//SEARCH mediaresult TAG END 4_70c271
		//AJAX TAG END 3_989692
>>>>>>> MERGE-SOURCE
		//output XML response
		$view = CMS_view::getInstance();
		$view->setDisplayMode(CMS_view::SHOW_RAW);
		$view->setContentTag('data');
		$view->setContent(CMS_polymod_definition_parsing::replaceVars($content, $replace));
		$view->show();
	}
}

$content = "";
$replace = "";
if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
$blockAttributes = array (
  'module' => 'pmedia',
  'language' => 'fr',
);
$parameters['pageID'] = '6';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
$parameters['module'] = 'pmedia';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
<<<<<<< TREE
		//AJAX TAG START 24_e982c6
		//SEARCH mediaresult TAG START 25_9baf91
=======
		//AJAX TAG START 24_4c3e51
		//SEARCH mediaresult TAG START 25_9f5c3a
>>>>>>> MERGE-SOURCE
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
<<<<<<< TREE
		$public_25_9baf91 = isset($public_search) ? $public_search : false;
=======
		$public_25_9f5c3a = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
		//get search params
<<<<<<< TREE
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_9baf91);
=======
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_9f5c3a);
>>>>>>> MERGE-SOURCE
		$launchSearch_mediaresult = true;
		//add search conditions if any
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 8,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$search_mediaresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_mediaresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_mediaresult->addOrderCondition("objectID", "desc");
<<<<<<< TREE
		//RESULT mediaresult TAG START 26_19a411
=======
		//RESULT mediaresult TAG START 26_8117af
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
			$object_26_19a411 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_26_19a411 = $replace; //save previous replace vars if any
			$count_26_19a411 = 0;
			$content_26_19a411 = $content; //save previous content var if any
			$maxPages_26_19a411 = $search_mediaresult->getMaxPages();
			$maxResults_26_19a411 = $search_mediaresult->getNumRows();
=======
			$object_26_8117af = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_26_8117af = $replace; //save previous replace vars if any
			$count_26_8117af = 0;
			$content_26_8117af = $content; //save previous content var if any
			$maxPages_26_8117af = $search_mediaresult->getMaxPages();
			$maxResults_26_8117af = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
					"{firstresult}" => (!$count_26_19a411) ? 1 : 0,
					"{lastresult}" 	=> ($count_26_19a411 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_26_19a411+1),
					"{maxpages}"    => $maxPages_26_19a411,
=======
					"{firstresult}" => (!$count_26_8117af) ? 1 : 0,
					"{lastresult}" 	=> ($count_26_8117af == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_26_8117af+1),
					"{maxpages}"    => $maxPages_26_8117af,
>>>>>>> MERGE-SOURCE
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
					"{maxresults}"  => $maxResults_26_19a411,
=======
					"{maxresults}"  => $maxResults_26_8117af,
>>>>>>> MERGE-SOURCE
				);
<<<<<<< TREE
				//IF TAG START 27_b0290c
=======
				//IF TAG START 27_d1df60
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 27_b0290c
=======
				}//IF TAG END 27_d1df60
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
<<<<<<< TREE
				//IF TAG START 28_b6a279
=======
				//IF TAG START 28_bcdc8e
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
<<<<<<< TREE
				}//IF TAG END 28_b6a279
=======
				}//IF TAG END 28_bcdc8e
>>>>>>> MERGE-SOURCE
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
<<<<<<< TREE
				//IF TAG START 29_587286
=======
				//IF TAG START 29_39d0e3
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
						//IF TAG START 30_526f10
=======
						//IF TAG START 30_7ae123
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
<<<<<<< TREE
						}//IF TAG END 30_526f10
=======
						}//IF TAG END 30_7ae123
>>>>>>> MERGE-SOURCE
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
<<<<<<< TREE
						//IF TAG START 31_2914bb
=======
						//IF TAG START 31_cb9c7d
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
<<<<<<< TREE
						}//IF TAG END 31_2914bb
=======
						}//IF TAG END 31_cb9c7d
>>>>>>> MERGE-SOURCE
					}
<<<<<<< TREE
				}//IF TAG END 29_587286
				//IF TAG START 32_0b8383
=======
				}//IF TAG END 29_39d0e3
				//IF TAG START 32_4e33a5
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
<<<<<<< TREE
						//IF TAG START 33_e3aa4f
=======
						//IF TAG START 33_0bacb2
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
						}//IF TAG END 33_e3aa4f
						//IF TAG START 34_93d276
=======
						}//IF TAG END 33_0bacb2
						//IF TAG START 34_e9d668
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
						}//IF TAG END 34_93d276
=======
						}//IF TAG END 34_e9d668
>>>>>>> MERGE-SOURCE
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 32_0b8383
				//IF TAG START 35_536730
=======
				}//IF TAG END 32_4e33a5
				//IF TAG START 35_72e168
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
						//IF TAG START 36_a75bb5
=======
						//IF TAG START 36_2a4535
>>>>>>> MERGE-SOURCE
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
<<<<<<< TREE
						}//IF TAG END 36_a75bb5
=======
						}//IF TAG END 36_2a4535
>>>>>>> MERGE-SOURCE
					}
<<<<<<< TREE
				}//IF TAG END 35_536730
				//IF TAG START 37_e25b2c
=======
				}//IF TAG END 35_72e168
				//IF TAG START 37_e42a19
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadow\">
						";
<<<<<<< TREE
						//IF TAG START 38_4dbe50
=======
						//IF TAG START 38_e8cace
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
						}//IF TAG END 38_4dbe50
						//IF TAG START 39_6204b2
=======
						}//IF TAG END 38_e8cace
						//IF TAG START 39_2d479e
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
						}//IF TAG END 39_6204b2
=======
						}//IF TAG END 39_2d479e
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 37_e25b2c
=======
				}//IF TAG END 37_e42a19
>>>>>>> MERGE-SOURCE
				$content .="
				</div>
				<div class=\"mediadesc\">
				Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
<<<<<<< TREE
				//IF TAG START 40_232566
=======
				//IF TAG START 40_52748b
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
<<<<<<< TREE
				}//IF TAG END 40_232566
=======
				}//IF TAG END 40_52748b
>>>>>>> MERGE-SOURCE
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
<<<<<<< TREE
				//IF TAG START 41_b3ab59
=======
				//IF TAG START 41_22a0f1
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
<<<<<<< TREE
						//FUNCTION TAG START 42_451178
						$parameters_42_451178 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
						//FUNCTION TAG START 42_a2929c
						$parameters_42_a2929c = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_451178, array (
=======
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_a2929c, array (
>>>>>>> MERGE-SOURCE
								0 =>
								array (
									'textnode' => '
									',
								),
								1 =>
								array (
									'nodename' => 'pages',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'textnode' => '{n}',
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								2 =>
								array (
									'textnode' => '
									',
								),
								3 =>
								array (
									'nodename' => 'currentpage',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'strong',
											'attributes' =>
											array (
											),
											'childrens' =>
											array (
												0 =>
												array (
													'textnode' => '{n}',
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								4 =>
								array (
									'textnode' => '
									',
								),
								5 =>
								array (
									'nodename' => 'previous',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => 'img/demo/interieur/newsPrevious.gif',
														'alt' => 'Page pr&eacute;c&eacute;dente',
														'title' => 'Page pr&eacute;c&eacute;dente',
													),
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								6 =>
								array (
									'textnode' => '
									',
								),
								7 =>
								array (
									'nodename' => 'next',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'a',
											'attributes' =>
											array (
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => 'img/demo/interieur/newsNext.gif',
														'alt' => 'Page suivante',
														'title' => 'Page suivante',
													),
												),
											),
										),
										1 =>
										array (
											'textnode' => ' ',
										),
									),
								),
								8 =>
								array (
									'textnode' => '
									',
								),
							)), $replace);
						} else {
							CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
						}
<<<<<<< TREE
						//FUNCTION TAG END 42_451178
=======
						//FUNCTION TAG END 42_a2929c
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 41_b3ab59
				$count_26_19a411++;
=======
				}//IF TAG END 41_22a0f1
				$count_26_8117af++;
>>>>>>> MERGE-SOURCE
				//do all result vars replacement
<<<<<<< TREE
				$content_26_19a411.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
				$content_26_8117af.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
			}
<<<<<<< TREE
			$content = $content_26_19a411; //retrieve previous content var if any
			$replace = $replace_26_19a411; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_26_19a411; //retrieve previous object search if any
=======
			$content = $content_26_8117af; //retrieve previous content var if any
			$replace = $replace_26_8117af; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_26_8117af; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		//RESULT mediaresult TAG END 26_19a411
		//NO-RESULT mediaresult TAG START 43_551515
=======
		//RESULT mediaresult TAG END 26_8117af
		//NO-RESULT mediaresult TAG START 43_43e404
>>>>>>> MERGE-SOURCE
		//launch search mediaresult if not already done
		if($launchSearch_mediaresult && !isset($results_mediaresult)) {
			if (isset($search_mediaresult)) {
				$results_mediaresult = $search_mediaresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
				$results_mediaresult = array();
			}
		} elseif (!$launchSearch_mediaresult) {
			$results_mediaresult = array();
		}
		if (!$results_mediaresult) {
			$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
		}
<<<<<<< TREE
		//NO-RESULT mediaresult TAG END 43_551515
=======
		//NO-RESULT mediaresult TAG END 43_43e404
>>>>>>> MERGE-SOURCE
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
<<<<<<< TREE
		//SEARCH mediaresult TAG END 25_9baf91
		//AJAX TAG END 24_e982c6
=======
		//SEARCH mediaresult TAG END 25_9f5c3a
		//AJAX TAG END 24_4c3e51
>>>>>>> MERGE-SOURCE
		//output XML response
		$view = CMS_view::getInstance();
		$view->setDisplayMode(CMS_view::SHOW_RAW);
		$view->setContentTag('data');
		$view->setContent(CMS_polymod_definition_parsing::replaceVars($content, $replace));
		$view->show();
	}
}

						//output empty XML response
						$view = CMS_view::getInstance();
						//set default display mode for this page
						$view->setDisplayMode(CMS_view::SHOW_RAW);
						$view->setContentTag('data');
						$view->setContent('');
						$view->show();
=======
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {
$cms_view = CMS_view::getInstance();
//set default display mode for this page
$cms_view->setDisplayMode(CMS_view::SHOW_RAW);
$cms_view->setContentTag('data');
$cache_0d0fcbbbbbe713d8efb14e7bf1fab208 = new CMS_cache('0d0fcbbbbbe713d8efb14e7bf1fab208', 'polymod', 'auto', true);
if ($cache_0d0fcbbbbbe713d8efb14e7bf1fab208->exist()):
	//Get content from cache
	$cache_0d0fcbbbbbe713d8efb14e7bf1fab208_content = $cache_0d0fcbbbbbe713d8efb14e7bf1fab208->load();
else:
	$cache_0d0fcbbbbbe713d8efb14e7bf1fab208->start();

$content = "";
$replace = "";
$atmIfResults = array();
if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
$blockAttributes = array (
  'module' => 'pmedia',
  'language' => 'fr',
);
$parameters['pageID'] = '6';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
$parameters['module'] = 'pmedia';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
		//AJAX TAG START 3_4bfb68
		//SEARCH mediaresult TAG START 4_47b18d
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_4_47b18d = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_47b18d);
		$launchSearch_mediaresult = true;
		//add search conditions if any
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 8,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$search_mediaresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_mediaresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_mediaresult->addOrderCondition("objectID", "desc");
		//RESULT mediaresult TAG START 5_99a202
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
			$object_5_99a202 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_5_99a202 = $replace; //save previous replace vars if any
			$count_5_99a202 = 0;
			$content_5_99a202 = $content; //save previous content var if any
			$maxPages_5_99a202 = $search_mediaresult->getMaxPages();
			$maxResults_5_99a202 = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_5_99a202) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_99a202 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_99a202+1),
					"{maxpages}"    => $maxPages_5_99a202,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_99a202,
					"{altclass}"    => (($count_5_99a202+1) % 2) ? "CMS_odd" : "CMS_even",
				);
				//IF TAG START 6_14b48a
				$ifcondition_6_14b48a = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_6_14b48a) {
					$func_6_14b48a = create_function("","return (".$ifcondition_6_14b48a.");");
					if ($func_6_14b48a()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
					unset($func_6_14b48a);
				}
				unset($ifcondition_6_14b48a);
				//IF TAG END 6_14b48a
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 7_cd66bd
				$ifcondition_7_cd66bd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition_7_cd66bd) {
					$func_7_cd66bd = create_function("","return (".$ifcondition_7_cd66bd.");");
					if ($func_7_cd66bd()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
					unset($func_7_cd66bd);
				}
				unset($ifcondition_7_cd66bd);
				//IF TAG END 7_cd66bd
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 8_341e28
				$ifcondition_8_341e28 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition_8_341e28) {
					$func_8_341e28 = create_function("","return (".$ifcondition_8_341e28.");");
					if ($func_8_341e28()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 9_1dbb0c
						$ifcondition_9_1dbb0c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition_9_1dbb0c) {
							$func_9_1dbb0c = create_function("","return (".$ifcondition_9_1dbb0c.");");
							if ($func_9_1dbb0c()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
							unset($func_9_1dbb0c);
						}
						unset($ifcondition_9_1dbb0c);
						//IF TAG END 9_1dbb0c
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 10_93342e
						$ifcondition_10_93342e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition_10_93342e) {
							$func_10_93342e = create_function("","return (".$ifcondition_10_93342e.");");
							if ($func_10_93342e()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
							unset($func_10_93342e);
						}
						unset($ifcondition_10_93342e);
						//IF TAG END 10_93342e
					}
					unset($func_8_341e28);
				}
				unset($ifcondition_8_341e28);
				//IF TAG END 8_341e28
				//IF TAG START 11_2328a9
				$ifcondition_11_2328a9 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition_11_2328a9) {
					$func_11_2328a9 = create_function("","return (".$ifcondition_11_2328a9.");");
					if ($func_11_2328a9()) {
						//IF TAG START 12_2d04db
						$ifcondition_12_2d04db = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition_12_2d04db) {
							$func_12_2d04db = create_function("","return (".$ifcondition_12_2d04db.");");$atmIfResults['thumbnail']['if'] = false;
							if ($func_12_2d04db()) {$atmIfResults['thumbnail']['if'] = true;
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_12_2d04db);
					}
					unset($ifcondition_12_2d04db);
					//IF TAG END 12_2d04db
					//ELSE TAG START 13_504e26
					if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
						$content .="
						<script type=\"text/javascript\">
						swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
						</script>
						";
					}
					//ELSE TAG END 13_504e26
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_11_2328a9);
			}
			unset($ifcondition_11_2328a9);
			//IF TAG END 11_2328a9
			//IF TAG START 14_9496d2
			$ifcondition_14_9496d2 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_14_9496d2) {
				$func_14_9496d2 = create_function("","return (".$ifcondition_14_9496d2.");");
				if ($func_14_9496d2()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 15_eea003
					$ifcondition_15_eea003 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_15_eea003) {
						$func_15_eea003 = create_function("","return (".$ifcondition_15_eea003.");");
						if ($func_15_eea003()) {
							$content .="
							<div class=\"imgLeft shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_15_eea003);
					}
					unset($ifcondition_15_eea003);
					//IF TAG END 15_eea003
				}
				unset($func_14_9496d2);
			}
			unset($ifcondition_14_9496d2);
			//IF TAG END 14_9496d2
			//IF TAG START 16_4f8edb
			$ifcondition_16_4f8edb = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_16_4f8edb) {
				$func_16_4f8edb = create_function("","return (".$ifcondition_16_4f8edb.");");
				if ($func_16_4f8edb()) {
					$content .="
					<div class=\"imgLeft shadow\">
					";
					//IF TAG START 17_9a2056
					$ifcondition_17_9a2056 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_17_9a2056) {
						$func_17_9a2056 = create_function("","return (".$ifcondition_17_9a2056.");");$atmIfResults['thumbnail']['if'] = false;
						if ($func_17_9a2056()) {$atmIfResults['thumbnail']['if'] = true;
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
						";
					}
					unset($func_17_9a2056);
				}
				unset($ifcondition_17_9a2056);
				//IF TAG END 17_9a2056
				//ELSE TAG START 18_56bc69
				if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
					$content .="
					<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
					";
				}
				//ELSE TAG END 18_56bc69
				$content .="
				</div>
				";
			}
			unset($func_16_4f8edb);
		}
		unset($ifcondition_16_4f8edb);
		//IF TAG END 16_4f8edb
		$content .="
		</div>
		<div class=\"mediadesc\">
		Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
		Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
		T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
		";
		//IF TAG START 19_d60b93
		$ifcondition_19_d60b93 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
		if ($ifcondition_19_d60b93) {
			$func_19_d60b93 = create_function("","return (".$ifcondition_19_d60b93.");");
			if ($func_19_d60b93()) {
				$content .="
				".$object[2]->objectValues(7)->getValue('value','')."
				";
			}
			unset($func_19_d60b93);
		}
		unset($ifcondition_19_d60b93);
		//IF TAG END 19_d60b93
		$content .="
		</div>
		<div class=\"spacer\"></div>
		</div>
		</div>
		</div>
		";
		//IF TAG START 20_87692e
		$ifcondition_20_87692e = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition_20_87692e) {
			$func_20_87692e = create_function("","return (".$ifcondition_20_87692e.");");
			if ($func_20_87692e()) {
				$content .="
				<div class=\"pages\" id=\"pages\">
				";
				//FUNCTION TAG START 21_b16cb9
				$parameters_21_b16cb9 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
				if (method_exists(new CMS_poly_definition_functions(), "pages")) {
					$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_b16cb9, array (
						0 =>
						array (
							'textnode' => '
							',
						),
						1 =>
						array (
							'nodename' => 'pages',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'textnode' => '{n}',
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						2 =>
						array (
							'textnode' => '
							',
						),
						3 =>
						array (
							'nodename' => 'currentpage',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'strong',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'textnode' => '{n}',
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						4 =>
						array (
							'textnode' => '
							',
						),
						5 =>
						array (
							'nodename' => 'previous',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/demo/interieur/newsPrevious.gif',
												'alt' => 'Page pr&eacute;c&eacute;dente',
												'title' => 'Page pr&eacute;c&eacute;dente',
											),
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						6 =>
						array (
							'textnode' => '
							',
						),
						7 =>
						array (
							'nodename' => 'next',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/demo/interieur/newsNext.gif',
												'alt' => 'Page suivante',
												'title' => 'Page suivante',
											),
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						8 =>
						array (
							'textnode' => '
							',
						),
					)), $replace);
				} else {
					CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
				}
				//FUNCTION TAG END 21_b16cb9
				$content .="
				</div>
				";
			}
			unset($func_20_87692e);
		}
		unset($ifcondition_20_87692e);
		//IF TAG END 20_87692e
		$count_5_99a202++;
		//do all result vars replacement
		$content_5_99a202.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
	$content = $content_5_99a202; //retrieve previous content var if any
	unset($content_5_99a202);
	$replace = $replace_5_99a202; //retrieve previous replace vars if any
	unset($replace_5_99a202);
	$object[$objectDefinition_mediaresult] = $object_5_99a202; //retrieve previous object search if any
	unset($object_5_99a202);
}
//RESULT mediaresult TAG END 5_99a202
//NO-RESULT mediaresult TAG START 22_ca97f5
//launch search mediaresult if not already done
if($launchSearch_mediaresult && !isset($results_mediaresult)) {
	if (isset($search_mediaresult)) {
		$results_mediaresult = $search_mediaresult->search();
	} else {
		CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
		$results_mediaresult = array();
	}
} elseif (!$launchSearch_mediaresult) {
	$results_mediaresult = array();
}
if (!$results_mediaresult) {
	$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
}
//NO-RESULT mediaresult TAG END 22_ca97f5
//destroy search and results mediaresult objects
unset($search_mediaresult);
unset($results_mediaresult);
//SEARCH mediaresult TAG END 4_47b18d
//AJAX TAG END 3_4bfb68
//set view format
$cms_view->setDisplayMode(CMS_view::SHOW_RAW);
$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
		}
$content .= '<!--{elements:'.base64_encode(serialize(array (
  'module' => 
  array (
    0 => 'standard',
    1 => 'standard',
    2 => 'standard',
    3 => 'standard',
    4 => 'pmedia',
  ),
))).'}-->';


	echo $content;
	$cache_0d0fcbbbbbe713d8efb14e7bf1fab208_content = $cache_0d0fcbbbbbe713d8efb14e7bf1fab208->endSave();
endif;
unset($cache_0d0fcbbbbbe713d8efb14e7bf1fab208);
$content = $cache_0d0fcbbbbbe713d8efb14e7bf1fab208_content;
unset($cache_0d0fcbbbbbe713d8efb14e7bf1fab208_content);
$cache_d70fe97e5582537d8f2cbffd937947d5 = new CMS_cache('d70fe97e5582537d8f2cbffd937947d5', 'polymod', 'auto', true);
if ($cache_d70fe97e5582537d8f2cbffd937947d5->exist()):
	//Get content from cache
	$cache_d70fe97e5582537d8f2cbffd937947d5_content = $cache_d70fe97e5582537d8f2cbffd937947d5->load();
else:
	$cache_d70fe97e5582537d8f2cbffd937947d5->start();

$content = "";
$replace = "";
$atmIfResults = array();
if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
$blockAttributes = array (
  'module' => 'pmedia',
  'language' => 'fr',
);
$parameters['pageID'] = '6';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
$parameters['module'] = 'pmedia';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
		//AJAX TAG START 24_8138c1
		//SEARCH mediaresult TAG START 25_66e69e
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_25_66e69e = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_66e69e);
		$launchSearch_mediaresult = true;
		//add search conditions if any
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 8,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
			'search' => 'mediaresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_mediaresult : false;
		$search_mediaresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_mediaresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_mediaresult->addOrderCondition("objectID", "desc");
		//RESULT mediaresult TAG START 26_f2d040
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
			$object_26_f2d040 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_26_f2d040 = $replace; //save previous replace vars if any
			$count_26_f2d040 = 0;
			$content_26_f2d040 = $content; //save previous content var if any
			$maxPages_26_f2d040 = $search_mediaresult->getMaxPages();
			$maxResults_26_f2d040 = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_26_f2d040) ? 1 : 0,
					"{lastresult}" 	=> ($count_26_f2d040 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_26_f2d040+1),
					"{maxpages}"    => $maxPages_26_f2d040,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_26_f2d040,
					"{altclass}"    => (($count_26_f2d040+1) % 2) ? "CMS_odd" : "CMS_even",
				);
				//IF TAG START 27_d29e35
				$ifcondition_27_d29e35 = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_27_d29e35) {
					$func_27_d29e35 = create_function("","return (".$ifcondition_27_d29e35.");");
					if ($func_27_d29e35()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
					unset($func_27_d29e35);
				}
				unset($ifcondition_27_d29e35);
				//IF TAG END 27_d29e35
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 28_81b8fa
				$ifcondition_28_81b8fa = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition_28_81b8fa) {
					$func_28_81b8fa = create_function("","return (".$ifcondition_28_81b8fa.");");
					if ($func_28_81b8fa()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
					unset($func_28_81b8fa);
				}
				unset($ifcondition_28_81b8fa);
				//IF TAG END 28_81b8fa
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 29_0737c1
				$ifcondition_29_0737c1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition_29_0737c1) {
					$func_29_0737c1 = create_function("","return (".$ifcondition_29_0737c1.");");
					if ($func_29_0737c1()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 30_df1a2c
						$ifcondition_30_df1a2c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition_30_df1a2c) {
							$func_30_df1a2c = create_function("","return (".$ifcondition_30_df1a2c.");");
							if ($func_30_df1a2c()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
							unset($func_30_df1a2c);
						}
						unset($ifcondition_30_df1a2c);
						//IF TAG END 30_df1a2c
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 31_0b7fd0
						$ifcondition_31_0b7fd0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition_31_0b7fd0) {
							$func_31_0b7fd0 = create_function("","return (".$ifcondition_31_0b7fd0.");");
							if ($func_31_0b7fd0()) {
								$content .="
								<div class=\"imgLeft shadow\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								";
							}
							unset($func_31_0b7fd0);
						}
						unset($ifcondition_31_0b7fd0);
						//IF TAG END 31_0b7fd0
					}
					unset($func_29_0737c1);
				}
				unset($ifcondition_29_0737c1);
				//IF TAG END 29_0737c1
				//IF TAG START 32_d482a4
				$ifcondition_32_d482a4 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition_32_d482a4) {
					$func_32_d482a4 = create_function("","return (".$ifcondition_32_d482a4.");");
					if ($func_32_d482a4()) {
						//IF TAG START 33_9be3d0
						$ifcondition_33_9be3d0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition_33_9be3d0) {
							$func_33_9be3d0 = create_function("","return (".$ifcondition_33_9be3d0.");");$atmIfResults['thumbnail']['if'] = false;
							if ($func_33_9be3d0()) {$atmIfResults['thumbnail']['if'] = true;
							$content .="
							<script type=\"text/javascript\">
							swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
							</script>
							";
						}
						unset($func_33_9be3d0);
					}
					unset($ifcondition_33_9be3d0);
					//IF TAG END 33_9be3d0
					//ELSE TAG START 34_68f381
					if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
						$content .="
						<script type=\"text/javascript\">
						swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
						</script>
						";
					}
					//ELSE TAG END 34_68f381
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
				unset($func_32_d482a4);
			}
			unset($ifcondition_32_d482a4);
			//IF TAG END 32_d482a4
			//IF TAG START 35_ac941a
			$ifcondition_35_ac941a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition_35_ac941a) {
				$func_35_ac941a = create_function("","return (".$ifcondition_35_ac941a.");");
				if ($func_35_ac941a()) {
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
					</script>
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
					//IF TAG START 36_031908
					$ifcondition_36_031908 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_36_031908) {
						$func_36_031908 = create_function("","return (".$ifcondition_36_031908.");");
						if ($func_36_031908()) {
							$content .="
							<div class=\"imgLeft shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
						unset($func_36_031908);
					}
					unset($ifcondition_36_031908);
					//IF TAG END 36_031908
				}
				unset($func_35_ac941a);
			}
			unset($ifcondition_35_ac941a);
			//IF TAG END 35_ac941a
			//IF TAG START 37_02e306
			$ifcondition_37_02e306 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition_37_02e306) {
				$func_37_02e306 = create_function("","return (".$ifcondition_37_02e306.");");
				if ($func_37_02e306()) {
					$content .="
					<div class=\"imgLeft shadow\">
					";
					//IF TAG START 38_5a11fc
					$ifcondition_38_5a11fc = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_38_5a11fc) {
						$func_38_5a11fc = create_function("","return (".$ifcondition_38_5a11fc.");");$atmIfResults['thumbnail']['if'] = false;
						if ($func_38_5a11fc()) {$atmIfResults['thumbnail']['if'] = true;
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
						";
					}
					unset($func_38_5a11fc);
				}
				unset($ifcondition_38_5a11fc);
				//IF TAG END 38_5a11fc
				//ELSE TAG START 39_126403
				if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
					$content .="
					<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
					";
				}
				//ELSE TAG END 39_126403
				$content .="
				</div>
				";
			}
			unset($func_37_02e306);
		}
		unset($ifcondition_37_02e306);
		//IF TAG END 37_02e306
		$content .="
		</div>
		<div class=\"mediadesc\">
		Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
		Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
		T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
		";
		//IF TAG START 40_7371ac
		$ifcondition_40_7371ac = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
		if ($ifcondition_40_7371ac) {
			$func_40_7371ac = create_function("","return (".$ifcondition_40_7371ac.");");
			if ($func_40_7371ac()) {
				$content .="
				".$object[2]->objectValues(7)->getValue('value','')."
				";
			}
			unset($func_40_7371ac);
		}
		unset($ifcondition_40_7371ac);
		//IF TAG END 40_7371ac
		$content .="
		</div>
		<div class=\"spacer\"></div>
		</div>
		</div>
		</div>
		";
		//IF TAG START 41_6e131a
		$ifcondition_41_6e131a = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition_41_6e131a) {
			$func_41_6e131a = create_function("","return (".$ifcondition_41_6e131a.");");
			if ($func_41_6e131a()) {
				$content .="
				<div class=\"pages\" id=\"pages\">
				";
				//FUNCTION TAG START 42_4aedee
				$parameters_42_4aedee = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
				if (method_exists(new CMS_poly_definition_functions(), "pages")) {
					$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_4aedee, array (
						0 =>
						array (
							'textnode' => '
							',
						),
						1 =>
						array (
							'nodename' => 'pages',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'textnode' => '{n}',
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						2 =>
						array (
							'textnode' => '
							',
						),
						3 =>
						array (
							'nodename' => 'currentpage',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'strong',
									'attributes' =>
									array (
									),
									'childrens' =>
									array (
										0 =>
										array (
											'textnode' => '{n}',
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						4 =>
						array (
							'textnode' => '
							',
						),
						5 =>
						array (
							'nodename' => 'previous',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/demo/interieur/newsPrevious.gif',
												'alt' => 'Page pr&eacute;c&eacute;dente',
												'title' => 'Page pr&eacute;c&eacute;dente',
											),
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						6 =>
						array (
							'textnode' => '
							',
						),
						7 =>
						array (
							'nodename' => 'next',
							'attributes' =>
							array (
							),
							'childrens' =>
							array (
								0 =>
								array (
									'nodename' => 'a',
									'attributes' =>
									array (
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/demo/interieur/newsNext.gif',
												'alt' => 'Page suivante',
												'title' => 'Page suivante',
											),
										),
									),
								),
								1 =>
								array (
									'textnode' => ' ',
								),
							),
						),
						8 =>
						array (
							'textnode' => '
							',
						),
					)), $replace);
				} else {
					CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
				}
				//FUNCTION TAG END 42_4aedee
				$content .="
				</div>
				";
			}
			unset($func_41_6e131a);
		}
		unset($ifcondition_41_6e131a);
		//IF TAG END 41_6e131a
		$count_26_f2d040++;
		//do all result vars replacement
		$content_26_f2d040.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
	$content = $content_26_f2d040; //retrieve previous content var if any
	unset($content_26_f2d040);
	$replace = $replace_26_f2d040; //retrieve previous replace vars if any
	unset($replace_26_f2d040);
	$object[$objectDefinition_mediaresult] = $object_26_f2d040; //retrieve previous object search if any
	unset($object_26_f2d040);
}
//RESULT mediaresult TAG END 26_f2d040
//NO-RESULT mediaresult TAG START 43_ac51ac
//launch search mediaresult if not already done
if($launchSearch_mediaresult && !isset($results_mediaresult)) {
	if (isset($search_mediaresult)) {
		$results_mediaresult = $search_mediaresult->search();
	} else {
		CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
		$results_mediaresult = array();
	}
} elseif (!$launchSearch_mediaresult) {
	$results_mediaresult = array();
}
if (!$results_mediaresult) {
	$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
}
//NO-RESULT mediaresult TAG END 43_ac51ac
//destroy search and results mediaresult objects
unset($search_mediaresult);
unset($results_mediaresult);
//SEARCH mediaresult TAG END 25_66e69e
//AJAX TAG END 24_8138c1
//set view format
$cms_view->setDisplayMode(CMS_view::SHOW_RAW);
$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
		}
$content .= '<!--{elements:'.base64_encode(serialize(array (
  'module' => 
  array (
    0 => 'standard',
    1 => 'standard',
    2 => 'standard',
    3 => 'standard',
    4 => 'pmedia',
  ),
))).'}-->';


	echo $content;
	$cache_d70fe97e5582537d8f2cbffd937947d5_content = $cache_d70fe97e5582537d8f2cbffd937947d5->endSave();
endif;
unset($cache_d70fe97e5582537d8f2cbffd937947d5);
$content = $cache_d70fe97e5582537d8f2cbffd937947d5_content;
unset($cache_d70fe97e5582537d8f2cbffd937947d5_content);
$cms_view->setContent($content);
//output empty XML response
unset($content);
$cms_view->show();
>>>>>>> MERGE-SOURCE
}  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Médiathèque</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Médiathèque</h1>
<h3>

		&raquo;&nbsp;Exemples de modules
		
		&raquo;&nbsp;Médiathèque
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [650 [Médiathèque] Recherche - r68_650_Mediatheque.xml] */   ?>
	<?php $cache_6c03061c1c2e3400bed277795c6d3726 = new CMS_cache('6c03061c1c2e3400bed277795c6d3726', 'polymod', 'auto', true);
if ($cache_6c03061c1c2e3400bed277795c6d3726->exist()):
	//Get content from cache
	$cache_6c03061c1c2e3400bed277795c6d3726_content = $cache_6c03061c1c2e3400bed277795c6d3726->load();
else:
	$cache_6c03061c1c2e3400bed277795c6d3726->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 16:59:51 +0200 by Automne (TM) 4.0.2 */
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pmedia', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
	$atmIfResults = array();
	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
	$blockAttributes = array (
		'module' => 'pmedia',
		'language' => 'fr',
	);
	$parameters['pageID'] = '6';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters['public']);
	$parameters['module'] = 'pmedia';
	$content .="
	<div id=\"mediasearch\">
	<script type=\"text/javascript\">
	var pageURL = '".CMS_tree::getPageValue($parameters['pageID'],"url")."';
	</script>
	<form action=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."\" method=\"get\">
	<h2>Rechercher des documents et m&eacute;dias : </h2>
	<div class=\"mediaForm\">
	<div class=\"formKeywords\">
	<label for=\"keyword\">Mots Cl&eacute;s : </label><br /><input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"".CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword)."\" /><br />
	</div>
	<div class=\"formCat\">
	<label for=\"cat\">Cat&eacute;gorie : </label><br />
	<select id=\"cat\" name=\"cat\">
	<option value=\"\"> </option>
	";
<<<<<<< TREE
<<<<<<< TREE
	//FUNCTION TAG START 23_bdc5de
	$parameters_23_bdc5de = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_23_bdc5de = &$object[2]->objectValues(8);
	if (method_exists($object_23_bdc5de, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_23_bdc5de->selectOptions($parameters_23_bdc5de, NULL), $replace);
=======
	//FUNCTION TAG START 23_3a15d6
	$parameters_23_3a15d6 = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_23_3a15d6 = &$object[2]->objectValues(8);
	if (method_exists($object_23_3a15d6, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_23_3a15d6->selectOptions($parameters_23_3a15d6, NULL), $replace);
>>>>>>> MERGE-SOURCE
=======
	//FUNCTION TAG START 23_fa692a
	$parameters_23_fa692a = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_23_fa692a = &$object[2]->objectValues(8);
	if (method_exists($object_23_fa692a, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_23_fa692a->selectOptions($parameters_23_fa692a, NULL), $replace);
>>>>>>> MERGE-SOURCE
	} else {
<<<<<<< TREE
<<<<<<< TREE
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_23_bdc5de));
=======
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_23_3a15d6));
>>>>>>> MERGE-SOURCE
=======
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_23_fa692a));
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
<<<<<<< TREE
	//FUNCTION TAG END 23_bdc5de
=======
	//FUNCTION TAG END 23_3a15d6
>>>>>>> MERGE-SOURCE
=======
	//FUNCTION TAG END 23_fa692a
>>>>>>> MERGE-SOURCE
	$content .="
	</select>
	</div>
	<div id=\"loadingSearch\"><img src=\"img/demo/interieur/loading-media.gif\" alt=\"Chargement ...\" title=\"Chargement ...\" /></div>
	<input type=\"submit\" class=\"button\" name=\"search\" id=\"submitSearch\" value=\"ok\" />
	<div class=\"spacer\"></div>
	</div>
	</form>
	</div>
	<div id=\"searchresult\">
	";
<<<<<<< TREE
<<<<<<< TREE
	//AJAX TAG START 24_e982c6
	//SEARCH mediaresult TAG START 25_9baf91
=======
	//AJAX TAG START 24_4c3e51
	//SEARCH mediaresult TAG START 25_9f5c3a
>>>>>>> MERGE-SOURCE
=======
	//AJAX TAG START 24_8138c1
	//SEARCH mediaresult TAG START 25_66e69e
>>>>>>> MERGE-SOURCE
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
<<<<<<< TREE
<<<<<<< TREE
	$public_25_9baf91 = isset($public_search) ? $public_search : false;
=======
	$public_25_9f5c3a = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
=======
	$public_25_66e69e = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
<<<<<<< TREE
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_9baf91);
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_9f5c3a);
>>>>>>> MERGE-SOURCE
=======
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_66e69e);
>>>>>>> MERGE-SOURCE
	$launchSearch_mediaresult = true;
	//add search conditions if any
	$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
		'search' => 'mediaresult',
		'type' => 8,
		'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
		'mandatory' => 'false',
	))) ? $launchSearch_mediaresult : false;
	$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
		'search' => 'mediaresult',
		'type' => 'keywords',
		'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
		'mandatory' => 'false',
	))) ? $launchSearch_mediaresult : false;
	$launchSearch_mediaresult = (CMS_polymod_definition_parsing::addSearchCondition($search_mediaresult, array (
		'search' => 'mediaresult',
		'type' => 'item',
		'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
		'mandatory' => 'false',
	))) ? $launchSearch_mediaresult : false;
	$search_mediaresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
	$search_mediaresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
	$search_mediaresult->addOrderCondition("objectID", "desc");
<<<<<<< TREE
<<<<<<< TREE
	//RESULT mediaresult TAG START 26_19a411
=======
	//RESULT mediaresult TAG START 26_8117af
>>>>>>> MERGE-SOURCE
=======
	//RESULT mediaresult TAG START 26_f2d040
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
		$object_26_19a411 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_26_19a411 = $replace; //save previous replace vars if any
		$count_26_19a411 = 0;
		$content_26_19a411 = $content; //save previous content var if any
		$maxPages_26_19a411 = $search_mediaresult->getMaxPages();
		$maxResults_26_19a411 = $search_mediaresult->getNumRows();
=======
		$object_26_8117af = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_26_8117af = $replace; //save previous replace vars if any
		$count_26_8117af = 0;
		$content_26_8117af = $content; //save previous content var if any
		$maxPages_26_8117af = $search_mediaresult->getMaxPages();
		$maxResults_26_8117af = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
=======
		$object_26_f2d040 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_26_f2d040 = $replace; //save previous replace vars if any
		$count_26_f2d040 = 0;
		$content_26_f2d040 = $content; //save previous content var if any
		$maxPages_26_f2d040 = $search_mediaresult->getMaxPages();
		$maxResults_26_f2d040 = $search_mediaresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
<<<<<<< TREE
<<<<<<< TREE
				"{firstresult}" => (!$count_26_19a411) ? 1 : 0,
				"{lastresult}" 	=> ($count_26_19a411 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_26_19a411+1),
				"{maxpages}"    => $maxPages_26_19a411,
=======
				"{firstresult}" => (!$count_26_8117af) ? 1 : 0,
				"{lastresult}" 	=> ($count_26_8117af == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_26_8117af+1),
				"{maxpages}"    => $maxPages_26_8117af,
>>>>>>> MERGE-SOURCE
=======
				"{firstresult}" => (!$count_26_f2d040) ? 1 : 0,
				"{lastresult}" 	=> ($count_26_f2d040 == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_26_f2d040+1),
				"{maxpages}"    => $maxPages_26_f2d040,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
<<<<<<< TREE
<<<<<<< TREE
				"{maxresults}"  => $maxResults_26_19a411,
=======
				"{maxresults}"  => $maxResults_26_8117af,
>>>>>>> MERGE-SOURCE
=======
				"{maxresults}"  => $maxResults_26_f2d040,
				"{altclass}"    => (($count_26_f2d040+1) % 2) ? "CMS_odd" : "CMS_even",
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 27_b0290c
=======
			//IF TAG START 27_d1df60
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 27_d29e35
			$ifcondition_27_d29e35 = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition_27_d29e35) {
				$func_27_d29e35 = create_function("","return (".$ifcondition_27_d29e35.");");
				if ($func_27_d29e35()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 27_b0290c
=======
			}//IF TAG END 27_d1df60
>>>>>>> MERGE-SOURCE
=======
				unset($func_27_d29e35);
			}
			unset($ifcondition_27_d29e35);
			//IF TAG END 27_d29e35
>>>>>>> MERGE-SOURCE
			$content .="
			<div class=\"mediaTop\">
			<div class=\"mediaBottom\">
			<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 28_b6a279
=======
			//IF TAG START 28_bcdc8e
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 28_81b8fa
			$ifcondition_28_81b8fa = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
			if ($ifcondition_28_81b8fa) {
				$func_28_81b8fa = create_function("","return (".$ifcondition_28_81b8fa.");");
				if ($func_28_81b8fa()) {
>>>>>>> MERGE-SOURCE
					$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 28_b6a279
=======
			}//IF TAG END 28_bcdc8e
>>>>>>> MERGE-SOURCE
=======
				unset($func_28_81b8fa);
			}
			unset($ifcondition_28_81b8fa);
			//IF TAG END 28_81b8fa
>>>>>>> MERGE-SOURCE
			$content .="<div class=\"spacer\"></div>
			<div class=\"mediaContent\">
			<div class=\"mediafile\">
			";
<<<<<<< TREE
<<<<<<< TREE
			//IF TAG START 29_587286
=======
			//IF TAG START 29_39d0e3
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
			//IF TAG START 29_0737c1
			$ifcondition_29_0737c1 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition_29_0737c1) {
				$func_29_0737c1 = create_function("","return (".$ifcondition_29_0737c1.");");
				if ($func_29_0737c1()) {
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 30_526f10
=======
					//IF TAG START 30_7ae123
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 30_df1a2c
					$ifcondition_30_df1a2c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition_30_df1a2c) {
						$func_30_df1a2c = create_function("","return (".$ifcondition_30_df1a2c.");");
						if ($func_30_df1a2c()) {
>>>>>>> MERGE-SOURCE
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 30_526f10
=======
					}//IF TAG END 30_7ae123
>>>>>>> MERGE-SOURCE
=======
						unset($func_30_df1a2c);
					}
					unset($ifcondition_30_df1a2c);
					//IF TAG END 30_df1a2c
>>>>>>> MERGE-SOURCE
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
<<<<<<< TREE
<<<<<<< TREE
					//IF TAG START 31_2914bb
=======
					//IF TAG START 31_cb9c7d
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
=======
					//IF TAG START 31_0b7fd0
					$ifcondition_31_0b7fd0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_31_0b7fd0) {
						$func_31_0b7fd0 = create_function("","return (".$ifcondition_31_0b7fd0.");");
						if ($func_31_0b7fd0()) {
>>>>>>> MERGE-SOURCE
							$content .="
							<div class=\"imgLeft shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
<<<<<<< TREE
					}//IF TAG END 31_2914bb
=======
					}//IF TAG END 31_cb9c7d
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
			}//IF TAG END 29_587286
			//IF TAG START 32_0b8383
=======
			}//IF TAG END 29_39d0e3
			//IF TAG START 32_4e33a5
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
<<<<<<< TREE
					//IF TAG START 33_e3aa4f
=======
					//IF TAG START 33_0bacb2
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
					}//IF TAG END 33_e3aa4f
					//IF TAG START 34_93d276
=======
					}//IF TAG END 33_0bacb2
					//IF TAG START 34_e9d668
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
					}//IF TAG END 34_93d276
=======
					}//IF TAG END 34_e9d668
>>>>>>> MERGE-SOURCE
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
<<<<<<< TREE
			}//IF TAG END 32_0b8383
			//IF TAG START 35_536730
=======
			}//IF TAG END 32_4e33a5
			//IF TAG START 35_72e168
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
=======
						unset($func_31_0b7fd0);
					}
					unset($ifcondition_31_0b7fd0);
					//IF TAG END 31_0b7fd0
				}
				unset($func_29_0737c1);
			}
			unset($ifcondition_29_0737c1);
			//IF TAG END 29_0737c1
			//IF TAG START 32_d482a4
			$ifcondition_32_d482a4 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition_32_d482a4) {
				$func_32_d482a4 = create_function("","return (".$ifcondition_32_d482a4.");");
				if ($func_32_d482a4()) {
					//IF TAG START 33_9be3d0
					$ifcondition_33_9be3d0 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition_33_9be3d0) {
						$func_33_9be3d0 = create_function("","return (".$ifcondition_33_9be3d0.");");$atmIfResults['thumbnail']['if'] = false;
						if ($func_33_9be3d0()) {$atmIfResults['thumbnail']['if'] = true;
						$content .="
						<script type=\"text/javascript\">
						swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml', startimage:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."'}, {allowfullscreen:true, wmode:'transparent'}, false);
						</script>
						";
					}
					unset($func_33_9be3d0);
				}
				unset($ifcondition_33_9be3d0);
				//IF TAG END 33_9be3d0
				//ELSE TAG START 34_68f381
				if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
>>>>>>> MERGE-SOURCE
					$content .="
					<script type=\"text/javascript\">
					swfobject.embedSWF('/automne/playerflv/player_flv.swf', 'media-".$object[2]->getValue('id','')."', '320', '200', '9.0.0', '/automne/swfobject/expressInstall.swf', {flv:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playerflv/config_playerflv.xml'}, {allowfullscreen:true, wmode:'transparent'}, false);
					</script>
<<<<<<< TREE
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
<<<<<<< TREE
					//IF TAG START 36_a75bb5
=======
					//IF TAG START 36_2a4535
>>>>>>> MERGE-SOURCE
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<div class=\"imgLeft shadow\">
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
							</div>
							";
						}
<<<<<<< TREE
					}//IF TAG END 36_a75bb5
=======
					}//IF TAG END 36_2a4535
>>>>>>> MERGE-SOURCE
				}
<<<<<<< TREE
			}//IF TAG END 35_536730
			//IF TAG START 37_e25b2c
=======
			}//IF TAG END 35_72e168
			//IF TAG START 37_e42a19
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"imgLeft shadow\">
					";
<<<<<<< TREE
					//IF TAG START 38_4dbe50
=======
					//IF TAG START 38_e8cace
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
					}//IF TAG END 38_4dbe50
					//IF TAG START 39_6204b2
=======
					}//IF TAG END 38_e8cace
					//IF TAG START 39_2d479e
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
					}//IF TAG END 39_6204b2
=======
					}//IF TAG END 39_2d479e
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
			}//IF TAG END 37_e25b2c
=======
			}//IF TAG END 37_e42a19
>>>>>>> MERGE-SOURCE
			$content .="
			</div>
			<div class=\"mediadesc\">
			Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
			Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
			T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
			";
<<<<<<< TREE
			//IF TAG START 40_232566
=======
			//IF TAG START 40_52748b
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					".$object[2]->objectValues(7)->getValue('value','')."
					";
				}
<<<<<<< TREE
			}//IF TAG END 40_232566
=======
			}//IF TAG END 40_52748b
>>>>>>> MERGE-SOURCE
			$content .="
			</div>
			<div class=\"spacer\"></div>
			</div>
			</div>
			</div>
			";
<<<<<<< TREE
			//IF TAG START 41_b3ab59
=======
			//IF TAG START 41_22a0f1
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"pages\" id=\"pages\">
					";
<<<<<<< TREE
					//FUNCTION TAG START 42_451178
					$parameters_42_451178 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
					//FUNCTION TAG START 42_a2929c
					$parameters_42_a2929c = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
					if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_451178, array (
=======
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_a2929c, array (
>>>>>>> MERGE-SOURCE
							0 =>
							array (
								'textnode' => '
								',
							),
							1 =>
							array (
								'nodename' => 'pages',
								'attributes' =>
								array (
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'a',
										'attributes' =>
										array (
											'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
										),
										'childrens' =>
										array (
											0 =>
											array (
												'textnode' => '{n}',
											),
										),
									),
									1 =>
									array (
										'textnode' => ' ',
									),
								),
							),
							2 =>
							array (
								'textnode' => '
								',
							),
							3 =>
							array (
								'nodename' => 'currentpage',
								'attributes' =>
								array (
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'strong',
										'attributes' =>
										array (
										),
										'childrens' =>
										array (
											0 =>
											array (
												'textnode' => '{n}',
											),
										),
									),
									1 =>
									array (
										'textnode' => ' ',
									),
								),
							),
							4 =>
							array (
								'textnode' => '
								',
							),
							5 =>
							array (
								'nodename' => 'previous',
								'attributes' =>
								array (
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'a',
										'attributes' =>
										array (
											'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
										),
										'childrens' =>
										array (
											0 =>
											array (
												'nodename' => 'img',
												'attributes' =>
												array (
													'src' => 'img/demo/interieur/newsPrevious.gif',
													'alt' => 'Page pr&eacute;c&eacute;dente',
													'title' => 'Page pr&eacute;c&eacute;dente',
												),
											),
										),
									),
									1 =>
									array (
										'textnode' => ' ',
									),
								),
							),
							6 =>
							array (
								'textnode' => '
								',
							),
							7 =>
							array (
								'nodename' => 'next',
								'attributes' =>
								array (
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'a',
										'attributes' =>
										array (
											'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
										),
										'childrens' =>
										array (
											0 =>
											array (
												'nodename' => 'img',
												'attributes' =>
												array (
													'src' => 'img/demo/interieur/newsNext.gif',
													'alt' => 'Page suivante',
													'title' => 'Page suivante',
												),
											),
										),
									),
									1 =>
									array (
										'textnode' => ' ',
									),
								),
							),
							8 =>
							array (
								'textnode' => '
								',
							),
						)), $replace);
					} else {
						CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
=======
					";
				}
				//ELSE TAG END 34_68f381
				$content .="
				<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
				<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
				</div>
				";
			}
			unset($func_32_d482a4);
		}
		unset($ifcondition_32_d482a4);
		//IF TAG END 32_d482a4
		//IF TAG START 35_ac941a
		$ifcondition_35_ac941a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'mp3'", $replace);
		if ($ifcondition_35_ac941a) {
			$func_35_ac941a = create_function("","return (".$ifcondition_35_ac941a.");");
			if ($func_35_ac941a()) {
				$content .="
				<script type=\"text/javascript\">
				swfobject.embedSWF('/automne/playermp3/player_mp3.swf', 'media-".$object[2]->getValue('id','')."', '200', '20', '9.0.0', '/automne/swfobject/expressInstall.swf', {mp3:'".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."', configxml:'/automne/playermp3/config_playermp3.xml'}, {wmode:'transparent'}, false);
				</script>
				<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-audio\" style=\"width:200px;height:20px;\">
				<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
				</div>
				";
				//IF TAG START 36_031908
				$ifcondition_36_031908 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition_36_031908) {
					$func_36_031908 = create_function("","return (".$ifcondition_36_031908.");");
					if ($func_36_031908()) {
						$content .="
						<div class=\"imgLeft shadow\">
						<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
						</div>
						";
>>>>>>> MERGE-SOURCE
					}
<<<<<<< TREE
<<<<<<< TREE
					//FUNCTION TAG END 42_451178
=======
					//FUNCTION TAG END 42_a2929c
>>>>>>> MERGE-SOURCE
=======
					unset($func_36_031908);
				}
				unset($ifcondition_36_031908);
				//IF TAG END 36_031908
			}
			unset($func_35_ac941a);
		}
		unset($ifcondition_35_ac941a);
		//IF TAG END 35_ac941a
		//IF TAG START 37_02e306
		$ifcondition_37_02e306 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
		if ($ifcondition_37_02e306) {
			$func_37_02e306 = create_function("","return (".$ifcondition_37_02e306.");");
			if ($func_37_02e306()) {
				$content .="
				<div class=\"imgLeft shadow\">
				";
				//IF TAG START 38_5a11fc
				$ifcondition_38_5a11fc = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition_38_5a11fc) {
					$func_38_5a11fc = create_function("","return (".$ifcondition_38_5a11fc.");");$atmIfResults['thumbnail']['if'] = false;
					if ($func_38_5a11fc()) {$atmIfResults['thumbnail']['if'] = true;
>>>>>>> MERGE-SOURCE
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
					";
				}
<<<<<<< TREE
<<<<<<< TREE
			}//IF TAG END 41_b3ab59
			$count_26_19a411++;
=======
			}//IF TAG END 41_22a0f1
			$count_26_8117af++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
			$content_26_19a411.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_26_8117af.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		$content = $content_26_19a411; //retrieve previous content var if any
		$replace = $replace_26_19a411; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_26_19a411; //retrieve previous object search if any
=======
		$content = $content_26_8117af; //retrieve previous content var if any
		$replace = $replace_26_8117af; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_26_8117af; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
	//RESULT mediaresult TAG END 26_19a411
	//NO-RESULT mediaresult TAG START 43_551515
=======
	//RESULT mediaresult TAG END 26_8117af
	//NO-RESULT mediaresult TAG START 43_43e404
>>>>>>> MERGE-SOURCE
=======
				unset($func_38_5a11fc);
			}
			unset($ifcondition_38_5a11fc);
			//IF TAG END 38_5a11fc
			//ELSE TAG START 39_126403
			if (isset($atmIfResults['thumbnail']['if']) && $atmIfResults['thumbnail']['if'] === false) {
				$content .="
				<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
				";
			}
			//ELSE TAG END 39_126403
			$content .="
			</div>
			";
		}
		unset($func_37_02e306);
	}
	unset($ifcondition_37_02e306);
	//IF TAG END 37_02e306
	$content .="
	</div>
	<div class=\"mediadesc\">
	Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
	Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
	T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
	";
	//IF TAG START 40_7371ac
	$ifcondition_40_7371ac = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
	if ($ifcondition_40_7371ac) {
		$func_40_7371ac = create_function("","return (".$ifcondition_40_7371ac.");");
		if ($func_40_7371ac()) {
			$content .="
			".$object[2]->objectValues(7)->getValue('value','')."
			";
		}
		unset($func_40_7371ac);
	}
	unset($ifcondition_40_7371ac);
	//IF TAG END 40_7371ac
	$content .="
	</div>
	<div class=\"spacer\"></div>
	</div>
	</div>
	</div>
	";
	//IF TAG START 41_6e131a
	$ifcondition_41_6e131a = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
	if ($ifcondition_41_6e131a) {
		$func_41_6e131a = create_function("","return (".$ifcondition_41_6e131a.");");
		if ($func_41_6e131a()) {
			$content .="
			<div class=\"pages\" id=\"pages\">
			";
			//FUNCTION TAG START 42_4aedee
			$parameters_42_4aedee = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
			if (method_exists(new CMS_poly_definition_functions(), "pages")) {
				$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_4aedee, array (
					0 =>
					array (
						'textnode' => '
						',
					),
					1 =>
					array (
						'nodename' => 'pages',
						'attributes' =>
						array (
						),
						'childrens' =>
						array (
							0 =>
							array (
								'nodename' => 'a',
								'attributes' =>
								array (
									'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
								),
								'childrens' =>
								array (
									0 =>
									array (
										'textnode' => '{n}',
									),
								),
							),
							1 =>
							array (
								'textnode' => ' ',
							),
						),
					),
					2 =>
					array (
						'textnode' => '
						',
					),
					3 =>
					array (
						'nodename' => 'currentpage',
						'attributes' =>
						array (
						),
						'childrens' =>
						array (
							0 =>
							array (
								'nodename' => 'strong',
								'attributes' =>
								array (
								),
								'childrens' =>
								array (
									0 =>
									array (
										'textnode' => '{n}',
									),
								),
							),
							1 =>
							array (
								'textnode' => ' ',
							),
						),
					),
					4 =>
					array (
						'textnode' => '
						',
					),
					5 =>
					array (
						'nodename' => 'previous',
						'attributes' =>
						array (
						),
						'childrens' =>
						array (
							0 =>
							array (
								'nodename' => 'a',
								'attributes' =>
								array (
									'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'img',
										'attributes' =>
										array (
											'src' => '/img/demo/interieur/newsPrevious.gif',
											'alt' => 'Page pr&eacute;c&eacute;dente',
											'title' => 'Page pr&eacute;c&eacute;dente',
										),
									),
								),
							),
							1 =>
							array (
								'textnode' => ' ',
							),
						),
					),
					6 =>
					array (
						'textnode' => '
						',
					),
					7 =>
					array (
						'nodename' => 'next',
						'attributes' =>
						array (
						),
						'childrens' =>
						array (
							0 =>
							array (
								'nodename' => 'a',
								'attributes' =>
								array (
									'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&amp;keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&amp;page={n}',
								),
								'childrens' =>
								array (
									0 =>
									array (
										'nodename' => 'img',
										'attributes' =>
										array (
											'src' => '/img/demo/interieur/newsNext.gif',
											'alt' => 'Page suivante',
											'title' => 'Page suivante',
										),
									),
								),
							),
							1 =>
							array (
								'textnode' => ' ',
							),
						),
					),
					8 =>
					array (
						'textnode' => '
						',
					),
				)), $replace);
			} else {
				CMS_grandFather::raiseError("Malformed atm-function tag : can't found method pagesin CMS_poly_definition_functions");
			}
			//FUNCTION TAG END 42_4aedee
			$content .="
			</div>
			";
		}
		unset($func_41_6e131a);
	}
	unset($ifcondition_41_6e131a);
	//IF TAG END 41_6e131a
	$count_26_f2d040++;
	//do all result vars replacement
	$content_26_f2d040.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
$content = $content_26_f2d040; //retrieve previous content var if any
unset($content_26_f2d040);
$replace = $replace_26_f2d040; //retrieve previous replace vars if any
unset($replace_26_f2d040);
$object[$objectDefinition_mediaresult] = $object_26_f2d040; //retrieve previous object search if any
unset($object_26_f2d040);
	}
	//RESULT mediaresult TAG END 26_f2d040
	//NO-RESULT mediaresult TAG START 43_ac51ac
>>>>>>> MERGE-SOURCE
	//launch search mediaresult if not already done
	if($launchSearch_mediaresult && !isset($results_mediaresult)) {
if (isset($search_mediaresult)) {
	$results_mediaresult = $search_mediaresult->search();
} else {
	CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"mediaresult\" tag ...");
	$results_mediaresult = array();
}
	} elseif (!$launchSearch_mediaresult) {
$results_mediaresult = array();
	}
	if (!$results_mediaresult) {
$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
	}
<<<<<<< TREE
<<<<<<< TREE
	//NO-RESULT mediaresult TAG END 43_551515
=======
	//NO-RESULT mediaresult TAG END 43_43e404
>>>>>>> MERGE-SOURCE
=======
	//NO-RESULT mediaresult TAG END 43_ac51ac
>>>>>>> MERGE-SOURCE
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
<<<<<<< TREE
<<<<<<< TREE
	//SEARCH mediaresult TAG END 25_9baf91
	//AJAX TAG END 24_e982c6
=======
	//SEARCH mediaresult TAG END 25_9f5c3a
	//AJAX TAG END 24_4c3e51
>>>>>>> MERGE-SOURCE
=======
	//SEARCH mediaresult TAG END 25_66e69e
	//AJAX TAG END 24_8138c1
>>>>>>> MERGE-SOURCE
	$content .="
	</div>
	";
	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);
	$content .= '<!--{elements:'.base64_encode(serialize(array (
'module' =>
array (
	0 => 'standard',
	1 => 'standard',
	2 => 'standard',
	3 => 'standard',
	4 => 'pmedia',
),
	))).'}-->';
	echo $content;
	unset($content);}
	   ?>
	<?php $cache_6c03061c1c2e3400bed277795c6d3726_content = $cache_6c03061c1c2e3400bed277795c6d3726->endSave();
endif;
unset($cache_6c03061c1c2e3400bed277795c6d3726);
echo $cache_6c03061c1c2e3400bed277795c6d3726_content;
unset($cache_6c03061c1c2e3400bed277795c6d3726_content);
   ?>

<?php /* End row [650 [Médiathèque] Recherche - r68_650_Mediatheque.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
<<<<<<< TREE
				Page  "Médiathèque" (http://test-folder/trunk/web/demo/6-mediatheque.php)
=======
				Page  "Médiathèque" (http://127.0.0.1/web/demo/6-mediatheque.php)
>>>>>>> MERGE-SOURCE
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>