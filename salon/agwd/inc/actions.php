<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


$ag_data = array();
$ag_home = '';

$srv_current_path_arr = explode('/',$srv_current_path);
array_pop($srv_current_path_arr);
$ag_ap_dir = '';
if (isset($srv_current_path_arr[(sizeof($srv_current_path_arr) - 1)])) {$ag_ap_dir = $srv_current_path_arr[(sizeof($srv_current_path_arr) - 1)];}
//echo $ag_ap_dir; apanel dir name

$ag_tab_url = '';
$ag_cat_url = '';
$ag_this_db = '';
$ag_this_cat = '';
$ag_icon_db = '';
$ag_name_db = '';
$ag_menu_db .= '';
$ag_values_db = array();
$ag_this_id = '';
$ag_title_cat = '';
$ag_set_staffs = array();

//meta
$ag_title_tab = '';
$ag_icon_tab = '';

unset($ag_ERROR);
if (isset($_GET['logout'])) { ag_exit($srv_script_absolute_url); } //LogOut

//get
if (isset($_GET['tab']) && !empty($_GET['tab'])) {$ag_this_db = htmlspecialchars($_GET['tab'], ENT_QUOTES, 'UTF-8');}
if (isset($_GET['cat']) && !empty($_GET['cat'])) {$ag_this_cat = htmlspecialchars($_GET['cat'], ENT_QUOTES, 'UTF-8');}
if (isset($_GET['id']) && !empty($_GET['id'])) {$ag_this_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');}

// this name


//staff db
$count_tab = 0;
foreach ($ag_db as $db_names => $db_values) { $count_tab++;
if ($count_tab == 1) {$ag_staff_db = $db_names;}
}
$ag_users = ag_read_data($ag_data_dir.'/'.$ag_staff_db.$agt);// all users

//first tab
$ag_first_tab = 1; // open tab after logon
$ag_first_page = '';
if(empty($ag_this_db)) {
$ag_title_tab = $ag_cfg_title;
/*	
$count_first_tab = 0;
foreach ($ag_db as $db_names => $db_values) { $count_first_tab++;
if ($count_first_tab == $ag_first_tab) {$ag_this_db = $db_names;}
}
*/
}

// home
if (!isset($_GET['settings']) && !isset($_GET['orders']) && !isset($_GET['common_search']) && !isset($_GET['tab'])) { $ag_home = 1; $ag_title_tab = $ag_cfg_title; }


if (!empty($ag_this_cat)) { $ag_cat_url = '&amp;cat='.$ag_this_cat; }
$ag_tab_url = '?tab='.$ag_this_db.$ag_cat_url;
$ag_id_url = '&amp;id='.$ag_this_id;
if (isset($_GET['iframe'])) {$ag_id_url = $ag_id_url.'&amp;iframe';}
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);


$ad_clear_check_files_str = '';
$ad_clear_del_files_str = '';
$ad_clear_check_files = array();
$ad_clear_del_files = array();

// menu tab

$ag_check_cat = array();
if (file_exists($ag_data_dir.'/category'.$agt)) { $ag_check_cat = ag_read_data($ag_data_dir.'/category'.$agt); }

if (file_exists('inc/orders.php') || file_exists('orders.php')) {
$ag_menu_class_orders = '';
if (isset($_GET['orders'])) {$ag_menu_class_orders = 'ag_this_tab';}
$ag_menu_db .= '<li class="' .$ag_menu_class_orders. '"><a href="?orders"><i class="icon-bell-4"></i>' .$ag_lng['orders']. '</a></li>';
}

if (empty($ag_check_cat)) {
$ag_first_open = 1;
// first settings punkt
$ag_menu_class_settings = '';
if (isset($_GET['settings'])) {$ag_menu_class_settings = 'ag_this_tab';}
$ag_menu_db .= '<li class="' .$ag_menu_class_settings. '"><a href="?settings"><i class="icon-cog"></i>' .$ag_lng['settings']. '</a></li>';

}

foreach ($ag_db as $db_names => $db_values) {
	
$name_tab = $db_names.'s';
if (isset($ag_lng[$db_names.'s'])) {$name_tab = $ag_lng[$db_names.'s'];}

$icon_tab = '<i class="icon-right-open-mini"></i>';
if (isset($ag_db_icons[$db_names])) {$icon_tab = '<i class="' .$ag_db_icons[$db_names]. '"></i>';}

$ag_menu_class = 'ag_tab';
if ($db_names == $ag_this_db) { // this tab
$ag_title_tab = $name_tab;
$ag_icon_tab = $icon_tab;
$ag_values_db = $db_values; // values this db
if (!isset($_GET['common_search'])) {$ag_menu_class .= ' ag_this_tab';}
}// this tab

if (isset($_GET['common_search'])) { $ag_title_tab = $ag_lng['common_search']; $ag_menu_class = '';}
if (isset($_GET['settings'])) { $ag_title_tab = $ag_lng['settings']; $ag_menu_class = '';}
if (isset($_GET['orders'])) { $ag_title_tab = $ag_lng['orders']; $ag_menu_class = '';}

// menu db dir
$ag_empty_punkt = array();
$ag_empty_punkt_str = '';
$ag_sub_punkt = '';
$ag_sub_name = $ag_lng['no_name'];

$ag_sab_menu_class = 'ag_sub_tab';
$ag_punkt_staffs = array();


$count_punkt_staff = 0;
$ag_sub_data = array();	
foreach ($ag_db_dir as $db_dir_name => $db_dir) {
	

	
if (file_exists($ag_data_dir.'/'.$db_dir_name.$agt)) {
$ag_sub_data = ag_read_data($ag_data_dir.'/'.$db_dir_name.$agt);
}

if (!empty($ag_sub_data)) {
if ($db_names == $db_dir) {
	
	$ag_file_list_menu = array();
	$ag_sub_punkt .= '<ul>';
	
	$ag_file_list_menu = ag_file_list($ag_data_dir.'/'.$db_dir, $agt);
	if (!empty($ag_file_list_menu)) { 
	foreach ($ag_sub_data as $sb_val) { 
	foreach ($ag_file_list_menu as $sub_id) {
	
    if (isset($sub_id['name'])) {
    $sub_id['name'] = str_replace(array($ag_data_dir.'/'.$db_dir, '/', $agt), '', $sub_id['name']);
    
	
	if (isset($sb_val['id']) && !empty($sb_val['id'])) { $ad_clear_check_files_str .= $sb_val['id'].$ag_separator[0]; }	
	$ad_clear_del_files_str	.= $sub_id['name'].$ag_separator[0];
	
	
	
	if (isset($sb_val[$ag_staff_db.'s'])) { 
	$ag_punkt_staffs = explode($ag_separator[2], $sb_val[$ag_staff_db.'s']);
	}
	
	$ag_sub_icon = 'icon-right-open-4';
	
	if (isset($sb_val['id']) && $sb_val['id'] == $ag_this_cat || isset($_POST['delete_item_file']) && $sb_val['id'] == $_POST['delete_item_file']) { // this cat
	if (isset($sb_val['name'])) {$ag_title_cat = $sb_val['name'];} // for title
	if (isset($sb_val['title'])) {$ag_title_cat = $sb_val['title'];} // for title
	
	if (isset($sb_val[$ag_staff_db.'s'])) {
	$ag_set_staffs = explode($ag_separator[2], $sb_val[$ag_staff_db.'s']);
	}// set staffs for this cat
	
	}// this cat
	
	if (isset($sb_val['id']) && $sb_val['id'] == $sub_id['name']) {
	if (isset($sb_val['name'])) {$ag_sub_name = $sb_val['name'];}
	if (isset($sb_val['title'])) {$ag_sub_name = $sb_val['title'];}
	
	
	if (isset($sb_val['icon']) && !empty($sb_val['icon'])) {$ag_sub_icon = $sb_val['icon'];}
	
	if ($sub_id['name'] == $ag_this_cat) { 
	if (!isset($_GET['common_search'])) { $ag_sab_menu_class .= ' ag_this_tab'; } 
	} else {
	$ag_sab_menu_class = 'ag_sub_tab';
	}
	
	
	
	if ($ag_user_access == 3) {
	
    if (!empty($ag_punkt_staffs)) { 
	if (in_array($ag_user_id, $ag_punkt_staffs)) {$count_punkt_staff ++;
	$ag_sub_punkt .= '<li class="' .$ag_sab_menu_class. '"><a href="?tab='.$db_dir.'&amp;cat='.$sub_id['name'].'"><span><i class="'.$ag_sub_icon.'"></i>' .$ag_sub_name. '</span></a></li>';	
	}
	
	}// set staffs for punkts
	}// access 3 
	
	if ($ag_user_access != 3) { $count_punkt_staff ++;
	$ag_sub_punkt .= '<li class="' .$ag_sab_menu_class. '"><a href="?tab='.$db_dir.'&amp;cat='.$sub_id['name'].'"><span><i class="'.$ag_sub_icon.'"></i>' .$ag_sub_name. '</span></a></li>';		
	}
	
	}// isset id
	
	} //sub_id name
	
	} //foreach ag_file_list_menu
	} //foreach ag_sub_data
}// no empty db dir


	if (isset($count_punkt_staff) && $count_punkt_staff == 0) {$ag_sub_punkt .= '<li class="' .$ag_sab_menu_class. '"><a href="#" class="ag_disabled"><span><i class="icon-roadblock"></i>' .$ag_lng['no_access_elements']. '</span></a></li>';}
	$ag_sub_punkt .= '</ul>';
	
}// id == id
} else { $ag_empty_punkt_str .= $db_dir.$ag_separator[0]; } // !empty ag_sub_data

}// foreach ag_db_dir

$ag_empty_punkt = explode($ag_separator[0], $ag_empty_punkt_str);
array_pop($ag_empty_punkt);

if (!in_array($db_names, $ag_empty_punkt)) {
if (in_array($db_names, $ag_db_dir)) {
$ag_menu_db .= '<li class="' .$ag_menu_class. '"><span tabindex="-1" onclick="ag_sub_menu(this)" class="ag_sub_punkts">' .$icon_tab.$name_tab. '<span class="ag_open_close_sub"><i class="icon-down-open-2"></i></span></span>' .$ag_sub_punkt. '</li>';
} else {
$ag_menu_db .= '<li class="' .$ag_menu_class. '"><a href="?tab=' .$db_names. '">' .$icon_tab.$name_tab. '</a></li>';
}
}	
	
}// foreach ag_db


// open filemanager
$ag_menu_db .= '<li><a href="#" onclick="ag_open_ifm(\'none\', \'\', \'ag_menu\')"><i class="icon-folder-5"></i>' .$ag_lng['file_manager']. '</a></li>';

if (!empty($ag_check_cat)) {
// settings punkt
$ag_menu_class_settings = '';
if (isset($_GET['settings'])) {$ag_menu_class_settings = 'ag_this_tab';}
$ag_menu_db .= '<li class="' .$ag_menu_class_settings. '"><a href="?settings"><i class="icon-cog"></i>' .$ag_lng['settings']. '</a></li>';
}


$ag_menu_db .= '
<script>
//*---swing long name in main menu---
var w_name_list_st = $("#ag_tabs_menu").outerWidth(true);
$(".ag_sub_tab a").hover(function() {
	
if ($(this).outerWidth(true) > w_name_list_st) {
	var wswing_st = $(this).outerWidth(true) - w_name_list_st+4;
	var speed_st = 8*wswing_st;
	if (speed_st < 800) {speed_st = 800;}
	$(this).css({transition: "none"});
    $(this).delay(300).animate({left: "-"+wswing_st+"px"}, speed_st); 
}}).mouseleave(function() {
	$(this).stop(true,true).css({left: "0px", transition: "all 0.5s ease-in-out"});
});
</script>';

$ag_menu_js = '
//*---submenu---
var ag_click_sab_menu = 0;
var ag_ul_click = 0;

$(".ag_sub_punkts").blur(function(){ ag_click_sab_menu = 0; });


function ag_sub_close_menu() {
$("#ag_main_menu li ul").stop().slideUp(200);
$("#ag_main_menu li span.ag_sub_punkts").removeClass("ag_open_sub"); 
$("#ag_main_menu li span span.ag_open_close_sub").removeClass("ag_close_sub");

$("#ag_first_menu li ul").stop().slideUp(200);
$("#ag_first_menu li span.ag_sub_punkts").removeClass("ag_open_sub"); 
$("#ag_first_menu li span span.ag_open_close_sub").removeClass("ag_close_sub");
}


function ag_sub_menu(el) { 
ag_sub_close_menu();
ag_click_sab_menu = ag_click_sab_menu + 1;

if (ag_click_sab_menu > 1) { 

$(el).parent().find("ul").stop().slideUp(300);
$(el).removeClass("ag_open_sub"); 
$(el).find("span.ag_open_close_sub").removeClass("ag_close_sub");
ag_click_sab_menu = 0;
} else {
$(el).parent().find("ul").stop().delay(100).slideDown(300);	
$(el).addClass("ag_open_sub");
$(el).find("span.ag_open_close_sub").addClass("ag_close_sub");	
}

}

$(document).mouseup(function (e) {
var ag_cl_el = $(".ag_sub_punkts");
if (!ag_cl_el.is(e.target) && ag_cl_el.parent().find("ul").has(e.target).length === 0) {	
ag_sub_close_menu();
}
});
';

$ag_menu_db = ag_return_html($ag_menu_db);

//=================================== First page menu
$ag_first_page = '';
if(!empty($ag_home)) {
if(!isset($_GET['common_search'])) {
$ag_search_home_val = ''; if (isset($_POST['common_search_query'])) { $ag_search_home_val = $_POST['common_search_query']; }
$ag_first_page = '<div id="ag_common_search" class="ag_common_search_home"><div class="ag_common_search"><form name="ag_common_search" action="' .$srv_script_absolute_url. '?common_search" method="post"><label id="ag_common_search_input" class=""><input type="text" name="common_search_query" placeholder="' .$ag_lng['common_search']. '" value="' .$ag_search_home_val. '" onblur="ag_out(\'ag_common_search_input\')" onfocus="ag_active(\'ag_common_search_input\')"></label><button class="ag_btn_big"><i class="icon-search"></i></button><div class="clear"></div></form></div></div>';
$ag_first_page .= '<div class="ag_first_menu"><ul id="ag_first_menu">' .$ag_menu_db. '</ul><div class="clear"></div></div>';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_first_page .= '<script>' .$ag_menu_js. '</script>';
} else {
$ag_first_page .= '
<script>
var ag_w_li_menu = $("#ag_first_menu li").outerWidth(true) - 70;
$("#ag_first_menu li a, #ag_first_menu li span.ag_sub_punkts").css({height: ag_w_li_menu + "px", maxHeight: ag_w_li_menu + "px"});
' .$ag_menu_js. '</script>';}

}
}


//=================================== CLEAR UNUSED FILES
$ad_clear_check_files = explode($ag_separator[0], $ad_clear_check_files_str);
$ad_clear_del_files = explode($ag_separator[0], $ad_clear_del_files_str);
array_pop($ad_clear_check_files);
array_pop($ad_clear_del_files);
$ad_clear_check_files = array_unique($ad_clear_check_files); // lines id
$ad_clear_del_files = array_unique($ad_clear_del_files); //file list

foreach ($ad_clear_del_files as $id_df) {
if (!in_array($id_df, $ad_clear_check_files)) {
	$ag_unlink_file = $ag_data_dir.'/'.$db_dir.'/'.$id_df.$agt;
	if (file_exists($ag_unlink_file)) { unlink($ag_unlink_file); } //delete 
	}
}

	


//=================================== READ DATA
if (!empty($ag_this_cat)) {
$ag_file_name = $ag_data_dir.'/'.$ag_this_db.'/'.$ag_this_cat.$agt;	
} else {
$ag_file_name = $ag_data_dir.'/'.$ag_this_db.$agt;	
}

if (!empty($ag_this_db)) {
$ag_data = ag_read_data($ag_file_name); //data
}
//=================================== READ DATA





// this name
$ag_this_edit_id = 1;
$ag_this_edit_access = '';
$ag_this_name = $ag_lng['no_name'];
foreach ($ag_data as $ag_all_items) {
if (isset($ag_all_items['id']) && isset($ag_all_items['name']) && $ag_this_id == $ag_all_items['id']) {$ag_this_name = $ag_all_items['name']; $ag_this_edit_id = $ag_all_items['id'];}
if (isset($ag_all_items['id']) && isset($ag_all_items['title']) && $ag_this_id == $ag_all_items['id']) {$ag_this_name = $ag_all_items['title'];}
if (isset($ag_all_items['id']) && isset($ag_all_items['access']) && $ag_this_id == $ag_all_items['id']) {$ag_this_edit_access = $ag_all_items['access'];}
}


if (!empty($ag_set_staffs)) {
if (in_array($ag_user_id, $ag_set_staffs)) {$ag_user_access = 1; $ag_this_access = 1;}	
}// user access for this cat


//=================================== DELETE & CLEAR EMPTY LINES


// search delete
if (isset($_POST['delete_item_dir'])) {
$_POST['delete_item_dir'] = htmlspecialchars($_POST['delete_item_dir'], ENT_QUOTES, 'UTF-8');
$ag_file_name = $ag_data_dir.'/'.$_POST['delete_item_dir'].$agt;
if (isset($_POST['delete_item_file']) && !empty($_POST['delete_item_file'])) {
$_POST['delete_item_file'] = htmlspecialchars($_POST['delete_item_file'], ENT_QUOTES, 'UTF-8');
$ag_file_name = $ag_data_dir.'/'.$_POST['delete_item_dir'].'/'.$_POST['delete_item_file'].$agt;
}
}// search delete


// CLEAR EMPTY LINES
if (file_exists($ag_file_name)) {
if (filesize($ag_file_name) != 0) {
$ag_lines = array();
	
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));	
$ag_br = "\n";

for ($i = 0; $i < sizeof($ag_lines); $i++) {
 if (empty($ag_lines[$i]) || strpos($ag_lines[$i], $ag_separator[0]) === false) { 
    if (isSet($ag_lines[(integer) $i]) == true) {   
        unset($ag_lines[(integer) $i]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode($ag_br, $ag_lines))); 
    }  
  } 
} 

// DELETE
if (isset($_POST['delete_item'])) {
	
if (is_array($_POST['delete_item'])) { $ag_del = $_POST['delete_item']; } else { $ag_del = array($_POST['delete_item']); }

foreach ($ag_del as $ag_del_id) {
$ag_del_id = htmlspecialchars($ag_del_id, ENT_QUOTES, 'UTF-8');



$ag_line_data = '';

// check ID as number line
foreach ($ag_lines as $n => $line) {
$line_arr = explode($ag_separator[0], $line);	
foreach ($line_arr as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'id') { if ($values[1] == $ag_del_id) { $ag_delete_line = $n; $ag_line_data = $line;} } 
}
}

// user self delete!
if ($ag_del_id == $ag_user_id) { $ag_ERROR['access_self_delete'] = $ag_lng['self_delete']; unset($ag_delete_line); } //user self delete!


// founder delete!
$found_line_arr = explode($ag_separator[0], $ag_line_data);
foreach ($found_line_arr as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == 'founder') { 
unset($ag_delete_line); $ag_ERROR['access_admin_delete'] = $ag_lng['admin_delete']; } // founder delete!

if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == '1') { // admin no edit other admins	
if ($ag_this_id != $ag_user_id && $ag_user_access != 'founder') { $ag_ERROR['access'] = $ag_lng['access_denied']; }
} // admin no edit other admins	
//

}





if (isset($ag_delete_line)) {

if ($ag_this_access != '1') {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access
	
if (isSet($ag_lines[(integer) $ag_delete_line]) == true && !isset($ag_ERROR)) {   
        unset($ag_lines[(integer) $ag_delete_line]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode($ag_br, $ag_lines)));
    }
  }	
  
 
//---------------------------db dir
foreach ($ag_db_dir as $add_name_db => $add_in_dir) {
if ($ag_this_db == $add_name_db) {
	
$ag_del_db_dir = $ag_data_dir.'/'.$add_in_dir.'/'.$ag_del_id.$agt;	
if (file_exists($ag_del_db_dir) && !isset($ag_ERROR)) {
unlink($ag_del_db_dir);	
}	
}// this db = db dir
}// foreach $ag_db_dir
 
  
  
}// foreach ag_del






if (isset($ag_ERROR)) {
$error_mess_str = '';
foreach ($ag_ERROR as $error_mess) {
$error_mess_str .= '<li>' .$error_mess. '</li>';
}
$ag_view_errors = '<script>ag_dialog("3000", "<ul>' .$error_mess_str. '</ul>", "'.$ag_lng['abort'].'", "ag_cancel", "icon-roadblock ag_str_red", "");</script>';

} else { //-------- ERRORS
$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url); 
}// no errors


}// isset delete


flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);

}// file != 0
}// file_exists
if (isset($_POST['remove_menu'])) { 
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url); 
}




//auto delete files in dir
$ag_all_fs_str = '';
$ag_all_fs_arr = array();

$ag_dir_fs_str = '';
$ag_dir_fs_arr = array();


if (isset($ag_db_settings)) {

//foreach ($ag_db_settings as $ag_fs_dir => $ag_fs_sett) {
$ag_fs_dir = $ag_this_db;

if (isset($ag_db_settings[$ag_fs_dir]['files'])) {

$ag_db_settings_files = explode('|', $ag_db_settings[$ag_this_db]['files']); 

foreach ($ag_db_settings_files as $fs_name_type) {
$fs_name_type_arr = explode('-', $fs_name_type);
if (isset($fs_name_type_arr[0])) {$fs_name = $fs_name_type_arr[0];}
if (isset($fs_name_type_arr[1])) {$fs_type = $fs_name_type_arr[1];}

if (file_exists($ag_data_dir.'/'.$ag_fs_dir.$agt)) {
	
$ag_db_file_dir = ag_read_data($ag_data_dir.'/'.$ag_fs_dir.$agt);

foreach ($ag_db_file_dir as $data_files_id) {
if (isset($data_files_id['id']) && isset($fs_name) && isset($fs_type)) {
	
$ag_all_file_db = $ag_data_dir.'/'.$ag_this_db.'/'.$fs_name.'_'.$data_files_id['id'].'.'.$fs_type;
$ag_all_fs_str .= $ag_all_file_db.$ag_separator[0];

}// isset id
}// foreach ag_db_file_dir
}// isset db for dir
}// foreach ag_db_settings_files


if (file_exists($ag_data_dir.'/'.$ag_fs_dir)) {
$ag_all_file_dir_arr = ag_file_list($ag_data_dir.'/'.$ag_fs_dir, '');
foreach ($ag_all_file_dir_arr as $ag_all_file_dir) {
$ag_dir_fs_str .= $ag_all_file_dir['name'].$ag_separator[0];
}
}


}// isset files settings

//}//foreach ag_db_settings

}// isset settings db

$ag_all_fs_arr = explode($ag_separator[0], $ag_all_fs_str);
array_pop($ag_all_fs_arr);

$ag_dir_fs_arr = explode($ag_separator[0], $ag_dir_fs_str);
array_pop($ag_dir_fs_arr);

foreach ($ag_dir_fs_arr as $ag_dir_fs_check) {
if (!in_array($ag_dir_fs_check, $ag_all_fs_arr)) {
	if (file_exists($ag_dir_fs_check)) {
		unlink($ag_dir_fs_check);
	}
	}
}


//===========================ADD
if (isset($_GET['add']) || isset($_POST['add'])) {
if (isset($_POST['add'])) { $_GET['add'] = $_POST['add']; }

//===========================ID
$ag_add_id = $ag_this_db.'_'.date('d_m_Y_H_i_s').'_'.rand(10, 99);
//===========================/ID

//---------------------------db dir
foreach ($ag_db_dir as $add_name_db => $add_in_dir) {
if ($ag_this_db == $add_name_db) {
	
$ag_add_db_dir = $ag_data_dir.'/'.$add_in_dir.'/'.$ag_add_id.$agt;	

$ag_db_dir_file_create = fopen($ag_add_db_dir, "w"); // create data file
fwrite($ag_db_dir_file_create, "");
fclose ($ag_db_dir_file_create);		
	
}// this db = db dir
}// foreach $ag_db_dir





$ag_str_sep_add_info = '::';
$ag_add_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR'];

$line_data_add = '';
$_GET['add'] = htmlspecialchars($_GET['add'], ENT_QUOTES, 'UTF-8');
	
if (file_exists($ag_file_name)) {
	
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
if (filesize($ag_file_name) != 0) { $ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name))); } else { $ag_lines = array(); }	
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);

$ag_count_add = 0;
$name_item = $ag_lng['new_item'];
foreach ($ag_lines as $count_lines) { 
if (!empty($count_lines)) { $ag_count_add++; }
}
if ($ag_this_access != '1') {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access
	
foreach ($ag_db as $file_name => $index) {
if (isset($_GET['tab']) && $file_name == $_GET['tab']) {

$name_item = $file_name;
if (isset($ag_lng[$file_name])) {$name_item = $ag_lng[$file_name];}
$ag_count_add = $ag_count_add + 1;
foreach ($index as $create_name) {
//id
if ($create_name == 'id'){ $line_data_add .= $create_name.$ag_separator[1].$ag_add_id.$ag_separator[0]; }
//name
else if ($create_name == 'name' || $create_name == 'title') { $line_data_add .= $create_name.$ag_separator[1].$name_item.'-'.$ag_count_add.$ag_separator[0]; }
//added
else if ($create_name == 'added') { $line_data_add .= $create_name.$ag_separator[1].$ag_add_info.$ag_separator[0]; }
//other
else { $line_data_add .= $create_name.$ag_separator[1].''.$ag_separator[0]; }
}	
}	
}	

if (!isset($ag_ERROR) && !empty($line_data_add)) {
$ag_br = '';
$ag_rec = "w";

if ($ag_count_add > 1) {

$ag_br = "\n"; 
$ag_rec = "a+";
$ag_fp = fopen($ag_file_name, $ag_rec);
flock($ag_fp, LOCK_SH);  
fputs($ag_fp, "$ag_br$line_data_add"); 
flock ($ag_fp, LOCK_UN);
fclose($ag_fp); 

} else {

$ag_br = '';
$ag_rec = "w";
$add_file_create = fopen($ag_file_name, $ag_rec); // create data file
fwrite($add_file_create, "$ag_br$line_data_add");
fclose ($add_file_create);

}





}// no errors & not empty number line
} else { $ag_ERROR['file_exists'] = $ag_lng['error_file_exists']. '&nbsp;-&nbsp;' .$ag_file_name; } // file_exists


if (isset($ag_ERROR)) {
$error_mess_str = '';
foreach ($ag_ERROR as $error_mess) {
$error_mess_str .= '<li>' .$error_mess. '</li>';
}
$ag_view_errors = '<script>ag_dialog("3000", "<ul>' .$error_mess_str. '</ul>", "'.$ag_lng['abort'].'", "quick_mess", "icon-roadblock ag_str_red", "");</script>';
	
} else { //-------- ERRORS

if (isset($_POST['add'])) {
$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url.'&added='.$ag_add_id.'&new_item_name='.$name_item.'-'.$ag_count_add.'#add_'.$ag_add_id);
} else {
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.'&id='.$ag_add_id);	
}

}//-------- NO ERRORS

}// isset add
if (isset($_POST['add_menu'])) {
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url); 	
}


//=================================== EDIT
if (isset($_GET['id'])) {
$ag_edit_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

if (isset($_POST['ag_replace'])) {

if ($ag_this_db == $ag_staff_db) {
if ($ag_edit_id == $ag_user_id) { $ag_this_access = 1; }
if ($ag_this_access != 1) {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access
}

foreach ($ag_values_db as $name) {
if (isset($name) && !empty($name)) {
if (isset($_POST[$name])) {
	
//check errors

// login
if ($name == 'login') { 
foreach ($ag_data as $ag_check_name) {
if (isset($ag_check_name['login']) && isset($ag_check_name['id']) && $ag_check_name['id'] != $ag_this_id && $ag_check_name['login'] == $_POST[$name]) {
$ag_lng['error_overlap_login'] = str_replace('%s', '&nbsp;<strong>' .$ag_check_name['login']. '</strong>&nbsp;', $ag_lng['error_overlap_login']);
$ag_ERROR['overlap_login'] = $ag_lng['error_overlap_login'];
}
}// foreach ag_data

if (empty($_POST[$name])) {$ag_ERROR['empty_login'] = $ag_lng['error_empty_login']; }
}// login


// pass
if ($name == 'pass' && empty($_POST[$name]) && !isset($_POST['changepass'])) { 
$ag_ERROR['empty_pass'] = $ag_lng['error_empty_pass']; 
}// pass 




// name
if ($name == 'name' && empty($_POST[$name])) { 
$ag_ERROR['empty_name'] = $ag_lng['error_empty_name']; 
}// name 


// alias
if ($name == 'alias') { 
if (isset($_POST['name'])) { $_POST[$name] = $_POST['name']; } 
else if (isset($_POST['title'])) { $_POST[$name] = $_POST['title']; } 
else {$_POST[$name] = $ag_lng['no_name'];}
$_POST[$name] = ag_rus_translit($_POST[$name], 'small');

$_POST[$name] = str_replace('/', '', $_POST[$name]);
$_POST[$name] = str_replace('\\', '', $_POST[$name]);
$_POST[$name] = str_replace('*', '', $_POST[$name]);
$_POST[$name] = str_replace('(', '', $_POST[$name]);
$_POST[$name] = str_replace(')', '', $_POST[$name]);
$_POST[$name] = str_replace('?', '', $_POST[$name]);
$_POST[$name] = str_replace('|', '', $_POST[$name]);
$_POST[$name] = str_replace('+', '', $_POST[$name]);
$_POST[$name] = str_replace('$', '', $_POST[$name]);
$_POST[$name] = str_replace('"', '', $_POST[$name]);
$_POST[$name] = str_replace("'", '', $_POST[$name]);
$_POST[$name] = str_replace(',', '', $_POST[$name]);
$_POST[$name] = str_replace(':', '', $_POST[$name]);
$_POST[$name] = str_replace('=', '', $_POST[$name]);
$_POST[$name] = str_replace('&', '', $_POST[$name]);
$_POST[$name] = str_replace('.', '', $_POST[$name]);
$_POST[$name] = str_replace('<', '', $_POST[$name]);
$_POST[$name] = str_replace('>', '', $_POST[$name]);
$_POST[$name] = str_replace(';', '', $_POST[$name]);
$_POST[$name] = str_replace('`', '', $_POST[$name]);
$_POST[$name] = str_replace('%', '', $_POST[$name]);
$_POST[$name] = str_replace('#', '', $_POST[$name]);
$_POST[$name] = str_replace(' ', '', $_POST[$name]);

$_POST[$name] = mb_strtolower($_POST[$name], 'utf8');

$ag_disp_name = '?';
foreach ($ag_data as $ag_check_name) {
if (isset($ag_check_name['alias']) && isset($ag_check_name['id']) && $ag_check_name['id'] != $ag_this_id && $ag_check_name['alias'] == $_POST[$name]) {
if (isset($ag_check_name['name'])) {$ag_disp_name = $ag_check_name['name'];}
if (isset($ag_check_name['title'])) {$ag_disp_name = $ag_check_name['title'];}

$ag_lng['error_overlap_name'] = str_replace('%s', '&nbsp;<strong>'.$ag_disp_name.'</strong>&nbsp;', $ag_lng['error_overlap_name']);

if ($ag_this_db != 'time') {
$ag_ERROR['overlap_name'] = $ag_lng['error_overlap_name'];
}

}
}// foreach ag_data


if ($ag_this_db == 'time') { // no check times

	if (empty($_POST[$name])) {$_POST[$name] = 'no_name';} 
} 

if (empty($_POST[$name])) {$ag_ERROR['empty_title'] = $ag_lng['error_empty_title'];}



}// alias


//periods 
if ($name == 'works_period') {if (isset($_POST[$name][0]) && empty($_POST[$name][0])) {$_POST[$name][0] = date("d.m.Y");}}
if ($name == 'works_period' && !empty($_POST[$name]) && isset($_POST[$name][0]) && isset($_POST[$name][1])&& !empty($_POST[$name][0]) && !empty($_POST[$name][1])) { 
$_POST[$name][0] = htmlspecialchars($_POST[$name][0], ENT_QUOTES, 'UTF-8');
$_POST[$name][1] = htmlspecialchars($_POST[$name][1], ENT_QUOTES, 'UTF-8');

$ag_per_from = date("Y-m-d", strtotime($_POST[$name][0]));
$ag_per_to = date("Y-m-d", strtotime($_POST[$name][1]));
if ($ag_per_from > $ag_per_to) {$ag_ERROR['error_date_period'] = $ag_lng['error_date_period'].'<br />('.$_POST[$name][0].'&nbsp;>&nbsp;'.$_POST[$name][1].')';}
}


if ($name == 'time_period' && !empty($_POST[$name]) && isset($_POST[$name][0]) && isset($_POST[$name][1]) && !empty($_POST[$name][0]) && !empty($_POST[$name][1])) { 

$_POST[$name][0] = htmlspecialchars($_POST[$name][0], ENT_QUOTES, 'UTF-8');
$_POST[$name][1] = htmlspecialchars($_POST[$name][1], ENT_QUOTES, 'UTF-8');

$ag_no_end_time = 'XX:XX';

if ($_POST[$name][1] != $ag_no_end_time && $_POST[$name][1] != '00:00') {
$ag_per_from = date("H:i", strtotime($_POST[$name][0]));
$ag_per_to = date("H:i", strtotime($_POST[$name][1]));
if ($ag_per_from > $ag_per_to) {$ag_ERROR['error_time_period'] = $ag_lng['error_time_period'].'<br />('.$_POST[$name][0].'&nbsp;>&nbsp;'.$_POST[$name][1].')';}
if ($ag_per_from == $ag_per_to) {$ag_ERROR['error_time_period'] = $ag_lng['error_time_period_equally'].'<br />('.$_POST[$name][0].'&nbsp;=&nbsp;'.$_POST[$name][1].')';}
}

}

if ($name == 'time_period' && isset($_POST[$name][0]) && isset($_POST[$name][1])) {
if (isset($_POST['title'])) {

$ag_pattern_time = '/(\d+):(\d+) - (\d+):(\d+)/i';
if (preg_match('/'.$ag_no_end_time.'/i', $_POST[$name][1])) {
$ag_pattern_time = '/(\d+):(\d+) - '.$ag_no_end_time.'/i';
$_POST['title'] = preg_replace('/(\d+):(\d+) - (\d+):(\d+)/i', '', $_POST['title']);
} else {
$_POST['title'] = preg_replace('/(\d+):(\d+) - '.$ag_no_end_time.'/i', '', $_POST['title']);
}

$_POST['title'] = preg_replace($ag_pattern_time, ' ', $_POST['title']); 

$_POST['title'] = $_POST[$name][0].' - '.$_POST[$name][1]. ' '.$_POST['title']; 
$_POST['title'] = preg_replace('/[\s]{2,}/', ' ', $_POST['title']);
}
}
//periods 

}// isset post name
}// isset name 
}// foreach ag_values_db



if (isset($ag_ERROR)) {

unset($_POST['ag_replace']);	

} else { //-------- ERRORS
$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url.'#'.$_POST['ag_replace']);
}
}// isset post ag_replace
}// get id

//=================================== ON/OFF
if(isset($_POST['id_on_off']) && isset($_POST['status'])) { 

if (is_array($_POST['id_on_off'])) {} else {$_POST['id_on_off'] = array($_POST['id_on_off']);}

if ($ag_this_access != '1') {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access

foreach ($_POST['id_on_off'] as $id_on_off) {

if (file_exists($ag_file_name)) {
if (filesize($ag_file_name) != 0) {

$ag_lines = array();

$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));		
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);


$ag_edit_id = htmlspecialchars($id_on_off, ENT_QUOTES, 'UTF-8');

if ($ag_edit_id == $ag_user_id) { $ag_ERROR['access_self_off'] = $ag_lng['self_off']; } //user self on/off!

// check ID as number line
foreach ($ag_lines as $n => $line) {
$line_arr = explode($ag_separator[0], $line);	
foreach ($line_arr as $values) {
$values	= explode($ag_separator[1], $values);	

if (isset($values[0]) && isset($values[1]) && $values[0] == 'id') { if ($values[1] == $ag_edit_id) {
	$ag_edit_line = $n; 
	$ag_line_data = $line;

//check login && pass
$ag_login_str = 'login'.$ag_separator[1].$ag_separator[0];
$ag_pass_str = 'pass'.$ag_separator[1].$ag_separator[0];
$ag_alias_str = 'alias'.$ag_separator[1].$ag_separator[0];

if (strpos($line, $ag_login_str) === false) { } else { $ag_ERROR['empty_login'] = $ag_lng['error_empty_login']; }	
if (strpos($line, $ag_pass_str) === false) { } else { $ag_ERROR['empty_pass'] = $ag_lng['error_empty_pass']; }	
if (strpos($line, $ag_alias_str) === false) { } else { $ag_ERROR['empty_title'] = $ag_lng['error_new_title']; }	


//check login && pass	
	
if ($_POST['status'] == 'off') { // status 0
	
	$ag_line_data = str_replace('status'.$ag_separator[1].'1'.$ag_separator[0], 'status'.$ag_separator[1].'0'.$ag_separator[0], $line);
	
} else { // status 1
	//$values
    $st_str = 'status'.$ag_separator[1].'0';
	if (strpos($line, $st_str) === false) { 
	$ag_line_data = str_replace('status'.$ag_separator[1].$ag_separator[0], 'status'.$ag_separator[1].'1'.$ag_separator[0], $line);	
	} else {
	$ag_line_data = str_replace('status'.$ag_separator[1].'0'.$ag_separator[0], 'status'.$ag_separator[1].'1'.$ag_separator[0], $line);	
	}
	
}// status 1	
	
	} } 

	
}
}
//found line
$found_line_arr = explode($ag_separator[0], $ag_line_data);
foreach ($found_line_arr as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == '1') { // admin no edit other admins	
if ($ag_this_id != $ag_user_id && $ag_user_access != 'founder') { $ag_ERROR['access'] = $ag_lng['access_denied']; }
} // admin no edit other admins	

if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == 'founder') { 
unset($ag_edit_line); $ag_ERROR['access_admin_off'] = $ag_lng['admin_off']; } //founder off!	
}


}// file != 0
} else { $ag_ERROR['file_exists'] = $ag_lng['error_file_exists']. '&nbsp;-&nbsp;' .$ag_file_name; } // file_exists	


//replace
if (isset($ag_edit_line) && isset($ag_line_data) && !empty($ag_line_data) && !isset($ag_ERROR)) { 

$ag_contents = file_get_contents($ag_file_name);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$ag_edit_line])) {
$ag_contents[$ag_edit_line] = $ag_line_data;
if (is_writable($ag_file_name)) {
	
   if (!$ag_handle = fopen($ag_file_name, 'wb')) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. '&nbsp;-&nbsp;' .$ag_file_name; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. '&nbsp;-&nbsp;' .$ag_file_name; }
   fclose($ag_handle);
    
}
}
}//--replace done

}// foreach $_POST['id']
unset($_POST['id_on_off']);


if (isset($ag_ERROR)) {
$error_mess_str = '';
foreach ($ag_ERROR as $error_mess) {
$error_mess_str .= '<li>' .$error_mess. '</li>';
}
$ag_view_errors = '<script>ag_dialog("3000", "<ul>' .$error_mess_str. '</ul>", "'.$ag_lng['abort'].'", "quick_mess", "icon-roadblock ag_str_red", "");</script>';	
} else { //-------- ERRORS
$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url); 
}// no errors


}// isset $_POST['id'] & status




//=================================== MOVES LINES 
if (isset($_POST['moves']) && isset($_POST['where'])) { 
if ($_POST['moves'] != '') {

if ($ag_this_access != '1') {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access


// check ID as number line
if (file_exists($ag_file_name)) {
if (filesize($ag_file_name) != 0) {
$ag_lines = array();
	
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));		
	
	
$ag_edit_id = htmlspecialchars($_POST['moves'], ENT_QUOTES, 'UTF-8');
// check ID as number line
foreach ($ag_lines as $n => $line) {
$line_arr = explode($ag_separator[0], $line);	
foreach ($line_arr as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'id') { if ($values[1] == $ag_edit_id) { $ag_moove_line = $n; $ag_line_data = $line; } } 
}
}
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);
}// file != 0

} else { $ag_ERROR['file_exists'] = $ag_lng['error_file_exists']. '&nbsp;-&nbsp;' .$ag_file_name; } // file_exists



// delete progress
$ag_fp = fopen($ag_file_name, "a+");
flock ($ag_fp,LOCK_EX); 
$lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));	
for ($i = 0; $i < sizeof($lines); $i++) {
 if (empty($lines[$i]) || strpos($lines[$i], $ag_separator[0]) === false) {
    if (isSet($lines[(integer) $i]) == true) {   
        unset($lines[(integer) $i]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode('\n', $lines))); 
    }  
  } 
} 
fflush ($ag_fp);
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);

if (isset($ag_moove_line)) {
$move1 = $ag_moove_line; 
if($_POST['where'] == 'up') { $where = 1; }
else { $where = 0; }
}


if (isset($move1) && isset($where)){

if ($where == '0') { $where = '-1'; }
$move2 = $move1 - $where;

if ($move1 < 0) {$move1 = 0;}
if ($move2 < 0) {$move2 = 0;}

$file = file($ag_file_name);
$imax = sizeof($file);
	
//founder moove!
if (isset($file[$move1])) {
$found_line_arr1 = explode($ag_separator[0], $file[$move1]);
foreach ($found_line_arr1 as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == 'founder') { 
$ag_ERROR['access_admin_moove'] = $ag_lng['error_admin_moove']; } //founder moove!	
}
}
if (isset($file[$move2])) {
$found_line_arr2 = explode($ag_separator[0], $file[$move2]);
foreach ($found_line_arr2 as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == 'founder') { 
$ag_ERROR['access_admin_moove'] = $ag_lng['error_admin_moove']; } //founder moove!	
}
}		
//founder moove!	

if ($move2 >= $imax || $move2 < '0' || isset($ag_ERROR)) {
	


} else { // no error moove


$ag_rn = chr(13).chr(10);

if (isset($file[$move1]) && isset($file[$move2])) {

$data1 = $file[$move1];
$data2 = $file[$move2];

if ($move1 == $imax - 1) { // last up!!!
$data1 = $file[$move1]; 
$data2 = $ag_rn.$file[$move2];
} 

if ($move2 == $imax - 1) { // last-1 down!!!
$data1 = $ag_rn.$file[$move1]; 
$data2 = $file[$move2];
}

$ag_fp = fopen($ag_file_name, "r+"); 
flock ($ag_fp,LOCK_EX); 
ftruncate($ag_fp, 0); // Delet data in file 


// change position
for ($i = 0; $i < $imax; $i++) {

if ($move1 == $i) { fputs($ag_fp, $data2); } 

else if ($move2 == $i) { fputs($ag_fp, $data1); }

else { fputs($ag_fp, $file[$i]); } 

}

}// isset data move 

}// no error
}// isset moove1 && where

unset($_POST['moves']);

if (isset($ag_ERROR)) {
	
$error_mess_str = '';
foreach ($ag_ERROR as $error_mess) {
$error_mess_str .= '<li>' .$error_mess. '</li>';
}
$ag_view_errors = '<script>ag_dialog("3000", "<ul>' .$error_mess_str. '</ul>", "'.$ag_lng['abort'].'", "quick_mess", "icon-roadblock ag_str_red", "");</script>';	

} else { //-------- ERRORS


$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url.'&clear_lines');

}// no errors

}// $_POST['moves'] != ''
}// isset posst mooves


// clear empty line
if (isset($_GET['clear_lines'])) {
if (file_exists($ag_file_name)) {
if (filesize($ag_file_name) != 0) {
$ag_lines = array();

$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));	
$ag_br = "\n";

for ($i = 0; $i < sizeof($ag_lines); $i++) {
 if (empty($ag_lines[$i]) || strpos($ag_lines[$i], $ag_separator[0]) === false) { 
    if (isSet($ag_lines[(integer) $i]) == true) {   
        unset($ag_lines[(integer) $i]); 
        fseek($ag_fp, 0);
        ftruncate($ag_fp, fwrite($ag_fp, implode($ag_br, $ag_lines)));	
    }  
  } 
} 
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);

$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
header("Location: ".$srv_script_absolute_url.$ag_tab_url.$ag_id_url);

}// file != 0
}// file_exists
}//clear empty line









//config
$ag_disalow_get = array('/', '\\', '*', '(', ')', '?', '|', '+', '$', '.', ';', '"', "'", ',', ':', '&', '#', '%', '№', '!', '@', '^', '>', '<', '`', '~', ' ');
if (isset($_POST['ag_replace_settings'])) {
	
if ($ag_user_access != 1 && $ag_user_access != 'founder') {  $ag_ERROR['access'] = $ag_lng['access_denied']; }

	
$data_rep_config = '<?php'."\n";
	
foreach ($ag_config_array as $conf_name => $conf_val) {

if (!isset($_POST['ag_cfg_home_widgets'])) {$_POST['ag_cfg_home_widgets'] = '';}
if (!isset($_POST['ag_cfg_footer_widgets'])) {$_POST['ag_cfg_footer_widgets'] = '';}

if (isset($_POST[$conf_name])) {

if(is_array($_POST[$conf_name])) {
	
	
//array => array
foreach ($_POST[$conf_name] as $pn => $ag_paa) {
if (is_array($ag_paa)) { 
$ag_paa = array_diff($ag_paa, array(''));
$ag_paa = array_diff($ag_paa, array('---'));
$ag_paa = array_unique($ag_paa);
$ag_paa_r = array();
foreach ($ag_paa as $pna => $paa) { $paa = str_replace('::', '', trim($paa)); $ag_paa_r[$pna] = $paa;}
$_POST[$conf_name][$pn] = implode('::', $ag_paa_r); 
}
}	
	

$_POST[$conf_name] = array_diff($_POST[$conf_name], array(''));
$_POST[$conf_name] = array_diff($_POST[$conf_name], array('---'));

$_POST[$conf_name] = array_unique($_POST[$conf_name]);		
$_POST[$conf_name] = implode($ag_separator[2], $_POST[$conf_name]); 

$_POST[$conf_name] = htmlspecialchars($_POST[$conf_name], ENT_QUOTES, 'UTF-8');
$_POST[$conf_name] = str_replace(array($ag_separator[0], $ag_separator[1]), '', trim($_POST[$conf_name])); //separator
$_POST[$conf_name] = str_replace($ag_data_upload_dir, '', trim($_POST[$conf_name])); //upload dir
$_POST[$conf_name] = preg_replace('/\\\\+/', '', $_POST[$conf_name]); 
$_POST[$conf_name] = preg_replace("|[\r\n]+|", " ", $_POST[$conf_name]); 
$_POST[$conf_name] = preg_replace("|[\n]+|", " ", $_POST[$conf_name]);


} else { // poost array

if ($conf_name == 'ag_get_cat' || $conf_name == 'ag_get_obj' || $conf_name == 'ag_get_page' || $conf_name == 'ag_get_search') {
if (isset ($_POST[$conf_name])) { $_POST[$conf_name] = str_replace($ag_disalow_get, '', trim($_POST[$conf_name])); }  	
}

if ($conf_name == 'ag_cfg_home_content') { $_POST[$conf_name] = str_replace('../', '[site_url]', $_POST[$conf_name]); }

$_POST[$conf_name] = htmlspecialchars($_POST[$conf_name], ENT_QUOTES, 'UTF-8');

if ($conf_name == 'ag_cfg_home_content_js' || $conf_name == 'ag_cfg_footer_code' || $conf_name == 'ag_cfg_header_code') {
$_POST[$conf_name] = str_replace('=', '::exactly::', trim($_POST[$conf_name]));
}


$_POST[$conf_name] = str_replace($ag_data_upload_dir, '', trim($_POST[$conf_name])); //upload dir

$_POST[$conf_name] = str_replace($ag_separator, '', trim($_POST[$conf_name])); //separator

foreach ($ag_separator as $ag_separators_str) {
if (isset($ag_separators_str[0]) && isset($ag_separators_str[1]) && isset($ag_separators_str[2])) {
$_POST[$conf_name] = str_replace($ag_separators_str[0].$ag_separators_str[1], '', trim($_POST[$conf_name])); //separator fragment 1	
$_POST[$conf_name] = str_replace($ag_separators_str[1].$ag_separators_str[2], '', trim($_POST[$conf_name])); //separator fragment 2	
}
}	

$_POST[$conf_name] = preg_replace('/\\\\+/', '', $_POST[$conf_name]); 
$_POST[$conf_name] = preg_replace("|[\r\n]+|", $ag_separator[3], $_POST[$conf_name]); 
$_POST[$conf_name] = preg_replace("|[\n]+|", $ag_separator[3], $_POST[$conf_name]);		


if ($conf_name == 'ag_cfg_theme') { if (empty($_POST[$conf_name])) { $_POST[$conf_name] = $ag_themes_dir.'/' .$ag_themes_defailt. '/'; } }


}// poost no array


$data_rep_config .= '$' .$conf_name. ' = "' .$_POST[$conf_name]. '";'."\n";
}// isset post conf_name




}// foreach ag_config_array
$data_rep_config .= '?>';


if (!isset($ag_ERROR)) {
$config_file_create = fopen($ag_data_dir.'/'.$ag_config, "w"); // create data file
fwrite($config_file_create, "$data_rep_config");
fclose ($config_file_create);
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
$ag_this_ctab = '';
if (isset($_GET['cfgtab'])) {$ag_this_ctab = '&cfgtab='.$_GET['cfgtab'];}
header("Location: ".$srv_script_absolute_url.'?settings'.$ag_this_ctab.'#done_settings');
} else {

}
unset($_POST['ag_replace_settings']);
}// post ag_replace_settings
?>