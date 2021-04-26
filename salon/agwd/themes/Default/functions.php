<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}

$ag_get_param = array(
$ag_get_cat, 
$ag_get_obj, 
$ag_get_page, 
$ag_get_search, 
'_'.$ag_get_page, 
'_'.$ag_get_search, 
$ag_get_rss, 
$ag_get_sitemap,
$ag_get_schedule,
$ag_get_confirm,
$ag_get_pay,
'fbclid'
);

$ag_error_get = '';

if(isset($_GET)) {
	foreach ($_GET as $kget => $vget) {
	if (isset($_GET[$kget]) && !in_array($kget, $ag_get_param))	{$ag_error_get = 1;}
	}
}

if (!isset($_GET[$ag_get_cat]) && isset($_GET[$ag_get_obj])) {$ag_error_get = 1;}
if (isset($_GET[$ag_get_cat]) && empty($_GET[$ag_get_cat])) {$ag_error_get = 1;}
if (isset($_GET[$ag_get_obj]) && empty($_GET[$ag_get_obj])) {$ag_error_get = 1;}

if (isset($_GET[$ag_get_schedule]) || isset($_GET[$ag_get_confirm]) || isset($_GET[$ag_get_pay])) {$ag_error_get = '';}


$ag_alias_cat = '';
$ag_alias_obj = '';
$ag_page = 1;
$ag_query = '';


if (isset($_GET[$ag_get_cat])) { $ag_alias_cat = htmlspecialchars($_GET[$ag_get_cat], ENT_QUOTES, 'UTF-8'); }
if (isset($_GET[$ag_get_obj])) { $ag_alias_obj = htmlspecialchars($_GET[$ag_get_obj], ENT_QUOTES, 'UTF-8'); }
if (isset($_GET[$ag_get_page])) { $ag_page = htmlspecialchars($_GET[$ag_get_page], ENT_QUOTES, 'UTF-8'); $ag_page = (int)$ag_page; }
if (isset($_GET[$ag_get_search])) { $ag_query = htmlspecialchars($_GET[$ag_get_search], ENT_QUOTES, 'UTF-8'); }
if (isset($_GET['_'.$ag_get_search])) {$ag_query = htmlspecialchars($_GET['_'.$ag_get_search], ENT_QUOTES, 'UTF-8');}

if (isset($_GET[$ag_get_rss])) {$ag_alias_cat = htmlspecialchars($_GET[$ag_get_rss], ENT_QUOTES, 'UTF-8');}

$ag_photos_dir = $ag_data_dir.'/'.$ag_upload_name;
if ($ag_is_mob == 1) {
$ag_photos_dir = $ag_data_dir.'/'.$ag_mob_images;
}
$ag_mob_photos = $ag_data_dir.'/'.$ag_mob_images;


$ag_404_content = '<div class="ag_error_404_content">';
$ag_404_content .= '<h2 class="ag_error_404_title">' .$ag_lng['error_404_meta']. '</h2>';
$ag_404_content .= '<div class="ag_error_404_icon"><i class="icon-eye-off-1"></i></div>';
$ag_404_content .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_404_content .= '</div>';


$ag_search_form = '<div class="ag_search_form">';
$ag_search_form .= '<div class="ag_search_form_inner">';
$ag_search_form .= '<form method="get">';
$ag_search_form .= '<label><input type="text" name="'.$ag_get_search.'" value="'.$ag_query.'" placeholder="'.$ag_lng['search'].'" oninput="ag_search_button(this)" /></label><span class="ag_search_submit" tabindex="-1" onclick="ag_search(this)"><i class="icon-search"></i></span>';
$ag_search_form .= '</form>';
$ag_search_form .= '</div>';
$ag_search_form .= '</div>';
$ag_search_form .= '<div class="ag_clear"></div>';



$ag_not_found_content = '<div class="ag_error_404_content">';
$ag_not_found_txt = str_replace('%s', '&laquo;'.$ag_query.'&raquo;', $ag_lng['not_found']);
$ag_not_found_content .= '<h2 class="ag_error_404_title">' .$ag_not_found_txt. '</h2>';
$ag_not_found_content .= '<div class="ag_error_404_icon"><i class="icon-eye-off-1"></i></div>';
$ag_not_found_content .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_not_found_content .= '</div>';


$ag_query_empty_content = '<div class="ag_error_404_content">';
$ag_query_empty_content .= '<h2 class="ag_error_404_title">' .$ag_lng['empty_query']. '</h2>';
$ag_query_empty_content .= '<div class="ag_error_404_icon"><i class="icon-eye-off-1"></i></div>';
$ag_query_empty_content .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_query_empty_content .= '</div>';



$ag_none_content = '<div class="ag_error_404_content">';
$ag_none_content .= '<h2 class="ag_error_404_title">' .$ag_lng['none_content']. '</h2>';
$ag_none_content .= '<div class="ag_error_404_icon"><i class="icon-eye-off-1"></i></div>';
if (!empty($ag_apanel_link)) { $ag_none_content .= '<div class="ag_error_404_link"><a href="' .$ag_apanel_link. '">' .$ag_lng['apanel']. '</a></div>';}
$ag_none_content .= '</div>';


//404
if ($ag_error_get == 1) { 
header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); 
} else {
if (ag_meta('title', '') == $ag_lng['error_404_meta']) { header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found'); }
}


if (isset($_POST['ag_login']) && isset($_POST['ag_pass'])) {
if (!empty($_POST['ag_login']) && !empty($_POST['ag_pass'])) {




$ag_uagent = '';
$ag_userip = '';

$session_per = $srv_host_name;
$ag_sub_domain = 'none';
if (strpos($srv_host_name, '.') === false) { } else {
$srv_host_name_a = explode('.', $srv_host_name);
if (isset($srv_host_name_a[0])) {$ag_sub_domain = $srv_host_name_a[0];}
array_pop($srv_host_name_a);
$session_per = array_pop($srv_host_name_a);
}
$session_per = $ag_sub_domain.$session_per.date('d.m.Y');
$session_per = crypt(sha1($session_per), substr($session_per,0,2));


$ag_uagent = $_SERVER['HTTP_USER_AGENT'];
$ag_userip = $_SERVER['REMOTE_ADDR'];

$ag_uagent_check = crypt(sha1($ag_uagent), substr($ag_uagent,0,2));
$ag_userip_check = crypt(sha1($ag_userip), substr($ag_userip,0,2));


if (!isset($_SESSION['ag_uagent'.$session_per])) {$_SESSION['ag_uagent'.$session_per] = $ag_uagent_check;}
if (!isset($_SESSION['ag_userip'.$session_per])) {$_SESSION['ag_userip'.$session_per] = $ag_userip_check;}



$ag_login = htmlspecialchars($_POST['ag_login'], ENT_QUOTES, 'UTF-8');
$ag_passw = htmlspecialchars($_POST['ag_pass'], ENT_QUOTES, 'UTF-8');	
$ag_passw = sha1($ag_passw);

$ag_login = crypt(sha1($ag_login), substr($ag_login,0,2));
$ag_passw = crypt(sha1($ag_passw), substr($ag_passw,0,2));

$_SESSION['ag_login'.$session_per] = $ag_login;
$_SESSION['ag_passw'.$session_per] = $ag_passw;



$ag_apanel_link = ag_apanel(); if (!empty($ag_apanel_link)) { header("Location: " .$srv_absolute_url.$ag_apanel_link); }
} else { $ag_empty_login = 1; }
}// post logon








//---------------------------------------------- WIDGETS
function ag_widgets($mode='') {
	
$ag_widgets = '';	
	
global $ag_lng;	
global $ag_lng_monts_r;
global $ag_cat;	

global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_get_search;
global $ag_get_sitemap;

global $ag_alias_cat;
global $ag_alias_obj;	

global $ag_data_dir;
global $ag_upload_name;

global $ag_photos_dir;
global $ag_is_mob;	

global $ag_cfg_home;
global $ag_cfg_home_widgets;
global $ag_cfg_footer_widgets;

global $ag_config;
global $ag_inc_widgets;
global $ag_error_get;

//wgt settings
global $ag_cfg_wgt_title_login;
global $ag_cfg_wgt_icon_login;

global $ag_cfg_wgt_title_mail;
global $ag_cfg_wgt_icon_mail;
global $ag_cfg_wgt_address_mail;

global $ag_cfg_wgt_title_last_obj;
global $ag_cfg_wgt_icon_last_obj;
global $ag_cfg_wgt_count_last_obj;

global $ag_cfg_wgt_title_list_cat;
global $ag_cfg_wgt_icon_list_cat;
global $ag_cfg_wgt_exclude_list_cat;

global $ag_cfg_wgt_title_soc_link;
global $ag_cfg_wgt_icon_soc_link;

global $ag_cfg_cal_title;
global $ag_cfg_cal_icon;

global $ag_apanel_link;

//cat
$cat_widgets = array();
$obj_widgets = array();
$ag_this_widgets = array();

foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { 
if (isset($cat['id'])) {$cat_id = $cat['id'];}

if (empty($ag_alias_cat) && $ag_cfg_home == 'first_category') {
if (isset($cat['widgets'])) { $cat_widgets = explode($ag_separator[2], $cat['widgets']); }
break;	
}


if (isset($cat['alias']) && $cat['alias'] == $ag_alias_cat) { $found_cat_wgt = 1;
if (isset($cat['widgets'])) { $cat_widgets = explode($ag_separator[2], $cat['widgets']); }
}

$ag_obj = array();
if (file_exists($ag_data_dir.'/object/'.$cat_id.$agt)){	
$ag_obj = ag_read_data($ag_data_dir.'/object/'.$cat_id.$agt);

//obj
foreach ($ag_obj as $nc => $obj) {

if (isset($obj['id'])) {$obj_id = $obj['id'];}
if (isset($obj['status']) && $obj['status'] == 1) {	

if (isset($obj['alias']) && $obj['alias'] == $ag_alias_obj) {

if (isset($obj['widgets'])) { $obj_widgets = explode($ag_separator[2], $obj['widgets']); }
if (isset($obj['parent_widgets'])) { if ($obj['parent_widgets'] == '1') {} else { $cat_widgets = array(); } }

}

}// status obj
}// foreach ag_obj
}// file_exists

}// status cat
}// foreach ag_data cat


$ag_this_widgets = array_merge($cat_widgets, $obj_widgets);

// home widgets
if (!isset($_GET[$ag_get_cat]) && !isset($_GET[$ag_get_search]) && !isset($_GET[$ag_get_sitemap])) { 
if ($ag_cfg_home == 'first_category') { 
$ag_home_widgets = explode($ag_separator[2], $ag_cfg_home_widgets); 
$ag_this_widgets = array_merge($ag_this_widgets, $ag_home_widgets);
} else {
$ag_this_widgets = explode($ag_separator[2], $ag_cfg_home_widgets); 
}
}

// footer widgets
if ($mode == 'footer') {
$ag_this_widgets = array();
$ag_this_widgets = explode($ag_separator[2], $ag_cfg_footer_widgets);	
}



$ag_this_widgets = array_diff($ag_this_widgets, array(''));
$ag_this_widgets = array_unique($ag_this_widgets);

$ag_wgt = array();
if (file_exists($ag_data_dir.'/widget'.$agt)){	
$ag_wgt = ag_read_data($ag_data_dir.'/widget'.$agt);
$ag_wgt = array_merge($ag_wgt, $ag_inc_widgets);
$ag_widget = '';

foreach ($ag_this_widgets as $wid) {

$ag_count_wgt = 0;
foreach ($ag_wgt as $nw => $wgt) { $ag_count_wgt++;


$wgt_title = '';
$wgt_icon = '';
$wgt_alt = '';
$wgt_photo = '';
$wgt_video = '';
$wgt_content = '';

if (isset($wgt['id']) && $wgt['id'] == $wid) {

if (isset($wgt['status']) && $wgt['status'] == '1') {


// settings

// ag_login_form
if ($wgt['id'] == 'ag_login_form' && !empty($ag_cfg_wgt_title_login)) { $wgt['title'] = $ag_cfg_wgt_title_login; }
if ($wgt['id'] == 'ag_login_form' && !empty($ag_cfg_wgt_icon_login)) { $wgt['icon'] = $ag_cfg_wgt_icon_login; }


// ag_login_form
if ($wgt['id'] == 'ag_mail_form' && !empty($ag_cfg_wgt_title_mail)) { $wgt['title'] = $ag_cfg_wgt_title_mail; }
if ($wgt['id'] == 'ag_mail_form' && !empty($ag_cfg_wgt_icon_mail)) { $wgt['icon'] = $ag_cfg_wgt_icon_mail; }


// ag_last_obj
if ($wgt['id'] == 'ag_last_obj' && !empty($ag_cfg_wgt_title_last_obj)) { $wgt['title'] = $ag_cfg_wgt_title_last_obj; }
if ($wgt['id'] == 'ag_last_obj' && !empty($ag_cfg_wgt_icon_last_obj)) { $wgt['icon'] = $ag_cfg_wgt_icon_last_obj; }


// ag_list_cat
if ($wgt['id'] == 'ag_list_cat' && !empty($ag_cfg_wgt_title_list_cat)) { $wgt['title'] = $ag_cfg_wgt_title_list_cat; }
if ($wgt['id'] == 'ag_list_cat' && !empty($ag_cfg_wgt_icon_list_cat)) { $wgt['icon'] = $ag_cfg_wgt_icon_list_cat; }


// ag_soc_link
if ($wgt['id'] == 'ag_soc_link' && !empty($ag_cfg_wgt_title_soc_link)) { $wgt['title'] = $ag_cfg_wgt_title_soc_link; }
if ($wgt['id'] == 'ag_soc_link' && !empty($ag_cfg_wgt_icon_soc_link)) { $wgt['icon'] = $ag_cfg_wgt_icon_soc_link; }


// ag_pub_calendar
if ($wgt['id'] == 'ag_pub_calendar' && !empty($ag_cfg_cal_title)) { $wgt['title'] = $ag_cfg_cal_title; }
if ($wgt['id'] == 'ag_pub_calendar' && !empty($ag_cfg_cal_icon)) { $wgt['icon'] = $ag_cfg_cal_icon; }

// settings



$obj_edit = '';

if (strpos($wgt['id'], 'widget_') === false) { } else {
$cat_staffs = array();
if (isset($wgt['staffs'])) { $cat_staffs = explode($ag_separator[2], $wgt['staffs']); }
$this_staff = ag_auth();
if (!empty($this_staff) && isset($this_staff['id'])) {
if (in_array($this_staff['id'], $cat_staffs)) {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=widget&amp;id='.$wgt['id'].'#item_'.$wgt['id'].'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
if ($this_staff['access'] == 'founder' || $this_staff['access'] == '1') {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=widget&amp;id='.$wgt['id'].'#item_'.$wgt['id'].'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
}
}
$obj_edit_link = '';
if (!empty($obj_edit)) { $obj_edit_link = '<div class="ag_edit">'.$obj_edit.'</div>'; }




if (isset($wgt['icon']) && !empty($wgt['icon'])) {
$wgt_icon = '<i class="' .$wgt['icon']. '"></i>';	
}


if (isset($wgt['title']) && !empty($wgt['title'])) {
	if (isset($wgt['hidden_title']) && $wgt['hidden_title'] == '1') {} else {$wgt_title = '<h4 class="ag_title_wgt">' .$wgt_icon.$wgt['title']. '</h4>';} 
	$wgt_alt = $wgt['title'];
}
$w_link_target = '';
$w_link_addr = '';
$w_link_txt = '';
if (isset($wgt['link']) && !empty($wgt['link'])) {
$w_link_a = explode($ag_separator[2],$wgt['link']);
if (isset($w_link_a[0]) && isset($w_link_a[1]) && !empty($w_link_a[0])) {
$w_link_addr = $w_link_a[0];
$w_link_txt = $w_link_a[1];
if (strpos($w_link_addr, 'http') === false) {} else {$w_link_target = ' target="_blank"';}
if (empty($w_link_txt)) {$w_link_txt = $w_link_addr;}	
}
}


if (isset($wgt['photo']) && !empty($wgt['photo'])) {
	if (file_exists($ag_photos_dir.$wgt['photo'])) {
$wgt_photo = '<img src="' .$ag_photos_dir.$wgt['photo']. '" alt="' .$wgt_alt. '" />';
if (!empty($w_link_addr)) {$wgt_photo = '<a href="'.$w_link_addr.'"'.$w_link_target.'><img src="' .$ag_photos_dir.$wgt['photo']. '" alt="' .$wgt_alt. '" /></a>';}
$wgt_video_img = $ag_photos_dir.$wgt['photo'];	
	}
}

if (isset($wgt['video']) && !empty($wgt['video'])) {
	if (file_exists($ag_data_dir.'/'.$ag_upload_name.$wgt['video'])) {
	$ag_v_format_a = explode('.', $wgt['video']);
	$ag_v_format = array_pop($ag_v_format_a);
	$ag_vposter = '';
	if(isset($wgt_video_img)) {$ag_vposter = ' poster="' .$wgt_video_img. '"';}
$wgt_video = '<video controls="controls"' .$ag_vposter. '><source src="'.$ag_data_dir.'/'.$ag_upload_name.$wgt['video'].'" type="video/'.$ag_v_format.'"></video>';
$wgt_photo = '';	
    }
}

$wgt_lbutton = '';
if (!empty($w_link_addr) && empty($wgt_photo)) {
$wgt_lbutton = '<a href="'.$w_link_addr.'"'.$w_link_target.' class="ag_button">'.$w_link_txt.'</a>';
}

if (isset($wgt['content']) && !empty($wgt['content'])) {
$wgt['content'] = html_entity_decode($wgt['content'], ENT_QUOTES, 'UTF-8');
$wgt['content'] = str_replace('[site_url]', '', $wgt['content']);
$wgt['content'] = str_replace($ag_separator[3], ' ', $wgt['content']);
$wgt['content'] = ag_close_tags($wgt['content']);
$wgt_class = '';
if ($wid == 'ag_last_obj' || $wid == 'ag_list_cat') {$wgt_class = ' ag_list_wgt';}
$wgt_content = '<div class="ag_widget_content'.$wgt_class.'">' .$wgt['content'].$wgt_lbutton.$obj_edit_link. '<div class="ag_clear"></div></div>';	
} else {
if (!empty($obj_edit)) {$wgt_content = '<div class="ag_widget_content'.$wgt_class.'">' .$wgt_lbutton.$obj_edit_link. '<div class="ag_clear"></div></div>';	}
}

//functions wgt
$wgt_func_top = '';
$wgt_func_bottom = '';
if (isset($wgt['functions'])) { 
$ag_functions = explode($ag_separator[2], $wgt['functions']);

$ag_function = array();
foreach ($ag_functions as $ag_function_id) {
if (file_exists($ag_data_dir.'/function'.$agt) && filesize($ag_data_dir.'/function'.$agt) != 0) {
$ag_function = ag_read_data($ag_data_dir.'/function'.$agt); 

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {	
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 

if (file_exists($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php')) {
    ob_start();
	include($ag_data_dir.'/'.$ag_config);
	include($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php');
	$ag_out_code_top = ob_get_contents();
	ob_end_clean();
    $wgt_func_top .= $ag_out_code_top; //out code top	
  }// file_exists top
  
  if (file_exists($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php')) { 
    ob_start();
	include($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php');
	
	$ag_out_code_bottom = ob_get_contents();
	ob_end_clean();
    $wgt_func_bottom .= $ag_out_code_bottom; //out code bottom	
  }// file_exists bottom

}// func status
}// func id
}// foreach ag_function
}// file_exists & !=0
}// foreach ag_functions
}// isset functions 

$ag_id_widget = 'r_'.$wid. '_'.$ag_count_wgt;
if ($mode == 'footer') {$ag_id_widget = 'f_'.$wid. '_'.$ag_count_wgt;}

$ag_widget .= '<div class="ag_widget_block">';
$ag_widget .= '<div class="ag_widget_block_inner">';
$ag_widget .= '<div class="ag_post_item" id="' .$ag_id_widget. '">';

$ag_widget .= $wgt_title;
$ag_widget .= $wgt_func_top;
$ag_widget .= $wgt_photo;
$ag_widget .= $wgt_video;
$ag_widget .= $wgt_content;
$ag_widget .= $wgt_func_bottom;

$ag_widget .= '<div class="ag_clear"></div>';
$ag_widget .= '</div>';
$ag_widget .= '</div>';
$ag_widget .= '</div>';

}// status
}// id

}// foreach ag_wgt
} //foreach ag_this_widgets

}// file_exists wgt

if (!empty($ag_widget)) {

if ($mode != 'footer') {
$ag_widgets .= '<div id="ag_widgets_open" onclick="ag_widgets_open()"><i class="icon-th-large"></i></div>';
$ag_widgets .= '<div id="ag_widget_column" class="ag_widget_column">';
$ag_widgets .= '<div class="ag_widgets_inner">';
}

$ag_widgets .= $ag_widget;
$ag_widgets .= '<div class="ag_clear"></div>';

if ($mode != 'footer') {
$ag_widgets .= '</div>';
$ag_widgets .= '</div>';
$ag_widgets .= '<div id="ag_widgets_close" onclick="ag_widgets_close()"><i class="icon-cancel"></i></div>';
}
}
//if ($ag_error_get == 1) {$ag_widgets = '';}
return $ag_widgets;
}// ag_widgets









function ag_check_obj() {
global $ag_cat;
global $ag_separator;
global $ag_data_dir;	
global $agt;

$count_cat = 0;	
$count_obj = 0;	
$cat_id = '';
$ag_obj = array();
foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { $count_cat++;
if (isset($cat['id'])) {$cat_id = $cat['id'];}

if (file_exists($ag_data_dir.'/object/'.$cat_id.$agt)){	
$ag_obj = ag_read_data($ag_data_dir.'/object/'.$cat_id.$agt);

//function obj
foreach ($ag_obj as $nc => $obj) {

if (isset($obj['id'])) {$obj_id = $obj['id'];}
if (isset($obj['status']) && $obj['status'] == 1) {	$count_obj ++;

}// status obj
}// foreach ag_obj
}// file_exists

}// status cat
}// foreach ag_cat
return $count_obj;
}

//---------------------------------------------- CSS IN FUNCTION

function ag_css_func() {

global $ag_cat;
global $ag_separator;
global $ag_data_dir;	
	
global $ag_alias_cat;
global $ag_alias_obj;	
global $agt;
	

$ag_func_css_str = '';
$ag_func_css_arr = array();
$ag_function = array();
$cat_id = '';
$cat_al = '';
$cat_this_id = '';

foreach ($ag_cat as $nc => $cat) {

if (isset($cat['id'])) {$cat_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_al = $cat['alias'];}
if (isset($cat['status']) && $cat['status'] == 1) {	

if (!empty($ag_alias_cat) && $ag_alias_cat == $cat_al) {$cat_this_id = $cat_id;}

//function cat
if (isset($cat['functions'])) { 
$ag_functions_cat = explode($ag_separator[2], $cat['functions']);
foreach ($ag_functions_cat as $ag_function_id) {
	
if (file_exists($ag_data_dir.'/function'.$agt) && filesize($ag_data_dir.'/function'.$agt) != 0) { 
$ag_function = ag_read_data($ag_data_dir.'/function'.$agt); 
}

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 

if (file_exists($ag_data_dir.'/function/css_'.$ag_func['id'].'.css')) { 
$ag_fcss_cont = file_get_contents($ag_data_dir.'/function/css_'.$ag_func['id'].'.css'); 
if (!empty($ag_fcss_cont)) {
$ag_func_css_str .= $ag_data_dir.'/function/css_'.$ag_func['id'].'.css'.$ag_separator[0]; 
}
}



}// status function
}// id function
}// foreach ag_function

}// foreach ag_functions_cat
}// isset cat functions



//function obj
$ag_function_obj = array();
if (file_exists($ag_data_dir.'/object/'.$cat_id.$agt)) {	
$ag_function_obj = ag_read_data($ag_data_dir.'/object/'.$cat_id.$agt);

//function obj
foreach ($ag_function_obj as $nc => $obj) {

if (isset($obj['id'])) {$obj_id = $obj['id'];}
if (isset($obj['status']) && $obj['status'] == 1) {	


if (isset($obj['functions'])) { 
$ag_functions_obj = explode($ag_separator[2], $obj['functions']);
foreach ($ag_functions_obj as $ag_function_id) {

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 

if (file_exists($ag_data_dir.'/function/css_'.$ag_func['id'].'.css')) {
$ag_fcss_cont = file_get_contents($ag_data_dir.'/function/css_'.$ag_func['id'].'.css'); 
if (!empty($ag_fcss_cont)) {
$ag_func_css_str .= $ag_data_dir.'/function/css_'.$ag_func['id'].'.css'.$ag_separator[0]; 
}
}



}// status function
}// id function
}// foreach ag_function

}// foreach ag_functions_obj
}// isset obj functions

}// status func obj
}// foreach ag_function_obj

}// file_exists obj cat


}// status cat
}// foreach ag_cat



//function wgt
$ag_wgt = array();
if (file_exists($ag_data_dir.'/widget'.$agt)){	
$ag_wgt = ag_read_data($ag_data_dir.'/widget'.$agt);
foreach ($ag_wgt as $nw => $wgt) {

if (isset($wgt['status']) && $wgt['status'] == 1) {	



if (isset($wgt['functions'])) { 
$ag_functions_wgt = explode($ag_separator[2], $wgt['functions']);
foreach ($ag_functions_wgt as $ag_function_id) {

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 

if (file_exists($ag_data_dir.'/function/css_'.$ag_func['id'].'.css')) { 
$ag_fcss_cont = file_get_contents($ag_data_dir.'/function/css_'.$ag_func['id'].'.css'); 
if (!empty($ag_fcss_cont)) {
$ag_func_css_str .= $ag_data_dir.'/function/css_'.$ag_func['id'].'.css'.$ag_separator[0];
} 
}

}// status function
}// id function
}// foreach ag_function

}// foreach ag_functions_wgt
}// isset wgt functions


}// wgt status	
}// foreach ag_wgt
}// file_exists widgets



$ag_func_css_arr = explode($ag_separator[0], $ag_func_css_str);
array_pop($ag_func_css_arr);
$ag_func_css_arr = array_unique($ag_func_css_arr);
return $ag_func_css_arr;
}// ag_css_func



//---------------------------------------------- META

function ag_meta($ag_tag='title', $meta_value) {
	
global $ag_cat;
global $ag_separator;
global $ag_data_dir;
global $agt;
global $ag_cfg_title;
global $ag_cfg_description;
global $ag_cfg_meta_description;
global $ag_get_cat;
global $ag_get_obj;
global $ag_get_search;
global $ag_get_sitemap;
global $ag_alias_cat;
global $ag_alias_obj;
global $ag_lng;
global $ag_error_get;
global $ag_not_found_content;


$ag_cfg_description = str_replace($ag_separator[3], ' ', $ag_cfg_description);
$ag_cfg_meta_description = str_replace($ag_separator[3], ' ', $ag_cfg_meta_description);

$ag_meta_id = '';
$ag_meta_alias = '';
$ag_meta_val = '';

$obj_alias = '';
$obj_title = '';
$obj_descr = '';

$ag_db_file = '';

$ag_found_cat = 0;
$ag_found_obj = 0;

if ($ag_tag == 'title') { $ag_meta_val = $ag_cfg_title.' - '.$ag_cfg_description; } // title home
if ($ag_tag == 'description') { 
if (!empty($ag_cfg_meta_description)) { 
$ag_meta_val = $ag_cfg_meta_description; 
} else { 
$ag_meta_val = $ag_cfg_description;
}
}// description home

if (!empty($ag_cat) && !empty($ag_alias_cat) && empty($meta_value)) {
foreach ($ag_cat as $ag_meta) {

if (isset($ag_meta['alias'])) { $ag_meta_alias = $ag_meta['alias']; }
if (isset($ag_meta['id'])) { $ag_meta_id = $ag_meta['id']; }	



if ($ag_alias_cat == $ag_meta_alias) {

//cat	
if (isset($ag_meta['status']) && $ag_meta['status'] == 1) {
	
if ($ag_tag == 'title') {
if (isset($ag_meta['name'])) { $ag_meta_val = $ag_meta['name']. ' - ' .$ag_cfg_title; }
if (isset($ag_meta['title'])) { $ag_meta_val = $ag_meta['title']. ' - ' .$ag_cfg_title; }
}// title

if ($ag_tag == 'description') {
if (isset($ag_meta['description']) && !empty($ag_meta['description'])) { 
$ag_meta['description'] = str_replace($ag_separator[3], ' ', $ag_meta['description']);
$ag_meta_val = $ag_meta['description']; 
}
}// description

//obj
if (!empty($ag_alias_obj)) {
	
if (file_exists($ag_data_dir.'/object/'.$ag_meta_id.$agt)) {
$ag_db_file = $ag_data_dir.'/object/'.$ag_meta_id.$agt;	
}
	
if (!empty($ag_db_file)) {
$ag_data_obj = ag_read_data($ag_db_file); 	
foreach ($ag_data_obj as $meta_obj) {

if (isset($meta_obj['alias'])) { $obj_alias = $meta_obj['alias']; }
	if ($obj_alias == $ag_alias_obj) { 
	if (isset($meta_obj['status']) && $meta_obj['status'] == 1) {
	$ag_found_obj = 1;
	if (isset($meta_obj['name'])) { $obj_title = $meta_obj['name']; }
	if (isset($meta_obj['title'])) { $obj_title = $meta_obj['title']; }
    if (isset($meta_obj['description'])) { $obj_descr = $meta_obj['description']; }

	if ($ag_tag == 'title') {
	$ag_meta_val = $obj_title. ' - ' .$ag_meta_val;	
	}
	
	if ($ag_tag == 'description') {
		if (!empty($obj_descr)) {
		$obj_descr = str_replace($ag_separator[3], ' ', $obj_descr);
	    $ag_meta_val = $obj_descr;	
	    } 
	}
	
	}// obj status	
	}// get = obj
	
	
}// foreach ag_data_obj
}// !empty ag_db_file
	
}// !empty ag_alias_obj


$ag_found_cat = 1;

}// status
}// alias = get

}// foreach ag_cat

}// no empty data

if (!empty($meta_value)) {$ag_meta_val = $meta_value;}

if ($ag_error_get == 1) { $ag_meta_val = $ag_lng['error_404_meta']; 
} else {
if (isset($_GET[$ag_get_cat]) && $ag_found_cat == 0) { $ag_meta_val = $ag_lng['error_404_meta']; }
if (isset($_GET[$ag_get_obj]) && $ag_found_obj == 0) { $ag_meta_val = $ag_lng['error_404_meta']; }
}
if (isset($_GET[$ag_get_search])) { 
$ag_meta_val = $ag_lng['search']. ' - ' .$ag_meta_val; 
if (ag_search($_GET[$ag_get_search]) == $ag_not_found_content) { $ag_meta_val = $ag_lng['error_404_meta'];}
}// search

if (isset($_GET[$ag_get_sitemap])) {
$ag_meta_val = $ag_lng['sitemap']. ' - ' .$ag_meta_val; 	
}// sitemap

return $ag_meta_val;
}// ag_meta

// other meta
$ag_title = '';
$ag_description = '';

// other meta



//---------------------------------------------- BOOKING
if (file_exists('inc/booking.php')) { include('inc/booking.php'); }







//---------------------------------------------- LIST OBJECTS


function ag_list_obj($cat_id='', $count_obj='0', $objects='', $mode='') {

global $ag_lng;	
global $ag_lng_monts_r;
global $ag_cat;	
global $ag_staff;
global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_get_page;
global $ag_get_search;
global $ag_get_sitemap;
global $ag_page;
global $ag_alias_cat;
global $ag_alias_obj;	

global $ag_photos_dir;
global $ag_mob_photos;
global $ag_is_mob;	

global $ag_404_content;
global $ag_none_content;

global $ag_cfg_home;
global $ag_cfg_home_blocks;

global $ag_cfg_home_content;
global $ag_cfg_home_content_js;
global $ag_config;

global $srv_absolute_url;
global $ag_apanel_link;

$ag_home_cat_blocks_obj = '0';

$list_obj = '';
$punkt_obj = '';
$ag_page_nav = '';
$obj_rss = '';

//page navigation
$co = 0;
$total_page = 1;
if(empty($count_obj)) {$count_obj = 0;}
$total_obj = 0;

$ag_found_obj = 0;
$ag_count_cat = 0;

$list_obj_arr = array();

$obj_mode = '';
if (!empty($mode)) {
$mode_arr = explode(',', $mode);
$count_short_post = 300;
if (isset($mode_arr[0]) && !empty($mode_arr[0])) {$obj_mode = $mode_arr[0];}
if (isset($mode_arr[1]) && !empty($mode_arr[1])) {
	if ((int)$mode_arr[1] > 0) { $count_short_post = (int)$mode_arr[1]; }
	}
}// !empty mode


//home
foreach ($ag_cat as $nc => $cat) {
$cat_home_id = '';
$cat_home_alias = '';
$count = 0;
if (isset($cat['id'])) {$cat_home_id = $cat['id'];}
if (isset($cat['alias'])) { $cat_home_alias = $cat['alias']; }

if (isset($cat['status']) && $cat['status'] == 1) { $ag_count_cat++; 
$count = (int)$count;
if (isset($cat['count']) && empty($count)) {
if ((int)$cat['count'] > 0) { $count = (int)$cat['count']; }
}
if (isset($cat['blocks_obj'])) { $ag_home_cat_blocks_obj = $cat['blocks_obj']; }
break;
}// status
}// foreach ag_cat	


if (empty($cat_id)) { 
foreach ($ag_cat as $cat_all) {
if (isset($cat_all['status']) && $cat_all['status'] == 1) {
if (isset($cat_all['id'])) {$cat_id .= $cat_all['id'].',';}	
}	
}
}// empty cat_id


$cat_id_arr = array();
$cat_id = str_replace(' ', '', $cat_id);


$objects_arr = array();
if (!empty($objects)) { 
$objects = str_replace(' ', '', $objects);
$objects_arr = explode(',', $objects); 
$objects_arr = array_diff($objects_arr, array(''));
$objects_arr = array_unique($objects_arr);
}


$cat_id_arr = explode(',', $cat_id);	
$cat_id_arr = array_diff($cat_id_arr, array(''));
$cat_id_arr = array_unique($cat_id_arr);	



$sort_obj = array();
$ag_obj_list_arr = array();

$ag_obj_list = '';
$ag_list = '';

if (!empty($cat_id_arr)) {	
// obj in cat
foreach ($cat_id_arr as $cat_id) {

$cat_alias_id = '';
$ag_db_file = '';
$ag_alias_cat_link = '';
$ag_blocks_obj = '0';
$ag_cat_name = '';
$ag_off_date = '';
$links_prev_next = '0';
$link_to_cat = '0';
$cat_staffs = array();


if (file_exists($ag_data_dir.'/object/'.$cat_id.$agt)) { // id
	foreach ($ag_cat as $nc => $cat) {
	if (isset($cat['id']) && $cat['id'] == $cat_id) { 
	$cat_alias_id = $cat['id'];
	if (isset($cat['status']) && $cat['status'] == 1) { $ag_count_cat++; 
	if (isset($cat['alias'])) { $ag_alias_cat_link = $cat['alias']; }
	if (isset($cat['blocks_obj'])) { $ag_blocks_obj = $cat['blocks_obj']; }
	if (isset($cat['title'])) { $ag_cat_name = $cat['title']; }
	if (isset($cat['off_date'])) { $ag_off_date = $cat['off_date']; }
    if (isset($cat['prev_next_obj'])) { $links_prev_next = $cat['prev_next_obj']; }
	if (isset($cat['cat_link'])) { $link_to_cat = $cat['cat_link']; }
	if (isset($cat['staffs'])) { $cat_staffs = explode($ag_separator[2], $cat['staffs']); }
	
	if(sizeof($cat_id_arr) == 1) {
	  if (empty($count_obj)) { 
	  if (isset($cat['count_obj'])) { $count_obj = (int)$cat['count_obj']; } 
	  }
	}
	
	$ag_db_file = $ag_data_dir.'/object/'.$cat_id.$agt;
	}
	}// id cat	
	}
	
	} else { // alias
	foreach ($ag_cat as $nc => $cat) {
	if (isset($cat['alias']) && $cat['alias'] == $cat_id) { 
    if (isset($cat['status']) && $cat['status'] == 1) { $ag_count_cat++;
	if (isset($cat['id'])) { $cat_alias_id = $cat['id']; }
	if (isset($cat['blocks_obj'])) { $ag_blocks_obj = $cat['blocks_obj']; }
	if (isset($cat['title'])) { $ag_cat_name = $cat['title']; }
	if (isset($cat['off_date'])) { $ag_off_date = $cat['off_date']; }
    if (isset($cat['prev_next_obj'])) { $links_prev_next = $cat['prev_next_obj']; }
	if (isset($cat['cat_link'])) { $link_to_cat = $cat['cat_link']; }
	if (isset($cat['staffs'])) { $cat_staffs = explode($ag_separator[2], $cat['staffs']); }
	
	if(sizeof($cat_id_arr) == 1) {
	  if (empty($count_obj)) { 
	  if (isset($cat['count_obj'])) { $count_obj = (int)$cat['count_obj']; } 
	  }
	}
	
    $ag_alias_cat_link = $cat['alias'];	
	}
	}
	}// foreach ag_cat	
	if (!empty($cat_alias_id)) {
    $ag_db_file = $ag_data_dir.'/object/'.$cat_alias_id.$agt;
    } else { $ag_db_file = ''; }	
}

$ag_data = array();
if (!empty($ag_db_file) && file_exists($ag_db_file)) {

$ag_data = ag_read_data($ag_db_file); 

if(empty($objects)) { $ag_data = array_reverse($ag_data, true); }//inverse data lines


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
$cat_off_date = date("Y-m-d", strtotime($ag_off_date));
}// cat off date




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
$obj_description = '';
$obj_content_sort = '';
$obj_content_full = '';
$obj_content = '';
$obj_photo = '';
$img_alt = '';
$obj_info = '';
$obj_inc = '';
$obj_func_top = '';
$obj_func_bottom = '';
$photo_only_short = '';
$obj_rss = '';
$ag_list_photo = '';

$obj_link_prev = '';
$obj_link_next = '';

$obj_edit = '';
$this_staff = array();

if (isset($val['alias'])) { $ag_obj_alias = $val['alias']; }
if (isset($val['id'])) { $ag_obj_id = $val['id']; }



if (isset($val['photo_only_list'])) { $photo_only_short = $val['photo_only_list']; }

//obj include
$ag_obj_inc_class = '';
if (isset($val['service']) && !empty($val['service'])) {

if (function_exists('ag_obj_incude')) {	
$obj_inc_data = ag_obj_incude($val['service']);
}

if (isset($obj_inc_data)) {
if (isset($_GET[$ag_get_obj])) {	
$obj_inc = '<div class="ag_obj_include"><div class="ag_obj_include_inner">'.$obj_inc_data.'</div></div>'; 
}
if (!empty($obj_inc_data)) {
$ag_obj_inc_class = ' ag_obj_inc'; 
}
}
}// service


$this_staff = ag_auth();
if (!empty($this_staff) && isset($this_staff['id'])) {
if (in_array($this_staff['id'], $cat_staffs)) {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=object&amp;cat='.$cat_alias_id.'&amp;id='.$ag_obj_id.'#item_'.$ag_obj_id.'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
if ($this_staff['access'] == 'founder' || $this_staff['access'] == '1') {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=object&amp;cat='.$cat_alias_id.'&amp;id='.$ag_obj_id.'#item_'.$ag_obj_id.'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
}
//founder

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

if (strpos($obj_e_month, '0') === false) {} else {$obj_e_month = $obj_e_month[1];}
$ag_post_date = $obj_e_year.'-'.$obj_e_month .'-'.$obj_e_day;
$ag_week_day = strftime("%a", strtotime($ag_post_date));
$ag_rss_month = date('M',mktime(0,0,0,$obj_e_month));

$ag_rss_date = $ag_week_day.", ".$obj_e_day." ".$ag_rss_month." ".$obj_e_year." ".$obj_e_time." ".date("O");


if (isset($obj_info_arr[0])) { $obj_add_day = $obj_info_arr[0]; }
if (isset($obj_info_arr[1])) { $obj_add_month = $obj_info_arr[1]; }
if (isset($obj_info_arr[2])) { $obj_add_year = $obj_info_arr[2]; }
if (isset($obj_info_arr[3])) { $obj_add_time = $obj_info_arr[3]; }
if (isset($obj_info_arr[4])) { $obj_add_staff = $obj_info_arr[4]; }

$found_astsff = 0;
foreach ($ag_staff as $staff) {
if (isset($staff['id']) && $staff['id'] == $obj_add_staff) { $found_astsff = 1;
	if (isset($staff['name'])) {$obj_add_staff = $staff['name'];}
	if (isset($staff['email'])) {$obj_add_staff_mail = $staff['email'];}
	break;
	}
}
if ($found_astsff == 0) {$obj_add_staff = '';}

$ag_list_title = $val['title'];
$ag_list_autor = '';
$ag_list_date = '';
$ag_list_time = '';

$ag_rss_autor = '';
if (!empty($obj_add_staff_mail) && !empty($obj_add_staff)) {$ag_rss_autor = '<author>'.$obj_add_staff_mail. ' ('.$obj_add_staff.')</author>';}
$ag_rss_date = '<pubDate>' .htmlspecialchars(strip_tags($ag_rss_date)). '</pubDate>';
$ag_rss_title = '';
$ag_rss_link = '';
$ag_rss_content = '';
$ag_rss_photo = '';
$ag_rss_cat = '<category>' .htmlspecialchars(strip_tags($ag_cat_name)). '</category>';
$ag_rss_guid = '';



//info str
if (isset($val['hidden_autor']) && $val['hidden_autor'] == 1 || empty($obj_add_staff)) {} else {
	
$obj_info_str .= '<span class="ag_add_staff">' .$obj_add_staff. '</span>';
$ag_list_autor = $obj_add_staff. ' - ';

}
if (isset($val['hidden_time']) && $val['hidden_time'] == 1) {} else {
$obj_info_str .= '<span class="ag_add_time">' .$obj_add_time. '</span>';
$ag_list_time = ''.$obj_add_time.'';
}
if (isset($val['hidden_date']) && $val['hidden_date'] == 1) {} else {
$obj_info_str .= '<span class="ag_add_date">' .$obj_add_day. ' '.$ag_lng_monts_r[$obj_add_month]. ' ' .$obj_add_year. '</span>';
$ag_list_date = '' .$obj_add_day. ' '.$ag_lng_monts_r[$obj_add_month]. ' ' .$obj_add_year. ' ';
}


//link
$obj_link = '?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$ag_obj_alias;
$ag_rss_link = '<link>'.$srv_absolute_url.'?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$ag_obj_alias.'</link>';
$ag_rss_guid = '<guid isPermaLink="false">'.$srv_absolute_url.'?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$ag_obj_alias.'</guid>';

if (isset($_GET[$ag_get_search])) {
$obj_link = $obj_link. '&amp;_' .$ag_get_search. '=' .$_GET[$ag_get_search];
if (isset($_GET[$ag_get_page])) { $obj_link = $obj_link. '&amp;_'.$ag_get_page.'=' .$_GET[$ag_get_page]; }
}


//punkt
$punkt_obj_class = '';
if (isset($_GET[$ag_get_cat]) && isset($_GET[$ag_get_obj]) && $_GET[$ag_get_cat] == $ag_alias_cat_link && $_GET[$ag_get_obj] == $ag_obj_alias) {
$punkt_obj_class = ' class="ag_this_punkt"';	
}
if (isset($_GET[$ag_get_sitemap]) || isset($_GET[$ag_get_search])) {$punkt_obj_class = '';}
$punkt_obj = '<li'.$punkt_obj_class.'><h3><a href="' .$obj_link. '">' .$ag_list_title. '</a></h3></li>';



//back link for search result
$title_query = '';
if (!empty($ag_alias_cat) && $ag_obj_alias == $ag_alias_obj) {
if (isset($_GET['_'.$ag_get_search])) { 
$title_query = htmlspecialchars($_GET['_'.$ag_get_search], ENT_QUOTES, 'UTF-8');
$obj_back_link = '?' .$ag_get_search. '=' .$_GET['_'.$ag_get_search];
$obj_back_link_text = $ag_lng['back_to_search_result']; 
if (isset($_GET['_'.$ag_get_page])) {$obj_back_link = $obj_back_link. '&amp;'.$ag_get_page.'=' .$_GET['_'.$ag_get_page];}
$obj_back_link = $obj_back_link.'#'.$cat_alias_id. '_' .$ag_obj_id;
}
}


$ag_post_info_item_class = '';
if (!empty($obj_info_str)) {
$obj_info = '<div class="ag_post_info"><div>' .$obj_info_str. '<div class="ag_clear"></div></div></div>';
} else {$ag_post_info_item_class = ' ag_obj_item_no_info';}

if (!empty($obj_back_link)) {

$obj_info .= '<div class="ag_after_obj_links">';
$obj_info .= '<div class="ag_after_obj_links_inner">';
$obj_info .= '<a href="' .$obj_back_link. '" title="'.$title_query.'" class="ag_prev_obj"><i class="icon-left-open-4"></i>' .$obj_back_link_text. '</a>';
$obj_info .= '<div class="ag_clear"></div>';
$obj_info .= '</div>';
$obj_info .= '</div>';

}
//obj info added


//next/prev link
if ($ag_obj_alias == $ag_alias_obj) {
	
//sizeof($ag_data_a)	
$num_obj_next = $n-1;
$num_obj_prev = $n+1;

$prev_alias = '';
$next_alias = '';
$prev_title = '';
$next_title = '';

if (isset($ag_data_a[$num_obj_prev]['alias'])) { $prev_alias = $ag_data_a[$num_obj_prev]['alias']; }
if (isset($ag_data_a[$num_obj_next]['alias'])) { $next_alias = $ag_data_a[$num_obj_next]['alias']; }

if (isset($ag_data_a[$num_obj_prev]['title'])) { $prev_title = $ag_data_a[$num_obj_prev]['title']; }
if (isset($ag_data_a[$num_obj_next]['title'])) { $next_title = $ag_data_a[$num_obj_next]['title']; }

if (!empty($next_alias)){
$obj_link_next = '<a href="?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$next_alias.'" title="'.$ag_lng['next_obj'].'" class="ag_next_obj"><i class="icon-right-open-4"></i><span>'.$next_title.'</span></a>'; }

if (!empty($prev_alias)){
$obj_link_prev = '<a href="?' .$ag_get_cat. '=' .$ag_alias_cat_link. '&amp;' .$ag_get_obj. '=' .$prev_alias.'" title="'.$ag_lng['prev_obj'].'" class="ag_prev_obj"><i class="icon-left-open-4"></i><span>'.$prev_title.'</span></a>'; }




if (!empty($prev_alias) || !empty($next_alias)) {
if ($links_prev_next == '1' && !isset($_GET['_'.$ag_get_search])) {
$obj_info .= '<div class="ag_after_obj_links">';
$obj_info .= '<div class="ag_after_obj_links_inner">';
$obj_info .= $obj_link_prev;
$obj_info .= $obj_link_next;
$obj_info .= '<div class="ag_clear"></div>';
$obj_info .= '</div>';
$obj_info .= '</div>';
}
}

}// next/prev link this obj


//title
if (isset($val['title'])) {
if ($ag_obj_alias == $ag_alias_obj) { $ag_found_obj = 1; } // found or 404
if (isset($val['hidden_title']) && $val['hidden_title'] == 1) {
$obj_title = '<div class="ag_no_title">&#160;</div>';
} else {	
$obj_title = '<h3 class="ag_title_obj"><a href="' .$obj_link. '">' .$val['title']. '</a></h3>'; 	
}// hidden tite
if (!empty($ag_alias_cat) && $ag_obj_alias == $ag_alias_obj) { 
$obj_title = '<h3 class="ag_title_obj ag_title_obj_open">'.$val['title']. '</h3>';
if ($link_to_cat == '1') {$obj_title .= '<h5 class="ag_to_cat">'.$ag_lng['category'].': <a href="?' .$ag_get_cat. '=' .$ag_alias_cat_link. '">' .$ag_cat_name. '</a></h5>';}

}
$img_alt = htmlspecialchars($val['title'], ENT_QUOTES, 'UTF-8');

//$ag_rss_title = htmlspecialchars($val['title'], ENT_QUOTES, 'UTF-8');
$ag_rss_title = $val['title'];
$ag_rss_title = '<title>'.htmlspecialchars(strip_tags($ag_rss_title)).'</title>';
}



//description
$hidden_desc = 0;
if (isset($val['hidden_description']) && $val['hidden_description'] == 1) { $hidden_desc = 1; }//hidden description
if ($hidden_desc == 0) {
if (isset($val['description']) && !empty($val['description'])) { 
$val['description'] = str_replace($ag_separator[3], '<br />', $val['description']);
$obj_description = '<h4 class="ag_description_obj">' .$val['description']. '</h4>'; 
}
}//hidden description


//top
$ag_open_obj_class = '';
if (!empty($ag_alias_cat)) {
if ($ag_obj_alias == $ag_alias_obj || $ag_blocks_obj == '0') { $ag_open_obj_class = ' ag_full_width_obj'; } 
} else {
if ($ag_cfg_home == 'first_category') { 
if ($ag_home_cat_blocks_obj == '0') { $ag_open_obj_class = ' ag_full_width_obj'; }
} else {
if ($ag_cfg_home_blocks == '0') { $ag_open_obj_class = ' ag_full_width_obj'; }	
} 
}
if (isset($_GET[$ag_get_search])) { $ag_open_obj_class = ' ag_full_width_obj'; }	



$obj_top = '<article>';
$obj_top .= '<div class="ag_obj_block' .$ag_open_obj_class. '">';
$obj_top .= '<div class="ag_obj_item'.$ag_post_info_item_class.'" id="' .$cat_alias_id. '_' .$ag_obj_id. '">';
$obj_top .= '<div class="ag_obj_content ag_post_item'.$ag_obj_inc_class.'">';
$obj_top .= '<div class="ag_content_width"></div>';
$obj_top .= $obj_title;

$obj_edit_link = '';
if (!empty($obj_edit)) { $obj_edit_link = '<div class="ag_edit">'.$obj_edit.'</div>'; }

//content
$no_content_class = '';
$obj_content_no_sort = '';
$ag_content_check = '';
if (isset($val['content']) && !empty($val['content'])) {



$val['content'] = html_entity_decode($val['content'], ENT_QUOTES, 'UTF-8');
$val['content'] = str_replace('[site_url]', '', $val['content']);
//$val['content'] = str_replace(array('&nbsp;', '&#160;'), ' ', $val['content']);
$val['content'] = str_replace('<p><!-- pagebreak --></p>', '<!-- pagebreak -->', $val['content']);
if ($val['content'] == '<!-- pagebreak -->') {$val['content'] = '';}

$ag_content_check = $val['content'];

$obj_content_arr = explode('<!-- pagebreak -->', $val['content']);
if (isset($obj_content_arr[0])) { $obj_content_sort = $obj_content_arr[0]; }
if (isset($obj_content_arr[1])) { $obj_content_no_sort = $obj_content_arr[1]; } else { $obj_content_no_sort = $val['content']; }


if (isset($val['hidden_short']) && $val['hidden_short'] == '1') {	
$obj_content_full = ag_close_tags($obj_content_no_sort);
} else {
$obj_content_full = $val['content'];
}




$more_text = '';
$more_text_search = '';
if ($obj_mode == 'short') { // short
$obj_content_sort = str_replace(array('<ul>','<ol>','</ul>','</ol>'), '', $obj_content_sort);
$obj_content_sort = str_replace('<li>', '<p>', $obj_content_sort);
$obj_content_sort = str_replace('</li>', '</p>', $obj_content_sort);
	$obj_content_sort = strip_tags($obj_content_sort, '<a><button><b><strong><i><u><small><span><p><br><table><thead><tbody><tr><th><td>');
	$obj_content_sort = str_replace($ag_separator[3], ' ', $obj_content_sort);
    $obj_content_sort = ag_close_tags($obj_content_sort);
	$obj_content_sort = str_replace(array('<p></p>','<p class="ag_empty_p">&nbsp;</p>'), '', $obj_content_sort);
	
    if (strpos($val['content'], '<!-- pagebreak -->') === false) { 
	$obj_content_sort = strip_tags($obj_content_sort, ' ');
	if (strlen($obj_content_sort) > $count_short_post) {
	$obj_content_sort = mb_substr($obj_content_sort, 0, mb_strrpos(mb_substr($obj_content_sort, 0, $count_short_post, 'utf-8'),' ', 'utf-8'), 'utf-8');
	rtrim($obj_content_sort, "!,.-");
    
	$more_text = ' <a href="' .$obj_link. '" title="'.$ag_lng['read_more'].'" class="ag_read_more">...</a>'; 
	}
	}
	if (isset($_GET[$ag_get_search])) {$more_text_search = '<a href="' .$obj_link. '" title="'.$ag_lng['open'].'" class="ag_button ag_search_open">'.$ag_lng['open'].'</a><span class="ag_clear"></span>';}
	
	
	if (!empty($obj_content_sort)) {
	if (strpos($obj_content_sort, '</p>') === false) {$obj_content_sort = '<p class="ag_short_p">' .$obj_content_sort.$more_text. '</p>';}
	else {$obj_content_sort = str_replace('<p', '<p class="ag_short_p"', $obj_content_sort);}
	if (empty($obj_description)) {$obj_description = $obj_description.'<p class="ag_empty_p ag_nomob_empty_p">&nbsp;</p>';}
	
	$obj_content = $obj_description.'<div class="ag_list_obj ag_short_obj"><div>' .$obj_content_sort. '' .$obj_edit_link.$more_text_search. '</div><div class="ag_clear"></div></div>';

	//if (empty($obj_content_sort)) {$no_content_class = ' ag_no_content'; }
	
	} else { 
	$no_content_class = ' ag_no_content'; 
	if (!empty($obj_edit)) {$obj_content = '<div class="ag_list_obj ag_short_obj"><div class="ag_edit">'.$obj_edit.'</div></div>';} 
	}
	
	
	} else { // full
		
		
	$obj_content_full = str_replace($ag_separator[3], "\n", $obj_content_full);
	$obj_content_full = str_replace('&nbsp<iframe', '<iframe', $obj_content_full);
	$obj_content_full = str_replace('&nbsp<img', '<img', $obj_content_full);
	$obj_content_full = str_replace('&nbsp<video', '<video', $obj_content_full);
	$obj_content_full = str_replace('&nbsp<audio', '<audio', $obj_content_full);
	
	
	if (!empty($obj_content_full)) {
	
    $obj_content = $obj_description.'<div class="ag_list_obj ag_full_obj">' .$obj_content_full.$obj_edit_link. '<div class="ag_clear"></div></div>';
    } else { 
	$no_content_class = ' ag_no_content';
	}
	}
} else { 

$no_content_class = ' ag_no_content'; $obj_content = '<div class="ag_empty">---</div>'; 

if (!empty($obj_edit)) {$obj_content = '<div class="ag_list_obj ag_short_obj"><div class="ag_edit">'.$obj_edit.'</div></div>';}
}// isset content


if ($obj_mode == 'short') { } else {
if (!empty($obj_inc)) {
if (empty($obj_content_full)) {$obj_content = $obj_description;}
$obj_inc = '<div class="ag_list_obj ag_full_obj">'.$obj_inc.'</div>';
}
}



$ag_rss_content = ag_close_tags($obj_content_sort);

$ag_rss_content = str_replace($ag_separator[3], "\n", $ag_rss_content);
if (empty($ag_rss_content)) {$ag_rss_content = $ag_lng['none_content'];}

$ag_rss_content = str_replace("'", "", $ag_rss_content);
$ag_rss_content = str_replace('"', '', $ag_rss_content);	

$ag_rss_content = str_replace('«', '', $ag_rss_content);
$ag_rss_content = str_replace('»', '', $ag_rss_content);	
$ag_rss_content = str_replace('’', '', $ag_rss_content);
$ag_rss_content = str_replace('`', '', $ag_rss_content);

$ag_rss_content = htmlspecialchars(strip_tags($ag_rss_content));

// list text
$ag_list_text = '';
$ag_list_text = strip_tags($val['content'], ' ');
if (!empty($ag_list_text)) {
$ag_list_text = mb_substr($ag_list_text, 0, strrpos(mb_substr($ag_list_text, 0, 180, 'utf-8'),' '), 'utf-8');
}
if (!empty($ag_list_text)) {$ag_list_text = $ag_list_text.' <a href="' .$obj_link. '" title="'.$ag_lng['read_more'].'" class="ag_read_more">...</a>';}


// photo
$obj_photo = '';
$obj_first_photo = '';
$obj_one_photo = '';
$obj_short_photos = '';
$obj_icon_photo = '';
$obj_text_photo = '';
$count_photos = 0;
$count_short_photos = 0;

$ag_photos_after = '';
if (isset($val['photos_after']) && $val['photos_after'] == 1) {$ag_photos_after = 1;}

if ($obj_mode == 'short') { $ag_photos_after = 0; }

if (isset($val['icon_photo']) && !empty($val['icon_photo'])) {
$obj_icon_photo = '<span class="ag_icon_photo"><i class="' .$val['icon_photo']. '"></i></span>';}
if (isset($val['text_photo']) && !empty($val['text_photo'])) {$val['text_photo'] = html_entity_decode($val['text_photo'], ENT_QUOTES, 'UTF-8'); $obj_text_photo = '<p class="ag_text_photo"><span>' .$val['text_photo']. '</span></p>';}



if (isset($val['photos']) && !empty($val['photos'])) {	
$photos = explode($ag_separator[2], $val['photos']);
foreach ($photos as $np => $photo) {

if ($np == 0) {	
if (!empty($photo) && file_exists($ag_photos_dir.$photo)) { 
$ag_rss_photo = '<img src="'.$srv_absolute_url.''.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" style="width:25%; height:auto; float:left; margin:0 16px 16px 0;" />';
}

//list photo
if (!empty($photo) && file_exists($ag_mob_photos.$photo)) {
$ag_list_photo = '<img src="'.$ag_mob_photos.$photo.'" alt="'.$img_alt.'" />';
}

}



if ($obj_mode == 'short') { $count_short_photos++;
if ($np == 0) {	
if (file_exists($ag_photos_dir.$photo)) { 
$obj_photo = '<div class="ag_obj_photo ag_first_photo'.$no_content_class.'"><a href="' .$obj_link.'" class="ag_rotate_phoos"><img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_move_photo" />'.$obj_icon_photo.$obj_text_photo.'</a></div>';
}
} else { // first photo

if (file_exists($ag_mob_photos.$photo)) {
if ($count_short_photos == sizeof($photos)) { $obj_short_photos .= 'ag_photo_'. $count_short_photos. ': "' .$ag_mob_photos.$photo. '"'; } else {
$obj_short_photos .= 'ag_photo_'. $count_short_photos. ': "' .$ag_mob_photos.$photo. '", ';}
}

} // short photos

} else {
if (!empty($photo) && file_exists($ag_photos_dir.$photo)) { $count_photos++;

if ($ag_obj_alias == $ag_alias_obj && $count_photos == 1) {
$obj_first_photo .= '<div class="ag_one_photo_open ag_top_photo">';
$obj_first_photo .= '<div class="ag_first_photo_open">';
$obj_first_photo .= '<img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_first_img" />';
$obj_first_photo .= '</div>';
$obj_first_photo .= '</div>';
$obj_first_photo .= '<div class="ag_clear"></div>';

$obj_one_photo .= '<div class="ag_one_photo_open">';
$obj_one_photo .= '<div class="ag_first_photo_open">';
$obj_one_photo .= '<img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_first_img" />';
$obj_one_photo .= '</div>';
$obj_one_photo .= '</div>';
$obj_one_photo .= '<div class="ag_clear"></div>';

}






$obj_photo .= '<div class="ag_obj_photo'.$no_content_class.'"><a href="'.$ag_photos_dir.$photo.'" class="ag_popup_photos"><img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_img_'.$count_photos.'" /></a><span class="ag_zoom_in"><i class="icon-zoom-in"></i></span></div>';	

}// file_exists photo
}// short mode

}// foreach photos
}// isset photos
if (isset($_GET[$ag_get_obj]) && !empty($_GET[$ag_get_obj]) && $count_photos > 1) {

$obj_photo = $obj_first_photo.'<div class="ag_photos">
<div class="ag_photos_inner">'.$obj_photo.'<div class="ag_clear"></div></div>
<div class="ag_photos_next" tabindex="-1" onclick="ag_next_photos(this)"><i class="icon-right-open-big"></i></div>
<div class="ag_photos_prev" tabindex="-1" onclick="ag_prev_photos(this)"><i class="icon-left-open-big"></i></div>
</div>';
$obj_photo_p = '';
if ($ag_photos_after == 1) {
	$obj_photo_p = '<p class="ag_empty_p ag_photos_after">&#160;</p>';
	if (!empty($obj_inc)) { $obj_photo_p = '<p class="ag_empty_p">&#160;</p>'; }
    if (empty($ag_content_check)) {$obj_photo_p = '<p class="ag_empty_p_nocontent">&#160;</p>';}	
	
} else {
	$obj_photo_p = '<p class="ag_empty_p">&#160;</p>';
	if (!empty($obj_inc)) { $obj_photo_p = '<p class="ag_empty_p">&#160;</p>'; }
    if (empty($ag_content_check)) {$obj_photo_p = '<p class="ag_empty_p_nocontent">&#160;</p>';}	
	if (!empty($obj_description)) {$obj_photo_p = '<p class="ag_empty_p_nocontent">&#160;</p>';}
	}
$obj_photo = $obj_photo.$obj_photo_p;
	
	
if ($photo_only_short == '1') {$obj_photo = '';}

} else {

if (!empty($ag_alias_cat) && $ag_obj_alias == $ag_alias_obj) { 

$obj_one_photo_p = '';
if ($ag_photos_after == 1) {
	$obj_one_photo_p = '<p class="ag_empty_p ag_photos_after">&#160;</p>';
	if (!empty($obj_inc)) { $obj_one_photo_p = '<p class="ag_empty_p">&#160;</p>'; }
    if (empty($ag_content_check)) {$obj_one_photo_p = '<p class="ag_empty_p ag_empty_p_nocontent">&#160;</p>';}	
	if (!empty($obj_description)) {$obj_one_photo_p = '<p class="ag_empty_p_nocontent">&#160;</p>';}
} else {
	$obj_one_photo_p = '<p class="ag_empty_p">&#160;</p>';
	if (!empty($obj_inc)) { $obj_one_photo_p = '<p class="ag_empty_p">&#160;</p>'; }
    if (empty($ag_content_check)) {$obj_one_photo_p = '<p class="ag_empty_p ag_empty_p_nocontent">&#160;</p>';}	
	if (!empty($obj_description)) {$obj_one_photo_p = '<p class="ag_empty_p_nocontent">&#160;</p>';}
	}

$obj_photo = $obj_one_photo.$obj_one_photo_p; 


} else {
$slId = 'ag_ph_'.$cat_alias_id. '_' .$ag_obj_id;
$obj_photo = '<div class="ag_one_photo" id="'.$slId.'">'.$obj_photo.'</div>';
if (!empty($obj_short_photos) && $ag_is_mob != 1) {
$obj_photo .=  '<script>

var ag_photos_'.$slId.' = {'.$obj_short_photos.'};

var preload_'.$slId.'_ph = "";

for (var pkey in ag_photos_'.$slId.') { 
preload_'.$slId.'_ph += \'<img src="\'+ ag_photos_'.$slId.'[pkey] +\'" alt="'.$img_alt.'" class="ag_fade_short_img slide_\'+ pkey +\'" style="position:absolute; top:0; display:none;" />\';
}

$("#'.$slId.' a.ag_rotate_phoos").append(preload_'.$slId.'_ph);

$(window).load(function() {

setTimeout(function(){ $("#'.$slId.' a.ag_rotate_phoos img.ag_fade_short_img").remove(); }, 300);


var rInterval_'.$slId.' = 50;


function ag_rotate_'.$slId.'(imgs) {
var timeout_in = 50;
for(var ii = 0; ii < imgs.length; ii++) {
setTimeout((function (N){return function() { 
if (N == imgs.length-1) { 
$(imgs[N]).fadeIn(200).delay(350).fadeOut(200); 
} else { 
$(imgs[N]).fadeIn(200).delay(500).fadeOut(200); 
}
}})(ii),timeout_in); 
timeout_in += 550;
if (ii == imgs.length-1) {timeout_in = timeout_in - 200;}
}
rInterval_'.$slId.' = timeout_in + 450;
}


var count_hover_'.$slId.' = 0;

$("#'.$slId.' a.ag_rotate_phoos").hover(function(){

count_hover_'.$slId.' = count_hover_'.$slId.' + 1;


var ag_rp_height = $(this).parent().outerHeight(true);
$("#'.$slId.' a.ag_rotate_phoos").append(preload_'.$slId.'_ph);

setTimeout(function(){ 

$(function() {
$("a.ag_rotate_phoos img.ag_fade_short_img").each(function(e) {

if ($(this).outerHeight(true) > ag_rp_height) {
var ag_rotate_top = ($(this).outerHeight(true) - ag_rp_height) / 2; 

if (ag_rotate_top < 16) {ag_rotate_top = 0;}
$(this).css({top: "-" + ag_rotate_top + "px"});
}

});
});

}, 100);


var imgs = $("#'.$slId.' a.ag_rotate_phoos img.ag_fade_short_img");
rInterval_'.$slId.' = 70;

setTimeout(function run() {
ag_rotate_'.$slId.'(imgs);

setTimeout(run, rInterval_'.$slId.' + 250);
}, rInterval_'.$slId.');



},
function(){
$("#'.$slId.' a.ag_rotate_phoos img.ag_fade_short_img").remove();
});

});
</script>
';}
}
if (!empty($ag_alias_cat) && $ag_obj_alias == $ag_alias_obj) { if ($photo_only_short == '1') {$obj_photo = '';} }
}

// photo




//list wgt obj
if (isset($val['title'])) {$ag_list_title = $val['title'];}
$ag_alist_title = $ag_list_autor.$ag_list_date.$ag_list_time;
if (empty($ag_alist_title)) {$ag_alist_title = $ag_list_title;}

$ag_list = '<li>';

$ag_list .= '<div>';
if (!empty($ag_list_photo)) {$ag_list .= '<a href="' .$obj_link. '" title="'.$ag_alist_title.'" class="ag_wgt_list_obj_photo">'.$ag_list_photo.'</a>';}
$ag_list .= '<h5><a href="' .$obj_link. '" title="'.$ag_alist_title.'" class="ag_wgt_list_obj_title">' .$ag_list_title. '</a></h5>';
if (!empty($ag_list_text)) {$ag_list .= '<div class="ag_wgt_list_obj_text"><p>'.$ag_list_text.'</p></div>';}
$ag_list .= '</div>';
$ag_list .= '<div class="ag_clear"></div>';
$ag_list .= '</li>';






$obj_end = '<div class="ag_clear"></div></div>';
$obj_end .= '<div class="ag_clear"></div></div>';

$obj_end .= '<div class="ag_clear"></div>' .$obj_info. '</div>'; // block
$obj_end .= '</article>';

$rss_br = "\n";
$obj_rss .= '<item>';	
$obj_rss .= $ag_rss_title;	
$obj_rss .= $ag_rss_link;
$obj_rss .= '<description><![CDATA[' .$ag_rss_photo.$ag_rss_content. ']]></description>';
$obj_rss .= $ag_rss_autor;
$obj_rss .= $ag_rss_date;
$obj_rss .= $ag_rss_cat;
$obj_rss .= $ag_rss_guid;
$obj_rss .= '</item>';	


if ($obj_mode == 'short') {} else {
	
//functions obj
if (isset($val['functions'])) { 
$ag_functions = explode($ag_separator[2], $val['functions']);
$ag_function = array();

foreach ($ag_functions as $ag_function_id) {
if (file_exists($ag_data_dir.'/function'.$agt) && filesize($ag_data_dir.'/function'.$agt) != 0) {
$ag_function = ag_read_data($ag_data_dir.'/function'.$agt); 

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {	
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 

if (file_exists($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php')) {
    ob_start();
	include($ag_data_dir.'/'.$ag_config);
	include($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php');
	$ag_out_code_top = ob_get_contents();
	ob_end_clean();
    $obj_func_top .= $ag_out_code_top; //out code top	
  }// file_exists top
  
  if (file_exists($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php')) { 
    ob_start();
	
	include($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php');
	$ag_out_code_bottom = ob_get_contents();
	ob_end_clean();
    $obj_func_bottom .= $ag_out_code_bottom; //out code bottom	
  }// file_exists bottom

}// func status
}// func id
}// foreach ag_function
}// file_exists & !=0

}// foreach ag_functions
}// isset functions 

}// short or home mode



if ($mode == 'list') {
$ag_obj_list .= ag_return_html($ag_list);
} else if ($mode == 'rss') {
$ag_obj_list .= $obj_rss;
} else if ($mode == 'punkt') {
$ag_obj_list .= $punkt_obj;
} else {
$ag_obj_list .= $obj_func_top;
$ag_obj_list .= ag_return_html($obj_top);
if ($ag_photos_after != 1) { $ag_obj_list .= ag_return_html($obj_photo); } else { if ($mode == 'short') {$ag_obj_list .= ag_return_html($obj_photo);}}
$ag_obj_list .= ag_return_html($obj_content);
if ($ag_photos_after == 1 && $mode != 'short') {$ag_obj_list .= ag_return_html($obj_photo); }
if ($mode != 'short') { if (!isset($_GET[$ag_get_search])) {$ag_obj_list .= ag_return_html($obj_inc);} }
$ag_obj_list .= ag_return_html($obj_end);
$ag_obj_list .= $obj_func_bottom;
}
$ag_obj_list .= $ag_separator[1].$ag_obj_id.$ag_separator[2].$ag_obj_alias;
$ag_obj_list .= $ag_separator[0];	


}// obj in cat foreach ag_data


} else { 
if ($mode != 'punkt' && $mode != 'rss' && $mode != 'list') { 
//return $ag_404_content; 
$ag_empty_cat_c = '';
return $ag_empty_cat_c;
} 
}


}// foreach cat_id_arr
}// !empty cat id/alias






$ag_obj_list_arr = explode($ag_separator[0], $ag_obj_list);
array_pop($ag_obj_list_arr);

$count_view_obj = 0;

$id_obj = '';
$al_obj = '';
$custom_obj = '';

foreach ($ag_obj_list_arr as $nc => $ag_obj_list) { 

$ag_obj_list_arr = explode($ag_separator[1], $ag_obj_list);
if (isset($ag_obj_list_arr[1])) {$obj_id_alias = $ag_obj_list_arr[1];}
if (isset($ag_obj_list_arr[0])) {$custom_obj = $ag_obj_list_arr[0];}

$obj_id_alias_arr = explode($ag_separator[2], $obj_id_alias);
if (isset($obj_id_alias_arr[0])) {$id_obj = $obj_id_alias_arr[0];}
if (isset($obj_id_alias_arr[1])) {$al_obj = $obj_id_alias_arr[1];}

$sort_obj[$nc] = array (
'id' => $id_obj,
'al' => $al_obj,
'ct' => $custom_obj
);


}// foreach ag_obj_list_arr





// custom sort
if (!empty($objects_arr)) {
// custom sort


$list_obj_arr = array();	
$list_obj = '';

foreach ($objects_arr as $ns => $set_obj) { 
$set_obj = str_replace(' ', '', $set_obj);
foreach ($sort_obj as $nso => $cobj) {
if ($set_obj == $cobj['id'] || $set_obj == $cobj['al']) { 
$list_obj_arr[$cobj['id'].'_'.$cobj['al']] = $cobj['ct']; 
}// alias or id
}
}// foreach objects_arr



//page navigation
if (empty($count_obj) || $count_obj < 1) { $count_obj = sizeof($list_obj_arr); }
$total_obj = sizeof($list_obj_arr);
$lo = ($count_obj * $ag_page);
if ($count_obj != $total_obj) {
$total_page = ceil($total_obj/$count_obj);
if ($ag_page > 1) { $co = ($count_obj * $ag_page) - $count_obj; }
}// count obj in page custom 




$no = 0;
foreach ($list_obj_arr as $k => $lobj) {
$no++;
if ($no > $co) { $list_obj .= $lobj; $count_view_obj++; }
if ($no == $lo) {break;}
}



} else { // !empty objects_arr
	
$list_obj_arr = array();	
$list_obj = '';

//page navigation
$co = 0;
$total_page = 1;
//page navigation
if (empty($count_obj) || $count_obj < 1) { $count_obj = sizeof($sort_obj); } //total obj count
$total_obj = sizeof($sort_obj);
$lo = ($count_obj * $ag_page);
if ($count_obj != $total_obj) {
$total_page = ceil($total_obj/$count_obj);
if ($ag_page > 1) { $co = ($count_obj * $ag_page) - $count_obj; }
}// count obj in page normal
	
$no = 0;	
foreach ($sort_obj as $cobj) {
$no++;
if ($no > $co) { $list_obj .= $cobj['ct']; $count_view_obj++; }
if ($no == $lo) {break;}
}	
	
	
}// empty objects_arr
if ($mode != 'rss' && $mode != 'list') {
$list_obj = $list_obj.'<div class="ag_clear"></div>';
}






//page nav
$ag_page_nav = '<ul>';
for ($p = 0; $p < $total_page; $p++) {
$pp = $p + 1;
if ($pp == $ag_page) { 
$ag_page_nav .= '<li><span>' .$pp. '</span></li>';

} else {
	
if (isset($_GET[$ag_get_cat])) {
$ag_page_nav .= '<li><a href="?' .$ag_get_cat. '='.$ag_alias_cat.'&amp;'.$ag_get_page.'=' .$pp. '">' .$pp. '</a></li>';	
} else if (isset($_GET[$ag_get_search])) {
$ag_page_nav .= '<li><a href="?' .$ag_get_search. '='.$_GET[$ag_get_search].'&amp;'.$ag_get_page.'=' .$pp. '">' .$pp. '</a></li>';		
} else {
$ag_page_nav .= '<li><a href="?'.$ag_get_page.'=' .$pp. '">' .$pp. '</a></li>';
}

}// this page
}// for total pages
$ag_page_nav .= '</ul>';

$ag_page_nav = '<div class="ag_pages_nav"><div>'.$ag_page_nav.'<div class="ag_clear"></div></div></div>';


if ($count_obj == $total_obj || $total_page < 2) {$ag_page_nav = '';}


if (isset($_GET[$ag_get_obj]) && $ag_found_obj == 0 && $mode != 'punkt' && $mode != 'rss' && $mode != 'list') { $list_obj = $ag_404_content;}

if ($ag_count_cat == 0 && empty($ag_cfg_home_content) && empty($ag_cfg_home_content_js) && $mode != 'punkt' && $mode != 'rss' && $mode != 'list') { $list_obj = $ag_none_content; }

if ($mode == 'rss' || $mode == 'list') { $ag_page_nav = ''; }

return $list_obj.$ag_page_nav;
}// ag_list_obj






//---------------------------------------------- LIST LAST OBJECTS
function ag_last_obj($count='0', $common_count='0', $mode='') {
	
global $ag_cat;	
global $agt;
global $ag_data_dir;


$count_obj = 0;

$view_obj_str = '';
$view_cat_str = '';

$all_obj = array();
$ag_data = array();
$cat_id = '';

foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { 
if (isset($cat['id'])) {$cat_id = $cat['id']; $view_cat_str .= $cat_id.',';}

if (file_exists($ag_data_dir.'/object/'.$cat_id.$agt)) { // id

$ag_data = ag_read_data($ag_data_dir.'/object/'.$cat_id.$agt); 
$ag_data = array_reverse($ag_data, true); //inverse data lines

foreach ($ag_data as $obj) { 
	
if (isset($obj['status']) && $obj['status'] == 1) { 
	
if (isset($obj['id']) && isset($obj['added'])) { 

$added_arr = explode('::', $obj['added']);
$obj_add_day = '';
$obj_add_month = '';
$obj_add_year = '';
$obj_add_time = '';
$obj_add_staff = '';
if (isset($added_arr[0])) { $obj_add_day = $added_arr[0]; }
if (isset($added_arr[1])) { $obj_add_month = $added_arr[1]; }
if (isset($added_arr[2])) { $obj_add_year = $added_arr[2]; }
if (isset($added_arr[3])) { $obj_add_time = $added_arr[3]; }
if (isset($added_arr[4])) { $obj_add_staff = $added_arr[4]; }

$format = 'Y-m-d H:i:s';
$all_obj[$obj['id']] = array(
'id' => $obj['id'],
'added' => date($format, strtotime($obj_add_year.'-'.$obj_add_month.'-'.$obj_add_day.' '.$obj_add_time))
);

}// id & added

}// obj status

}// foreach ag_data

}// file exists obj cat

}// status cat
}// foreach ag_cat

//sorting by date
   
usort($all_obj, 'ag_sorta');
$all_obj = array_reverse($all_obj, true);
//sorting by date      


foreach ($all_obj as $obj_date_sort) { $count_obj++;
$view_obj_str .= $obj_date_sort['id'].',';	
if ($common_count > 0) {
if ($count_obj == $common_count) { break; }
}
}




return ag_list_obj('', $count, $view_obj_str, $mode);	

}// ag_last_obj
$ag_count_lo = 10;
if (isset($ag_cfg_wgt_count_last_obj) && !empty($ag_cfg_wgt_count_last_obj) && $ag_cfg_wgt_count_last_obj != 0) {$ag_count_lo = $ag_cfg_wgt_count_last_obj;}
$ag_last_obj = '<ul class="ag_wgt_list_obj">' .ag_last_obj('', $ag_count_lo, 'list'). '</ul>';





function ag_slider($slider_cat='') {
	
$ag_slider = '';

	
global $ag_lng;	
global $ag_cat;	
global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_get_rss;
global $ag_alias_cat;
global $ag_alias_obj;
global $ag_get_page;
global $ag_get_search;
global $ag_get_sitemap;
global $ag_page;	
global $ag_photos_dir;
global $ag_upload_name;
global $ag_is_mob;	
global $ag_error_get;

global $ag_cfg_home;
global $ag_cfg_home_slides;
global $ag_apanel_link;

$cat_home_alias = '';
//home
foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { 
if (isset($cat['id'])) {$cat_home_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_home_alias = $cat['alias'];}
break;
}// status
}// foreach ag_cat	
// home

$cat_sliders = array();	

if (empty($slider_cat) && $ag_cfg_home == 'first_category') { 
$slider_cat = $cat_home_alias; 
}


if (empty($slider_cat) && $ag_cfg_home != 'first_category') {
$cat_sliders = explode($ag_separator[2], $ag_cfg_home_slides);
$slider_cat = '';
}

	
if (isset($_GET[$ag_get_page]) && $_GET[$ag_get_page] > 1 || isset($_GET[$ag_get_obj]) || isset($_GET[$ag_get_search]) || isset($_GET[$ag_get_sitemap])) {
$slider_cat = '';
$cat_sliders = array();	
}
	
$cat_sliders_id = '';	

	
$cat_id = '';
$cat_alias = '';
$ag_slider_menu = '';
$ag_slides = '';	



if (!empty($slider_cat)) {
	
foreach ($ag_cat as $nc => $cat) {

if (isset($cat['id'])) {$cat_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_alias = $cat['alias'];}

if (isset($cat['status']) && $cat['status'] == 1 && $cat_alias == $slider_cat) { 

if (isset($cat['sliders'])) {$cat_sliders_id = $cat['sliders'];}
$cat_sliders = explode($ag_separator[2], $cat_sliders_id);

break;
}// status cat
}// foreach ag_cat
}// !empty slider_cat





$slides_data = array();
if (file_exists($ag_data_dir.'/slider'.$agt)) {
$slides_data = ag_read_data($ag_data_dir.'/slider'.$agt); 
}	



$count_slides = 0;


$ag_slider_menu = '';
$ag_slides = '';


if (!empty($cat_sliders )) {

foreach ($cat_sliders as $slides) {	
	
foreach ($slides_data as $slide) {

$slide_id = '';
$slide_title = '';
$slide_text = '';
$slide_icon = '';
$slide_links = '';
$slide_photo = '';
$slide_video = '';
$slide_image = '';
$slide_background = '';
$slide_text_background = '';
$slide_text_opacity = '1';
$slide_photo_opacity = '1';
$slide_image_opacity = '1';
$slide_video_opacity = '1';
$slide_text_color = '';
$slide_text_left = '0';
$slide_links_display = '';	

$slide_title_color = '';
$slide_link_color = '';
$slide_link_border_color = '';
$slide_link_back_color = '';


if (isset($slide['id']) && $slide['id'] == $slides) { 

if (isset($slide['status']) && $slide['status'] == '1') { $count_slides++;

if (isset($slide['title'])) { $slide_title = $slide['title']; }
if (isset($slide['text'])) { $slide_text = $slide['text']; }
if (isset($slide['icon'])) { $slide_icon = $slide['icon']; }
if (isset($slide['links'])) { $slide_links = $slide['links']; }
if (isset($slide['photo'])) { $slide_photo = $slide['photo']; }
if (isset($slide['slider_video'])) { $slide_video = $slide['slider_video']; }
if (isset($slide['hover_image'])) { $slide_image = $slide['hover_image']; }
if (isset($slide['back_color'])) { $slide_background = $slide['back_color']; }
if (isset($slide['text_back_color'])) { $slide_text_background = $slide['text_back_color']; }
if (isset($slide['text_back_opacity'])) { $slide_text_opacity = (int)$slide['text_back_opacity'] / 100; }
if (isset($slide['photo_opacity'])) { if ((int)$slide['photo_opacity'] != 0) {$slide_photo_opacity = (int)$slide['photo_opacity'] / 100;} }
if (isset($slide['hover_image_opacity'])) { if ((int)$slide['hover_image_opacity'] != 0) {$slide_image_opacity = (int)$slide['hover_image_opacity'] / 100;} }
if (isset($slide['video_opacity'])) { if ((int)$slide['video_opacity'] != 0) {$slide_video_opacity = (int)$slide['video_opacity'] / 100;} }
if (isset($slide['text_color'])) { $slide_text_color = $slide['text_color']; }
if (isset($slide['text_left'])) { $slide_text_left = $slide['text_left']; }

if (isset($slide['title_color'])) { $slide_title_color = $slide['title_color']; }
if (isset($slide['link_color'])) { $slide_link_color = $slide['link_color']; }
if (isset($slide['link_border_color'])) { $slide_link_border_color = $slide['link_border_color']; }
if (isset($slide['link_back_color'])) { $slide_link_back_color = $slide['link_back_color']; }


$slide_text = str_replace(' ', '&nbsp;&shy;', $slide_text);

$obj_edit = '';
$cat_staffs = array();
if (isset($slide['staffs'])) { $cat_staffs = explode($ag_separator[2], $slide['staffs']); }
$this_staff = ag_auth();
if (!empty($this_staff) && isset($this_staff['id'])) {
if (in_array($this_staff['id'], $cat_staffs)) {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=slider&amp;id='.$slide['id'].'#item_'.$slide['id'].'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
if ($this_staff['access'] == 'founder' || $this_staff['access'] == '1') {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=slider&amp;id='.$slide['id'].'#item_'.$slide['id'].'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
}

$obj_edit_link = '';
if (!empty($obj_edit)) { $obj_edit_link = '<div class="ag_edit">'.$obj_edit.'</div>'; }





$link_style = '';
if (!empty($slide_link_color)) {$link_style .= 'color:'.$slide_link_color.';';}
if (!empty($slide_link_border_color)) {$link_style .= 'border:'.$slide_link_border_color.' 1px solid;';}
if (!empty($slide_link_back_color)) {$link_style .= 'background:'.$slide_link_back_color.';';}
if (!empty($link_style)) {$link_style = ' style="'.$link_style.'"';}


if (!empty($slide_links)) {
$slide_links_a = explode($ag_separator[2], $slide_links);
foreach ($slide_links_a as $links) {
	
	
$link = explode('::', $links);
	if (isset($link[0])) {$link_address = $link[0];}
	if (isset($link[1])) {$link_text = $link[1];}

if (empty($link_text)) {
$link_text = $link_address;
$link_text = str_replace(array('http://','https://'), '', $link_text);
}
if (!empty($link_address)) { 
$l_target = '';
if (strpos($link_address, 'http') === false) {} else {$l_target = ' target="_blank"';}	

$slide_links_display .= '<a href="'.$link_address.'"'.$l_target.$link_style.'>'.$link_text.'</a>';
}	
	
}
}// links

if (!empty($slide_photo) && file_exists($ag_photos_dir.$slide_photo)) {
$slide_photo = '<img src="' .$ag_photos_dir.$slide_photo. '" alt="' .$slide_title. '" />';	
} else { $slide_photo = ''; }

if (!empty($slide_video) && file_exists($ag_data_dir.'/'.$ag_upload_name.$slide_video) && $ag_is_mob == 0) {
$ag_v_format_a = explode('.', $slide_video);
$ag_v_format = array_pop($ag_v_format_a);
$slide_video = '<video autoplay="autoplay" loop="loop"><source src="'.$ag_data_dir.'/'.$ag_upload_name.$slide_video.'" type="video/'.$ag_v_format.'"></video>';
} else { $slide_video = ''; }


$class_slide_image = '';
if ($slide_text_left == '0') {$class_slide_image = ' class="ag_slide_pict_left"';}

if (!empty($slide_image) && file_exists($ag_photos_dir.$slide_image)) {
$slide_image = '<img src="' .$ag_photos_dir.$slide_image. '" alt="' .$slide_title. '"'.$class_slide_image.' />';	
} else { $slide_image = ''; }

if (!empty($slide_background)) {$slide_background = ' style="background:'.$slide_background.';"';}
if (!empty($slide_text_background)) {$slide_text_background = 'background:'.$slide_text_background.';';}
if (!empty($slide_text_color)) {$slide_text_color = ' style="color:'.$slide_text_color.';"';}

$title_style = '';
if (!empty($slide_text_color)) { $title_style = $slide_text_color; }
if (!empty($slide_title_color)) { $title_style = ' style="color:'.$slide_title_color.';"'; } 

if (empty($slide_icon)) {$slide_icon = 'icon-record-2';}




$ag_slides .= '<li'.$slide_background .'>';

$ag_slides .= '<div class="ag_slide" id="ag_slide_'.$count_slides.'">';

if (!empty($slide_photo)) {
$ag_slides .= '<div class="ag_slide_image" style="opacity:'.$slide_photo_opacity.';">'.$slide_photo.'</div>';
}

if (!empty($slide_video)) {
$ag_slides .= '<div class="ag_slide_video" style="opacity:'.$slide_video_opacity.';">'.$slide_video.'</div>';
}

$ag_slides .= '<div class="ag_slide_inner">';

if ($slide_text_left == '0') {
if (!empty($slide_image)) {
$ag_slides .= '<div class="ag_slide_picture" style="opacity:'.$slide_image_opacity.';">'.$slide_image.'</div>';
} else {$ag_slides .= '<div class="ag_slide_picture">&#160;</div>';}
}

$ag_slides .= '<div class="ag_slide_content">';
$ag_slides .= '<div class="ag_slide_content_back" style="'.$slide_text_background.' opacity:'.$slide_text_opacity.';"></div>';
$ag_slides .= '<div class="ag_slide_content_inner"'.$slide_text_color.'>';

$ag_slides .= '<h3 class="ag_slide_title"'.$title_style.'>'.$slide_title.'</h3>';

$slide_text = str_replace($ag_separator[3], "<br />", $slide_text);
$slide_text = html_entity_decode($slide_text, ENT_QUOTES, 'UTF-8');
$slide_text = ag_close_tags($slide_text);
if (!empty($slide_text)) {
$ag_slides .= '<div class="ag_slide_text">'.$slide_text.$obj_edit_link.'<div class="ag_clear"></div></div>';
} else {
if (!empty($obj_edit)) { $ag_slides .= '<div class="ag_slide_text">'.$obj_edit_link.'<div class="ag_clear"></div></div>'; }
}


$ag_slides .= '<div class="ag_slide_buttons">'.$slide_links_display.'<div class="ag_clear"></div></div>';


$ag_slides .= '<div class="ag_clear"></div>';
$ag_slides .= '</div>';
$ag_slides .= '</div><!-- /ag_slide_content -->';

if ($slide_text_left == '1') {
if (!empty($slide_image)) {
$ag_slides .= '<div class="ag_slide_picture" style="opacity:'.$slide_image_opacity.';">'.$slide_image.'</div>';
} else {$ag_slides .= '<div class="ag_slide_picture">&#160;</div>';}
}

$ag_slides .= '<div class="ag_clear"></div>';
$ag_slides .= '</div><!-- /ag_slide_inner -->';
$ag_slides .= '</div><!-- /ag_slide -->';

$ag_slides .= '</li>';

$li_menu_class = '';
if ($count_slides == 0) {$li_menu_class = ' ag_current_slide'; }

$ag_slider_menu .= '<li class="ag_sl_menu_item"><div tabindex="-1" title="' .$slide_title. '"><i class="'.$slide_icon.'"></i></div></li>';

}// status slide
}// id slide


}// foreach slides_data	
}// foreach cat_sliders
}// !empty cat_sliders





if (!empty($cat_sliders) && $count_slides > 0) {

$ag_slider = '<div id="ag_slider_block" class="ag_slider_block">';
$ag_slider .= '<div class="ag_slider_loading"><i class="icon-spin1 animate-spin"></i></div>';
$ag_slider .= '<ul class="ag_slider_list">';

$ag_slider .= $ag_slides;

$ag_slider .= '</ul>';
$ag_slider .= '<div class="ag_clear"></div>';

$ag_slider .= '<div class="ag_slider_arrows">';
$ag_slider .= '<span class="ag_slider_prev" tabindex="-1"><i class="icon-left-open-big"></i></span>';
$ag_slider .= '<span class="ag_slider_next" tabindex="-1"><i class="icon-right-open-big"></i></span>';
$ag_slider .= '</div>';

$ag_slider .= '<div id="ag_slider_menu" class="ag_slider_menu">';
$ag_slider .= '<div class="ag_slider_menu_inner">';
$ag_slider .= '<ul>'.$ag_slider_menu.'</ul>';
$ag_slider .= '</div>';	
$ag_slider .= '<div class="ag_clear"></div>';
$ag_slider .= '<div class="ag_slider_time_block"><div class="ag_slider_time">&#160;</div></div>';
$ag_slider .= '</div><!-- /ag_slider_menu -->';

$ag_slider .= '<div class="ag_slider_pause"><i class="icon-spin1 animate-spin"></i></div>';
$ag_slider .= '</div><!-- /ag_slider -->';
$ag_slider .= '<script>$(window).load(function(){ $(".ag_slider_loading").fadeOut(450); setTimeout(function(){ $(".ag_slider_loading").remove(); },500);  });</script>';
}// !empty cat_sliders


if ($ag_error_get == 1) {$ag_slider = '';}

global $ag_get_confirm;
global $ag_get_pay;
if (isset($_GET[$ag_get_confirm])) {$ag_slider = '';}
if (isset($_GET[$ag_get_pay])) {$ag_slider = '';}

return $ag_slider;
}// ag_slider








//---------------------------------------------- LIST CATEGORY


function ag_list_cat($cats='', $count='0', $mode='') {

$cat_list = '';

$cats_arr = array();
if (!empty($cats)) {
$cats_arr = explode(',', $cats);
$cats_arr = array_diff($cats_arr, array(''));
$cats_arr = array_unique($cats_arr);	
}

global $ag_lng;	
global $ag_cat;	
global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_get_rss;
global $ag_alias_cat;
global $ag_alias_obj;
global $ag_get_page;
global $ag_page;	
global $ag_photos_dir;
global $ag_mob_images;
global $ag_is_mob;

global $ag_404_content;
global $ag_none_content;
global $ag_config;
global $ag_error_get;

global $ag_apanel_link;

if (empty($cats_arr)) {
foreach ($ag_cat as $lnc => $lcats){
if (isset($lcats['id'])) { $cats_arr[$lnc] = $lcats['id']; }	
}
}


$cat_top = '';
$cat_title = '';
$cat_description = '';
$cat_content = '';
$cat_photos = '';
$cat_objects = '';
$cat_end = '';
$ag_cat_list = '';
$cat_home_alias = '';
$cat_home_id = '';
$ag_found_cat = 0;
$ag_count_cat = 0; 
$count_obj_row = 2;
$count_photos = 0;



//home
foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { 
if (isset($cat['id'])) {$cat_home_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_home_alias = $cat['alias'];}
break;
}// status
}// foreach ag_cat	
// home


if (empty($ag_alias_cat)) {$cats_arr = array($cat_home_alias);}


foreach ($ag_cat as $nc => $cat) {
$cat_id = '';
$cat_alias = '';

if (isset($cat['id'])) {$cat_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_alias = $cat['alias'];}


if (isset($cat['status']) && $cat['status'] == 1) { $ag_count_cat++;


if (isset($_GET[$ag_get_cat]) && $cat_alias == $_GET[$ag_get_cat]) { $ag_found_cat = 1; }








//cat photos
$cat_photo = '';
$cat_photos = '';
$ag_list_photo = '';
$ag_photos_after = '';
$cat_first_photo = '';
$cat_one_photo = '';
$cat_short_photos = '';
$count_photos = 0;
$photos = array();

if (isset($cat['title'])) {$img_alt = $cat['title'];}


$ag_mob_photos = $ag_mob_images;

if (isset($cat['photos_after']) && $cat['photos_after'] == 1) {$ag_photos_after = 1;}

if (isset($cat['photos']) && !empty($cat['photos'])) {	
$photos = explode($ag_separator[2], $cat['photos']);


$count_photos = 0;
foreach ($photos as $np => $photo) {

if (!empty($photo) && file_exists($ag_photos_dir.$photo)) { $count_photos++;


if ($count_photos == 1) {

$cat_first_photo = '<div class="ag_one_photo_open ag_top_photo">';
$cat_first_photo .= '<div class="ag_first_photo_open">';
$cat_first_photo .= '<img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_first_img" />';
$cat_first_photo .= '</div>';
$cat_first_photo .= '</div>';
$cat_first_photo .= '<div class="ag_clear"></div>';

$cat_one_photo = '<div class="ag_content_width_cat"></div><div class="ag_one_photo_open">';
$cat_one_photo .= '<div class="ag_first_photo_open">';
$cat_one_photo .= '<img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_first_img" />';
$cat_one_photo .= '</div>';
$cat_one_photo .= '</div>';
$cat_one_photo .= '<div class="ag_clear"></div>';

}



$cat_photos .= '<div class="ag_obj_photo"><a href="'.$ag_photos_dir.$photo.'" class="ag_popup_photos"><img src="'.$ag_photos_dir.$photo.'" alt="'.$img_alt.'" class="ag_img_'.$count_photos.'" /></a><span class="ag_zoom_in"><i class="icon-zoom-in"></i></span></div>';	

}// file_exists photo


}// foreach photos
}// isset photos

if ($count_photos > 1) {

$cat_photo = '<div class="ag_content_width_cat"></div>'.$cat_first_photo.'<div class="ag_photos ag_cat_photos">
<div class="ag_photos_inner">'.$cat_photos.'<div class="ag_clear"></div></div>
<div class="ag_photos_next" tabindex="-1" onclick="ag_cat_next_photos(this)"><i class="icon-right-open-big"></i></div>
<div class="ag_photos_prev" tabindex="-1" onclick="ag_cat_prev_photos(this)"><i class="icon-left-open-big"></i></div>
</div>';

} else {
$cat_photo = $cat_one_photo;
}
//cat photos










//obj include

$ag_obj_inc_class = '';
$obj_inc = '';
if (isset($cat['service']) && !empty($cat['service'])) {

if (function_exists('ag_obj_incude')) {	
$obj_inc_data = ag_obj_incude($cat['service']);
}

if (!empty($obj_inc_data)) {
$obj_inc = '<div class="ag_obj_include"><div class="ag_obj_include_inner">'.$obj_inc_data.'</div></div>'; 
$ag_obj_inc_class = ' ag_obj_inc'; 
}
}// service



$count = (int)$count;
if (isset($cat['count']) && empty($count)) {
if ((int)$cat['count'] > 0) { $count = (int)$cat['count']; }
}


if (isset($cat['count_obj_row'])) { $count_obj_row = (int)$cat['count_obj_row']; }	

$blocks_obj_class = '';
if (isset($cat['blocks_obj']) && $cat['blocks_obj'] == 1) { 
$blocks_obj_class = ' ag_blocks_cat'; 
if ($count_obj_row > 1) {$blocks_obj_class .= ' ag_row_blocks_'.$count_obj_row;}
}
	
$cat_top = '<div class="ag_cat'.$blocks_obj_class.'" id="' .$cat_id. '">';

// title
$cat_title = '';
$img_alt = '';

$obj_edit = '';
$cat_staffs = array();
if (isset($cat['staffs'])) { $cat_staffs = explode($ag_separator[2], $cat['staffs']); }
$this_staff = ag_auth();
if (!empty($this_staff) && isset($this_staff['id'])) {
if (in_array($this_staff['id'], $cat_staffs)) {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=category&amp;id='.$cat_id.'#item_'.$cat_id.'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
if ($this_staff['access'] == 'founder' || $this_staff['access'] == '1') {$obj_edit = '<a href="'.$ag_apanel_link.'?tab=category&amp;id='.$cat_id.'#item_'.$cat_id.'"><i class="icon-edit-3"></i>'.$ag_lng['edit'].'</a>';}
}

$obj_edit_link = '';
if (!empty($obj_edit)) { $obj_edit_link = '<div class="ag_edit">'.$obj_edit.'</div>'; }




if (isset($cat['title']) && !empty($cat['title'])) { 
if (isset($_GET[$ag_get_cat]) && $cat_alias == $_GET[$ag_get_cat] || $cat_alias == $cat_home_alias) { 
$cat_title = '<h2 class="ag_title_cat">' .$cat['title']. '</h2>'; 
} else {
$cat_title = '<h2 class="ag_title_cat"><a href="?' .$ag_get_cat. '='. $cat_alias. '">' .$cat['title']. '</a></h2>'; 
}// cat link in list

// description
$cat_description = '';
if (isset($cat['description']) && !empty($cat['description'])) { $cat_description = '<h3 class="ag_description_cat">' .$cat['description']. '</h3>'; }

$img_alt = $cat['title'];

if (isset($cat['hidden_title']) && $cat['hidden_title'] == 1) {} else {
$cat_top .= '<div class="ag_cat_top">'.ag_return_html($cat_title).ag_return_html($cat_description).'</div>';
}
}

$ag_cat_content_inner_class = 'ag_cat_content_inner';
if (!empty($cat_photo)) {
	$ag_cat_content_inner_class = 'ag_cat_content_inner ag_cat_content_inner_photos';
	if ($ag_photos_after == 1) {$ag_cat_content_inner_class = 'ag_cat_content_inner ag_cat_content_inner_photos_after';}
	}

// content
$cat_content = '';
$cat_content_all = '';
if (isset($_GET[$ag_get_page]) && $_GET[$ag_get_page] > 1) {
$cat_content = '<div class="ag_cat_no_content"></div>';
} else {
if (isset($cat['content'])) {
$cat_content = html_entity_decode($cat['content'], ENT_QUOTES, 'UTF-8');
$cat_content = str_replace($ag_separator[3], "\n", $cat_content);
$cat_content = str_replace('[site_url]', '', $cat_content);

if (!empty($obj_inc)) {$obj_edit_link = $obj_edit_link.'<p class="ag_empty_p">&nbsp;</p>';}
if (empty($cat_content) && empty($cat_photo)) {$obj_edit_link = '';} 
if (!empty($obj_inc) && !empty($cat_content) || !empty($cat_photo) && !empty($cat_content)) {$ag_class_cat_block = ' ag_inc_margin';}
if (empty($cat_content)) {$ag_cat_content_inner_class .= ' ag_cat_content_inner_empty'; }
if (empty($cat_content) && empty($cat_photo)) { $cat_content = '<div class="ag_cat_no_content"></div>'; }

if ($cat_content != '<div class="ag_cat_no_content"></div>') {

if ($ag_photos_after == 1) {
	$cat_content_all = '<div class="'.$ag_cat_content_inner_class.'">'.$cat_content.'</div>'.$cat_photo.$obj_edit_link.$obj_inc;
	} else {
	$cat_content_all = $cat_photo.'<div class="'.$ag_cat_content_inner_class.'">'.$cat_content.'</div>'.$obj_edit_link.$obj_inc;	
	}
$ag_class_cat_block = '';

$cat_content = '<div class="ag_cat_content'.$ag_class_cat_block.'"><div class="ag_post_item">' .$cat_content_all. '<div class="ag_clear"></div></div></div>'; 

} else { 

if (!empty($obj_inc)) {$cat_content = '<div class="ag_cat_content"><div class="ag_post_item">' .$obj_inc. '<div class="ag_clear"></div></div></div>';}

}

}
}// first page



$cat_content = ag_return_html($cat_content);
$cat_content = ag_close_tags($cat_content);

//functions cat
$cat_func_top = '';
$cat_func_bottom = '';
$ag_function = array();

if (isset($cat['functions'])) { 
$ag_functions = explode($ag_separator[2], $cat['functions']);

foreach ($ag_functions as $ag_function_id) {
if (file_exists($ag_data_dir.'/function'.$agt) && filesize($ag_data_dir.'/function'.$agt) != 0) {
$ag_function = ag_read_data($ag_data_dir.'/function'.$agt); 

foreach ($ag_function as $ag_func) {
if (isset($ag_func['id']) && $ag_func['id'] == $ag_function_id) {	
if (isset($ag_func['status']) && $ag_func['status'] == 1) { 



if (file_exists($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php')) {
    ob_start();
	include($ag_data_dir.'/'.$ag_config);
	include($ag_data_dir.'/function/code_top_'.$ag_func['id'].'.php');
	$ag_out_code_top = ob_get_contents();
	ob_end_clean();
    $cat_func_top .= $ag_out_code_top; //out code top	
  }// file_exists top
  
  if (file_exists($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php')) { 
    ob_start();
	
	include($ag_data_dir.'/function/code_bottom_'.$ag_func['id'].'.php');
	$ag_out_code_bottom = ob_get_contents();
	ob_end_clean();
    $cat_func_bottom .= $ag_out_code_bottom; //out code bottom	
  }// file_exists bottom

}// func status
}// func id
}// foreach ag_function
}// file_exists & !=0
}// foreach ag_functions
}// isset functions 



if ($mode != 'none') { $cat_objects = ag_list_obj($cat_id, $count, '', $mode); }



$cat_end = '<div class="ag_clear"></div></div>';

if ($mode == 'rss') {
$ag_cat_list .= $cat_objects;	
} else {
$ag_cat_list .= $cat_func_top;
$ag_cat_list .= $cat_top;
$ag_cat_list .= $cat_content;
$ag_cat_list .= $cat_objects;
$ag_cat_list .= $cat_end;
$ag_cat_list .= $cat_func_bottom;
}
$ag_cat_list .= $ag_separator[1].$cat_id.$ag_separator[2].$cat_alias;
$ag_cat_list .= $ag_separator[0];	


	
}// cat status

}// foreach ag_cat	


$ag_cat_list_arr = explode($ag_separator[0], $ag_cat_list);
array_pop($ag_cat_list_arr);

$count_cat = 0;

if (!empty($cats_arr)) {
$id_cat = '';
$al_cat = '';
$custom_cat = '';



$sort_cat = array();

foreach ($ag_cat_list_arr as $nc => $ag_cat_list) { 

$ag_cat_list_arr = explode($ag_separator[1], $ag_cat_list);
if (isset($ag_cat_list_arr[1])) {$cat_id_alias = $ag_cat_list_arr[1];}
if (isset($ag_cat_list_arr[0])) {$custom_cat = $ag_cat_list_arr[0];}

$cat_id_alias_arr = explode($ag_separator[2], $cat_id_alias);
if (isset($cat_id_alias_arr[0])) {$id_cat = $cat_id_alias_arr[0];}
if (isset($cat_id_alias_arr[1])) {$al_cat = $cat_id_alias_arr[1];}



$sort_cat[$nc] = array (
'id' => $id_cat,
'al' => $al_cat,
'ct' => $custom_cat
);


}// foreach ag_cat_list_arr


foreach ($cats_arr as $set_cat) { 
$set_cat = str_replace(' ', '', $set_cat);
foreach ($sort_cat as $ccat) {
if ($set_cat == $ccat['id'] || $set_cat == $ccat['al']) {$cat_list .= $ccat['ct']; $count_cat++;}
}
}// foreach cats_arr


} else {

foreach ($ag_cat_list_arr as $ag_cat_list) { 
$ag_cat_list_arr = explode($ag_separator[1], $ag_cat_list);
if (isset($ag_cat_list_arr[0])) { $cat_list .= $ag_cat_list_arr[0]; $count_cat++; }
}

}

if (isset($_GET[$ag_get_cat]) && $ag_found_cat == 0) {$cat_list = $ag_404_content;}
if ($ag_count_cat == 0) {$list_obj = $ag_none_content;}

if ($ag_error_get == 1) {$cat_list = '';}

return $cat_list;	
}// ag_view_cat





//site map
function ag_site_map($mode='') {
	
global $ag_lng;	
global $ag_cat;	
global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_alias_cat;
global $ag_get_search;
global $ag_get_sitemap;
global $ag_alias_obj;
global $ag_get_page;
global $ag_page;		

global $ag_cfg_home;
global $ag_cfg_home_icon;
global $ag_cfg_home_text;
global $srv_absolute_url;

global $ag_cfg_wgt_exclude_list_cat;
	
$ag_site_map = '';

$exclude_list_cat = array();
if (!empty($ag_cfg_wgt_exclude_list_cat)) {
$exclude_list_cat = explode($ag_separator[2], $ag_cfg_wgt_exclude_list_cat);
}

//home
$cat_home_alias = '';
foreach ($ag_cat as $nc => $cat) {
if (isset($cat['status']) && $cat['status'] == 1) { 
if (isset($cat['id'])) {$cat_home_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_home_alias = $cat['alias'];}
break;
}// status
}// foreach ag_cat	
// home

if (isset($_GET[$ag_get_search])) { $ag_list_alias_cat = $ag_get_search; }// search
if (isset($_GET[$ag_get_sitemap])) { $ag_list_alias_cat = $ag_get_sitemap; }// sitemap


if ($ag_cfg_home == 'last_objects' && $mode == 'cat_list' || $ag_cfg_home == 'custom_content' && $mode == 'cat_list') {
$this_home_class = '';
if (empty($ag_alias_cat)) {$this_home_class = ' ag_this_list';}

if (isset($_GET[$ag_get_search])) { $this_home_class = ''; }// search
if (isset($_GET[$ag_get_sitemap])) { $this_home_class = ''; }// sitemap

$ag_list_home_text = $ag_cfg_home_text;
if (empty($ag_cfg_home_text)) { $ag_list_home_text = $ag_lng['home_group_cfg']; }
$ag_list_home_icon = '<i class="' .$ag_cfg_home_icon. '"></i>';
if (empty($ag_cfg_home_icon)) { $ag_list_home_icon = ''; }

$ag_site_map .= '<li class="ag_wgt_list_cat' .$this_home_class.'"><h5><a href="' .$srv_absolute_url. '">' .$ag_list_home_icon.$ag_list_home_text. '</a></h5></li>';

}

$ag_list_alias_cat = $ag_alias_cat;
if (empty($ag_list_alias_cat) && $ag_cfg_home == 'first_category') { $ag_list_alias_cat = $cat_home_alias; }


foreach ($ag_cat as $cat) {	

$cat_list_title = '';
$cat_list_icon = '';
$cat_list_alias = '';
$cat_list_id = '';

if (isset($cat['status']) && $cat['status'] == '1') {
if (isset($cat['id'])) {$cat_list_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_list_alias = $cat['alias'];}
if (isset($cat['title'])) {$cat_list_title = $cat['title'];}
if (isset($cat['icon'])) {$cat_list_icon = '<i class="'.$cat['icon'].'"></i>';}




$cat_link = '?' .$ag_get_cat. '='. $cat_list_alias. '';
if ($ag_list_alias_cat == $cat_list_alias && $ag_cfg_home == 'first_category') { $cat_link = $srv_absolute_url; }

if ($mode == 'cat_list') { 
if (!in_array($cat_list_id, $exclude_list_cat)) {
$this_class = '';
if ($ag_list_alias_cat == $cat_list_alias) {$this_class = ' ag_this_list';} 
$ag_site_map .= '<li class="ag_wgt_list' .$this_class.'"><h5><a href="' .$cat_link. '">' .$cat_list_icon.$cat_list_title. '</a></h5></li>'; 
}
}// mode cat_list

if ($mode == 'full_list') { 
$this_class = '';
if ($ag_list_alias_cat == $cat_list_alias) {$this_class = ' ag_this_list';} 
$ag_site_map .= '<li class="ag_wgt_list ag_cat_name' .$this_class.'"><h5><a href="' .$cat_link. '">' .$cat_list_icon.$cat_list_title. '</a></h5>';


//obj
$obj_list_id = '';
$obj_list_alias = '';
$obj_list_title = '';
$obj_list = '';
$ag_db_file = $ag_data_dir.'/object/'.$cat_list_id.$agt;
$obj_data = array();
$count_obj_list = 0;
if (file_exists($ag_db_file)) {
$obj_data = ag_read_data($ag_db_file);	
$count_obj_list = 0;
foreach ($obj_data as $obj) { $count_obj_list++;

if (isset($obj['status']) && $obj['status'] == '1') {
if (isset($obj['id'])) {$obj_list_id = $obj['id'];}
if (isset($obj['alias'])) {$obj_list_alias = $obj['alias'];}
if (isset($obj['title'])) {$obj_list_title = $obj['title'];}

$obj_link = '?' .$ag_get_cat. '='. $cat_list_alias. '&amp;'.$ag_get_obj.'='.$obj_list_alias;
$obj_list .= '<li><a href="' .$obj_link. '"><span>' .$obj_list_title. '</span></a></li>';

}// obj status
}// foreach obj_data
}// file_exists ag_db_file
//obj
if ($count_obj_list > 0) {$ag_site_map .= '<ul>'.$obj_list.'</ul>';}
$ag_site_map .= '</li>'; 
}// full list




if ($mode == 'xml') { 

$ag_timezone = date('O');
$ag_timezone = $ag_timezone[0].$ag_timezone[1].$ag_timezone[2].':'.$ag_timezone[3].$ag_timezone[4];

// cat date
$cat_info_arr = array();
$cat_changed_arr = array();
$cat_info_str = '';
if (isset($cat['added'])) { $cat_info_arr = explode('::', $cat['added']); }
if (isset($cat['changed'])) { $cat_changed_arr = explode('::', $cat['changed']); }

$cat_add_day = '';
$cat_add_month = '';
$cat_add_year = '';
$cat_add_time = '';
$cat_add_staff = '';
$cat_add_staff_mail = '';
$cat_link = '';
$cat_back_link = '';
$cat_back_link_text = '';

$cat_e_day = '01';
$cat_e_month = '01';
$cat_e_year = '2000';
$cat_e_time = '00:00:00';



if (isset($cat_changed_arr[0])) { $cat_e_day = $cat_changed_arr[0]; }
if (isset($cat_changed_arr[1])) { $cat_e_month = $cat_changed_arr[1]; }
if (isset($cat_changed_arr[2])) { $cat_e_year = $cat_changed_arr[2]; }
if (isset($cat_changed_arr[3])) { $cat_e_time = $cat_changed_arr[3]; }

//if (strpos($cat_e_month, '0') === false) {} else {$cat_e_month = $cat_e_month[1];}

$cat_lastmod = ''.$cat_e_year.'-'.$cat_e_month.'-'.$cat_e_day.'T'.$cat_e_time.''.$ag_timezone.'';

$cat_link = '?' .$ag_get_cat. '='. $cat_list_alias. '';

$ag_site_map .= '<url>
<loc>' .$srv_absolute_url.$cat_link. '</loc>
<lastmod>'.$cat_lastmod.'</lastmod>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>';	

//obj
$obj_list_id = '';
$obj_list_alias = '';
$obj_list_title = '';
$obj_list = '';
$ag_db_file = $ag_data_dir.'/object/'.$cat_list_id.$agt;
$obj_data = array();
if (file_exists($ag_db_file)) {
$obj_data = ag_read_data($ag_db_file);	
$count_obj_list = 0;
foreach ($obj_data as $obj) { $count_obj_list++;


// date
$obj_info_arr = array();
$obj_changed_arr = array();
$obj_info_str = '';
if (isset($obj['added'])) { $obj_info_arr = explode('::', $obj['added']); }
if (isset($obj['changed'])) { $obj_changed_arr = explode('::', $obj['changed']); }

$obj_add_day = '';
$obj_add_month = '';
$obj_add_year = '';
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



if (isset($obj['status']) && $obj['status'] == '1') {
if (isset($obj['id'])) {$obj_list_id = $obj['id'];}
if (isset($obj['alias'])) {$obj_list_alias = $obj['alias'];}
if (isset($obj['title'])) {$obj_list_title = $obj['title'];}

$obj_lastmod = ''.$obj_e_year.'-'.$obj_e_month.'-'.$obj_e_day.'T'.$obj_e_time.''.$ag_timezone.'';

$obj_link = $cat_link.'&amp;'.$ag_get_obj.'='.$obj_list_alias;

$ag_site_map .= '<url>
<loc>' .$srv_absolute_url.$obj_link. '</loc>
<lastmod>'.$obj_lastmod.'</lastmod>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>';	

}// obj status
}// foreach obj_data
}// file_exists ag_db_file
//obj

}// xml




}// cat status

}// foreach ag_cat

return $ag_site_map;

}// ag_site_map
$ag_cat_list = '<ul class="ag_wgt_list">'.ag_site_map('cat_list').'</ul>';
$ag_full_list = '<ul class="ag_wgt_full_list">'.ag_site_map('full_list').'</ul>';








//---------------------------------------------- MAIN MENU
function ag_menu($cat='') {
	
global $ag_lng;	
global $ag_cat;	
global $agt;
global $ag_separator;
global $ag_data_dir;

global $ag_get_cat;
global $ag_get_obj;
global $ag_get_search;
global $ag_get_sitemap;
global $ag_get_confirm;
global $ag_get_pay;
global $ag_alias_cat;
global $ag_alias_obj;	
global $ag_photos_dir;
global $ag_is_mob;	
global $srv_absolute_url;
global $ag_cfg_home;
global $ag_cfg_home_icon;
global $ag_cfg_home_text;
global $ag_error_get;
$ag_home_cat = '';
$ag_menu = array();



$ag_db_menu = $ag_data_dir.'/punkt'.$agt;
if (file_exists($ag_db_menu)) {
$ag_menu = ag_read_data($ag_db_menu); 
}


// custom_menu
$custom_menu = '';
$custom_menu_punkts = '';
foreach ($ag_menu as $punkt) {
$punkt_title = '';
$punkt_icon = '';
$punkt_link = '';
$punkt_first = '';

$punkt_links_arr = array();
$punkt_links = array();


$punkt_cats_arr = array();
$punkt_cats = array();


$punkt_obj_arr = array();
$punkt_obj = array();

$count_punkts = 0;
$punkts_str = '';

if (isset($punkt['status']) && $punkt['status'] == 1) {
if (isset($punkt['title'])) { $punkt_title = $punkt['title']; }
if (isset($punkt['icon']) && !empty($punkt['icon'])) { $punkt_icon = '<i class="'.$punkt['icon'].'"></i>'; }

$punkt_first = '<span class="ag_title_punkts">'.$punkt_icon.$punkt_title.'</span>';

//punkt_link
if (isset($punkt['punkt_link'])) { $punkt_link = $punkt['punkt_link']; }
if (!empty($punkt_link)) {
$punkt_link_arr = explode('::', $punkt_link);

if (isset($punkt_link_arr[0])) {
	$lm_target = '';
    if (strpos($punkt_link_arr[0], 'http') === false) {} else {$lm_target = ' target="_blank"';}	
	$punkt_link = '<a href="'.$punkt_link_arr[0].'"'.$lm_target.'>'.$punkt_icon.$punkt_title.'</a>';
	}
$punkt_first = $punkt_link;
} 



// links
if (isset($punkt['links'])) { $punkt_links_arr = explode($ag_separator[2], $punkt['links']); }

$link_address = '';
$link_text = '';
foreach ($punkt_links_arr as $links) {
	$link = explode('::', $links);
	if (isset($link[0])) {$link_address = $link[0];}
	if (isset($link[1])) {$link_text = $link[1];}

if (empty($link_text)) {
$link_text = $link_address;
$link_text = str_replace(array('http://','https://'), '', $link_text);
}
if (!empty($link_address)) { 
$l_target = '';
if (strpos($link_address, 'http') === false) {} else {$l_target = ' target="_blank"';}	
    $punkt_links[] = '<a href="'.$link_address.'"'.$l_target.'>'.$link_text.'</a>';
}
}
// links



foreach ($ag_cat as $cats) {
if (isset($cats['status']) && $cats['status'] == 1) {
if (isset($cats['alias'])) { $ag_home_cat = $cats['alias']; }
break;
} 	
}


// cats
if (isset($punkt['categorys'])) { $punkt_cats_arr = explode($ag_separator[2], $punkt['categorys']); }
foreach ($punkt_cats_arr as $pcats_id) {
	foreach ($ag_cat as $cat) {
	if (isset($cat['id']) && isset($cat['alias']) && isset($cat['title']) && isset($cat['status']) && $cat['status'] == '1') {
	$ag_cat_address = '?'.$ag_get_cat.'='.$cat['alias'];
	if ($cat['alias'] == $ag_home_cat && $ag_cfg_home == 'first_category') {$ag_cat_address = $srv_absolute_url;}
	if ($pcats_id == $cat['id']) { $punkt_cats[$cat['alias']] = '<a href="'.$ag_cat_address.'">'.$cat['title'].'</a>'; }	
	}//status
	}
}// foreach punkt_cats_arr
//cats





if (!empty($punkt_cats)) {
foreach ($punkt_cats as $al => $pcats) { $count_punkts++;
// ag_this_punkt
$this_cat_class = '';
if ($al == $ag_alias_cat && empty($ag_alias_obj)) {$this_cat_class = ' class="ag_this_punkt"';}
if ($al == $ag_home_cat && empty($ag_alias_cat) && $ag_cfg_home == 'first_category') {$this_cat_class = ' class="ag_this_punkt"';}
if (isset($_GET[$ag_get_sitemap]) || isset($_GET[$ag_get_search]) || isset($_GET[$ag_get_confirm]) || isset($_GET[$ag_get_pay])) {$this_cat_class = '';}
$punkts_str .= '<li'.$this_cat_class.'><h3>'.$pcats.'</h3></li>';
}	
}


if (!empty($punkt_links)) {
foreach ($punkt_links as $plinks) { $count_punkts++;
$punkts_str .= '<li><h3>'.$plinks.'</h3></li>';
}	
}

// objects
$str_objects_id = '';

if (isset($punkt['objects']) && !empty($punkt['objects'])) { 

$punkt_obj_arr = explode($ag_separator[2], $punkt['objects']); 

foreach ($punkt_obj_arr as $pobj_id) { $count_punkts++;
$pobj_id_arr = explode('::', $pobj_id);
$id_pobj = '';	
$id_pcat = '';
if (isset($pobj_id_arr[0])) {$id_pcat = $pobj_id_arr[0];}
if (isset($pobj_id_arr[1])) {$id_pobj = $pobj_id_arr[1];}

$str_objects_id .= $id_pobj.',';

}// foreach punkt_obj_arr

if (!empty($str_objects_id)) {
$punkts_str .= strip_tags(ag_list_obj('', 0, $str_objects_id, 'punkt'), '<li><h3><a>'); 
}

}// objects

//$count_punkt_obj

if ($count_punkts > 0) {
	if ($count_punkts == 1) {
	//$punkts_str = strip_tags($punkts_str, '<li><h3><a>'); 
	$punkts_str = str_replace('<li>', '<li class="ag_menu_item">', $punkts_str); 
	$ag_str_a = ag_str_cat($punkts_str, '<a href="', '">');
	
	$punkts_str = preg_replace('/<a href=(.*?)>/', $ag_str_a.$punkt_icon, $punkts_str);
	$custom_menu .= $punkts_str; 
	} else {
	$custom_menu .= '<li class="ag_menu_item ag_menu_item_punkts" tabindex="-1" onclick="ag_open_punkts(this)"><h3>'.$punkt_first.'</h3>';
	if (!empty($punkts_str)) {$custom_menu .= '<ul class="ag_punkts">'.$punkts_str.'</ul>';}
	$custom_menu .= '</li>';
		
	}
} else { if (!empty($punkt_link)) {$custom_menu .= '<li class="ag_menu_item"><h3>'.$punkt_first.'</h3></li>';} }

}// punkt status 	
}// foreach ag_menu



if (empty($custom_menu)) {



// default menu
foreach ($ag_cat as $cats) {
if (isset($cats['status']) && $cats['status'] == 1) {
if (isset($cats['alias'])) { $ag_home_cat = $cats['alias']; }
break;
} 	
}


$ag_alias_cat_menu = $ag_alias_cat;

if (isset($_GET[$ag_get_search])) { $ag_alias_cat = $ag_get_search; }// search
if (isset($_GET[$ag_get_sitemap])) { $ag_alias_cat = $ag_get_sitemap; }// sitemap
if (ag_meta('title', '') == $ag_lng['error_404_meta']) {$ag_alias_cat = 'error_404';}

$count_menu = 0;
$ag_menu = '<ul>';

$ag_home_li_class = '';
if ($ag_cfg_home != 'first_category') { 
if (!empty($ag_cfg_home_icon)) { 
if (empty($ag_cfg_home_text)) { 
$ag_cfg_home_icon = '<i class="'.$ag_cfg_home_icon.' ag_one_icon"></i>';
$ag_home_li_class = ' ag_empty_home';
$ag_cfg_home_text = '<span class="ag_none">'.$ag_lng['home_group_cfg'].'</span>';
} else { 
$ag_cfg_home_icon = '<i class="'.$ag_cfg_home_icon.'"></i>'; 
}
}


if (empty($ag_alias_cat) && !isset($_GET[$ag_get_sitemap]) && !isset($_GET[$ag_get_search]) && $ag_error_get != 1) {
$ag_menu .= '<li class="ag_menu_item ag_home'.$ag_home_li_class.'"><h3><span>' .$ag_cfg_home_icon. '' .$ag_cfg_home_text. '</span></h3></li>';
} else {	
$ag_menu .= '<li class="ag_menu_item ag_home'.$ag_home_li_class.'"><h3><a href="' .$srv_absolute_url. '">' .$ag_cfg_home_icon. '' .$ag_cfg_home_text. '</a></h3></li>';
}


} else { if (empty($ag_alias_cat)) { $ag_alias_cat_menu = $ag_home_cat; }  } // home




foreach ($ag_cat as $nc => $cat) {
$cat_id = '';
$cat_alias = '';
$cat_title = '';
$cat_icon = '';
$cat_link = '';

$count = 0;


if (isset($cat['id'])) {$cat_id = $cat['id'];}
if (isset($cat['alias'])) {$cat_alias = $cat['alias'];}

if (isset($cat['status']) && $cat['status'] == 1) { $count_menu++;
$count = (int)$count;
if (isset($cat['count']) && empty($count)) {
if ((int)$cat['count'] > 0) { $count = (int)$cat['count']; }
}

if (isset($cat['title'])) {$cat_title = $cat['title'];}
if (isset($cat['icon']) && !empty($cat['icon'])) {$cat_icon = '<i class="' .$cat['icon']. '"></i>';}



if ($cat_alias == $ag_alias_cat_menu) {
$ag_menu .= '<li class="ag_menu_item"><h3><span>' .$cat_icon. '' .$cat_title. '</span></h3></li>';	
} else {
$cat_link = '?' .$ag_get_cat. '='. $cat_alias;
if ($ag_cfg_home == 'first_category') { if ($cat_alias == $ag_home_cat) {$cat_link = $srv_absolute_url;} }
$ag_menu .= '<li class="ag_menu_item"><h3><a href="' .$cat_link. '">' .$cat_icon. '' .$cat_title. '</a></h3></li>';	

}


}// status


}// foreach ag_cat


$ag_menu .= '</ul>';
if ($count_menu > 1) {
return $ag_menu;} else { return ''; }


} else {
$ag_menu = '<ul>';


$ag_home_li_class = '';
if ($ag_cfg_home != 'first_category') { 
if (!empty($ag_cfg_home_icon)) { 
if (empty($ag_cfg_home_text)) { 
$ag_cfg_home_icon = '<i class="'.$ag_cfg_home_icon.' ag_one_icon"></i>';
$ag_home_li_class = ' ag_empty_home';
$ag_cfg_home_text = '<span class="ag_none">'.$ag_lng['home_group_cfg'].'</span>';
} else { 
$ag_cfg_home_icon = '<i class="'.$ag_cfg_home_icon.'"></i>'; 
}
}


if (empty($ag_alias_cat) && !isset($_GET[$ag_get_sitemap]) && !isset($_GET[$ag_get_search]) && $ag_error_get != 1) {
$ag_menu .= '<li class="ag_menu_item ag_home'.$ag_home_li_class.'"><h3><span>' .$ag_cfg_home_icon. '' .$ag_cfg_home_text. '</span></h3></li>';
} else {	
$ag_menu .= '<li class="ag_menu_item ag_home'.$ag_home_li_class.'"><h3><a href="' .$srv_absolute_url. '">' .$ag_cfg_home_icon. '' .$ag_cfg_home_text. '</a></h3></li>';
}


} else { if (empty($ag_alias_cat)) { $ag_alias_cat_menu = $ag_home_cat; }  } // home



$ag_menu .= $custom_menu;

$ag_menu .= '</ul>';
return $ag_menu;
}


}// ag_menu




//---------------------------------------------- SEARCH

function ag_search($query) {

global $ag_data_dir;	
global $agt;
global $ag_separator;
global $ag_lng;
global $ag_not_found_content;
global $ag_query_empty_content;
global $ag_get_search;

$ag_count_found = 0;

$ag_search_name = '';
$ag_search_id = '';
$ag_search_content = '';
$ag_match_str = '';
$found_id_str = '';

$ag_disalow_insearch = array('/', '\\', '*', '(', ')', '?', '|', '+', '$', '&', '=');
$query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
$query = mb_strtolower($query, 'utf8');
$query = str_replace($ag_disalow_insearch, '', $query);	

if (!empty($query) && iconv_strlen($query, 'UTF-8') > 2) {

if (file_exists($ag_data_dir.'/object')) {
$ag_list_db = ag_file_list($ag_data_dir.'/object', $agt);

$ag_search_db = array();
foreach($ag_list_db as $ag_file_db) {
if (file_exists($ag_file_db['name'])) {
$ag_search_db = ag_read_data($ag_file_db['name']);
foreach ($ag_search_db as $ag_sear_val) {
	
if (isset($ag_sear_val['status']) && $ag_sear_val['status'] == 1) {	

if (isset($ag_sear_val['name'])) {$ag_search_name = $ag_sear_val['name'];}	
else if (isset($ag_sear_val['title'])) {$ag_search_name = $ag_sear_val['title'];}
if (isset($ag_sear_val['content'])) {$ag_search_content = $ag_sear_val['content'];}
if (isset($ag_sear_val['id'])) {$ag_search_id = $ag_sear_val['id'];}

$ag_search_content = html_entity_decode($ag_search_content, ENT_QUOTES, 'UTF-8');
$ag_search_content = str_replace('[site_url]', '', $ag_search_content);
$ag_search_content = str_replace(array('<br>','<br />'), ' ', $ag_search_content);
$ag_search_content = strip_tags($ag_search_content, ' ');
$ag_search_content = str_replace($ag_separator[3], ' ', $ag_search_content);


$ag_match_str = mb_strtolower($ag_search_name.' '.$ag_search_content, 'utf8');

if (preg_match('/'.$query.'/i', $ag_match_str)) { $ag_count_found ++; // found search
$found_id_str .= $ag_search_id.',';
}

}// status


}// foreach ag_search_db
}// file_exists & !=0
}// foreach ag_list_db
$ag_search_top = '';
if (isset($_GET[$ag_get_search])) {$query = htmlspecialchars($_GET[$ag_get_search], ENT_QUOTES, 'UTF-8');}
$ag_search_title = str_replace('%s', '&laquo;' .$query. '&raquo;', $ag_lng['search_result']);
$ag_search_top = '<div class="ag_cat_top"><h2 class="ag_title_cat">' .$ag_search_title. '</h2></div>';
if ($ag_count_found > 0) {
return '<div class="ag_cat ag_search_result">'.$ag_search_top.ag_list_obj('', '10', $found_id_str, 'short,300').'</div>';	

} else {
return $ag_not_found_content; 
}

}// file_exists
} 
if (empty($query) || iconv_strlen($query, 'UTF-8') < 3) { return $ag_query_empty_content; } // !empty query & > 2

}// ag_search





$ag_check_count_objects = 0;
$ag_check_count_objects = ag_check_obj(); 
include('inc/ag_widgets.php');
?>