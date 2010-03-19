<<<<<<< TREE
<?php //Generated on Thu, 11 Mar 2010 16:57:18 +0100 by Automne (TM) 4.0.1
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');
=======
<?php //Generated on Fri, 19 Mar 2010 15:24:29 +0100 by Automne (TM) 4.0.1
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
>>>>>>> MERGE-SOURCE
if (!isset($cms_page_included) && !$_POST && !$_GET) {
<<<<<<< TREE
	CMS_view::redirect('http://test-folder/trunk/web/demo/print-5-actualite.php', true, 301);
=======
	CMS_view::redirect('http://127.0.0.1/web/demo/print-5-actualite.php', true, 301);
>>>>>>> MERGE-SOURCE
}
 ?>
<?php require_once(PATH_REALROOT_FS.'/automne/classes/polymodFrontEnd.php');  ?><?php if(isset($_REQUEST['out']) && $_REQUEST['out'] == 'xml') {

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
<<<<<<< TREE
		//AJAX TAG START 3_bbb909
		//SEARCH newsresult TAG START 4_d05388
=======
		//AJAX TAG START 3_fe7474
		//SEARCH newsresult TAG START 4_a4e1c0
>>>>>>> MERGE-SOURCE
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
<<<<<<< TREE
		$public_4_d05388 = isset($public_search) ? $public_search : false;
=======
		$public_4_a4e1c0 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
		//get search params
<<<<<<< TREE
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_4_d05388);
=======
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_4_a4e1c0);
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
		//RESULT newsresult TAG START 5_6613b4
=======
		//RESULT newsresult TAG START 5_9a8b54
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
			$object_5_6613b4 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_5_6613b4 = $replace; //save previous replace vars if any
			$count_5_6613b4 = 0;
			$content_5_6613b4 = $content; //save previous content var if any
			$maxPages_5_6613b4 = $search_newsresult->getMaxPages();
			$maxResults_5_6613b4 = $search_newsresult->getNumRows();
=======
			$object_5_9a8b54 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_5_9a8b54 = $replace; //save previous replace vars if any
			$count_5_9a8b54 = 0;
			$content_5_9a8b54 = $content; //save previous content var if any
			$maxPages_5_9a8b54 = $search_newsresult->getMaxPages();
			$maxResults_5_9a8b54 = $search_newsresult->getNumRows();
>>>>>>> MERGE-SOURCE
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
<<<<<<< TREE
					"{firstresult}" => (!$count_5_6613b4) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_6613b4 == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_6613b4+1),
					"{maxpages}"    => $maxPages_5_6613b4,
=======
					"{firstresult}" => (!$count_5_9a8b54) ? 1 : 0,
					"{lastresult}" 	=> ($count_5_9a8b54 == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_5_9a8b54+1),
					"{maxpages}"    => $maxPages_5_9a8b54,
>>>>>>> MERGE-SOURCE
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
<<<<<<< TREE
					"{maxresults}"  => $maxResults_5_6613b4,
=======
					"{maxresults}"  => $maxResults_5_9a8b54,
>>>>>>> MERGE-SOURCE
				);
<<<<<<< TREE
				//IF TAG START 6_ed48b2
=======
				//IF TAG START 6_e458a8
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
				}//IF TAG END 6_ed48b2
=======
				}//IF TAG END 6_e458a8
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
<<<<<<< TREE
				//IF TAG START 7_a9ce85
=======
				//IF TAG START 7_9e5fa9
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
				}//IF TAG END 7_a9ce85
				//IF TAG START 8_38786e
=======
				}//IF TAG END 7_9e5fa9
				//IF TAG START 8_4ff686
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
<<<<<<< TREE
				}//IF TAG END 8_38786e
				//IF TAG START 9_ea8bf8
=======
				}//IF TAG END 8_4ff686
				//IF TAG START 9_32c6c6
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
				}//IF TAG END 9_ea8bf8
=======
				}//IF TAG END 9_32c6c6
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
<<<<<<< TREE
				//IF TAG START 10_ed7347
=======
				//IF TAG START 10_d74fdb
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
<<<<<<< TREE
						//FUNCTION TAG START 11_91007d
						$parameters_11_91007d = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
						//FUNCTION TAG START 11_f70177
						$parameters_11_f70177 = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_11_91007d, array (
=======
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_11_f70177, array (
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
														'src' => 'img/demo/interieur/newsNext.gif',
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
<<<<<<< TREE
						//FUNCTION TAG END 11_91007d
=======
						//FUNCTION TAG END 11_f70177
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 10_ed7347
				$count_5_6613b4++;
=======
				}//IF TAG END 10_d74fdb
				$count_5_9a8b54++;
>>>>>>> MERGE-SOURCE
				//do all result vars replacement
<<<<<<< TREE
				$content_5_6613b4.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
				$content_5_9a8b54.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
			}
<<<<<<< TREE
			$content = $content_5_6613b4; //retrieve previous content var if any
			$replace = $replace_5_6613b4; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_5_6613b4; //retrieve previous object search if any
=======
			$content = $content_5_9a8b54; //retrieve previous content var if any
			$replace = $replace_5_9a8b54; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_5_9a8b54; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		//RESULT newsresult TAG END 5_6613b4
		//NO-RESULT newsresult TAG START 12_5687a8
=======
		//RESULT newsresult TAG END 5_9a8b54
		//NO-RESULT newsresult TAG START 12_fa1436
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
		//NO-RESULT newsresult TAG END 12_5687a8
=======
		//NO-RESULT newsresult TAG END 12_fa1436
>>>>>>> MERGE-SOURCE
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
<<<<<<< TREE
		//SEARCH newsresult TAG END 4_d05388
		//AJAX TAG END 3_bbb909
=======
		//SEARCH newsresult TAG END 4_a4e1c0
		//AJAX TAG END 3_fe7474
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
<<<<<<< TREE
		//AJAX TAG START 14_7fdd17
		//SEARCH newsresult TAG START 15_c1aa91
=======
		//AJAX TAG START 14_a99507
		//SEARCH newsresult TAG START 15_117818
>>>>>>> MERGE-SOURCE
		$objectDefinition_newsresult = '1';
		if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
			$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
		}
		//public search ?
<<<<<<< TREE
		$public_15_c1aa91 = isset($public_search) ? $public_search : false;
=======
		$public_15_117818 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
		//get search params
<<<<<<< TREE
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_c1aa91);
=======
		$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_117818);
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
		//RESULT newsresult TAG START 16_fe5bd8
=======
		//RESULT newsresult TAG START 16_5fc60b
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
			$object_16_fe5bd8 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_16_fe5bd8 = $replace; //save previous replace vars if any
			$count_16_fe5bd8 = 0;
			$content_16_fe5bd8 = $content; //save previous content var if any
			$maxPages_16_fe5bd8 = $search_newsresult->getMaxPages();
			$maxResults_16_fe5bd8 = $search_newsresult->getNumRows();
=======
			$object_16_5fc60b = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
			$replace_16_5fc60b = $replace; //save previous replace vars if any
			$count_16_5fc60b = 0;
			$content_16_5fc60b = $content; //save previous content var if any
			$maxPages_16_5fc60b = $search_newsresult->getMaxPages();
			$maxResults_16_5fc60b = $search_newsresult->getNumRows();
>>>>>>> MERGE-SOURCE
			foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
				$content = "";
				$replace["atm-search"] = array (
					"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
<<<<<<< TREE
					"{firstresult}" => (!$count_16_fe5bd8) ? 1 : 0,
					"{lastresult}" 	=> ($count_16_fe5bd8 == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_16_fe5bd8+1),
					"{maxpages}"    => $maxPages_16_fe5bd8,
=======
					"{firstresult}" => (!$count_16_5fc60b) ? 1 : 0,
					"{lastresult}" 	=> ($count_16_5fc60b == sizeof($results_newsresult)-1) ? 1 : 0,
					"{resultcount}" => ($count_16_5fc60b+1),
					"{maxpages}"    => $maxPages_16_5fc60b,
>>>>>>> MERGE-SOURCE
					"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
<<<<<<< TREE
					"{maxresults}"  => $maxResults_16_fe5bd8,
=======
					"{maxresults}"  => $maxResults_16_5fc60b,
>>>>>>> MERGE-SOURCE
				);
<<<<<<< TREE
				//IF TAG START 17_05a95a
=======
				//IF TAG START 17_70a2c6
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
				}//IF TAG END 17_05a95a
=======
				}//IF TAG END 17_70a2c6
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"newsTitle\">
				<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
				</div>
				<div class=\"newsContent\">
				";
<<<<<<< TREE
				//IF TAG START 18_7cd946
=======
				//IF TAG START 18_2b97c0
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
				}//IF TAG END 18_7cd946
				//IF TAG START 19_d58d87
=======
				}//IF TAG END 18_2b97c0
				//IF TAG START 19_b9303b
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
						<br />".$object[1]->objectValues(3)->getValue('value','')."
						";
					}
<<<<<<< TREE
				}//IF TAG END 19_d58d87
				//IF TAG START 20_216471
=======
				}//IF TAG END 19_b9303b
				//IF TAG START 20_1e1ab4
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
				}//IF TAG END 20_216471
=======
				}//IF TAG END 20_1e1ab4
>>>>>>> MERGE-SOURCE
				$content .="
				<div class=\"spacer\"></div>
				</div>
				";
<<<<<<< TREE
				//IF TAG START 21_a07478
=======
				//IF TAG START 21_a6b141
>>>>>>> MERGE-SOURCE
				$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
				if ($ifcondition) {
					$func = create_function("","return (".$ifcondition.");");
					if ($func()) {
						$content .="
						<div class=\"pages\" id=\"pages\">
						";
<<<<<<< TREE
						//FUNCTION TAG START 22_fc4c9f
						$parameters_22_fc4c9f = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
						//FUNCTION TAG START 22_26afff
						$parameters_22_26afff = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
						if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_fc4c9f, array (
=======
							$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_26afff, array (
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
														'src' => 'img/demo/interieur/newsNext.gif',
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
<<<<<<< TREE
						//FUNCTION TAG END 22_fc4c9f
=======
						//FUNCTION TAG END 22_26afff
>>>>>>> MERGE-SOURCE
						$content .="
						</div>
						";
					}
<<<<<<< TREE
				}//IF TAG END 21_a07478
				$count_16_fe5bd8++;
=======
				}//IF TAG END 21_a6b141
				$count_16_5fc60b++;
>>>>>>> MERGE-SOURCE
				//do all result vars replacement
<<<<<<< TREE
				$content_16_fe5bd8.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
				$content_16_5fc60b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
			}
<<<<<<< TREE
			$content = $content_16_fe5bd8; //retrieve previous content var if any
			$replace = $replace_16_fe5bd8; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_16_fe5bd8; //retrieve previous object search if any
=======
			$content = $content_16_5fc60b; //retrieve previous content var if any
			$replace = $replace_16_5fc60b; //retrieve previous replace vars if any
			$object[$objectDefinition_newsresult] = $object_16_5fc60b; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		//RESULT newsresult TAG END 16_fe5bd8
		//NO-RESULT newsresult TAG START 23_414a90
=======
		//RESULT newsresult TAG END 16_5fc60b
		//NO-RESULT newsresult TAG START 23_34ade8
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
		//NO-RESULT newsresult TAG END 23_414a90
=======
		//NO-RESULT newsresult TAG END 23_34ade8
>>>>>>> MERGE-SOURCE
		//destroy search and results newsresult objects
		unset($search_newsresult);
		unset($results_newsresult);
<<<<<<< TREE
		//SEARCH newsresult TAG END 15_c1aa91
		//AJAX TAG END 14_7fdd17
=======
		//SEARCH newsresult TAG END 15_117818
		//AJAX TAG END 14_a99507
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
	<?php /*Generated on Fri, 19 Mar 2010 15:24:29 +0100 by Automne (TM) 4.0.1 */
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
<<<<<<< TREE
	//FUNCTION TAG START 13_45e793
	$parameters_13_45e793 = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_13_45e793 = &$object[1]->objectValues(5);
	if (method_exists($object_13_45e793, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_13_45e793->selectOptions($parameters_13_45e793, NULL), $replace);
=======
	//FUNCTION TAG START 13_7d68ff
	$parameters_13_7d68ff = array ('selected' => CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::getVarContent("request", "cat", "int", @$cat), $replace),);
	$object_13_7d68ff = &$object[1]->objectValues(5);
	if (method_exists($object_13_7d68ff, "selectOptions")) {
		$content .= CMS_polymod_definition_parsing::replaceVars($object_13_7d68ff->selectOptions($parameters_13_7d68ff, NULL), $replace);
>>>>>>> MERGE-SOURCE
	} else {
<<<<<<< TREE
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_13_45e793));
=======
		CMS_grandFather::raiseError("Malformed atm-function tag : can't found method selectOptions on object : ".get_class($object_13_7d68ff));
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
	//FUNCTION TAG END 13_45e793
=======
	//FUNCTION TAG END 13_7d68ff
>>>>>>> MERGE-SOURCE
	$content .="
	</select>
	</div>
	<div id=\"loadingSearch\"><img src=\"img/demo/interieur/loading-news.gif\" alt=\"Chargement ...\" title=\"Chargement ...\" /></div>
	<input type=\"submit\" class=\"button\" name=\"search\" id=\"submitSearch\" value=\"ok\" />
	<div class=\"spacer\"></div>
	</div>
	</form>
	</div>
	<div id=\"searchresult\">
	";
<<<<<<< TREE
	//AJAX TAG START 14_7fdd17
	//SEARCH newsresult TAG START 15_c1aa91
=======
	//AJAX TAG START 14_a99507
	//SEARCH newsresult TAG START 15_117818
>>>>>>> MERGE-SOURCE
	$objectDefinition_newsresult = '1';
	if (!isset($objectDefinitions[$objectDefinition_newsresult])) {
		$objectDefinitions[$objectDefinition_newsresult] = new CMS_poly_object_definition($objectDefinition_newsresult);
	}
	//public search ?
<<<<<<< TREE
	$public_15_c1aa91 = isset($public_search) ? $public_search : false;
=======
	$public_15_117818 = isset($public_search) ? $public_search : false;
>>>>>>> MERGE-SOURCE
	//get search params
<<<<<<< TREE
	$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_c1aa91);
=======
	$search_newsresult = new CMS_object_search($objectDefinitions[$objectDefinition_newsresult], $public_15_117818);
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
	//RESULT newsresult TAG START 16_fe5bd8
=======
	//RESULT newsresult TAG START 16_5fc60b
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
		$object_16_fe5bd8 = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
		$replace_16_fe5bd8 = $replace; //save previous replace vars if any
		$count_16_fe5bd8 = 0;
		$content_16_fe5bd8 = $content; //save previous content var if any
		$maxPages_16_fe5bd8 = $search_newsresult->getMaxPages();
		$maxResults_16_fe5bd8 = $search_newsresult->getNumRows();
=======
		$object_16_5fc60b = (isset($object[$objectDefinition_newsresult])) ? $object[$objectDefinition_newsresult] : ""; //save previous object search if any
		$replace_16_5fc60b = $replace; //save previous replace vars if any
		$count_16_5fc60b = 0;
		$content_16_5fc60b = $content; //save previous content var if any
		$maxPages_16_5fc60b = $search_newsresult->getMaxPages();
		$maxResults_16_5fc60b = $search_newsresult->getNumRows();
>>>>>>> MERGE-SOURCE
		foreach ($results_newsresult as $object[$objectDefinition_newsresult]) {
			$content = "";
			$replace["atm-search"] = array (
				"{resultid}" 	=> (isset($resultID_newsresult)) ? $resultID_newsresult : $object[$objectDefinition_newsresult]->getID(),
<<<<<<< TREE
				"{firstresult}" => (!$count_16_fe5bd8) ? 1 : 0,
				"{lastresult}" 	=> ($count_16_fe5bd8 == sizeof($results_newsresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_16_fe5bd8+1),
				"{maxpages}"    => $maxPages_16_fe5bd8,
=======
				"{firstresult}" => (!$count_16_5fc60b) ? 1 : 0,
				"{lastresult}" 	=> ($count_16_5fc60b == sizeof($results_newsresult)-1) ? 1 : 0,
				"{resultcount}" => ($count_16_5fc60b+1),
				"{maxpages}"    => $maxPages_16_5fc60b,
>>>>>>> MERGE-SOURCE
				"{currentpage}" => ($search_newsresult->getAttribute('page')+1),
<<<<<<< TREE
				"{maxresults}"  => $maxResults_16_fe5bd8,
=======
				"{maxresults}"  => $maxResults_16_5fc60b,
>>>>>>> MERGE-SOURCE
			);
<<<<<<< TREE
			//IF TAG START 17_05a95a
=======
			//IF TAG START 17_70a2c6
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
			}//IF TAG END 17_05a95a
=======
			}//IF TAG END 17_70a2c6
>>>>>>> MERGE-SOURCE
			$content .="
			<div class=\"newsTitle\">
			<h2><a href=\"".CMS_tree::getPageValue($parameters['pageID'],"url")."?item=".$object[1]->getValue('id','')."\" title=\"".$object[1]->getValue('label','')."\">".$object[1]->getValue('label','')."</a></h2><span>".$object[1]->getValue('formatedDateStart','d/m/Y')."</span><div class=\"spacer\"></div>
			</div>
			<div class=\"newsContent\">
			";
<<<<<<< TREE
			//IF TAG START 18_7cd946
=======
			//IF TAG START 18_2b97c0
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
			}//IF TAG END 18_7cd946
			//IF TAG START 19_d58d87
=======
			}//IF TAG END 18_2b97c0
			//IF TAG START 19_b9303b
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item))." == ".CMS_polymod_definition_parsing::prepareVar($object[1]->getValue('id','')), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<strong>".$object[1]->objectValues(2)->getValue('value','')."</strong>
					<br />".$object[1]->objectValues(3)->getValue('value','')."
					";
				}
<<<<<<< TREE
			}//IF TAG END 19_d58d87
			//IF TAG START 20_216471
=======
			}//IF TAG END 19_b9303b
			//IF TAG START 20_1e1ab4
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
			}//IF TAG END 20_216471
=======
			}//IF TAG END 20_1e1ab4
>>>>>>> MERGE-SOURCE
			$content .="
			<div class=\"spacer\"></div>
			</div>
			";
<<<<<<< TREE
			//IF TAG START 21_a07478
=======
			//IF TAG START 21_a6b141
>>>>>>> MERGE-SOURCE
			$ifcondition = CMS_polymod_definition_parsing::replaceVars("{lastresult} && !".CMS_polymod_definition_parsing::prepareVar(CMS_poly_definition_functions::getVarContent("request", "item", "int", @$item)), $replace);
			if ($ifcondition) {
				$func = create_function("","return (".$ifcondition.");");
				if ($func()) {
					$content .="
					<div class=\"pages\" id=\"pages\">
					";
<<<<<<< TREE
					//FUNCTION TAG START 22_fc4c9f
					$parameters_22_fc4c9f = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
=======
					//FUNCTION TAG START 22_26afff
					$parameters_22_26afff = array ('maxpages' => CMS_polymod_definition_parsing::replaceVars("{maxpages}", $replace),'currentpage' => CMS_polymod_definition_parsing::replaceVars("{currentpage}", $replace),'displayedpage' => CMS_polymod_definition_parsing::replaceVars("5", $replace),);
>>>>>>> MERGE-SOURCE
					if (method_exists(new CMS_poly_definition_functions(), "pages")) {
<<<<<<< TREE
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_fc4c9f, array (
=======
						$content .= CMS_polymod_definition_parsing::replaceVars(CMS_poly_definition_functions::pages($parameters_22_26afff, array (
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
													'src' => 'img/demo/interieur/newsNext.gif',
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
<<<<<<< TREE
					//FUNCTION TAG END 22_fc4c9f
=======
					//FUNCTION TAG END 22_26afff
>>>>>>> MERGE-SOURCE
					$content .="
					</div>
					";
				}
<<<<<<< TREE
			}//IF TAG END 21_a07478
			$count_16_fe5bd8++;
=======
			}//IF TAG END 21_a6b141
			$count_16_5fc60b++;
>>>>>>> MERGE-SOURCE
			//do all result vars replacement
<<<<<<< TREE
			$content_16_fe5bd8.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
=======
			$content_16_5fc60b.= CMS_polymod_definition_parsing::replaceVars($content, $replace);
>>>>>>> MERGE-SOURCE
		}
<<<<<<< TREE
		$content = $content_16_fe5bd8; //retrieve previous content var if any
		$replace = $replace_16_fe5bd8; //retrieve previous replace vars if any
		$object[$objectDefinition_newsresult] = $object_16_fe5bd8; //retrieve previous object search if any
=======
		$content = $content_16_5fc60b; //retrieve previous content var if any
		$replace = $replace_16_5fc60b; //retrieve previous replace vars if any
		$object[$objectDefinition_newsresult] = $object_16_5fc60b; //retrieve previous object search if any
>>>>>>> MERGE-SOURCE
	}
<<<<<<< TREE
	//RESULT newsresult TAG END 16_fe5bd8
	//NO-RESULT newsresult TAG START 23_414a90
=======
	//RESULT newsresult TAG END 16_5fc60b
	//NO-RESULT newsresult TAG START 23_34ade8
>>>>>>> MERGE-SOURCE
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
<<<<<<< TREE
	//NO-RESULT newsresult TAG END 23_414a90
=======
	//NO-RESULT newsresult TAG END 23_34ade8
>>>>>>> MERGE-SOURCE
	//destroy search and results newsresult objects
	unset($search_newsresult);
	unset($results_newsresult);
<<<<<<< TREE
	//SEARCH newsresult TAG END 15_c1aa91
	//AJAX TAG END 14_7fdd17
=======
	//SEARCH newsresult TAG END 15_117818
	//AJAX TAG END 14_a99507
>>>>>>> MERGE-SOURCE
	$content .="
	</div>
	";
	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);
}
   ?>	
<?php /* End row [605 [Actualités] Recherche - r58_610_Actualites__Recherche_FR.xml] */   ?><?php /* End clientspace [first] */   ?><br />
<hr />
<div align="center">
	<small>
		
		
<<<<<<< TREE
				Page  "Actualités" (http://test-folder/trunk/web/demo/5-actualite.php)
=======
				Page  "Actualités" (http://127.0.0.1/web/demo/5-actualite.php)
>>>>>>> MERGE-SOURCE
				<br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>