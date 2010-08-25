<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
$moduleCodename = io::get('moduleCodename');
if (!$moduleCodename) {
	exit;
}
//Create page object
$dialog = new CMS_dialog();
$dialog->setTitle('Export');

$aHeaders = array(
	'php'	=> 'text/plain',
	'xml'	=> 'text/xml',
);
switch (io::get('action')) {
	case 'export':
		$dialog->setBackLink('export.php?moduleCodename='.$moduleCodename);
		$oModule = CMS_modulesCatalog::getByCodename($moduleCodename);
		$aModule = $oModule->asArray();
		$format = io::get('format');
		switch ($format) {
			case 'php':
				$sOutput = var_export($aModule, true);
				break;
			case 'xml':
				$oDom = new CMS_DOMDocument();
				$oModule = $oDom->createElement('module');
				$oModule->setAttribute('codename', $aModule['codename']);
				$oDom->appendChild($oModule);
				//module labels
				foreach ($aModule['labels'] as $sLanguage=>$sLabel) {
					$oLabel  = $oDom->createElement('label', $sLabel);
					$oLabel->setAttribute('language', $sLanguage);
					$oModule->appendChild($oLabel);
				}
				//module classes
				foreach ($aModule['classes'] as $aClass) {
					$oClass  = $oDom->createElement('class');
					$oClass->setAttribute('id', $aClass['id']);
					//class labels
					foreach ($aClass['labels'] as $sLanguage=>$sLabel) {
						$oLabel = $oDom->createElement('label', $sLabel);
						$oLabel->setAttribute('language', $sLanguage);
						$oClass->appendChild($oLabel);
					}
					//class descriptions
					foreach ($aClass['descriptions'] as $sLanguage=>$sDescription) {
						$oDescription = $oDom->createElement('description', $sDescription);
						$oDescription->setAttribute('language', $sLanguage);
						$oClass->appendChild($oDescription);
					}
					//class params
					foreach ($aClass['params'] as $sParamName=>$mParamValue) {
						switch ($sParamName) {
							case 'params':
								$oCdata = $oDom->createCDATASection(serialize($mParamValue));
								$oParam = $oDom->createElement('param');
								$oParam->appendChild($oCdata);
								break;
							case 'composedLabel':
							case 'previewURL':
							case 'indexURL':
							case 'resultsDefinition':
								$oCdata = $oDom->createCDATASection($mParamValue);
								$oParam = $oDom->createElement('param');
								$oParam->appendChild($oCdata);
								break;
							default:
								$oParam = $oDom->createElement('param', $mParamValue);
								break;
						}
						$oParam->setAttribute('name', $sParamName);
						$oClass->appendChild($oParam);
					}
					//fields
					foreach ($aClass['fields'] as $aField) {
						$oField = $oDom->createElement('field');
						$oField->setAttribute('type', $aField['type']);
						$oField->setAttribute('multi', $aField['multi']);
						//fields labels
						foreach ($aField['labels'] as $sLanguage=>$sLabel) {
							$oLabel = $oDom->createElement('label', $sLabel);
							$oLabel->setAttribute('language', $sLanguage);
							$oField->appendChild($oLabel);
						}
						//fields descriptions
						foreach ($aField['descriptions'] as $sLanguage=>$sDescription) {
							$oDescription = $oDom->createElement('description', $sDescription);
							$oDescription->setAttribute('language', $sLanguage);
							$oField->appendChild($oDescription);
						}
						//fields params
						foreach ($aField['params'] as $sParamName=>$mParamValue) {
							switch ($sParamName) {
								case 'params':
									$oCdata = $oDom->createCDATASection(serialize($mParamValue));
									$oParam = $oDom->createElement('param');
									$oParam->appendChild($oCdata);
									break;
								default:
									$oParam = $oDom->createElement('param', $mParamValue);
									break;
							}
							$oParam->setAttribute('name', $sParamName);
							$oField->appendChild($oParam);
						}
						$oClass->appendChild($oField);
					}
					$oModule->appendChild($oClass);
				}
				$sOutput = $oDom->saveXML();
				break;
			default:
				$content .= 'format inconu';
				break;
		}
		if (isset($sOutput)) {
			if (io::get('download', '', false)) {
				header('Content-type: '.$aHeaders[$format].'; charset=utf-8');
				header('Content-Disposition: attachment; filename='.$aModule['codename'].'.'.$format);
				echo $sOutput;
				exit;
			} else {
				$content .= '<textarea cols="128" rows="32">'.$sOutput.'</textarea>';
			}
		}
		break;
	default:
		$dialog->setBackLink('modules_admin.php?moduleCodename='.$moduleCodename);
		$content .= '
			<table border="0" cellpadding="2" cellspacing="2">
				<tr>
					<form action="'.$_SERVER['SCRIPT_NAME'].'" method="get">
						<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
						<input type="hidden" name="action" value="export" />
						<fieldset>
							<legend>Format</legend>
							<label>
								<input type="checkbox" name="download" value="1" />
								Transmettre
							</label>
							<label>
								<input type="radio" name="format" value="xml" />
								XML
							</label>
							<label>
								<input type="radio" name="format" value="php" />
								PHP
							</label>
						</fieldset>
						<td>
							<input type="submit" class="admin_input_submit" value="Exporter" />
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
