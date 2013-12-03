<?php
/**
	* PHP page : polymod oembed definition
	*
	*/

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

//load page objects and vars
$moduleCodename = io::request("moduleCodename");
$objectDefitionId = io::request("object");
$objectDefinition = CMS_poly_object_catalog::getObjectDefinition($objectDefitionId);

$RSSDefinition = new CMS_poly_rss_definitions();

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

$cms_message = "";

switch ($_POST["cms_action"]) {
	case "validate":
	case "switchexplanation":
	break;
}

$dialog = new CMS_dialog();
$dialog->setTitle("Cr&eacute;ation / modification d'une d&eacute;finition oembed",'picto_modules.gif');
$dialog->setBacklink("modules_admin.php?moduleCodename=".$moduleCodename."&object=".$objectDefinition->getID());

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$scriptname = $_SERVER['SCRIPT_NAME'];

// Automne dialog system forces us to use a $content variable and so to mix everything...

$content = <<<HTML
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../codemirror/codemirror.css" />
<script type="text/javascript" src="../codemirror/codemirror.js"></script>
<script type="text/javascript" src="../codemirror/xml.js"></script>
<script type="text/javascript" src="../codemirror/javascript.js"></script>
<script type="text/javascript" src="../codemirror/clike.js"></script>
<script type="text/javascript" src="../codemirror/htmlmixed.js"></script>
<script type="text/javascript" src="../codemirror/php.js"></script>
<script type="text/javascript" src="./js/oembed.js"></script>

<div class="container">
<form name="frm" id="oembeddef" action="$scriptname" method="post" class="form-horizontal">
<input type="hidden" id="cms_action" name="cms_action" value="validate" />
<input type="hidden" name="moduleCodename" value="$moduleCodename" />
<input type="hidden" name="object" value="$objectDefinition->getID()" />
<fieldset>
	<div class="row">
		<div class="col-md-6">
			<!-- Text input-->
			<div class="control-group">
				<label class="control-label" for="codename">Codename</label>
				<div class="controls">
					<input id="codename" name="codename" type="text" placeholder="" class="input-medium" required="">
					<p class="help-block">Les pages possédant ce codename auront le code spécifique à l\'oembed rajouté dans le header de la page</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<!-- Text input-->
			<div class="control-group">
				<label class="control-label" for="parameter">Paramètre</label>
				<div class="controls">
					<input id="parameter" name="parameter" type="text" placeholder="" class="input-medium" required="">
					<p class="help-block">La variable dans l\'url de la page qui donne l\'identifiant de l\'objet à traiter</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="control-group">
				<label class="control-label" for="textarea">Définition XML</label>
				<div class="controls">
					<textarea id="definitionXml" name="definitionXml" class="form-control" rows="18">'.''.'</textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6">
<label class="control-label" for="textarea">Aide</label>
	<pre>&lt;oembed&gt;
	&lt;type&gt;value&lt;/type&gt;
	&lt;title&gt;value&lt;/title&gt;
	&lt;author_name&gt;value&lt;/author_name&gt;
	&lt;author_url&gt;value&lt;/author_url&gt;
	&lt;width&gt;value&lt;/width&gt;
	&lt;height&gt;value&lt;/height&gt;
	&lt;url&gt;value&lt;/url&gt;
	&lt;web_page&gt;value&lt;/web_page&gt;
	&lt;thumbnail_url&gt;value&lt;/thumbnail_url&gt;
	&lt;thumbnail_width&gt;value&lt;/thumbnail_width&gt;
	&lt;thumbnail_height&gt;value&lt;/thumbnail_height&gt;
	&lt;web_page_short_url&gt;value&lt;/web_page_short_url&gt;
	&lt;license&gt;value&lt;/license&gt;
	&lt;license_id&gt;value&lt;/license_id&gt;
	&lt;version&gt;value&lt;/version&gt;
	&lt;cache_age&gt;value&lt;/cache_age&gt;
	&lt;provider_name&gt;value&lt;/provider_name&gt;
	&lt;provider_url&gt;value&lt;/provider_url&gt;
&lt;/oembed&gt;</pre>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="control-group">
				<label class="control-label" for="textarea">Définition JSON</label>
				<div class="controls">
					<textarea id="definitionJson" name="definitionJson" class="form-control" rows="18">'.''.'</textarea>
				</div>
			</div>
		</div>
		<div class="col-md-6">
<label class="control-label" for="textarea">Aide</label>
	<pre>
{
	"type": "value",
	"title": "value",
	"author_name": "value",
	"author_url": "value",
	"width": "value",
	"height": "value",
	"url": "value",
	"web_page": "value",
	"thumbnail_url": "value",
	"thumbnail_width": "value",
	"thumbnail_height": "value",
	"web_page_short_url": "value",
	"license": "value",
	"license_id": "value",
	"version": "value",
	"cache_age": "value",
	"provider_name": "value",
	"provider_url": "value"
}</pre>
		</div>
	</div>

</fieldset>
HTML;

//selected value
$selected['working'] = ($_POST['objectexplanation'] == 'working') ? ' selected="selected"':'';
$selected['working-polymod'] = ($_POST['objectexplanation'] == 'working-polymod') ? ' selected="selected"':'';
$selected['search'] = ($_POST['objectexplanation'] == 'search') ? ' selected="selected"':'';
$selected['vars'] = ($_POST['objectexplanation'] == 'vars') ? ' selected="selected"':'';
$selected['rss'] = ($_POST['objectexplanation'] == 'rss') ? ' selected="selected"':'';

$content.= '
<div class="control-group">
	<label class="control-label" for="selectbasic">Aide à la syntaxe</label>
	<div class="controls">
		<select name="objectexplanation" class="input-xlarge" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.getElementById(\'oembeddef\').submit();">
			<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
			<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
				<option value="rss"'.$selected['rss'].'>'.$cms_language->getMessage(MESSAGE_PAGE_RSS_TAG,false,MOD_POLYMOD_CODENAME).'</option>
				<option value="search"'.$selected['search'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
				<option value="working"'.$selected['working'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS).'</option>
				<option value="working-polymod"'.$selected['working-polymod'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_POLYMOD_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
				<option value="vars"'.$selected['vars'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENERAL_VARS).'</option>
			</optgroup>
			<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
				$content.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $objectDefinition->getID());
			$content.= '
			</optgroup>';
		$content.= '
		</select>
	</div>
</div>';


//then display chosen object infos
if ($_POST['objectexplanation']) {
	switch ($_POST['objectexplanation']) {
		case 'rss':
			$moduleLanguages = CMS_languagesCatalog::getAllLanguages($moduleCodename);
			foreach ($moduleLanguages as $moduleLanguage) {
				$moduleLanguagesCodes[] = $moduleLanguage->getCode();
			}
			$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_RSS_TAG_EXPLANATION,array(implode(', ',$moduleLanguagesCodes)),MOD_POLYMOD_CODENAME);
		break;
		case 'search':
			$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
		break;
		case 'working':
			$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION);
		break;
		case 'working-polymod':
			$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_POLYMOD_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
		break;
		case 'vars':
			$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION);
		break;
		default:
			//object info
			$content.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
		break;
	}
}
$content.='</form>';

$content .= '
	</div><!-- end container -->
';

$dialog->setContent($content);
$dialog->show();
?>