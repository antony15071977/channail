<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}

if (!isset($ag_ap_orders)) { include('inc/db_booking.php'); }

$ag_auth_this_staff = array();
$ag_auth_this_staff = ag_auth();



//this category service
$ag_booking_objects = array();
$ag_this_serv_cat = '';
$ag_this_serv_obj = ''; 
$ag_ob_data = array();

if (isset($_GET[$ag_get_schedule])) {
$ag_booking_objects = ag_file_list($ag_data_dir.'/object', $agt);

if (!empty($ag_booking_objects)) {
foreach ($ag_booking_objects as $ag_obj_bf) {
if (file_exists($ag_obj_bf['name']) && filesize($ag_obj_bf['name']) != 0) {
$ag_ob_data = ag_read_data($ag_obj_bf['name']);
foreach ($ag_ob_data as $obd) {
if (isset($obd['service']) && $obd['service'] == $_GET[$ag_get_schedule]) {
	$ag_this_serv_cat = $ag_obj_bf['name'];
	if (isset($obd['id'])) {$ag_this_serv_obj = $obd['id'];}
	break; 
	}
}
}// file_exists & !=0
}
$ag_this_serv_cat = str_replace(array($ag_data_dir.'/object', $agt, '/'), '' ,$ag_this_serv_cat);
//$ag_this_serv_cat;
//$ag_this_serv_obj;
}
}



function ag_success($res='',$mess='') {
global $success;
if (!empty($mess)) {$mess = ', "message": "'.$mess.'"';}
$result = '{"'.$success.'": '.$res.$mess.'}';	
return $result;
}


//---------------------------------------------- SERVICE CALENDAR
function ag_serv_calendar($start, $end, $closed, $count, $nowd) {
	
//$nowd = '';	
//$closed = '';

global $ag_lng;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_days_short;
global $ag_default_period;

$aperiod = $ag_default_period;
$oi_start_check = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
if (empty($start)) {$start = $oi_start_check;}
if ($count == 0 && empty($start) && empty($end)) {$count = $aperiod;}


$ag_service_calendar = '';

$ag_service_calendar .= '<div class="ag_date">

<label><span id="ag_date_display" tabindex="-1" onclick="ag_view_cal()" onfocus="ag_active(this)" onblur="ag_out(this)">'.date('d.m.Y').'</span></label>
<input type="hidden" value="'.date('Y-m-d').'" id="ag_date" />

<div class="ag_date_select" id="ag_date_select">
<i class="ag_cal_arrow"></i>

<!-- <div class="ag_mob_table"> -->
<table id="ag_idate">
  <thead>
  
    <tr class="ag_di_select_month">
	<td class="ag_di_ms" tabindex="-1"><i class="icon-left-open-big"></i></td>
	<td colspan="5"></td>
	<td tabindex="-1" class="ag_di_ms"><i class="icon-right-open-big"></i></td>
	</tr>
	
	 <tr>
	 <td>'.$ag_lng_days_short[1].'</td>
	 <td>'.$ag_lng_days_short[2].'</td>
	 <td>'.$ag_lng_days_short[3].'</td>
	 <td>'.$ag_lng_days_short[4].'</td>
	 <td>'.$ag_lng_days_short[5].'</td>
	 <td class="ag_holiday">'.$ag_lng_days_short[6].'</td>
	 <td class="ag_holiday">'.$ag_lng_days_short[0].'</td>
	 </tr>
	 
  </thead>
  
  <tbody></tbody>
  
</table>
<!-- </div> // close tag added in ag_return_html function -->

</div>
</div>

<div class="ag_clear"></div>';



$ag_service_calendar .= '<script>

var ag_closed_dates = "'.$closed.'".split(",");
var nowd = "'.$nowd.'";
var no_week_day = [];
if (nowd) {no_week_day = nowd.split(",");}

function ag_in_array_cal(value, array) {
    for(var i=0; i<array.length; i++){
        if(value == array[i]) return true;
    }
    return false;
}



function ag_insert_date(e) {
var idate = $(e).attr("data-day");
var imonth = $(e).attr("data-month");	
var iyear = $(e).attr("data-year");	
$("#ag_date").val(iyear + "-" + imonth + "-" + idate);
$("#ag_date_display").html(idate + "." + imonth + "." + iyear);
$(".ag_di").removeClass("ag_this_di");
$(e).addClass("ag_this_di");
ag_display_time();
setTimeout(function() { ag_hidd_cal(); }, 50);
}

function ag_with_zerro(num) { if (num < 10) {num = "0" + num; } return num; }

function ag_idate(id, year, month) {

var selected_date = $("#ag_date").val();

var now = new Date();
';
$start_y = date('Y');
$start_m = date('n');
$start_d = date('j');

$end_y = date('Y') + 3;
$end_m = 12;
$end_d = 31;

if (!empty($start)) {
$start_a = explode('-', $start);
if (isset($start_a[0])) {$start_y = (int)$start_a[0];}
if (isset($start_a[1])) {$start_m = (int)$start_a[1];}	
if (isset($start_a[2])) {$start_d = (int)$start_a[2];}		
}
if (!empty($end)) {
$end_a = explode('-', $end);
if (isset($end_a[0])) {$end_y = (int)$end_a[0];}
if (isset($end_a[1])) {$end_m = (int)$end_a[1];}	
if (isset($end_a[2])) {$end_d = (int)$end_a[2];}		
}

if ($count > 0) {
$count = $count - 1;
$ag_service_calendar .= '
var ag_thisDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').');
var ag_endDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').' + '.$count.');
';

} else {
	
if (!empty($start)) {
$oi_date_check = date("Y-m-d", strtotime($start_y.'-'.$start_m.'-'.$start_d));

if ($oi_date_check < $oi_start_check) {
$ag_service_calendar .= 'var ag_thisDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').');';	
} else {
$ag_service_calendar .= 'var ag_thisDate = new Date('.$start_y.', '.($start_m - 1).', '.$start_d.');';
}


} else { $ag_service_calendar .= 'var ag_thisDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').');'; }

if (!empty($end)) {
$ag_service_calendar .= 'var ag_endDate = new Date('.$end_y.', '.($end_m - 1).', '.$end_d.');';
} else { $ag_service_calendar .= 'var ag_endDate = new Date('.date('Y').', '.(date('n') - 1).', '.date('j').' + '.$aperiod.');'; }

}


$ag_service_calendar .= '
var Dlast = new Date(year,month+1,0).getDate(),
    D = new Date(year,month,Dlast),
    DNlast = new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),
    DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
    calendar = \'<tr>\',
    month=["'.$ag_lng_monts['01'].'","'.$ag_lng_monts['02'].'","'.$ag_lng_monts['03'].'","'.$ag_lng_monts['04'].'","'.$ag_lng_monts['05'].'","'.$ag_lng_monts['06'].'","'.$ag_lng_monts['07'].'","'.$ag_lng_monts['08'].'","'.$ag_lng_monts['09'].'","'.$ag_lng_monts['10'].'","'.$ag_lng_monts['11'].'","'.$ag_lng_monts['12'].'"];
	
if (DNfirst != 0) {
  for(var  i = 1; i < DNfirst; i++) calendar += \'<td></td>\';
} else {
  for(var  i = 0; i < 6; i++) calendar += \'<td></td>\';
}

for(var  i = 1; i <= Dlast; i++) {
	

var di = i;
if (di < 10) {di = "0" + di;}

var dw = new Date(D.getFullYear(),D.getMonth(),i).getDay();

	

var ag_checkDate = new Date(D.getFullYear(), D.getMonth(), i);

var ag_today_class = "";
if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth()) {ag_today_class = " ag_today";}


if (ag_checkDate >= ag_thisDate && ag_checkDate <= ag_endDate) {

var idate = di + "." + ag_with_zerro(D.getMonth() + 1);



if (ag_in_array_cal(idate, ag_closed_dates) || ag_in_array_cal(dw, no_week_day)) {
	
calendar += \'<td title="'.$ag_lng['closed_date'].'">\' + di + \'</td>\';
	
} else {

var selected_class = "";
var check_select = D.getFullYear() + "-" + ag_with_zerro(D.getMonth() + 1) + "-" + di;
if (check_select == selected_date) {selected_class = " ag_this_di";}

calendar += \'<td tabindex="-1" class="ag_di\' + ag_today_class + selected_class + \'" data-day="\' + di + \'" data-month="\' + ag_with_zerro(D.getMonth() + 1) + \'" data-year="\' + D.getFullYear() + \'" data-weekday="\' + dw + \'" onclick="ag_insert_date(this)">\' + di + \'</td>\';


}


} else {
	
calendar += \'<td>\' + di + \'</td>\';

}
	

	
	
  
  if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) {
    calendar += \'</tr>\';
  }
}

if (DNlast > 0) {
for (var  i = DNlast; i < 7; i++) { calendar += \'<td>&nbsp;</td>\'; }
}

$("#"+id+" tbody").html(calendar);
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").html(month[D.getMonth()] +" "+ D.getFullYear());
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").attr("data-month", D.getMonth());
$("#"+id+" thead tr.ag_di_select_month td:nth-child(2)").attr("data-year", D.getFullYear());

if ($("#"+id+" tbody tr").length < 6) { }




}';




$ag_service_calendar .= '
ag_idate("ag_idate", new Date().getFullYear(), new Date().getMonth());

$("#ag_idate thead tr.ag_di_select_month:nth-child(1) td:nth-child(1)").click(function(){
ag_idate("ag_idate", $("#ag_idate thead tr.ag_di_select_month td:nth-child(2)").attr("data-year"), parseFloat($("#ag_idate thead td:nth-child(2)").attr("data-month"))-1);
});

$("#ag_idate thead tr.ag_di_select_month:nth-child(1) td:nth-child(3)").click(function(){
ag_idate("ag_idate", $("#ag_idate thead tr.ag_di_select_month td:nth-child(2)").attr("data-year"), parseFloat($("#ag_idate thead td:nth-child(2)").attr("data-month"))+1);
});


function ag_hidd_cal() { $("#ag_date_select").fadeOut(120); }

$(document).mouseup(function (e) {
var ag_tcal = $(".ag_date");
if (!ag_tcal.is(e.target) && ag_tcal.has(e.target).length === 0) {
setTimeout(function(){ ag_hidd_cal(); }, 120);
}
});


function ag_view_cal() { 
var set_date = $("#ag_date").val().split("-");
var set_m = new Date().getMonth();
var set_y = new Date().getFullYear();
if (set_date[0]) {set_y = parseFloat(set_date[0]);}
if (set_date[1]) {set_m = parseFloat(set_date[1]) - 1;}

ag_idate("ag_idate", set_y, set_m);
$("#ag_date_select").fadeIn(160); 

}



</script>
';



return $ag_service_calendar;
}// ag_serv_calendar





//---------------------------------------------- OBJECTS INCLUDE
function ag_obj_incude($id_inc) {

global $ag_lng;
global $ag_lng_monts_r;
global $ag_data_dir;
global $agt;
global $ag_separator;
global $srv_absolute_url;
global $ag_get_schedule;


global $s_date;
global $s_time;
global $s_time_end;
global $s_free;
global $s_price;
global $s_custom;
global $s_currency;
global $s_currency_sign;
global $s_currency_position;
global $s_weekday;
global $s_spots;
global $s_count_spots;
global $success;


global $ag_booking_inputs;

global $ag_orders_dir;

global $ag_auth_this_staff;

global $ag_order_status;

global $ag_get_confirm;

global $ag_get_pay;

//global $ag_orders_db;

$obj_include = '';	// main str

$oi_title = '<h4 id="ag_title_servie">'.$ag_lng['sevice_not_found'].'</h4>';
$oi_period = '';
$oi_period_start = '';
$oi_period_end = '';
$oi_period_check = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$closed_dates = '';
$count_days = 0;
$oi_currency = '';
$curr_disp = '';
$ag_no_period = 0;
$obj_include_errors = '';


//order edit
$ag_edit_order_num = '';
$edit_js = '';
$val_inp_arr = array();
$eord_data = array();
$ts_check_val = '';
$oetime = '';
$oespots = '';
$oestatus = '1';

$edit_odate = date('Y-m-d');	
$edit_odate_disp = date('d.m.Y');

$ag_s_id = '';

if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($_GET['order'])) {
	
	
if (file_exists($ag_orders_dir.'/'.$_GET['m_y'].$agt)) {
$eord_data = ag_read_data($ag_orders_dir.'/'.$_GET['m_y'].$agt);	

foreach ($eord_data as $eord) {
	
if (isset($eord['id']) && !empty($_GET['order']) && $eord['id'] == $_GET['order']) {
	
if (isset($eord['status'])) { $oestatus = $eord['status']; }

if (isset($eord['number_order'])) {$ag_edit_order_num = ' / '.$ag_lng['order'].' № '.$eord['number_order'];}


foreach ($ag_booking_inputs as $ni => $vi) {
$via = explode(':',$vi);
if (isset($via[0])) {
	$vian = $via[0];
	if (isset($eord[$vian])) {
		$ag_sch = array();
		$ag_tch = array();
		
		if ($vian != 'time' && $vian != 'spots') {$val_inp_arr[$vian] = $eord[$vian];}
		
		if ($vian == 'date') {
		$edit_odate	= $eord[$vian];
		$disp_eod = date('d');
		$disp_eom = date('m');
		$disp_eoy = date('Y');
		$edit_odatea = explode('-', $eord[$vian]);
		if (isset($edit_odatea[0])) {$disp_eoy = $edit_odatea[0];}
		if (isset($edit_odatea[1])) {$disp_eom = $edit_odatea[1];}
		if (isset($edit_odatea[2])) {$disp_eod = $edit_odatea[2];}
		$edit_odate_disp = $disp_eod.'.'.$disp_eom.'.'.$disp_eoy;
		}
		
		if ($vian == 'time') {
			$oetime = '';
			
			$oetimea = explode($ag_separator[2], $eord[$vian]);
			foreach ($oetimea as $eot) {
			$eota = explode('-', $eot);	
			if (isset($eota[0])) {$oetime .= $eota[0].',';}
			}
			if (!empty($oetime) && $oetime[strlen($oetime) - 1] == ',') {$oetime = substr($oetime, 0, -1);}	
			
			//$val_inp_arr[$vian] = $oetime;
			//$val_inp_arr[$vian] = '';
		}// val time
		
		if ($vian == 'spots') {
		
		$oespots = str_replace($ag_separator[2], ',', $eord[$vian]); 
		//$val_inp_arr[$vian] = $oespots;
		//$val_inp_arr[$vian] = '';
		}// val spots
		
	}
	
}
}// foreach ag_booking_inputs	

$ag_tch = explode(',', $oetime);
$ag_sch = explode(',', $oespots);

foreach ($ag_tch as $tsc => $vtsc) {
	if (isset($ag_sch[$tsc])) {$ts_check_val .= $vtsc.'-'.$ag_sch[$tsc].',';}
}
if (!empty($ts_check_val) && $ts_check_val[strlen($ts_check_val) - 1] == ',') {$ts_check_val = substr($ts_check_val, 0, -1);}
	 

	
}// id
	
}// foreach eord_data
}// file_exists

$ag_order_today_date = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$ag_order_set_date = date("Y-m-d", strtotime($edit_odate));
if ($ag_order_today_date > $ag_order_set_date) {
$edit_odate = date('Y').'-'.date('m').'-'.date('d'); 
$edit_odate_disp = date('d').'.'.date('m').'.'.date('Y');
}

$edit_js = '$("#ag_date").val("'.$edit_odate.'"); $("#ag_date_display").text("'.$edit_odate_disp.'");';

}// get edit	


global $ag_apanel_link;
$inc_edit = '';


unset($ag_s_ERROR);



//reserve
global $ag_cfg_phone;
global $ag_cfg_email;
if (isset($_GET['reserve']) && !empty($ag_auth_this_staff)) {
	
	$val_inp_arr['first_name'] = $ag_auth_this_staff['name'];
	$val_inp_arr['phone'] = $ag_auth_this_staff['phone'];
	$val_inp_arr['email'] = $ag_auth_this_staff['email'];
	$val_inp_arr['comment'] = $ag_lng['reserve_comment'];
	
	if (empty($ag_auth_this_staff['phone'])) {$val_inp_arr['phone'] = $ag_cfg_phone;}
	if (empty($ag_auth_this_staff['email'])) {$val_inp_arr['email'] = $ag_cfg_email;}
	
}
	
$obj_inc_data = array();
$ag_reserve_opt = '';
if (file_exists($ag_data_dir.'/service'.$agt) && filesize($ag_data_dir.'/service'.$agt) != 0) {
$obj_inc_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_inc_data as $inc) {

if (isset($_GET['edit']) && !empty($ag_auth_this_staff)) {
$ag_selected_serv = '';
if ($_GET['edit'] == $inc['id']) {$ag_selected_serv = ' selected="selected"';}
if (isset($inc['title']) && isset($inc['id']) && isset($inc['status']) && $inc['status'] == 1) {
	$ag_reserve_opt .= '<option value="'.$inc['id'].'"'.$ag_selected_serv.'>'.$inc['title'].'</option>';
	}	
}		
}
}

$obj_inc_data = array();
if (file_exists($ag_data_dir.'/service'.$agt) && filesize($ag_data_dir.'/service'.$agt) != 0) {
$obj_inc_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_inc_data as $inc) {
	


if (isset($inc['id']) && $inc['id'] == $id_inc) {
if (isset($inc['status']) && $inc['status'] == 1) {
	
$ag_s_id = $inc['id'];
	
//access

$inc_edit = '';
if (isset($inc['staffs'])) { $inc_staffs = explode($ag_separator[2], $inc['staffs']); }

if (!empty($ag_auth_this_staff) && isset($ag_auth_this_staff['id'])) {
if (in_array($ag_auth_this_staff['id'], $inc_staffs)) {$inc_edit = ' <a href="'.$ag_apanel_link.'?tab=service&amp;id='.$id_inc.'#item_'.$id_inc.'" class="ag_serv_edit"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
if ($ag_auth_this_staff['access'] == 'founder' || $ag_auth_this_staff['access'] == '1') {$inc_edit = ' <a href="'.$ag_apanel_link.'?tab=service&amp;id='.$id_inc.'#item_'.$id_inc.'" class="ag_serv_edit"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
}	
	
	
	




	
	
	
	
	
	
//title	
$disp_title = '';
if (isset($inc['title'])) {$disp_title = $inc['title']; $oi_title = '<h4 id="ag_title_servie">'.$disp_title.$ag_edit_order_num.'</h4>'; }
if (isset($inc['hidden_name']) && $inc['hidden_name'] == 1 && !isset($_GET['order'])) { $oi_title = ''; }




//period
if (isset($inc['works_period'])) {$oi_period = $inc['works_period'];}
$oi_period_a = explode($ag_separator[2], $oi_period);
if (isset($oi_period_a[0])) {$oi_period_start = $oi_period_a[0];}
if (isset($oi_period_a[1])) {$oi_period_end = $oi_period_a[1];}
$oi_period_start_a = explode('.', $oi_period_start);
$oi_period_end_a = explode('.', $oi_period_end);
$oi_ps_day = '';
$oi_ps_month = '';
$oi_ps_year = '';
$oi_pe_day = '';
$oi_pe_month = '';
$oi_pe_year = '';
$ag_no_period = 0;
if (isset($oi_period_start_a[0])) {$oi_ps_day = $oi_period_start_a[0];}
if (isset($oi_period_start_a[1])) {$oi_ps_month = $oi_period_start_a[1];}
if (isset($oi_period_start_a[2])) {$oi_ps_year = $oi_period_start_a[2];}
if (isset($oi_period_end_a[0])) {$oi_pe_day = $oi_period_end_a[0];}
if (isset($oi_period_end_a[1])) {$oi_pe_month = $oi_period_end_a[1];}
if (isset($oi_period_end_a[2])) {$oi_pe_year = $oi_period_end_a[2];}

if (!empty($oi_period_start)) {$oi_period_start = date("Y-m-d", strtotime($oi_ps_year.'-'.$oi_ps_month.'-'.$oi_ps_day));}

if (!empty($oi_period_end)) {$oi_period_end = date("Y-m-d", strtotime($oi_pe_year.'-'.$oi_pe_month.'-'.$oi_pe_day));}

$ag_error_period_end = str_replace('%s', '<strong>'.$disp_title.'</strong>', $ag_lng['error_period_end']);
$ag_error_period_start = str_replace('%s', '<strong>'.$disp_title.'</strong>', $ag_lng['error_period_start']);
/*
if ($oi_period_start > $oi_period_check) {
$ag_s_ERROR['period'] = $ag_error_period_start.' ('.$ag_lng['period_from'].' <strong>'.$oi_ps_day.' '.$ag_lng_monts_r[$oi_ps_month].' '.$oi_ps_year.'</strong> - '.$ag_lng['period_to'].' <strong>'.$oi_pe_day.' '.$ag_lng_monts_r[$oi_pe_month].' '.$oi_pe_year.'</strong>)';
$ag_no_period = 1;
}
*/
if (!empty($oi_period_end) && $oi_period_end < $oi_period_check) {
$ag_s_ERROR['period'] = $ag_error_period_end.' ('.$ag_lng['period_from'].' <strong>'.$oi_ps_day.' '.$ag_lng_monts_r[$oi_ps_month].' '.$oi_ps_year.'</strong> - '.$ag_lng['period_to'].' <strong>'.$oi_pe_day.' '.$ag_lng_monts_r[$oi_pe_month].' '.$oi_pe_year.'</strong>)';
$ag_no_period = 1;
}

if (isset($inc['active_period'])) {$count_days = $inc['active_period'];}



}// inc status	
break;	// only one service
}// id = service
}// foreach obj_inc_data

}// file_exists service

// service errors
if (isset($ag_s_ERROR)) {
$obj_include_errors = '<ul class="ag_serv_error">';
foreach ($ag_s_ERROR as $k => $serv_error) {$obj_include_errors .= '<li>'.$serv_error.'</li>';}	
$obj_include_errors .= '</ul>';
}


//closed dates
if (isset($inc['year_days'])) {
$cdates = explode($ag_separator[2], $inc['year_days']);
foreach ($cdates as $kd => $vd) {
$cdate = '';
$sprice = '';
$vda = explode('::', $vd);
if (isset($vda[0])) {$cdate = $vda[0];}
if (isset($vda[1])) {$sprice = $vda[1];}



if (strpos($cdate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $cdate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {
if (empty($sprice) && !empty($cdate)) { $closed_dates .= $cdate.','; }// no work days
}
}



}	
}
//closed dates


//week days
$no_wd = '';
if (isset($inc['schedule'])) {
	
$sharr = explode($ag_separator[2], $inc['schedule']);
foreach ($sharr as $nwd => $shID) {
if (empty($shID)) {
	$nwd = $nwd + 1;
	if ($nwd == 7) {$nwd = 0;}
	$no_wd .= $nwd.',';
	}
}	
if (!empty($no_wd) && $no_wd[strlen($no_wd) - 1] == ',') {$no_wd = substr($no_wd, 0, -1);}	
	
}


	
	
$ag_no_price = 0;
if (isset($inc['no_price'])) {$ag_no_price = $inc['no_price'];}

//currency
$oi_currency = '';
if (isset($inc['currency'])) {$oi_currency = $inc['currency'];}
$currency = array();
$currency['title'] = '';
$currency['value'] = '';
$currency['icon'] = '';
$currency['sign'] = '';
$currency['left'] = '';

if (file_exists($ag_data_dir.'/currency'.$agt)) {
$curr_data = ag_read_data($ag_data_dir.'/currency'.$agt);	
foreach ($curr_data as $curr) {
if (isset($curr['id']) && $curr['id'] == $oi_currency) {
if (isset($curr['status']) && $curr['status'] == 1) {
if (isset($curr['title'])) {$currency['title'] = $curr['title'];}
if (isset($curr['currency_value'])) {$currency['value'] = $curr['currency_value'];}
if (isset($curr['icon'])) {$currency['icon'] = $curr['icon'];}
if (isset($curr['currency_sign'])) {$currency['sign'] = $curr['currency_sign'];}
if (isset($curr['currency_pos_left'])) {$currency['left'] = $curr['currency_pos_left'];}
}
break;}
}
}	
$curr_val = $currency['value'];
$curr_sign = '<i class="'. $currency['icon']. '"></i>';
$curr_pos = $currency['left'];

if (!empty($currency['sign'])) {$curr_sign = $currency['sign'];}
if (empty($currency['sign']) && empty($currency['icon'])) {$curr_sign = $curr_val;}
$curr_sign = html_entity_decode($curr_sign, ENT_QUOTES, 'UTF-8');
$curr_disp = '<span class="ag_summ"></span><span class="ag_curr">'.$curr_sign.'</span>';
if ($curr_pos == 1) {$curr_disp = '<span class="ag_curr">'.$curr_sign.'</span><span class="ag_summ"></span>';}




$pay_methods_arr = array();
$ag_payment_important = 0;
if (isset($inc['payments']) && !empty($inc['payments'])) {$pay_methods_arr = explode($ag_separator[2], $inc['payments']);}
if (isset($inc['payment_important']) && $inc['payment_important'] == '1') {$ag_payment_important = 1;}


$ag_booking_submit = $ag_lng['booking_submit'];
if (isset($inc['form_submit']) && !empty($inc['form_submit'])) {$ag_booking_submit = $inc['form_submit'];}



//eula
$check_eula = '';
$eula_text = '';
$eula_html = '';
$eula_js = '';
if(empty($this_staff)) {
$eula_title = $ag_lng['accept_policy'];
if (isset($inc['eula_text']) && !empty($inc['eula_text'])) {$eula_text = html_entity_decode($inc['eula_text'], ENT_QUOTES, 'UTF-8');}
$eula_text = str_replace('[site_url]', '', $eula_text);
$eula_text = str_replace(array('&nbsp;', '&#160;'), ' ', $eula_text);
$eula_text = str_replace('<p><!-- pagebreak --></p>', '', $eula_text);
$eula_text = str_replace('<!-- pagebreak -->', '', $eula_text);
$eula_text = str_replace($ag_separator[3], '', $eula_text);
$eula_text = ag_close_tags($eula_text);
if (isset($inc['eula_title']) && !empty($inc['eula_title'])) {$eula_title = $inc['eula_title'];}
$check_eula = strip_tags($eula_text, '');
}
if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y'])) {$check_eula = '';}

$custom_done_text = '';
if (isset($inc['signature_message_done']) && !empty($inc['signature_message_done'])) {
$custom_done_text = html_entity_decode($inc['signature_message_done'], ENT_QUOTES, 'UTF-8');
//$custom_done_text = str_replace(' ', '&nbsp;&shy;', $custom_done_text);
$custom_done_text = str_replace('[site_url]', '', $custom_done_text);
$custom_done_text = str_replace("'", '', $custom_done_text);
$custom_done_text = str_replace(',', ',&nbsp;&shy;', $custom_done_text);
//$custom_done_text = str_replace('&nbsp;&shy;&nbsp;&shy;', '&nbsp;&shy;', $custom_done_text);
$custom_done_text = str_replace('-', '&nbsp;-&nbsp;', $custom_done_text);
$custom_done_text = str_replace($ag_separator[3], '<br />', $custom_done_text);
$custom_done_text = '<div class="ag_custom_booking_mess">'.$custom_done_text.'</div>';
}



if (!empty($check_eula)) { // must eula accept
$eula_html = '<div class="ag_clear"></div>';	
$eula_html .= '<div class="ag_eula_input">';
$eula_html .= '<table class="ag_eula_block"><tr>';
$eula_html .= '<td class="ag_eula_checkbox"><label class="ag_one_ceckbox" title="'.$ag_lng['accept'].'">';
$eula_html .= '<input type="checkbox" value="1" id="ag_eula_accept" />';
$eula_html .= '<span class="ag_checkbox_custom"></span>';
$eula_html .= '</label></td>';
$eula_html .= '<td><div id="ag_eula_open" tabindex="-1" onclick="ag_eula(\'open\')"><span>'.$eula_title.'</span></div></td>';
$eula_html .= '</tr></table>';
$eula_html .= '<div class="ag_clear"></div>';	
$eula_html .= '</div>';

$eula_html .= '<div id="ag_eula_text">';
$eula_html .= '<div class="inner">';
$eula_html .= '<div class="ag_eula_text_inner">';
$eula_html .= $eula_text;
$eula_html .= '<div class="ag_clear"></div>';
$eula_html .= '<span id="ag_eula_close" class="ag_button" tabindex="-1" onclick="ag_eula(\'close\')"><i class="icon-cancel"></i> '.$ag_lng['close'].'</span>';
$eula_html .= '<div class="ag_clear"></div>';
$eula_html .= '</div>';
$eula_html .= '</div>';
$eula_html .= '</div>';

$eula_js = '
$("#ag_eula_text").css({display:"none"});
function ag_eula(trig) {
if (trig == "open") {
	$(".ag_back_layer").fadeIn(250);
	$("#ag_eula_text").fadeIn(250);
	}
if (trig == "close") {
	$("#ag_eula_text").fadeOut(250);
	$(".ag_back_layer").fadeOut(250);
	}		
}
';
}



$ag_order_status_select = '';
$order_status_display = '';
foreach ($ag_order_status as $ost => $name_ost)	{
$ostatus_selected = '';
if ($ost == $oestatus) {$ostatus_selected = ' selected="selected"';}	
$order_status_display = $name_ost;
if (isset($ag_lng[$name_ost])) {$order_status_display = $ag_lng[$name_ost];}	
$ag_order_status_select .= '<option value="'.$ost.'"'.$ostatus_selected.'>'.$order_status_display.'</option>';
}
$ag_order_status_select = '<div class="ag_oeder_ststus_select"><select id="ag_status">'.$ag_order_status_select.'</select></div>';	





$order_form = '<div class="ag_form_block" id="ag_onriv_form_block">';
$order_form .= '<div id="ag_booking_form" class="ag_booking_form">';
$order_form .= '<div id="ag_main_form" class="ag_main_form">';


if (!empty($ag_reserve_opt)) {$order_form .= '<div class="ag_select_service"><select id="ag_select_service" onchange="ag_select_service(this)">'.$ag_reserve_opt.'</select></div>';}

$order_form .= ag_serv_calendar($oi_period_start, $oi_period_end, $closed_dates, $count_days, $no_wd);

$order_form .= '<div id="ag_time_list" class="ag_time_list_select">';
$order_form .= '<div class="ag_time_block">&#160;</div>';
$order_form .= '</div>';

$order_form .= '<div class="ag_form">';









//inputs
$val_inp = '';
foreach ($ag_booking_inputs as $ni => $vi) {
$via = explode(':',$vi);
if (isset($via[0]) && isset($via[1]) && isset($via[2])) {
$val_inp = '';
$placeholder = $via[0];

if (isset($val_inp_arr[$placeholder])) {$val_inp = $val_inp_arr[$placeholder];}
if (isset($ag_lng[$placeholder])) {$placeholder = $ag_lng[$placeholder];}

$label_class = '';
$placeholder_imp = '';
if ($via[2] == '1') {$label_class = ' ag_important_input'; $placeholder_imp = '*';}
if ($via[0] != 'date') {
if ($via[1] == 'text') {$order_form .= '<label class="ag_'.$via[0].$label_class.'"><input type="text" value="'.$val_inp.'" id="ag_'.$via[0].'" placeholder="' .$placeholder.$placeholder_imp. '" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';}
else if ($via[1] == 'textarea') {
	$val_inp = str_replace($ag_separator[3], "\n", $val_inp);
	$order_form .= '<label class="ag_'.$via[0].$label_class.'"><textarea id="ag_'.$via[0].'" placeholder="' .$placeholder.$placeholder_imp. '" onfocus="ag_active(this)" onblur="ag_out(this)">'.$val_inp.'</textarea></label>';}	
else if ($via[1] == 'email') {$order_form .= '<label class="ag_'.$via[0].$label_class.'"><input type="email" value="'.$val_inp.'" id="ag_'.$via[0].'" placeholder="' .$placeholder.$placeholder_imp. '" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';}		
else if ($via[1] == 'phone') {$order_form .= '<label class="ag_'.$via[0].$label_class.'"><input type="text" value="'.$val_inp.'" id="ag_'.$via[0].'" placeholder="' .$placeholder.$placeholder_imp. '" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';}	
else if ($via[1] == 'hidden') {$order_form .= '<input type="hidden" value="" id="ag_'.$via[0].'" />';}	
}// no date
}// isset via 0,1,2
}//foreach ag_booking_inputs
$order_form .= '<input type="hidden" value="" id="ag_check_spots" />';
$order_form .= '<input type="hidden" value="'.date("H").'" id="ag_check_time_h" />';
$order_form .= '<input type="hidden" value="'.date("i").'" id="ag_check_time_m" />';
$order_form .= '<input type="hidden" value="'.date("s").'" id="ag_check_time_s" />';


$order_form .= $eula_html;


$order_form .= '</div>';


if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {
	$ag_booking_submit = $ag_lng['edit_order']; 
	$order_form .= $ag_order_status_select;
	}
if (isset($_GET['reserve']) && !empty($ag_auth_this_staff)) {$ag_booking_submit = $ag_lng['reserve'];}




$order_form .= '<div class="ag_clear"></div>';
$order_form .= '<div id="ag_booking_submit"><button onclick="ag_submit_post()" class="ag_submit">' .$ag_booking_submit. '</button><div id="ag_view_time"></div></div>';
$order_form .= '<div class="ag_clear"></div>';

$order_form .= '<div class="ag_back_layer"></div>';
$order_form .= '<div id="ag_result"></div>';

if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y'])) {
$order_form .= '<div id="ag_total_price" class="ag_edit_total_price"><h3>'.$ag_lng['summ'].': '.$curr_disp.'</h3></div>';
} else {
$order_form .= '<div id="ag_total_price"><h3>'.$ag_lng['summ'].': '.$curr_disp.'</h3></div>';
}

if (!isset($_GET['order'])) {$order_form .= $inc_edit.'<div class="ag_clear"></div>';}

$order_form .= '</div>';
$order_form .= '</div>';
$order_form .= '</div>';



$order_form .= '<script>';


if (isset($_GET['order'])) {
	
if (isset($inc['numerous_times']) && $inc['numerous_times'] == '1') {	
	
$order_form .= ' 

var count_call_oe = 0;
function ag_order_edit() { count_call_oe++;

var click_elements_num = [];

if (count_call_oe == 1) {
$("#ag_time").val("");
$("#ag_spots").val("");


var etime = "'.$oetime.'".split(",");
var espots = "'.$oespots.'".split(",");

var ts_check_val = "'.$ts_check_val.'";
var set_estots = 1;



for (var et = 0; et < $("#ag_time_list div.ag_time_block ul li.ag_enabled").length; et++) {
	
	for (var st = 0; st < etime.length; st++) {
		
		if (espots[st]) { set_estots = parseFloat(espots[st]); }
		if ($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).attr("data-time") == etime[st]) {
			
			
			
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("input.ag_spots_order").val(set_estots);
			var total_sp = parseFloat($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("input.ag_this_spots").val());
			var left_sp = total_sp - set_estots;
			
			if ($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("span.ag_spots_free span").length) {
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("span.ag_spots_free span").text(left_sp);
			}
			var el = et + 1;
			click_elements_num[el] = el;
			
			
			
			
		}
	}	
	
}
var tcl = 300;
if (click_elements_num.length > 20) {tcl = 160;}
if (click_elements_num.length > 0) {
for (var i = 1; i <= click_elements_num.length; i++) {
    (function(i) {
        setTimeout(function(){
		  var el = click_elements_num[i] - 1;
          $("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(el).click();
        }, tcl);
    })(i);
}
}

}


}




';


} else {
	
	
$order_form .= ' 
function ag_order_edit() {

$("#ag_time").val("");
$("#ag_spots").val("");


var etime = "'.$oetime.'";
var espots = "'.$oespots.'";



var ts_check_val = "'.$ts_check_val.'";


var set_estots = 1;
		if (espots) { set_estots = parseFloat(espots); }


for (var et = 0; et < $("#ag_time_list div.ag_time_block ul li.ag_enabled").length; et++) {
	if ($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).attr("data-time") == etime) {
			
			
			if (($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).attr("class").indexOf("ag_selected") + 1) > 0) { 
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).click();
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).click();
			} else {
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).click();
			}
			
			
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("input.ag_spots_order").val(set_estots);
			var total_sp = parseFloat($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("input.ag_this_spots").val());
			var left_sp = total_sp - set_estots;
			
			
			$("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("span.ag_spots_free span").text(left_sp);
			
			ag_spots_check($("#ag_time_list div.ag_time_block ul li.ag_enabled").eq(et).find("input.ag_spots_order"));
			
		}
		
	
}



}

';	
	
	
}

} else { $order_form .= 'function ag_order_edit() {}'; }



$order_form .= $edit_js;

$order_form .= $eula_js;

$order_form .= '
var ag_move_hours = '.(int)date("H").';
var ag_move_min = '.date("i").';
var ag_move_sec = '.date("s").'; 

function ag_check_time() {

var ag_move_sec_display = "";
var ag_move_min_display = "";
var ag_move_hour_display = "";

var date = new Date();
if (ag_move_hours == date.getHours()) {

ag_move_hours = date.getHours();
ag_move_min = date.getMinutes();
ag_move_sec = date.getSeconds();

} else {

ag_move_sec += 1;
if (ag_move_sec >= 60){
ag_move_min += 1;
ag_move_sec = 0;
}

if (ag_move_min >= 60){
ag_move_hours += 1;
ag_move_min = 0;
}

if (ag_move_hours >= 24) {
ag_move_hours = 0;
}

}

if (ag_move_sec < 10){
ag_move_sec_display = "0" + ag_move_sec;
} else {
ag_move_sec_display = ag_move_sec;
}

if (ag_move_min < 10) {
ag_move_min_display = "0" + ag_move_min ;
} else {
ag_move_min_display = ag_move_min;
}

if (ag_move_hours < 10) {
ag_move_hour_display = "0" + ag_move_hours;
} else {
ag_move_hour_display = ag_move_hours;
}

setTimeout("ag_check_time();", 990);

$("#ag_check_time_h").val(ag_move_hour_display);
$("#ag_check_time_m").val(ag_move_min_display);
$("#ag_check_time_s").val(ag_move_sec_display);


$("#ag_view_time").html(ag_move_hour_display + ":" + ag_move_min_display + ":" + ag_move_sec_display);
}
ag_check_time();
';






	
$order_form .= '
function ag_count_price() {
var total = 0;
for (var tp = 0; tp < $("#ag_time_list div.ag_time_block ul li.ag_selected").length; tp++) {
var tprice = parseFloat($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).attr("data-price"));

var spots_price = 1;
if ($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).find("input.ag_spots_order").val()) {
spots_price = parseFloat($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).find("input.ag_spots_order").val());	
}

if ($("#ag_time_list div.ag_time_block ul li.ag_selected").eq(tp).attr("data-cs") == 1) {
total += (tprice * spots_price);
} else {
total += tprice;	
}

}
if (total > 0) {
total = total.toFixed(2);
$("#ag_total_price h3 span.ag_summ").html(total);
$("#ag_total_price").stop().animate({left: "18px"}, 250, "easeInOutQuint");	
} else {
$("#ag_total_price").stop().animate({left: "-120%"}, 250, "easeInOutQuint");	
}
}';

//}



$order_form .= '

function ag_in_array_spot(value, array) {
    for(var i=0; i<array.length; i++){
	var index = i + 1;
	if(value == array[i]) return index;
    }
    return false;
}


function ag_spots_count(all_time) {

var set_new_spots = "";
var set_new_check_spots = "";

if(!all_time) { all_time = $("#ag_time").val().split(","); }

if (!$("#ag_time").val()) {
$("#ag_check_spots").val("");
$("#ag_spots").val("");
}

var set_timea = [];
var set_spotsa = [];

for (var e = 0; e < $(".ag_spots").length; e++) { 
var sdt = $(".ag_spots").eq(e).parents("li").attr("data-time");
var ssp = $(".ag_spots").eq(e).find("input.ag_spots_order").val();
set_timea[e] = sdt;
set_spotsa[e] = ssp;
}

for (var t = 0; t < all_time.length; t++) {
if (ag_in_array_spot(all_time[t], set_timea)) {
var is = ag_in_array_spot(all_time[t], set_timea);
is = is - 1;
set_new_spots += set_spotsa[is] + ",";
set_new_check_spots += all_time[t] + "-" +set_spotsa[is]+ ",";
}	


}



if (set_new_spots != "") {
set_new_spots = set_new_spots.substring(0, set_new_spots.length - 1);
set_new_spots = set_new_spots.replace(new RegExp(",,",\'g\'),",");



$("#ag_spots").val(set_new_spots);
}

if (set_new_check_spots != "") {
set_new_check_spots = set_new_check_spots.substring(0, set_new_check_spots.length - 1);
set_new_check_spots = set_new_check_spots.replace(new RegExp(",,",\'g\'),",");



$("#ag_check_spots").val(set_new_check_spots);
}
	

}




function ag_set_spots() { 

if (!$("#ag_time").val()) {
$("#ag_check_spots").val("");
$("#ag_spots").val("");
}

time_spots = $("#ag_check_spots").val().split(","); 
var ctimes = $("#ag_time").val();

if (!ctimes) {time_spots = [];}
 
for (var ts = 0; ts < time_spots.length; ts++) {
var tsa = time_spots[ts].split("-");
var stime = tsa[0];
var sspot = tsa[1];	

for (var ss = 0; ss < $(".ag_spots").length; ss++) { 
var sdt = $(".ag_spots").eq(ss).parents("li").attr("data-time");	

if (stime == sdt) {


if ($(".ag_spots").eq(ss).find(".ag_this_spots")) {
var stt = parseFloat($(".ag_spots").eq(ss).find(".ag_this_spots").val());	
var os = parseFloat(sspot);
var set_spots = stt - os;
if (set_spots >= 0) {
	$(".ag_spots").eq(ss).find("span.ag_spots_free span").text(set_spots);
	$(".ag_spots").eq(ss).find(".ag_spots_order").val(sspot);
	}
}

}
	
}
}	
}




function ag_spots_check(inp) {
if (inp) {
if (this.ST) return; 
var ov = $(inp).val(); 

var ovrl = ov.replace(/\d*/, "").length;
this.ST = true;
if (ovrl > 0) {$(inp).val($(inp).attr("lang")); ag_spots_checkError(inp); return}
$(inp).attr("lang", $(inp).val()); this.ST = null;

var time_spots = 1;
if ($(inp).parents(".ag_spots").find("span.ag_spots_free span").text()) {
time_spots = parseFloat($(inp).parents(".ag_spots").find("span.ag_spots_free span").text());
}

var ag_this_spots = 1;
if ($(inp).siblings(".ag_this_spots").val()) {
ag_this_spots =	parseFloat($(inp).siblings(".ag_this_spots").val());
}

var inp_spots = 0;
if ($(inp).val()) {
inp_spots = parseFloat($(inp).val());
} 
if (inp_spots > 0) {
var time_spots_count = ag_this_spots - inp_spots;

if (time_spots_count >= 0) {$(inp).parents(".ag_spots").find("span.ag_spots_free span").text(time_spots_count);}

} else { 
$(inp).parents(".ag_spots").find("span.ag_spots_free span").text(ag_this_spots);
}
if (time_spots_count < 0) { $(inp).val(1); /*ag_spots_checkError(inp); return*/ }


var ag_spots_str = "";
var ag_check_spots_str = "";
var spots_data_time = $(inp).parents("li").attr("data-time");
var set_time = $("#ag_time").val().split(",");
var set_spots = $("#ag_spots").val().split(",");

for (var st = 0; st < set_time.length; st++) {
var sts = 1;
if (set_spots[st]) {sts = set_spots[st];}
if (set_time[st] == spots_data_time) {sts = $(inp).val();}
ag_spots_str += sts + ",";
ag_check_spots_str += set_time[st] + "-" + sts + ",";
}

if (ag_spots_str != "") {
ag_spots_str = ag_spots_str.substring(0, ag_spots_str.length - 1);
ag_spots_str = ag_spots_str.replace(new RegExp(",,",\'g\'),",");
$("#ag_spots").val(ag_spots_str);
}

if (ag_check_spots_str != "") {
ag_check_spots_str = ag_check_spots_str.substring(0, ag_check_spots_str.length - 1);
ag_check_spots_str = ag_check_spots_str.replace(new RegExp(",,",\'g\'),",");



$("#ag_check_spots").val(ag_check_spots_str);
}

ag_count_price();
}
}


function ag_spots_checkError(inp) {
if (!this.inp) { 
this.inp = inp; 
$(inp).css({background:"pink"}); 
this.TIM = setTimeout(ag_spots_checkError, 100);
} else {
$(this.inp).parent().removeAttr("style"); 
$(this.inp).removeAttr("style"); 
clearTimeout(this.TIM); 
this.ST = null; 
ag_spots_check(inp); 
this.inp = null;
}
}


function ag_spots_select(e, d) {
if (!$(e).parents(".ag_spots").find(".ag_spots_order").val()){$(e).parents(".ag_spots").find(".ag_spots_order").val("0");}
var this_d = parseFloat($(e).parents(".ag_spots").find(".ag_spots_order").val());
var max_spots =	parseFloat($(e).parents(".ag_spots").find(".ag_this_spots").val());
var left_sp = parseFloat($(e).parents(".ag_spots").find(".ag_spots_free span").text()); 

var set_d = this_d + d;
if (set_d >= 1 && set_d <= max_spots) {
$(e).parents(".ag_spots").find(".ag_spots_order").val(set_d);
ag_spots_check($(e).parents(".ag_spots").find("input.ag_spots_order"));
}
if (left_sp < 0) {
	$(e).parents(".ag_spots").find(".ag_spots_order").val(1);
	$(e).parents(".ag_spots").find(".ag_spots_free span").text(max_spots - 1);
	}


}
';



$ag_dir = ag_apanel('../');
$ag_dir = str_replace('../', '', $ag_dir);
//$ag_dir = str_replace('/', '', $ag_dir);

$ag_addr_query = $srv_absolute_url;
$ag_addr_query = str_replace($ag_dir, '', $ag_addr_query);


$ag_order_edit_get = '';
if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y'])) {
$ag_order_edit_get = '&edit='.$_GET['edit'].'&order='.$_GET['order'].'&m_y='.$_GET['m_y'];	
}
if (isset($_GET['reserve'])) {$ag_order_edit_get = '';}

$order_form .= '

var ag_your_slot_id = "' .$ag_s_id. '";

if ($("#ag_select_service").val()) { ag_your_slot_id = $("#ag_select_service").val(); }

function ag_height_times() {
var maxHeight = 0;	
$(".ag_time_block ul li").find("p").height("auto").each(function () {
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            }).height(maxHeight);	
}



var ag_count_display_time = 0;
function ag_display_time() {
	

	
var ag_selected_time = $("#ag_time").val().split(",");
var ag_new_select_time = "";

	
ag_count_display_time = ag_count_display_time + 1;
var ag_date = $("#ag_date").val();
var ag_time_list = \'<div class="ag_load_times"><i class="icon-spin1 animate-spin"></i></div>\';
$("#ag_time_list div.ag_time_block").html(ag_time_list);
$.getJSON("' .$ag_addr_query. '?' .$ag_get_schedule. '=" + ag_your_slot_id + "'.$ag_order_edit_get.'", function(data) {
	
var this_hour = parseFloat($("#ag_check_time_h").val());
var this_min = parseFloat($("#ag_check_time_m").val());
var count_time_p = 0;
	
        ag_time_list = \'<ul>\';
        for (var i in data) {
			
            var ag_time_class = "";	
			
			if (data[i].'.$s_date.' == ag_date) { count_time_p++;
			
			for (var ti = 0; ti < ag_selected_time.length; ti++) { 
				
			var itimea = ag_selected_time[ti].split(":");	
            var ih = parseFloat(itimea[0]);
            var im = parseFloat(itimea[1]);
			
			if (ag_selected_time[ti] == data[i].'.$s_time.') {
				
				if (ag_date == "'.date("Y-m-d").'") {
				if (ih > this_hour || ih == this_hour && im > this_min) {
				ag_time_class = " ag_selected"; ag_new_select_time += data[i].'.$s_time.' + ",";
				}
				} else {
				if (data[i].'.$s_free.' != false) {	
				ag_time_class = " ag_selected"; ag_new_select_time += data[i].'.$s_time.' + ",";
				}
				}
				
				}
			}
			
			var ag_spots = 1;
			if(data[i].'.$s_spots.') {ag_spots = data[i].'.$s_spots.';}
			
            var ag_currency_val = data[i].'.$s_currency.';
			var ag_currency_sig = data[i].'.$s_currency_sign.';
			var ag_currency_pos = data[i].'.$s_currency_position.';
			
			var ag_display_price = data[i].'.$s_price.' + " " + ag_currency_sig;
			if (ag_currency_pos == "1") {ag_display_price = ag_currency_sig + " " + data[i].'.$s_price.';}
			
			var ag_dd = data[i].'.$s_date.'.split("-");
			var ag_display_date = ag_dd[2] + "." + ag_dd[1] + "." + ag_dd[0];
			
			var ag_display_time = data[i].'.$s_time.' + "&#160;-&#160;" + data[i].'.$s_time_end.';
			if (data[i].'.$s_time_end.' == "XX:XX") {ag_display_time = data[i].'.$s_time.';}
			';
			
			if ($ag_no_price == 1) {  $order_form .= 'ag_display_price = ag_display_date; data[i].'.$s_price.' = 0;';  }
			
$order_form .= '			
			if (data[i].'.$s_free.' == false) {
			ag_time_list += \'<li class="ag_disabled"><p>\' + ag_display_time + \'<span class="ag_currency">\' + ag_display_price + \'</span></p></li>\';
			
			} else { 
			
			ag_time_list += \'<li class="ag_enabled\' + ag_time_class + \'" tabindex="-1"\';
			ag_time_list += " onclick=\"ag_select_time(\'" + data[i].'.$s_time.' + "\', this)\" ";
			ag_time_list += \'data-time="\' + data[i].'.$s_time.' + \'" data-price="\' + data[i].'.$s_price.' + \'" data-cs="\' + data[i].'.$s_count_spots.' + \'"><p>\' + ag_display_time + \'<span class="ag_currency">\' + ag_display_price + \'</span>\';
			if (ag_spots > 1) {
			ag_time_list += \'<span class="ag_spots">\';
			ag_time_list += \'<span class="ag_spots_input"><input type="text" value="" placeholder="'.$ag_lng['count_spots'].'" oninput="ag_spots_check(this)" onpropertychange="ag_spots_check(this)" class="ag_spots_order" /><input type="hidden" value="\'+ ag_spots +\'" class="ag_this_spots" /><span class="ag_spots_select ag_spots_select_plus" tabindex="-1" onclick="ag_spots_select(this, 1)"><i class="icon-up-dir"></i></span><span class="ag_spots_select ag_spots_select_minus" tabindex="-1" onclick="ag_spots_select(this, -1)"><i class="icon-down-dir-1"></i></span></span>\';
			ag_time_list += \'<span class="ag_spots_free">'.$ag_lng['free_spots'].':&#160;<span>\'+ ag_spots +\'</span></span>\';
			ag_time_list += \'</span>\';
			} else {
			ag_time_list += \'<span class="ag_spots ag_hidden"><input type="hidden" value="1" class="ag_spots_order" /><input type="hidden" value="0" class="ag_this_spots" /></span>\';	
			}
			ag_time_list += \'</p></li>\'; 
			}
			}
        }
		if (count_time_p == 1) { setTimeout(function() { $("li.ag_enabled").click();},300); }
		if (count_time_p < 4) {$("#ag_booking_form").addClass("ag_fw_times");} else {$("#ag_booking_form").removeClass("ag_fw_times");}
		if (count_time_p > 6) {$("#ag_booking_form").addClass("ag_top_times");} else {$("#ag_booking_form").removeClass("ag_top_times");}
		
		
		ag_new_select_time = ag_new_select_time.substring(0, ag_new_select_time.length - 1);
		ag_new_select_time = ag_new_select_time.replace(new RegExp(",,",\'g\'),",");
        ag_new_select_time = ag_new_select_time.replace(new RegExp(" ",\'g\'),"");
		$("#ag_time").val(ag_new_select_time);
		
		if (ag_time_list == \'<ul>\') {ag_time_list += \'<li class="ag_no_time"><p>' .$ag_lng['no_free_time']. '</p></li>\';}
        ag_time_list += \'<li class="ag_clear"></li></ul>\';
        $("#ag_time_list div.ag_time_block").html(ag_time_list);
		
		
		
		
		ag_set_spots(); 
		
		ag_select_time(0, 0);
		
		ag_spots_count(ag_new_select_time.split(","));
		
		ag_height_times();
		
	    ag_count_price();
		
		setTimeout(function() { ag_order_edit(); }, 80);
	
		
}).fail(function(jqXHR, textStatus, errorThrown) { 
 
ag_time_list = \'<ul><li class="ag_no_time"><p>' .$ag_lng['error_answer']. ' (\' + textStatus + \')</p></li></ul>\'; 
$("#ag_time_list div.ag_time_block").html(ag_time_list);

});
 

if (ag_count_display_time > 1) { 
var ag_margin_top = $("#ag_mob_top_panel").outerHeight(true) + 18;
$("html, body").animate( {scrollTop: $("#ag_onriv_form_block").offset().top - ag_margin_top}, 400, "easeOutQuart");
}


}

setInterval("ag_count_display_time = 0; ag_display_time();", 300000);';

$ag_wlh = '';
if (isset($_GET['order']) && isset($_GET['m_y'])) {$ag_wlh = '?orders&m_y='.$_GET['m_y'].'&edit="+$(e).val()+"&order='.$_GET['order'].'&iframe';}
if (isset($_GET['reserve'])) {$ag_wlh = '?orders&m_y='.date('m_Y').'&edit="+$(e).val()+"&order=&reserve=&iframe';}

$order_form .= '
function ag_select_service(e) {
$("#ag_title_servie").text($(e).find("option:selected").text());
window.location="'.$ag_wlh.'";	
}

';


//$curr_sign
//$curr_pos




if (isset($inc['numerous_times']) && $inc['numerous_times'] == '1') {
$order_form .= '
function ag_select_time(time, e) {

$("input.ag_spots_order, span.ag_spots_select").click(function(){	
if (($(this).parents("li").attr("class").indexOf("ag_selected") + 1) > 0) { return false; }
});
	

var stime = "";
var itime = "";


if (time) {

if ($("#ag_time").val()) {stime = $("#ag_time").val() + ",";}

if ((stime.indexOf(time) + 1) > 0) {

var stimea = stime.split(",");

var this_hour = parseFloat($("#ag_check_time_h").val());
var this_min = parseFloat($("#ag_check_time_m").val());


for (var ti = 0; ti < stimea.length; ti++) {
if (stimea[ti] != time && stimea[ti] != "") {
	
var ctime = "";
var itimea = stimea[ti].split(":");	
var ih = parseFloat(itimea[0]);
var im = parseFloat(itimea[1]);	

if ($("#ag_date").val() == "'.date("Y-m-d").'") {
if (ih > this_hour || ih == this_hour && im > this_min) {ctime = stimea[ti];}
} else { ctime = stimea[ti]; }

   itime += ctime + ","; 
   
   }
}
itime = itime.substring(0, itime.length - 1);

$(e).removeClass("ag_selected");	

if ($(e).find("input.ag_spots_order").val()) {$(e).find("input.ag_spots_order").val("");}

} else {
		
	
itime = stime + time;
$(e).addClass("ag_selected");

if (!$(e).find("input.ag_spots_order").val()) {$(e).find("input.ag_spots_order").val("1");}
	
}

itime = itime.replace(new RegExp(",,",\'g\'),",");
itime = itime.replace(new RegExp(" ",\'g\'),"");
$("#ag_time").val(itime); 	

ag_spots_check($(e).find("input.ag_spots_order"));

ag_spots_count(itime.split(","));

ag_count_price();

}

}';	


} else {

$order_form .= '
function ag_select_time(time, e) {

if ($(e).attr("class") == "ag_enabled ag_selected") {
$(".ag_enabled").removeClass("ag_selected");	
$("input.ag_spots_order").val("");
$("#ag_time").val("");	
$("#ag_spots").val("");
ag_count_price();
return false;
}

$("span.ag_spots").each(function(){
var val_cs = $(this).find(".ag_spots_input").val();
var val_ls = $(this).find(".ag_this_spots").val();
$(this).find(".ag_spots_free span").text(val_ls);
});

$(e).find("input.ag_spots_order, span.ag_spots_select").click(function(){	
if (($(this).parents("li").attr("class").indexOf("ag_selected") + 1) > 0) { return false; }
});


	
	
if (time) {
	
$(".ag_enabled").removeClass("ag_selected");	
$("input.ag_spots_order").val("");
$(e).find("input.ag_spots_order").val("1");

var this_hour = parseFloat($("#ag_check_time_h").val());
var this_min = parseFloat($("#ag_check_time_m").val());
var itimea = time.split(":");	
var ih = parseFloat(itimea[0]);
var im = parseFloat(itimea[1]);	

if ($("#ag_date").val() == "'.date("Y-m-d").'") {
if (ih > this_hour || ih == this_hour && im > this_min) {
	$("#ag_time").val(time); 
	$(e).addClass("ag_selected");
	}
} else {

$("#ag_time").val(time); 
$(e).addClass("ag_selected");

}



ag_spots_check($(e).find("input.ag_spots_order"));

ag_spots_count(time.split(","));

ag_count_price();

}

}';
}

$order_form .= '

function ag_insert_date(e) {
var idate = $(e).attr("data-day");
var imonth = $(e).attr("data-month");	
var iyear = $(e).attr("data-year");	
$("#ag_date").val(iyear + \'-\' + imonth + \'-\' + idate);
$("#ag_date_display").html(idate + \'.\' + imonth + \'.\' + iyear);
$(".ag_di").removeClass("ag_this_di");
$(e).addClass("ag_this_di");
ag_display_time();
setTimeout(function() { ag_hidd_cal(); }, 70);
}

ag_display_time();
$(window).on("resize", function () { ag_height_times(); setTimeout(function() { ag_height_times(); }, 70); });

function ag_wait_post(i) {

	var button_w = $("#ag_booking_submit").find("button").outerWidth(true);
	var button_h = $("#ag_booking_submit").find("button").outerHeight(true);
	if (i == 1) {
    $("#ag_booking_submit").find("button").addClass("ag_wait_post");
	$("#ag_booking_submit").find("button").css({minWidth: button_w + "px"});
	$("#ag_booking_submit").find("button").removeAttr("onclick");
	$("#ag_booking_submit").find("button").html(\'<i class="icon-spin1 animate-spin"></i>\');
	} else {
	$("#ag_booking_submit").find("button").animate({opacity: "0"},200);
	setTimeout(function() { 
	$("#ag_booking_submit").find("button").html("");
	$("#ag_booking_submit").find("button").text("' .$ag_booking_submit. '");	
	$("#ag_booking_submit").find("button").css({minWidth: "auto"});
	$("#ag_booking_submit").find("button").removeClass("ag_wait_post");  
	$("#ag_booking_submit").find("button").attr("onclick", "ag_submit_post()");
	$("#ag_booking_submit").find("button").animate({opacity: "1"},200); 
	}, 300);
	}
}

function ag_submit_post() {';

if (!empty($check_eula)) {
	
$order_form .= '
if ($("#ag_eula_accept").prop("checked")) {} else {	
$(".ag_back_layer").fadeIn(250);
$("#ag_result").css({top: "-100%", display:"block"});

ag_inner_class = ""; 
var ag_min_width = 800;
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

if (ag_win_width < ag_min_width) {
ag_inner_class = " inner_mobile"; 
$("#ag_result").animate({top: "0px"}, 400);
} else {
ag_inner_class = "";
$("#ag_result").animate({top: "20%"}, 400);
}	
var ag_dialog_class = " ag_error";

$("#ag_result").html(\'<div class="inner\' + ag_inner_class + \'\' + ag_dialog_class + \'"><p><strong>'.$ag_lng['error'].'</strong></p><p>'.$ag_lng['error_empty_inputs'].':</p><p>'.$eula_title.'</p><span class="ag_button" onclick="ag_close_done()">'.$ag_lng['close'].'</span><div class="ag_clear"></div></div>\'); 	

return false;	
}';	
}


$order_posts = '';
foreach ($ag_booking_inputs as $ni => $vi) {
$via = explode(':',$vi);
if (isset($via[0]) && isset($via[1]) && isset($via[2])) {
$order_form .= 'var ag_'.$via[0].' = $("#ag_'.$via[0].'").val();';


//if ($via[0] != 'spots') { 
$order_posts .= $via[0].'=" + ag_'.$via[0].' + "&'; 
//}

}
}
if ($order_posts[strlen($order_posts) - 1] == '&') {$order_posts = substr($order_posts, 0, -1);}

if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {
	
$order_form .= 'var ag_order_status = $("#ag_status").val();';
$order_posts .= '&ag_order_status = " + ag_order_status + "';	
}


$ag_dir = ag_apanel('../');
$ag_dir = str_replace('../', '', $ag_dir);
//$ag_dir = str_replace('/', '', $ag_dir);

$ag_addr_query = $srv_absolute_url;
$ag_addr_query = str_replace($ag_dir, '', $ag_addr_query);


$ag_bdone_mess = $ag_lng['booking_done_time'];
if (!empty($ag_order_edit_get)) {$ag_bdone_mess = $ag_lng['order_edit_done'];}

$order_form .= '
$.ajax({
	
type: "POST",
url: "' .$ag_addr_query. '?' .$ag_get_schedule. '='.$id_inc.$ag_order_edit_get.'",
data: "'.$order_posts.'",
 
success: function(data) {
var ag_dialog_class = " ag_message";
var ddatea = ag_date.split("-");
var ddate = ddatea[2] + "." + ddatea[1] + "." + ddatea[0];
var ag_time_disp = ag_time;
if (ag_time) { ag_time_disp = ag_time.replace(new RegExp(",",\'g\'),"&sbquo;&nbsp;&shy;"); }
if (!data.message && data.success != false) { ';
	
	
if (isset($_GET['order'])) {$custom_done_text = '';}

$order_form .= '	
data.message = \'<p><strong>'.$ag_bdone_mess.'</strong></p><p>'.$ag_lng['booking_time'].':&nbsp;<strong>\'+ ag_time_disp +\'</strong>&nbsp;&shy;'.$ag_lng['booking_in'].'&nbsp;<strong>\'+ ddate +\'</strong></p>'.$custom_done_text.'\'; 
';



$order_form .= '
ag_dialog_class = " ag_done"; 
$("#ag_time").val("");

}
if (data.success == false) {ag_dialog_class = " ag_error";}
if (!data.message && !data.success)	{ag_dialog_class = " ag_error"; data.message = "<p>'.$ag_lng['error_answer'].'</p>";}

$(".ag_back_layer").fadeIn(250);
$("#ag_result").css({top: "-100%", display:"block"});

ag_inner_class = ""; 
var ag_min_width = 800;
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

if (ag_win_width < ag_min_width) {
ag_inner_class = " inner_mobile"; 
$("#ag_result").animate({top: "0px"}, 400);
} else {
ag_inner_class = "";
$("#ag_result").animate({top: "20%"}, 400);
}	
var ag_cifrm_order = "";
if (ag_dialog_class == " ag_done") { ag_cifrm_order = "; ag_close_edit_order()";}';



//$pay_methods_arr = array();
//$ag_payment_important = 0;


$order_form .= '
var ag_result_disp = "";

ag_result_disp = \'<div class="inner\' + ag_inner_class + \'\' + ag_dialog_class + \'"><div class="ag_answer_booking">\' + data.message + \'</div>\';

';

if (!empty($pay_methods_arr)) {
	
if (!isset($_GET['order'])) {	
$order_form .= '
if (data.success != false) {
ag_result_disp += \'<span class="ag_button ag_pay_button" onclick="ag_pay(\' + data.success + \');">'.$ag_lng['pay_order_now'].'</span>\';
}
';
}		
}	

$order_form .= 'var pay_methods_imp = 0;';
if (!empty($pay_methods_arr) && $ag_payment_important == 1) {$order_form .= 'pay_methods_imp = 1;';}
if (isset($_GET['order'])) { $order_form .= 'pay_methods_imp = 0;'; }

$order_form .= '
if (pay_methods_imp == 0 || data.success == false) {
ag_result_disp += \'<span class="ag_button" onclick="ag_close_done()\' + ag_cifrm_order + \'">'.$ag_lng['close'].'</span><div class="ag_clear"></div></div>\';
}
';




$order_form .= '

$("#ag_result").html(ag_result_disp);

},
error: function(XMLHttpRequest, textStatus, errorThrown) {



$(".ag_back_layer").fadeIn(250);
$("#ag_result").css({top: "-100%", display:"block"});

ag_inner_class = ""; 
var ag_min_width = 800;
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

if (ag_win_width < ag_min_width) {
ag_inner_class = " inner_mobile"; 
$("#ag_result").animate({top: "0px"}, 400);
} else {
ag_inner_class = "";
$("#ag_result").animate({top: "20%"}, 400);
}	
ag_dialog_class = " ag_error";

$("#ag_result").html(\'<div class="inner\' + ag_inner_class + \'\' + ag_dialog_class + \'"><div class="ag_answer_booking">'.$ag_lng['error_answer'].'</div><span class="ag_button" onclick="ag_close_done()">'.$ag_lng['close'].'</span><div class="ag_clear"></div></div>\'); 



}
}); 


ag_wait_post(1);

}


function ag_pay(num) {	
window.location = "'.$srv_absolute_url.'?'.$ag_get_confirm.'=" + num + "&'.$ag_get_pay.'";	
}



function ag_close_done() {
$(".ag_back_layer").fadeOut(250);
$("#ag_result").animate({top: "-100%"}, 300);
ag_display_time();	
ag_wait_post(0);
}';

if (isset($_GET['order'])) {
$ag_get_p = 1;
if (isset($_GET['page'])) {$ag_get_p = (int)$_GET['page'];}
$order_form .= 'function ag_close_edit_order() {

var ag_orders_reperiod = $("#ag_date").val();
var ag_orders_reperioda = ag_orders_reperiod.split("-");
ag_orders_reperiod = ag_orders_reperioda[1] + "_" + ag_orders_reperioda[0];
window.parent.location = "?orders&m_y=" + ag_orders_reperiod + "&p='.$ag_get_p.'&edit_done='.rand(10,99).'#'.$_GET['order'].'";
setTimeout(function() { $(window.parent.document).find("#cboxClose").click(); }, 50);
}';	

} else if (isset($_GET['reserve'])) {
	
$order_form .= 'function ag_close_edit_order() {

var ag_orders_reperiod = $("#ag_date").val();
var ag_orders_reperioda = ag_orders_reperiod.split("-");
ag_orders_reperiod = ag_orders_reperioda[1] + "_" + ag_orders_reperioda[0];
window.parent.location = "?orders&m_y=" + ag_orders_reperiod + "&reserve_done='.rand(10,99).'";
setTimeout(function() { $(window.parent.document).find("#cboxClose").click(); }, 50);
}';	
} else {
$order_form .= 'function ag_close_edit_order() {}';
}


$order_form .= '</script>';






if ($ag_no_period == 1) {$order_form = '';}



$obj_include .= $obj_include_errors;
//if (!isset($ag_s_ERROR)) {
$obj_include .= $oi_title;
$obj_include .= $order_form;
//}




return $obj_include;
}// ag_obj_incude








function ag_booking_time_spots($time_start, $time_end, $date, $sid, $parallel, $odb) {

$res = 0;

global $ag_data_dir;
global $agt;
global $ag_separator;	

global $ag_orders_db;
global $ag_orders_dir;
global $ag_orders_file;
global $ag_get_schedule;

global $ag_auth_this_staff;

$date_db = date('m_Y');
$date_a = explode('-', $date);
if (isset($date_a[0]) && isset($date_a[1])) {$date_db = $date_a[1].'_'.$date_a[0];}



if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y'])) {
	//$ag_orders_dir = '../'.$ag_orders_dir; 
	//$date_db = $_GET['m_y'];
}



//check booking time
$b_data = array();
$b_data = $odb;
/*
if (file_exists($ag_orders_dir.'/'.$date_db.$agt)) {
$b_data = ag_read_data($ag_orders_dir.'/'.$date_db.$agt);	
}// file_exists
*/


$get_edit_id = '';
if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {
$get_edit_id = $_GET['order'];
}

foreach ($b_data as $order) {

if (isset($order['id']) && $order['id'] == $get_edit_id) { $order['status'] = '0'; }
	
//parallel	
//category? queue? ------------------------------------------
if ($parallel == '1') {
	

	
if (
    isset($order['status']) && $order['status'] != '0' && 
    isset($order['date']) && $order['date'] == $date
	) {
if (isset($order['time'])) {


$bspots = array();
$bt_spots = 1;

if (isset($order['spots'])) { $bspots = explode($ag_separator[2], $order['spots']);	}

$order_tsa = explode($ag_separator[2], $order['time']);	
foreach ($order_tsa as $ok => $ot) {
$ota = explode('-', $ot);

if (isset($bspots[$ok])) {$bt_spots = (int)$bspots[$ok];}



if (isset($ota[0]) && isset($ota[1])) {
	$noEnd = false;
	if (empty($time_start)) { $time_start = '00:00'; }
	if (empty($time_end) || $time_end == 'XX:XX') { $time_end = '00:00'; $noEnd = true; }
	if (empty($ota[0])) { $ota[0] = '00:00'; }
	if (empty($ota[1]) || $ota[1] == 'XX:XX') { $ota[1] = '00:00'; }
	$time_start = strtotime($time_start);
	$time_end = strtotime($time_end);
	$ota[0] = strtotime($ota[0]);
	$ota[1] = strtotime($ota[1]);
	
	//ag_log(array('timeStart' => $time_start, 'timeEnd' => $time_start, 'bookTimeStart' => $ota[0], 'bookTimeEnd' => $ota[1]));
	
	$chTimePeriod = false;
	
	/* time periods */
	/*
	$ctpa = array();
	for ($i = $ota[0]; $i < $ota[1]; $i++) {
		$ctpa[] = $i;
	}
	if (in_array($time_start, $ctpa) || in_array($time_end, $ctpa)) { $chTimePeriod = true; }
	*/
	$ctpa = array();
	for ($i = ($time_start + 1); $i < $time_end; $i++) {
		$ctpa[] = $i;
	}
	if (in_array($ota[0], $ctpa) || in_array($ota[1], $ctpa)) { $chTimePeriod = true; }
	/* time periods */
	
if ($time_start == $ota[0] || $time_start > $ota[0] && $time_end <= $ota[1] || $chTimePeriod) { // || $chTimePeriod - add 12.01.2021 
	
$res += $bt_spots;

}
}
}


}
}// this date && service	
	
	
	
} else { // parallel 0



if (
    isset($order['status']) && $order['status'] != '0' && 
    isset($order['date']) && $order['date'] == $date && 
	isset($order['service']) && $order['service'] == $sid
	) {
if (isset($order['time'])) {
	
	
$bspots = array();
$bt_spots = 1;

if (isset($order['spots'])) { $bspots = explode($ag_separator[2], $order['spots']);	}

$order_tsa = explode($ag_separator[2], $order['time']);	
foreach ($order_tsa as $ok => $ot) {
$ota = explode('-', $ot);

if (isset($bspots[$ok])) {$bt_spots = (int)$bspots[$ok];}



if (isset($ota[0])) {
if ($time_start == $ota[0]) {

$res += $bt_spots;

}
}
}


}
}// this date && service

}// parallel 



}// foreach b_data









return $res;
}//ag_time_booking_spots












//----------------------------------------------JSON TIMES
function ag_time($sid, $date, $gid, $cdates, $pdates, $cwd, $currency) {
	
$return = '';	

global $s_date;
global $s_time;
global $s_time_end;
global $s_free;
global $s_price;
global $s_custom;
global $s_currency;
global $s_currency_sign;
global $s_currency_position;
global $s_weekday;
global $s_spots;
global $s_count_spots;
global $success;

global $ag_data_dir;
global $agt;
global $ag_separator;	

global $ag_orders_db;
global $ag_orders_dir;
global $ag_orders_file;
global $ag_get_schedule;

global $ag_auth_this_staff;

$free = 'true';
$price = 0;

$odb = array();
$date_db = date('m_Y');
$date_a = explode('-', $date);
if (isset($date_a[0]) && isset($date_a[1])) {$date_db = $date_a[1].'_'.$date_a[0];}
if (file_exists($ag_orders_dir.'/'.$date_db.$agt)) {
$odb = ag_read_data($ag_orders_dir.'/'.$date_db.$agt);	
}// file_exists


$ag_this_time = date("H:i", strtotime(date("H:i")));

$weekn = array(
'0' => 'Mon',
'1' => 'Tue',
'2' => 'Wed',
'3' => 'Thu',
'4' => 'Fri',
'5' => 'Sat',
'6' => 'Sun'
);
$wnum = '';
$week_day = strftime("%a", strtotime($date));
foreach ($weekn as $wn => $wname) {
	if ($week_day == $wname) {$wnum = $wn;}
}

$parallel = '0';
$serv_data = array();
if (file_exists($ag_data_dir.'/service'.$agt)) {
$serv_data = ag_read_data($ag_data_dir.'/service'.$agt);	
}// file_exists
foreach ($serv_data as $serv) {
if (isset($serv['id']) && $serv['id'] == $sid) {
if (isset($serv['parallel'])) {$parallel = $serv['parallel'];}
}// id
}// foreach serv_data 



$s_data = array();
if (file_exists($ag_data_dir.'/schedule'.$agt)) {
$s_data = ag_read_data($ag_data_dir.'/schedule'.$agt);	
}// file_exists

$time_data = array();
if (file_exists($ag_data_dir.'/time'.$agt)) {
$time_data = ag_read_data($ag_data_dir.'/time'.$agt);	
}// file_exists


foreach ($gid as $nw => $ids) { 
foreach ($s_data as $schedule) {
if (isset($schedule['id']) && $schedule['id'] == $ids) {
if (isset($schedule['status']) && $schedule['status'] == 1) {
	
	
//TIME	

if (isset($schedule['times']) && !empty($schedule['times'])) {

$times_arr = explode($ag_separator[2], $schedule['times']);
foreach ($times_arr as $k => $tID) {
	

foreach ($time_data as $nt => $times) {

if (isset($times['id']) && $times['id'] == $tID) {
if (isset($times['status']) && $times['status'] == 1) {
if (isset($times['time_period'])) {
$time_start = '';
$time_end = '';
$timea = explode($ag_separator[2], $times['time_period']);
if (isset($timea[0])) {$time_start = $timea[0];}
if (isset($timea[1])) {$time_end = $timea[1];}

$count_spots = 1;
if (isset($times['no_count_spots']) && $times['no_count_spots'] == '1') { $count_spots = 0; }

//free
$this_date = date('Y-m-d');
$tdate = date("Y-m-d", strtotime($this_date));


$date_c = '';
$date_a = explode('-', $date);
if (isset($date_a[1]) && isset($date_a[2])) {$date_c = $date_a[2].'.'.$date_a[1];}





//spots
$f_spots = 1;
if (isset($times['spots'])) { $f_spots = (int)$times['spots']; }
$m_spots = 0;

$m_spots = ag_booking_time_spots($time_start, $time_end, $date, $sid, $parallel, $odb);



$f_spots = $f_spots - $m_spots;




if ($f_spots <= 0) {
$free = 'false';
} else {
$free = 'true';
if ($this_date == $date) {
$ag_set_time = date("H:i", strtotime($time_start));
if ($ag_this_time >= $ag_set_time) {$free = 'false';} else {$free = 'true';}	
}
}









// price
if (isset($times['price'])) { $price = $times['price']; }

foreach ($pdates as $sdate => $sprice) {
if ($sdate == $date_c) {
	
	if (strpos($sprice, '%') === false) { 
	$price = $price + $sprice;
	} else {
	$spercent = $price * $sprice / 100;
	$price = $price + $spercent;
	}
	
	}
}
if ($price < 0) {$price = 0;}

$curr_val = $currency['value'];
$curr_sign = '<i class=\"'. $currency['icon']. '\"></i>';
$curr_pos = $currency['left'];

if (!empty($currency['sign'])) {$curr_sign = $currency['sign'];}
if (empty($currency['sign']) && empty($currency['icon'])) {$curr_sign = $curr_val;}
$curr_sign = html_entity_decode($curr_sign, ENT_QUOTES, 'UTF-8');









//return date times
if ($nw == $wnum && !in_array($date_c, $cdates)) { 
$weekdayname = '';
if (isset($weekn[$nw])) {$weekdayname = $weekn[$nw];}


$abr = "\n";
$abr = '';
$return .= '{'.$abr;
$return .= '"'.$s_date.'":'.'"'.$date.'",'.$abr;
$return .= '"'.$s_time.'":'.'"'.$time_start.'",'.$abr;	
$return .= '"'.$s_time_end.'":'.'"'.$time_end.'",'.$abr;	
$return .= '"'.$s_free.'":'.''.$free.','.$abr;
$return .= '"'.$s_price.'":'.''.$price.','.$abr;
$return .= '"'.$s_currency.'":'.'"'.$curr_val.'",'.$abr;
$return .= '"'.$s_currency_sign.'":'.'"'.$curr_sign.'",'.$abr;
$return .= '"'.$s_currency_position.'":'.'"'.$curr_pos.'",'.$abr;
$return .= '"'.$s_custom.'":'.'"'.$sid.'",'.$abr;
$return .= '"'.$s_weekday.'":'.'"'.$weekdayname.'",'.$abr;
$return .= '"'.$s_spots.'":'.'"'.$f_spots.'",'.$abr;
$return .= '"'.$s_count_spots.'":'.'"'.$count_spots.'"';
$return .= $abr.'},';

}// week day times
	
	
	

	
}// isset time_period
}// status time item
break;}// tID
	
}// foreach time_data


}// foreach times_arr
	
}//schedule times	
	
	
	
}// status
break;}// id
}// foreach schedules
}// foreach id	


return $return;
}









//---------------------------------------------- JSON SCHEDULE
function ag_json_schedule($id) {
	
global $ag_lng;
global $ag_lng_monts_r;
global $ag_data_dir;
global $agt;
global $ag_separator;	
global $ag_default_period;	
$abr = "\n";
$abr = '';
	
$schedule = '';	
$schedule = '['.$abr;	

$oi_period = '';
$oi_period_start = '';
$oi_period_end = '';
$oi_period_check = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$closed_dates = array();
$count_days = 0;	



$weekn = array(
'0' => 'Mon',
'1' => 'Tue',
'2' => 'Wed',
'3' => 'Thu',
'4' => 'Fri',
'5' => 'Sat',
'6' => 'Sun'
);

$monts_names = $ag_lng_monts_r;


$ida = array();
if (!empty($id)) {
$id = urldecode($id);
$id = preg_replace('/[\s]{2,}/', '', $id);
$id = str_replace(' ', '', $id);
if ($id[strlen($id) - 1] == ',') {$id = substr($id, 0, -1);}
$ida = explode(',', $id);
$ida = array_diff($ida, array(''));
$ida = array_unique($ida);
}


foreach ($ida as $k => $ids) {

if (file_exists($ag_data_dir.'/service'.$agt)) {
$serv_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($serv_data as $serv) {
if (isset($serv['id']) && $serv['id'] == $ids) {
if (isset($serv['status']) && $serv['status'] == 1) {

$currency = array();
$currency['title'] = '';
$currency['value'] = '';
$currency['icon'] = '';
$currency['sign'] = '';
$currency['left'] = '';
if (isset($serv['currency'])) {
if (file_exists($ag_data_dir.'/currency'.$agt)) {
$curr_data = ag_read_data($ag_data_dir.'/currency'.$agt);	
foreach ($curr_data as $curr) {
if (isset($curr['id']) && $curr['id'] == $serv['currency']) {
if (isset($curr['status']) && $curr['status'] == 1) {
if (isset($curr['title'])) {$currency['title'] = $curr['title'];}
if (isset($curr['currency_value'])) {$currency['value'] = $curr['currency_value'];}
if (isset($curr['icon'])) {$currency['icon'] = $curr['icon'];}
if (isset($curr['currency_sign'])) {$currency['sign'] = $curr['currency_sign'];}
if (isset($curr['currency_pos_left'])) {$currency['left'] = $curr['currency_pos_left'];}
}
break;}
}
}	
}

//------------------------

//period
$oi_period = '';
$oi_period_start = '';
$oi_period_end = '';
if (isset($serv['works_period'])) {$oi_period = $serv['works_period'];}
$oi_period_a = explode($ag_separator[2], $oi_period);
if (isset($oi_period_a[0])) {$oi_period_start = $oi_period_a[0];}
if (isset($oi_period_a[1])) {$oi_period_end = $oi_period_a[1];}
$oi_period_start_a = explode('.', $oi_period_start);
$oi_period_end_a = explode('.', $oi_period_end);
$oi_ps_day = '';
$oi_ps_month = '';
$oi_ps_year = '';
$oi_pe_day = '';
$oi_pe_month = '';
$oi_pe_year = '';
if (isset($oi_period_start_a[0])) {$oi_ps_day = $oi_period_start_a[0];}
if (isset($oi_period_start_a[1])) {$oi_ps_month = $oi_period_start_a[1];}
if (isset($oi_period_start_a[2])) {$oi_ps_year = $oi_period_start_a[2];}
if (isset($oi_period_end_a[0])) {$oi_pe_day = $oi_period_end_a[0];}
if (isset($oi_period_end_a[1])) {$oi_pe_month = $oi_period_end_a[1];}
if (isset($oi_period_end_a[2])) {$oi_pe_year = $oi_period_end_a[2];}

if (!empty($oi_period_start)) {$oi_period_start = date("Y-m-d", strtotime($oi_ps_year.'-'.$oi_ps_month.'-'.$oi_ps_day));}

if (!empty($oi_period_end)) {$oi_period_end = date("Y-m-d", (strtotime($oi_pe_year.'-'.$oi_pe_month.'-'.$oi_pe_day)) + 86400);}


$count_days = 0;
if (isset($serv['active_period'])) {$count_days = (int)$serv['active_period'];}

$cper = $count_days;
if ($cper == 0) {$cper = $ag_default_period;}

$date_start = date('Y-m-d');
$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper));

if ($oi_period_start > $oi_period_check) {$date_start = $oi_period_start;}
if (empty($oi_period_end)) {
	
	$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper));
	if ($count_days == 0) {$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper)); }
	
} else {
		
    $date_end = $oi_period_end; 
    if ($count_days > 0) {$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper)); }
}



//closed dates
$closed_dates = array();
$price_dates = array();
if (isset($serv['year_days'])) {
$cdates = explode($ag_separator[2], $serv['year_days']);
foreach ($cdates as $kd => $vd) {
$cdate = '';
$sprice = '';
$vda = explode('::', $vd);
if (isset($vda[0])) {$cdate = $vda[0];}
if (isset($vda[1])) {$sprice = $vda[1];}


if (strpos($cdate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $cdate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {
if (!empty($cdate))	{
if (empty($sprice)) { $closed_dates[$kd] = $cdate; }// no work days
else { $price_dates[$cdate] = $sprice; } // swing prise dates
}

}
}


}	
}
//closed dates


//week days
$no_wd = array();
$id_times = array();
if (isset($serv['schedule'])) {
$cnwd = 0;	
$sharr = explode($ag_separator[2], $serv['schedule']);
foreach ($sharr as $nwd => $shID) {
	
if (empty($shID)) { $cnwd++;
	$nwd = $nwd + 1;
	if ($nwd == 7) {$nwd = 0;}	
	$no_wd[$cnwd] = $nwd;
	} else {
	$id_times[$nwd]	= $shID;
	}
}	

	
}//week days








//period massive date
$from = new DateTime($date_start);
$to   = new DateTime($date_end);

$period = new DatePeriod($from, new DateInterval('P1D'), $to);

$arrayOfDates = array_map(
    function($item){return $item->format('Y-m-d');},
    iterator_to_array($period)
);






//print_r($arrayOfDates);
//$schedule .= $serv['id'].' ';

//------------------------

foreach($arrayOfDates as $n => $date) {


$schedule .= ag_time($serv['id'], $date, $id_times, $closed_dates, $price_dates, $no_wd, $currency);


}



}// status
}// id == serv
}//foreach serv_data

}// file_exists	
}// foreach id	

if ($schedule[strlen($schedule) - 1] == ',') {$schedule = substr($schedule, 0, -1);}

$schedule .= $abr.']';

return $schedule;
}// ag_json_schedule






function ag_order_post_check($id, $date, $time, $spots) {

$result = array();


$result['time'] = '';
$result['price'] = '';
$result['spots'] = '';
$result['staffs'] = '';
$result['title'] = '';
$result['currency'] = '';
$result['service'] = '';
$payment_important = '';

global $ag_lng;
global $ag_lng_monts_r;
global $ag_data_dir;
global $agt;
global $ag_separator;	
global $ag_booking_inputs;
global $ag_orders_db;
global $ag_orders_dir;
global $ag_orders_file;
global $ag_get_schedule;	
global $ag_default_period;	
	

$odb = array();
$date_db = date('m_Y');
$date_a = explode('-', $date);
if (isset($date_a[0]) && isset($date_a[1])) {$date_db = $date_a[1].'_'.$date_a[0];}
if (file_exists($ag_orders_dir.'/'.$date_db.$agt)) {
$odb = ag_read_data($ag_orders_dir.'/'.$date_db.$agt);	
}// file_exists	
	
	
$oi_period = '';
$oi_period_start = '';
$oi_period_end = '';
$oi_period_check = date("Y-m-d", strtotime(date('Y').'-'.date('m').'-'.date('d')));
$count_days = 0;	
$swing_price = 0;

$cd = '';
$cm = '';
$cy = '';
$cdatea = explode('-', $date);
if (isset($cdatea[0])) {$cy = $cdatea[0];}
if (isset($cdatea[1])) {$cm = $cdatea[1];}
if (isset($cdatea[2])) {$cd = $cdatea[2];}
if (empty($cd) || empty($cm) || empty($cy)) {$result['error'] = $ag_lng['error_date_format'];}

$weekn = array(
'0' => 'Mon',
'1' => 'Tue',
'2' => 'Wed',
'3' => 'Thu',
'4' => 'Fri',
'5' => 'Sat',
'6' => 'Sun'
);	
	
$wnum = '';
$week_day = strftime("%a", strtotime($date));
foreach ($weekn as $wn => $wname) {
	if ($week_day == $wname) {$wnum = $wn;}
}	
	

$s_data = array();
if (file_exists($ag_data_dir.'/schedule'.$agt)) {
$s_data = ag_read_data($ag_data_dir.'/schedule'.$agt);	
}// file_exists

$time_data = array();
if (file_exists($ag_data_dir.'/time'.$agt)) {
$time_data = ag_read_data($ag_data_dir.'/time'.$agt);	
}// file_exists


$times = array();
if (!empty($time)) {
$time = preg_replace('/[\s]{2,}/', '', $time);
$time = str_replace(' ', '', $time);
$times = explode(',', $time);
$times = array_diff($times, array(''));
$times = array_unique($times);
}
	
$spotsa = array();
if (!empty($spots)) {
$spots = preg_replace('/[\s]{2,}/', '', $spots);
$spots = str_replace(' ', '', $spots);
$spotsa = explode(',', $spots);
$spotsa = array_diff($spotsa, array(''));
}

//check booking time
$date_db = $cm.'_'.$cy;
$b_data = array();
if (file_exists($ag_orders_dir.'/'.$date_db.$agt)) {
$b_data = ag_read_data($ag_orders_dir.'/'.$date_db.$agt);	
}// file_exists

$this_service = '';
if (isset($_GET[$ag_get_schedule])) {$this_service = $_GET[$ag_get_schedule];}



	
//check service
$parallel = '0';
$found_serv = 0;
$id_graphic = '';
if (file_exists($ag_data_dir.'/service'.$agt)) {
$obj_serv_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_serv_data as $serv) {
if (isset($serv['id']) && $serv['id'] == $id) { 
if (isset($serv['status']) && $serv['status'] == 1) { $found_serv = 1;
if (isset($serv['title'])) {$result['title'] = $serv['title'];}	
$result['service'] = $serv['id'];
if (isset($serv['parallel'])) {$parallel = $serv['parallel'];}
if (isset($serv['payment_important']) && $serv['payment_important'] == '1' && isset($serv['payment_important_time'])) {
	$payment_important = $serv['payment_important_time'];
	if (empty($payment_important)) {$payment_important = 10;}
	}

// currency	
$currency = array();
$currency['title'] = '';
$currency['value'] = '';
$currency['icon'] = '';
$currency['sign'] = '';
$currency['left'] = '';
if (isset($serv['currency'])) {
if (file_exists($ag_data_dir.'/currency'.$agt)) {
$curr_data = ag_read_data($ag_data_dir.'/currency'.$agt);	
foreach ($curr_data as $curr) {
if (isset($curr['id']) && $curr['id'] == $serv['currency']) {
if (isset($curr['status']) && $curr['status'] == 1) {
if (isset($curr['title'])) {$currency['title'] = $curr['title'];}
if (isset($curr['currency_value'])) {$currency['value'] = $curr['currency_value'];}
if (isset($curr['icon'])) {$currency['icon'] = $curr['icon'];}
if (isset($curr['currency_sign'])) {$currency['sign'] = $curr['currency_sign'];}
if (isset($curr['currency_pos_left'])) {$currency['left'] = $curr['currency_pos_left'];}
}
break;}
}
}	
}// currency		
$result['currency'] = $currency['value'];
if (empty($result['currency'])) {$result['currency'] = '&curren;';}		
	
//period
$oi_period = '';
$oi_period_start = '';
$oi_period_end = '';
if (isset($serv['works_period'])) {$oi_period = $serv['works_period'];}
$oi_period_a = explode($ag_separator[2], $oi_period);
if (isset($oi_period_a[0])) {$oi_period_start = $oi_period_a[0];}
if (isset($oi_period_a[1])) {$oi_period_end = $oi_period_a[1];}
$oi_period_start_a = explode('.', $oi_period_start);
$oi_period_end_a = explode('.', $oi_period_end);
$oi_ps_day = '';
$oi_ps_month = '';
$oi_ps_year = '';
$oi_pe_day = '';
$oi_pe_month = '';
$oi_pe_year = '';
if (isset($oi_period_start_a[0])) {$oi_ps_day = $oi_period_start_a[0];}
if (isset($oi_period_start_a[1])) {$oi_ps_month = $oi_period_start_a[1];}
if (isset($oi_period_start_a[2])) {$oi_ps_year = $oi_period_start_a[2];}
if (isset($oi_period_end_a[0])) {$oi_pe_day = $oi_period_end_a[0];}
if (isset($oi_period_end_a[1])) {$oi_pe_month = $oi_period_end_a[1];}
if (isset($oi_period_end_a[2])) {$oi_pe_year = $oi_period_end_a[2];}

if (!empty($oi_period_start)) {$oi_period_start = date("Y-m-d", strtotime($oi_ps_year.'-'.$oi_ps_month.'-'.$oi_ps_day));}

if (!empty($oi_period_end)) {$oi_period_end = date("Y-m-d", (strtotime($oi_pe_year.'-'.$oi_pe_month.'-'.$oi_pe_day)));}


$count_days = 0;
if (isset($serv['active_period'])) {$count_days = (int)$serv['active_period'];}

$cper = $count_days;
if ($cper == 0) {$cper = $ag_default_period;}

$date_start = date('Y-m-d');
$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper));

if ($oi_period_start > $oi_period_check) {$date_start = $oi_period_start;}
if (empty($oi_period_end)) {
	
	$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper));
	if ($count_days == 0) {$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper)); }
	
} else {
		
    $date_end = $oi_period_end; 
    if ($count_days > 0) {$date_end = date('Y-m-d',(strtotime($date_start) + 86400 * $cper)); }
}


//check date
$tdate = date("Y-m-d", strtotime($date));
if ($tdate > $date_end) {$result['error'] = '<strong>'.$cd.'.'.$cm.'.'.$cy.'</strong> - '.$ag_lng['error_date_not_active'];}
if ($tdate < $date_start) {$result['error'] = '<strong>'.$cd.'.'.$cm.'.'.$cy.'</strong> - '.$ag_lng['error_date_not_active'];}



//closed dates & swing price
$swing_price = 0;
if (isset($serv['year_days'])) {
$cdates = explode($ag_separator[2], $serv['year_days']);
foreach ($cdates as $kd => $vd) {
$cdate = '';
$sprice = '';
$vda = explode('::', $vd);
if (isset($vda[0])) {$cdate = $vda[0];}
if (isset($vda[1])) {$sprice = $vda[1];}


if (strpos($cdate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $cdate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {
if (!empty($cdate))	{
if (empty($sprice)) { if ($cdate == $cd.'.'.$cm) {$result['error'] = '<strong>'.$cd.'.'.$cm.'.'.$cy.'</strong> - '.$ag_lng['error_date_not_active'];} }// no work days
else { if ($cdate == $cd.'.'.$cm) {$swing_price = $sprice;} } // swing priсe dates
}

}
}


}	
}
//closed dates







//week days
$id_graphic = '';
if (isset($serv['schedule'])) {
$cnwd = 0;	
$sharr = explode($ag_separator[2], $serv['schedule']);

foreach ($sharr as $nwd => $shID) {
	
if (empty($shID)) { $cnwd++;
	
	   if ($wnum == $nwd) { $result['error'] = '<strong>'.$cd.'.'.$cm.'.'.$cy.'</strong> - '.$ag_lng['error_date_not_active'];}
	   
	} else {
		
	   if ($wnum == $nwd) { $id_graphic = $shID; }
	  
	}
}	

}//week days	
	

	
// times
$this_date = date('Y-m-d');
$allow_times = 0;
$count_times = 0;	
if (isset($serv['numerous_times'])) {$allow_times = $serv['numerous_times'];}


if (!empty($time)) {
foreach ($times as $t) { $count_times ++;

if ($this_date == $date) {
$ag_set_time = date("H:i", strtotime($t));
$ag_this_time = date("H:i", strtotime(date("H:i")));
if ($ag_this_time >= $ag_set_time) { $result['error'] = '<strong>'.$t.'</strong> - '.$ag_lng['error_expired_times']; } 
}
	
	
}// foreach times
if ($count_times > 1 && $allow_times == 0) { $result['error'] = $ag_lng['error_count_times']; }	
} else { 
//$result['error'] = $ag_lng['error_set_time']; 
} // empty time	
	
}// serv status
break;}// serv ID
}// foreach obj_serv_data
} else { $result['error'] = $ag_lng['error_file_exists'].' ('.$ag_lng['services'].')'; } // file_exists	service




//serv times
$serv_times = array();
foreach ($s_data as $schedule) {
if (isset($schedule['id']) && $schedule['id'] == $id_graphic) {
if (isset($schedule['status']) && $schedule['status'] == 1) {
	
	


if (isset($schedule['times']) && !empty($schedule['times'])) {
$times_arr = explode($ag_separator[2], $schedule['times']);


$time_start = '';
$time_end = '';
$time_price = 0;
$time_spots = 1;
$time_staff = '';

$time_close = '';
$spots_close = '';
$m_spots = 0;

foreach ($times_arr as $k => $tID) {
foreach ($time_data as $nt => $stimes) {
if (isset($stimes['id']) && $stimes['id'] == $tID) {
if (isset($stimes['status']) && $stimes['status'] == 1) {

//time_period	
if (isset($stimes['time_period'])) {
$timea = explode($ag_separator[2], $stimes['time_period']);
if (isset($timea[0])) {$time_start = $timea[0];}
if (isset($timea[1])) {$time_end = $timea[1];}
}// isset time_period

if (isset($stimes['spots'])) {$time_spots = (int)$stimes['spots'];}


if (!empty($time)) {
foreach ($times as $p => $t) {
$pspots = 1;
if ($time_start == $t) {
	
$m_spots = ag_booking_time_spots($t, $time_end, $date, $id, $parallel, $odb);

$f_spots = $time_spots - $m_spots;

if (isset($spotsa[$p])) {$pspots = (int)$spotsa[$p];}

if ($f_spots <= 0) {
	$time_close .= '<strong>'.$t.'</strong>,';
	}
	
$check_spots = $f_spots - $pspots;
if ($check_spots < 0) {
	
	$ag_lng['left_spots'] = str_replace('%s', $f_spots, $ag_lng['left_spots']);
	
    $spots_close .= '<strong>'.$t.'</strong>,';
    }
	
}
}
}


if (isset($stimes['price'])) {$time_price = $stimes['price'];}
if (isset($stimes['staffs_appoint'])) {$time_staff = $stimes['staffs_appoint'];}
$count_spots = 1;
if (isset($stimes['no_count_spots']) && $stimes['no_count_spots'] == '1') { $count_spots = 0; }


$serv_times[$tID]['time_start'] = $time_start;
$serv_times[$tID]['time_end'] = $time_end;
$serv_times[$tID]['price'] = $time_price;
$serv_times[$tID]['staffs'] = $time_staff;
$serv_times[$tID]['spots'] = $time_spots;
$serv_times[$tID]['count_spots'] = $count_spots;

}// status time
}// id time	
}// foreach time_data	
}// foreach times_arr in schedule	
}// isset schedule times
	
	
}// status schedule
}// id schedule
}// foreach s_data




//check booking time
if (!empty($time_close)) {
if ($time_close[strlen($time_close) - 1] == ',') {$time_close = substr($time_close , 0, -1);}
$time_close = str_replace(',', ', ', $time_close);
$ag_lng['error_booking_time'] = str_replace('%s', $time_close.' ('.$cd.'.'.$cm.'.'.$cy.')', $ag_lng['error_booking_time']);
$result['error'] = $ag_lng['error_booking_time'];	
}	

//check booking spots
if (!empty($spots_close)) {
if ($spots_close[strlen($spots_close) - 1] == ',') {$spots_close = substr($spots_close , 0, -1);}
$spots_close = str_replace(',', ', ', $spots_close);
$result['error'] = $ag_lng['error_booking_spots'].': '.$spots_close;	
}	


$not_found_times = '';
$nfta = array();
$cts = 0;
$total_price = 0;
$total_time = '';
$total_staff = '';
$total_spots = '';
$time_spots_asort = array();


foreach ($times as $k => $v) {
foreach ($serv_times as $tId => $set_time) { $cts++;
if (isset($set_time['time_start']) && isset($set_time['price'])) {
if ($set_time['time_start'] == $v) {
	
$t_spots = 1;
$nfta[$cts]	= $set_time['time_start'];



if (isset($spotsa[$k])) {$t_spots = (int)$spotsa[$k];}

$time_spots_asort[$v] = $t_spots;


if (strpos($swing_price, '%') === false) { 
	$set_time['price'] = $set_time['price'] + $swing_price;
	} else {
	$spercent = $set_time['price'] * $swing_price / 100;
	$set_time['price'] = $set_time['price'] + $spercent;
	}



if ($set_time['count_spots'] == 1) {	
$set_time['price'] = $set_time['price'] * $t_spots;	// price * spots
}

$total_price += $set_time['price']; // count total price


}
}
}
}

//time & spots sort

foreach ($serv_times as $tsId => $sset_time) {
foreach ($time_spots_asort as $k => $v) {
if (isset($sset_time['time_start']) && isset($sset_time['time_end']) && isset($sset_time['staffs'])) {
if ($sset_time['time_start'] == $k) {

$total_time .= $sset_time['time_start'].'-'.$sset_time['time_end'].'#';
$total_staff .= $sset_time['staffs'].'#';
$total_spots .= $v.'#';

}
}
}	
}




if ($total_price < 0) {$total_price = 0;}

if (!empty($total_time) && $total_time[strlen($total_time) - 1] == '#') {$total_time = substr($total_time , 0, -1);}
$total_time = str_replace('#', $ag_separator[2], $total_time);


if (!empty($total_spots) && $total_spots[strlen($total_spots) - 1] == '#') {$total_spots = substr($total_spots , 0, -1);}
$total_spots = str_replace('#', $ag_separator[2], $total_spots);


if (!empty($total_staff) && $total_staff[strlen($total_staff) - 1] == '#') {$total_staff = substr($total_staff , 0, -1);}
$total_staff = str_replace('#', $ag_separator[2], $total_staff);
if ($total_staff == $ag_separator[2]) {$total_staff = '';}
$total_staff_a = explode($ag_separator[2], $total_staff);
$total_staff_a = array_diff($total_staff_a, array(''));
$total_staff_a = array_unique($total_staff_a);
$total_staff = implode($ag_separator[2], $total_staff_a);




foreach ($times as $tcheck) {
if (!in_array($tcheck, $nfta)) {$not_found_times .= '<strong>'.$tcheck.'</strong>; ';}
}

if (!empty($not_found_times)) {
if ($not_found_times[strlen($not_found_times) - 2] == ';') {$not_found_times = substr($not_found_times , 0, -2);}
$result['error'] = $ag_lng['error_not_found_times'].' ('.$not_found_times.')';
}



if ($found_serv == 0) { $result['error'] = $ag_lng['error_sevice_not_found']; }	






// order add
$result['time'] = $total_time;
$result['price'] = $total_price;
$result['spots'] = $total_spots;
$result['staffs'] = $total_staff;
$result['payment_important'] = $payment_important;


	
return $result;	
}// ag_order_post_check



function ag_check_num($add_num, $orders) {
$res = $add_num;
$found_n = 0;
foreach ($orders as $chno) {
if (isset($chno['number_order']) && $chno['number_order'] == $add_num) { $found_n = 1;
	$res = $add_num + 1;
	}	
}
if ($found_n == 1) { $res = ag_check_num($res, $orders); }
return $res;
}// ag_check_num


function ag_order_process($post) {

global $ag_lng;
global $ag_lng_monts_r;
global $ag_data_dir;
global $agt;
global $ag_separator;	
global $ag_booking_inputs;
global $ag_orders_db;
global $ag_orders_dir;
global $ag_orders_file;
global $ag_get_schedule;

global $ag_this_serv_cat;
global $ag_cat;

global $ag_cfg_a_color;
global $ag_cfg_title;
global $ag_cfg_description;
global $ag_cfg_email;
global $ag_auth_this_staff;

global $ag_order_status;

global $srv_absolute_url;

global $ag_get_confirm;
global $ag_get_pay;



unset($error);





$success = 'false';
$mess = '<strong>'.$ag_lng['error'].'</strong>';
$empty_inputs = '';	


//no check for edit & reserve	
if (!empty($ag_auth_this_staff)) {
if (isset($post['phone']) && empty($post['phone'])) {$post['phone'] = 'no';}
if (isset($post['email']) && empty($post['email'])) {$post['email'] = 'no';}	
}		
//no check for edit & reserve


if (isset($_GET['edit']) && empty($ag_auth_this_staff)) {
$success = 'false';
$mess = '<strong>'.$ag_lng['error'].' </strong>';
$error = 1;	
}




foreach ($post as $k => $v) {

// empty check
foreach ($ag_booking_inputs as $ni => $vi) {
$via = explode(':', $vi);
if (isset($via[0]) && isset($via[1]) && isset($via[2])) {


	
if ($via[0] == $k && $via[2] == '1') {
if (empty($v) || iconv_strlen($v, 'UTF-8') < 2) {
	$empty_inputs_name = $k;
	if (isset($ag_lng[$k])) {$empty_inputs_name = $ag_lng[$k];}
	$empty_inputs .= $empty_inputs_name. '; ';
	}	
}
}
}// foreach ag_booking_inputs
	
	
}// foreach post

if (!empty($empty_inputs)) {
if ($empty_inputs[strlen($empty_inputs) - 2] == ';') {$empty_inputs = substr($empty_inputs, 0, -2);}
$success = 'false';
$mess = '<p><strong>'.$ag_lng['error'].'</strong></p><p>'.$ag_lng['error_empty_inputs'].':</p><p>'.$empty_inputs.'</p>';
$error = 1;
}


if (!empty($ag_auth_this_staff)) {} else {

//check email
if (isset($post['email']) && !empty($post['email'])) {
if(!preg_match('/.+@.+..+/i', $post['email'])) { 
$success = 'false';
$mess = $mess.'<p>'.$ag_lng['error_input_email'].'</p>';
$error = 1;
} else {
$mail_check_a = explode('@', $post['email']);
$url_check_add_domain = '';
if (isset($mail_check_a[1])) {
$url_check_add_domain = $mail_check_a[1];
} else { 
$success = 'false';
$mess = $mess.'<p>'.$ag_lng['error_input_email'].'</p>';
$error = 1;
}
if (!empty($url_check_add_domain)) {
if (dns_get_record($url_check_add_domain, DNS_MX)) { } else { 
$success = 'false';
$mess = $mess.'<p>'.$ag_lng['error_valid_email'].'</p>';
$error = 1;
}
}//!empty url_check_add_domain	
}//valid email	
}

//check phone
if (isset($post['phone']) && !empty($post['phone'])) {
if (preg_match("/[^0-9+( )-]/u", $post['phone'])) {
$success = 'false';
$mess = $mess.'<p>'.$ag_lng['error_input_phone'].'</p>';
$error = 1;
}	
}

}// no check for edit & reserve



//check date time spots
if (isset($_GET[$ag_get_schedule]) && isset($post['date']) && isset($post['time']) && isset($post['spots'])) {
$_GET[$ag_get_schedule] = htmlspecialchars($_GET[$ag_get_schedule], ENT_QUOTES, 'UTF-8');
$post_check = ag_order_post_check($_GET[$ag_get_schedule], $post['date'], $post['time'], $post['spots']);
if (isset($post_check['error'])) {
$success = 'false';
$mess = $mess.'<br />'.$post_check['error'];
$error = 1;	
}
}



$post = array_merge($post, $post_check);





$ag_need_confirm = 0;
$ag_pay_important = 0;
$ag_pay_time = 10;
$ag_signature_message_order = '';
if (isset($post['service'])) {
if (file_exists($ag_data_dir.'/service'.$agt)) {
$obj_serv_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_serv_data as $serv) {
if (isset($serv['id']) && $serv['id'] == $post['service']) { 
if (isset($serv['need_confirm']) && $serv['need_confirm'] == 1) {$ag_need_confirm = 1;}
if (isset($serv['payment_important']) && $serv['payment_important'] == 1) {$ag_pay_important = 1;}
if (isset($serv['payment_important_time']) && !empty($serv['payment_important_time']) && $serv['payment_important_time'] != '0') {$ag_pay_time = $serv['payment_important_time'];}
if (isset($serv['signature_message_order'])) {$ag_signature_message_order = $serv['signature_message_order'];}
break;}// id
}// foreach obj_serv_data
}// file_exists
}








if (!isset($error)) {
	

	
//order add 
$message = '';

$date_db = $ag_orders_file;
$dno = date('m');
if (isset($post['date'])) {
$date_a = explode('-', $post['date']);
if (isset($date_a[0]) && isset($date_a[1])) {$date_db = $date_a[1].'_'.$date_a[0]; $dno = $date_a[1];}  
}


$add_order_line = ''; 
$add_order_line_check_change = '';
$added_order = '';
$num_order = '';




$id_order = 'order_'.date('d_m_Y_H_i_s').'_'.rand(10, 99);

if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {
$id_order = $_GET['order'];
if (file_exists($ag_orders_dir.'/'.$_GET['m_y'].$agt)) {
	$eodata = ag_read_data($ag_orders_dir.'/'.$_GET['m_y'].$agt);
	foreach ($eodata as $eoc) {
	if (isset($eoc['id']) && $eoc['id'] == $id_order) {
		if (isset($eoc['added'])) {$added_order = $eoc['added'];}
		if ($date_db == $_GET['m_y']) {	
		if (isset($eoc['number_order'])) {$num_order = $eoc['number_order'];}
		}
		}	
	}
}
}//edit






//number order

if (empty($num_order)) {

$onyyyy = strval(date('Y') + 1);
$ony = 1;
if (isset($onyyyy[3])) { $ony = $onyyyy[3]; }
if ($ony == 0) {$ony = 1;}
$onmindex = date('m');
$onmindex = (int)$onmindex + 8;
if ($onmindex < 10) {$onmindex = '0'.$onmindex;}
$num_order = $ony.$dno.$onmindex.rand(10, 99); 

//$num_order = '1111';//check

$ag_file_check = $ag_orders_dir.'/'.$date_db.$agt;
$chnoa = array();
if (file_exists($ag_file_check)) {$chnoa = ag_read_data($ag_file_check);}


/*
foreach ($chnoa as $chno) {
if (isset($chno['number_order']) && $chno['number_order'] == $num_order) {
	$num_order = $num_order + 1;
	}
}
*/

$num_order = ag_check_num($num_order, $chnoa);


}// empty number
//number order





$success = $num_order; $mess = ''; // order ok!




$ag_str_sep_add_info = '::';
$ag_user_id = '';

if (empty($added_order)) {
$added_order = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR'];
}

$ag_count_add = 0;
  
$sms_time = '';  
$sms_date = '';
$sms_price = '';
$sms_name = '';
 
foreach ($ag_orders_db as $n => $name) {
$value = '';
if (isset($post[$name])) {$value = $post[$name];}
	
if ($name == 'id') {$value = $id_order;}
if ($name == 'number_order') {$value = $num_order;}
if ($name == 'added') {$value = $added_order;}
if ($name == 'status') {
	$value = '1';
	if (isset($post['ag_order_status'])) {$value = $post['ag_order_status'];}
}
if ($name == 'category') {$value = $ag_this_serv_cat;}


//message
$name_li = $name;
$td_style_title = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#fafafb;width:160px;max-width:210px;color:#75757f"';
$td_style_title_2 = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#fafafb;width:160px;max-width:210px;color:#75757f"';

$td_style_title_o = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#FFFFE0;width:160px;max-width:210px;color:#000"';

$td_style_value = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#fff;width:auto"';
$td_style_value_2 = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#fff;width:auto"';
$td_style_value_3 = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:8px 16px;background:#fff;width:auto"';

$td_style_value_o = ' style="vertical-align:top;border:#e3e3e9 1px solid;padding:16px;background:#FFFFE0;width:auto"';

if (isset($ag_lng[$name])) {$name_li = $ag_lng[$name];}
if ($name == 'number_order') {$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$num_order.'</td></tr>';}

if ($name == 'status') {
	$ag_mo_status = '1';
	if (isset($post['ag_order_status'])) {$ag_mo_status = $post['ag_order_status'];}
	$ag_check_confirm_st = $ag_mo_status;
	$ag_ost_style = '';
	if ($ag_mo_status == '0') {$ag_ost_style = ' style="color:#f03000"';}
	if ($ag_mo_status == '1') {$ag_ost_style = ' style="color:#39373d"';}
	if ($ag_mo_status == '2') {$ag_ost_style = ' style="color:#0047ab"';}
	if ($ag_mo_status == '3') {$ag_ost_style = ' style="color:#54911F"';}
	
	if (isset($ag_order_status[$ag_mo_status])) {
		$ag_ostd = $ag_order_status[$ag_mo_status]; 
		if (isset($ag_lng[$ag_ostd])) {$ag_mo_status = $ag_lng[$ag_ostd];}
	}
	
	$message .= '<tr><td'.$td_style_title.'>'.$ag_lng['order_status'].':</td><td'.$td_style_value.'><strong'.$ag_ost_style.'>'.$ag_mo_status.'</strong></td></tr>';
	
	//confirm link
	if ($ag_check_confirm_st == '1' && $ag_need_confirm == 1 && $ag_pay_important == 0) {
	$ag_order_confirm_link = $srv_absolute_url.'?'.$ag_get_confirm.'='.$num_order;
	
$ag_dir = ag_apanel('../');
$ag_dir = str_replace('../', '', $ag_dir);
$ag_order_confirm_link = str_replace($ag_dir, '', $ag_order_confirm_link);
	
	//$message .= '<tr><td'.$td_style_title_o.'>'.$ag_lng['confirm_order'].':</td><td'.$td_style_value_o.'><a href="'.$ag_order_confirm_link.'" style="color:#FC8F1A">'.$ag_lng['confirm_order_link'].'</a></td></tr>';	
	
	$message .= '<tr><td'.$td_style_value_o.' colspan="2"><a href="'.$ag_order_confirm_link.'" style="display:block;background:#FC8F1A;color:#fff;padding:16px 21px;text-align:center;text-decoration:none;border-radius:3px">'.$ag_lng['confirm_order'].'</a></td></tr>';	
	
	}
	
	
	// pay link
	if ($ag_check_confirm_st == '1' && $ag_pay_important == 1) {
		
	$ag_order_confirm_link = $srv_absolute_url.'?'.$ag_get_confirm.'='.$num_order.'&amp;'.$ag_get_pay;
	
$ag_dir = ag_apanel('../');
$ag_dir = str_replace('../', '', $ag_dir);
$ag_order_confirm_link = str_replace($ag_dir, '', $ag_order_confirm_link);
	$ag_pay_order_notice_time = str_replace('%s', $ag_pay_time, $ag_lng['pay_order_notice_time']);
	$message .= '<tr><td'.$td_style_title_o.' colspan="2">'.$ag_lng['pay_order_message'].': <a href="'.$ag_order_confirm_link.'" style="color:#FC8F1A">'.$ag_lng['pay_order_now'].'</a><br /><small>'.$ag_pay_order_notice_time.'</small></td></tr>';
		
	}
	
	
	
	
	}

if ($name == 'title') {
	$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';
	$sms_name = $post[$name];
	}
if ($name == 'date') {
	$mdatea = explode('-', $post[$name]);
	$mdated = '';
	$mdatem = '';
	$sdatem = '';
	$mdatey = '';
	if (isset($mdatea[0])) {$mdatey = $mdatea[0];}
	if (isset($mdatea[1])) {$mdatem = $mdatea[1]; if (isset($ag_lng_monts_r[$mdatem])) {$mdatem = $ag_lng_monts_r[$mdatem];}}
	if (isset($mdatea[1])) {$sdatem = $mdatea[1];}
	if (isset($mdatea[2])) {$mdated = $mdatea[2];}
	
	$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'><strong>'.$mdated.' '.$mdatem.' '.$mdatey.'</strong></td></tr>';
	$sms_date = $mdated.'.'.$sdatem.'.'.$mdatey;
}

if ($name == 'time') {
	$mtimea = explode($ag_separator[2], $post[$name]);
	$mspotsa = array();
	if (isset($post['spots'])) {$mspotsa = explode($ag_separator[2], $post['spots']);}
	$mtimes = '';
	
	foreach ($mtimea as $nt => $mtime) {
	$mspots = '';
	
	$ch_spots = 0;
	foreach ($mspotsa as $cs) {if ($cs > 1) {$ch_spots = 1; break;}}
	
	if (isset($mspotsa[$nt]) && $ch_spots == 1) {$mspots = 'x '.$mspotsa[$nt].'';}
	
	$mtimes .= '<tr><td style="border:none;background:none;padding:8px 0;"><strong>'.$mtime.'</strong></td><td style="border:none;background:none;padding:8px;">'.$mspots.'</td></tr>'; 
	
	$sms_timea = explode('-', $mtime);
	if (isset($sms_timea[0])) {$sms_time .= $sms_timea[0].',';}
	}
	$mtimes = str_replace('-', ' - ', $mtimes);
	$mtimes = '<table style="border-collapse:collapse;border:none;background:none;padding:0;margin:0">'.$mtimes.'</table>';
	$message .= '<tr><td'.$td_style_title.'>'.$ag_lng['booking_time'].':</td><td'.$td_style_value_3.'>'.$mtimes.'</td></tr>';
	}
/*	
if ($name == 'spots') {
	$message .= '';
	$message .= '<tr><td'.$td_style_title.'>'.$ag_lng['count_spots'].':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';
	}
*/

if ($name == 'currency') {
	$sms_price = $sms_price.$post[$name];
	}

if ($name == 'price') {
	if ($post[$name] > 0) {
	$mcurr = '';
	if (isset($post['currency'])) {$mcurr = $post['currency'];}
	$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'><strong>'.$post[$name].'</strong> '.$mcurr.'</td></tr>';
	$sms_price = $post[$name];
	}
}

if ($name == 'first_name') {$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';}
if ($name == 'family_name') {$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';}
if ($name == 'email') {$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';}
if ($name == 'phone') {$message .= '<tr><td'.$td_style_title.'>'.$name_li.':</td><td'.$td_style_value.'>'.$post[$name].'</td></tr>';}
if ($name == 'comment') {
	$mcomment = str_replace($ag_separator[3], '<br />', $post[$name]);
	$mcomment_check = strip_tags($mcomment, '');
	if (!empty($mcomment_check)) {
	$message .= '<tr><td'.$td_style_title_2.'>'.$name_li.':</td><td'.$td_style_value_2.'><i>'.$mcomment.'</i></td></tr>';
	}
	}


$add_order_line .= $name.$ag_separator[1].$value.$ag_separator[0];
}	

 
$ag_file_name = $ag_orders_dir.'/'.$date_db.$agt;
 
$ag_lines = array(); 
if (file_exists($ag_file_name)) {
	
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
if (filesize($ag_file_name) != 0) { $ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name))); } else { $ag_lines = array(); }	
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp); 
 
}//file_exists 
 else {
$ag_order_file_create = fopen($ag_file_name, "w"); // create data file
fwrite($ag_order_file_create, '');
fclose ($ag_order_file_create);
}

$ag_count_add = sizeof($ag_lines);



if (!empty($add_order_line)) {
	

	
// EDIT	-----------
if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {


//replace



	
	
// this data file	
if ($date_db == $_GET['m_y']) {	

if (file_exists($ag_file_name)) {
	
$ag_data_orders = ag_read_data($ag_file_name);
foreach ($ag_data_orders as $onum => $eod) {
if (isset($eod['id']) && $eod['id'] == $_GET['order']) {$ag_edit_line = $onum;} 	
}





//check change line
if (isset($ag_edit_line) && isset($ag_lines[$ag_edit_line])) { 
//changed'.$ag_separator[1].' '.$ag_separator[0].'
$add_order_line_check_change = $ag_lines[$ag_edit_line]; 


$old_cd = ag_str_cat($add_order_line_check_change, 'changed'.$ag_separator[1].'', ''.$ag_separator[0].'');
$add_order_line_check_change = str_replace($old_cd, 'changed'.$ag_separator[1].''.$ag_separator[0].'', $add_order_line_check_change);


}



unset($no_change_edit);
if ($add_order_line_check_change == $add_order_line) {
$success = 'false';
$mess = $ag_lng['error_no_change'];
$no_change_edit = 1;


} else { //change info

$change_info = '';
	
$ag_str_sep_add_info = '::';
$ag_user_id = $ag_auth_this_staff['name'];

$change_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR'];
$add_order_line = str_replace('changed'.$ag_separator[1].'', 'changed'.$ag_separator[1].''.$change_info, $add_order_line);	
}


//$success = 'false';
//$mess = $add_order_line_check_change.'<hr />'.$add_order_line;







if (isset($ag_edit_line) && !isset($no_change_edit)) {
$ag_contents = file_get_contents($ag_file_name);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$ag_edit_line])) {

$ag_contents[$ag_edit_line] = $add_order_line;
if (is_writable($ag_file_name)) {
	
   if (!$ag_handle = fopen($ag_file_name, 'wb')) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. ' - ' .$ag_file_name; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. ' - ' .$ag_file_name; }
   fclose($ag_handle);
    
}
}
}//isset ag_edit_line
}//file_exists ag_file_name


} else { // file = get m_y




//change info
if ($add_order_line_check_change != $add_order_line) {
$change_info = '';
	
$ag_str_sep_add_info = '::';
$ag_user_id = $ag_auth_this_staff['name'];


$change_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR'];
$add_order_line = str_replace('changed'.$ag_separator[1].'', 'changed'.$ag_separator[1].''.$change_info, $add_order_line);	
}





if ($ag_count_add > 0) {

$ag_br = "\n"; 
$ag_rec = "a+";
$ag_fp = fopen($ag_file_name, $ag_rec);
flock($ag_fp, LOCK_SH);  
fputs($ag_fp, "$ag_br$add_order_line"); 
flock ($ag_fp, LOCK_UN);
fclose($ag_fp); 

} else {

$ag_br = '';
$ag_rec = "w";
$add_file_create = fopen($ag_file_name, $ag_rec); // create data file
fwrite($add_file_create, "$ag_br$add_order_line");
fclose ($add_file_create);

}// ADD



// DELETE
$ag_file_name_del = $ag_orders_dir.'/'.$_GET['m_y'].$agt;

if (file_exists($ag_file_name_del)) {
	
$ag_data_orders_del = ag_read_data($ag_file_name_del);
foreach ($ag_data_orders_del as $onumd => $eodd) {
if (isset($eodd['id']) && $eodd['id'] == $_GET['order']) {$ag_delete_line = $onumd;} 	
}	
	
if (isset($ag_delete_line))	{
$ag_fp = fopen($ag_file_name_del, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name_del)));	
$ag_br = "\n";

if (isSet($ag_lines[(integer) $ag_delete_line]) == true) {   
        unset($ag_lines[(integer) $ag_delete_line]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode($ag_br, $ag_lines)));
    }
}// num line
}//file_exists ag_file_name_del

}// DELETE


//--replace



} else { // // ADD	----------------
	
	
if ($ag_count_add > 0) {

$ag_br = "\n"; 
$ag_rec = "a+";
$ag_fp = fopen($ag_file_name, $ag_rec);
flock($ag_fp, LOCK_SH);  
fputs($ag_fp, "$ag_br$add_order_line"); 
flock ($ag_fp, LOCK_UN);
fclose($ag_fp); 

} else {

$ag_br = '';
$ag_rec = "w";
$add_file_create = fopen($ag_file_name, $ag_rec); // create data file
fwrite($add_file_create, "$ag_br$add_order_line");
fclose ($add_file_create);

}// ADD
 
 
}// GET EDIT
}// no empty line

 
 
// sent mail 

$staffs_id_a = array();
$staff_sms = array();
$staff_mail = array();




 
if (isset($post['staffs']) && !empty($post['staffs'])) {
$staffs_id_a = explode($ag_separator[2], $post['staffs']);
}  
$sms_this_time = date("H:i");
$sms_this_time = date("H:i", strtotime($sms_this_time));

foreach ($staffs_id_a as $staffId) {

if (file_exists($ag_data_dir.'/staff'.$agt)) {
$staff_data = ag_read_data($ag_data_dir.'/staff'.$agt);	
foreach ($staff_data as $staff) {
if (isset($staff['id']) && $staff['id'] == $staffId) {
if (isset($staff['status']) && $staff['status'] == 1) {
	
if (
isset($staff['phone_formated']) && 
isset($staff['api_id_sms']) && 
!empty($staff['phone_formated']) && 
!empty($staff['api_id_sms']) && 
isset($staff['sent_sms']) && $staff['sent_sms'] == 1
) {

$sms_time_start = date("H:i", strtotime('00:00'));
$sms_time_end = date("H:i", strtotime('23:59'));
$sms_per_a = array();

if (isset($staff['period_sms'])) {$sms_per_a = explode($ag_separator[2], $staff['period_sms']);}
if (isset($sms_per_a[0]) && !empty($sms_per_a[0])) {$sms_time_start = date("H:i", strtotime($sms_per_a[0]));}
if (isset($sms_per_a[1]) && !empty($sms_per_a[1]) && $sms_per_a[1] != 'XX:XX') {
	if ($sms_per_a[1] == '00:00') {$sms_per_a[1] = '23:59';}
	$sms_time_end = date("H:i", strtotime($sms_per_a[1]));
	}


if ($sms_this_time <= $sms_time_end && $sms_this_time >= $sms_time_start) { 
$staff_sms[$staff['phone_formated']] = $staff['api_id_sms'];
}// sms time period


}// phone && api ID

if (isset($staff['email']) && !empty($staff['email'])) {$staff_mail[$staff['id']] = $staff['email'];}

}// status
}// staff id
}// foreach obj_inc_data
}// file_exists		
	
}// foreach staffs_id_a
 
$staff_mail = array_diff($staff_mail, array(''));
$staff_mail = array_unique($staff_mail); 

$staff_sms = array_diff($staff_sms, array(''));
$staff_sms = array_unique($staff_sms); 
 

//sent mail
if(empty($staff_mail)) { $staff_mail = array($ag_cfg_email); }
if (isset($post['email']) && !empty($post['email']) && $post['email'] != 'no') { array_push($staff_mail, $post['email']); }


if (!empty($staff_mail)) {
	
$other = $_SERVER['REMOTE_ADDR'];
$cname = $ag_cfg_title;
$mail_title = $ag_lng['booking_mail_title'].' - '.$ag_cfg_title;

//edit
if (isset($_GET['edit']) && isset($_GET['order']) && isset($_GET['m_y']) && !empty($ag_auth_this_staff)) {
$mail_title = $ag_lng['order_edit_mail_title'].' - '.$ag_cfg_title;
}

//if (isset($post['first_name']) && !empty($post['first_name'])) {$cname = $post['first_name'];}
//if (isset($post['family_name']) && !empty($post['family_name'])) {$cname = $cname.' '.$post['family_name'];}

if (!empty($ag_signature_message_order)) {
$ag_signature_message_order = str_replace($ag_separator[3], '<br />', $ag_signature_message_order);
$ag_signature_message_order = html_entity_decode($ag_signature_message_order, ENT_QUOTES, 'UTF-8');
$ag_signature_message_order = str_replace('[site_url]', '', $ag_signature_message_order);
$ag_signature_message_order = ag_close_tags($ag_signature_message_order);
$ag_signature_message_order = '<tr><td colspan="2"'.$td_style_value.'>'.$ag_signature_message_order.'</td></tr>';
}
$message = '<table style="border-collapse:collapse;border:0;width:100%">'.$message.$ag_signature_message_order.'</table>';

if (!isset($no_change_edit)) {
ag_sent_mail($staff_mail, $cname, '', $mail_title, $message, $ag_cfg_a_color, $other);
}// yes change

}

//sent sms


if (!isset($no_change_edit)) {
if (!empty($staff_sms)) {
	
if ($sms_time[strlen($sms_time) - 1] == ',') {$sms_time = substr($sms_time, 0, -1);}
$sms_name = ag_rus_translit($sms_name, '');
$sms_txt = $ag_lng['sms_order'].' ('.$_SERVER['HTTP_HOST'].') '.$sms_name.'/'.$sms_date.'/'.$sms_time.'/'.$sms_price;
//$sms_txt = mb_substr($sms_txt, 0, mb_strrpos(mb_substr($sms_txt, 0, 160, 'utf-8'),' ', 'utf-8'), 'utf-8');	
$sms_txt = mb_substr($sms_txt, 0, 160, 'utf-8');




foreach ($staff_sms as $phone => $api_id) {

require_once 'inc/sms/smsru.php';
$sms = new \Zelenin\smsru( $api_id );
$result = $sms->sms_send( $phone, $sms_txt );


/*
require_once 'inc/sms/sms.ru.php';
$smsru = new SMSRU($api_id); // Ваш уникальный программный ключ, который можно получить на главной странице
$data = new stdClass();
$data->to = $phone;
$data->text = $sms_txt; // Текст сообщения
// $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
if (date('G') <= 21 && date('G') >= 9) { } else { // не тризвонить по ночам!
$swing_h = 0;
if (date('G') < 9) {$swing_h = 9 - date('G');}
else {$swing_h = 23 - date('G') + 9;}
$data->time = time() + $swing_h*60*60; // Отложить отправку на N часов до 9 утра
}
// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
$sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
*/

usleep(10000);

	
}// foreach staff_sms
}// staff_sms
}// yes change

}// no error




return ag_success($success, $mess);	
}// ag_order_process








//---------------------------------------------- DISPLAY JSON SCHEDULE
if (isset($_GET[$ag_get_schedule])) {
header('Access-Control-Allow-Origin: *');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
header("Content-Type: application/json;charset=utf-8");
$_GET[$ag_get_schedule] = htmlspecialchars($_GET[$ag_get_schedule], ENT_QUOTES, 'UTF-8');




$not_all_post = 0;
$ag_booking_post_check = 0;
$ag_found_post = array();
foreach ($ag_booking_inputs as $ni => $vi) {
$via = explode(':',$vi);
if (isset($via[0]) && isset($via[1]) && isset($via[2])) {

if (isset($_POST[$via[0]]))	{ 
$ag_booking_post_check = 1; $ag_found_post[$ni] = $via[0];
} else { 

if ($via[2] == '1') { 
$ag_booking_post_check = 0; break;
}

}
}
}
if (!empty($ag_found_post) && $ag_booking_post_check == 0) { 
echo ag_success('false', $ag_lng['error_not_all_post']); die;
}


if ($ag_booking_post_check == 1) {
$ag_order_post = array();
foreach ($_POST as $name => $value) {
	if (isset($_POST[$name])) {
$_POST[$name] = htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8');
$_POST[$name] = str_replace(array($ag_separator[0], $ag_separator[1], $ag_separator[2], $ag_separator[3], $ag_separator[4]), '', trim($_POST[$name])); //separator
foreach ($ag_separator as $ag_separators_str) {
if (isset($ag_separators_str[0]) && isset($ag_separators_str[1]) && isset($ag_separators_str[2])) {
$_POST[$name] = str_replace($ag_separators_str[0].$ag_separators_str[1], '', trim($_POST[$name])); //separator fragment 1	
$_POST[$name] = str_replace($ag_separators_str[1].$ag_separators_str[2], '', trim($_POST[$name])); //separator fragment 2	
}
}	
$_POST[$name] = preg_replace('/[\s]{2,}/', ' ', $_POST[$name]);	
$_POST[$name] = preg_replace('/\\\\+/', '', $_POST[$name]); 
$_POST[$name] = preg_replace("|[\r\n]+|", $ag_separator[3], $_POST[$name]); 
$_POST[$name] = preg_replace("|[\n]+|", $ag_separator[3], $_POST[$name]);	

$ag_order_post[$name] = $_POST[$name]; 

}// isset post name
}// foreach $_POST	

echo ag_order_process($ag_order_post); die;

} else {

echo ag_json_schedule($_GET[$ag_get_schedule]); die;	
}

if (empty($_GET[$ag_get_schedule])) {
$_POST = array();
header('HTTP/1.1 301 Moved Permanently'); header("Location: ".$srv_absolute_url.""); 
}// empty get schedule

}// get schedule	



if (file_exists($ag_data_dir.'/service'.$agt)) {
$ag_services_json = '<ul class="ag_wgt_full_list ag_json_list"><li class="ag_wgt_list ag_cat_name"><h5><i class="icon-calendar"></i>'.$ag_lng['schedule_json_services'].'</h5><ul>';
$obj_inc_data = ag_read_data($ag_data_dir.'/service'.$agt);	
foreach ($obj_inc_data as $inc) {
if (isset($inc['status']) && $inc['status'] == 1) {
if (isset($inc['title']) && isset($inc['id'])) {
$ag_services_json  .= '<li><a href="'.$srv_absolute_url.'?'.$ag_get_schedule.'='.$inc['id'].'">'.$inc['title'].'</a><!-- ('.$srv_absolute_url.'?'.$ag_get_schedule.'='.$inc['id'].') --></li>';	
}
}// status
}// foreach obj_inc_data
$ag_services_json .= '</ul></li></ul>';
}// file_exists	




?>