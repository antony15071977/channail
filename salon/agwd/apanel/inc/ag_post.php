<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
error_reporting(0);
$ag_index = 1;
$ag_post_php = 1;
include ('../../inc/host.php');
include ('../../inc/db_conf.php');

$ag_data_dir = '../../'.$ag_data_dir; //apanel
$ag_data_upload_dir = $ag_data_dir.'/upload'; //apanel

include ($ag_data_dir. '/'. $ag_config); 
include ('../../'.$ag_cfg_lng);// LNG
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
include ('../../inc/mobile_detect/mobile_detect.php'); 
include ('../../inc/functions.php');
include ('../../inc/auth.php'); //LogOn
include ('../../inc/actions.php');
include ('../../inc/form_elements.php');

include ('list_items.php');
?> 