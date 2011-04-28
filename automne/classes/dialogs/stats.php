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

/**
  * Class CMS_stats
  *
  * Store and display debug statistics
  *
  * @package Automne
  * @subpackage user
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_stats extends CMS_grandFather
{
	private static $_started = false;
	public static $timeStart = 0;
	public static $timeEnd = 0;
	public static $totalTime = 0;
	public static $sqlNbRequests = 0;
	public static $filesTime = 0;
	public static $filesLoaded = 0;
	public static $sqlTable = array();
	public static $filesTable = array();
	public static $memoryTable = array();
	
	/**
     * Constructor overriding - make sure that a developer cannot instantiate
     */
    protected function __construct(){}
	
	public static function start() {
		self::$_started = true;
		self::$filesLoaded = 6; //Start at 6 : 3 config files and 3 requires
		self::$timeStart = self::getmicrotime();
		//start xhprof profiling
		if (defined('APPLICATION_ENABLE_PROFILING') && APPLICATION_ENABLE_PROFILING && function_exists('xhprof_enable')) {
			// start profiling
			xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
		}
	}
	
	public static function view($removefieldset = false){ 
		if (!self::$_started) {
			return;
		}
		self::$timeEnd = self::getmicrotime();
		$time = sprintf('%.5f', self::$timeEnd - self::$timeStart);
		$files = sprintf('%.5f', self::$filesTime);
		$rapportSQL = sprintf('%.2f', ((100*self::$totalTime)/$time));
		$rapportPHP = 100-$rapportSQL;
		$memoryPeak = round((memory_get_peak_usage()/1048576),3);
		$content = 
		'File ' .$_SERVER['SCRIPT_NAME'] ."\n".
		'Loaded in ' . $time . ' seconds'."\n".
		'Loaded PHP files : '. self::$filesLoaded ."\n".
		'SQL requests : ' . sprintf('%.5f',self::$totalTime) . ' seconds ('. self::$sqlNbRequests .' requests)'."\n".
		'% SQL/PHP : '. $rapportSQL .' / '. $rapportPHP .' %'."\n".
		'Memory Peak : '. $memoryPeak .'Mo'."\n";
		if (function_exists('xdebug_get_profiler_filename') && xdebug_get_profiler_filename()) {
			$content .= 'XDebug Profile : '. xdebug_get_profiler_filename()."\n";
		}
		if (function_exists('xdebug_get_profiler_filename') && xdebug_get_tracefile_name()) {
			$content .= 'XDebug Trace : '. xdebug_get_tracefile_name()."\n";
		}
		$content .= 'User : '.(CMS_session::getUserId() ? CMS_session::getUser()->getFullName().' ('.CMS_session::getUserId().')' : 'none')."\n";
		$content .= 'Session Id '.Zend_Session::getId()."\n";
		if (VIEW_SQL && $_SERVER["SCRIPT_NAME"] != PATH_ADMIN_WR.'/stat.php') {
			$stat = array(
				'stat_time_start'		=> self::$timeStart,
				'stat_time_end'			=> self::$timeEnd,
				'stat_total_time'		=> self::$totalTime,
				'stat_sql_nb_requests'	=> self::$sqlNbRequests,
				'stat_sql_table'		=> self::$sqlTable,
				'stat_content_name'		=> basename($_SERVER["SCRIPT_NAME"]),
				'stat_files_table'		=> self::$filesTable,
				'stat_memory_table'		=> self::$memoryTable,
				'stat_memory_peak'		=> $memoryPeak,
				'stat_files_loaded'		=> self::$filesLoaded,
			);
			$statName = 'stat_'.md5(rand());
			//save stats to cache (for 10 min)
			$cache = new CMS_cache($statName, 'atm-stats', 600, false);
			if ($cache) {
				$cache->save($stat);
			}
		}
		$content = !$removefieldset ? '<fieldset style="width:200px;" class="atm-debug"><legend>Debug Statistics</legend><pre>'.$content.'</pre>' : 'Debug Statistics :'."\n".$content;
		if (isset($statName)) {
			$content .= '<a href="'.PATH_ADMIN_WR.'/stat.php?stat='.$statName.'" target="_blank">View statistics detail</a>';
		}
		//end xhprof profiling
		if (defined('APPLICATION_ENABLE_PROFILING') && APPLICATION_ENABLE_PROFILING && function_exists('xhprof_disable')) {
			$xhprof_data = xhprof_disable();
			include_once APPLICATION_XHPROF_ROOT_FS . "/xhprof_lib/utils/xhprof_lib.php";
			include_once APPLICATION_XHPROF_ROOT_FS . "/xhprof_lib/utils/xhprof_runs.php";
			$xhprof_runs = new XHProfRuns_Default();
			$profileName = md5($_SERVER['REQUEST_URI']);
			$run_id = $xhprof_runs->save_run($xhprof_data, md5($_SERVER['REQUEST_URI']));
			$content .= '<a href="'.APPLICATION_XHPROF_URI.'xhprof_html/index.php?run='.$run_id.'&amp;source='.$profileName.'" target="_blank">View profiling detail</a>';
		}
		$content .= !$removefieldset ? '</fieldset>' : '';
		
		return $content;
	}
	
	/**
	  * Usefull time function for statistics and regenerator
	  */
	public static function getmicrotime(){ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	}
}
?>