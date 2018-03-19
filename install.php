<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2011 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.							 	  |
// +----------------------------------------------------------------------+
// | Author: Sebastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * PHP page : Automne Installation Manager
  * 
  * @package CMS
  * @subpackage installation
  * @author Sebastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Set some PHP configurations
error_reporting(E_ALL);
@set_time_limit(0);
@ini_set("memory_limit" , "64M");
@ini_set('magic_quotes_gpc', 0);
@ini_set('magic_quotes_runtime', 0);
@ini_set('magic_quotes_sybase', 0);
@ini_set('session.gc_probability', 0);
@ini_set('allow_call_time_pass_reference', 0);

//Set minimal version PHP 5.6.29
$MINIMAL_PHP_VERSION = '5.6.29';

/**
  *	Path of the REAL document root
  *	Default : $_SERVER["DOCUMENT_ROOT"]
  */
if ($_SERVER["DOCUMENT_ROOT"] != realpath($_SERVER["DOCUMENT_ROOT"])) {
	//rewrite server document root if needed
	$_SERVER["DOCUMENT_ROOT"] = realpath($_SERVER["DOCUMENT_ROOT"]);
}
//Demo FR file
$demoFr = 'demo-fr.tgz';
//Demo EN file
$demoEn = 'demo-en.tgz';

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
			if (version_compare(PHP_VERSION, $MINIMAL_PHP_VERSION) === -1) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, PHP version ('.PHP_VERSION.') not match</li>';
			} else {
				$content .= '<li class="atm-pic-ok">PHP version <strong style="color:green">OK</strong> ('.PHP_VERSION.')</li>';
			}
			//XML
			$pi = phpinfo_array(true);
			if (!isset($pi['xml'])) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, XML extension not installed</li>';
			} else {
				if (isset($pi['xml']['EXPAT Version'])) {
					$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, XML extension installed with Expat library.</li>';
				} else {
					//isset($pi['xml']['libxml2 Version'])
					$content .= '<li class="atm-pic-ok">XML extension <strong style="color:green">OK</strong></li>';
				}
			}
			//DOM
			if (!class_exists('DOMDocument')) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, DOM extension not installed</li>';
			} else{
				$content .= '<li class="atm-pic-ok">DOM extension <strong style="color:green">OK</strong></li>';
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
			if (!is_writable(realpath(dirname(__FILE__)))) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:red">Error</strong>, No permissions to write files on website directory ('.realpath(dirname(__FILE__)).')</li>';
			} else {
				$content .= '<li class="atm-pic-ok">Website root filesystem permissions are <strong style="color:green">OK</strong></li>';
			}
			//Email
			if (!@mail("root@localhost", "Automne SMTP Test", "Automne SMTP Test")) {
				$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, No SMTP server found</li>';
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
					$content .= '<li class="atm-pic-cancel"><strong style="color:orange">Warning</strong>, unable to find php CLI with command "which php" : '.$error.'</li>';
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
						if (version_compare($cliversion, $MINIMAL_PHP_VERSION) === -1) {
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
			$footer = 'Installation d\'Automne version 4. Pour toute information, visitez <a href="http://www.automne-cms.org" target="_blank">www.automne-cms.org</a>';
			$needhelp = '<div id="needhelp"><a href="'.$_SERVER['SCRIPT_NAME'].'?step=help&install_language='.$install_language.'" target="_blank">Besoin d\'aide ?</a></div>';
			
			//STEP Help
			$stepHelp_title = 'Aide &agrave; l\'installation d\'Automne';
			$stepHelp_installation_help = 'Si vous rencontrez des difficult&eacute;s pour installer Automne - que vous ayez simplement besoin d\'explications ou si vous rencontrez des erreurs - n\'h&eacute;sitez pas &agrave; poser vos questions sur <a href="http://www.automne-cms.org/forum/" target="_blank">le forum d\'Automne</a>.<br /><br />
			Vous y obtiendrez une aide rapide et adapt&eacute;e &agrave; votre situation.<br /><br />
			Pour nous aider &agrave; diagnostiquer vos probl&egrave;mes, merci de donner le plus d\'informations possible sur le type d\'h&eacute;bergement dont vous disposez ainsi que les messages d\'erreurs &eacute;ventuels que vous rencontrez. <br /><br />
			Vous pouvez aussi fournir le fichier de diagnostic suivant &agrave; un administrateur du forum via message priv&eacute; ou par email sur <a href="mailto:contact@automne-cms.org">contact@automne-cms.org</a>.<br />Ce fichier contient toutes les informations de configuration de votre serveur et il nous aidera &agrave; identifier pr&eacute;cis&eacute;ment la source du probl&egrave;me.<br /><br />
			&raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'?file=info" target="_blank">T&eacute;l&eacute;charger le fichier de diagnostic</a>.';
			
			//STEP check
			$error_docroot = "Erreur, Automne doit &ecirc;tre install&eacute; &agrave; la racine de votre serveur web : %s.<br />Vous devriez cr&eacute;er un h&ocirc;te virtuel sp&eacute;cifique pour Automne dans votre configuration d'Apache.";
			$error_stepCheck_php_error = 'Erreur, Votre version de PHP ('.phpversion().') n\'est pas compatible avec Automne. Vous devez avoir une version sup&eacute;rieure &agrave; la '.$MINIMAL_PHP_VERSION.'.';
			$error_stepCheck_dir_not_writable_error = 'Erreur, Apache ne poss&egrave;de pas les droits d\'&eacute;criture sur le r&eacute;pertoire racine (%s) de votre site web.';
			$error_stepCheck_safe_mode_error = 'Attention ! L\'option "safe_mode" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_pdo_error = 'Attention, l\'extension PDO pour PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.pdo.php" target="_blank">configuration de PHP et ajouter le support de PDO</a>.';
			$error_stepCheck_pdo_mysql_error = 'Attention, le driver MySQL pour l\'extension PDO de PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.pdo.php" target="_blank">configuration de PHP et ajouter le support de MySQL &agrave; PDO</a>.';
			$error_stepCheck_mbstring_error = 'Attention, l\'extension Multibyte String (mbsring) pour PHP n\'est pas disponible sur votre serveur. Veuillez v&eacute;rifier la <a href="http://www.php.net/manual/book.mbstring.php" target="_blank">configuration de PHP et ajouter le support de mbstring</a>.';
			$error_stepCheck_magic_quotes_error = 'Attention ! L\'option "magic_quotes_gpc" est active sur votre configuration de PHP. Cette option est fortement d&eacute;conseill&eacute;e car l\'ensemble des fonctions d\'Automne ne seront pas disponibles et/ou leurs fonctionnement sera d&eacute;grad&eacute;.';
			$error_stepCheck_magic_quotes_runtime_error = 'Attention ! L\'option "magic_quotes_runtime" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_magic_quotes_sybase_error = 'Attention ! L\'option "magic_quotes_sybase" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_register_globals_error = 'Attention ! L\'option "register_globals" est active sur votre configuration de PHP. Cette option est incompatible avec Automne. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_xml_error = 'Erreur, l\'extension XML n\'est pas install&eacute;e sur votre serveur. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_dom_error = 'Erreur, l\'extension DOM n\'est pas install&eacute;e sur votre serveur. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_xml_expat_error = 'Erreur, l\'extension XML est install&eacute;e avec EXPAT au lieu de LibXML. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_error = 'Erreur, l\'extension GD n\'est pas install&eacute;e sur votre serveur. V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_gif_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images GIF ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_jpeg_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images JPEG ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_gd_png_error = 'Erreur, les fonctionnalit&eacute;s de traitement d\'images PNG ne sont pas install&eacute;es (Extension GD). V&eacute;rifiez votre installation de PHP.';
			$error_stepCheck_memory_limit_error = 'Erreur, l\'utilisation m&eacute;moire des scripts PHP ne peut &ecirc;tre modifi&eacute;e et elle est limit&eacute;e &agrave; %so. Veuillez modifier votre configuration pour allouer un minimum de 64Mo de m&eacute;moire ou bien pour laisser les scripts PHP choisir leur utilisation m&eacute;moire.';
			$stepCheck_title = 'Compatibilit&eacute; de votre syst&egrave;me :';
			$stepCheck_installation_stopped = 'Vous ne pouvez poursuivre l\'installation d\'Automne ...<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne-cms.org/faq/">les FAQ en ligne.</a>';
			
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
			$step1_htaccess_warning = 'Attention, toute erreur dans ce fichier pourrait provoquer une erreur 500 sur le serveur.<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne-cms.org/faq/">les FAQ en ligne.</a>';
			
			//GPL STEP
			$stepGPL_title = 'Licence d\'exploitation :';
			$stepGPL_explanation = 'L\'utilisation d\'Automne est soumis &agrave; l\'acceptation de la licence GNU-GPL suivante.';
			$stepGPL_licenseNotFound = 'Le fichier de licence est introuvable, veuillez le consulter ici : <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a>';
			$stepGPL_accept = 'Acceptez vous les termes de cette licence ?';
			$stepGPL_yes = 'J\'accepte les termes de la licence.';
			$stepGPL_no = 'Je n\'accepte pas les termes de la licence.';
			
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
			$step2_PHPCLI_name = 'Chemin absolu de votre PHP CLI (facultatif)';
			
			//STEP 3
			$error_step3_must_choose_option = 'Erreur, vous devez choisir une option ...';
			$error_step3_SQL_conf = 'Attention : MySQL est configur&eacute; pour &ecirc;tre insensible &agrave; la casse.<br /><br />Si vous poursuivez l\'installation avec cette configuration de MySQL, vous ne pourrez pas transf&eacute;rer cette installation d\'Automne sur un serveur o&ugrave; MySQL est sensible &agrave; la casse (ce qui est g&eacute;n&eacute;ralement le cas des serveurs Unix/Linux).<br /><br />Pour changer cette configuration, vous devez &eacute;diter le fichier de configuration de MySQL (my.ini ou my.cnf) et y ajouter la ligne suivante dans la section [mysqld] du fichier :<pre>lower_case_table_names = 0</pre>';
			$error_step3_SQL_script = 'Erreur, syntaxe incorrecte dans le fichier : %s ou fichier manquant';
			$error_step3_Demo_script = 'Erreur durant l\'installation de la D&eacute;mo :'."\n\n".' %s';
			$step3_title = 'Choisissez un type d\'installation :';
			$step3_demo_FR = 'Automne avec la D&eacute;mo Fran&ccedil;aise (conseill&eacute; pour tester et apprendre le logiciel)';
			$step3_demo_EN = 'Automne avec la D&eacute;mo Anglaise';
			$step3_empty = 'Automne vide (conseill&eacute; pour cr&eacute;er un site &agrave; partir de z&eacute;ro)';
			$step3_skip = 'Conserver la Base de Donn&eacute;es actuelle';
			
			//STEP 4
			$error_step4_enter_url = 'Erreur, Vous devez saisir une adresse ...';
			$step4_title = 'Adresse du site web :';
			$step4_enter_url = 'Entrez l\'adresse du site web (la valeur par d&eacute;faut doit-&ecirc;tre correcte).<br /><br />Il s\'agit de l\'adresse de la racine du site (sans sous r&eacute;pertoire).<br />Si vous saisissez un nom de domaine, ce dernier doit exister. Vous pourrez modifier cela &agrave; tout moment dans l\'administration du site.';
			$step4_url = 'Adresse * : ';
			
			//STEP 5
			$error_step5_perms_files = 'Erreur, Vous devez entrer une valeur de permission pour les fichiers ...';
			$error_step5_perms_dirs = 'Erreur, Vous devez entrer une valeur de permission pour les dossiers ...';
			$step5_title = 'Permissions des fichiers et des dossiers :';
			$step5_explanation = 'Automne g&eacute;n&egrave;re un grand nombre de fichiers et de dossiers. Les droits suivant ont &eacute;t&eacute; detect&eacute;s comme &eacute;tant utilis&eacute;s par votre serveur.<br /><br />Etes-vous d\'accord pour les utiliser lorsque Automne cr&eacute;&eacute;ra des fichiers et des dossiers ? (Automne doit avoir le droit d\'&eacute;criture sur tous les fichiers du serveur).<br /><br />Attention, modifier ces droits peut entrainer des erreurs sur le serveur si ce dernier ne les accepte pas. Modifiez ces param&egrave;tres seulement si vous savez ce que vous faites.<br /><br />Plus d\'information sur les h&eacute;bergeurs sur <a href="http://www.automne-cms.org/faq/">les FAQ en ligne.</a>';
			$step5_files_perms = 'Permissions sur les fichiers';
			$step5_dirs_perms = 'Permissions sur les dossiers';
			
			//STEP 6
			$error_step6_choose_option = 'Erreur, vous devez choisir une option ...';
			$step6_title = 'Fonctionnement des scripts :';
			$step6_explanation = 'Certaines op&eacute;rations d\'Automne n&eacute;cessitent l\'ex&eacute;cution de t&acirc;ches de fond.<br /><br />
			Veuillez choisir la m&eacute;thode d\'ex&eacute;cution de ces t&acirc;ches de fond :<br />
			<ul>
				<li><strong>D&eacute;clench&eacute;es par le navigateur</strong> : Processus lent et qui n&eacute;cessite que le navigateur d\'un administrateur d\'Automne reste ouvert mais qui fonctionne sur tous les serveurs. Vous devez choisir cela sur les serveurs mutualis&eacute;s et autres solutions ne disposant pas de PHP-CLI.<br /><br /></li>
				<li><strong>Scripts en t&acirc;che de fond sur le serveur</strong> : Processus rapide mais qui ne fonctionne pas sur tous les serveurs. Vous pouvez choisir cela sur les serveurs d&eacute;di&eacute;s qui ont l\'ex&eacute;cutable PHP-CLI install&eacute; (Aide sur PHP-CLI : <a href="http://fr.php.net/manual/fr/features.commandline.php" target="_blank">Utiliser PHP en ligne de commande</a>).</li>
			</ul>
			<fieldset>D&eacute;tection de la pr&eacute;sence de PHP-CLI sur votre serveur : <span style="color:red;">%s</span></fieldset><br /><br />';
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
			$step8_htaccess_explanation = '<h2>Fichiers .htaccess</h2>Automne utilise des fichiers .htaccess pour renforcer la s&eacute;curit&eacute; du syst&egrave;me, prot&eacute;ger l\'acc&egrave;s de certains repertoires et sp&eacute;cifier certaines configurations.<noscript><br /><br /><strong>V&eacute;rifiez que le serveur d\'h&eacute;bergement que vous utilisez accepte bien l\'utilisation des fichiers .htaccess</strong></noscript>';
			$step8_htaccess_ok = 'Les fichiers .htaccess sont support&eacute;s par votre serveur.';
			$step8_htaccess_error = 'Erreur, les fichiers .htaccess ne sont pas support&eacute;s par votre serveur.<br />VOTRE INSTALLATION N\'EST PAS SECURIS&Eacute;E.<br />N\'employez pas cette configuration sur un serveur public !';
			$step8_no_application_email_title = '<h2>Serveur SMTP introuvable</h2>';
			$step8_no_application_email = 'Cochez cette case si vous souhaitez d&eacute;sactiver l\'envoi d\'email par l\'application';
			$step8_application_label = '<h2>Nommez votre installation</h2>Saisissez un nom pour cette installation d\'Automne.';
			$step8_label = 'Nom de l\'installation';
			
			//STEP9
			$step9_title = 'Installation termin&eacute;e !';
			$step9_alldone = '<h2>L\'installation d\'Automne est termin&eacute;e :</h2>
			<fieldset>
				<legend><strong>Vous pouvez acc&eacute;der &agrave; l\'administration du site &agrave; cette adresse</strong></legend>
				<a href="%s/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
				L\'identifiant par d&eacute;faut est "<strong>root</strong>" et le mot de passe "<strong>automne</strong>".<br />
				Pensez &agrave; changer rapidement le mot de passe dans le profil utilisateur !<br />
			</fieldset>
			<h2>Informations importantes :</h2>
			Si vous avez choisi l\'installation de la D&eacute;mo, la partie publique sera visible &agrave; l\'adresse <a href="%s/" target="_blank">%s/</a> une fois que vous vous serez connect&eacute; une premi&egrave;re fois &agrave; l\'administration de votre site.<br />
			<br />
			Vous pouvez maintenant supprimer les fichiers ayant servi &agrave; cette installation :<br />%s
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
			0 0 * * * %s php '.realpath(dirname(__FILE__).'/automne/classes/scripts/daily_routine.php').'<br /><br />
			Cette ligne de configuration &agrave; ajouter dans la crontab de votre serveur vous permettra de lancer les t&acirc;ches de publication et de d&eacute;publication automatiques, tous les jours &agrave; minuit.
			</fieldset>
			<br />
			Vous trouverez toute l\'aide n&eacute;cessaire pour l\'utilisation du logiciel sur <a href="http://www.automne-cms.org" target="_blank">www.automne-cms.org</a> et sur <a href="http://doc.automne-cms.org" target="_blank">doc.automne-cms.org</a>. N\'h&eacute;sitez pas &agrave; poser vos questions sur <a href="http://www.automne-cms.org/forum/" target="_blank">le forum</a>.<br /><br />
			Merci d\'utiliser Automne !<br />';
		break;
		case "en":
		default:
			//General labels
			$label_next = 'Next';
			$footer = 'Installing Automne version 4. For more informations, visit <a href="http://www.automne-cms.org" target="_blank">www.automne-cms.org</a>.';
			$needhelp = '<div id="needhelp"><a href="'.$_SERVER['SCRIPT_NAME'].'?step=help&install_language='.$install_language.'" target="_blank">Need help?</a></div>';
			//STEP Help
			$stepHelp_title = 'Help to Automne installation';
			$stepHelp_installation_help = 'If you have problems installing Automne - you just need clarification or if you encounter any errors - please ask your questions on <a href="http://www.automne-cms.org/forum/" target="_blank">the Automne forum</a>.<br /><br />
			You\'ll get a quick and appropriate help for your situation.<br /><br />
			To help us diagnose your problems, thank you to give as much information as possible about the type of hosting you use and the possible error messages you encounter.<br /><br />
			You can also provide the following diagnostic file to an administrator using private message or by email on <a href="mailto:contact@automne-cms.org">contact@automne-cms.org</a>.<br />
			This file contains all the configuration information for your server and will help us pinpoint the source of the problem.<br /><br />
			&raquo; <a href="'.$_SERVER['SCRIPT_NAME'].'?file=info" target="_blank">Download the diagnostic file</a>.';
			
			
			//STEP check
			$error_docroot = "Error, Automne must be installed at the server Document Root: %s.<br />You should create a specific Virtual Host for Automne in your Apache configuration.";
			$error_stepCheck_php_error = 'Error, Your PHP version ('.phpversion().') is not compatible with Automne. You must have a version greater than '.$MINIMAL_PHP_VERSION.'.';
			$error_stepCheck_dir_not_writable_error = 'Error, Apache does not have write permissions on your website root directory (%s).';
			$error_stepCheck_safe_mode_error = 'Beware! The "safe_mode" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_pdo_error = 'Error, PDO extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.pdo.php" target="_blank">PHP installation and add it PDO extension</a>.';
			$error_stepCheck_pdo_mysql_error = 'Error, MySQL driver for PDO extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.pdo.php" target="_blank">PHP installation and add MySQL driver to PDO extension</a>.';
			$error_stepCheck_mbstring_error = 'Error,  Multibyte String (mbsring) extension is not installed on your server. Please check your <a href="http://www.php.net/manual/book.mbstring.php" target="_blank">PHP installation and add it mbstring extension</a>.';
			$error_stepCheck_magic_quotes_error = 'Beware! The "magic_quotes_gpc" option is active on your PHP configuration. This option is strongly disadvised because some Automne functions will not be available or should be degraded.';
			$error_stepCheck_magic_quotes_runtime_error = 'Beware! The "magic_quotes_runtime" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_magic_quotes_sybase_error = 'Beware! The "magic_quotes_sybase" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_register_globals_error = 'Beware ! The "register_globals" option is active on your PHP configuration. This option is not compatible with Automne. Please Check your PHP installation.';
			$error_stepCheck_xml_error = 'Error, XML extension is not installed on your server. Please Check your PHP installation.';
			$error_stepCheck_dom_error = 'Error, DOM extension is not installed on your server. Please Check your PHP installation.';
			$error_stepCheck_xml_expat_error = 'Error, XML extension is installed with EXPAT instead of LibXML. Please Check your PHP installation.';
			$error_stepCheck_gd_error = 'Error, GD extension is not installed on your server. Please Check your PHP installation.';
			$error_stepCheck_gd_gif_error = 'Error, functionalities of GIF image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_gd_jpeg_error = 'Error, functionalities of JPEG image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_gd_png_error = 'Error, functionalities of PNG image processing are not installed (GD Extension). Please Check your PHP installation.';
			$error_stepCheck_memory_limit_error = 'Error, memory usage of PHP scripts can not be changed and it is limited to %sB. Please correct your configuration to allow a minimum of 64MB of memory or let PHP scripts to choose their memory usage.';
			$stepCheck_title = 'System compatibility:';
			$stepCheck_installation_stopped = 'You cannot continue Automne installation...<br /><br />More information about hosts on <a href="http://www.automne-cms.org/faq/">the FAQ pages.</a>';
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
			$step1_htaccess_warning = 'Attention, any error in this file could cause an error 500 on the server.<br /><br />More information about hosts on <a href="http://www.automne-cms.org/faq/">the FAQ pages.</a>';
			
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
			$step2_PHPCLI_name = 'PHP Cli asbolute path (optional)';
			
			//STEP 3
			$error_step3_must_choose_option = 'Error, You must choose an option ...';
			$error_step3_SQL_conf = 'Warning: MySQL is configured to be case insensitive.<br /><br />If you continue the install with this configuration of MySQL, you will not be able to transfer this installation of Automne on a server where MySQL is case sensitive (which is usually the case with Unix / Linux).<br /><br />To change this setting, you must edit the MySQL configuration file (my.cnf or my.ini) and add the following line in the [mysqld] part of the file: <pre> lower_case_table_names = 0 </pre>';
			$error_step3_SQL_script = 'Error, syntax error in sql script file: %s or file missing';
			$error_step3_Demo_script = 'Error during Demo installation :'."\n\n".'%s';
			$step3_title = 'Choose installation type:';
			$step3_demo_FR = 'Automne with French Demo';
			$step3_demo_EN = 'Automne with English Demo (advised to begin on the software)';
			$step3_empty = 'Automne empty (to create a site from scratch)';
			$step3_skip = 'Preserve the current database';
			
			//STEP 4
			$error_step4_enter_url = 'Error, You must enter an URL ...';
			$step4_title = 'Website URL:';
			$step4_enter_url = 'Enter the URL of the website (the default should be correct). This is the URL of the site root.<br />If you enter a domain name, it must exist. You can change this at any time in the administration of the site.';
			$step4_url = 'URL *: ';
			
			//STEP 5
			$error_step5_perms_files = 'Error, You must enter permission values for files ...';
			$error_step5_perms_dirs = 'Error, You must enter permission values for directories ...';
			$step5_title = 'Files and directories permissions:';
			$step5_explanation = 'Automne generates many files and directories. The following rights have been detected to be used by the server for files and directories creation.<br /><br />Do you agree with using these rights when Automne creates files or directories? (Automne must have write permission on all files in the server).<br /><br />Warning, modifying these rights can involve errors on the server if it does not accept them. Modify them only if you are sure of the values.<br /><br />More information about hosts on <a href="http://www.automne-cms.org/faq/">the FAQ pages.</a>';
			$step5_files_perms = 'Files permissions';
			$step5_dirs_perms = 'Directories permissions';
			
			//STEP 6
			$error_step6_choose_option = 'Error, You must choose an option ...';
			$step6_title = 'Scripts operation:';
			$step6_explanation = '
			Some operations require Automne running background tasks.<br /><br />
			Please choose the method of execution of these background tasks:<br />
			<ul>
				<li><strong>Triggered by the browser</strong>: Slow process that requires the browser of an Automne administrator remains open, but that works on all servers. You should choose this on shared hosts and other solutions that do not have PHP-CLI.</li>
				<li><strong>Scripts in the background on the server</strong>: Rapid process but that does not work on all servers. You can select it on dedicated servers which have the PHP-CLI executable installed (Help on PHP-CLI: <a href="http://www.php.net/manual/en/features.commandline.php" target="_blank">Using PHP from the command line</a>).</li>
			</ul>
			<fieldset>PHP-CLI detection on your server: <span style="color:red;">%s</span></fieldset><br /><br />';
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
			$step7_tmp_path_explanation = 'No Path found for the temporary directory on this server. <br />Please enter a temporary path here (full path needed ex: /tmp or c:\tmp). This directory must be writable by the server.';
			$step7_tmp_path = 'Temp path';
			
			//STEP 8
			$error_step8_sessions = 'Error, You have a problem with server session creation. You must correct it before using Automne !';
			$error_step8_smtp_error = 'Error, No SMTP server found. Please Check your PHP installation or check the box below to cancel the application email sending.';
			$error_step8_label = 'Error, Please to enter a name for your site.';
			$step8_title = 'Installation finalisation:';
			$step8_htaccess_explanation = '<h2>.htaccess files</h2>Automne uses .htaccess files to enhance system security, protect some directories and specify some configurations.<br /><br /><strong>Check that the hosting server that you use accepts the usage of the .htaccess files.</strong>';
			$step8_htaccess_ok = '.htaccess files are supported by your server.';
			$step8_htaccess_error = 'Error, .htaccess files are not supported : YOUR INSTALLATION IS NOT SECURE ! Do not use this configuration on a public server.';
			$step8_no_application_email_title = '<h2>SMTP Server not found</h2>';
			$step8_no_application_email = 'Check this box if you want to disable sending email through the application';
			$step8_application_label = '<h2>Name your installation</h2>Enter a name for this installation of Automne.';
			$step8_label = 'Installation name';
			
			//STEP9
			$step9_title = 'Installation done!';
			$step9_alldone = '
			<h2>Automne installation is done.</h2>
			<fieldset>
				<legend><strong>You can access the website administration at:</strong></legend>
				<a href="%s/automne/admin/" target="_blank">%s/automne/admin/</a><br /><br />
				Default login is "<strong>root</strong>" and password is "<strong>automne</strong>".<br />
				Please modify this password in the user profile!<br />
			</fieldset>
			<h2>Important informations:</h2>
			If you chose to install the demo, the public site will be visible at the address <a href="%s/" target="_blank">%s/</a> once you login once to the administration.<br />
			<br />
			You can now delete the files used for this installation :<br />%s
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
			0 0 * * * %s php '.realpath(dirname(__FILE__).'/automne/classes/scripts/daily_routine.php').'<br /><br />
			This configuration line to add to the crontab of your server will start the task of automatic publishing and unpublishing daily at midnight.
			</fieldset>
			<br />
			You will find all necessary assistance for the use of the software on <a href="http://en.automne-cms.org" target="_blank">en.automne-cms.org</a> and <a href="http://man.automne-cms.org" target="_blank">man.automne-cms.org</a>.
			Feel free to ask your questions in <a href="http://www.automne-cms.org/forum/" target="_blank">the forum</a>. <br /><br />
			Thank you for using Automne!<br />
			<br />';
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
		if (version_compare(phpversion(), $MINIMAL_PHP_VERSION) !== -1) {
			//check for document root writing
			if (!is_writable(realpath(dirname(__FILE__)))) {
				$error .= sprintf($error_stepCheck_dir_not_writable_error, realpath(dirname(__FILE__))).'<br /><br />';
				$stopInstallation = true;
			}
			//check for docroot
			/*if (realpath($_SERVER["DOCUMENT_ROOT"]) != realpath(dirname(__FILE__))) {
				$error .= sprintf($error_docroot, realpath(dirname(__FILE__))).'<br /><br />';
				$stopInstallation = true;
			}*/
			
			//XML
			$pi = phpinfo_array(true);
			if (!isset($pi['xml'])) {
				$error .= $error_stepCheck_xml_error.'<br /><br />';
				$stopInstallation = true;
			} else {
				if (isset($pi['xml']['EXPAT Version'])) {
					$error .= $error_stepCheck_xml_expat_error.'<br /><br />';
					$stopInstallation = true;
				}
			}
			//DOM
			if (!class_exists('DOMDocument')) {
				$stopInstallation = true;
				$error .= $error_stepCheck_dom_error.'<br /><br />';
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
		$directory = dir(realpath(dirname(__FILE__)));
		
		$archiveFound = false;
		while (false !== ($file = $directory->read())) {
			if ($file!='.' && $file!='..') {
				if ((strpos($file, '.tar.gz') !== false || strpos($file, '.tgz') !== false) && strpos($file, 'automne') !== false && strpos($file, '._') !== 0) {
					$archiveFound = true;
					$archiveFile = $file;
				}
				if ($file == 'cms_rc.php') {
					//archive already uncompressed, then skip to next installation step
					$step = 'gpl';
				}
			}
		}
	}
	//if archive found, uncompress it
	if (isset($archiveFound) && $archiveFound && $step==1) {
		if ($cms_action == 'extract') {
			//to avoid error on server with lots of PHP extensions, extend memory limit during this step
			$archive = new CMS_gzip_file_install(dirname(__FILE__)."/".$archiveFile);
			$error='';
			
			if (!$archive->hasError()) {
				$archive->set_options(array('basedir'=>dirname(__FILE__)."/", 'overwrite'=>1, 'level'=>1, 'dontUseFilePerms'=>1, 'forceWriting'=>1));
				if (is_dir(dirname(__FILE__)))  {
					if (method_exists($archive, 'extract_files')) {
						$extractArchive = true;
						$content .= sprintf($step1_extraction_to,$archiveFile,dirname(__FILE__)).' ...<br /><br />';
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
			if (file_exists(dirname(__FILE__).'/.htaccess')) {
				$htaccess = file_get_contents(dirname(__FILE__).'/.htaccess');
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
	
	//if archive found, uncompress it
	if ($step === 'gpl') {
		if ($cms_action == 'acceptlicense') {
			if (isset($_POST["license"]) && $_POST["license"] == 'yes') {
				//go to next step
				$step = 2;
			} else {
				//go to www.automne-cms.org
				header("Location: http://www.automne-cms.org");
				exit;
			}
		} else {
			$title ='<h1>'.$stepGPL_title.'</h1>';
			$content .= '
			'.$stepGPL_explanation.'<br /><br />';
			if (@file_exists(dirname(__FILE__).'/automne/LICENSE-GPL')) {
				$content .= '<div class="license"><pre>'.file_get_contents(dirname(__FILE__).'/automne/LICENSE-GPL').'</pre></div><br /><br />';
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
	if (file_exists(dirname(__FILE__).'/cms_rc_frontend.php')) {
		//Remove session if exists
		if($step < 4){
			//prevent error due to tables sessions and modules missing on cms_rc_frontend.php inclusion
			define("APPLICATION_CONFIG_LOADED",false);
		}
		require_once(dirname(__FILE__).'/cms_rc_frontend.php');
		//if file config.php exists then go to next step
		if ($step == 2 && file_exists(dirname(__FILE__).'/config.php')) {
			$step = 3;
		}
	} elseif ($step != 'check' && $step != 'gpl' && $step > 1) {
		die(sprintf($error_step2_no_cms_rc_admin,dirname(__FILE__)));
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
			$dbhostValue = isset($_POST["dbhost"]) ? $_POST["dbhost"]:'127.0.0.1';
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
					<br/>
					<label for="phpcli">'.$step2_PHPCLI_name.' : <input id="phpcli" name="phpcli" type="text" value="'.@$_POST['phpcli'].'" /></label><br/>
					<input type="submit" class="submit" value="'.$label_next.'" />
				</div>
			</form>
			';
		} else {
			//create config file with valid DB infos
			$configFile = new CMS_file(dirname(__FILE__)."/config.php");
			
			$configContent = '<?php
/**
  * AUTOMNE CONFIGURATION FILE
  * This file is generated by Automne installation process (install.php file).
  * If you need to modify any configuration constants of files
  * cms_rc.php, cms_rc_admin.php or cms_rc_frontend.php
  * simply define the constant and it\'s new value in this file
  * 
  * @package Automne
  * @subpackage config
  * @author Sebastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

define("APPLICATION_DB_HOST", "'.$_POST["dbhost"].'");
define("APPLICATION_DB_NAME", "'.$_POST["dbname"].'");
define("APPLICATION_DB_USER", "'.$_POST["dbuser"].'");
define("APPLICATION_DB_PASSWORD", "'.$_POST["dbpass"].'");


';
if(isset($_POST["phpcli"])){
	$configContent .= '
//Custom PHP cli path
define("PATH_PHP_CLI_UNIX","'.$_POST["phpcli"].'");
';

}
if (realpath($_SERVER["DOCUMENT_ROOT"]) != realpath(dirname(__FILE__))) {
	//append path info if needed
	$configContent .= 'define("PATH_REALROOT_WR", \''.pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME).'\');';
}
$configContent .= '
?>';
			
			$configFile->setContent($configContent);
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
			if (!isset($_POST["installationType"]) || !$_POST["installationType"]) {
				$error .= $error_step3_must_choose_option.'<br />';
			}
			if (isset($_POST["installationType"]) && $_POST["installationType"] == 'keep') {
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
		
		//check mysql case sensitive configuration
		$caseSensitiveDB = true;
		$sql = "
			SHOW VARIABLES where Variable_name = 'lower_case_table_names';
			";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			$r = $q->getArray();
			if ($r['Value'] != 0) {
				$caseSensitiveDB = false;
			}
		}
		
		if ($error || $cms_action != "dbscripts") {
			$title = '<h1>'.$step3_title.'</h1>';
			if ($error) {
				$content .= '<span class="error">'.$error.'</span><br />';
			}
			if (!$caseSensitiveDB) {
				$content .= '<span class="error">'.$error_step3_SQL_conf.'</span><br />';
			}
			$content .= '
			<form action="'.$_SERVER["PHP_SELF"].'" method="post" onsubmit="check();">
				<input type="hidden" name="step" value="3" />
				<input type="hidden" name="cms_action" value="dbscripts" />
				<input type="hidden" name="install_language" value="'.$install_language.'" />';
				if (file_exists(dirname(__FILE__).'/'.$demoEn)) {
					$content .= '<label for="demoen"><input id="demoen" type="radio" name="installationType" value="demoen" /> '.$step3_demo_EN.'</label><br />';
				}
				if (file_exists(dirname(__FILE__).'/'.$demoFr)) {
					$content .= '<label for="demofr"><input id="demofr" type="radio" name="installationType" value="demofr" /> '.$step3_demo_FR.'</label><br />';
				}
				$content .= '
				<label for="empty"><input id="empty" type="radio" name="installationType" value="clean" /> '.$step3_empty.'</label><br />';
				if ($exists === true) {
					$content .= '<label for="skip"><input id="skip" type="radio" name="installationType" value="keep" /> '.$step3_skip.'</label><br />';
				}
			$content .= '
				<input type="submit" class="submit" value="'.$label_next.'" />
			</form>
			';
		} elseif ($step == 3) {
			//load DB scripts
			
			switch ($_POST['installationType']) {
				case 'demoen':
					$error = '';
					if (!patch(dirname(__FILE__).'/'.$demoEn, $error)) {
						die(sprintf($error_step3_Demo_script, $error));
					}
				break;
				case 'demofr':
					$error = '';
					if (!patch(dirname(__FILE__).'/'.$demoFr, $error)) {
						die(sprintf($error_step3_Demo_script, $error));
					}
				break;
				case 'clean':
					//Import DB structure
					$structureScript = PATH_MAIN_FS."/sql/automne4.sql";
					if (file_exists($structureScript) && CMS_patch::executeSqlScript($structureScript, true)) {
						CMS_patch::executeSqlScript($structureScript);
					} else {
						die(sprintf($error_step3_SQL_script,$structureScript));
					}
					
					//Set websites language like the current installation language
					$q = new CMS_query("update websites set language_web='".io::sanitizeSQLString($install_language)."'");
				break;
			}
			
			//Import DB messages
			//get all SQL files of the message dir
			$files = glob(PATH_MAIN_FS."/sql/messages/*/*.sql", GLOB_NOSORT);
			if (is_array($files)) {
				foreach($files as $file) {
					if (file_exists($file) && CMS_patch::executeSqlScript($file, true)) {
						CMS_patch::executeSqlScript($file);
					} else {
						die(sprintf($error_step3_SQL_script,$file));
					}
				}
			} else {
				die(sprintf($error_step3_SQL_script, PATH_MAIN_FS."/sql/messages/*/*.sql"));
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
			$protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && strtolower($_SERVER["HTTPS"]) != 'off') ? 'https://' : 'http://';
			$websiteUrl = isset($_POST["website"]) ? $_POST["website"] : $protocol . $_SERVER["HTTP_HOST"];
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
			if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
				//skip chmod step on windows platform
				$step = 6;
			}  else {
				$step = 5;
			}
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
					$configFile = new CMS_file(dirname(__FILE__)."/config.php");
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
					$configFile = new CMS_file(dirname(__FILE__)."/config.php");
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
			@touch(dirname(__FILE__).'/testfile.php');
			$stat = @stat(dirname(__FILE__).'/testfile.php');
			$fileChmod = substr(decoct($stat['mode']),-4,4);
			@unlink(dirname(__FILE__).'/testfile.php');
			
			//Check directory creation with default permissions
			@mkdir(dirname(__FILE__).'/testdir');
			$stat = @stat(dirname(__FILE__).'/testdir');
			$dirChmod = substr(decoct($stat['mode']),-4,4);
			@rmdir(dirname(__FILE__).'/testdir');
			
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
			</form>';
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

			$phpclibinary = 'php';
			if(PATH_PHP_CLI_UNIX){
				$phpclibinary = PATH_PHP_CLI_UNIX;
			}
			if (!(function_exists('exec') || !function_exists('passthru')) && !function_exists('system')) {
				$clidetection = $step6_CLIDetection_nosystem;
				$cliAvailable = false;
			}
			if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
				$clidetection = $step6_CLIDetection_windows;
				$cliAvailable = true;
				$windows = true;
			} else {
				if (substr(CMS_patch::executeCommand('which '.$phpclibinary.' 2>&1',$error),0,1) == '/' && !$error) {
					//test CLI version
					$return = CMS_patch::executeCommand($phpclibinary.' -v',$error);
					if (strpos(strtolower($return), '(cli)') !== false) {
						$cliversion = trim(str_replace($phpclibinary.' ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
						if (version_compare($cliversion, $MINIMAL_PHP_VERSION) === -1) {
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
				$cliPath = isset($_POST["cliPath"]) ? $_POST["cliPath"] : "php";
				//test for CLI proveded
				if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
					$return = CMS_patch::executeCommand('"'.$cliPath.'" -v',$error);
				} else {
					$return = CMS_patch::executeCommand(escapeshellcmd($cliPath).' -v',$error);
				}
				$error = '';
				if (strpos(strtolower($return), '(cli)') === false) {
					$error .= $error_step7_CLI_path.'<br />';
				} else {
					$cliversion = trim(str_replace('php ', '', substr(strtolower($return), 0, strpos(strtolower($return), '(cli)'))));
					if (version_compare($cliversion, $MINIMAL_PHP_VERSION) === -1) {
						$error .= $step6_CLIDetection_version_not_match.' ('.$cliversion.')<br />';
					} else {
						if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
							//add CLI path to config.php file
							$configFile = new CMS_file(dirname(__FILE__)."/config.php");
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
						} else {
							//add CLI path to config.php file
							$configFile = new CMS_file(dirname(__FILE__)."/config.php");
							$configFileContent = $configFile->readContent("array","rtrim");
							$skip = false;
							foreach ($configFileContent as $lineNb => $aLineOfConfigFile) {
								if (strpos($aLineOfConfigFile, "PATH_PHP_CLI_UNIX") !== false) {
									$configFileContent[$lineNb] = 'define("PATH_PHP_CLI_UNIX", \''.$cliPath.'\');';
									$skip = true;
								}
							}
							if (!$skip) {
								$configFileContent[sizeof($configFileContent)-1] = 'define("PATH_PHP_CLI_UNIX", \''.$cliPath.'\');';
								$configFileContent[sizeof($configFileContent)] = '?>';
							}
							$configFile->setContent($configFileContent);
							$configFile->writeToPersistence();
						}
					}
				}
			}
			
			//Temporary path (if needed)
			if (isset($_POST["needTmpPath"]) && $_POST["needTmpPath"] && (!isset($_POST["tmpPath"]) || !$_POST["tmpPath"])) {
				$error .= $error_step7_tmp_path.'<br />';
			} elseif (isset($_POST["needTmpPath"]) && $_POST["needTmpPath"]) {
				//check tmpPath
				$tmpPathOK = false;
				if (@is_dir($_POST["tmpPath"]) && is_writable($_POST["tmpPath"])) {
					$tmpPath = $_POST["tmpPath"];
					$tmpPathOK = true;
				} elseif (!is_file($_POST["tmpPath"]) && @mkdir($_POST["tmpPath"])) {
					if (@is_dir($_POST["tmpPath"]) && is_writable($_POST["tmpPath"])) {
						$tmpPath = $_POST["tmpPath"];
						$tmpPathOK = true;
					}
				}
				$tmpPathOK = realpath($tmpPathOK);
				if ($tmpPathOK) {
					//add tmp path to config.php file
					$configFile = new CMS_file(dirname(__FILE__)."/config.php");
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
			$needCliPath = false;
			$cliPath = "";
			if ($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1) {
				if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
					$needCliPath = true;
					$cliPath = isset($_POST["cliPath"]) ? $_POST["cliPath"] : PATH_PHP_CLI_WINDOWS;
				} elseif(substr(CMS_patch::executeCommand('which php 2>&1',$error),0,1) !== '/') {
					$return = CMS_patch::executeCommand('php -v',$error);
					if (strpos(strtolower($return), '(cli)') === false) {
						$needCliPath = true;
						$cliPath = isset($_POST["cliPath"]) ? $_POST["cliPath"] : PATH_PHP_CLI_UNIX;
					}
				}
			}
			//CHMOD scripts with good values
			$scriptsFiles = CMS_file::getFileList(PATH_PACKAGES_FS.'/scripts/*.php');
			foreach ($scriptsFiles as $aScriptFile) {
				//then set it executable
				CMS_file::makeExecutable($aScriptFile["name"]);
			}
			
			//test temporary directory and create it if none found
			$tmpPath ='';
			if (@is_dir(ini_get("session.save_path")) && is_writable(PATH_TMP_FS)) {
				$tmpPath = ini_get("session.save_path");
			} elseif (@is_dir(PATH_PHP_TMP) && is_writable(PATH_PHP_TMP)) {
				$tmpPath = PATH_PHP_TMP;
			} else {
				if (@is_dir(PATH_TMP_FS) && is_writable(PATH_TMP_FS)) {
					$tmpPath = realpath(PATH_TMP_FS);
					//add tmp path to config.php file
					$configFile = new CMS_file(dirname(__FILE__)."/config.php");
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
			if (($moduleParameters['USE_BACKGROUND_REGENERATOR'][0] == 1 && $needCliPath) || !$tmpPath) {
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
						'.$step7_CLI.'  : <input type="text" name="cliPath" value="'.htmlspecialchars($cliPath).'" /><br />';
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
			@chmod(dirname(__FILE__).'/index.php', octdec(FILES_CHMOD));
			@chmod(dirname(__FILE__).'/config.php', octdec(FILES_CHMOD));
			
			//deploy htaccess files
			$automnePatch = new CMS_patch();
			$automnePatch->automneGeneralScript();
			
			//force regeneration of first page to avoid any error
			$rootPage = CMS_tree::getPageByID(1);
			if ($rootPage && is_object($rootPage) && !$rootPage->hasError()) {
				$rootPage->regenerate(true);
			}
		}
		
		//Check sessions creation
		$session = true;
		if (function_exists("session_start")) {
			@error_reporting(0);
			if (ini_get("session.save_path") && !@is_dir(ini_get("session.save_path"))) {
				@mkdir(ini_get("session.save_path"));
			}
			@error_reporting(E_ALL ^ E_NOTICE);
		} else {
			$session = false;
		}
		if ($session == false) {
			$error .= $error_step8_sessions.'<br />';
		}
		
		//Recompile Polymod Definitions
		CMS_polymod::compileDefinitions();
		
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
				<input type="hidden" name="install_language" value="'.$install_language.'" />';
				if ($no_application_email) {
					$content .= $step8_no_application_email_title.'<label for="no_application_email"><input type="checkbox" id="no_application_email" name="no_application_email" value="1" /> '.$step8_no_application_email.'</label><br /><br />';
				}
				$content .= $step8_htaccess_explanation.'<br /><br />
				<div id="htaccess-ok" style="display:none;" class="valid">'.$step8_htaccess_ok.'</div>
				<div id="htaccess-nok" style="display:none;" class="error">'.$step8_htaccess_error.'</div>
				<script type="text/javascript">
					function getHTTPObject() {
						var xmlhttp = false;
						responseXML = null;
						/*@cc_on
						@if (@_jscript_version >= 5)
							var msxml = new Array(\'MSXML2.XMLHTTP.5.0\',\'MSXML2.XMLHTTP.4.0\',\'MSXML2.XMLHTTP.3.0\',\'MSXML2.XMLHTTP\',\'Microsoft.XMLHTTP\');
							for(var i=0; i<msxml.length; i++){
								try {
									// Instantiates XMLHttpRequest for IE and assign to xmlhttp.
									xmlhttp = new ActiveXObject(msxml[i]);
									if(xmlhttp){
										break;
									}
								} catch(e){}
							}
							
							@else
								xmlhttp = false;
						@end @*/
						if (!xmlhttp && typeof XMLHttpRequest != \'undefined\') {
							try {
								xmlhttp = new XMLHttpRequest();
							} catch (e) {
								xmlhttp = false;
							}
						}
						return xmlhttp;
					}
					function checkHTAccess() {
						var xmlhttp = getHTTPObject();
						var response;
						xmlhttp.onreadystatechange=function() {
							if (xmlhttp.readyState == 4) {
								if (xmlhttp.status && xmlhttp.status == 403) {
									document.getElementById(\'htaccess-ok\').style.display=\'block\';
									return true;
								} else if (xmlhttp.status) {
									document.getElementById(\'htaccess-nok\').style.display=\'block\';
									return false;
								}
							}
						}
						//add timestamp at end of query to avoid navigator cache
						var time = new Date();
						url = \''.PATH_AUTOMNE_CHMOD_SCRIPT_WR.'?time=\' + time.getTime();
						xmlhttp.open("GET", url, true);
						xmlhttp.send(null);
					}
					checkHTAccess();
				</script>';
				
				$content .= $step8_application_label.'<br /><br />
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
		if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
			$uname = 'www-data';
		} else {
			if (function_exists('posix_getpwuid') && function_exists('posix_getuid')) {
			  $uid = @posix_getpwuid(@posix_getuid());
			  $uname = isset($uid['name']) ? $uid['name'] : @posix_getuid();
			}
			if (!$uname) {
				$uname = 'www-data';
			}
		}
		//create archives listing to inform user which file to delete
		$archives = array();
		$archiveFound = false;
		$directory = dir(dirname(__FILE__));
		while (false !== ($file = $directory->read())) {
			if ($file!='.' && $file!='..') {
				if ((strpos($file, '.tar.gz')!==false || strpos($file, '.tgz')!==false) && strpos($file, 'automne')!==false) {
					$archiveFound = true;
					$archiveFile = $file;
				}
			}
		}
		$archives[] = 'install.php';
		if ($archiveFound) {
			$archives[] = $archiveFile;
		}
		if (file_exists(dirname(__FILE__).'/'.$demoFr)) {
			$archives[] = $demoFr;
		}
		if (file_exists(dirname(__FILE__).'/'.$demoEn)) {
			$archives[] = $demoEn;
		}
		$archivesNames = '<ul>';
		foreach ($archives as $archive) {
			$archivesNames .= '<li>'.$archive.'</li>';
		}
		$archivesNames .= '</ul>';
		$mainURL = CMS_websitesCatalog::getMainURL().PATH_REALROOT_WR;
		$content .= sprintf($step9_alldone, $mainURL, $mainURL, $mainURL, $mainURL, $archivesNames, $uname);
	}
	
	// +----------------------------------------------------------------------+
	// | RENDERING                                                            |
	// +----------------------------------------------------------------------+
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Automne :: Installation</title>
	<style type="text/css">
		body{
			background-color:	#e9f1da;
			font-family:		arial,verdana,helvetica,sans-serif;
			font-size:			13px;
			margin:				0;
			padding:			0;
		}
		.error {
			color:				orange;
			border:				2px solid red;
			font-weight:		bold;
			display:			block;
			padding:			5px;
			margin-bottom:		10px;
		}
		.valid {
			border:				2px solid green;
			font-weight:		bold;
			display:			block;
			padding:			5px;
			margin-bottom:		10px;
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
		h2{
			font-size:			13px;
			color:				#8cbe35;
			margin-bottom:		15px;
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
		#needhelp a {
			float:				right;
			border:				1px solid #E9F1DA;
			font-weight:		bold;
			margin:				3px 10px;
			padding:			5px;
			border-radius: 			7px;
			-moz-border-radius:		7px;
			-webkit-border-radius:	7px;
			box-shadow:				2px 2px 3px #888;
			-moz-box-shadow:		2px 2px 3px #888;
			-webkit-box-shadow:		2px 2px 3px #888;
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
			font-size:			13px;
			font-weight:		bold;
			border: 			1px solid #fff;
			padding: 			.5em;
			color:				#fff;;
			background-color:	#ABD64A;
			float:				right;
			line-height: 		1; 
			text-decoration: 	none; 
			-moz-border-radius: .4em; 
			-webkit-border-radius: .4em; 
			border-radius:		.4em;
			-moz-box-shadow: 	0 1px 3px rgba(0,0,0,0.25); 
			-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.25); 
			text-shadow: 		0 -1px 1px rgba(0,0,0,0.25); 
			border-bottom: 		1px solid rgba(0,0,0,0.25); 
			position: 			relative; 
			overflow: 			visible;
			width: 				auto; 
		}
		ul.atm-server {
			padding:			10px 0 0 0;
			margin:				0;
			list-style-image:	none;
			list-style-position:outside;
			list-style-type:	none;
		}
		ul.atm-server li {
			background-repeat:	no-repeat;
		    padding:			2px 0 6px 20px;
		}
		.atm-pic-ok {
			background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
			background-position:0px -91px;
		}
		.atm-pic-cancel{
			background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
			background-position:0px -182px;
		}
		.atm-pic-question{
			background-image:	url('.$_SERVER['SCRIPT_NAME'].'?file=pictos);
			background-position:0px 0px;
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
			'.($step != 'help' ? $needhelp : '').'
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
			if (file_exists(dirname(__FILE__).'/config.php')) {
				@unlink(dirname(__FILE__).'/config.php');
			}
			//append .htaccess content if any
			if (isset($_POST['htaccess']) && file_exists(dirname(__FILE__).'/.htaccess')) {
				file_put_contents(dirname(__FILE__).'/.htaccess', "\n\n".$_POST['htaccess'], FILE_APPEND);
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
		case 'pictos':
			$file = base64_decode('
				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');
			header('Content-Type: image/png');
			header('Content-Length: '.(string) strlen($file));
			echo $file;
			exit;
		break;
		case 'info':
			$phpinfo = print_r(phpinfo_array(true), true);
			
			header("Cache-Control: ");
			header("Pragma: ");
			header('Content-Type: application/octet-stream');
			header('Content-Length: '.(string) strlen($phpinfo));
			header('Content-Disposition: attachment; filename="infos-'.date('Ymd').'.txt"');
			
			echo $phpinfo;
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

//Return an array of all phpinfo values
function phpinfo_array($return=false){
	ob_start();
	phpinfo(-1);
	
	$pi = preg_replace(
	array('#^.*<body>(.*)</body>.*$#ms', '#<h2>PHP License</h2>.*$#ms',
	'#<h1>Configuration</h1>#',  "#\r?\n#", "#</(h1|h2|h3|tr)>#", '# +<#',
	"#[ \t]+#", '#&nbsp;#', '#  +#', '# class=".*?"#', '%&#039;%',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)" alt="PHP Logo" /></a>'
	.'<h1>PHP Version (.*?)</h1>(?:\n+?)</td></tr>#',
	'#<h1><a href="(?:.*?)\?=(.*?)">PHP Credits</a></h1>#',
	'#<tr>(?:.*?)" src="(?:.*?)=(.*?)"(?:.*?)Zend Engine (.*?),(?:.*?)</tr>#',
	"# +#", '#<tr>#', '#</tr>#'),
	array('$1', '', '', '', '</$1>' . "\n", '<', ' ', ' ', ' ', '', ' ',
	'<h2>PHP Configuration</h2>'."\n".'<tr><td>PHP Version</td><td>$2</td></tr>'.
	"\n".'<tr><td>PHP Egg</td><td>$1</td></tr>',
	'<tr><td>PHP Credits Egg</td><td>$1</td></tr>',
	'<tr><td>Zend Engine</td><td>$2</td></tr>' . "\n" .
	'<tr><td>Zend Egg</td><td>$1</td></tr>', ' ', '%S%', '%E%'),
	ob_get_clean());
	
	$sections = explode('<h2>', strip_tags($pi, '<h2><th><td>'));
	unset($sections[0]);
	
	$pi = array();
	foreach($sections as $section){
		$n = substr($section, 0, strpos($section, '</h2>'));
		preg_match_all(
		'#%S%(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?(?:<td>(.*?)</td>)?%E%#',
		$section, $askapache, PREG_SET_ORDER);
		foreach($askapache as $m)
			$pi[$n][$m[1]]=(!isset($m[3])||@$m[2]==$m[3]) ? @$m[2] : array_slice($m,2);
	}
	
	return ($return === false) ? print_r($pi) : $pi;
}

//Pass a patch on Automne
//Give the path file (FS relative) in parameter
//Return true on success or false on failure
function patch($patchFile, &$error) {
	$archive = new CMS_gzip_file($patchFile);
	if (!$archive->hasError()) {
		$archive->set_options(array('basedir'=>PATH_TMP_FS."/", 'overwrite'=>1, 'level'=>1, 'dontUseFilePerms'=>1, 'forceWriting'=>1));
		if (is_dir(PATH_TMP_FS))  {
			if (!method_exists($archive, 'extract_files') || !$archive->extract_files()) {
				$error = 'Error : Extraction error...';
				return false;
			}
		} else {
			$error = 'Error : Extraction directory does not exist';
			return false;
		}
	} else {
		$error = 'Error : Unable to extract archive wanted '.$filename.'. It is not a valid format...';
		return false;
	}
	
	if (!$archive->hasError()) {
		unset($archive);
	} else {
		$error = 'Extraction error...';
		return false;
	}
	
	//Check files content
	$automnePatch = new CMS_patch();
	
	//read patch param file and check versions
	$patchFile = new CMS_file(PATH_TMP_FS."/patch");
	
	if ($patchFile->exists()) {
		$patch = $patchFile->readContent("array");
	} else {
		$error = 'Error : File '.PATH_TMP_FS.'/patch does not exists ...';
		return false;
	}
	if (!$automnePatch->checkPatch($patch)) {
		$error = 'Error : Patch does not match current version ...';
		return false;
	}
	
	//read install param file and do maximum check on it before starting the installation process
	$installFile = new CMS_file(PATH_TMP_FS."/install");
	if ($installFile->exists()) {
		$install = $installFile->readContent("array");
	} else {
		$error = 'Error : File '.PATH_TMP_FS.'/install does not exists ...';
		return false;
	}
	$installError = $automnePatch->checkInstall($install, $errorsInfos);
	if ($installError) {
		$error = 'Error : Invalid install file :';
		$error .= $installError;
		return false;
	}
	
	//start Installation process
	$automnePatch->doInstall($install);
	$installError = false;
	$return = $automnePatch->getReturn();
	foreach ($return as $line) {
		if ($line['type'] == 'report') {
			$error .= $line['text'];
		}
	}
	
	if ($installError) {
		$error = 'Error during installation process : '.$error;
		return false;
	}
	
	//remove temporary files
	!CMS_file::deltree(PATH_TMP_FS);
	
	return true;
}

/**
  * Class CMS_archive_install, CMS_tar_file_install, CMS_gzip_file_install
  *
  * This script manages TAR/GZIP/BZIP2/ZIP archives
  *
  * Based on an original script "TAR/GZIP/BZIP2/ZIP ARCHIVE CLASSES 2.0"
  * from Devin Doucette
  *
  * @package CMS
  * @subpackage files
  * @author C&eacute;dric Soret <cedric.soret@ws-interactive.fr> &
  * @author S&eacute;bastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
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
	function __construct($name) {
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
		echo "<br /><pre><b>AUTOMNE INSTALLATION PROCESS error : ".$errorMessage."</b></pre><br />\n";
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
	 * @return array $files found in the directory
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
	function __construct($name)
	{
		if (trim($name) == '') {
			$this->_raiseError(get_class($this)." : Not a valid name given to archive ".$name);
			return;
		}
		parent::__construct($name);
		$this->options['type'] = "tar";
	}

	/**
	 * Extract files from the archive
	 * 
	 * @return true on success
	 */
	function extract_files(){
		if (defined('APPLICATION_IS_WINDOWS') && APPLICATION_IS_WINDOWS) {
			return $this->extract_files_windows();
		}else{
			$pwd = getcwd();
			chdir($this->options['basedir']);
			$stdout = exec("tar -zxf ".$this->options['name'] . " && echo OK || echo KO");
			if(preg_match('/OK/',$stdout)){
				return true;
			}else{
				return false;
			}
			chdir($pwd);
		}
	}

	function extract_files_windows() 
	{
		$pwd = getcwd();
		chdir($this->options['basedir']);

		if ($fp = $this->open_archive()) {
			if ($this->options['inmemory'] == 1) {
				$this->files = array ();
			}

			while ($block = fread($fp, 512)) {
				$temp = unpack("a100name/a8mode/a8uid/a8gid/a12size/a12mtime/a8checksum/a1type/a100temp/a6magic/a2temp/a32temp/a32temp/a8temp/a8temp/a155prefix/a12temp", $block);
				$file = array ('name' => trim($temp['prefix'].$temp['name']), 'stat' => array (2 => $temp['mode'], 4 => octdec($temp['uid']), 5 => octdec($temp['gid']), 7 => octdec($temp['size']), 9 => octdec($temp['mtime']),), 'checksum' => octdec($temp['checksum']), 'type' => $temp['type'], 'magic' => $temp['magic'],);
				if ($file['checksum'] == 0x00000000) {
					break;
				} else
					/*if ($file['magic'] != "ustar") {
						$this->raiseError("This script does not support extracting this type of tar file.");
						break;
					}*/
				$block = substr_replace($block, "        ", 148, 8);
				$checksum = 0;
				for ($i = 0; $i < 512; $i ++) {
					$checksum += ord(io::substr($block, $i, 1));
				}
				if ($file['checksum'] != $checksum) {
					$this->raiseError("Could not extract from {$this->options['name']}, it is corrupt.");
				}

				if ($this->options['inmemory'] == 1) {
					$file['data'] = @fread($fp, $file['stat'][7]);
					@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
					unset ($file['checksum'], $file['magic']);
					$this->files[] = $file;
				} else {
					if ($file['type'] == 5) {
						if (!is_dir($file['name'])) {
							
							/*if ($this->options['forceWriting']) {
								chmod($file['name'], 1777);
							}*/
							if (!$this->options['dontUseFilePerms']) {
								@mkdir($file['name'], $file['stat'][2]);
								//pr($file['name'].' : '.$file['stat'][4]);
								//pr($file['name'].' : '.$file['stat'][5]);
								@chown($file['name'], $file['stat'][4]);
								@chgrp($file['name'], $file['stat'][5]);
							} else {
								@mkdir($file['name']);
							}
						}
					} else {
						if ($this->options['overwrite'] == 0 && file_exists($file['name'])) {
							$this->_raiseError(get_class($this)." : extract_files : {$file['name']} already exists.");
						} else
							if ($new = fopen($file['name'], "wb")) {
								@fwrite($new, @fread($fp, $file['stat'][7]));
								@fread($fp, (512 - $file['stat'][7] % 512) == 512 ? 0 : (512 - $file['stat'][7] % 512));
								@fclose($new);
								//pr($file['name'].' : '.$file['stat'][2]);
								if (!$this->options['dontUseFilePerms']) {
									@chmod($file['name'], $file['stat'][2]);
									@chown($file['name'], $file['stat'][4]);
									@chgrp($file['name'], $file['stat'][5]);
								}
								/*if ($this->options['forceWriting']) {
									chmod($file['name'], 0777);
								}*/
							} else {
								$this->raiseError("Could not open {$file['name']} for writing.");
							}
						}
					}
				}
				unset ($file);
			}
		} else {
			$this->raiseError("Could not open file {$this->options['name']}");
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
	function __construct($name)
	{
		if (trim($name) == '') {
			$this->_raiseError(get_class($this)." : Not a valid name given to archive ".$name);
			return;
		}
		parent::__construct($name);
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


