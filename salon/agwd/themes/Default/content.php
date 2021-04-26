<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}


$ag_widgets = ag_widgets();
if (isset($_GET[$ag_get_sitemap]) || isset($_GET[$ag_get_search])) {$ag_widgets = '';}

if ($ag_error_get == 1) { $ag_widgets = '';
echo $ag_404_content;	

} else if (isset($ag_display_confirm)) { $ag_widgets = '';
echo $ag_display_confirm;

} else {



$ag_widgets_class = '';
if (!empty($ag_widgets)) {$ag_widgets_class = ' ag_widgets';}

echo '<div id="ag_content" class="ag_content' .$ag_widgets_class. '">';



//search
if (isset($_GET[$ag_get_search])) { 

echo ag_search($_GET[$ag_get_search]); 

} else if (isset($_GET[$ag_get_sitemap])) {

echo '<div class="ag_cat ag_sitemap">';

echo '<div class="ag_cat_top"><h2 class="ag_title_cat">'.$ag_lng['sitemap'].'</h2></div>';

echo '<div class="ag_cat_content"><div class="ag_post_item">';	
echo $ag_full_list;


//json schedules in sitemap
if (isset($ag_services_json)) {
echo $ag_services_json;
}// json schedules


echo '<span class="ag_xml_sitemap_link"><i class="icon-code-3"></i> <a href="?'.$ag_get_sitemap.'=xml">'.$ag_lng['sitemap'].' XML</a></span>';
echo '</div></div>';
echo '</div>';	

} else {


if (isset($_GET[$ag_get_cat])) { // cat

	if (!empty($ag_alias_obj)) {
echo ag_list_obj($ag_alias_cat, '' ,$ag_alias_obj, '');
	} else {
echo ag_list_cat($ag_alias_cat,'','short');		
	}

	
} else { //home 



if (!empty($ag_cfg_home_content) && $ag_page == 1) {
$ag_cfg_home_content = str_replace('[site_url]', '', $ag_cfg_home_content);
$ag_cfg_home_content = html_entity_decode($ag_cfg_home_content, ENT_QUOTES, 'UTF-8');
$ag_cfg_home_content = str_replace($ag_separator[3], "\n", $ag_cfg_home_content);
$ag_cfg_home_content = '<div class="ag_cat_content ag_home_content"><div class="ag_post_item">'.$ag_cfg_home_content.'<div class="ag_clear"></div></div></div>';
$ag_cfg_home_content = ag_return_html($ag_cfg_home_content);
$ag_cfg_home_content = ag_close_tags($ag_cfg_home_content);
} else {$ag_cfg_home_content = '';}

//ag_custom_home_content
if (!isset($ag_custom_home_content)) { $ag_custom_home_content = ''; }
if ($ag_page == 1) {
$ag_custom_home_content .= html_entity_decode($ag_cfg_home_content_js, ENT_QUOTES, 'UTF-8');
$ag_custom_home_content = str_replace($ag_separator[3], "\n", $ag_custom_home_content);
$ag_custom_home_content = ag_return_html($ag_custom_home_content);
$ag_custom_home_content = ag_close_tags($ag_custom_home_content);
}

if ($ag_cfg_home_content_pos == '0' || empty($ag_cfg_home_content_pos)) {
	echo $ag_cfg_home_content;
	echo $ag_custom_home_content;
}


$ag_home_blocks_class = '';
if ($ag_cfg_home_blocks == '1') { $ag_home_blocks_class = ' ag_blocks_cat ag_row_blocks_'.$ag_cfg_home_blocks_row; }

if ($ag_cfg_home == 'first_category') { 
echo ag_list_cat('', '', 'short,500'); 


} else if ($ag_cfg_home == 'last_objects') {
echo '<div class="ag_cat'.$ag_home_blocks_class.'">' .ag_last_obj($ag_cfg_home_blocks_count, $ag_cfg_home_common_count, 'short'). '<div class="ag_clear"></div></div>'; 


} else if ($ag_cfg_home == 'custom_content') {
$ag_home_obj = '';
if (isset($ag_cfg_home_objects) && !empty($ag_cfg_home_objects)) {
$ag_cfg_home_objects_a = explode($ag_separator[2], $ag_cfg_home_objects);

foreach ($ag_cfg_home_objects_a as $ag_set_obj) {
$ag_set_obj_a = explode('::', $ag_set_obj);	
if (isset($ag_set_obj_a[1])) {$ag_home_obj .= $ag_set_obj_a[1].',';}
}
echo '<div class="ag_cat'.$ag_home_blocks_class.'">' .ag_list_obj('', '', $ag_home_obj, 'short'). '<div class="ag_clear"></div></div>'; 
}// isset ag_cfg_home_objects
}// custom_content


else {}


if ($ag_cfg_home_content_pos == '1') {
	echo '<div class="ag_home_content_bottom">'.$ag_cfg_home_content.'</div>';
	echo $ag_custom_home_content;
}


}// home


}// search

// none content
$ag_count_cat_ceck = 0;
if (empty($ag_cat)) {
if (empty($ag_cfg_home_content)) { echo $ag_none_content; }
} else {

foreach ($ag_cat as $ag_check_cat) {
	if (isset($ag_check_cat['status']) && $ag_check_cat['status'] == '1') {$ag_count_cat_ceck++;} 
	}
	if ($ag_count_cat_ceck == 0 && empty($ag_cfg_home_content)) {echo $ag_none_content;} else {
	if ($ag_cfg_home == 'custom_content' && empty($ag_cfg_home_content)) {echo $ag_none_content;}
}
}
 

echo '</div>'; // ag_content
echo $ag_widgets; //ag_widgets
echo '<div class="ag_clear"></div>';

}// error get





?>
