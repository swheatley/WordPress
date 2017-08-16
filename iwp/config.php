<?php
#Show Error
define('APP_SHOW_ERROR', true);

@ini_set('display_errors', (APP_SHOW_ERROR) ? 'On' : 'Off');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
if(defined('E_DEPRECATED')) {
error_reporting(error_reporting() & ~E_DEPRECATED);
}
define('SHOW_SQL_ERROR', APP_SHOW_ERROR);

define('APP_VERSION', '2.12.0');
define('APP_INSTALL_HASH', '35b4983c39822aa1c6f335e619efff3ba4e5e96c');

define('APP_ROOT', dirname(__FILE__));
define('APP_DOMAIN_PATH', 'localhost:8888/humescores/iwp/');

define('EXECUTE_FILE', 'execute.php');
define('DEFAULT_MAX_CLIENT_REQUEST_TIMEOUT', 180);//Request to client wp

$config = array();
$config['SQL_DATABASE'] = 'humescores-child-theme';
$config['SQL_HOST'] = 'localhost';
$config['SQL_USERNAME'] = 'root';
$config['SQL_PASSWORD'] = 'root';
$config['SQL_PORT'] = '3306';
$config['SQL_TABLE_NAME_PREFIX'] = 'iwp_';
