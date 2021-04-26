<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header('Content-type: text/html; charset=utf-8');
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Pragma: no-cache"); // HTTP/1.0
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
$ag_index = 1;
include ('inc/host.php');
include ('inc/db_conf.php');

if (file_exists($ag_data_dir.'/'. $ag_config)) {
include ($ag_data_dir.'/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
include ($ag_cfg_lng);// LNG
include ('inc/functions.php'); 
} else {
include ('inc/functions.php'); 
die;	
}

include ($ag_cfg_theme.'params.php'); 

if (empty($ag_cfg_theme)) { $ag_cfg_theme = 'themes/Default/'; }

ob_start();// top
include($ag_cfg_theme.'header.php'); 
$ag_top_html = ob_get_contents(); 
ob_end_clean();
echo ag_return_html($ag_top_html);

// content
include($ag_cfg_theme.'content.php');
 
ob_start();// bottom
include($ag_cfg_theme.'footer.php'); 
$ag_bottom_html = ob_get_contents(); 
ob_end_clean();
echo ag_return_html($ag_bottom_html);

?>