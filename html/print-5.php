<?php //Generated on Mon, 24 May 2010 16:59:49 +0200 by Automne (TM) 4.0.2
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-5-actualite.php', true, 301);
}
 ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"].'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {
$cms_view = CMS_view::getInstance();
//set default display mode for this page
$cms_view->setDisplayMode(CMS_view::SHOW_RAW);
$cms_view->setContentTag('data');
$cache_d783dc927ccc48d1c073baef1fe5ef50 = new CMS_cache('d783dc927ccc48d1c073baef1fe5ef50', 'polymod', 'auto', true);
if ($cache_d783dc927ccc48d1c073baef1fe5ef50->exist()):
	//Get content from cache
	$cache_d783dc927ccc48d1c073baef1fe5ef50_content = $cache_d783dc927ccc48d1c073baef1fe5ef50->load();
else:
	$cache_d783dc927ccc48d1c073baef1fe5ef50->start();

$content = "";
$replace = "";
$atmIfResults = array();
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
		//AJAX TAG START 3_edb3e6
		//SEARCH newsresult TAG START 4_7c5c10
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
		$public_4_7c5c10 = isset($public_search) ? $public_search : false;
		//get search params
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_4_7c5c10);
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
		//RESULT newsresult TAG START 5_492a23
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
			$object_5_492a23 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_5_492a23 = $replace; //save previous replace vars if any
			$count_5_492a23 = 0;
			$content_5_492a23 = $content; //save previous content var if any
			$maxPages_5_492a23 = $search_newsresult->getMaxPages();
			$maxResults_5_492a23 = $search_newsresult->getNumRows();
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
					"{firstresult}" => (!$count_5_492a23) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_492a23 == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_492a23+1),
					"{maxpages}"    => $maxPages_5_492a23,
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_5_492a23,
					"{altclass}"    => (($count_5_492a23+1) % 2) ? "CMS_odd" : "CMS_even",
				);
				//IF TAG START 6_cf7720
				$ifcondition_6_cf7720 = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_6_cf7720) {
					$func_6_cf7720 = create_function("","return (".$ifcondition_6_cf7720.");");
					if ($func_6_cf7720()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
					unset($func_6_cf7720);
				}
				unset($ifcondition_6_cf7720);
				//IF TAG END 6_cf7720
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
				//IF TAG START 7_9fcf31
				$ifcondition_7_9fcf31 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
				if ($ifcondition_7_9fcf31) {
					$func_7_9fcf31 = create_function("","return (".$ifcondition_7_9fcf31.");");
					if ($func_7_9fcf31()) {
						$content .="
						<div class=\"imgRight shadow\">
						".$object[1]->objectValues(4)->getValue('imageHTML','')."
						</div>
						";
					}
					unset($func_7_9fcf31);
				}
				unset($ifcondition_7_9fcf31);
				//IF TAG END 7_9fcf31
				//IF TAG START 8_ae1c8b
				$ifcondition_8_ae1c8b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition_8_ae1c8b) {
					$func_8_ae1c8b = create_function("","return (".$ifcondition_8_ae1c8b.");");
					if ($func_8_ae1c8b()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
					unset($func_8_ae1c8b);
				}
				unset($ifcondition_8_ae1c8b);
				//IF TAG END 8_ae1c8b
				//IF TAG START 9_6e8bab
				$ifcondition_9_6e8bab = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_9_6e8bab) {
					$func_9_6e8bab = create_function("","return (".$ifcondition_9_6e8bab.");");
					if ($func_9_6e8bab()) {
						$content .="
						".$object[1]->objectValues(2)->getValue('value','')."
						<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
						<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
						<span class=\"blocLienBottom\">En savoir plus</span>
						</a>
						";
					}
					unset($func_9_6e8bab);
				}
				unset($ifcondition_9_6e8bab);
				//IF TAG END 9_6e8bab
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
				//IF TAG START 10_fe356a
				$ifcondition_10_fe356a = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_10_fe356a) {
					$func_10_fe356a = create_function("","return (".$ifcondition_10_fe356a.");");
					if ($func_10_fe356a()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 11_ed5e08
						$parameters_11_ed5e08 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_11_ed5e08, array (
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
						//FUNCTION TAG END 11_ed5e08
						$content .="
						</div>
						";
					}
					unset($func_10_fe356a);
				}
				unset($ifcondition_10_fe356a);
				//IF TAG END 10_fe356a
				$count_5_492a23++;
				//do all result vars replacement
				$content_5_492a23.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_5_492a23; //retrieve previous content var if any
			unset($content_5_492a23);
			$replace = $replace_5_492a23; //retrieve previous replace vars if any
			unset($replace_5_492a23);
			$object[$objectDefinition_newsresult] = $object_5_492a23; //retrieve previous object search if any
			unset($object_5_492a23);
		}
		//RESULT newsresult TAG END 5_492a23
		//NO-RESULT newsresult TAG START 12_4cb63a
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
		//NO-RESULT newsresult TAG END 12_4cb63a
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
		//SEARCH newsresult TAG END 4_7c5c10
		//AJAX TAG END 3_edb3e6
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
    4 => 'pnews',
  ),
))).'}-->';


	echo $content;
	$cache_d783dc927ccc48d1c073baef1fe5ef50_content = $cache_d783dc927ccc48d1c073baef1fe5ef50->endSave();
endif;
unset($cache_d783dc927ccc48d1c073baef1fe5ef50);
$content = $cache_d783dc927ccc48d1c073baef1fe5ef50_content;
unset($cache_d783dc927ccc48d1c073baef1fe5ef50_content);
$cache_e7934e9c6753e491ead88c93404cf084 = new CMS_cache('e7934e9c6753e491ead88c93404cf084', 'polymod', 'auto', true);
if ($cache_e7934e9c6753e491ead88c93404cf084->exist()):
	//Get content from cache
	$cache_e7934e9c6753e491ead88c93404cf084_content = $cache_e7934e9c6753e491ead88c93404cf084->load();
else:
	$cache_e7934e9c6753e491ead88c93404cf084->start();

$content = "";
$replace = "";
$atmIfResults = array();
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
		//AJAX TAG START 14_ee4055
		//SEARCH newsresult TAG START 15_70e820
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
		$public_15_70e820 = isset($public_search) ? $public_search : false;
		//get search params
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_70e820);
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
		//RESULT newsresult TAG START 16_224a9b
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
			$object_16_224a9b = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_16_224a9b = $replace; //save previous replace vars if any
			$count_16_224a9b = 0;
			$content_16_224a9b = $content; //save previous content var if any
			$maxPages_16_224a9b = $search_newsresult->getMaxPages();
			$maxResults_16_224a9b = $search_newsresult->getNumRows();
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
					"{firstresult}" => (!$count_16_224a9b) ? 1 : 0,
					"{lastresult}" 	=> ($count_16_224a9b == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_16_224a9b+1),
					"{maxpages}"    => $maxPages_16_224a9b,
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
					"{maxresults}"  => $maxResults_16_224a9b,
					"{altclass}"    => (($count_16_224a9b+1) % 2) ? "CMS_odd" : "CMS_even",
				);
				//IF TAG START 17_da3d6c
				$ifcondition_17_da3d6c = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_17_da3d6c) {
					$func_17_da3d6c = create_function("","return (".$ifcondition_17_da3d6c.");");
					if ($func_17_da3d6c()) {
						$content .="
						<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
						";
					}
					unset($func_17_da3d6c);
				}
				unset($ifcondition_17_da3d6c);
				//IF TAG END 17_da3d6c
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
				//IF TAG START 18_753b76
				$ifcondition_18_753b76 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
				if ($ifcondition_18_753b76) {
					$func_18_753b76 = create_function("","return (".$ifcondition_18_753b76.");");
					if ($func_18_753b76()) {
						$content .="
						<div class=\"imgRight shadow\">
						".$object[1]->objectValues(4)->getValue('imageHTML','')."
						</div>
						";
					}
					unset($func_18_753b76);
				}
				unset($ifcondition_18_753b76);
				//IF TAG END 18_753b76
				//IF TAG START 19_df30fb
				$ifcondition_19_df30fb = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition_19_df30fb) {
					$func_19_df30fb = create_function("","return (".$ifcondition_19_df30fb.");");
					if ($func_19_df30fb()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
					unset($func_19_df30fb);
				}
				unset($ifcondition_19_df30fb);
				//IF TAG END 19_df30fb
				//IF TAG START 20_bec081
				$ifcondition_20_bec081 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_20_bec081) {
					$func_20_bec081 = create_function("","return (".$ifcondition_20_bec081.");");
					if ($func_20_bec081()) {
						$content .="
						".$object[1]->objectValues(2)->getValue('value','')."
						<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
						<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
						<span class=\"blocLienBottom\">En savoir plus</span>
						</a>
						";
					}
					unset($func_20_bec081);
				}
				unset($ifcondition_20_bec081);
				//IF TAG END 20_bec081
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
				//IF TAG START 21_5d82ba
				$ifcondition_21_5d82ba = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition_21_5d82ba) {
					$func_21_5d82ba = create_function("","return (".$ifcondition_21_5d82ba.");");
					if ($func_21_5d82ba()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
						//FUNCTION TAG START 22_c9fda3
						$parameters_22_c9fda3 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_c9fda3, array (
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
						//FUNCTION TAG END 22_c9fda3
						$content .="
						</div>
						";
					}
					unset($func_21_5d82ba);
				}
				unset($ifcondition_21_5d82ba);
				//IF TAG END 21_5d82ba
				$count_16_224a9b++;
				//do all result vars replacement
				$content_16_224a9b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
			}
			$content = $content_16_224a9b; //retrieve previous content var if any
			unset($content_16_224a9b);
			$replace = $replace_16_224a9b; //retrieve previous replace vars if any
			unset($replace_16_224a9b);
			$object[$objectDefinition_newsresult] = $object_16_224a9b; //retrieve previous object search if any
			unset($object_16_224a9b);
		}
		//RESULT newsresult TAG END 16_224a9b
		//NO-RESULT newsresult TAG START 23_31cd08
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
		//NO-RESULT newsresult TAG END 23_31cd08
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
		//SEARCH newsresult TAG END 15_70e820
		//AJAX TAG END 14_ee4055
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
    4 => 'pnews',
  ),
))).'}-->';


	echo $content;
	$cache_e7934e9c6753e491ead88c93404cf084_content = $cache_e7934e9c6753e491ead88c93404cf084->endSave();
endif;
unset($cache_e7934e9c6753e491ead88c93404cf084);
$content = $cache_e7934e9c6753e491ead88c93404cf084_content;
unset($cache_e7934e9c6753e491ead88c93404cf084_content);
$cms_view->setContent($content);
//output empty XML response
unset($content);
$cms_view->show();
}  ?><?php /* Template [print.xml] */   ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Actualités</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Actualités</h1>
<h3>

		&raquo;&nbsp;Exemples de modules
		
		&raquo;&nbsp;Actualités
		
</h3>
<?php /* Start clientspace [first] */   ?><?php /* Start row [605 [Actualités] Recherche - r58_610_Actualites__Recherche_FR.xml] */   ?>
	<?php $cache_449dff0a02e0cd56b4e09f6d3cd630b4 = new CMS_cache('449dff0a02e0cd56b4e09f6d3cd630b4', 'polymod', 'auto', true);
if ($cache_449dff0a02e0cd56b4e09f6d3cd630b4->exist()):
	//Get content from cache
	$cache_449dff0a02e0cd56b4e09f6d3cd630b4_content = $cache_449dff0a02e0cd56b4e09f6d3cd630b4->load();
else:
	$cache_449dff0a02e0cd56b4e09f6d3cd630b4->start();
	   ?>
<?php /*Generated on Mon, 24 May 2010 16:59:49 +0200 by Automne (TM) 4.0.2 */
if(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, 'CMS_profile_user') && $cms_user->hasModuleClearance('pnews', CLEARANCE_MODULE_VIEW))){
	$content = "";
	$replace = "";
	$atmIfResults = array();
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
	//FUNCTION TAG START 13_36849b
	$parameters_13_36849b = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_13_36849b = &$object[1]->objectValues(5);
	if (method_exists($object_13_36849b, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_13_36849b->selectOptions($parameters_13_36849b, NULL), $replace);
	} else {
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_13_36849b));
	}
	//FUNCTION TAG END 13_36849b
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
	//AJAX TAG START 14_ee4055
	//SEARCH newsresult TAG START 15_70e820
	$objectDefinition_newsresult = '1';
	if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
		$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
	}
	//public search ?
	$public_15_70e820 = isset($public_search) ? $public_search : false;
	//get search params
	$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_70e820);
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
	//RESULT newsresult TAG START 16_224a9b
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
		$object_16_224a9b = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
		$replace_16_224a9b = $replace; //save previous replace vars if any
		$count_16_224a9b = 0;
		$content_16_224a9b = $content; //save previous content var if any
		$maxPages_16_224a9b = $search_newsresult->getMaxPages();
		$maxResults_16_224a9b = $search_newsresult->getNumRows();
		foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
				"{firstresult}" => (!$count_16_224a9b) ? 1 : 0,
				"{lastresult}" 	=> ($count_16_224a9b == sizeof($results_newsresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_16_224a9b+1),
				"{maxpages}"    => $maxPages_16_224a9b,
				"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
				"{maxresults}"  => $maxResults_16_224a9b,
				"{altclass}"    => (($count_16_224a9b+1) % 2) ? "CMS_odd" : "CMS_even",
			);
			//IF TAG START 17_da3d6c
			$ifcondition_17_da3d6c = CMS_polymod_definition_parsing::replaceVars("{firstresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition_17_da3d6c) {
				$func_17_da3d6c = create_function("","return (".$ifcondition_17_da3d6c.");");
				if ($func_17_da3d6c()) {
					$content .="
					<div id=\"maxResults\">{maxresults} r&eacute;sultat(s) pour votre recherche.</div>
					";
				}
				unset($func_17_da3d6c);
			}
			unset($ifcondition_17_da3d6c);
			//IF TAG END 17_da3d6c
			$content .="
			<div class=\"newsTitle\">
			<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
			</div>
			<div class=\"newsContent\">
			";
			//IF TAG START 18_753b76
			$ifcondition_18_753b76 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[1]->objectValues(4)->getValue('imageName','')), $replace);
			if ($ifcondition_18_753b76) {
				$func_18_753b76 = create_function("","return (".$ifcondition_18_753b76.");");
				if ($func_18_753b76()) {
					$content .="
					<div class=\"imgRight shadow\">
					".$object[1]->objectValues(4)->getValue('imageHTML','')."
					</div>
					";
				}
				unset($func_18_753b76);
			}
			unset($ifcondition_18_753b76);
			//IF TAG END 18_753b76
			//IF TAG START 19_df30fb
			$ifcondition_19_df30fb = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
			if ($ifcondition_19_df30fb) {
				$func_19_df30fb = create_function("","return (".$ifcondition_19_df30fb.");");
				if ($func_19_df30fb()) {
					$content .="
					<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
					<br />".$object[1]->objectValues(3)->getValue('value','')."
					";
				}
				unset($func_19_df30fb);
			}
			unset($ifcondition_19_df30fb);
			//IF TAG END 19_df30fb
			//IF TAG START 20_bec081
			$ifcondition_20_bec081 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition_20_bec081) {
				$func_20_bec081 = create_function("","return (".$ifcondition_20_bec081.");");
				if ($func_20_bec081()) {
					$content .="
					".$object[1]->objectValues(2)->getValue('value','')."
					<a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" class=\"blocLien\" title=\"En savoir plus concernant '".$object[1]->getValue('label','')."'\">
					<span class=\"blocLienTop\">".$object[1]->getValue('label','')."</span>
					<span class=\"blocLienBottom\">En savoir plus</span>
					</a>
					";
				}
				unset($func_20_bec081);
			}
			unset($ifcondition_20_bec081);
			//IF TAG END 20_bec081
			$content .="
			<div class=\"spacer\"></div>
			</div>
			";
			//IF TAG START 21_5d82ba
			$ifcondition_21_5d82ba = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition_21_5d82ba) {
				$func_21_5d82ba = create_function("","return (".$ifcondition_21_5d82ba.");");
				if ($func_21_5d82ba()) {
					$content .="
					<div class=\"pages\" id=\"pages\">
					";
					//FUNCTION TAG START 22_c9fda3
					$parameters_22_c9fda3 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
					if (method_exists(new CMS_poly_definition_functions(), "pages")) {
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_c9fda3, array (
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
					//FUNCTION TAG END 22_c9fda3
					$content .="
					</div>
					";
				}
				unset($func_21_5d82ba);
			}
			unset($ifcondition_21_5d82ba);
			//IF TAG END 21_5d82ba
			$count_16_224a9b++;
			//do all result vars replacement
			$content_16_224a9b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
		}
		$content = $content_16_224a9b; //retrieve previous content var if any
		unset($content_16_224a9b);
		$replace = $replace_16_224a9b; //retrieve previous replace vars if any
		unset($replace_16_224a9b);
		$object[$objectDefinition_newsresult] = $object_16_224a9b; //retrieve previous object search if any
		unset($object_16_224a9b);
	}
	//RESULT newsresult TAG END 16_224a9b
	//NO-RESULT newsresult TAG START 23_31cd08
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
	//NO-RESULT newsresult TAG END 23_31cd08
	//destroy search and results newsresult objects
	unset($search_newsresult);
	unset($results_newsresult);
	//SEARCH newsresult TAG END 15_70e820
	//AJAX TAG END 14_ee4055
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
			4 => 'pnews',
		),
	))).'}-->';
	echo $content;
	unset($content);}
	   ?>
	<?php $cache_449dff0a02e0cd56b4e09f6d3cd630b4_content = $cache_449dff0a02e0cd56b4e09f6d3cd630b4->endSave();
endif;
unset($cache_449dff0a02e0cd56b4e09f6d3cd630b4);
echo $cache_449dff0a02e0cd56b4e09f6d3cd630b4_content;
unset($cache_449dff0a02e0cd56b4e09f6d3cd630b4_content);
   ?>
	
<?php /* End row [605 [Actualités] Recherche - r58_610_Actualites__Recherche_FR.xml] */   ?><?php /* End clientspace [first] */   ?><br />
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