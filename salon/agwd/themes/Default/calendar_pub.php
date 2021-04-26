<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)

header('Content-type: text/html; charset=utf-8');
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Pragma: no-cache"); // HTTP/1.0
error_reporting(0);

if (isset($_POST['ag_date'])) {
$ag_index = 1;
include ('../../inc/host.php');
include ('../../inc/db_conf.php');
include ('../../'.$ag_data_dir.'/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
include ('../../'.$ag_cfg_lng);// LNG
include ('../../inc/functions.php'); 
$ag_data_dir = '../../'.$ag_data_dir;
}
include ('params.php'); 

//============================= Calendar publication

function ag_obj_calendar($date = '') {

$return_obj = array();

if(empty($date)) {$date = date('Y-m-d');}

global $ag_data_dir;
global $ag_cat;
global $ag_get_cat;
global $ag_get_obj;
global $agt;	
global $ag_separator;
global $ag_cfg_cal_exclude_list_cat;

$ag_db_file = '';
$ag_alias_cat_link = '';
$ag_cat_name = '';
$ag_off_date = '';
$cat_id = '';
$ag_exc_cat = array();

	foreach ($ag_cat as $nc => $cat) {


	if (isset($cat['status']) && $cat['status'] == 1) { 
	if (isset($cat['alias'])) { $ag_alias_cat_link = $cat['alias']; }
	if (isset($cat['off_date'])) { $ag_off_date = $cat['off_date']; }
	if (isset($cat['title'])) { $ag_cat_name = $cat['title']; }
	if (isset($cat['id'])) { $cat_id = $cat['id']; }
	
	if (isset($ag_cfg_cal_exclude_list_cat) && !empty($ag_cfg_cal_exclude_list_cat)) {$ag_exc_cat = explode($ag_separator[2], $ag_cfg_cal_exclude_list_cat);}
	
	if (!in_array($cat_id, $ag_exc_cat)) {
	
	// cat off date
$cat_off_date = '2000-01-01';
if (!empty($ag_off_date)) {
$obj_off_day = date('d');
$obj_off_month = date('m');
$obj_off_year = date('Y');
$cat_off_date_a = explode('.', $ag_off_date);
if (isset($cat_off_date_a[0])) { $obj_off_day = $cat_off_date_a[0]; }
if (isset($cat_off_date_a[1])) { $obj_off_month = $cat_off_date_a[1]; }
if (isset($cat_off_date_a[2])) { $obj_off_year = $cat_off_date_a[2]; }
$ag_off_date = $obj_off_year.'-'.$obj_off_month.'-'.$obj_off_day;
}
$cat_off_date = date("Y-m-d", strtotime($ag_off_date));


if (!empty($cat_id)) {

$ag_db_file = $ag_data_dir.'/object/'.$cat_id.$agt;
$ag_data = ag_read_data($ag_db_file); 
$ag_data = array_reverse($ag_data, true); //inverse data lines

//actual && on items
$ag_data_a = array();
$num_obj = 0;
foreach ($ag_data as $n => $val) { 
// off date
$obj_off_date = 0;
if (!empty($ag_off_date)) {
	
//obj info
$obj_info_arr = array();
$obj_changed_arr = array();
$obj_info_str = '';
if (isset($val['added'])) { $obj_info_arr = explode('::', $val['added']); }
if (isset($val['changed'])) { $obj_changed_arr = explode('::', $val['changed']); }

$obj_add_day = '01';
$obj_add_month = '01';
$obj_add_year = '2000';
$obj_add_time = '';
$obj_add_staff = '';
$obj_add_staff_mail = '';
$obj_link = '';
$obj_back_link = '';
$obj_back_link_text = '';

$obj_e_day = '01';
$obj_e_month = '01';
$obj_e_year = '2000';
$obj_e_time = '00:00:00';

if (isset($obj_changed_arr[0])) { $obj_e_day = $obj_changed_arr[0]; }
if (isset($obj_changed_arr[1])) { $obj_e_month = $obj_changed_arr[1]; }
if (isset($obj_changed_arr[2])) { $obj_e_year = $obj_changed_arr[2]; }
if (isset($obj_changed_arr[3])) { $obj_e_time = $obj_changed_arr[3]; }

if (isset($obj_info_arr[0])) { $obj_add_day = $obj_info_arr[0]; }
if (isset($obj_info_arr[1])) { $obj_add_month = $obj_info_arr[1]; }
if (isset($obj_info_arr[2])) { $obj_add_year = $obj_info_arr[2]; }
if (isset($obj_info_arr[3])) { $obj_add_time = $obj_info_arr[3]; }
if (isset($obj_info_arr[4])) { $obj_add_staff = $obj_info_arr[4]; }	

$ag_add_date = $obj_add_year.'-'.$obj_add_month.'-'.$obj_add_day;


$obj_add_date = date("Y-m-d", strtotime($ag_add_date));




if ($cat_off_date > $obj_add_date) { $obj_off_date = 1; }

}// off date

if (isset($val['status']) && $val['status'] == 1 && $obj_off_date == 0) { $num_obj++; $ag_data_a[$num_obj] = $val; }

}//foreach ag_data actual && on items


$num_obj_a = 0;
$n = 0;
$val = array();
foreach ($ag_data_a as $n => $val) { 

$num_obj_a++;

$ag_obj_alias = '1';
$ag_obj_id = '1';
$obj_title = '';

if (isset($val['alias'])) { $ag_obj_alias = $val['alias']; }
if (isset($val['id'])) { $ag_obj_id = $val['id']; }
if (isset($val['title'])) { $obj_title = $val['title']; }

//obj info
$obj_info_arr = array();
$obj_changed_arr = array();
$obj_info_str = '';
if (isset($val['added'])) { $obj_info_arr = explode('::', $val['added']); }
if (isset($val['changed'])) { $obj_changed_arr = explode('::', $val['changed']); }

$obj_add_day = '';
$obj_add_month = '';
$obj_add_year = '';
$obj_add_time = '';

$obj_link = '';
$obj_back_link = '';

$obj_e_day = '01';
$obj_e_month = '01';
$obj_e_year = '2000';
$obj_e_time = '00:00:00';



if (isset($obj_changed_arr[0])) { $obj_e_day = $obj_changed_arr[0]; }
if (isset($obj_changed_arr[1])) { $obj_e_month = $obj_changed_arr[1]; }
if (isset($obj_changed_arr[2])) { $obj_e_year = $obj_changed_arr[2]; }
if (isset($obj_changed_arr[3])) { $obj_e_time = $obj_changed_arr[3]; }

//if (strpos($obj_e_month, '0') === false) {} else {$obj_e_month = $obj_e_month[1];}


if (isset($obj_info_arr[0])) { $obj_add_day = $obj_info_arr[0]; }
if (isset($obj_info_arr[1])) { $obj_add_month = $obj_info_arr[1]; }
if (isset($obj_info_arr[2])) { $obj_add_year = $obj_info_arr[2]; }
if (isset($obj_info_arr[3])) { $obj_add_time = $obj_info_arr[3]; }
if (isset($obj_info_arr[4])) { $obj_add_staff = $obj_info_arr[4]; }

$ag_post_date = $obj_add_year.'-'.$obj_add_month .'-'.$obj_add_day;
$fdate = date('Y-m-d', strtotime($ag_post_date));
$obj_link = '?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$ag_obj_alias;

if ($date == $fdate) {
$return_obj[] = array('date' => $fdate, 'title' => $obj_title, 'link' => $obj_link);
}

}


	
}// !empty($ag_db_file)
	
	
	}// status cat

	}// exclude cat

	}// foreach ag_cat

return $return_obj;
	
}// ag_obj_calendar
	







function ag_pub_calendar() { 

global $ag_lng;
global $ag_lng_monts;
global $ag_lng_days_short;
global $ag_this_url;
global $ag_cfg_theme;
global $srv_absolute_url;

$ag_obj_cal = array();

  $month_names = $ag_lng_monts;
  
  if (isset($_POST['ag_y'])) $y = $_POST['ag_y'];
  if (isset($_POST['ag_n'])) $m = $_POST['ag_m']; 
  
  if (isset($_POST['ag_date'])) { list($y, $m) = explode ('-', $_POST['ag_date']); }
  
  if (!isset($y) OR $y < 1970 OR $y > 2037) $y = date("Y");
  if (!isset($m) OR $m < 1 OR $m > 12) $m = date("m");

  $month_stamp = mktime(0, 0, 0, $m, 1, $y);
  $day_count = date("t", $month_stamp);
  $weekday = date("w", $month_stamp);
  if ($weekday == 0) $weekday = 7;
  $start =- ($weekday - 2);
  $last=($day_count+$weekday-1) % 7;
  if ($last == 0) $end = $day_count; else $end = $day_count + 7 - $last;
  $today = date('Y-m-d');
  $prev = date('Y-m', mktime (0,0,0,$m-1,1,$y));  
  $next = date('Y-m', mktime (0,0,0,$m+1,1,$y));
  $i = 0;


$ag_wgt_pub_cal = '<table>';
$ag_wgt_pub_cal .= '<thead>';
$ag_wgt_pub_cal .= '<tr class="ag_top_cal">';
$ag_wgt_pub_cal .= '<td class="ag_pc_prev"><span class="'.$prev.'" onclick="ag_month_pc(this)" tabindex="-1"><i class="icon-left-open-big"></i></span></td>';
$ag_wgt_pub_cal .= '<td colspan="5"><span>'.$ag_lng_monts[$m].' '.$y.'</span></td>';
$ag_wgt_pub_cal .= '<td class="ag_pc_next"><span class="'.$next.'" onclick="ag_month_pc(this)" tabindex="-1"><i class="icon-right-open-big"></i></span></td>';
$ag_wgt_pub_cal .= '</tr>';

$ag_wgt_pub_cal .= '<tr>
<td><span>'.$ag_lng_days_short['1'].'</span></td>
<td><span>'.$ag_lng_days_short['2'].'</span></td>
<td><span>'.$ag_lng_days_short['3'].'</span></td>
<td><span>'.$ag_lng_days_short['4'].'</span></td>
<td><span>'.$ag_lng_days_short['5'].'</span></td>
<td><span>'.$ag_lng_days_short['6'].'</span></td>
<td><span>'.$ag_lng_days_short['0'].'</span></td>
</tr>';
$ag_wgt_pub_cal .= '</thead>';
 

$ag_wgt_pub_cal .= '<tbody>';

  for($d = $start; $d <= $end; $d++) { 
    if (!($i++ % 7)) $ag_wgt_pub_cal .= '<tr>';
	
	
	$fdate = date('Y-m-d', strtotime($y.'-'.$m.'-'.$d));
	$ag_td_pc_class = '';
	if($fdate == $today) {$ag_td_pc_class = ' ag_pc_today';}

// objects	
$list_obj = '';
$ag_obj_cal = ag_obj_calendar($fdate);
if (!empty($ag_obj_cal)) {
$list_obj = '<ul class="ag_obj_cal">';
foreach ($ag_obj_cal as $obj) {
$list_obj .= '<li><a href="'.$obj['link'].'"><i class="icon-right-open-mini"></i><strong>'.$obj['title'].'</strong></a></li>';	
}// foreach ag_obj_cal
$list_obj .= '</ul>';
}	

// objects	
 if (!empty($list_obj)) {$ag_td_pc_class .= ' ag_pc_event';}
 
   // $ag_wgt_pub_cal .= '<td class="ag_pc_date'.$ag_td_pc_class.'" tabindex="-1" onclick="ag_view_pc(this)">';
	
    if ($d < 1 OR $d > $day_count) {
	  $ag_wgt_pub_cal .= '<td class="ag_pc_date">';
      $ag_wgt_pub_cal .= '<span>&nbsp;</span>';
    } else {
      $now = "$y-$m-".sprintf("%02d", $d);
	  $date_event_class = '';
        $ag_wgt_pub_cal .= '<td class="ag_pc_date'.$ag_td_pc_class.'" tabindex="-1" onclick="ag_view_pc(this)">';
        $ag_wgt_pub_cal .= '<span class="ag_pc_day">'.$d.'</span>';
		$ag_wgt_pub_cal .= $list_obj;
      
    } 
	
    $ag_wgt_pub_cal .= '</td>';
	
	
    if (!($i % 7))  $ag_wgt_pub_cal .= '</tr>';
  } 
$ag_wgt_pub_cal .= '</tbody>';

$ag_wgt_pub_cal .= '<tfoot>';
$ag_wgt_pub_cal .= '<tr class="ag_period_pc">
<td colspan="1"><span class="ag_pc_sub" onclick="ag_today_pc(this)"><i class="icon-left-open-big"></i></span></td>
<td colspan="3">
<span>
<select class="ag_pc_month_select">';
foreach ($ag_lng_monts as $km => $vm) {
if ($vm != '?') {
$ag_cal_pub_selected = '';
if ($km == $m) { $ag_cal_pub_selected = ' selected="selected"'; }
$ag_wgt_pub_cal .= '<option value="'.$km.'"'.$ag_cal_pub_selected.'>'.$vm.'</option>';
}
}
$ag_wgt_pub_cal .= '</select>
</span>
</td>
<td colspan="2"><span><input type="number" value="'.$y.'" class="ag_pc_year_select" min="0" max="9999" size="4"></span></td>
<td colspan="1"><span class="ag_pc_sub" onclick="ag_period_pc(this)"><i class="icon-right-open-big"></i></span></td>
</tr>';
$ag_wgt_pub_cal .= '</tfoot>';

$ag_wgt_pub_cal .= '</table>';


$ag_wgt_pub_cal .= '<script>';
$ag_wgt_pub_cal .= '
$(function() {
$(".ag_pub_calendar").find("table tbody tr td").each(function(e) {
if ($(this).find("ul.ag_obj_cal").length) {

var ag_n_td = $(this).index();
var ag_n_text = $(this).find("span").text();

var ag_pc_list = $(this).find("ul.ag_obj_cal").html();
$(this).find("ul.ag_obj_cal").css({display:"none"});
$(this).closest(".ag_pub_calendar").append(\'<div class="ag_obj_cal_view ag_event_cal_\'+ ag_n_text +\'\'+ ag_n_td +\'" style="opacity:0;"><div class="ag_pc_arrow"></div><ul>\' + ag_pc_list + \'</ul></div>\');
}

});
});

function ag_close_pc() {
$("div.ag_obj_cal_view").stop().animate({opacity: "0"}, 200);	
setTimeout(function() { $("div.ag_obj_cal_view").css({display:"none", top:"100%", opacity: "0"}); }, 250);
}

function ag_view_pc(el) { 

if ($(el).find("ul.ag_obj_cal").length) {
	
var ag_table_pc_w = $(el).closest("table").outerWidth(true) - 16;
var ag_td_pc_h = $(el).outerHeight(true);

var ag_n_td = $(el).index();
var ag_n_text = $(el).find("span").text();

if ($(el).closest(".ag_pub_calendar").find("div.ag_event_cal_" + ag_n_text + ag_n_td).css("display") == "none") {

$("div.ag_obj_cal_view").stop().css({ display: "none", top: "100%", opacity: "0" });

var ag_pc_td_w = $(el).outerWidth(true);
var ag_pc_td_pl = $(el).position().left - $(el).closest("table").position().left + (ag_pc_td_w / 2) - 8 - 10;
var ag_pc_td_pt = $(el).position().top - $(el).closest("table").position().top + ag_td_pc_h;	
$(el).closest(".ag_pub_calendar").find("div.ag_event_cal_" + ag_n_text + ag_n_td).css({display: "block", width: ag_table_pc_w + "px", maxWidth: ag_table_pc_w + "px", left: "8px"});
$(el).closest(".ag_pub_calendar").find("div.ag_event_cal_" + ag_n_text + ag_n_td + " div.ag_pc_arrow").css({left: "" + ag_pc_td_pl + "px"});
$("div.ag_event_cal_" + ag_n_text + ag_n_td).stop().animate({top: (ag_pc_td_pt - 1) + "px", opacity: "1"}, 300, "easeInOutQuint");

} else {ag_close_pc();}


}

}

$(document).mouseup(function (e) {
var ag_pc = $(".ag_pub_calendar");
if (!ag_pc.is(e.target) && ag_pc.has(e.target).length === 0) {
ag_close_pc();
}
});

';
$ag_wgt_pub_cal .= '</script>';

return ag_return_html($ag_wgt_pub_cal);

}


if (isset($_POST['ag_date'])) {
echo  ag_pub_calendar();
}

?>