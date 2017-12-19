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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: query.php,v 1.7 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_query
  *
  * Launches query against the database. Connection information can be passed as parameter,
  * or is taken from global constants.
  * For now, only manages MySQL database.
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

 class CMS_query extends CMS_grandFather {
	/**
	  * All db connection in use
	  * @var array(PDO)
	  * @access private
	  * @static
	  */
	private static $_connection;
	
	/**
	  * Current db connection in use
	  * @var PDO
	  * @access private
	  */
	private $_db;
	
	/**
	  * Query result (resource object)
	  * @var resource
	  * @access private
	  */
	private $_result;
	
	/**
	  * Number of rows returned or deleted or inserted.
	  * @var integer
	  * @access private
	  */
	private $_numRows = 0;
	
	/**
	  * SQL statement.
	  * @var string
	  * @access private
	  */
	private $_sql;
	
	/**
	  * ID of the last inserted row.
	  * @var integer;
	  * @access private
	  */
	private $_lastInsertedID = 0;
	
	/**
	  * Constructor.
	  * Initializes the connection and launches the query.
	  *
	  * @param string $sql The sql statement
	  * @param string $dsn The database dsn
	  * @param string $user The database user
	  * @param string $pass The database password
	  * @return void
	  * @access public
	  */
	public function __construct($sql = '', $dsn = APPLICATION_DB_DSN, $user = APPLICATION_DB_USER, $pass = APPLICATION_DB_PASSWORD) {
		$this->_sql = trim($sql);
		$this->_connect($dsn, $user, $pass);
		if ($this->_sql && $this->_db) {
			/*only for stats*/
			if (STATS_DEBUG) $time_start = CMS_stats::getmicrotime();
			if (preg_match("#^(insert|update)#i", $this->_sql)) {
				$this->_numRows = $this->_db->exec($this->_sql);
				if (preg_match("#^insert#i", $this->_sql)) {
					$this->_lastInsertedID = $this->_db->lastInsertId();
				}
				$errorInfos = $this->_db->errorInfo();
				if (isset($errorInfos[2])) {
					$clean_sql = str_replace("\n", "", $this->_sql);
					$clean_sql = preg_replace("#\t+#", " ", $clean_sql);
					$errorInfo = isset($errorInfos[2]) ? $errorInfos[2] : 'No error returned';
					$this->setError('Database querying failed : '.$errorInfo."\nQuery : ".$clean_sql);
				}
			} else {
				$this->_result = $this->_db->query($this->_sql);
				if ($this->_result) {
					$this->_numRows = $this->_result->rowCount();
				} else {
					$clean_sql = str_replace("\n", "", $this->_sql);
					$clean_sql = preg_replace("#\t+#", " ", $clean_sql);
					$errorInfos = $this->_db->errorInfo();
					$errorInfo = isset($errorInfos[2]) ? $errorInfos[2] : 'No error returned';
					$this->setError('Database querying failed : '.$errorInfo."\nQuery : ".$clean_sql."\nFrom : ".io::getCallInfos(3));
				}
			}
			/*only for stats*/
			if (STATS_DEBUG) {
				$currenttime = CMS_stats::getmicrotime();
  	            $time = $currenttime - $time_start;
				if (VIEW_SQL) CMS_stats::$sqlTable[]=array('sql' => $this->_sql, 'time' => $time, 'current' => $currenttime - CMS_stats::$timeStart, 'from' => io::getCallInfos(3), 'memory' => memory_get_usage(), 'peak' => memory_get_peak_usage());
				
				CMS_stats::$sqlNbRequests++;
				CMS_stats::$totalTime += $time;
			}
		}
	}
	
	/**
	  * Execute prepared query
	  * Warning : this function is buggy when it used with serialised datas into an insert or an update statement
	  * Use it only for select.
	  *
	  * @param string $sql : the prepared query to execute
	  * @param array $params : the parameters for the query
	  * @return void
	  * @access private
	  */
	public function executePreparedQuery($sql, $params) {
		$this->_sql = trim($sql);
		$this->_result = $this->_db->prepare($this->_sql);
		if ($this->_result) {
			if ($this->_result->execute($params)) {
				//the last inserted id only has a sense if it's an insert query
				if (preg_match("#^insert#i", $this->_sql)) {
					$this->_lastInsertedID = $this->_db->lastInsertId();
				}
				return true;
			}
		}
		$clean_sql = str_replace("\n", "", $this->_sql);
		$clean_sql = preg_replace("#\t+#", " ", $clean_sql);
		$errorInfos = $this->_db->errorInfo();
		$errorInfo = isset($errorInfos[2]) ? $errorInfos[2] : 'no error returned';
		$this->setError('Prepared query failed : '.$errorInfo."\nQuery : ".$clean_sql."\nParameters : ".print_r($params,true));
		return false;
	}
	
	/**
	  * Initiates connection with the database.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access private
	  */
	private function _connect($dsn, $user, $pass) {
		$connectID = md5($dsn.$user.$pass);
		if (!isset(self::$_connection[$connectID])) {
			if (!defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY')) {
				$this->setError('PDO MySQL driver not loaded ... please check your PHP configuration.');
				if (SYSTEM_DEBUG) {
					die('<pre><b>'.self::SYSTEM_LABEL.' '.AUTOMNE_VERSION.' error : PDO MySQL driver not loaded ... please check your PHP configuration.'."</b></pre>\n");
				}
				exit;
			}
			try {
				self::$_connection[$connectID] = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => APPLICATION_DB_PERSISTENT_CONNNECTION, PDO::ERRMODE_EXCEPTION => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
			} catch (PDOException $e) {
				unset(self::$_connection[$connectID]);
				$this->setError($e->getMessage());
				if (SYSTEM_DEBUG) {
					die('<pre><b>'.self::SYSTEM_LABEL.' '.AUTOMNE_VERSION.' error : '.$e->getMessage()."</b></pre>\n");
				}
				exit;
			}
			if(io::strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
				//set connection to utf-8 charset
				$q = new CMS_query("SET NAMES 'utf8'");
			} else {
				$q = new CMS_query("SET NAMES 'latin1'");
			}
		}
		$this->_db = self::$_connection[$connectID];
		return true;
	}
	
	/**
	  * Get the next record as an associative array with fields names as keys.
	  *
	  * @return array(string=>mixed)
	  * @access public
	  */
	public function getArray($fetchMode = PDO::FETCH_BOTH) {
		return (is_object($this->_result)) ? $this->_result->fetch($fetchMode) : false;
	}
	
	/**
	  * Get the all records as an associative array with fields names as keys.
	  *
	  * @return array()
	  * @access public
	  */
	public function getAll($fetchMode = PDO::FETCH_BOTH, $column = 0) {
		if($fetchMode & PDO::FETCH_COLUMN > 0){
			return $this->_result->fetchAll($fetchMode, $column);
		} else {
			return $this->_result->fetchAll($fetchMode);
		}
	}
	
	/**
	  * Get the next record but only one field.
	  *
	  * @param string $field The field name we want the value of.
	  * @return mixed
	  * @access public
	  */
	public function getValue($field) {
		return ($arr = $this->getArray()) ?  (isset($arr[$field]) ? $arr[$field] : false) : false;
	}
	
	/**
	  * Get the number of rows returned.
	  *
	  * @return integer The number of rows affected
	  * @access public
	  */
	public function getNumRows() {
		return $this->_numRows;
	}
	
	/**
	  * Get the last inserted ID.
	  *
	  * @return integer The last inserted ID.
	  * @access public
	  */
	public function getLastInsertedID() {
		return $this->_lastInsertedID;
	}
	
	/**
	  * Return an echapped input to use into an SQL query
	  *
	  * @param string $input The string to echap
	  * @return string echapped query
	  * @access public
	  */
	public static function echap($input) {
		try {
			$db = (is_array(self::$_connection)) ? current(self::$_connection) : new PDO(APPLICATION_DB_DSN, APPLICATION_DB_USER, APPLICATION_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => APPLICATION_DB_PERSISTENT_CONNNECTION, PDO::ERRMODE_EXCEPTION => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
		} catch (PDOException $e) {
			CMS_query::raiseError($e->getMessage());
			exit;
		}
		return io::substr($db->quote($input),1,-1);
	}
}
?>