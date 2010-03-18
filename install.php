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
// $Id: install.php,v 1.29 2010/03/18 16:10:35 sebastien Exp $

/**
  * PHP page : Automne Installation Manager
  * 
  * @package CMS
  * @subpackage installation
  * @author Sebastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Remove notices
error_reporting(E_ALL);
@set_time_limit(0);
@ini_set("memory_limit" , "64M");
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
	$accepted_step = array('0','1','2','3','4','5','6','7','8','9','gpl','check','help');
	$step = (in_array($step , $accepted_step) === true) ? $step:'check';
	
	$cms_action = isset($_POST["cms_action"]) ? $_POST["cms_action"] : '';
	
	$content = $title = $error = '';
	
	// +----------------------------------------------------------------------+
	// | STEP 0 : Installation language                                       |
	// +----------------------------------------------------------------------+
	if ($install_language == '' && $step != 'help') {
		$title = '<h1>Langue d\'installation / Installation language:</h1>';
		$footer = '';
		$content .= '
		<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
			<input type="hidden" name="step" value="'.$step.'" />
			Veuillez choisir votre langue d\'installation.<br />
			Please choose your installation language.<br /><br />
			<label for="fr"><input id="fr" type="radio" name="install_language" value="fr" checked="checked" /> Fran&ccedil;ais</label><br />
			<label for="en"><input id="en" type="radio" name="install_language" value="en" /> English</label><br />
			<input type="submit" class="submit" value=" OK " />
		</form>
		<br /><br />
		<fieldset>
			<legend>Tests for all needed parameters to run Automne V4</legend>
						<ul class="atm-server">';
			if (version_compare(PHP_VERSION, "5.2.0") === -1) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP version ('.PHP_VERSION.') not match</li>';
			} else {
				$content .= '<li class="atm-pic-ok">PHP version <strong style="color:green">OK</strong> ('.PHP_VERSION.')</li>';
			}
			//GD
			if (!function_exists('imagecreatefromgif') || !function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, GD extension not installed</li>';
			} else {
				$content .= '<li class="atm-pic-ok">GD extension <strong style="color:green">OK</strong></li>';
			}
			//MySQL
			if (!class_exists('PDO')) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PDO extension not installed</li>';
			} else{
				$content .= '<li class="atm-pic-ok">PDO extension <strong style="color:green">OK</strong></li>';
			    $pdo_drivers = PDO::getAvailableDrivers();
			    if(!in_array('mysql', $pdo_drivers)){
			        $content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PDO MySQL driver not installed</li>';
			    } else{
			        $content .= '<li class="atm-pic-ok">PDO MySQL driver <strong style="color:green">OK</strong></li>';
			    }
			}
			//MBSTRING
			if (!function_exists('mb_substr') || !function_exists('mb_convert_encoding')) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, Multibyte String (mbsring) extension is not installed.</li>';
			} else {
				$content .= '<li class="atm-pic-ok">Multibyte String (mbsring) extension <strong style="color:green">OK</strong></li>';
			}
			//Files writing
			if (!is_writable(realpath($_SERVER['DOCUMENT_ROOT']))) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, No permissions to write files on website root directory ('.realpath($_SERVER['DOCUMENT_ROOT']).')</li>';
			} else {
				$content .= '<li class="atm-pic-ok">Website root filesystem permissions are <strong style="color:green">OK</strong></li>';
			}
			//Email
			if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, No SMTP server founded</li>';
			} else {
				$content .= '<li class="atm-pic-ok">SMTP server <strong style="color:green">OK</strong></li>';
			}
			//Memory
			ini_set('memory_limit', "64M");
			if (ini_get('memory_limit') && ini_get('memory_limit') < 64) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, Cannot upgrade memory limit to 64M. Memory detected : '.ini_get('memory_limit')."\n";
			} else {
				$content .= '<li class="atm-pic-ok">Memory limit <strong style="color:green">OK</strong></li>';
			}
			//CLI
			if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
				$content .= '<li class="atm-pic-question">Cannot test CLI on Windows Platform ...</li>';
			} else {
				function executeCommand($command, &$error) {
					//change current dir
					$pwd = getcwd();
					if (function_exists("exec")) {
						//execute command
						@exec($command, $return , $error );
						$return = implode("\n",$return);
					} elseif (function_exists("passthru")) {
						//execute command
						@ob_start();
						@passthru ($command, $error);
						$return = @ob_get_contents();
						@ob_end_clean();
					} else {
						$error=1;
						return false;
					}
					//restore original dir
					@chdir($pwd);
					return $return;
				}
				$error = '';
				$return = executeCommand('which php 2>&1',$error);
				if ($error && $return !== false) {
					$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, unable to find php CLI with command "which php" : '.$error."\n";
				}
				if ($return === false) {
					$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, commands passthru() and exec() are not available. PHP CLI is not usable.</li>';
				} elseif (substr($return,0,1) != '/') {
					$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, unable to find php CLI with command "which php"</li>';
				} else {
					//test CLI version
					$return = executeCommand('php -v',$error);
					if ($return === false) {
						$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, PHP CLI not found'."\n";
					} elseif (strpos(strtolower($return), '(cli)') === false) {
						$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, installed php is not the CLI version : '.$return."\n";
					} else {
						$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
						if (version_compare($cliversion, "5.2.0") === -1) {
							$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, PHP CLI version ('.$cliversion.') not match</li>';
						} else {
							$content .= '<li class="atm-pic-ok">PHP CLI version <strong style="color:green">OK</strong> ('.$cliversion.')</li>';
						}
					}
				}
			}
			
			//Conf PHP
			//try to change some misconfigurations
			@ini_set('magic_quotes_gpc', 0);
			@ini_set('magic_quotes_runtime', 0);
			@ini_set('magic_quotes_sybase', 0);
			if (ini_get('magic_quotes_gpc') != 0) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, PHP magic_quotes_gpc is active and cannot be changed</li>';
			}
			if (ini_get('magic_quotes_runtime') != 0) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP magic_quotes_runtime is active and cannot be changed</li>';
			}
			if (ini_get('magic_quotes_sybase') != 0) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP magic_quotes_sybase is active and cannot be changed</li>';
			}
			if (ini_get('register_globals') != 0) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP register_globals is active and cannot be changed</li>';
			}
			if (ini_get('allow_url_include') != 0) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP allow_url_include is active and cannot be changed</li>';
			}
			//check for safe_mode
			if (ini_get('safe_mode') && strtolower(ini_get('safe_mode')) != 'off') {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP safe_mode is active</li>';
			}
			$content .='</ul>
		</fieldset>';
		$step = 0;
	}
	
	//Installation labels
	switch ($install_language) {
		case "fr":
			//General labels
			$label_next = 'Suivant';
			$label_docroot = "Erreur, ce fichier doit ce trouver &agrave; la racine du serveur web ! (%s)";
			$footer = 'Installation d\'Automne version 4. Pour toute information, visitez <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>';
			$needhelp = '<div id="needhelp"><a href="'.$_SERVER['SCRIPT_NAME'].'?step=help&install_language='.$install_language.'" target="_blank">Besoin d\'aide ?</a></div>';
			
			//STEP Help
			$stepHelp_title = 'Aide &agrave; l\'installation d\'Automne';
			$stepHelp_installation_help = 'Si vous rencontrez des difficult&eacute;s pour installer Automne - que vous ayez simplement besoin d\'explications ou si vous rencontrez des erreurs - n\'h&eacute;sitez pas &agrave; poser vos questions sur <a href="http://www.automne.ws/forum/" target="_blank">le forum d\'Automne</a>.<br /><br />
			Vous y obtiendrez une aide rapide et adapt&eacute;e &agrave; votre situation.<br /><br />
			Pour nous aider &agrave; diagnostiquer vos probl&egrave;mes, merci de donner le plus d\'informations possible sur le type d\'h&eacute;bergement dont vous disposez ainsi que les messages d\'erreurs &eacute;ventuels que vous rencontrez. <br /><br />
			Vous pouvez aussi fournir le fichier de diagnostic suivant &agrave; un administrateur du forum via message priv&eacute; ou par email sur <a href="mailto:contact@automne.ws">contact@automne.ws</a>.<br />Ce fichier contient toutes les informations de configuration de votre serveur et il nous aidera &agrave; identifier pr&eacute;cis&eacute;ment la source du probl&egrave;me.<br /><br />
			&raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'?file=info" target="_blank">T&eacute;l&eacute;charger le fichier de diagnostic</a>.';
			
			//STEP check
			$error_stepCheck_php_error = 'Erreur, Votre version de PHP ('.phpversion().') n\'est pas compatible avec Automne. Vous devez avoir une version sup&eacute;rieure &agrave; la 5.2.0.';
			$error_stepCheck_dir_not_writable_error = 'Erreur, Apache ne poss&egrave;de pas les droits d\'&eacute;criture sur le r&eacute;pertoire racine (%s) de votre site web.';
			$error_stepCheck_safe_mode_error = 'Attention ! L\'option "safe_mode" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_pdo_error = 'Attention, l\'extension PDO pour PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.pdo.php" target="_blank">configuration de PHP et ajouter le support de PDO</a>.';
			$error_stepCheck_pdo_mysql_error = 'Attention, le driver MySQL pour l\'extension PDO de PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.pdo.php" target="_blank">configuration de PHP et ajouter le support de MySQL &agrave; PDO</a>.';
			$error_stepCheck_mbstring_error = 'Attention, l\'extension Multibyte String (mbsring) pour PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.mbstring.php" target="_blank">configuration de PHP et ajouter le support de mbstring</a>.';
			$error_stepCheck_magic_quotes_error = 'Attention ! L\'option "magic_quotes_gpc" est active sur votre configuration de PHP. Cette option est fortement d&eacute;conseill&eacute;e car l\'ensemble des fonctions d\'Automne ne seront pas disponibles et/ou leurs fonctionnement sera d&eacute;grad&eacute;.';
			$error_stepCheck_magic_quotes_runtime_error = 'Attention ! L\'option "magic_quotes_runtime" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_magic_quotes_sybase_error = 'Attention ! L\'option "magic_quotes_sybase" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_register_globals_error = 'Attention ! L\'option "register_globals" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_error = 'Erreur, l\'extension GD n\'est pas install&eacute;e sur votre serveur. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_gif_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images GIF ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_jpeg_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images JPEG ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_png_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images PNG ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_memory_limit_error = 'Erreur, l\'utilisation m&eacute;moire des scripts PHP ne peut &ecirc;tre modifi&eacute;e et elle est limit&eacute;e &agrave; %so. Veuillez modifier votre configuration pour allouer un minimum de 64Mo de m&eacute;moire ou bien pour laisser les scripts PHP choisir leur utilisation m&eacute;moire.';
			$stepCheck_title = 'Compatibilit&eacute; de votre syst&egrave;me :';
			$stepCheck_installation_stopped = 'Vous ne pouvez poursuivre l\'installation d\'Automne ...<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			
			//STEP 1
			$error_step1_directory_not_exists = 'Erreur, Le repertoire d\'extraction n\'exise pas';
			$error_step1_cant_extract = 'Erreur, Impossible d\'extraire l\'archive %s. Format invalide...';
			$error_step1_archive_not_exists = 'Erreur, Impossible de trouver l\'archive d\'Automne &agrave; d&eacute;compresser ...';
			$step1_title = 'D&eacute;compression de l\'archive :';
			$step1_extraction_to = 'D&eacute;compression de %s vers %s';
			$step1_extraction_ok = 'D&eacute;compression r&eacute;alis&eacute;e avec succ&egrave;s';
			$step1_extraction_error = 'Erreur de d&eacute;compression ... Veuillez d&eacute;compresser manuellement l\'archive %s dans ce repertoire et relancez l\'installation.';
			$step1_package_extraction = 'Lancer la d&eacute;compression de l\'archive %s...';
			$step1_htaccess_exists = 'Durant cette d&eacute;compression, Automne cr&eacute;era un fichier .htaccess comportant un certain nombre de configurations n&eacute;cessaires.<br /><br />Actuellement un fichier .htaccess existe d&eacute;j&agrave; sur le serveur. Vous en trouverez le contenu dans le champ texte ci-dessous.<br /><br />Vous pouvez modifier ou supprimer ce contenu. Ce que vous conserverez sera ajout&eacute; au fichier .htaccess d\'Automne.';
			$step1_htaccess_not_exists = 'Durant cette d&eacute;compression, Automne cr&eacute;era un fichier .htaccess comportant un certain nombre de configurations n&eacute;cessaires.<br /><br />Si votre configuration le requiert, vous pouvez ajouter du contenu &agrave; ce fichier .htaccess dans le champ texte ci-dessous.<br /><br />Ce que vous saisirez sera ajout&eacute; au fichier .htaccess d\'Automne.';
			$step1_htaccess_warning = 'Attention, toute erreur dans ce fichier pourrait provoquer une erreur 500 sur le serveur.<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			
			//GPL STEP
			$stepGPL_title = 'License d\'exploitation :';
			$stepGPL_explanation = 'L\'utilisation d\'Automne est soumis &agrave; l\'acceptation de la license GNU-GPL suivante.';
			$stepGPL_licenseNotFound = 'Le fichier de license est introuvable, veuillez le consulter ici : <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a>';
			$stepGPL_accept = 'Acceptez vous les termes de cette license ?';
			$stepGPL_yes = 'J\'accepte les termes de la license.';
			$stepGPL_no = 'Je n\'accepte pas les termes de la license.';
			
			//STEP 2
			$error_step2_no_cms_rc_admin = 'Erreur, impossible de trouver %s/cms_rc_admin.php';
			$error_step2_missing_host = 'Erreur, param&egrave;tre h&ocirc;te de la base de donn&eacute;es manquant';
			$error_step2_missing_name = 'Erreur, param&egrave;tre nom de la base de donn&eacute;es manquant';
			$error_step2_missing_user = 'Erreur, param&egrave;tre utilisateur de la base de donn&eacute;es manquant';
			$error_step2_DB_connection_failed = 'Erreur, Connection &agrave; la base de donn&eacute;es impossible :';
			$error_step2_incorrect_pass_confirm = 'Erreur, le mot de passe et sa confirmation ne correspondent pas';
			$error_step2_DB_version_not_match = 'Erreur, La version de MySQL (%s) ne correspond pas (5.0.0 minimum).';
			$error_step2_DB_cannot_get_version = 'Erreur, impossible d\'obtenir la version de MySQL.';
			$step2_title = 'Identification &agrave; la base de donn&eacute;es:';
			$step2_explanation = 'Les informations de connection &agrave; la base de donn&eacute;es vous sont fournies par votre h&eacute;bergeur. Veillez &agrave; ce que la base que vous allez utiliser existe.';
			$step2_DB_host = 'H&ocirc;te de la base de donn&eacute;es';
			$step2_DB_name = 'Nom de la base de donn&eacute;es';
			$step2_DB_user = 'Utilisateur de la base de donn&eacute;es';
			$step2_DB_password = 'Mot de passe de la base de donn&eacute;es';
			$step2_DB_password_confirm = 'Confirmation';
			
			//STEP 3
			$error_step3_must_choose_option = 'Erreur, vous devez choisir un option ...';
			$error_step3_SQL_script = 'Erreur, syntaxe incorrecte dans le fichier : %s ou fichier manquant';
			$step3_title = 'Choisissez un type d\'installation :';
			$step3_Demo = 'Automne avec la D&eacute;mo (conseill&eacute; pour tester et apprendre le logiciel)';
			$step3_Empty = 'Automne vide (conseill&eacute; pour cr&eacute;er un site &agrave; partir de z&eacute;ro)';
			$step3_skip = 'Conserver la Base de Donn&eacute;es actuelle';
			
			//STEP 4
			$error_step4_enter_url = 'Erreur, Vous devez saisir une URL ...';
			$step4_title = 'URL du site web :';
			$step4_enter_url = 'Entrez l\'URL du site web (la valeur par d&eacute;faut doit-&ecirc;tre correcte). Il s\'agit de l\'URL de la racine du site.<br />Si vous saisissez un nom de domaine, ce dernier doit exister. Vous pourrez modifier cela &agrave; tout moment dans l\'administration du site.';
			$step4_url = 'URL * : http://';
			
			//STEP 5
			$error_step5_perms_files = 'Erreur, Vous devez entrer une valeur de permission pour les fichiers ...';
			$error_step5_perms_dirs = 'Erreur, Vous devez entrer une valeur de permission pour les dossiers ...';
			$step5_title = 'Permissions des fichiers et des dossiers :';
			$step5_explanation = 'Automne g&eacute;n&egrave;re un grand nombre de fichiers et de dossiers. Les droits suivant ont &eacute;t&eacute; detect&eacute;s comme &eacute;tant utilis&eacute;s par votre serveur.<br /><br />Etes-vous d\'accord pour les utiliser lorsque Automne cr&eacute;&eacute;ra des fichiers et des dossiers ? (Automne doit avoir le droit d\'&eacute;criture sur tous les fichiers du serveur).<br /><br />Attention, modifier ces droits peut entrainer des erreurs sur le serveur si ce dernier ne les acceptes pas. Modifiez ces param&egrave;tres seulement si vous savez ce que vous faites.<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne.ws/faq/">les FAQ en ligne.</a>';
			$step5_files_perms = 'Permissions sur les fichiers';
			$step5_dirs_perms = 'Permissions sur les dossiers';
			
			//STEP 6
			$error_step6_choose_option = 'Erreur, vous devez choisir une option ...';
			$step6_title = 'Fonctionnement des scripts :';
			$step6_explanation = 'Certaines op&eacute;rations d\'Automne n&eacute;cessitent l\'ex&eacute;cution de t&acirc;ches de fond.<br /><br />
			Veuillez choisir la m&eacute;thode d\'ex&eacute;cution de ces t&acirc;ches de fond :<br />
			<ul>
				<li>D&eacute;clench&eacute;es par le navigateur : Processus lent et qui n&eacute;cessite que le navigateur d\'un administrateur d\'Automne reste ouvert mais qui fonctionne sur tous les serveurs. Vous devez choisir cela sur les serveurs mutualis&eacute;s et autres solutions ne disposant pas de PHP-CLI.<br /><br /></li>
				<li>Scripts en t&acirc;che de fond sur le serveur : Processus rapide mais qui ne fonctionne pas sur tous les serveurs. Vous pouvez choisir cela sur les serveurs d&eacute;di&eacute;s qui ont l\'ex&eacute;cutable PHP-CLI install&eacute; (Aide sur PHP-CLI : <a href="http://fr.php.net/manual/fr/features.commandline.php" target="_blank">Utiliser PHP en ligne de commande</a>).</li>
			</ul>
			D&eacute;tection de la pr&eacute;sence de PHP-CLI sur votre serveur : <span style="color:red;">%s</span><br /><br />';
			$step6_CLIDetection_nosystem = 'Indisponible : Fonctions "system", "exec" et "passthru" d&eacute;sactiv&eacute;es.';
			$step6_CLIDetection_windows = 'D&eacute;tection impossible sur un serveur Windows';
			$step6_CLIDetection_available = 'Disponible';
			$step6_CLIDetection_unavailable = 'D&eacute;tection impossible';
			$step6_CLIDetection_version_not_match = 'Disponible mais version incorrecte';
			$step6_popup = 'D&eacute;clench&eacute;es par le navigateur';
			$step6_bg = 'Scripts en t&acirc;che de fond sur le serveur';
			
			//STEP 7
			$error_step7_CLI_path = 'Erreur, Vous devez saisir un chemin pour l\'&eacute;x&eacute;cutable PHP-CLI ...';
			$error_step7_tmp_path = 'Erreur, Vous devez sp&eacute;cifier un r&eacute;pertoire temporaire ...';
			$error_step7_valid_tmp_path = 'Erreur, Vous devez sp&eacute;cifier un r&eacute;pertoire temporaire valide ...';
			$step7_title = 'Scripts en t&acirc;che de fond :';
			$step7_CLI_explanation = 'Entrez ici le chemin vers l\'&eacute;x&eacute;cutable PHP-CLI.';
			$step7_CLI = 'Chemin vers l\'&eacute;x&eacute;cutable PHP-CLI';
			$step7_tmp_path_explanation = 'Aucun r&eacute;pertoire temporaire n\'a put &ecirc;tre identifi&eacute; sur ce serveur. <br />Merci d\'entrer un repertoire temporaire ici (Le chemin complet du repertoire est requis, ex : /tmp ou c:\tmp). Ce repertoire doit &ecirc;tre accessible en &eacute;criture par le serveur web.';
			$step7_tmp_path = 'Chemin du repertoire temporaire';
			
			//STEP 8
			$error_step8_sessions = 'Erreur, Vous avez un probl&egrave;me avec la cr&eacute;ation de sessions utilisateurs. Vous devez corriger cela avant d\'utiliser Automne !';
			$error_step8_smtp_error = 'Erreur, Aucun serveur SMTP trouv&eacute;. V&eacute;rifiez votre installation de PHP ou cochez la case ci-dessous si vous souhaitez d&eacute;sactiver l\'envoi d\'email par l\'application.';
			$error_step8_label = 'Erreur, Merci de saisir un nom pour votre site.';
			$step8_title = 'Finalisation de l\'installation :';
			$step8_htaccess_explanation = '<h2>Fichiers .htaccess</h2>Automne utilise des fichiers .htaccess pour renforcer la s&eacute;curit&eacute; du syst&egrave;me, prot&eacute;ger l\'acc&egrave;s de certains repertoires et sp&eacute;cifier certaines configurations.<br /><br /><strong>V&eacute;rifiez que le serveur d\'h&eacute;bergement que vous utilisez accepte bien l\'utilisation des fichiers .htaccess</strong>';
			$step8_no_application_email_title = '<h2>Serveur SMTP introuvable</h2>';
			$step8_no_application_email = 'Cochez cette case si vous souhaitez d&eacute;sactiver l\'envoi d\'email par l\'application';
			$step8_application_label = '<h2>Nommez votre installation</h2>Saisissez un nom pour cette installation d\'Automne.';
			$step8_label = 'Nom de l\'installation';
			
			//STEP9
			$step9_title = 'Installation termin&eacute;e !';
			$step9_alldone = '<strong>L\'installation d\'Automne est termin&eacute;e.</strong><br />
			<br />Vous pouvez acc&eacute;der &agrave; l\'administration du site &agrave; cette adresse :<br />
			<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
			<h2>Informations importantes :</h2>
			L\'identifiant par d&eacute;faut est "<strong>root</strong>" et le mot de passe "<strong>automne</strong>".<br />
			Pensez &agrave; changer rapidement le mot de passe dans le profil utilisateur !<br />
			<br />
			Si vous avez choisi l\'installation de la D&eacute;mo, la partie publique sera visible &agrave; l\'adresse <a href="/" target="_blank">%s</a> une fois que vous vous serez connect&eacute; une premi&egrave;re fois &agrave; l\'administration de votre site.<br />
			<br />
			Vous pouvez maintenant supprimer l\'archive ayant servie &agrave; cette installation ainsi que le fichier install.php.<br />
			<span style="color:red;">Attention</span> : laisser ces fichiers sur un site en production repr&eacute;sente une faille importante de s&eacute;curit&eacute; pour votre site !<br />
			<br />
			Si vous souhaitez modifier certaines options saisies lors de cette installation, relancez le fichier install.php ou :
			<ul>
				<li>Modifiez les param&egrave;tres d\'Automne depuis le panneau d&eacute;di&eacute; depuis l\'administration.</li>
				<li>Editez le fichier /config.php se trouvant &agrave; la racine de votre installation d\'Automne.</li>
				<li>Editez le fichier de param&egrave;tres /automne/classes/modules/standard_rc.xml.</li>
			</ul>
			<strong>Pour profiter des fonctionnalit&eacute;s de publication et d&eacute;publication automatique</strong>, planifiez l\'ex&eacute;cution du script /automne/classes/scripts/daily_routine.php toutes les nuits dans votre crontab (ou dans les taches planifi&eacute;es de windows).<br /><br />
			<fieldset>
			<legend>Exemple pour la crontab sur serveur Unix</legend>
			0 0 * * * %s php '.$_SERVER['DOCUMENT_ROOT'].'/automne/classes/scripts/daily_routine.php<br /><br />
			Cette ligne de configuration &agrave; ajouter dans la crontab de votre serveur vous permettra de lancer les t&acirc;ches de publication et de d&eacute;publication automatiques, tous les jours &agrave; minuit.
			</fieldset>
			<br />
			Vous trouverez toute l\'aide n&eacute;cessaire pour l\'utilisation du logiciel sur <a href="http://www.automne.ws" target="_blank">www.automne.ws</a> et sur <a href="http://doc.automne.ws" target="_blank">doc.automne.ws</a>. N\'h&eacute;sitez pas &agrave; poser vos questions sur <a href="http://www.automne.ws/forum/" target="_blank">le forum</a>.<br /><br />
			Merci d\'utiliser Automne !<br />';
		break;
		case "en":
		default:
			//General labels
			$label_next = 'Next';
			$label_docroot = "Error, this file Must be at the server Document Root ! (%s)";
			$footer = 'Installing Automne version 4. For more informations, visit <a href="http://www.automne.ws" target="_blank">www.automne.ws</a>.';
			$needhelp = '<div id="needhelp"><a href="'.$_SERVER['SCRIPT_NAME'].'?step=help&install_language='.$install_language.'" target="_blank">Need help?</a></div>';
			//STEP Help
			$stepHelp_title = 'Help to Automne installation';
			$stepHelp_installation_help = 'If you have problems installing Automne - you just need clarification or if you encounter any errors - please ask your questions on <a href="http://www.automne.ws/forum/" target="_blank">the Automne forum</a>.<br /><br />
			You\'ll get a quick and appropriate help for your situation.<br /><br />
			To help us diagnose your problems, thank you to give as much information as possible about the type of hosting you use and the possible error messages you encounter.<br /><br />
			You can also provide the following diagnostic file to an administrator using private message or by email on <a href="mailto:contact@automne.ws">contact@automne.ws</a>.<br />
			This file contains all the configuration information for your server and will help us pinpoint the source of the problem.<br /><br />
			&raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'?file=info" target="_blank">Download the diagnostic file</a>.';
			
			
			//STEP check
			$error_stepCheck_php_error = 'Error, Your PHP version ('.phpversion().') is not compatible with Automne. You must have a version greater than 5.2.0.';
			$error_stepCheck_dir_not_writable_error = 'Error, Apache does not have write permissions on your website root directory (%s).';
			$error_stepCheck_safe_mode_error = 'Beware! The "safe_mode" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_pdo_error = 'Error, PDO extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.pdo.php" target="_blank">PHP installation and add it PDO extension</a>.';
			$error_stepCheck_pdo_mysql_error = 'Error, MySQL driver for PDO extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.pdo.php" target="_blank">PHP installation and add MySQL driver to PDO extension</a>.';
			$error_stepCheck_mbstring_error = 'Error,  Multibyte String (mbsring) extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.mbstring.php" target="_blank">PHP installation and add it mbstring extension</a>.';
			$error_stepCheck_magic_quotes_error = 'Beware! The "magic_quotes_gpc" option is active on your PHP configuration. This option is strongly disadvised because some Automne functions will not be available or should be degraded.';
			$error_stepCheck_magic_quotes_runtime_error = 'Beware! The "magic_quotes_runtime" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_magic_quotes_sybase_error = 'Beware! The "magic_quotes_sybase" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
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
			$stepGPL_explanation = 'Using Automne is subjected to acceptance of following GNU-GPL license.';
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
			$step2_explanation = 'Connection informations to the database are provided by your host. Take care that the database that you will use exists.';
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
			$step4_enter_url = 'Enter the URL of the website (the default should be correct). This is the URL of the site root.<br />If you enter a domain name, it must exist. You can change this at any time in the administration of the site.';
			$step4_url = 'URL * : http://';
			
			//STEP 5
			$error_step5_perms_files = 'Error, You must enter permission values for files ...';
			$error_step5_perms_dirs = 'Error, You must enter permission values for directories ...';
			$step5_title = 'Files and directories permissions:';
			$step5_explanation = 'Automne generates many files and directories. The following rights have been detected to be used by the server for files and directories creation.<br /><br />Do you agree with using these rights when Automne creates files or directories? (Automne must have write permission on all files in the server).<br /><br />Warning, modifying these rights can involve errors on the server if it does not accept them. Modify them only if you are sure of the values.<br /><br />More information about hosts on <a href="http://www.automne.ws/faq/">the FAQ pages.</a>';
			$step5_files_perms = 'Files permissions';
			$step5_dirs_perms = 'Directories permissions';
			
			//STEP 6
			$error_step6_choose_option = 'Error, You must choose an option ...';
			$step6_title = 'Scripts operation:';
			$step6_explanation = '
			Some operations require Automne running background tasks.<br /><br />
			Please choose the method of execution of these background tasks:<br />
			<ul>
				<li>Triggered by the browser: Slow process that requires the browser of an Automne administrator remains open, but that works on all servers. You should choose this on shared hosts and other solutions that do not have PHP-CLI.</li>
				<li>Scripts in the background on the server: Rapid process but that does not work on all servers. You can select it on dedicated servers which have the PHP-CLI executable installed (Help on PHP-CLI: <a href="http://www.php.net/manual/en/features.commandline.php" target="_blank">Using PHP from the command line</a>).</li>
			</ul>
			PHP-CLI detection on your server: <span style="color:red;">%s</span><br /><br />';
			$step6_CLIDetection_nosystem = 'Unavailable : Functions "system", "exec" and "passthru" inactive.';
			$step6_CLIDetection_windows = 'Detection impossible on Windows server';
			$step6_CLIDetection_available = 'Available';
			$step6_CLIDetection_unavailable = 'Detection impossible';
			$step6_CLIDetection_version_not_match = 'Available but wrong version';
			$step6_popup = 'Triggered by the browser';
			$step6_bg = 'Scripts in the background on the server';
			
			//STEP 7
			$error_step7_CLI_path = 'Error, You must enter a Path for the PHP-CLI ...';
			$error_step7_tmp_path = 'Error, You must specify a temporary path ...';
			$error_step7_valid_tmp_path = 'Error, You must specify a valid temporary path ...';
			$step7_title = 'Background scripts:';
			$step7_CLI_explanation = 'Enter here the path to the PHP-CLI executable.';
			$step7_CLI = 'PHP-CLI path';
			$step7_tmp_path_explanation = 'No Path founded for the temporary directory on this server. <br />Please enter a temporary path here (full path needed ex: /tmp or c:\tmp). This directory must be writable by the server.';
			$step7_tmp_path = 'Temp path';
			
			//STEP 8
			$error_step8_sessions = 'Error, You have a problem with server session creation. You must correct it before using Automne !';
			$error_step8_smtp_error = 'Error, No SMTP server found. Please Check your PHP installation or check the box below to cancel the application email sending.';
			$error_step8_label = 'Error, Please to enter a name for your site.';
			$step8_title = 'Installation finalisation:';
			$step8_htaccess_explanation = '<h2>.htaccess files</h2>Automne uses .htaccess files to enhance system security, protect some directories and specify some configurations.<br /><br /><strong>Check that the hosting server that you use accepts the usage of the .htaccess files.</strong>';
			$step8_no_application_email_title = '<h2>SMTP Server not found</h2>';
			$step8_no_application_email = 'Check this box if you want to disable sending email through the application';
			$step8_application_label = '<h2>Name your installation</h2>Enter a name for this installation of Automne.';
			$step8_label = 'Installation name';
			
			//STEP9
			$step9_title = 'Installation done!';
			$step9_alldone = '
			<strong>Automne installation is done.</strong><br />
			<br />
			You can access the website administration at:<br />
			<a href="/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
			<h2>Important informations:</h2>
			Default login is "<strong>root</strong>" and password is "<strong>automne</strong>".<br />
			Please modify this password in the user profile!<br />
			<br />
			If you chose to install the demo, the public site will be visible at the address <a href="/" target="_blank">%s</a> once you login once to the administration.<br />
			<br />
			You can now delete the package file used for this installation as well as the file install.php.<br />
			<span style="color:red;">Warning</span>, leaving these files on a production site represents a major breach of security for your site!<br />
			<br />
			If you want to change some options you enter during this installation, run again the install.php file or:
			<ul>
				<li>Change the settings from the dedicated Automne panel in administration.</li>
				<li>Edit the file /config.php located in the root of your installation of Automne.</li>
				<li>Edit the settings file /automne/classes/modules/standard_rc.xml.</li>
			</ul>
			<strong>If you want to use automatic publish and unpublish features</strong>, schedule the script /automne/classes/scripts/daily_routine.php every nigths in your crontab (or in the windows scheduled task).<br /><br />
			<fieldset>
			<legend>Example on Unix server</legend>
			0 0 * * * %s php '.$_SERVER['DOCUMENT_ROOT'].'/automne/classes/scripts/daily_routine.php<br /><br />
			This configuration line to add to the crontab of your server will start the task of automatic publishing and unpublishing daily at midnight.
			</fieldset>
			<br />
			You will find all necessary assistance for the use of the software on <a href="http://en.automne.ws" target="_blank">en.automne.ws</a> and <a href="http://man.automne.ws" target="_blank">man.automne.ws</a>.
			Feel free to ask your questions in <a href="http://www.automne.ws/forum/" target="_blank">the forum</a>. <br /><br />
			Thank you for using Automne!<br />
			<br />
			';
		break;
	}
	
	// +----------------------------------------------------------------------+
	// | STEP Help : Give some advise in case of problem                      |
	// +----------------------------------------------------------------------+
	if ($step === 'help') {
		$title ='<h1>'.$stepHelp_title.'</h1>';
		if ($error) {
			$content .= '<span class="error">'.$error.'</span><br />';
		}
		$content .= $stepHelp_installation_help;
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
			//check for PDO
			if (!class_exists('PDO')) {
				$error .= $error_stepCheck_pdo_error.'<br /><br />';
				$stopInstallation = true;
			} else {
				$pdo_drivers = PDO::getAvailableDrivers();
				if(!in_array('mysql', $pdo_drivers)){
					$error .= $error_stepCheck_pdo_mysql_error.'<br /><br />';
					$stopInstallation = true;
				}
			}
			//check for mbstring
			if (!function_exists('mb_substr') || !function_exists('mb_convert_encoding')) {
				$error .= $error_stepCheck_mbstring_error.'<br /><br />';
				$stopInstallation = true;
			}
			//check for safe_mode
			if (ini_get('safe_mode') && strtolower(ini_get('safe_mode')) != 'off') {
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
					<label for="db