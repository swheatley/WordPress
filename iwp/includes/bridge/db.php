<?php
/********************************************************************
 * Db Driver File, Autiomatic choice the connection mysql or mysqli *
 * Code-Base : Infinitewp Base Panel                                *
 * Auther : Senthil kumar V - Tech Lead, Revmakx Techonology Pvt    *
 * Copyright (c) 2012 Revmakx                                       *
 * www.revmakx.com                                                  *
 *                                                                  *
 *******************************************************************/

//Code from mysql.php - Start
class DBMysql{
	
	protected $DBLink;
	protected $DBHost;
	protected $DBUsername;
	protected $DBPassword;
	protected $DBName;
	protected $DBPort;
	
	function __construct($DBHost, $DBUsername, $DBPassword, $DBName, $DBPort){
		$this->DBHost = $DBHost;
		$this->DBUsername = $DBUsername;
		$this->DBPassword = $DBPassword;
		$this->DBName = $DBName;
		$this->DBPort = $DBPort;
	}
	
	function connect(){
		$this->DBLink = mysql_connect($this->DBHost.':'.$this->DBPort, $this->DBUsername, $this->DBPassword);
		if (!$this->DBLink) {
			return 'Mysql connect error: (' . mysql_error().') '.$this->error();
		}
		if (!mysql_select_db($this->DBName, $this->DBLink)){
			return 'Mysql connect error: (' . $this->errorNo().') '.$this->error();
		} else {
			return true;
		}
	}
	
	function query($SQL){
		
		$result = mysql_query($SQL, $this->DBLink);
		
		if(empty($result)){			
			$errno = $this->errorNo();
			if ($errno == 2013 || $errno == 2006){
				$this->connect();
				return mysql_query($SQL, $this->DBLink);
			}
		}
		
		return $result;
	}
	
	function insertID(){
		return mysql_insert_id($this->DBLink);
	}
	
	function affectedRows(){
		return mysql_affected_rows($this->DBLink);
	}	
	
	function realEscapeString($val){
		return mysql_real_escape_string($val, $this->DBLink);
	}
	
	function ping(){
		return mysql_ping($this->DBLink);	
	}
	
	function errorNo(){
		return mysql_errno($this->DBLink);
	}
	
	function error(){
		return mysql_error($this->DBLink);
	}
}

class DBMysqlResult{
	
	private $DBResult;
	
	function __construct($newResult)
	{
		$this->DBResult = $newResult;
	}
	function numRows()
	{
		return mysql_num_rows($this->DBResult);
	}
	function nextRow()
	{
		return mysql_fetch_assoc($this->DBResult);
	}
	function rowExists()
	{
		if (!$this->numRows())
			return false;
		return true;
	}
	function free(){
		return mysql_free_result($this->DBResult);
	}
}
//Code from mysql.php - End

//Code from mysqli.php - Start
class DBMysqli{
	
	protected $DBLink;
	protected $DBHost;
	protected $DBUsername;
	protected $DBPassword;
	protected $DBName;
	protected $DBPort;
	
	
	function __construct($DBHost, $DBUsername, $DBPassword, $DBName, $DBPort){
		$this->DBHost = $DBHost;
		$this->DBUsername = $DBUsername;
		$this->DBPassword = $DBPassword;
		$this->DBName = $DBName;
		$this->DBPort = $DBPort;
	}
	
	function connect(){
		$this->DBLink = new mysqli($this->DBHost, $this->DBUsername, $this->DBPassword, $this->DBName, $this->DBPort);
		if ($this->DBLink->connect_errno) {
			return 'Mysql connect error: (' . $this->DBLink->connect_errno.') '.$this->DBLink->connect_error;
		} else {
			return true;
		}
	}
	
	function query($SQL){
		$result = $this->DBLink->query($SQL);
		
		if(empty($result)){			
			$errno = $this->errorNo();
			if ($errno == 2013 || $errno == 2006){
				$this->connect();
				return $this->DBLink->query($SQL);
			}
		}
		
		return $result;
	}
	
	function insertID(){
		return $this->DBLink->insert_id;
	}
	
	function affectedRows(){
		return $this->DBLink->affected_rows;
	}	
	
	function realEscapeString($val){
		return $this->DBLink->real_escape_string($val);
	}
	
	function ping(){
		return $this->DBLink->ping();	
	}
	
	function errorNo(){
		return $this->DBLink->errno;
	}
	
	function error(){
		return $this->DBLink->error;
	}
}

class DBMysqliResult{
	
	private $DBResult;
	
	function __construct($newResult)
	{
		$this->DBResult = $newResult;
	}
	function numRows()
	{
		return $this->DBResult->num_rows;
	}
	function nextRow()
	{
		return $this->DBResult->fetch_assoc();
	}
	function rowExists()
	{
		if (!$this->numRows())
			return false;
		return true;
	}
	function free(){
		$this->DBResult->free();
	}
}
//Code from mysqli.php - End

//Code from db.php - Start
class DB{
	
	private static $queryString;
	private static $printQuery;
	private static $printAllQuery;
	private static $DBDriver;
	public static $DBResultClass;
	//private static $showError;
	//private static $showSQL;
	
	
	public static function connect($DBHost, $DBUsername, $DBPassword, $DBName, $DBPort){
		$driver = self::getDriver();
		if(in_array($driver, array('mysql', 'mysqli'))){
			$DBClass = 'DB'.ucfirst($driver);
			self::$DBResultClass = $DBClass.'Result';
			
			self::$DBDriver = new $DBClass($DBHost, $DBUsername, $DBPassword, $DBName, $DBPort);
			$DBConnect = self::$DBDriver->connect();
			if($DBConnect !== true) {
				return $DBConnect;
			}
		} else {
			return "PHP has no mysql extension installed";
		}
		return true;
	}

	public static function getDriver() {
		if(class_exists('mysqli')){
				$driver = 'mysqli';
		}
		elseif(function_exists('mysql_connect')){
				$driver = 'mysql';
		}
		else{
				return false;
		}
		return $driver;
	}
	
	private static function get($params, $type){
		if(empty($params)) return false;
		
		$result = array();		
		$query = self::prepareQ('select', $params);
		
		$query_result = self::doQuery($query);	
		if(!$query_result) return $query_result;	
		$_result = new self::$DBResultClass($query_result);	
		
		
		if($_result){
			if($type == 'array'){
				while($row = $_result->nextRow()){
					if(!empty($params[3])){//array key hash
						$result[ $row[$params[3]] ] = $row;
					}
					else{
					$result[] = $row;
				}
			}
			}
			elseif($type == 'row'){
				$result = $_result->nextRow();
			}
			elseif($type == 'exists'){
				$result = $_result->rowExists();
			}
			elseif($type == 'field'){
				$row = $_result->nextRow();
				$result = ($row && is_array($row)) ? reset($row) : NULL;
			}
			elseif($type == 'fields'){
				while($row = $_result->nextRow()){
					if(!empty($params[3])){//array key hash
						$result[ $row[$params[3]] ] = reset($row);
					}
					else{
					$result[] = reset($row);
					}
				}
			}
			$_result->free();
		}
		return $result;
	}
	
	public static function getArray(){//table, select, conditions
		$args = func_get_args();
		return self::get($args, 'array');
	}
	public static function getRow(){//table, select, conditions
		$args = func_get_args();
		return self::get($args, 'row');
	}
	
	public static function getExists(){//table, select, conditions
		$args = func_get_args();
		return self::get($args, 'exists');
	}
	
	public static function getField(){//table, select, conditions
		$args = func_get_args();
		return self::get($args, 'field');
	}
	
	public static function getFields(){//table, select, conditions
		$args = func_get_args();
		return self::get($args, 'fields');
	}
	
	private static function prepareQ($type, $params){
		
		if(!empty($params) && count($params) == 1){
			return $params[0];
		}
		
		if($type == 'select'){
			if(empty($conditions)){ $conditions = 'true'; }
			return "SELECT ".$params[1]." FROM ".$params[0]." WHERE ".$params[2];
		}
		elseif($type == 'insert' || $type == 'replace'){
			if(is_array($params[1])) $params[1] = self::array2MysqlSet($params[1]);
			return ($type == 'insert' ? "INSERT" : "REPLACE")." INTO ".$params[0]." SET ".$params[1];
		}
		elseif($type == 'update'){
			if(is_array($params[1])) $params[1] = self::array2MysqlSet($params[1]);
			return "UPDATE ".$params[0]." SET ".$params[1]." WHERE ".$params[2];
		}
		elseif($type == 'delete'){
			return "DELETE FROM ".$params[0]." WHERE ".$params[1];
		}
	}
	
	public static function insert(){//table, setCommand
		$args=func_get_args();
		$query = self::prepareQ('insert', $args);
		return self::insertReplace($query);
	}
	
	
	public static function replace(){//table, setCommand
		$args=func_get_args();
		$query = self::prepareQ('replace', $args);
		return self::insertReplace($query);
	}
	
	private static function insertReplace($query){
		
		if(self::doQuery($query)){
			$lastInsertID = self::lastInsertID();
			if(!empty($lastInsertID)) return $lastInsertID;
			return true;
		}
		return false;
	}
	
	public static function update(){//table, setCommand, conditions
		$args=func_get_args();
		$query = self::prepareQ('update', $args);
		return self::doQuery($query);
	}
	
	public static function delete(){//table, conditions
		$args=func_get_args();
		$query = self::prepareQ('delete', $args);
		return self::doQuery($query);
	}

	public static function doQuery($queryString){	
	
		//$queryString = str_replace('?:', Reg::get('config.SQL_TABLE_NAME_PREFIX'), $queryString);
		
		self::$queryString = $queryString;
		
		if(self::$printAllQuery || self::$printQuery)
			echo '<br>'.self::$queryString.'<br>';

		$query = self::$DBDriver->query(self::$queryString);

		if($query)
			 return $query;
		else
		{
			self::printError(debug_backtrace());
			echo "\n".self::$queryString."\n<br>";
			return false;
		}
	}
	
	public static function getLastQuery(){//avoid using this function, it should be called as soon as query is executed
		return self::$queryString;		
	}
	
	private static function lastInsertID(){
		return self::$DBDriver->insertID();
	}
	
	public static function errorNo(){
		return self::$DBDriver->errorNo();
	}
	
	public static function error(){
		return self::$DBDriver->error();
	}
	
	public static function affectedRows(){
		return self::$DBDriver->affectedRows();
	}
	
	public static function realEscapeString($val){
		return self::$DBDriver->realEscapeString($val);
	}
	
	public static function escapse($val){ //same as public static function realEscapeString($val) 
		return self::$DBDriver->realEscapeString($val);
	}
	
	private static function printError($traceback_detail){
		echo "<b>Manual SQL Error</b>: [". self::$DBDriver->errorNo()."] " . self::$DBDriver->error() . "<br />\n
		 in file <b>" . $_SERVER['PHP_SELF'] ."</b> On line <b>" . $traceback_detail[count($traceback_detail) - 1]['line'] . "</b><br> ";
	}
	
	private static function array2MysqlSet($array){
		$mysqlSet='';
		$isPrev=false;
		foreach($array as $key => $value)
		{
			if($isPrev) $mysqlSet .= ', ';
			if(isset($value) && is_array($value))
				$mysqlSet .= $key." = ".self::realEscapeString($value[0]).""; //without quotes
			else
				$mysqlSet .= $key." = '".self::realEscapeString($value)."'";
			$isPrev = true;
		}
		return $mysqlSet;
	}
	
	private static function array2MysqlSelect($array){
		$mysqlSet='';
		$isPrev=false;
		foreach($array as $key => $value)
		{
			if($isPrev) $mysqlSet .= ', ';
			$mysqlSet .= $value;
			$isPrev = true;
		}
		return $mysqlSet;
	}
	
	public static function setPrintQuery($var){
		self::$printQuery = $var;
	}
}

//-------------------------------------------------------------------------------------------------------------------->

# stores a mysql result
class DBResult{
	var $DBResult;
	function __construct($newResult)
	{
		$this->DBResult = $newResult;
	}
	function numRows()
	{
		return $this->DBResult->num_rows;
	}
	function nextRow()
	{
		return $this->DBResult->fetch_assoc();
	}
	function rowExists()
	{
		if (!$this->numRows())
			return false;
		return true;
	}
	function free(){
		$this->DBResult->free();
	}
	
}
//Code from db.php - End

class DBUpdateEngine extends DB
{
	
	public static function getTextColumns($table) 
	{
		$type_where  = "type NOT LIKE 'tinyint%' AND ";
		$type_where .= "type NOT LIKE 'smallint%' AND ";
		$type_where .= "type NOT LIKE 'mediumint%' AND ";
		$type_where .= "type NOT LIKE 'int%' AND ";
		$type_where .= "type NOT LIKE 'bigint%' AND ";
		$type_where .= "type NOT LIKE 'float%' AND ";
		$type_where .= "type NOT LIKE 'double%' AND ";
		$type_where .= "type NOT LIKE 'decimal%' AND ";
		$type_where .= "type NOT LIKE 'numeric%' AND ";
		$type_where .= "type NOT LIKE 'date%' AND ";
		$type_where .= "type NOT LIKE 'time%' AND ";
		$type_where .= "type NOT LIKE 'year%' ";

		$result = self::getArray("SHOW COLUMNS FROM `{$table}` WHERE {$type_where}");
		if (empty($result)) { 
			return null;
		} 
		$fields = array(); 
		if (count($result) > 0 ) { 
			foreach ($result as $key => $row) {
				$fields[] = $row['Field']; 
			} 
		} 

		$result = self::getArray("SHOW INDEX FROM `{$table}`");
		if (count($result) > 0) { 
			foreach ($result as $key => $row) {
				$fields[] = $row['Column_name']; 
			} 
		} 
	
		return (count($fields) > 0) ? $fields : null;
	}

	public static function load($list = array(), $tables = array(), $fullsearch = false) 
	{
		$report = array(
			'scan_tables' => 0, 
			'scan_rows' => 0, 
			'scan_cells' => 0,
			'updt_tables' => 0, 
			'updt_rows' => 0, 
			'updt_cells' => 0,
			'errsql' => array(), 
			'errser' => array(), 
			'errkey' => array(),
			'errsql_sum' => 0, 
			'errser_sum' => 0, 
			'errkey_sum' => 0,
			'time' => '', 
			'err_all' => 0
		);
		
		$walk_function = create_function('&$str', '$str = "`$str`";');

		
		if (is_array($tables) && !empty($tables)) {
			
			foreach ($tables as $table) 
			{
				$report['scan_tables']++;
				$columns = array();

				$fields = self::getArray('DESCRIBE ' . $table);
				foreach ($fields as $key => $column) {
					$columns[$column['Field']] = $column['Key'] == 'PRI' ? true : false;
				}
				
				$row_count = self::getField("SELECT COUNT(*) FROM `{$table}`");		
				if ($row_count == 0) {
					
					continue;
				}

				$page_size = 25000;
				$offset = ($page_size + 1);
				$pages = ceil($row_count / $page_size);

				$colList = '*';
				$colMsg  = '*';
				if (! $fullsearch) 
				{
					$colList = self::getTextColumns($table);
					if ($colList != null && is_array($colList)) {
						array_walk($colList, $walk_function);
						$colList = implode(',', $colList);
					} 
					$colMsg = (empty($colList)) ? '*' : '~';
				}
				
				if (empty($colList)) 
				{
					
					continue;
				} 
				else 
				{
					
				}

				//Paged Records
				for ($page = 0; $page < $pages; $page++) 
				{
					$current_row = 0;
					$start = $page * $page_size;
					$end   = $start + $page_size;
					$sql = sprintf("SELECT {$colList} FROM `%s` LIMIT %d, %d", $table, $start, $offset);
					$data  = self::getArray($sql);

					if (empty($data))
						//$report['errsql'][] = mysqli_error($conn);
					
					$scan_count = ($row_count < $end) ? $row_count : $end;

				foreach ($data as $key => $row) {
				
						$report['scan_rows']++;
						$current_row++;
						$upd_col = array();
						$upd_sql = array();
						$where_sql = array();
						$upd = false;
						$serial_err = 0;

						
						foreach ($columns as $column => $primary_key) 
						{
							$report['scan_cells']++;
							$edited_data = $data_to_fix = $row[$column];
							$base64coverted = false;
							$txt_found = false;

							
							if (!empty($row[$column]) && !is_numeric($row[$column])) 
							{
								//Base 64 detection
								if (base64_decode($row[$column], true)) 
								{
									$decoded = base64_decode($row[$column], true);
									if (self::is_serialized($decoded)) 
									{
										$edited_data = $decoded;
										$base64coverted = true;
									}
								}
								
								//Skip table cell if match not found
								foreach ($list as $item) 
								{
									if (strpos($edited_data, $item['search']) !== false) {
										$txt_found = true;
										break;
									}
								}
								if (! $txt_found) {
									continue;
								}

								//Replace logic - level 1: simple check on any string or serlized strings
								foreach ($list as $item) {
									$edited_data = self::recursive_unserialize_replace($item['search'], $item['replace'], $edited_data);
								}

								//Replace logic - level 2: repair serilized strings that have become broken
								$serial_check = self::fix_serial_string($edited_data);
								if ($serial_check['fixed']) 
								{
									$edited_data = $serial_check['data'];
								} 
								elseif ($serial_check['tried'] && !$serial_check['fixed']) 
								{
									$serial_err++;
								}
							}

							//Change was made
							if ($edited_data != $data_to_fix || $serial_err > 0) 
							{
								$report['updt_cells']++;
								//Base 64 encode
								if ($base64coverted) {
									$edited_data = base64_encode($edited_data);
								}
								$upd_col[] = $column;
								$upd_sql[] = $column . ' = "' . self::realEscapeString($edited_data) . '"';
								$upd = true;
							}

							if ($primary_key) {
								$where_sql[] = $column . ' = "' . self::realEscapeString($data_to_fix) . '"';
							}
						}

						if ($upd && !empty($where_sql)) 
						{
							
							$sql = "UPDATE `{$table}` SET " . implode(', ', $upd_sql) . ' WHERE ' . implode(' AND ', array_filter($where_sql));
							$result = self::doQuery($sql);
					
							if ($result) {
								if ($serial_err > 0) {
									$report['errser'][] = "SELECT " . implode(', ', $upd_col) . " FROM `{$table}`  WHERE " . implode(' AND ', array_filter($where_sql)) . ';';
								}
								$report['updt_rows']++;
							}
						} elseif ($upd) {
							$report['errkey'][] = sprintf("Row [%s] on Table [%s] requires a manual update.", $current_row, $table);
						}
					}
					
				}

				if ($upd) {
					$report['updt_tables']++;
				}
			}
		}
		
		$report['errsql_sum'] = empty($report['errsql']) ? 0 : count($report['errsql']);
		$report['errser_sum'] = empty($report['errser']) ? 0 : count($report['errser']);
		$report['errkey_sum'] = empty($report['errkey']) ? 0 : count($report['errkey']);
		$report['err_all'] = $report['errsql_sum'] + $report['errser_sum'] + $report['errkey_sum'];
		return $report;
	}


	public static function recursive_unserialize_replace($from = '', $to = '', $data = '', $serialised = false) 
	{
		
		try 
		{
			if (is_string($data) && ($unserialized = @unserialize($data)) !== false) 
			{
				$data = self::recursive_unserialize_replace($from, $to, $unserialized, true);
			} 
			elseif (is_array($data)) 
			{
				$_tmp = array();
				foreach ($data as $key => $value) 
				{
					$_tmp[$key] = self::recursive_unserialize_replace($from, $to, $value, false);
				}
				$data = $_tmp;
				unset($_tmp);
				
			} 
			elseif (is_object($data)) 
			{

				$_tmp = $data; 
				$props = get_object_vars( $data );
				foreach ($props as $key => $value) 
				{
					$_tmp->$key = self::recursive_unserialize_replace( $from, $to, $value, false );
				}
				$data = $_tmp;
				unset($_tmp);
			} 

			else 
			{
				if (is_string($data)) {
					$data = str_replace($from, $to, $data);
				}
			}

			if ($serialised)
				return serialize($data);
			
		} 
		catch (Exception $error) 
		{
			
		}
		return $data;
	}

	public static function is_serialized($data) 
	{
		$test = @unserialize(($data));
		return ($test !== false || $test === 'b:0;') ? true : false;
	}

	public static function fix_serial_string($data) 
	{
		$result = array('data' => $data, 'fixed' => false, 'tried' => false);
		if (preg_match("/s:[0-9]+:/", $data)) 
		{
			if (!self::is_serialized($data)) 
			{
				$regex = '!(?<=^|;)s:(\d+)(?=:"(.*?)";(?:}|a:|s:|b:|d:|i:|o:|N;))!s';
				$serial_string = preg_match('/^s:[0-9]+:"(.*$)/s', trim($data), $matches);
				//Nested serial string
				if ($serial_string) 
				{
					$inner = preg_replace_callback($regex, 'DBUpdateEngine::fix_string_callback', rtrim($matches[1], '";'));
					$serialized_fixed = 's:' . strlen($inner) . ':"' . $inner . '";';
				} 
				else 
				{
					$serialized_fixed = preg_replace_callback($regex, 'DBUpdateEngine::fix_string_callback', $data);
				}
				
				if (self::is_serialized($serialized_fixed)) 
				{
					$result['data'] = $serialized_fixed;
					$result['fixed'] = true;
				}
				$result['tried'] = true;
			}
		}
		return $result;
	}

	private static function fix_string_callback($matches) 
	{
		return 's:' . strlen(($matches[2]));
	}

}
