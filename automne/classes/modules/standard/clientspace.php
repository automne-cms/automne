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
// $Id: clientspace.php,v 1.3 2010/03/08 16:43:29 sebastien Exp $

/**
  * Class CMS_moduleClientspace_standard
  *
  * represent a standard client space which are data containers.
  *
  * @package CMS
  * @subpackage module
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_moduleClientspace_standard extends CMS_moduleClientspace
{
	/**
	  * template DB id
	  * @var integer
	  * @access private
	  */
	protected $_templateID;

	/**
	  * ID attribute of the client space tag
	  * @var string
	  * @access private
	  */
	protected $_tagID;

	/**
	  * The rows contained in the client space as XML tags
	  * @var array(CMS_row)
	  * @access private
	  */
	protected $_rows = array();

	/**
	  * Is the client space created in edition mode (data reside in the _edition table)
	  * @var boolean
	  * @access private
	  */
	protected $_editionMode = false;
	
	/**
	  * Constructor.
	  * initializes the rows.
	  *
	  * @param integer $templateID the DB ID of the template
	  * @param integer $tagID the tag ID of the client space tag
	  * @param boolean $editionMode true if we are in edition mode (data should be fetched from _edition table)
	  * @param integer $location The location we want to get the block from
	  * @param boolean $public The needed precision for USERSPACE location
	  * @return void
	  * @access public
	  */
	function __construct($templateID, $tagID, $editionMode = false, $location=RESOURCE_LOCATION_USERSPACE, $public=false)
	{
		$this->_editionMode = $editionMode;
		if ($this->_editionMode) {
			$location = RESOURCE_LOCATION_EDITION;
			$public = false;
		}
		$this->_templateID = $templateID;
		$this->_tagID = $tagID;
		if ($templateID && $tagID) {
			$this->_checkRows($location, $public);
		}
	}
	
	/**
	  * Gets the table name which depends of the page location
	  *
	  * @param integer $location The location we want tag definition from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return string The table name
	  * @access public
	  */
	protected function _getDataTableName($location, $public)
	{
		$prefix = "mod_standard_clientSpaces";
		switch ($location) {
		case RESOURCE_LOCATION_USERSPACE:
			$table = ($public) ? $prefix."_public" : $prefix."_edited";
			break;
		case RESOURCE_LOCATION_ARCHIVED:
			$table = $prefix."_archived";
			break;
		case RESOURCE_LOCATION_DELETED:
			$table = $prefix."_deleted";
			break;
		case RESOURCE_LOCATION_EDITION:
			$table = $prefix."_edition";
			break;
		}
		return $table;
	}
	
	/**
	  * Initialize rows depending on location user space
	  *
	  * @param integer $location The location we want tag definition from
	  * @param boolean $public The precision needed for USERSPACE location
	  * @return string The table name
	  * @access public
	  */
	protected function _checkRows($location=RESOURCE_LOCATION_USERSPACE, $public=false)
	{
		if ($this->_templateID && $this->_tagID) {
			if (!SensitiveIO::isPositiveInteger($this->_templateID)) {
				$this->raiseError("id is not a positive integer");
				return;
			}
			$this->_rows = array();
			$table = $this->_getDataTableName($location, $public);
			$sql = "
				select
					*
				from
					".$table."
				where
					template_cs='".SensitiveIO::sanitizeSQLString($this->_templateID)."'
					and tagID_cs='".SensitiveIO::sanitizeSQLString($this->_tagID)."'
					and type_cs != 0
				order by 
					order_cs asc
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				while ($data = $q->getArray()) {
					$this->_rows[$data['order_cs']] = new CMS_row($data["type_cs"], $data["rowsDefinition_cs"]);
				}
			}
		}
	}
	
	/**
	  * Gets the template DB ID.
	  *
	  * @return integer the template DB id
	  * @access public
	  */
	function getTemplateID()
	{
		return $this->_templateID;
	}
	
	/**
	  * Gets the tag ID.
	  *
	  * @return integer the tag ID attribute
	  * @access public
	  */
	function getTagID()
	{
		return $this->_tagID;
	}
	
	/**
	  * Gets the rows field
	  *
	  * @return array(CMS_rows) the rows
	  * @access public
	  */
	function getRows()
	{
		return $this->_rows;
	}
	
	/**
	  * Gets a row in CS
	  *
	  * @return CMS_rows the queried row
	  * @access public
	  */
	function getRow($rowID, $rowTagID)
	{
		foreach ($this->_rows as $row) {
			if ($row->getID() == $rowID && $row->getTagID() == $rowTagID) {
				return $row;
			}
		}
		return false;
	}
	
	
	/**
	  * Gets the data from the rows, using the specified visualization mode.
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page the page parsed
	  * @param integer $visualizationMode the visualization mode
      * @param boolean $templateHasPages don't display forms if set to true
	  * @return string the data from the rows.
	  * @access public
	  */
	function getData(&$language, &$page, $visualizationMode, $templateHasPages=false)
	{
		global $cms_user;
		// Prepare content
		$content = $this->getRawData($language, $page, $visualizationMode, $templateHasPages);
		// Add form visualizations
		if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM || $visualizationMode == PAGE_VISUALMODE_FORM) {
			//add row specification
			$data = '
			<script type="text/javascript">
				atmCSDatas[\''.$this->getTagID().'\'] = {
					id:					\''.$this->getTagID().'\',
					template:			\''.$this->getTemplateID().'\',
					page:				\''.$page->getID().'\',
					visualMode:			\''.$visualizationMode.'\',
					document:			document
				};
			</script>
			'.$content.'
			<div id="atm-cs-'.$this->getTagID().'" class="atm-empty-cs"></div>';
		} else {
			$data = $content;
		}
		$data = '<?php /* Start clientspace ['.$this->getTagID().'] */?>'.$data.'<?php /* End clientspace ['.$this->getTagID().'] */?>';
		return $data;
	}
	
	/**
	  * Gets the data from all rows after initialized 
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page the page parsed
	  * @param integer $visualizationMode the visualization mode
      * @param boolean $templateHasPages don't display forms if set to true
	  * @return string, The data returned by all rows as a string
	  * @access public
	  */
	function getRawData(&$language, &$page, $visualizationMode, $templateHasPages=false)
	{
		$rowCanBeEdited = false ;
		switch ($visualizationMode) {
		case PAGE_VISUALMODE_HTML_PUBLIC:
		case PAGE_VISUALMODE_PRINT:
			$this->_checkRows(RESOURCE_LOCATION_USERSPACE, true);
			break;
		case PAGE_VISUALMODE_HTML_EDITED:
			// No use, done yet in constructor.
			//$this->_checkRows(RESOURCE_LOCATION_USERSPACE, false);
			break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$rowCanBeEdited = true ;
			$this->_checkRows(RESOURCE_LOCATION_USERSPACE, false);
			break;
		case PAGE_VISUALMODE_HTML_EDITION:
		case PAGE_VISUALMODE_FORM:
			$rowCanBeEdited = true ;
			$this->_checkRows(RESOURCE_LOCATION_EDITION, false);
			break;
		}
		// Prepare content
		$content = '';
		foreach ($this->_rows as $row) {
        	$content .= $row->getData($language, $page, $this, $visualizationMode, $templateHasPages, $rowCanBeEdited);
		}
		return $content;
	}
	
	/**
	  * Add a row to the client space.
	  *
	  * @param integer $rowID the DB ID of the row to add
	  * @param integer $rowTagID the ID attribute of the row tag to add
	  * @param integer $index the index position of the row in the CS
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function addRow($rowID, $rowTagID, $index) {
		//check that another row with same tag ID doesn't exists
		foreach ($this->_rows as $row) {
			if ($row->getTagID() == $rowTagID) {
				return false;
			}
		}
		//row index cannot be more than current rows length
		$sizeofRows = sizeof($this->_rows);
		if ($index > $sizeofRows) {
			$index = $sizeofRows;
		}
		$row = CMS_rowsCatalog::getByID($rowID, $rowTagID);
		if (is_a($row, "CMS_row")) {
			//put row at given index
			$rows = array_slice($this->_rows, 0, $index);
			$after = array_slice($this->_rows, $index);
			$rows[] = $row;
			$this->_rows = array_merge($rows, $after);
			return $row;
		} else {
			$this->raiseError("Row addition was not given a valid rowID");
			return false;
		}
	}
	
	/**
	  * Deletes a row.
	  *
	  * @param integer $rowID the DB ID of the row to remove from the stack
	  * @param integer $rowTagID the ID attribute of the row tag to del
	  * @return boolean
	  * @access public
	  */
	function delRow($rowID, $rowTagID)
	{
		$rows = array();
		foreach ($this->_rows as $row) {
			if ($row->getID() != $rowID || $row->getTagID() != $rowTagID) {
				$rows[] = $row;
			}
		}
		$this->_rows = $rows;
		return true;
	}
	
	/**
	  * Move a row to a given index in clientspace
	  *
	  * @param integer $rowID the ID of the row to move
	  * @param integer $rowTagID the ID attribute of the row tag to move
	  * @param integer $index the index to put row at
	  * @return boolean true if the move is successful, false otherwise
	  * @access public
	  */
	function moveRow($rowID, $rowTagID, $index)
	{
		//find row current index and remove it from rows
		$row = false;
		$oldIndex = false;
		$sizeofRows = sizeof($this->_rows);
		//row index cannot be more than current rows length
		if ($index > $sizeofRows - 1) {
			$index = $sizeofRows - 1;
		}
		for ($i=0 ; $i < $sizeofRows ; $i++) {
			if ($this->_rows[$i]->getID() == $rowID && $this->_rows[$i]->getTagID() == $rowTagID) {
				$row = $this->_rows[$i];
				$oldIndex = $i;
				//if row is already at queried index, return
				if($oldIndex == $index) {
					return true;
				}
				unset($this->_rows[$i]);
				break;
			}
		}
		if (!$row) {
			return false;
		}
		//put row at given index
		$rows = array_slice($this->_rows, 0, $index);
		$after = array_slice($this->_rows, $index);
		$rows[] = $row;
		$this->_rows = array_merge($rows, $after);
		return true;
	}
	
	/**
	  * Totally destroys the clientSpace from persistence, but not its rows.
	  *
	  * @return void
	  * @access public
	  */
	function destroy()
	{
	}
	
	/**
	  * Writes the clientSpace into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if ($this->_templateID && $this->_tagID) {
			$table = "mod_standard_clientSpaces";
			$table .= ($this->_editionMode) ? "_edition" : "_edited";
			
			//delete from table
			$sql = "
				delete from
					".$table."
				where
					template_cs='".$this->_templateID."'
					and tagID_cs='".SensitiveIO::sanitizeSQLString($this->_tagID)."'
			";
			$q = new CMS_query($sql);
			//insert new rows datas if any
			if (is_array($this->_rows) && $this->_rows) {
				$sql = "insert into
							".$table."
							(`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) 
						VALUES ";
				$count = 0;
				foreach ($this->_rows as $order => $row) {
					if (SensitiveIO::isPositiveInteger($row->getID())) {
						$sql .= ($count) ? ',':'';
						$sql .= "('".$this->_templateID."', '".SensitiveIO::sanitizeSQLString($this->_tagID)."', '".SensitiveIO::sanitizeSQLString($row->getTagID())."', '".$row->getID()."', '".$order."')";
						$count++;
					}
				}
				$q = new CMS_query($sql);
				if ($q->hasError()) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
}
?>