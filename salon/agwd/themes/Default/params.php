<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}
if (session_id() == '') session_start();
//data
$ag_db_cat = $ag_data_dir.'/category.dat';
$ag_cat = ag_read_data($ag_db_cat); 

//staff
$ag_db_staff = $ag_data_dir.'/staff.dat';
$ag_staff = ag_read_data($ag_db_staff);

//GET
if(empty($ag_get_cat)) {$ag_get_cat = 'c';}
if(empty($ag_get_obj)) {$ag_get_obj = 'o';}
if(empty($ag_get_page)) {$ag_get_page = 'p';}
if(empty($ag_get_search)) {$ag_get_search = 's';}
if(empty($ag_get_rss)) {$ag_get_rss = 'rss';}
if(empty($ag_get_sitemap)) {$ag_get_sitemap = 'sitemap';}

if(empty($ag_get_schedule)) {$ag_get_schedule = 'schedule';}
if(empty($ag_get_confirm)) {$ag_get_confirm = 'confirm';}
if(empty($ag_get_pay)) {$ag_get_pay = 'pay';}
?>