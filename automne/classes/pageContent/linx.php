<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
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
// $Id: linx.php,v 1.12 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_linx
  *
  * Manages a linx representation
  *
  * @package Automne
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_linx extends CMS_grandFather
{
	/**
	  * The parsed page
	  * @var integer
	  * @access private
	  */
	protected $_page;

	/**
	  * Do we resolve the linx in public or private tree ?
	  * @var boolean
	  * @access private
	  */
	protected $_publicTree;

	/**
	  * The linx type
	  * @var string
	  * @access private
	  */
	protected $_type;

	/**
	  * The selection condition
	  * @var CMS_linxCondition
	  * @access private
	  */
	protected $_selectionCondition = false;

	/**
	  * The selection start page(s) tags
	  * @var array(CMS_linxNodespec)
	  * @access private
	  */
	protected $_selectionStartPages = array();

	/**
	  * The selection stop page tag (if any)
	  * @var CMS_linxNodespec
	  * @access private
	  */
	protected $_selectionStopPage = false;

	/**
	  * The display object instances
	  * @var array(CMS_linxDisplay)
	  * @access private
	  */
	protected $_displays = array();

	/**
	  * The computed targets, filtered by the selection condition
	  * @var array(CMS_page)
	  * @access private
	  */
	protected $_targets = array();

	/**
	  * Father watches : pages that this page watch for siblings change (only the IDs are here)
	  * @var array(integer)
	  * @access private
	  */
	protected $_fatherWatches = array();
	
	/**
	  * Array of objects for the recursivelinks
	  * @var multidimentionnal array(CMS_page id => array(subpages))
	  * @access private
	  */
	protected $_recursiveTargets = array();

	/**
	  * Display linx error ?
	  * @var boolean true to hide all errors or false (default)
	  * @access private
	  */
	protected $_noerror = false;
	
	/**
	  * Content displayed if sibling page(s) does not exists
	  * @var CMS_tag
	  * @access private
	  */
	protected $_noselection;
	
	/**
	  * Does this links display pages accross websites ?
	  * @var boolean (default : false)
	  * @access private
	  */
	protected $_crosswebsite = false;
	
	/**
	  * Optionnal linx args (such as id or class) to append to generated code
	  * @var boolean (default : false)
	  * @access private
	  */
	protected $_args = array();
	
	/**
	  * Constructor.
	  * initializes the linx.
	  *
	  * @param string $type The linx type
	  * @param string $tagContent The tag content.
	  * @param CMS_page $page The page we're parsing
	  * @param boolean $publicTree Does the linx must be calculated in the public or edited tree ?
	  * @return void
	  * @access public
	  */
	public function __construct($type, $tagContent, $page, $publicTree = false, $args = array())
	{
		if (!SensitiveIO::isInSet($type, CMS_linxesCatalog::getAllTypes())) {
			$this->setError("Constructor has an unknown type : ".$type);
			return;
		} elseif (!is_a($page, "CMS_page")) {
			$this->setError("Constructor was not given a valid CMS_page");
			return;
		} else {
			$this->_args = $args;
			$this->_type = $type;
			
			//Hack for shorthand writing of atm-linx
			//<atm-linx type="direct" node="pageID"> ... </atm-linx>
			//<atm-linx type="direct" codename="pageCodename"> ... </atm-linx>
			if ((isset($this->_args['node']) || isset($this->_args['codename'])) && $this->_type == 'direct') {
				$tag = new CMS_XMLTag('atm-linx', $this->_args);
				$tag->setTextContent($tagContent);
				
				$tagContent = 
				'<atm-linx type="direct">'.
					'<selection '.(isset($this->_args['crosswebsite']) ? ' crosswebsite="'.$this->_args['crosswebsite'].'"' : '').'>';
				if (isset($this->_args['node'])) {
					$tagContent .= '<start><nodespec type="node" value="'.$this->_args['node'].'" /></start>';
					//remove useless node argument
					unset($this->_args['node']);
				} else {
					$tagContent .= '<start><nodespec type="codename" value="'.$this->_args['codename'].'" /></start>';
					//remove useless node argument
					unset($this->_args['codename']);
				}
				$tagContent .= 
					'</selection>'.
					'<display>'.
						'<htmltemplate>'.$tag->getInnerContent().'</htmltemplate>'.
					'</display>'.
				'</atm-linx>';
			}
			
			$this->_page = $page;
			$this->_publicTree = $publicTree;
			$domdocument = new CMS_DOMDocument();
			try {
				$domdocument->loadXML($tagContent);
			} catch (DOMException $e) {
				$this->setError('Malformed atm-linx content in page '.$page->getID().' : '.$e->getMessage()."\n".$tagContent, true);
				return false;
			}
			$selections = $domdocument->getElementsByTagName('selection');
			if ($selections->length > 0) {
				$selection = $selections->item(0);
				//parse the selection for nodespecs and condition
				if (!$this->_parseSelection($selection)) {
					$this->setError();
					return;
				}
			}
			$noselections = $domdocument->getElementsByTagName('noselection');
			if ($noselections->length > 0) {
				$this->_noselection = $noselections->item(0);
			}
			$displays = $domdocument->getElementsByTagName('display');
			
			//get the displays objects
			$unsortedDisplays = array();
			foreach ($displays as $display) {
				$unsortedDisplays[] = new CMS_linxDisplay($display);
			}
			//put the default display (the one with no condition) at the end of the array
			$default = false;
			foreach ($unsortedDisplays as $dsp) {
				if ($dsp->hasCondition() && !$default) {
					$this->_displays[] = $dsp;
				} else {
					$default = $dsp;
				}
			}
			if ($default) {
				$this->_displays[] = $default;
			}
		}
	}

	/**
	  * Get the HTML output
	  *
	  * @return string The HTML
	  * @access public
	  */
	public function getOutput($register = false)
	{
		if ($this->hasError()) {
			return '';
		}
		//computes the targets (from selection)
		$this->_targets = $this->_buildTargets();
		//set output
		$output = '';
		if ($this->_type == 'recursivelinks') {
			$root = CMS_tree::getRoot();
			$lineage = CMS_tree::getLineage($root->getID(), $this->_page->getID(), false, $this->_publicTree);
			if (is_array($this->_displays)) {
				foreach ($this->_displays as $display) {
					$html = $display->getRecursiveOutput($this->_page, 0, $this->_recursiveTargets, $this->_targets, $this->_publicTree, $lineage);
					if ($html) {
						$output .= $html;
						break;
					}
				}
			}
		} else {
			if (is_array($this->_displays)) {
				foreach ($this->_displays as $display) {
					$displayOutput = '';
					if (is_array($this->_targets) && $this->_targets) {
						$sizeofTargets = sizeof($this->_targets);
						for ($i = 0 ; $i < $sizeofTargets ; $i++) {
							$target = $this->_targets[$i];
							$displayOutput .= $display->getOutput($this->_page, $target, $this->_publicTree, $i + 1, $this->_noerror, $this->_noselection);
						}
						$output .= $display->getSubLevelOutput($displayOutput);
					} elseif(is_object($this->_noselection)) {
						$output .= CMS_DOMDocument::DOMElementToString($this->_noselection, true);
					}
				}
			}
		}
		if ($register) {
			$this->_register();
		}
		//append args to generated linx code
		if ($this->_args) {
			//append atm-row class and row-id to all first level tags found in row datas
			$domdocument = new CMS_DOMDocument();
			try {
				$domdocument->loadXML('<linx>'.$output.'</linx>');
			} catch (DOMException $e) {
				$this->setError('Parse error for linx : '.$e->getMessage()." :\n".io::htmlspecialchars($output));
				return '';
			}
			$rowNodes = $domdocument->getElementsByTagName('linx');
			if ($rowNodes->length == 1) {
				$rowXML = $rowNodes->item(0);
			}
			$elements = array();
			if (isset($rowXML)) {
				foreach($rowXML->childNodes as $rowChildNode) {
					if (is_a($rowChildNode, 'DOMElement') && $rowChildNode->tagName != 'script') {
						if ($this->_args['class'] !== false) {
							if ($rowChildNode->hasAttribute('class')) {
								$rowChildNode->setAttribute('class', $rowChildNode->getAttribute('class').' '.$this->_args['class']);
							} else {
								$rowChildNode->setAttribute('class', $this->_args['class']);
							}
						}
						if ($this->_args['id'] !== false) {
							$rowChildNode->setAttribute('id', $this->_args['id']);
						}
					}
				}
				$output = CMS_DOMDocument::DOMElementToString($rowXML, true);
			} else {
				$output = '';
			}
		}
		return $output;
	}

	/**
	  * Register the linx in the surveillance tables
	  *
	  * @return string The HTML
	  * @access private
	  */
	protected function _register()
	{
		//register "real" links
		if (is_array($this->_targets) && $this->_targets) {
			$sql = '';
			foreach ($this->_targets as $target) {
				$sql .= ($sql) ? ', ':'';
				$sql .= "('".$this->_page->getID()."' ,'".((is_object($target)) ? $target->getID() : $target)."') ";
			}
			$sql = "
				replace into
					linx_real_public (start_lre, stop_lre)
				values 
					".$sql;
			$q = new CMS_query($sql);
		}
		//register father watch links, from the special array
		if (is_array($this->_fatherWatches) && $this->_fatherWatches) {
			$sql = '';
			foreach ($this->_fatherWatches as $fwID) {
				$sql .= ($sql) ? ', ':'';
				$sql .= "('".$this->_page->getID()."' ,'".$fwID."') ";
			}
			$sql = "
				replace into
					linx_watch_public (page_lwa, target_lwa)
				values 
					".$sql;
			$q = new CMS_query($sql);
		}
	}

	/**
	  * Parse a "selection" XML tag searching for start and stop nodespecs
	  * This will fill the _selectionStartPageTags and _selectionStopPageTag attributes
	  *
	  * @param CMS_XMLTag $selectionTag The selection tag to parse
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _parseSelection($selectionTag)
	{
		if (is_a($selectionTag, "DOMElement")) {
			//set error level on selection attribute
			if ($selectionTag->hasAttribute('noerror') && ($selectionTag->getAttribute('noerror') == 'true' || $selectionTag->getAttribute('noerror') == '1')) {
				$this->_noerror = true;
			}
			//set cross website status on selection attribute
			if ($selectionTag->hasAttribute('crosswebsite') && $selectionTag->getAttribute('crosswebsite') == 'true' || $selectionTag->getAttribute('crosswebsite') == '1') {
				$this->_crosswebsite = true;
			}
			$starts = $selectionTag->getElementsByTagName('start');
			$stops = $selectionTag->getElementsByTagName('stop');
			$conditions = $selectionTag->getElementsByTagName('condition');
			if ($conditions->length > 0) {
				$this->_selectionCondition = CMS_linxCondition::createCondition($conditions->item(0));
			}
			//parse the start tag(s)
			foreach ($starts as $start) {
				$nodespecs = $start->getElementsByTagName('nodespec');
				if ($nodespecs->length > 0) {
					$nodespec = $nodespecs->item(0);
					$nodespec = CMS_linxNodespec::createNodespec($nodespec, $this->_crosswebsite);
				}
				$pages = $nodespec->getTarget($this->_page, $this->_publicTree);
				if ($pages) {
					if (!is_array($pages)) {
						$pages = array($pages);
					}
					foreach ($pages as $pg) {
						$this->_selectionStartPages[] = $pg;
						//if nodespec type is relative and relative type is father OR the linx type is sublinks,
						//store the representation ID in the _fatherWatch array
						if ($nodespec->getRelativeType() == "brother" || $this->_type == "sublinks" || $this->_type == "recursivelinks") {
							$this->_fatherWatches[] = $pg->getID();
						}
					}
				}
			}
			if ($stops->length > 0) {
				$stop = $stops->item(0);
				$nodespecs = $stop->getElementsByTagName('nodespec');
				if ($nodespecs->length > 0) {
					$nodespec = $nodespecs->item(0);
					$nodespec = CMS_linxNodespec::createNodespec($nodespec);
					$pg = $nodespec->getTarget($this->_page, $this->_publicTree);
					if ($pg) {
						$this->_selectionStopPage = $pg;
					}
				}
			}
		} else {
			$this->setError('SelectionTag is not a DOMElement instance');
			return false;
		}
		return true;
	}

	/**
	  * Build the targets from the selection start and stop nodes
	  * Uses the websites catalog to exclude (for desclinks and sublinks) pages that are not part of the current website
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _buildTargets()
	{
		if (!$this->_selectionStartPages || !$this->_selectionStartPages) {
			return false;
		}
		
		$targets = array();
		switch ($this->_type) {
		case "direct":
			$targets = $this->_selectionStartPages;
			//apply the selection to the builded targets
			$targets = $this->_selectTargets($targets);
			break;
		case "desclinks":
			if (!$this->_selectionStopPage) {
				//$this->setError("No stop page found for desclinks");
				return false;
			}
			foreach ($this->_selectionStartPages as $start) {
				$targets_temp = CMS_tree::getLineage($start, $this->_selectionStopPage, true, $this->_publicTree);
				if ($targets_temp && is_array($targets_temp)) {
					$targets_temp = array_reverse($targets_temp);
					$root_found = false;
					foreach ($targets_temp as $aTarget) {
						if (CMS_websitesCatalog::isWebsiteRoot($aTarget->getID())) {
							if ($root_found) {
								break;
							} else {
								$root_found = true;
							}
						}
						$targets[] = $aTarget;
					}
					$targets = array_reverse($targets);
				}
			}
			//apply the selection to the builded targets
			$targets = $this->_selectTargets($targets);
			break;
		case "sublinks":
			foreach ($this->_selectionStartPages as $start) {
				$targets_temp = CMS_tree::getSiblings($start, $this->_publicTree);
				if ($targets_temp && is_array($targets_temp)) {
					foreach ($targets_temp as $aTarget) {
						if ($this->_crosswebsite || !CMS_websitesCatalog::isWebsiteRoot($aTarget->getID())) {
							$targets[] = $aTarget;
						}
					}
				}
			}
			//apply the selection to the builded targets
			$targets = $this->_selectTargets($targets);
			break;
		case "recursivelinks":
			//construct targets and recursive targets then apply the selection to the builded targets
			foreach ($this->_selectionStartPages as $start) {
				$targets[$start->getID()] = $start;
				$returnedDatas = $this->_buildRecursiveTargets($start->getID());
				$targets = $targets + $returnedDatas["targets"];
				$this->_recursiveTargets[$start->getID()] = $returnedDatas["recursiveTree"];
				//add this page to father watches
				$this->_fatherWatches[] = $this->_page->getID();
			}
			break;
		}
		return $targets;
	}
	
	/**
	  * Recursive function to Build the targets tree (recursivelinks) 
	  * then apply the selection to the builded targets
	  * Uses the websites catalog to exclude (for desclinks and sublinks) pages that are not part of the current website
	  *
	  * @return multidimensionnal array : array("recursiveTree" => tree of page id, "targets" => cms_page objects);
	  * @access private
	  */
	protected function _buildRecursiveTargets($pageID, $level=0)
	{
		$targets=array();
		$recursiveTargets = array();
		$targets_temp = CMS_tree::getSiblings($pageID, $this->_publicTree, false);
		if ($targets_temp && is_array($targets_temp)) {
			foreach ($targets_temp as $aTarget_temp) {
				if ($this->_crosswebsite || !CMS_websitesCatalog::isWebsiteRoot($aTarget_temp)) {
					//construct targets array
					$targets[$aTarget_temp] = $aTarget_temp;
					if ($this->_selectionCondition === false || $this->_selectionCondition->levelPasses($level+1)) {
						//construct recursive targets array and array of cms_pages objects
						$returnedDatas = $this->_buildRecursiveTargets($aTarget_temp, $level+1);
						$targets = $targets + $returnedDatas["targets"];
						//add this page to father watches
						if (sizeof($returnedDatas["targets"])) {
							$this->_fatherWatches[] = $aTarget_temp;
						}
						$recursiveTargets[$aTarget_temp] = $returnedDatas["recursiveTree"];
					}
				}
			}
		}
		return array("recursiveTree" => $recursiveTargets, "targets" => $targets);
	}

	/**
	  * Selects the targets : apply the selection to the builded targets
	  *
	  * @param array(CMS_page) $targets The build targets of which we want the selection
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _selectTargets($targets)
	{
		$public_targets = array();
		if (is_array($targets)) {
			foreach ($targets as $target) {
				
				if ((!$this->_publicTree /*&& $target->getPublication() != RESOURCE_PUBLICATION_VALIDATED*/) || ($this->_publicTree && $target->isUseable() && $target->getPublication() == RESOURCE_PUBLICATION_PUBLIC)) {
					$public_targets[] = $target;
				}
			}
		}
		$targets = $public_targets;
		if (!$targets || !$this->_selectionCondition) {
			return $targets;
		}
		$selected_targets = array();
		$sizeofTargets = sizeof($targets);
		for ($i = 0 ; $i < $sizeofTargets ; $i++) {
			$current_target = $targets[$i];
			$pass = $this->_selectionCondition->pagePasses($this->_page, $current_target, $this->_publicTree, $i + 1);
			if ($pass) {
				$selected_targets[] = $current_target;
			}
		}
		return $selected_targets;
	}
}
?>