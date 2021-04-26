<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {
	
//header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

header('Access-Control-Allow-Origin: *');

include ('../../inc/db_booking.php'); $ag_orders_dir = '../../'.$ag_orders_dir;	
$ag_ap_orders = 1;
include ('../../inc/booking.php');

} else { 

include ('../inc/db_booking.php'); $ag_orders_dir = '../'.$ag_orders_dir; 
$ag_ap_orders = 1;
include ('../inc/booking.php');
}




function ag_statistic_service($id) {
global	$ag_data_dir;
global	$agt;
global	$ag_separator;
global	$ag_lng;


$service = array();
$service['name'] = '';

$service_data = array();
$service_data_file = $ag_data_dir.'/service'.$agt;
if (file_exists($service_data_file)) {
$service_data = ag_read_data($service_data_file);
}

foreach ($service_data as $srv) {
if (isset($srv['id']) && $srv['id'] == $id) {
if (isset($srv['title'])) { $service['name'] = $srv['title']; }
break;}	
}

return $service;
}// ag_statistic_service func


function ag_unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 


//first service
$ag_serv_res_id = '';
if (file_exists($ag_data_dir.'/service'.$agt))
$obj_inc_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_inc_data as $ns => $inc) {
if ($ns == 0) {
if (isset($inc['id'])) { $ag_serv_res_id = $inc['id'];}
}	
}


$ag_orders = array();
$ag_orders_sort = array();
$ag_orders_data = array();

$ag_get_period = date('m_Y');
if (isset($_GET['m_y'])) {$ag_get_period = htmlspecialchars($_GET['m_y'], ENT_QUOTES, 'UTF-8');}

//$ag_orders_file = $ag_orders_dir.'/'.$ag_get_period.$agt; // order file default
$ag_orders_file = '';

$ag_all_orders = array();
if (file_exists($ag_orders_dir)) {
$ag_all_orders = ag_file_list($ag_orders_dir, $agt); // files orders periods
}



$ag_ostaff_data = array();
if (file_exists($ag_data_dir.'/'.$ag_users_db.$agt) && filesize($ag_data_dir.'/'.$ag_users_db.$agt) != 0) { $ag_ostaff_data = ag_read_data($ag_data_dir.'/'.$ag_users_db.$agt);}
$ag_oserv_data = array();
if (file_exists($ag_data_dir.'/service'.$agt) && filesize($ag_data_dir.'/service'.$agt) != 0) { $ag_oserv_data = ag_read_data($ag_data_dir.'/service'.$agt);}



$ag_order_this_date = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$ag_order_this_time = date("H:i", strtotime(date("H:i")));



$order_refresh = '';

if (isset($_GET['order_count'])) {$_SESSION['order_count'] = (int)$_GET['order_count'];}



//------------------------------pages
function ag_page_nav($list) {
$pages = array();
$count_items = 10;
if (isset($_SESSION['order_count'])) {
	$count_items = $_SESSION['order_count'];
	}
if ($count_items < 10) {$count_items = 10;}
$view_items = 10;
$pn = 1;
if (isset($_GET['p'])) {$pn = (int)$_GET['p'];}
if ($pn <= 0) {$pn = 1;}
$pages['num'] = $pn;

$view_items = $pn * $count_items;
$total_page = ceil(sizeof($list) / $count_items);

$pages['view'] = $view_items;
$pages['count'] = $count_items;
//page nav
$ag_page_nav = '';

if ($total_page > 1) {
for ($p = 0; $p < $total_page; $p++) {
$pp = $p + 1;
$lp = $pp * $count_items;
$fp = $lp - $count_items + 1;
if ($pp == $pn) { 
$ag_page_nav .= '<li><span>' .$pp.'</span></li>';

} else {

$aurl = '?orders&amp;p='.$pp;	

if (isset($_GET['m_y'])) {$aurl = '?orders&amp;m_y='.$_GET['m_y'].'&amp;p='.$pp;}
if (isset($_GET['order_search'])) {$aurl = '?orders&amp;order_search='.$_GET['order_search'].'&amp;p='.$pp;}
if (isset($_GET['today'])) {$aurl = '?orders&amp;today&amp;p='.$pp;}
if (isset($_GET['actual'])) {$aurl = '?orders&amp;actual&amp;p='.$pp;}
if (isset($_GET['sort'])) {$aurl = '?orders&amp;sort&amp;p='.$pp;}

$ag_page_nav .= '<li><a href="'.$aurl.'">' .$pp.'</a></li>'; 


}// this page
}// for total pages
}// >1

$pages['total'] = $total_page;
if (!empty($ag_page_nav)) {
$ag_page_nav = '<div class="ag_pages_nav"><div><ul>'.$ag_page_nav.'<li class="ag_clear"></li></ul><div class="ag_clear"></div></div></div>';
}
$pages['html'] = $ag_page_nav;
$pages['items'] = sizeof($list);
return $pages;	
}
//------------------------------pages



//select period
$ag_get_per_m = date('m');
$ag_get_per_y = date('Y');
$ag_get_per_a = array();
if (isset($_GET['m_y'])) {
	$ag_get_per_a = explode('_', htmlspecialchars($_GET['m_y'], ENT_QUOTES, 'UTF-8'));
	}
if (isset($ag_get_per_a[0]) && !empty($ag_get_per_a[0])) {$ag_get_per_m = $ag_get_per_a[0];}
if (isset($ag_get_per_a[1]) && !empty($ag_get_per_a[1])) {$ag_get_per_y = $ag_get_per_a[1];}

$ag_link_nm = (int)$ag_get_per_m + 1; 
$ag_link_ny = $ag_get_per_y;
if ($ag_link_nm == 13) {$ag_link_nm = 1; $ag_link_ny = $ag_get_per_y + 1;}
if ($ag_link_nm < 10) {$ag_link_nm = '0'.$ag_link_nm;}

$ag_link_pm = (int)$ag_get_per_m - 1;
$ag_link_py = $ag_get_per_y;
if ($ag_link_pm == 0) {$ag_link_pm = 12; $ag_link_py = $ag_get_per_y - 1;}
if ($ag_link_pm < 10) {$ag_link_pm = '0'.$ag_link_pm;}	


//-------------------------------------------------------------------------------ORDERS
$ag_of_count = 0;
$ag_search_count = 0;

$ag_count_actual = 0;
$ag_count_today = 0;

foreach ($ag_all_orders as $order_file) { 


$ag_orders_search_line = '';	


$ag_order_period = str_replace($ag_orders_dir, '', $order_file['name']);
$ag_order_period = str_replace($agt, '', $ag_order_period);
$ag_order_period = str_replace('/', '', $ag_order_period);





if (isset($_GET['order_search'])) {
$ag_disalow_insearch = array('/', '\\', '*', '(', ')', '?', '|', '+', '$', '&', '=');
$ag_orders_query = htmlspecialchars($_GET['order_search'], ENT_QUOTES, 'UTF-8');
$ag_orders_query = mb_strtolower($ag_orders_query, 'utf8');
$ag_orders_query = str_replace($ag_disalow_insearch, '', $ag_orders_query);		
if (!empty($ag_orders_query) && iconv_strlen($ag_orders_query, 'UTF-8') > 2) {}	else { 
$ag_ERROR['order'] = $ag_lng['empty_query'];
unset($ag_orders_query); 
}

if (isset($order_file['name']) && file_exists($order_file['name']) && filesize($order_file['name']) != 0) { $ag_orders_file = $order_file['name']; $ag_of_count++; }

} else {

if ($ag_order_period == $ag_get_period) { // get period
if (isset($order_file['name'])) { $ag_orders_file = $order_file['name']; }
}


$ag_order_period = $ag_get_period;


} // get search


if (file_exists($ag_orders_file) && filesize($ag_orders_file) != 0) {
$ag_orders_data = ag_read_data($ag_orders_file);
$ag_orders_data = array_reverse($ag_orders_data, true);
} else {
//$ag_ERROR['order'] = ''; // not orders in choise month
}



	
	
	
$td_order_data = '';
$ag_table_orders = '';	
$ag_orders_search_line = '';










$ag_count_actual = 0;
$ag_count_today = 0;

foreach ($ag_orders_data as $no => $orders) { 
$order_date = '';
if (isset($orders['date'])) {$order_date = $orders['date'];}
if ($ag_order_this_date <= date("Y-m-d", strtotime($order_date))) { $ag_count_actual++; }
if ($ag_order_this_date == date("Y-m-d", strtotime($order_date))) { $ag_count_today++;}
}

$list_num = sizeof($ag_orders_data) + 1;
//if (isset($_GET['actual'])) {$list_num = $ag_count_actual;}
//if (isset($_GET['today'])) {$list_num = $ag_count_today;}

$ag_onum = 0;
$ag_count_orders = 0;

foreach ($ag_orders_data as $no => $orders) { 

$ag_count_orders++;
$list_num--;

//if (isset($_GET['order_search'])) {$ag_search_count++; $list_num = $ag_search_count;}


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

$order_add_data = '';

$td_order_data = '';
$ag_table_orders = '';
$ag_orders_search_line = '';	



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



$odis_class = '';	
$order_timeline = '';
//if ($ag_order_period == date('m_Y')) { 
if ($ag_order_this_date > date("Y-m-d", strtotime($order_date))) {$odis_class = ' ag_noactual_order'; } 
if ($ag_order_this_date == date("Y-m-d", strtotime($order_date))) {$odis_class = ' ag_today_order'; }
//} 

//refresh
if ($ag_order_period == date('m_Y') && !isset($_GET['order_search'])) {

//$order_refresh = 'setInterval(function() {window.location = "'.$_SERVER['REQUEST_URI'].'";}, 180000);';
$order_refresh = '
idleTimer = null;
idleState = false; 
idleWait = 300000;
 
$(document).ready( function(){
  $(document).bind("mousemove keydown scroll", function(){
    clearTimeout(idleTimer); 
   
 
    idleState = false;
    idleTimer = setTimeout(function(){ 
     
      window.location = "'.$_SERVER['REQUEST_URI'].'";
      idleState = true; 
    }, idleWait);
  });
 
  $("body").trigger("mousemove"); 
});
';

}


$ag_ocd = (strtotime($order_date) - strtotime($ag_order_this_date)) / 86400;
$order_timeline = $ag_ocd;
if ($ag_ocd < 0) {$order_timeline = $ag_lng['os_expired'];}
if ($ag_ocd == 0) {$order_timeline = $ag_lng['for_today'];}
if ($ag_ocd == 1) {$order_timeline = $ag_lng['for_tomorrow'];}
if ($ag_ocd > 1) {
	$order_timeline = str_replace('%s', $ag_ocd, $ag_lng['after_n_days']);
	
	}


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

$order_add_data = '<li>'.$add_d.'.'.$add_m.'.'.$add_y.'</li>';
$order_add_data .= '<li><small>'.$add_t.'</small></li>';
$order_add_data .= '<li class="ag_order_staffs" onclick="ag_open_ifm(\'000\',\'inc/ip.php?ip='.$add_ip.'\',\'ag_url\')"><span><small>IP: '.$add_ip.'</small></span></li>';

if (isset($orders['payment_important']) && !empty($orders['payment_important']) && $orders['payment_important'] != '0') {
	if ($order_status == '0' || $order_status == '1') {
$time_this_d = date('d');
$time_this_mon = date('m');
$time_this_y = date('Y');
$time_this = date('H:i:s');
$ag_this_date_time = new DateTime("$time_this_y-$time_this_mon-$time_this_d $time_this");

$ag_order_date_time = new DateTime("$add_y-$add_m-$add_d $add_t");
$ag_order_date_time = $ag_order_date_time->add(new DateInterval('PT'.$orders['payment_important'].'M'));

$ag_ipay_time = date('H:i:s', strtotime($add_t.' + '.$orders['payment_important'].' min')); 

$str_info_to_pay = '<li><small>'.$ag_lng['to_pay_to'].':<br /><strong>'.$ag_order_date_time->format('H:i').'</strong> '.$ag_order_date_time->format('d.m.Y').'</small></li>';

if ($ag_this_date_time > $ag_order_date_time) {
$str_info_to_pay = '<li class="ag_str_red"><small>'.$ag_lng['to_pay_to'].':<br /><strong>'.$ag_order_date_time->format('H:i').'</strong> '.$ag_order_date_time->format('d.m.Y').'</small><br />';
$str_info_to_pay .= '<small>'.$ag_lng['expired_pay'].'</small></li>';

	
$str_info_to_pay .= '<script>
$.get(
"../?' .$ag_get_schedule. '='.$order_serv.'",
{   
	reserve: "",	
}
);';
if ($order_status == '1') {
$str_info_to_pay .= '
$(document).ready(function(){ 

if ($("#'.$order_id.'").find(".os_off").length) { } else {
	window.location = "'.$_SERVER['REQUEST_URI'].'";
}
});';
}
$str_info_to_pay .= '</script>';

}

$order_add_data .= $str_info_to_pay;
	}// status 0 or 1
}



$order_change_data = '';
if (!empty($order_changed)) {
$order_changed_a = explode('::',$order_changed);
$change_d = '';
$change_m = '';
$change_y = '';
$change_t = '';
$change_u = '';
$change_ip = '';
if(isset($order_changed_a[0])) {$change_d = $order_changed_a[0];}
if(isset($order_changed_a[1])) {$change_m = $order_changed_a[1];}
if(isset($order_changed_a[2])) {$change_y = $order_changed_a[2];}
if(isset($order_changed_a[3])) {$change_t = $order_changed_a[3];}
if(isset($order_changed_a[4])) {$change_u = $order_changed_a[4];}
if(isset($order_changed_a[5])) {$change_ip = $order_changed_a[5];}

$order_change_data = '<p class="ag_changed_title">'.$ag_lng['changed'].':</p><ul>';
$order_change_data .= '<li><small>'.$change_u.'</small></li>';
$order_change_data .= '<li><small>'.$change_d.'.'.$change_m.'.'.$change_y.' ['.$change_t.']</small></li>';
$order_change_data .= '<li><small>IP: '.$change_ip.'</small></li></ul>';
} 





$order_comment_sear = $order_comment;
$order_comment = str_replace($ag_separator[3], '<br />', $order_comment);
if (!empty($order_comment)) { $order_comment = '<p>'.$order_comment.'</p>';}
$order_comment = ''.$order_comment.''.$order_change_data;
$order_comment_check = strip_tags($order_comment, '');

if (!empty($order_comment_check)) {$order_comment = '<div class="ag_order_comment" tabindex="-1"><i class="icon-comment-alt"></i><div class="ag_view_comment"><div>'.$order_comment.'</div></div></div>';} else {$order_comment = '';}

$order_staff_a = explode($ag_separator[2], $order_staff);
$order_time_a = explode($ag_separator[2], $order_time);
$order_spots_a = explode($ag_separator[2], $order_spots);


$ostaff_name = $ag_lng['user_not_found'];
$order_staffs = '';
$open_ostaff = '';
$apspaff = '';
$class_ostaffs = 'ag_order_staff_notfound';
foreach ($order_staff_a as $ostaff) {
foreach ($ag_ostaff_data as $allstaff) {
if (isset($allstaff['id']) && $allstaff['id'] == $ostaff) {
$open_ostaff = ' onclick="ag_open_ifm(\''.$ostaff.'\',\'\',\'ag_item\')"';	
$class_ostaffs = 'ag_order_staffs';
if ($ostaff == $ag_user_id) {$class_ostaffs = 'ag_order_this_staff';}
if (isset($allstaff['name'])) {$ostaff_name = $allstaff['name']; $apspaff .= $allstaff['name'].$ag_separator[2];}
$order_staffs .= '<li class="'.$class_ostaffs.'"'.$open_ostaff.'><span>'.$ostaff_name.'</span></li>';	
}	
}
	
}


$ag_disable_edit_order = '';
$time_str = '';	
foreach ($order_time_a as $nt => $times) {
	$time_str .= '<li>';
	//$times = str_replace('-', ' - ', $times);
	//ag_otime_expired
	$otime_class = '';
	$otime_start = '';
	$otime_end = '';
	$otime_thish = '';
	$timesa = explode('-', $times);
	if (isset($timesa[0])) {$otime_start = $timesa[0];}
	if (isset($timesa[1])) {$otime_end = $timesa[1];}
	if ($ag_order_period == date('m_Y') && $ag_order_this_date == date("Y-m-d", strtotime($order_date))) { 
	if ($ag_order_this_time > date("H:i", strtotime($otime_end))) {$otime_class = ' ag_otime_expired'; $ag_disable_edit_order = 1;}
	$otime_starta = explode(':', $otime_start); if(isset($otime_starta[0])) {$otime_thish = $otime_starta[0];}
	//if ($otime_thish == date("H")) {$otime_class = ' ag_otime_thish';}
	if ($ag_order_this_time >= date("H:i", strtotime($otime_start)) && $ag_order_this_time < date("H:i", strtotime($otime_end))) {
		$otime_class = ' ag_otime_thish'; 
		$ag_disable_edit_order = 1;}
	}
	

	$time_str .= '<span class="ag_otime'.$otime_class.'">'.$otime_start.'-'.$otime_end.'</span>';
	if (isset($order_spots_a[$nt])) {$time_str .= '<span> x '.$order_spots_a[$nt].'</span>';} 
	$time_str .= '</li>';
	}
$time_str .= '<li class="ag_order_price"><strong>'.$order_price.'</strong> '.$order_curr.'</li>';
	

$order_date_a = explode('-', $order_date);	
$o_day = '';
$o_month = '';	
$o_year = '';
if (isset($order_date_a[0])) {$o_year = $order_date_a[0];}
if (isset($order_date_a[1])) {$o_month = $order_date_a[1];}
if (isset($order_date_a[2])) {$o_day = $order_date_a[2];}
$order_date_disp = $o_day. ' '.$ag_lng_monts_short[$o_month]. ' '.$o_year;
	
$odel_butt = '<span><i class="icon-cancel"></i></span>';

if ($ag_user_access == 2 || $ag_user_access == 3) { 
if (in_array($ag_user_id, $order_staff_a)) { 
$odel_butt = '<span class="ag_order_delete" title="'.$ag_lng['delete_order'].'" onclick="ag_order_delete_confirm(\''.$ag_order_period.'\', \''.$order_id.'\')"><i class="icon-cancel"></i></span>';	 
} else { $odel_butt = '<span class="ag_disabled"><i class="icon-cancel"></i></span>'; }
} else {
//$odis_class = ' ag_noactual_order';
$odel_butt = '<span class="ag_order_delete" title="'.$ag_lng['delete_order'].'" onclick="ag_order_delete_confirm(\''.$ag_order_period.'\', \''.$order_id.'\')"><i class="icon-cancel"></i></span>';
}	

//$order_date




$ag_client = '<li><i class="icon-user-1"></i> '.$order_name.'</li>';

if (!empty($order_fam)) {$ag_client .= '<li><i class="icon-pencil"></i> '.$order_fam.'</li>';}

if (!empty($order_mail) && $order_mail != 'no') {
if (strpos($order_mail, '@') === false) {$ag_client .= '<li><i class="icon-mail-1"></i> '.$order_mail.'</li>';
} else { $ag_client .= '<li><i class="icon-mail-1"></i> <a href="mailto:'.$order_mail.'">'.$order_mail.'</a></li>'; } } else {$ag_client .= '<li><i class="icon-mail-1"></i> <i>'.$ag_lng['no_value'].'</i></li>';}

if (!empty($order_phone) && $order_phone != 'no') {$ag_client .= '<li><i class="icon-mobile"></i> '.$order_phone.'</li>';} else { $ag_client .= '<li><i class="icon-mobile"></i> <i>'.$ag_lng['no_value'].'</i></li>';}
	

	
$oserv_open = '<span class="ag_order_serv_notfound">'.$order_title.'<br />('.$ag_lng['sevice_not_found'].')</span>';
foreach ($ag_oserv_data as $oserv) {
if (isset($oserv['id']) && $oserv['id'] == $order_serv)	{
$order_title_disp = ag_statistic_service($order_serv);
if (empty($order_title_disp['name'])) {$order_title_disp['name'] = $order_title;}
$oserv_open = '<span class="ag_order_serv" onclick="ag_open_ifm(\''.$order_serv.'\',\'\',\'ag_item\')">'.$order_title_disp['name'].'</span>';
}
}	
	
	
$order_status_display = '';
$order_status_select_opt = '';
$disp_st_class = '';
foreach ($ag_order_status as $ost => $name_ost)	{
$list_st_class = ' class="'.$name_ost.'"';

$list_st_act = ' onclick="ag_order_change_status('.$ost.',this)"'; 
if ($ost == $order_status) {$order_status_display = $name_ost; $disp_st_class = ' class="'.$name_ost.'"'; }
$opt_st = $name_ost;
if (isset($ag_lng[$name_ost])) {$opt_st = $ag_lng[$name_ost];}



$order_status_select_opt .= '<li tabindex="-1" data-order="'.$order_id.'" data-period="'.$ag_order_period.'"'.$list_st_act.$list_st_class.'>\'+decodeURI(\''.urlencode($opt_st).'\')+\'</li>';


}

$order_status_select_opt = '<ul id="ag_status_list_'.$order_id.'" class="ag_list_status">'.$order_status_select_opt.'</ul>';

if (isset($ag_lng[$order_status_display])) {$order_status_display = $ag_lng[$order_status_display];}





if ($ag_user_access == 2 || $ag_user_access == 3) { 
if (in_array($ag_user_id, $order_staff_a)) { 
$order_status_select = '<div tabindex="-1" onclick="ag_order_status_select_'.$order_id.'(this)" onblur="ag_status_select_blur(this)"'.$disp_st_class.'><span>'.$order_status_display.'</span></div>';
} else { $order_status_select = '<div class="ag_disabled"><span>'.$order_status_display.'</span></div>'; }
} else {
$order_status_select = '<div tabindex="-1" onclick="ag_order_status_select_'.$order_id.'(this)" onblur="ag_status_select_blur(this)"'.$disp_st_class.'><span>'.$order_status_display.'</span></div>';
}	









$order_status_select .= '<script>
var ag_trig_ws = 0;
function ag_order_status_select_'.$order_id.'(e) { ag_trig_ws++;

$(".ag_order_status_select").find("ul.ag_list_status").remove();

$(e).parents(".ag_order_status_select").append(\''.$order_status_select_opt.'\');
$(e).parents(".ag_order_status_select").find("ul.ag_list_status").fadeIn(250);

if (ag_trig_ws > 1) {
setTimeout(function(){  $(e).parents(".ag_order_status_select").find("ul.ag_list_status").remove(); }, 50);
ag_trig_ws = 0;	
}

}</script>';


$order_status_select_js = '
function ag_order_change_status(status,e) {
	
var ag_cs_oid = $(e).attr("data-order");
var st_order_data = $(e).attr("data-period");
var ag_cs_text = $(e).text();
var ag_cs_class = $(e).attr("class");
var ag_cs_num = $(e).parents("tr").find("span.ag_order_num").text();

$(e).parents(".ag_order_status_select").find("span").text(ag_cs_text);
$(e).parents(".ag_order_status_select").find("div").removeAttr("class");
$(e).parents(".ag_order_status_select").find("div").addClass(ag_cs_class);


$.ajax({
	
type: "POST",
url: "'.$srv_absolute_url.'inc/orders.php",
data: "order_change_status=" + ag_cs_oid + "&order_new_status=" + status + "&order_data=" + st_order_data,
 
success: function(data) {
	
var cl_alert_st = "ag_str_green";
var ic_alert_st = "icon-ok";
var tl_alert_st = data.message;
var ms_alert_st = "'.$ag_lng['order'].' №" + ag_cs_num +" "+ ag_cs_text;
var tm_alert_st = 1400;
var bt_alert_st = "";
var fn_alert_st = "quick_mess";

if (data.ag_success == false) {
cl_alert_st = "ag_str_orange";	
ic_alert_st = "icon-chat";
ms_alert_st = data.message;
tl_alert_st = "'.$ag_lng['abort'].'";
tm_alert_st = ag_cs_oid;
bt_alert_st = "button0";
fn_alert_st = "";
}

ag_dialog(tm_alert_st, ms_alert_st, tl_alert_st, fn_alert_st, ic_alert_st + " " + cl_alert_st, bt_alert_st);	

}
});

ag_trig_ws = 0;	
}


function ag_status_select_blur(e) {
setTimeout(function(){ $(e).parents(".ag_order_status_select").find("ul.ag_list_status").fadeOut(250); }, 50);
setTimeout(function(){ $(e).parents(".ag_order_status_select").find("ul.ag_list_status").remove(); }, 300);
ag_trig_ws = 0;		
}

';


$td_order_data = '<tr class="ag_order_row'.$odis_class.'" id="'.$order_id.'">';
$td_order_data .= '<td class="ag_order_col tr_num"><label class="ag_order_check">
<input type="checkbox" data-id="'.$order_id.'" data-file="'.$ag_order_period.'" onclick="ag_select_orders()" /><span></span></label><span class="ag_order_list_num">'.$list_num.'</span></td>';
$td_order_data .= '<td class="ag_order_col ag_info_col"><span class="ag_order_num">'.$order_num.'</span></td>';
$td_order_data .= '<td class="ag_order_col ag_info_col">'.$oserv_open.'</td>';
$td_order_data .= '<td class="ag_order_col ag_info_col"><span class="ag_order_date">'.$order_date_disp.'</span><span class="ag_order_timeline">'.$order_timeline.'</span><span class="ag_hidden ag_order_sort_date">'.$o_day.'.'.$o_month.'.'.$o_year.'</span></td>';
$td_order_data .= '<td class="ag_order_col ag_times_td ag_info_col"><ul>'.$time_str.'</ul></td>';
$td_order_data .= '<td class="ag_order_col ag_info_col"><ul>'.$ag_client.'</ul></td>';
$td_order_data .= '<td class="ag_order_col ag_info_col"><ul>'.$order_add_data.'</ul></td>';
$td_order_data .= '<td class="ag_order_col ag_info_col"><ul>'.$order_staffs.'</ul></td>';
$td_order_data .= '<td class="ag_order_col ag_order_status ag_info_col"><div class="ag_order_status_select">'.$order_status_select.'</div></td>';
$td_order_data .= '<td class="ag_order_col ag_order_comment_td">'.$order_comment.'</td>';


$ag_get_p = 1;
if (isset($_GET['p'])) {$ag_get_p = (int)$_GET['p'];}

$td_order_data .= '<td class="ag_order_col ag_order_tools">';
if (empty($ag_disable_edit_order)) {
	
	
	

$ag_eb = '<span><i class="icon-edit-alt"></i></span>';
if ($ag_user_access == 2 || $ag_user_access == 3) { 
if (in_array($ag_user_id, $order_staff_a)) { 
$ag_eb = '<a href="#" class="ag_order_edit_link" title="'.$ag_lng['edit'].'" onclick="ag_open_order(\'?orders&m_y='.$ag_order_period.'&edit='.$order_serv.'&order='.$order_id.'&page='.$ag_get_p.'&iframe\')"><i class="icon-edit-alt"></i></a>';
} else { $ag_eb = '<span class="ag_disabled"><i class="icon-edit-alt"></i></span>'; }
} else {
$ag_eb = '<a href="#" class="ag_order_edit_link" title="'.$ag_lng['edit'].'" onclick="ag_open_order(\'?orders&m_y='.$ag_order_period.'&edit='.$order_serv.'&order='.$order_id.'&page='.$ag_get_p.'&iframe\')"><i class="icon-edit-alt"></i></a>';
}	
$td_order_data .= $ag_eb;

} else {
$td_order_data .= '<span class="ag_disabled"><i class="icon-edit-alt"></i></span>';
}
$td_order_data .= '</td>';


$td_order_data .= '<td class="ag_order_col ag_order_tools">'.$odel_butt.'</td>';
$td_order_data .= '</tr>';





$ag_orders_search_line = $order_num.$ag_separator[2];
$ag_orders_search_line .= $order_title.$ag_separator[2];
$ag_orders_search_line .= $o_day. '.'.$o_month. '.'.$o_year.$ag_separator[2];
$ag_orders_search_line .= $order_time.$ag_separator[2];
$ag_orders_search_line .= $order_name.$ag_separator[2];
$ag_orders_search_line .= $order_fam.$ag_separator[2];
$ag_orders_search_line .= $order_mail.$ag_separator[2];	
$ag_orders_search_line .= $order_phone.$ag_separator[2];	
$ag_orders_search_line .= $order_comment_sear.$ag_separator[2];	
$ag_orders_search_line .= $add_d.'.'.$add_m.'.'.$add_y.$ag_separator[2];
$ag_orders_search_line .= $add_t.$ag_separator[2];	
$ag_orders_search_line .= $add_ip.$ag_separator[2];
//$ag_orders_search_line .= $apspaff;
$ag_orders_search_line = mb_strtolower($ag_orders_search_line, 'utf8');



$td_order_disp = $td_order_data;	

$ag_table_orders = $td_order_disp;	


//if (isset($ag_orders_query)) { 

//$list_num++;
//$ag_table_orders = $td_order_disp;
	
//} else {
	
//$list_num--;
//$ag_table_orders = $td_order_disp;
// access
/*
if ($ag_user_access == 2 || $ag_user_access == 3) { // user & editor
if (in_array($ag_user_id, $order_staff_a)) { 
$ag_table_orders = $td_order_disp;
} 
} else { // admin & founder
$ag_table_orders = $td_order_disp;	
}	
*/
	
//}




if (isset($_GET['my_order_search'])) {

if (in_array($_GET['my_order_search'], $order_staff_a)) { 
$ag_orders[$ag_of_count.$no]['table'] = $ag_table_orders;
$ag_orders_sort[$ag_of_count.$no] = $order_date;
} else {  }	

} else if (isset($_GET['actual'])) {
	
if ($ag_order_this_date <= date("Y-m-d", strtotime($order_date))) {
$ag_orders[$ag_of_count.$no]['table'] = $ag_table_orders;
} else {  }

} else if (isset($_GET['today'])) {

if ($ag_order_this_date == date("Y-m-d", strtotime($order_date))) {
$ag_orders[$ag_of_count.$no]['table'] = $ag_table_orders;

} else {  }

} else {

$ag_orders[$ag_of_count.$no]['table'] = $ag_table_orders;
$ag_orders_sort[$ag_of_count.$no] = $order_date;

}

$ag_orders[$ag_of_count.$no]['search'] = $ag_orders_search_line;


}// foreach ag_orders_data

}// foreach ag_all_orders

if (isset($_GET['sort'])) {
if (!empty($ag_orders_sort) && sizeof($ag_orders_sort) == sizeof($ag_orders)) {
array_multisort($ag_orders_sort, $ag_orders);
$ag_orders = array_reverse($ag_orders, true);
}
}






$ag_thead_orders = '<thead>';
$ag_thead_orders .= '<tr>';
$ag_thead_orders .= '<td class="tr_num"><div id="ag_select_all" onclick="ag_select_all()"><i class="icon-check"></i></div></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['number'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['service'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['date'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['booking_time'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['client'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['added'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['staffs_order'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td><input type="text" placeholder="'.$ag_lng['order_status'].'" onfocus="ag_filter_focus(this)" onblur="ag_filter_blur(this)" /></td>';
$ag_thead_orders .= '<td class="ag_td_tool"></td>';
$ag_thead_orders .= '<td class="ag_td_tool"></td>';
$ag_thead_orders .= '<td class="ag_td_tool"></td>';
$ag_thead_orders .= '</tr>';
$ag_thead_orders .= '</thead>';



if(!empty($ag_orders)) {
//$ag_orders = ag_unique_multidim_array($ag_orders, 'search');
//$ag_orders = ag_unique_multidim_array($ag_orders, 'table');
}





$ag_orders_arr = array();
if (isset($ag_orders_query)) { 
foreach($ag_orders as $n => $order) {
if (isset($order['search'])) {
if (preg_match('/'.$ag_orders_query.'/i', $order['search'])) { 
if (isset($order['table']) && !empty($order['table'])) {$ag_orders_arr[$n] = $order['table'];} }
}
}
} else {
foreach($ag_orders as $n => $order) { if (isset($order['table']) && !empty($order['table'])) {$ag_orders_arr[$n] = $order['table'];} }	
}

if(!empty($ag_orders_arr)) {
$ag_orders_arr = array_diff($ag_orders_arr, array(''));
$ag_orders_arr = array_unique($ag_orders_arr);
}

$ag_pages = ag_page_nav($ag_orders_arr);
$co = 0;
if ($ag_pages['num'] > 1) { $co = ($ag_pages['count'] * $ag_pages['num']) - $ag_pages['count']; }
$ag_oc = 0;

$ag_tbody_orders = '';

foreach($ag_orders_arr as $o => $tr) { $ag_oc++;
if ($ag_oc > $co) { $ag_tbody_orders .= $tr; }
if ($ag_oc == $ag_pages['view']) {break;}
}






if (empty($ag_tbody_orders)) {

$ag_table_orders = '<div class="ag_mess_orders"><p>'.$ag_lng['no_orders'].'</p></div>';
if (isset($_GET['order_search'])) { 
$_GET['order_search'] = htmlspecialchars($_GET['order_search'], ENT_QUOTES, 'UTF-8'); 
$ag_lng['not_found'] = str_replace('%s', '<strong>'.$_GET['order_search'].'</strong>', $ag_lng['not_found']);
$ag_table_orders = '<div class="ag_mess_orders"><p>'.$ag_lng['not_found'].'</p></div>'; 
}

} else {

$ag_table_orders = '<div class="ag_scroll_table">
<div class="ag_scroll_table_inner">
<div class="ag_orders_table_area">
<table class="ag_orders" id="ag_orders">'.$ag_thead_orders.'<tbody>'.$ag_tbody_orders.'</tbody></table>'.$ag_pages['html'].'<div class="clear"></div>
</div>
</div>
</div>';
}

$ag_top_order = '<div class="ag_select_order_tools">';
$ag_top_order .= '<div class="ag_count_selected_orders"><span>0</span></div>';
$ag_top_order .= '<div class="ag_delete_selected_orders">';
$ag_top_order .= '<button onclick="ag_del_select_orders()" class="ag_btn_big ag_ch_on"><i class="icon-cancel-2"></i><span>'.$ag_lng['delete'].'</span></button>';
$ag_top_order .= '</div>';
$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';




$ag_top_order .= '<div class="ag_top_tools ag_top_orders" id="ag_top_tools"><div class="ag_orders_tools">';
if ($ag_user_access == 2 || $ag_user_access == 3) {
$url_my_orders = '?orders&amp;my_order_search='.$ag_user_id;

if (isset($_GET['m_y'])) {$url_my_orders = '?orders&amp;m_y='.$_GET['m_y'].'&amp;my_order_search='.$ag_user_id;}
if (isset($_GET['my_order_search'])) {
$url_my_orders = '?orders';
if (isset($_GET['m_y'])) {$url_my_orders = '?orders&amp;m_y='.$_GET['m_y'];}
$ag_top_order .= '<div class="ag_tool_btn_a"><a href="'.$url_my_orders.'" title="'.$ag_lng['view_all_orders'].'"><i class="icon-th-list"></i></a></div>';	
} else {
$ag_top_order .= '<div class="ag_tool_btn_a"><a href="'.$url_my_orders.'" title="'.$ag_lng['view_only_my_orders'].'"><i class="icon-user"></i></a></div>';
}

}


$ag_top_order .='<div class="ag_tool_btn_a ag_schedule_a"><a href="#" onclick="ag_open_ifm(\'000\',\'../schedule.php\',\'ag_url\')" title="'.$ag_lng['orders_schedule'].'"><i class="icon-calendar"></i></a></div>';



//select period html
$ag_top_order .= '<div class="ag_order_period">';
$ag_top_order .= '<div class="ag_prev_month"><a href="?orders&amp;m_y='.$ag_link_pm.'_'.$ag_link_py.'" title="'.$ag_lng_monts[$ag_link_pm].' '.$ag_link_py.'"><i class="icon-left-open-big"></i></a></div>';

$oper_class = '';
if (isset($_GET['order_search'])) { 
$ag_order_sear_val = htmlspecialchars($_GET['order_search'], ENT_QUOTES, 'UTF-8'); 
if (!empty($ag_order_sear_val) && iconv_strlen($ag_order_sear_val, 'UTF-8') > 2) {
	$oper_class = ' ag_order_noperiod';
}}
$ag_top_order .= '<div class="ag_select_month'.$oper_class.'" id="ag_select_month" tabindex="-1" onclick="ag_select_month(1, this)"><span>'.$ag_lng_monts[$ag_get_per_m].'</span>';


$ag_top_order_months = '';
$imn_class = '';
foreach ($ag_lng_monts as $imn => $nmn) {
if ($imn != '' && $imn != '0' && $imn != '00') {
if ($imn == $ag_get_per_m) {$imn_class = 'ag_imn_current';} else {$imn_class = '';}
$ag_top_order_months .= '<li class="'.$imn_class.'" tabindex="-1" onclick="ag_order_ins_month(\''.$imn.'\', \''.$nmn.'\', this)">'.$nmn.'</li>';
}	
}
$ag_top_order .= '<div class="ag_order_months"><ul>'.$ag_top_order_months.'</ul></div>';
$ag_top_order .= '</div>';

$ag_top_order .= '<div class="ag_select_year'.$oper_class.'">';
$ag_top_order .= '<label><input type="text" id="ag_select_year" value="'.$ag_get_per_y.'" oninput="ag_order_ins_month(\'01\', \''.$ag_lng_monts['01'].'\', \'\'); ag_phone_check(this)" onpropertychange="ag_order_ins_month(\''.$imn.'\', \''.$nmn.'\', \'\'); ag_phone_check(this)" /></label>';
$ag_top_order .= '</div>';

$ag_to_curr_m = '<span id="ag_per_butt"><i class="icon-calendar-check-o"></i></span>';
if (isset($_GET['m_y']) && $_GET['m_y'] != date('m_Y')) {
$ag_to_curr_m = '<a href="?orders&amp;m_y='.date('m_Y').'" title="'.$ag_lng['to_current_month'].'" id="ag_per_butt"><i class="icon-calendar-check-o"></i></a>';
}
$ag_top_order .= '<div class="ag_current_month">'.$ag_to_curr_m.'</div>';

$ag_top_order .= '<div class="ag_next_month"><a href="?orders&amp;m_y='.$ag_link_nm.'_'.$ag_link_ny.'" title="'.$ag_lng_monts[$ag_link_nm].' '.$ag_link_ny.'"><i class="icon-right-open-big"></i></a></div>';

$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';
//select period

//search form
$ag_top_order .= '<div class="ag_order_search">';
$ag_top_order .= '<form action="'.$srv_absolute_url.'" method="get">';
$ag_top_order .= '<input type="hidden" value="" name="orders" />';
$ag_order_sear_val = '';
$ag_order_sear_reset = '';
if (isset($_GET['order_search'])) { 
$ag_order_sear_val = htmlspecialchars($_GET['order_search'], ENT_QUOTES, 'UTF-8'); 
if (!empty($ag_order_sear_val) && iconv_strlen($ag_order_sear_val, 'UTF-8') > 2) {
$ag_order_sear_reset = '<a href="?orders&amp;m_y='.date('m_Y').'" class="ag_order_sear_reset" title="'.$ag_lng['search_reset'].'"><i class="icon-cancel-circled-1"></i></a>';
}
}
$ag_top_order .= '<label><input type="text" value="'.$ag_order_sear_val.'" name="order_search" /></label>';
$ag_top_order .= $ag_order_sear_reset;
$ag_top_order .= '<button><i class="icon-search"></i></button>';
$ag_top_order .= '</form>';
$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';
//search form


if ($ag_get_period == date('m_Y')) {
$ag_top_order .= '<div class="ag_this_month_tools">';



$ag_td_cl = '';
if (isset($_GET['today'])) {$ag_td_cl = ' ag_ocurrent_tool';}
$ag_top_order .= '<div class="ag_in_today'.$ag_td_cl.'" tabindex="-1" onclick="ag_in_today(this)">'.$ag_lng['for_today'].'<span>: <strong>'.$ag_count_today.'</strong></span></div>';

//if (!isset($_GET['actual'])) {
$ag_td_cl = '';
if (isset($_GET['actual'])) {$ag_td_cl = ' ag_ocurrent_tool';}
$ag_top_order .= '<div class="ag_orders_actual'.$ag_td_cl.'" tabindex="-1" onclick="ag_orders_actual(this)">'.$ag_lng['orders_actual'].'<span>: <strong>'.$ag_count_actual.'</strong></span></div>';
//}



if (isset($_GET['order_search']) || isset($_GET['my_order_search']) || isset($_GET['actual'])) {
$ag_top_order .= '<div class="ag_reset_tools" tabindex="-1" onclick="ag_reset_tools(this)" title="'.$ag_lng['reset'].'"><i class="icon-cancel-circled-1"></i></div>';	
}

if (!isset($_GET['order_search']) && !isset($_GET['my_order_search']) && !isset($_GET['actual']) && !isset($_GET['today'])) { 
$ag_top_order .= '<div class="ag_reset_tools ag_reset_tools_refresh ag_disabled"><i class="icon-block-1"></i></div>';
} else {
$ag_top_order .= '<div class="ag_reset_tools ag_reset_tools_refresh" tabindex="-1" onclick="ag_reset_tools_refresh(this)" title="'.$ag_lng['back'].'"><i class="icon-left-1"></i></div>';	
}

$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';	


if (!isset($_GET['order_search']) && !isset($_GET['my_order_search']) && !isset($_GET['actual']) && !isset($_GET['today'])) { 
$url_my_orders = '?orders';
if (isset($_GET['m_y'])) {$url_my_orders = '?orders&amp;m_y='.$_GET['m_y'];}
if (isset($_GET['sort'])) {
$ag_top_order .= '<div class="ag_tool_btn_a"><a href="'.$url_my_orders.'" title="'.$ag_lng['sort_default'].'"><i class="icon-down-1"></i></a></div>';
} else {
$ag_top_order .= '<div class="ag_tool_btn_a"><a href="'.$url_my_orders.'&amp;sort" title="'.$ag_lng['sort_actual'].'"><i class="icon-up-1"></i></a></div>';	
}
}


}// this month






$ag_cc_url = '?orders';
if (isset($_GET['m_y'])) {$ag_cc_url = '?orders&m_y='.$_GET['m_y'];}
if (isset($_GET['order_search'])) {$ag_cc_url = '?orders&order_search='.$_GET['order_search'];}
if (isset($_GET['today'])) {$ag_cc_url = '?orders&today';}
if (isset($_GET['actual'])) {$ag_cc_url = '?orders&actual';}
if (isset($_GET['sort'])) {$ag_cc_url = '?orders&sort';}

$ag_tcp = 10;
if (isset($_SESSION['order_count'])) {$ag_tcp = $_SESSION['order_count']; }

if ($ag_pages['total'] > 1 || $ag_pages['items'] > 10) {
$ag_top_order .= '
<div class="ag_order_count">
<div class="ag_order_status_select">
<div class="ag_count_opt" tabindex="-1" onclick="ag_order_count(this)"><span>'.$ag_tcp.'</span></div>
</div>
</div>
<script>
var ag_trig_oc=0;

$(document).ready(function(){
	$(document).mouseup(function (e){
	var ag_opt = $(".ag_count_opt, .ag_list_pc");
	if(!ag_opt.is(e.target) && ag_opt.has(e.target).length===0){
		$(".ag_order_count").find("ul").fadeOut(200); ag_trig_oc = 0;
	}});
	});

function ag_order_count(e){
	ag_trig_oc++;
	$(".ag_order_status_select").find("ul.ag_list_status").remove();
	$(e).parents(".ag_order_status_select").append(\'<ul class="ag_list_status ag_list_pc"><li tabindex="-1" onclick="ag_order_change_count(10,this)">10</li><li tabindex="-1" onclick="ag_order_change_count(25,this)">25</li><li tabindex="-1" onclick="ag_order_change_count(50,this)">50</li><li tabindex="-1" onclick="ag_order_change_count(100,this)">100</li></ul>\');
	$(e).parents(".ag_order_status_select").find("ul.ag_list_status").fadeIn(250);
	if(ag_trig_oc>1){
		setTimeout(function(){$(e).parents(".ag_order_status_select").find("ul.ag_list_status").remove();},50);
		ag_trig_oc=0;
		}
	}
	
	function ag_order_change_count(c,e) {
	window.location = "'.$ag_cc_url.'&order_count=" + c;	
	}
	</script>
';
}// $pages['total']>1

if ($ag_pages['total'] > 1) {
if ($ag_pages['count'] > 1) {
	$ag_p_url = '?orders';
	if (isset($_GET['m_y'])) {$ag_p_url = '?orders&amp;m_y='.$_GET['m_y'];}
	
    if (isset($_GET['order_search'])) {$ag_p_url = '?orders&amp;order_search='.$_GET['order_search'];}
    if (isset($_GET['today'])) {$ag_p_url = '?orders&amp;today';}
    if (isset($_GET['actual'])) {$ag_p_url = '?orders&amp;actual';}
    if (isset($_GET['sort'])) {$ag_p_url = '?orders&sort';}
	
	$ag_next_page = '<span class="next ag_disabled"><i class="icon-right-open-big"></i></span>';
	$ag_prev_page = '<span class="prev ag_disabled"><i class="icon-left-open-big"></i></span>';
	if ($ag_pages['num'] > 1) {$ag_prev_page = '<a href="'.$ag_p_url.'&amp;p='.($ag_pages['num']-1).'" class="prev"><i class="icon-left-open-big"></i></a>';}
	if ($ag_pages['num'] < $ag_pages['total']) {$ag_next_page = '<a href="'.$ag_p_url.'&amp;p='.($ag_pages['num']+1).'" class="next"><i class="icon-right-open-big"></i></a>';}
	
	$ag_top_order .= '<div class="ag_page_num">
	'.$ag_prev_page.'
	<span>'.$ag_lng['page_num'].': <strong>'.$ag_pages['num'].'</strong></span>
	'.$ag_next_page.'
	<span class="clear"></span>
	</div>';
	}
}





$ag_top_order .='
<div class="ag_top_reserve">
<button class="ag_btn_big ag_right" onclick="ag_open_order(\'?orders&m_y='.date('m_Y').'&edit='.$ag_serv_res_id.'&order=&reserve=&iframe\')"><i class="icon-clock"></i><span>'.$ag_lng['reserve'].'</span></button>
<div class="clear"></div>
</div>
<div class="clear"></div>';



$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div></div>';
$ag_top_order .= '<div class="clear"></div>';

//list_orders

$ag_list_orders = $ag_top_order;
$ag_list_orders .= '<div class="ag_edit_block" id="ag_edit_block">';
$ag_list_orders .= '<div class="ag_edit_block_inner">';
$ag_list_orders .= $ag_table_orders;



$ag_list_orders .='
<div class="clear"></div>
<div class="ag_bottom_orders">
<!-- <button class="ag_btn_big ag_right" onclick="ag_open_order(\'?orders&m_y='.date('m_Y').'&edit='.$ag_serv_res_id.'&order=&reserve=&iframe\')"><i class="icon-clock"></i><span>'.$ag_lng['reserve'].'</span></button> -->
<div class="clear"></div>
</div>
<div class="clear"></div>';

$ag_list_orders .= '</div>';
$ag_list_orders .= '</div>';



$ag_list_orders .= '<script>';


if (isset($order_status_select_js)) { $ag_list_orders .= $order_status_select_js; }

$ag_list_orders .= '


function ag_done_order_edit() {
if (window.location.hash) {

var done_order_edit = window.location.hash.replace("#","");	
if ($("#" + done_order_edit).length) {

$("#" + done_order_edit).addClass("ag_order_after_edit");
setTimeout(function(){ $("#" + done_order_edit).removeClass("ag_order_after_edit"); }, 3000);





tdh = $("table.ag_orders thead").outerHeight(true);
tdo = $("#" + done_order_edit).position();
dscr = tdo.top + 1;
if (dscr > (tdh+2)) {$("#ag_edit_block").animate( {scrollTop: (dscr - tdh)}, 200);}
}

setTimeout(function(){ window.location.hash = ""; }, 300);
}
}


function ag_open_order(ag_url_ifm) {
$.colorbox({
close: "<i class=\"icon-cancel\"></i>",
iframe:true, 
transition:"elastic", ';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_list_orders .= '
fixed:true,
top:"0",
width:"100%", 
height:"100%", ';
} else {
$ag_list_orders .= '	
fixed:true,
top:"16px",
width:"80%", 
height:"90%", ';
} 
$ag_list_orders .= '
opacity:"100", 
href:ag_url_ifm
});';


$ag_list_orders .= '
$(document).bind(\'cbox_closed\', function(){
 ag_done_order_edit();
});';


$ag_list_orders .= '	
}
';

$ag_list_orders .= '
var ag_min_width = 1200;

function ag_getScrollBarWidth() {
    var inner = document.createElement("p");
    inner.style.width = "100%";
    inner.style.height = "200px";

    var outer = document.createElement("div");
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild (inner);

    document.body.appendChild (outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = "scroll";
    var w2 = inner.offsetWidth;
    if (w1 == w2)
        w2 = outer.clientWidth;
    document.body.removeChild (outer);

    return (w1 - w2);
}


var sp = $("#ag_edit_block").scrollTop();	
var ag_all_tr = [];
if ($("table.ag_orders tbody tr.ag_order_row").length > 10) {
	$("table.ag_orders tbody tr.ag_order_row").each(function () {
		
	/*if ($(this).index() > 9) {$(this).css({display:"none"});}*/
	
	
	var id = $(this).attr("id");
	var eq = $(this).index();
	
	
	});
	
$("#ag_edit_block").scroll(function() { 
    var th = $("#ag_edit_block").outerHeight(true);
    sp = $("#ag_edit_block").scrollTop();
    });		
}







var tcl = 250;
function ag_order_table() {
	
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);	
/*var ag_sclool_w = ag_getScrollBarWidth();*/




/*
var maxWidth = 0;
$("table.ag_orders tbody tr.ag_order_row").find("td").each(function () {
    if ($(this).outerWidth(true) > maxWidth) {
    maxWidth = $(this).outerWidth(true);
   }
}).width(maxWidth);	
*/






	
	
var ag_th_h = $("table.ag_orders thead tr td").outerHeight(true);
var ag_table_w = $("table.ag_orders").outerWidth(true);


$("table.ag_orders").addClass("ag_orders_mob"); 
$(".ag_orders_table_area").css({paddingTop: "0"});

if (ag_min_width > ag_win_width) { 
$("table.ag_orders").addClass("ag_orders_mob"); 
$(".ag_orders_table_area").css({paddingTop: "0"});
} else { 
$("table.ag_orders").removeClass("ag_orders_mob");
$(".ag_orders_table_area").css({paddingTop: ag_th_h + "px"});
} 



var ag_count_order_row = 0;



for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) { ag_count_order_row++;
if (ag_count_order_row % 2 == 0) {
$("table.ag_orders tbody tr.ag_order_row").eq(r).addClass("ag_order_row_even");
} else {
$("table.ag_orders tbody tr.ag_order_row").eq(r).removeClass("ag_order_row_even");
}



/*
if (r > 10) {
	(function(r) {
        setTimeout(function(){
		  $("table.ag_orders tbody tr.ag_order_row").eq(r).css({display:"table-row"});
        }, tcl);
	tcl = tcl + 25;	
    })(r);
	
	}
*/	
}


for (var i = 0; i < $("table.ag_orders tbody tr.ag_order_row").eq(0).find("td").length; i++) {
var ag_td_w = $("table.ag_orders tbody tr.ag_order_row").eq(0).find("td").eq(i).outerWidth(true);
$("table.ag_orders thead tr td").eq(i).css({width: ag_td_w   + "px", maxWidth: ag_td_w   + "px", overflow:"hidden"});
}
$("table.ag_orders thead").css({minWidth: $("table.ag_orders").outerWidth(true) + "px", maxHeight:ag_th_h + "px"});



var ag_order_th = $("table.ag_orders").outerHeight(true);
/*$(".ag_scroll_table").css({height: (ag_order_th) + "px"});*/

var ag_work_h = $("#ag_top").outerHeight(true) + $("#ag_top_tools").outerHeight(true);
$("table.ag_orders thead").css({top: ag_work_h + "px"});


$("table.ag_orders tbody tr.ag_order_row").removeClass("ag_order_checked");
if ($("table.ag_orders tbody tr").find("input:checkbox").is(":checked")) {
$("table.ag_orders tbody tr").find("input:checkbox").prop("checked", false);
ag_select_orders();
}

ag_count_today_actual();


var count_td = 0;		
if (ag_count_order_row == 0) {
count_td = $("table.ag_orders thead tr td").length; 

if (!$(".ag_ofilter_notfound").length) {
$("table.ag_orders tbody").append(\'<tr class="ag_ofilter_notfound"><td colspan="\'+count_td+\'">'.$ag_lng['not_found_list'].'</td></tr>\');
}

}

}






var ag_w_height = $(window).outerHeight(true);
var ag_w_width = window.innerWidth;
var ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;

$(document).ready(function(){ 
ag_done_order_edit(); 
});

$(window).on("resize", function(event) { 
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;

var ag_r_h = $(window).outerHeight(true);
var ag_r_w = window.innerWidth;

setTimeout(function() { ag_order_table(); }, ag_tr_count + 180); 
});

$(window).load(function(){ 
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
if ($("table.ag_orders tbody tr.ag_order_row").length > 10) { 
setTimeout(function() { ag_order_table(); }, ag_tr_count + 35); 
} else { setTimeout(function() { ag_order_table(); }, 35);  }
});

var ag_count_oninput_filters = 0;
var filters = [];

	function ag_td_filter(table,col,text)
	{   
	ag_count_oninput_filters++;
	var ag_found_val = 0;
		$("table.ag_orders tbody").find("tr.ag_ofilter_notfound").remove();
		$(".ag_this_month_tools div").removeClass("ag_ocurrent_tool");
		
		filters[col] = encodeURIComponent(text);
	
		$(table).find("tr").each(function(i){
			$(this).data("passed", true);
		});
		
		for(index in filters)
		{
			if(filters[index] !== "any")
			{
				$(table).find("tr td:nth-child("+index+")").each(function(i){

					if( encodeURIComponent( $(this).text().toLowerCase() ).indexOf(filters[index]) > -1 && $(this).parent().data("passed"))
					{   
						$(this).parent().data("passed", true);
					}
					else
					{   
						$(this).parent().data("passed", false);
					}
				});
			}
		}
		
		$(table).find("tr").each(function(i){
			if(!$(this).data("passed"))
			{   
				$(this).addClass("ag_hidden_row");
				$(this).removeClass("ag_order_row");
			}
			else
			{
				$(this).removeClass("ag_hidden_row");
				$(this).addClass("ag_order_row");
			}
		});
		
		
for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) { ag_found_val++; }		
		

	
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
setTimeout(function() { ag_order_table(); }, ag_tr_count); 
		
if (ag_count_oninput_filters == 1) {
setTimeout(function() { $(".ag_reset_tools").addClass("ag_reset_tools_active");	}, 30);
}    
		
		
	}


$(function() {

$("thead tr td input").on("input",function () {


var query_all = "";
var query = $(this).val().toLowerCase();
var ncell = $(this).parents("td").index() + 1;

filters = [];

for (var i = 0; i < $("thead tr td input").length; i++) {
query = $("thead tr td input").eq(i).val().toLowerCase();
ncell = $("thead tr td input").eq(i).parents("td").index() + 1;
ag_td_filter("#ag_orders tbody", ncell, query); 
query_all += query;
}





if (query_all != "") {
	$(".ag_reset_tools").addClass("ag_reset_tools_active"); 
	} else {
	$(".ag_reset_tools").removeClass("ag_reset_tools_active");
	ag_count_oninput_filters = 0;
	}


	
});

});

var ag_f_placeholder = "";

function ag_filter_focus(e) {
ag_f_placeholder = $(e).attr("placeholder");	
$(e).attr("placeholder", "");
}


function ag_filter_blur(e) {
$(e).attr("placeholder", ag_f_placeholder);	
}


function ag_order_error(id) {
	ag_cancel();
}

function ag_order_notfound(id) {	
ag_cancel();
$("#"+id).removeClass("ag_order_row");
$("#"+id+" td").fadeOut(250);
setTimeout(function() { $("#"+id).remove(); ag_order_table(); }, 300);	
}

function ag_order_delete_confirm(file, id) {
	var del_item_name_a = id.split(",");
	var del_item_name = "<ul>";
	var count_del_orders = 0;
	for (var i = 0; i < del_item_name_a.length; i++) { 
	if (del_item_name_a[i]) {count_del_orders++;
	del_item_name += "<li>'.$ag_lng['order'].' № "+$("#"+del_item_name_a[i]).find("span.ag_order_num").text()+"</li>";
	}
	}
	del_item_name += "</ul>";
	id = file + "|" + id;
	var ag_title_odel = "'.$ag_lng['confirm_delete'].'";
	if (count_del_orders > 1) {ag_title_odel = "'.$ag_lng['confirm_delete_multi'].'";}
	ag_dialog(id, del_item_name, ag_title_odel, "ag_order_delete", "icon-attention ag_str_red", "button2");	
}


function ag_order_delete(id) { 
var arg = (id).split("|");

$.ajax({
	
type: "POST",
url: "'.$srv_absolute_url.'inc/orders.php",
data: "order_delete="+arg[1]+"&order_period="+arg[0],
 
success: function(data) {

if(!data.ag_success && !data.message) {alert(data);}

if (data.ag_success == true) { 
ag_cancel();

var ag_del_rows = arg[1].split(",");


var dtimeout = 0;
for(var d = 0; d < ag_del_rows.length; d++) {
	
$("#"+ag_del_rows[d]).addClass("ag_order_remove");	
	


(function(d) {
        setTimeout(function(){
		$("#"+ag_del_rows[d]).fadeOut(230);	
		setTimeout(function(){ $("#"+ag_del_rows[d]).remove();},250);
        }, dtimeout);
		dtimeout = dtimeout + 70;
    })(d);


}

dtimeoutm = dtimeout + 70;
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
setTimeout(function() { ag_order_table(); ag_select_orders(); }, ag_tr_count+dtimeout); 
} 

if (data.message) {
	ag_cancel();
	var ag_success_func = "ag_order_error";
	setTimeout(function() {
	if (data.message == "'.$ag_lng['error_order_delete_found'].'") {ag_success_func = "ag_order_notfound";}
	ag_dialog(arg[1], data.message, "'.$ag_lng['error'].'", ag_success_func, "icon-cancel-circle ag_str_red", "button0");
	ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
    setTimeout(function() { ag_order_table(); }, ag_tr_count); 
	}, 500);
}
	

},
error: function(XMLHttpRequest, textStatus, errorThrown) {
   ag_cancel();
   setTimeout(function() {
   ag_dialog(arg[1], textStatus, "'.$ag_lng['error'].'", "ag_order_error", "icon-cancel-circle ag_str_red", "button0");
   ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
   setTimeout(function() { ag_order_table(); }, ag_tr_count); 
   }, 500);
}
});

}




function ag_select_month(trig, e) {
	if (trig == 1) {
		$(".ag_order_months").slideDown(250); 
		$(e).attr("onclick", "ag_select_month(0, this)");
	} else {
		$(".ag_order_months").slideUp(250); 
		$(e).attr("onclick", "ag_select_month(1, this)");
	}
}


function ag_order_ins_month(num, nam, e) {
	$("#ag_select_month span").text(nam);
	var soyear = $("#ag_select_year").val();
	$(".ag_order_months ul li").removeClass("ag_imn_current");
	if (e != "") {
	$(e).addClass("ag_imn_current");
	} else {
	$(".ag_order_months ul li").eq(0).addClass("ag_imn_current");	
	}
	$(".ag_current_month").html(\'<span class="ag_sub_per" title="'.$ag_lng['go'].' '.$ag_lng['to'].' \'+nam+\' \'+soyear+\'" onclick="ag_sub_per(\'+num+\')"><i class="icon-ok"></i></span>\');
	
	$(".ag_select_month, .ag_select_year").removeClass("ag_order_noperiod");
}

function ag_sub_per(num) {
if (num < 10) {num = "0"+num;}
var soyear = $("#ag_select_year").val();
window.location = "?orders&m_y="+num+"_"+soyear;	
}


$(document).mouseup(function (e) {
var ag_oper = $(".ag_select_month");
if (!ag_oper.is(e.target) && ag_oper.has(e.target).length === 0) {	
ag_select_month(0, $(".ag_select_month"));
}
});



function ag_reset_tools_refresh(e) {
window.location = "?orders";		
}

';


if (!isset($_GET['order_search']) && !isset($_GET['my_order_search']) && !isset($_GET['actual'])) { 

$ag_list_orders .= '
function ag_orders_actual(e) {
window.location = "?orders&actual";	
}
function ag_in_today(e) {
window.location = "?orders&today";	
}
function ag_count_today_actual() {}
';

} else {
	
$ag_list_orders .= '
function ag_orders_actual(e) {
var all_actual = "";

var ag_thisDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').');
	$(".ag_this_month_tools div").removeClass("ag_ocurrent_tool");
	if (e) {$(e).addClass("ag_ocurrent_tool");}
	
$("table.ag_orders tbody").find("tr.ag_ofilter_notfound").remove();	
$("table.ag_orders tbody tr").removeClass("ag_hidden_row").addClass("ag_order_row");
$("table.ag_orders thead tr td").find("input").val("");
	
var ag_count_order_row = 0;

for (var r = 0; r < $("table.ag_orders tbody tr").length; r++) { 
var ag_o_date = $("table.ag_orders tbody tr").eq(r).find(".ag_order_sort_date").text();
var ad = "";
var am = "";
var ay = "";
if(ag_o_date) {
var ag_o_datea = ag_o_date.split(".");	
ad = parseFloat(ag_o_datea[0]);
am = parseFloat(ag_o_datea[1]) - 1;
ay = parseFloat(ag_o_datea[2]);
}
var ag_oDate = new Date(ay, am, ad);
if (ag_thisDate > ag_oDate) {
	$("table.ag_orders tbody tr").eq(r).removeClass("ag_order_row").addClass("ag_hidden_row");
} else {ag_count_order_row++;}

}

if (ag_count_order_row == 0) {
	var count_td = $("table.ag_orders thead tr td").length;
	$("table.ag_orders tbody").append(\'<tr class="ag_ofilter_notfound"><td colspan="\'+count_td+\'">'.$ag_lng['not_found_list'].'</td></tr>\');
}
	
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
setTimeout(function() { ag_order_table(); }, ag_tr_count); 
$(".ag_reset_tools").addClass("ag_reset_tools_active");
}
';


$ag_list_orders .= '

function ag_in_today(e) {
	$("table.ag_orders tbody").find("tr.ag_ofilter_notfound").remove();
	$(".ag_this_month_tools div").removeClass("ag_ocurrent_tool");
	$(e).addClass("ag_ocurrent_tool");
	
var ag_count_order_row = 0;
for (var r = 0; r < $("table.ag_orders tbody tr").length; r++) { 
var ag_o_date = $("table.ag_orders tbody tr").eq(r).find(".ag_order_sort_date").text();
if (ag_o_date != "'.date('d.m.Y').'") { 
$("table.ag_orders tbody tr").eq(r).removeClass("ag_order_row").addClass("ag_hidden_row"); 
} else {ag_count_order_row++;}
}

if (ag_count_order_row == 0) {
	var count_td = $("table.ag_orders thead tr td").length;
	$("table.ag_orders tbody").append(\'<tr class="ag_ofilter_notfound"><td colspan="\'+count_td+\'">'.$ag_lng['not_found_list'].'</td></tr>\');
}

ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
setTimeout(function() { ag_order_table(); }, ag_tr_count); 
setTimeout(function() { $(".ag_reset_tools").addClass("ag_reset_tools_active");	}, 30);
}



function ag_count_today_actual() {
var all_actual = "";	
';
	
if (isset($_GET['actual'])) {$ag_list_orders .= 'all_actual = '.$ag_count_actual.';';}	

$ag_list_orders .= '	
var ag_count_order_row = 0;
var ag_count_today = 0;
var ag_count_noactual = 0;
var ag_count_actual = 0;

for (var r = 0; r < $("table.ag_orders tbody tr").length; r++) { ag_count_order_row++; }
if ($("table.ag_orders tbody tr.ag_ofilter_notfound").length) {ag_count_order_row = ag_count_order_row - 1;}
for (var t = 0; t < $("table.ag_orders tbody tr.ag_today_order").length; t++) { ag_count_today++; }
for (var a = 0; a < $("table.ag_orders tbody tr.ag_noactual_order").length; a++) { ag_count_noactual++; }
ag_count_actual = ag_count_order_row - ag_count_noactual;


if (all_actual) {ag_count_actual = all_actual;}
$(".ag_in_today span").html(\':&#160;<strong>\'+ag_count_today+\'</strong>\');
$(".ag_orders_actual span").html(\':&#160;<strong>\'+ag_count_actual+\'</strong>\');


if (ag_count_order_row == 0) {
	var count_td = $("table.ag_orders thead tr td").length;
	$("table.ag_orders tbody").append(\'<tr class="ag_ofilter_notfound"><td colspan="\'+count_td+\'">'.$ag_lng['not_found_list'].'</td></tr>\');
}	

}



';	
	
}


$ag_list_orders .= '


function ag_reset_tools(e) {
$("table.ag_orders tbody").find("tr.ag_ofilter_notfound").remove();
$(".ag_this_month_tools div").removeClass("ag_ocurrent_tool");
$("table.ag_orders tbody tr").removeClass("ag_hidden_row").addClass("ag_order_row");
$("table.ag_orders thead tr td").find("input").val("");
ag_tr_count = $("table.ag_orders tbody tr.ag_order_row").length;
setTimeout(function() { ag_order_table(); }, ag_tr_count);
$(".ag_reset_tools").removeClass("ag_reset_tools_active");
}


var ag_so_cc = 0;
function ag_select_orders() {
ag_so_cc = ag_so_cc + 1;
var ag_count_select_order_row = 0;

$("table.ag_orders tbody tr.ag_order_row").removeClass("ag_order_checked");
for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) { 
if ($("table.ag_orders tbody tr.ag_order_row").eq(r).find("input:checkbox").is(":checked")) { ag_count_select_order_row++; 
$("table.ag_orders tbody tr.ag_order_row").eq(r).addClass("ag_order_checked");

}
}


if (ag_count_select_order_row > 0) { 

$(".ag_select_order_tools").stop().css({right:"32px"});

$(".ag_count_selected_orders span").text(ag_count_select_order_row);
$(".ag_reset_tools").addClass("ag_reset_tools_active"); 

} else {
$(".ag_select_order_tools").stop().animate({right:"-120%"}, 250);	
$(".ag_reset_tools").removeClass("ag_reset_tools_active");
}


}

function ag_del_select_orders() {
var ag_checked_id = "";
var ag_checked_file = "";
for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) { 
if ($("table.ag_orders tbody tr.ag_order_row").eq(r).find("input:checkbox").is(":checked")) {
ag_checked_id += $("table.ag_orders tbody tr.ag_order_row").eq(r).find("input:checkbox").attr("data-id") + ",";
ag_checked_file += $("table.ag_orders tbody tr.ag_order_row").eq(r).find("input:checkbox").attr("data-file") + ",";
}
}
ag_order_delete_confirm(ag_checked_file, ag_checked_id);	
}

var ag_total = '.$ag_pages['total'].';
var ag_page = '.$ag_pages['num'].';
var ag_items = '.$ag_pages['items'].';
var ag_count = '.$ag_pages['count'].';
var item_num = ag_items;
var ag_co = 0;
if (ag_page > 1) { ag_co = (ag_count * ag_page) - ag_count; }
for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) {
ag_co++;
item_num = (ag_items - ag_co) + 1;
$("table.ag_orders tbody tr.ag_order_row").eq(r).find(".ag_order_list_num").text(item_num);
}


function ag_select_all() {
/*$(".ag_order_check input").click();*/	
var dtimeout = 0;
for (var r = 0; r < $("table.ag_orders tbody tr.ag_order_row").length; r++) {


(function(r) {
        setTimeout(function(){
		$("table.ag_orders tbody tr.ag_order_row").eq(r).find(".ag_order_check input:checkbox").click();	
        }, dtimeout);
		dtimeout = dtimeout + 35;
    })(r);

}
}


'.$order_refresh.'
</script>


';
//ag_order_sort_date





function ag_order_success($res='', $mess='') {
if (!empty($mess)) {$mess = ', "message": "'.$mess.'"';}
$result = '{"ag_success": '.$res.$mess.'}';	
return $result;
}




if (isset($_POST['order_change_status']) && isset($_POST['order_new_status']) && isset($_POST['order_data'])) {
header("Content-Type: application/json;charset=utf-8");
unset($ag_change_error);
$ag_orders_data = array();
$ag_orders_file = $ag_orders_dir.'/'.$_POST['order_data'].$agt; 
if (file_exists($ag_orders_file)) { 
$ag_orders_data = ag_read_data($ag_orders_file);
} 	
$o_old_status = 1;
foreach ($ag_orders_data as $nl => $od) {
if (isset($od['id']) && $od['id'] == $_POST['order_change_status']) {
if (isset($od['status'])) {$o_old_status = $od['status'];}
if ($o_old_status != $_POST['order_new_status']) {
	$old_line_status = $o_old_status;
	$new_line_status = (int)$_POST['order_new_status'];
	$num_line = $nl;
	} else {
	//$ag_change_error = $ag_lng['error_no_change'];	
	}
}// id	
}// foreach ag_orders_data


$ag_lines = array(); 
if (file_exists($ag_orders_file)) {
	
$ag_fp = fopen($ag_orders_file, "r+");
flock ($ag_fp,LOCK_EX); 
if (filesize($ag_orders_file) != 0) { $ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_orders_file))); } 
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp); 
 
 
 
$ag_str_sep_add_info = '::';
$ag_user_id = $ag_auth_this_staff['name'];

$change_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR']; 
 
 
 
 
if (isset($num_line) && isset($ag_lines[$num_line]) && isset($new_line_status) && isset($old_line_status)) {
	
	
// change info
$ag_new_line = str_replace('status|*|'.$old_line_status, 'status|*|'.$new_line_status, $ag_lines[$num_line]);	

$old_cd = ag_str_cat($ag_new_line, 'changed|*|', '|:|');
$ag_new_line = str_replace($old_cd, 'changed|*||:|', $ag_new_line);

$ag_new_line = str_replace('changed|*|', 'changed|*|'.$change_info, $ag_new_line);	
// change info


$ag_contents = file_get_contents($ag_orders_file);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$num_line])) {

$ag_contents[$num_line] = $ag_new_line;
if (is_writable($ag_orders_file)) {
	
   if (!$ag_handle = fopen($ag_orders_file, 'wb')) { $ag_change_error = $ag_lng['error_open_file']. ' - ' .$ag_orders_file; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_change_error = $ag_lng['error_open_file']. ' - ' .$ag_orders_file; }
   fclose($ag_handle);
    
}
}



}// isset ag_line
 
 
 
}//file_exists 

if (isset($ag_change_error)) {echo ag_order_success('false', $ag_change_error);}
else {echo ag_order_success('true', $ag_lng['done']);}

}// post change status








if (isset($_POST['order_period'])) {
header("Content-Type: application/json;charset=utf-8");

$ag_orders_data = array();
$ag_post_orders = array();	
$id_del_orders = array();
$post_order_staff = array();

$ag_orders_file_s = htmlspecialchars($_POST['order_period'], ENT_QUOTES, 'UTF-8');
$ag_orders_files = explode(',', $ag_orders_file_s); 
$ag_orders_files = array_diff($ag_orders_files, array(''));
$ag_orders_files = array_unique($ag_orders_files);



	
if (isset($_POST['order_delete'])) { 
$ag_post_orders = explode(',', $_POST['order_delete']); 
$ag_post_orders = array_diff($ag_post_orders, array(''));
$ag_post_orders = array_unique($ag_post_orders);
}	

foreach ($ag_post_orders as $nd => $post_order) {
	
if (isset($ag_orders_files[$nd])) {	
$ag_orders_file = $ag_orders_dir.'/'.$ag_orders_files[$nd].$agt; 
if (file_exists($ag_orders_file)) { 
$ag_orders_data = ag_read_data($ag_orders_file);
} 	
}	
	
$id_del_orders[$nd]['num'] = 'notfound';
$id_del_orders[$nd]['file'] = $ag_orders_file;
	
foreach ($ag_orders_data as $io => $a_order) {
if (isset($a_order['id']) && $a_order['id'] == $post_order) {

if (isset($a_order['staffs'])) { $post_order_staff = explode($ag_separator[2], $a_order['staffs']); }	
	
	if ($ag_user_access == 2 || $ag_user_access == 3) { // user & editor
	$id_del_orders[$nd]['num'] = 'noaccess';
    if (in_array($ag_user_id, $post_order_staff)) { 
	$id_del_orders[$nd]['num'] = $io + 1;
	} 
	} else {
	$id_del_orders[$nd]['num'] = $io + 1;	
	}
	
}// id


}// foreach ag_orders_data
}// foreach ag_post_orders


$ag_do_answer = 'true';
$ag_do_message = '';

if (!empty($id_del_orders)) {

	foreach($id_del_orders as $nd) { 
	if (isset($nd['num']) && isset($nd['file'])) {
		
	if ($nd['num'] == 'noaccess') {
		$ag_do_answer = 'false'; $ag_do_message = $ag_lng['error_order_delete_access']; break;
	} else if ($nd['num'] == 'notfound') {
		$ag_do_answer = 'false'; $ag_do_message = $ag_lng['error_order_delete_found']; break;
	} else {
		
		$ag_do_answer = 'true'; $ag_do_message = '';
		if (!empty($nd['num'])) {$nd['num'] = $nd['num'] - 1;}
		//
		//delete

$ag_delete_line = $nd['num'];
$ag_lines = array();

$ag_file_name = $nd['file'];	
if (file_exists($ag_file_name)) {
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));	
$ag_br = "\n";

if (isSet($ag_lines[(integer) $ag_delete_line]) == true) {   
        unset($ag_lines[(integer) $ag_delete_line]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode($ag_br, $ag_lines)));
    }
}//	file_exists ag_file_name	
	
	

		
		
		
		
	}
	}
	}
	
}

echo ag_order_success($ag_do_answer, $ag_do_message);	
} 




// statistics
$ag_statistics = '';
$ag_statistics_js = '';
$ag_statistics_order_data = array();
$ag_all_order_data = array();
if (isset($_GET['statistics'])) {
$ag_all_orders = array();
if (file_exists($ag_orders_dir)) {
$ag_all_orders = ag_file_list($ag_orders_dir, $agt); // files orders periods
}
$ag_count_all_oeders_lines = 0;
foreach ($ag_all_orders as $ag_order_data_files) {
if (file_exists($ag_order_data_files['name'])) {$ag_all_order_data = ag_read_data($ag_order_data_files['name']);} 

foreach ($ag_all_order_data as $sf => $saorder) { $ag_count_all_oeders_lines ++;
$ag_statistics_order_data[$ag_count_all_oeders_lines ] =  $saorder;
}
}// foreach ag_all_orders







$ag_statistics_serv = array();
// count service
$ag_statistics_serv_id = array();
$ag_statistics_serv_title = array();
foreach ($ag_statistics_order_data as $sorder) {
if (isset($sorder['service'])) {
	$ag_statistics_serv_id[] = $sorder['service'];
	$ag_statistics_serv[$sorder['service']]['count'] = 0;
	}
}
$ag_statistics_serv_id = array_unique($ag_statistics_serv_id);
// count service






$ag_total_orders = sizeof($ag_statistics_order_data); //total orders count

$ag_count_all_orders = 0;
$ag_count_serv_orders = 0;
$ag_display_name_serv = '';



foreach ($ag_statistics_order_data as $sorder) { 
$ag_count_all_orders++;
$ag_count_serv_orders = 0;


if (isset($sorder['title']) && isset($sorder['service'])) { 

if (in_array($sorder['service'], $ag_statistics_serv_id)) { $ag_count_serv_orders++;
 
$ag_display_serv = ag_statistic_service($sorder['service']);
$ag_display_name_serv = $ag_display_serv['name'];
if (empty($ag_display_name_serv)) {$ag_display_name_serv = $sorder['title'];}	


$ag_statistics_serv[$sorder['service']]['name'] = $ag_display_name_serv;
$ag_statistics_serv[$sorder['service']]['count'] += $ag_count_serv_orders;
}

}

}

//services & orders
$ag_services_orders = 'var ag_total_orders = '.$ag_total_orders.';';
$ag_services_orders .= 'var ag_services_orders = [';
foreach ($ag_statistics_serv as $serv_graph) {
$ag_services_orders .= '{name: "'.$serv_graph['name'].'", value: '.$serv_graph['count'].'},';	
}
if (!empty($ag_services_orders) && $ag_services_orders[strlen($ag_services_orders) - 1] == ',') {$ag_services_orders = substr($ag_services_orders, 0, -1);}	
$ag_services_orders .= '];';
$ag_statistics_js .= $ag_services_orders;
$ag_statistics_js .= '
var ag_st_data_table = "";
var countchrttr = 0;
for (var i in ag_services_orders) { countchrttr++;
ag_st_data_table += "<tr>";
ag_st_data_table += "<td class=\"ag_chart_td_serv\"><span><strong>" + countchrttr + ".</strong>&#160;" + ag_services_orders[i].name + ":</span></td>";	
ag_st_data_table += "<td class=\"ag_chart_td_val\"><div>" + ag_services_orders[i].value + "</div></td>";
ag_st_data_table += \'<td class="ag_st_chart_td"><div class="ag_st_chart" data-value="\' + ag_services_orders[i].value + \'"></div></td>\';
ag_st_data_table += "</tr>";
}
var ag_st_total_tr = \'<tr class="ag_total_ordst_tr"><td><span>'.$ag_lng['total_orders'].':</span></td><td colspan="2"><span><strong>\' +ag_total_orders+ \'</strong></span></td></tr>\';
$("#ag_services_orders").html(ag_st_data_table + ag_st_total_tr);

function ag_chart_serv() {
$("#ag_services_orders tr td.ag_st_chart_td").find("div").css({width: "0px"});
for (var ti = 0; ti < $("#ag_services_orders tr td.ag_st_chart_td").length; ti++) {
var ag_chart_w = $("#ag_services_orders tr td.ag_st_chart_td").eq(ti).outerWidth(true);
var ag_chart_h = $("#ag_services_orders tr td.ag_st_chart_td").eq(ti).outerHeight(true);
var ag_cart_val = parseFloat($("#ag_services_orders tr td.ag_st_chart_td").eq(ti).find("div").attr("data-value"));
var ag_cart_percent = ag_cart_val * 100 / ag_total_orders;
ag_cart_percent = ag_cart_percent.toFixed(1);
$("#ag_services_orders tr td.ag_st_chart_td").eq(ti).find("div").css({height: (ag_chart_h - 4) + "px", marginTop: "2px"});
$("#ag_services_orders tr td.ag_chart_td_val").eq(ti).find("div").css({height: (ag_chart_h - 4) + "px", lineHeight: (ag_chart_h - 4) + "px", marginTop: "2px"});
$("#ag_services_orders tr td.ag_st_chart_td").eq(ti).find("div").animate({width: ag_cart_percent + "%"}, 300);
$("#ag_services_orders tr td.ag_chart_td_val").eq(ti).find("div").append(\'&#160;<small>(\' + ag_cart_percent + \'%)</small>\');
}
}

$(window).load(function() { 
setTimeout(function() { ag_chart_serv(); },50);
});
$(window).resize(function() {
setTimeout(function() { ag_chart_serv(); },50); 
});

';


$ag_statistics .= '<div class="ag_st_block">';
$ag_statistics .= '<div class="ag_st_block_inner">';
$ag_statistics .= '<h3 class="ag_title_statistics">'.$ag_lng['statistics_services_orders'].'</h3>';
$ag_statistics .= '<table id="ag_services_orders" class="ag_st_table"></table>';
$ag_statistics .= '</div>';
$ag_statistics .= '</div>';




$ag_statistics_js = '<script>'.$ag_statistics_js.'</script>';
$ag_statistics .= $ag_statistics_js;
}// get statistics









$ag_ch_ord_post = 0;
if (isset($_POST['order_period']) || isset($_POST['order_change_status'])) {$ag_ch_ord_post = 1;}

if ($ag_ch_ord_post == 0) { 

if (isset($_GET['edit']) && isset($_GET['order'])) {

$ag_book_form = '<div class="ag_apanel_booking_form">'.ag_obj_incude($_GET['edit']).'</div>';	
$ag_book_form .= '
<script>
var ag_now_height = $(window).outerHeight(true);
var ag_now_width = window.innerWidth;

function ag_wsize() {
ag_now_height = $(window).outerHeight(true);
ag_now_width = window.innerWidth;
if (ag_now_width < 1080) {$("#ag_main").addClass("ag_main_mobile");} else {$("#ag_main").removeClass("ag_main_mobile");}
}

$(window).resize(function() {ag_wsize(); });
$(document).ready(function(){ag_wsize(); });
</script>';	
echo ag_return_html($ag_book_form);

} else {
	
if (isset($_GET['statistics'])) {
	echo ag_return_html($ag_statistics);
} else {
	echo ag_return_html($ag_list_orders); 
}

}

}


//$ag_ERROR['order'] = 'test error order';
?>