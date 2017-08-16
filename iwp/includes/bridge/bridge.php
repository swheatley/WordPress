<?php

$GLOBALS['IWP_MMB_PROFILING']['ACTION_START'] = microtime(1);
global $extract_start_time;
$extract_start_time = $GLOBALS['IWP_MMB_PROFILING']['ACTION_START'];

register_shutdown_function("bridge_shutdown");
error_reporting(E_ALL ^ E_NOTICE);
@ini_set("display_errors", 1);
@ignore_user_abort(true);

require_once 'fileSystem.php';
require_once 'db.php';

$HTTP_RAW_POST_DATA = file_get_contents('php://input');
if (strrpos($HTTP_RAW_POST_DATA, '_IWP_JSON_PREFIX_') !== false) {
	$request_data_array = explode('_IWP_JSON_PREFIX_', $HTTP_RAW_POST_DATA);
	$request_raw_data = $request_data_array[1];
	$data = trim(base64_decode($request_raw_data));
	$GLOBALS['IWP_JSON_COMMUNICATION'] = 1;
}else{
	exit();
}

$http_data = json_decode($data, true);
$_REQUEST = $http_data;

// ----- for multicall
$isMultiCall = false;
$prevMultiCallResponse = array();
$connectionFlag = false;
if(!empty($_REQUEST['iwp_action']) && $_REQUEST['iwp_action'] == 'bridgeExtractMulticall'){

	$oldValues = unserialize(base64_decode($_REQUEST['params']['param1']));
	$_REQUEST = array_merge($_REQUEST, $oldValues);
	define('DB_HOST',$_REQUEST['dbHost']);
	define('DB_USER',$_REQUEST['dbUser']);
	define('DB_PASSWORD',$_REQUEST['dbPassword']);
	define('DB_NAME',$_REQUEST['dbName']);
	$connectionFlag = DB::connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, '3306');
	if(!$connectionFlag){
		$status = "DB verification Failed(".$connectionFlag.")";
		die(status($status, $success=false, $return=true));
	}
	$cloneStatus = DB::getField("iwp_clone_stats", "optionValue", "optionName = 'cloneStatus'");
	$cloneStatus = unserialize($cloneStatus);
	if (!empty($cloneStatus)) {
		$isMultiCall = true;
		$isDownloadMultiCall = $cloneStatus['isDownloadMultiCall'];
		$prevMultiCallResponse = $cloneStatus;
		$historyID = $_REQUEST['extractParentHID'];
	} else {
		//To run directly from iwp request not referring cloneStatus.php
		$isDownloadMultiCall = $_REQUEST['params']['responseData']['isDownloadMultiCall'];
		$prevMultiCallResponse = $_REQUEST['params']['responseData'];
		if (empty($prevMultiCallResponse)) {
			die(status('Retriving clone status' . DB::error(), $success=false, $return=true));
		}
	}
}

if (!defined('DB_HOST')) {
	define('DB_HOST',$_REQUEST['dbHost']);
}
if (!defined('DB_USER')) {
	define('DB_USER',$_REQUEST['dbUser']);
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD',$_REQUEST['dbPassword']);
}
if (!defined('DB_NAME')) {
	define('DB_NAME',$_REQUEST['dbName']);
}
$db_table_prefix = (isset($_REQUEST['db_table_prefix'])) ? $_REQUEST['db_table_prefix'] : false;

$GLOBALS['downloadPossibleError'] = '';
$GLOBALS['REPLACE_LIST'] = array();
//$old = $_REQUEST['oldSite'];
$old_url = removeTrailingSlash($_REQUEST['oldSite']);
$old_user = $_REQUEST['oldUser'];
$newUser = $_REQUEST['newUser'];
$newPassword = $_REQUEST['newPassword'];
$new_url = removeTrailingSlash($_REQUEST['newSiteURL']);
$isTestConnection = $_REQUEST['isTestConnection'];
$testConnectionResult = true;
$GLOBALS['LOG_FILE_NAME'] = "iwp-clone-log.txt";
$GLOBALS['new_file_path'] = dirname(__FILE__);
if ($isMultiCall) {
	$GLOBALS['LOG_FILE_HANDLE'] = @fopen($GLOBALS['LOG_FILE_NAME'], "a+");
}else{
	$GLOBALS['LOG_FILE_HANDLE'] = @fopen($GLOBALS['LOG_FILE_NAME'], "w+");
}
if ($isMultiCall==false) {
	status("*********************************** Clone Test connection started  *************************", $success=true, $return=false);
}

//Check access
@ini_set('memory_limit', "-1"); // For big uploads
@ini_set("max_execution_time", 0);
@set_time_limit(0);
if (empty($connectionFlag)) {
	$connectionFlag = DB::connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, '3306');
}
//TestConnection
if($isTestConnection == 1){
	if($connectionFlag === true) {
		appUpdateMsg("test-connection : DB verification Success");
		return true;
	} else{
		appUpdateMsg("test-connection : DB verification Failed(".$connectionFlag.")", 1);
	}
	exit;
}

if ($connectionFlag !== true) {
	$status = "DB verification Failed(".$connectionFlag.")";
	die(status($status, $success=false, $return=true));
}elseif($isMultiCall == false){
	status("DB connected Successfully", $success=true, $return=false);
}

$query = DB::doQuery("CREATE TABLE IF NOT EXISTS `iwp_clone_stats` (
		  `optionName` varchar(255) NOT NULL,
		  `optionValue` longtext
		) ;");
if (!$query) {
	$status = 'Clone status table creation failed check your database credentials';
	die(status($status, $success=false, $return=true));
}elseif($isMultiCall == false){
	status("Clone status table created successfully", $success=true, $return=false);
}

if($connectionFlag !== true) {
    appUpdateMsg("Error establishing DB : ".$connectionFlag, 1);
    return true;
} else{
    appUpdateMsg("DB Connected");
    status("Database SQLMODE chose", $success=true, $return=false);
	DB::doQuery("SET SESSION sql_mode = ' '");
}
if ($isMultiCall == false) {
	status("*********************************** Clone Test connection Ended *************************", $success=true, $return=false);
}
if(!empty($_REQUEST['isDeleteStagingSite'])){
	deleteStagingDB($db_table_prefix);
	deleteStagingSite();
	exit;
} else if(!empty($prevMultiCallResponse['oldURLReplacement'])){
	oldURLReplacement($prevMultiCallResponse['dbModificationArray'], $prevMultiCallResponse['oldURLReplacement']);
	exit;
}else if(!empty($prevMultiCallResponse['dbModification'])){
	cloneDatabaseModification($prevMultiCallResponse['dbModificationArray']);
	exit;
}else if($isMultiCall && !($isDownloadMultiCall) && !$prevMultiCallResponse['is_file_copy']){
	if(empty($_REQUEST['temp_unzip_dir'])){
		$_REQUEST['temp_unzip_dir'] = $prevMultiCallResponse['temp_unzip_dir'];
		$_REQUEST['temp_pclzip'] = $prevMultiCallResponse['temp_pclzip'];
		$_REQUEST['bkfile'] = $prevMultiCallResponse['temp_pclzip'];
	}
	$bkfile = $prevMultiCallResponse['bkfile'];
}else if($_REQUEST['backupURL'] == "localPackage"){
	$bkfile = "WPPackage.zip";
	
	if(!file_exists($bkfile)) {
   		die(status("Couldn't Find the backup file.", false ,true));
	}
	
	if(file_exists($bkfile)){
		status("Backup File Exist.", true, false);
	}

} else if(!empty($_REQUEST['manualBackupFile']) && $_REQUEST['manualBackupFile'] != 'undefined'){
	$bkfile = array();
	//$bkfile[] = '../' . $_REQUEST['manualBackupFile'];
	$bkfile =  get_files_array_from_iwp_part($_REQUEST['manualBackupFile'], 'manual');
} else{
	if ($prevMultiCallResponse['backupURL']) {
		$this_backup_URL = $prevMultiCallResponse['backupURL'];
	}else {
		status("*********************************** Backup file download started *************************", $success=true, $return=false);
		status("Multipart file checking... ", $success=true, $return=false);
		$this_backup_URL = get_files_array_from_iwp_part($_REQUEST['backupURL']);
	}
	
	if(!is_array($this_backup_URL))
	{
		$this_temp_backup_URL = $this_backup_URL;
		$this_backup_URL = array();
		$this_backup_URL[] = $this_temp_backup_URL;
	}

	$tempBkFile= array();
	$tempBkFile=$this_backup_URL;
	$bkfile = array();
	if (!empty($prevMultiCallResponse['bkfile'])) {
		# code...
		$bkfile = $prevMultiCallResponse['bkfile'];
	}
	$download_result = array();
	$is_send_multicall_response = false;
	foreach($this_backup_URL as $key => $single_backup_URL)
	{
		iwp_mmb_auto_print('downloading_backup_file');
		$download_result = downloadURL($single_backup_URL, 'WPPackage.zip', $prevMultiCallResponse);
		if($download_result['isDownloadMultiCall']){
			$is_send_multicall_response = true;
			status("Backup file download will continue next call ", $success=true, $return=false);
			break;
		} else if(!empty($download_result['file'])){
			$bkfile[] = $download_result['file'];
		} else{
			$bkfile[] = $download_result;
		}
		if (!file_exists($bkfile[$key])) {
			 die(status("Couldn't Download the backup file.", false ,true));
		}
		if(file_exists($bkfile[$key])){
			status("Backup File Downloaded", true, false);
		}
		unset($tempBkFile[$key]);
		unset($prevMultiCallResponse['file']);
		unset($prevMultiCallResponse['startRange']);
		unset($prevMultiCallResponse['endRange']);
	}
	if($is_send_multicall_response){
		$download_result['backupURL'] = $tempBkFile;
		$download_result['bkfile'] = $bkfile;
		send_multicall_response($download_result);
	}
	//exit;
}

iwp_mmb_auto_print('downloaded_all_backup_file');

transfer($bkfile, $new_url, $newUser, $newPassword, $old_user, $db_table_prefix, $prevMultiCallResponse);

function deleteStagingDB($table_prefix){
	$tables_delete_query = "SELECT CONCAT( 'DROP TABLE ', GROUP_CONCAT(table_name) , ';' )
		AS statement FROM information_schema.tables
		WHERE table_schema = '".DB_NAME."' AND table_name LIKE '$table_prefix%';";
	
	$queryResult = DB::doQuery($tables_delete_query);
	if(!$queryResult){
		echo DB::error();
	}
	$_result = new DB::$DBResultClass($queryResult);
	$queriedRows = $_result->numRows($_result);
	if($queriedRows){
		$tablesArray = $_result->nextRow($_result);
		$queryResult = DB::doQuery($tablesArray['statement']);
		if(!$queryResult){
			echo DB::error();
		}
	}
	
	status("delete_db_completed", $success=true, $return=false);
}

function deleteStagingSite(){
	$site_parent_folder = dirname(dirname(__FILE__));
	initFileSystem(false, $site_parent_folder);
	$directFSObj = new filesystemDirect('');
	$delete_result = $directFSObj->delete($site_parent_folder, true);//dirname(__FILE__) => clone_controller folder
	if(!$delete_result){
		$delete_result = $GLOBALS['FileSystemObj']->delete(removeTrailingSlash(APP_FTP_BASE).'/clone_controller', true);//for those files and folders not delete with direct file system
	}
	if(!$delete_result){
		status("Delete through file system Error.", $success=false, $return=false);
	}
	status("delete_completed", $success=true, $return=false);
}

function transfer($backup_file, $new_url, $newUser, $newPassword, $old_user, $db_table_prefix, $prevMultiCallResponse = array()){
	// ***************************************** Extract the ZIP  Starts {*************************

	if(empty($prevMultiCallResponse['is_extract_over'])){
		if(empty($prevMultiCallResponse) || empty($prevMultiCallResponse['next_extract_id'])){
			status("*********************************** Backup file extract process started *************************", $success=true, $return=false);
			if(!isset($_REQUEST['temp_unzip_dir'])){
				$temp_unzip_dir = dirname(__FILE__);
				$temp_unzip_dir = removeTrailingSlash($temp_unzip_dir);
				$temp_uniq = md5(microtime(1));
				while (is_dir($temp_unzip_dir .'/'. $temp_uniq )) {
					$temp_uniq = md5(microtime(1));
				}
				$temp_pclzip = $temp_unzip_dir.'/'.$temp_uniq."_zip_tmp";
				mkdir($temp_pclzip);
				status("Temp folder created ", $success=true, $return=false);
			} else {
				$temp_unzip_dir = $_REQUEST['temp_unzip_dir'];
				$temp_pclzip 	= $_REQUEST['temp_pclzip'];
			}

	        if(@is_writable($temp_unzip_dir) && @is_writable($temp_pclzip)) {
	            status("Using temp working dir:".$temp_unzip_dir, $success=true, $return=false);
				define( 'IWP_PCLZIP_TEMPORARY_DIR',  $temp_pclzip."/");
				
				if(empty($_REQUEST['temp_unzip_dir'])){
					$_REQUEST['temp_unzip_dir'] = $temp_unzip_dir;
					$_REQUEST['temp_pclzip'] = $temp_pclzip;
					$_REQUEST['bkfile'] = $backup_file;
				}
	        } else {
	           die(status('Unable to write files to the randam directory.', $success=false, $return=true));
	        }
		} else{
			//setting old values from response data
			$temp_unzip_dir = $_REQUEST['temp_unzip_dir'];
			$temp_pclzip = $_REQUEST['temp_pclzip'];
			define( 'IWP_PCLZIP_TEMPORARY_DIR',  $temp_pclzip."/");
			logExtractResponse('', array('status' => 'startingBridgeExtract', 'extractParentHID' => $_REQUEST['extractParentHID']), $_REQUEST);
		}
		// For unzipping
		require_once 'class-pclzip.php';
		if(!is_array($backup_file)){
			$temp_backup_file = $backup_file;
			$backup_file = array();
			$backup_file[] = $temp_backup_file;
		}
		@ini_set('memory_limit', '-1');

		if (empty($prevMultiCallResponse['is_file_append'])) {
			$extract_result = extract_in_multicall($backup_file, $temp_unzip_dir);
		}
		
		if(is_array($extract_result) && $extract_result['status'] == 'partiallyCompleted' && empty($prevMultiCallResponse['is_file_append'])){
			global $response_arr;

			$response_arr = array();

			initialize_response_array($response_arr);
			$response_arr['next_extract_id'] = $extract_result['next_extract_id'];

			$response_arr['is_extract_over'] = false;

			$response_arr['status'] = 'partiallyCompleted';

			$response_arr['break'] = true;
			$response_arr['v_pos_entry'] = $extract_result['v_pos_entry'];

			$response_arr['bkfile'] = $extract_result['bkfile'];;

			$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);

			status("Extract will continue next call", $success=true, $return=false);
			die(status("multicall", $success=true, $return=false, $response_arr));

			return true;

			exit;
		}else{
			status("*********************************** Backup file extract process end *************************", $success=true, $return=false);
			status("*********************************** Renaming the htaccess  *************************", $success=true, $return=false);
			renameServerConfig($temp_unzip_dir);
		}

	}
	$temp_unzip_dir = dirname(__FILE__);
	$temp_unzip_dir = removeTrailingSlash($temp_unzip_dir);
	if (empty($prevMultiCallResponse['is_file_append']) && empty($prevMultiCallResponse['next_db_insert_id'])) {

		$directFSObj = new filesystemDirect('');
		$directFSObj->delete($temp_pclzip, true);
		foreach ($backup_file as $key => $file) {
			unlink($file);
		}
		global $response_arr;
		$response_arr = array();
		status("*********************************** File appending process started *************************", $success=true, $return=false);
		initialize_response_array($response_arr);
		$response_arr['is_file_append'] = true;
		$response_arr['status'] = 'partiallyCompleted';
		$response_arr['break'] = true;
		$response_arr['is_extract_over'] = true;
		$response_arr['temp_pclzip'] = $temp_pclzip;
		$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
		die(status("multicall", $success=true, $return=false, $response_arr));
		return $response_arr;
		
	}elseif(!empty($prevMultiCallResponse['is_extract_over']) && !empty($prevMultiCallResponse['is_file_append'])){
		
		if (empty($prevMultiCallResponse['appendFileLists'])) {
			$appendFileLists = $temp_unzip_dir;
		} else{
			$appendFileLists = $prevMultiCallResponse['appendFileLists'];
		}
		appendSplitFiles($appendFileLists);
		status("*********************************** File appending process Ended *************************", $success=true, $return=false);
		status("*********************************** Database dump started *************************", $success=true, $return=false);

	}
	
	@chmod($temp_unzip_dir, 0755);
	discourageSearchEngine($temp_unzip_dir);
	if(file_exists($temp_unzip_dir.'/iwp_db/index.php')){
		include	$temp_unzip_dir.'/iwp_db/index.php';//this will overwrite few global variables $old_url and $old_file_path
		global $old_url, $old_file_path;
		if(isset($old_file_path)){
			$old_file_path = removeTrailingSlash($old_file_path);
		}
		if(isset($old_url)){
			$old_url = removeTrailingSlash($old_url);
		}
	}
	
	// ***************************************** }Extract the ZIP  Ends ****************************
	
	// ***************************************** Replace DB Starts{*********************************
	global $old_url, $new_url, $old_table_prefix, $table_prefix;
	$do_db_clone_basic_requirements = false;
	if(empty($prevMultiCallResponse['old_table_prefix'])){
		$old_table_prefix = trim(get_table_prefix($temp_unzip_dir));
		$do_db_clone_basic_requirements = true;
	} else{
		$old_table_prefix = $prevMultiCallResponse['old_table_prefix'];
	}
	if ($db_table_prefix && ($old_table_prefix != $db_table_prefix)) {
		$has_new_prefix = true;
		$table_prefix = $db_table_prefix;
	} else {
		$has_new_prefix = false;
		$table_prefix = $old_table_prefix;
	}
	
	if($do_db_clone_basic_requirements){
		$changed_prefix_config = change_table_prefix_config_file($temp_unzip_dir, $table_prefix);
		if ($changed_prefix_config) {
			status("Table prefix changed in Config file.", $success=true, $return=false);
		} else {
			die(status("Error: Couldn't change wp-config.php file.", $success=false, $return=true));
		}
	}
	
	@chmod($temp_unzip_dir.'/iwp_db',0755);
	
	$paths     = check_mysql_paths();
	$db_file_path = $temp_unzip_dir.'/iwp_db';
	$file_name = glob($db_file_path . '/*.sql');
	
	
	/*-----Replace URL--------*/
	$db_file = $file_name[0];
    $db_file = $db_file_path  . "/" . basename($db_file);
		
	/*if($do_db_clone_basic_requirements){
		if(modify_db_dump($db_file, $has_new_prefix)) {
			status("Database dump modified url and prefix.", $success=true, $return=false);
		} else {
			status("Error: Database dump cannot be modified.", $success=false, $return=true);
		}
	} /* No need to replace URL seperatly it can be done along with while query run */
	/*-----Replace URL-ends--------*/

	$brace     = (substr(PHP_OS, 0, 3) == 'WIN') ? '"' : '';
	$command   = $brace . $paths['mysql'] . $brace . ' --host="' . DB_HOST . '" --user="' . DB_USER . '" --password="' . DB_PASSWORD . '" --default-character-set="utf8" ' . DB_NAME . ' < ' . $brace . $db_file . $brace;
	
	$result = false;
	//$result = cmdExec($command);	
	
    iwp_mmb_auto_print('sql_import');
	
	if ($result){
		status("Database dump executed using command.", $success=true, $return=false);
	} else{
        //Else PHP db dump
        DB::doQuery("SET FOREIGN_KEY_CHECKS = 0");
        DB::doQuery("SET unique_checks=0");
        DB::doQuery("SET NAMES 'utf8'");
        // Read in entire file
        //$lines         = file($db_file);
   
        $handle = fopen($db_file, "r");

		global $response_arr;
		$response_arr = array();
		initialize_response_array($response_arr);
		$next_db_insert_id = empty($prevMultiCallResponse['next_db_insert_id']) ? 0 : $prevMultiCallResponse['next_db_insert_id'];
		$change_collotion = empty($prevMultiCallResponse['change_collotion']) ? 0 : $prevMultiCallResponse['change_collotion'];
		$finalQueryCount = empty($prevMultiCallResponse['finalQueryCount']) ? 0 : $prevMultiCallResponse['finalQueryCount'];
		$failedQueryCount = empty($prevMultiCallResponse['failedQueryCount']) ? 0 : $prevMultiCallResponse['failedQueryCount'];
		$count = 0;
        // Loop through each line
        if($handle){
            while (!feof($handle)){
            	$line = fgets($handle);
                $count ++;
            	
				if($count < $next_db_insert_id){
					continue;
				}

                iwp_mmb_auto_print('php_sql_import');
                // Skip it if it's a comment
                if(substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 3) == '/*!'){
                    continue;
				}
                $line = preg_replace_callback("/(TABLE[S]?|INSERT\ INTO|DROP\ TABLE\ IF\ EXISTS) [`]?([^`\;\ ]+)[`]?/", 'search_and_replace_prefix', $line);// this will replace the old prefix to new one 

                $current_query .= $line;

                if (strlen($current_query) < 10 || $current_query == ";") {
                	continue;
                }
               	if ($change_collotion == true && strrpos($current_query,'utf8mb4_unicode_520_ci')) {
               		$current_query = str_replace('utf8mb4_unicode_520_ci','utf8mb4_unicode_ci',$current_query);
               	}
                // If it has a semicolon at the end, it's the end of the query
               
                if(substr(trim($line), -1, 1) == ';'){
                    // Perform the query
                	$finalQueryCount ++;
                    $result = DB::doQuery($current_query);
                    if (!$result) {
                    	$failedQueryCount++;
						//------------Due to big query, error msg is not getting saved in IWP Panel DB due to max packet length and other issues-- this is a fix for it------
						$temp_error_replace_text = '...[Big text removed for error]...';
						$max_error_query_length = 1500 + strlen($temp_error_replace_text);
						$temp_current_query = $current_query;
						if(strlen($current_query) > $max_error_query_length){
							$temp_current_query = substr_replace($temp_current_query, '...[Big text removed for error]...', 750, -750);
						}
						$temp_current_query = htmlentities($temp_current_query);
						//------------Due to big query, error msg is not getting saved in IWP Panel DB due to max packet length and other issues-- this is a fix for it------
						echo "line count".$count;
                        $db_error = 'Error performing query "<strong>' . $temp_current_query . '</strong>": ' . DB::error().' Error Number'.DB::errorNo();
                        status("Failed to restore: "  . $db_error, $success=true, $return=false);
                        if (DB::errorNo()==1273) {
                        	$current_query = str_replace('utf8mb4_unicode_520_ci','utf8mb4_unicode_ci',$current_query);
                        	$result = DB::doQuery($current_query);
                        	$change_collotion = true;
                        }
                        clone_error_status_log($db_error);
                        // break;
                    }
                    // Reset temp variable to empty
                    $current_query = '';
					
					$is_multicall_break = check_for_clone_break();
					//if($key == 10){
					if($is_multicall_break){
						global $response_arr;
						$response_arr['next_db_insert_id'] = $count + 1;
						$response_arr['old_table_prefix'] = $old_table_prefix;
						$response_arr['is_extract_over'] = true;
						$response_arr['is_db_insert_over'] = false;
						$response_arr['failedQueryCount'] = $failedQueryCount;
						$response_arr['finalQueryCount'] = $finalQueryCount;
						$response_arr['change_collotion'] = $change_collotion;
						$response_arr['status'] = 'partiallyCompleted';
						$response_arr['break'] = true;
						$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
						break;
					}
                }
            }
        } else{
            $db_error = 'Cannot open database file.';
            fclose($handle);
        }
        fclose($handle);
		if($response_arr['break'] == true){
			//logExtractResponse($_REQUEST['extractParentHID'], array('status' => 'partiallyCompleted', 'sendResponse' => true, 'nextFunc' => 'backupFiles', 'responseParams' => $response_arr));
			storeCloningResponse();
			status("Query processed : ".$finalQueryCount, $success=true, $return=false);
			die(status("multicall", $success=true, $return=false, $response_arr));
			exit;
			return true;
			
		}
        
    	status("Total query executed : ".$finalQueryCount, $success=true, $return=false);
    	status("Total query failed : ".$failedQueryCount, $success=true, $return=false);
    	status("***********************************Database dump executed*********************************** ", $success=true, $return=false);

	}


	$dbModificationArray = array();
	$dbModificationArray['old_file_path'] = $old_file_path;
	$dbModificationArray['has_new_prefix'] = $has_new_prefix;
	$dbModificationArray['db_file'] = $db_file;
	$dbModificationArray['table_prefix'] = $table_prefix;
	$dbModificationArray['temp_unzip_dir'] = $temp_unzip_dir;
	$dbModificationArray['newUser'] = $newUser;
	$dbModificationArray['newPassword'] = $newPassword;
	$dbModificationArray['old_user'] = $old_user;
	$dbModificationArray['table_prefix'] = $table_prefix;
	$dbModificationArray['old_table_prefix'] = $old_table_prefix;
	$dbModificationArray['new_url'] = $new_url;
	$dbModificationArray['old_url'] = $old_url;

	$isBreak = check_for_clone_break();
	if ($isBreak) {
		global $response_arr;
		$response_arr = array();
		initialize_response_array($response_arr);
		$response_arr['status'] = 'partiallyCompleted';
		$response_arr['break'] = true;
		$response_arr['dbModificationArray'] = $dbModificationArray;
		$response_arr['dbModification'] = true;
		$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
		die(status("multicall", $success=true, $return=false, $response_arr));
		return $response_arr;
	}

	cloneDatabaseModification($dbModificationArray);
	// $result = copyFilesAndRemoveCloneDir($temp_unzip_dir, dirname(dirname(__FILE__)));
	// if ($result) {
	// 	sendCompleteResponse($newUser, $new_url, $old_user, $table_prefix);
	// }
	
	//@unlink('class-pclzip.php');	
	//@unlink('bridge.php');
	//@unlink('fileSystem.php');
	//@unlink($backup_file);
	
	//if(file_exists('error_log')) @unlink('error_log');
	//@clearstatcache();
	//@rmdir('../clone_controller');
	return true;
}

function unset_safe_path($path) {
        return str_replace("/", "\\", $path);
 }
function _dupx_array_rtrim(&$value) {
    $value = rtrim($value, '\/');
}

function cloneDatabaseModification($dbModificationArray){
	$old_file_path = $dbModificationArray['old_file_path'];
	$has_new_prefix = $dbModificationArray['has_new_prefix'];
	$db_file = $dbModificationArray['db_file'];
	$table_prefix = $dbModificationArray['table_prefix'];
	$temp_unzip_dir = $dbModificationArray['temp_unzip_dir'];
	$newUser = $dbModificationArray['newUser'];
	$newPassword = $dbModificationArray['newPassword'];
	$old_user = $dbModificationArray['old_user'];
	$table_prefix = $dbModificationArray['table_prefix'];
	$old_table_prefix = $dbModificationArray['old_table_prefix'];
	$new_url = $dbModificationArray['new_url'];
	$old_url = $dbModificationArray['old_url'];
	if ($has_new_prefix) {
    	$query = "
			UPDATE {$table_prefix}options
    		SET option_name = '{$table_prefix}user_roles'
    		WHERE option_name = '{$old_table_prefix}user_roles'
    		LIMIT 1";
        DB::doQuery($query) or die(status('Error replacing options values - ' . DB::error(), $success=false, $return=true));
		
    	$query = "
			UPDATE {$table_prefix}usermeta
	    	SET meta_key = CONCAT('{$table_prefix}', SUBSTR(meta_key, CHAR_LENGTH('{$old_table_prefix}') + 1))
	    	WHERE meta_key LIKE '{$old_table_prefix}%'";
    	DB::doQuery($query) or die(status('Error replacing usermeta values - ' . DB::error(), $success=false, $return=true));
    }
	
	status("DB restored", $success=true, $return=false);
	status("DB user role modified", $success=true, $return=false);
	
	@unlink($db_file);
	@unlink(dirname($db_file).'/index.php');
	@clearstatcache();
	@rmdir(dirname($db_file));
	status("Database file deleted", $success=true, $return=false);
	//}***************************************** Replace DB Ends*********************************
	
	//*********************************** Write the Config File Starts { *************************
	status("*********************************** Write the Config File Starts { *************************", $success=true, $return=false);
	
	$lines = @file($temp_unzip_dir.'/wp-config.php');
    if(empty($lines)){
		$lines = @file($temp_unzip_dir.'/wp-config-sample.php');
	}
	@unlink($temp_unzip_dir.'/wp-config.php'); // Unlink if a config already exists
	if(empty($lines)){ die(status("Please replace wp-config.php. It seems missing", $success=false, $return=true)); }
	foreach ($lines as $line) {
		if (strstr($line, 'DB_NAME')){
			$line = "define('DB_NAME', '".DB_NAME."');\n";
		}
		if (strstr($line, 'DB_USER')){
			$line = "define('DB_USER', '".DB_USER."');\n";
		}
		if (strstr($line, 'DB_PASSWORD')){
			$line = "define('DB_PASSWORD', '".DB_PASSWORD."');\n";
		}
		if (strstr($line, 'DB_HOST')){
			$line = "define('DB_HOST', '".DB_HOST."');\n";
		}
		if (strstr($line, 'WP_HOME') || strstr($line, 'WP_SITEURL')){
			$line = "";
		}
		if(file_put_contents($temp_unzip_dir.'/wp-config.php', $line, FILE_APPEND) === FALSE)
			die(status("Permission denied to write the config file.", $success=false, $return=true));
	}
	status("*********************************** Write the Config File Ends { *************************", $success=true, $return=false);			
	// }*********************************** Write the Config File Ends **********************************
			
	if (!$old_url) {//$old_url - old site url
		$query =  "SELECT option_value FROM " . $table_prefix . "options  WHERE option_name = 'siteurl' LIMIT 1";
		$result = DB::doQuery($query) or die(status('Error getting old site URL' . DB::error(), $success=false, $return=true));
        $_result = new DB::$DBResultClass($result);
		$info = $_result->nextRow($_result);
		$old_url = removeTrailingSlash($info['option_value']);
	}
				
	// Update the Home / Site URL
	/* This will happen next
	$query = "UPDATE " . $table_prefix . "options SET option_value = '".$new_url."' WHERE option_name = 'home'";
	DB::doQuery($query) or die(status("Error updating the home URL", $success=false, $return=true));
	status("Home URL updated", $success=true, $return=false);
	
	$query = "UPDATE " . $table_prefix . "options  SET option_value = '".$new_url."' WHERE option_name = 'siteurl'";
	DB::doQuery($query) or die(status("Error updating the site URL", $success=false, $return=true));
	status("Site URL updated", $success=true, $return=false);
	*/
	
	//Set the new admin password  
	if ($newUser && $newPassword && $old_user) {//$newPassword -> md5ed password
		$query = "UPDATE " . $table_prefix . "users SET user_login = '".$newUser."', user_pass = '".$newPassword."' WHERE user_login = '".$old_user."'";
		DB::doQuery($query) or die(status("Error setting up credentials.", $success=false, $return=true));
		status("Credentials updated.", $success=true, $return=false);
	}
	//Remove trailing slashes
	$isBreak = check_for_clone_break();
		if ($isBreak) {
			global $response_arr;
			$response_arr = array();
			initialize_response_array($response_arr);
			$response_arr['status'] = 'partiallyCompleted';
			$response_arr['break'] = true;
			$response_arr['dbModificationArray'] = $dbModificationArray;
			$response_arr['oldURLReplacement'] = true;
			$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
			die(status("multicall", $success=true, $return=false, $response_arr));
			return $response_arr;
		}
	oldURLReplacement($dbModificationArray, false);
	
}
function oldURLReplacement($dbModificationArray, $is_fresh = false){
		$table_prefix = $dbModificationArray['table_prefix'];
		$temp_unzip_dir = $dbModificationArray['temp_unzip_dir'];
		$newUser = $dbModificationArray['newUser'];
		$newPassword = $dbModificationArray['newPassword'];
		$old_user = $dbModificationArray['old_user'];
		$old_table_prefix = $dbModificationArray['old_table_prefix'];
		$new_url = $dbModificationArray['new_url'];
		$old_url = $dbModificationArray['old_url'];
		$old_file_path = $dbModificationArray['old_file_path'];
		$url_old_json = str_replace('"', "", json_encode($old_url));
		$url_new_json = str_replace('"', "", json_encode($new_url));
		$path_old_json = str_replace('"', "", json_encode($old_file_path));
		$path_new_json = str_replace('"', "", json_encode($GLOBALS['new_file_path']));

		array_push($GLOBALS['REPLACE_LIST'], 
				array('search' => $old_url,			 'replace' => $new_url), 
				array('search' => $old_file_path,			 'replace' => $GLOBALS['new_file_path']), 
				array('search' => $url_old_json,				 'replace' => $url_new_json), 
				array('search' => $path_old_json,				 'replace' => $path_new_json), 	
				array('search' => urlencode($old_file_path), 'replace' => urlencode($GLOBALS['new_file_path'])), 
				array('search' => urlencode($old_url),  'replace' => urlencode($new_url)),
				array('search' => rtrim(unset_safe_path($old_file_path), '\\'), 'replace' => rtrim($GLOBALS['new_file_path'], '/'))
		);

		array_walk_recursive($GLOBALS['REPLACE_LIST'], _dupx_array_rtrim);
		if ($is_fresh == false && empty($dbModificationArray['replaceTableList'])) {
			$result = DB::getFields( 'SHOW TABLES LIKE "'.$table_prefix.'%"');
		}else{
			$result = $dbModificationArray['replaceTableList'];
		}
		foreach ($result as $key => $value) {
			DBUpdateEngine::load($GLOBALS['REPLACE_LIST'], array(0=>$value), true);
			status("Table ".$value." URL content updated.", $success=true, $return=false);
			unset($result[$key]);
			$isBreak = check_for_clone_break();
			if ($isBreak) {
				global $response_arr;
				$response_arr = array();
				initialize_response_array($response_arr);
				$response_arr['status'] = 'partiallyCompleted';
				$response_arr['break'] = true;
				$dbModificationArray['replaceTableList'] = $result;
				$response_arr['dbModificationArray'] = $dbModificationArray;
				$response_arr['oldURLReplacement'] = true;
				$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
				die(status("multicall", $success=true, $return=false, $response_arr));
				return $response_arr;
			}
		}
		//Replace the post contents
		// $query = "UPDATE " . $table_prefix . "posts SET post_content = REPLACE (post_content, '$old_url','$new_url') WHERE post_content REGEXP 'src=\"(.*)$old_url(.*)\"' OR post_content REGEXP 'href=\"(.*)$old_url(.*)\"'";
		// DB::doQuery($query) or die(status("Error updating the post content", $success=false, $return=true));
		status("Post content updated.", $success=true, $return=false);
		 
		//$table = $GLOBALS['table_prefix'].'iwp_backup_status';
		 
		//mysql_num_rows(mysql_query("SHOW TABLES LIKE ".$table_prefix."iwp_backup_status"))
		$queryTestBS = DB::doQuery("SHOW TABLES LIKE '".$table_prefix."iwp_backup_status'");
		if(!$queryTestBS){
			echo DB::error();
		}
		$_result = new DB::$DBResultClass($queryTestBS);
		$queryTestBSRows = $_result->numRows($_result);
			
		if($queryTestBSRows){
			$delete = DB::doQuery("TRUNCATE TABLE ".$table_prefix."iwp_backup_status ")or die(status('Failed to clear old IWP backup status table.' . DB::error(), $success=false, $return=true));
			status("IWP backup status table cleared", $success=true, $return=false);
		}
		 
		//clearing iwp-client plugin iwp_client_public_key, iwp_client_action_message_id, iwp_client_nossl_key
		$query = "DELETE FROM " . $table_prefix . "options WHERE option_name = 'iwp_client_public_key' OR option_name = 'iwp_client_action_message_id' OR option_name = 'iwp_client_nossl_key'";
		DB::doQuery($query) or die(status('Failed to clear old IWP Client Plugin details.' . DB::error(), $success=false, $return=true));
		status("Cleared old IWP Client Plugin details.", $success=true, $return=false);
		
		//Remove the iwp-client plugin old data // Need to change these
		$query = "DELETE FROM " . $table_prefix . "options WHERE option_name IN ('iwp_backup_tasks', 'iwp_notifications', 'iwp_client_brand', 'user_hit_count', 'iwp_pageview_alerts')";
		DB::doQuery($query) or die(status('Error deleting client settings' . DB::error(), $success=false, $return=true));
		status("IWP settings Deleted", $success=true, $return=false);  
			   
	    if (!empty($_REQUEST['toIWP'])) {
			$iwp_client_activation_key = sha1( rand(1, 99999). uniqid('', true) .$new_url);
			$query = "REPLACE INTO " . $table_prefix . "options(option_name, option_value) VALUES('iwp_client_activate_key', '$iwp_client_activation_key')";
			DB::doQuery($query) or die(status("Failed to create Activation Key", $success=false, $return=true));
			status("Activation Key Created", $success=true, $return=false);
	    } else{
			//deactivate iwp-client plugin
			$query = "SELECT option_value FROM " . $table_prefix . "options WHERE option_name='active_plugins'";
			$result = DB::doQuery($query) or die(status("Failed to get active plugins", $success=false, $return=true));
	        $_result = new DB::$DBResultClass($result);
			$row = $_result->nextRow($_result);
			$active_plugins = @unserialize($row['option_value']);
			$key = array_search('iwp-client/init.php', $active_plugins);
			if($key !== false && $key !== NULL){
				unset($active_plugins[$key]);
			}
			$active_plugins = @serialize($active_plugins);
			$query = "UPDATE " . $table_prefix . "options SET option_value = '$active_plugins' WHERE option_name='active_plugins'";
			$result = DB::doQuery($query) or die(status("Failed to deactivate client plugin", $success=false, $return=true));
		}
			   
		$admin_email = trim($_REQUEST['admin_email']);
	    if(trim($old_user) == ''){
	    	if ($admin_email) {
				//Clean Install
				$query = "UPDATE " . $table_prefix . "options SET option_value = '$admin_email' WHERE option_name = 'admin_email'";
				DB::doQuery($query) or die(status('Error setting admin email - ' . DB::error(), $success=false, $return=true));
				status("Admin Email created", $success=true, $return=false);
				
				$query = "SELECT * FROM " . $table_prefix ."users LIMIT 1";
				$temp_user_result = DB::doQuery($query) or die(status('Error: user to replace not found - ' . DB::error(), $success=false, $return=true));
				$_result = new DB::$DBResultClass($temp_user_result);
				if($temp_user = $_result->nextRow($_result)){
					$query        = "UPDATE " . $table_prefix . "users SET user_email='$admin_email', user_login = '$newUser', user_pass = '$newPassword' WHERE user_login = '$temp_user[user_login]'";
					DB::doQuery($query) or die(status('Error setting new user - ' . DB::error(), $success=false, $return=true));
					status("New User Created", $success=true, $return=false);
				}
			} else {
	    		//Clone from url
	    		if($newUser && $newPassword){
					$query = "UPDATE " . $table_prefix . "users SET user_pass = '$newPassword' WHERE user_login = '$newUser'";
					DB::doQuery($query) or die(status('Error setting new password - ' . DB::error(), $success=false, $return=true));
					status("New Password Created", $success=true, $return=false);
				}
	    	}
	    }
		
		//Reset media upload settings
	    $query = "UPDATE " . $table_prefix . "options SET option_value = '' WHERE option_name = 'upload_path' OR option_name = 'upload_url_path'";
	    DB::doQuery($query) or die(status('Error setting media upload settings - ' . DB::error(), $success=false, $return=true));
		
		//@mysql_close($sqlConnect);
		status("DB Modifications done", $success=true, $return=false);

		//$result = copyFilesAndRemoveCloneDir($temp_unzip_dir, dirname(dirname(__FILE__)));
		//if ($result) {
		status("*********************************** Server config file reset process started*************************", $success=true, $return=false);
		replace_htaccess($new_url, $temp_unzip_dir, $old_file_path);
		status("********** Wordfence configurations **********", $success=true, $return=false);
		resetWordfenceConfig($temp_unzip_dir, $old_file_path);
		status("*********************************** Server config file reset process ended *************************", $success=true, $return=false);
		replaceOldCachePath($temp_unzip_dir, $old_file_path);
		deleteCloneDir();
		sendCompleteResponse($newUser, $new_url, $old_user, $table_prefix);
		//}
}
function extract_in_multicall($backup_file, $temp_unzip_dir){
	$backup_file_temp = $backup_file;
	foreach($backup_file as $key => $single_backup_file)
	{
		status("Extracting backup file ".$single_backup_file, $success=true, $return=false);
		/* iwp_mmb_auto_print('unzipping');
		$unzip = cmdExec('which unzip', true);
		if (!$unzip) $unzip = "unzip";   
		$command = "$unzip -d $temp_unzip_dir -o $single_backup_file";
		$result = cmdExec($command); */
		
		$result = false;
		if (!$result) {
			$archive   = new IWPPclZip($single_backup_file);
			$extracted = $archive->extract(IWP_PCLZIP_OPT_PATH, $temp_unzip_dir, IWP_PCLZIP_OPT_TEMP_FILE_THRESHOLD, 1);
			if ($extracted['break']) {
				$extracted['bkfile'] = $backup_file_temp;
				return $extracted;
			}

			if (!$extracted || $archive->error_code) {
				die(status('Error: Failed to extract backup file (' . $archive->error_string . ').'.$GLOBALS['downloadPossibleError'], $success=false, $return=true));
			}
			unset($backup_file_temp[$key]);
			unlink($single_backup_file);
			unset($_REQUEST['params']['responseData']['next_extract_id']);
			unset($_REQUEST['params']['responseData']['v_pos_entry']);
		} else{
			status('Native zip is used to unzip.', $success=true, $return=false);
		}
	}
}

function copyFilesAndRemoveCloneDir($fromFile, $toFile, $skipList = array(), $prevMultiCallResponse = array() ){
	
	if (empty($fromFile)) {
		return false;
	}
	initFileSystem(false, dirname(dirname(__FILE__)));
	$isBreak = check_for_clone_break();
	if ($isBreak) {
		global $response_arr;
		initialize_response_array($response_arr);
		$response_arr['from_dir'] = $fromFile;
		$response_arr['to_dir'] = $toFile;
		$response_arr['is_file_copy'] = true;
		$response_arr['status'] = 'partiallyCompleted';
		$response_arr['break'] = true;
		$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
		die(status("multicall", $success=true, $return=false, $response_arr));
		return $response_arr;
	}
		$FSCopyResult = array();
		$FSCopyResult = multicallFSCopyDir($fromFile, $toFile);
		if($FSCopyResult['break']){
			global $response_arr;
			echo "file copy break";
			$response_arr = array();
			initialize_response_array($response_arr);
			$response_arr['is_file_copy'] = true;
			$response_arr['status'] = 'partiallyCompleted';
			$response_arr['break'] = true;
			$response_arr['from_dir'] = $fromFile;
			$response_arr['to_dir'] = $toFile;
			$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
			die(status("multicall", $success=true, $return=false, $response_arr));
			return $response_arr;
		}
	
		if($FSCopyResult !== true){
			die(status("Error in file system copy.", $success=false, $return=true));
		}
		
		deleteCloneDir();
		return true;
		
}

function deleteCloneDir(){
		unlink(dirname(__FILE__)."/bridge.php");
		unlink(dirname(__FILE__)."/fileSystem.php");
		unlink(dirname(__FILE__)."/class-pclzip.php");
		unlink(dirname(__FILE__)."/db.php");
		echo "<h1>Clone Completed</h1>";
		$mem_peak = (memory_get_peak_usage(true)/1024/1024);
		status("clone_completed", $success=true, $return=false);//changing success or status will affect result processing in addon controller
		return true;
}

function deleteCloneDirWhileError(){
	$directFSObj = new filesystemDirect('');
	$directFSObj->delete(dirname(__FILE__), true);
	echo "Clone folder deleted during error";
}

function discourageSearchEngine($temp_unzip_dir){
	if (isset($_REQUEST['isStaging'])) {
		$data = "User-agent: *\nDisallow: /\n";
		@file_put_contents($temp_unzip_dir.'/robots.txt', $data);
	}
}

function sendCompleteResponse($newUser, $new_url, $old_user, $db_table_prefix){
	status("clone_completed", $success=true, $return=false);
	if (!empty($_REQUEST['toIWP'])) {
		$query = "SELECT option_value FROM " . $db_table_prefix . "options WHERE option_name='iwp_client_activate_key'";
			$temp_user_result = DB::doQuery($query) or die(status('Error: user to replace not found - ' . DB::error(), $success=false, $return=true));
			$_result = new DB::$DBResultClass($temp_user_result);
			$row = $_result->nextRow($_result);
			$iwp_client_activation_key = $row['option_value'];
			if(!empty($newUser)){
				status("Datas", $success=true, $return=false, array('URL' => $new_url, 'userName' => $newUser, 'activationKey' => $iwp_client_activation_key));
			} else{
				status("Datas", $success=true, $return=false, array('URL' => $new_url, 'userName' => $old_user, 'activationKey' => $iwp_client_activation_key));
			}
		}
}

function initialize_response_array(&$response_arr){
	$response_arr['db_table_prefix'] = $_REQUEST['db_table_prefix'];
	$response_arr['temp_unzip_dir'] = $_REQUEST['temp_unzip_dir'];
	$response_arr['temp_pclzip'] = $_REQUEST['temp_pclzip'];
	$response_arr['bkfile'] = $_REQUEST['bkfile'];
	$response_arr['extractParentHID'] = $_REQUEST['extractParentHID'];
	$response_arr['isDownloadMultiCall'] = false;
	$response_arr['is_file_append'] = false;
	$response_arr['dbModification'] = false;
	$response_arr['oldURLReplacement'] = false;
	$response_arr['next_extract_id'] = 0;
	$response_arr['isStaging'] = $_REQUEST['isStaging'];
	$response_arr['status'] = 'completed';
	$response_arr['break'] = false;
}

function get_files_array_from_iwp_part($backup_file, $manual = ''){
	$backup_files_array = array();
	if(!is_array(($backup_file)) && strpos($backup_file, '_iwp_part') !== false)
	{
		$orgName = substr($backup_file, 0, strpos($backup_file, '_iwp_part_'));
		if (!empty($manual)) {
			$orgName = $orgName;
		}
		$totalParts = substr($backup_file, strpos($backup_file, '_iwp_part_')+10);
		$totalParts = substr($totalParts, 0, strlen($totalParts)-4);
		for($i=0; $i<=$totalParts; $i++)
		{
			iwp_mmb_auto_print('get_files_array_from_iwp_part');
			if($i == 0)
			{
				$backup_files_array[] = $orgName.'.zip';
			} else {
				$backup_files_array[] = $orgName.'_iwp_part_'.$i.'.zip';
			}
		}
		return $backup_files_array;
	} else {
		if (!empty($manual)) {
			$backup_file = $backup_file;
		}
		$backup_files_array[] = $backup_file;
		return $backup_file;
	}
}

function appendSplitFiles($fileToAppend){
	 // function to join the split files during multicall backup
	
	if (!is_array($fileToAppend)) {
		$directory_tree = get_all_files_from_dir($fileToAppend);
		$isBreak = check_for_clone_break();
		if ($isBreak) {
			global $response_arr;
			$response_arr = array();
			initialize_response_array($response_arr);
			$response_arr['is_file_append'] = true;
			$response_arr['status'] = 'partiallyCompleted';
			$response_arr['break'] = true;
			$response_arr['kuppu'] = true;
			$response_arr['is_extract_over'] = true;
			$response_arr['appendFileLists'] = $directory_tree;
			$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
			die(status("multicall", $success=true, $return=false, $response_arr));
			return $response_arr;
		}
	} else{
		$directory_tree = $fileToAppend;
	}
	usort($directory_tree, "sortString");
	$joinedFilesArray = array();
	$orgHashValues = array();
	$hashValue = '';
		
	foreach($directory_tree as $k => $v)
	{
		$contents = '';
			$orgFileCount = 0;
			$count = 0;
		/* $subject = $v;
		$pattern = '/iwp_part/i';
		preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
		print_r($matches); */
		$pos = strpos($v, 'iwp_part');
		if($pos !== false)
		{
			$count ++;
			$currentFile = explode(".",$v);
				$currentFileSize = count($currentFile);
			 foreach($currentFile as $key => $val)
				{
					iwp_mmb_auto_print('appendSplitFiles');
					if(($key == ($currentFileSize-2))||($currentFileSize == 1))
					{
						$insPos = strpos($val, '_iwp_part');
						$rest = substr_replace($val, '', $insPos);
						$currentFile[$key] = $rest;
						
						$insPos2 = strpos($rest, '_iwp_hash');
						if($insPos2 != false)
						{
							$hashValue = substr($rest, -32);
							$rest = substr_replace($rest, '', $insPos2);
							$currentFile[$key] = $rest;
						}
					}
				}
				$orgFileCount++;	
			$orgFileName = implode(".", $currentFile);
			$handle = fopen($v,"r");
			$contents = fread($handle, filesize($v));
			fclose($handle);
				if($orgFileCount == 1)
				{
					//clearing contents of file intially to prevent appending to already existing file
				}
			file_put_contents($orgFileName,$contents,FILE_APPEND);
			$joinedFilesArray[$orgFileName] = 'hash';
			$orgHashValues[$orgFileName] = $hashValue;
			echo " orgFileName - ".$orgFileName;
			$file_to_ulink = realpath($v);
			$resultUnlink = unlink($file_to_ulink);
			$resultUnlink = error_get_last();
			if(!$resultUnlink)
			{
				if(is_file($v))
				{
					unlink($file_to_ulink);
				}
			}
			if (!is_file($v)) {
				unset($directory_tree[$k]);
			}
		}

		$isBreak = check_for_clone_break();
		if ($isBreak) {
			global $response_arr;
			$response_arr = array();
			initialize_response_array($response_arr);
			$response_arr['is_file_append'] = true;
			$response_arr['status'] = 'partiallyCompleted';
			$response_arr['break'] = true;
			$response_arr['kuppu'] = true;
			$response_arr['is_extract_over'] = true;
			$response_arr['appendFileLists'] = $directory_tree;
			$response_arr['peak_mem_usage'] = (memory_get_peak_usage(true)/1024/1024);
			die(status("multicall", $success=true, $return=false, $response_arr));
			return $response_arr;
		}
	}
	// md5 hash check currently not in use 
	// $hashValues = array();
	// foreach($joinedFilesArray as $key => $value)
	// {
	// 	$hashValues[$key] = md5_file($key);
	// }
	// 	$totalHashValues = array();
	// 	$totalHashValues['orgHash'] = $orgHashValues;
	// 	$totalHashValues['afterSplitHash'] = $hashValues;
	// 	return $totalHashValues;
}

function sortString($a, $b){
	// the uSort CallBack Function used in the appendSplitFiles function
	$stringArr = array();
	$stringArr[0] = $a;
	$stringArr[1] = $b;
	$strA = '';
	$strB = '';
	foreach($stringArr as $strKey => $strVal)
	{
		$mystring = $strVal;
		$findme = '_iwp_part';																		//fileNameSplit logic
		$pos = strpos($mystring, $findme);
		$rest = substr($mystring, $pos);
		$pos2 = strrpos($rest, $findme);
		$len = strlen($rest);
		$actLen = $pos2+strlen($findme);
		$actPos = $len - $actLen -1;
		$actPartNum = substr($rest, -($actPos));
			$actPartNumArray = explode(".",$actPartNum);
			foreach($actPartNumArray as $key => $val)
			{
				if($key == 0)
				$actPartNum = $val;
			}
		if($strKey == 0){
			$strA = intval($actPartNum);
		}
		else{
			$strB = intval($actPartNum);
		}
	}
	if ($strA == $strB){return 0;}
	return ($strA < $strB) ? -1 : 1;	
}

function get_all_files_from_dir($path, $exclude = array()){
	if ($path[strlen($path) - 1] === "/") $path = substr($path, 0, -1);
	global $directory_tree, $ignore_array;
	$directory_tree = array();
	foreach ($exclude as $file) {
		if (!in_array($file, array('.', '..'))) {
			if ($file[0] === "/") $path = substr($file, 1);
			$ignore_array[] = "$path/$file";
		}
	}
	get_all_files_from_dir_recursive($path);
	return $directory_tree;
}

function get_all_files_from_dir_recursive($path, $ignore_array=array()){
	if ($path[strlen($path) - 1] === "/") $path = substr($path, 0, -1);
	global $directory_tree, $ignore_array;
	$directory_tree_temp = array();
	$dh = @opendir($path);
	if(empty($ignore_array))
	{
		$ignore_array = array();
	}
	while (false !== ($file = @readdir($dh))) {
		if (!in_array($file, array('.', '..'))) {
			if (!in_array("$path/$file", $ignore_array)) {
				if (!is_dir("$path/$file")) {
						$pos = strpos("$path/$file", 'iwp_part');
						if($pos !== false) {
							$directory_tree[] = "$path/$file";
						}
				} else {
					iwp_mmb_auto_print('appendSplitFiles');
					get_all_files_from_dir_recursive("$path/$file");
				}
			}
		}
	}
	@closedir($dh);
}

function change_table_prefix_config_file($file_path, $db_table_prefix){
	//select wp-config-sample.php
	$wp_config_file = glob($file_path . '/wp-config.php');
	if (@rename($wp_config_file[0], $file_path.'/wp-config-temp.php')) {
		$lines = file($file_path.'/wp-config-temp.php');
		@unlink($file_path.'/wp-config-temp.php');
	} else {
		$lines = @file($file_path.'/wp-config-sample.php');
	}

	@unlink($file_path.'/wp-config.php');

	if (empty($lines))
		die(status('Error: Cannot recreate wp-config.php file.', $success=false, $return=true));

	$file_success = false;

	foreach ($lines as $line) {
		if ($db_table_prefix && strstr($line, '$table_prefix')) {
			$line         = "\$table_prefix = '$db_table_prefix';\n";
			$file_success = true;
		}

		if (file_put_contents($file_path.'/wp-config.php', $line, FILE_APPEND) === FALSE)
			die(status('Error: Cannot write wp-config.php file.', $success=false, $return=true));
	}
	return $file_success;
}

function cmdExec(){
	if ($command == ''){
		return false;
	}
    if (checkFunctionExists('exec')) {
        $log = @exec($command, $output, $return);
        if ($string)
            return $log;
        return $return ? false : true;
    } else if (checkFunctionExists('system')) {
        $log = @system($command, $return);
        if ($string){
			return $log;
        }
        return $return ? false : true;
    } else if (checkFunctionExists('passthru') && !$string) {
        $log = passthru($command, $return);
        return $return ? false : true;
    } else {
        return false;
    }
}

function checkFunctionExists($function_callback){
	
	if(!function_exists($function_callback)){
		return false;
	}
		
	$disabled = explode(', ', @ini_get('disable_functions'));
	if (in_array($function_callback, $disabled)){
		return false;
	}
		
	if (extension_loaded('suhosin')) {
		$suhosin = @ini_get("suhosin.executor.func.blacklist");
		if (empty($suhosin) == false) {
			$suhosin = explode(',', $suhosin);
			$blacklist = array_map('trim', $suhosin);
			$blacklist = array_map('strtolower', $blacklist);
			if(in_array($function_callback, $blacklist)){
				return false;
			}
		}
	}
	return true;
}

function get_table_prefix($temp_unzip_dir){
	$lines = file($temp_unzip_dir.'/wp-config.php');
	foreach ($lines as $line) {
		if (strstr($line, '$table_prefix')) {
			$pattern = "/(\'|\")[^(\'|\")]*/";
			preg_match($pattern, $line, $matches);
			$prefix = substr($matches[0], 1);
			return $prefix;
			break;
		}
	}
	return 'wp_'; //default
}

if (!function_exists('file_put_contents')){
	function file_put_contents($filename, $data){
		$f = @fopen($filename, 'w');
		if (!$f) {
		  die(status("Error - Fopen needs to be enabled in your server", $success=false, $return=true));
		} else {
			$bytes = fwrite($f, $data);
			fclose($f);
			return $bytes;
		}
	}
}

function check_mysql_paths(){
	 $paths = array(
		'mysql' => '',
		'mysqldump' => ''
	);
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		$mysql_install = DB::doQuery("SHOW VARIABLES LIKE 'basedir'");
		$_result = new DB::$DBResultClass($mysql_install);
		$mysql_install = $_result->nextRow($_result);
		appUpdateMsg("inside-check-mysql-path : ".$mysql_install->Value);
		if ($mysql_install) {
			$install_path       = str_replace('\\', '/', $mysql_install->Value);
			$paths['mysql']     = $install_path . 'bin/mysql.exe';
			$paths['mysqldump'] = $install_path . 'bin/mysqldump.exe';
		} else {
			$paths['mysql']     = 'mysql.exe';
			$paths['mysqldump'] = 'mysqldump.exe';
		}
	} else {
		$paths['mysql'] = cmdExec('which mysql', true);
		if (empty($paths['mysql']))
			$paths['mysql'] = 'mysql'; // try anyway
		
		$paths['mysqldump'] = cmdExec('which mysqldump', true);
		if (empty($paths['mysqldump']))
			$paths['mysqldump'] = 'mysqldump'; // try anyway         
		
	}
	
	return $paths;
}

function check_sys(){
	if ($this->mmb_function_exists('exec')){
		return 'exec';
	}

	if ($this->mmb_function_exists('system')){
		return 'system';
	}

	if ($this->mmb_function_exists('passhtru')){
		return 'passthru';
	}

	return false;
	
}

function replace_htaccess($url, $temp_unzip_dir, $old_file_path){
	$file = @file_get_contents($temp_unzip_dir.'/.htaccess.orgi');
    if ($file && strlen($file)) {
        $args    = parse_url($url);        
        $string  = rtrim($args['path'], "/");
        $regex   = "/BEGIN WordPress(.*?)RewriteBase(.*?)\n(.*?)RewriteRule \.(.*?)index\.php(.*?)END WordPress/sm";
        $replace = "BEGIN WordPress$1RewriteBase " . $string . "/ \n$3RewriteRule . " . $string . "/index.php$5END WordPress";
        $file    = preg_replace($regex, $replace, $file);
        $file    = str_replace($old_file_path, $GLOBALS['new_file_path'], $file);

        status(".htaccess content modified", $success=true, $return=false);
        
        @file_put_contents($temp_unzip_dir.'/.htaccess', $file);
    }
	if (isset($_REQUEST['isStaging'])) {
		replaceDefaultHtaccess($url, $temp_unzip_dir);
	}
	status(".htaccess file changed", $success=true, $return=false);

}

function renameServerConfig($temp_unzip_dir){
	$file = @file_get_contents($temp_unzip_dir.'/.htaccess');
    if ($file && strlen($file)) {
		@file_put_contents($temp_unzip_dir.'/.htaccess.orgi', $file);
		@unlink($temp_unzip_dir.'/.htaccess');
		status(".htaccess rename", $success=true, $return=false);
	}
	$isUseriniCopied = @copy($temp_unzip_dir.'/.user.ini', $temp_unzip_dir.'/.user.ini.orgi');
	if ($isUseriniCopied) {
		@unlink($temp_unzip_dir.'/.user.ini');
		status(".user.ini renamed for wordfence", $success=true, $return=false);
	}
	$isWebConfigCopied = @copy($temp_unzip_dir.'/web.config', $temp_unzip_dir.'/web.config.orgi');
	if ($isWebConfigCopied) {
		@unlink($temp_unzip_dir.'/web.config');
		status("web.config file renamed", $success=true, $return=false);
	}

}

function replaceDefaultHtaccess($url,$temp_unzip_dir){
	$args    = parse_url($url);        
	$string  = rtrim($args['path'], "/");
	$data = "# BEGIN WordPress\n<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteBase /".$string."/\nRewriteRule ^index\.php$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . /".$string."/index.php [L]\n</IfModule>\n# END WordPress";
	@file_put_contents($temp_unzip_dir.'/.htaccess', $data);
}
function resetWordfenceConfig($temp_unzip_dir, $old_file_path){
	$file = @file_get_contents($temp_unzip_dir.'/.user.ini.orgi');
	if ($file && strlen($file)) {
		$file    = str_replace($old_file_path, $GLOBALS['new_file_path'], $file);
		$file = @file_put_contents($temp_unzip_dir.'/.user.ini', $file);
		status(".user.ini old path replaced", $success=true, $return=false);
	}
	$file = @file_get_contents($temp_unzip_dir.'/wordfence-waf.php');
	if ($file && strlen($file)) {
		$file    = str_replace($old_file_path, $GLOBALS['new_file_path'], $file);
		$file = @file_put_contents($temp_unzip_dir.'/wordfence-waf.php', $file);
		status("wordfence-waf.php old path replaced", $success=true, $return=false);
	}
}

function replaceOldCachePath($temp_unzip_dir, $old_file_path){
	$file = @file_get_contents($temp_unzip_dir.'/wp-config.php');
	if ($file && strlen($file)) {
		$file    = str_replace($old_file_path, $GLOBALS['new_file_path'], $file);
		$file = @file_put_contents($temp_unzip_dir.'/wp-config.php', $file);
		status("old cache path replaced in wp-config.php", $success=true, $return=false);
	}
}

function modify_db_dump($db_file, $has_new_prefix){
	copy($db_file,$db_file.'tmp');
	$handle = fopen($db_file.'tmp', "r");
	@unlink($db_file);
	// Loop through each line
	
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
                        iwp_mmb_auto_print('modify_db_dump');
			// Skip it if it's a comment
                        if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 3) == '/*!')
				continue;
			
			
			
			//$line = preg_replace_callback('/\\\'(.*?[^\\\\])\\\'[\\,\\)]/', 'search_and_replace_url', $line);//old - /\'([^\']+)\'[\,\)]/ new - /\'(.*?[^\\])\'[\,\)]/
			if ($has_new_prefix) {
				$line = preg_replace_callback("/(TABLE[S]?|INSERT\ INTO|DROP\ TABLE\ IF\ EXISTS) [`]?([^`\;\ ]+)[`]?/", 'search_and_replace_prefix', $line);				
			}
			// Add this line to the current segment
			if (file_put_contents($db_file, $line, FILE_APPEND) === FALSE)
            	die(status('Error: Cannot write wp-config.php file.', $success=false, $return=true));
		}
		fclose($handle);
		@unlink($db_file.'tmp');
		return true;
	} else {
		fclose($handle);
		@unlink($db_file.'tmp');
		return false;
	}
}

function is_serialized( $data ){
	
	// if it isn't a string, it isn't serialized
	if ( ! is_string( $data ) )
		return false;
	$data = trim( $data );
	if ( 'N;' == $data )
		return true;
	$length = strlen( $data );
	if ( $length < 4 )
		return false;
	if ( ':' !== $data[1] )
		return false;
	$lastc = $data[$length-1];
	if ( ';' !== $lastc && '}' !== $lastc )
		return false;
	$token = $data[0];
	switch ( $token ) {
		case 's' :
			if ( '"' !== $data[$length-2] )
				return false;
		case 'a' :
		case 'O' :
			return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		case 'b' :
		case 'i' :
		case 'd' :
			return (bool) preg_match( "/^{$token}:[0-9.E-]+;\$/", $data );
	}
	return false;
}

function apply_replaces($subject, $is_serialized = false){
	global $old_url, $new_url, $old_file_path;
	
	$search = array();
	$replace = array();
	
	//all these values with untrailed slashes will be good
	
	$search[0] = $old_url;
	$replace[0] = $new_url;
	
	if(!empty($old_file_path)){
		$search[1] = $old_file_path;
		$replace[1] = $GLOBALS['new_file_path'];
	}

	return str_replace($search, $replace, $subject);
}

function replace_array_values(&$value, $key){
	if (!is_string($value)) return;
	$value = apply_replaces($value, true);
}

function search_and_replace_url($matches){

	global $old_url, $old_file_path;
	$replace = $search = $matches[1];
	$subject = $matches[0];
	
	if (($old_url && strpos($replace, $old_url) !== false) || ($old_file_path && strpos($replace, $old_file_path) !== false)) {//URL and file path IWP improvement
		if (is_serialized(stripcslashes($replace)) && false !== ($data = @unserialize(stripcslashes($replace)))) {
			if ( is_array( $data ) ) {
				array_walk_recursive($data, 'replace_array_values');
			} else if (is_string($data)) {
				$data = apply_replaces($data, true);
			}
			$replace = addslashes(serialize($data));
			$replace = str_replace("\r", '\r', $replace);
			$replace = str_replace("\n", '\n', $replace);
		} else {
			$replace = apply_replaces($replace);
		}
	}
	return str_replace($search, $replace, $subject);
}

function search_and_replace_prefix($matches){
	global $old_table_prefix, $table_prefix;
	$subject = $matches[0];
	$old_table_name = $matches[2];

	//$new_table_name = str_replace($old_table_prefix, $table_prefix, $old_table_name);
	
	$new_table_name = preg_replace("/$old_table_prefix/", $table_prefix, $old_table_name, 1);
	
	return str_replace($old_table_name, $new_table_name, $subject);
}

function status($status, $success=true, $return=true, $options='', $multicall=false){
	
	if($success && !empty($options)){  
		echo '#Status('.base64_encode(serialize(array('success' => $status, 'options' => $options))).')#'; echo "\n".serialize(array('success' => $status, 'options' => $options));
		if ($GLOBALS["LOG_FILE_HANDLE"]) {
			@fwrite($GLOBALS["LOG_FILE_HANDLE"], 'success : '.$status."\n");
		} 
	} else if($success){ 
		echo '#Status('.base64_encode(serialize(array('success' => $status))).')#';  echo "\n".serialize(array('success' => $status)); 
		if ($GLOBALS["LOG_FILE_HANDLE"])
		@fwrite($GLOBALS["LOG_FILE_HANDLE"], 'success : '.$status."\n");
	} else if(!$success && $return){  
		echo '#Status('.base64_encode(serialize(array('error' => $status))).')#';  echo "\n".serialize(array('error' => $status));
		if ($GLOBALS["LOG_FILE_HANDLE"]) 
		@fwrite($GLOBALS["LOG_FILE_HANDLE"], 'error : '.$status."\n"); 
		//deleteCloneDirWhileError(); write now it is no need because we cant get log
	} else if($return){ 
		echo '#Status('.base64_encode(serialize(array('error' => $status))).')#';  echo "\n".serialize(array('error' => $status)); 
		if ($GLOBALS["LOG_FILE_HANDLE"])
		@fwrite($GLOBALS["LOG_FILE_HANDLE"], 'error : '.$status."\n"); 
	}

	//if($multicall)){  echo '#Status('.base64_encode(serialize(array('success' => $status, 'options' => $options))).')#'; echo "\n".serialize(array('success' => $status, 'options' => $options)); }
	
	ob_flush(); flush();
	
        $GLOBALS['IWP_MMB_PROFILING']['LAST_PRINT'] = $current_time;
}

function bridge_shutdown(){
	$isError = false;
	$isWarning = false;

	if ($error = error_get_last()){
		switch($error['type']){
			/*case E_PARSE:*/
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_PARSE:
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
				$isError = true;
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_USER_WARNING:
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_STRICT:
				$isWarning = true;
			}
	}

	if ($isError){
		$status = 'PHP Fatal error occured: '.$error['message'].' in '.$error['file'].' on line '.$error['line'].'.';
		status($status, $success=false, $return=true);
	}elseif($isWarning){
		$status = 'PHP Fatal error occured: '.$error['message'].' in '.$error['file'].' on line '.$error['line'].'.';
		status($status, $success=false, $return=false);
	}

	storeCloningResponse();
}

function storeCloningResponse(){
	global $response_arr, $download_result;
	if (!empty($response_arr)) {
		DB::doQuery("UNLOCK TABLES");
		$exit = DB::getExists("iwp_clone_stats", "optionValue", "optionName = 'cloneStatus'");
		if ($exit) {
			!DB::update("iwp_clone_stats", array('optionName' => 'cloneStatus', 'optionValue' => serialize($response_arr)), "optionName = 'cloneStatus'");
		}else{
			DB::insert("iwp_clone_stats", array('optionName' => 'cloneStatus', 'optionValue' => serialize($response_arr))) or die(status('Error storing clone status' . DB::error(), $success=false, $return=false));
		}
	}else{
		$exit = DB::getExists("iwp_clone_stats", "optionValue", "optionName = 'cloneStatus'");
		if ($exit) {
			!DB::update("iwp_clone_stats", array('optionName' => 'cloneStatus', 'optionValue' => serialize($download_result)), "optionName = 'cloneStatus'");
		}else{
			DB::insert("iwp_clone_stats", array('optionName' => 'cloneStatus', 'optionValue' => serialize($download_result))) or die(status('Error storing clone status' . DB::error(), $success=false, $return=false));
		}
	} 
}

function appUpdateMsg($msg, $isError=0){
	if($isError){
		die(status($msg, $success=false, $return=true, $options=''));
	}
	else{
		status($msg, $success=true, $return=false, $options='');
	}
}

function iwp_mmb_auto_print($unique_task, $task_desc=''){// this will help responding web server, will keep alive the script execution
    $print_every_x_secs = 5;

    $current_time = microtime(1);
    if(!$GLOBALS['IWP_MMB_PROFILING']['TASKS'][$unique_task]['START']){
            $GLOBALS['IWP_MMB_PROFILING']['TASKS'][$unique_task]['START'] = $current_time;	
    }

    if(!$GLOBALS['IWP_MMB_PROFILING']['LAST_PRINT'] || ($current_time - $GLOBALS['IWP_MMB_PROFILING']['LAST_PRINT']) > $print_every_x_secs){

            //$print_string = "TT:".($current_time - $GLOBALS['IWP_MMB_PROFILING']['ACTION_START'])."\n";
            if(!empty($task_desc)){
                $print_string = $unique_task."  Task Desc :".$task_desc." TT:".($current_time - $GLOBALS['IWP_MMB_PROFILING']['TASKS'][$unique_task]['START']);
            }else {
                $print_string = $unique_task." TT:".($current_time - $GLOBALS['IWP_MMB_PROFILING']['TASKS'][$unique_task]['START']);
            }
            iwp_mmb_print_flush($print_string);            		
            $GLOBALS['IWP_MMB_PROFILING']['LAST_PRINT'] = $current_time;
    }
}

function iwp_mmb_print_flush($print_string){// this will help responding web server, will keep alive the script execution
    echo $print_string." ||| ";
    echo "TT:".(microtime(1) - $GLOBALS['IWP_MMB_PROFILING']['ACTION_START'])."\n";
    ob_flush();
    flush();
}

function logExtractResponse($historyID = '', $statusArray = array(), $params=array()){
	return true;
	$insertID = '';
	if(empty($historyID))
	{
		$insert  = DB::insert($_REQUEST['db_table_prefix'].'iwp_extract_status', array( 'stage' => 'installClone', 'status' => $statusArray['status'],  'action' => 'installClone', 'type' => 'bridge','category' => 'installClone','historyID' => $statusArray['extractParentHID'],'finalStatus' => 'pending','startTime' => microtime(true),'endTime' => '','statusMsg' => 'blah','requestParams' => serialize($params),'taskName' => 'installCloneBridge'));
		if($insert)
		{
			$insertID = $insert; 
		}
	} else if((isset($statusArray['responseParams']))||(isset($statusArray['task_result']))) {
		$update = DB::update($_REQUEST['db_table_prefix'].'iwp_extract_status', array( 'responseParams' => serialize($statusArray['responseParams']),'stage' => 'installClone', 'status' => $statusArray['status'],'statusMsg' => 'blah','taskResults' =>  isset($statusArray['task_result']) ? serialize($statusArray['task_result']) : serialize(array())), "historyID=".$historyID);
	} else {
		//$responseParams = $this -> getRequiredData($historyID,"responseParams");
		$update = DB::update($_REQUEST['db_table_prefix'].'iwp_extract_status', array('stage' => 'installClone', 'status' => $statusArray['status'],'statusMsg' => 'blah' ),"historyID=". $historyID);
	}
	if( (isset($update)&&($update === false)) || (isset($insert)&&($insert === false)) )
	{
		 die(status("Error: Insert or Update", $success=false, $return=true));
	}
	if((isset($statusArray['sendResponse']) && $statusArray['sendResponse'] == true) || $statusArray['status'] == 'completed')
	{
		$returnParams = array();
		$returnParams['parentHID'] = $historyID;
		$returnParams['backupRowID'] = $insertID;
		$returnParams['stage'] = $statusArray['stage'] ;
		$returnParams['status'] = $statusArray['status'];
		$returnParams['nextFunc'] = isset($statusArray['nextFunc']) ? $statusArray['nextFunc'] : '';
		return array('success' => $returnParams);
	} else {
		if($statusArray['status'] == 'error') {
			$returnParams = array();
			$returnParams['parentHID'] = $historyID;
			$returnParams['backupRowID'] = $insertID;
			$returnParams['stage'] = $statusArray['stage'] ;
			$returnParams['status'] = $statusArray['status'];
			$returnParams['statusMsg'] = $statusArray['statusMsg'];
			
			die(status("Error: Insert or Update status", $success=false, $return=true));
		}
	}
}

function send_multicall_response($multicall_response){
	die(status("multicall", $success=true, $return=false, $multicall_response));
}

function check_for_clone_break(){
	global $extract_start_time;
	$extract_time_taken = microtime(1) - $extract_start_time;
	
	if($extract_time_taken >= 20){
		return true;
	}
}

function clone_error_status_log($error){
	$data = DB::getField("iwp_clone_stats", "optionValue", "optionName = 'cloneErrorStatus'");
	if (!empty($data)) {
		!DB::update("iwp_clone_stats", array('optionName' => 'cloneErrorStatus', 'optionValue' => $data.'<br>'.$error), "optionName = 'cloneErrorStatus'") ;
	}else{
		DB::insert("iwp_clone_stats", array('optionName' => 'cloneErrorStatus', 'optionValue' => $error));
	}
}