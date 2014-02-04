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
$objectDefitionId = io::request("objectdefinition");
$objectDefinition = CMS_poly_object_catalog::getObjectDefinition($objectDefitionId);
$oembedDefinitionId = io::request("definition");

$oembedDefinition = CMS_polymod_oembed_definition_catalog::getById($oembedDefinitionId);
if(!$oembedDefinition) {
	$oembedDefinition = new CMS_polymod_oembed_definition();
}

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

$cms_message = "";

switch ($_POST["cms_action"]) {
	case "validate":
		$oembedDefinition->setObjectdefinition(io::post('objectdefinition'));
		$oembedDefinition->setCodename(io::post('codename'));
		$oembedDefinition->setHtml(io::post('html'));
		$oembedDefinition->setParameter(io::post('parameter'));
		$oembedDefinition->setLabel(io::post('label'));

		if($oembedDefinition->validate()) {
			$oembedDefinition->writeToPersistence();
		}
		else {
			$errors = $oembedDefinition->getValidationFailures();
			foreach ($errors as $error) {
				$cms_message .= "\n".$error;
			}
		}
	break;
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
$definitionHtml = htmlspecialchars($oembedDefinition->getHtml());

// Automne dialog system forces us to use a $content variable and so to mix everything...

$content = <<<HTML
<link rel="stylesheet" type="text/css" href="./css/admin-bootstrap.css" />
<link rel="stylesheet" type="text/css" href="../codemirror/codemirror.css" />
<script type="text/javascript" src="../codemirror/codemirror.js"></script>
<script type="text/javascript" src="../codemirror/indent.js"></script>
<script type="text/javascript" src="../codemirror/xml.js"></script>
<script type="text/javascript" src="../codemirror/javascript.js"></script>
<script type="text/javascript" src="../codemirror/clike.js"></script>
<script type="text/javascript" src="../codemirror/htmlmixed.js"></script>
<script type="text/javascript" src="../codemirror/php.js"></script>
<script type="text/javascript" src="../codemirror/css.js"></script>
<script type="text/javascript" src="./js/oembed.js"></script>

<div class="container">
<form name="frm" id="oembeddef" action="$scriptname" method="post" class="form-horizontal" style="font-size: 12px;">
<input type="hidden" id="cms_action" name="cms_action" value="validate" />
<input type="hidden" name="moduleCodename" value="$moduleCodename" />
<input type="hidden" name="objectdefinition" value="{$objectDefinition->getID()}" />
<input type="hidden" name="definition" value="{$oembedDefinition->getId()}" />
<fieldset>
	<div class="row">
		<div class="col-md-12">
			<!-- Text input-->
			<div class="form-group">
				<label class="" for="label">Libellé</label>
				<div class="controls">
					<p class="help-block">Un libellé décrivant la définition oembed</p>
					<input id="label" name="label" type="text" placeholder="" class="form-control" required="" value="{$oembedDefinition->getLabel()}">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<!-- Text input-->
			<div class="form-group">
				<label class="" for="codename">Codename</label>
				<div class="controls">
					<p class="help-block">Les pages possédant ce codename auront le code spécifique à l'oembed rajouté dans le header de la page</p>
					<input id="codename" name="codename" type="text" placeholder="" class="form-control" required="required" value="{$oembedDefinition->getCodename()}">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<!-- Text input-->
			<div class="form-group">
				<label class="" for="parameter">Paramètre</label>
				<div class="controls">
					<p class="help-block">La variable dans l'url de la page qui donne l'identifiant de l'objet à traiter</p>
					<input id="parameter" name="parameter" type="text" placeholder="" class="form-control" required="" value="{$oembedDefinition->getParameter()}">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="" for="textarea">Contenu HTML</label>
				<p class="help-block">Le contenu ci-dessous sera utilisé pour la représentation HTML de l'objet</p>
				<div class="controls">
					<textarea id="editor" name="html" class="form-control" rows="30">{$definitionHtml}</textarea>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
	  <div class="controls">
	  	<button type="button" class="btn btn-primary" id="reindent">
	    	<span class="glyphicon glyphicon-transfer"></span>
	    	Réindenter
	    </button>
	    <button type="submit" class="btn btn-success">
	    <span class="glyphicon glyphicon-floppy-disk"></span>
	    	Valider
	    </button>
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

$helpContent.= '
<div class="form-group">
	<label class="" for="selectbasic">Aide à la syntaxe</label>
	<div class="controls">
		<select name="objectexplanation" class="input-xlarge" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.getElementById(\'oembeddef\').submit();">
			<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
			<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
				<option value="search"'.$selected['search'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
				<option value="working"'.$selected['working'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS).'</option>
				<option value="working-polymod"'.$selected['working-polymod'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_POLYMOD_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
				<option value="vars"'.$selected['vars'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENERAL_VARS).'</option>
			</optgroup>
			<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
				$helpContent.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $objectDefinition->getID());
			$helpContent.= '
			</optgroup>';
		$helpContent.= '
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
			$helpContent .= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_RSS_TAG_EXPLANATION,array(implode(', ',$moduleLanguagesCodes)),MOD_POLYMOD_CODENAME);
		break;
		case 'search':
			$helpContent .= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
		break;
		case 'working':
			$helpContent .= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION);
		break;
		case 'working-polymod':
			$helpContent .= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_POLYMOD_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
		break;
		case 'vars':
			$helpContent .= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION);
		break;
		default:
			//object info
			$helpContent .= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
		break;
	}
}

$content .= '<div class="well">'.$helpContent.'</div>';

$content.='</form>';

$content .= '
	</div><!-- end container -->
';

$dialog->setContent($content);
$dialog->show();
?>