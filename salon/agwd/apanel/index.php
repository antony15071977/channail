<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header('Content-type: text/html; charset=utf-8');
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Pragma: no-cache"); // HTTP/1.0
header('Access-Control-Allow-Origin: *'); 
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);
$ag_index = 1;
$ag_top_html = '';
$ag_content_html = '';
$ag_bottom_html = '';
include ('../inc/host.php');
if (!file_exists('../inc/db_conf.php')) {
	$srv_absolute_url = str_replace('/apanel', '', $srv_absolute_url);
	header("Location: ".$srv_absolute_url); die;
	}
include ('../inc/db_conf.php');
include ('../inc/mobile_detect/mobile_detect.php'); 
include ('../inc/functions.php');
include ('../inc/create.php');
include ($ag_data_dir. '/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
include ('../'.$ag_cfg_lng);// LNG


include ('../inc/auth.php'); //LogOn
include ('../inc/actions.php');
include('../inc/ag_widgets.php');
include ('../inc/form_elements.php');


ob_start(); //top
include ('inc/top.php'); 
$ag_top_html = ob_get_contents(); 
ob_end_clean();
echo ag_return_html($ag_top_html);

if (isset($_GET['settings'])) {
	
include ('inc/settings.php'); 

/*
ob_start();// ag_settings_html
include ('inc/settings.php');
$ag_settings_html = ob_get_contents(); 
ob_end_clean();
echo ag_return_html($ag_settings_html);
*/
	
} else if (isset($_GET['orders']) && file_exists('inc/orders.php')) {
include ('inc/orders.php'); 
} else {
include ('inc/content.php'); 
include ('../inc/edit.php');
}

ob_start(); // bottom
include ('inc/bottom.php'); 
$ag_bottom_html = ob_get_contents(); 
ob_end_clean();
echo ag_return_html($ag_bottom_html);
?> 