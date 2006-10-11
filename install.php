<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2005 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | or (at your discretion) to version 3.0 of the PHP license.           |
// | The first is bundled with this package in the file LICENSE-GPL, and  |
// | is available at through the world-wide-web at                        |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | The later is bundled with this package in the file LICENSE-PHP, and  |
// | is available at through the world-wide-web at                        |
// | http://www.php.net/license/3_0.txt.                                  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>  &   |
// | Author: Devin Doucette <darksnoopy@shaw.ca> (for archives classes)   |
// +----------------------------------------------------------------------+
//
// $Id: install.php,v 1.10 2006/10/11 15:44:15 sebastien Exp $

/**
  * PHP page : Automne Installation Manager
  * 
  * @package CMS
  * @subpackage installation
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Remove notices
error_reporting(E_ALL ^ E_NOTICE);
@set_time_limit(0);

//Installation languages
$install_language = ($_REQUEST["install_language"]) ? $_REQUEST["install_language"]:'';
$accepted_languages = array('en','fr');
$install_language = (in_array($install_language , $accepted_languages) === true) ? $install_language : '';

//Current installation step
$step = ($_REQUEST["step"]) ? $_REQUEST["step"]:'check';
$accepted_step = array('0','1','2','3','4','5','6','7','8','9','gpl','check');
$step = (in_array($step , $accepted_step) === true) ? $step:'check';

$content = $title = '';

// +----------------------------------------------------------------------+
// | STEP 0 : Installation language                                       |
// +----------------------------------------------------------------------+
if ($install_language == '') {
	$title = '<h1>Installation language / Langue d\'installation :</h1>';
	$content .= '
	<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
		<input type="hidden" name="step" value="'.$step.'" />
		Please choose your installation language.<br />
		Veuillez choisir votre langue d\'installation.<br />
		<label for="fr"><input id="fr" type="radio" name="install_language" value="fr" checked="checked" /> Français</label><br />
		<label for="en"><input id="en" type="radio" name="install_language" value="en" /> English</label><br />
		<input type="submit" class="submit" value=" OK " />
	</form>';
	$step = 0;
}

//Installation labels
switch ($install_language) {
	case "fr":
		//General labels
		$label_next = 'Suivant';
		$label_docroot = "Erreur, ce fichier doit ce trouver à la racine du serveur web ! (%s)";
		
		//STEP check
		$error_stepCheck_php_error = 'Erreur, Votre version de PHP ('.phpversion().') n\'est pas compatible avec Automne. Vous devez avoir une version supérieure à la 4.3.7 et inférieure à la version 5.0.0.';
		$error_stepCheck_dir_not_writable_error = 'Erreur, Apache ne possède pas les droits d\'écriture sur le répertoire racine de votre site web.';
		$error_stepCheck_safe_mode_error = 'Attention ! L\'option "safe_mode" est active sur votre configuration de PHP. Cette option est fortement déconseillée car l\'ensemble des fonctions d\'Automne ne seront pas disponibles et/ou leurs fonctionnement sera dégradé.';
		$error_stepCheck_magic_quotes_error = 'Attention ! L\'option "magic_quotes_gpc" est active sur votre configuration de PHP. Cette option est fortement déconseillée car l\'ensemble des fonctions d\'Automne ne seront pas disponibles et/ou leurs fonctionnement sera dégradé.';
		$error_stepCheck_gd_error = 'Erreur, l\'extension GD n\'est pas installée sur votre serveur. Vérifiez votre installation de PHP.';
		$error_stepCheck_gd_gif_error = 'Erreur, les fonctionnalités de traitement d\'images GIF ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
		$error_stepCheck_gd_jpeg_error = 'Erreur, les fonctionnalités de traitement d\'images JPEG ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
		$error_stepCheck_gd_png_error = 'Erreur, les fonctionnalités de traitement d\'images PNG ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
		$stepCheck_title = 'Compatibilité de votre système :';
		$stepCheck_installation_stopped = 'Vous ne pouvez poursuivre l\'installation d\'Automne ...';
		
		//STEP 1
		$error_step1_directory_not_exists = 'Erreur, Le repertoire d\'extraction n\'exise pas';
		$error_step1_cant_extract = 'Erreur, Impossible d\'extraire l\'archive %s. Format invalide...';
		$step1_title = 'Décompression de l\'archive :';
		$step1_extraction_to = 'Décompression de %s vers %s';
		$step1_extraction_ok = 'Décompression réalisée avec succès';
		$step1_extraction_error = 'Erreur de décompression ... Veuillez décompresser manuellement l\'archive %s dans ce repertoire et relancez l\'installation.';
		$step1_package_extraction = 'Lancer la décompression de l\'archive %s...';
		
		//GPL STEP
		$stepGPL_title = 'License d\'exploitation :';
		$stepGPL_explanation = 'L\'utilisation d\'Automne est soumis à l\'acceptation de la license GNU-GPL suivante.';
		$stepGPL_licenseNotFound = 'Le fichier de license est introuvable, veuillez le consulter ici : <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a>';
		$stepGPL_accept = 'Acceptez vous les termes de cette license ?';
		$stepGPL_yes = 'J\'accepte les termes de la license.';
		$stepGPL_no = 'Je n\'accepte pas les termes de la license.';
		
		//STEP 2
		$error_step2_no_cms_rc_admin = 'Erreur, impossible de trouver %s/cms_rc_admin.php';
		$error_step2_missing_host = 'Erreur, paramètre hôte de la base de données manquant';
		$error_step2_missing_name = 'Erreur, paramètre nom de la base de données manquant';
		$error_step2_missing_user = 'Erreur, paramètre utilisateur de la base de données manquant';
		$error_step2_DB_connection_failed = 'Erreur, Connection à la base de données impossible';
		$error_step2_DB_incorrect_name = 'Erreur, nom de base de données incorrect, selection de la base impossible';
		$step2_title = 'Identification à la base de données:';
		$step2_explanation = 'Les informations de connection à la base de données vous sont fournies par votre hébergeur. Veillez à ce que la base que vous allez utiliser existe. Si La base n\'existe pas, ce script tentera de la créer si vous avez les droits suffisants.';
		$step2_DB_host = 'Hôte de la base de données';
		$step2_DB_name = 'Nom de la base de données';
		$step2_DB_user = 'Utilisateur de la base de données';
		$step2_DB_password = 'Mot de passe de la base de données';
		
		//STEP 3
		$error_step3_must_choose_option = 'Erreur, vous devez choisir un option ...';
		$error_step3_SQL_script = 'Erreur, syntaxe incorrecte dans le fichier : %s ou fichier manquant';
		$step3_title = 'Choisissez un type d\'installation :';
		$step3_Demo = 'Automne avec la Démo (conseillé pour débuter sur le logiciel)';
		$step3_Empty = 'Automne vide (pour créer un site à partir de zéro)';
		$step3_skip = 'Conserver la Base de Données actuelle';
		
		//STEP 4
		$error_step4_enter_url = 'Erreur, Vous devez saisir une URL ...';
		$step4_title = 'URL du site web :';
		$step4_enter_url = 'Entrez l\'URL du site web (la valeur par défaut doit-être correcte). Il s\'agit de l\'URL de la racine du site.<br />Si vous saisissez un nom de domaine, ce dernier doit exister. Vous pourrez modifier cela à tout moment dans l\'administration du site.';
		$step4_url = 'URL * : http://';
		
		//STEP 5
		$error_step5_perms_files = 'Erreur, Vous devez entrer une valeur de permission pour les fichiers ...';
		$error_step5_perms_dirs = 'Erreur, Vous devez entrer une valeur de permission pour les dossiers ...';
		$step5_title = 'Permissions des fichiers et des dossiers :';
		$step5_explanation = 'Automne génère un grand nombre de fichiers et de dossiers. Les droits suivant ont été detectés comme étant utilisés par votre serveur.<br />Etes-vous d\'accord pour les utiliser lorsque Automne crééra des fichiers et des dossiers ?<br />Attention, modifier ces droits peut entrainer des erreurs sur le serveur si ce dernier ne les acceptes pas. Modifiez les seulement si vous savez ce que vous faites.';
		$step5_files_perms = 'Permissions sur les fichiers';
		$step5_dirs_perms = 'Permissions sur les dossiers';
		
		//STEP 6
		$error_step6_choose_option = 'Erreur, vous devez choisir une option ...';
		$step6_title = 'Méthode de régénération :';
		$step6_explanation = 'Automne génère les pages finales des visiteurs. Cette génération peut-être faite de deux manière :<br />
			<ul>
				<li>Par une fenêtre pop-up. Processus assez lent mais qui fonctionne sur tous les serveurs. Vous devez choisir cela sur les serveurs mutualisés (ou sur Easyphp et autres solutions n\'utilisant pas une version complète de PHP)</li>
				<li>Par un script en tache de fond. Processus rapide mais qui ne fonctionne pas sur tous les serveurs. Vous pouvez choisir cela sur les serveurs dédiés qui ont l\'éxécutable PHP-CLI installé (éxécutable en ligne de commande) et si vous connaissez sont chemin d\'installation sur le serveur.</li>
			</ul>';
		$step6_popup = 'Fenêtre pop-up';
		$step6_bg = 'Script en tache de fond';
		
		//STEP 7
		$error_step7_CLI_path = 'Erreur, Vous devez saisir un chemin pour l\'éxécutable PHP-CLI ...';
		$error_step7_tmp_path = 'Erreur, Vous devez spécifier un répertoire temporaire ...';
		$error_step7_valid_tmp_path = 'Erreur, Vous devez spécifier un répertoire temporaire valide ...';
		$step7_title = 'Paramètres de régénération :';
		$step7_CLI_explanation = 'Entrez ici le chemin vers l\'éxécutable PHP-CLI (sur les serveurs Unix il s\'agit généralement de /usr/local/bin/php. Sur les serveurs Windows il s\'agit généralement de c:\php\cli\cli.exe).';
		$step7_CLI = 'Chemin vers l\'éxécutable PHP-CLI';
		$step7_tmp_path_explanation = 'Aucun répertoire temporaire n\'a put être identifié sur ce serveur. <br />Merci d\'entrer un repertoire temporaire ici (Le chemin complet du repertoire est requis, ex /tmp or c:\tmp). Ce repertoire doit être inscriptible par le serveur web.';
		$step7_tmp_path = 'Chemin du repertoire temporaire';
		
		//STEP 8
		$error_step8_sessions = 'Erreur, Vous avez un problème avec la création de sessions utilisateurs. Vous devez corriger cela avant d\'utiliser Automne !';
		$error_step8_smtp_error = 'Erreur, Aucun serveur SMTP trouvé. Vérifiez votre installation de PHP ou cochez la case ci-dessous si vous souhaitez désactiver l\'envoi d\'email par l\'application.';
		$error_step8_label = 'Erreur, Merci de saisir un nom pour votre site.';
		$step8_title = 'Finalisation de l\'installation :';
		$step8_CLI_explanation = 'Automne utilise des fichiers .htaccess pour protéger l\'accès de certains repertoires.<br />Le service d\'hébergement de Free.fr n\'accepte pas la syntaxe courante de ces fichiers. Si vous hébergez Automne chez Free.fr, cochez la case ci-dessous pour modifier ces fichiers .htaccess';
		$step8_freefr = 'Cochez si vous êtes hébergé par Free.fr';
		$step8_no_application_email = 'Cochez si vous souhaitez désactiver l\'envoi d\'email par l\'application';
		$step8_application_label = 'Saisissez un nom pour votre site.';
		$step8_label = 'Nom du site';
		
		//STEP9
		$step9_title = 'Installation terminée !';
		$step9_alldone = 'L\'installation d\'Automne est terminée.<br />
		<br />Vous pouvez accéder à l\'administration du site à cette adresse :<br />
		<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br />
		L\'identifiant par défaut est "root" et le mot de passe "automne".<br />
		Pensez à changer rapidement le mot de passe dans le profil utilisateur !<br />
		<br />
		Si vous avez choisi l\'installation de la Démo, la partie publique sera visible à l\'adresse <a href="/" target="_blank">%s</a> une fois que vous vous serez connecté une première fois à l\'administration de votre site.<br />
		<br />
		Vous pouvez supprimer l\'archive ayant servie à cette installation ainsi que le fichier install.php.<br />
		Attention, laisser ces fichiers sur un site en production représente une faille importante de sécurité pour votre site !<br />
		<br />
		Si vous souhaitez modifier certaines options saisies lors de cette installation, relancez le fichier install.php ou éditez le fichier config.php se trouvant à la racine de votre site web.<br />
		<br />
		Merci d\'utiliser Automne !<br />
		<br />
		Pour toutes questions, contactez le support Automne sur le forum du site <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.';
	break;
	case "en":
	default:
		//General labels
		$label_next = 'Next';
		$label_docroot = "Error, this file Must be at the server Document Root ! (%s)";
		
		//STEP check
		$error_stepCheck_php_error = 'Error, Your PHP version ('.phpversion().') is not compatible with Automne. You must have a version greater than 4.3.7 and lower than 5.0.0.';
		$error_stepCheck_dir_not_writable_error = 'Error, Apache does not have write permissions on your website root directory.';
		$error_stepCheck_safe_mode_error = 'Beware ! The "safe_mode" option is active on your PHP configuration. This option is strongly disadvised because some Automne functions will not be available or should be degraded.';
		$error_stepCheck_magic_quotes_error = 'Beware ! The "magic_quotes_gpc" option is active on your PHP configuration. This option is strongly disadvised because some Automne functions will not be available or should be degraded.';
		$error_stepCheck_gd_error = 'Error, GD extension is not installed on your server. Please Check your PHP installation.';
		$error_stepCheck_gd_gif_error = 'Error, functionalities of GIF image processing are not installed (GD Extension). Please Check your PHP installation.';
		$error_stepCheck_gd_jpeg_error = 'Error, functionalities of JPEG image processing are not installed (GD Extension). Please Check your PHP installation.';
		$error_stepCheck_gd_png_error = 'Error, functionalities of PNG image processing are not installed (GD Extension). Please Check your PHP installation.';
		$stepCheck_title = 'System compatibility:';
		$stepCheck_installation_stopped = 'You cannot continue Automne installation...';
		
		//STEP 1
		$error_step1_directory_not_exists = 'Error, Extraction directory does not exist';
		$error_step1_cant_extract = 'Error, Can\'t extract archive wanted %s. It is not a valid format...';
		$step1_title = 'Archive extraction:';
		$step1_extraction_to = 'Extract %s to %s';
		$step1_extraction_ok = 'Extraction successful';
		$step1_extraction_error = 'Extraction error... Please decompress manually the file %s in this repertory and start again the installation.';
		$step1_package_extraction = 'Launch extraction of package %s...';
		
		//GPL STEP
		$stepGPL_title = 'User License:';
		$stepGPL_explanation = 'The use of Automne is subjected to acceptance of following GNU-GPL license.';
		$stepGPL_licenseNotFound = 'License file does not exist, You can consult it here : <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a>';
		$stepGPL_accept = 'Do you agree with terms of this license?';
		$stepGPL_yes = 'I accept the terms of the license.';
		$stepGPL_no = 'I do not accept the terms of the license.';
		
		//STEP 2
		$error_step2_no_cms_rc_admin = 'Error, cannot find %s/cms_rc_admin.php';
		$error_step2_missing_host = 'Error, Missing Database Host parameter';
		$error_step2_missing_name = 'Error, Missing Database Name parameter';
		$error_step2_missing_user = 'Error, Missing Database User parameter';
		$error_step2_DB_connection_failed = 'Error, Database engine connection failed';
		$error_step2_DB_incorrect_name = 'Error, Incorrect Database Name, Database selection failed';
		$step2_title = 'Database identification:';
		$step2_explanation = 'Information of connection to the database is provided to you by your web administrator. Take care that the database that you will use exists. If the database does not exist, this script will try to create it if you have the sufficient privileges.';
		$step2_DB_host = 'Database Host';
		$step2_DB_name = 'Database Name';
		$step2_DB_user = 'Database User';
		$step2_DB_password = 'Database Password';
		
		//STEP 3
		$error_step3_must_choose_option = 'Error, You must choose an option ...';
		$error_step3_SQL_script = 'Error, syntax error in sql script file: %s or file missing';
		$step3_title = 'Choose installation type:';
		$step3_Demo = 'Automne with Demo (advised to begin on the software)';
		$step3_Empty = 'Automne empty (to create a site from scratch)';
		$step3_skip = 'Preserve the current database';
		
		//STEP 4
		$error_step4_enter_url = 'Error, You must enter an URL ...';
		$step4_title = 'Website URL:';
		$step4_enter_url = 'Enter the URL of the website (default value should be correct). It is the URL of the server Document Root.<br />If you enter a domain name, this must exist. You will be able to modify this at any time in the administration platform of the site.';
		$step4_url = 'URL * : http://';
		
		//STEP 5
		$error_step5_perms_files = 'Error, You must enter permission values for files ...';
		$error_step5_perms_dirs = 'Error, You must enter permission values for directories ...';
		$step5_title = 'Files and directories permissions:';
		$step5_explanation = 'Automne generates many files and directories. The following rights have been detected to be used by the server for files and directories creation.<br />Do you agree with using these rights when Automne creates files or directories?<br />Warning, modifying these rights can involve errors on the server if it does not accept them. Modify them only if you are sure of the values. Else, please contact your administrator';
		$step5_files_perms = 'Files permissions';
		$step5_dirs_perms = 'Directories permissions';
		
		//STEP 6
		$error_step6_choose_option = 'Error, You must choose an option ...';
		$step6_title = 'Choose regeneration method:';
		$step6_explanation = 'Automne generates all web pages. This generation can be accomplished using one of two methods :<br />
			<ul>
				<li>Pop-up window. Slow but works fine on all servers. You must choose this method for mutualized servers (or with Easyphp or other solutions that do not use a complete version of PHP).</li>
				<li>Background script. Fast but does not work on all servers. You can choose this method if you are on a dedicated server who has PHP-CLI installed and if you know the path of PHP-CLI on the server.</li>
			</ul>';
		$step6_popup = 'Pop-up window';
		$step6_bg = 'Background script';
		
		//STEP 7
		$error_step7_CLI_path = 'Error, You must enter a Path for the PHP-CLI ...';
		$error_step7_tmp_path = 'Error, You must specify a temporary path ...';
		$error_step7_valid_tmp_path = 'Error, You must specify a valid temporary path ...';
		$step7_title = 'Regeneration parameters:';
		$step7_CLI_explanation = 'Enter here the path to the PHP-CLI executable (on Unix servers it is usually /usr/local/bin/php on Windows servers it is usually c:\php\cli\cli.exe).';
		$step7_CLI = 'PHP-CLI path';
		$step7_tmp_path_explanation = 'No Path founded for the temporary directory on this server. <br />Please enter a temporary path here (full path needed ex : /tmp or c:\tmp). This directory must be writable by the server.';
		$step7_tmp_path = 'Temp path';
		
		//STEP 8
		$error_step8_sessions = 'Error, You have a problem with server session creation. You must correct it before using Automne !';
		$error_step8_smtp_error = 'Error, No SMTP server found. Please Check your PHP installation or check the box below to cancel the application email sending.';
		$error_step8_label = 'Error, Please to enter a name for your site.';
		$step8_title = 'Installation finalisation:';
		$step8_CLI_explanation = 'Automne uses .htaccess files to protect some directories.<br />The Free.fr hosting service does not accept the current syntax of these files. If you are on Free.fr, check the box below to modify the .htaccess files.';
		$step8_freefr = 'Check box if you are on Free.fr hosting service';
		$step8_no_application_email = 'Check box if you want to cancel application email sending';
		$step8_application_label = 'Enter a name for your site.';
		$step8_label = 'Site name';
		
		//STEP9
		$step9_title = 'Installation done!';
		$step9_alldone = '
		Automne installation is done.<br />
		<br />
		You can reach the site administration at this address:<br />
		<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br />
		Default login is "root" and password is "automne".<br />
		Please modify the password in the user profile!<br />
		<br />
		If you selected the Demo installation, the public site will be visible at the address <a href="/" target="_blank">%s</a> once you will have connected first to the administration of your Web site.<br />
		<br />
		You can now remove the package file used for this installation as well as the file install.php.<br />
		Warning, leaving these files on a production website may represent an important security hole for your Web site!<br />
		<br />
		If you wish to modify options saved during this installation, start again the file install.php or edit the file config.php at the root of your Web site.<br />
		<br />
		Thank you for using Automne!<br />
		<br />
		For all questions, contact the automne support team via the web site <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.';
	break;
}

// +----------------------------------------------------------------------+
// | STEP check : System check compatibility                              |
// +----------------------------------------------------------------------+
if ($step === 'check') {
	//check for php compatibility
	if (version_compare(phpversion(), "4.3.8", ">=") && version_compare(phpversion(), "5.0.0", "<")) {
		//check for document root writing
		if (function_exists('is_executable') //assume we are on windows platform because this function does not exists before PHP5.0.0 (so files are always executable)
			&& !@is_executable(dirname(__FILE__))) {
			$error .= $error_stepCheck_dir_not_writable_error.'<br /><br />';
			$stopInstallation = true;
		}
		//check for GD
		if (!function_exists("imagecopyresampled")) {
			$error .= $error_stepCheck_gd_error.'<br /><br />';
			$stopInstallation = true;
		} else {
			if (!function_exists("imagecreatefromgif")) {
				$error .= $error_stepCheck_gd_gif_error.'<br /><br />';
				$stopInstallation = true;
			}
			if (!function_exists("imagecreatefromjpeg")) {
				$error .= $error_stepCheck_gd_jpeg_error.'<br /><br />';
				$stopInstallation = true;
			}
			if (!function_exists("imagecreatefrompng")) {
				$error .= $error_stepCheck_gd_png_error.'<br /><br />';
				$stopInstallation = true;
			}
		}
		//check for safe_mode
		if (ini_get ( 'safe_mode' )) {
			$error .= $error_stepCheck_safe_mode_error.'<br /><br />';
		}
		//check for magic quotes
		if (get_magic_quotes_gpc()) {
			$error .= $error_stepCheck_magic_quotes_error.'<br /><br />';
		}
	} else {
		$error .= $error_stepCheck_php_error.'<br /><br />';
		$stopInstallation = true;
	}
	if ($error) {
		$title ='<h1>'.$stepCheck_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		if (!$stopInstallation) {
			$content .= '
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<input type="hidden" name="step" value="1" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />
				<input type="submit" class="submit" value="'.$label_next.'" />
			</form>
			';
		} else {
			$content .= $stepCheck_installation_stopped;
		}
	} else {
		//all is ok, skip to next step
		$step = 1;
	}
}

// +----------------------------------------------------------------------+
// | STEP 1 : Uncompress archive                                          |
// +----------------------------------------------------------------------+

if ($step == 1) {
	//read current dir and search archive (.tar.gz or .tgz file)
	$directory = dir($_SERVER['DOCUMENT_ROOT']);
	$archiveFound=false;
	while (false !== ($file = $directory->read())) {
		if ($file!='.' && $file!='..') {
			if ((strpos($file, '.tar.gz')!==false || strpos($file, '.tgz')!==false) && strpos($file, 'automne')!==false) {
				$archiveFound=true;
				$archiveFile = $file;
			}
			if ($file == 'cms_rc_admin.php') {
				//archive allready uncompressed, then skip to next installation step
				$step = 'gpl';
			}
		}
	}
}
//if archive founded, uncompress it
if ($archiveFound && $step==1) {
	if ($_POST["cms_action"] == 'extract') {
		$archive = new CMS_gzip_file_install($_SERVER['DOCUMENT_ROOT']."/".$archiveFile);
		$error='';
		
		if (!$archive->hasError()) {
			$archive->set_options(array('basedir'=>$_SERVER['DOCUMENT_ROOT']."/", 'overwrite'=>1, 'level'=>1, 'dontUseFilePerms'=>1, 'forceWriting'=>1));
			if (is_dir($_SERVER['DOCUMENT_ROOT']))  {
				if (method_exists($archive, 'extract_files')) {
					$extractArchive = true;
					$content .= sprintf($step1_extraction_to,$archiveFile,$_SERVER['DOCUMENT_ROOT']).' ...<br /><br />';
				}
			} else {
				$error .= $error_step1_directory_not_exists.'<br />';
			}
		} else {
			$error .= sprintf($error_step1_cant_extract,$archiveFile).'<br />';
		}
		$title ='<h1>'.$step1_title.'</h1>';
	} else {
		$title ='<h1>'.$step1_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		'.sprintf($step1_package_extraction,$archiveFile).'
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="1" />
			<input type="hidden" name="cms_action" value="extract" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	}
}

// +----------------------------------------------------------------------+
// | STEP GPL : Accept GNU-GPL license                                    |
// +----------------------------------------------------------------------+

//if archive founded, uncompress it
if ($step === 'gpl') {
	if ($_POST["cms_action"] == 'acceptlicense') {
		if ($_POST["license"] == 'yes') {
			//go to next step
			$step = 2;
		} else {
			//go to www.automne.ws
			header("Location: http://www.automne.ws");
			exit;
		}
	} else {
		$title ='<h1>'.$stepGPL_title.'</h1>';
		$content .= '
		'.$stepGPL_explanation.'<br /><br />';
		if (@file_exists($_SERVER['DOCUMENT_ROOT'].'/automne/LICENSE-GPL')) {
			$content .= '<div class="license"><pre>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/automne/LICENSE-GPL').'</pre></div><br /><br />';
		} else {
			$content .= $stepGPL_licenseNotFound.'<br /><br />';
		}
		$content .= '
		'.$stepGPL_accept.'<br /><br />
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="1" />
			<input type="hidden" name="cms_action" value="acceptlicense" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			<label for="yes"><input id="yes" type="radio" name="license" value="yes" /> '.$stepGPL_yes.'</label><br />
			<label for="no"><input id="no" type="radio" name="license" value="no" checked="checked" /> '.$stepGPL_no.'</label><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	}
}

// +----------------------------------------------------------------------+
// | STEP 2 : Create config.php file                                      |
// +----------------------------------------------------------------------+

//Load all Automne classes
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/cms_rc_admin.php')) {
	require_once($_SERVER['DOCUMENT_ROOT'].'/cms_rc_admin.php');
	//if file config.php exists then go to next step
	if ($step == 2 && file_exists($_SERVER['DOCUMENT_ROOT'].'/config.php')) {
		$step = 3;
	}
} elseif ($step != 'check' && $step != 'gpl' && $step > 1) {
	die(sprintf($error_step2_no_cms_rc_admin,$_SERVER['DOCUMENT_ROOT']));
}

//create config.php
if ($step == 2) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "dbinfos") {
		//Params
		if (!$_POST["dbhost"]) {
			$error .= $error_step2_missing_host.'<br />';
		}
		if (!$_POST["dbname"]) {
			$error .= $error_step2_missing_name.'<br />';
		}
		if (!$_POST["dbuser"]) {
			$error .= $error_step2_missing_user.'<br />';
		}
		//DB connection
		if (!$errors) {
			//check DB infos
			$dblink = @mysql_connect($_POST["dbhost"], $_POST["dbuser"], $_POST["dbpass"]);
			if (!is_resource($dblink)) {
				$error .= $error_step2_DB_connection_failed."<br />";
			} else {
				$dbselect = @mysql_select_db($_POST["dbname"], $dblink);
				if ($dbselect) {
					@mysql_close($dblink);
				} else {
					//Try to create the DB
					if (@mysql_create_db($_POST["dbname"],$dblink) !== false) {
					} else {
						$error .= $error_step2_DB_incorrect_name."<br />";
					}
					@mysql_close($dblink);
				}
			}
		}
	}
	
	if ($error || $_POST["cms_action"] != "dbinfos") {
		$dbhostValue = ($_POST["dbhost"]) ? $_POST["dbhost"]:'localhost';
		$title ='<h1>'.$step2_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="2" />
			<input type="hidden" name="cms_action" value="dbinfos" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			'.$step2_explanation.'<br /><br />
			'.$step2_DB_host.' * : <input type="text" name="dbhost" value="'.$dbhostValue.'" /><br />
			'.$step2_DB_name.' * : <input type="text" name="dbname" value="'.$_POST["dbname"].'" /><br />
			'.$step2_DB_user.' * : <input type="text" name="dbuser" value="'.$_POST["dbuser"].'" /><br />
			'.$step2_DB_password.' : <input type="text" name="dbpass" value="'.$_POST["dbpass"].'" /><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} else {
		//create config file with valid DB infos
		$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
		$configFile->setContent('<?php
/*
 * AUTOMNE CONFIGURATION FILE
 * If you need to modify any configuration constants of files
 * cms_rc.php, cms_rc_admin.php or cms_rc_frontend.php
 * simply define the constant and it\'s new value in this file
 */

define("APPLICATION_DB_HOST", "'.$_POST["dbhost"].'");
define("APPLICATION_DB_NAME", "'.$_POST["dbname"].'");
define("APPLICATION_DB_USER", "'.$_POST["dbuser"].'");
define("APPLICATION_DB_PASSWORD", "'.$_POST["dbpass"].'");
?>');
		$configFile->writeToPersistence();
		
		//reload page (to include config.php file) and go to next step
		header("Location: ".$_SERVER["PHP_SELF"]."?step=3&install_language=".$install_language);
		exit;
	}
}

// +----------------------------------------------------------------------+
// | STEP 3 : Database Creation                                           |
// +----------------------------------------------------------------------+

if ($step == 3) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "dbscripts") {
		//Params
		if (!$_POST["script"]) {
			$error .= $error_step3_must_choose_option.'<br />';
		}
		if ($_POST["script"] == 3) {
			//keep current DB so go to next step
			$step = 4;
		}
	}
	
	//check if tables allready exists
	$exists = false;
	$sql = "
		show tables
		";
	$q = new CMS_query($sql);
	if ($q->getNumRows()) {
		//tables exists then scripts are allready executed so skip to next step
		$exists = true;
	}
	
	if ($error || $_POST["cms_action"] != "dbscripts") {
		$title = '<h1>'.$step3_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="3" />
			<input type="hidden" name="cms_action" value="dbscripts" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			<label for="demo"><input id="demo" type="radio" name="script" value="1" /> '.$step3_Demo.'</label><br />
			<label for="empty"><input id="empty" type="radio" name="script" value="2" /> '.$step3_Empty.'</label><br />';
			if ($exists === true) {
				$content .= '<label for="skip"><input id="skip" type="radio" name="script" value="3" /> '.$step3_skip.'</label><br />';
			}
		$content .= '
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} elseif ($step == 3) {
		//load DB scripts
		
		//1- DB structure
		$structureScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne3.sql";
		if (file_exists($structureScript) && CMS_patch::executeSqlScript($structureScript,true)) {
			CMS_patch::executeSqlScript($structureScript);
		} else {
			die(sprintf($error_step3_SQL_script,$structureScript));
		}
		
		//2- DB datas
		$dataScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne3-data.sql";
		if (file_exists($dataScript) && CMS_patch::executeSqlScript($dataScript,true)) {
			CMS_patch::executeSqlScript($dataScript);
		} else {
			die(sprintf($error_step3_SQL_script,$dataScript));
		}
		
		//3- DB messages
		$messagesScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne3-I18NM_messages.sql";
		if (file_exists($messagesScript) && CMS_patch::executeSqlScript($messagesScript,true)) {
			CMS_patch::executeSqlScript($messagesScript);
		} else {
			die(sprintf($error_step3_SQL_script,$messagesScript));
		}
		
		if ($_POST["script"] == 2) {
			//4- Clean Automne DB
			$scratchScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne3-scratch.sql";
			if (file_exists($scratchScript) && CMS_patch::executeSqlScript($scratchScript,true)) {
				CMS_patch::executeSqlScript($scratchScript);
			} else {
				die(sprintf($error_step3_SQL_script,$scratchScript));
			}
		}
		
		//go to next step
		$step = 4;
	}
}

// +----------------------------------------------------------------------+
// | STEP 4 : Website URL                                                 |
// +----------------------------------------------------------------------+

if ($step == 4) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "website") {
		//Params
		if (!$_POST["website"]) {
			$error .= $error_step4_enter_url.'<br />';
		}
	}
	
	if ($error || $_POST["cms_action"] != "website") {
		$websiteUrl = ($_POST["website"]) ? $_POST["website"]: $_SERVER["HTTP_HOST"];
		$title = '<h1>'.$step4_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="4" />
			<input type="hidden" name="cms_action" value="website" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			'.$step4_enter_url.'<br /><br />
			'.$step4_url.'<input type="text" name="website" value="'.$websiteUrl.'" /><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} else {
		$tmp = new CMS_websitesCatalog();
		if (method_exists($tmp, 'writeRootRedirection')) {
			CMS_websitesCatalog::writeRootRedirection();
		} else {
			$websites = CMS_websitesCatalog::getAll();
			foreach($websites as $aWebsite) {
				if ($aWebsite->isMain()) {
					$aWebsite->setURL($_POST["website"]);
					$aWebsite->writeToPersistence();
					$aWebsite->writeRootRedirection();
				}
			}
		}
		//go to next step
		$step = 5;
	}
}

// +----------------------------------------------------------------------+
// | STEP 5 : CHMOD Constants                                             |
// +----------------------------------------------------------------------+

if ($step == 5) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "chmodConstants") {
		//Params
		if (!$_POST["fileChmod"]) {
			$error .= $error_step5_perms_files.'<br />';
		} else {
			if ($_POST["fileChmod"] != FILES_CHMOD) {
				//add file chmod value to config.php file
				$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
				$configFileContent = $configFile->readContent("array","rtrim");
				$skip = false;
				foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
					if (strpos($aLineOfConfigFile, "FILES_CHMOD") !== false) {
						$configFileContent[$lineNb] = 'define("FILES_CHMOD", "'.$_POST["fileChmod"].'");';
						$skip = true;
					}
				}
				if (!$skip) {
					$configFileContent[sizeof($configFileContent)-1] = 'define("FILES_CHMOD", "'.$_POST["fileChmod"].'");';
					$configFileContent[sizeof($configFileContent)] = '?>';
				}
				$configFile->setContent($configFileContent);
				$configFile->writeToPersistence();
			}
		}
		if (!$_POST["dirChmod"]) {
			$error .= $error_step5_perms_dirs.'<br />';
		} else {
			if ($_POST["dirChmod"] != DIRS_CHMOD) {
				//add directory chmod value to config.php file
				$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
				$configFileContent = $configFile->readContent("array","rtrim");
				$skip = false;
				foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
					if (strpos($aLineOfConfigFile, "DIRS_CHMOD") !== false) {
						$configFileContent[$lineNb] = 'define("DIRS_CHMOD", "'.$_POST["dirChmod"].'");';
						$skip = true;
					}
				}
				if (!$skip) {
					$configFileContent[sizeof($configFileContent)-1] = 'define("DIRS_CHMOD", "'.$_POST["dirChmod"].'");';
					$configFileContent[sizeof($configFileContent)] = '?>';
				}
				$configFile->setContent($configFileContent);
				$configFile->writeToPersistence();
			}
		}
	}
	
	if (($error || $_POST["cms_action"] != "chmodConstants") && function_exists("chmod")) {
		//Check file creation with default permissions
		@touch($_SERVER['DOCUMENT_ROOT'].'/testfile.php');
		$stat = @stat($_SERVER['DOCUMENT_ROOT'].'/testfile.php');
		$fileChmod = substr(decoct($stat['mode']),-4,4);
		@unlink($_SERVER['DOCUMENT_ROOT'].'/testfile.php');
		
		//Check directory creation with default permissions
		@mkdir($_SERVER['DOCUMENT_ROOT'].'/testdir');
		$stat = @stat($_SERVER['DOCUMENT_ROOT'].'/testdir');
		$dirChmod = substr(decoct($stat['mode']),-4,4);
		@rmdir($_SERVER['DOCUMENT_ROOT'].'/testdir');
		
		$title = '<h1>'.$step5_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="5" />
			<input type="hidden" name="cms_action" value="chmodConstants" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			'.$step5_explanation.'<br /><br />
			'.$step5_files_perms.' * : <input type="text" name="fileChmod" value="'.$fileChmod.'" /><br />
			'.$step5_dirs_perms.' * : <input type="text" name="dirChmod" value="'.$dirChmod.'" /><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} else {
		
		//reload page (to include new config.php file) and go to next step
		header("Location: ".$_SERVER["PHP_SELF"]."?step=6&install_language=".$install_language);
		exit;
	}
}

// +----------------------------------------------------------------------+
// | STEP 6 : Choose Regeneration method                                  |
// +----------------------------------------------------------------------+

if ($step == 6) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "regenerator") {
		//Params
		if (!$_POST["regenerator"]) {
			$error .= $error_step6_choose_option.'<br />';
		}
	}
	
	if ($error || $_POST["cms_action"] != "regenerator") {
		$title = '<h1>'.$step6_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="6" />
			<input type="hidden" name="cms_action" value="regenerator" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			'.$step6_explanation.'
			<label for="popup"><input id="popup" type="radio" name="regenerator" value="1" checked="checked" /> '.$step6_popup.'</label><br />
			<label for="cli"><input id="cli" type="radio" name="regenerator" value="2" /> '.$step6_bg.'</label><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} else {
		//set values in standard_rc.xml file
		$module = CMS_modulesCatalog::getByCodename('standard');
		$moduleParameters = $module->getParameters(false,true);
		if ($_POST["regenerator"] == 1) {
			$moduleParameters['USE_BACKGROUND_REGENERATOR'][0] = 0;
		} else {
			$moduleParameters['USE_BACKGROUND_REGENERATOR'][0] = 1;
		}
		$module->setAndWriteParameters($moduleParameters);
		
		//go to next step
		$step = 7;
	}
}

// +----------------------------------------------------------------------+
// | STEP 7 : Regenerator parameters                                      |
// +----------------------------------------------------------------------+

if ($step == 7) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "regeneratorParams") {
		//get values in standard_rc.xml file
		$module = CMS_modulesCatalog::getByCodename('standard');
		$moduleParameters = $module->getParameters(false,true);
		
		// CLI path
		if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 && !$_POST["cliPath"]) {
			$error .= $error_step7_CLI_path.'<br />';
		} else {
			$cliPath = $_POST["cliPath"];
			if ($_SERVER["WINDIR"] || $_SERVER["windir"]) {
				//add CLI path to config.php file
				$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
				$configFileContent = $configFile->readContent("array","rtrim");
				$skip = false;
				foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
					if (strpos($aLineOfConfigFile, "PATH_PHP_CLI_WINDOWS") !== false) {
						$configFileContent[$lineNb] = 'define("PATH_PHP_CLI_WINDOWS", "'.$cliPath.'");';
						$skip = true;
					}
				}
				if (!$skip) {
					$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_CLI_WINDOWS", "'.$cliPath.'");';
					$configFileContent[sizeof($configFileContent)] = '?>';
				}
				$configFile->setContent($configFileContent);
				$configFile->writeToPersistence();
			} else {
				//add CLI path to all scripts php files
				$scriptsFiles = CMS_file::getFileList(PATH_PACKAGES_FS.'/scripts/*.php');
				foreach ($scriptsFiles as $aScriptFile) {
					$scriptFile = new CMS_file($aScriptFile["name"]);
					$scriptFileContent = $scriptFile->readContent("array","rtrim");
					//check if file is a script (search start of bang line)
					if (strpos($scriptFileContent[0], "#!") !== false) {
						//then set the new bang line
						$scriptFileContent[0] = '#!'.$cliPath.' -q';
						$scriptFile->setContent($scriptFileContent);
						$scriptFile->writeToPersistence();
						//then set it executable
						CMS_file::makeExecutable($aScriptFile["name"]);
					}
				}
			}
		}
		
		//CHMOD scripts with good values
		$scriptsFiles = CMS_file::getFileList(PATH_PACKAGES_FS.'/scripts/*.php');
		foreach ($scriptsFiles as $aScriptFile) {
			@chmod($aScriptFile["name"], octdec(DIRS_CHMOD));
		}
		
		//Temporary path (if needed)
		if ($_POST["needTmpPath"] && !$_POST["tmpPath"]) {
			$error .= $error_step7_tmp_path.'<br />';
		} elseif ($_POST["needTmpPath"]) {
			//check tmpPath
			$tmpPathOK = false;
			if (@is_dir($_POST["tmpPath"]) && is_object(@dir($_POST["tmpPath"]))) {
				$tmpPath = $_POST["tmpPath"];
				$tmpPathOK = true;
			} else {
				@mkdir($_POST["tmpPath"]);
				if (@is_dir($_POST["tmpPath"]) && is_object(@dir($_POST["tmpPath"]))) {
					$tmpPath = $_POST["tmpPath"];
					$tmpPathOK = true;
				}
			}
			if ($tmpPathOK) {
				if ($_SERVER["WINDIR"] || $_SERVER["windir"]) {
					$tmpPath .= '\\\\';
				}
				//add tmp path to config.php file
				$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
				$configFileContent = $configFile->readContent("array","rtrim");
				$skip = false;
				foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
					if (strpos($aLineOfConfigFile, "PATH_PHP_TMP") !== false) {
						$configFileContent[$lineNb] = 'define("PATH_PHP_TMP", "'.$tmpPath.'");';
						$skip = true;
					}
				}
				if (!$skip) {
					$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_TMP", "'.$tmpPath.'");';
					$configFileContent[sizeof($configFileContent)] = '?>';
				}
				$configFile->setContent($configFileContent);
				$configFile->writeToPersistence();
			} else {
				$error .= $error_step7_valid_tmp_path.'<br />';
			}
		}
	}
	
	if ($error || $_POST["cms_action"] != "regeneratorParams") {
		//get values in standard_rc.xml file
		$module = CMS_modulesCatalog::getByCodename('standard');
		$moduleParameters = $module->getParameters(false,true);
		
		//found CLI path
		if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1) {
			if ($_SERVER["WINDIR"] || $_SERVER["windir"]) {
				$cliPath = ($_POST["cliPath"]) ? $_POST["cliPath"] : PATH_PHP_CLI_WINDOWS;
			} else {
				$regeneratorFile = new CMS_file(PATH_PACKAGES_FS.'/scripts/regenerator.php');
				$regeneratorContent = $regeneratorFile->readContent("array","rtrim");
				$unixCliPath = trim(str_replace("#!","",str_replace("-q","", $regeneratorContent[0])));
				$cliPath = ($_POST["cliPath"]) ? $_POST["cliPath"] : $unixCliPath;
			}
		}
		//test temporary directory and create it if none founded
		$tmpPath ='';
		if (@is_dir(ini_get("session.save_path")) && is_object(@dir(ini_get("session.save_path")))) {
			$tmpPath = ini_get("session.save_path");
		} elseif (@is_dir(PATH_PHP_TMP) && is_object(@dir(PATH_PHP_TMP))) {
			$tmpPath = PATH_PHP_TMP;
		} else {
			@mkdir($_SERVER['DOCUMENT_ROOT']."/tmp");
			if (@is_dir($_SERVER['DOCUMENT_ROOT']."/tmp") && is_object(@dir($_SERVER['DOCUMENT_ROOT']."/tmp"))) {
				$tmpPath = $_SERVER['DOCUMENT_ROOT']."/tmp";
				
				if ($_SERVER["WINDIR"] || $_SERVER["windir"]) {
					$tmpPath .= '\\\\';
				}
				//add tmp path to config.php file
				$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
				$configFileContent = $configFile->readContent("array","rtrim");
				$skip = false;
				foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
					if (strpos($aLineOfConfigFile, "PATH_PHP_TMP") !== false) {
						$configFileContent[$lineNb] = 'define("PATH_PHP_TMP", "'.$tmpPath.'");';
						$skip = true;
					}
				}
				if (!$skip) {
					$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_TMP", "'.$tmpPath.'");';
					$configFileContent[sizeof($configFileContent)] = '?>';
				}
				$configFile->setContent($configFileContent);
				$configFile->writeToPersistence();
			} else {
				$tmpPath ='';
			}
		}
		if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 || !$tmpPath) {
			$title = '<h1>'.$step7_title.'</h1>';
			if ($error) {
				$content .= '<span class="error">'.$error.'</span><br />';
			}
			$content .= '
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<input type="hidden" name="step" value="7" />
				<input type="hidden" name="cms_action" value="regeneratorParams" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />
				<input type="hidden" name="regenerationMethod" value="'.$moduleParameters['USE_BACKGROUND_REGENERATOR'][0].'" />';
				if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1) {
					$content .= '
					'.$step7_CLI_explanation.'<br /><br />
					'.$step7_CLI.'  : <input type="text" name="cliPath" value="'.$cliPath.'" /><br />';
				}
				if (!$tmpPath) {
					$content .= '
					<hr />
					'.$step7_tmp_path_explanation.'<br /><br />
					'.$step7_tmp_path.'  : <input type="text" name="tmpPath" value="" /><input type="hidden" name="needTmpPath" value="1" /><br /><br />
					';
				}
			$content .= '
				<input type="submit" class="submit" value="'.$label_next.'" />
			</form>
			';
		} else {
			//go to next step
			$step = 8;
		}
	} else {
		
		//go to next step
		$step = 8;
	}
}

// +----------------------------------------------------------------------+
// | STEP 8 : Sessions & htaccess files                                   |
// +----------------------------------------------------------------------+

if ($step == 8) {
	$error ='';
	
	//check for errors
	if ($_POST["cms_action"] == "finalisation") {
		
		//Application Label
		if (!$_POST["label"]) {
			$error .= $error_step8_label.'<br />';
		} else {
			//set values in standard_rc.xml file
			$module = CMS_modulesCatalog::getByCodename('standard');
			$moduleParameters = $module->getParameters(false,true);
			$moduleParameters['APPLICATION_LABEL'][0] = $_POST["label"];
			$module->setAndWriteParameters($moduleParameters);
			
			//change root page Name
			//in edited table
			$sql = "
				update
					pagesBaseData_edited 
				set
					title_pbd = '".sensitiveIO::sanitizeSQLString($_POST["label"])."',
					linkTitle_pbd = '".sensitiveIO::sanitizeSQLString($_POST["label"])."'
				where
					page_pbd = '1'
			";
			$q = new CMS_query($sql);
			//in public table
			$sql = "
				update
					pagesBaseData_public
				set
					title_pbd = '".sensitiveIO::sanitizeSQLString($_POST["label"])."',
					linkTitle_pbd = '".sensitiveIO::sanitizeSQLString($_POST["label"])."'
				where
					page_pbd = '1'
			";
			$q = new CMS_query($sql);
		}
		
		//modify .htaccess files for Free.fr
		//temporary useless : free is on PHP5 : incompatible for now
		/*if ($_POST["freeHosting"] == 1) {
			//search .htaccess files for modules
			$htaccessFiles = CMS_file::getFileList($_SERVER['DOCUMENT_ROOT'].'/automne_modules_files/*.htaccess');
			//define known .htaccess files (can't search them because it's overide memory limit on Free)
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne/admin/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne/phpMyAdmin/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne/templates/images/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne_bin/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/automne_linx_files/.htaccess';
			$htaccessFiles[]["name"] = $_SERVER['DOCUMENT_ROOT'].'/sql/.htaccess';
			
			foreach ($htaccessFiles as $aHtaccessFile) {
				$htaccessFile = new CMS_file($aHtaccessFile["name"]);
				$htaccessFileContent = $htaccessFile->readContent();
				//check wich type of htacces it is
				if (strpos($htaccessFileContent, "LimitExcept ") !== false) {
					//then set the new content
					$htaccessFileContent = 'allow from all';
					$htaccessFile->setContent($htaccessFileContent);
					$htaccessFile->writeToPersistence();
				} elseif (strpos($htaccessFileContent, "Limit ") !== false) {
					//then set the new content
					$htaccessFileContent = 'deny from all';
					$htaccessFile->setContent($htaccessFileContent);
					$htaccessFile->writeToPersistence();
				}
			}
		}*/
		
		//No application email
		if ($_POST["no_application_email"] == 1)  {
			//set values in standard_rc.xml file
			$module = CMS_modulesCatalog::getByCodename('standard');
			$moduleParameters = $module->getParameters(false,true);
			$moduleParameters['NO_APPLICATION_MAIL'][0] = 1;
			$module->setAndWriteParameters($moduleParameters);
		}
		
		//Change resources creation date to force all regenerations at first launch
		$sql = "
			update
				resourceStatuses
			set
				publicationDateStart_rs = NOW(),
				publication_rs = '1'
			where
				publication_rs = '2'
		";
		$q = new CMS_query($sql);
		
		//change default user language
		if ($install_language == 'en') {
			$sql = "
				update
					profilesUsers
				set
					language_pru = 'en'
				where
					login_pru = 'root'
			";
		} else {
			$sql = "
				update
					profilesUsers
				set
					language_pru = 'fr'
				where
					login_pru = 'root'
			";
		}
		$q = new CMS_query($sql);
		
		//CHMOD index.php and config.php with new values
		@chmod($_SERVER['DOCUMENT_ROOT'].'/index.php', octdec(FILES_CHMOD));
		@chmod($_SERVER['DOCUMENT_ROOT'].'/config.php', octdec(FILES_CHMOD));
	}
	
	//Check sessions creation
	$session = true;
	if (function_exists("session_start")) {
		@error_reporting(0);
		if (!@is_dir(ini_get("session.save_path"))) {
			@mkdir(ini_get("session.save_path"));
		}
		if (!@session_start()) {
			$session = false;
		}
		@error_reporting(E_ALL ^ E_NOTICE);
	} else {
		$session = false;
	}
	if ($session == false) {
		$error .= $error_step8_sessions.'<br />';
	}
	
	//SMTP Test
	if (!$_POST["no_application_email"]) {
		$no_email = false;
		if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
			$error .= $error_step8_smtp_error.'<br />';
			$no_application_email = true;
		}
	}
	if ($error || $_POST["cms_action"] != "finalisation") {
		$title = '<h1>'.$step8_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="8" />
			<input type="hidden" name="cms_action" value="finalisation" />
			<input type="hidden" name="install_language" value="'.$install_language.'" />
			'.$step8_CLI_explanation.'<br /><br />
			<!--<label for="freeHosting"><input type="checkbox" id="freeHosting" name="freeHosting" value="1" /> '.$step8_freefr.'</label><br />-->';
			if ($no_application_email) {
				$content .= '<br /><label for="no_application_email"><input type="checkbox" id="no_application_email" name="no_application_email" value="1" /> '.$step8_no_application_email.'</label><br />';
			}
			$content .= '
			<br />
			'.$step8_application_label.'<br /><br />
			'.$step8_label.' *  : <input type="text" name="label" value="Automne" /><br />
			<input type="submit" class="submit" value="'.$label_next.'" />
		</form>
		';
	} else {
		
		//go to next step
		$step = 9;
	}
}

// +----------------------------------------------------------------------+
// | STEP 9 : Installation Done                                           |
// +----------------------------------------------------------------------+

if ($step == 9) {
	$title = '<h1>'.$step9_title.'</h1>';
	$content .= sprintf($step9_alldone,CMS_websitesCatalog::getMainURL(),CMS_websitesCatalog::getMainURL());
}

// +----------------------------------------------------------------------+
// | RENDERING                                                            |
// +----------------------------------------------------------------------+

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Automne :: Installation</title>
	<style type="text/css" media="screen">
		body {
			font-family:		verdana,arial,helvetica;
			font-size:			11px;
			color: 				#4d4d4d;
			background-color:	#FFFFFF;
			margin-left:		0px;
			margin-top:			0px;
			margin-right:		0px;
			margin-bottom:		0px;
		}
		form {
			margin:				0px;
			padding: 			0px;
		}
		h1 {
			margin:				0px;
			margin-top:			30px;
			margin-bottom:		30px;
			padding:			10px;
			padding-left:		60px;
			border-bottom:		1px dashed #000000;
			border-top:			1px dashed #000000;
			background-color: 	#EDECEB;
			font-family:		verdana,arial,helvetica;
			color:				#796B67;
			font-size:			15px;
		}
		.error {
			font-family:		verdana,arial,helvetica;
			color:				red;
			font-size:			11px;
			font-weight:		bold;
		}
		input {
			font-family:		verdana,arial,helvetica;
			font-size:			10px; 
		}
		input.submit {
			cursor: 			pointer;
			border: 			0px;
			padding: 			2px;
			color:				#FFFFFF;
			height: 			20px;
			background-color:	#ABD64A;
			background-image: 	url(/automne/admin/img/boutonOn.gif);
			background-position:top-left;
			background-repeat: 	no-repeat;
			float:				right;
		}
		div.contener {
			width:				60%;
			margin:				0 auto 0 auto;
			padding: 			20px;
			top:				0px;
			display: 			block;
			border:				1px dashed #FB7A35;
			background-color:	#FFFFFF;
		}
		hr {
			border-top: 		1px solid #FFFFFF;
			border-bottom: 		1px dashed #FB7A35;
			margin: 			0 0 0 0;
			padding: 			0;
		}
		#logo {
			position:			absolute;
			right:				100px;
			top:				0px;
			background-image: 	url(/automne/admin/img/logo.gif);
			height:				72px;
			width:				138px;
		}
		A {
			color:#598503;
			font-size:11px;
			text-decoration:none
		}
		.license {
			width:100%;
			height:250px;
			overflow:scroll;
			padding:10px;
			margin:10px 0  10px 0;
			float:left;
			background-color:#EFF8CF;
		}
	</style>
</head>
<body onLoad="initJavascript();">
<!-- javascriptCheck usefull initialisation javascript functions -->
<script language="JavaScript" type="text/javascript">
	function initJavascript() {
		makeFocus();
	}
	function makeFocus() {
		for (var j=\'0\'; j < document.forms.length; j++) {
			if (document.forms[j]!=null) {
				for (var i=\'0\'; i < document.forms[j].length; i++) {
					if (document.forms[j].elements[i].type == "text" || document.forms[j].elements[i].type == "textarea") {
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
	}
	function check() {
		buttonDisable();
		window.setTimeout("buttonEnable()",15000);
	}
	function buttonDisable() {
		for (var j=\'0\'; j < document.forms.length; j++) {
			if (document.forms[j]!=null) {
				for (var i=\'0\'; i < document.forms[j].length; i++) {
					if (document.forms[j].elements[i].type == "submit" || document.forms[j].elements[i].type == "button") {
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
</script>
<div id="logo">&nbsp;</div>
'.$title.'
<div class="contener">
	'.$content;
if (!$extractArchive) {
	echo '
		</div>
		</body>
		</html>
	';
} else {
	$archive->extract_files();
	$content = '<br />';
	if (!$archive->hasError()) {
		$content .= $step1_extraction_ok.'<br />';
	} else {
		$error .= sprintf($step1_extraction_error,$archiveFile).'<br />';
	}
	unset($archive);
	if ($error) {
		$content .= '<span class="error">'.$error.'</span><br />';
	}
	$content .= '
	<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
		<input type="hidden" name="step" value="gpl" />
		<input type="hidden" name="install_language" value="'.$install_language.'" />';
	if (!$error) {
		$content .= '<input type="submit" class="submit" value="'.$label_next.'" />';
	}
	$content .= '
	</form>
	';
	
	echo $content.'
		</div>
		</body>
		</html>
	';
}
// +----------------------------------------------------------------------+
// | Installation Classes & Functions                                     |
// +----------------------------------------------------------------------+

//Usefull function to dump a var.
function pr_install($data)
{
	$content .= "<pre>";
	print_r($data);
	$content .= "</pre>";
	flush();
}
/**
  * Class CMS_archive_install, CMS_tar_file_install, CMS_gzip_file_install
  *
  * This script manages TAR/GZIP/BZIP2/ZIP archives
  *
  * Based on an original script "TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.0"
  * from Devin Doucette mentionned in copyright
  *
  * @package CMS
  * @subpackage files
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Devin Doucette <darksnoopy@shaw.ca>
  */
class CMS_archive_install
{
	/**
	 * Stores raw data in this var
	 * @var string
	 */
	var $CMS_archive;
	/**
	 * All options about this archive:
	 * @var mixed array
	 * @access public
	 */
	var $options = array ();
	/**
	 * All files managed when processing the archive
	 * @var array
	 * @access public
	 */
	var $files = array ();
	/**
	 * Contains files not to be stored into archive
	 * @var array
	 * @access public
	 */
	var $exclude = array ();
	/**
	 * Contains files to be stored into archive
	 * @var array
	 * @access public
	 */
	var $storeonly = array ();
	/**
	  * True if this object has raised an error.
	  * @var boolean
	  * @access private
	  */
	var $_errRaised = false;
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function CMS_archive_install($name) {
		if (trim($name) == '') {
			$this->_raiseError(get_class($this)." : Not a valid name given to archive ".$name);
			return;
		}
		$this->options = array (
			'basedir' => ".",
			'name' => $name,
			'prepend' => "", 
			'inmemory' => 0, 
			'overwrite' => 0,
			'recurse' => 1,
			'storepaths' => 1,
			'level' => 3,
			'method' => 1,
			'sfx' => "",
			'type' => "",
			'comment' => ""
		);
	}
	/**
	  * Raises an error. Shows it to the screen
	  *
	  * @param string $errorMessage the error message.
	  * @return void
	  * @access private
	  */
	function _raiseError($errorMessage)
	{
		echo "<br /><pre><b>AUTOMNE INSTALLATION PROCESS error : ".$errorMessage."".$backTrace."</b></pre><br />\n";
		flush();
		$this->_errRaised = true;
	}
	/**
	  * Returns true if this instance has already raised an error.
	  *
	  * @return boolean true if an error was raised by this instance, false otherwise.
	  * @access public
	  */
	function hasError()
	{
		return $this->_errRaised;
	}
	/**
	 * Sets options array to this archive
	 * 
	 * @var mixed array, @see $options attributes for details
	 * @return void
	 */
	function set_options($options) {
		if (is_array($options)) {
			foreach ($options as $key => $value) {
				$this->options[$key] = $value;
			}
			if (!empty ($this->options['basedir'])) {
				$this->options['basedir'] = str_replace("\\", "/", $this->options['basedir']);
				$this->options['basedir'] = preg_replace("/\/+/", "/", $this->options['basedir']);
				$this->options['basedir'] = preg_replace("/\/$/", "", $this->options['basedir']);
			}
			if (!empty ($this->options['name'])) {
				$this->options['name'] = str_replace("\\", "/", $this->options['name']);
				$this->options['name'] = preg_replace("/\/+/", "/", $this->options['name']);
			}
			if (!empty ($this->options['prepend'])) {
				$this->options['prepend'] = str_replace("\\", "/", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/^(\.*\/+)+/", "", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/\/+/", "/", $this->options['prepend']);
				$this->options['prepend'] = preg_replace("/\/$/", "", $this->options['prepend'])."/";
			}
		} else {
			$this->_raiseError("CMS_archive : set_option : Not a valid optins array given");
		}
	}
	/**
	 * Build list of all files to manage respecting stored files and
	 * those to exlude
	 * 
	 * @return void
	 */
	function make_list() {
		if (!empty ($this->exclude)) {
			foreach ($this->files as $key => $value) {
				foreach ($this->exclude as $current) {
					if ($value['name'] == $current['name']) {
						unset ($this->files[$key]);
					}
				}
			}
		}
		if (!empty ($this->storeonly)) {
			foreach ($this->files as $key => $value) {
				foreach ($this->storeonly as $current) {
					if ($value['name'] == $current['name']) {
						$this->files[$key]['method'] = 0;
					}
				}
			}
		}
		unset($this->exclude, $this->storeonly);
	}
	/**
	 * List files of archive and sort them with sort_files method
	 * 
	 * @param array $list, all files to list in an array 
	 * @return array, files to list
	 */
	function list_files($list) {
		if (!is_array($list)) {
			$temp = $list;
			$list = array ($temp);
			unset ($temp);
		}
		$files = array ();
		$pwd = getcwd();
		chdir($this->options['basedir']);
		foreach ($list as $current) {
			$current = str_replace("\\", "/", $current);
			$current = preg_replace("/\/+/", "/", $current);
			$current = preg_replace("/\/$/", "", $current);
			if (strstr($current, "*")) {
				$regex = preg_replace("/([\\\^\$\.\[\]\|\(\)\?\+\{\}\/])/", "\\\\\\1", $current);
				$regex = str_replace("*", ".*", $regex);
				$dir = strstr($current, "/") ? substr($current, 0, strrpos($current, "/")) : ".";
				$temp = $this->parse_dir($dir);
				foreach ($temp as $current2) {
					if (preg_match("/^{$regex}$/i", $current2['name'])) {
						$files[] = $current2;
					}
				}
				unset ($regex, $dir, $temp, $current);
			} elseif (@ is_dir($current)) {
				$temp = $this->parse_dir($current);
				foreach ($temp as $file) {
					$files[] = $file;
				}
				unset ($temp, $file);
			} elseif (@ file_exists($current)) {
				$files[] = array ('name' => $current, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($current, "/")) ? substr($current, strrpos($current, "/") + 1) : $current), 'type' => 0, 'ext' => substr($current, strrpos($current, ".")), 'stat' => stat($current));
			}
		}
		chdir($pwd);
		unset ($current, $pwd);
		usort($files, array ("CMS_archive", "sort_files"));
		return $files;
	}
	/**
	 * Parse a directory to get its content
	 *  
	 * @param string $dirname, name of the directory to parse
	 * @return array $files founded in the directory
	 */
	function parse_dir($dirname) {
		if ($this->options['storepaths'] == 1 && !preg_match("/^(\.+\/*)+$/", $dirname)) {
			$files = array (array ('name' => $dirname, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname, "/")) ? substr($dirname, strrpos($dirname, "/") + 1) : $dirname), 'type' => 5, 'stat' => stat($dirname)));
		} else {
			$files = array ();
		}
		$dir = @opendir($dirname);
		while ($file = @readdir($dir)) {
			if ($file == "." || $file == "..") {
				continue;
			} elseif (@is_dir($dirname."/".$file)) {
				if (empty ($this->options['recurse'])) {
					continue;
				}
				$temp = $this->parse_dir($dirname."/".$file);
				foreach ($temp as $file2) {
					$files[] = $file2;
				}
			} elseif (@file_exists($dirname."/".$file)) {
				$files[] = array ('name' => $dirname."/".$file, 'name2' => $this->options['prepend'].preg_replace("/(\.+\/+)+/", "", ($this->options['storepaths'] == 0 && strstr($dirname."/".$file, "/")) ? substr($dirname."/".$file, strrpos($dirname."/".$file, "/") + 1) : $dirname."/".$file), 'type' => 0, 'ext' => substr($file, strrpos($file, ".")), 'stat' => stat($dirname."/".$file));
			}
		}
		@closedir($dir);
		return $files;
	}
	/**
	 * Sorts files
	 * 
	 * @param string $a
	 * @param  string $b
	 * @return integer, 0 if nothing sorted
	 */
	function sort_files($a, $b) {
		if ($a['type'] != $b['type']) {
			return $a['type'] > $b['type'] ? -1 : 1;
		} elseif ($a['type'] == 5) {
			return strcmp(strtolower($a['name']), strtolower($b['name']));
		} else {
			if ($a['ext'] != $b['ext']) {
				return strcmp($a['ext'], $b['ext']);
			} elseif ($a['stat'][7] != $b['stat'][7]) {
				return $a['stat'][7] > $b['stat'][7] ? -1 : 1;
			} else {
				return strcmp(strtolower($a['name']), strtolower($b['name']));
			}
		}
		return 0;
	}
}

class CMS_tar_file_install extends CMS_archive_install
{
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function CMS_tar_file_install($name)
	{
		if (trim($name) == '') {
			$this->_raiseError(get_class($this)." : Not a valid name given to archive ".$name);
			return;
		}
		$this->CMS_archive_install($name);
		$this->options['type'] = "tar";
	}
	/**
	 * Extract files from the archive
	 * 
	 * @return true on success
	 */
	function extract_files() 
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);
		
		if ($fp = $this->open_archive()) {
			if ($this->options['inmemory'] == 1) {
				$this->files = array ();
			}
			while ($block = fread($fp, 512)) {
				$temp = unpack("a100name/a8mode/a8uid/a8gid/a12size/a12mtime/a8checksum/a1type/a100temp/a6magic/a2temp/a32temp/a32temp/a8temp/a8temp/a155prefix/a12temp", $block);
				$file = array ('name' => $temp['prefix'].$temp['name'], 'stat' => array (2 => $temp['mode'], 4 => octdec($temp['uid']), 5 => octdec($temp['gid']), 7 => octdec($temp['size']), 9 => octdec($temp['mtime']),), 'checksum' => octdec($temp['checksum']), 'type' => $temp['type'], 'magic' => $temp['magic'],);
				if ($file['checksum'] == 0x00000000) {
					break;
				} else
					/*if ($file['magic'] != "ustar") {
						$this->_raiseError(get_class($this)." : extract_files : This script does not support extracting this type of tar file.");
						break;
					}*/
				$block = substr_replace($block, "        ", 148, 8);
				$checksum = 0;
				for ($i = 0; $i < 512; $i ++) {
					$checksum += ord(substr($block, $i, 1));
				}
				if ($file['checksum'] != $checksum) {
					$this->_raiseError(get_class($this)." : extract_files : Could not extract from {$this->options['name']}, it is corrupt.");
				}
				if ($this->options['inmemory'] == 1) {
					$file['data'] = @fread($fp, $file['stat'][7]);
					@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					unset ($file['checksum'], $file['magic']);
					$this->files[] = $file;
				} else {
					if ($file['type'] == 5) {
						if (!is_dir($file['name'])) {
							
							if (!$this->options['dontUseFilePerms']) {
								@mkdir($file['name'], $file['stat'][2]);
								@chown($file['name'], $file['stat'][4]);
								@chgrp($file['name'], $file['stat'][5]);
							} else {
								@mkdir($file['name']);
							}
						}
					} else
						if ($this->options['overwrite'] == 0 && file_exists($file['name'])) {
							$this->_raiseError(get_class($this)." : extract_files : {$file['name']} already exists.");
						} else
							if ($new = @fopen($file['name'], "wb")) {
								@fwrite($new, @fread($fp, $file['stat'][7]));
								@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
								@fclose($new);
								if (!$this->options['dontUseFilePerms']) {
									@chmod($file['name'], $file['stat'][2]);
									@chown($file['name'], $file['stat'][4]);
									@chgrp($file['name'], $file['stat'][5]);
								}
								//need to send datas to browser else we can loose connection ...
								echo $file['name']." done ...<br />";
							} else {
								$this->_raiseError(get_class($this)." : extract_files : Could not open {$file['name']} for writing.");
							}
				}
				unset ($file);
			}
		} else {
			$this->_raiseError(get_class($this)." : extract_files : Could not open file {$this->options['name']}");
		}
		chdir($pwd);
		return true;
	}
	/**
	 * Opens archive by opening/decompressing file
	 * 
	 * @return true on success, false on failure
	 */
	function open_archive()
	{
		return @fopen($this->options['name'], "rb");
	}
}

class CMS_gzip_file_install extends CMS_tar_file_install
{
	/**
	 * Constructor
	 * 
	 * @param string $name, the full filename of the archive
	 * @return void
	 */
	function CMS_gzip_file($name)
	{
		if (trim($name) == '') {
			$this->_raiseError(get_class($this)." : Not a valid name given to archive ".$name);
			return;
		}
		$this->CMS_tar_file_install($name);
		$this->options['type'] = "gzip";
	}
	/**
	 * Opens archive by opening/decompressing file
	 * 
	 * @return true on success, false on failure
	 */
	function open_archive() {
		return @gzopen($this->options['name'], "rb");
	}
}
?>