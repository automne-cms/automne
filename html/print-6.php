<?php //Generated on Mon, 18 Jan 2010 16:11:09 +0100 by Automne (TM) 4.0.0
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-6-mediatheque.php', true, 301);
}
 ?><?php if (!is_object($cms_user) || !$cms_user->hasPageClearance(6, CLEARANCE_PAGE_VIEW)) {
	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
}
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
		//AJAX TAG START 3_3cfd6f
		//SEARCH mediaresult TAG START 4_bfb1e1
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_4_bfb1e1 = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_4_bfb1e1);
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
		//RESULT mediaresult TAG START 5_dc3619
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
			$object_5_dc3619 = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_5_dc3619 = $replace; //save previous replace vars if any
			$count_5_dc3619 = 0;
			$content_5_dc3619 = $content; //save previous content var if any
			$maxPages_5_dc3619 = $search_mediaresult->getMaxPages();
			$maxResults_5_dc3619 = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_5_dc3619) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_dc3619 == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_dc3619+1),
					"{maxpages}"    => $maxPages_5_dc3619,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_dc3619,
				);
				//IF TAG START 6_06dc74
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 6_06dc74
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 7_914095
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
				}//IF TAG END 7_914095
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 8_bfdf40
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 9_f7f5ce
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
						}//IF TAG END 9_f7f5ce
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 10_4314fc
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
						}//IF TAG END 10_4314fc
					}
				}//IF TAG END 8_bfdf40
				//IF TAG START 11_6df2ac
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						//IF TAG START 12_9cc92a
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
						}//IF TAG END 12_9cc92a
						//IF TAG START 13_a3e85e
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
						}//IF TAG END 13_a3e85e
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
				}//IF TAG END 11_6df2ac
				//IF TAG START 14_12f449
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
						//IF TAG START 15_041fff
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
						}//IF TAG END 15_041fff
					}
				}//IF TAG END 14_12f449
				//IF TAG START 16_aaf193
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadow\">
						";
						//IF TAG START 17_89b901
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
								";
							}
						}//IF TAG END 17_89b901
						//IF TAG START 18_6d4b22
						$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
								";
							}
						}//IF TAG END 18_6d4b22
						$content .="
						</div>
						";
					}
				}//IF TAG END 16_aaf193
				$content .="
				</div>
				<div class=\"mediadesc\">
				Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
				//IF TAG START 19_d60ea6
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
				}//IF TAG END 19_d60ea6
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
				//IF TAG START 20_442e9e
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 21_c8e860
						$parameters_21_c8e860 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_21_c8e860, array (
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
						//FUNCTION TAG END 21_c8e860
						$content .="
						</div>
						";
					}
				}//IF TAG END 20_442e9e
				$count_5_dc3619++;
				//do all result vars replacement
				$content_5_dc3619.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_5_dc3619; //retrieve previous content var if any
			$replace = $replace_5_dc3619; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_5_dc3619; //retrieve previous object search if any
		}
		//RESULT mediaresult TAG END 5_dc3619
		//NO-RESULT mediaresult TAG START 22_bdee29
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
		//NO-RESULT mediaresult TAG END 22_bdee29
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
		//SEARCH mediaresult TAG END 4_bfb1e1
		//AJAX TAG END 3_3cfd6f
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
		//AJAX TAG START 24_964c92
		//SEARCH mediaresult TAG START 25_77add2
		$objectDefinition_mediaresult = '2';
		if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
			$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
		}
		//public search ?
		$public_25_77add2 = isset($public_search) ? $public_search : false;
		//get search params
		$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_77add2);
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
		//RESULT mediaresult TAG START 26_c9324b
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
			$object_26_c9324b = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
			$replace_26_c9324b = $replace; //save previous replace vars if any
			$count_26_c9324b = 0;
			$content_26_c9324b = $content; //save previous content var if any
			$maxPages_26_c9324b = $search_mediaresult->getMaxPages();
			$maxResults_26_c9324b = $search_mediaresult->getNumRows();
			foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
					"{firstresult}" => (!$count_26_c9324b) ? 1 : 0,
					"{lastresult}" 	=> ($count_26_c9324b == sizeof($results_mediaresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_26_c9324b+1),
					"{maxpages}"    => $maxPages_26_c9324b,
					"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_26_c9324b,
				);
				//IF TAG START 27_86b606
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 27_86b606
				$content .="
				<div class=\"mediaTop\">
				<div class=\"mediaBottom\">
				<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
				//IF TAG START 28_e4b333
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
					}
				}//IF TAG END 28_e4b333
				$content .="<div class=\"spacer\"></div>
				<div class=\"mediaContent\">
				<div class=\"mediafile\">
				";
				//IF TAG START 29_6ba669
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
						//IF TAG START 30_13779e
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
							}
						}//IF TAG END 30_13779e
						$content .=" ".$object[2]->getValue('label','')."</a>
						";
						//IF TAG START 31_b008c0
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
						}//IF TAG END 31_b008c0
					}
				}//IF TAG END 29_6ba669
				//IF TAG START 32_0d5dec
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						//IF TAG START 33_a19ec5
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
						}//IF TAG END 33_a19ec5
						//IF TAG START 34_5ebb17
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
						}//IF TAG END 34_5ebb17
						$content .="
						<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
						<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
						</div>
						";
					}
				}//IF TAG END 32_0d5dec
				//IF TAG START 35_d1ac6e
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
						//IF TAG START 36_87be35
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
						}//IF TAG END 36_87be35
					}
				}//IF TAG END 35_d1ac6e
				//IF TAG START 37_457681
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgLeft shadow\">
						";
						//IF TAG START 38_808685
						$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
								";
							}
						}//IF TAG END 38_808685
						//IF TAG START 39_12dc91
						$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
						if ($ifcondition) {
							$func = create_function("","return (".$ifcondition.");");
							if ($func()) {
								$content .="
								<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
								";
							}
						}//IF TAG END 39_12dc91
						$content .="
						</div>
						";
					}
				}//IF TAG END 37_457681
				$content .="
				</div>
				<div class=\"mediadesc\">
				Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
				Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
				T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
				";
				//IF TAG START 40_b16952
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[2]->objectValues(7)->getValue('value','')."
						";
					}
				}//IF TAG END 40_b16952
				$content .="
				</div>
				<div class=\"spacer\"></div>
				</div>
				</div>
				</div>
				";
				//IF TAG START 41_0374a9
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 42_a6eeea
						$parameters_42_a6eeea = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_a6eeea, array (
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
						//FUNCTION TAG END 42_a6eeea
						$content .="
						</div>
						";
					}
				}//IF TAG END 41_0374a9
				$count_26_c9324b++;
				//do all result vars replacement
				$content_26_c9324b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_26_c9324b; //retrieve previous content var if any
			$replace = $replace_26_c9324b; //retrieve previous replace vars if any
			$object[$objectDefinition_mediaresult] = $object_26_c9324b; //retrieve previous object search if any
		}
		//RESULT mediaresult TAG END 26_c9324b
		//NO-RESULT mediaresult TAG START 43_ecbef6
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
		//NO-RESULT mediaresult TAG END 43_ecbef6
		//destroy search and results mediaresult objects
		unset($search_mediaresult);
		unset($results_mediaresult);
		//SEARCH mediaresult TAG END 25_77add2
		//AJAX TAG END 24_964c92
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
}  ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Médiathèque</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Médiathèque</h1>
<h3>
<?php if ($cms_user->hasPageClearance(31, CLEARANCE_PAGE_VIEW)) {
echo '
		&raquo;&nbsp;Exemples de modules
		';
}
?><?php if ($cms_user->hasPageClearance(6, CLEARANCE_PAGE_VIEW)) {
echo '
		&raquo;&nbsp;Médiathèque
		';
}
?>
</h3>

	<?php //Generated by : $Id: print-6.php,v 1.11 2010/01/18 15:20:10 sebastien Exp $
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pmedia', CLEARANCE_MODULE_VIEW))){
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
	//FUNCTION TAG START 23_c52da5
	$parameters_23_c52da5 = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_23_c52da5 = &$object[2]->objectValues(8);
	if (method_exists($object_23_c52da5, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_23_c52da5->selectOptions($parameters_23_c52da5, NULL), $replace);
	} else {
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_23_c52da5));
	}
	//FUNCTION TAG END 23_c52da5
	$content .="
	</select>
	</div>
	<div id=\"loadingSearch\"><img src=\"/img/demo/interieur/loading-media.gif\" alt=\"Chargement ...\" title=\"Chargement ...\" /></div>
	<input type=\"submit\" class=\"button\" name=\"search\" id=\"submitSearch\" value=\"ok\" />
	<div class=\"spacer\"></div>
	</div>
	</form>
	</div>
	<div id=\"searchresult\">
	";
	//AJAX TAG START 24_964c92
	//SEARCH mediaresult TAG START 25_77add2
	$objectDefinition_mediaresult = '2';
	if (!isset($objectDefinitions[$objectDefinition_mediaresult])) {
		$objectDefinitions[$objectDefinition_mediaresult] = new CMS_poly_object_definition($objectDefinition_mediaresult);
	}
	//public search ?
	$public_25_77add2 = isset($public_search) ? $public_search : false;
	//get search params
	$search_mediaresult = new CMS_object_search($objectDefinitions[$objectDefinition_mediaresult], $public_25_77add2);
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
	//RESULT mediaresult TAG START 26_c9324b
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
		$object_26_c9324b = (isset($object[$objectDefinition_mediaresult])) ? $object[$objectDefinition_mediaresult] : ""; //save previous object search if any
		$replace_26_c9324b = $replace; //save previous replace vars if any
		$count_26_c9324b = 0;
		$content_26_c9324b = $content; //save previous content var if any
		$maxPages_26_c9324b = $search_mediaresult->getMaxPages();
		$maxResults_26_c9324b = $search_mediaresult->getNumRows();
		foreach ($results_mediaresult as $object[$objectDefinition_mediaresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_mediaresult)) ? $resultID_mediaresult : $object[$objectDefinition_mediaresult]->getID(),
				"{firstresult}" => (!$count_26_c9324b) ? 1 : 0,
				"{lastresult}" 	=> ($count_26_c9324b == sizeof($results_mediaresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_26_c9324b+1),
				"{maxpages}"    => $maxPages_26_c9324b,
				"{currentpage}" => ($search_mediaresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_26_c9324b,
			);
			//IF TAG START 27_86b606
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
					";
				}
			}//IF TAG END 27_86b606
			$content .="
			<div class=\"mediaTop\">
			<div class=\"mediaBottom\">
			<h2 title=\"Afficher - Masquer le m&eacute;dia\">".$object[2]->getValue('label','')."&nbsp;&nbsp;<span class=\"date\">".$object[2]->getValue('formatedDateStart','d/m/Y')."</span></h2>";
			//IF TAG START 28_e4b333
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="<span class=\"picto\"><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')." - Cliquez pour chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" /></a></span>";
				}
			}//IF TAG END 28_e4b333
			$content .="<div class=\"spacer\"></div>
			<div class=\"mediaContent\">
			<div class=\"mediafile\">
			";
			//IF TAG START 29_6ba669
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'flv' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'mp3' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'jpg' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'gif' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." != 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\">";
					//IF TAG START 30_13779e
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileIcon','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="<img src=\"".$object[2]->objectValues(9)->getValue('fileIcon','')."\" alt=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" title=\"Fichier ".$object[2]->objectValues(9)->getValue('fileExtension','')."\" />";
						}
					}//IF TAG END 30_13779e
					$content .=" ".$object[2]->getValue('label','')."</a>
					";
					//IF TAG START 31_b008c0
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
					}//IF TAG END 31_b008c0
				}
			}//IF TAG END 29_6ba669
			//IF TAG START 32_0d5dec
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'flv'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					//IF TAG START 33_a19ec5
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
					}//IF TAG END 33_a19ec5
					//IF TAG START 34_5ebb17
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
					}//IF TAG END 34_5ebb17
					$content .="
					<div id=\"media-".$object[2]->getValue('id','')."\" class=\"pmedias-video\" style=\"width:320px;height:200px;\">
					<p><a href=\"http://www.adobe.com/go/getflashplayer\"><img src=\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\" alt=\"Get Adobe Flash player\" /></a></p>
					</div>
					";
				}
			}//IF TAG END 32_0d5dec
			//IF TAG START 35_d1ac6e
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
					//IF TAG START 36_87be35
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
					}//IF TAG END 36_87be35
				}
			}//IF TAG END 35_d1ac6e
			//IF TAG START 37_457681
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'jpg' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'gif' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('fileExtension',''))." == 'png'", $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"imgLeft shadow\">
					";
					//IF TAG START 38_808685
					$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" onclick=\"javascript:CMS_openPopUpImage('/imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue('filename','')."&amp;label=".$object[2]->getValue('label','js')."');return false;\" target=\"_blank\" title=\"Voir l'image '".$object[2]->getValue('label','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('thumbnail','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" /></a>
							";
						}
					}//IF TAG END 38_808685
					//IF TAG START 39_12dc91
					$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue('thumbnail','')), $replace);
					if ($ifcondition) {
						$func = create_function("","return (".$ifcondition.");");
						if ($func()) {
							$content .="
							<img src=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" alt=\"".$object[2]->getValue('label','')."\" title=\"".$object[2]->getValue('label','')."\" style=\"max-width:200px;\" />
							";
						}
					}//IF TAG END 39_12dc91
					$content .="
					</div>
					";
				}
			}//IF TAG END 37_457681
			$content .="
			</div>
			<div class=\"mediadesc\">
			Cat&eacute;gorie : <a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?cat=".$object[2]->objectValues(8)->getValue('id','')."\" rel=\"search\" alt=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\" title=\"Chercher dans la cat&eacute;gorie ".$object[2]->objectValues(8)->getValue('label','')."\"><strong>".$object[2]->objectValues(8)->getValue('label','')."</strong></a><br />
			Taille : <strong>".$object[2]->objectValues(9)->getValue('fileSize','')."Mo</strong><br />
			T&eacute;l&eacute;charger : <a href=\"".$object[2]->objectValues(9)->getValue('filePath','')."/".$object[2]->objectValues(9)->getValue('filename','')."\" target=\"_blank\" title=\"T&eacute;l&eacute;charger le document '".$object[2]->objectValues(9)->getValue('fileLabel','')."' (".$object[2]->objectValues(9)->getValue('fileExtension','')." - ".$object[2]->objectValues(9)->getValue('fileSize','')."Mo)\"><strong>".$object[2]->getValue('label','')."</strong></a><br />
			";
			//IF TAG START 40_b16952
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(7)->getValue('value','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					".$object[2]->objectValues(7)->getValue('value','')."
					";
				}
			}//IF TAG END 40_b16952
			$content .="
			</div>
			<div class=\"spacer\"></div>
			</div>
			</div>
			</div>
			";
			//IF TAG START 41_0374a9
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"pages\" id=\"pages\">
					";
					//FUNCTION TAG START 42_a6eeea
					$parameters_42_a6eeea = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
					if (method_exists(new CMS_poly_definition_functions(), "pages")) {
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_42_a6eeea, array (
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
					//FUNCTION TAG END 42_a6eeea
					$content .="
					</div>
					";
				}
			}//IF TAG END 41_0374a9
			$count_26_c9324b++;
			//do all result vars replacement
			$content_26_c9324b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_26_c9324b; //retrieve previous content var if any
		$replace = $replace_26_c9324b; //retrieve previous replace vars if any
		$object[$objectDefinition_mediaresult] = $object_26_c9324b; //retrieve previous object search if any
	}
	//RESULT mediaresult TAG END 26_c9324b
	//NO-RESULT mediaresult TAG START 43_ecbef6
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
	//NO-RESULT mediaresult TAG END 43_ecbef6
	//destroy search and results mediaresult objects
	unset($search_mediaresult);
	unset($results_mediaresult);
	//SEARCH mediaresult TAG END 25_77add2
	//AJAX TAG END 24_964c92
	$content .="
	</div>
	";
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
   ?>
<br />
<hr />
<div align="center">
	<small>
		
		<?php if ($cms_user->hasPageClearance(6, CLEARANCE_PAGE_VIEW)) {
echo '
				Page  "Médiathèque" (http://127.0.0.1/web/demo/6-mediatheque.php)
				';
}
?><br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>