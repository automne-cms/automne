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
// $Id: install.php,v 1.19 2009/06/26 14:01:24 sebastien Exp $

/**
  * PHP page : Automne Installation Manager
  * 
  * @package CMS
  * @subpackage installation
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Remove notices
error_reporting(E_ALL);
@set_time_limit(0);
ini_set("memory_limit" , "64M");
//try to remove magic quotes
@ini_set('magic_quotes_gpc', 0);
@ini_set('magic_quotes_runtime', 0);
@ini_set('magic_quotes_sybase', 0);
//try to change some misconfigurations
@ini_set('session.gc_probability', 0);
@ini_set('allow_call_time_pass_reference', 0);
/**
  *	Path of the REAL document root
  *	Default : $_SERVER["DOCUMENT_ROOT"]
  */
if ($_SERVER["DOCUMENT_ROOT"] != dirname(__FILE__)) {
	//rewrite server document root if needed
	$_SERVER["DOCUMENT_ROOT"] = dirname(__FILE__);
}

if (!isset($_GET['file'])) {
	//Installation languages
	$install_language = (isset($_REQUEST["install_language"])) ? $_REQUEST["install_language"]:'';
	$accepted_languages = array('en','fr');
	$install_language = (in_array($install_language , $accepted_languages) === true) ? $install_language : '';
	
	//Current installation step
	$step = (isset($_REQUEST["step"])) ? $_REQUEST["step"]:'check';
	$accepted_step = array('0','1','2','3','4','5','6','7','8','9','gpl','check');
	$step = (in_array($step , $accepted_step) === true) ? $step:'check';
	
	$cms_action = isset($_POST["cms_action"]) ? $_POST["cms_action"] : '';
	
	$content = $title = $error = '';
	
	// +----------------------------------------------------------------------+
	// | STEP 0 : Installation language                                       |
	// +----------------------------------------------------------------------+
	if ($install_language == '') {
		$title = '<h1>Langue d\'installation / Installation language:</h1>';
		$footer = '';
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="'.$step.'" />
			Veuillez choisir votre langue d\'installation.<br />
			Please choose your installation language.<br /><br />
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
			$footer = 'Installation d\'Automne version 4. Pour toute information, visitez <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.';
			
			//STEP check
			$error_stepCheck_php_error = 'Erreur, Votre version de PHP ('.phpversion().') n\'est pas compatible avec Automne. Vous devez avoir une version supérieure à la 5.2.0.';
			$error_stepCheck_dir_not_writable_error = 'Erreur, Apache ne possède pas les droits d\'écriture sur le répertoire racine (%s) de votre site web.';
			$error_stepCheck_safe_mode_error = 'Attention ! L\'option "safe_mode" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. Vérifiez votre installation de PHP.';
			$error_stepCheck_magic_quotes_error = 'Attention ! L\'option "magic_quotes_gpc" est active sur votre configuration de PHP. Cette option est fortement déconseillée car l\'ensemble des fonctions d\'Automne ne seront pas disponibles et/ou leurs fonctionnement sera dégradé.';
			$error_stepCheck_magic_quotes_runtime_error = 'Attention ! L\'option "magic_quotes_runtime" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. Vérifiez votre installation de PHP.';
			$error_stepCheck_magic_quotes_sybase_error = 'Attention ! L\'option "magic_quotes_sybase" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. Vérifiez votre installation de PHP.';
			$error_stepCheck_register_globals_error = 'Attention ! L\'option "register_globals" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. Vérifiez votre installation de PHP.';
			$error_stepCheck_gd_error = 'Erreur, l\'extension GD n\'est pas installée sur votre serveur. Vérifiez votre installation de PHP.';
			$error_stepCheck_gd_gif_error = 'Erreur, les fonctionnalités de traitement d\'images GIF ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
			$error_stepCheck_gd_jpeg_error = 'Erreur, les fonctionnalités de traitement d\'images JPEG ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
			$error_stepCheck_gd_png_error = 'Erreur, les fonctionnalités de traitement d\'images PNG ne sont pas installées (Extension GD). Vérifiez votre installation de PHP.';
			$error_stepCheck_memory_limit_error = 'Erreur, l\'utilisation mémoire des scripts PHP ne peut être modifiée et elle est limitée à %so. Veuillez modifier votre configuration pour allouer un minimum de 64Mo de mémoire ou bien pour laisser les scripts PHP choisir leur utilisation mémoire.';
			$stepCheck_title = 'Compatibilité de votre système :';
			$stepCheck_installation_stopped = 'Vous ne pouvez poursuivre l\'installation d\'Automne ...<br /><br />Plus d\'information sur les hébergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			
			//STEP 1
			$error_step1_directory_not_exists = 'Erreur, Le repertoire d\'extraction n\'exise pas';
			$error_step1_cant_extract = 'Erreur, Impossible d\'extraire l\'archive %s. Format invalide...';
			$error_step1_archive_not_exists = 'Erreur, Impossible de trouver l\'archive d\'Automne à décompresser ...';
			$step1_title = 'Décompression de l\'archive :';
			$step1_extraction_to = 'Décompression de %s vers %s';
			$step1_extraction_ok = 'Décompression réalisée avec succès';
			$step1_extraction_error = 'Erreur de décompression ... Veuillez décompresser manuellement l\'archive %s dans ce repertoire et relancez l\'installation.';
			$step1_package_extraction = 'Lancer la décompression de l\'archive %s...';
			$step1_htaccess_exists = 'Durant cette décompression, Automne créera un fichier .htaccess comportant un certain nombre de configurations nécessaires.<br /><br />Actuellement un fichier .htaccess existe déjà sur le serveur. Vous en trouverez le contenu dans le champ texte ci-dessous.<br /><br />Vous pouvez modifier ou supprimer ce contenu. Ce que vous conserverez sera ajouté au fichier .htaccess d\'Automne.';
			$step1_htaccess_not_exists = 'Durant cette décompression, Automne créera un fichier .htaccess comportant un certain nombre de configurations nécessaires.<br /><br />Si votre configuration le requiert, vous pouvez ajouter du contenu à ce fichier .htaccess dans le champ texte ci-dessous.<br /><br />Ce que vous saisirez sera ajouté au fichier .htaccess d\'Automne.';
			$step1_htaccess_warning = 'Attention, toute erreur dans ce fichier pourrait provoquer une erreur 500 sur le serveur.<br /><br />Plus d\'information sur les hébergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			
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
			$error_step2_DB_connection_failed = 'Erreur, Connection à la base de données impossible :';
			$error_step2_incorrect_pass_confirm = 'Erreur, le mot de passe et sa confirmation ne correspondent pas';
			$error_step2_DB_version_not_match = 'Erreur, La version de MySQL (%s) ne correspond pas (5.0.0 minimum).';
			$error_step2_DB_cannot_get_version = 'Erreur, impossible d\'obtenir la version de MySQL.';
			$step2_title = 'Identification à la base de données:';
			$step2_explanation = 'Les informations de connection à la base de données vous sont fournies par votre hébergeur. Veillez à ce que la base que vous allez utiliser existe.';
			$step2_DB_host = 'Hôte de la base de données';
			$step2_DB_name = 'Nom de la base de données';
			$step2_DB_user = 'Utilisateur de la base de données';
			$step2_DB_password = 'Mot de passe de la base de données';
			$step2_DB_password_confirm = 'Confirmation';
			
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
			$step5_explanation = 'Automne génère un grand nombre de fichiers et de dossiers. Les droits suivant ont été detectés comme étant utilisés par votre serveur.<br /><br />Etes-vous d\'accord pour les utiliser lorsque Automne crééra des fichiers et des dossiers ?<br /><br />Attention, modifier ces droits peut entrainer des erreurs sur le serveur si ce dernier ne les acceptes pas. Modifiez ces paramètres seulement si vous savez ce que vous faites.<br /><br />Plus d\'information sur les hébergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			$step5_files_perms = 'Permissions sur les fichiers';
			$step5_dirs_perms = 'Permissions sur les dossiers';
			
			//STEP 6
			$error_step6_choose_option = 'Erreur, vous devez choisir une option ...';
			$step6_title = 'Fonctionnement des scripts :';
			$step6_explanation = 'Certaines opérations complêxes d\'Automne nécessites l\'utilisation de scripts serveurs.<br />
			Veuillez choisir la méthode d\'exécution de ces scripts :<br />
			<ul>
				<li>Par une fenêtre pop-up. Processus assez lent mais qui fonctionne sur tous les serveurs. Vous devez choisir cela sur les serveurs mutualisés (ou sur Easyphp et autres solutions n\'utilisant pas une version complète de PHP)</li>
				<li>Scripts en tache de fond. Processus rapide mais qui ne fonctionne pas sur tous les serveurs. Vous pouvez choisir cela sur les serveurs dédiés qui ont l\'exécutable PHP-CLI installé (<a href="http://fr.php.net/manual/fr/features.commandline.php" target="_blank">Utiliser PHP en ligne de commande</a>).<br /><br />Détection de la présence de PHP-CLI sur votre serveur : <span style="color:red;">%s</span></li>
			</ul>';
			$step6_CLIDetection_nosystem = 'Indisponible : Fonctions "system", "exec" et "passthru" désactivées.';
			$step6_CLIDetection_windows = 'Détection impossible sur un serveur Windows';
			$step6_CLIDetection_available = 'Disponible';
			$step6_CLIDetection_unavailable = 'Indisponible';
			$step6_CLIDetection_version_not_match = 'Disponible mais version incorrecte';
			$step6_popup = 'Fenêtre pop-up';
			$step6_bg = 'Script en tache de fond';
			
			//STEP 7
			$error_step7_CLI_path = 'Erreur, Vous devez saisir un chemin pour l\'éxécutable PHP-CLI ...';
			$error_step7_tmp_path = 'Erreur, Vous devez spécifier un répertoire temporaire ...';
			$error_step7_valid_tmp_path = 'Erreur, Vous devez spécifier un répertoire temporaire valide ...';
			$step7_title = 'Paramètres de régénération :';
			$step7_CLI_explanation = 'Entrez ici le chemin vers l\'éxécutable PHP-CLI (Sur les serveurs Windows il s\'agit généralement de c:\php\php-win.exe).';
			$step7_CLI = 'Chemin vers l\'éxécutable PHP-CLI';
			$step7_tmp_path_explanation = 'Aucun répertoire temporaire n\'a put être identifié sur ce serveur. <br />Merci d\'entrer un repertoire temporaire ici (Le chemin complet du repertoire est requis, ex /tmp or c:\tmp). Ce repertoire doit être inscriptible par le serveur web.';
			$step7_tmp_path = 'Chemin du repertoire temporaire';
			
			//STEP 8
			$error_step8_sessions = 'Erreur, Vous avez un problème avec la création de sessions utilisateurs. Vous devez corriger cela avant d\'utiliser Automne !';
			$error_step8_smtp_error = 'Erreur, Aucun serveur SMTP trouvé. Vérifiez votre installation de PHP ou cochez la case ci-dessous si vous souhaitez désactiver l\'envoi d\'email par l\'application.';
			$error_step8_label = 'Erreur, Merci de saisir un nom pour votre site.';
			$step8_title = 'Finalisation de l\'installation :';
			$step8_htaccess_explanation = 'Automne utilise des fichiers .htaccess pour protéger l\'accès de certains repertoires et spécifier certaines configurations.<br />Vérifiez que le serveur d\'hébergement que vous utilisez accepte bien l\'utilisation des fichiers .htaccess';
			$step8_freefr = 'Cochez si vous êtes hébergé par Free.fr';
			$step8_no_application_email = 'Cochez si vous souhaitez désactiver l\'envoi d\'email par l\'application';
			$step8_application_label = 'Saisissez un nom pour votre site.';
			$step8_label = 'Nom du site';
			
			//STEP9
			$step9_title = 'Installation terminée !';
			$step9_alldone = 'L\'installation d\'Automne est terminée.<br />
			<br />Vous pouvez accéder à l\'administration du site à cette adresse :<br />
			<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
			L\'identifiant par défaut est "<strong>root</strong>" et le mot de passe "<strong>automne</strong>".<br />
			Pensez à changer rapidement le mot de passe dans le profil utilisateur !<br />
			<br />
			Si vous avez choisi l\'installation de la Démo, la partie publique sera visible à l\'adresse <a href="/" target="_blank">%s</a> une fois que vous vous serez connecté une première fois à l\'administration de votre site.<br />
			<br />
			Vous pouvez supprimer l\'archive ayant servie à cette installation ainsi que le fichier install.php.<br />
			<span style="color:red;">Attention</span> : laisser ces fichiers sur un site en production représente une faille importante de sécurité pour votre site !<br />
			<br />
			Si vous souhaitez modifier certaines options saisies lors de cette installation, relancez le fichier install.php ou éditez le fichier config.php se trouvant à la racine de votre site web ou le fichier de paramètres /automne/classes/modules/standard_rc.xml.<br />
			<br />
			Pour profiter des fonctionnalités de publication et dépublication automatique, planifiez l\'execution du script /automne/classes/scripts/daily_routine.php toutes les nuits dans votre crontab (ou dans les taches planifiées de windows).<br />
			Exemple : 0 0 * * * www-data php '.$_SERVER['DOCUMENT_ROOT'].'/automne/classes/scripts/daily_routine.php (ici www-data est l\'utilisateur utilisé pour éxecuter Apache).
			<br /><br />
			Merci d\'utiliser Automne !<br />
			<br />
			Vous trouverez toute l\'aide nécessaire pour l\'utilisation du logiciel sur <a href="http://www.automne.ws" target="_blank">www.automne.ws</a> et sur <a href="http://doc.automne.ws" target="_blank">doc.automne.ws</a>.';
		break;
		case "en":
		default:
			//General labels
			$label_next = 'Next';
			$label_docroot = "Error, this file Must be at the server Document Root ! (%s)";
			$footer = 'Installing Automne version 4. For more informations, visit <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.';
			
			//STEP check
			$error_stepCheck_php_error = 'Error, Your PHP version ('.phpversion().') is not compatible with Automne. You must have a version greater than 5.2.0.';
			$error_stepCheck_dir_not_writable_error = 'Error, Apache does not have write permissions on your website root directory (%s).';
			$error_stepCheck_safe_mode_error = 'Beware ! The "safe_mode" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_magic_quotes_error = 'Beware ! The "magic_quotes_gpc" option is active on your PHP configuration. This option is strongly disadvised because some Automne functions will not be available or should be degraded.';
			$error_stepCheck_magic_quotes_runtime_error = 'Beware ! The "magic_quotes_runtime" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_magic_quotes_sybase_error = 'Beware ! The "magic_quotes_sybase" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_register_globals_error = 'Beware ! The "register_globals" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_gd_error = 'Error, GD extension is not installed on your server. Please Check your PHP installation.';
			$error_stepCheck_gd_gif_error = 'Error, functionalities of GIF image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_gd_jpeg_error = 'Error, functionalities of JPEG image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_gd_png_error = 'Error, functionalities of PNG image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_memory_limit_error = 'Error, memory usage of PHP scripts can not be changed and it is limited to %sB. Please correct your configuration to allow a minimum of 64MB of memory or let PHP scripts to choose their memory usage.';
			$stepCheck_title = 'System compatibility:';
			$stepCheck_installation_stopped = 'You cannot continue Automne installation...<br /><br />More information about hosts on <a href="http://www.automne.ws/faq/">the FAQ pages.</a>';
			//STEP 1
			$error_step1_directory_not_exists = 'Error, Extraction directory does not exist';
			$error_step1_cant_extract = 'Error, Can\'t extract archive wanted %s. It is not a valid format...';
			$error_step1_archive_not_exists = 'Error, Unable to find the Automne archive to unpack...';
			$step1_title = 'Archive extraction:';
			$step1_extraction_to = 'Extract %s to %s';
			$step1_extraction_ok = 'Extraction successful';
			$step1_extraction_error = 'Extraction error... Please decompress manually the file %s in this repertory and start again the installation.';
			$step1_package_extraction = 'Launch extraction of package %s...';
			$step1_htaccess_exists = 'During this decompression, Automne will create a file .htaccess containing a number of configurations needed.<br /><br />Currently a .htaccess file already exists on the server. You will find the contents into the text field below.<br /><br />You can change or remove this content. What you keep will be added to the .htaccess file of Automne.';
			$step1_htaccess_not_exists = 'During this decompression, Automne will create a .htaccess file containing a number of configurations needed.<br /><br />If your configuration requires it, you can add content to this .htaccess file in the text field below.<br /><br />What you enter will be added to the Automne .htaccess file.';
			$step1_htaccess_warning = 'Attention, any error in this file could cause an error 500 on the server.<br /><br />More information about hosts on <a href="http://www.automne.ws/faq/">the FAQ pages.</a>';
			
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
			$error_step2_incorrect_pass_confirm = 'Error, Password and Password confirmation did not match';
			$error_step2_DB_connection_failed = 'Error, Database engine connection failed:';
			$error_step2_DB_version_not_match = 'Error, MySQL version (%s) not match (5.0.0 minimum)';
			$error_step2_DB_cannot_get_version = 'Error, Can not retrieve MySQL version';
			$step2_title = 'Database identification:';
			$step2_explanation = 'Information of connection to the database is provided to you by your web administrator. Take care that the database that you will use exists.';
			$step2_DB_host = 'Database Host';
			$step2_DB_name = 'Database Name';
			$step2_DB_user = 'Database User';
			$step2_DB_password = 'Database Password';
			$step2_DB_password_confirm = 'Confirm';
			
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
			$step5_explanation = 'Automne generates many files and directories. The following rights have been detected to be used by the server for files and directories creation.<br /><br />Do you agree with using these rights when Automne creates files or directories?<br /><br />Warning, modifying these rights can involve errors on the server if it does not accept them. Modify them only if you are sure of the values.<br /><br />More information about hosts on <a href="http://www.automne.ws/faq/">the FAQ pages.</a>';
			$step5_files_perms = 'Files permissions';
			$step5_dirs_perms = 'Directories permissions';
			
			//STEP 6
			$error_step6_choose_option = 'Error, You must choose an option ...';
			$step6_title = 'Scripts operation:';
			$step6_explanation = 'Some complex operations in Automne needs usage of server scripts.<br />
			Please choose those scripts execution method :<br />
			<ul>
				<li>Pop-up window. Slow but works fine on all servers. You must choose this method for mutualized servers (or with Easyphp or other solutions that do not use a complete version of PHP).</li>
				<li>Background script. Fast but does not work on all servers. You can choose this method if you are on a dedicated server who has PHP-CLI installed (<a href="http://www.php.net/manual/en/features.commandline.php" target="_blank">Using PHP from the command line</a>).<br /><br />PHP-CLI detection on your server: <span style="color:red;">%s</span></li>
			</ul>';
			$step6_CLIDetection_nosystem = 'Unavailable : Functions "system", "exec" and "passthru" inactive.';
			$step6_CLIDetection_windows = 'Detection impossible on Windows server';
			$step6_CLIDetection_available = 'Available';
			$step6_CLIDetection_unavailable = 'Unavailable';
			$step6_CLIDetection_version_not_match = 'Available but wrong version';
			$step6_popup = 'Pop-up window';
			$step6_bg = 'Background script';
			
			//STEP 7
			$error_step7_CLI_path = 'Error, You must enter a Path for the PHP-CLI ...';
			$error_step7_tmp_path = 'Error, You must specify a temporary path ...';
			$error_step7_valid_tmp_path = 'Error, You must specify a valid temporary path ...';
			$step7_title = 'Regeneration parameters:';
			$step7_CLI_explanation = 'Enter here the path to the PHP-CLI executable (on Windows server it is usually c:\php\php-win.exe).';
			$step7_CLI = 'PHP-CLI path';
			$step7_tmp_path_explanation = 'No Path founded for the temporary directory on this server. <br />Please enter a temporary path here (full path needed ex : /tmp or c:\tmp). This directory must be writable by the server.';
			$step7_tmp_path = 'Temp path';
			
			//STEP 8
			$error_step8_sessions = 'Error, You have a problem with server session creation. You must correct it before using Automne !';
			$error_step8_smtp_error = 'Error, No SMTP server found. Please Check your PHP installation or check the box below to cancel the application email sending.';
			$error_step8_label = 'Error, Please to enter a name for your site.';
			$step8_title = 'Installation finalisation:';
			$step8_htaccess_explanation = 'Automne uses .htaccess files to protect some directories and specify some configurations.<br />Check that the hosting server that you use accepts the usage of the .htaccess files.';
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
			<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
			Default login is "<strong>root</strong>" and password is "<strong>automne</strong>".<br />
			Please modify the password in the user profile!<br />
			<br />
			If you selected the Demo installation, the public site will be visible at the address <a href="/" target="_blank">%s</a> once you will have connected first to the administration of your Web site.<br />
			<br />
			You can now remove the package file used for this installation as well as the file install.php.<br />
			<span style="color:red;">Warning</span>, leaving these files on a production website may represent an important security hole for your Web site!<br />
			<br />
			If you wish to modify options saved during this installation, start again the file install.php or edit the file config.php at the root of your Web site or the parameter file /automne/classes/modules/standard_rc.xml.<br />
			<br />
			If you want to use automatic publication and depublication fonctionnalities, plan the execution of the script /automne/classes/scripts/daily_routine.php every nigths in your crontab.<br />
			Example : 0 0 * * * www-data php '.$_SERVER['DOCUMENT_ROOT'].'/automne/classes/scripts/daily_routine.php (here www-data is the Apache user).
			<br /><br />
			
			Thank you for using Automne!<br />
			<br />
			You will find all necessary assistance for the use of the Software on <a href="http://www.automne.ws" target="_blank">www.automne.ws</a> and <a href="http://doc.automne.ws" target="_blank">doc.automne.ws</a>.';
		break;
	}
	
	// +----------------------------------------------------------------------+
	// | STEP check : System check compatibility                              |
	// +----------------------------------------------------------------------+
	if ($step === 'check') {
		//check for php compatibility
		if (version_compare(phpversion(), "5.2.0") !== -1) {
			//check for document root writing
			if (!is_writable(realpath($_SERVER['DOCUMENT_ROOT']))) {
				$error .= sprintf($error_stepCheck_dir_not_writable_error, realpath($_SERVER['DOCUMENT_ROOT'])).'<br /><br />';
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
			//check for memory_limit
			if(function_exists('memory_get_usage')) {
				if (ini_get('memory_limit') < 64) {
					$error .= sprintf($error_stepCheck_memory_limit_error,ini_get('memory_limit')).'<br /><br />';
					$stopInstallation = true;
				}
			}
			//check for safe_mode
			if (ini_get ( 'safe_mode' )) {
				$error .= $error_stepCheck_safe_mode_error.'<br /><br />';
				$stopInstallation = true;
			}
			//check for magic quotes
			if (get_magic_quotes_gpc()) {
				$error .= $error_stepCheck_magic_quotes_error.'<br /><br />';
			}
			if (ini_get('magic_quotes_runtime') != 0) {
				$error .= $error_stepCheck_magic_quotes_runtime_error.'<br /><br />';
				$stopInstallation = true;
			}
			if (ini_get('magic_quotes_sybase') != 0) {
				$error .= $error_stepCheck_magic_quotes_sybase_error.'<br /><br />';
				$stopInstallation = true;
			}
			if (ini_get('register_globals') != 0) {
				$error .= $error_stepCheck_register_globals_error.'<br /><br />';
				$stopInstallation = true;
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
			if (!isset($stopInstallation) || !$stopInstallation) {
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
				if ($file == 'cms_rc_frontend.php') {
					//archive allready uncompressed, then skip to next installation step
					$step = 'gpl';
				}
			}
		}
	}
	//if archive founded, uncompress it
	if (isset($archiveFound) && $archiveFound && $step==1) {
		if ($cms_action == 'extract') {
			//to avoid error on server with lots of PHP extensions, extend memory limit during this step
			@ini_set('memory_limit', '32M');
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
			$htaccess = '';
			if (file_exists($_SERVER['DOCUMENT_ROOT'].'/.htaccess')) {
				$htaccess = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/.htaccess');
				$content .= $step1_htaccess_exists;
			} else {
				$content .= $step1_htaccess_not_exists;
			}
			$content .= '
			'.$step1_htaccess_warning.'
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<textarea name="htaccess" class="htaccess" wrap="off" style="white-space:nowrap;">'.htmlspecialchars($htaccess).'</textarea>
				'.sprintf($step1_package_extraction,$archiveFile).'<br /><br />
				<input type="hidden" name="step" value="1" />
				<input type="hidden" name="cms_action" value="extract" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />
				<input type="submit" class="submit" value="'.$label_next.'" />
			</form>
			';
		}
	} elseif (isset($archiveFound) && !$archiveFound && $step==1) {
		$error .= $error_step1_archive_not_exists.'<br />';
		$title ='<h1>'.$step1_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
	}
	
	// +----------------------------------------------------------------------+
	// | STEP GPL : Accept GNU-GPL license                                    |
	// +----------------------------------------------------------------------+
	
	//if archive founded, uncompress it
	if ($step === 'gpl') {
		if ($cms_action == 'acceptlicense') {
			if (isset($_POST["license"]) && $_POST["license"] == 'yes') {
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
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/cms_rc_frontend.php')) {
		//Remove session if exists
		@session_name('AutomneSession');
		@session_start();
		@session_destroy();
		require_once($_SERVER['DOCUMENT_ROOT'].'/cms_rc_frontend.php');
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
		if ($cms_action == "dbinfos") {
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
			if ($_POST["dbpass"] != $_POST["dbpass2"]) {
				$error .= $error_step2_incorrect_pass_confirm.'<br />';
			}
			//DB connection
			if (!$error) {
				$dsn = 'mysql:host='.$_POST["dbhost"].';dbname='.$_POST["dbname"];
				try {
					$db = new PDO($dsn, $_POST["dbuser"], $_POST["dbpass"],
	                              array(PDO::ATTR_PERSISTENT => APPLICATION_DB_PERSISTENT_CONNNECTION,
	                                    PDO::ERRMODE_EXCEPTION => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
	                //MySQL Version
					$result = $db->query('SELECT VERSION() as v;');
	                if(is_object($result)){
	                    $version = ($arr = $result->fetch(PDO::FETCH_BOTH)) ?  $arr['v'] : false;
	                    if($version !== false){
	                        if (version_compare($version, '5.0.0') === -1) {
	                            $error .= sprintf($error_step2_DB_version_not_match, $version).'<br />';
						    }
	                    } else{
	                        $error .= $error_step2_DB_cannot_get_version."<br />";
	                    }
	                }
				} catch (PDOException $e) {
	                $error .= $error_step2_DB_connection_failed."<br />".'<pre>'.$e->getMessage().'</pre>';
				}
			}
		}
		
		if ($error || $cms_action != "dbinfos") {
			$dbhostValue = isset($_POST["dbhost"]) ? $_POST["dbhost"]:'localhost';
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
				<div class="dbinfos">
					<label for="dbhost">'.$step2_DB_host.' * : <input id="dbhost" type="text" name="dbhost" value="'.$dbhostValue.'" /></label><br />
					<label for="dbname">'.$step2_DB_name.' * : <input id="dbname" type="text" name="dbname" value="'.htmlspecialchars(@$_POST["dbname"]).'" /></label><br />
					<label for="dbuser">'.$step2_DB_user.' * : <input id="dbuser" type="text" name="dbuser" value="'.htmlspecialchars(@$_POST["dbuser"]).'" /></label><br />
					<label for="dbpass">'.$step2_DB_password.' : <input id="dbpass" type="password" name="dbpass" value="'.htmlspecialchars(@$_POST["dbpass"]).'" /></label><br />
					<label for="dbpass2">'.$step2_DB_password_confirm.' : <input id="dbpass2" type="password" name="dbpass2" value="'.htmlspecialchars(@$_POST["dbpass2"]).'" /></label><br />
					<input type="submit" class="submit" value="'.$label_next.'" />
				</div>
			</form>
			';
		} else {
			//create config file with valid DB infos
			$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
			$configFile->setContent('<?php
/*
 * AUTOMNE CONFIGURATION FILE
 * All default configurations are in file /cms_rc.php
 * If you need to modify any configuration constants of the the cms_rc.php
 * simply define the constant and it\'s new value in this file
 */

define("APPLICATION_DB_HOST", "'.$_POST["dbhost"].'");
define("APPLICATION_DB_NAME", "'.$_POST["dbname"].'");
define("APPLICATION_DB_USER", "'.$_POST["dbuser"].'");
define("APPLICATION_DB_PASSWORD", "'.$_POST["dbpass"].'");

//To use Google Map, uncomment and add your Google map Key
//define("GOOGLE_MAPS_KEY", \'YOUR_GGOGLE_MAP_KEY_HERE\');
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
		if ($cms_action == "dbscripts") {
			//Params
			if (!isset($_POST["script"]) || !$_POST["script"]) {
				$error .= $error_step3_must_choose_option.'<br />';
			}
			if (isset($_POST["script"]) && $_POST["script"] == 3) {
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
		
		if ($error || $cms_action != "dbscripts") {
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
			
			//1- DB structure (this file is in utf-8)
			$structureScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne4.sql";
			if (file_exists($structureScript) && CMS_patch::executeSqlScript($structureScript, true, true)) {
				CMS_patch::executeSqlScript($structureScript, false, true);
			} else {
				die(sprintf($error_step3_SQL_script,$structureScript));
			}
			
			//2- DB messages
			$messagesScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne4-I18NM_messages.sql";
			if (file_exists($messagesScript) && CMS_patch::executeSqlScript($messagesScript, true)) {
				CMS_patch::executeSqlScript($messagesScript);
			} else {
				die(sprintf($error_step3_SQL_script,$messagesScript));
			}
			
			if (isset($_POST["script"]) && $_POST["script"] == 2) {
				//3- Clean Automne DB
				$scratchScript = $_SERVER['DOCUMENT_ROOT']."/sql/automne4-scratch.sql";
				if (file_exists($scratchScript) && CMS_patch::executeSqlScript($scratchScript, true)) {
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
		if ($cms_action == "website") {
			//Params
			if (!isset($_POST["website"]) || !$_POST["website"]) {
				$error .= $error_step4_enter_url.'<br />';
			}
		}
		
		if ($error || $cms_action != "website") {
			$websiteUrl = isset($_POST["website"]) ? $_POST["website"]: $_SERVER["HTTP_HOST"];
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
				$websites = CMS_websitesCatalog::getAll();
				foreach($websites as $aWebsite) {
					$aWebsite->setURL($_POST["website"]);
					$aWebsite->writeToPersistence();
				}
				CMS_websitesCatalog::writeRootRedirection();
			} else {
				$websites = CMS_websitesCatalog::getAll();
				foreach($websites as $aWebsite) {
					$aWebsite->setURL($_POST["website"]);
					$aWebsite->writeToPersistence();
					$aWebsite->writeRootRedirection();
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
		if ($cms_action == "chmodConstants") {
			//Params
			if (!isset($_POST["fileChmod"]) || !$_POST["fileChmod"]) {
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
		
		if (($error || $cms_action != "chmodConstants") && function_exists("chmod")) {
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
		if ($cms_action == "regenerator") {
			//Params
			if (!isset($_POST["regenerator"]) || !$_POST["regenerator"]) {
				$error .= $error_step6_choose_option.'<br />';
			}
		}
		
		if ($error || $cms_action != "regenerator") {
			$title = '<h1>'.$step6_title.'</h1>';
			if ($error) {
				$content .= '<span class="error">'.$error.'</span><br />';
			}
			
			//detect CLI
			$windows = false;
			if (!(function_exists('exec') || !function_exists('passthru')) && !function_exists('system')) {
				$clidetection = $step6_CLIDetection_nosystem;
				$cliAvailable = false;
			} elseif (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
				$clidetection = $step6_CLIDetection_windows;
				$cliAvailable = true;
				$windows = true;
			} else {
				if (substr(CMS_patch::executeCommand('which php 2>&1',$error),0,1) == '/' && !$error) {
					//test CLI version
					$return = CMS_patch::executeCommand('php -v',$error);
					if (strpos(strtolower($return), '(cli)') !== false) {
						$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
						if (version_compare($cliversion, "5.2.0") === -1) {
							$clidetection = $step6_CLIDetection_version_not_match.' ('.$cliversion.')';
							$cliAvailable = false;
						} else {
							$clidetection = $step6_CLIDetection_available.' ('.$cliversion.')';
							$cliAvailable = true;
						}
					} else {
						$clidetection = $step6_CLIDetection_unavailable;
						$cliAvailable = false;
					}
				} else {
					$clidetection = $step6_CLIDetection_unavailable;
					$cliAvailable = false;
				}
			}
			
			$content .= '
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<input type="hidden" name="step" value="6" />
				<input type="hidden" name="cms_action" value="regenerator" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />
				'.sprintf($step6_explanation,$clidetection).'
				<label for="popup"><input id="popup" type="radio" name="regenerator" value="1"'.((!$cliAvailable || $windows) ? ' checked="true"' : '').' /> '.$step6_popup.'</label><br />
				<label for="cli"><input id="cli" type="radio" name="regenerator" value="2"'.(!$cliAvailable ? ' disabled="true"' : (!$windows) ? ' checked="true"' : '').' /> '.$step6_bg.'</label><br />
				<input type="submit" class="submit" value="'.$label_next.'" />
			</form>
			';
		} else {
			//set values in standard_rc.xml file
			$module = CMS_modulesCatalog::getByCodename('standard');
			$moduleParameters = $module->getParameters(false,true);
			if (isset($_POST["regenerator"]) && $_POST["regenerator"] == 1) {
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
		if ($cms_action == "regeneratorParams") {
			//get values in standard_rc.xml file
			$module = CMS_modulesCatalog::getByCodename('standard');
			$moduleParameters = $module->getParameters(false,true);
			// CLI path
			if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 && (!isset($_POST["cliPath"]) || !$_POST["cliPath"])) {
				$error .= $error_step7_CLI_path.'<br />';
			} else {
				$cliPath = $_POST["cliPath"];
				if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
					//add CLI path to config.php file
					$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
					$configFileContent = $configFile->readContent("array","rtrim");
					$skip = false;
					foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
						if (strpos($aLineOfConfigFile, "PATH_PHP_CLI_WINDOWS") !== false) {
							$configFileContent[$lineNb] = 'define("PATH_PHP_CLI_WINDOWS", \''.$cliPath.'\');';
							$skip = true;
						}
					}
					if (!$skip) {
						$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_CLI_WINDOWS", \''.$cliPath.'\');';
						$configFileContent[sizeof($configFileContent)] = '?>';
					}
					$configFile->setContent($configFileContent);
					$configFile->writeToPersistence();
				}/* else {
					//makes files executables
					$scriptsFiles = CMS_file::getFileList(PATH_PACKAGES_FS.'/scripts/*.php'); 	 
					foreach ($scriptsFiles as $aScriptFile) {
						$scriptFile = new CMS_file($aScriptFile["name"]);
						$scriptFileContent = $scriptFile->readContent("array","rtrim");
						//check if file is a script with a bang line (search start of bang line)
						if (strpos($scriptFileContent[0], "#!") !== false) {
							//then set the new bang line
							$scriptFileContent[0] = '#!'.$cliPath.' -q';
							$scriptFile->setContent($scriptFileContent);
							$scriptFile->writeToPersistence(); 	 
						}
						//then set it executable
						CMS_file::makeExecutable($aScriptFile["name"]);
						pr($aScriptFile["name"]);
					}
					exit;
				}*/
			}
			
			//Temporary path (if needed)
			if (isset($_POST["needTmpPath"]) && $_POST["needTmpPath"] && (!isset($_POST["tmpPath"]) || !$_POST["tmpPath"])) {
				$error .= $error_step7_tmp_path.'<br />';
			} elseif (isset($_POST["needTmpPath"]) && $_POST["needTmpPath"]) {
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
					if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
						$tmpPath .= '\\\\';
					}
					//add tmp path to config.php file
					$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
					$configFileContent = $configFile->readContent("array","rtrim");
					$skip = false;
					foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
						if (strpos($aLineOfConfigFile, "PATH_PHP_TMP") !== false) {
							$configFileContent[$lineNb] = 'define("PATH_PHP_TMP", \''.$tmpPath.'\');';
							$skip = true;
						}
					}
					if (!$skip) {
						$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_TMP", \''.$tmpPath.'\');';
						$configFileContent[sizeof($configFileContent)] = '?>';
					}
					$configFile->setContent($configFileContent);
					$configFile->writeToPersistence();
				} else {
					$error .= $error_step7_valid_tmp_path.'<br />';
				}
			}
		}
		
		if ($error || $cms_action != "regeneratorParams") {
			//get values in standard_rc.xml file
			$module = CMS_modulesCatalog::getByCodename('standard');
			$moduleParameters = $module->getParameters(false,true, true);
			//found CLI path
			if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 && strtolower(substr(PHP_OS, 0, 3)) === 'win') {
				$cliPath = isset($_POST["cliPath"]) ? $_POST["cliPath"] : PATH_PHP_CLI_WINDOWS;
			}
			//CHMOD scripts with good values
			$scriptsFiles = CMS_file::getFileList(PATH_PACKAGES_FS.'/scripts/*.php');
			foreach ($scriptsFiles as $aScriptFile) {
				//then set it executable
				CMS_file::makeExecutable($aScriptFile["name"]);
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
					if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
						$tmpPath .= '/';
					}
					//add tmp path to config.php file
					$configFile = new CMS_file($_SERVER['DOCUMENT_ROOT']."/config.php");
					$configFileContent = $configFile->readContent("array","rtrim");
					$skip = false;
					foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
						if (strpos($aLineOfConfigFile, "PATH_PHP_TMP") !== false) {
							$configFileContent[$lineNb] = 'define("PATH_PHP_TMP", \''.$tmpPath.'\');';
							$skip = true;
						}
					}
					if (!$skip) {
						$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_TMP", \''.$tmpPath.'\');';
						$configFileContent[sizeof($configFileContent)] = '?>';
					}
					$configFile->setContent($configFileContent);
					$configFile->writeToPersistence();
				} else {
					$tmpPath ='';
				}
			}
			if (($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 && strtolower(substr(PHP_OS, 0, 3)) === 'win') || !$tmpPath) {
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
		if ($cms_action == "finalisation") {
			
			//Application Label
			if (!isset($_POST["label"]) || !$_POST["label"]) {
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
			
			//No application email
			if (isset($_POST["no_application_email"]) && $_POST["no_application_email"] == 1)  {
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
			
			//force regeneration of first page to avoid any error
			$rootPage = CMS_tree::getPageByID(1);
			$rootPage->regenerate(true);
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
		if (!isset($_POST["no_application_email"]) || !$_POST["no_application_email"]) {
			$no_email = false;
			if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
				$error .= $error_step8_smtp_error.'<br />';
				$no_application_email = true;
			}
		}
		if ($error || $cms_action != "finalisation") {
			$title = '<h1>'.$step8_title.'</h1>';
			if ($error) {
				$content .= '<span class="error">'.$error.'</span><br />';
			}
			$content .= '
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<input type="hidden" name="step" value="8" />
				<input type="hidden" name="cms_action" value="finalisation" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />
				'.$step8_htaccess_explanation.'<br /><br />';
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
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Automne :: Installation</title>
	<style type="text/css">
		body{
			background-color:	#e9f1da;
			font-family:		arial,verdana,helvetica,sans-serif;
			font-size:			12px;
			margin:				0;
			padding:			0;
		}
		.error {
			color:				red;
			font-weight:		bold;
		}
		a{
			text-decoration:	none;
			color:				#5f900b;
		}
		#main{
			width:				639px;
			margin:				auto;
		}
		#content{
			background:			url('.$_SERVER['SCRIPT_NAME'].'?file=logo) no-repeat 75px 0;
			margin:				auto;
			background-color:	#ffffff;
			width:				639px;
			border-left:		1px solid #dde6cb;
			border-right:		1px solid #dde6cb;
			border-bottom:		1px solid #dde6cb;
			color:				#5d5856;
			padding-top:		118px;
			padding-bottom:		30px;
			min-height:			300px;
		}
		#text {
			padding-left:		35px;
			padding-right:		15px;
		}
		h1{
			background:			url('.$_SERVER['SCRIPT_NAME'].'?file=picto) no-repeat 0 5px;
			font-size:			16px;
			color:				#8cbe35;
			padding-left:		21px;
			margin-bottom:		20px;
		}
		#footer{
			color:				#5a6266;
			height:				60px;
			width:				639px;
			margin:				auto;
			padding-top:		8px;
			text-align:			center;
			font-size:			11px;
		}
		.license,
		.htaccess,
		.extraction {
			width:				100%;
			height:				250px;
			overflow:			auto;
			padding:			5px 5px 5px 0;
			margin:				10px 10px 10px 0;
			background-color:	#EFF8CF;
		}
		.dbinfos{
			text-align:			right;
		}
		.dbinfos label {
			width:				400px;
			display:			block;
		}
		input.submit {
			cursor: 			pointer;
			border: 			0px;
			padding: 			2px;
			color:				#FFFFFF;
			height: 			20px;
			background-color:	#ABD64A;
			background-position:top-left;
			background-repeat: 	no-repeat;
			float:				right;
		}
	</style>
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
</head>
<body onLoad="initJavascript();">
	<div id="main">
		<div id="content">
			<div id="text">
				'.$title.'
				'.$content;
	if (!isset($extractArchive) || !$extractArchive) {
		echo '
			</div>
		</div>
		<div id="footer">'.$footer.'</div>
	</div>
</body>
</html>
		';
	} else {
		echo '<pre class="extraction">';
		$archive->extract_files();
		$content = '</pre><br />';
		if (!$archive->hasError()) {
			$content .= $step1_extraction_ok.'<br />';
			//remove file config.php if exists in archive : install process will create a new one
			if (file_exists($_SERVER['DOCUMENT_ROOT'].'/config.php')) {
				@unlink($_SERVER['DOCUMENT_ROOT'].'/config.php');
			}
			//append .htaccess content if any
			if (isset($_POST['htaccess']) && file_exists($_SERVER['DOCUMENT_ROOT'].'/.htaccess')) {
				file_put_contents($_SERVER['DOCUMENT_ROOT'].'/.htaccess', "\n\n".$_POST['htaccess'], FILE_APPEND);
			}
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
		</div>
		<div id="footer">'.$footer.'</div>
	</div>
</body>
</html>
		';
	}
} else {
	// +----------------------------------------------------------------------+
	// | Installation Binary files           		                          |
	// +----------------------------------------------------------------------+
	switch($_GET['file']) {
		case 'logo':
			$file = base64_decode('
				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');
			header('Content-Type: image/jpg');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
		case 'picto':
			$file = base64_decode('
				R0lGODlhDQAJAIAAAP///2aZACH5BAAAAAAALAAAAAANAAkAAAIRDIwHy+2bonpUSVnbtfltwxQA
				Ow==');
			header('Content-Type: image/gif');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
	}
}
// +----------------------------------------------------------------------+
// | Installation Classes & Functions                                     |
// +----------------------------------------------------------------------+

//Usefull function to dump a var.
function pr_install($data,$useVarDump = false) {
	if (!$useVarDump) {
		echo "<pre>".print_r($data,true)."</pre>";
		flush();
	} else {
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		flush();
	}
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