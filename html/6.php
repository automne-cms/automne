<?php //Generated on Mon, 09 Feb 2009 12:09:18 +0100 by Automne (TM) 4.0.0a3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/fr/6-mediatheque.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {

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
		//AJAX TAG START 3_006940
		//SEARCH mediaresult TAG START 4_8fa40f
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_4_8fa40f = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_8fa40f);
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
		//RESULT mediaresult TAG START 5_cc2fdb
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
			$object_5_cc2fdb = $object[$objectDefinition_mediaresult]; //save previous object search if any
			$replace_5_cc2fdb = $replace; //save previous replace vars if any
			$count_5_cc2fdb = 0;
			$content_5_cc2fdb = $content; //save previous content var if any
			$maxPages_5_cc2fdb = $search_mediaresult->getMaxPages();
			$maxResults_5_cc2fdb = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_5_cc2fdb) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_cc2fdb == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_cc2fdb+1),
					"{maxpages}"    => $maxPages_5_cc2fdb,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_cc2fdb,
				);
				//IF TAG START 6_9e1fef
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} résultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 6_9e1fef
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le média\">".$object[2]->getValue('label','').",&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 7_d62970
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
				}//IF TAG END 7_d62970
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 8_52e224
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 9_e29497
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
						}//IF TAG END 9_e29497
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 10_13ebe6
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadowR\">
								<div class=\"shadowB\">
								<div class=\"shadowTR\">
								<div class=\"shadowBL\">
								<div class=\"shadowBR\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								</div>
								</div>
								</div>
								</div>
								";
							}
						}//IF TAG END 10_13ebe6
					}
				}//IF TAG END 8_52e224
				//IF TAG START 11_971e2a
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						//IF TAG START 12_c531af
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
						}//IF TAG END 12_c531af
						//IF TAG START 13_b9d0cd
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
						}//IF TAG END 13_b9d0cd
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
				}//IF TAG END 11_971e2a
				//IF TAG START 14_1a9aa8
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
						//IF TAG START 15_df082e
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<div class=\"imgLeft shadowR\">
								<div class=\"shadowB\">
								<div class=\"shadowTR\">
								<div class=\"shadowBL\">
								<div class=\"shadowBR\">
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
								</div>
								</div>
								</div>
								</div>
								</div>
								";
							}
						}//IF TAG END 15_df082e
					}
				}//IF TAG END 14_1a9aa8
				//IF TAG START 16_a8a53f
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadowR\">
						<div class=\"shadowB\">
						<div class=\"shadowTR\">
						<div class=\"shadowBL\">
						<div class=\"shadowBR\">
						";
						//IF TAG START 17_530bc4
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue('filename','')."&label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
								";
							}
						}//IF TAG END 17_530bc4
						//IF TAG START 18_596633
						$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
								";
							}
						}//IF TAG END 18_596633
						$content .="
						</div>
						</div>
						</div>
						</div>
						</div>
						";
					}
				}//IF TAG END 16_a8a53f
				$content .="
				</div>
				<div class=\"mediadesc\">
				Catégorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				Télécharger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
				//IF TAG START 19_e4341d
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
				}//IF TAG END 19_e4341d
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
				//IF TAG START 20_b854b5
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 21_912d61
						$parameters_21_912d61 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_912d61, array (
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
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
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
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => '/img/interieur/newsPrevious.gif',
														'alt' => 'Page précédente',
														'title' => 'Page précédente',
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
												'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
											),
											'childrens' =>
											array (
												0 =>
												array (
													'nodename' => 'img',
													'attributes' =>
													array (
														'src' => '/img/interieur/newsNext.gif',
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
						//FUNCTION TAG END 21_912d61
						$content .="
						</div>
						";
					}
				}//IF TAG END 20_b854b5
				$count_5_cc2fdb++;
				//do all result vars replacement
				$content_5_cc2fdb.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_5_cc2fdb; //retrieve previous content var if any
			$replace = $replace_5_cc2fdb; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_5_cc2fdb; //retrieve previous object search if any
		}
		//RESULT mediaresult TAG END 5_cc2fdb
		//NO-RESULT mediaresult TAG START 22_abf52b
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
			$content .="Aucun résultat trouvé pour votre recherche ...";
		}
		//NO-RESULT mediaresult TAG END 22_abf52b
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
		//SEARCH mediaresult TAG END 4_8fa40f
		//AJAX TAG END 3_006940
		//output XML response
		header("Content-Type: text/xml");
		echo "<"."?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">
		<response xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
		<error>0</error>
		<errormessage/>
		<data><![CDATA[".CMS_polymod_definition_parsing::replaceVars($content, $replace)."]]></data>
		</response>";
		exit;
	}
}

						//output empty XML response
						header("Content-Type: text/xml");
						echo "<"."?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">
						<response xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
						<error>0</error>
						<errormessage/>
						</response>";
						exit;
}  ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
	<head>
		<title>Automne 4 : Médiathèque</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<?php echo CMS_view::getCSS(array('/css/common.css','/css/interieur.css','/css/modules/pmedia.css'), 'screen');  ?>

		<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="/css/ie6.css" media="screen" />
		<![endif]-->
		<?php echo CMS_view::getJavascript(array('/js/sifr.js','/js/common.js','/js/CMS_functions.js','/js/modules/pmedia/jquery-1.2.6.min.js','/js/modules/pmedia/pmedia.js','/js/modules/pmedia/swfobject.js'));  ?>

		<link rel="icon" type="image/x-icon" href="http://127.0.0.1/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://127.0.0.1" />

	</head>
	<body>
		<div id="main">
			<div id="container">
				<div id="header">
					
								

<a id="lienAccueil" href="http://127.0.0.1/web/fr/2-accueil.php" title="Retour à l'accueil">Retour à l'accueil</a>


							


				</div>
				<div id="backgroundBottomContainer">
					<div id="menuLeft">
						<ul class="CMS_lvl1"><li class="CMS_lvl1 CMS_open "><a class="CMS_lvl1" href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a><ul class="CMS_lvl2"><li class="CMS_lvl2 CMS_nosub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/3-presentation.php">Présentation</a></li>
<li class="CMS_lvl2 CMS_sub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/4-fonctionnalites.php">Fonctionnalités</a></li>
<li class="CMS_lvl2 CMS_nosub "><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/5-actualite.php">Actualités</a></li>
<li class="CMS_lvl2 CMS_nosub CMS_current"><a class="CMS_lvl2" href="http://127.0.0.1/web/fr/6-mediatheque.php">Médiathèque</a></li>
</ul>
</li>
</ul>



					</div>
					<div id="content" class="page6">
						<div id="breadcrumbs">
							<a href="http://127.0.0.1/web/fr/2-accueil.php">Accueil</a>

 &gt; 


						</div>
						<div id="title">
							<h1>Médiathèque</h1>
						</div>
						
	<?php //Generated by : $Id: 6.php,v 1.3 2009/02/09 11:07:33 sebastien Exp $
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
$content .="
<div id=\"mediasearch\">
<script type=\"text/javascript\">
var pageURL = '".CMS_tree::getPageValue($parameters['pageID'],"url")."';
</script>
<form action=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."\" method=\"get\">
<h2>Rechercher des documents et médias : </h2>
<div class=\"mediaForm\">
<div class=\"formKeywords\">
<label for=\"keyword\">Mots Clés : </label><br /><input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"".CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword)."\" /><br />
</div>
<div class=\"formCat\">
<label for=\"cat\">Catégorie : </label><br />
<select id=\"cat\" name=\"cat\">
<option value=\"\"> </option>
";
//FUNCTION TAG START 2_8772f9
$parameters_2_8772f9 = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
$object_2_8772f9 = &$object[2]->objectValues(8);
if (method_exists($object_2_8772f9, "selectOptions")) {
	$content .= CMS_polymod_definition_parsing::replaceVars($object_2_8772f9->selectOptions($parameters_2_8772f9, NULL), $replace);
} else {
	CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_2_8772f9));
}
//FUNCTION TAG END 2_8772f9
$content .="
</select>
</div>
<div id=\"loadingSearch\"><img src=\"/img/loading-media.gif\" alt=\"Chargement ...\" title=\"Chargement ...\" /></div>
<input type=\"submit\" class=\"button\" name=\"search\" id=\"submitSearch\" value=\"ok\" />
<div class=\"spacer\"></div>
</div>
</form>
</div>
<div id=\"searchresult\">
";
//AJAX TAG START 3_006940
//SEARCH mediaresult TAG START 4_8fa40f
$objectDefinition_mediaresult = '2';
if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
	$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
}
//public search ?
$public_4_8fa40f = isset($public_search) ? $public_search : false;
//get search params
$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_8fa40f);
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
//RESULT mediaresult TAG START 5_cc2fdb
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
	$object_5_cc2fdb = $object[$objectDefinition_mediaresult]; //save previous object search if any
	$replace_5_cc2fdb = $replace; //save previous replace vars if any
	$count_5_cc2fdb = 0;
	$content_5_cc2fdb = $content; //save previous content var if any
	$maxPages_5_cc2fdb = $search_mediaresult->getMaxPages();
	$maxResults_5_cc2fdb = $search_mediaresult->getNumRows();
	foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
		$content = "";
		$replace["atm-search"] = array (
			"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
			"{firstresult}" => (!$count_5_cc2fdb) ? 1 : 0,
			"{lastresult}" 	=> ($count_5_cc2fdb == sizeof($results_mediaresult)-1) ? 1 : 0,
			"{resultcount}" => ($count_5_cc2fdb+1),
			"{maxpages}"    => $maxPages_5_cc2fdb,
			"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
			"{maxresults}"  => $maxResults_5_cc2fdb,
		);
		//IF TAG START 6_9e1fef
		$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<div id=\"maxResults\">{maxresults} résultat(s) pour votre recherche.</div>
				";
			}
		}//IF TAG END 6_9e1fef
		$content .="
		<div class=\"mediaTop\">
		<div class=\"mediaBottom\">
		<h2 title=\"Afficher - Masquer le média\">".$object[2]->getValue('label','').",&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
		//IF TAG START 7_d62970
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
			}
		}//IF TAG END 7_d62970
		$content .="<div class=\"spacer\"></div>
		<div class=\"mediaContent\">
		<div class=\"mediafile\">
		";
		//IF TAG START 8_52e224
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
				//IF TAG START 9_e29497
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
					}
				}//IF TAG END 9_e29497
				$content .=" ".$object[2]->getValue('label','')."</a>
				";
				//IF TAG START 10_13ebe6
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadowR\">
						<div class=\"shadowB\">
						<div class=\"shadowTR\">
						<div class=\"shadowBL\">
						<div class=\"shadowBR\">
						<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
						</div>
						</div>
						</div>
						</div>
						</div>
						";
					}
				}//IF TAG END 10_13ebe6
			}
		}//IF TAG END 8_52e224
		//IF TAG START 11_971e2a
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				//IF TAG START 12_c531af
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
				}//IF TAG END 12_c531af
				//IF TAG START 13_b9d0cd
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
				}//IF TAG END 13_b9d0cd
				$content .="
				<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
				<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
				</div>
				";
			}
		}//IF TAG END 11_971e2a
		//IF TAG START 14_1a9aa8
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
				//IF TAG START 15_df082e
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadowR\">
						<div class=\"shadowB\">
						<div class=\"shadowTR\">
						<div class=\"shadowBL\">
						<div class=\"shadowBR\">
						<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" />
						</div>
						</div>
						</div>
						</div>
						</div>
						";
					}
				}//IF TAG END 15_df082e
			}
		}//IF TAG END 14_1a9aa8
		//IF TAG START 16_a8a53f
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<div class=\"imgLeft shadowR\">
				<div class=\"shadowB\">
				<div class=\"shadowTR\">
				<div class=\"shadowBL\">
				<div class=\"shadowBR\">
				";
				//IF TAG START 17_530bc4
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue('filename','')."&label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
						";
					}
				}//IF TAG END 17_530bc4
				//IF TAG START 18_596633
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
						";
					}
				}//IF TAG END 18_596633
				$content .="
				</div>
				</div>
				</div>
				</div>
				</div>
				";
			}
		}//IF TAG END 16_a8a53f
		$content .="
		</div>
		<div class=\"mediadesc\">
		Catégorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
		Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
		Télécharger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
		";
		//IF TAG START 19_e4341d
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				".$object[2]->objectValues(7)->getValue('value','')."
				";
			}
		}//IF TAG END 19_e4341d
		$content .="
		</div>
		<div class=\"spacer\"></div>
		</div>
		</div>
		</div>
		";
		//IF TAG START 20_b854b5
		$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<div class=\"pages\" id=\"pages\">
				";
				//FUNCTION TAG START 21_912d61
				$parameters_21_912d61 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
				if (method_exists(new CMS_poly_definition_functions(), "pages")) {
					$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_912d61, array (
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
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
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
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/interieur/newsPrevious.gif',
												'alt' => 'Page précédente',
												'title' => 'Page précédente',
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
										'href' => CMS_tree::getPageValue($parameters['pageID'],"url").'?cat='.CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat).'&keyword='.CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword).'&page={n}',
									),
									'childrens' =>
									array (
										0 =>
										array (
											'nodename' => 'img',
											'attributes' =>
											array (
												'src' => '/img/interieur/newsNext.gif',
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
				//FUNCTION TAG END 21_912d61
				$content .="
				</div>
				";
			}
		}//IF TAG END 20_b854b5
		$count_5_cc2fdb++;
		//do all result vars replacement
		$content_5_cc2fdb.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
	$content = $content_5_cc2fdb; //retrieve previous content var if any
	$replace = $replace_5_cc2fdb; //retrieve previous replace vars if any
	$object[$objectDefinition_mediaresult] = $object_5_cc2fdb; //retrieve previous object search if any
}
//RESULT mediaresult TAG END 5_cc2fdb
//NO-RESULT mediaresult TAG START 22_abf52b
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
	$content .="Aucun résultat trouvé pour votre recherche ...";
}
//NO-RESULT mediaresult TAG END 22_abf52b
//destroy search and results mediaresult objects
unset($search_mediaresult);
unset($results_mediaresult);
//SEARCH mediaresult TAG END 4_8fa40f
//AJAX TAG END 3_006940
$content .="
</div>
";
echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
  ?>

						<a href="#header" id="top" title="haut de la page">Haut</a>
					</div>
					<div class="spacer"></div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div id="menuBottom">
				<ul>
					<li><a href="http://127.0.0.1/web/fr/8-plan-du-site.php">Plan du site</a></li>


<li><a href="http://127.0.0.1/web/fr/9-contact.php">Contact</a></li>



				</ul>
				<div class="spacer"></div>
			</div>
		</div>
	<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>