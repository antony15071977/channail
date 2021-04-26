<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


$ag_db_dir_s = array();
foreach ($ag_db_dir as $ks => $vs) {$ag_db_dir_s[$ks] = $vs.'s';} //'s


if (empty($ag_home)) {
if (isset($_GET['iframe']) || isset($_GET['common_search'])) { } else {
echo '<div class="ag_top_tools" id="ag_top_tools">';
if (!isset($_GET['id'])) {
echo '<div><a href="' .$ag_tab_url. '&amp;add" class="ag_btn_big" id="ag_add_btn_top"><i class="icon-plus"></i><span>' .$ag_lng['add']. '</span></a></div>';
} else {
	

echo '<div>
<span class="ag_btn_big" id="ag_add_btn_top" tabindex="-1" onclick="ag_add_item()"><i class="icon-plus"></i><span>' .$ag_lng['add']. '</span></span>
<span class="ag_btn_big ag_right" id="ag_save_btn_top" tabindex="-1" onclick="ag_save_item()"><i class="icon-floppy-1"></i><span>' .$ag_lng['save']. '</span></span>
</div>';	


}

} // iframe

$ag_disalow_insearch = array('/', '\\', '*', '(', ')', '?', '|', '+', '$', '&', '=');


//////////////////////////////////////////////////////
if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
} else {
$ag_lng['error_php_version'] = str_replace('%s', phpversion(), $ag_lng['error_php_version']);
$ag_WARING['php_version'] = $ag_lng['error_php_version'];
}
echo '<div class="ag_scroll_top"></div>';
echo '</div>';
} else { echo '<div class="ag_no_top_tools" id="ag_top_tools"><div class="ag_scroll_top"></div></div>'; } // no empty ag_data


if (isset($_GET['iframe'])) { 
echo '<div class="ag_edit_block ag_edit_block_iframe" id="ag_edit_block">';
} else {
echo '<div class="ag_edit_block" id="ag_edit_block">';
} // iframe

echo '<div class="ag_edit_block_inner">';



//-------------------------FILTERS
if (isset($_GET['filter']) && isset($_GET['filter_query'])) {

$ag_filter_db = $_GET['filter'];
$ag_filter_db = htmlspecialchars($ag_filter_db, ENT_QUOTES, 'UTF-8');

$ag_filter_query = $_GET['filter_query'];
$ag_filter_query = htmlspecialchars($ag_filter_query, ENT_QUOTES, 'UTF-8');
$ag_filter_query = mb_strtolower($ag_filter_query, 'utf8');
$ag_filter_query = str_replace($ag_disalow_insearch, '', $ag_filter_query);


}// get filter


echo '<div class="ag_filters_block" id="ag_filters_block">';
$names_db_arr = array();
if (!isset($_GET['iframe'])) {
foreach ($ag_data as $nf => $valf) { 

$idb_name = '';
$idb_id = '';
$idb_names = '';
$idb_ids = '';
$ag_filter_query_name = '';

foreach ($ag_db as $names_db => $index) {
	if ( in_array($names_db, array_keys($valf))) { // one
	$names_db_arr[$names_db] = $names_db;
	}
	if ( in_array($names_db.'s', array_keys($valf))) { // multi
	$names_db_arr[$names_db.'s'] = $names_db;
	}
	if ( in_array('staffs_appoint', array_keys($valf)) ) { // staffs appoint
	$names_db_arr['staffs_appoint'] = 'staffs_appoint';
	}
}

}

if (!empty($names_db_arr)) {
$names_db_arr = array_unique($names_db_arr);
$ag_count_filters = 0;
$ag_count_filters_width = 0;
$ag_include_db = array();

foreach ($names_db_arr as $names_db) { $ag_count_filters_width++; }

foreach ($names_db_arr as $names_db) { $ag_count_filters++;

if (!in_array($names_db, $ag_db_dir) && !in_array($names_db, $ag_db_dir_s)) {
if ($names_db == 'staffs_appoint') {$ag_include_db = ag_read_data($ag_data_dir.'/'.$ag_staff_db.$agt);} // staffs appoint
else {$ag_include_db = ag_read_data($ag_data_dir.'/'.$names_db.$agt);}
if ($names_db == 'widget') {$ag_include_db = array_merge($ag_include_db, $ag_inc_widgets); }


} else {
	

$ag_include_db = array();
if (in_array($names_db, $ag_db_dir)) {

$optd = array();
$db_ddata = array();
$db_nd = array_search($names_db, $ag_db_dir);	
$db_ddata = ag_read_data($ag_data_dir.'/'.$db_nd.$agt);
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
$dird = $names_db;
if (!empty($catd_id)) { $optd = ag_read_data($ag_data_dir.'/'.$dird.'/'.$catd_id.$agt); }
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
$ag_include_db[$catd_id.$obd_id] = array('id' => $catd_id.'::'.$obd_id, 'name' => $catd_name.' - '.$obd_name, 'status' => $obd_status);

}// foreach optd
}//foreach db_ddata

	
}
	
}// dir db all

$ag_name_filter = $names_db;
if (isset($ag_lng[$names_db.'s'])) {$ag_name_filter = $ag_lng[$names_db.'s'];}

$filters_width = '';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
$filters_width = '100%';
} else {
if ($ag_count_filters_width == 1) {$filters_width = '100%';}
if ($ag_count_filters_width == 2) {$filters_width = '50%';}
if ($ag_count_filters_width == 3) {$filters_width = '33.3%';}
if ($ag_count_filters_width > 3) {$filters_width = '50%';}
}

echo '<div class="ag_filter" id="ag_filter_'.$names_db.'_'.$ag_count_filters.'" style="width:' .$filters_width. ';">';
echo '<div class="ag_filter_inner" tabindex="-1" onfocus="ag_filter_select_view(\'ag_filter_'.$names_db.'_'.$ag_count_filters.'\', \''.$ag_count_filters.'\')" onblur="ag_filter_select_hidden(\'ag_filter_'.$names_db.'_'.$ag_count_filters.'\')">';
echo '<div class="ag_filter_name" id="ag_filter_name_'.$names_db.'_'.$ag_count_filters.'"><span>'.$ag_name_filter.'</span></div>';
echo '<div class="ag_filter_list ag_search_list">';	

//search in list
if (sizeof($ag_include_db) > 16) {
echo '<div class="ag_search_in_list" id="ag_search_list_filter_' .$ag_count_filters. '"><div>
<input type="text" id="ag_search_inp_filter_' .$ag_count_filters. '" placeholder="'.$ag_lng['list_search'].'" />
<span id="agt_search_filter_' .$ag_count_filters. '" onclick="ag_search_in_list(\'ag_search_inp_filter_' .$ag_count_filters. '\', \'options_filter_' .$ag_count_filters. '\', \'ag_content_search_list_filter_' .$ag_count_filters. '\', \'agt_search_filter_' .$ag_count_filters. '\', \'agt_search_next_filter_' .$ag_count_filters. '\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_filter_' .$ag_count_filters. '" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
<span id="reset_search_filter_' .$ag_count_filters. '"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div></div>'; //search in list
}
	
echo '<ul id="ag_content_search_list_filter_' .$ag_count_filters. '">';

foreach ($ag_include_db as $ival) {
if (isset($ival['id'])) {$idb_id = $ival['id'];}
if (isset($ival['name'])) {$idb_name = $ival['name'];}
if (isset($ival['title'])) {$idb_name = $ival['title'];}



if (isset($ag_filter_query) && $idb_id == $ag_filter_query) {$ag_filter_query_name = $idb_name;}

$ag_li_filter_class = '';
if (isset($_GET['filter_query']) && $_GET['filter_query'] == $idb_id) {
echo '<script>$("#ag_filter_name_'.$names_db.'_'.$ag_count_filters.' span").text("'.$idb_name.'");</script>';
$ag_li_filter_class = ' ag_this_filter';
}

if ($names_db == $ag_staff_db) {
if (isset($ival['access']) && isset($ival['status']) && $ival['access'] != 1 && $ival['access'] != 'founder') {
echo '<li class="ag_f_sel'.$ag_li_filter_class.'" onclick="ag_filter(\'ag_filter_name_'.$names_db.'_'.$ag_count_filters.'\', \''.$idb_id.'\', \''.$idb_name.'\', \''.$names_db.'\')" tabindex="-1">'.$idb_name.'</li>';	
} 

} else {
	
echo '<li class="ag_f_sel'.$ag_li_filter_class.'" onclick="ag_filter(\'ag_filter_name_'.$names_db.'_'.$ag_count_filters.'\', \''.$idb_id.'\', \''.$idb_name.'\', \''.$names_db.'\')" tabindex="-1">'.$idb_name.'</li>';
}

}

echo '</ul>';
echo '</div>'; //ag_filter_list
echo '<span class="ag_filter_icon"><i class="icon-filter-1"></i></span>';
echo '</div>';
echo '</div>';
}
}// no empty names_db_arr




}// get iframe
echo '<div class="clear"></div>';
echo '</div>';

//-------------------------FILTERS RESULT 



if (isset($ag_filter_query) && isset($ag_filter_db)) {
	
echo '<div id="ag_found_info"></div>';
	
echo '<div id="ag_coomon_search_result">';	

echo '<ul>';

$ag_search_name = '';
$ag_count_found_cs = 0;
$ag_filter_arr = array();


foreach ($ag_data as $ag_sear_val) {


if (isset($ag_sear_val[$ag_filter_db.'s'])) { $ag_sear_str = $ag_sear_val[$ag_filter_db.'s']; }

if (isset($ag_sear_val['name'])) {$ag_search_name = $ag_sear_val['name'];}	
else if (isset($ag_sear_val['title'])) {$ag_search_name = $ag_sear_val['title'];}	


if (isset($ag_sear_val[$ag_filter_db])) { 

$ag_sear_val_arr_one = array();
if (strpos($ag_sear_val[$ag_filter_db], $ag_separator[2]) === false) {} else {
$ag_sear_val_arr_one = explode($ag_separator[2], $ag_sear_val[$ag_filter_db]);}

if ($ag_filter_query == $ag_sear_val[$ag_filter_db] || !empty($ag_sear_val_arr_one) && in_array($ag_filter_query, $ag_sear_val_arr_one)) { $ag_count_found_cs ++; 
if (isset($ag_sear_val['id'])) { 

echo '<li id="' .$ag_sear_val['id']. '">';
echo '<a href="#" onclick="ag_open_ifm(\'' .$ag_sear_val['id']. '\', \'' .$ag_this_cat. '\', \'ag_item\')">' .$ag_search_name. '</a>';

if ($ag_this_access == 1) {
echo '<a href="#" class="ag_search_delete" title="' .$ag_lng['delete']. '" onclick="ag_dialog(\''.$ag_sear_val['id'].'\', \'' .$ag_search_name. '\', \''.$ag_lng['confirm_delete'].'!\', \'ag_delete_item\', \'icon-attention ag_str_orange\', \'button2\')"><i class="icon-cancel-2"></i></a>';
}

echo '</li>'; 
}	
}
} // one


if (isset($ag_sear_val[$ag_filter_db.'s'])) { 
$ag_filter_arr = explode($ag_separator[2], $ag_sear_val[$ag_filter_db.'s']);

foreach ($ag_filter_arr as $mid) {
if ($ag_filter_query == $mid) { $ag_count_found_cs ++; 
if (isset($ag_sear_val['id'])) { 
echo '<li id="' .$ag_sear_val['id']. '">';
echo '<a href="#" onclick="ag_open_ifm(\'' .$ag_sear_val['id']. '\', \'' .$ag_this_cat. '\', \'ag_item\')">' .$ag_search_name. '</a>';

if ($ag_this_access == 1) {
echo '<a href="#" class="ag_search_delete" title="' .$ag_lng['delete']. '" onclick="ag_dialog(\''.$ag_sear_val['id'].'\', \'' .$ag_search_name. '\', \''.$ag_lng['confirm_delete'].'!\', \'ag_delete_item\', \'icon-attention ag_str_orange\', \'button2\')"><i class="icon-cancel-2"></i></a>';
}

echo '</li>'; 
}	
}
}

} // multi


}// foreach ag_data
	


if ($ag_count_found_cs == 0) {
	$ag_lng['filter_not_found'] = str_replace('%s', '<strong>&quot;'.$ag_filter_query_name.'&quot;</strong>', $ag_lng['filter_not_found']);
	echo '<li class="ag_not_found"><span>'.$ag_lng['filter_not_found'].'</span></li>';
} else {
	$ag_lng['filter_found'] = str_replace('%s', '<span>&quot;'.$ag_filter_query_name.'&quot;</span>', $ag_lng['filter_found']);
	echo '<script>$("#ag_found_info").html("<div>'.$ag_lng['filter_found'].': <strong>'.$ag_count_found_cs.'</strong></div>");</script>';
}

echo '</ul>';
echo '</div>';	
} //isset ag_filter_query



//-------------------------FILTERS 







// common search
if (isset($_GET['common_search'])) {
if (isset($_POST['common_search_query'])) {
$_POST['common_search_query'] = htmlspecialchars($_POST['common_search_query'], ENT_QUOTES, 'UTF-8');
$_POST['common_search_query'] = mb_strtolower($_POST['common_search_query'], 'utf8');
$_POST['common_search_query'] = str_replace($ag_disalow_insearch, '', $_POST['common_search_query']);


echo '<div id="ag_found_info" class="ag_search_found_info"></div>';

echo '<div id="ag_coomon_search_result">';	
echo '<ul>';

if (!empty($_POST['common_search_query']) && iconv_strlen($_POST['common_search_query'], 'UTF-8') > 2) {
$ag_search_name = '';
$ag_count_found_cs = 0;

$ag_list_db = ag_file_list($ag_data_dir, $agt);


foreach($ag_list_db as $ag_file_db) {
$ag_search_db = ag_read_data($ag_file_db['name']);
foreach ($ag_search_db as $ag_sear_val) {
if (isset($ag_sear_val['name'])) {$ag_search_name = $ag_sear_val['name'];}	
else if (isset($ag_sear_val['title'])) {$ag_search_name = $ag_sear_val['title'];}

$ag_match_name = mb_strtolower($ag_search_name, 'utf8');

if (preg_match('/'.$_POST['common_search_query'].'/i', $ag_match_name)) { $ag_count_found_cs ++; // found search


if (isset($ag_sear_val['id'])) { 
$ag_del_sear_dir = '';
$ag_del_dir_arr = explode('_', $ag_sear_val['id']);
if (isset($ag_del_dir_arr[0])) {$ag_del_sear_dir = $ag_del_dir_arr[0];}
echo '<li id="' .$ag_sear_val['id'].$ag_count_found_cs. '">';
echo '<a href="#" onclick="ag_open_ifm(\'' .$ag_sear_val['id']. '\', \'\', \'ag_item\')">' .$ag_search_name. '</a>';

if ($ag_this_access == 1) {
echo '<a href="#" class="ag_search_delete" title="'.$ag_lng['delete'].'" onclick="ag_delete_search_item(\'' .$ag_sear_val['id'].'\', \'' .$ag_del_sear_dir. '\', \'\', \'' .$ag_count_found_cs.'\', \'' .$ag_search_name.'\')"><i class="icon-cancel-2"></i></a>';
}

echo '</li>'; 
}	
}


}// foreach ag_search_db

}// foreach ag_list_db


//search in db dir
$ag_set_user_access_arr = array();
foreach ($ag_db_dir as $sear_tab => $sear_dir) {
if (file_exists($ag_data_dir.'/'.$sear_dir)) {
$ag_list_dir_db = ag_file_list($ag_data_dir.'/'.$sear_dir, $agt);


foreach($ag_list_dir_db as $ag_file_db) {
$ag_search_db = ag_read_data($ag_file_db['name']);
$ag_file_db['name'] = str_replace(array($ag_data_dir.'/'.$sear_dir, '/', $agt), '', $ag_file_db['name']);

foreach ($ag_search_db as $ag_sear_val) {
if (isset($ag_sear_val['name'])) {$ag_search_name = $ag_sear_val['name'];}	
else if (isset($ag_sear_val['title'])) {$ag_search_name = $ag_sear_val['title'];}


$ag_match_name = mb_strtolower($ag_search_name, 'utf8');

if (preg_match('/'.$_POST['common_search_query'].'/i', $ag_match_name)) { $ag_count_found_cs ++; // found search

$ag_cat_name = $ag_lng['no_value'];
$ag_cat_found_id = '';
$ag_search_dir_db = ag_read_data($ag_data_dir.'/'.$sear_tab.$agt); // dir item names
foreach ($ag_search_dir_db as $sdn) {
if (isset($sdn['id']) && $sdn['id'] == $ag_file_db['name']) {
$ag_cat_found_id = $sdn['id'];
if (isset($sdn['name'])) {$ag_cat_name = $sdn['name'];}	
if (isset($sdn['title'])) {$ag_cat_name = $sdn['title'];}

//access
if (isset($sdn[$ag_staff_db.'s'])) {
$ag_set_user_access_arr = explode($ag_separator[2], $sdn[$ag_staff_db.'s']);	
}
//access

$ag_cat_tab_name = $sear_tab;
if (isset($ag_lng[$sear_tab])) {$ag_cat_tab_name = $ag_lng[$sear_tab];}

if (isset($ag_sear_val['id'])) { 
echo '<li class="ag_child_found" id="' .$ag_sear_val['id'].$ag_count_found_cs. '">
<a href="#" onclick="ag_open_ifm(\'' .$ag_sear_val['id'].'\', \''.$ag_file_db['name'].'\', \'ag_item\')">' .$ag_search_name. '</a> 
<div>('.$ag_cat_tab_name.': <a href="#" onclick="ag_open_ifm(\'' .$ag_cat_found_id.'\', \'\', \'ag_item\')">'.$ag_cat_name.'</a>)</div>
<div class="clear"></div>';

if (!empty($ag_set_user_access_arr) && in_array($ag_user_id, $ag_set_user_access_arr) && $ag_this_access != 1) {
echo '<a href="#" class="ag_search_delete" title="'.$ag_lng['delete'].'" onclick="ag_delete_search_item(\'' .$ag_sear_val['id'].'\', \'' .$sear_dir.'\', \'' .$ag_file_db['name'].'\', \'' .$ag_count_found_cs.'\', \'' .$ag_search_name.' ('.$ag_cat_tab_name.': ' .$ag_cat_name. ')\')"><i class="icon-cancel-2"></i></a>';	
} 
if ($ag_this_access == 1) {
echo '<a href="#" class="ag_search_delete" title="'.$ag_lng['delete'].'" onclick="ag_delete_search_item(\'' .$ag_sear_val['id'].'\', \'' .$sear_dir.'\', \'' .$ag_file_db['name'].'\', \'' .$ag_count_found_cs.'\', \'' .$ag_search_name.' ('.$ag_cat_tab_name.': ' .$ag_cat_name. ')\')"><i class="icon-cancel-2"></i></a>';
}

echo '</li>'; 
}	

}// id == id
}// foreach ag_search_dir_db
}// preg_match

}// foreach ag_search_db

}// foreach ag_list_db


}// file_exists dir
}// foreach ag_db_dir
//search in db dir

if ($ag_count_found_cs == 0) {
	$ag_lng['not_found'] = str_replace('%s', '<strong>&quot;' .$_POST['common_search_query']. '&quot;</strong>', $ag_lng['not_found']);
	echo '<li class="ag_not_found"><span>'.$ag_lng['not_found'].'</span></li>';
	} else {
	$ag_lng['search_found'] = str_replace('%s', '<span>&quot;'.$_POST['common_search_query'].'&quot;</span>', $ag_lng['search_found']);
	echo '<script>$("#ag_found_info").html("<div>'.$ag_lng['search_found'].': <strong>'.$ag_count_found_cs.'</strong></div>");</script>';
	}

} else { echo '<li class="ag_err_query"><span>'.$ag_lng['empty_query'].'</span></li>'; }

echo '</ul>';
echo '</div>';	
} else { // post query
echo '<div id="ag_found_info" class="ag_search_found_info"></div>';
echo '<div id="ag_coomon_search_result">';	
echo '<ul>'; 
echo '<li class="ag_err_query"><span>'.$ag_lng['empty_query'].'</span></li>';
echo '</ul>';
echo '</div>';	} // not post query

}// get common_search
// common search



// home--------------------------
echo $ag_first_page;
// home--------------------------



$ag_title_element = '';
$ag_count = 0;
$ag_option = array();	


foreach ($ag_data as $n => $val) { 
if (isset($_GET['id']) && isset($val['id']) && $_GET['id'] == $val['id']) { $ag_found_item = 1;


$ag_id_url = str_replace('&amp;', '&', $ag_id_url);
$ag_tab_url = str_replace('&amp;', '&', $ag_tab_url);
echo '<form name="ag_edit" method="post" action="'.$srv_script_absolute_url.$ag_tab_url.$ag_id_url.'#'.$ag_this_id.'">';


$ag_type_found = 0;
foreach ($ag_values_db as $name) { $ag_count++;
$ag_type_found = 0;
if (isset($val[$name])){ $value = $val[$name]; } else {$value = '';}
foreach ($ag_name_type as $names => $types) { 
if ($names == $name) { $type = $types; $ag_type_found = 1;} 
}
if ($ag_type_found == 0) {$type = 'unknown';}

$ag_title_element = $name;

if (isset($ag_lng[$name])) {$ag_title_element = $ag_lng[$name];}
if ($name == $ag_staff_db.'s') {$ag_title_element = $ag_lng['staffs_acess'];}

if (strpos($ag_title_element, ' (?) ') === false) {
$ag_title_element = '<span>'.$ag_title_element.':</span>';
} else {
$ag_title_element_arr = explode(' (?) ', $ag_title_element);
if (isset($ag_title_element_arr[0]) && isset($ag_title_element_arr[1])) {
$ag_title_element = '<span class="ag_help ag_this_title" tabindex="-1"><i class="icon-help-circled"></i>' .$ag_title_element_arr[0]. ':<span class="ag_title ag_help_element">' .$ag_title_element_arr[1]. '</span></span>';	
}
}

if ($type != 'hidden') {
	
$ag_element_class = '';
if ($name == 'status') {$ag_element_class = ' ag_status_item';}

echo '<div class="ag_edit_form' .$ag_element_class. '">';
echo '<div class="ag_title_element"><div>' .$ag_title_element. '</div></div>';

echo '<div class="ag_elements_area">';




$ag_class_element = '';
//db connect

$db_connect = array();
foreach ($ag_db as $name_db => $inputs_arr) {
	if ($name == $name_db && !in_array($name, $ag_db_dir) && !in_array($name, $ag_db_dir_s)) {
	$db_connect = ag_read_data($ag_data_dir.'/'.$name_db.$agt);
	$ag_option = $db_connect;
	$type = 'selectlink';
	} else if ($name == $name_db.'s' && !in_array($name, $ag_db_dir) && !in_array($name, $ag_db_dir_s)) {
	$db_connect = ag_read_data($ag_data_dir.'/'.$name_db.$agt);
	$ag_option = $db_connect;
    $type = 'multiselectlink';	
	} 
	//staffs appoint
	else if ($name == 'staffs_appoint') {
	$db_connect = ag_read_data($ag_data_dir.'/'.$ag_staff_db.$agt);
	$ag_option = $db_connect;
    $type = 'multiselectlink';	
	} 
}


if ($name == $ag_staff_db.'s') {
	$ag_option = array();
	$db_connect = ag_read_data($ag_data_dir.'/'.$ag_staff_db.$agt);
	foreach ($db_connect as $nsu => $set_user) {
	if (isset($set_user['access']) && $set_user['access'] == 3 && isset($set_user['status']) && $set_user['status'] == 1) { 
	$ag_option[$nsu] = $set_user; // only users & active
	}
	}
	$type = 'multiselectlink';
	}

//$ag_db_dir
if (in_array($name, $ag_db_dir_s)) {
$ag_option = array();
$optd = array();
$db_ddata = array();
$db_nd = array_search($name, $ag_db_dir_s);	
$db_ddata = ag_read_data($ag_data_dir.'/'.$db_nd.$agt);
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
$dird = substr($name,0,-1);
if (!empty($catd_id)) { $optd = ag_read_data($ag_data_dir.'/'.$dird.'/'.$catd_id.$agt); }
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
$ag_option[$catd_id.$obd_id] = array('id' => $catd_id.'::'.$obd_id, 'name' => $catd_name.' - '.$obd_name, 'status' => $obd_status);

}// foreach optd
}// foreach db_ddata


$type = 'multiselectlink';
}
//---------one
if (in_array($name, $ag_db_dir)) {
$ag_option = array();
$optd = array();
$db_ddata = array();
$db_nd = array_search($name, $ag_db_dir);	
$db_ddata = ag_read_data($ag_data_dir.'/'.$db_nd.$agt);
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
$dird = $name;
if (!empty($catd_id)) { $optd = ag_read_data($ag_data_dir.'/'.$dird.'/'.$catd_id.$agt); }
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
$ag_option[$catd_id.$obd_id] = array('id' => $catd_id.'::'.$obd_id, 'name' => $catd_name.' - '.$obd_name, 'status' => $obd_status);

}// foreach optd
}//foreach db_ddata


$type = 'selectlink';
}





//--------------------------------------------------------options 
if ($name == 'status') {$ag_class_element = 'ag_active_checkbox';}
if ($name == 'access' && isset($ag_access_levels)) {$ag_option = $ag_access_levels;}
if ($name == 'count_obj_row') {
$ag_option = array(
'2' => array('id' => '2', 'name' => '2'), 
'3' => array('id' => '3', 'name' => '3'),
'4' => array('id' => '4', 'name' => '4'),
'5' => array('id' => '5', 'name' => '5'),
'6' => array('id' => '6', 'name' => '6')
);
}
if ($name == 'link_info' || $name == 'addr_return') {
$ag_info_alias = '';
$ag_info_status = '0';
if (isset($val['alias'])) { $ag_info_alias = $val['alias']; }
if (isset($val['status'])) { $ag_info_status = $val['status']; }
$ag_option = array(
'1' => array('id' => '1', 'name' => $val['id']), 
'2' => array('id' => '2', 'name' => $ag_info_alias),
'3' => array('id' => '3', 'name' => $ag_info_status)
);	
}
if ($name == 'widgets') {$ag_option = array_merge($ag_option, $ag_inc_widgets); }

if ($name == 'form_method') {
$ag_option = array(
'0' => array('id' => 'POST', 'name' => 'POST'), 
'1' => array('id' => 'GET', 'name' => 'GET')
);
}
//--------------------------------------------------------options



//--------------------------------------------------------access


$ag_edit_user_id = '0';
$ag_edit_user_access = '1';
foreach ($ag_users as $nu => $ag_user) {
if (isset($ag_user['id']) && isset($ag_user['access'])) { 
if ($ag_this_id == $ag_user['id']) {$ag_edit_user_access = $ag_user['access'];} // this user access
}// isset id & access
}// foreach  ag_users

if ($ag_this_db == $ag_staff_db) { // staff db
if ($ag_this_access != 1 && $ag_user_id == $ag_this_id) {$ag_this_access = 1;} // self edit

if ($ag_user_access == 'founder') {} else {
if ($ag_edit_user_access == 1 && $ag_this_id != $ag_user_id) { $ag_this_access = 0; } // admin no edit other admins
if ($ag_edit_user_access == 'founder' && $ag_this_id != $ag_user_id) { $ag_this_access = 0; } // no edit founder
}// founder


// inputs do not self edit
if ($ag_this_id == $ag_user_id && $name == 'access') { // access
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 0);
//---------------------------------
} else if ($ag_this_id == $ag_user_id && $name == 'status') { // status
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 0); 
//---------------------------------
} else if ($ag_this_id != $ag_user_id && $name == 'pass' && !empty($value)) { // password
if ($ag_this_access == 1) {
ag_form_element('changepass', 'changepass', $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 1); 	
} else {
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, 0); 
}
//---------------------------------
} else { // normal
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, $ag_this_access); 	
}



} else { //================================================ no staff db


// ----------------------------schedule
if ($name == 'schedule') {
$ag_week_schedule = array($ag_lng_days_short[1], $ag_lng_days_short[2], $ag_lng_days_short[3], $ag_lng_days_short[4], $ag_lng_days_short[5], $ag_lng_days_short[6], $ag_lng_days_short[0]);


foreach ($ag_week_schedule as $nd => $ag_week_day) {
$ag_sched_v = '';
$ag_weekend_class = '';
if ($nd == 5 || $nd == 6) {$ag_weekend_class = ' ag_weekend_schedule';}
echo '<div class="ag_schedule">';	

echo '<div class="ag_week_name' .$ag_weekend_class. '">' .$ag_week_day. '</div>';
echo '<div class="ag_day_graphic">';

$ag_schedule_val_arr = explode($ag_separator[2], $value);

if (isset($ag_schedule_val_arr[$nd])) {$ag_sched_v = $ag_schedule_val_arr[$nd];}	
if (isset($_POST[$name][$nd])) {$ag_sched_v = $_POST[$name][$nd];}

ag_form_element($type, $name.'[' .$nd. ']', $_GET['id'].$ag_count.$nd, $ag_sched_v, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, $ag_this_access); 


echo '</div>';//ag_day_graphic

echo '<div class="clear"></div>';
echo '</div>';// ag_schedule

echo '<div class="clear"></div>';
}// foreach ag_week_schedule
echo '<div class="ag_schedule"></div>';

echo '
<script>
function ag_width_schedule() {
var w_block = $(".ag_schedule").outerWidth(true);
var w_name = $(".ag_week_name").outerWidth(true);	
var w_select = w_block - w_name;
$(".ag_day_graphic").css({width: w_select + "px"});
}
</script>
';

}// type schedule
// ----------------------------schedule

else {


//set user access for item
if (isset($val[$ag_staff_db.'s'])) { 
$set_users = explode($ag_separator[2], $val[$ag_staff_db.'s']);
if (in_array($ag_user_id, $set_users)) {$ag_this_access = 1;}
}

if (!empty($ag_set_staffs)) {
if (in_array($ag_user_id, $ag_set_staffs)) {$ag_this_access = 1;}	
}
//set user access

if ($ag_user_access == 2) {$ag_this_access = 1;} // editor access

$ag_before_access = $ag_this_access;
if ($ag_user_access != 'founder') {
	
if ($name == $ag_staff_db.'s' && $ag_user_access != 1) {
$ag_this_access = 0;
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, $ag_this_access); 
} else {
$ag_this_access = $ag_before_access;
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, $ag_this_access); 	
}
		
} else { // founder
ag_form_element($type, $name, $_GET['id'].$ag_count, $value, $ag_option, $ag_data_upload_dir, $ag_user_id, $ag_class_element, $ag_users, $ag_this_access); 			
}


}// no schedule

}// no staff db
//--------------------------------------------------------access


echo '</div>'; // ag_elements_area

echo '<div class="clear"></div>'; 
echo '</div>'; // ag_edit_form

} // no hidden type
}// foreach val



// hidden elements
foreach ($val as $name => $value) { $ag_count++;
foreach ($ag_name_type as $names => $types) { if ($names == $name) {$type = $types; } }
if ($type == 'hidden') {
echo '<div class="ag_hidden_element">';
ag_form_element($type, $name, $val['id'].$ag_count, $value, 'opt', 'upload', 'User', 'class1', 'all users', '1');
echo '</div>';
}// hidden type
}// foreach val


if ($ag_this_access != 0) {
echo '<input type="hidden" name="ag_replace" value="' .$val['id']. '" />'; 
echo '<div class="ag_save">
<button class="ag_btn_big" id="ag_save_btn_bottom"><i class="icon-floppy-1"></i><span>' .$ag_lng['save']. '</span></button>
<div class="clear"></div>
</div>';
} else {echo '<script> $("#ag_save_btn_top").css({display: "none"}); </script>';}

echo '</form>';



}// get id

}// foreach ag_data


if (!isset($ag_found_item)) {
if (isset($_GET['id'])) { 
//$ag_ERROR['item_not_found'] = $ag_lng['error_item_not_found']; 
echo '<script>$(document).ready(function() { ag_dialog("3000", "<ul><li>' .$ag_lng['error_item_not_found']. '</li></ul>", "'.$ag_lng['error'].'", "ag_cancel", "icon-roadblock ag_str_red", "link_tab"); });</script>';
}

if (!isset($_GET['common_search']) && !isset($ag_filter_query) && empty($ag_home)) {

echo '<div class="ag_not_select_item" id="ag_not_select_item">
' .$ag_icon_tab. '
<div>' .$ag_lng['select_item_or_add']. '</div>
</div>';
echo '
<script>
var count_event_r = 0;
function ag_icon_not_item() {

count_event_r++;

var edit_block_w = $("#ag_edit_block").outerWidth(true); 
var edit_block_h = $("#ag_edit_block").outerHeight(true); 
var ag_topm_h = $("#ag_filters_block").outerHeight(true) + 16;
if (count_event_r < 2) { $("#ag_not_select_item div").css({display: "none"}); }
setTimeout(function(){ 
edit_block_w = $("#ag_edit_block").outerWidth(true); 
edit_block_h = $("#ag_edit_block").outerHeight(true); 
';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
echo 'ag_topm_h = $("#ag_top").outerHeight(true) + $("#ag_top_tools").outerHeight(true) + $("#ag_filters_block").outerHeight(true) + $("#ag_title_top_mob").outerHeight(true) + 8;'; 
}
echo '
$("#ag_not_select_item i").fadeIn(300);

if (count_event_r < 2) { 
$("#ag_not_select_item i").fadeIn(300).animate({fontSize: (edit_block_w / 4 + 16) + "px"}, 300).animate({fontSize: (edit_block_w / 4) + "px"}, 200).delay(800).stop();
} else { $("#ag_not_select_item i").css({transition: "all 0.4s ease-in-out", fontSize: (edit_block_w / 4) + "px"}); }

$("#ag_not_select_item").css({width: (edit_block_w) + "px", margin: "0 0 0 -" + (edit_block_w / 2) + "px", top: ag_topm_h + "px"});
$("#ag_not_select_item div").delay(800).fadeIn(400);
}, 200);


}
$(document).ready(function(){ ag_icon_not_item(); });
$(window).on("resize", function(event) { ag_icon_not_item(); });
';
echo '</script>
';	
}// common search
}

echo '</div>'; // ag_edit_block_inner
echo '</div>'; // ag_edit_block


//list items menu

if (empty($ag_home)) {

$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
if (!isset($_GET['iframe']) && !isset($_GET['common_search'])) {
echo '<div class="ag_open_close_list">';
echo '<div class="ag_open_close_list_inner">';
echo '<div id="ag_open_list" tabindex="-1" onclick="ag_open_list()"><i class="icon-th"></i></div>';
echo '<div id="ag_close_list" tabindex="-1" onclick="ag_close_list()"><i class="icon-cancel"></i></div>';	
echo '<div class="clear"></div>'; 
echo '</div>';
echo '</div>';	
}// iframe
}


if (!isset($_GET['iframe']) && !isset($_GET['common_search'])) {

echo '<div class="ag_search_list" id="ag_list_items_block">';
echo '<div class="ag_list_items" id="ag_list_items">';
include('list_items.php');
echo '</div>'; // ag_list_items
echo '</div>'; // ag_search_list
echo '<div class="clear"></div>'; 


//ag_checked_tools
echo '<div class="ag_checked_tools" id="ag_checked_tools">

<div class="ag_top_checked_tools">
<span class="ag_checked_count" id="ag_checked_count"></span>
<span class="ag_check_reset" onclick="ag_remove_checked()"><i class="icon-cancel-circle"></i></span>
<div class="clear"></div>
</div>

<div class="ag_btn_checked_tools">';
echo '<button onclick="ag_on_items()" class="ag_btn_small ag_ch_on"><i class="icon-toggle-on"></i><span>' .$ag_lng['on']. '</span></button>';
echo '<button onclick="ag_off_items()" class="ag_btn_small ag_ch_off"><i class="icon-toggle-off"></i><span>' .$ag_lng['off']. '</span></button>';
echo '<button onclick="ag_delete_items()" class="ag_btn_small ag_ch_del"><i class="icon-cancel-2"></i><span>' .$ag_lng['delete']. '</span></button>';
echo '<div class="clear"></div>';

echo '</div></div>'; //ag_checked_tools

echo '<script>
function ag_delete_items() {
var ag_checked_item = $.map( $(".ag_items_check:checked"), function(el){ return $(el).val(); });
var ag_checked_name = $.map( $(".ag_items_check:checked"), function(el){ return $(el).find(" + span").text(); }); 
ag_dialog(ag_checked_item, ag_checked_name, \''.$ag_lng['confirm_delete_multi'].'!\', \'ag_delete_item\', \'icon-attention ag_str_orange\', \'button2\');
}

function ag_on_items() {
var ag_checked_item = $.map( $(".ag_items_check:checked"), function(el){ return $(el).val(); });
ag_on_item(""+ag_checked_item+"");
}

function ag_off_items() {
var ag_checked_item = $.map( $(".ag_items_check:checked"), function(el){ return $(el).val(); });
ag_off_item(""+ag_checked_item+"");
}
</script>';
} // iframe

} // no empty ag_data
?>