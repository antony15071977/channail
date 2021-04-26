<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) { header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die; }

$ag_inc_widgets = array();

$ag_this_url = $ag_protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//if ($ag_this_url{strlen($ag_this_url)-1} == '/') { $ag_this_url = substr($ag_this_url,0,-1); }

//============================= Login form


$ag_login_form_class = '';
$ag_login_form = '';

$ag_apanel_link = ag_apanel(); if (!empty($ag_apanel_link)) {

if (isset($ag_empty_login)) {
$ag_login_form_class = ' ag_empty_login';

$ag_login_form .= ag_return_html('<script>
  $(document).ready(function(){
	  
  var ag_id_lf_r_m = "";
  var ag_id_lf_r = "";
   
  if ($(".ag_widget_column_mobile").find("div.ag_login_form").length) {
	  ag_id_lf_r_m = $(".ag_widget_column_mobile").find(".ag_login_form").parents(".ag_post_item").attr("id"); 
	  }
  var ag_id_lf_r = $(".ag_widget_column").find(".ag_login_form").parents(".ag_post_item").attr("id"); 
  
	  
  if (ag_id_lf_r_m) {
  window.location.hash = ""; 
  $(".ag_widget_column_mobile").css({right:"0px"});
  setTimeout(function(){  
  var ag_lf_block_r = $("#"+ ag_id_lf_r_m);
  jQuery(".ag_widget_column_mobile").scrollTo(ag_lf_block_r, 500, {axis:"y", offset:0});
  }, 200);
  
  $("#ag_widgets_close").css({display:"block"});
  
  } 

});
</script>');
}
$ag_login_form .= '<div class="ag_login_form' .$ag_login_form_class. '"><form method="post" action="' .$ag_this_url. '">';
$ag_login_form .= '<div><label class="ag_login_apanel"><input type="text" name="ag_login" placeholder="' .$ag_lng['login']. '" onfocus="ag_active(this)" onblur="ag_out(this)" /></label></div>';
$ag_login_form .= '<div><label class="ag_passw_apanel"><input type="password" name="ag_pass" placeholder="' .$ag_lng['pass']. '" oninput="ag_login_button(this)" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';
$ag_login_form .= '<button title="'. $ag_lng['logon']. '"><i class="icon-right-open"></i></button></div>';
$ag_login_form .= '</form><div class="ag_clear"></div></div>';
$ag_login_form .= '<script>var ag_id_lf = $(".ag_login_form").parents(".ag_post_item").attr("id"); $("#" + ag_id_lf).find("form").attr("action", "' .$ag_this_url. '#" + ag_id_lf); </script>';
}




//============================= Mail form
$ag_captcha = 1; // 1 - Задействовать каптчу; 0 - Не использовать
if (isset($ag_cfg_wgt_captcha_mail)) {$ag_captcha = $ag_cfg_wgt_captcha_mail;}
$to_mail = $ag_cfg_email; // Адрес, куда будут отправляться письма (по умолчанию, на указанный в настройках общий e-mail)
if (isset($ag_cfg_wgt_address_mail) && !empty($ag_cfg_wgt_address_mail)) {$to_mail = $ag_cfg_wgt_address_mail;}
$ag_from = 'noreply@'.$_SERVER['HTTP_HOST']; // От кого
$ag_teme = $ag_lng['message_from_site'].' "'.$ag_cfg_title.'"'; // Тема письма
$ag_ip_sender = $ag_lng['ip_sender'].': '.$_SERVER['REMOTE_ADDR']; // Примечание
$ag_done_message = $ag_lng['mail_done_message'].'.'; // Сообщение о выполнении
$ag_disallow_sent = array('http', 'www', 'href'); // Остановить отправку письма, если оно содержит перечисленные значения (спам)
$ag_wgt_policy_mail = '';
$ag_wgt_title_policy_mail = $ag_lng['accept_policy'];
if (isset($ag_cfg_wgt_policy_mail) && !empty($ag_cfg_wgt_policy_mail)) {
$ag_wgt_policy_mail	= $ag_cfg_wgt_policy_mail;
$ag_wgt_policy_mail = str_replace($ag_separator[3], '<br />', $ag_wgt_policy_mail);
}
if (isset($ag_cfg_wgt_title_policy_mail) && !empty($ag_cfg_wgt_title_policy_mail)) {$ag_wgt_title_policy_mail = $ag_cfg_wgt_title_policy_mail;}

//--------------------------------------------------------------------------------
$ag_mail_done_block = '';
$ag_color = $ag_cfg_a_color;

unset($M_ERROR);
$ag_name = '';
$ag_mail = '';
$ag_text = '';
$ag_mail_error_message = '';


//-----------------------------------------------
$ag_mail_form = '';
if (isset($_POST['ag_name'])) {
 $ag_name = $_POST['ag_name'];
 if (!empty($ag_name)) {
 foreach($ag_disallow_sent as $dis_el) {
 if (preg_match('/'.$dis_el.'/i', $ag_name)) { $M_ERROR['qtext'] = $ag_lng['mail_error_spam']; break; }
 }
 $ag_name = htmlspecialchars($ag_name, ENT_QUOTES, 'UTF-8'); 
} else { $M_ERROR['ag_name'] = $ag_lng['mail_error_name']; }
}//isset post ag_name
 
if (isset($_POST['ag_mail'])) {
  $ag_mail = $_POST['ag_mail'];
  if (!empty($ag_mail)) {
 $ag_mail = htmlspecialchars($ag_mail, ENT_QUOTES, 'UTF-8'); 
 if(!preg_match('/.+@.+..+/i', $ag_mail)) { $M_ERROR['ag_mail'] = $ag_lng['mail_error_mail']; }
} else { $M_ERROR['ag_mail'] = $ag_lng['mail_error_empty_mail']; }
}//isset post ag_mail
 
if (isset($_POST['ag_text'])) {
  $ag_text = $_POST['ag_text'];
  if (!empty($ag_text)) {
    foreach($ag_disallow_sent as $dis_el) {
  if (preg_match('/'.$dis_el.'/i', $ag_text)) { $M_ERROR['qtext'] = $ag_lng['mail_error_spam']; break; }
     }
 
 $ag_text = htmlspecialchars($ag_text, ENT_QUOTES, 'UTF-8'); 
 
 $ag_text = str_replace(array("\n", "\r"), '<br />', $ag_text);
 
 $ag_text = str_replace('[b]', '<strong>', $ag_text);
 $ag_text = str_replace('[/b]', '</strong>', $ag_text);
 
 $ag_text = str_replace('[i]', '<i>', $ag_text);
 $ag_text = str_replace('[/i]', '</i>', $ag_text);
 
 $ag_text = str_replace('[u]', '<u>', $ag_text);
 $ag_text = str_replace('[/u]', '</u>', $ag_text);
 
 $ag_text = str_replace('[s]', '<small>', $ag_text);
 $ag_text = str_replace('[/s]', '</small>', $ag_text);
 
 $ag_text = ag_close_tags($ag_text);
 
} else { $M_ERROR['ag_text'] = $ag_lng['mail_error_text']; }
} //isset post ag_text
 
if ($ag_captcha == 1) { //enable captcha
if (isset($_POST['keystring'])) {
if (empty($_POST['keystring'])) {$M_ERROR['captcha'] = $ag_lng['mail_empty_captcha'];}
if (isset($_SESSION['captcha_keystring']) && strtolower($_SESSION['captcha_keystring']) != strtolower($_POST['keystring'])) {
$M_ERROR['captcha'] = $ag_lng['mail_error_captcha'];} 
} //isset post keystring
else {$M_ERROR['captcha'] = $ag_lng['mail_empty_captcha'];}
} else {$_POST['keystring'] = 1;}
 //check & sent
if (isset($_POST['ag_name']) && isset($_POST['ag_mail']) && isset($_POST['ag_text']) && isset($_POST['keystring'])) {
   
   
if (!empty($ag_wgt_policy_mail) && !isset($_POST['policy_accept'])) {$M_ERROR['policy_accept'] = $ag_lng['error_not_specified'].': &laquo;'.$ag_wgt_title_policy_mail.'&raquo;';}
 

if (isset($M_ERROR)) {
  $ag_mail_error_message .= '<ul class="ag_mail_form_message">';
  foreach($M_ERROR as $error_text) {$ag_mail_error_message .= '<li>' .$error_text. '</li>';}
  $ag_mail_error_message .= '</ul>';
} else { // send mail
  $ag_text = $ag_text. '<hr />'.$ag_lng['mail_from'].': <strong>' .$ag_name. ' ' .$ag_mail. '</strong>';
  ag_sent_mail($to_mail, $ag_name, $ag_from, $ag_teme, $ag_text, $ag_color, $ag_ip_sender);
  
  $ag_mail_done_block = '<ul class="ag_mail_form_message">';
  $ag_mail_done_block .= '<li class="ag_done_mess">';
  $ag_mail_done_block .= '<span>'.$ag_lng['thank_you'].' ' .$ag_name. '. ' .$ag_done_message. '</span>';
  $ag_mail_done_block .= '</li>';
  $ag_mail_done_block .= '</ul>';
 
  $to_mail = '';
  $ag_text = '';
  $ag_mail = '';
  $ag_name = '';


}
  
}

$ag_mail_form .= '<div class="ag_mail_block">';
$ag_mail_form .= $ag_mail_error_message;
$ag_mail_form .= $ag_mail_done_block;
$ag_mail_form .= '<form name="ag_feedback" method="post" action="'.$ag_this_url.'">';
$ag_mail_form .= '<label class="ag_first_fb"><input type="text" name="ag_name" placeholder="'.$ag_lng['name'].'" value="'.$ag_name.'" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';
$ag_mail_form .= '<label><input type="email" name="ag_mail" value="'.$ag_mail.'" placeholder="'.$ag_lng['email'].'" onfocus="ag_active(this)" onblur="ag_out(this)" /></label>';
$ag_mail_form .= '<label><textarea name="ag_text" placeholder="'.$ag_lng['message_text'].'" onfocus="ag_active(this)" onblur="ag_out(this)">'.$ag_text.'</textarea></label>';

if ($ag_captcha == 1) { 
$ag_mail_form .= '<div class="ag_catpcha"><img title="'.$ag_lng['change_captcha'].'" alt="captcha" onclick="this.src=this.src+\'&amp;\'+Math.round(Math.random())" src="inc/ag_captcha/imaga.php?'.session_name().'='.session_id().'" class="img_captcha" /></div>';
$ag_mail_form .= '<div class="ag_catpcha"><label><input type="text" name="keystring" value="" placeholder="'.$ag_lng['code'].'" onfocus="ag_active(this)" onblur="ag_out(this)" /></label></div>';
$ag_mail_form .= '<div class="clear"></div>';
} 

if (!empty($ag_wgt_policy_mail)) {
	$ag_policy_mail_checked = '';
	if (isset($_POST['policy_accept'])) {$ag_policy_mail_checked = ' checked="checked"';}
$ag_mail_form .= '<div class="ag_policy_input"><div class="ag_mob_table"><table class="ag_policy_block"><tbody><tr><td class="ag_policy_checkbox"><label class="ag_one_ceckbox" title="'.$ag_lng['accept'].'"><input type="checkbox" value="1" name="policy_accept"'.$ag_policy_mail_checked.' /><span class="ag_checkbox_custom"></span></label></td><td><div class="ag_policy_title" tabindex="-1" onclick="ag_policy(\'open\')"><span>'.$ag_wgt_title_policy_mail.'</span></div></td></tr></tbody></table></div><div class="ag_clear"></div></div>';
}

$ag_mail_form .= '<button>'.$ag_lng['sent'].'</button>';
$ag_mail_form .= '</form><div class="ag_clear"></div>';
$ag_mail_form .= '</div>';

if (!empty($ag_wgt_policy_mail)) {
$ag_wgt_policy_mail = str_replace('[:br:]', '<br />', $ag_wgt_policy_mail);
$ag_mail_form .= '<div class="ag_back_layer"></div>';
$ag_mail_form .= '<div class="ag_policy_text" style="display: block;"><div class="inner"><div class="ag_policy_text_inner">'.$ag_wgt_policy_mail.'<div class="ag_clear"></div><span class="ag_policy_close ag_button" tabindex="-1" onclick="ag_policy(\'close\')"><i class="icon-cancel"></i> Закрыть</span><div class="ag_clear"></div></div></div></div>';
}

$ag_mail_form .= ag_return_html('<script>
var ag_id_mf = $(".ag_mail_block").parents(".ag_post_item").attr("id"); $("#" + ag_id_mf).find("form").attr("action", "' .$ag_this_url. '#" + ag_id_mf);
$(".ag_policy_text").css({display:"none"});
function ag_policy(trig) {
if (trig == "open") {
	$(".ag_back_layer").fadeIn(250);
	$(".ag_policy_text").fadeIn(250);
	$("#ag_widgets_close").fadeOut(250);
	}
if (trig == "close") {
	$(".ag_policy_text").fadeOut(250);
	$(".ag_back_layer").fadeOut(250);
	$("#ag_widgets_close").fadeIn(250);
	}		
}
</script>');

if (isset($_POST['ag_name']) && isset($_POST['ag_mail']) && isset($_POST['ag_text']) && isset($_POST['keystring'])) {
   
  $ag_mail_form .= ag_return_html('<script>
  $(document).ready(function(){
	  
  var ag_id_mf_r_m = "";
  var ag_id_mf_r = "";
   
  if ($(".ag_widget_column_mobile").find("div.ag_mail_block").length) { 
	  ag_id_mf_r_m = $(".ag_widget_column_mobile").find(".ag_mail_block").parents(".ag_post_item").attr("id"); 
	  }
  var ag_id_mf_r = $(".ag_widget_column").find(".ag_mail_block").parents(".ag_post_item").attr("id"); 
  
	  
  if (ag_id_mf_r_m != "") {
  window.location.hash = ""; 
  $(".ag_widget_column_mobile").css({right:"0px"});
  setTimeout(function(){  
  var ag_mf_block_r = $("#"+ ag_id_mf_r_m);
  jQuery(".ag_widget_column_mobile").scrollTo(ag_mf_block_r, 500, {axis:"y", offset:0});
  }, 200);
  
  $("#ag_widgets_close").css({display:"block"});
  
  } 

});
</script>');
if (!isset($M_ERROR)) {
	unset($_POST['ag_name']);
	unset($_POST['ag_mail']);
	unset($_POST['ag_text']);
}
}



//============================= Last posts list
$ag_wgt_last_obj = '';
if (isset($ag_last_obj)) {$ag_wgt_last_obj = $ag_last_obj;}


//============================= Category list
$ag_wgt_last_cat = '';
if (isset($ag_cat_list)) {$ag_wgt_last_cat = $ag_cat_list;}


//============================= Full list
$ag_wgt_full_cat = '';
if (isset($ag_full_list)) {$ag_wgt_full_cat = $ag_full_list;}


//============================= Search form
$ag_wgt_query = '';
if (isset($_GET[$ag_get_search])) {$ag_wgt_query = htmlspecialchars($_GET[$ag_get_search], ENT_QUOTES, 'UTF-8');}
if (isset($_GET['_'.$ag_get_search])) {$ag_wgt_query = htmlspecialchars($_GET['_'.$ag_get_search], ENT_QUOTES, 'UTF-8');}
$ag_wgt_search_form = '<div class="ag_wgt_search_form">';
$ag_wgt_search_form .= '<form method="get" action="' .$ag_this_url. '">';
$ag_wgt_search_form .= '<div>';
$ag_wgt_search_form .= '<label class="ag_wgt_search">';
$ag_wgt_search_form .= '<input type="text" name="'.$ag_get_search.'" value="' .$ag_wgt_query. '" placeholder="' .$ag_lng['search']. '" onfocus="ag_active(this)" onblur="ag_out(this)" />';
$ag_wgt_search_form .= '</label>';
$ag_wgt_search_form .= '<button title="'. $ag_lng['search']. '"><i class="icon-right-open"></i></button>';
$ag_wgt_search_form .= '</div>';
$ag_wgt_search_form .= '</form>';
$ag_wgt_search_form .= '<div class="ag_clear"></div>';
$ag_wgt_search_form .= '</div>';



//============================= Calendar publication
$ag_pub_cal = '';
if (file_exists($ag_cfg_theme.'calendar_pub.php')) {
include($ag_cfg_theme.'calendar_pub.php');
$ag_pub_cal = '<div class="ag_pub_calendar">'.ag_pub_calendar().'</div>';
$ag_pub_cal .= ag_return_html('<script>
function ag_month_pc(e) {
var ad_date = $(e).attr("class"); 
var ag_id_pc = $(e).parents("div.ag_widget_block").find(".ag_pub_calendar").parents(".ag_post_item").attr("id"); 
$.post("'.$ag_cfg_theme.'calendar_pub.php", {  ag_date: ad_date },function onAjaxSuccess(data) { 
$("#" + ag_id_pc).find(".ag_pub_calendar").html(data);
}); 
}
function ag_period_pc(e) {
var ad_date_m = $(e).parents("tr").find("select").val();
var ad_date_y = $(e).parents("tr").find("input").val();
var ad_date = ad_date_y + "-" + ad_date_m; 
var ag_id_pc = $(e).parents("div.ag_widget_block").find(".ag_pub_calendar").parents(".ag_post_item").attr("id"); 
$.post("'.$ag_cfg_theme.'calendar_pub.php", {  ag_date: ad_date },function onAjaxSuccess(data) { 
$("#" + ag_id_pc).find(".ag_pub_calendar").html(data);
}); 	
}
function ag_today_pc(e) {
var ad_date = "'.date('Y').'-'.date('m').'";
var ag_id_pc = $(e).parents("div.ag_widget_block").find(".ag_pub_calendar").parents(".ag_post_item").attr("id"); 
$.post("'.$ag_cfg_theme.'calendar_pub.php", {  ag_date: ad_date },function onAjaxSuccess(data) { 
$("#" + ag_id_pc).find(".ag_pub_calendar").html(data);
}); 	
}
</script>');
}



//============================= Social links
$ag_list_soc_links = '';

if (isset($ag_ag_cfg_soc_links) && !empty($ag_ag_cfg_soc_links)) {

$ag_cfg_soc_links_arr = explode($ag_separator[2], $ag_ag_cfg_soc_links);


$ag_soc_link_a = array();
$ag_soc_link = '';
$ag_name_soc = '';


$ag_soc_icon = 'icon-globe-1';
if (!empty($ag_cfg_font_text_color)) { $ag_soc_icon_color = $ag_cfg_font_text_color;} else {$ag_soc_icon_color = '#000'; }

$ag_soc_icon_bg_color = '#f5f5f7';

foreach ($ag_cfg_soc_links_arr as $ag_soc_link_s) {

$ag_soc_link = '';
$ag_name_soc = '';

$ag_soc_link_a = explode('::', $ag_soc_link_s);
if (isset($ag_soc_link_a[0])) {$ag_soc_link = $ag_soc_link_a[0];}
if (isset($ag_soc_link_a[1])) {$ag_name_soc = $ag_soc_link_a[1];}		
	
//$ag_soc_link = mb_strtolower($ag_soc_link, 'utf8');
if (empty($ag_name_soc)) { $ag_name_soc = str_replace(array('http://', 'https://'), '', $ag_soc_link); }

//==================== soc links icons & colors

if (preg_match('/vk.com/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-vkontakte-2';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#507299';
}

else if (preg_match('/facebook/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-facebook-2';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#3B5998';
}

else if (preg_match('/youtu/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-youtube';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#E62117';
}

else if (preg_match('/soundcloud/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-soundcloud';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#FF5500';
}

else if (preg_match('/mail/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-at';
$ag_soc_icon_color = '#FFA930';
$ag_soc_icon_bg_color = '#168DE2';
}

else if (preg_match('/ok.ru/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-odnoklassniki';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#EE8208';
}

else if (preg_match('/twitter/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-twitter';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#1DA1F2';
}

else if (preg_match('/instagram/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-instagram-filled';
$ag_soc_icon_color = '#000';
$ag_soc_icon_bg_color = '#f7f7f9';
}

else if (preg_match('/google/i', $ag_soc_link)) {
$ag_soc_icon = 'icon-google-1';
$ag_soc_icon_color = '#fff';
$ag_soc_icon_bg_color = '#DD4E42';
}

else {
$ag_soc_icon = 'icon-network-1';
if (!empty($ag_cfg_font_text_color)) { $ag_soc_icon_color = $ag_cfg_font_text_color;} else {$ag_soc_icon_color = '#000'; }
if (!empty($ag_cfg_background_color)) {$ag_soc_icon_bg_color = $ag_cfg_background_color; } else { $ag_soc_icon_bg_color = '#ECECEF';}
}

$ag_list_soc_links .= '<h5>
<a href="' .$ag_soc_link. '" target="_blank"><i class="' .$ag_soc_icon. '" style="background:' .$ag_soc_icon_bg_color. '; color:' .$ag_soc_icon_color. ';"></i></a>
<a href="' .$ag_soc_link. '" target="_blank">' .$ag_name_soc. '</a>
</h5>';

}//foreach ag_cfg_soc_links_arr


}

$ag_wgt_soc_links = '<div class="ag_wgt_soc_links">';
$ag_wgt_soc_links .= ag_return_html($ag_list_soc_links);
$ag_wgt_soc_links .= '<div class="ag_clear"></div>';
$ag_wgt_soc_links .= '</div>';











$ag_status_socl = 0;
if (!empty($ag_list_soc_links)) {$ag_status_socl = 1;}

$ag_inc_widgets = array (
'ag_login_form' => array('id' => 'ag_login_form', 'name' => $ag_lng['wgt_apanel_name'], 'title' => $ag_lng['wgt_apanel_title'], 'icon' => 'icon-login-1', 'content' => $ag_login_form, 'status' => '1'),
'ag_mail_form' => array('id' => 'ag_mail_form', 'name' => $ag_lng['feed_back_name'], 'title' => $ag_lng['feed_back_title'], 'icon' => 'icon-email', 'content' => $ag_mail_form, 'status' => '1'),
'ag_last_obj' => array('id' => 'ag_last_obj', 'name' => $ag_lng['last_objects_name'], 'title' => $ag_lng['last_objects_title'], 'icon' => 'icon-arrows-cw-1', 'content' => $ag_wgt_last_obj, 'status' => '1'),
'ag_list_cat' => array('id' => 'ag_list_cat', 'name' => $ag_lng['categorys_name'], 'title' => $ag_lng['categorys'], 'icon' => 'icon-archive-2', 'content' => $ag_wgt_last_cat, 'status' => '1'),
'ag_list_full' => array('id' => 'ag_list_full', 'name' => $ag_lng['sitemap_name'], 'title' => $ag_lng['sitemap'], 'icon' => 'icon-sitemap', 'content' => $ag_wgt_full_cat, 'status' => '1'),
'ag_search_form' => array('id' => 'ag_search_form', 'name' => $ag_lng['search_wgt'], 'title' => $ag_lng['search_wgt'], 'icon' => 'icon-search', 'content' => $ag_wgt_search_form, 'status' => '1'),
'ag_pub_calendar' => array('id' => 'ag_pub_calendar', 'name' => $ag_lng['pub_calendar'], 'title' => $ag_lng['pub_calendar'], 'icon' => 'icon-calendar', 'content' => $ag_pub_cal, 'status' => '1'),
'ag_soc_link' => array('id' => 'ag_soc_link', 'name' => $ag_lng['soc_link_name'], 'title' => $ag_lng['soc_link_title'], 'icon' => 'icon-network-1', 'content' => $ag_wgt_soc_links, 'status' => $ag_status_socl),
);

?>