<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//Create page object
$dialog = new CMS_dialog();
$dialog->setTitle('Import <strong>!!! NE PAS UTILISER !!!</strong>');

switch (io::post('action')) {
	case 'import':
		$dialog->setBackLink('import.php');
		$format = io::post('format');
		if (!isset($_FILES['file'])) {
			$content .= 'Erreur upload: file not set.';
			break;
		}
		if ($_FILES['file']['error'] != UPLOAD_ERR_OK) {
			$content .= 'Erreur upload: file error '.$_FILES['file']['error'].'.';
			break;
		}
		switch ($format) {
			case 'xml':
				if ($_FILES['file']['type'] == 'text/xml') {
					include './PolymodExportDirector.php';
					include './PolymodModuleBuilder.php';
					$oXml = new CMS_DOMDocument();
					$oXml->load($_FILES['file']['tmp_name']);
					$oModuleBuilder = new PolymodModuleBuilder();
					$oModuleDirector = new PolymodExportDirector($oXml);
					$mResult = $oModuleDirector->construct($oModuleBuilder);
					if ($mResult !== true) {
						$content .= print_r($mResult, true);
					}
				} else {
					$content .= print_r($_FILES['file']['type'], true);
				}
				break;
			default:
				$content .= 'format?';
				break;
		}
		break;
	default:
		/*
		if (io::get('dev') != '123') { //dev state security
			$content .= 'Not ready yet.';
			$dialog->setContent($content);
			$dialog->show();
			exit;
		}
		*/
		$dialog->setBackLink('modules_admin.php');
		$content .= '
			<table border="0" cellpadding="2" cellspacing="2">
				<tr>
					<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" value="import" />
						<label>
							Fichier
							<input type="file" name="file" />
						</label>
						<fieldset>
							<legend>Format</legend>
							<label>
								<input type="radio" name="format" value="xml" />
								XML
							</label>
						</fieldset>
						<td>
							<input type="submit" class="admin_input_submit" value="Importer" />
						</td>
					</form>
				</tr>
			</table>
		';
		break;
}
//draw content
$dialog->setContent($content);
$dialog->show();
?>
