<?php //Generated on Tue, 17 Nov 2009 17:11:50 +0100 by Automne (TM) 4.0.0rc3
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://127.0.0.1/web/demo/print-5-actualite.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {

$content = "";
$replace = "";
if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
$blockAttributes = array (
  'module' => 'pnews',
  'language' => 'fr',
);
$parameters['pageID'] = '5';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters['public']);
$parameters['module'] = 'pnews';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
		//AJAX TAG START 3_fdf25c
		//SEARCH newsresult TAG START 4_503f97
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
		$public_4_503f97 = isset($public_search) ? $public_search : false;
		//get search params
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_4_503f97);
		$launchSearch_newsresult = true;
		//add search conditions if any
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 5,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$search_newsresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_newsresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_newsresult->addOrderCondition("objectID", "desc");
		//RESULT newsresult TAG START 5_00c1b2
		//launch search newsresult if not already done
		if($launchSearch_newsresult && !isset($results_newsresult)) {
			if (isset($search_newsresult)) {
				$results_newsresult = $search_newsresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-result tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
				$results_newsresult = array();
			}
		} elseif (!$launchSearch_newsresult) {
			$results_newsresult = array();
		}
		if ($results_newsresult) {
			$object_5_00c1b2 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_5_00c1b2 = $replace; //save previous replace vars if any
			$count_5_00c1b2 = 0;
			$content_5_00c1b2 = $content; //save previous content var if any
			$maxPages_5_00c1b2 = $search_newsresult->getMaxPages();
			$maxResults_5_00c1b2 = $search_newsresult->getNumRows();
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
					"{firstresult}" => (!$count_5_00c1b2) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_00c1b2 == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_00c1b2+1),
					"{maxpages}"    => $maxPages_5_00c1b2,
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_00c1b2,
				);
				//IF TAG START 6_96c84e
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 6_96c84e
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
				//IF TAG START 7_75540a
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgRight shadow\">
						".$object[1]->objectValues(4)->getValue('imageHTML','')."
						</div>
						";
					}
				}//IF TAG END 7_75540a
				//IF TAG START 8_102d28
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
				}//IF TAG END 8_102d28
				//IF TAG START 9_3db010
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[1]->objectValues(2)->getValue('value','')."
						<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
						<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
						<span class=\"blocLienBottom\">En savoir plus</span>
						</a>
						";
					}
				}//IF TAG END 9_3db010
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
				//IF TAG START 10_993d76
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 11_e1e5be
						$parameters_11_e1e5be = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_11_e1e5be, array (
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
														'alt' => 'page pr&eacute;c&eacute;dente',
														'title' => 'page pr&eacute;c&eacute;dente',
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
														'alt' => 'page suivante',
														'title' => 'page suivante',
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
						//FUNCTION TAG END 11_e1e5be
						$content .="
						</div>
						";
					}
				}//IF TAG END 10_993d76
				$count_5_00c1b2++;
				//do all result vars replacement
				$content_5_00c1b2.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_5_00c1b2; //retrieve previous content var if any
			$replace = $replace_5_00c1b2; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_5_00c1b2; //retrieve previous object search if any
		}
		//RESULT newsresult TAG END 5_00c1b2
		//NO-RESULT newsresult TAG START 12_3d4755
		//launch search newsresult if not already done
		if($launchSearch_newsresult && !isset($results_newsresult)) {
			if (isset($search_newsresult)) {
				$results_newsresult = $search_newsresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
				$results_newsresult = array();
			}
		} elseif (!$launchSearch_newsresult) {
			$results_newsresult = array();
		}
		if (!$results_newsresult) {
			$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
		}
		//NO-RESULT newsresult TAG END 12_3d4755
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
		//SEARCH newsresult TAG END 4_503f97
		//AJAX TAG END 3_fdf25c
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
  'module' => 'pnews',
  'language' => 'fr',
);
$parameters['pageID'] = '5';
if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
$parameters['public'] = true;
if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
if (!isset($object) || !is_array($object)) $object = array();
if (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters['public']);
$parameters['module'] = 'pnews';

$xmlCondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "out", "string", @$out))." == 'xml'", $replace);
if ($xmlCondition) {
	$func = create_function("","return (".$xmlCondition.");");
	if ($func()) {
		//AJAX TAG START 14_41a604
		//SEARCH newsresult TAG START 15_0bd9ec
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
		$public_15_0bd9ec = isset($public_search) ? $public_search : false;
		//get search params
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_0bd9ec);
		$launchSearch_newsresult = true;
		//add search conditions if any
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 5,
			'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 'keywords',
			'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
			'search' => 'newsresult',
			'type' => 'item',
			'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
			'mandatory' => 'false',
		))) ? $launchSearch_newsresult : false;
		$search_newsresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
		$search_newsresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
		$search_newsresult->addOrderCondition("objectID", "desc");
		//RESULT newsresult TAG START 16_f057cf
		//launch search newsresult if not already done
		if($launchSearch_newsresult && !isset($results_newsresult)) {
			if (isset($search_newsresult)) {
				$results_newsresult = $search_newsresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-result tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
				$results_newsresult = array();
			}
		} elseif (!$launchSearch_newsresult) {
			$results_newsresult = array();
		}
		if ($results_newsresult) {
			$object_16_f057cf = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_16_f057cf = $replace; //save previous replace vars if any
			$count_16_f057cf = 0;
			$content_16_f057cf = $content; //save previous content var if any
			$maxPages_16_f057cf = $search_newsresult->getMaxPages();
			$maxResults_16_f057cf = $search_newsresult->getNumRows();
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
					"{firstresult}" => (!$count_16_f057cf) ? 1 : 0,
					"{lastresult}" 	=> ($count_16_f057cf == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_16_f057cf+1),
					"{maxpages}"    => $maxPages_16_f057cf,
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_16_f057cf,
				);
				//IF TAG START 17_525871
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
				}//IF TAG END 17_525871
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
				//IF TAG START 18_ad5704
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"imgRight shadow\">
						".$object[1]->objectValues(4)->getValue('imageHTML','')."
						</div>
						";
					}
				}//IF TAG END 18_ad5704
				//IF TAG START 19_87de56
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
				}//IF TAG END 19_87de56
				//IF TAG START 20_20b1c3
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						".$object[1]->objectValues(2)->getValue('value','')."
						<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
						<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
						<span class=\"blocLienBottom\">En savoir plus</span>
						</a>
						";
					}
				}//IF TAG END 20_20b1c3
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
				//IF TAG START 21_2f0c29
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 22_b4550d
						$parameters_22_b4550d = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_b4550d, array (
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
														'alt' => 'page pr&eacute;c&eacute;dente',
														'title' => 'page pr&eacute;c&eacute;dente',
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
														'alt' => 'page suivante',
														'title' => 'page suivante',
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
						//FUNCTION TAG END 22_b4550d
						$content .="
						</div>
						";
					}
				}//IF TAG END 21_2f0c29
				$count_16_f057cf++;
				//do all result vars replacement
				$content_16_f057cf.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_16_f057cf; //retrieve previous content var if any
			$replace = $replace_16_f057cf; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_16_f057cf; //retrieve previous object search if any
		}
		//RESULT newsresult TAG END 16_f057cf
		//NO-RESULT newsresult TAG START 23_3d9934
		//launch search newsresult if not already done
		if($launchSearch_newsresult && !isset($results_newsresult)) {
			if (isset($search_newsresult)) {
				$results_newsresult = $search_newsresult->search();
			} else {
				CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
				$results_newsresult = array();
			}
		} elseif (!$launchSearch_newsresult) {
			$results_newsresult = array();
		}
		if (!$results_newsresult) {
			$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
		}
		//NO-RESULT newsresult TAG END 23_3d9934
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
		//SEARCH newsresult TAG END 15_0bd9ec
		//AJAX TAG END 14_41a604
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
	<title>Automne 4 : Actualités</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Actualités</h1>
<h3>

		&raquo;&nbsp;

Exemples de modules
		
		&raquo;&nbsp;

Actualités
		
</h3>

	<?php //Generated by : $Id: print-5.php,v 1.10 2009/11/17 16:04:29 sebastien Exp $
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pnews', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();
	$blockAttributes = array (
		'module' => 'pnews',
		'language' => 'fr',
	);
	$parameters['pageID'] = '5';
	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != 'fr')) $cms_language = new CMS_language('fr');
	$parameters['public'] = true;
	if (isset($parameters['item'])) {$parameters['objectID'] = $parameters['item']->getObjectID();} elseif (isset($parameters['itemID']) && sensitiveIO::isPositiveInteger($parameters['itemID']) && !isset($parameters['objectID'])) $parameters['objectID'] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters['itemID']);
	if (!isset($object) || !is_array($object)) $object = array();
	if (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters['public']);
	$parameters['module'] = 'pnews';
	$content .="
	<div id=\"newssearch\">
	<script type=\"text/javascript\">
	var pageURL = '".CMS_tree::getPageValue($parameters['pageID'],"url")."';
	</script>
	<form action=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."\" method=\"get\">
	<h2>Rechercher des actualit&eacute;s : </h2>
	<div class=\"newsForm\">
	<div class=\"formKeywords\">
	<label for=\"keyword\">Mots Cl&eacute;s : </label><br /><input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"".CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword)."\" /><br />
	</div>
	<div class=\"formCat\">
	<label for=\"cat\">Cat&eacute;gorie : </label><br />
	<select id=\"cat\" name=\"cat\">
	<option value=\"\"> </option>
	";
	//FUNCTION TAG START 13_eeb94a
	$parameters_13_eeb94a = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_13_eeb94a = &$object[1]->objectValues(5);
	if (method_exists($object_13_eeb94a, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_13_eeb94a->selectOptions($parameters_13_eeb94a, NULL), $replace);
	} else {
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_13_eeb94a));
	}
	//FUNCTION TAG END 13_eeb94a
	$content .="
	</select>
	</div>
	<div id=\"loadingSearch\"><img src=\"/img/demo/interieur/loading-news.gif\" alt=\"Chargement ...\" title=\"Chargement ...\" /></div>
	<input type=\"submit\" class=\"button\" name=\"search\" id=\"submitSearch\" value=\"ok\" />
	<div class=\"spacer\"></div>
	</div>
	</form>
	</div>
	<div id=\"searchresult\">
	";
	//AJAX TAG START 14_41a604
	//SEARCH newsresult TAG START 15_0bd9ec
	$objectDefinition_newsresult = '1';
	if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
		$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
	}
	//public search ?
	$public_15_0bd9ec = isset($public_search) ? $public_search : false;
	//get search params
	$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_0bd9ec);
	$launchSearch_newsresult = true;
	//add search conditions if any
	$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
		'search' => 'newsresult',
		'type' => 5,
		'value' => CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat),
		'mandatory' => 'false',
	))) ? $launchSearch_newsresult : false;
	$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
		'search' => 'newsresult',
		'type' => 'keywords',
		'value' => CMS_poly_definition_functions::getVarContent("request", "keyword", "string", @$keyword),
		'mandatory' => 'false',
	))) ? $launchSearch_newsresult : false;
	$launchSearch_newsresult = (CMS_polymod_definition_parsing::addSearchCondition($search_newsresult, array (
		'search' => 'newsresult',
		'type' => 'item',
		'value' => CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item),
		'mandatory' => 'false',
	))) ? $launchSearch_newsresult : false;
	$search_newsresult->setAttribute('itemsPerPage', (int) CMS_polymod_definition_parsing::replaceVars("10", $replace));
	$search_newsresult->setAttribute('page', (int) (CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "page", "int", @$page), $replace) -1 ));
	$search_newsresult->addOrderCondition("objectID", "desc");
	//RESULT newsresult TAG START 16_f057cf
	//launch search newsresult if not already done
	if($launchSearch_newsresult && !isset($results_newsresult)) {
		if (isset($search_newsresult)) {
			$results_newsresult = $search_newsresult->search();
		} else {
			CMS_grandFather::raiseError("Malformed atm-result tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
			$results_newsresult = array();
		}
	} elseif (!$launchSearch_newsresult) {
		$results_newsresult = array();
	}
	if ($results_newsresult) {
		$object_16_f057cf = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
		$replace_16_f057cf = $replace; //save previous replace vars if any
		$count_16_f057cf = 0;
		$content_16_f057cf = $content; //save previous content var if any
		$maxPages_16_f057cf = $search_newsresult->getMaxPages();
		$maxResults_16_f057cf = $search_newsresult->getNumRows();
		foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
				"{firstresult}" => (!$count_16_f057cf) ? 1 : 0,
				"{lastresult}" 	=> ($count_16_f057cf == sizeof($results_newsresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_16_f057cf+1),
				"{maxpages}"    => $maxPages_16_f057cf,
				"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_16_f057cf,
			);
			//IF TAG START 17_525871
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
					";
				}
			}//IF TAG END 17_525871
			$content .="
			<div class=\"newsTitle\">
			<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
			</div>
			<div class=\"newsContent\">
			";
			//IF TAG START 18_ad5704
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"imgRight shadow\">
					".$object[1]->objectValues(4)->getValue('imageHTML','')."
					</div>
					";
				}
			}//IF TAG END 18_ad5704
			//IF TAG START 19_87de56
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
					<br />".$object[1]->objectValues(3)->getValue('value','')."
					";
				}
			}//IF TAG END 19_87de56
			//IF TAG START 20_20b1c3
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					".$object[1]->objectValues(2)->getValue('value','')."
					<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
					<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
					<span class=\"blocLienBottom\">En savoir plus</span>
					</a>
					";
				}
			}//IF TAG END 20_20b1c3
			$content .="
			<div class=\"spacer\"></div>
			</div>
			";
			//IF TAG START 21_2f0c29
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"pages\" id=\"pages\">
					";
					//FUNCTION TAG START 22_b4550d
					$parameters_22_b4550d = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
					if (method_exists(new CMS_poly_definition_functions(), "pages")) {
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_b4550d, array (
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
													'alt' => 'page pr&eacute;c&eacute;dente',
													'title' => 'page pr&eacute;c&eacute;dente',
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
													'alt' => 'page suivante',
													'title' => 'page suivante',
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
					//FUNCTION TAG END 22_b4550d
					$content .="
					</div>
					";
				}
			}//IF TAG END 21_2f0c29
			$count_16_f057cf++;
			//do all result vars replacement
			$content_16_f057cf.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_16_f057cf; //retrieve previous content var if any
		$replace = $replace_16_f057cf; //retrieve previous replace vars if any
		$object[$objectDefinition_newsresult] = $object_16_f057cf; //retrieve previous object search if any
	}
	//RESULT newsresult TAG END 16_f057cf
	//NO-RESULT newsresult TAG START 23_3d9934
	//launch search newsresult if not already done
	if($launchSearch_newsresult && !isset($results_newsresult)) {
		if (isset($search_newsresult)) {
			$results_newsresult = $search_newsresult->search();
		} else {
			CMS_grandFather::raiseError("Malformed atm-noresult tag : can't use this tag outside of atm-search \"newsresult\" tag ...");
			$results_newsresult = array();
		}
	} elseif (!$launchSearch_newsresult) {
		$results_newsresult = array();
	}
	if (!$results_newsresult) {
		$content .="Aucun r&eacute;sultat trouv&eacute; pour votre recherche ...";
	}
	//NO-RESULT newsresult TAG END 23_3d9934
	//destroy search and results newsresult objects
	unset($search_newsresult);
	unset($results_newsresult);
	//SEARCH newsresult TAG END 15_0bd9ec
	//AJAX TAG END 14_41a604
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
		
		
				Page  "Actualités" (http://127.0.0.1/web/demo/5-actualite.php)
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>