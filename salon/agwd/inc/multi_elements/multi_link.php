<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


function ag_multi_link($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	

global $ag_separator;
global $ag_lng;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_days;
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
	

$laddress = '';
$ltext = '';	
$count_elements = 0;	
	
if ($access != 1) { $_POST[$name] = $value; 

$value_arr = array();
$values_arr = array();
if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;

$laddress = '';
$ltext = '';
$values_arr = explode('::', $values);
if (isset($values_arr[0])) {$laddress = $values_arr[0];}
if (isset($values_arr[1])) {$ltext = $values_arr[1];}

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';

echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_address" class="ag_noaccess">';
echo '<input type="text" value="'. $laddress .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_text" class="ag_noaccess">';
echo '<input type="text" value="'. $ltext .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';
echo '</div>';

echo '<div class="clear"></div>';
echo '</div></div>';

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


$laddress = '';
$ltext = '';
$values_arr = explode('::', $values);
if (isset($values_arr[0])) {$laddress = $values_arr[0];}
if (isset($values_arr[1])) {$ltext = $values_arr[1];}

echo '<div class="ag_link element_block" id="element_' .$id. '_'.$n. '"><div class="element_inner">';

echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id.'_address_'.$n. '">';
echo '<input type="text" name="' .$name. '['.$n.'][0]" value="' .$laddress. '" placeholder="'.$ag_lng['link_address'].'" class="' .$class. '" id="input_' .$id.'_address_'.$n. '" onfocus="ag_active(\'label_' .$id.'_address_'.$n. '\')" onblur="ag_out(\'label_' .$id.'_address_'.$n. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-link"></i></span>
</span>';
echo '</label>';
echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id.'_text_'.$n. '">';
echo '<input type="text" name="' .$name. '['.$n.'][1]" value="' .$ltext. '" placeholder="'.$ag_lng['link_text'].'" class="' .$class. '" id="input_' .$id.'_text_'.$n. '" onfocus="ag_active(\'label_' .$id.'_text_'.$n. '\')" onblur="ag_out(\'label_' .$id.'_text_'.$n. '\')" />';
echo '<span class="element_tools"><span class="ag_icon_element"><i class="icon-pencil-7"></i></span><span class="ag_remove" onclick="remove_element_' .$id. '(\'element_' .$id. '_'.$n. '\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span></span>';
echo '</label>';
echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';

echo '</div></div>';



}// !empty values
}// foreach value_arr	

}// !empty value	

if ($count_elements == 0) {

echo '<div class="ag_link element_block" id="element_' .$id. '_0"><div class="element_inner">';

echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_address_0">';
echo '<input type="text" name="' .$name. '[0][0]" value="' .$laddress. '" placeholder="'.$ag_lng['link_address'].'" class="' .$class. '" id="input_' .$id. '_address_0" onfocus="ag_active(\'label_' .$id. '_address_0\')" onblur="ag_out(\'label_' .$id. '_address_0\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-link"></i></span>
</span>';
echo '</label>';
echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_text_0">';
echo '<input type="text" name="' .$name. '[0][1]" value="' .$ltext. '" placeholder="'.$ag_lng['link_text'].'" class="' .$class. '" id="input_' .$id. '_text_0" onfocus="ag_active(\'label_' .$id. '_text_0\')" onblur="ag_out(\'label_' .$id. '_text_0\')" />';
echo '<span class="element_tools"><span class="ag_icon_element"><i class="icon-pencil-7"></i></span><span class="ag_remove" onclick="remove_element_' .$id. '(\'element_' .$id. '_0\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span></span>';
echo '</label>';
echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';

echo '</div></div>';

}// empty value	

echo '<div class="clear"></div>';
echo '</div>'; // elements





echo '<div class="ag_add_element" onclick="add_element_' .$id. '()" title="' .$ag_lng['add']. '"><span><i class="icon-plus-circled"></i></span></div>';	

echo '</div>'; // ag_form_element


	
//JS add & remove elements

$ag_append = '<div class=\"ag_link element_block\" id=\"element_' .$id. '_" + ' .$id. '_num + "\"><div class=\"element_inner\" style=\"display:none;\">';

$ag_append .= '<div class=\"ag_two_inputs\">';	
$ag_append .= '<div class=\"ag_two_inputs_inner ag_two_inputs_left\">';
$ag_append .= '<label id=\"label_' .$id. '_address_" + ' .$id. '_num + "\">';
$ag_append .= '<input type=\"text\" name=\"' .$name. '[" + ' .$id. '_num + "][0]\" value=\"\" placeholder=\"'.$ag_lng['link_address'].'\" class=\"' .$class. '\" id=\"input_' .$id. '_address_" + ' .$id. '_num + "\" onfocus=\"ag_active(\'label_' .$id.'_address_" + ' .$id. '_num + "\')\" onblur=\"ag_out(\'label_' .$id.'_address_" + ' .$id. '_num + "\')\" />';
$ag_append .= '<span class=\"element_tools\"><span class=\"ag_icon_element\"><i class=\"icon-link\"></i></span></span>';
$ag_append .= '</label>';
$ag_append .= '</div>';
$ag_append .= '</div>';


$ag_append .= '<div class=\"ag_two_inputs\">';	
$ag_append .= '<div class=\"ag_two_inputs_inner ag_two_inputs_right\">';
$ag_append .= '<label id=\"label_' .$id. '_text_" + ' .$id. '_num + "\">';
$ag_append .= '<input type=\"text\" name=\"' .$name. '[" + ' .$id. '_num + "][1]\" value=\"\" placeholder=\"'.$ag_lng['link_text'].'\" class=\"' .$class. '\" id=\"input_' .$id. '_text" + ' .$id. '_num + "\" onfocus=\"ag_active(\'label_' .$id.'_text_" + ' .$id. '_num + "\')\" onblur=\"ag_out(\'label_' .$id.'_text_" + ' .$id. '_num + "\')\" />';
$ag_append .= '<span class=\"element_tools\"><span class=\"ag_icon_element\"><i class=\"icon-pencil-7\"></i></span><span class=\"ag_remove\" onclick=\"remove_element_' .$id. '(\'element_' .$id. '_" + ' .$id. '_num + "\')\" title=\"' .$ag_lng['remove']. '\"><i class=\"icon-block\"></i></span></span>';
$ag_append .= '</label>';
$ag_append .= '</div>';
$ag_append .= '</div>';
$ag_append .= '<div class=\"clear\"></div>';

$ag_append .= '</div></div>';



echo '
<script>

//*---add---
var ' .$id. '_num = ' .$count_elements. ';

function add_element_' .$id. '() {
' .$id. '_num = ' .$id. '_num + 1;
$("#elements_' .$id. '").append("' .$ag_append. '");
$("#element_' .$id. '_" + ' .$id. '_num + " div.element_inner").fadeIn(400);
setTimeout(function() { $("#input_' .$id. '_" + ' .$id. '_num).focus(); }, 300);
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