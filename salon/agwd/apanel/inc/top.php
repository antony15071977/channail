<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) { header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die; } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $ag_lng_value; ?>" lang="<?php echo $ag_lng_value; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $ag_title_tab; if (isset($ag_title_cat) && !empty($ag_title_cat)) {echo ' - '.$ag_title_cat;} if (empty($ag_title_tab)) {if (empty($ag_cfg_title)) {echo $ag_product;} else {echo $ag_cfg_title;} } else {if (empty($ag_cfg_title)) { echo ' - '.$ag_product; } else { if(isset($_GET['tab']) || isset($_GET['settings'])) { echo ' - '.$ag_cfg_title;} } } ?></title>
<link rel="stylesheet" href="../css/icons/fontello.css" />
<link rel="stylesheet" href="../css/icons/animation.css" />
<link rel="stylesheet" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../css/main.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" href="../css/colorbox.css" />
<link rel="stylesheet" href="../css/datepicker.css" />

<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
<link rel="stylesheet" href="../css/mobile.css" />
<?php } ?>
<meta name="robots" content="noindex, nofollow" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
<script src="../js/jquery-2.1.1.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/jquery.ui.touch-punch.min.js"></script>
<?php if (!isset($ag_cfg_editor) || isset($ag_cfg_editor) && empty($ag_cfg_editor)) {$ag_cfg_editor = 'tinymce';} // editors conf ?>
<?php if ($ag_cfg_editor == 'tinymce') { ?> <script src="../js/tinymce/tinymce.min.js"></script> <?php } ?>
<?php if ($ag_cfg_editor == 'ckeditor') { ?> <script src="../js/ckeditor/ckeditor.js"></script> <?php } ?>
<?php 

$ag_fonts_arr = array();
if (file_exists('../fonts')){
$ag_fonts_dir = ag_file_list('../fonts', 'dir');
    foreach ($ag_fonts_dir as $nf => $font) {
	$font_path = $font['name'];
	if (ag_file_list($font_path, 'ttf') && ag_file_list($font_path, 'woff')) {
	$font_name_arr = explode('/', $font_path); $font_name_arr = array_diff($font_name_arr, array(''));
	$font_names = array_pop($font_name_arr);
	$ag_fonts_arr[$font_names] = $font_path;
	}
  }

if (!empty($ag_fonts_arr)) {
echo '<style>';	
foreach ($ag_fonts_arr as $fn => $fp) {
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
.ag_'.$fn.' { font-family: \''.$fn.'\'!important; }
.ag_'.$fn.':first-letter { text-transform: uppercase; }
';	

}
echo '</style>';	
}
}// file_exists fonts
?>

<script>

//*---return top---
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { ?>
$(document).ready(function() {
    $('<div id="ag_arrow_top"><i class="icon-up-1"></i></div>').insertAfter('#ag_edit_block');
    $("#ag_edit_block").scroll(function() {	
	
if ($(this).scrollTop() >= 400) {$('#ag_arrow_top').fadeIn();} else { $('#ag_arrow_top').fadeOut(); }
	
if ($(this).scrollTop() >= 1) {$(".ag_scroll_top").fadeIn(100);} else {$(".ag_scroll_top").fadeOut(200);}

});
  $('#ag_arrow_top').click(function() {
    $("#ag_edit_block").animate( {scrollTop: 0}, 'slow')
  })
});
<?php } ?>


var pu_win_w = $(window).width();
var pu_win_h = $(window).height();
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
pu_win_w = pu_win_w;
pu_win_h = pu_win_h;
<?php } else { ?>
pu_win_w = pu_win_w * 80 / 100;
pu_win_h = pu_win_h * 70 / 100;
<?php } ?>

function Ag_windowSize(){
pu_win_w = $(window).width(); 
pu_win_h = $(window).height();
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
pu_win_w = pu_win_w;
pu_win_h = pu_win_h;
<?php } else { ?>
pu_win_w = pu_win_w * 80 / 100;
pu_win_h = pu_win_h * 70 / 100;
<?php } ?>
}
$(window).resize(function() { Ag_windowSize(); });



//*---tinymce editor---
<?php if ($ag_cfg_editor == 'tinymce') { ?>

tinymce.init({
selector: ".editor",
language: 'ru',
skin: 'argentum',
height: 320,
convert_urls : false,
relative_urls: false,
verify_html : true,
content_css : "../js/tinymce/tinymce_content.php",
pagebreak_split_block: true,

<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
plugins: [
    "code fullscreen nonbreaking codemirror",
  ],
<?php } else { ?>
plugins: [
    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking codemirror linkbutton ag_gaw",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern responsivefilemanager ag_news"
  ],
<?php } ?>
//*---filemanager---
external_filemanager_path:"<?php echo $srv_absolute_url; ?>filemanager/",
external_plugins: { "filemanager" : "<?php echo $srv_absolute_url; ?>filemanager/plugin.min.js" },
filemanager_title: "Файлы" ,
image_advtab: true,
//*---codemirror---
codemirror: {
    indentOnInit: true, 
    fullscreen: false,   
    config: {         
       mode: 'application/x-httpd-php',
       lineNumbers: true
    },
    width: pu_win_w, 
    height: pu_win_h,
    jsFiles: [ 
       'mode/clike/clike.js',
       'mode/php/php.js'
    ]
},
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
toolbar1: "fullscreen code",
<?php } else { ?>
toolbar1: "undo redo restoredraft | cut copy paste searchreplace | bullist | numlist | outdent indent | forecolor | backcolor | fullscreen code print | ag_news",
toolbar2: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | ltr rtl | visualchars visualblocks | link unlink anchor | image media responsivefilemanager | linkbutton | ag_gaw",
toolbar3: "table | insertdatetime | blockquote hr nonbreaking | subscript superscript charmap emoticons pagebreak | removeformat styleselect fontselect fontsizeselect",
<?php } ?> 
menubar: false,

setup: function (editor) {
				editor.on('focus', function (e) {
					$(".focus_editor").click();
				});
				editor.on('blur', function (e) {
					$(".blur_editor").click();
				});
			},

//*---toolbar_items_size: 'small',---
filemanager_access_key: "<?php echo $ag_fm_key; ?>" 
});
<?php } // tinymce conf ?>



//*---CKEditor---
<?php if ($ag_cfg_editor == 'ckeditor') { ?> 
$(document).ready(function() {
	
var ced=1; 

$(".editor").each(function(){ 

$(this).attr("id","editor" + ced); 

CKEDITOR.replace( 'editor' + ced, {
	
	filebrowserBrowseUrl: 'filemanager/dialog.php?akey=<?php echo $ag_fm_key; ?>&type=2&editor=ckeditor&relative_url=0&fldr=',
	filebrowserImageBrowseUrl: 'filemanager/dialog.php?akey=<?php echo $ag_fm_key; ?>&type=2&editor=ckeditor&relative_url=0&fldr=',
	
	contentsCss: "../js/tinymce/tinymce_content.php",
	fullPage: false,
    allowedContent: true,
  
	
	disableNativeSpellChecker: false,
	
	/*
	enterMode : CKEDITOR.ENTER_BR,
    shiftEnterMode: CKEDITOR.ENTER_P,
	*/
	
	entities: false,
    htmlEncodeOutput: false,
	
	
	
	
	removePlugins: 'about, newpage, flash, pagebreak',
	extraPlugins: 'codemirror, agpb, youtube',
	
	skin: 'moono-lisa',
	height: '480px'
});

ced=ced+1; });	

});


<?php } // ckeditor conf ?>




</script>

<link rel="stylesheet" href="../js/tinymce/plugins/codemirror/codemirror-4.8/lib/codemirror.css">
<link rel="stylesheet" href="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/dialog/dialog.css">
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/lib/codemirror.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/xml/xml.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/javascript/javascript.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/css/css.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/htmlmixed/htmlmixed.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/clike/clike.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/mode/php/php.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/edit/matchbrackets.js"></script>

<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/dialog/dialog.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/search/searchcursor.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/search/search.js"></script>
<script src="../js/tinymce/plugins/codemirror/codemirror-4.8/addon/selection/active-line.js"></script>

<script src="../js/jscolor/jscolor.js"></script>
<script src="../js/jquery.colorbox-min.js"></script>

<script src="../js/highlight.jquery.js"></script>
<script src="../js/jquery.scrollTo.min.js"></script>

<script src="../js/datepicker/datepicker.js"></script>

<style id="ag_fade_in_page">#ag_main {opacity:0;}</style>
<script>
$(document).ready(function(){
	$("#ag_main").animate({opacity:"1"}, 300);
	setTimeout(function(){ $("#ag_fade_in_page").remove(); }, 700);
	});</script>
<noscript><style>#ag_main {opacity:1;}</style></noscript>

</head>

<body>
<div id="ag_main">
<?php $ag_class_top_ifr = ''; if (isset($_GET['iframe'])) { $ag_class_top_ifr = ' ag_top_ifr'; $ag_title_tab = $ag_this_name; } 
//orders
if (isset($_GET['order']) && isset($_GET['iframe'])) {
	$ag_icon_tab = '<i class="icon-bell-4"></i>';
	$ag_title_tab = $ag_lng['edit_order'];
	}
if (isset($_GET['reserve']) && isset($_GET['iframe'])) {
	$ag_icon_tab = '<i class="icon-bell-4"></i>';
	$ag_title_tab = $ag_lng['reserve'];
	}
if (isset($_GET['statistics']) && isset($_GET['iframe'])) {
	$ag_icon_tab = '<i class="icon-chart-bar-3"></i>';
	$ag_title_tab = $ag_lng['statistics'];
	}
?>



<div class="ag_top<?php echo $ag_class_top_ifr; ?>" id="ag_top">


<?php // orders statistics button
if (isset($_GET['orders']) && !isset($_GET['iframe']) && !isset($_GET['edit'])) {
echo '<div class="ag_top_btn ag_user_info_btn ag_statistics_orders_btn" title="'.$ag_lng['statistics'].'" onclick="ag_open_order(\'?orders&statistics&iframe\')"><i class="icon-chart-bar-3"></i></div>';	
}
?>


<?php $ag_title_top_class = '';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile() && !isset($_GET['iframe'])) { 
if (!empty($ag_home)) { echo '<div class="ag_title_top ag_home_title_top"><h2>' .$ag_user_name. '</h2></div>'; } 
} else { 
if (!empty($ag_home)) {$ag_title_top_class = ' ag_home_title_top';}
$ag_top_href = $srv_absolute_url;
if (isset($_GET['iframe'])) {$ag_top_href = '#';}
 ?>
<div class="ag_title_top<?php echo $ag_title_top_class; ?>"><h2><a href="<?php echo $ag_top_href; ?>"><?php if (empty($ag_home)) {echo $ag_title_tab;} else { if (empty($ag_cfg_title)) {echo $ag_product;} else {echo $ag_cfg_title;} } ?><?php if (isset($ag_title_cat) && !empty($ag_title_cat)) {echo ' - '.$ag_title_cat;}  ?></a></h2></div>
<?php } ?> 

<!-- User info -->
<?php 
$ag_user_info_class = '';
if (isset($_GET['common_search']) || isset($_GET['settings']) || isset($_GET['orders']) || empty($ag_this_db)) {$ag_user_info_class = ' ag_user_info_search';}
if (!isset($_GET['iframe'])) { ?>

<div class="ag_top_btn<?php echo $ag_user_info_class; ?>" id="ag_top_btn">

<?php if ($ag_this_db == $ag_staff_db && $ag_this_id == $ag_user_id) { } else { ?>
<div class="ag_user_info" id="ag_user_info" tabindex="-1">
<div class="ag_user_info_btn"><i class="icon-user"></i></div>
<div class="ag_user_info_inner">
<div class="ag_user_info_list">
<?php 
echo '<div class="ag_this_user_name"><h4>' .$ag_user_name. '</h4></div>';

$ag_user_img_dir = $ag_upload_name;
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {$ag_user_img_dir = $ag_mob_images;}
$ag_user_img_src = 'img/no_photo.png';
if (!empty($ag_user_photo) && file_exists($ag_data_dir.'/'.$ag_user_img_dir.$ag_user_photo)) {
$ag_user_img_src = $ag_data_dir.'/'.$ag_user_img_dir.$ag_user_photo;
}

if (file_exists($ag_user_img_src)) {
echo '<div class="ag_this_user_photo" id="ag_this_user_photo" onclick="ag_open_ifm(\'' .$ag_user_id. '\', \'\', \'ag_item\');"><img src="' .$ag_user_img_src. '" alt="' .$ag_user_name. '" /></div>';
} else { echo '<div class="ag_this_user_photo" id="ag_this_user_photo" onclick="ag_open_ifm(\'' .$ag_user_id. '\', \'\', \'ag_item\');"><img src="img/no_photo.png" alt="' .$ag_user_name. '" /></div>'; }
echo '<div class="ag_this_user_profile">
<span onclick="ag_open_ifm(\'' .$ag_user_id. '\', \'\', \'ag_item\');">
<i class="icon-edit-1"></i>' .$ag_lng['my_profile']. '
</span>
</div>';



echo '<div class="ag_this_user_link">
<a href="../" target="_blank"><i class="icon-eye-3"></i>' .$ag_lng['open_site']. '</a>
</div>';

echo '<div class="ag_this_user_logout">
<span onclick="ag_dialog(\'logout\', \'' .$ag_lng['confirm_logout']. '\', \'' .$ag_lng['logout']. '\', \'ag_logout\', \'icon-hand-paper-o ag_str_red\', \'button2\')">
<i class="icon-logout-3"></i>' .$ag_lng['logout']. '
</span>
</div>';
?>
</div>
</div>
</div>
<?php } ?>
<!-- /User info -->







<?php 
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else {
if (isset($ag_data) && sizeof($ag_data) > 16) { ?>
<div class="ag_user_info ag_qsearch_list_btn" id="ag_qsearch_list" tabindex="-1">
<div class="ag_user_info_btn"><i class="icon-search-8"></i></div>
<div class="ag_user_info_inner">
<div class="ag_user_info_list ag_top_list_search">

<?php
//search in list

echo '
<div class="ag_search_in_list_items">
<div class="ag_search_in_list" id="ag_search_list_items"><div>
<input type="text" id="ag_search_inp_items" placeholder="'.$ag_lng['list_search'].'" />

<div class="ag_qsearch_btn">
<span id="agt_search_items" onclick="ag_search_in_list(\'ag_search_inp_items\', \'ag_list_items_block\', \'ag_list_items\', \'agt_search_items\', \'agt_search_next_items\')">' .$ag_lng['search']. '<i class="icon-play-circled"></i></span>
<span id="agt_search_next_items" class="agt_search_next">' .$ag_lng['next_search']. '<i class="icon-forward-circled"></i></span>
</div>

<div class="clear"></div>
</div></div>
</div>'; //search in list

?>

</div>
</div>
</div>
<?php } } // search in list no mobile ?> 
<!-- /ag_qsearch_list -->



<div class="clear"></div>
</div>
<!-- /ag_top_btn -->
<?php } else { // iframe ?> 
<div class="ag_icon_top"><h2><?php echo $ag_icon_tab; ?></h2></div>
<?php } // iframe ?> 

<div class="clear"></div>
<?php if (isset($_GET['common_search'])) {echo '<div class="ag_scroll_top"></div>';} ?>
</div><!-- ag_top -->

<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile() && !isset($_GET['iframe'])) { ?>

<div class="ag_title_top_mob" id="ag_title_top_mob"><h2><?php if(empty($ag_title_tab)) { if (empty($ag_cfg_title)) {echo $ag_product;} else {echo $ag_cfg_title;} } else { echo $ag_title_tab; } ?><?php if (isset($ag_title_cat) && !empty($ag_title_cat)) {echo ' - '.$ag_title_cat;} ?></h2></div>

<?php } ?> 


<?php if (!isset($_GET['iframe']) && empty($ag_home)) { ?>
<div class="ag_tabs" id="ag_tabs_menu">
<div class="ag_tabs_menu_inner" id="ag_tabs_menu_inner">

<div id="ag_common_search">
<div class="ag_common_search">
<form name="ag_common_search" action="<?php echo $srv_script_absolute_url; ?>?common_search" method="post">
<label id="ag_common_search_input">
<input type="text" name="common_search_query" placeholder="<?php echo $ag_lng['common_search']; ?>" value="<?php if (isset($_POST['common_search_query'])) {echo $_POST['common_search_query'];} ?>" onblur="ag_out('ag_common_search_input')" onfocus="ag_active('ag_common_search_input')" />
</label>
<button class="ag_btn_big"><i class="icon-search"></i></button>
<div class="clear"></div>
</form>
</div>
</div><!-- ag_common_search -->


<ul id="ag_main_menu"><?php include('main_menu.php'); ?></ul>

</div><!-- ag_tabs_menu_inner -->
</div><!-- ag_tabs_menu -->

<div class="ag_open_close_menu">
<div class="ag_open_close_menu_inner">
<div id="ag_open_menu" tabindex="-1" onclick="ag_open_menu()"><i class="icon-menu-3"></i></div>
<div id="ag_close_menu" tabindex="-1" onclick="ag_close_menu()"><i class="icon-cancel"></i></div>
<div class="clear"></div>
</div>
</div>	




<?php } // iframe & home ?> 
