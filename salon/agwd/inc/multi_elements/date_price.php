<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


function ag_date_price($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	

global $ag_separator;
global $ag_lng;
global $ag_lng_value;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_days;
global $ag_lng_days_short;
global $ag_lng_monts_short;
global $ag_mob;

$ag_img_dir = $upload;
global $ag_upload_name;
global $ag_mob_images;
if ($ag_mob == 1) { $ag_img_dir = str_replace($ag_upload_name, $ag_mob_images, $upload); }

if (isset($ag_separator[0])) { $ag_db_seporator = $ag_separator[0]; } else {die;}
if (isset($ag_separator[1])) { $ag_db_seporator_index = $ag_separator[1]; } else {die;}
if (isset($ag_separator[2])) { $ag_db_seporator_array = $ag_separator[2]; } else {die;}
if (isset($ag_separator[3])) { $ag_br = $ag_separator[3]; } else {die;}
if (isset($ag_separator[4])) { $ag_str_seporator = $ag_separator[4]; } else {die;}	
	

$ldate = '';
$lprice = '';	
$count_elements = 0;	
	
if ($access != 1) { $_POST[$name] = $value; 

$value_arr = array();
$values_arr = array();
if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;

$ldate = '';
$lprice = '';
$values_arr = explode('::', $values);
if (isset($values_arr[0])) {$ldate = $values_arr[0];}
if (isset($values_arr[1])) {$lprice = $values_arr[1];}


if (strpos($ldate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $ldate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {
	
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';

echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_address" class="ag_noaccess">';
echo '<input type="text" value="'. $ldate .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_text" class="ag_noaccess">';
echo '<input type="text" value="'. $lprice .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';
echo '</div>';

echo '<div class="clear"></div>';
echo '</div></div>';

}// check date
}// '.' in date
}
}
}


} else { // access

$value_arr = array();

if (isset($_POST[$name])) { 
//array => array
if (!empty($_POST[$name]) && is_array($_POST[$name])) {
foreach ($_POST[$name] as $pn => $ag_paa) {
if (is_array($ag_paa)) { 
$ag_paa = array_diff($ag_paa, array(''));
$ag_paa = array_diff($ag_paa, array('---'));
$ag_paa = array_unique($ag_paa);
$value_arr[$pn] = implode('::', $ag_paa); 
}
}
}
}

echo '<script>var oh = parseFloat($("#ag_main").outerHeight(true)); var oheb = parseFloat($("#ag_edit_block").outerHeight(true));</script>';
echo '<div class="ag_form_element" id="' .$id. '">';	
echo '<div id="elements_' .$id. '">';

$count_elements = 0;
if (!empty($value)) {
	
$value_arr = explode($ag_db_seporator_array, $value);	
	
if (strpos($value, $ag_db_seporator_array) === false) {
$value_arr = array();
$value_arr[0] = $value;
} 
	

foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;


$ldate = '';
$lprice = '';
$values_arr = explode('::', $values);
if (isset($values_arr[0])) {$ldate = $values_arr[0];}
if (isset($values_arr[1])) {$lprice = $values_arr[1];}

if (strpos($ldate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $ldate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {

echo '<div class="ag_link element_block" id="element_' .$id. '_'.$n.'"><div class="element_inner">';

echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';

echo '<label id="label_' .$id. '_date_'.$n.'" onclick="ag_dp_' .$id. '(this)">';
echo '<input type="text" name="' .$name. '['.$n.'][0]" value="'. $ldate .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_date_'.$n.'\')" onblur="ag_out(\'label_' .$id. '_date_'.$n.'\')" id="input_' .$id. '_date_'.$n.'" class="ag_date_price" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-calendar-8"></i></span>';
echo '</span>';
echo '</label>';

echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';

echo '<label id="label_' .$id.'_price_'.$n. '">';
echo '<input type="text" name="' .$name. '['.$n.'][1]" value="' .$lprice. '" placeholder="'.$ag_lng['swing_price'].'" class="ag_swing_price" id="input_' .$id.'_price_'.$n. '" onfocus="ag_active(\'label_' .$id.'_price_'.$n. '\')" onblur="ag_out(\'label_' .$id.'_price_'.$n. '\')" oninput="ag_swingPrice(this)" onpropertychange="ag_swingPrice(this)" />';
echo '<span class="element_tools"><span class="ag_icon_element"><i class="icon-sort"></i></span><span class="ag_remove" onclick="remove_element_' .$id. '(\'element_' .$id. '_'.$n. '\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span></span>';
echo '</label>';

echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';

echo '</div></div>';


$tday = date('j');
$tmonth = date('n') - 1;
$tyear = date('Y');
if (!empty($ldate)) {
$valued_arr = explode('.', $ldate);
if (isset($valued_arr[0])) {$tday = $valued_arr[0];}
if (isset($valued_arr[1])) {$tmonth = $valued_arr[1] - 1;}
if (isset($valued_arr[2])) {$tyear = $valued_arr[2];}
}
echo '<script>';

echo '
var ag_h_offset_' .$id. '_' .$n. ' = $("#label_' .$id. '_date_' .$n. '").outerHeight(true) - ($("#input_' .$id. '_date_' .$n. '").outerHeight(true) * 2) + 2;

var offset_' .$id. '_' .$n. ' = $("#label_' .$id. '_date_' .$n. '").offset().top - $("#' .$id. '").offset().top - ag_h_offset_' .$id. '_' .$n. ' - 7;

var ag_mob_offset_' .$id. '_' .$n. ' = ($("#label_' .$id. '_date_' .$n. '").offset().top - oh) + ag_h_offset_' .$id. '_' .$n. ';
';

echo '$("#input_' .$id. '_date_' .$n. '").datepicker({
startDate: new Date('.$tyear.', '.$tmonth.', '.$tday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$tday. ' && date.getMonth() == ' .$tmonth. ' && date.getFullYear() == ' .$tyear. ') { 
return {
classes: "-setdate-"
}
}
},	
dateFormat: "dd.mm",	
clearButton: false,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';
if ($ag_mob == 1) {echo 'offset: ag_mob_offset_' .$id. '_' .$n. '';} else {echo 'offset: offset_' .$id. '_' .$n. '';}
echo '});

</script>';

}// check date
}// '.' in date


}// !empty values
}// foreach value_arr	

}// !empty value	

if ($count_elements == 0) {
$n = 0;
if (strpos($ldate, '.') === false) { } else {
$check_ldate = array();
$check_ldate = explode('.', $ldate);
if (isset($check_ldate[0]) && isset($check_ldate[1]) && !empty($check_ldate[0]) && !empty($check_ldate[1]) && $check_ldate[0] <= 31 && $check_ldate[1] <= 12) {

echo '<div class="ag_link element_block" id="element_' .$id. '_0"><div class="element_inner">';

echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';

echo '<label id="label_' .$id. '_date_0">';
echo '<input type="text" name="' .$name. '[0][0]" value="'. $ldate .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_date_0\')" onblur="ag_out(\'label_' .$id. '_date_0\')" id="input_' .$id. '_date_0" class="ag_date_price" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-calendar-8"></i></span>';
echo '</span>';
echo '</label>';

echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_price_0">';
echo '<input type="text" name="' .$name. '[0][1]" value="' .$lprice. '" placeholder="'.$ag_lng['swing_price'].'" class="ag_swing_price" id="input_' .$id. '_price_0" onfocus="ag_active(\'label_' .$id. '_price_0\')" onblur="ag_out(\'label_' .$id. '_price_0\')" oninput="ag_swingPrice(this)" onpropertychange="ag_swingPrice(this)" />';
echo '<span class="element_tools"><span class="ag_icon_element"><i class="icon-sort"></i></span><span class="ag_remove" onclick="remove_element_' .$id. '(\'element_' .$id. '_0\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span></span>';
echo '</label>';
echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';

echo '</div></div>';



$tday = date('j');
$tmonth = date('n') - 1;
$tyear = date('Y');

echo '<script>';

echo 'var ag_mob_offset_' .$id. '_0 = $("#label_' .$id. '_date_0").outerHeight(true) - $("#input_' .$id. '_date_0").outerHeight(true);';

echo '$("#input_' .$id. '_date_0").datepicker({
startDate: new Date('.$tyear.', '.$tmonth.', '.$tday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$tday. ' && date.getMonth() == ' .$tmonth. ' && date.getFullYear() == ' .$tyear. ') { 
return {
classes: "-setdate-"
}
}
},
dateFormat: "dd.mm",
clearButton: false,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';

if ($ag_mob == 1) {echo 'offset: ag_mob_offset_' .$id. '_0';} else {echo 'offset: -3';}
echo '});

</script>';
}// check date
}// '.' in date

}// empty value	

echo '<div class="clear"></div>';
echo '</div>'; // elements





echo '<div class="ag_add_element" onclick="add_element_' .$id. '()" title="' .$ag_lng['add']. '"><span><i class="icon-plus-circled"></i></span></div>';	

echo '</div>'; // ag_form_element


	
//JS add & remove elements

$ag_append = '<div class=\"ag_link element_block\" id=\"element_' .$id. '_" + ' .$id. '_num + "\"><div class=\"element_inner\" style=\"display:none;\">';

$ag_append .= '<div class=\"ag_two_inputs\">';	
$ag_append .= '<div class=\"ag_two_inputs_inner ag_two_inputs_left\">';
$ag_append .= '<label id=\"label_' .$id. '_date_" + ' .$id. '_num + "\">';
$ag_append .= '<input type=\"text\" name=\"' .$name. '[" + ' .$id. '_num + "][0]\" readonly=\"readonly\" onfocus=\"ag_active(\'label_' .$id.'_date_" + ' .$id. '_num + "\')\" onblur=\"ag_out(\'label_' .$id.'_date_" + ' .$id. '_num + "\')\" id=\"input_' .$id. '_date_" + ' .$id. '_num + "\" class=\"ag_date_price\" onclick=\"ag_dp_' .$id. '(this)\" />'; 
$ag_append .= '<span class=\"element_tools\">';
$ag_append .= '<span class=\"ag_icon_element\"><i class=\"icon-calendar-8\"></i></span>';
$ag_append .= '</span>';
$ag_append .= '</label>';



$ag_append .= '</div>';
$ag_append .= '</div>';


$ag_append .= '<div class=\"ag_two_inputs\">';	
$ag_append .= '<div class=\"ag_two_inputs_inner ag_two_inputs_right\">';
$ag_append .= '<label id=\"label_' .$id. '_price_" + ' .$id. '_num + "\">';
$ag_append .= '<input type=\"text\" name=\"' .$name. '[" + ' .$id. '_num + "][1]\" value=\"\" placeholder=\"'.$ag_lng['swing_price'].'\" class=\"ag_swing_price\" id=\"input_' .$id. '_price_" + ' .$id. '_num + "\" onfocus=\"ag_active(\'label_' .$id.'_price_" + ' .$id. '_num + "\')\" onblur=\"ag_out(\'label_' .$id.'_price_" + ' .$id. '_num + "\')\" oninput=\"ag_swingPrice(this)\" onpropertychange=\"ag_swingPrice(this)\" />';
$ag_append .= '<span class=\"element_tools\"><span class=\"ag_icon_element\"><i class=\"icon-sort\"></i></span><span class=\"ag_remove\" onclick=\"remove_element_' .$id. '(\'element_' .$id. '_" + ' .$id. '_num + "\')\" title=\"' .$ag_lng['remove']. '\"><i class=\"icon-block\"></i></span></span>';
$ag_append .= '</label>';
$ag_append .= '</div>';
$ag_append .= '</div>';
$ag_append .= '<div class=\"clear\"></div>';

$ag_append .= '</div></div>';



echo '<script>';

echo '$.fn.datepicker.language["'.$ag_lng_value.'"] =  {
    days: ["'.$ag_lng_days[0].'","'.$ag_lng_days[1].'","'.$ag_lng_days[2].'","'.$ag_lng_days[3].'","'.$ag_lng_days[4].'","'.$ag_lng_days[5].'","'.$ag_lng_days[6].'"],
    daysShort: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    daysMin: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    months: ["'.$ag_lng_monts['01'].'","'.$ag_lng_monts['02'].'","'.$ag_lng_monts['03'].'","'.$ag_lng_monts['04'].'","'.$ag_lng_monts['05'].'","'.$ag_lng_monts['06'].'","'.$ag_lng_monts['07'].'","'.$ag_lng_monts['08'].'","'.$ag_lng_monts['09'].'","'.$ag_lng_monts['10'].'","'.$ag_lng_monts['11'].'","'.$ag_lng_monts['12'].'"],
    monthsShort: ["'.$ag_lng_monts_short['01'].'","'.$ag_lng_monts_short['02'].'","'.$ag_lng_monts_short['03'].'","'.$ag_lng_monts_short['04'].'","'.$ag_lng_monts_short['05'].'","'.$ag_lng_monts_short['06'].'","'.$ag_lng_monts_short['07'].'","'.$ag_lng_monts_short['08'].'","'.$ag_lng_monts_short['09'].'","'.$ag_lng_monts_short['10'].'","'.$ag_lng_monts_short['11'].'","'.$ag_lng_monts_short['12'].'"],
    today: "'.$ag_lng['today'].'",
    clear: "'.$ag_lng['reset'].'",
    dateFormat: "dd.mm",
    timeFormat: "hh:ii",
    firstDay: 1
};';

echo '
function ag_dp_' .$id. '(e) {

	var tdate = $(e).val();
	var tdatea = tdate.split(".");
	var tday = tdatea[0];
	var tmonth = tdatea[1];
	var tyear = tdatea[2];
}';



echo '
//*---add---
var ' .$id. '_num = ' .$count_elements. ';

function add_element_' .$id. '() {
' .$id. '_num = ' .$id. '_num + 1;
$("#elements_' .$id. '").append("' .$ag_append. '");
$("#element_' .$id. '_" + ' .$id. '_num + " div.element_inner").fadeIn(400);
setTimeout(function() { $("#input_' .$id. '_date_" + ' .$id. '_num).focus(); }, 300);
';



echo '
var ag_h_offset_' .$id. '_' .$n. ' = $("#label_' .$id. '_date_"  + ' .$id. '_num).outerHeight(true) - ($("#input_' .$id. '_date_" + ' .$id. '_num).outerHeight(true) * 2) + 2;

var offset_' .$id. '_' .$n. ' = $("#label_' .$id. '_date_"  + ' .$id. '_num).offset().top - $("#' .$id. '").offset().top - ag_h_offset_' .$id. '_' .$n. ' - 7;

var ag_mob_offset_' .$id. '_' .$n. ' = ($("#label_' .$id. '_date_"  + ' .$id. '_num).offset().top - oh) + ag_h_offset_' .$id. '_' .$n. ';
';

$tday = date('j');
$tmonth = date('n') - 1;
$tyear = date('Y');

echo '$("#input_' .$id. '_date_" + ' .$id. '_num).datepicker({
startDate: new Date('.$tyear.', '.$tmonth.', '.$tday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$tday. ' && date.getMonth() == ' .$tmonth. ' && date.getFullYear() == ' .$tyear. ') { 
return {
classes: "-setdate-"
}
}
},
dateFormat: "dd.mm",
clearButton: false,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';
if ($ag_mob == 1) {echo 'offset: ag_mob_offset_' .$id. '_' .$n. '';} else {echo 'offset: offset_' .$id. '_' .$n. '';}
echo '});



}

//*---remove---
function remove_element_' .$id. '(id) {
var element_width_' .$id. ' = $("#"+id+" div.element_inner").outerWidth(true);

$("#"+id+" div.element_inner").css({width: element_width_' .$id. ' + "px"});
$("#"+id+" div.element_inner").animate({ marginLeft: "-16px" }, 250).animate({ marginLeft: "120%" }, 180); 
setTimeout(function() { $("#"+id).css({overflow: "hidden"}); $("#"+id).addClass("ag_gradient_after"); }, 300);

setTimeout(function() { $("#"+id).remove(); }, 550);
}
</script>
';	















}// access	
	
	
	
	

}
?>