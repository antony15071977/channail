<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

$ag_congig_group_tab_id = '';
$ag_congig_group_tab_icon = '';
$ag_congig_group_tab_id_str = '';
$ag_this_cgf_tab = '';
$ag_congig_group_tab_id_arr = array();



echo '<div class="ag_top_tools" id="ag_top_tools">';

echo '<div class="ag_srv_time" title="' .$ag_lng['sys_time']. '">';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else {
echo '<span class="ag_inf_date">' .date('d'). ' ' .$ag_lng_monts_r[date('m')]. ' ' .date('Y'). '</span>'; 
}
include('inc/srv_time.php'); 
echo '</div>';

echo '<div><span class="ag_btn_big ag_right" id="ag_save_btn_top" tabindex="-1" onclick="ag_save_item()"><i class="icon-floppy-1"></i><span>' .$ag_lng['save']. '</span></span></div>';

echo '<div class="clear"></div>'; 

echo '<div class="ag_scroll_top"></div>';
echo '</div>';


if (isset($_GET['iframe'])) { 
echo '<div class="ag_edit_block ag_edit_block_iframe" id="ag_edit_block">';
} else {
echo '<div class="ag_edit_block" id="ag_edit_block">';
} // iframe


foreach ($ag_config_array as $conf_name => $conf_val) {
$conf_val_arr = explode($ag_separator[0], $conf_val);
if (isset($conf_val_arr[2]) && isset($conf_val_arr[3])) { $ag_congig_group_tab_id_str .= $conf_val_arr[2].$ag_separator[1].$conf_val_arr[3].$ag_separator[0]; }
}

$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
echo '<div id="ag_cfg_tabs_mob_open" tabindex="-1" onclick="ag_cfg_tabs_mob_open()" class="ag_cfg_tabs_mob"><i class="icon-down-open-3"></i></div>';
echo '<div id="ag_cfg_tabs_mob_close" tabindex="-1" onclick="ag_cfg_tabs_mob_close()" class="ag_cfg_tabs_mob"><i class="icon-up-open-3"></i></div>';
}

echo '<div id="ag_cfg_tabs" class="ag_cfg_tabs">';

$ag_congig_group_tab_id_arr = explode($ag_separator[0], $ag_congig_group_tab_id_str);
array_pop($ag_congig_group_tab_id_arr);
$ag_congig_group_tab_id_arr = array_diff($ag_congig_group_tab_id_arr, array(''));
$ag_congig_group_tab_id_arr = array_unique($ag_congig_group_tab_id_arr);

$ag_congig_groups_arr = array();

foreach($ag_congig_group_tab_id_arr as $ntc => $ag_congig_groups) {
$ag_congig_groups_arr = explode($ag_separator[1], $ag_congig_groups);	
if (isset($ag_congig_groups_arr[0])) {$ag_congig_group_tab_id = $ag_congig_groups_arr[0];}
if (isset($ag_congig_groups_arr[1])) {$ag_congig_group_tab_icon = $ag_congig_groups_arr[1];}
$ag_congig_group_tab_name = $ag_congig_group_tab_id;
if (isset($ag_lng[$ag_congig_group_tab_id])) {$ag_congig_group_tab_name = $ag_lng[$ag_congig_group_tab_id];}

echo '<div class="ag_cfg_tab" tabindex="-1" id="' .$ag_congig_group_tab_id. '" onclick="ag_cfg_tabs(\''.$ag_congig_group_tab_id.'\')"><i class="' .$ag_congig_group_tab_icon. '"></i><span>' .$ag_congig_group_tab_name. '</span></div>';

if ($ntc == 0) {$ag_this_cgf_tab = $ag_congig_group_tab_id;}
}

echo '<div class="clear"></div>'; 
echo '</div>';// ag_cfg_tabs


echo '<form id="ag_cfg_settings" method="post" action="?settings">';


$ag_file_conf_name = $ag_data_dir.'/'. $ag_config;
$ag_conf_lines = array();

if (file_exists($ag_file_conf_name)) {
	
$ag_conf_fp = fopen($ag_file_conf_name, "r+");
flock ($ag_conf_fp, LOCK_EX); 
if (filesize($ag_file_conf_name) != 0) { 
$ag_conf_lines = preg_split("~\r*?\n+\r*?~", fread($ag_conf_fp, filesize($ag_file_conf_name))); 
} else { $ag_conf_lines = array(); }	
flock ($ag_conf_fp, LOCK_UN);
fclose ($ag_conf_fp);

}

$ag_varc_name = '';
$ag_varc_val = '';
$ag_congig_group = '';
$ag_class_element = '';

$ag_conf_option = array();
$conf_names = array();
$conf_values = array();

foreach ($ag_config_array as $conf_name => $conf_val) {
$conf_names[] = $conf_name;
$conf_val_arr = explode($ag_separator[0], $conf_val);
$ag_config_type = '';
if (isset($conf_val_arr[1])) { $ag_config_type = $conf_val_arr[1]; }
if (isset($conf_val_arr[2])) { $ag_congig_group = $conf_val_arr[2]; }

foreach ($ag_conf_lines as $ncl => $ag_cline) {
if ($ncl != 0 && $ncl != sizeof($ag_conf_lines) - 1) {
	$ag_cline_arr = explode(' = ', $ag_cline);
	if (isset($ag_cline_arr[0])) { $ag_varc_name = $ag_cline_arr[0]; }
	if (isset($ag_cline_arr[1])) { $ag_varc_val = $ag_cline_arr[1]; }
	
	
	$ag_varc_name = str_replace('$', '', $ag_varc_name);
	$ag_varc_val = str_replace('";', '', $ag_varc_val);
	$ag_varc_val = str_replace('"', '', $ag_varc_val);
	
	$conf_values[] = $ag_varc_name;
	
	if ($conf_name == $ag_varc_name) {
	

	if ($ag_config_type == 'checkbox') {$ag_class_element = 'ag_active_checkbox';}
    $ag_title_cfg_input = $ag_varc_name;
	if (isset($ag_lng[$ag_varc_name])) {$ag_title_cfg_input = $ag_lng[$ag_varc_name];}
	
if (strpos($ag_title_cfg_input, ' (?) ') === false) {
$ag_title_cfg_input = '<span>'.$ag_title_cfg_input.':</span>';
} else {
$ag_title_element_arr = explode(' (?) ', $ag_title_cfg_input);
if (isset($ag_title_element_arr[0]) && isset($ag_title_element_arr[1])) {
$ag_title_cfg_input = '<span class="ag_help ag_this_title" tabindex="-1"><i class="icon-help-circled"></i>' .$ag_title_element_arr[0]. ':<span class="ag_title ag_help_element">' .$ag_title_element_arr[1]. '</span></span>';	
}
}
	
	//options
	
	// time zone
 	if ($conf_name == 'ag_cfg_time_zone') {
    $ag_conf_option = array();		
	$count_tz = 0;
	foreach ($ag_time_zones as $tz_val => $tz_name) { $count_tz++;
	$ag_conf_option[$count_tz] = array('id' => $tz_val, 'name' => $tz_name);
	}
	
	// lang
	} else if ($conf_name == 'ag_cfg_lng') { 
	$ag_conf_option = array();
	$ag_clangs = ag_file_list('../'.$ag_lng_dir, '.php');
    foreach ($ag_clangs as $nlg => $lng_file) {
	$lng_val = $lng_file['name'];
	
	
$ag_file_lang_name = $lng_val;
$ag_lang_lines = array();

if (file_exists($ag_file_lang_name)) {
	
$ag_lang_fp = fopen($ag_file_lang_name, "r+");
flock ($ag_lang_fp, LOCK_EX); 
if (filesize($ag_file_lang_name) != 0) { 
$ag_lang_lines = preg_split("~\r*?\n+\r*?~", fread($ag_lang_fp, filesize($ag_file_lang_name))); 
} else { $ag_lang_lines = array(); }	
flock ($ag_lang_fp, LOCK_UN);
fclose ($ag_lang_fp);

}
$ag_list_lng_name = '';
foreach ($ag_lang_lines as $nll => $lng_line) {
if (strpos($lng_line, '$ag_lng_name') === false) {} else {$ag_list_lng_name = $lng_line; break;}
}
if (!empty($ag_list_lng_name)) { 
$ag_list_lng_name = str_replace(array('$ag_lng_name', "'", ";", "=", " "), '', $ag_list_lng_name);
}
	
	$lng_val = str_replace('../', '', $lng_val);
	$lng_sname = str_replace(array($ag_lng_dir, '/', '.php',), '', $lng_val);
	$lng_name = $lng_sname;
	if (!empty($ag_list_lng_name)) {$lng_name = $ag_list_lng_name;}
	$ag_conf_option[$nlg] = array('id' => $lng_val, 'name' => $lng_name);	
	}
	
	
	
	
	// themes
	} else if ($conf_name == 'ag_cfg_theme') {
    $ag_conf_option = array();		
	$ag_cthemes = ag_file_list('../'.$ag_themes_dir, 'dir');
    foreach ($ag_cthemes as $ntm => $themes_file) {
	$themes_val = $themes_file['name'];
	
	$themes_val = str_replace('../', '', $themes_val);
	$themes_name = str_replace(array($ag_themes_dir, '/', '.php',), '', $themes_val);
	$ag_conf_option[$ntm] = array('id' => $themes_val, 'name' => $themes_name);	
	}
	
	} else if ($conf_name == 'ag_cfg_home') {
    $ag_conf_option = array();
	$ag_conf_option = array(
	'1' => array('id' => 'first_category', 'name' => $ag_lng['first_category']),
	'2' => array('id' => 'last_objects', 'name' => $ag_lng['last_objects']),
	'3' => array('id' => 'custom_content', 'name' => $ag_lng['custom_content'])
	);
	
    } else if ($conf_name == 'ag_cfg_home_blocks_row') {
    $ag_conf_option = array();
	$ag_conf_option = array(
	'1' => array('id' => '2', 'name' => '2'),
	'2' => array('id' => '3', 'name' => '3'),
	'3' => array('id' => '4', 'name' => '4'),
	'4' => array('id' => '5', 'name' => '5'),
	'5' => array('id' => '6', 'name' => '6'),
	);
	
	} else if ($conf_name == 'ag_cfg_font_size') {
    $ag_conf_option = array();
	$ag_conf_option = array(
	'1' => array('id' => '10', 'name' => '10'),
	'2' => array('id' => '24', 'name' => '24'),
	);

	// fonts
	} else if ($conf_name == 'ag_cfg_font_title' || $conf_name == 'ag_cfg_font_menu' || $conf_name == 'ag_cfg_font_h' || $conf_name == 'ag_cfg_font_description' || $conf_name == 'ag_cfg_font_text') {
	$ag_conf_option = array();
	$ag_fonts = ag_file_list('../fonts', 'dir');
    foreach ($ag_fonts as $nf => $font_dir) {
	$font_val = $font_dir['name'];
	if (ag_file_list($font_val, 'ttf') && ag_file_list($font_val, 'woff')) {
	$font_val = str_replace('../', '', $font_val);
	$font_name_a = explode('/', $font_val); $font_name_a = array_diff($font_name_a, array(''));
	$font_name = array_pop($font_name_a);
	$ag_conf_option[$font_name] = array('id' => $font_val, 'name' => $font_name);	
	}
	}
	ksort($ag_conf_option);
	
	// slides
	} else if ($conf_name == 'ag_cfg_home_slides' || $conf_name == 'ag_cfg_home_slides') {
	$ag_conf_option = array();
		
	if (file_exists($ag_data_dir.'/slider'.$agt)){	
    $ag_conf_option = ag_read_data($ag_data_dir.'/slider'.$agt);
	}
	
	} else if ($conf_name == 'ag_cfg_slider_time') {
    $ag_conf_option = array();
	$ag_conf_option = array(
	'1' => array('id' => '0', 'name' => '0'),
	'2' => array('id' => '180', 'name' => '180'),
	);
	
    // widgets
	} else if ($conf_name == 'ag_cfg_home_widgets' || $conf_name == 'ag_cfg_footer_widgets') {
	$ag_conf_option = array();
		
	if (file_exists($ag_data_dir.'/widget'.$agt)){	
    $ag_wgt = ag_read_data($ag_data_dir.'/widget'.$agt);
    $ag_conf_option = $ag_wgt;
    $ag_conf_option = array_merge($ag_conf_option, $ag_inc_widgets); 
	}
	
	// objects
	} else if ($conf_name == 'ag_cfg_home_objects') {
	$ag_conf_option = array();
		
if (file_exists($ag_data_dir.'/category'.$agt)){		
$db_ddata = ag_read_data($ag_data_dir.'/category'.$agt);
foreach ($db_ddata as $catd) {
$catd_id = '';
$catd_name = '';
$catd_title = '';
$catd_status = '';
if (isset($catd['id']))	{$catd_id = $catd['id'];}
if (isset($catd['name'])) {$catd_name = $catd['name'];}
if (isset($catd['title'])) {$catd_title = $catd['title'];}
if (isset($catd['status'])) {$catd_status = $catd['status'];}
if(empty($catd_name)) {$catd_name = $catd_title;}

if (!empty($catd_id) && file_exists($ag_data_dir.'/object/'.$catd_id.$agt)) { $optd = ag_read_data($ag_data_dir.'/object/'.$catd_id.$agt); }

foreach ($optd as $obd) {
$obd_id = '';
$obd_name = '';
$obd_title = '';
$obd_status = '';
if (isset($obd['id']))	{$obd_id = $obd['id'];}
if (isset($obd['name'])) {$obd_name = $obd['name'];}
if (isset($obd['title'])) {$obd_title = $obd['title'];}
if (isset($obd['status'])) {$obd_status = $obd['status'];}
if ($catd_status == '0') {$obd_status = '0';}
if(empty($obd_name)) {$obd_name = $obd_title;}
$ag_conf_option[$catd_id.$obd_id] = array('id' => $catd_id.'::'.$obd_id, 'name' => $catd_name.' - '.$obd_name, 'status' => $obd_status);

}// foreach optd
}// foreach db_ddata

}// file_exists	
	
	

// widgets
} else if ($conf_name == 'ag_cfg_wgt_exclude_list_cat' || $conf_name == 'ag_cfg_cal_exclude_list_cat') {
$ag_conf_option = array();
if (file_exists($ag_data_dir.'/category'.$agt)){		
$ag_conf_option = ag_read_data($ag_data_dir.'/category'.$agt);		
}	

// ag_ag_cfg_soc_links
} else if ($conf_name == 'ag_ag_cfg_soc_links') {
$ag_conf_option = array();

// editor select
} else if ($conf_name == 'ag_cfg_editor') { 
	$ag_conf_option = array(
	'1' => array('id' => 'tinymce', 'name' => 'TinyMCE'),
	'2' => array('id' => 'ckeditor', 'name' => 'CKeditor'),
	);
	
	
	
} else { $ag_conf_option = array(); }

	//options
	
	
	echo '<div class="ag_edit_form ag_cfg_element '.$ag_congig_group.'">';
    echo '<div class="ag_title_element"><div>' .$ag_title_cfg_input. '</div></div>';

    echo '<div class="ag_elements_area">';
	ag_form_element($ag_config_type, $ag_varc_name, $ag_varc_name, $ag_varc_val, $ag_conf_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 1);
	echo '</div>';// ag_elements_area
	
	echo '<div class="clear"></div>';
	echo '</div>';// ag_edit_form
	 
	}  // conf_name == ag_varc_name


}// not first & not last (<?php & ? >)
}// foreach ag_conf_lines



// add new values
$conf_values = array_unique($conf_values);
foreach ($conf_names as $new_conf_name) {
if (!in_array($new_conf_name, $conf_values)) {
if ($new_conf_name == $conf_name) {
	
$ag_title_cfg_input = $new_conf_name;
	if (isset($ag_lng[$new_conf_name])) {$ag_title_cfg_input = $ag_lng[$new_conf_name];}
	
if (strpos($ag_title_cfg_input, ' (?) ') === false) {
$ag_title_cfg_input = '<span>'.$ag_title_cfg_input.':</span>';
} else {
$ag_title_element_arr = explode(' (?) ', $ag_title_cfg_input);
if (isset($ag_title_element_arr[0]) && isset($ag_title_element_arr[1])) {
$ag_title_cfg_input = '<span class="ag_help ag_this_title" tabindex="-1"><i class="icon-help-circled"></i>' .$ag_title_element_arr[0]. ':<span class="ag_title ag_help_element">' .$ag_title_element_arr[1]. '</span></span>';	
}
}	
	

$ag_conf_option = array(); // new options

	
echo '<div class="ag_edit_form ag_cfg_element '.$ag_congig_group.'">';
    echo '<div class="ag_title_element"><div>' .$ag_title_cfg_input. '</div></div>';

    echo '<div class="ag_elements_area">';
	ag_form_element($ag_config_type, $new_conf_name, $new_conf_name, '', $ag_conf_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 1);
	echo '</div>';// ag_elements_area
	
	echo '<div class="clear"></div>';
	echo '</div>';// ag_edit_form

}
}
}

}// foreach ag_config_array














echo '<input type="hidden" name="ag_replace_settings" value="settings" />'; 
echo '<div class="ag_save">
<button class="ag_btn_big" id="ag_save_btn_bottom"><i class="icon-floppy-1"></i><span>' .$ag_lng['save']. '</span></button>
<div class="clear"></div>
</div>';


echo '</form>';

echo '<div class="clear"></div>'; 
echo '</div>'; // ag_edit_block





echo '<script>';
echo '$(document).ready(function(){';

if (isset($_GET['cfgtab'])) {echo 'ag_cfg_tabs(\''.$_GET['cfgtab'].'\');'; } else { echo 'ag_cfg_tabs(\''.$ag_this_cgf_tab.'\');'; }

if (!isset($ag_ERROR)) {  
echo '
var done_id = window.location.hash.replace("#","");	
if (done_id != "") {
if (done_id.indexOf("done") == 0) {
ag_dialog(1800, \'' .$ag_lng['settings_set']. '\', \''.$ag_lng['done'].'.\', \'quick_mess\', \'icon-ok-3 ag_str_green\', \'\');
window.location.hash = "";
}
}';
}

echo '});';
echo '</script>';





?>