<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Content-Type: application/json;charset=utf-8");
if (session_id() == '') session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$ag_index = 1;

include ('host.php');
include ('db_conf.php');
$ag_data_dir = '../'.$ag_data_dir;
if (file_exists($ag_data_dir.'/'. $ag_config)) {
include ($ag_data_dir.'/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
//include ('../'.$ag_cfg_lng);// LNG
include ('functions.php'); 
} else {
include ('functions.php'); 
die;	
}
$ag_no_create_order_dir = 1;
include ('db_booking.php');
$ag_orders_dir = '../'.$ag_orders_dir;

if(!isset($ag_get_schedule)) {$ag_get_schedule = 'schedule';}
$ag_service = '';
foreach ($_GET as $g_key => $g_val) {
$_GET[$g_key] = htmlspecialchars($_GET[$g_key], ENT_QUOTES, 'UTF-8');	
}
if (isset($_GET['id'])) {$ag_service = $_GET['id'];} //else {die();}

$ag_auth_user = ag_auth();


$ag_year = date("Y");
$ag_month = date("m");
$ag_day = date("d");
$ag_get_day = '';

if (isset($_GET['year']) && !empty($_GET['year']) && isset($_GET['month']) && !empty($_GET['month'])) {
$ag_year = $_GET['year'];
$ag_month = $_GET['month'];	
}
if (isset($_GET['day']) && !empty($_GET['day'])) {
$ag_day = $_GET['day'];	$ag_get_day = $_GET['day']; 
}
if ($ag_month > 12 || (int)$ag_month <= 0) {$ag_month = '01';}
if ($ag_day > 31 || (int)$ag_day <= 0) {$ag_day = '01';}
if (strlen($ag_year) > 4 || (int)$ag_year <= 0) {$ag_year = date("Y");}

$ag_orders_file = $ag_orders_dir.'/'.$ag_month.'_'.$ag_year.$agt;

$ag_orders = array();
if (file_exists($ag_orders_file)) {$ag_orders = ag_read_data($ag_orders_file);}

$ag_orders_staff = array();
$ag_orders_staff_names = array();
if (file_exists($ag_data_dir.'/staff'.$agt)) {$ag_orders_staff = ag_read_data($ag_data_dir.'/staff'.$agt);}
foreach ($ag_orders_staff as $s => $staff) {
if (isset($staff['id']) && isset($staff['name'])) {$ag_orders_staff_names[$staff['id']] = $staff['name'];}
}
function ag_staff_name($arr, $id) {
$name = '';
foreach ($arr as $sid => $sname) {
if ($id == $sid) {$name = $sname; break;}
}
return $name;	
}


$ag_orders_cat = array();
$ag_orders_cat_names = array();
if (file_exists($ag_data_dir.'/category'.$agt)) {$ag_orders_cat = ag_read_data($ag_data_dir.'/category'.$agt);}
foreach ($ag_orders_cat as $s => $cat) {
if (isset($cat['id']) && isset($cat['title'])) {$ag_orders_cat_names[$cat['id']] = $cat['title'];}
}
function ag_cat_name($arr, $id) {
$name = '';
foreach ($arr as $cid => $cname) {
if ($id == $cid) {$name = $cname; break;}
}
return $name;	
}




$ag_order_this_date = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$ag_order_this_time = date("H:i", strtotime(date("H:i")));

$ag_count_orders = 0;
$ag_schedule = '';
foreach ($ag_orders as $n => $orders) {

$order_id = '';
$order_num = '';
$order_serv = '';
$order_title = '';
$order_cat = '';
$order_date = '';
$order_time = '';
$order_spots = '';
$order_price = '';
$order_curr = '';
$order_name = '';
$order_fam = '';
$order_mail = '';
$order_phone = '';
$order_comment = '';
$order_staff = '';
$order_added = '';
$order_changed = '';
$order_status = '';


if (isset($orders['id'])) {$order_id = $orders['id'];}
if (isset($orders['number_order'])) {$order_num = $orders['number_order'];}
if (isset($orders['service'])) {$order_serv = $orders['service'];}
if (isset($orders['title'])) {$order_title = $orders['title'];}
if (isset($orders['category'])) {$order_cat = $orders['category'];}
if (isset($orders['date'])) {$order_date = $orders['date'];}
if (isset($orders['time'])) {$order_time = $orders['time'];}
if (isset($orders['spots'])) {$order_spots = $orders['spots'];}
if (isset($orders['price'])) {$order_price = $orders['price'];}
if (isset($orders['currency'])) {$order_curr = $orders['currency'];}
if (isset($orders['first_name'])) {$order_name = $orders['first_name'];}
if (isset($orders['family_name'])) {$order_fam = $orders['family_name'];}
if (isset($orders['email'])) {$order_mail = $orders['email'];}
if (isset($orders['phone'])) {$order_phone = $orders['phone'];}
if (isset($orders['comment'])) {$order_comment = $orders['comment'];}
if (isset($orders['staffs'])) {$order_staff = $orders['staffs'];}
if (isset($orders['added'])) {$order_added = $orders['added'];}
if (isset($orders['changed'])) {$order_changed = $orders['changed'];}
if (isset($orders['status'])) {$order_status = $orders['status'];}
	
$order_added_a = explode('::',$order_added);
$add_d = '';
$add_m = '';
$add_y = '';
$add_t = '';
$add_u = '';
$add_ip = '';
if(isset($order_added_a[0])) {$add_d = $order_added_a[0];}
if(isset($order_added_a[1])) {$add_m = $order_added_a[1];}
if(isset($order_added_a[2])) {$add_y = $order_added_a[2];}
if(isset($order_added_a[3])) {$add_t = $order_added_a[3];}
if(isset($order_added_a[4])) {$add_u = $order_added_a[4];}
if(isset($order_added_a[5])) {$add_ip = $order_added_a[5];}	

$order_date_format = date("Y-m-d", strtotime($order_date));

$order_staff_a = explode($ag_separator[2], $order_staff);
$order_time_a = explode($ag_separator[2], $order_time);
$order_spots_a = explode($ag_separator[2], $order_spots);


$change_d = '00';
$change_m = '00';
$change_y = '0000';
$change_t = '';
$change_u = '';
$change_ip = '';
if (!empty($order_changed)) {
$order_changed_a = explode('::',$order_changed);
if(isset($order_changed_a[0])) {$change_d = $order_changed_a[0];}
if(isset($order_changed_a[1])) {$change_m = $order_changed_a[1];}
if(isset($order_changed_a[2])) {$change_y = $order_changed_a[2];}
if(isset($order_changed_a[3])) {$change_t = $order_changed_a[3];}
if(isset($order_changed_a[4])) {$change_u = $order_changed_a[4];}
if(isset($order_changed_a[5])) {$change_ip = $order_changed_a[5];}
}


$ag_set_staff = '';
$ag_set_staff_id = '';
foreach ($order_staff_a as $id_staff) {
$ag_set_staff_id .= $id_staff.',';
$ag_set_staff .= ag_staff_name($ag_orders_staff_names, $id_staff).',';	
}
if (!empty($ag_set_staff)) {
if ($ag_set_staff{strlen($ag_set_staff) - 1} == ',') {$ag_set_staff = substr($ag_set_staff, 0, -1);}
}
if (!empty($ag_set_staff_id)) {
if ($ag_set_staff_id{strlen($ag_set_staff_id) - 1} == ',') {$ag_set_staff_id = substr($ag_set_staff_id, 0, -1);}
}

$order_cat_name = ag_cat_name($ag_orders_cat_names, $order_cat);	

$ag_spots = array_sum($order_spots_a);



if ($order_status != 0) {

if (!empty($ag_service) && $ag_service == $order_serv || empty($ag_service)) {
if (!empty($ag_get_day) && $order_date == $ag_year.'-'.$ag_month.'-'.$ag_get_day || empty($ag_get_day)) {

foreach ($order_time_a as $nt => $times) {
$otime_start = '';
$otime_end = '';	
$timesa = explode('-', $times);
	if (isset($timesa[0])) {$otime_start = $timesa[0];}
	if (isset($timesa[1])) {$otime_end = $timesa[1];}
if (isset($order_spots_a[$nt])) {$ag_spots = $order_spots_a[$nt];}
	

	
//$ag_schedule $order_id
$abr = "\n";
//$abr = '';


	
$ag_schedule .= '{'.$abr;

if (!empty($ag_auth_user)) {

$ag_schedule .= '"id":'.'"'.$order_id.'",'.$abr;
$ag_schedule .= '"number":'.'"'.$order_num.'",'.$abr;
$ag_schedule .= '"service":'.'"'.$order_serv.'",'.$abr;
$ag_schedule .= '"serviceTitle":'.'"'.$order_title.'",'.$abr;
$ag_schedule .= '"catID":'.'"'.$order_cat.'",'.$abr;
$ag_schedule .= '"cat":'.'"'.$order_cat_name.'",'.$abr;
$ag_schedule .= '"date":'.'"'.$order_date.'",'.$abr;
$ag_schedule .= '"time":'.'"'.$otime_start.'",'.$abr;	
$ag_schedule .= '"timeEnd":'.'"'.$otime_end.'",'.$abr;	
$ag_schedule .= '"price":'.''.$order_price.','.$abr;
$ag_schedule .= '"currency":'.'"'.$order_curr.'",'.$abr;
$ag_schedule .= '"spots":'.'"'.$ag_spots.'",'.$abr;

$ag_schedule .= '"staffID":'.'"'.$ag_set_staff_id.'",'.$abr;
$ag_schedule .= '"staffNames":'.'"'.$ag_set_staff.'",'.$abr;

$ag_schedule .= '"name":'.'"'.$order_name.'",'.$abr;
$ag_schedule .= '"family":'.'"'.$order_fam.'",'.$abr;
$ag_schedule .= '"email":'.'"'.$order_mail.'",'.$abr;
$ag_schedule .= '"phone":'.'"'.$order_phone.'",'.$abr;
$ag_schedule .= '"comment":'.'"'.$order_comment.'",'.$abr;

$ag_schedule .= '"addDate":'.'"'.$add_y.'-'.$add_m.'-'.$add_d.'",'.$abr;
$ag_schedule .= '"addTime":'.'"'.$add_t.'",'.$abr;
$ag_schedule .= '"addUserID":'.'"'.$add_u.'",'.$abr;
$ag_schedule .= '"addUser":'.'"'.ag_staff_name($ag_orders_staff_names, $add_u).'",'.$abr;
$ag_schedule .= '"addIP":'.'"'.$add_ip.'",'.$abr;

$ag_schedule .= '"changeDate":'.'"'.$change_y.'-'.$change_m.'-'.$change_d.'",'.$abr;
$ag_schedule .= '"changeTime":'.'"'.$change_t.'",'.$abr;
$ag_schedule .= '"changeUserID":'.'"'.$change_u.'",'.$abr;
$ag_schedule .= '"changeUser":'.'"'.ag_staff_name($ag_orders_staff_names, $change_u).'",'.$abr;
$ag_schedule .= '"changeIP":'.'"'.$change_ip.'",'.$abr;

$ag_schedule .= '"status":'.'"'.$order_status.'"';

} else {
$ag_schedule .= '"serviceTitle":'.'"'.$order_title.'",'.$abr;
$ag_schedule .= '"date":'.'"'.$order_date.'",'.$abr;
$ag_schedule .= '"time":'.'"'.$otime_start.'",'.$abr;	
$ag_schedule .= '"timeEnd":'.'"'.$otime_end.'",'.$abr;	
$ag_schedule .= '"spots":'.'"'.$ag_spots.'",'.$abr;	
$ag_schedule .= '"status":'.'"'.$order_status.'"';
}

$ag_schedule .= $abr.'},';


}// foreach order_time_a

}// select day
}// select service
}// status
	
}// foreach ag_orders

if (!empty($ag_schedule)) {
//if ($ag_schedule{strlen($ag_schedule) - 1} == ',') {
	$ag_schedule = substr($ag_schedule, 0, -1);
//	}
}
$ag_schedule = '['.$ag_schedule.']';


echo $ag_schedule;

?>