<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}

include('functions.php');

if (isset($_GET[$ag_get_rss])) {
include('rss.php');		
} else if (isset($_GET[$ag_get_sitemap]) && $_GET[$ag_get_sitemap] == 'xml') {
include('sitemap.php');	
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $ag_lng_value; ?>" lang="<?php echo $ag_lng_value; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title><?php echo ag_meta('title', $ag_title); ?></title>

<meta name="copyright" content="&copy; <?php echo $ag_cfg_title; ?>">
<meta name="title" content="<?php echo ag_meta('title', $ag_title); ?>" />
<meta name="description" content="<?php echo ag_meta('description', $ag_description); ?>" />
<meta property="og:title" content="<?php echo ag_meta('title', $ag_title); ?>" />
<meta property="og:description" content="<?php echo ag_meta('description', $ag_description); ?>" />

<meta property="og:url" content="<?php echo $ag_protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
<meta property="og:type" content="website" />

<meta http-equiv="X-UA-Compatible" content="IE=edge" />


<link rel="stylesheet" href="css/icons/animation.css" />
<link rel="stylesheet" href="css/main.css" />
<link rel="stylesheet" href="css/colorbox.css" />
<link rel="stylesheet" href="<?php echo $ag_cfg_theme ?>css/style.css" />
<?php foreach (ag_css_func() as $ag_func_css) { if (!empty($ag_func_css)) { echo '<link rel="stylesheet" href="' .$ag_func_css. '" />'; } } ?>


<?php if (!empty($ag_cfg_logo) && file_exists($ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo)) { // --- LOGO ?>
<link rel="image_src" href="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>" /> 
<link rel="icon" href="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>" type="image/jpeg" />
<link rel="apple-touch-icon" href="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>" type="image/jpeg" />
<meta name="msapplication-TileImage" content="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>"/>
<meta name="msapplication-square300x300logo" content="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>"/>
<meta property="og:image" content="<?php echo $srv_absolute_url.$ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo; ?>" />
<?php } ?>
<?php if (file_exists('favicon.ico')) { ?>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<?php }  //--- /LOGO ?>

<?php if ($ag_check_count_objects > 1) { ?>
<link href="<?php echo $srv_absolute_url; ?>?<?php echo $ag_get_rss;?><?php if(isset($_GET[$ag_get_cat])) {echo '='.$_GET[$ag_get_cat];} ?>" rel="alternate" type="application/rss+xml" title="<?php echo ag_meta('title', $ag_title); ?>">
<?php }  //--- /RSS ?>

<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/jquery.touchSwipe.min.js"></script>

<?php if ($ag_is_mob == 1) { ?>
<link rel="stylesheet" href="<?php echo $ag_cfg_theme ?>css/mobile.css" />
<?php } ?>
<?php if (empty($ag_alias_cat) && !empty($ag_cfg_home_content_css)) { 
$ag_cfg_home_content_css = html_entity_decode($ag_cfg_home_content_css, ENT_QUOTES, 'UTF-8');
$ag_cfg_home_content_css = str_replace($ag_separator[3], "\n", $ag_cfg_home_content_css);
?>
<style><?php echo $ag_cfg_home_content_css; ?></style>
<?php } ?>

<style>
<?php 

$ag_fonts = array($ag_cfg_font_title, $ag_cfg_font_description, $ag_cfg_font_menu, $ag_cfg_font_h, $ag_cfg_font_text);
$ag_fonts = array_diff($ag_fonts, array(''));
$ag_fonts = array_unique($ag_fonts);

if (!empty($ag_fonts)) {
$ag_count_set_fonts = 0;
foreach ($ag_fonts as $fp) {
if (file_exists($fp) && ag_file_list($fp, 'ttf') && ag_file_list($fp, 'woff')) { $ag_count_set_fonts ++;
$fn = '';
$fn_arr = explode('/', $fp); $fn_arr = array_diff($fn_arr, array(''));
$fn = array_pop($fn_arr);
echo '
@font-face {
 font-family: \''.$fn.'\';
 src: url(\''.$fp.$fn.'.eot\');
 src: url(\''.$fp.$fn.'.eot?#iefix\') format(\'embedded-opentype\'),
 url(\''.$fp.$fn.'.woff\') format(\'woff\'),
 url(\''.$fp.$fn.'.ttf\') format(\'truetype\');
 font-weight: normal;
 font-style: normal;
}
';	
}
}
}
if ($ag_count_set_fonts > 0) {
//text font
$ag_font = '"Helvеtica Neue", Helvetica, Arial, sans-serif';
if (!empty($ag_cfg_font_text)) {
$ag_font_text = explode('/', $ag_cfg_font_text); $ag_font_text = array_diff($ag_font_text, array(''));
$ag_font = '"'.array_pop($ag_font_text).'"';
} 
$ag_font_size = '';
if (!empty($ag_cfg_font_size) && $ag_cfg_font_size >= '8' && $ag_cfg_font_size < '32') {
$ag_font_size = 'font-size:' .$ag_cfg_font_size. 'px;';
echo 'div.ag_post_item p {min-height:' .$ag_cfg_font_size. 'px;}';
}

echo 'body, input, select, textarea, button {font-family: '.$ag_font.'; '.$ag_font_size.'}';
echo '.ag_menu ul li h3 a i.ag_one_icon:before, .ag_menu ul li h3 span i.ag_one_icon:before {margin-left: -'.($ag_cfg_font_size / 2).'px;}';
//backgrounds
if (isset($ag_cfg_background_color) && !empty($ag_cfg_background_color)) { 
echo 'body {background:' .$ag_cfg_background_color. ';}
.ag_slider_loading {color:rgba(255,255,255,0.45);}
.ag_obj_photo {background:' .$ag_cfg_background_color. ';}
.ag_photos {background:' .$ag_cfg_background_color. ';}
#ag_idate {border: rgba(255,255,255,0.12) 1px solid;}
#ag_date_select {background:' .$ag_cfg_background_color. ';}
#ag_time_list ul li.ag_disabled p {background:' .$ag_cfg_background_color. '; border-color:rgba(255,255,255,0.25);}
.ag_cal_arrow {background:' .$ag_cfg_background_color. '; border-color:rgba(255,255,255,0.25);}
#ag_idate tbody td, #ag_idate tbody th, #ag_idate thead td, #ag_idate thead th {color:rgba(255,255,255,0.25);}
#ag_main_form span.ag_spots_input span.ag_spots_select {border-color:rgba(255,255,255,0.25); background:' .$ag_cfg_background_color. ';}
#ag_view_time {border-color:rgba(255,255,255,0.25); background:' .$ag_cfg_background_color. ';}
#ag_time_list ul li.ag_no_time p {border-color:rgba(255,255,255,0.25); color:rgba(255,255,255,0.45); background:' .$ag_cfg_background_color. ';}
.ag_copy, .ag_footer_decor {border:none;}
'; 
}
if (isset($ag_cfg_items_background_color) && !empty($ag_cfg_items_background_color)) { 	
echo '
.ag_obj_item {background:' .$ag_cfg_items_background_color. '; border:none;}
.ag_pages_nav ul li a {background:' .$ag_cfg_items_background_color. ';}
.ag_cat_content {background:' .$ag_cfg_items_background_color. '; border:none;}
.ag_widget_block_inner {background:' .$ag_cfg_items_background_color. '; border:none;}
div.ag_done_mess {background:' .$ag_cfg_items_background_color. ';}
.ag_widget_column_mobile {background:' .$ag_cfg_items_background_color. ';}
.ag_error_404_content {border:none; background:' .$ag_cfg_items_background_color. ';}
.share {border:none;}
.share_inner {background:' .$ag_cfg_items_background_color. ';}
div.ag_map {background:' .$ag_cfg_items_background_color. '; border:none;}
.ag_after_obj_links {background:' .$ag_cfg_items_background_color. '; border:none;}
.ag_widget_column div.ag_pub_calendar select, .ag_widget_column div.ag_pub_calendar input {background:' .$ag_cfg_items_background_color. ';}


.ag_cat_top {background:rgba(255,255,255,0.3); border:none;}
.ag_widget_block div.ag_post_item h4 {background:rgba(255,255,255,0.3); border:none;}
.ag_obj_item h3.ag_title_obj {background:rgba(255,255,255,0.3); border:none;}
div.ag_post_item h4.ag_description_obj {background:rgba(255,255,255,0.21); border:none;}
.ag_obj_item_mobile div.ag_post_item h4.ag_description_obj {background:rgba(255,255,255,0.21); border:none;}
.ag_widget_block div.ag_post_item h4.ag_title_wgt { background:rgba(255,255,255,0.21); }
#ag_footer .ag_widget_block div.ag_post_item h4 {background:none;}

.ag_post_info {background:rgba(255,255,255,0.3); border:none;}
.ag_blocks_cat_mob .ag_post_info {background:rgba(255,255,255,0.3); border:none;}
.ag_obj_item_no_info {border:none;}
.ag_blocks_cat .ag_obj_block div.ag_obj_item_no_info {border:none;}
.ag_blocks_cat .ag_obj_block div.ag_obj_item {border:none;}


label {background:rgba(255,255,255,0.25); border:none; }
label.ag_active {box-shadow:none;}
.ag_catpcha label {border:rgba(255,255,255,0.25) 1px solid;}
.ag_widgets_close {background:none;}


span.ag_xml_sitemap_link {border:none; border-top: rgba(255,255,255,0.12) 1px solid;}
ul.ag_wgt_list_obj li { border:none; border-bottom: rgba(255,255,255,0.12) 1px solid; }
.ag_widget_block div.ag_post_item ul.ag_wgt_list li a {border-bottom: rgba(255,255,255,0.12) 1px solid;}
h4.ag_to_cat {border:none; border-top: rgba(255,255,255,0.12) 1px solid;}

div.ag_post_item ul.ag_mail_form_message li {background:rgba(255,255,255,0.12);}

div.ag_post_item table tr {background:rgba(255,255,255,0.07);}
div.ag_post_item table tr:nth-child(2n) {background:rgba(255,255,255,0.03);}
div.ag_post_item table td, table th {border:none;}

.ag_widget_column div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view {background:' .$ag_cfg_items_background_color. ';}
.ag_widget_column div.ag_post_item div.ag_pub_calendar div.ag_pc_arrow {
border: 9px dashed ' .$ag_cfg_items_background_color. ';
    border-bottom-style: solid;
    border-top: none;
    border-left-color: transparent;
    border-right-color: transparent;	
}
div.ag_post_item h5.ag_to_cat {border-top: rgba(255,255,255,0.12) 1px solid;}
#ag_time_list ul li p {border: rgba(255,255,255,0.12) 1px solid; background:' .$ag_cfg_items_background_color. ';}


#ag_booking_form .ag_disabled {color:rgba(255,255,255,0.25);}
#ag_time_list ul li.ag_disabled span.ag_currency {border-color:rgba(255,255,255,0.25);}
#ag_time_list ul li.ag_disabled:after {color:rgba(255,255,255,0.25);}


#ag_idate tbody td.ag_di:hover, #ag_idate thead td.ag_di:hover {background:' .$ag_cfg_items_background_color. ';}

#ag_idate tbody td.ag_today, #ag_idate tbody td.ag_today:nth-child(n+6) {background:' .$ag_cfg_items_background_color. '; outline: 1px solid rgba(255,255,255,0.12);}

#ag_main_form span.ag_spots_input,
#ag_booking_form label
{background:rgba(255,255,255,0.12); border: rgba(255,255,255,0.12) 1px solid;}
#ag_main_form label.ag_first_name:before, #ag_main_form label.ag_family_name:before, #ag_main_form label.ag_phone:before, #ag_main_form label.ag_email:before, #ag_main_form .ag_date label:before {border-left: rgba(255,255,255,0.12) 1px solid; background:' .$ag_cfg_items_background_color. ';}

#ag_main_form table.ag_eula_block td.ag_eula_checkbox {background:' .$ag_cfg_items_background_color. '; border-right: rgba(255,255,255,0.12) 1px solid;}
.ag_eula_input {border: rgba(255,255,255,0.12) 1px solid;}

#ag_eula_text div.inner, #ag_result div.inner {background:' .$ag_cfg_items_background_color. ';}
#ag_result div.ag_message:before, #ag_result div.ag_done:before, #ag_result div.ag_error:before {color:rgba(255,255,255,0.12);}
.ag_load_times i {color:rgba(255,255,255,0.12);}
.ag_policy_text div.inner {background:' .$ag_cfg_items_background_color. ';}
#ag_payment_page ul li div {border:rgba(255,255,255,0.12) 1px solid;}
';
}



	
//h font
if (!empty($ag_cfg_font_h)) {
$ag_font_h = explode('/', $ag_cfg_font_h); $ag_font_h = array_diff($ag_font_h, array(''));
echo 'h1,h2,h3,h4,h5,h6 {font-family: "'.array_pop($ag_font_h).'", arial;}';			
} else { echo 'h1,h2,h3,h4,h5,h6 {font-family: '.$ag_font.', arial;}'; } 
//title font
if (!empty($ag_cfg_font_title)) {
$ag_font_title = explode('/', $ag_cfg_font_title); $ag_font_title = array_diff($ag_font_title, array(''));
echo '.ag_top h2 {font-family: "'.array_pop($ag_font_title).'", arial!important; }';	
} else { echo '.ag_top h2 {font-family: '.$ag_font.', arial;}'; }
//description font
if (!empty($ag_cfg_font_description)) {
$ag_font_description = explode('/', $ag_cfg_font_description); $ag_font_description = array_diff($ag_font_description, array(''));
echo '.ag_top h1 {font-family: "'.array_pop($ag_font_description).'", arial!important; }';	
} else { echo '.ag_top h1 {font-family: '.$ag_font.', arial;}'; }
//menu font
if (!empty($ag_cfg_font_menu)) {
$ag_font_menu = explode('/', $ag_cfg_font_menu); $ag_font_menu = array_diff($ag_font_menu, array(''));
echo '.ag_menu ul li h3 {font-family: "'.array_pop($ag_font_menu).'", arial!important;}';		
} else { echo '.ag_menu ul li h3 {font-family: '.$ag_font.', arial;}'; } 
}// count set fonts
?>
<?php 
//custom colors

if (!empty($ag_cfg_font_text_color)) {
echo 'body, input, select, textarea, div.ag_done_mess h4, .ag_pages_nav ul li a, .ag_widget_block div.ag_post_item ul.ag_wgt_list li a, .ag_search_submit i.icon-right-open, .ag_search_submit:hover i.icon-right-open,
.ag_login_form button, .ag_widget_block .ag_wgt_search_form button,
h1,h2,h3,h4,h5,h6, div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a, #ag_widgets_close,
div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a, div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a:hover
{color:'.$ag_cfg_font_text_color.';}
.ag_menu ul li ul {border-top: '.$ag_cfg_font_text_color.' 4px solid;}
.ag_menu ul li.ag_menu_item_punkts span:before {
border: 8px dashed '.$ag_cfg_font_text_color.'; 
border-bottom-style: solid;
border-top: none;
border-left-color: transparent;
border-right-color: transparent;}
div.ag_done_mess h4, #ag_footer div.ag_done_mess h4 {color:'.$ag_cfg_font_text_color.';}
input::-webkit-input-placeholder {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}
input::-moz-placeholder          {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}/* Firefox 19+ */
input:-moz-placeholder           {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}/* Firefox 18- */
input:-ms-input-placeholder      {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}

textarea::-webkit-input-placeholder {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}
textarea::-moz-placeholder          {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}/* Firefox 19+ */
textarea:-moz-placeholder           {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}/* Firefox 18- */
textarea:-ms-input-placeholder      {color:'.$ag_cfg_font_text_color.'; opacity:0.5;}
.ag_error_404_icon {color:'.$ag_cfg_font_text_color.';}
#ag_time_list ul li p {border: ' .$ag_cfg_font_text_color. ' 1px solid;}

#ag_idate tbody td.ag_di:hover, #ag_idate tbody td.ag_di, #ag_idate thead td.ag_di:hover, #ag_idate thead td {color:'.$ag_cfg_font_text_color.'!important;}
#ag_main_form span.ag_spots_input span.ag_spots_select {color:'.$ag_cfg_font_text_color.';}
#ag_main_form label.ag_first_name:before, #ag_main_form label.ag_family_name:before, #ag_main_form label.ag_phone:before, #ag_main_form label.ag_email:before, #ag_main_form .ag_date label:before {color:'.$ag_cfg_font_text_color.';}
#ag_eula_open span {border-bottom: 1px dashed '.$ag_cfg_font_text_color.';}
.ag_policy_title span{border-bottom:1px dashed '.$ag_cfg_font_text_color.';}
.ag_menu ul li.ag_this_punkt a:hover {color:'.$ag_cfg_font_text_color.'!important;}
';
}


if (!empty($ag_cfg_font_title_color)) {
echo '
.ag_top h2, 
.ag_top h2 a 
{color:' .$ag_cfg_font_title_color. ';}';
} 

if (!empty($ag_cfg_ae_color)) {
echo '
button, 
a.ag_button, span.ag_button, a.ag_button:hover, span.ag_button:hover,
#ag_footer button, #ag_footer button:hover, #ag_footer a.ag_button, #ag_footer span.ag_button, #ag_footer a.ag_button:hover, #ag_footer span.ag_button:hover,
.ag_pages_nav ul li span
{color:'.$ag_cfg_ae_color.';}
'; 
}
if (!empty($ag_cfg_ae_hover_color)) {
echo '
button:hover, 
a.ag_button:hover, 
span.ag_button:hover,
#ag_footer a.ag_button:hover,
#ag_footer span.ag_button:hover,
#ag_footer button:hover,
.ag_pages_nav ul li a:hover
{color:'.$ag_cfg_ae_hover_color.';}'; 
}


if (!empty($ag_cfg_a_color)) {
echo '
a, a:hover,
.ag_widget_block .ag_login_form button.ag_button_active,
.ag_wgt_search_form button:hover,
.ag_search_submit i.icon-right-open,
.ag_menu ul li.ag_this_title_punkts h3 span.ag_title_punkts i
{color:' .$ag_cfg_a_color. ';} 
button, 
a.ag_button, 
span.ag_button, 
#ag_footer a.ag_button, #ag_footer a.ag_button:hover,
.ag_pages_nav ul li span, 
#ag_load div,
.ag_menu ul li span, 
.ag_menu ul li.ag_this_punkt a, .ag_menu ul li.ag_this_punkt a:hover
{background:' .$ag_cfg_a_color. ';}
.ag_widget_block div.ag_post_item ul.ag_wgt_list li.ag_this_list a { color:' .$ag_cfg_a_color. ';}
#ag_footer a, #ag_footer a:hover {color:' .$ag_cfg_a_color. ';}
.ag_full_width_obj .ag_obj_item h3.ag_title_obj a, .ag_full_width_obj .ag_obj_item h3.ag_title_obj a:hover {color:' .$ag_cfg_a_color. '!important;}
#ag_footer .ag_login_form button.ag_button_active {color:' .$ag_cfg_a_color. ';}
.ag_search_submit i.icon-right-open {color:' .$ag_cfg_a_color. '!important;}
div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub, div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub:hover {color:' .$ag_cfg_a_color. ';}
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span, div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span, div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span:hover, div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span:hover,
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span,
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a, #ag_footer div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a:hover
{color:' .$ag_cfg_a_color. ';}


button:hover, 
a.ag_button:hover, 
span.ag_button:hover, 
#ag_footer a.ag_button:hover,
.ag_pages_nav ul li a:hover
{background:' .$ag_cfg_a_color. ';}
.ag_widget_block div.ag_post_item ul.ag_wgt_list li a:hover
{color:' .$ag_cfg_a_color. ';}
#ag_footer a:hover {color:' .$ag_cfg_a_color. ';}
.ag_full_width_obj .ag_obj_item h3.ag_title_obj a:hover, .ag_search_submit:hover i.icon-right-open {color:' .$ag_cfg_a_color. '!important;}
div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover, #ag_footer div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover {color:' .$ag_cfg_a_color. ';}
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_today span, div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_today span:hover {background:' .$ag_cfg_a_color. '; color:#fff!important;}

.ag_slider_menu ul li.ag_current_slide div {color:' .$ag_cfg_a_color. ';}
.ag_slider_time {background:' .$ag_cfg_a_color. ';}


#ag_booking_form ul li.ag_enabled:after {color:' .$ag_cfg_a_color. ';}
#ag_booking_form ul li.ag_enabled:hover {color:' .$ag_cfg_a_color. ';}

#ag_time_list ul li.ag_selected p, #ag_time_list ul li.ag_selected:hover p, .ag_main_mobile #ag_booking_form .ag_selected:hover p {
border:' .$ag_cfg_a_color. ' 1px solid; color:#fff; background:' .$ag_cfg_a_color. ';}
#ag_booking_form .ag_enabled:hover p {border:' .$ag_cfg_a_color. ' 1px solid;}
#ag_booking_form .ag_enabled:hover span.ag_currency {border-top:' .$ag_cfg_a_color. ' 1px solid;}
#ag_total_price {border-left: ' .$ag_cfg_a_color. ' 4px solid;}
#ag_idate tbody td.ag_today, #ag_idate tbody td.ag_today:nth-child(n+6) {color:' .$ag_cfg_a_color. ';}
#ag_idate tbody td.ag_this_di, #ag_idate tbody td.ag_this_di:nth-child(n+6), #ag_idate tbody td.ag_di:focus {
background:' .$ag_cfg_a_color. '; color:#fff}
#ag_idate td.ag_di_ms:hover {color:' .$ag_cfg_a_color. ';}
#ag_main_form label.ag_active:before {color:' .$ag_cfg_a_color. ';}
#ag_main_form label.ag_one_ceckbox input:checked + span.ag_checkbox_custom:before {color:' .$ag_cfg_a_color. ';}
#ag_main_form span.ag_spots_input span.ag_spots_select:hover {color:' .$ag_cfg_a_color. ';}

#ag_idate thead td i {color:' .$ag_cfg_a_color. ';}

.ag_policy_input label.ag_one_ceckbox input:checked+span.ag_checkbox_custom:before {color:' .$ag_cfg_a_color. ';}
#ag_payment_page ul li.ag_selected_payment div {border:' .$ag_cfg_a_color. ' 1px solid;}
#ag_payment_page ul li.ag_selected_payment div:before {color:' .$ag_cfg_a_color. ';}
';
} 
if (!empty($ag_cfg_a_hover_color)) {
echo 'a:hover 
{color:' .$ag_cfg_a_hover_color. ';} 
button:hover, 
a.ag_button:hover, 
span.ag_button:hover, 
#ag_footer a.ag_button:hover,
.ag_pages_nav ul li a:hover 
{background:' .$ag_cfg_a_hover_color. ';}
.ag_widget_block div.ag_post_item ul.ag_wgt_list li a:hover { color:' .$ag_cfg_a_hover_color. ';}
#ag_footer a:hover, #ag_footer .ag_login_form button.ag_button_active:hover, .ag_login_form button.ag_button_active:hover {color:' .$ag_cfg_a_hover_color. ';}
.ag_full_width_obj .ag_obj_item h3.ag_title_obj a:hover, .ag_search_submit:hover i.icon-right-open {color:' .$ag_cfg_a_hover_color. '!important;}
div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover, #ag_footer div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover {color:' .$ag_cfg_a_hover_color. ';}
div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub:hover {color:' .$ag_cfg_a_hover_color. ';}
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span:hover, div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span:hover,
div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover
{color:' .$ag_cfg_a_hover_color. ';}

#ag_main_form span.ag_spots_input span.ag_spots_select:hover {color:' .$ag_cfg_a_hover_color. ';}
#ag_idate thead td:hover i {color:' .$ag_cfg_a_hover_color. ';}
';
} 

if (isset($ag_cfg_ah_color) && !empty($ag_cfg_ah_color)) {
echo '
.ag_obj_item h3.ag_title_obj, .ag_obj_item h3.ag_title_obj a, .ag_obj_item h3.ag_title_obj a:hover {background:'.$ag_cfg_ah_color.'; border:none;}
.ag_full_width_obj .ag_obj_item_mobile h3.ag_title_obj a, .ag_full_width_obj .ag_obj_item_mobile h3.ag_title_obj a:hover {background:'.$ag_cfg_ah_color.'; border:none;}
';
} 

if (isset($ag_cfg_ah_hover_color) && !empty($ag_cfg_ah_hover_color)) {
echo '
.ag_obj_item h3.ag_title_obj a:hover {background:'.$ag_cfg_ah_hover_color.';}
.ag_obj_item_mobile h3.ag_title_obj a:hover {background:'.$ag_cfg_ah_hover_color.';}
';
} 

if (isset($ag_cfg_ah_font_color) && !empty($ag_cfg_ah_font_color)) {
echo '
.ag_obj_item h3.ag_title_obj a, .ag_obj_item h3.ag_title_obj a:hover {color:'.$ag_cfg_ah_font_color.';}
.ag_full_width_obj .ag_obj_item_mobile h3.ag_title_obj a, .ag_full_width_obj .ag_obj_item_mobile h3.ag_title_obj a:hover {color:'.$ag_cfg_ah_font_color.'!important;}
';
} 
if (isset($ag_cfg_ah_font_hover_color) && !empty($ag_cfg_ah_font_hover_color)) {
echo '.ag_obj_item h3.ag_title_obj a:hover {color:'.$ag_cfg_ah_font_hover_color.';}
.ag_full_width_obj .ag_obj_item_mobile h3.ag_title_obj a:hover {color:'.$ag_cfg_ah_font_hover_color.'!important;}
';
}

if (isset($ag_cfg_h_background) && !empty($ag_cfg_h_background)) {
echo '
.ag_widget_block div.ag_post_item h4, 
div.ag_post_item h4.ag_description_obj, 
.ag_obj_item_mobile div.ag_post_item h4.ag_description_obj, 
.ag_cat_top, #ag_widgets_close, 
div.ag_post_item div.ag_pub_calendar table tr th, div.ag_post_item div.ag_pub_calendar table tr td,
.ag_widget_block div.ag_post_item h4.ag_title_wgt
{background:'.$ag_cfg_h_background.';}
#ag_footer .ag_widget_block div.ag_post_item h4 {background:none;}
.ag_widget_column div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view {background:'.$ag_cfg_h_background.';}
.ag_widget_column div.ag_post_item div.ag_pub_calendar div.ag_pc_arrow {
border: 9px dashed '.$ag_cfg_h_background.';
    border-bottom-style: solid;
    border-top: none;
    border-left-color: transparent;
    border-right-color: transparent;	
}
';
}

if (isset($ag_cfg_info_background) && !empty($ag_cfg_info_background)) {
echo '.ag_post_info {background:'.$ag_cfg_info_background.'!important; border:none!important;}
.ag_obj_item {border:none!important;}
.ag_blocks_cat .ag_obj_block div.ag_obj_item {border:none!important;}
';
}



if (isset($ag_cfg_ctitle_background) && !empty($ag_cfg_ctitle_background)) {
echo '
div#ag_cust_title {background:'.$ag_cfg_ctitle_background.';}
div#ag_cust_title:before {border: 8px dashed '.$ag_cfg_ctitle_background.'; border-bottom-style: solid;
border-top: none;
border-left-color: transparent;
border-right-color: transparent;}
';
}
if (isset($ag_cfg_ctitle_color) && !empty($ag_cfg_ctitle_color)) {
echo '
div#ag_cust_title {color:'.$ag_cfg_ctitle_color.';}
';
}


if (!empty($ag_cfg_font_description_color)) {
echo '.ag_top h1 {color:'.$ag_cfg_font_description_color.';}';
}
if (!empty($ag_cfg_font_h_color)) {
echo 'h1,h2,h3,h4,h5,h6, div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a, #ag_widgets_close {color:'.$ag_cfg_font_h_color.';}';
}



if (!empty($ag_cfg_menu_bgcolor)) {
echo '.ag_menu, .ag_mob_top_panel_inner, .ag_button_menu, #ag_widgets_open {background:' .$ag_cfg_menu_bgcolor. ';}
.ag_menu ul li a:hover, .ag_menu ul li h3 span.ag_title_punkts, .ag_menu ul li:hover h3 span.ag_title_punkts, .ag_menu ul li ul {background:' .$ag_cfg_menu_bgcolor. ';}
ul li.ag_empty_home {background:none;}
';
}



if (!empty($ag_cfg_font_menu_color)) {
echo '.ag_menu ul li a, .ag_mob_top_panel_inner, .ag_button_menu, #ag_widgets_open, #ag_mob_top_panel .ag_search_form_inner label input, #ag_close_menu, .ag_menu ul li h3 span.ag_title_punkts, .ag_menu ul li:hover h3 span.ag_title_punkts {color:' .$ag_cfg_font_menu_color. ';}
.ag_move_menu ul li:hover h3 span.ag_title_punkts {color:' .$ag_cfg_font_menu_color. '!important;}
.ag_move_menu ul li:hover h3 span.ag_title_punkts, .ag_move_menu ul li.ag_open_punkt:hover h3 span {color:' .$ag_cfg_font_menu_color. ';}
#ag_mob_top_panel .ag_search_form_inner label input::-webkit-input-placeholder {color:' .$ag_cfg_font_menu_color. '; opacity:0.5;}
#ag_mob_top_panel .ag_search_form_inner label input::-moz-placeholder          {color:' .$ag_cfg_font_menu_color. '; opacity:0.5;}
#ag_mob_top_panel .ag_search_form_inner label input:-moz-placeholder           {color:' .$ag_cfg_font_menu_color. '; opacity:0.5;}
#ag_mob_top_panel .ag_search_form_inner label input:-ms-input-placeholder      {color:' .$ag_cfg_font_menu_color. '; opacity:0.5;}
.ag_menu ul li ul {border-top: '.$ag_cfg_font_menu_color.' 4px solid;}
.ag_menu ul li.ag_menu_item_punkts span:before {
border: 8px dashed '.$ag_cfg_font_menu_color.'; 
border-bottom-style: solid;
border-top: none;
border-left-color: transparent;
border-right-color: transparent;}
';
}

if (!empty($ag_cfg_font_menu_hover_color)) {
echo '.ag_menu ul li a:hover, .ag_search_submit:hover i.icon-right-open, .ag_menu ul li:hover h3 span.ag_title_punkts, .ag_search_submit:focus i.icon-right-open, .ag_menu ul li.ag_this_title_punkts h3 span.ag_title_punkts i, .ag_menu ul li:hover h3 span.ag_title_punkts {color:' .$ag_cfg_font_menu_hover_color. ';}
.ag_move_menu ul li.ag_open_punkt h3 span, .ag_move_menu ul li.ag_open_punkt:hover h3 span {color:' .$ag_cfg_font_menu_hover_color. '!important;}';
}


if (!empty($ag_cfg_menu_hover_bgcolor)) {
echo '.ag_menu ul li a:hover, .ag_menu ul li:hover h3 span.ag_title_punkts, .ag_menu ul li.ag_this_title_punkts, .ag_move_menu ul li.ag_open_punkt {background:' .$ag_cfg_menu_hover_bgcolor. ';} 
.ag_move_menu ul li.ag_this_title_punkts, .ag_move_menu ul li.ag_this_title_punkts h3 span {background:none;} 
.ag_move_menu ul li.ag_open_punkt {background:' .$ag_cfg_menu_hover_bgcolor. ';}
.ag_move_menu ul li.ag_open_punkt h3 span, .ag_move_menu ul li:hover h3 span.ag_title_punkts {background:none;} 
';
}


if (!empty($ag_cfg_font_menu_this_color)) {
echo '.ag_menu ul li span, .ag_menu ul li.ag_this_punkt a, .ag_menu ul li.ag_this_punkt a:hover {color:' .$ag_cfg_font_menu_this_color. ';}
.ag_menu ul li.ag_this_punkt a:hover {color:'.$ag_cfg_font_menu_this_color.'!important;}
';
}
if (!empty($ag_cfg_menu_this_bgcolor)) {
echo '
.ag_menu ul li span,
#ag_load div,
.ag_menu ul li.ag_this_punkt a, .ag_menu ul li.ag_this_punkt a:hover
{background:' .$ag_cfg_menu_this_bgcolor. ';}';
}


if (!empty($ag_cfg_header_bgcolor)) {
echo '.ag_top_decor {background:' .$ag_cfg_header_bgcolor. '; opacity:1;} .ag_top {border:none;}
#ag_top_search {background:rgba(255,255,255,0.21); border:none;}
';
}
if (!empty($ag_cfg_footer_bgcolor)) {
echo '
.ag_footer {background:none; border:none;}
.ag_footer_decor, .ag_footer_mobile .ag_footer_decor {background:' .$ag_cfg_footer_bgcolor. '; opacity:1;} 
#ag_footer label {background:rgba(255,255,255,0.12); border:none;}
#ag_footer .ag_catpcha label {border:rgba(255,255,255,0.04) 1px solid;}
#ag_footer div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view {background:' .$ag_cfg_footer_bgcolor. ';}
#ag_footer div.ag_post_item div.ag_pub_calendar table tr th, #ag_footer div.ag_post_item div.ag_pub_calendar table tr td,
#ag_footer select
{background:rgba(255,255,255,0.12);}
#ag_footer div.ag_post_item div.ag_pub_calendar div.ag_pc_arrow  {
border: 9px dashed ' .$ag_cfg_footer_bgcolor. ';
border-bottom-style: solid;
border-top: none;
border-left-color: transparent;
border-right-color: transparent;	
}
';
}


if (!empty($ag_cfg_font_footer_color)) {
echo '
.ag_footer,
#ag_footer h4,
.ag_copy span.ag_copy_text
{color:' .$ag_cfg_font_footer_color. ';}
#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li.ag_this_list a { color:' .$ag_cfg_font_footer_color. '!important; }
#ag_footer input, #ag_footer textarea, #ag_footer select {color:'.$ag_cfg_font_footer_color.';}
#ag_footer input::-webkit-input-placeholder {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}
#ag_footer input::-moz-placeholder          {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}/* Firefox 19+ */
#ag_footer input:-moz-placeholder           {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}/* Firefox 18- */
#ag_footer input:-ms-input-placeholder      {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}

#ag_footer textarea::-webkit-input-placeholder {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}
#ag_footer textarea::-moz-placeholder          {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}/* Firefox 19+ */
#ag_footer textarea:-moz-placeholder           {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}/* Firefox 18- */
#ag_footer textarea:-ms-input-placeholder      {color:'.$ag_cfg_font_footer_color.'; opacity:0.5;}
#ag_footer .ag_login_form button, #ag_footer .ag_login_form button:hover, #ag_footer div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a {color:'.$ag_cfg_font_footer_color.';}
';
} else { echo '#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li.ag_this_list a {color:#cacacf;}'; }

if (!empty($ag_cfg_link_footer_color)) {
echo '#ag_footer a, #ag_footer a:hover {color:' .$ag_cfg_link_footer_color. ';}
#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li.ag_this_list a { color:' .$ag_cfg_link_footer_color. ';}
#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li a:hover { color:' .$ag_cfg_link_footer_color. ';}
#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li.ag_this_list a, #ag_footer div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span, 
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span:hover, 
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub:hover
{color:' .$ag_cfg_link_footer_color. ';}
#ag_footer .ag_login_form button.ag_button_active {color:' .$ag_cfg_link_footer_color. '!important;}
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_today span {background:'.$ag_cfg_link_footer_color.';}

#ag_footer button, #ag_footer button:hover, #ag_footer a.ag_button, #ag_footer span.ag_button, #ag_footer a.ag_button:hover, #ag_footer span.ag_button:hover 
{ background:' .$ag_cfg_link_footer_color. ';}
';
}
if (!empty($ag_cfg_link_hover_footer_color)) {
echo '#ag_footer a:hover {color:' .$ag_cfg_link_hover_footer_color. ';}
#ag_footer .ag_widget_block div.ag_post_item ul.ag_wgt_list li a:hover { color:' .$ag_cfg_link_hover_footer_color. ';}
.ag_widget_block .ag_login_form button:hover, #ag_footer div.ag_post_item ul.ag_wgt_full_list li.ag_cat_name h5 a:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_event span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar div.ag_obj_cal_view ul li a:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_prev span:hover, 
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td.ag_pc_next span:hover,
#ag_footer div.ag_post_item div.ag_pub_calendar table tr td span.ag_pc_sub:hover
{color:'.$ag_cfg_link_hover_footer_color.';}
#ag_footer button:hover,  #ag_footer a.ag_button:hover, #ag_footer span.ag_button:hover {background:'.$ag_cfg_link_hover_footer_color.';}

';
}
if (!empty($ag_cfg_copy_bgcolor)) {
echo '.ag_copy {background:' .$ag_cfg_copy_bgcolor. '; border:none;}';
}


if (isset($ag_cfg_input_background) && !empty($ag_cfg_input_background)) {
echo 'label, #ag_footer label, #ag_top_search, select, #ag_footer select {background:'.$ag_cfg_input_background.'; border:none;}
.ag_catpcha label, #ag_footer .ag_catpcha label {border: '.$ag_cfg_input_background.' 1px solid;}
#ag_footer div.ag_post_item div.ag_pub_calendar table tr th, #ag_footer div.ag_post_item div.ag_pub_calendar table tr td, #ag_footer select {background:'.$ag_cfg_input_background.';}
#ag_main_form span.ag_spots_input, #ag_booking_form label {background:'.$ag_cfg_input_background.';}
';
}
if (isset($ag_cfg_input_top_background) && !empty($ag_cfg_input_top_background)) {
echo '#ag_top label, #ag_top_search {background:'.$ag_cfg_input_top_background.'!important;}';
}


if (!empty($ag_cfg_custom_css)) {
$ag_cfg_custom_css = html_entity_decode($ag_cfg_custom_css, ENT_QUOTES, 'UTF-8');
$ag_cfg_custom_css = str_replace($ag_separator[3], "\n", $ag_cfg_custom_css);	
echo $ag_cfg_custom_css;
}

if (isset($ag_cfg_input_footer_background) && !empty($ag_cfg_input_footer_background)) {
echo '#ag_footer label, #ag_footer select, #ag_footer input, #ag_footer textarea {background:'.$ag_cfg_input_footer_background.';}
#ag_footer .ag_catpcha label {border:'.$ag_cfg_input_footer_background.' 1px solid;}
#ag_footer div.ag_post_item div.ag_pub_calendar table tr th, #ag_footer div.ag_post_item div.ag_pub_calendar table tr td, #ag_footer select.ag_pc_month_select, #ag_footer select {background:'.$ag_cfg_input_footer_background.';}
';
}
?>
</style>

<style id="ag_fade_in_page">#ag_main {opacity:0;}</style>


<noscript><style>#ag_main {opacity:1;}</style><link rel="stylesheet" href="css/icons/fontello.css" /></noscript>

</head>

<body>
<div id="ag_load"><div></div></div>
<div id="ag_main">

<header>

<!-- ag_menu -->
<?php if (isset($ag_cfg_hidden_menu) && $ag_cfg_hidden_menu == '1') { echo '<div class="ag_hidden_menu">&#160;</div>'; } else { ?>
<div id="ag_mob_top_panel"><div class="ag_mob_top_panel_inner">
<div id="ag_button_menu" class="ag_button_menu" tabindex="-1" onclick="ag_menu()"><i class="icon-menu"></i></div>

<!-- search form -->
<?php if ($ag_check_count_objects > 1) { if (isset($ag_cfg_hidden_search) && $ag_cfg_hidden_search == '1') { } else { echo $ag_search_form; } } ?>
<!-- /search form -->

</div></div><!-- /ag_mob_top_panel -->

<div id="ag_menu" class="ag_menu"><nav><?php echo ag_menu(); ?></nav>
<div class="ag_clear"></div>
<div id="ag_close_menu" class="ag_button_menu" tabindex="-1" onclick="ag_menu_close()"><i class="icon-cancel"></i></div>
</div>
<?php } // hidden menu ?>
<!-- /ag_menu -->

<!-- ag_top -->
<?php if (isset($ag_cfg_hidden_header) && $ag_cfg_hidden_header == '1') { echo '<div class="ag_hidden_header">&#160;</div>'; } else { ?>
<div id="ag_top" class="ag_top">
<div class="ag_top_layot">
<div class="ag_top_decor"></div>

<div class="ag_top_inner">

<?php if (!empty($ag_cfg_logo) && file_exists($ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo)) { ?>
<div class="ag_top_logo">
<a href="<?php echo $srv_absolute_url; ?>"><img src="<?php echo $ag_data_dir.'/'.$ag_upload_name.$ag_cfg_logo ?>" alt="<?php echo $ag_cfg_title; ?>" /></a>
</div>
<?php } ?>

<div class="ag_top_title">
<h2><a href="<?php echo $srv_absolute_url; ?>"><?php echo $ag_cfg_title; ?></a></h2>
<h1><?php echo $ag_cfg_description; ?></h1>
</div>

<?php $ag_check_count_objects = ag_check_obj();
if ($ag_check_count_objects > 1) { if (isset($ag_cfg_hidden_search) && $ag_cfg_hidden_search == '1') { } else { echo '<div class="ag_top_search" id="ag_top_search">'.$ag_search_form.'</div>';} }
?>

<div class="ag_clear"></div>
</div><!-- /ag_top_inner -->

</div><!-- /ag_top_layot -->
</div><!-- /ag_top -->
<?php } // hidden header ?>


<?php
if (isset($ag_cfg_header_code) && !empty($ag_cfg_header_code)) {
$ag_header_code = html_entity_decode($ag_cfg_header_code, ENT_QUOTES, 'UTF-8');
$ag_header_code = str_replace('::exactly::', '=', trim($ag_header_code));
if ($ag_header_code == '<script>'.$ag_separator[3].'</script>') {$ag_header_code = '';}
$ag_header_code = str_replace($ag_separator[3], "\n", $ag_header_code);

echo $ag_header_code;
}
?>


<?php 
if ($ag_is_mob == 1) {
if ($ag_cfg_slider_mob == 0) { echo ag_slider($ag_alias_cat); }	
} else { echo ag_slider($ag_alias_cat); }


?>
</header>