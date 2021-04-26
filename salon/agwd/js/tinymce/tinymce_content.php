<?php // AgCMS | May 2016 | Autor: Шаклеин Максим (Shaklein Maxim) | www.agwd.ru (c)
$ag_index = 1;
include ('../../inc/host.php');
include ('../../inc/db_conf.php');
$ag_data_dir = '../../'.$ag_data_dir;
include ($ag_data_dir. '/'. $ag_config); 
include ('../../inc/functions.php');
header("Content-type: text/css; charset: UTF-8");

?>
@import url("../../css/icons/fontello.css");

body {padding:9px; font-family: 'Helvеtica Neue', Helvetica, Arial, sans-serif; font-size:18px; color:#121117;}
td, pre, div { margin:0; padding:0;}

@font-face {
 font-family: 'oswaldmain';
 src: url('../../css/fonts/oswald/oswald.eot');
 src: url('../../css/fonts/oswald/oswald.eot?#iefix') format('embedded-opentype'),
 url('../../css/fonts/oswald/oswald.woff') format('woff'),
 url('../../css/fonts/oswald/oswald.ttf') format('truetype');
 font-weight: normal;
 font-style: normal;
}

h1, h2, h3, h4, h5, h6 {
display:block; 
margin:0; 
padding:0; 
font-weight:normal;
font-family: 'oswaldmain';
}

a { color:#FC8F1A; text-decoration:underline; outline:none; transition: all 0.2s ease-in-out;}
a:hover { color:#413d51; text-decoration:underline; }

input, select, textarea, button {
padding:0;
margin:0;
border:0;
outline:none;
background:#fff;
font-size:100%;
font-family: 'Helvеtica Neue', Helvetica, Arial, sans-serif;
}
input:disabled, textarea:disabled {cursor:default; color:#95959a;}

button::-moz-focus-inner {
    padding: 0;
    border: 0
}

button, a.ag_button, span.ag_button {
line-height:1.1;
display:inline-block; 
width:auto;
margin:18px auto 0 auto; 
padding:18px 24px; 
font-weight:normal;	
color:#fff!important;
background:#FC8F1A;
border-radius:2px;
text-decoration:none;
text-align:center;
cursor:pointer;
}

button:hover, a.ag_button:hover, span.ag_button:hover {
color:#fff!important;
background:#38363d;
text-decoration:none;
}

hr {
clear: both;
    height: 0px;
    background: none;
    border: 0;
    border-bottom: #d7d7d9 1px solid;
    box-shadow: 0 1px 1px #fff;
    padding: 10px 0 0 0;
    margin: 0 0 10px 0;
    display: block;	
}

@import url("../../css/icons/fontello.css");
@import url("../../css/icons/animation.css");

 h1 {font-size:180%;}
 h2 {font-size:160%;}
 h3 {font-size:140%;}
 h4 {font-size:120%;}
 h5 {font-size:120%;}
 
body {background:#FFF;}
body.mceForceColors {background:#FFF; color:#000;}

p {margin:0; line-height:1.6;}


table {border-collapse:collapse; border-spacing:0; width:100%; margin:0; padding:0;}
table tr {background:none;}
table tr:nth-child(2n) {background:#f7f7f9;}
table th {background:none; padding:18px; font-weight:normal; text-align:left; 
color:#474A59; font-size:120%;}
table td {background:none; box-shadow:none; padding:18px;}
table td, table th {border:#d9d9db 1px solid;}

<?php 
$ag_fonts = array($ag_cfg_font_title, $ag_cfg_font_description, $ag_cfg_font_menu, $ag_cfg_font_h, $ag_cfg_font_text);
$ag_fonts = array_diff($ag_fonts, array(''));
$ag_fonts = array_unique($ag_fonts);

if (!empty($ag_fonts)) {

foreach ($ag_fonts as $fp) {
$fp = '../../'. $fp;
if (file_exists($fp) && ag_file_list($fp, 'ttf') && ag_file_list($fp, 'woff')) {
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
//text font
$ag_font = '"Helvеtica Neue", Helvetica, Arial, sans-serif';
if (!empty($ag_cfg_font_text)) {
$ag_font_text = explode('/', $ag_cfg_font_text); $ag_font_text = array_diff($ag_font_text, array(''));
$ag_font = array_pop($ag_font_text);
} 
$ag_font_size = '';
if (!empty($ag_cfg_font_size) && $ag_cfg_font_size >= '8' && $ag_cfg_font_size < '32') {$ag_font_size = 'font-size:'.$ag_cfg_font_size.'px;';}
echo 'body {font-family: '.$ag_font.'; '.$ag_font_size.'} input {font-family: '.$ag_font.'; }';			
//h font
if (!empty($ag_cfg_font_h)) {
$ag_font_h = explode('/', $ag_cfg_font_h); $ag_font_h = array_diff($ag_font_h, array(''));
echo 'h1,h2,h3,h4,h5,h6 {font-family: "'.array_pop($ag_font_h).'";}';			
} else { echo 'h1,h2,h3,h4,h5,h6 {font-family: '.$ag_font.';}'; } 
//title font
if (!empty($ag_cfg_font_title)) {
$ag_font_title = explode('/', $ag_cfg_font_title); $ag_font_title = array_diff($ag_font_title, array(''));
echo '.ag_top h2 {font-family: "'.array_pop($ag_font_title).'"!important; }';	
} else { echo '.ag_top h2 {font-family: '.$ag_font.';}'; }
//description font
if (!empty($ag_cfg_font_description)) {
$ag_font_description = explode('/', $ag_cfg_font_description); $ag_font_description = array_diff($ag_font_description, array(''));
echo '.ag_top h1 {font-family: "'.array_pop($ag_font_description).'"!important; }';	
} else { echo '.ag_top h1 {font-family: '.$ag_font.';}'; }
//menu font
if (!empty($ag_cfg_font_menu)) {
$ag_font_menu = explode('/', $ag_cfg_font_menu); $ag_font_menu = array_diff($ag_font_menu, array(''));
echo '.ag_menu ul li h3 {font-family: "'.array_pop($ag_font_menu).'"!important;}';		
} else { echo '.ag_menu ul li h3 {font-family: '.$ag_font.';}'; } 



//custom colors
if (!empty($ag_cfg_font_title_color)) {
echo '
.ag_top h2, 
.ag_top h2 a 
{color:' .$ag_cfg_font_title_color. ';}';
} 
if (!empty($ag_cfg_a_color)) {
echo '
a, a:hover,
#ag_footer .ag_login_form button.ag_button_active,
.ag_search_submit i.icon-right-open
{color:' .$ag_cfg_a_color. '!important;} 
button, 
a.ag_button, 
span.ag_button, 
.ag_pages_nav ul li span, 
.ag_menu ul li span, 
#ag_load div 
{background:' .$ag_cfg_a_color. ';}' ;
} 
if (!empty($ag_cfg_a_hover_color)) {
echo 'a:hover 
{color:' .$ag_cfg_a_hover_color. '!important;} 
button:hover, 
a.ag_button:hover, 
span.ag_button:hover, 
.ag_pages_nav ul li a:hover 
{background:' .$ag_cfg_a_hover_color. ';}';
} 
if (!empty($ag_cfg_ae_color)) {
echo '
button, 
a.ag_button, span.ag_button, 
.ag_pages_nav ul li span,
{color:'.$ag_cfg_ae_color.';}'; 
}
if (!empty($ag_cfg_ae_hover_color)) {
echo '
button:hover, 
a.ag_button:hover, 
span.ag_button:hover,
.ag_pages_nav ul li a:hover
{color:'.$ag_cfg_ae_hover_color.';}'; 
}
if (!empty($ag_cfg_font_h_color)) {
echo 'h1,h2,h3,h4,h5,h6 {color:'.$ag_cfg_font_h_color.';}';
}
if (!empty($ag_cfg_font_text_color)) {
echo 'body, input, select, textarea {color:'.$ag_cfg_font_text_color.';}';
}
if (isset($ag_cfg_items_background_color) && !empty($ag_cfg_items_background_color)) { 	
echo 'body, input, select, textarea, body.mceForceColors {background:'.$ag_cfg_items_background_color.';}
table tr {background:rgba(255,255,255,0.25);}
table tr:nth-child(2n) {background:rgba(255,255,255,0.12);}
table td, table th {border: rgba(255,255,255,0.12) 1px solid;}
';
}
?>


video {max-width:100%!important; clear:both; min-width:50%!important; height:auto!important; margin:18px auto; padding:0; display:block; border: #F5F5F7 18px solid; }
audio {max-width:100%!important; clear:both; min-width:50%!important; margin:18px auto; padding:0; display:block;}

img {
margin: 0 18px 18px 0;	
}

ol, ul {
	list-style: disc;
	clear:both;
}
ol ol, ul ul {
	list-style: circle;
	margin:18px;
}
ol ol ol, ul ul ul {
	list-style: square;
	margin: 0 18px;
}

ol li, ul li {
padding:6px 0;	
}

p {line-height:1.6;}
 
a, span{
outline:none;
}



.target_button {margin:18px 0; padding:0;}
.target_button a {
display:inline-block;
line-height:1.4; 
padding: 18px 32px 18px 32px; 
color:#fff!important; 
background:#FFA000;
border-radius: 2px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
-khtml-border-radius: 2px;
text-decoration:none;
font-size:108%;
box-shadow: inset 0px 22px 44px rgba(255, 255, 255, 0.14);
}
.target_button a:hover, .target_button a:focus {background:#474A59; color:#fff!important; } 

[class*=" icon-"]:before,[class^=icon-]:before{font-family:fontello;font-style:normal;font-weight:400;speak:none;display:inline-block;text-decoration:inherit;width:1em;margin-right:.2em;text-align:center;font-variant:normal;text-transform:none;line-height:1em;margin-left:.2em;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}


a.ag_button_store {
display:inline-block;	
border-radius:4px;
outline:none;
overflow:hidden;
background:#000;
color:#fff!important;
border:#fff 1px solid;
min-width:190px;
}
.ag_button_store span.ag_icon_store {
display:block;
float:left;
padding:0;
width:61px;
height:61px;
line-height:61px;
text-align:center;
font-size:32px;
background:rgba(255,255,255,0.25);	
border-right: #fff 1px solid;
}
.ag_button_store span.ag_icon_store, .ag_button_store span.ag_icon_store:before {
margin: 0 0 0 0;
padding: 0 0 0 0;	
text-align:center;
}
.ag_button_store span.ag_icon_store:before {margin-left:9px;}

.ag_button_store span.ag_text_store {
display:block;
float:left;
padding:0 18px;
width:auto;
height:61px;
text-align:left!important;
}
.ag_button_store span.ag_text_store span {
display:block;
height:30px;
line-height:30px;
font-size:14px;
text-align:left!important;
}
.ag_button_store span.ag_text_store span.ag_title_store {
border-top: #fff 1px solid;
font-weight:bold;
font-size:16px;
}	
	
.ag_button_store:hover {
background:#252529;
}	
	
table img{margin:0}

.agpb {clear:both!important;height:4px; border:#000 1px dashed;}

ag_clear{clear:both!important;display:block!important;height:0!important;width:0!important;border:0!important;padding:0!important;margin:0!important;font-size:0!important;line-height:0!important;visibility:hidden!important;float:none!important}