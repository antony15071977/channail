<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


function ag_multi_string($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	

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
	

	
	
	
if ($access != 1) { $_POST[$name] = $value; 

$value_arr = array();
if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $values .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

}
}
}


} else { // access

$value_arr = array();

if (isset($_POST[$name])) { $value_arr = $_POST[$name]; }


echo '<div class="ag_form_element" id="' .$id. '">';	
echo '<div id="elements_' .$id. '">';

$count_elements = 0;
if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;
echo '<div class="element_block" id="element_' .$id. '_' .$n. '"><div class="element_inner">';
echo '<label id="label_' .$id. '_' .$n. '" class="' .$class. '">';
echo '<input type="text" name="' .$name. '[' .$n. ']" value="' .$values. '" id="input_' .$id. '_' .$n. '" onfocus="ag_active(\'label_' .$id. '_' .$n. '\')" onblur="ag_out(\'label_' .$id. '_' .$n. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-pencil-7"></i></span>
<span class="ag_remove" onclick="remove_element_' .$id. '(\'element_' .$id. '_' .$n. '\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span>
</span>';
echo '</label>';
echo '</div></div>';
$count_elements = $n;
}// !empty values
}// foreach value_arr	

}// !empty value	

if ($count_elements == 0) {

echo '<div class="element_block" id="element_' .$id. '_0"><div class="element_inner">';
echo '<label id="label_' .$id. '_0" class="' .$class. '">';
echo '<input type="text" name="' .$name. '[0]" value="" id="input_' .$id. '_0" onfocus="ag_active(\'label_' .$id. '_0\')" onblur="ag_out(\'label_' .$id. '_0\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-pencil-7"></i></span>
<span class="ag_disabled"><i class="icon-block"></i></span>
</span>';
echo '</label>';
echo '</div></div>';
}// empty value	

echo '<div class="clear"></div>';
echo '</div>'; // elements

echo '<div class="ag_add_element" onclick="add_element_' .$id. '()" title="' .$ag_lng['add']. '"><span><i class="icon-plus-circled"></i></span></div>';	

echo '</div>'; // ag_form_element


	
//JS add & remove elements
$ag_append = '<div class=\"element_block\" id=\"element_' .$id. '_" + ' .$id. '_num + "\"><div class=\"element_inner\" style=\"display:none;\">';
$ag_append .= '<label id=\"label_' .$id. '_" + ' .$id. '_num + "\" class=\"' .$class. '\">';
$ag_append .= '<input type=\"text\" name=\"' .$name. '[" + ' .$id. '_num + "]\" value=\"00" + (' .$id. '_num + 1)+ "\" id=\"input_' .$id. '_" + ' .$id. '_num + "\" onfocus=\"ag_active(\'label_' .$id. '_" + ' .$id. '_num + "\')\" onblur=\"ag_out(\'label_' .$id. '_" + ' .$id. '_num + "\')\" />';
$ag_append .= '<span class=\"element_tools\"><span class=\"ag_icon_element\"><i class=\"icon-pencil-7\"></i></span><span class=\"ag_remove\" onclick=\"remove_element_' .$id. '(\'element_' .$id. '_" + ' .$id. '_num + "\')\" title=\"' .$ag_lng['remove']. '\"><i class=\"icon-block\"></i></span></span>';
$ag_append .= '</label>';
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