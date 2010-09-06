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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: jsdialog.php,v 1.4 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_JSDialog
  *
  * Interface generation : all javascript codes
  * This class is deprecated since Automne V4, only here for compatibility with old modules.
  *
  * @package Automne
  * @subpackage dialogs
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_JSDialog extends CMS_grandFather
{
	const MESSAGE_CONFIRM_EXIT_WITHOUT_SAVING = 1324;
	/**
	  * Javascript text, will be outputed in the head
	  *
	  * @var string
	  * @access private
	  */
	protected $_javascript = '';

	/**
	  * Set dialog javascript
	  *
	  * @var string $javascript
	  * @return void
	  * @access public
	  */
	function setJavascript($javascript)
	{
		$this->_javascript .= $javascript;
	}

		/**
	  * add usefull javascript for verifying frame size
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	function addFrameCheck()
	{
		$frameCheck ='
			<!-- checkFrameSize to verify the width/height of all frames and launch reloading using frameChecker if necessary -->
			<script src="'.PATH_ADMIN_WR.'/v3/js/clientsnifferjr.js" type="text/javascript"></script>
			<script language="JavaScript" type="text/javascript">
				function checkFrameSize() {
					if (typeof parent.arbo == "object") {
						if (is.nav5up || is.ie) {
							if (is.nav5up) {
								hauteurArbo = parent.arbo.innerHeight;
								hauteurModules = parent.modules.innerHeight;
								largeur = parent.arbo.innerWidth;
							} else {
								hauteurArbo = parent.document.all.arbo.height;
								largeur = parent.document.all.arbo.width;
								hauteurModules = parent.document.all.modules.height;
							}
							if (largeur!=\''.$this->_context->getSessionVar('largeur').'\' || hauteurModules!=\''.$this->_context->getSessionVar('hauteurModules').'\') {
								if (is.nav5up) {
									cible = parent.frameChecker.document.saveFramesetSize;
								} else {
									cible = parent.frameChecker.document.saveFramesetSize;
								}
								cible.largeur.value=largeur;
								cible.hauteurModules.value=hauteurModules;
								cible.hauteurArbo.value=hauteurArbo;
								cible.submit();
							}
						}
					}
				}
			</script>';
		$this->setJavascript($frameCheck);
		return true;
	}

	/**
	  * add usefull javascript for page_summary
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	function addOnglet()
	{
		$onglet = '
			<!-- addOnglet add all javascript Tab functions -->
			<script language="Javascript">
			  <!--
			function Onglet(nom, tailleX, tailleY, tailleXOg, tailleYOg, initOg ){
					this.nom = nom;
					this.tailleX = tailleX;
					this.tailleY = tailleY;
					this.tailleXOg = tailleXOg;
					this.tailleYOg = tailleYOg;
					this.onglets = new Array();
					this.currentOnglet = null;
					this.currentSelOnglet = null;
					this.initOg = initOg;
					this.clsEna = "ongletTextEna";
					this.clsDis = "ongletTextDis";
					this.clsSp = "ongletSpace";
					this.clsMiddle = "ongletMiddle";
					this.clsMain = "ongletMain";
					this.colorOver = "#FF7D36";
					this.add = addOnglet;
					this.displayHeader = displayOngletHeader;
					this.displayFooter = displayOngletFooter;
					this.changeOnglet = changeOnglet;
					this.onOngletOver = onOngletOver;
					this.onOngletOut = onOngletOut;
			}

			function addOnglet( og ){
				this.onglets[this.onglets.length] = og;
			}

			function displayOngletHeader(){
				var html = "";
				html += "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				html += "<tr>";

				for( var i=0; i < this.onglets.length; i++ ){
				    html += "<td width=\"" + this.tailleXOg + "\" height=\"" + this.tailleYOg + "\" title=\"" + this.onglets[i].libOg + "\" id=\"ogO" + this.nom + i + "\" class=\"" + ((this.initOg == i)?this.clsEna:this.clsDis) + "\" onclick=\"" + this.nom + ".changeOnglet(this, \'og_" + this.nom + i + "\')\" onmouseover=\"" + this.nom + ".onOngletOver(this)\" onmouseout=\"" + this.nom + ".onOngletOut(this)\">" + this.onglets[i].titreOg + "</td>";
				    html += "<td class=\"" + this.clsSp + "\" width=\"5\"><img src=\"'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif\" border=\"0\" width=\"5\" height=\"1\" /></td>";
				}
				html += "<td class=\"" + this.clsSp + "\">&nbsp;</td></tr></table>";
				document.write(html)
			}

			function displayOngletFooter(){
				var html = "";
				document.getElementById("og_" + this.nom + this.initOg).style.display = "";
				this.currentOnglet = document.getElementById("og_" + this.nom + this.initOg);
				this.currentSelOnglet = document.getElementById("ogO" + this.nom + this.initOg);
				document.write(html);
			}

			function OngletItem(titreOg, libOg ){
				this.titreOg = titreOg;
				this.libOg = libOg;
			}

			function changeOnglet( srcOg, srcTab ){
				this.currentSelOnglet.className = this.clsDis;
				this.currentOnglet.style.display = "none";
				this.currentSelOnglet.style.color="";
				this.currentSelOnglet = srcOg;
				this.currentOnglet = document.getElementById(srcTab);
				this.currentSelOnglet.className = this.clsEna;
				this.currentOnglet.style.display = "";
			}

			function onOngletOver( srcOg ){
				if( srcOg != this.currentSelOnglet ){
					srcOg.style.cursor = "pointer";
					srcOg.style.color = this.colorOver;
				}else{
					srcOg.style.cursor=\'default\';
					srcOg.style.color = "";
				}
			}

			function onOngletOut( srcOg ){
				srcOg.style.color="";
			}

			function ongletstyle(){
			mystyle="<style>";
			mystyle +=".clsAction {FONT-WEIGHT: bold; FONT-SIZE: 10px; COLOR: #EBE6DE; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif}";
			mystyle +=".ongletTextEna {BORDER-RIGHT: medium none; BORDER-TOP: medium none; FONT-WEIGHT: bold; FONT-SIZE: 10px; BORDER-LEFT: medium none; COLOR: #FF7D36; BORDER-BOTTOM: #EEEBEA 1px solid; FONT-FAMILY: verdana; BACKGROUND-COLOR: #EEEBEA; TEXT-ALIGN: center; background-image : url('.PATH_ADMIN_IMAGES_WR.'/../v3/img/onglet_on.gif);}";
			mystyle +=".ongletTextDis {BORDER-RIGHT: medium none; BORDER-TOP: medium none; FONT-WEIGHT: normal; FONT-SIZE: 10px; BORDER-LEFT: medium none; COLOR: #BEB7B5; BORDER-BOTTOM: #BBB4B2 1px dashed; FONT-FAMILY: verdana; BACKGROUND-COLOR: #FFFFFF; TEXT-ALIGN: center; background-image : url('.PATH_ADMIN_IMAGES_WR.'/../v3/img/onglet_off.gif);}";
			mystyle +=".ongletSpace {BORDER-BOTTOM: #BBB4B2 1px dashed}";
			//mystyle +=".ongletMiddle {BORDER-RIGHT: #FF0000 1px solid; BORDER-TOP: medium none; FONT-SIZE: 1px; BORDER-LEFT: #80add6 2px solid; BORDER-BOTTOM: medium none; BACKGROUND-COLOR: #dce8f4}";
			mystyle +="</style>";
			document.write(mystyle);
			}
			  // -->
			</script>';
		$this->setJavascript($onglet);
		return true;
	}


	/**
	  * reload tree frame
	  *
	  * @return void
	  * @access private
	  */
	function reloadTree()
	{
		$reloadTree = '
			<!-- reloadTree reload the tree Frame -->
			<script language="Javascript">
				function reloadTree() {
					if (typeof parent.arbo == "object") {
						parent.arbo.location.replace(\'./tree.php?loadFromContext=1&'.session_name().'='.session_id().'\');
					}
				}
			</script>';
		$this->setJavascript($reloadTree);
		return true;
	}

	/**
	  * reload all frameset
	  * usually to remove a frame (ie modules or tree frame)
	  *
	  * @return void
	  * @access private
	  */
	function reloadAll()
	{
		$reloadAll = '
			<!-- reloadAll reload all Frames -->
			<script language="Javascript">
				function reloadAll() {
					parent.top.location.replace(\'./frames.php?'.session_name().'='.session_id().'\');
				}
			</script>';
		$this->setJavascript($reloadAll);
		return true;
	}

	/**
	  * reload modules frame
	  *
	  * @return void
	  * @access private
	  */
	function reloadModules()
	{
		$reloadModules = '
			<!-- reloadModules reload the modules Frame -->
			<script language="Javascript">
				function reloadModules() {
					parent.modules.location.replace(\'./modules.php?'.session_name().'='.session_id().'\');
				}
			</script>';
		$this->setJavascript($reloadModules);
		return true;
	}
	/**
	  * reload modules frame
	  *
	  * @return void
	  * @access private
	  */
	function changeColor()
	{
		$changeColor = '
			<!-- Switch color of an item -->
			<script language="Javascript">
				function changeColor(el,color) {
					if (color) {
						color = "#" + color;
					}
					if (el.setAttribute) {
						el.setAttribute(\'bgcolor\', color,0);
					} else {
						el.style.backgroundColor = color;
					}
				}
			</script>';
		if (isset($this) && is_a($this, 'CMS_dialog')) {
			$this->setJavascript($changeColor);
			return true;
		} else {
			return $changeColor;
		}
	}

	/**
	  * clearField : Emptying and filling search field
	  * checkField : Setting default value to search field
	  *
	  * @return void
	  * @access private
	  */
	function addSearchCheck()
	{
		$searchCheck = '
			<!-- searchCheck Emptying and filling search field, Setting default value to search field -->
			<script language="Javascript">
				function clearField(field) {
					if (field.value == field.defaultValue) {
						field.value = "";
					}
				}

				function checkField(field) {
					if (field.value == "") {
						field.value = field.defaultValue;
					}
				}
			</script>';
		$this->setJavascript($searchCheck);
		return true;
	}

	/**
	  * add javascript to view/hide the DHTMLMenu
	  *
	  * @return void
	  * @access private
	  */
	function addDHTMLMenu()
	{
		$DHTMLMenu = '
			<!-- showMenu needed to show the DHTML menu -->
			<script language="Javascript">
				var intDefaultTimeout = 500 ;
				var timer = 0 ;
				var button= false ;
				function swap(imgName, status){
					if (document.images){
						document[imgName].src = eval(imgName + "_" + status + \'.src\');
					}
				}
				if (document.images){
					var image_CMS_actionMenu_on = new Image();
					image_CMS_actionMenu_on.src = "'.PATH_ADMIN_IMAGES_WR.'/../v3/img/menu_on.gif";
					var image_CMS_actionMenu_off = new Image();
					image_CMS_actionMenu_off.src = "'.PATH_ADMIN_IMAGES_WR.'/../v3/img/menu_off.gif";
				}
				function killtimeout(){
				    clearTimeout(timer);
				}
				function showMenu(name) {
					if (button) {
						killtimeout();
						document.getElementById(name).style.visibility = "visible";
						swap("image_"+ name, "on");
					}
				}
				function hideMenu(name) {
					var Menu= \'hideM("\' + name + \'")\';
					timer = eval("setTimeout(\'" + Menu + "\', " + intDefaultTimeout + ");");
				}
				function hideM(name) {
					document.getElementById(name).style.visibility = "hidden";
					swap("image_"+ name, "off");
				}
			</script>';
		$this->setJavascript($DHTMLMenu);
		return true;
	}

	/**
	  * add javascript and CSS for calendar display
	  *
	  * @return void
	  * @access public
	  */
	function addCalendar()
	{
		$calendar = '
		<link rel="stylesheet" type="text/css" href="'.PATH_ADMIN_WR.'/v3/css/calendar.css" />
		<script src="'.PATH_ADMIN_WR.'/v3/js/calendar.js" type="text/javascript"></script>';
		$this->setJavascript($calendar);
		return true;
	}

	/**
	  * add javascript popup image
	  *
	  * @return void
	  * @access public
	  */
	function addPopupImage() {
		$popupimage = '
		<script type="text/javascript">
			function CMS_openPopUpImage(href)
			{
				if (href != "") {
					pagePopupWin = window.open(href+\'&popup=true\', "popup", "width=20,height=20,resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0");
				}
			}
		</script>';
		$this->setJavascript($popupimage);
		return true;
	}

	/**
	  * add javascript Ajax API
	  *
	  * @return void
	  * @access public
	  */
	function addAjaxAPI() {
		$ajaxAPI = '
			<link rel="stylesheet" href="'.PATH_ADMIN_WR.'/v3/css/editPage.css" media="screen" type="text/css" />
			<script type="text/javascript" src="/js/serverCall.php?'.session_name().'='.session_id().'"></script>';
		$this->setJavascript($ajaxAPI);
		return true;
	}

	/**
	  * add javascript stopTab function
	  *
	  * @return void
	  * @access public
	  */
	function addStopTab() {
		$stoptab = '
		<script type="text/javascript">
			function setSelectionRange(input, selectionStart, selectionEnd) {
			  if (input.setSelectionRange) {
			    input.focus();
			    input.setSelectionRange(selectionStart, selectionEnd);
			  }
			  else if (input.createTextRange) {
			    var range = input.createTextRange();
			    range.collapse(true);
			    range.moveEnd(\'character\', selectionEnd);
			    range.moveStart(\'character\', selectionStart);
			    range.select();
			  }
			}
			function replaceSelection (input, replaceString) {
				if (input.setSelectionRange) {
					var selectionStart = input.selectionStart;
					var selectionEnd = input.selectionEnd;
					input.value = input.value.substring(0, selectionStart)+ replaceString + input.value.substring(selectionEnd);
					if (selectionStart != selectionEnd){
						setSelectionRange(input, selectionStart, selectionStart + 	replaceString.length);
					}else{
						setSelectionRange(input, selectionStart + replaceString.length, selectionStart + replaceString.length);
					}
				}else if (document.selection) {
					var range = document.selection.createRange();
					if (range.parentElement() == input) {
						var isCollapsed = range.text == \'\';
						range.text = replaceString;
						 if (!isCollapsed)  {
							range.moveStart(\'character\', -replaceString.length);
							range.select();
						}
					}
				}
			}
			function catchTab(item,e){
				if(navigator.userAgent.match("Gecko")){
					c=e.which;
				}else{
					c=e.keyCode;
				}
				if(c==9){
					replaceSelection(item,String.fromCharCode(9));
					return false;
				}
			}
		</script>';
		$this->setJavascript($stoptab);
		return true;
	}

	/**
	  * add usefull javascript for disable submit button
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	function addJavascriptCheck($makeFocus=true)
	{
		$javascriptCheck ='
			<!-- javascriptCheck usefull initialisation javascript functions -->
			<script language="JavaScript" type="text/javascript">
				function initJavascript() {';
		if ($makeFocus) {
			$javascriptCheck .='
					makeFocus();';
		}
		$javascriptCheck .='
					if (typeof reloadAll == "function") {
						reloadAll();
					}
					if (typeof checkFrameSize == "function") {
						checkFrameSize();
					}
					if (typeof reloadTree == "function") {
						reloadTree();
					}
					if (typeof reloadModules == "function") {
						reloadModules();
					}
					if (typeof sortList == "function") {
						sortList();
					}
					if (typeof(parent.document) != \'undefined\'
						&& typeof(parent.document) != \'unknown\'
				        && typeof(parent.document.title) == \'string\') {
				        parent.document.title=document.title;
				    } else {
						window.status=document.title;
					}
				}';
		if ($makeFocus) {
			$javascriptCheck .='
				function makeFocus() {
					for (var j=\'0\'; j < document.forms.length; j++) {
						if (document.forms[j]!=null) {
							for (var i=\'0\'; i < document.forms[j].length; i++) {
								if (document.forms[j].elements[i] && document.forms[j].elements[i].type == "text" || document.forms[j].elements[i].type == "textarea") {
									if (document.forms[j].elements[i].value==\'\') {
										document.forms[j].elements[i].focus();
										return true;
									} else {
										document.forms[j].elements[i].select();
										return true;
									}
								}
							}
						} else {
							return false;
						}
					}
				}';
		}
		$javascriptCheck .='
				function check() {
					buttonDisable();
					window.setTimeout("buttonEnable()",45000);
				}
				function buttonDisable() {
					for (var j=\'0\'; j < document.forms.length; j++) {
						if (document.forms[j]!=null) {
							for (var i=\'0\'; i < document.forms[j].length; i++) {
								if (document.forms[j].elements[i].type == "submit" || document.forms[j].elements[i].type == "button" || document.forms[j].elements[i].type == "image") {
									document.forms[j].elements[i].style.backgroundColor = "D9D5D4";
									document.forms[j].elements[i].style.color = "6E5E59";
									document.forms[j].elements[i].disabled = true;
								}
							}
						}
					}
					return true;
				}
				function buttonEnable() {
					for (var j=\'0\'; j < document.forms.length; j++) {
						if (document.forms[j]!=null) {
							for (var i=\'0\'; i < document.forms[j].length; i++) {
								if (document.forms[j].elements[i].type == "submit" || document.forms[j].elements[i].type == "button") {
									document.forms[j].elements[i].disabled = false;
									document.forms[j].elements[i].style.backgroundColor = "ABD64A";
									document.forms[j].elements[i].style.color = "FFFFFF";
								}
							}
						}
					}
					return true;
				}
				if (parent && parent.Automne && parent.Ext) {
					var Automne = parent.Automne;
					var Ext = parent.Ext;
					var pr = parent.pr;
				}
			</script>';
		if (isset($this) && is_a($this, 'CMS_dialog')) {
			$this->changeColor();
			$this->setJavascript($javascriptCheck);
			return true;
		} else {
			return $javascriptCheck.CMS_dialog::changeColor();
		}
	}

	/**
	  * This function launch the scripts queue process in popup mode if it is needed
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	function launchScriptPopup() {
		//check for anti popup system.
		/*if (!$_SESSION["cms_context"]->getSessionVar('scriptpopup_is_open')) {
			$_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',$_SESSION["cms_context"]->getSessionVar('scriptpopup_opening_try')+1);
		}
		if ($_SESSION["cms_context"]->getSessionVar('scriptpopup_opening_try')>1) {
			define("MESSAGE_PAGE_REMOVE_ANTI_POPUP", 1182);
			$user = $this->_context->getUser();
			$language = $user->getLanguage();
			$this->_actionMessage .= "\n".$language->getMessage(MESSAGE_PAGE_REMOVE_ANTI_POPUP);
			$_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',0);
		}
		//launch popup
		$searchCheck = '
			<!-- launch regenerator popup -->
			<script language="Javascript">
				// Change popup window format here
				var name = "popRegenerator";// Name
				var w = 280;				// Width
				var h = 120;				// Height
				var r = "no";				// Resize ?
				var s = "no";				// Scrolling ?
				var m = "no";				// Menubar ?
				var left = 40;				// Left position
				var top = 40;				// Top position
				// Opens
				scriptsPopup = window.open(\''.PATH_ADMIN_WR.'/scriptspopup.php?'.session_name().'='.session_id().'\', name, \'width=\' + w + \',height=\' + h + \',resizable=\' + r +\',scrollbars=\'+ s + \',menubar=\' + m + \',left=\' + left + \',top=\' + top);
			</script>';
		$this->setJavascript($searchCheck);*/
		return true;
	}

	/**
	  * This function add method to swith between the row/block display in page edition
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	function switchRows() {
		$switchRows =
		'<script type="text/javascript">
			var viewWhat = "'.$_SESSION["cms_context"]->getSessionVar('viewWhat').'";
			function switchView() {
				var rowElements = new Array(';
				$count=0;
				foreach ($_SESSION["cms_context"]->getSessionVar('switchRow') as $aRowID) {
					if ($count) $switchRows .= ',';
					$count++;
					$switchRows .= '"'.$aRowID.'"';
				}
			$switchRows .= ');
				var blockElements = new Array(';
				$count=0;
				foreach ($_SESSION["cms_context"]->getSessionVar('switchBlock') as $aBlockID) {
					if ($count) $switchRows .= ',';
					$count++;
					$switchRows .= '"'.$aBlockID.'"';
				}
			$switchRows .= ');
				if (viewWhat=="block") {
					for (var i=0; i<rowElements.length; i++) {
						if (document.getElementById(rowElements[i])) {
							document.getElementById(rowElements[i]).className = "showit";
						}
					}
					for (var i=0; i<blockElements.length; i++) {
						if (document.getElementById(blockElements[i])) {
							document.getElementById(blockElements[i]).className = "hideit";
						}
					}
					viewWhat = "row";
				} else {
					for (var i=0; i<rowElements.length; i++) {
						if (document.getElementById(rowElements[i])) {
							document.getElementById(rowElements[i]).className = "hideit";
						}
					}
					for (var i=0; i<blockElements.length; i++) {
						if (document.getElementById(blockElements[i])) {
							document.getElementById(blockElements[i]).className = "showit";
						}
					}
					viewWhat = "block";
				}
				return true;
			}
			if (viewWhat=="row") {
				viewWhat = "block";
				//on windows load switch row/block view
				CMS_addEvent(window, \'load\', function() {switchView();});
			}
		</script>';
		if (isset($this) && is_a($this, 'CMS_dialog')) {
			$this->setJavascript($switchRows);
			return true;
		} else {
			return $switchRows;
		}
	}

	/**
	  * This function block all links and forms useage in page edition mode to avoid left the edition mode without saving it
	  *
	  * @param integer pageID : the current edited page ID (to unlock it if page is leaved anyway)
	  * @return string : the javascript to add
	  * @access private
	  */
	function linksBlocker($pageID) {
		global $cms_language;
		$linksBlocker =
		'<script type="text/javascript">
			function linksBlocker() {
				var links = document.getElementsByTagName(\'A\');
				for (var i=0; i < links.length; i++) {
					var link = links[i];
					if (link.target != "_blank") {
						CMS_addEvent(link, \'click\', stopLink);
					}
				}
				var forms = document.getElementsByTagName(\'FORM\');
				for (var i=0; i < forms.length; i++) {
					var form = forms[i];
					if (form.target != "_blank" && form.action.indexOf("automne/admin") == -1 && form.action.indexOf("http://") != -1) {
						CMS_addEvent(form, \'submit\', stopLink);
					}
				}
				return true;
			}
			function stopLink (e) {
				if (!confirm("'.$cms_language->getMessage(self::MESSAGE_CONFIRM_EXIT_WITHOUT_SAVING).'")) {
					var event = e || window.event;
					CMS_cancelEvent(event);
				} else {
					//send a call to server to unlock the page
					sendServerCall("'.PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR.'?cms_action=pageUnlock&page='.$pageID.'", null, true);
				}
			}
			//on windows load launch linksBlocker
			CMS_addEvent(window, \'load\', function() {linksBlocker();});
		</script>';

		if (isset($this) && is_a($this, 'CMS_dialog')) {
			$this->setJavascript($linksBlocker);
			return true;
		} else {
			return $linksBlocker;
		}
	}
}
?>