<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header('Content-type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
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
include ('inc/db_booking.php');

if(!isset($ag_get_schedule)) {$ag_get_schedule = 'schedule';}
$ag_service = '';
$ag_get_day = '';
foreach ($_GET as $g_key => $g_val) {
$_GET[$g_key] = htmlspecialchars($_GET[$g_key], ENT_QUOTES, 'UTF-8');	
}
if (isset($_GET['id'])) {$ag_service = $_GET['id'];} //else {die();}
if (isset($_GET['day'])) {$ag_get_day = $_GET['day'];} //else {die();}

$ag_this_date = date("Y-m-d");
$ag_this_time = date("H:i");

$ag_year = date("Y");
$ag_month = date("m");
$ag_day = date("d");

if (isset($_GET['year']) && !empty($_GET['year']) && isset($_GET['month']) && !empty($_GET['month'])) {
$ag_year = $_GET['year'];
$ag_month = $_GET['month'];	
}
if (isset($_GET['day']) && !empty($_GET['day'])) {
$ag_day = $_GET['day'];	
}
if ($ag_month > 12 || (int)$ag_month <= 0) {$ag_month = '01';}
if ($ag_day > 31 || (int)$ag_day <= 0) {$ag_day = '01';}
if (strlen($ag_year) > 4 || (int)$ag_year <= 0) {$ag_year = date("Y");}

$ag_hour = date("H");
$ag_minutes = date("i");

$ag_head_html = '<!DOCTYPE html>';
$ag_head_html .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$ag_lng_value.'" lang="'.$ag_lng_value.'">';
$ag_head_html .= '<head>';
$ag_head_html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$ag_head_html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
$ag_head_html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
$ag_head_html .= '<title>'.$ag_lng['orders_schedule'].' - '.$ag_cfg_title.'</title>';
$ag_head_html .= '<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />';
$ag_head_html .= '<link rel="stylesheet" href="css/main.css" />';
$ag_head_html .= '<link rel="stylesheet" href="css/icons/fontello.css" />';
$ag_head_html .= '<link rel="stylesheet" href="css/icons/animation.css" />';
$ag_head_html .= '<link rel="stylesheet" href="css/schedule.css" />';
$ag_head_html .= '<script src="js/jquery-2.1.1.js"></script>';
$ag_head_html .= '<script src="js/detect.min.js"></script>';
$ag_head_html .= '</head>';
$ag_head_html .= '<body>';
$ag_head_html .= '<div id="ag_main">';
$ag_head_html .= '<div id="ag_schedule">';

$ag_footer_html = '</div>'; //ag_schedule
$ag_footer_html .= '</div>'; //ag_main
$ag_footer_html .= '</body>';
$ag_footer_html .= '</html>';




$ag_get_per_m = $ag_month;
$ag_get_per_y = $ag_year;

$ag_link_nm = (int)$ag_get_per_m + 1; 
$ag_link_ny = $ag_get_per_y;
if ($ag_link_nm == 13) {$ag_link_nm = 1; $ag_link_ny = $ag_get_per_y + 1;}
if ($ag_link_nm < 10) {$ag_link_nm = '0'.$ag_link_nm;}

$ag_link_pm = (int)$ag_get_per_m - 1;
$ag_link_py = $ag_get_per_y;
if ($ag_link_pm == 0) {$ag_link_pm = 12; $ag_link_py = $ag_get_per_y - 1;}
if ($ag_link_pm < 10) {$ag_link_pm = '0'.$ag_link_pm;}	






//select period html
$ag_id_url = '?';
if (isset($_GET['id']) && !empty($_GET['id'])) {$ag_id_url = '?id='.$_GET['id'].'&amp;';}
$ag_top_order = '<div class="ag_orders_tools">';


$ag_top_order .= '<div class="ag_order_period">';
$ag_top_order .= '<div class="ag_prev_month"><a href="'.$ag_id_url.'month='.$ag_link_pm.'&amp;year='.$ag_link_py.'" title="'.$ag_lng_monts[$ag_link_pm].' '.$ag_link_py.'"><i class="icon-left-open-big"></i></a></div>';

$oper_class = '';

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
if (isset($_GET['month']) && $_GET['month'] != date('m') || isset($_GET['year']) && $_GET['year'] != date('Y')) {
$ag_to_curr_m = '<a href="'.$ag_id_url.'month='.date('m').'&amp;year='.date('Y').'" title="'.$ag_lng['to_current_month'].'" id="ag_per_butt"><i class="icon-calendar-check-o"></i></a>';
}
$ag_top_order .= '<div class="ag_current_month">'.$ag_to_curr_m.'</div>';

$ag_top_order .= '<div class="ag_next_month"><a href="'.$ag_id_url.'month='.$ag_link_nm.'&amp;year='.$ag_link_ny.'" title="'.$ag_lng_monts[$ag_link_nm].' '.$ag_link_ny.'"><i class="icon-right-open-big"></i></a></div>';

$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';
//select period


//select service
$ag_services = array();

$ag_mopt_serv = '';
$ag_opt_serv = '<li tabindex="-1" data-option="" onclick="ag_service_change(this)">'.$ag_lng['view_all_services'].'</li>';
if (file_exists($ag_data_dir.'/service'.$agt)) {$ag_services = ag_read_data($ag_data_dir.'/service'.$agt);}
foreach ($ag_services as $serv) {
if (isset($serv['id']) && isset($serv['title'])) {
$ag_opt_serv .= '<li tabindex="-1" data-option="'.$serv['id'].'" onclick="ag_service_change(this)">'.$serv['title'].'</li>';
$ag_mopt_serv .= '{"id": "'.$serv['id'].'", "name": "'.$serv['title'].'"},';
}
}

if (!empty($ag_mopt_serv)) {
if ($ag_mopt_serv{strlen($ag_mopt_serv) - 1} == ',') {$ag_mopt_serv = substr($ag_mopt_serv, 0, -1);}
$ag_mopt_serv = '[{"id": "","name": "'.$ag_lng['view_all_services'].'"},'.$ag_mopt_serv.']';
} else {$ag_mopt_serv = '[{}]';}


if (!isset($_GET['id']) || isset($_GET['id']) && empty($_GET['id'])) {
$ag_top_order .= '<div class="ag_select">';
$ag_top_order .= '<div class="ag_order_service_select">';
$ag_top_order .= '<div class="ag_count_opt" tabindex="-1" onclick="ag_order_serv(this)"><span id="ag_title_select">'.$ag_lng['view_all_services'].'</span></div>';
$ag_top_order .= '</div>';
$ag_top_order .= '</div>';
}
//select service



$ag_num_url = '?';
if (isset($_GET['id']) && !empty($_GET['id'])) {$ag_num_url = '?id='.$_GET['id'].'&amp;';} 
if (isset($_GET['month']) && !empty($_GET['month']) && isset($_GET['year']) && !empty($_GET['year'])) {$ag_num_url = $ag_num_url.'month='.$_GET['month'].'&amp;year='.$_GET['year'].'';}

if (!isset($_GET['day']) || isset($_GET['day']) && empty($_GET['day'])) {
$ag_top_order .= '<button class="ag_tool_btn" id="ag_reset_table" onclick="ag_reset_day(\''.$ag_num_url.'\')">'.$ag_lng['back'].'</button>';
}

$ag_top_order .= '<div class="clear"></div>';
$ag_top_order .= '</div>';

// times
$ag_this_time = date("H:i", strtotime(date("H:i")));




// dates
$ag_table_tr = '';
$ag_count_days = date("t", strtotime($ag_year.'-'.$ag_month));
for ($d = 0; $d < $ag_count_days; ++$d) { 
$day = $d + 1;
if ($day < 10) {$day = '0'.$day;}
$ag_tr_class = 'ag_date';
if ((int)$ag_year <= (int)date('Y') && (int)$ag_month <= (int)date('m') && (int)$day < (int)$ag_day) {$ag_tr_class .= ' ag_past_date';}
if ((int)$ag_year <= (int)date('Y') && (int)$ag_month < (int)date('m') || (int)$ag_year < (int)date('Y')) {$ag_tr_class .= ' ag_past_date';}
if ((int)$ag_year == date('Y') && (int)$ag_month == (int)date('m') && $day == $ag_day) {$ag_tr_class .= ' ag_today_date';}


$ag_table_td = '';
for ($s = 0; $s < 24; ++$s) {
if ($s < 10) {$s = '0'.$s;}
$ag_td_class = 'ag_time';
if ((int)$ag_year == (int)date('Y') && (int)$ag_month == (int)date('m') && (int)$day == (int)$ag_day && (int)$s < (int)$ag_hour) {$ag_td_class .= ' ag_past_time';}
if ((int)$ag_year <= (int)date('Y') && (int)$ag_month <= (int)date('m') && (int)$day < (int)$ag_day) {$ag_td_class .= ' ag_past_time';}
if ((int)$ag_year <= (int)date('Y') && (int)$ag_month < (int)date('m') || (int)$ag_year < (int)date('Y')) {$ag_td_class .= ' ag_past_time';}
$ag_table_td .= '<td class="'.$ag_td_class.'" data-time="'.$s.'" tabindex="-1"><div class="ag_td_inner"><span class="ag_time_point">'.$s.'</span><div class="ag_schedule_order"></div></div></td>';	
}

/*
if ($ag_year == date('Y') && $ag_month == date('m')) {
if ((int)$day >= (int)$ag_day) {
$ag_table_tr .= '<tr class="'.$ag_tr_class.'" data-date="'.$ag_year.'-'.$ag_month.'-'.$day.'"><td class="ag_num_day"><span>'.$day.'</span></td>'.$ag_table_td.'</tr>';
}
} else {
$ag_table_tr .= '<tr class="'.$ag_tr_class.'" data-date="'.$ag_year.'-'.$ag_month.'-'.$day.'"><td class="ag_num_day"><span>'.$day.'</span></td>'.$ag_table_td.'</tr>';	
}
*/

$ag_week_day = date("w", mktime(0, 0, 0, $ag_month, $day, $ag_year));

$ag_table_tr .= '<tr class="'.$ag_tr_class.'" data-date="'.$ag_year.'-'.$ag_month.'-'.$day.'"><td class="ag_num_day" tabindex="-1" onclick="ag_day_details(this, \''.$ag_num_url.'&amp;day='.$day.'\', \''.$day.'\')"><div class="ag_td_inner"><span><strong>'.$day.'</strong> <small>'.$ag_lng_days_short[$ag_week_day].'</small></span></div></td>'.$ag_table_td.'</tr>';

}// ag_count_days



$ag_table_html = '<div class="ag_mob_table">'.$ag_top_order.'<table class="ag_schedule_table"><tbody>';
$ag_table_html .= $ag_table_tr;
$ag_table_html .= '</tbody></table></div>';



if (!empty($srv_absolute_url)) {
if ($srv_absolute_url{strlen($srv_absolute_url) - 1} == '/') {$srv_absolute_url = substr($srv_absolute_url, 0, -1);}
}



$ag_js = '

<div id="agWait"><div><i class="icon-spin2 animate-spin"></i></div></div>
<script>

function ag_nn(n) {
if (n < 10)	{n = "0" + n;}
return n;
}

var ag_table_tr = $(".ag_schedule_table tbody tr");

var ag_get_year = new Date().getFullYear();
var ag_get_month = ag_nn(new Date().getMonth() + 1);
var ag_get_day = ag_nn(new Date().getDate());
var ag_get_hour = "'.date('H').'";
var ag_get_minute = "'.date('i').'";
var ag_get_second = "'.date('s').'";



function ag_time() {


$.getJSON("'.$srv_absolute_url.'/inc/ag_time.php", function(time) { 

ag_get_day = time.day,
ag_get_month = time.month,
ag_get_year = time.year,
ag_get_hour = time.hour,
ag_get_minute = time.minute,	
ag_get_second = time.second


});


var res = {
day: ag_get_day,
month: ag_get_month,
year: ag_get_year,
hour: ag_get_hour,
minute: ag_get_minute,	
second: ag_get_second
};	

return res;

}

function ag_responsitive() {
var res = {};
var ag_min_width = 800;
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

if (ag_win_width < ag_min_width) {
$("#ag_main").addClass("agMainMobile");
} else {
$("#ag_main").removeClass("agMainMobile");
}


res = {
width: ag_win_width,
height: ag_win_height,
minWidth: ag_min_width
};
return res;
}

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


var ag_ua = detect.parse(navigator.userAgent);
var ag_browser = ag_ua.browser.family;
/*alert(ag_browser);*/



function ag_scale(day, s_hour, s_minuts, e_hour, e_minuts, tcount) { 
var res = {};

var bb = false;
if (ag_browser == "Firefox" || ag_browser == "IE" || ag_browser == "Edge") {bb = true;}

var ag_time_style = \'\';
var left_pos = 0;
var div_scale = \'\';
var teq = parseFloat(day) - 1;



var h_day = (tcount * 32) + 320;
$("#AgDayDetails div.ag_inner_day").css({minHeight: h_day + "px"});


ag_table_tr.eq(teq).find("td").addClass("ag_td_scale");


var tr = ag_table_tr.eq(teq);
var tr_w = ag_table_tr.eq(teq).outerWidth(true);
var ww = ag_responsitive().width;
var hw = ag_responsitive().height;
var ws = $("#ag_schedule").outerHeight(true);

var offset_l = 16;


if (tr_w > ww) {
	
	
	if (hw < ws) {
	offset_l = 16;
	} else {
    offset_l = 16;
    offset_l = offset_l;	
	}
	
	
    } else {
		
		
if (hw < ws) {
	ww = ww - ag_getScrollBarWidth();
	offset_l = (ww - tr_w)/2;
	} else {
	offset_l = (ww - tr_w)/2;
    offset_l = offset_l;	
	}
}
 


var left_pos = 0;
var ow = 26;


for (var i = 0; i < tr.find("td").length; i++) {

var td_w = tr.find("td").eq(i).outerWidth(true);
var div_scale_style = \'\';


var ds_w = td_w;
if (bb) {ds_w = (tr_w / tr.find("td").length);}
if (i == 0) { ds_w = td_w - 1; } else {}

div_scale_style = \' style="width:\' +ds_w+ \'px;max-width:\' +ds_w+ \'px;min-width:\' +ds_w+ \'px;"\';
div_scale += \'<div class="ag_div_scale"\'+div_scale_style+\'></div>\';

/*bad browsers*/
/*if (bb) {div_scale = \'\';}*/

left_pos = tr.find("td").eq(i).offset().left - offset_l;

/*width*/
/*ow = td_w;*/
/*s_hour, s_minuts, e_hour, e_minuts*/
var sih = parseFloat(s_hour);
var m_sta = (td_w / 60) * s_minuts;
var m_end = (td_w / 60) * e_minuts;
var min_pos = m_end - m_sta;

ow = e_hour - sih;
if (ow <= 0) {ow = 1;}
ow = ow * td_w;
ow = ow + min_pos;


left_pos = left_pos + m_sta;

/*p_test = \'sta:\' +s_minuts+ \'; end:\' +e_minuts;*/

if (s_hour && tr.find("td").eq(i).attr("data-time") == s_hour) {
ag_time_style = {left: left_pos, width: ow};
}

}


div_scale = div_scale + \'<div class="ag_clear"></div>\';	

res = {
scale: div_scale,
style: ag_time_style	
};
return res;
}





function ag_table_pre(day) {

ag_responsitive();

var ag_colspan = 0;
ag_colspan = ag_table_tr.eq(0).find("td").length;	
	

$(".ag_schedule_order").html("");
$(".ag_time").removeClass("ag_order_td");
$(".ag_time_point").removeClass("ag_order_point");
$("#AgDayDetails").remove();
$(".ag_day_details").remove();
$(".ag_td_inner").removeClass("ag_td_scale");
$(".ag_day_details_bottom").remove();
$("td").removeClass("ag_day_this_time");
	

if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") { 
$("table.ag_schedule_table tbody").append(\'<tr class="ag_day_details"><td colspan="\'+ag_colspan+\'" id="AgDayDetails"><div class="ag_inner_day"><div class="ag_scale"><div class="ag_inner_scale"></div></div></div></td></tr>\');
$("#ag_reset_table").fadeIn(300);
} else {
$("#ag_reset_table").fadeOut(300);
}	
	

var dmy = ag_time().year + "-" + ag_time().month + "-" + ag_time().day;
var dt = new Date(dmy);		
	
for (var tr = 0; tr < ag_table_tr.length; tr++) {
	
var dtr = ag_table_tr.eq(tr).attr("data-date");
var dl = new Date(dtr);

		
if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") {
	
if ((tr + 1) != parseFloat(day)) { ag_table_tr.eq(tr).hide(); } 

for (var td = 0; td < ag_table_tr.eq(tr).find("td").length; td++) { 
var td_t = parseFloat(ag_table_tr.eq(tr).find("td").eq(td).attr("data-time"));	
var tt = parseFloat(ag_time().hour);

if (dtr == dmy && tt > td_t) { 
ag_table_tr.eq(tr).find("td").eq(td).addClass("ag_past_time"); 
ag_table_tr.eq(tr).find("td").eq(td).removeClass("ag_day_this_time"); 
}

if (dtr == dmy) {
if (tt == td_t)	{
ag_table_tr.eq(tr).find("td").eq(td).addClass("ag_day_this_time"); 
} else { ag_table_tr.eq(tr).find("td").eq(td).removeClass("ag_day_this_time");}
} else { ag_table_tr.eq(tr).find("td").eq(td).removeClass("ag_day_this_time");}
}

} else {
	
ag_table_tr.eq(tr).show();



if (tr > 16) {ag_table_tr.eq(tr).find("td div.ag_schedule_order").addClass("ag_schedule_order_top");} else {ag_table_tr.eq(tr).find("td div.ag_schedule_order").removeClass("ag_schedule_order_top");} 

for (var td = 0; td < ag_table_tr.eq(tr).find("td").length; td++) { 
if (td > 12) {ag_table_tr.eq(tr).find("td").eq(td).find("div.ag_schedule_order").addClass("ag_schedule_order_right");} else {ag_table_tr.eq(tr).find("td").eq(td).find("div.ag_schedule_order").removeClass("ag_schedule_order_right");}



var td_t = parseFloat(ag_table_tr.eq(tr).find("td").eq(td).attr("data-time"));	
var tt = parseFloat(ag_time().hour);
if (dtr == dmy && tt > td_t) { ag_table_tr.eq(tr).find("td").eq(td).addClass("ag_past_time"); } 



if (dtr == dmy) {
if (tt == td_t)	{
ag_table_tr.eq(tr).find("td").eq(td).addClass("ag_day_this_time"); 
} else { ag_table_tr.eq(tr).find("td").eq(td).removeClass("ag_day_this_time");}
}


}


}
	
}



}







var ag_services = '.$ag_mopt_serv.';
var ag_select_service = "";
var ag_select_day = "";


function ag_get_schedule(service, day) { 


$("#agWait").fadeIn(250);


$(".ag_schedule_order").html("");
$(".ag_time").removeClass("ag_order_td");
$(".ag_time_point").removeClass("ag_order_point");
$(".ag_day_details").remove();
$(".ag_td_inner").removeClass("ag_td_scale");
$(".ag_day_details_bottom").remove();



if (!service) {service = "";}
var get_service = \''.$ag_service.'\';
if (get_service != "") {service = get_service;}

if (!day) {day = "";}
var get_day = \''.$ag_get_day.'\';
if (get_day && get_day != "" && get_day != 0) {day = parseFloat(get_day); if (day < 10) {day = "0" + day;}}

ag_select_service = service;
ag_select_day = day;


/*alert(ag_time().day+"/"+ag_time().month+"/"+ag_time().year+" "+ag_time().hour+":"+ag_time().minute+":"+ag_time().second);*/
	
var ag_year = "'.$ag_year.'";
var ag_month = "'.$ag_month.'";
var ag_day = "'.$ag_day.'";

var ag_h = ag_time().hour;
var ag_m = ag_time().minute;
var ag_s = ag_time().second;

var s_day = "00";
var s_month = "00";
var s_year = "0000";

var s_hour = "";
var s_minuts = "";

var e_hour = "";
var e_minuts = "";



$.getJSON("'.$srv_absolute_url.'/inc/ag_orders.php?id="+service+"&year="+ag_year+"&month="+ag_month+"&day="+day, function(data) { 

$("#AgDayDetails").remove();
$(".ag_day_details").remove();
$(".ag_time").removeClass("ag_td_scale");
$(".ag_day_details_bottom").remove();

ag_table_pre(day);

var ag_order_day = \'\';
var ag_tcount = 0;

if (data) { 
ag_tcount = data.length;




for (var i in data) { 
	
var s_date_a = data[i].date.split("-");
s_year = s_date_a[0];
s_month = s_date_a[1];
s_day = s_date_a[2];

if (s_year == ag_year && s_month == ag_month) { 

var s_time_a = data[i].time.split(":");
s_hour = s_time_a[0];
s_minuts = parseFloat(s_time_a[1]);

var e_time_a = data[i].timeEnd.split(":");
e_hour = parseFloat(e_time_a[0]);
e_minuts = parseFloat(e_time_a[1]);

var ag_order_info = \'\';
var ag_order = \'\';


if (parseFloat(data[i].spots) > 1) {data[i].spots = \' <i class="icon-right-open-mini"></i><i class="icon-male-2"></i> <strong>\'+data[i].spots+\'</strong>\';} else {data[i].spots = \'\';}


var ag_num_order = \'\';
if (data[i].number) {ag_num_order = \' <i class="icon-bell-4"></i> <span class="ag_open_order" onclick="ag_open_order(\'+data[i].number+\')">\'+data[i].number+\'</span>\';}

if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") {
ag_order_info += \'<li><span><i class="icon-clock-7"></i> \'+data[i].time+\' - \'+data[i].timeEnd+\'\'+ag_num_order+\'</span></li>\'; 
ag_order_info += \'<li><span><i class="icon-calendar"></i> \'+data[i].date+\'</span></li>\'; 	
}

 if (data[i].serviceTitle) { ag_order_info += \'<li><span><i class="icon-aperture"></i> \'+data[i].serviceTitle+\'</span></li>\'; }
 if (data[i].price && data[i].currency) {ag_order_info += \'<li><span><i class="icon-money-2"></i> \'+data[i].price+\' \'+data[i].currency+\'\'+data[i].spots+\'</span></li>\';}
 if (data[i].email) { ag_order_info += \'<li><span><i class="icon-mail-2"></i> \'+data[i].email+\'</span></li>\';}
 if (data[i].phone) { ag_order_info += \'<li onclick="ag_copy_text(this)"><span><i class="icon-phone-1"></i> \'+data[i].phone+\'</span></li>\'; }
 if (data[i].name) { ag_order_info += \'<li><span><i class="icon-user-3"></i> \'+data[i].name+\'</span></li>\'; }
 if (ag_order_info != "") {ag_order_info = \'<div class="ag_order_info"><ul>\'+ag_order_info+\'</ul></div>\';}

 
 


var ag_time_style = \'\';
if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") {


ag_order_day += \'<div class="ag_time_orders" tabindex="-1"><div class="ag_inner" tabindex="-1" data-time="\'+s_hour+\':\'+s_minuts+\',\'+e_hour+\':\'+e_minuts+\'"><span><i class="icon-bell-4"></i></span></div>\'+ag_order_info+\'</div>\';	

} else {
ag_order = \'<div class="ag_time_orders" tabindex="-1"><div class="ag_inner"\'+ag_time_style+\'><span><i class="icon-clock-7"></i> \'+data[i].time+\' - \'+data[i].timeEnd+\'\'+ag_num_order+\'</span></div>\'+ag_order_info+\'</div>\';
}
 


for (var tr = 0; tr < ag_table_tr.length; tr++) {
var t_date = ag_table_tr.eq(tr).attr("data-date");


if (t_date == data[i].date) {  
for (var td = 0; td < ag_table_tr.eq(tr).find("td").length; td++) {

var t_time = ag_table_tr.eq(tr).find("td").eq(td).attr("data-time");
 if (t_time == s_hour) { 
 if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") { } else {
 ag_table_tr.eq(tr).find("td").eq(td).addClass("ag_order_td").find(".ag_schedule_order").append(ag_order); 
 ag_table_tr.eq(tr).find("td").eq(td).find("span.ag_time_point").css({display:"none"}).addClass("ag_order_point");
 }
 }
 
}
}/*t_date == s_day*/
}

}/*month & year*/


}/*for data*/





if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") { 

$("#AgDayDetails div.ag_inner_day").append(ag_order_day);


var tcl = 300;
var otime = 120;

$(".ag_time_orders div.ag_inner").each(function(i){ 

(function(i) {
setTimeout(function(){



var this_h = parseFloat(ag_h);	
var this_d = parseFloat(ag_day);	
var sday = parseFloat(day);


var dt = [];	
if ($(".ag_time_orders div.ag_inner").eq(i).attr("data-time")) {
dt = $(".ag_time_orders div.ag_inner").eq(i).attr("data-time").split(",");
}


var hs = 0;
var ms = 0;

var he = 0;
var me = 0;	

if (dt[0] && dt[1]) {
var start = dt[0].split(":");
var end = dt[1].split(":");

hs = start[0];
ms = parseFloat(start[1]);

he = parseFloat(end[0]);
me = parseFloat(end[1]);	
}			
			
		var istyle = ag_scale(day, hs, ms, he, me, ag_tcount).style;
		 $(".ag_time_orders div.ag_inner").eq(i).css({left: istyle.left+"px", width:istyle.width+"px", opacity:"1"});
		 
		 /* ag_order_info */
		 var ag_inf_left = parseFloat(istyle.left) + parseFloat(istyle.width);
		 
		
		 var ihs = parseFloat(hs);
		 var tm = parseFloat(ag_time().month);
		 var ty = parseFloat(ag_time().year);
		 
		 var sm = parseFloat(ag_month);
		 var sy = parseFloat(ag_year);
		 
		 if (he > 12) {
			 var inf_w = $(".ag_time_orders div.ag_inner").eq(i).parent().find(".ag_order_info").outerWidth(true);
			 ag_inf_left = parseFloat(istyle.left) - inf_w;
			 $(".ag_time_orders div.ag_inner").eq(i).parent().find(".ag_order_info").addClass("ag_order_info_left");
			 }
		if (he > 12 && ihs < 5) {
             ag_inf_left = parseFloat(istyle.left);
			 $(".ag_time_orders div.ag_inner").eq(i).parent().find(".ag_order_info").addClass("ag_order_info_bottom");
		}		
		 $(".ag_time_orders div.ag_inner").eq(i).parent().find(".ag_order_info").css({left:ag_inf_left+"px"});
		 
		 
		 if (ty == sy && tm == sm && sday == this_d) {
		 
		 if (this_h == ihs || this_h >= ihs && he > this_h) { $(".ag_time_orders div.ag_inner").eq(i).addClass("ag_current_hour"); }
		
		 if (this_h < ihs) {$(".ag_time_orders div.ag_inner").eq(i).addClass("ag_next_hour");}
		 else {$(".ag_time_orders div.ag_inner").eq(i).removeClass("ag_next_hour");}
		 
		 if (this_h > ihs && this_h >= he) {$(".ag_time_orders div.ag_inner").eq(i).addClass("ag_past_hour");}
		  
		 }
		  
		 if (ty == sy && tm == sm && sday < this_d) {$(".ag_time_orders div.ag_inner").eq(i).addClass("ag_past_hour");} 
		 if (ty > sy || ty >= sy && tm > sm) {$(".ag_time_orders div.ag_inner").eq(i).addClass("ag_past_hour");} 
		   
		  
		  
}, tcl);
tcl = tcl + otime;
		
})(i);


$(".ag_time_orders div.ag_inner").eq(i).click(function() {
			$(".ag_time_orders div.ag_inner").eq(i).parent().find(".ag_order_info").css({opacity:"1", visibility:"visible"});
			$(".ag_time_orders div.ag_inner").removeClass("ag_inner_focused");
            $(".ag_time_orders div.ag_inner").eq(i).addClass("ag_inner_focused");
		 });

});






setTimeout(function(){ 
var div_scale = ag_scale(day, \'\', \'\', \'\', \'\', ag_tcount).scale;
$(".ag_inner_scale").css({display:"none"}).html(div_scale);
}, 250);
setTimeout(function(){ $(".ag_inner_scale").fadeIn(250); }, 300);


var teq = parseFloat(day) - 1;
var scale_bottom = ag_table_tr.eq(teq).html();
$(".ag_schedule_table tbody").append(\'<tr class="ag_date ag_day_details_bottom">\'+scale_bottom+\'</tr>\');


}

setTimeout(function(){ $("span.ag_time_point").fadeIn(300); }, 250);

$(".ag_order_td").click(function() {
if (day && day != "" && day != 0 && day != "0" && day != "00" && day != " ") { } else {
$(".ag_schedule_order").removeAttr("style");
$(".ag_order_td").removeClass("ag_view_order");
$(this).addClass("ag_view_order").find(".ag_schedule_order").css({opacity:"1", visibility:"visible"});	
}
});

} else { /*if data*/
	
}/*no data*/
setTimeout(function(){ $("#agWait").fadeOut(250); }, 250);


}).fail(function(jqXHR, textStatus, errorThrown) { 

$("#agWait").fadeOut(250);

alert(textStatus + \' \' +errorThrown);

});









for (var i in ag_services) {
if (ag_services[i].id == ag_select_service) { $("#ag_title_select").text(ag_services[i].name); }
}	



}/*get json*/





function ag_day_details(e, url, sday) {
ag_get_schedule(ag_select_service, sday);
}


function ag_reset_day(url) {
/*window.location = url;*/
ag_get_schedule(\'\', \'\');
/*ag_select_service = "";*/
ag_select_day = "";
$("#ag_reset_table").fadeOut(300);
}






var ag_trig_oc = 0;
function ag_order_serv(e){
	ag_trig_oc++;
	$(".ag_order_service_select").find("ul.ag_list_options").remove();
	var sopt = \'\';
	sopt += \'<ul class="ag_list_options">\';
	sopt += \''.$ag_opt_serv.'\';
	sopt += \'</ul>\';
	$(e).parents(".ag_order_service_select").append(sopt);
	$(e).parents(".ag_order_service_select").find("ul.ag_list_options").fadeIn(250);
	if(ag_trig_oc > 1){
		setTimeout(function(){$(e).parents(".ag_order_service_select").find("ul.ag_list_options").remove();},50);
		ag_trig_oc = 0;
		}
	}
	
	
	function ag_service_change(e) {
	var serv_id = $(e).attr("data-option");
	var serv_name = $(e).text();
	$("#ag_title_select").text(serv_name);
	$(".ag_order_service_select").find("ul.ag_list_options").fadeOut(250);
	ag_get_schedule(serv_id, ag_select_day);
	}






function ag_copy_text(e) {
var text = $(e).text();
 
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
';

$ag_id_per_url = str_replace('&amp;', '', $ag_id_url);

$ag_js .= '
function ag_sub_per(num) {
if (num < 10) {num = "0"+num;}
var soyear = $("#ag_select_year").val();
window.location = "'.$ag_id_per_url.'&month="+num+"&year="+soyear;	
}


$(document).mouseup(function (e) {

var ag_oper = $(".ag_select_month");
if (!ag_oper.is(e.target) && ag_oper.has(e.target).length === 0) {	
ag_select_month(0, $(".ag_select_month"));
}
var ag_vo = $(".ag_order_info");
if (!ag_vo.is(e.target) && ag_vo.has(e.target).length === 0) {	
$(".ag_schedule_order").removeAttr("style");
$(".ag_order_td").removeClass("ag_view_order");
}

var ag_opt = $(".ag_list_options");
if(!ag_opt.is(e.target) && ag_opt.has(e.target).length===0){
$(".ag_select").find("ul").fadeOut(200); ag_trig_oc = 0;
}


var ag_dinf = $("#AgDayDetails").find(".ag_order_info");
if(!ag_dinf.is(e.target) && ag_dinf.has(e.target).length===0){
$("#AgDayDetails").find(".ag_order_info").css({opacity:"0", visibility:"hidden"}); 
}

var ag_dord = $("#AgDayDetails").find(".ag_time_orders div.ag_inner");
if(!ag_dord.is(e.target) && ag_dord.has(e.target).length===0){
ag_dord.removeClass("ag_inner_focused");
}

});


function ag_phone_check(obj) {
if (this.ST) return; var ov = obj.value;

var ovrl = ov.replace (/\d*/, \'\').length;
this.ST = true;
if (ovrl > 0) {obj.value = obj.lang; ag_phone_checkError(obj); return}
obj.lang = obj.value; this.ST = null;
}
function ag_phone_checkError(obj) {
if (!this.OBJ) { this.OBJ = obj; $(obj).parent().css({background:\'pink\'}); $(obj).css({background:\'pink\'}); this.TIM = setTimeout(ag_phone_checkError, 100)}
else {$(this.OBJ).parent().removeAttr(\'style\'); $(this.OBJ).removeAttr(\'style\'); clearTimeout(this.TIM); this.ST = null; ag_phone_check(this.OBJ); this.OBJ = null}
}

function ag_open_order(num) {
/*?orders*/
window.parent.location="'.$srv_absolute_url.'/'.$ag_apanel_link.'/?orders&order_search="+num;	
}

$(document).ready(function(){
ag_responsitive();
ag_get_schedule(\'\',\'\');	
});
$(window).load(function(){
ag_responsitive(); 
});

$(window).resize(function() {
setTimeout(function(){ 
ag_responsitive();
if (ag_select_day && ag_select_day != "" && ag_select_day != 0 && ag_select_day != "0" && ag_select_day != "00" && ag_select_day != " ") {
 ag_get_schedule(ag_select_service, ag_select_day); 
}
 }, 100);
});



ag_ref_Timer = null;
ag_ref_State = false; 
ag_ref_Wait = 300000;
 
$(document).ready( function(){
  $(document).bind("mousemove keydown scroll", function(){
    clearTimeout(ag_ref_Timer); 
   
 
    ag_ref_State = false;
    ag_ref_Timer = setTimeout(function(){ 
     
      /*window.location = "'.$ag_num_url.'";*/
	  /*ag_get_schedule(ag_select_service, ag_select_day);*/
	  
      ag_ref_State = true; 
    }, ag_ref_Wait);
  });
 
  $("body").trigger("mousemove"); 
});

ag_ref = setInterval(function(){ ag_get_schedule(ag_select_service, ag_select_day); }, ag_ref_Wait);


</script>

';


echo $ag_head_html;
echo $ag_table_html;
echo ag_return_html($ag_js);
echo $ag_footer_html;

?>