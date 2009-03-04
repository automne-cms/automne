<?php //Generated on Wed, 04 Mar 2009 11:06:55 +0100 by Automne (TM) 4.0.0b1
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://automne4/web/fr/print-6-mediatheque.php');
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
		//AJAX TAG START 3_22f9e7
		//SEARCH mediaresult TAG START 4_b8c771
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_4_b8c771 = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_b8c771);
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
		//RESULT mediaresult TAG START 5_1ce9b9
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
			$object_5_1ce9b9 = $object[$objectDefinition_mediaresult]; //save previous object search if any
			$replace_5_1ce9b9 = $replace; //save previous replace vars if any
			$count_5_1ce9b9 = 0;
			$content_5_1ce9b9 = $content; //save previous content var if any
			$maxPages_5_1ce9b9 = $search_mediaresult->getMaxPages();
			$maxResults_5_1ce9b9 = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_5_1ce9b9) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_1ce9b9 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_1ce9b9+1),
					"{maxpages}"    => $maxPages_5_1ce9b9,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_1ce9b9,
				);
				//IF TAG START 6_0c8dce
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} résultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 6_0c8dce
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le média\">".$object[2]->getValue('label','').",&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 7_179fa0
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
				}//IF TAG END 7_179fa0
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 8_c6d397
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 9_a473b7
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
						}//IF TAG END 9_a473b7
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 10_e40a2d
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
						}//IF TAG END 10_e40a2d
					}
				}//IF TAG END 8_c6d397
				//IF TAG START 11_44cf88
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						//IF TAG START 12_a5d941
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
						}//IF TAG END 12_a5d941
						//IF TAG START 13_1232c9
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
						}//IF TAG END 13_1232c9
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
				}//IF TAG END 11_44cf88
				//IF TAG START 14_cf0ab6
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
						//IF TAG START 15_346591
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
						}//IF TAG END 15_346591
					}
				}//IF TAG END 14_cf0ab6
				//IF TAG START 16_5d35c6
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
						//IF TAG START 17_1f4363
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue('filename','')."&label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
								";
							}
						}//IF TAG END 17_1f4363
						//IF TAG START 18_dfb06c
						$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
								";
							}
						}//IF TAG END 18_dfb06c
						$content .="
						</div>
						</div>
						</div>
						</div>
						</div>
						";
					}
				}//IF TAG END 16_5d35c6
				$content .="
				</div>
				<div class=\"mediadesc\">
				Catégorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				Télécharger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
				//IF TAG START 19_7e41d4
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
				}//IF TAG END 19_7e41d4
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
				//IF TAG START 20_b6c404
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 21_d86e5e
						$parameters_21_d86e5e = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_d86e5e, array (
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
						//FUNCTION TAG END 21_d86e5e
						$content .="
						</div>
						";
					}
				}//IF TAG END 20_b6c404
				$count_5_1ce9b9++;
				//do all result vars replacement
				$content_5_1ce9b9.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_5_1ce9b9; //retrieve previous content var if any
			$replace = $replace_5_1ce9b9; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_5_1ce9b9; //retrieve previous object search if any
		}
		//RESULT mediaresult TAG END 5_1ce9b9
		//NO-RESULT mediaresult TAG START 22_834f3b
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
		//NO-RESULT mediaresult TAG END 22_834f3b
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
		//SEARCH mediaresult TAG END 4_b8c771
		//AJAX TAG END 3_22f9e7
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
		//AJAX TAG START 24_e79212
		//SEARCH mediaresult TAG START 25_3b2e65
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_25_3b2e65 = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_3b2e65);
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
		//RESULT mediaresult TAG START 26_678142
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
			$object_26_678142 = $object[$objectDefinition_mediaresult]; //save previous object search if any
			$replace_26_678142 = $replace; //save previous replace vars if any
			$count_26_678142 = 0;
			$content_26_678142 = $content; //save previous content var if any
			$maxPages_26_678142 = $search_mediaresult->getMaxPages();
			$maxResults_26_678142 = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_26_678142) ? 1 : 0,
					"{lastresult}" 	=> ($count_26_678142 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_26_678142+1),
					"{maxpages}"    => $maxPages_26_678142,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_26_678142,
				);
				//IF TAG START 27_220f8f
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} résultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 27_220f8f
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le média\">".$object[2]->getValue('label','').",&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 28_b8d264
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
				}//IF TAG END 28_b8d264
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 29_fd379d
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 30_eeb13d
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
						}//IF TAG END 30_eeb13d
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 31_5279f1
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
						}//IF TAG END 31_5279f1
					}
				}//IF TAG END 29_fd379d
				//IF TAG START 32_5943d7
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						//IF TAG START 33_3190aa
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
						}//IF TAG END 33_3190aa
						//IF TAG START 34_8577f9
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
						}//IF TAG END 34_8577f9
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
				}//IF TAG END 32_5943d7
				//IF TAG START 35_ab3364
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
						//IF TAG START 36_665e1f
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
						}//IF TAG END 36_665e1f
					}
				}//IF TAG END 35_ab3364
				//IF TAG START 37_2f30ae
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
						//IF TAG START 38_76f7bc
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue('filename','')."&label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
								";
							}
						}//IF TAG END 38_76f7bc
						//IF TAG START 39_8ca4b6
						$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
								";
							}
						}//IF TAG END 39_8ca4b6
						$content .="
						</div>
						</div>
						</div>
						</div>
						</div>
						";
					}
				}//IF TAG END 37_2f30ae
				$content .="
				</div>
				<div class=\"mediadesc\">
				Catégorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				Télécharger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
				//IF TAG START 40_7a12c8
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
				}//IF TAG END 40_7a12c8
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
				//IF TAG START 41_8c797a
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 42_c184e0
						$parameters_42_c184e0 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_c184e0, array (
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
						//FUNCTION TAG END 42_c184e0
						$content .="
						</div>
						";
					}
				}//IF TAG END 41_8c797a
				$count_26_678142++;
				//do all result vars replacement
				$content_26_678142.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_26_678142; //retrieve previous content var if any
			$replace = $replace_26_678142; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_26_678142; //retrieve previous object search if any
		}
		//RESULT mediaresult TAG END 26_678142
		//NO-RESULT mediaresult TAG START 43_7fac8e
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
		//NO-RESULT mediaresult TAG END 43_7fac8e
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
		//SEARCH mediaresult TAG END 25_3b2e65
		//AJAX TAG END 24_e79212
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
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Automne 4 : Médiathèque</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Médiathèque</h1>
<h3>

		

&raquo;


&nbsp;

Médiathèque
		
</h3>

	<?php //Generated by : $Id: print-6.php,v 1.5 2009/03/04 10:02:09 sebastien Exp $
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
//FUNCTION TAG START 23_a792d0
$parameters_23_a792d0 = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
$object_23_a792d0 = &$object[2]->objectValues(8);
if (method_exists($object_23_a792d0, "selectOptions")) {
	$content .= CMS_polymod_definition_parsing::replaceVars($object_23_a792d0->selectOptions($parameters_23_a792d0, NULL), $replace);
} else {
	CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_23_a792d0));
}
//FUNCTION TAG END 23_a792d0
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
//AJAX TAG START 24_e79212
//SEARCH mediaresult TAG START 25_3b2e65
$objectDefinition_mediaresult = '2';
if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
	$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
}
//public search ?
$public_25_3b2e65 = isset($public_search) ? $public_search : false;
//get search params
$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_3b2e65);
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
//RESULT mediaresult TAG START 26_678142
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
	$object_26_678142 = $object[$objectDefinition_mediaresult]; //save previous object search if any
	$replace_26_678142 = $replace; //save previous replace vars if any
	$count_26_678142 = 0;
	$content_26_678142 = $content; //save previous content var if any
	$maxPages_26_678142 = $search_mediaresult->getMaxPages();
	$maxResults_26_678142 = $search_mediaresult->getNumRows();
	foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
		$content = "";
		$replace["atm-search"] = array (
			"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
			"{firstresult}" => (!$count_26_678142) ? 1 : 0,
			"{lastresult}" 	=> ($count_26_678142 == sizeof($results_mediaresult)-1) ? 1 : 0,
			"{resultcount}" => ($count_26_678142+1),
			"{maxpages}"    => $maxPages_26_678142,
			"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
			"{maxresults}"  => $maxResults_26_678142,
		);
		//IF TAG START 27_220f8f
		$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<div id=\"maxResults\">{maxresults} résultat(s) pour votre recherche.</div>
				";
			}
		}//IF TAG END 27_220f8f
		$content .="
		<div class=\"mediaTop\">
		<div class=\"mediaBottom\">
		<h2 title=\"Afficher - Masquer le média\">".$object[2]->getValue('label','').",&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
		//IF TAG START 28_b8d264
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
			}
		}//IF TAG END 28_b8d264
		$content .="<div class=\"spacer\"></div>
		<div class=\"mediaContent\">
		<div class=\"mediafile\">
		";
		//IF TAG START 29_fd379d
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
				//IF TAG START 30_eeb13d
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
					}
				}//IF TAG END 30_eeb13d
				$content .=" ".$object[2]->getValue('label','')."</a>
				";
				//IF TAG START 31_5279f1
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
				}//IF TAG END 31_5279f1
			}
		}//IF TAG END 29_fd379d
		//IF TAG START 32_5943d7
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				//IF TAG START 33_3190aa
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
				}//IF TAG END 33_3190aa
				//IF TAG START 34_8577f9
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
				}//IF TAG END 34_8577f9
				$content .="
				<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
				<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
				</div>
				";
			}
		}//IF TAG END 32_5943d7
		//IF TAG START 35_ab3364
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
				//IF TAG START 36_665e1f
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
				}//IF TAG END 36_665e1f
			}
		}//IF TAG END 35_ab3364
		//IF TAG START 37_2f30ae
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
				//IF TAG START 38_76f7bc
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&module=pmedia&file=".$object[2]->objectValues(9)->getValue('filename','')."&label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
						";
					}
				}//IF TAG END 38_76f7bc
				//IF TAG START 39_8ca4b6
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
						";
					}
				}//IF TAG END 39_8ca4b6
				$content .="
				</div>
				</div>
				</div>
				</div>
				</div>
				";
			}
		}//IF TAG END 37_2f30ae
		$content .="
		</div>
		<div class=\"mediadesc\">
		Catégorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la catégorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
		Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
		Télécharger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"Télécharger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
		";
		//IF TAG START 40_7a12c8
		$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				".$object[2]->objectValues(7)->getValue('value','')."
				";
			}
		}//IF TAG END 40_7a12c8
		$content .="
		</div>
		<div class=\"spacer\"></div>
		</div>
		</div>
		</div>
		";
		//IF TAG START 41_8c797a
		$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
		if ($ifcondition) {
			$func = create_function("","return (".$ifcondition.");");
			if ($func()) {
				$content .="
				<div class=\"pages\" id=\"pages\">
				";
				//FUNCTION TAG START 42_c184e0
				$parameters_42_c184e0 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
				if (method_exists(new CMS_poly_definition_functions(), "pages")) {
					$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_c184e0, array (
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
				//FUNCTION TAG END 42_c184e0
				$content .="
				</div>
				";
			}
		}//IF TAG END 41_8c797a
		$count_26_678142++;
		//do all result vars replacement
		$content_26_678142.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
	}
	$content = $content_26_678142; //retrieve previous content var if any
	$replace = $replace_26_678142; //retrieve previous replace vars if any
	$object[$objectDefinition_mediaresult] = $object_26_678142; //retrieve previous object search if any
}
//RESULT mediaresult TAG END 26_678142
//NO-RESULT mediaresult TAG START 43_7fac8e
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
//NO-RESULT mediaresult TAG END 43_7fac8e
//destroy search and results mediaresult objects
unset($search_mediaresult);
unset($results_mediaresult);
//SEARCH mediaresult TAG END 25_3b2e65
//AJAX TAG END 24_e79212
$content .="
</div>
";
echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
  ?>
<br />
<hr />
<div align="center">
	<small>
		
		
				Page  "Médiathèque" (http://automne4/web/fr/6-mediatheque.php)
				<br />
		Tiré du site http://<?php echo $_SERVER["HTTP_HOST"];   ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>