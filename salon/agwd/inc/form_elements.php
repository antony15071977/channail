<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


$ag_mob = '';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { $ag_mob = 1; }

include('multi_elements/multi_select.php');
include('multi_elements/multi_string.php');
include('multi_elements/multi_media.php');
include('multi_elements/multi_link.php');
include('multi_elements/multi_inp.php');

//booking
if(file_exists('../inc/multi_elements/date_price.php')) {include('multi_elements/date_price.php');}




function ag_form_element($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	
global $ag_separator;
global $ag_lng;
global $ag_lng_value;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_monts_short;
global $ag_lng_days;
global $ag_lng_days_short;
global $ag_mob;
global $agt;
global $ag_data_dir;
global $ag_get_cat;
global $ag_get_obj;
global $ag_get_pay;

if(empty($ag_get_cat)) {$ag_get_cat = 'c';}
if(empty($ag_get_obj)) {$ag_get_obj = 'o';}


$ag_img_dir = $upload;
global $ag_upload_name;
global $ag_mob_images;
if ($ag_mob == 1) { $ag_img_dir = str_replace($ag_upload_name, $ag_mob_images, $upload); }

global $srv_absolute_url;
global $srv_current_path;
$ag_apath_arr = explode('/',$srv_current_path);
array_pop($ag_apath_arr);

$ag_site_url = $srv_absolute_url;
if (isset($ag_apath_arr[(sizeof($ag_apath_arr) - 1)])) {
	$ag_site_url = str_replace($ag_apath_arr[(sizeof($ag_apath_arr) - 1)].'/', '', $srv_absolute_url);
}

if (isset($ag_separator[0])) { $ag_db_seporator = $ag_separator[0]; } else {die;}
if (isset($ag_separator[1])) { $ag_db_seporator_index = $ag_separator[1]; } else {die;}
if (isset($ag_separator[2])) { $ag_db_seporator_array = $ag_separator[2]; } else {die;}
if (isset($ag_separator[3])) { $ag_br = $ag_separator[3]; } else {die;}
if (isset($ag_separator[4])) { $ag_str_seporator = $ag_separator[4]; } else {die;}
	

// ----------------------------hidden
if ($type == 'hidden') {	
if ($access != 1) { $_POST[$name] = $value; } else { //access

if (isset($_POST[$name])) { $value = $_POST[$name]; }	

if ($name != 'hash') {
echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="element_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';
}

}// access
}// ----------------------------hidden


// ----------------------------editor
else if ($type == 'editor') {	
if ($access != 1) { $_POST[$name] = $value; 
$value = str_replace($ag_br, '', $value);
$value = str_replace($ag_site_url, '../', $value);
$value = str_replace('[site_url]', '../', $value);
$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');

echo '<div class="ag_form_element" id="' .$id. '">';

echo '<div id="label_' .$id. '" class="for_editor ' .$class. '">';
echo '<div class="ag_editor_no_access"><div class="ag_post_item">' .$value. '<div class="clear"></div></div></div>';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>
</span>';
echo '</div>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element


} else { //access


echo '<div class="ag_form_element" id="' .$id. '">';

echo '
<div class="focus_editor"></div>
<div class="blur_editor"></div>';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
$value = str_replace($ag_br, '', $value);
$value = str_replace($ag_site_url, '../', $value);
$value = str_replace('[site_url]', '../', $value);

echo '<div id="label_' .$id. '" class="for_editor ' .$class. '" tabindex="-1">';
echo '<textarea name="' .$name. '" class="editor">' .$value. '</textarea>';
echo '<span class="element_tools" tabindex="-1" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">
<span class="ag_icon_element"><i class="icon-doc-text-inv-1"></i></span>
</span>';
echo '</div>';

echo '<script>
$(".focus_editor").click(function(){
ag_active("label_' .$id. '");
});	
$(".blur_editor").click(function(){
ag_out("label_' .$id. '");
});	
</script>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------editor


// ----------------------------email
else if ($type == 'email') {	
if ($access != 1) { 
$_POST[$name] = $value; 


echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';


} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<label id="label_' .$id. '">';
echo '<input type="email" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-mail-2"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------email


// ----------------------------string
else if ($type == 'string') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
if ($name == 'login') {echo '<input type="text" value="'. $ag_lng['disabled'] .'" disabled="disabled" />'; 
} else {
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
}

echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-pencil-7"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------string


// ----------------------------phone
else if ($type == 'phone') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" oninput="ag_phone_check(this)" onpropertychange="ag_phone_check(this)" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-phone-1"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------phone


// ----------------------------pass
else if ($type == 'pass') {	

if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $ag_lng['disabled'] .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	

echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-key-5"></i></span>
</span>';
echo '</label>';
echo '<input type="hidden" name="hash" value="' .$value. '" />';
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access

}// ----------------------------pass

// ----------------------------changepass
else if ($type == 'changepass') {	

if ($access != 1) {  } else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name]) && !empty($_POST[$name])) { $value = $_POST[$name]; } else { $_POST[$name] = $value; }
$value = '';
echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="'.$value.'" placeholder="'.$ag_lng['user_change_pass'].'" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-key-5"></i></span>
</span>';
echo '</label>';
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access

}// ----------------------------changepass


// ----------------------------multistring
else if ($type == 'multistring') {	

ag_multi_string($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);

}// ----------------------------multistring



// ----------------------------date_price
else if ($type == 'year_days') {	
if (function_exists('ag_date_price')) {	
ag_date_price($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);
}
}// ----------------------------date_price



// ----------------------------link
else if ($type == 'link') {	
if ($access != 1) { 
$_POST[$name] = $value; 

$laddress = '';
$ltext = '';

$value_arr = array();
$value_arr = explode($ag_db_seporator_array, $value);
if (isset($value_arr[0])) {$laddress = $value_arr[0];}
if (isset($value_arr[1])) {$ltext = $value_arr[1];}


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

} else { //access

$laddress = '';
$ltext = '';

$value_arr = array();
$value_arr = explode($ag_db_seporator_array, $value);
if (isset($value_arr[0])) {$laddress = $value_arr[0];}
if (isset($value_arr[1])) {$ltext = $value_arr[1];}



echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }

echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_address">';
echo '<input type="text" name="' .$name. '[0]" value="' .$laddress. '" placeholder="'.$ag_lng['link_address'].'" class="' .$class. '" id="input_' .$id. '_address" onfocus="ag_active(\'label_' .$id. '_address\')" onblur="ag_out(\'label_' .$id. '_address\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-link"></i></span>
</span>';
echo '</label>';
echo '</div>';
echo '</div>';


echo '<div class="ag_two_inputs">';	
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_text">';
echo '<input type="text" name="' .$name. '[1]" value="' .$ltext. '" placeholder="'.$ag_lng['link_text'].'" class="' .$class. '" id="input_' .$id. '_text" onfocus="ag_active(\'label_' .$id. '_text\')" onblur="ag_out(\'label_' .$id. '_text\')" />';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-pencil-7"></i></span>
</span>';
echo '</label>';
echo '</div>';
echo '</div>';
echo '<div class="clear"></div>';

echo '</div>'; // ag_form_element
}// access
}// ----------------------------link



// ----------------------------multilink
else if ($type == 'multilink') {	

ag_multi_link($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);

}// ----------------------------multilink


// ----------------------------inputs_custom
else if ($type == 'inputs_custom') {	

ag_multi_inp($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);

}// ---------------------------inputs_custom


// ----------------------------textarea
else if ($type == 'textarea') {	
if ($access != 1) { 
$_POST[$name] = $value; 

$value = str_replace($ag_br, "\n", $value);
$value = str_replace('[:br:]', "\n", $value);
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="for_textarea ag_noaccess">';
echo '<textarea disabled="disabled">'. $value .'</textarea>'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';


} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
$value = str_replace($ag_br, "\n", $value);
$value = str_replace('[:br:]', "\n", $value);
echo '<label id="label_' .$id. '" class="for_textarea">';
echo '<textarea name="' .$name. '" class="' .$class. '" id="element_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">' .$value. '</textarea>';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-edit-alt"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------textarea


// ----------------------------code
else if ($type == 'code') {	
if ($access != 1) { 
$_POST[$name] = $value; 

$value = str_replace($ag_br, "\n", $value);
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="for_textarea ag_noaccess">';
echo '<textarea disabled="disabled">'. $value .'</textarea>'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';


} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
$value = str_replace($ag_br, "\n", $value);


if (strpos($name, 'code') === false) {
if (empty($value)) { $value = ''; }	
} else {
if (empty($value)) { $value = '<?php' ."\n"."\n". '?>'; }
}

echo '<div id="label_' .$id. '" tabindex="-1" class="for_editor ' .$class. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">';
echo '<textarea name="' .$name. '" id="element_' .$id. '">' .$value. '</textarea>';

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-code-3"></i></span>
</span>';
echo '</div>';

echo '<script>
var code_editor_' .$id. ' = CodeMirror.fromTextArea(document.getElementById("element_' .$id. '"), {

mode: "application/x-httpd-php",
tabMode: "indent", 
ctrl_z: "undo", 
ctrl_y: "redo", 
tab: "reindent-selection", 
matchBrackets: true, 
lineNumbers: true,
lineWrapping: true,
indentUnit: 2,
tabSize: 2,
indentWithTabs: true,
matchBrackets: true,
saveCursorPosition: true,
styleActiveLine: true

});	

code_editor_' .$id. '.on("focus", function(){
    ag_active("label_' .$id. '");
});
code_editor_' .$id. '.on("blur", function(){
    ag_out("label_' .$id. '");
});	
</script>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------code




// ----------------------------html_js
else if ($type == 'html_js') {	
if ($access != 1) { 
$_POST[$name] = $value; 

$value = str_replace($ag_br, "\n", $value);
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="for_textarea ag_noaccess">';
echo '<textarea disabled="disabled">'. $value .'</textarea>'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';


} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }
	
$value = str_replace($ag_br, "\n", $value);
//$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');

$value = str_replace('::exactly::', '=', trim($value));

if (empty($value)) { $value = '<script>' ."\n\r"."\n". '</script>'; }

echo '<div id="label_' .$id. '" tabindex="-1" class="for_editor ' .$class. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">';
echo '<textarea name="' .$name. '" id="element_' .$id. '">' .$value. '</textarea>';

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-code-3"></i></span>
</span>';
echo '</div>';

echo '<script>
var code_editor_' .$id. ' = CodeMirror.fromTextArea(document.getElementById("element_' .$id. '"), {

mode: "application/x-httpd-php",
tabMode: "indent", 
ctrl_z: "undo", 
ctrl_y: "redo", 
tab: "reindent-selection", 
matchBrackets: true, 
lineNumbers: true,
lineWrapping: true,
indentUnit: 2,
tabSize: 2,
indentWithTabs: true,
matchBrackets: true,
saveCursorPosition: true,
styleActiveLine: true

});	

code_editor_' .$id. '.on("focus", function(){
    ag_active("label_' .$id. '");
});
code_editor_' .$id. '.on("blur", function(){
    ag_out("label_' .$id. '");
});	
</script>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------html_js





// ----------------------------css
else if ($type == 'css') {	
if ($access != 1) { 
$_POST[$name] = $value; 

$value = str_replace($ag_br, "\n", $value);
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="for_textarea ag_noaccess">';
echo '<textarea disabled="disabled">'. $value .'</textarea>'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
$value = str_replace($ag_br, "\n", $value);
//$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');

echo '<div id="label_' .$id. '" tabindex="-1" class="for_editor ' .$class. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">';

echo '<textarea name="' .$name. '" id="element_' .$id. '">' .$value. '</textarea>';

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-code-3"></i></span>
</span>';
echo '</div>';

echo '<script>
var code_editor_' .$id. ' = CodeMirror.fromTextArea(document.getElementById("element_' .$id. '"), {
    
mode: "text/css",
tabMode: "indent", 
ctrl_z: "undo", 
ctrl_y: "redo", 
tab: "reindent-selection", 
matchBrackets: true, 
lineNumbers: true,
lineWrapping: true,
indentUnit: 2,
tabSize: 2,
indentWithTabs: true,
matchBrackets: true,
saveCursorPosition: true,
styleActiveLine: true

});	

code_editor_' .$id. '.on("focus", function(){
    ag_active("label_' .$id. '");
});
code_editor_' .$id. '.on("blur", function(){
    ag_out("label_' .$id. '");
});	
</script>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------css


// ----------------------------checkbox
else if ($type == 'checkbox') {	

if ($access != 1) { $_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';

$view_value = $ag_lng['no'];
if ($value == '1') {$view_value = $ag_lng['yes'];}
echo '<input type="text" value="'. $view_value .'" disabled="disabled" />'; 

echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';



} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';
$ag_checked = '';
$ag_icon_cb = '<i class="icon-toggle-off"></i>';
$ag_text_cb = $ag_lng['no'];
$ag_class_icb = '';
if (isset($_POST[$name])) { $value = $_POST[$name]; }	
if ($value == 1) {
$ag_checked = ' checked="checked"';
$ag_icon_cb = '<i class="icon-toggle-on"></i>';
$ag_text_cb = $ag_lng['yes'];
$ag_class_icb = ' ag_checked';
}
echo '<label id="label_' .$id. '" class="for_checkbox">';
echo '<input type="checkbox" name="' .$name. '" value="1" class="' .$class. ' ag_hidden" id="element_' .$id. '"' .$ag_checked. ' />';
echo '<span class="element_tools">
<span class="ag_icon_element' .$ag_class_icb. '">'.$ag_icon_cb.'</span>
<span class="ag_cb_text">' .$ag_text_cb. '</span>
</span>';
echo '</label>';

echo '<div id="no_check_' .$id. '"></div>';

echo '
<script>

if ($("#element_' .$id. '").prop("checked") === true) {} else {$("#no_check_' .$id. '").html(\'<input type="hidden" name="' .$name. '" value="0" />\');}

$("#element_' .$id. '").on("click", function() {
if ($(this).prop("checked") === true) {
$(this).find(" + span.element_tools span.ag_icon_element").html("<i class=\"icon-toggle-on\"></i>");
$(this).find(" + span.element_tools span.ag_icon_element").addClass("ag_checked");
$(this).find(" + span.element_tools span.ag_icon_element + span.ag_cb_text").html("' .$ag_lng['yes']. '");
$("#no_check_' .$id. '").html(\'\');
} else {

$(this).find(" + span.element_tools span.ag_icon_element").html("<i class=\"icon-toggle-off\"></i>");	
$(this).find(" + span.element_tools span.ag_icon_element").removeClass("ag_checked");
$(this).find(" + span.element_tools span.ag_icon_element + span.ag_cb_text").html("<input type=\"hidden\" name=\"' .$name. '\" value=\"0\" />' .$ag_lng['no']. '");
$("#no_check_' .$id. '").html(\'<input type="hidden" name="' .$name. '" value="0" />\');
}	
});
</script>
';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------checkbox


// ----------------------------photo
else if ($type == 'photo') {	
if ($access != 1) { 
$_POST[$name] = $value; 
$ag_img_noaccess = '<img src="img/no_photo.png" alt="no photo" />';
if(file_exists($ag_img_dir.$value) && !empty($value)) {
$ag_img_noaccess = '<img src="' .$ag_img_dir.$value. '" alt="no photo" />';	
}
$element_class = '';
if ($name == 'ag_cfg_logo') { $element_class = ' ag_cfg_logo'; } 
echo '<div class="ag_form_element' .$element_class. '" id="element_' .$id. '">';

echo '<div id="' .$id. '" class="for_photo"><div class="ag_photo_inner">';
echo '<div id="img_' .$id. '" class="ag_insert_img">' .$ag_img_noaccess. '</div>';
echo '<div class="clear"></div> </div>'; //ag_photo_inner

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>
</span>';

echo '</div>'; // for_photo
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element


} else { //access

$element_class = '';
if ($name == 'ag_cfg_logo') { $element_class = ' ag_cfg_logo'; } 
echo '<div class="ag_form_element' .$element_class. '" id="element_' .$id. '" onclick="active' .$id. '()">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<div id="' .$id. '" class="for_photo" tabindex="-1" onfocus="ag_active(\'' .$id. '\')" onblur="ag_out(\'' .$id. '\')"><div class="ag_photo_inner">';

echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" />';

echo '<div id="img_' .$id. '" class="ag_insert_img" onclick="ag_open_ifm(\'' .$id. '\', \'\', 1)"></div>';

echo '<script>';
echo 'function active' .$id. '() {$("#' .$id. '").focus();}';

if(file_exists($ag_img_dir.$value)) {
echo '
var val_img_' .$id. ' = $("#input_' .$id. '").val();
if (val_img_' .$id. ' == "" || val_img_' .$id. ' == "img/no_photo.png") { $("#img_' .$id. '").html("<img src=\"img/no_photo.png\" alt=\"' .$name. '\" />"); }
else { $("#img_' .$id. '").html("<img src=\"' .$ag_img_dir. '"+ val_img_' .$id. ' +"\" alt=\"' .$name. '\" />"); }
'; 
} else {
echo ' $("#img_' .$id. '").html("<img src=\"img/no_photo.png\" alt=\"no photo\" />"); ';	
}// file_exists
echo '</script>';

echo '<div class="ag_tools_photo">';
echo '
<span onclick="reset_img(\'' .$id. '\')" class="ag_reset_img ag_btn_small"><i class="icon-block"></i><span>' .$ag_lng['remove']. '</span></span>
<span onclick="ag_open_ifm(\'' .$id. '\', \'\', 1)" tabindex="-1" class="ag_add_img ag_btn_small"><i class="icon-upload-4"></i><span>' .$ag_lng['choice']. '</span></span>

<div class="clear"></div>
</div>
</div>'; // ag_photo_inner for_photo

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-picture-5"></i></span>
</span>';

echo '</div>';
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------photo


// ----------------------------gallery

else if ($type == 'gallery') {	

ag_multi_media($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);

}// ----------------------------gallery




// ----------------------------video
else if ($type == 'video') {	
if ($access != 1) { 
$_POST[$name] = $value; 
$ag_video_noaccess = '<img src="img/no_video.png" alt="no video" />';
if(file_exists($ag_data_dir.$value) && !empty($value)) {
$ag_video_noaccess = '<video src="' .$ag_data_dir.$value. '" controls="controls"></video>';	
}
$element_class = '';
if ($name == 'ag_cfg_logo') { $element_class = ' ag_cfg_logo'; } 
echo '<div class="ag_form_element' .$element_class. '" id="element_' .$id. '">';

echo '<div id="' .$id. '" class="for_photo"><div class="ag_photo_inner">';
echo '<div id="video_' .$id. '" class="ag_insert_img">' .$ag_video_noaccess. '</div>';
echo '<div class="clear"></div> </div>'; //ag_photo_inner

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>
</span>';

echo '</div>'; // for_photo
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element


} else { //access

$element_class = '';
if ($name == 'ag_cfg_logo') { $element_class = ' ag_cfg_logo'; } 
echo '<div class="ag_form_element' .$element_class. '" id="element_' .$id. '" onclick="active' .$id. '()">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<div id="' .$id. '" class="for_photo ag_video" tabindex="-1" onfocus="ag_active(\'' .$id. '\')" onblur="ag_out(\'' .$id. '\')"><div class="ag_photo_inner">';

echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_video_' .$id. '" />';

echo '<div id="video_' .$id. '" class="ag_insert_img" onclick="ag_open_ifm(\'video_' .$id. '\', \'\', 3)"></div>';


echo '<script>';
echo 'function active' .$id. '() {$("#' .$id. '").focus();}';

if(file_exists($ag_data_dir.'/'.$ag_upload_name.$value)) {
echo '
var val_video_' .$id. ' = $("#input_video_' .$id. '").val();
if (val_video_' .$id. ' == "" || val_video_' .$id. ' == "img/no_video.png") { $("#video_' .$id. '").html("<img src=\"img/no_video.png\" alt=\"' .$name. '\" />"); }
else { $("#video_' .$id. '").html("<video src=\"' .$ag_data_dir. '/' .$ag_upload_name. '"+ val_video_' .$id. ' +"\" controls=\"controls\"></video>"); }
'; 
} else {
echo ' $("#video_' .$id. '").html("<img src=\"img/no_video.png\" alt=\"no video\" />"); ';	
}// file_exists
echo '</script>';

echo '<div class="ag_tools_photo">';
echo '
<span onclick="reset_img(\'video_' .$id. '\')" class="ag_reset_img ag_btn_small"><i class="icon-block"></i><span>' .$ag_lng['remove']. '</span></span>
<span onclick="ag_open_ifm(\'video_' .$id. '\', \'\', 3)" tabindex="-1" class="ag_add_img ag_btn_small"><i class="icon-upload-4"></i><span>' .$ag_lng['choice']. '</span></span>

<div class="clear"></div>
</div>
</div>'; // ag_photo_inner for_photo

echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-video-2"></i></span>
</span>';

echo '</div>';
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------video













// ----------------------------select
else if ($type == 'select' || $type == 'selectlink') {	

// no open in iframe
$ag_inc_widgets_arr = array();	
$ag_inc_widgets_str = '';
if (isset($ag_inc_widgets)) {
foreach ($ag_inc_widgets as $kw => $vw) {
$ag_inc_widgets_arr[] = $kw;
$ag_inc_widgets_str .= $kw.',';
}
}	

$opt_search_view = 16;

if ($access != 1) { $_POST[$name] = $value; //access for this input


echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
foreach ($options as $keyopt => $option) {

if (isset($option['id'])) {$optId = $option['id'];}
if (isset($option['name'])) {$optName = $option['name'];}
else if (isset($option['title'])) {$optName = $option['title'];}	

if ($name == 'access') { //access select
if (isset($ag_lng[$optName])) { $optName = $ag_lng[$optName]; }	
if (empty($value)) {$value = sizeof($options);}
if ($value == 'founder') {$optName = $ag_lng['founder'];}
}

if ($optId == $value) { 
echo '<input type="text" value="'. $optName .'" disabled="disabled" />'; 
}
}
if ($value == 'founder'){
echo '<input type="text" value="'. $optName .'" disabled="disabled" />'; 
}

echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';



} else { // access yes

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }

$ag_inp_class = ' ag_'.$value;	

if (strpos($value, '/') === false) { } else {
	$val_class = explode('/', $value);
	$val_class = array_diff($val_class, array(''));
	$ag_inp_class = array_pop($val_class);
	$ag_inp_class = ' ag_'.$ag_inp_class;
}
echo '<label id="label_' .$id. '">';

echo '<input type="text" value="" class="' .$class.$ag_inp_class. '" id="opt_' .$id. '" readonly="readonly" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" />';

echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" />';

echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-down-open-3"></i></span>';

if ($type == 'selectlink' && !isset($_GET['iframe'])) {
	
if (in_array($value, $ag_inc_widgets_arr)) {
echo '<span class="ag_open_item" id="open_item_' .$id. '" onclick="open_item_' .$id. '(\'' .$id. '\')" title="' .$ag_lng['open']. '" style="display:none;"><i class="icon-popup"></i></span>';
} else {	
echo '<span class="ag_open_item" id="open_item_' .$id. '" onclick="open_item_' .$id. '(\'' .$id. '\')" title="' .$ag_lng['open']. '"><i class="icon-popup"></i></span>';
}

}

echo '</span>';
echo '</label>';

// options
echo '<div id="options_' .$id. '" class="ag_select_options ag_search_list">';


//search in list
$opt_count = 0;
foreach ($options as $keyopt => $option) { if (!empty($option)) {$opt_count++;} }
if ($opt_count > $opt_search_view) {
echo '<div class="ag_search_in_list" id="ag_search_list_block_' .$id. '"><div>
<input type="text" id="ag_search_inp_' .$id. '" placeholder="'.$ag_lng['list_search'].'" />
<span id="agt_search_' .$id. '" onclick="ag_search_in_list(\'ag_search_inp_' .$id. '\', \'options_' .$id. '\', \'ag_content_search_list_' .$id. '\', \'agt_search_' .$id. '\', \'agt_search_next_' .$id. '\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_' .$id. '" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
<span id="reset_search_' .$id. '"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div></div>'; //search in list
}


echo '<div class="ag_select_options_inner" id="ag_content_search_list_' .$id. '">';
$optId = '';
$optName = '';

//opt status indicator
$optStat = '1';
$optStat_indicator = '';
$optStat_class = '';
$optStat_off_str = '';
//opt status indicator

$opt_input = '';
$opt_class = '';
$search_val_str = '';
$ag_edit_user_access = '';
echo '<ul>';
foreach ($options as $keyopt => $option) {

if (isset($option['id'])) {$optId = $option['id'];}
if (isset($option['name'])) {$optName = $option['name'];}
else if (isset($option['title'])) {$optName = $option['title'];}


//opt status indicator
$optStat_indicator = '';
$optStat_class = '';
if (isset($option['status'])) {$optStat = $option['status'];}
if ($optStat != 1) {
$optStat_indicator = '<i class="icon-toggle-off" title="' .$ag_lng['status_off']. '"></i>'; 
$optStat_class = ' ag_status_off';
$optStat_off_str .= $optId.',';
}
//opt status indicator


if ($name == 'access') { //access select

if (isset($ag_lng[$optName])) {$optName = $ag_lng[$optName]; }	
if (empty($value)) {$value = sizeof($options);}

// admin option only for founder
foreach ($users as $nu => $ag_user) {
if (isset($ag_user['id']) && isset($ag_user['access'])) { 
if ($user == $ag_user['id']) {$ag_edit_user_access = $ag_user['access'];} // this user access
}// isset id & access
}// foreach  ag_users


}

if ($value == $optId && !empty($value)) {
$opt_class = 'opt_this';
$opt_input = $optName;

	
} else { $opt_class = ''; }
$search_val_str .= $optId.' ';

$ag_opt_id_js = str_replace('/', '_', $optId);
$ag_opt_id_js = str_replace('.', '_point_', $ag_opt_id_js);
$ag_opt_id_js = $ag_opt_id_js.$id;

$ag_val_class = ' ag_'.$optName;

if ($ag_edit_user_access != 'founder' && $name == 'access' && $optId == 1) {} else { // admin option only for founder
echo '<li id="' .$ag_opt_id_js. '" tabindex="-1" onclick="insert_value_' .$id. '(\'' .$ag_opt_id_js. '\', \''.$optName.'\', \'' .$optId. '\', \''.$ag_val_class.'\')" class="' .$opt_class.$optStat_class.$ag_val_class. '">' .$optName.$optStat_indicator. '</li>';	
}// admin option only for founder

}// foreach  options

$check_val = str_replace('/', '_', $value);
$search_val_str = str_replace('/', '_', $search_val_str);
if (!empty($search_val_str) && !preg_match('/'. $check_val .'/', $search_val_str)) {$opt_input = $ag_lng['value_not_found'];}

//reset option
if ($name != 'access') {
if ($id == $name && $name == 'ag_cfg_lng' || $name == 'ag_cfg_home' || $name == 'ag_cfg_home_blocks_row' || $name == 'ag_cfg_editor') {} else {
echo '<li class="ag_reset_select" id="empty_' .$id. '" tabindex="-1" onclick="insert_value_' .$id. '(\'empty_' .$id. '\',\'' .$ag_lng['no_value']. '\')">' .$ag_lng['reset']. ' <i class="icon-cancel-circled-outline"></i></li>';	}
}


echo '</ul>';
echo '</div>';
echo '</div>';
// options

echo '<script>

function ucfirst_' .$id. '(str) 
{
    var first' .$id. ' = str.substr(0,1).toUpperCase();
    return first' .$id. ' + str.substr(1);
}




var sear_view_opt_' .$id. ' = 0;
var opt_input_' .$id. ' = "' .$opt_input. '";
if (opt_input_' .$id. ' == "") {opt_input_' .$id. ' = "' .$ag_lng['no_value']. '";}
$("#opt_' .$id. '").val(ucfirst_' .$id. '(opt_input_' .$id. '));

$("#opt_' .$id. '").focus(function() {
$("#options_' .$id. '").fadeIn(300);
});


$("#ag_search_inp_' .$id. '").focus(function() {
sear_view_opt_' .$id. ' = 1;
});
$("#agt_search_next_' .$id. '").click(function() {
$("#opt_' .$id. '").focus();
sear_view_opt_' .$id. ' = 1;
});
$("#reset_search_' .$id. '").click(function() {
$("#ag_search_inp_' .$id. '").val("");
sear_view_opt_' .$id. ' = 0;
$("#opt_' .$id. '").blur();
});
$("#ag_content_search_list_' .$id. '").click(function() {
sear_view_opt_' .$id. ' = 0;
$("#opt_' .$id. '").blur();
});


$("#opt_' .$id. '").blur(function() {
setTimeout(function(){ 
if (sear_view_opt_' .$id. ' == 0) {
$("#options_' .$id. '").fadeOut(140); 
}
}, 100);
});



//*---status item---
var off_items_' .$id. ' = "' .$optStat_off_str. '".split(",");
var this_item_' .$id. ' = $("#input_' .$id. '").val();
for (var si = 0; si < off_items_' .$id. '.length; si++) {
	if (off_items_' .$id. '[si] != "" && off_items_' .$id. '[si] == this_item_' .$id. ') { $("#opt_' .$id. '").addClass("ag_str_red"); }
}
//*---status item---



function insert_value_' .$id. '(id, name, val, ag_class) {
	
//*---status item---
$("#opt_' .$id. '").removeClass("ag_str_red");	
for (var oi = 0; oi < off_items_' .$id. '.length; oi++) {
	if (off_items_' .$id. '[oi] == val) { $("#opt_' .$id. '").addClass("ag_str_red"); }
}
//*---status item---	
	
	
$("#opt_' .$id. '").val(ucfirst_' .$id. '(name));

$("#opt_' .$id. '").removeAttr("class");
$("#opt_' .$id. '").addClass(ag_class);

if (val == "empty_' .$id. '") {val = ""; $("#opt_' .$id. '").removeAttr("class");}	

$("#input_' .$id. '").val(val);


$("#options_' .$id. ' ul li").removeClass("opt_this");
$("#"+id).addClass("opt_this");


$("#"+id).parents("div.element_inner").find("span.ag_open_item").css({display:"block"});
var wgt_arr' .$id. ' = "'.$ag_inc_widgets_str.'".split(",");
for (var wi = 0; wi < wgt_arr' .$id. '.length; wi++) {
if (wgt_arr' .$id. '[wi] == val) {
$("#"+id).parents("div.element_inner").find("span.ag_open_item").css({display:"none"});
}
}


id = null;
}

//*---open item---
function open_item_' .$id. '(obj_id) {
var item_id = "";
item_id = obj_id;


var cat_id = "";
var cat_id_a = $("#input_"+obj_id).val().split("::");
if (cat_id_a[1] && cat_id_a[0]) {cat_id = cat_id_a[0]; item_id = cat_id_a[1]; }

$(".ag_select_options_inner").css({display: "none"});
setTimeout(function() { $(".ag_select_options").css({display: "none"});  }, 300);

setTimeout(function() { $(".ag_select_options_inner").css({display: "block"}); $("#ag_open_menu").focus();}, 400);

if ($("#input_"+obj_id).val() == "") { 
item_id = ""; 
} 

ag_open_ifm(item_id, cat_id, "ag_item");
item_id = null;
obj_id = null;
}
</script>';


echo '<div class="clear"></div>';
echo '</div>'; // element_block
echo '</div>'; // ag_form_element
}// access
}// ----------------------------select


// ----------------------------multiselect / multiselectlink
else if ($type == 'multiselect' || $type == 'multiselectlink') {

ag_multi_select($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access);
}// ----------------------------multiselect




// ----------------------------icon
else if ($type == 'icon') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
echo '<label id="label_' .$id. '" onclick="ag_open_ifm(\'' .$id. '\', \'\', \'ag_icon\')">';
$ag_icon = '';
if (!empty($value)) {$ag_icon = '<i class="'. $value. '"></i>';}
echo '<span class="ag_icon_input" tabindex="-1" id="icon_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">'.$ag_icon.'</span>';
echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" readonly="readonly" />';
echo '<span class="element_tools" tabindex="-1" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')">
<span class="ag_icon_element"><i class="icon-popup"></i></span>
</span>';
echo '</label>';


echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------icon



// ----------------------------date period
else if ($type == 'date_period') {	

if ($access != 1) { 

$_POST[$name] = $value; 
$val_from = '';
$val_to = '';
$value_arr = explode($ag_db_seporator_array, $value);
if (isset($value_arr[0])) {$val_from = $value_arr[0];}
if (isset($value_arr[1])) {$val_to = $value_arr[1];}
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="' .$ag_lng['period_from']. ': '. $val_from .' - ' .$ag_lng['period_to']. ': ' .$val_to. '" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { // access

$value_arr = explode($ag_db_seporator_array, $value);

if (isset($_POST[$name])) { $value_arr = $_POST[$name]; }

$val_from = '';
$val_to = '';

if (isset($value_arr[0])) {$val_from = $value_arr[0];}
if (isset($value_arr[1])) {$val_to = $value_arr[1];}

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block period_select_date">';

//echo '<div class="datepicker-here"></div>';

// from
echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_from">';
echo '<input type="text" name="' .$name. '[0]" value="'. $val_from .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_from\')" onblur="ag_out(\'label_' .$id. '_from\')" id="input_' .$id. '_from" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-calendar-8"></i></span>';
echo '</span>';
echo '<span class="ag_title_period">' .$ag_lng['period_from']. '</span>';
echo '</label>';
echo '</div>';
echo '</div>';

$fday = date('j');
$fmonth = date('n') - 1;
$fyear = date('Y');
if (!empty($val_from)) {
$val_from_arr = explode('.', $val_from);
if (isset($val_from_arr[0])) {$fday = $val_from_arr[0];}
if (isset($val_from_arr[1])) {$fmonth = $val_from_arr[1] - 1;}
if (isset($val_from_arr[2])) {$fyear = $val_from_arr[2];}
}
echo '<script>';


echo '$.fn.datepicker.language["'.$ag_lng_value.'"] =  {
    days: ["'.$ag_lng_days[0].'","'.$ag_lng_days[1].'","'.$ag_lng_days[2].'","'.$ag_lng_days[3].'","'.$ag_lng_days[4].'","'.$ag_lng_days[5].'","'.$ag_lng_days[6].'"],
    daysShort: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    daysMin: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    months: ["'.$ag_lng_monts['01'].'","'.$ag_lng_monts['02'].'","'.$ag_lng_monts['03'].'","'.$ag_lng_monts['04'].'","'.$ag_lng_monts['05'].'","'.$ag_lng_monts['06'].'","'.$ag_lng_monts['07'].'","'.$ag_lng_monts['08'].'","'.$ag_lng_monts['09'].'","'.$ag_lng_monts['10'].'","'.$ag_lng_monts['11'].'","'.$ag_lng_monts['12'].'"],
    monthsShort: ["'.$ag_lng_monts_short['01'].'","'.$ag_lng_monts_short['02'].'","'.$ag_lng_monts_short['03'].'","'.$ag_lng_monts_short['04'].'","'.$ag_lng_monts_short['05'].'","'.$ag_lng_monts_short['06'].'","'.$ag_lng_monts_short['07'].'","'.$ag_lng_monts_short['08'].'","'.$ag_lng_monts_short['09'].'","'.$ag_lng_monts_short['10'].'","'.$ag_lng_monts_short['11'].'","'.$ag_lng_monts_short['12'].'"],
    today: "'.$ag_lng['today'].'",
    clear: "'.$ag_lng['reset'].'",
    dateFormat: "dd.mm.yyyy",
    timeFormat: "hh:ii",
    firstDay: 1
};';



echo 'var ag_mob_offset_from = $("#label_' .$id. '_from").parents(".ag_two_inputs").position().top + $("#label_' .$id. '_from").outerHeight(true) - 18;';

echo '$("#input_' .$id. '_from").datepicker({
startDate: new Date('.$fyear.', '.$fmonth.', '.$fday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$fday. ' && date.getMonth() == ' .$fmonth. ' && date.getFullYear() == ' .$fyear. ') { 
return {
classes: "-setdate-"
}
}
},		
clearButton: true,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';
if ($ag_mob == 1) {echo 'offset: ag_mob_offset_from';} else {echo 'offset: -3';}
echo '});';
echo '</script>';


//to
echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';
echo '<label id="label_' .$id. '_to">';
echo '<input type="text" name="' .$name. '[1]" value="'. $val_to .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_to\')" onblur="ag_out(\'label_' .$id. '_to\')" id="input_' .$id. '_to" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-calendar-8"></i></span>';
echo '</span>';
echo '<span class="ag_title_period">' .$ag_lng['period_to']. '</span>';
echo '</label>';
echo '</div>';
echo '</div>';

$tday = date('j');
$tmonth = date('n') - 1;
$tyear = date('Y');
if (!empty($val_to)) {
$val_to_arr = explode('.', $val_to);
if (isset($val_to_arr[0])) {$tday = $val_to_arr[0];}
if (isset($val_to_arr[1])) {$tmonth = $val_to_arr[1] - 1;}
if (isset($val_to_arr[2])) {$tyear = $val_to_arr[2];}
}
echo '<script>';
echo 'var ag_mob_offset_to = $("#label_' .$id. '_to").parents(".ag_two_inputs").position().top + $("#label_' .$id. '_to").outerHeight(true) - 10;';
echo '$("#input_' .$id. '_to").datepicker({
startDate: new Date('.$tyear.', '.$tmonth.', '.$tday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$tday. ' && date.getMonth() == ' .$tmonth. ' && date.getFullYear() == ' .$tyear. ') { 
return {
classes: "-setdate-"
}
}
},		
clearButton: true,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';
if ($ag_mob == 1) {echo 'offset: ag_mob_offset_to';} else {echo 'offset: -3';}
echo '});';

echo '</script>';


echo '<div class="clear"></div>';

echo '</div></div>';

	
}// access

}
// ----------------------------date period







// ----------------------------calendar date
else if ($type == 'date') {	

if ($access != 1) { 

$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { // access

//if (empty($value)) {$value = '01.01.2000';}

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block">';


echo '<label id="label_' .$id. '_to">';
echo '<input type="text" name="' .$name. '" value="'. $value .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_to\')" onblur="ag_out(\'label_' .$id. '_to\')" id="input_' .$id. '_to" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-calendar-8"></i></span>';
echo '</span>';
echo '</label>';


$tday = date('j');
$tmonth = date('n') - 1;
$tyear = date('Y');
if (!empty($value)) {
$value_arr = explode('.', $value);
if (isset($value_arr[0])) {$tday = $value_arr[0];}
if (isset($value_arr[1])) {$tmonth = $value_arr[1] - 1;}
if (isset($value_arr[2])) {$tyear = $value_arr[2];}
}
echo '<script>';

echo '$.fn.datepicker.language["'.$ag_lng_value.'"] =  {
    days: ["'.$ag_lng_days[0].'","'.$ag_lng_days[1].'","'.$ag_lng_days[2].'","'.$ag_lng_days[3].'","'.$ag_lng_days[4].'","'.$ag_lng_days[5].'","'.$ag_lng_days[6].'"],
    daysShort: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    daysMin: ["'.$ag_lng_days_short[0].'","'.$ag_lng_days_short[1].'","'.$ag_lng_days_short[2].'","'.$ag_lng_days_short[3].'","'.$ag_lng_days_short[4].'","'.$ag_lng_days_short[5].'","'.$ag_lng_days_short[6].'"],
    months: ["'.$ag_lng_monts['01'].'","'.$ag_lng_monts['02'].'","'.$ag_lng_monts['03'].'","'.$ag_lng_monts['04'].'","'.$ag_lng_monts['05'].'","'.$ag_lng_monts['06'].'","'.$ag_lng_monts['07'].'","'.$ag_lng_monts['08'].'","'.$ag_lng_monts['09'].'","'.$ag_lng_monts['10'].'","'.$ag_lng_monts['11'].'","'.$ag_lng_monts['12'].'"],
    monthsShort: ["'.$ag_lng_monts_short['01'].'","'.$ag_lng_monts_short['02'].'","'.$ag_lng_monts_short['03'].'","'.$ag_lng_monts_short['04'].'","'.$ag_lng_monts_short['05'].'","'.$ag_lng_monts_short['06'].'","'.$ag_lng_monts_short['07'].'","'.$ag_lng_monts_short['08'].'","'.$ag_lng_monts_short['09'].'","'.$ag_lng_monts_short['10'].'","'.$ag_lng_monts_short['11'].'","'.$ag_lng_monts_short['12'].'"],
    today: "'.$ag_lng['today'].'",
    clear: "'.$ag_lng['reset'].'",
    dateFormat: "dd.mm.yyyy",
    timeFormat: "hh:ii",
    firstDay: 1
};';

echo 'var ag_mob_offset_' .$id. ' = $("#label_' .$id. '_to").outerHeight(true) - $("#input_' .$id. '_to").outerHeight(true);';

echo '$("#input_' .$id. '_to").datepicker({
startDate: new Date('.$tyear.', '.$tmonth.', '.$tday.', 0, 0, 0, 0),
onRenderCell: function(date, cellType) {
if (cellType == "day" && date.getDate() == ' .$tday. ' && date.getMonth() == ' .$tmonth. ' && date.getFullYear() == ' .$tyear. ') { 
return {
classes: "-setdate-"
}
}
},		
clearButton: true,
autoClose: true,
prevHtml: \'<i class="icon-left-open-5"></i>\',
nextHtml: \'<i class="icon-right-open-5"></i>\',';


if ($ag_mob == 1) {echo 'offset: ag_mob_offset_' .$id. '';} else {echo 'offset: -3';}

echo '});';

echo '</script>';


echo '<div class="clear"></div>';


echo '</div></div>';
}// access
}// calendar date










// ----------------------------time period
else if ($type == 'time_period') {	

if ($access != 1) { 

$_POST[$name] = $value; 
$val_from = '';
$val_to = '';
$value_arr = explode($ag_db_seporator_array, $value);
if (isset($value_arr[0])) {$val_from = $value_arr[0];}
if (isset($value_arr[1])) {$val_to = $value_arr[1];}
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
$val_dis = '';
if (!empty($value)) {
$val_dis = '' .$ag_lng['period_from']. ': '. $val_from .' - ' .$ag_lng['time_period_to']. ': ' .$val_to. '';
}
echo '<input type="text" value="' .$val_from. ' - ' .$val_to. '" disabled="disabled" />'; 

echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { // access

$value_arr = explode($ag_db_seporator_array, $value);

if (isset($_POST[$name])) { $value_arr = $_POST[$name]; }

$val_from = '00:00';
$val_to = '00:00';

if (isset($value_arr[0]) && !empty($value_arr[0])) {$val_from = $value_arr[0];}
if (isset($value_arr[1]) && !empty($value_arr[1])) {$val_to = $value_arr[1];}

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block period_select_date">';

//echo '<div class="datepicker-here"></div>';

// from
echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_left">';
echo '<label id="label_' .$id. '_from" onclick="ag_list_time_from_' .$id. '()">';
echo '<input type="text" name="' .$name. '[0]" value="'. $val_from .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_from\')" onblur="ag_out(\'label_' .$id. '_from\')" id="input_' .$id. '_from" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-clock-7"></i></span>';
echo '</span>';
echo '<span class="ag_title_period">' .$ag_lng['period_from']. '</span>';
echo '</label>';

echo '<div class="ag_time_list -bottom-left-" id="ag_time_' .$id. '_from">
<i class="datepicker--pointer"></i>

<div class="ag_thours_list"><div class="title_time_list"><span>' .$ag_lng['hours']. '</span></div></div>
<div class="ag_minuts_list"><div class="title_time_list"><span>' .$ag_lng['minutes']. '</span></div></div>

<div class="ag_thours_list" id="ag_thours_' .$id. '_from"></div>
<div class="ag_minuts_list" id="ag_minutes_' .$id. '_from"></div>
<div class="clear"></div>
</div>';

echo '</div>';
echo '</div>';


echo '<script>';
echo '
function ag_list_time_from_' .$id. '() {
	

var time_from_val = $("#input_' .$id. '_from").val();
var time_from_val_arr = time_from_val.split(":");


var thours_list = "<ul>";
for (var h = 0; h < 24; h++) {
var thour_class = "";
h = ""+h+"";
if (h.length == 1) {h = "0"+h;}
if (time_from_val_arr[0] == h) { thour_class = "ag_time_selected"; }
thours_list += \'<li><span tabindex="-1" class="\'+thour_class+\'" onclick="ag_insert_thour_from_' .$id. '(this)">\'+h+\':00</span></li>\';	
}
thours_list += \'<li class="clear"></li></ul>\';
$("#ag_thours_' .$id. '_from").html(thours_list);


var minutes_list = "<ul>";
for (var m = 0; m < 60; m++) {
var minute_class = "";
m = ""+m+"";
if (m.length == 1) {m = "0"+m;}
if (time_from_val_arr[1] == m) { minute_class = "ag_time_selected"; }
if (m%5) {} else { minutes_list += \'<li><span tabindex="-1" class="\'+minute_class+\'" onclick="ag_insert_minute_from_' .$id. '(this)">\'+m+\'</span></li>\';}
}
minutes_list += \'<li class="clear"></li></ul>\';
$("#ag_minutes_' .$id. '_from").html(minutes_list);

$("#ag_time_' .$id. '_from").fadeIn(200);

}



function ag_insert_thour_from_' .$id. '(elh) {
$("#input_' .$id. '_from").focus();
$("#ag_thours_' .$id. '_from ul li span").removeClass("ag_time_selected");
$("#ag_minutes_' .$id. '_from ul li span").removeClass("ag_time_selected");	
$(elh).addClass("ag_time_selected");	
$("#ag_minutes_' .$id. '_from ul li:eq(0) span").addClass("ag_time_selected");	
var thour = $(elh).text();
$("#input_' .$id. '_from").val(thour);
}


function ag_insert_minute_from_' .$id. '(elm) {
$("#input_' .$id. '_from").focus();
$("#ag_minutes_' .$id. '_from ul li span").removeClass("ag_time_selected");
var thour = $("#input_' .$id. '_from").val();
var thour_arr = thour.split(":");
thour = thour_arr[0];
var minute = $(elm).text();
$("#input_' .$id. '_from").val(thour+":"+minute);
$(elm).addClass("ag_time_selected");
}

';
echo '</script>';


//to
echo '<div class="ag_two_inputs">';
echo '<div class="ag_two_inputs_inner ag_two_inputs_right">';

echo '<label id="label_' .$id. '_to" onclick="ag_list_time_to_' .$id. '()">';
echo '<input type="text" name="' .$name. '[1]" value="'. $val_to .'" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_to\')" onblur="ag_out(\'label_' .$id. '_to\')" id="input_' .$id. '_to" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-clock-7"></i></span>';
echo '</span>';
echo '<span class="ag_title_period">' .$ag_lng['time_period_to']. '</span>';
echo '</label>';

echo '<div class="ag_time_list -bottom-left-" id="ag_time_' .$id. '_to">
<i class="datepicker--pointer"></i>

<div class="ag_thours_list"><div class="title_time_list"><span>' .$ag_lng['hours']. '</span></div></div>
<div class="ag_minuts_list"><div class="title_time_list"><span>' .$ag_lng['minutes']. '</span></div></div>

<div class="ag_thours_list" id="ag_thours_' .$id. '_to"></div>
<div class="ag_minuts_list" id="ag_minutes_' .$id. '_to"></div>

<div class="clear"></div>';

if ($name != 'period_sms') {
echo '<div class="ag_reset_end_time"><div class="reset_end_time_btn"><span tabindex="-1" onclick="ag_no_end_time_' .$id. '(\'input_' .$id. '_to\')">' .$ag_lng['set_no_end_time']. '</span></div></div>';
}

echo '</div>';

echo '</div>';
echo '</div>';


echo '<script>';
echo '
function ag_no_end_time_' .$id. '(inp) {
$("#"+inp).val("XX:XX");
$("#ag_thours_' .$id. '_to ul li span").removeClass("ag_time_selected");
$("#ag_minutes_' .$id. '_to ul li span").removeClass("ag_time_selected");
}


var thour = $("#input_' .$id. '_to").val();
function ag_insert_thour_to_' .$id. '(elh) {
$("#input_' .$id. '_to").focus();
$("#ag_thours_' .$id. '_to ul li span").removeClass("ag_time_selected");
$("#ag_minutes_' .$id. '_to ul li span").removeClass("ag_time_selected");
$(elh).addClass("ag_time_selected");	
$("#ag_minutes_' .$id. '_to ul li:eq(0) span").addClass("ag_time_selected");	
thour = $(elh).text();
$("#input_' .$id. '_to").val(thour);
ag_list_time_to_' .$id. '();
}


function ag_insert_minute_to_' .$id. '(elm) {
$("#input_' .$id. '_to").focus();
$("#ag_minutes_' .$id. '_to ul li span").removeClass("ag_time_selected");
var thour = $("#input_' .$id. '_to").val();
var thour_arr = thour.split(":");
thour = thour_arr[0];
var minute = $(elm).text();

if (thour != "XX" && thour != "00") {
$("#input_' .$id. '_to").val(thour+":"+minute);
$(elm).addClass("ag_time_selected");
}

}




function ag_list_time_to_' .$id. '() {
	
	
var time_to_val = thour;
var time_to_val_arr = time_to_val.split(":");

var time_from_val = $("#input_' .$id. '_from").val();
var time_from_val_arr = time_from_val.split(":");


var thours_list = "<ul>";
for (var h = 0; h < 24; h++) {
var thour_class = "ag_thour";
h = ""+h+"";
if (h.length == 1) {h = "0"+h;}
if (time_to_val_arr[0] == h) { thour_class = " ag_time_selected"; }

var thour_set_class = "";
if (h == time_from_val_arr[0]) { thour_set_class = " ag_set_time"; }

if (h >= time_from_val_arr[0] || h == "00") {
thours_list += \'<li><span tabindex="-1" class="\'+thour_class+\'\'+thour_set_class+\'" onclick="ag_insert_thour_to_' .$id. '(this)">\'+h+\':00</span></li>\';
} else {
thours_list += \'<li><span tabindex="-1" class="ag_disabled">\'+h+\':00</span></li>\';	
}

}

thours_list += \'<li class="clear"></li></ul>\';
$("#ag_thours_' .$id. '_to").html(thours_list);


var minutes_list = "<ul>";
for (var m = 0; m < 60; m++) {
var minute_class = "ag_minute";
m = ""+m+"";
if (m.length == 1) {m = "0"+m;}
if (time_to_val_arr[1] == m) { minute_class = " ag_time_selected"; }

if (m%5) {} else { 

min_set_class = "";


if (time_to_val_arr[0] == time_from_val_arr[0]) {

var mm = parseFloat(m);
var mf = parseFloat(time_from_val_arr[1]) + 5;
if (m == mf) { min_set_class = " ag_set_time"; }
	
if (m > time_from_val_arr[1]) {

minutes_list += \'<li><span tabindex="-1" class="\'+minute_class+\'\'+min_set_class+\'" onclick="ag_insert_minute_to_' .$id. '(this)">\'+m+\'</span></li>\';

} else {
minutes_list += \'<li><span tabindex="-1" class="ag_disabled">\'+m+\'</span></li>\';	
}

} else {
minutes_list += \'<li><span tabindex="-1" class="\'+minute_class+\'\'+min_set_class+\'" onclick="ag_insert_minute_to_' .$id. '(this)">\'+m+\'</span></li>\';	
}


}

}
minutes_list += \'<li class="clear"></li></ul>\';
$("#ag_minutes_' .$id. '_to").html(minutes_list);


$("#ag_time_' .$id. '_to").fadeIn(200);

}



$(document).mouseup(function (e) {
var ag_time_' .$id. ' = $(".ag_time_list");
if (!ag_time_' .$id. '.is(e.target) && ag_time_' .$id. '.has(e.target).length === 0) {	
$(".ag_time_list").fadeOut(200);
}
});
';
echo '</script>';


echo '<div class="clear"></div>';

echo '</div></div>';

	
}// access

}
// ----------------------------time period



// ----------------------------integer_number
else if ($type == 'integer_number') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';


if ($name == 'spots') {
	if ($value === '0') {$value = -1;} else { if (empty($value)) {$value = 1;} } 
	} else {
	if (empty($value)) {$value = 0;}	
}
	
if (isset($_POST[$name])) { $value = $_POST[$name]; }
$value = (int)$value;
if ($value < 0) {$value = 0;}

echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" oninput="ag_phone_check(this)" onpropertychange="ag_phone_check(this)" />';
echo '<span class="element_tools">
<span class="ag_icon_element" onclick="ag_number_up(\'input_' .$id. '\')"><i class="icon-up-dir"></i></span>
<span class="ag_icon_element" onclick="ag_number_down(\'input_' .$id. '\')"><i class="icon-down-dir-1"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------integer_number



// ----------------------------number
else if ($type == 'number') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
if (empty($value)) {$value = '0.0';}
echo '<label id="label_' .$id. '">';
echo '<input type="text" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" oninput="ag_phone_check_fraction(this)" onpropertychange="ag_phone_check_fraction(this)" />';
echo '<span class="element_tools">
<span class="ag_icon_element" onclick="ag_number_fraction_up(\'input_' .$id. '\')"><i class="icon-up-dir"></i></span>
<span class="ag_icon_element" onclick="ag_number_fraction_down(\'input_' .$id. '\')"><i class="icon-down-dir-1"></i></span>
</span>';
echo '</label>';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------number




// ----------------------------added
else if ($type == 'added') { 
$str_sep = '::';
$new_value = date('d').$str_sep.date('m').$str_sep.date('Y').$str_sep.date('H:i:s').$str_sep.$user.$str_sep.$_SERVER['REMOTE_ADDR'];

if (!empty($value)) {$_POST[$name] = $value;}

echo '<div class="ag_form_element" id="' .$id. '">';
echo '<div class="ag_label for_textarea" id="label_' .$id. '">';

$add_day = '';
$add_month = '';
$add_year = '';
$add_time = '';
$add_user_id = '';
$add_user_ip = '';
$add_user_name = '';

if (!empty($value)) {
$value_arr = explode($str_sep, $value);
if (isset($value_arr[0])) {$add_day = $value_arr[0];}
if (isset($value_arr[1])) {$add_month = $value_arr[1];}
if (isset($value_arr[2])) {$add_year = $value_arr[2];}
if (isset($value_arr[3])) {$add_time = $value_arr[3];}
if (isset($value_arr[4])) {$add_user_id = $value_arr[4];}
if (isset($value_arr[5])) {$add_user_ip = $value_arr[5];}


foreach ($users as $user_info) {
if (isset($user_info['id']) && isset($user_info['name']) && $user_info['id'] == $add_user_id) {
$add_user_name = $user_info['name'];	
}
}
$ag_click_user = '';
if (!isset($_GET['iframe'])) {$ag_click_user = ' onclick="open_item_' .$id. '(\''. $id .'\')"';}

$view_str = '<span class="ag_info_date">' .$add_day. ' ' .$ag_lng_monts_r[$add_month]. ' ' .$add_year. '</span><span class="ag_info_time">' .$add_time. '</span><span class="ag_info_user ag_this_title"'.$ag_click_user.'>'. $add_user_name.'<span class="ag_title ag_user_info_title">IP:&#160;&#160;'.$add_user_ip.'</span></span>';

} else {$view_str = '<span>'.$ag_lng['no_data'].'</span>'; echo '<input type="hidden" name="'.$name.'" value="'. $new_value .'" />'; }
echo '<div class="ag_item_info">' .$view_str. '<div class="clear"></div></div>';

echo '<input type="hidden" id="input_'. $id .'" value="'. $add_user_id .'" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-doc-new"></i></span>';
echo '</span>';
echo '</div>';
echo '</div>';
echo '<script>

//*---open item---
function open_item_' .$id. '(obj_id) {
var item_id = "";
item_id = obj_id;

if ($("#input_"+obj_id).val() == "") { 
item_id = ""; 
} 

ag_open_ifm(item_id, "", "ag_item");
item_id = null;
obj_id = null;
}

</script>';
}// ----------------------------added


// ----------------------------changed
else if ($type == 'changed') { 
$str_sep = '::';
$new_value = date('d').$str_sep.date('m').$str_sep.date('Y').$str_sep.date('H:i:s').$str_sep.$user.$str_sep.$_SERVER['REMOTE_ADDR'];

if (isset($_POST[$name])) { $new_value = $_POST[$name]; }

echo '<div class="ag_form_element" id="' .$id. '">';
echo '<div class="ag_label for_textarea" id="label_' .$id. '">';

$add_day = '';
$add_month = '';
$add_year = '';
$add_time = '';
$add_user_id = '';
$add_user_ip = '';
$add_user_name = '';

if (!empty($value)) {
$value_arr = explode($str_sep, $value);
if (isset($value_arr[0])) {$add_day = $value_arr[0];}
if (isset($value_arr[1])) {$add_month = $value_arr[1];}
if (isset($value_arr[2])) {$add_year = $value_arr[2];}
if (isset($value_arr[3])) {$add_time = $value_arr[3];}
if (isset($value_arr[4])) {$add_user_id = $value_arr[4];}
if (isset($value_arr[5])) {$add_user_ip = $value_arr[5];}


foreach ($users as $user_info) {
if (isset($user_info['id']) && isset($user_info['name']) && $user_info['id'] == $add_user_id) {
$add_user_name = $user_info['name'];	
}
}
$ag_click_user = '';
if (!isset($_GET['iframe'])) {$ag_click_user = ' onclick="open_item_' .$id. '(\''. $id .'\')"';}

$view_str = '<span class="ag_info_date">' .$add_day. ' ' .$ag_lng_monts_r[$add_month]. ' ' .$add_year. '</span><span class="ag_info_time">' .$add_time. '</span><span class="ag_info_user ag_this_title"'.$ag_click_user.'>'. $add_user_name.'<span class="ag_title ag_user_info_title">IP:&#160;&#160;'.$add_user_ip.'</span></span>';
} else {$view_str = '<span>'.$ag_lng['no_data'].'</span>';}
echo '<div class="ag_item_info">' .$view_str. '<div class="clear"></div></div>';

echo '<input type="hidden" id="input_'. $id .'" value="'. $add_user_id .'" />'; 
echo '<input type="hidden" name="'.$name.'" value="'. $new_value .'" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-cw"></i></span>';
echo '</span>';
echo '</div>';
echo '</div>';
echo '<script>

//*---open item---
function open_item_' .$id. '(obj_id) {
var item_id = "";
item_id = obj_id;

if ($("#input_"+obj_id).val() == "") { 
item_id = ""; 
} 

ag_open_ifm(item_id, "", "ag_item");
item_id = null;
obj_id = null;
}

</script>';

}// ----------------------------changed



// ----------------------------color
else if ($type == 'color') {
	
if ($access != 1) { 
$_POST[$name] = $value; 
$ind_style = '';
if (!empty($value)) {$ind_style = 'style="background:'.$value.';"';}
echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_color">';
echo '<label id="label_' .$id. '" class="ag_noaccess ag_color">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />';
echo '<span id="color_' .$id. '" class="ag_ind_color"'.$ind_style.'></span>'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access
$cp_width = 320;
$cp_height = 210;

if ($ag_mob == 1) {
$cp_width = 240;
$cp_height = 180;	
}

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_color">';
echo '<label id="label_' .$id. '" class="ag_color">';
echo '<input id="color_value_' .$id. '" type="text" name="' .$name. '" value="' .$value. '" class="jscolor { mode:\'HVS\', width:'.$cp_width.', height:'.$cp_height.', position:\'bottom\', borderWidth:\'1\', insetWidth:\'0\', borderColor:\'#E0E0E5 #E0E0E5 #E0E0E5 #E0E0E5\', insetColor:\'#fff #fff #fff #fff\', backgroundColor:\'#fff\', borderRadius:false,  shadowBlur:\'8\', shadowColor:\'rgba(71, 74, 89, 0.08)\', valueElement:\'color_value_' .$id. '\', styleElement:\'color_' .$id. '\', hash:true, required:false} jscolor-active" autocomplete="off" onfocus="ag_active(\'label_' .$id. '\')" onblur="ag_out(\'label_' .$id. '\')" placeholder="' .$ag_lng['default']. '" />';
echo '<span id="color_' .$id. '" class="ag_ind_color"></span>';
echo '<span class="element_tools">';
echo '<span class="ag_icon_element" onclick="ag_act(\'color_value_' .$id. '\')"><i class="icon-art-gallery"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

}//access	
	
}// ----------------------------color




// ----------------------------slide
else if ($type == 'slide') {	
if ($access != 1) { 
$_POST[$name] = $value; 

echo '<div class="ag_form_element" id="' .$id. '"><div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $value .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div></div>';

} else { //access

echo '<div class="ag_form_element" id="' .$id. '">';

$smin = 0;
$smax = 100;

$sopt_count = 0;
if (!empty($options)) {
foreach ($options as $sopt) { $sopt_count++;
if ($sopt_count == 1) {$smin = $sopt['id'];}
if ($sopt_count == sizeof($options)) {$smax = $sopt['id'];}
}
}

if (isset($_POST[$name])) { $value = $_POST[$name]; }	
if (empty($value) || $value < $smin) {$value = $smin;}

echo '<label id="label_' .$id. '" onclick="ag_active(\'label_' .$id. '\')" class="for_slide">';
echo '<input type="hidden" name="' .$name. '" value="' .$value. '" class="' .$class. '" id="input_' .$id. '" />';
echo '<span id="slide_' .$id. '" class="ag_slide_line" onclick="ag_active(\'label_' .$id. '\')"></span>';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-sliders"></i></span>
</span>';
echo '<span class="ag_slive_value" id="val_' .$id. '"></span>';
echo '</label>';


if ($value > $smax) {$value = $smax;}
echo '
<script>
$(document).ready(function(){
	     $( "#slide_' .$id. '" ).slider({
				value : ' .$value. ',
				min : '.$smin.',
				max : '.$smax.',
				step : 1,
				create: function( event, ui ) {
					val = $( "#slide_' .$id. '" ).slider("value");
					$("#val_' .$id. '").html(val);
					
				},
            slide: function( event, ui ) {
				$("#val_' .$id. '").html(ui.value);
				$("#input_' .$id. '").val(ui.value);
 
            }
        });
});

$(document).mouseup(function (e) {
var ag_cl_el' .$id. ' = $("#label_' .$id. '");
if (!ag_cl_el' .$id. '.is(e.target) && ag_cl_el' .$id. '.has(e.target).length === 0) {	
ag_out(\'label_' .$id. '\');
}
});


</script>
';

echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access
}// ----------------------------slide







// ----------------------------link_info
else if ($type == 'link_info') { 
$info_alias = '';
$info_id = '';
$ag_info_cat = array();
$cat_info_alias = '';
$info_status = 0;
if (isset($options['1']['name'])) {$info_id = $options['1']['name'];} 	
if (isset($options['2']['name'])) {$info_alias = $options['2']['name'];} 	
if (isset($options['3']['name'])) {$info_status = $options['3']['name'];} 
//echo $info_id. ' - ' .$info_alias;
if (isset($_GET['cat'])) {
	if (file_exists($ag_data_dir.'/category'.$agt)) { 
	$ag_info_cat = ag_read_data($ag_data_dir.'/category'.$agt);
	foreach ($ag_info_cat as $cat_info) {
	if (isset($cat_info['id']) && $cat_info['id'] == $_GET['cat'] && isset($cat_info['alias'])) {$cat_info_alias = $cat_info['alias'];}
	}
	}
}
//$ag_get_cat = 'c';
//$ag_get_obj = 'o';

if ($info_status == 1) {
$info_link = $ag_site_url.'?'.$ag_get_cat.'='.$info_alias;
if (!empty($cat_info_alias)) {$info_link = $ag_site_url.'?'.$ag_get_cat.'='.$cat_info_alias.'&amp;'.$ag_get_obj.'='.$info_alias;}
$info_link = '<a href="'.$info_link.'" target="_blank">'.$info_link.'</a>';
} else {$info_link = $ag_lng['status_off'];}


echo '<div class="ag_form_element" id="' .$id. '">';
echo '<div class="ag_post_item ag_link_info">';

$tl = $ag_lng['link'];
if (strpos($ag_lng['link'], '(?)') === false) {} else { $tla = explode(' (?) ', $ag_lng['link']); if(isset($tla[0])) {$tl = $tla[0];} }

echo '<div class="ag_mob_table"><table>';
echo '<tr><td>'.$ag_lng['id'].':</td><td>'.$info_id.'</td></tr>';
echo '<tr><td>'.$ag_lng['alias'].':</td><td>'.$info_alias.'</td></tr>';
echo '<tr><td>'.$tl.':</td><td>'.$info_link.'</td></tr>';
echo '</table></div>';

echo '</div>'; 
echo '</div>';
}// ----------------------------link_info




// ----------------------------addr_return

else if ($type == 'addr_return') { 
$info_alias = '';

if (isset($options['2']['name'])) {$info_alias = '='.$options['2']['name'];} 	

$return_link = $ag_site_url.'?'.$ag_get_pay.$info_alias;

echo '<div class="ag_form_element" id="' .$id. '">';
echo '<div class="ag_post_item ag_link_info">';

echo '<div class="ag_return_url">'.$return_link.'</div>';

echo '</div>'; 
echo '</div>';

}// ----------------------------addr_return




// ----------------------------unknown
else if ($type == 'unknown') { 
$_POST[$name] = $value;
echo '<div class="ag_form_element" id="' .$id. '">
<div class="ag_unknown_element">
' .$value. ' <span class="ag_str_red">'.$ag_lng['unknown_type'].'</span>
</div>
</div>'; 

} else { 

$_POST[$name] = $value;
echo'<div class="ag_form_element" id="' .$id. '">
<div class="ag_unknown_element">
' .$value. ' <span class="ag_str_red">'.$ag_lng['unknown_type'].'</span>
</div>
</div>'; 
}

}// function ag_form_element
?>