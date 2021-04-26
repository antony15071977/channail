<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}
if (session_id() == '') session_start();

$ag_auth = 0;
$ag_fm_key = 0;
$ag_auth_page = '';

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

foreach ($ag_db as $ag_auth_name => $ag_auth_val) {
if (in_array('login', $ag_auth_val) && in_array('pass', $ag_auth_val) && in_array('hash', $ag_auth_val)) {$ag_users_db = $ag_auth_name;}
}

if (isset($ag_users_db)) {
	
if (isset($_POST['ag_login']) && isset($_POST['ag_pass'])) {
$ag_login = htmlspecialchars($_POST['ag_login'], ENT_QUOTES, 'UTF-8');
$ag_passw = htmlspecialchars($_POST['ag_pass'], ENT_QUOTES, 'UTF-8');	
$ag_passw = sha1($ag_passw);

$ag_login = crypt(sha1($ag_login), substr($ag_login,0,2));
$ag_passw = crypt(sha1($ag_passw), substr($ag_passw,0,2));

$_SESSION['ag_login'.$session_per] = $ag_login;
$_SESSION['ag_passw'.$session_per] = $ag_passw;

}// post logon	





if(isset($_GET['remember']) && isset($_POST['ag_remember_email'])) {

if (empty($_POST['ag_remember_email'])) {
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
header("Location: ".$srv_script_absolute_url."?remember#empty_email");
} else {
$ag_rmail = htmlspecialchars($_POST['ag_remember_email'], ENT_QUOTES, 'UTF-8');	
}	
}
	
$ag_auth_data = ag_read_data($ag_data_dir.'/'.$ag_users_db.$agt);

$ag_users_id = '';
$ag_users_login = '';
$ag_users_pass = '';
$ag_users_hash = '';
$ag_users_name = '';
$ag_users_photo = '';
$ag_users_email = '';
$ag_users_access = 0;
$ag_users_status = '';


$ag_user_id = '';
$ag_user_login = '';
$ag_user_pass = '';
$ag_user_hash = '';
$ag_user_name = '';
$ag_user_photo = '';
$ag_user_email = '';
$ag_user_access = 0;
$ag_user_status = '';

$ag_found_email = 0;
$ag_message = '';
$ag_user_email = '';

$ag_this_access = 0;



foreach ($ag_auth_data as $an => $aval) {
	
if (isset($aval['id'])) {$ag_users_id = $aval['id'];}
if (isset($aval['login'])) {$ag_users_login = $aval['login'];}
if (isset($aval['pass'])) {$ag_users_pass = $aval['pass'];}
if (isset($aval['hash'])) {$ag_users_hash = $aval['hash'];}
if (isset($aval['name'])) {$ag_users_name = $aval['name'];}
if (isset($aval['photo'])) {$ag_users_photo = $aval['photo'];}
if (isset($aval['email'])) {$ag_users_email = $aval['email'];}
if (isset($aval['access'])) {$ag_users_access = $aval['access'];}
if (isset($aval['status'])) {$ag_users_status = $aval['status'];}


$ag_users_login_a = crypt(sha1($ag_users_login), substr($ag_users_login,0,2));
$ag_users_hash = crypt(sha1($ag_users_hash), substr($ag_users_hash,0,2));


if (isset($_SESSION['ag_login'.$session_per]) && isset($_SESSION['ag_passw'.$session_per])) {



// this user	
if (
$_SESSION['ag_login'.$session_per] == $ag_users_login_a && 
$_SESSION['ag_passw'.$session_per] == $ag_users_hash && 
$_SESSION['ag_uagent'.$session_per] == $ag_uagent_check &&
$_SESSION['ag_userip'.$session_per] == $ag_userip_check &&
!empty($ag_users_login) && 
!empty($ag_users_hash)
) {
	
$ag_user_id = $ag_users_id;
$ag_user_login = $ag_users_login;
$ag_user_pass = $ag_users_pass;
$ag_user_hash = $ag_users_hash;
$ag_user_name = $ag_users_name;
$ag_user_photo = $ag_users_photo;
$ag_user_email = $ag_users_email;
$ag_user_access = $ag_users_access;
$ag_user_status = $ag_users_status;

if ($ag_user_access == 'founder') { $ag_user_status = 1; $ag_this_access = 1;}
if ($ag_user_access == '1') { $ag_this_access = 1; }
	
if ($ag_user_status	== 1) {
$ag_auth = 1;
$ag_fm_key = sha1(date('Ymd')/17);	
} else { $ag_auth = 0; $ag_off_user = 1; }// user active
	
break;
} 

} else { $ag_auth = 0; } // isset ssession	


if (isset($ag_rmail) && $ag_rmail == $ag_users_email) { // send lost pass

$ag_found_email = 1;
$ag_user_login = $ag_users_login;
$ag_user_pass = $ag_users_pass;
$ag_user_name = $ag_users_name;
$ag_user_email = $ag_users_email;

$ag_message = '<h4 style="padding:0; margin:0;">'.$ag_lng['hello'].' '.$ag_user_name.'!</h4><br />
'.$ag_lng['login']. ': <b>' .$ag_user_login. '</b><br />'.$ag_lng['pass']. ': <b>' .$ag_user_pass. '</b><br />';

}// this user

}// foreach ag_auth_data


if (isset($ag_rmail) && $ag_found_email == 1 && !empty($ag_user_email)) {
ag_sent_mail($ag_user_email, '', '', $ag_lng['access_data'], $ag_message, '', '');
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
header("Location: ".$srv_script_absolute_url."#send_done");
//send
}

if (isset($ag_rmail) && $ag_found_email == 0 ) {
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
header("Location: ".$srv_script_absolute_url."?remember#not_found");
//not found email
}

if (isset($_POST['ag_login']) && empty($_POST['ag_login']) || isset($_POST['ag_pass']) && empty($_POST['ag_pass'])) {
ag_exit($srv_script_absolute_url.'#empty_login');  die; // exit	
}// empty_login

if (isset($_SESSION['ag_login'.$session_per]) && isset($_SESSION['ag_passw'.$session_per]) && $ag_auth == 0) { 
if (isset($ag_off_user)) { ag_exit($srv_script_absolute_url.'#user_off'); die; } //user off
if (isset($_GET['tab'])) { ag_exit($srv_script_absolute_url.'#relogin'); die; } //relogin
ag_exit($srv_script_absolute_url.'#login_error');  die; // exit

}// ag_auth == 0
	

} else { die('<h1 class="ag_error_str">Error. Not found users data!</h1>'); }



$ag_lg_form_action = str_replace('index.php', '', $srv_script_absolute_url);

//--------------------------------------------------------
//var use to bottom.php
$ag_id_url = '';
$ag_tab_url = '';
$ag_this_id = '';
$ag_db_settings_reverse = '';

$ag_back_url = str_replace('index.php', '', $srv_script_absolute_url);


if ($ag_auth == 0) {
session_destroy();	
if (isset($ag_post_php)) { $ag_ERROR['access'] = $ag_lng['access_denied']; } else {
if(!isset($ag_salt)) {unset($ag_index);}	
$ag_title_logon_form = $ag_cfg_title;	
if (empty($ag_cfg_title)) {	
$ag_title_logon_form = $ag_product;
}
	
	
$ag_auth_page = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .$ag_lng_value. '" lang="' .$ag_lng_value. '">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />


<title>' .$ag_lng['logon']. ' - ' .$ag_title_logon_form. '</title>
<link rel="stylesheet" href="../css/icons/fontello.css" />
<link rel="stylesheet" href="../css/icons/animation.css" />
<link rel="stylesheet" href="../css/main.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../css/colorbox.css" />';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_auth_page .= '
<link rel="stylesheet" href="../css/mobile.css" />';
} 
$ag_auth_page .= '
<meta name="robots" content="noindex, nofollow" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<script src="../js/jquery-2.1.1.js"></script>
<script src="../js/jquery.colorbox-min.js"></script>
<style>#ag_main {opacity:0;}</style>
<script>$(document).ready(function(){$("#ag_main").animate({opacity:"1"}, 300);});</script>
<noscript><style>#ag_main {opacity:1;}</style></noscript>
</head>


<body class="ag_login_body">
<div id="ag_main">


<div class="ag_logon_form">

<div class="ag_top_login_form"><h3><i class="icon-login-1"></i>' .$ag_title_logon_form. '</h3></div>

<div class="ag_login_form_inner">';

if(isset($_GET['remember'])) { 

$ag_auth_page .= '
<form action="' .$ag_lg_form_action. '?remember" method="post">
<div class="ag_edit_form">';

$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { 
$ag_auth_page .= '<div class="ag_title_element">
<div>' .$ag_lng['email']. ':</div>
</div>';
} 

$ag_auth_page .= '
<div class="ag_elements_area">
<div class="ag_form_element" id="ag_login_input">
<label id="label_ag_login_input" class="">';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_auth_page .= '
<input type="email" name="ag_remember_email" value="" placeholder="' .$ag_lng['email']. '" id="input_ag_login_input" onfocus="ag_active(\'label_ag_login_input\')" onblur="ag_out(\'label_ag_login_input\')" />';
} else { 
$ag_auth_page .= '
<input type="email" name="ag_remember_email" value="" id="input_ag_login_input" onfocus="ag_active(\'label_ag_login_input\')" onblur="ag_out(\'label_ag_login_input\')">';
} 
$ag_auth_page .= '
<span class="element_tools">
<span class="ag_icon_element"><i class="icon-email"></i></span>
</span>
</label>
<div class="clear"></div>
</div>
</div>


<div class="clear"></div>
</div>

<div class="ag_edit_form ag_button_login">
<a href="' .$ag_back_url. '" class="ag_remember">' .$ag_lng['back']. '</a>
<button class="ag_btn_big"><i class="icon-right-open-5"></i><span>' .$ag_lng['send']. '</span></button>
<div class="clear"></div>
</div>


</form>';

} else {

$ag_auth_page .= '
<form action="' .$ag_lg_form_action. '" method="post">

<div class="ag_edit_form">';

$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { 
$ag_auth_page .= '
<div class="ag_title_element">
<div>' .$ag_lng['login']. ':</div>
</div>';
} 
$ag_auth_page .= '
<div class="ag_elements_area">
<div class="ag_form_element" id="ag_login_input">
<label id="label_ag_login_input" class="">';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_auth_page .= '
<input type="text" name="ag_login" value="" placeholder="' .$ag_lng['login']. '" id="input_ag_login_input" onfocus="ag_active(\'label_ag_login_input\')" onblur="ag_out(\'label_ag_login_input\')" />';
} else {
$ag_auth_page .= '
<input type="text" name="ag_login" value="" id="input_ag_login_input" onfocus="ag_active(\'label_ag_login_input\')" onblur="ag_out(\'label_ag_login_input\')">';
} 
$ag_auth_page .= '
<span class="element_tools">
<span class="ag_icon_element"><i class="icon-group"></i></span>
</span>
</label>
<div class="clear"></div>
</div>
</div>


<div class="clear"></div>
</div>


<div class="ag_edit_form">';

$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { 
$ag_auth_page .= '
<div class="ag_title_element">
<div>' .$ag_lng['pass']. ':</div>
</div>';
}

$ag_auth_page .= '
<div class="ag_elements_area">
<div class="ag_form_element" id="ag_pass_input">
<label id="label_ag_pass_input" class="">';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
$ag_auth_page .= '
<input type="password" name="ag_pass" value="" placeholder="' .$ag_lng['pass']. '" id="input_ag_pass_input" onfocus="ag_active(\'label_ag_pass_input\')" onblur="ag_out(\'label_ag_pass_input\')" />';
} else {
$ag_auth_page .= '
<input type="password" name="ag_pass" value="" id="input_ag_pass_input" onfocus="ag_active(\'label_ag_pass_input\')" onblur="ag_out(\'label_ag_pass_input\')" />';
} 
$ag_auth_page .= '
<span class="element_tools">
<span class="ag_icon_element"><i class="icon-key-5"></i></span>
</span>
</label>
<div class="clear"></div>
</div>
</div>
<div class="clear"></div>
</div>



<div class="ag_edit_form ag_button_login">
<a href="?remember" class="ag_remember">' .$ag_lng['not_remember_password']. '</a>
<button class="ag_btn_big"><i class="icon-right-open-5"></i><span>'. $ag_lng['logon']. '</span></button>
<div class="clear"></div>
</div>

</form>';
}

$ag_auth_page .= '
</div>
</div>';

$ag_auth_page .= '
<script>
$(document).ready(function(){
var ag_mess = window.location.hash.replace("#","");	
if (ag_mess != "") {
	
if (ag_mess == "login_error") {
$(".ag_logon_form").addClass("ag_error_logon");
ag_dialog("2000", "' .$ag_lng['error_login']. '", "' .$ag_lng['access_denied']. '", "quick_mess", "icon-roadblock ag_str_red", "");
}

if (ag_mess == "empty_login") {
$(".ag_logon_form").addClass("ag_error_logon");
ag_dialog("2000", "' .$ag_lng['empty_login']. '", "' .$ag_lng['error']. '", "quick_mess", "icon-roadblock ag_str_red", "");
}

if (ag_mess == "empty_email") {
$(".ag_logon_form").addClass("ag_error_logon");
ag_dialog("2000", "' .$ag_lng['empty_email']. '", "' .$ag_lng['error']. '", "quick_mess", "icon-roadblock ag_str_red", "");
}

if (ag_mess == "not_found") {
$(".ag_logon_form").addClass("ag_error_logon");
ag_dialog("5000", "' .$ag_lng['email_not_found']. '", "' .$ag_lng['error']. '", "quick_mess", "icon-roadblock ag_str_red", "");
}

if (ag_mess == "user_off") {
ag_dialog("5000", "' .$ag_lng['error_user_off']. '", "' .$ag_lng['access_denied']. '", "quick_mess", "icon-off ag_str_red", "");
}

if (ag_mess == "send_done") {
ag_dialog("5000", "' .$ag_lng['access_data_send_done']. '", "' .$ag_lng['done']. '", "ag_cancel", "icon-email ag_str_green", "button0");
}

if (ag_mess == "relogin") {
ag_dialog("5000", "' .$ag_lng['relogin']. '", "' .$ag_lng['waring']. '", "ag_cancel", "icon-logout-1 ag_str_orange", "link_home");
}

window.location.hash = "";
}
});
</script>';
} // no ag_post_php


$ag_self_p = $_SERVER['PHP_SELF'];
$ag_self_arr = explode('/', $ag_self_p);
$ag_self = array_pop($ag_self_arr);
if(!isset($ag_cl)) {unset($ag_index);}
if ($ag_self == 'ag_post.php' && $ag_auth == 0 || $ag_self == 'ag_update_menu.php' && $ag_auth == 0 || $ag_self == 'dialog.php' && $ag_auth == 0) {
header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']);
die(); 
}

if (!isset($ag_post_php)) {
$ag_bottom_html = '';
echo ag_return_html($ag_auth_page);
ob_start(); 
include ('inc/bottom.php'); 
$ag_bottom_html = ob_get_contents(); 
$ag_bottom_html = ag_return_html($ag_bottom_html);
ob_end_clean();
echo $ag_bottom_html;
}

die(); 
} // auth 0

?>