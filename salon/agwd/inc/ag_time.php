<?php // Product: Ag Booking CMS | Autor: Shaklein Maksim (Шаклеин Максим) | Create: October 2017 | Argentum Web Design (c) www.agwd.ru 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Content-Type: application/json;charset=utf-8");

$ag_index = 1;
include ('../inc/host.php');
include ('../inc/db_conf.php');

$ag_data_dir = '../'.$ag_data_dir;

if (file_exists($ag_data_dir.'/'. $ag_config)) {
include ($ag_data_dir.'/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
}

$ag_return_time .= '{';
$ag_return_time .= '"year":"'.date('Y').'",';
$ag_return_time .= '"month":"' .date('m'). '",';
$ag_return_time .= '"day":"' .date('d'). '",';
$ag_return_time .= '"hour":"' .date('H'). '",';
$ag_return_time .= '"minute":"' .date('i'). '",';
$ag_return_time .= '"second":"' .date('s'). '"';
$ag_return_time .= '}';
echo $ag_return_time;
?>