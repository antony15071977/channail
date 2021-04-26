<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


function ag_multi_select($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	

	
global $ag_separator;
global $ag_lng;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_days;
global $ag_mob;
global $ag_inc_widgets;

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

echo '<div class="ag_form_element" id="' .$id. '">';

$value_arr = array();
$val_count = 0;
if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { 

$optId = '';
$optName = '';
$opt_input = '';

foreach ($options as $keyopt => $option) { 

if (isset($option['id'])) {$optId = $option['id'];}
if (isset($option['name'])) {$optName = $option['name'];}
else if (isset($option['title'])) {$optName = $option['title'];}

if ($values == $optId) { $val_count++;
echo '<div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $optName .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';
if ($val_count != sizeof($value_arr)) { echo '<div class="ag_empty_sep">&#160;</div>'; }
}

}
}
}
} else {// empty value
echo '<div class="element_block ag_select">';
echo '<label id="label_' .$id. '" class="ag_noaccess">';
echo '<input type="text" value="'. $ag_lng['no_value'] .'" disabled="disabled" />'; 
echo '<span class="element_tools">';
echo '<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>';
echo '</span>';
echo '</label>';
echo '</div>';	
}// empty value
echo '</div>';

} else { // access


// no open in iframe
$ag_inc_widgets_arr = array();	
$ag_inc_widgets_str = '';
if (isset($ag_inc_widgets)) {
foreach ($ag_inc_widgets as $kw => $vw) {
$ag_inc_widgets_arr[] = $kw;
$ag_inc_widgets_str .= $kw.',';
}
}	


$value_arr = array();

if (isset($_POST[$name])) { $value_arr = $_POST[$name]; }



echo '<div class="ag_form_element" id="' .$id. '">';	
echo '<div id="elements_' .$id. '">';

$count_elements = 0;
$opt_search_view = 16;

//opt status indicator
$optStat = '';
$optStat_indicator = '';
$optStat_class = '';
$optStat_off_str = '';
$opt_input = '';
$opt_class = '';
$search_val_str = '';
//opt status indicator

if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) { 
if (!empty($values)) { $count_elements++;



// options
$ag_list_options = '<div id="options_' .$id.$n. '" class="ag_select_options ag_multiselect_options ag_search_list">';


//search in list
$opt_count = 0;
foreach ($options as $keyopt => $option) { if (!empty($option)) {$opt_count++;} }
if ($opt_count > $opt_search_view) {
$ag_list_options .= '<div class="ag_search_in_list" id="ag_search_list_block_' .$id.$n. '"><div>
<input type="text" id="ag_search_inp_' .$id.$n. '" placeholder="'.$ag_lng['list_search'].'" />
<span id="agt_search_' .$id.$n. '" onclick="ag_search_in_list(\'ag_search_inp_' .$id.$n. '\', \'options_' .$id.$n. '\', \'ag_content_search_list_' .$id.$n. '\', \'agt_search_' .$id.$n. '\', \'agt_search_next_' .$id.$n. '\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_' .$id.$n. '" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
<span id="reset_search_' .$id.$n. '"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div></div>'; //search in list
}

$ag_list_options .= '<div class="ag_select_options_inner" id="ag_content_search_list_' .$id.$n. '">';

$optId = '';
$optName = '';

$opt_input = '';
$opt_class = '';
$search_val_str = '';

$ag_list_options .= '<ul>';
foreach ($options as $keyopt => $option) { if (!empty($option)) {$opt_count++;}

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


if ($values == $optId && !empty($values)) {
$opt_class = 'opt_this';
$opt_input = $optName;	
} else { $opt_class = ''; }
$search_val_str .= $optId.' ';


$ag_list_options .= '<li id="' .$optId.$n. '" tabindex="-1" onclick="insert_value_' .$id.$n. '(\'' .$optId. '\',\''.$optName.'\',this)" class="' .$opt_class.$optStat_class. '">' .$optName.$optStat_indicator. '</li>';


}// foreach  options

$check_val = str_replace('/', '_', $values);
$search_val_str = str_replace('/', '_', $search_val_str);
if (!preg_match('/'. $check_val .'/', $search_val_str)) { $opt_input = $ag_lng['value_not_found']; }

$ag_list_options .= '</ul>';
$ag_list_options .= '</div>';
$ag_list_options .= '</div>';





// list js
$ag_list_options .= '<script>
var opt_input_' .$id.$n. ' = "' .$opt_input. '";
if (opt_input_' .$id.$n. ' == "") {opt_input_' .$id.$n. ' = "' .$ag_lng['no_value']. '";}
$("#opt_' .$id.$n. '").val(opt_input_' .$id.$n. ');

var no_view_opt_' .$id.$n. ' = 0;
var sear_view_opt_' .$id.$n. ' = 0;

$("#remove_element_' .$id.$n. '").click(function() { no_view_opt_' .$id.$n. ' = 1; });

$("#opt_' .$id.$n. '").focus(function() {
if (no_view_opt_' .$id.$n. ' == 0) { 
$("#options_' .$id.$n. '").fadeIn(200);
}
});


$("#ag_search_inp_' .$id.$n. '").focus(function() {
sear_view_opt_' .$id.$n. ' = 1;
});
$("#agt_search_next_' .$id.$n. '").click(function() {
$("#opt_' .$id.$n. '").focus();
sear_view_opt_' .$id.$n. ' = 1;
});
$("#reset_search_' .$id.$n. '").click(function() {
$("#ag_search_inp_' .$id.$n. '").val("");
sear_view_opt_' .$id.$n. ' = 0;
$("#opt_' .$id.$n. '").blur();
});
$("#ag_content_search_list_' .$id.$n. '").click(function() {
sear_view_opt_' .$id.$n. ' = 0;
$("#opt_' .$id.$n. '").blur();
});

$("#opt_' .$id.$n. '").blur(function() {
setTimeout(function(){ 
if (sear_view_opt_' .$id.$n. ' == 0) {
$("#options_' .$id.$n. '").fadeOut(140); 
}
}, 100);
});


//*---status item---
var off_items_' .$id.$n. ' = "' .$optStat_off_str. '".split(",");
var this_item_' .$id.$n. ' = $("#input_' .$id.$n. '").val();
for (var si = 0; si < off_items_' .$id.$n. '.length; si++) {
	if (off_items_' .$id.$n. '[si] != "" && off_items_' .$id.$n. '[si] == this_item_' .$id.$n. ') { $("#opt_' .$id.$n. '").addClass("ag_str_red"); }
}
//*---status item---



function insert_value_' .$id.$n. '(id, name, e) {
	

//*---status item---
$("#opt_' .$id.$n. '").removeClass("ag_str_red");	
for (var oi = 0; oi < off_items_' .$id.$n. '.length; oi++) {
	if (off_items_' .$id.$n. '[oi] == id) { $("#opt_' .$id.$n. '").addClass("ag_str_red"); }
}
//*---status item---

	
$("#opt_' .$id.$n. '").val(name);
$("#input_' .$id.$n. '").val(id);

$("#options_' .$id.$n. ' ul li").removeClass("opt_this");

$(e).addClass("opt_this");

$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"block"});
var wgt_arr' .$id.$n. ' = "'.$ag_inc_widgets_str.'".split(",");
for (var wi = 0; wi < wgt_arr' .$id.$n. '.length; wi++) {
if (wgt_arr' .$id.$n. '[wi] == id) {
$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"none"});
}
}


id = null;
}

</script>';
// options



// select item
$ag_select_item = '';
$ag_select_item .= '<div class="element_block ag_select" id="element_' .$id. '_' .$n. '"><div class="element_inner">';

$ag_select_item .= '<label id="label_' .$id. '_' .$n. '" class="' .$class. '">';
$ag_select_item .= '<input type="text" value="" class="' .$class. '" id="opt_' .$id.$n. '" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_' .$n. '\')" onblur="ag_out(\'label_' .$id. '_' .$n. '\')" />';
$ag_select_item .= '<input type="hidden" name="' .$name. '[' .$n. ']" value="' .$values. '" class="' .$class. '" id="input_' .$id.$n. '" />';
$ag_select_item .= '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-down-open-3"></i></span>';


//$ag_select_item .= '<span class="ag_open_item" tabindex="-1"><i class="icon-search"></i></span>';// for quck search


if ($type == 'multiselectlink' && !isset($_GET['iframe'])) {

if (in_array($values, $ag_inc_widgets_arr)) {
$ag_select_item .= '<span class="ag_open_item" id="open_item_' .$id. '_' .$n. '" onclick="open_item_' .$id. '(\'' .$id.$n. '\')" title="' .$ag_lng['open']. '" style="display:none;"><i class="icon-popup"></i></span>';
} else {
$ag_select_item .= '<span class="ag_open_item" id="open_item_' .$id. '_' .$n. '" onclick="open_item_' .$id. '(\'' .$id.$n. '\')" title="' .$ag_lng['open']. '"><i class="icon-popup"></i></span>';
}

}

$ag_select_item .= '<span class="ag_remove" id="remove_element_' .$id.$n. '" onclick="remove_element_' .$id. '(\'element_' .$id. '_' .$n. '\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span>';
$ag_select_item .= '</span>';
$ag_select_item .= '</label>';
$ag_select_item .= $ag_list_options;
$ag_select_item .= '<div class="ag_empty_sep">&#160;</div>';
$ag_select_item .= '</div></div>'; // element_block element_inner
// select item

echo $ag_select_item;

}// !empty values
}// foreach value_arr	

}// !empty value	

if ($count_elements == 0) { // empty value
$n = 0;

// options
$ag_list_options = '<div id="options_' .$id.$n. '" class="ag_select_options ag_multiselect_options ag_search_list">';

//search in list
$opt_count = 0;
foreach ($options as $keyopt => $option) { if (!empty($option)) {$opt_count++;} }
if ($opt_count > $opt_search_view) {
$ag_list_options .= '<div class="ag_search_in_list" id="ag_search_list_block_' .$id.$n. '"><div>
<input type="text" id="ag_search_inp_' .$id.$n. '" placeholder="'.$ag_lng['list_search'].'" />
<span id="agt_search_' .$id.$n. '" onclick="ag_search_in_list(\'ag_search_inp_' .$id.$n. '\', \'options_' .$id.$n. '\', \'ag_content_search_list_' .$id.$n. '\', \'agt_search_' .$id.$n. '\', \'agt_search_next_' .$id.$n. '\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_' .$id.$n. '" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
<span id="reset_search_' .$id.$n. '"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div></div>'; //search in list
}

$ag_list_options .= '<div class="ag_select_options_inner" id="ag_content_search_list_' .$id.$n. '">';
$optId = '';
$optName = '';

$ag_list_options .= '<ul>';
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



$ag_list_options .= '<li id="' .$optId.$n. '" tabindex="-1" onclick="insert_value_' .$id.$n. '(\'' .$optId. '\',\''.$optName.'\',this)" class="' .$opt_class.$optStat_class. '">' .$optName.$optStat_indicator. '</li>';	
}// foreach  options

$ag_list_options .= '</ul>';
$ag_list_options .= '</div>';
$ag_list_options .= '</div>';

// list js
$ag_list_options .= '<script>

var no_view_opt_' .$id.$n. ' = 0;
var sear_view_opt_' .$id.$n. ' = 0;

$("#remove_element_' .$id.$n. '").click(function() { no_view_opt_' .$id.$n. ' = 1; });

$("#opt_' .$id.$n. '").focus(function() {
if (no_view_opt_' .$id.$n. ' == 0) { 
$("#options_' .$id.$n. '").fadeIn(200);
}
});


$("#ag_search_inp_' .$id.$n. '").focus(function() {
sear_view_opt_' .$id.$n. ' = 1;
});
$("#agt_search_next_' .$id.$n. '").click(function() {
$("#opt_' .$id.$n. '").focus();
sear_view_opt_' .$id.$n. ' = 1;
});
$("#reset_search_' .$id.$n. '").click(function() {
$("#ag_search_inp_' .$id.$n. '").val("");
sear_view_opt_' .$id.$n. ' = 0;
$("#opt_' .$id.$n. '").blur();
});
$("#ag_content_search_list_' .$id.$n. '").click(function() {
sear_view_opt_' .$id.$n. ' = 0;
$("#opt_' .$id.$n. '").blur();
});


$("#opt_' .$id.$n. '").blur(function() {
setTimeout(function(){ 
if (sear_view_opt_' .$id.$n. ' == 0) {
$("#options_' .$id.$n. '").fadeOut(140); 
}
}, 100);
});


//*---status item---
var off_items_' .$id.$n. ' = "' .$optStat_off_str. '".split(",");
var this_item_' .$id.$n. ' = $("#input_' .$id.$n. '").val();
for (var si = 0; si < off_items_' .$id.$n. '.length; si++) {
	if (off_items_' .$id.$n. '[si] != "" && off_items_' .$id.$n. '[si] == this_item_' .$id.$n. ') { $("#opt_' .$id.$n. '").addClass("ag_str_red"); }
}
//*---status item---


function insert_value_' .$id.$n. '(id, name, e) {
	

//*---status item---
$("#opt_' .$id.$n. '").removeClass("ag_str_red");	
for (var oi = 0; oi < off_items_' .$id.$n. '.length; oi++) {
	if (off_items_' .$id.$n. '[oi] == id) { $("#opt_' .$id.$n. '").addClass("ag_str_red"); }
}
//*---status item---
	
$("#opt_' .$id.$n. '").val(name);
$("#input_' .$id.$n. '").val(id);

$("#options_' .$id.$n. ' ul li").removeClass("opt_this");
$(e).addClass("opt_this");

$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"block"});
var wgt_arr' .$id.$n. ' = "'.$ag_inc_widgets_str.'".split(",");
for (var wi = 0; wi < wgt_arr' .$id.$n. '.length; wi++) {
if (wgt_arr' .$id.$n. '[wi] && wgt_arr' .$id.$n. '[wi] == id) {
$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"none"});
}
}

id = null;
}



</script>';
// options


$ag_select_item = '';
$ag_select_item .= '<div class="element_block ag_select" id="element_' .$id. '_' .$n. '"><div class="element_inner">';
$ag_select_item .= '<label id="label_' .$id. '_' .$n. '" class="' .$class. '">';
$ag_select_item .= '<input type="text" value="' .$ag_lng['no_value']. '" class="' .$class. '" id="opt_' .$id.$n. '" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_' .$n. '\')" onblur="ag_out(\'label_' .$id. '_' .$n. '\')" />';
$ag_select_item .= '<input type="hidden" name="' .$name. '[' .$n. ']" value="" class="' .$class. '" id="input_' .$id.$n. '" />';
$ag_select_item .= '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-down-open-3"></i></span>';

if ($type == 'multiselectlink' && !isset($_GET['iframe'])) {

$ag_select_item .= '<span class="ag_open_item" id="open_item_' .$id. '_' .$n. '" onclick="open_item_' .$id. '(\'' .$id.$n. '\')" title="' .$ag_lng['open']. '"><i class="icon-popup"></i></span>';

}

$ag_select_item .= '<span class="ag_remove" id="remove_element_' .$id.$n. '" onclick="remove_element_' .$id. '(\'element_' .$id. '_' .$n. '\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span>';
$ag_select_item .= '</span>';
$ag_select_item .= '</label>';
$ag_select_item .= $ag_list_options;
$ag_select_item .= '<div class="ag_empty_sep">&#160;</div>';
$ag_select_item .= '</div></div>'; // element_block element_inner

echo $ag_select_item;

}// empty value	

echo '<div class="clear"></div>';
echo '</div>'; // elements

echo '<div class="ag_add_element" onclick="add_element_' .$id. '()" title="' .$ag_lng['add']. '"><span><i class="icon-plus-circled"></i></span></div>';	

echo '</div>'; // ag_form_element


// options js
$ag_list_options_js = '<div id="options_' .$id. '*+ ' .$id. '_num +*" class="ag_select_options ag_multiselect_options">';


//search in list
$opt_count = 0;
foreach ($options as $keyopt => $option) { if (!empty($option)) {$opt_count++;} }
if ($opt_count > $opt_search_view) {
$ag_list_options_js .= '<div class="ag_search_in_list" id="ag_search_list_block_' .$id. '*+ ' .$id. '_num +*"><div>
<input type="text" id="ag_search_inp_' .$id. '*+ ' .$id. '_num +*" placeholder="'.$ag_lng['list_search'].'" />
<span id="agt_search_' .$id. '*+ ' .$id. '_num +*" onclick="ag_search_in_list(\'ag_search_inp_' .$id. '*+ ' .$id. '_num +*\', \'options_' .$id. '*+ ' .$id. '_num +*\', \'ag_content_search_list_' .$id. '*+ ' .$id. '_num +*\', \'agt_search_' .$id. '*+ ' .$id. '_num +*\', \'agt_search_next_' .$id. '*+ ' .$id. '_num +*\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_' .$id. '*+ ' .$id. '_num +*" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
<span id="reset_search_' .$id. '*+ ' .$id. '_num +*"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div></div>'; //search in list
}


$ag_list_options_js .= '<div class="ag_select_options_inner" id="ag_content_search_list_' .$id. '*+ ' .$id. '_num +*">';
$optId = '';
$optName = '';

$ag_list_options_js .= '<ul>';
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


$ag_list_options_js .= '<li id="' .$optId. '*+ ' .$id. '_num +*" tabindex="-1" onclick="new_insert_value_' .$id. '(\'' .$id. '*+ ' .$id. '_num +*\', \'' .$optId. '\', \''.$optName.'\', this)" class="' .$opt_class.$optStat_class. '">' .$optName.$optStat_indicator. '</li>';	
}// foreach  options
$ag_list_options_js .= '</ul>';
$ag_list_options_js .= '</div>';
$ag_list_options_js .= '</div>';
// options js

	
// JS append
$ag_append = '';
$ag_append .= '<div class="element_block ag_select" id="element_' .$id. '_*+ ' .$id. '_num +*"><div class="element_inner" style="display:none;">';
$ag_append .= '<label id="label_' .$id. '_*+ ' .$id. '_num +*" class="' .$class. '">';
$ag_append .= '<input type="text" value="' .$ag_lng['no_value']. '" class="' .$class. '" id="opt_' .$id. '*+ ' .$id. '_num +*" readonly="readonly" onfocus="ag_active(\'label_' .$id. '_*+ ' .$id. '_num +*\'); new_select_focus_' .$id. '(\'options_' .$id. '*+ ' .$id. '_num +*\', \'*+ ' .$id. '_num +*\');" onblur="ag_out(\'label_' .$id. '_*+ ' .$id. '_num +*\'); new_select_blur_' .$id. '(\'options_' .$id. '*+ ' .$id. '_num +*\');" />';
$ag_append .= '<input type="hidden" name="' .$name. '[*+ ' .$id. '_num +*]" value="" class="' .$class. '" id="input_' .$id. '*+ ' .$id. '_num +*" />';
$ag_append .= '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-down-open-3"></i></span>';

if ($type == 'multiselectlink' && !isset($_GET['iframe'])) {

$ag_append .= '<span class="ag_open_item" id="open_item_' .$id. '*+ ' .$id. '_num +*" onclick="open_item_' .$id. '(\'' .$id. '*+ ' .$id. '_num +*\')" title="' .$ag_lng['open']. '"><i class="icon-popup"></i></span>';

}

$ag_append .= '<span class="ag_remove" id="remove_element_' .$id. '*+ ' .$id. '_num +*" onclick="remove_element_' .$id. '(\'element_' .$id. '_*+ ' .$id. '_num +*\')" title="' .$ag_lng['remove']. '"><i class="icon-block"></i></span>';
$ag_append .= '</span>';
$ag_append .= '</label>';
$ag_append .= $ag_list_options_js;
$ag_append .= '<div class="ag_empty_sep"></div>';
$ag_append .= '</div></div>'; // element_block element_inner


$ag_append = str_replace('"', '\"', $ag_append);
$ag_append = str_replace('*', '"', $ag_append);
$ag_append = preg_replace("|[\r\n]+|", "", $ag_append); 
$ag_append = preg_replace("|[\n]+|", "", $ag_append);

// JS add & remove elements
echo '
<script>
//*---add---
var ' .$id. '_num = ' .$count_elements. ';

function add_element_' .$id. '() {
' .$id. '_num = ' .$id. '_num + 1;
$("#elements_' .$id. '").append("' .$ag_append. '");
$("#element_' .$id. '_" + ' .$id. '_num + " div.element_inner").fadeIn(400);
setTimeout(function() { $("#input_' .$id. '_" + ' .$id. '_num).focus(); $(".agt_search_next").css({display: "none"}); }, 300);
$("#options_' .$id. '" + ' .$id. '_num + " ul li").removeClass("opt_this");
}


//*---remove---
var new_no_view_opt_' .$id. ' = 0;

function remove_element_' .$id. '(id) {
	
new_no_view_opt_' .$id. ' = 1;

var element_width_' .$id. ' = $("#"+id+" div.element_inner").outerWidth(true);

$("#"+id+" div.element_inner").css({width: element_width_' .$id. ' + "px"});

$("#"+id+" div.element_inner").animate({ marginLeft: "-16px" }, 250).animate({ marginLeft: "120%" }, 180); 

setTimeout(function() { $("#"+id).css({overflow: "hidden"}); $("#"+id).addClass("ag_gradient_after"); new_no_view_opt_' .$id. ' = 0; }, 300);
setTimeout(function() { $("#"+id).remove(); id = null; }, 550);

}

var off_items_new = "' .$optStat_off_str. '".split(",");

//*---new value---
function new_insert_value_' .$id. '(id_inputs, id, name, e) {
	
//*---status item---
$("#opt_" +id_inputs).removeClass("ag_str_red");	
for (var oin = 0; oin < off_items_new.length; oin++) {
	if (off_items_new[oin] == id) { $("#opt_" +id_inputs).addClass("ag_str_red"); }
}
//*---status item---	
	
$("#opt_" +id_inputs).val(name);
$("#input_" +id_inputs).val(id);
$("#options_" +id_inputs+ " ul li").removeClass("opt_this");
$(e).addClass("opt_this");	

$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"block"});
var wgt_arr' .$id. ' = "'.$ag_inc_widgets_str.'".split(",");
for (var wi = 0; wi < wgt_arr' .$id. '.length; wi++) {
if (wgt_arr' .$id. '[wi] == id) {
$(e).parents("div.element_inner").find("span.ag_open_item").css({display:"none"});
}
}


id = null;
}


var new_sear_view_opt_' .$id. ' = 0;
function new_select_focus_' .$id. '(id, num) {
if (new_no_view_opt_' .$id. ' == 0) { $("#"+id).fadeIn(300); }	
new_no_view_opt_' .$id. ' = 0;


$("#ag_search_inp_' .$id. '"+num).focus(function() {
new_sear_view_opt_' .$id. ' = 1;
});
$("#agt_search_next_' .$id. '"+num).click(function() {
new_sear_view_opt_' .$id. ' = 1;
});
$("#reset_search_' .$id. '"+num).click(function() {
$("#ag_search_inp_' .$id. '"+num).val("");
new_sear_view_opt_' .$id. ' = 0;
$("#opt_' .$id. '"+num).blur();
});
$("#ag_content_search_list_' .$id. '"+num).click(function() {
new_sear_view_opt_' .$id. ' = 0;
$("#opt_' .$id. '"+num).blur();
});

return new_no_view_opt_' .$id. ';
id = null;
}

function new_select_blur_' .$id. '(id) {
setTimeout(function(){  new_select_blur_time_' .$id. '(id); }, 100);
}
function new_select_blur_time_' .$id. '(id) {
var hidden_list_' .$id. ' = $("#"+id);
if (new_sear_view_opt_' .$id. ' == 0) { hidden_list_' .$id. '.fadeOut(140); }
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

</script>
';	


}// access



}
?>