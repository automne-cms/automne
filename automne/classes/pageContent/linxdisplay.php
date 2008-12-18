<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: linxdisplay.php,v 1.2 2008/12/18 10:40:54 sebastien Exp $

/**
  * Class CMS_linxDisplay
  *
  * Manages a linx "display" tag representation
  *
  * @package CMS
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_linxDisplay extends CMS_grandFather
{
	/**
	  * The html template, which will contain several {{xxx}} strings
	  * @var string
	  * @access private
	  */
	protected $_htmlTemplate;
	
	/**
	  * The html sublevel template, which will contain {{sublevel}} strings (only for recursivelinks)
	  * @var string
	  * @access private
	  */
	protected $_subleveltemplate;
	
	/**
	  * The display mode (only for recursivelinks) : open or close (default is close)
	  * @var string
	  * @access private
	  */
	protected $_mode = "close";
	
	/**
	  * Conditions of the display. If none, it's the default display we're dealing with.
	  * @var array of CMS_linxCondition
	  * @access private
	  */
	protected $_conditions = array();
	
	/**
	  * Constructor.
	  * initializes the linxDisplay.
	  *
	  * @param string $tagContent The tag content.
	  * @return void
	  * @access public
	  */
	function __construct($tag)
	{
		$conditions = $tag->getElementsByTagName('condition');
		$htmltemplates = $tag->getElementsByTagName('htmltemplate');
		$modes = $tag->getElementsByTagName('mode');
		$subleveltemplates = $tag->getElementsByTagName('subleveltemplate');
		//conditions
		if ($conditions->length > 0) {
			foreach ($conditions as $condition) {
				$this->_conditions[] = CMS_linxCondition::createCondition($condition);
			}
		}
		//htmltemplate
		if ($htmltemplates->length > 0) {
			$this->_htmlTemplate = CMS_DOMDocument::DOMElementToString($htmltemplates->item(0), true);
		}
		//mode
		if ($modes->length > 0) {
			$this->_mode = trim(CMS_DOMDocument::DOMElementToString($modes->item(0), true));
		}
		//subleveltemplate
		if ($subleveltemplates->length > 0) {
			$this->_subleveltemplate = CMS_DOMDocument::DOMElementToString($subleveltemplates->item(0), true);
		}
	}

	/**
	  * Get the HTML display for a page, if it passes the condition of course.
	  *
	  * @param CMS_page $parsedPage The page in which the linx tag is
	  * @param CMS_page $page The page to get the display of
	  * @param boolean $public Is the page data to show the public or edited one ?
	  * @param integer $rank The rank of the page in the linx targets
	  * @param boolean $noerror : Hide all link error (default : false)
	  * @return string The html or false if page fails to pass the condition
	  * @access public
	  */
	function getOutput(&$parsedPage, &$page, $public, $rank, $noerror = false)
	{
		if (!is_a($page,"CMS_page")) {
			if (!$noerror) {
				$tpl = $parsedPage->getTemplate();
				if (is_a($tpl,'CMS_pageTemplate')) {
					$tplName = $tpl->getID()."\t : ".$tpl->getLabel();
				} else {
					$tplName = 'No template set !';
				}
				$this->raiseError("Page parameter not defined\n - Page : ".$parsedPage->getID()."\n - Template : ".$tplName."\n");
			}
			return false;
		}
		if (!$this->hasCondition() || $this->pagePassesConditions($parsedPage, $page, $public, $rank)) {
			//get pages infos
			$linkTitle = $page->getLinkTitle($public);
			$jsLinkTitle = str_replace("'", "\'", $linkTitle);
			$title = $page->getTitle($public);
			$jsTitle = str_replace("'", "\'", $title);
			$replace = array(
				"{{title}}"         => $linkTitle,
				"{{jstitle}}"       => $jsLinkTitle,
				"{{pagetitle}}"     => $title,
				"{{jspagetitle}}"   => $jsTitle,
				"{{desc}}"          => $page->getDescription($public),
				"{{href}}"          => $page->getURL(),
				"{{id}}"            => $page->getID(),
				"{{number}}" 		=> ($rank-1),
				"{{modulo}}" 		=> ($rank-1) % 2,
				"{{currentClass}}" 	=> ($parsedPage->getID() == $page->getID()) ? "CMS_current" : "",
				'id="{{currentID}}"'=> ($parsedPage->getID() == $page->getID()) ? 'id="CMS_current"' : "",
			);
			if (strpos($this->_htmlTemplate,'{{isParent}}') !== false) {
				//only if needed because getLineage require a lot of query
				$lineage = CMS_tree::getLineage($page->getID(), $parsedPage->getID(), false);
				$replace['class="{{isParent}}"'] 	= (is_array($lineage) && in_array($parsedPage->getID(), $lineage)) ? 'class="CMS_parent"' : "";
				$replace['{{isParent}}'] 			= (is_array($lineage) && in_array($parsedPage->getID(), $lineage)) ? 'CMS_parent' : "";
				$replace['id="{{isParent}}"']		= (is_array($lineage) && in_array($parsedPage->getID(), $lineage)) ? 'id="CMS_parent"' : "";
			}
			$html = str_replace(array_keys($replace), $replace, $this->_htmlTemplate);
			if (APPLICATION_ENFORCES_ACCESS_CONTROL && $public && !(eregi("(page_previsualization.php|page_content.php)", $_SERVER["SCRIPT_NAME"]))) { //TODOV4
				$html=$this->_addSlashAroundPHPContent($html);
				//pr($html);
				$replace = array(
					"<?php" => "';",
					"?>" 	=> "echo '",
				);
				$html = str_replace(array_keys($replace), $replace, $html);
				$html=
				'<?php if ($cms_user->hasPageClearance('.$page->getID().', CLEARANCE_PAGE_VIEW)) {'."\n".
					'echo \''.$html.'\';'."\n".
				'}'."\n".
				'?>';
			}
			return $html;
		} else {
			return false;
		}
	}
	
	/**
	  * Surround the HTML output by sublevel template if any.
	  *
	  * @param string $html The html to surround by sublevel html
	  * @return string The html sourrounded
	  * @access public
	  */
	function getSubLevelOutput($html) {
		if ($html && strpos($this->_subleveltemplate , "{{sublevel}}") !== false) {
			$replace = array(
				"{{sublevel}}" 	=> $html
			);
			$html = str_replace(array_keys($replace), $replace, $this->_subleveltemplate);
		}
		return $html;
	}
	
	/**
	  * Get the recursive HTML display for a recursivelinks, if it passes the condition of course.
	  *
	  * @param CMS_page $parsedPage The page in which the linx tag is
	  * @param integer $level The current level of recursivity
	  * @param multidimentionnal array $recursiveTree The tree to display
	  * @param array $pages array of pages objects (indexed by id)
	  * @param boolean $public Is the page data to show the public or edited one ?
	  * @param array $lineage The lineage of the pages (used to see wich recursions need to be done in closed link display mode)
	  * @return string The html of the recursive link
	  * @access public
	  */
	function getRecursiveOutput(&$parsedPage, $level=0, $recursiveTree, &$pages, $public, $lineage=array())
	{
		$html = '';
		if (is_array($recursiveTree) && $recursiveTree) {
			$rank = 1;
			$levelhtml='';
			foreach ($recursiveTree as $pageID => $subPages) {
				//get Page Object
				$page = $pages[$pageID];
				//instanciate page if not exists as object
				if (!is_object($page) && sensitiveIO::isPositiveInteger($page)) {
					$page = CMS_tree::getPageByID($page);
				}
				$pagehtml = '';
				//check if page pass the condition
				if (is_object($page) && (!$this->hasCondition() || $this->pagePassesConditions($parsedPage, $page, $public, $rank)) && $page->getPublication() == RESOURCE_PUBLICATION_PUBLIC) {
					//get pages infos
					$linkTitle = $page->getLinkTitle($public);
                    $jsLinkTitle = str_replace("'", "\'", $linkTitle);
                    $title = $page->getTitle($public);
                    $jsTitle = str_replace("'", "\'", $title);
					//set pages infos in html template
					$replace = array(
						"{{title}}"         => $linkTitle,
                        "{{jstitle}}"       => $jsLinkTitle,
                        "{{pagetitle}}"     => $title,
                        "{{jspagetitle}}"   => $jsTitle,
  	                    "{{desc}}"          => $page->getDescription($public),
  	                    "{{href}}"          => $page->getURL(),
  	                    "{{id}}"            => $page->getID(),
						"{{number}}" 		=> ($rank-1),
						"{{modulo}}" 		=> ($rank-1) % 2,
						"{{lvlClass}}" 		=> "CMS_lvl".($level+1),
						"{{currentClass}}" 	=> ($parsedPage->getID() == $page->getID()) ? "CMS_current" : "",
						'id="{{currentID}}"'=> ($parsedPage->getID() == $page->getID()) ? 'id="CMS_current"' : "",
					);
					if (strpos($this->_htmlTemplate,'{{isParent}}') !== false) {
						//only if needed because getLineage require a lot of query
						$pagelineage = CMS_tree::getLineage($page->getID(), $parsedPage->getID(), false);
                        $replace['class="{{isParent}}"'] = (is_array($pagelineage) && in_array($parsedPage->getID(), $pagelineage)) ? 'class="CMS_parent"' : "";
                        $replace['{{isParent}}']         = (is_array($pagelineage) && in_array($parsedPage->getID(), $pagelineage)) ? 'CMS_parent' : "";
                        $replace['id="{{isParent}}"']    = (is_array($pagelineage) && in_array($parsedPage->getID(), $pagelineage)) ? 'id="CMS_parent"' : "";
					}
					$pagehtml = str_replace(array_keys($replace), $replace, $this->_htmlTemplate);
					//check if link is in open or closed mode
					if ($this->_mode == "open") {
						//if it is open mode recurse indefinitely (until end of tree)
						//then mark info of sublevels or not
						$replace = array(
							"{{typeClass}}" => ($subPages) ? "CMS_sub" : "CMS_nosub",
							"{{sublevel}}" 	=> $this->getRecursiveOutput($parsedPage, $level+1, $subPages, $pages, $public),
						);
						$pagehtml = str_replace(array_keys($replace), $replace, $pagehtml);
					} else {
						//if it is 'close' mode recurse only for pages in current lineage
						$recurse = (in_array($page->getID(),$lineage)) ? true : false;
						//then mark info of sublevels or not and if level is open or not
						$sub = ($recurse) ? "CMS_open" : "CMS_sub";
						$replace = array(
							"{{typeClass}}" => ($subPages) ? $sub : "CMS_nosub",
							"{{sublevel}}" 	=> ($recurse) ? $this->getRecursiveOutput($parsedPage, $level+1, $subPages, $pages, $public, $lineage) : "",
						);
						if (!$recurse) {
							//needed to update link targets which is used after to register watched links
							$it = new RecursiveArrayIterator($subPages);
							foreach ($it as $pageID => $element) {
								unset($pages[$pageID]);
							}
						}
						$pagehtml = str_replace(array_keys($replace), $replace, $pagehtml);
					}
					//add APPLICATION_ENFORCES_ACCESS_CONTROL php access checking
					if (APPLICATION_ENFORCES_ACCESS_CONTROL && $public && !(eregi("(page_previsualization.php|page_content.php)", $_SERVER["SCRIPT_NAME"]))) { //TODOV4
						//cause bug in recursion 
						$pagehtml = $this->_addSlashAroundPHPContent($pagehtml);
						$replace = array(
							"<?php" => "';",
							"?>" 	=> "echo '",
						);
						$pagehtml = str_replace(array_keys($replace), $replace, $pagehtml);
						$pagehtml =
						'<?php if ($cms_user->hasPageClearance('.$page->getID().', CLEARANCE_PAGE_VIEW)) {'."\n".
							'echo \''.$pagehtml.'\';'."\n".
						'}'."\n".
						'?>';
					}
					$rank++;
				} else {
					//needed to update link targets which is used after to register watched links
					unset($pages[$pageID]);
				}
				$levelhtml .= $pagehtml;
			}
			if (strpos($this->_subleveltemplate , "{{sublevel}}") !== false) {
				$replace = array(
					"{{sublevel}}" 	=> $levelhtml,
					"{{lvlClass}}" 	=> "CMS_lvl".($level+1),
				);
				$html = str_replace(array_keys($replace), $replace, $this->_subleveltemplate);
			} else {
				$html = $levelhtml;
			}
		}
		return $html;
	}
	
	/**
	  * add slash arround all php content founded in string.
	  * Static function
	  * @param $html string
	  * @return string evalued content
	  * @access private
	  */
	protected function _addSlashAroundPHPContent($html)
	{
		$strNewtxt_content = '' ;
		$split = explode('<?php', $html) ;
		$replace = array(
			'\"'	=> '"',
			'\\\"'	=> '"',
		);
		if(is_array($split)){
			foreach ($split as $str) {
				$arrS = explode("?>", $str) ;
				if (sizeof($arrS) == 2) {
					//php is in this data
					$strNewtxt_content .= '<?php '.$arrS[0].' ?>';
					$strNewtxt_content .= str_replace(array_keys($replace), $replace, addslashes($arrS[1]));
				} else {
					$strNewtxt_content .= str_replace(array_keys($replace), $replace, addslashes($str));
				}
			}
			$html = $strNewtxt_content;
		}
		return $html;
	}
	
	/**
	  * Test to see if a page passes all conditions
	  *
	  * @param CMS_page $page The parsed page : the one which contains the linx tag
	  * @param CMS_page $page The page to test
	  * @param boolean $publicTree Is the test conducted inside the public or edited tree ?
	  * @param integer $rank The rank of the page in the pre-condition targets
	  * @return boolean true if the page passes conditions, false otherwise
	  * @access public
	  */
	function pagePassesConditions(&$parsedPage, &$page, $public, $rank)
	{
		$passesConditions = true;
		foreach($this->_conditions as $aCondition) {
			if (!$passesConditions) {
				continue;
			}
			$passesConditions = ($aCondition->pagePasses($parsedPage, $page, $public, $rank)) ? $passesConditions:false;
		}
		return $passesConditions;
	}
	
	/**
	  * Does the display has a condition ?
	  *
	  * @return boolean true if yes, false if no
	  * @access public
	  */
	function hasCondition()
	{
		return $this->_conditions ? true : false;
	}
}
?>