<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}
?>
<?php if (isset($ag_cfg_hidden_footer) && $ag_cfg_hidden_footer == '1') { echo '<div class="ag_hidden_footer">&#160;</div>'; } else { ?>
<footer>
<div id="ag_footer" class="ag_footer">
<div class="ag_footer_layot">
<div class="ag_footer_decor"></div>

<div class="ag_footer_inner">
<?php echo ag_widgets('footer'); ?>
<div class="ag_clear"></div>
</div>


<div class="ag_copy">
<div class="ag_copy_inner">


<?php if (!empty($ag_cfg_phone) && $ag_cfg_footer_off_phone != 1) { ?>
<span class="ag_email_link"><i class="icon-phone-3"></i><?php echo $ag_cfg_phone; ?></span>
<?php } ?>

<?php if (!empty($ag_cfg_email) && $ag_cfg_footer_off_email != 1) { ?>
<span class="ag_email_link"><i class="icon-mail-8"></i><a href="mailto:<?php echo $ag_cfg_email; ?>"><?php echo $ag_cfg_email; ?></a></span>
<?php } ?>


<?php if ($ag_check_count_objects > 1) { ?>

<?php if ($ag_cfg_footer_off_rss != 1) { 
if (isset($_GET[$ag_get_cat])) {
$ag_check_rss =	ag_list_cat($_GET[$ag_get_cat],'10','rss');
} else {
if ($ag_cfg_home == 'first_category') { $ag_check_rss = ag_list_cat('', '', 'rss'); } else { $ag_check_rss = ag_last_obj('10', $ag_cfg_home_common_count, 'rss'); }
}

if (!empty($ag_check_rss)) {

?>
<span class="ag_rss_link"><i class="icon-rss-5"></i><a href="<?php echo $srv_absolute_url; ?>?<?php echo $ag_get_rss;?><?php if(isset($_GET[$ag_get_cat])) {echo '='.$_GET[$ag_get_cat];} ?>" target="_blank"><?php echo $ag_lng['rss']; ?></a></span>
<?php 
}
} 
?>

<?php if ($ag_cfg_footer_off_sitemap != 1) { ?>
<span class="ag_sitemap_link"><i class="icon-sitemap"></i><a href="?<?php echo $ag_get_sitemap; ?>"><?php echo $ag_lng['sitemap']; ?></a></span>
<?php } ?>

<?php } ?>

<span class="ag_copy_text"><?php echo $ag_cfg_description; ?> &copy; <a href="<?php echo $srv_absolute_url; ?>"><?php echo $ag_cfg_title; ?></a> <?php echo date('Y'); ?></span>
<div class="ag_clear"></div>
</div>
</div>

</div>
</div>
</footer><!-- ag_footer -->
<?php } // hidden footer ?>
</div> <!-- ag_main -->





<script>

var ag_page_load_time = 0;
function ag_count_load_time(){

var now = new Date().getTime();
var ag_page_load_time = now - performance.timing.navigationStart;
if (ag_page_load_time < 5000) {
$("#ag_load").css({display:"block"});
$("#ag_load div").animate({width:"100%"}, ag_page_load_time);
setTimeout(function() { $("#ag_load").fadeOut(250); }, ag_page_load_time + 100);
}
}



//*---ag_window_size---
function ag_window_size() {

var ag_min_width = 800;
var ag_sizes = {};

var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

ag_sizes = {
minw: ag_min_width,
windoww: ag_win_width,
windowh: ag_win_height
};

return ag_sizes;
}//*---ag_window_size--- 


//*---colorbox links---
function ag_colorbox_links() {

for (var i = 0; i < $("a").length; i++) {
var ag_a_src = $("a").eq(i).attr("href");
var ag_a_src_a = ag_a_src.split(".");
var ag_a_src_type = ag_a_src_a[ag_a_src_a.length-1];
if (ag_a_src_type == "pdf") {$("a").eq(i).addClass("ag_iframe");}
if (ag_a_src_type == "jpg" || ag_a_src_type == "jpeg") {$("a").eq(i).addClass("ag_popup_photos");}
}
	
}//*---colorbox links---


//*---photo responsitive---

function ag_photo_responsitive() { 

var ag_photo_sizes = {};
var ag_ww = ag_window_size().windoww;
var ag_wh = ag_window_size().windowh;
var ag_mw = ag_window_size().minw;

var ag_post_width = $(".ag_content_width").eq(0).outerWidth(true);
var ag_cat_width = $(".ag_content_width_cat").eq(0).outerWidth(true);

var ag_count_photo = $(".ag_photos .ag_obj_photo").length;
var ag_cat_count_photo = $(".ag_cat_content").find(".ag_obj_photo").length;



var ag_photo_width = ag_post_width / 4;
var ag_photo_width_cat = ag_cat_width / 4;

var ag_photo_width_front = ag_post_width / 3;

var ag_blocks_photo_width = ag_post_width;
if (ag_ww < ag_mw) { 
   ag_photo_width = ag_post_width;  
   ag_photo_width_front = ag_post_width; 
   ag_photo_width_cat = ag_cat_width;
} else { 
   ag_photo_width = ag_post_width / 4; 
   ag_photo_width_front = ag_post_width / 3;
   ag_photo_width_cat = ag_cat_width / 4;
   }

var ag_photo_height_front = (ag_photo_width_front * 9) / 16;

var ag_photo_height = (ag_photo_width * 9) / 16;
var ag_blocks_photo_height = (ag_post_width * 9) / 16;
var ag_photo_inner_width = ag_photo_width * ag_count_photo;

var ag_cat_photo_height = (ag_photo_width_cat * 9) / 16;
var ag_cat_blocks_photo_height = (ag_cat_width * 9) / 16;
var ag_cat_photo_inner_width = ag_photo_width_cat * ag_cat_count_photo;

var ag_one_photo_height = (ag_post_width * 9) / 21;
if (ag_ww < ag_mw) { ag_one_photo_height = (ag_post_width * 9) / 16; } 


var ag_cat_one_photo_height = (ag_cat_width * 9) / 21;
if (ag_ww < ag_mw) { ag_cat_one_photo_height = (ag_cat_width * 9) / 16; } 


var ag_wgt_obj_phw = $("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo").eq(0).outerWidth(true);
var ag_wgt_obj_phh = (ag_wgt_obj_phw * 9) / 16;
$("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo").css({height: ag_wgt_obj_phh + "px"});
$("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo img").css({minHeight: ag_wgt_obj_phh + "px"});


if (ag_wgt_obj_phw) {
for (var i = 0; i < $("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo").length; i++) {
var ag_list_wgt_photo_height = $("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo:eq("+i+") img").outerHeight(true);
if (ag_list_wgt_photo_height > ag_wgt_obj_phh) {
var ag_list_wgt_photo_center_top = (ag_list_wgt_photo_height - ag_wgt_obj_phh) / 2;
if (ag_list_wgt_photo_center_top < 8) {ag_list_wgt_photo_center_top = 0;}
$("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo:eq("+i+") img").css({position: "absolute", top: "-" + ag_list_wgt_photo_center_top + "px"});
} else { $("ul.ag_wgt_list_obj li a.ag_wgt_list_obj_photo:eq("+i+") img").css({position: "absolute", top: "0px"}); }	
}	
}



	
$(".ag_photos_inner").css({width: ag_photo_inner_width + "px", position: "absolute"});
$(".ag_obj_photo").css({height: ag_photo_height + "px", overflow: "hidden"});	
$(".ag_photos").css({height: ag_photo_height + "px", width: ag_post_width + "px", position: "relative"});
$(".ag_blocks_cat .ag_obj_block div.ag_obj_item div.ag_obj_content .ag_first_photo").css({height: ag_blocks_photo_height + "px", overflow: "hidden"});
$(".ag_photos_inner .ag_obj_photo").css({width: ag_photo_width + "px"});
$(".ag_first_photo_open").css({width: ag_post_width + "px", height: ag_one_photo_height + "px", overflow: "hidden"});



$(".ag_cat_content").find(".ag_photos_inner").css({width: ag_cat_photo_inner_width + "px", position: "absolute"});
$(".ag_cat_content").find(".ag_obj_photo").css({height: ag_cat_photo_height + "px", overflow: "hidden"});	
$(".ag_cat_content").find(".ag_photos").css({height: ag_cat_photo_height + "px", width: ag_cat_width + "px", position: "relative"});
$(".ag_cat_content").find(".ag_blocks_cat .ag_obj_block div.ag_obj_item div.ag_obj_content .ag_first_photo").css({height: ag_cat_blocks_photo_height + "px", overflow: "hidden"});
$(".ag_cat_content").find(".ag_photos_inner .ag_obj_photo").css({width: ag_photo_width_cat + "px"});
$(".ag_cat_content").find(".ag_first_photo_open").css({width: ag_cat_width + "px", height: ag_cat_one_photo_height + "px", overflow: "hidden"});





if (!$(".ag_blocks_cat").length) {
$(".ag_one_photo").find(".ag_obj_photo").css({height: ag_photo_height_front + "px", overflow: "hidden"});
}

	
if ($(".ag_first_photo_open img.ag_first_img").outerHeight(true) > ag_one_photo_height) {
var ag_one_photo_center_top	= ($(".ag_first_photo_open img.ag_first_img").outerHeight(true) - ag_one_photo_height) / 2;
if (ag_one_photo_center_top < 16) {ag_one_photo_center_top = 0;}
$(".ag_first_photo_open img.ag_first_img").css({position: "absolute", top: "-" + ag_one_photo_center_top + "px"});
} else { $(".ag_first_photo_open img.ag_first_img").css({position: "absolute", top: "0px"}); }


if ($(".ag_cat_content").find(".ag_first_photo_open img.ag_first_img").outerHeight(true) > ag_cat_one_photo_height) {
var ag_cat_one_photo_center_top	= ($(".ag_cat_content").find(".ag_first_photo_open img.ag_first_img").outerHeight(true) - ag_cat_one_photo_height) / 2;
if (ag_cat_one_photo_center_top < 16) {ag_cat_one_photo_center_top = 0;}
$(".ag_cat_content").find(".ag_first_photo_open img.ag_first_img").css({position: "absolute", top: "-" + ag_cat_one_photo_center_top + "px"});
} else { $(".ag_cat_content").find(".ag_first_photo_open img.ag_first_img").css({position: "absolute", top: "0px"}); }


if (ag_ww < ag_mw) {
	
	if ($(".ag_photos").outerWidth(true)) { $(".ag_one_photo_open").css({display:"none"}); }
	
	$(".ag_cat_top").addClass("ag_cat_mobile");
	$(".ag_cat_content").addClass("ag_cat_mobile");
	$(".ag_obj_item").addClass("ag_obj_item_mobile");
	$(".ag_post_info").addClass("ag_post_info_mobile");
	$(".ag_first_photo").addClass("ag_full_width_photo");
	if ($("div.ag_blocks_cat").length) { $(".ag_blocks_cat").addClass("ag_blocks_cat_mob"); }
    if (ag_count_photo < 2) { 
    $(".ag_photos_prev, .ag_photos_next").css({display:"none"}); 
	$(".ag_obj_photo").addClass("ag_full_width_photo");
	} else { 
	$(".ag_photos_prev, .ag_photos_next").fadeIn(300);
	}
	
} else {

    $(".ag_one_photo_open").css({display:"block"});
	$(".ag_cat_top").removeClass("ag_cat_mobile");
    $(".ag_cat_content").removeClass("ag_cat_mobile");
    if (ag_count_photo <= 4) { $(".ag_photos_prev, .ag_photos_next").css({display:"none"}); }
    $(".ag_obj_photo").removeClass("ag_full_width_photo");
    $(".ag_first_photo").removeClass("ag_full_width_photo");	
    $(".ag_obj_item").removeClass("ag_obj_item_mobile");
    $(".ag_post_info").removeClass("ag_post_info_mobile");
    if ($(".ag_blocks_cat")) { $(".ag_blocks_cat").removeClass("ag_blocks_cat_mob"); }
}


if ($(".ag_photos").outerWidth(true)) {
for (var i = 0; i < $(".ag_photos div.ag_obj_photo").length; i++) {
var ag_list_photo_height = $(".ag_photos div.ag_obj_photo:eq("+i+") img").outerHeight(true);
if (ag_list_photo_height > $(".ag_photos").outerHeight(true)) {
var ag_list_photo_center_top = (ag_list_photo_height - $(".ag_photos").outerHeight(true)) / 2;
if (ag_list_photo_center_top < 10) {ag_list_photo_center_top = 0;}
$(".ag_photos div.ag_obj_photo:eq("+i+") img").css({position: "absolute", top: "-" + ag_list_photo_center_top + "px"});
} else { $(".ag_photos div.ag_obj_photo:eq("+i+") img").css({position: "absolute", top: "0px"}); }	
}	
}


for (var i = 0; i < $(".ag_first_photo").length; i++) {
var ag_first_photo_height = $(".ag_first_photo:eq("+i+") img.ag_move_photo").outerHeight(true);
if (ag_first_photo_height > $(".ag_first_photo:eq("+i+")").outerHeight(true)) {
var ag_first_photo_center_top = (ag_first_photo_height - $(".ag_first_photo:eq("+i+")").outerHeight(true)) / 2;
if (ag_first_photo_center_top < 16) {ag_first_photo_center_top = 0;}	
$(".ag_first_photo:eq("+i+") img.ag_move_photo").css({position: "absolute", top: "-" + ag_first_photo_center_top + "px"});
} else { $(".ag_first_photo:eq("+i+") img.ag_move_photo").css({position: "absolute", top: "0px"}); }
}


ag_photo_sizes = {
phwidth: ag_photo_width,
phheight: ag_photo_height,
phcount: ag_count_photo,
phinner: ag_photo_inner_width,

phwidth_cat: ag_photo_width_cat,
phheight_cat: ag_cat_photo_height,
phcount_cat: ag_cat_count_photo,
phinner_cat: ag_cat_photo_inner_width
};

return ag_photo_sizes;
}//*---photo responsitive---




function ag_position_photo() {
$(".ag_photos_inner").css({left: "0px"});
}

//*---next photos---
var ag_swing_bind = 1;
function ag_anim_swing(ag_swing_pos, e, vec) {
ag_swing_bind = 0;
$(e).off('click');
if (vec == 'next') {
$(".ag_photos_inner").stop().animate({left: ag_swing_pos + "px"}, 300, "easeInOutQuint", 
(function() { ag_swing_bind = 1; $(e).on('click'); })
);
}
if (vec == 'prev') {
$(".ag_photos_inner").stop().animate({left: ag_swing_pos + "px"}, 300, "easeInOutQuint", 
(function() { ag_swing_bind = 1; $(e).on('click'); })
);	
}
}

function ag_next_photos(e) {
$(e).off('click');
var ag_ww = ag_window_size().windoww;
var ag_wh = ag_window_size().windowh;
var ag_mw = ag_window_size().minw;
var ag_phw = ag_photo_responsitive().phwidth;
var ag_iw = ag_photo_responsitive().phinner;

var ag_inner_pos = $(".ag_photos_inner").position().left;
var ag_swing_pos = ag_inner_pos - ag_phw;
var ag_count_photo_list = $(".ag_photos div.ag_obj_photo").length;

var ag_int_pos = ag_inner_pos + (-ag_inner_pos * 2);
var end_row = ag_iw - (ag_phw * 4);
if (ag_ww < ag_mw) { 
end_row = ag_iw - ag_phw; 
ag_int_pos = ag_inner_pos + (-ag_inner_pos * 2);
} 
var penultimate_ph = end_row - ag_phw;



if (ag_int_pos < end_row - 16) {} else {
	ag_swing_bind = 0;
$(".ag_photos_inner").stop().animate({left: "0px"}, 250, "easeInOutQuint");
setTimeout(function() { ag_swing_bind = 1; }, 300);
	}

if (ag_swing_bind == 1) { ag_anim_swing(ag_swing_pos, e, 'next'); }




}//*---next photos---

function ag_prev_photos(e) {
$(e).off('click');
var ag_phw = ag_photo_responsitive().phwidth;
if ($(".ag_photos_inner").position().left < -ag_phw) {
var s_left = $(".ag_photos_inner").position().left + ag_phw;
if (ag_swing_bind == 1) { ag_anim_swing(s_left, e, 'prev'); }
} else { 
ag_swing_bind = 0;
$(".ag_photos_inner").stop().animate({left: "0px"}, 250, "easeInOutQuint");
setTimeout(function() { ag_swing_bind = 1; }, 300);
}
}





//*---cat next photos---
var ag_cat_swing_bind = 1;
function ag_cat_anim_swing(ag_swing_pos, e, vec) {
ag_cat_swing_bind = 0;
$(e).off('click');
if (vec == 'next') {
$(".ag_cat_content").find(".ag_photos_inner").stop().animate({left: ag_swing_pos + "px"}, 300, "easeInOutQuint", 
(function() { ag_cat_swing_bind = 1; $(e).on('click'); })
);
}
if (vec == 'prev') {
$(".ag_cat_content").find(".ag_photos_inner").stop().animate({left: ag_swing_pos + "px"}, 300, "easeInOutQuint", 
(function() { ag_cat_swing_bind = 1; $(e).on('click'); })
);	
}
}

function ag_cat_next_photos(e) {
$(e).off('click');
var ag_ww = ag_window_size().windoww;
var ag_wh = ag_window_size().windowh;
var ag_mw = ag_window_size().minw;
var ag_phw = ag_photo_responsitive().phwidth_cat;
var ag_iw = ag_photo_responsitive().phinner_cat;

var ag_inner_pos = $(".ag_cat_content").find(".ag_photos_inner").position().left;
var ag_swing_pos = ag_inner_pos - ag_phw;
var ag_count_photo_list = $(".ag_cat_content").find(".ag_photos div.ag_obj_photo").length;

var ag_int_pos = ag_inner_pos + (-ag_inner_pos * 2);
var end_row = ag_iw - (ag_phw * 4);
if (ag_ww < ag_mw) { 
end_row = ag_iw - ag_phw; 
ag_int_pos = ag_inner_pos + (-ag_inner_pos * 2);
} 
var penultimate_ph = end_row - ag_phw;



if (ag_int_pos < end_row - 16) {} else {
	ag_cat_swing_bind = 0;
$(".ag_cat_content").find(".ag_photos_inner").stop().animate({left: "0px"}, 250, "easeInOutQuint");
setTimeout(function() { ag_cat_swing_bind = 1; }, 300);
	}

if (ag_cat_swing_bind == 1) { ag_cat_anim_swing(ag_swing_pos, e, 'next'); }




}//*---cat next photos---


function ag_cat_prev_photos(e) {
$(e).off('click');
var ag_phw = ag_photo_responsitive().phwidth_cat;
if ($(".ag_cat_content").find(".ag_photos_inner").position().left < -ag_phw) {
var s_left = $(".ag_cat_content").find(".ag_photos_inner").position().left + ag_phw;
if (ag_cat_swing_bind == 1) { ag_cat_anim_swing(s_left, e, 'prev'); }
} else { 
ag_cat_swing_bind = 0;
$(".ag_cat_content").find(".ag_photos_inner").stop().animate({left: "0px"}, 250, "easeInOutQuint");
setTimeout(function() { ag_cat_swing_bind = 1; }, 300);
}
}










//*---ag_responsitive menu---
function ag_menu() {
	
setTimeout(function() { $("#ag_menu").addClass("ag_menu_shadow"); }, 50);
$("#ag_menu").stop().animate({left: "0px"}, 350, "easeInOutQuint");

<?php if ($ag_is_mob == 0) { ?>
if (ag_window_size().windoww > ag_window_size().minw) { $("#ag_close_menu").css({display:"none"}); }
else { setTimeout(function() { $("#ag_close_menu").fadeIn(250); }, 300); }
<?php } else { ?>
setTimeout(function() { $("#ag_close_menu").fadeIn(250); }, 300);
<?php } ?>
$("#ag_widgets_open").fadeOut(250);	
ag_widgets_close();
}
function ag_menu_close() {
$("#ag_menu").stop().animate({left: "-100%"}, 300, "easeInOutQuint");	
$("#ag_close_menu").fadeOut(160);
$("#ag_menu").removeClass("ag_menu_shadow"); 
$("#ag_widgets_open").fadeIn(250);	
}

function ag_responsitive_menu() {

$("#ag_menu").removeClass("ag_move_menu");
$("#ag_menu").removeClass("ag_move_menu_full");
$("#ag_menu").removeAttr("style");
$("#ag_menu").removeClass("ag_menu_shadow");

var ag_mp_h = $("#ag_menu ul li").outerHeight(true);

if (!$("#ag_menu").find("ul li").length) {
ag_mp_h = 55;
$("#ag_button_menu").remove();
}

$("#ag_mob_top_panel").css({display: "none", height: ag_mp_h  + "px", lineHeight: ag_mp_h  + "px"});
$("#ag_mob_top_panel div.ag_mob_top_panel_inner").css({height: ag_mp_h + "px", lineHeight: ag_mp_h + "px"});
$(".ag_button_menu, #ag_mob_top_panel .ag_search_submit").css({width: ag_mp_h  + "px", height: ag_mp_h + "px", lineHeight: (ag_mp_h  + 1) + "px"});
$("#ag_mob_top_panel label input").css({height: ag_mp_h + "px", lineHeight: (ag_mp_h + 1) + "px"});

$("#ag_main").css({marginTop: $("#ag_menu").outerHeight(true) + "px"});	
$("#ag_close_menu").css({display: "none"});


var mw = 24;
if ($(".ag_punkts").length) {mw = 180;}
for (var i = 0; i < $(".ag_menu ul li.ag_menu_item").length; i++) { 
mw += $(".ag_menu ul li.ag_menu_item").eq(i).outerWidth(true);	
}

if (mw < ag_window_size().minw) {mw = ag_window_size().minw;}

if (ag_window_size().windoww < mw) {
$("#ag_menu").addClass("ag_move_menu");
if ($("#ag_menu").find("ul li").length) { $("#ag_mob_top_panel").css({display: "block"}); }
$("#ag_main").css({marginTop: "0px"});
if (ag_window_size().windoww < ag_window_size().minw) { $("#ag_menu").addClass("ag_move_menu_full"); } 
$("#ag_top_search").css({display:"none"});
} else {$("#ag_top_search").fadeIn(200);}

$(document).mouseup(function (e) {
var ag_move_menu = $(".ag_move_menu, .ag_button_menu");
if (!ag_move_menu.is(e.target) && ag_move_menu.has(e.target).length === 0) {
if (ag_window_size().windoww < mw) {	
setTimeout(function(){ ag_menu_close(); }, 120);
}
}
});



if (ag_window_size().windoww < mw) {
if ($(window).scrollTop() >= 1) { 
$("#ag_mob_top_panel div.ag_mob_top_panel_inner").addClass("ag_menu_shadow").addClass("ag_scroll_menu"); 
} else { 
$("#ag_mob_top_panel div.ag_mob_top_panel_inner").removeClass("ag_menu_shadow").removeClass("ag_scroll_menu"); 
}

} else {	

if ($(window).scrollTop() >= 1) { 
$("#ag_menu").addClass("ag_menu_shadow").addClass("ag_scroll_menu"); 
} else { 
$("#ag_menu").removeClass("ag_menu_shadow").removeClass("ag_scroll_menu");
}


$("ul.ag_punkts").css({display: "block", height:"auto"});	

}
ag_close_punkts(1, $(".ag_move_menu nav ul li"));


$(window).scroll(function() {	
if (ag_window_size().windoww < mw) {

if ($(this).scrollTop() >= 1) { 
$("#ag_mob_top_panel div.ag_mob_top_panel_inner").addClass("ag_menu_shadow").addClass("ag_scroll_menu"); 
if (!$("#ag_mob_top_panel").length) { $("#ag_widgets_open").addClass("ag_menu_shadow").addClass("ag_widgets_close_scroll"); } 
} else { 
$("#ag_mob_top_panel div.ag_mob_top_panel_inner").removeClass("ag_menu_shadow").removeClass("ag_scroll_menu"); 
$("#ag_widgets_open").removeClass("ag_menu_shadow").removeClass("ag_widgets_close_scroll"); 
}

} else {	

if ($(this).scrollTop() >= 1) { 
$("#ag_menu").addClass("ag_menu_shadow").addClass("ag_scroll_menu"); 
} else { 
$("#ag_menu").removeClass("ag_menu_shadow").removeClass("ag_scroll_menu"); 
}

}

<?php if ($ag_is_mob == 0) { ?>
if ($(this).scrollTop() >= 200) { $("#ag_arrow_top").fadeIn(300); } else { $("#ag_arrow_top").fadeOut(300); }
<?php } ?>
});

$(".ag_widget_column_mobile").scroll(function() {
if ($(this).scrollTop() >= 1) { 
$("#ag_widgets_close").addClass("ag_menu_shadow").addClass("ag_widgets_close_scroll");
} else {
$("#ag_widgets_close").removeClass("ag_menu_shadow").removeClass("ag_widgets_close_scroll");
}



});
	
$(function() {
$("li.ag_menu_item_punkts").each(function(e) {
if ($(this).find("ul li.ag_this_punkt").length) { $(this).addClass("ag_this_title_punkts"); }
});
});	


}//*---responsitive menu---

//*---mobile menu punkts---
function ag_open_punkts(el) {
if ($(".ag_move_menu").length)	{
var ag_punkt_click = 0;
if ($(el).find("ul").attr("class") == "ag_punkts ag_open_punkts") {ag_punkt_click = 1;}
$(el).find("ul").stop().slideDown(250); 
$(el).find("ul").addClass("ag_open_punkts");
$(el).addClass("ag_open_punkt");

$(el).find("ul li h3 a").click(function(){ 

var ag_url_punkt = $(this).attr("href");
var ag_target_punkt = $(this).attr("target");
if (ag_target_punkt == "_blank") {window.open(ag_url_punkt);} else {document.location.href = ag_url_punkt;}
return false;

});

ag_close_punkts(ag_punkt_click, el);
}
}
function ag_close_punkts(clicks, el) {
if (clicks > 0)	{ $(el).find("ul").stop().slideUp(250); 
$(el).find("ul").removeClass("ag_open_punkts"); 
$(el).removeClass("ag_open_punkt");
ag_punkt_click = 0; }
}
//*---mobile menu punkts---	




//*--- responsitive blocks---
function ag_responsitive_blocks() {

if (ag_window_size().windoww < ag_window_size().minw) {$("#ag_main").addClass("ag_main_mobile");} else {$("#ag_main").removeClass("ag_main_mobile");}

if (ag_window_size().windoww > 1400) { 
$(".ag_widgets").find("div.ag_full_width_obj").addClass("ag_full_width_obj_large");
if (!$(".ag_blocks_cat").find(".ag_obj_block").length) { $("#ag_content.ag_widgets").addClass("ag_full_width_obj_large"); }
} else {
$(".ag_widgets").find("div.ag_full_width_obj").removeClass("ag_full_width_obj_large");
$("#ag_content.ag_widgets").removeClass("ag_full_width_obj_large");
}

if ($("div.ag_blocks_cat").length) {

var ag_block_width_inner = $(".ag_obj_item").innerWidth();
$(".ag_post_info").css({width: ag_block_width_inner + "px"});

if (ag_window_size().windoww < ag_window_size().minw) {

$(".ag_blocks_cat div.ag_obj_block").css({height: "auto"}); 
$(".ag_done_mess").addClass("ag_mob_done_mess");

} else {

$(".ag_done_mess").removeClass("ag_mob_done_mess");	
var ag_block_info_height = $(".ag_post_info").outerHeight(true);
var ag_block_width = $(".ag_obj_block").outerWidth(true);
var hblocks = "";
for (var p = 0; p < $(".ag_obj_content").length; p++) {
hblocks += ($(".ag_obj_content").eq(p).outerHeight(true) + ag_block_info_height) + "|";
}
hblocks = hblocks + "0";
var hblocks_arr = hblocks.split("|");
hblocks_arr.sort(function(a,b){return a-b;});
var max_height_block = hblocks_arr[hblocks_arr.length - 1];
max_height_block = parseFloat(max_height_block);

$(".ag_blocks_cat div.ag_obj_block").css({height: max_height_block + "px"}); 

}

}

if (ag_window_size().windoww < ag_window_size().minw) {
$("#ag_widget_column").addClass("ag_widget_column_mobile");
var ag_wgt_btn_wh = $("#ag_mob_top_panel").outerHeight(true);
if (!$("#ag_mob_top_panel").length) { ag_wgt_btn_wh = 55; }
$("#ag_widgets_open, #ag_widgets_close").css({
width: ag_wgt_btn_wh + "px",
height: ag_wgt_btn_wh + "px",
lineHeight: (ag_wgt_btn_wh + 1) + "px",
overflow: "hidden"
});

$(".ag_widgets").addClass("ag_widgets_mobile");
$("#ag_widgets_open").fadeIn(250);	
} else {
ag_widgets_close();
$("#ag_widget_column").removeClass("ag_menu_shadow");
$("#ag_widget_column").removeClass("ag_widget_column_mobile");
$("#ag_widget_column").removeAttr("style");
$(".ag_widgets").removeClass("ag_widgets_mobile");
$("#ag_widgets_open").fadeOut(250);
$("#ag_widgets_open, #ag_widgets_close").css({ width: "0px", overflow: "hidden" });	
}	
	
var ag_mp_h = $("#ag_menu ul li").outerHeight(true);
var ag_mp_m = $("#ag_menu ul li").outerHeight(true);
if (!$("#ag_menu").find("ul li").length) {
ag_mp_h = 53;
ag_mp_m = 18;
}	
	

$("#ag_mob_top_panel .ag_search_form").css({
width: ($("#ag_mob_top_panel").outerWidth(true) - ag_mp_m - $("#ag_widgets_open").outerWidth(true)) + "px", marginLeft: ag_mp_m + "px"
});

$("#ag_mob_top_panel .ag_search_form label").css({
width: ($("#ag_mob_top_panel").outerWidth(true) - (ag_mp_h * 2) - $("#ag_widgets_open").outerWidth(true)) + "px"
});	
	
if($("#ag_widget_column .ag_widget_block_inner").length) { 
$("#ag_top_search").css({width: $(".ag_widget_block_inner").outerWidth(true) + "px"}); 
$("#ag_top_search label").css({width: ($(".ag_widget_block_inner").outerWidth(true) - $(".ag_search_submit").outerWidth(true) - 18) + "px"}); 
} else {
if (
$(".ag_obj_content").length && $(".ag_obj_content").outerWidth(true) < 500) {$("#ag_top_search").find(".ag_search_form label").css({width: ($(".ag_obj_content").outerWidth(true) - $(".ag_search_submit").outerWidth(true) - 18) + "px"});
$("#ag_top_search").css({width: $(".ag_obj_content").outerWidth(true) + "px"}); 
} else { $("#ag_top_search").find(".ag_search_form label").css({width: "180px"}); }
}	
	
if ($("#ag_footer div.ag_widget_block").length) {
var ag_count_footer_blocks = $("#ag_footer div.ag_widget_block").length;
var ag_footer_blocks_w = 100 / ag_count_footer_blocks;


var fwblocks = "";
for (var fw = 0; fw < ag_count_footer_blocks; fw++) {
fwblocks += $("#ag_footer div.ag_widget_block div.ag_widget_block_inner").eq(fw).outerHeight(true) + "|";
}
var fw_height_block = 0;
fwblocks = fwblocks + "0";
var fwlocks_arr = fwblocks.split("|");
fwlocks_arr.sort(function(a,b){return a-b;});
fw_height_block = fwlocks_arr[fwlocks_arr.length - 1];
fw_height_block = parseFloat(fw_height_block);

if (ag_window_size().windoww < ag_window_size().minw) {
$("#ag_footer div.ag_widget_block").removeAttr("style");
} else {
$("#ag_footer div.ag_widget_block").css({height: fw_height_block + "px"}); 
if (ag_footer_blocks_w >= 25) { $("#ag_footer div.ag_widget_block").css({width: ag_footer_blocks_w + "%"}); }	
}
$(".ag_footer_inner").removeClass("ag_footer_inner_no_content");
} else { $(".ag_footer_inner").addClass("ag_footer_inner_no_content"); }	



if ($(".ag_move_menu").find("li.ag_home h3 span i.ag_one_icon").length || $(".ag_move_menu").find("li.ag_home h3 a i.ag_one_icon").length) {
var ag_emmh = "";
var ag_emmi = "";

if ($(".ag_move_menu").find("li.ag_home h3 a").length) { 
ag_emmh = $(".ag_move_menu").find("li.ag_home h3 a").html(); 
ag_emmi = $(".ag_move_menu").find("li.ag_home h3 a i").attr("class");
} else {
ag_emmh = $(".ag_move_menu").find("li.ag_home h3 span").html();
ag_emmi = $(".ag_move_menu").find("li.ag_home h3 span i").attr("class");	
}

if (ag_window_size().windoww < ag_window_size().minw) {
$(".ag_move_menu").find("li.ag_home h3 span").html('<i class="'+ag_emmi+'"></i>');
$(".ag_move_menu").find("li.ag_home h3 a").html('<i class="'+ag_emmi+'"></i>');

$(".ag_move_menu").find("li.ag_home h3 span i").after('<b class="ag_empty_home"><?php echo $ag_lng['home_group_cfg']; ?></b>');
$(".ag_move_menu").find("li.ag_home h3 a i").after('<b class="ag_empty_home"><?php echo $ag_lng['home_group_cfg']; ?></b>');
} else {
$(".ag_move_menu").find("li.ag_home h3 span").html('<i class="'+ag_emmi+'"></i>');
$(".ag_move_menu").find("li.ag_home h3 a").html('<i class="'+ag_emmi+'"></i>');		
}
}

$("ul.ag_wgt_list_obj li").eq($("ul.ag_wgt_list_obj li").length - 1).addClass("ag_wgt_li_obj_last");

if ($(".ag_photos").length || $(".ag_one_photo_open").length || $(".ag_description_obj").length) { } else {
$(".ag_obj_item_mobile").find(".ag_full_obj").css({paddingTop: "0px"});
}


$(".ag_pub_calendar").closest(".ag_widget_content").css({padding: "0"});

if ($(".ag_wgt_soc_links").eq(0).find("h5").length) { $(".ag_wgt_soc_links").eq(0).find("h5").eq($(".ag_wgt_soc_links").eq(0).find("h5").length - 1).addClass("ag_last_soc_link"); }
if ($(".ag_wgt_soc_links").eq(1).find("h5").length) { $(".ag_wgt_soc_links").eq(1).find("h5").eq($(".ag_wgt_soc_links").eq(1).find("h5").length - 1).addClass("ag_last_soc_link"); }

//*--- video content---
$(function() {
$("iframe").each(function(e) {
if (ag_iframe_src) {
var ag_iframe_src = $(this).attr("src"); 
if (ag_iframe_src.indexOf("youtu") + 1 || 
ag_iframe_src.indexOf("video_ext.php") + 1 || 
ag_iframe_src.indexOf("rutube") + 1 || 
ag_iframe_src.indexOf("yandex") + 1 || 
ag_iframe_src.indexOf("mail.ru") + 1 || 
ag_iframe_src.indexOf("vimeo") + 1 || 
ag_iframe_src.indexOf("flickr") + 1 || 
ag_iframe_src.indexOf("ustream") + 1 || 
ag_iframe_src.indexOf("photobucket") + 1 || 
ag_iframe_src.indexOf("bigmir") + 1 || 
ag_iframe_src.indexOf("sibnet") + 1 || 
ag_iframe_src.indexOf("metacafe") + 1 || 
ag_iframe_src.indexOf("livestream") + 1 || 
ag_iframe_src.indexOf("instagram") + 1) { 
var ag_iframe_w = $(this).parents("p").outerWidth(true); 
var ag_iframe_h = (ag_iframe_w * 9) / 16; 
$(this).removeAttr("width"); $(this).removeAttr("height");
$(this).css({width: ag_iframe_w + "px", height: ag_iframe_h + "px"});
}
}
});
});	
$(function() {
$("p video").each(function(e) {
var ag_video_w = $(this).parents("p").outerWidth(true); 
var ag_video_h = (ag_video_w * 9) / 16; 
$(this).removeAttr("width"); $(this).removeAttr("height");
$(this).css({width: ag_video_w + "px", height: ag_video_h + "px"});
});
});	


}//*--- responsitive blocks---

//*--- widgets ---
function ag_widgets_open() {
$(".ag_widget_column_mobile").animate({right: "0px"}, 350, "easeInOutQuint");
$(".ag_widget_column_mobile").addClass("ag_menu_shadow");
setTimeout(function() { $("#ag_widgets_close").fadeIn(200); }, 250);	
$("#ag_widgets_close").addClass("ag_widgets_close");
ag_menu_close();
}
function ag_widgets_close() {
$(".ag_widget_column_mobile").animate({right: "-100%"}, 250, "easeInOutQuint");	
setTimeout(function() { $(".ag_widget_column_mobile").removeClass("ag_menu_shadow"); }, 250);
$("#ag_widgets_close").fadeOut(200);
$("#ag_widgets_close").removeClass("ag_widgets_close");
}

function ag_login_button(elem) {
$(elem).closest("div").find("button").addClass("ag_button_active");
if ($(elem).val() == "") {$(elem).closest("div").find("button").removeClass("ag_button_active");}
}

//*--- responsitive top blocks---
function ag_responsitive_top() {
if ($("#ag_top").length) {
if (ag_window_size().windoww < ag_window_size().minw) {
$("#ag_top").addClass("ag_top_mobile");
} else {
$("#ag_top").removeClass("ag_top_mobile");	
}	
}

}


//*--- responsitive footer blocks---
function ag_responsitive_footer() {

if ($("#ag_footer div.ag_widget_block").length) {
if (ag_window_size().windoww < ag_window_size().minw) {
$("#ag_footer").addClass("ag_footer_mobile");
} else {
$("#ag_footer").removeClass("ag_footer_mobile");	
}	
	
}


var ag_content_h = ag_window_size().windowh;

if ($("#ag_main").outerHeight(true) < ag_content_h) {
$("#ag_footer").addClass("ag_fixed_footer");
$("#ag_main").css({marginBottom: $("#ag_footer").outerHeight(true) + "px"});	
} else {
$("#ag_footer").removeClass("ag_fixed_footer");	
$("#ag_main").css({marginBottom: "0px"});	
}


}
//*--- responsitive footer blocks---


//*--- search---
function ag_search(btn) {
var ag_sinp = $(btn).closest("form").find("input");
if (ag_sinp.val() == "") {
ag_sinp.focus();
} else {
$(btn).parent("form").submit();	
}
}
function ag_search_button(inp) {
if ($(".ag_search_submit i").attr("class") == "icon-search") {
$(".ag_search_submit i.icon-search").remove();
$(".ag_search_submit").html('<i class="icon-right-open" style="display:none;"></i>'); 
$(".ag_search_submit i").fadeIn(200);
} else {
if ($(inp).val() == "") { 
$(".ag_search_submit").html('<i class="icon-search"></i>'); 
$(inp).removeClass("ag_search_active");
} else {$(inp).addClass("ag_search_active");} 
}

if ($(inp).val() == "") { $(inp).closest("form").find("label").removeClass("ag_search_active"); } else { $(inp).closest("form").find("label").addClass("ag_search_active"); } 

}
//*--- search ---






//*--- slider ---



function ag_sl_move(where) {
	
	var num = $("#ag_slider_menu ul li.ag_current_slide").index();
	if (!num) {num = 0;}

		if (where == "next") { 
		num = num + 1;	
		if (num == $("#ag_slider_menu ul li").length) { $("#ag_slider_menu ul li").eq(0).find("div").trigger("click",[true]); }
		else { $("#ag_slider_menu ul li").eq(num).find("div").trigger("click",[true]);	}
		} 
		
		if (where == "prev") {
		
		if (num > 0) {
		$("#ag_slider_menu ul li").eq(num - 1).find("div").trigger("click",[true]);	
		}  
		
		else if (num == 0) {
		$("#ag_slider_menu ul li").eq($("#ag_slider_menu ul li").length - 1).find("div").trigger("click",[true]);	
		}
		
		}
		
}


function ag_slider_height() {

var ag_slide_height = 480;
if (ag_window_size().windowh > ag_slide_height) {
ag_slide_height	= ag_window_size().windowh - ag_window_size().windowh / 4;
if (ag_slide_height < 480) {ag_slide_height = 480;}
if (ag_slide_height > 720) {ag_slide_height = 720;}

if (ag_window_size().windoww < 1080) {ag_slide_height = 480;}

} else {
ag_slide_height = ag_slide_height - $(".ag_mob_top_panel").outerHeight(true);
}

$("#ag_slider_block").css({height: ag_slide_height + "px"});
$(".ag_slide_picture").css({height: ag_slide_height + "px"});
$(".ag_slide_content").css({height: (ag_slide_height - 32) + "px"});
$(".ag_slider_loading").css({height: ag_slide_height + "px", lineHeight: ag_slide_height + "px"});	
	
}

var ag_sl_cl = 0;

function ag_slider() {

ag_sl_cl = ag_sl_cl + 1;

var ag_amimate_t = 400;

$("#ag_slider_menu ul li div").unbind("click");

$("#ag_slider_block ul.ag_slider_list li").fadeIn(200);

$("#ag_slider_block ul.ag_slider_list li").css({width: $("#ag_slider_block").outerWidth(true) + "px"});
$("#ag_slider_block ul.ag_slider_list").stop().css({left: "0px", position: "absolute"});
$("li.ag_sl_menu_item").removeClass("ag_current_slide");
$("li.ag_sl_menu_item div").addClass("ag_in_slide");


$("#ag_slider_menu ul li div").bind("click");


 ag_slider_height();

 
if (ag_window_size().windoww < ag_window_size().minw) {
ag_amimate_t = 300;
	$("#ag_slider_block").addClass("ag_slider_block_mob");
	$(".ag_slide_image img").css({height: $("#ag_slider_block").outerHeight(true) + "px", minHeight: $("#ag_slider_block").outerHeight(true) + "px"});

for (var i = 0; i < $(".ag_slide").length; i++) {
var ag_slider_photo_width = $(".ag_slide").eq(i).find(".ag_slide_image img").outerWidth(true);
if (ag_slider_photo_width > $("#ag_slider_block").outerWidth(true)) {
var ag_slider_photo_center_left = (ag_slider_photo_width - $("#ag_slider_block").outerWidth(true)) / 2;
if (ag_slider_photo_center_left < 16) {ag_slider_photo_center_left = 0;}	
$(".ag_slide").eq(i).find(".ag_slide_image img").css({position: "absolute", left: "-" + ag_slider_photo_center_left + "px"});
} else { $(".ag_slide").eq(i).find(".ag_slide_image img").css({position: "absolute", left: "0px"}); }
}
	
	
} else {
ag_amimate_t = 400;
	$("#ag_slider_block").removeClass("ag_slider_block_mob");
	$(".ag_slide_image img").removeAttr("style");
}

var ag_sl_full_w = 0;
var ag_sl_positions = [];

for (var i = 0; i < $(".ag_slide").length; i++) {


ag_sl_positions[i] = ag_sl_full_w;	
ag_sl_full_w += $("#ag_slider_block").outerWidth(true);


var ag_slider_photo_height = $(".ag_slide").eq(i).find(".ag_slide_image img").outerHeight(true);
if (ag_slider_photo_height > $("#ag_slider_block").outerHeight(true)) {
var ag_slider_photo_center_top = (ag_slider_photo_height - $("#ag_slider_block").outerHeight(true)) / 2;
if (ag_slider_photo_center_top < 16) {ag_slider_photo_center_top = 0;}	
$(".ag_slide").eq(i).find(".ag_slide_image img").css({position: "absolute", top: "-" + ag_slider_photo_center_top + "px"});
} else { $(".ag_slide").eq(i).find(".ag_slide_image img").css({position: "absolute", top: "0px"}); }

var ag_sl_pict_h = $(".ag_slide").eq(i).find(".ag_slide_picture").outerHeight(true);
var ag_sl_pict_w = $(".ag_slide").eq(i).find(".ag_slide_picture").outerWidth(true);
var ag_sl_pict_img_h = $(".ag_slide").eq(i).find(".ag_slide_picture img").outerHeight(true);
var ag_sl_pict_img_w = $(".ag_slide").eq(i).find(".ag_slide_picture img").outerWidth(true);


var ag_sl_pict_img_top = (ag_sl_pict_h - ag_sl_pict_img_h) / 2;
var ag_sl_pict_img_left = (ag_sl_pict_w - ag_sl_pict_img_w) / 2;

$(".ag_slide").eq(i).find(".ag_slide_picture img").css({top: ag_sl_pict_img_top + "px", left: (ag_sl_pict_img_left + 32) + "px"});
$(".ag_slide").eq(i).find(".ag_slide_picture img.ag_slide_pict_left").css({top: ag_sl_pict_img_top + "px", left: (ag_sl_pict_img_left - 32) + "px"});


var ag_sl_content_h = $(".ag_slide_content_inner").eq(i).outerHeight(true);

var ag_sl_content_top = ($("#ag_slider_block").outerHeight(true) - ag_sl_content_h) / 2;
$(".ag_slide_content_inner").eq(i).css({top: ag_sl_content_top + "px"});
$(".ag_slide_content_back").eq(i).css({height: ag_sl_content_h + "px", top: ag_sl_content_top + "px"});
}


$("#ag_slider_block ul.ag_slider_list").css({width: ag_sl_full_w + "px"});


var ag_sl_time = <?php echo ($ag_cfg_slider_time * 1000); ?>;

var ag_sl_current = 1;
var pos = 0;
var delay_t_fo = ag_amimate_t / 2;


if (ag_sl_cl > 1) { $(".ag_slider_time").stop().remove(); $(".ag_slider_pause").remove(); }



$(".ag_slider_time").stop().css({width: "0px", display: "block"}).animate({width: "100%"}, ag_sl_time - ag_amimate_t).fadeOut(delay_t_fo);


function ag_sl_auto() {

if (ag_sl_current < 0 || ag_sl_cl > 1 || $(".ag_slide").length < 2 || ag_sl_time == 0) { 
$(".ag_slider_pause").remove();
return false; 
}

$("#ag_slider_menu ul li div").eq(ag_sl_current).trigger("click",[true]);
$(".ag_slider_time").stop().css({width: "0px", display: "block"}).animate({width: "100%"}, ag_sl_time - ag_amimate_t).fadeOut(delay_t_fo);

}

var ag_sl_interval = setInterval(function(){ ag_sl_auto(); }, ag_sl_time);		
clearInterval(ag_sl_interval);
ag_sl_interval = setInterval(function(){ ag_sl_auto(); }, ag_sl_time);	

if ($(".ag_slide").length < 2 || ag_sl_time == 0) { $("#ag_slider_menu ul li div").off("click"); }




$("#ag_slider_menu ul li div").click(function(e) {

if ($(this).attr("class") == "ag_in_slide") {

$("#ag_slider_block ul.ag_slider_list li").removeClass("ag_current_slide");
$("#ag_slider_menu ul li").removeClass("ag_current_slide");
$(this).parent().addClass("ag_current_slide");


$("li.ag_sl_menu_item div").addClass("ag_in_slide");
$(this).removeClass("ag_in_slide");

pos = $(this).parent().index();

$(".ag_slider_time").stop().fadeOut(200);



if (ag_sl_positions.length > 1) {

$("#ag_slider_block ul.ag_slider_list").stop().animate({left: -ag_sl_positions[pos] + "px"}, ag_amimate_t, "easeInOutQuint");


$("#ag_slider_block ul.ag_slider_list li").eq(pos).addClass("ag_current_slide");

var anim_t1 = ag_amimate_t / 1.4; 
var swing_left_sl_t = $("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_inner").outerWidth(true);



$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_inner").css({marginLeft: -swing_left_sl_t + "px"});
$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_back").css({marginLeft: -swing_left_sl_t + "px"});
$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_picture img").css({marginTop: "120%"});

$(".ag_slide_content_inner").stop();
$(".ag_slide_content_back").stop();
$(".ag_slide_picture img").stop();

var sl_swing_text = ag_amimate_t + ag_amimate_t + 300;
var sl_swing_text_back = ag_amimate_t + ag_amimate_t;

if ($("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_picture img").length) {
	
if (ag_window_size().windoww < ag_window_size().minw) {
sl_swing_text = ag_amimate_t + 300;
sl_swing_text_back = ag_amimate_t;	
}	

if ($("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_back").attr("style").indexOf("background"))  {
sl_swing_text = ag_amimate_t + 400;
if (ag_window_size().windoww < ag_window_size().minw) { sl_swing_text = ag_amimate_t; }
sl_swing_text_back = 300;		
}

	
} else {
sl_swing_text = ag_amimate_t + 300;
sl_swing_text_back = ag_amimate_t;	
}


$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_inner").stop().delay(sl_swing_text).animate({marginLeft: "8px"}, anim_t1, "easeInOutQuad").animate({marginLeft:"0px"}, 180);

$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_content_back").stop().delay(sl_swing_text_back).animate({marginLeft: "0px"}, anim_t1, "easeInOutQuad");

$("#ag_slider_block ul.ag_slider_list li").eq(pos).find(".ag_slide_picture img").stop().delay(ag_amimate_t).animate({marginTop: "0px"}, ag_amimate_t, "easeInOutCirc");



ag_sl_current = pos + 1;
if (ag_sl_current >= $("#ag_slider_menu ul li div").length) {ag_sl_current = 0;}

}//*--- slides > 1 ---
}//*--- slides menu class == ag_in_slide ---
});


$("#ag_slider_menu ul li.ag_sl_menu_item:first").addClass("ag_current_slide");
$("#ag_slider_menu ul li.ag_sl_menu_item div").addClass("ag_in_slide");
$("#ag_slider_menu ul li.ag_sl_menu_item:first").find("div").removeClass("ag_in_slide");
 
 var ag_ls_hover = 0;
$("#ag_slider_block").hover(function() {
ag_ls_hover = 1;
clearInterval(ag_sl_interval);
if ($(".ag_slide").length > 1) {
$(this).find("div.ag_slider_pause").stop().fadeIn(300);
$(".ag_slider_time").stop().fadeOut(300);
}
},
function(){ 
if (ag_ls_hover == 1) {
ag_sl_interval = setTimeout(function(){ ag_sl_auto(); clearInterval(ag_sl_interval); ag_sl_interval = setInterval(function(){ ag_sl_auto(); }, ag_sl_time); }, 1800);
$(this).find("div.ag_slider_pause").stop().fadeOut(1800);
}
});	


$(".ag_slider_prev, .ag_slider_next").unbind("click");
$(".ag_slider_prev, .ag_slider_next").bind("click");

$(".ag_slider_prev").click(function(){
clearInterval(ag_sl_interval);
ag_sl_move("prev");
});	

$(".ag_slider_next").click(function(){
clearInterval(ag_sl_interval);
ag_sl_move("next");
});	

if ($(".ag_slide").length < 2) {
$("#ag_slider_menu, .ag_slider_prev, .ag_slider_next").css({display:"none"});	
} else {
$(".ag_slider_next, .ag_slider_prev, .ag_slider_menu").fadeIn(450);
}



}//*--- slider ---








function ag_responsitive() {

ag_responsitive_blocks();
setTimeout(function(){ ag_photo_responsitive(); ag_responsitive_blocks(); }, 120);

ag_photo_responsitive();
setTimeout(function(){ ag_photo_responsitive(); }, 80);

ag_responsitive_top();
ag_responsitive_menu();
ag_position_photo();
ag_slider_height();
ag_responsitive_footer();

}





$(function() {
    $("ul.ag_wgt_list").each(function(e) {
	var ag_list_li = $(this).find("li").length;
	$(this).find("li").eq(0).addClass("ag_list_first");
	$(this).find("li").eq(ag_list_li-1).addClass("ag_list_last");
});
});


//*---window resize---
var ag_now_height = $(window).outerHeight(true);
var ag_now_width = window.innerWidth;

$(window).resize(function() {
	
setTimeout(function() {	ag_now_height = $(window).outerHeight(true); ag_now_width = window.innerWidth; }, 300);
var ag_kh = ag_now_height - ag_window_size().windowh;
var ag_kw = ag_now_width - ag_window_size().windoww;

if (ag_kh < 0) {ag_kh = ag_kh - (ag_kh * 2);}
if (ag_kw < 0) {ag_kw = ag_kw - (ag_kw * 2);}
	
<?php if ($ag_is_mob == 1) { ?>
if (ag_kh > 80 && ag_kw != 0) { 
<?php } ?>	
ag_responsitive(); 
ag_slider();
<?php if ($ag_is_mob == 1) { ?>
}
<?php } ?>	

});

function ag_active(elem) {
$(elem).parent().addClass("ag_active");
}
function ag_out(elem) {
$(elem).parent().removeClass("ag_active");	
}

<?php if ($ag_is_mob == 0) { ?>
$(function() {
    $("a, img, div, input, button, span, small, label").each(function(b) {
        if (this.title) {
            var c = this.title;
            var x = -18;
            var y = 32;
            $(this).mouseover(function(d) {
				
                this.title = "";
                $("#ag_main").append('<div id="ag_cust_title">' + c + "</div>");
				
                $("#ag_cust_title").css({
					
                    left: (d.pageX + x) + "px",
                    top: (d.pageY + y) + "px",
                    opacity: "0.9",
					visibility: "visible",
					
				
                }).delay(300).fadeIn(400)
					
            }).mouseout(function() {
                this.title = c;
                $("#ag_cust_title").remove()
            }).mousemove(function(d) {
                $("#ag_cust_title").css({
                    left: (d.pageX + x) + "px",
                    top: (d.pageY + y) + "px"
                })
            })
        }
    })
    });
<?php } ?>






$(document).ready(function(){

$("head").append('<link rel="stylesheet" href="css/icons/fontello.css" />');
	
if (window.location.hash) {
window.location.hash = window.location.hash + "_now";
}	
	
ag_responsitive();	


$("#ag_main").animate({opacity:"1"}, 400);
setTimeout(function(){ $("#ag_fade_in_page").remove(); }, 700);


ag_colorbox_links();

$(".ag_popup_photos").colorbox({
returnFocus: false,
rel:'ag_popup_photos', 
<?php if ($ag_is_mob == 1) { ?>
transition:"elastic", 
width:"100%", 
height:"auto", 
<?php } else { ?>
transition:"elastic", 
width:"auto", 
height:"90%", 
<?php } ?>
opacity:"0.8", 
slideshow:false, 
title:false, 
rel:true, 
close: "<i class=\"icon-cancel\"></i>",
previous: '<i class="icon-left-open-big"></i>', 
next: '<i class="icon-right-open-big"></i>'
});
$(".ag_iframe").colorbox({
iframe:true, 
transition:"elastic", 
width:"90%", 
height:"90%", 
opacity:"100",
close: "<i class=\"icon-cancel\"></i>"
});



$('<div id="ag_arrow_top"><i class="icon-up-1"></i></div>').insertAfter('#ag_main');
 


$("#ag_arrow_top").click(function() {
$("html, body").animate( {scrollTop: 0}, "slow");
});


//*---photos hover---
if ($(".ag_photos").outerWidth(true)) {
var ag_first_photo = $(".ag_first_photo_open").html();
setTimeout(function() { ag_first_photo = $(".ag_first_photo_open").html(); }, 100);


$(".ag_photos div.ag_obj_photo").hover(function(){

var ag_ww = ag_window_size().windoww;
var ag_mw = ag_window_size().minw;

var ag_post_width = $(".ag_content_width").eq(0).outerWidth(true);		
var ag_one_photo_height = (ag_post_width * 9) / 21;
if (ag_ww < ag_mw) { ag_one_photo_height = (ag_post_width * 9) / 16; } 	

var ag_cat_width = $(".ag_content_width_cat").eq(0).outerWidth(true);	
var ag_cat_one_photo_height = (ag_cat_width * 9) / 21;
if (ag_ww < ag_mw) { ag_cat_one_photo_height = (ag_cat_width * 9) / 16; } 	
	
var ag_hover_photo_class = "ag_img_" + ($(this).index() + 1);


if ($(".ag_first_photo_open img").attr("class") != ag_hover_photo_class) {
setTimeout(function() { $(".ag_first_photo_open img." + $(".ag_first_photo_open img").eq(($(".ag_first_photo_open img").length - 2)).attr("class")).remove(); }, 300);

$(".ag_photos div.ag_obj_photo").unbind("hover");
$(".ag_first_photo_open").append($(this).find("a").html());
$(".ag_first_photo_open img." + ag_hover_photo_class).css({display: "none"});
$(".ag_first_photo_open img." + ag_hover_photo_class).stop().fadeIn(250, (function() { $(".ag_photos div.ag_obj_photo").bind("hover"); }));
 



if ($(".ag_first_photo_open img." + ag_hover_photo_class).outerHeight(true) > ag_one_photo_height) {
var ag_one_photo_center_top	= ($(".ag_first_photo_open img." + ag_hover_photo_class).outerHeight(true) - ag_one_photo_height) / 2;
if (ag_one_photo_center_top < 16) {ag_one_photo_center_top = 0;}	
$(".ag_first_photo_open img." + ag_hover_photo_class).css({position: "absolute", top: "-" + ag_one_photo_center_top + "px"});
} else { $(".ag_first_photo_open img." + ag_hover_photo_class).css({position: "absolute", top: "0 px"}); }



if ($(".ag_cat_content").find(".ag_first_photo_open img." + ag_hover_photo_class).outerHeight(true) > ag_cat_one_photo_height) {
var ag_cat_one_photo_center_top	= ($(".ag_cat_content").find(".ag_first_photo_open img." + ag_hover_photo_class).outerHeight(true) - ag_cat_one_photo_height) / 2;
if (ag_cat_one_photo_center_top < 16) {ag_cat_one_photo_center_top = 0;}	
$(".ag_cat_content").find(".ag_first_photo_open img." + ag_hover_photo_class).css({position: "absolute", top: "-" + ag_cat_one_photo_center_top + "px"});
} else { $(".ag_cat_content").find(".ag_first_photo_open img." + ag_hover_photo_class).css({position: "absolute", top: "0 px"}); }


}






if ($(".ag_first_photo_open").html() == "") { $(".ag_first_photo_open").html(ag_first_photo);}
setTimeout(function() { if ($(".ag_first_photo_open").html() == "") { $(".ag_first_photo_open").html(ag_first_photo);} }, 300);
},
function(){
if ($(".ag_first_photo_open").html() == "") { $(".ag_first_photo_open").html(ag_first_photo);}
setTimeout(function() { if ($(".ag_first_photo_open").html() == "") { $(".ag_first_photo_open").html(ag_first_photo);} }, 300);
});	
}//*---photos hover---




$(".ag_login_form button").css({
height: $(".ag_passw_apanel").outerHeight(true) + "px", 
lineHeight: ($(".ag_passw_apanel").outerHeight(true) + 1) + "px"
});

$(".ag_wgt_search_form button").css({
height: $(".ag_wgt_search").outerHeight(true) + "px", 
lineHeight: ($(".ag_wgt_search").outerHeight(true) + 1) + "px"
});


//*---swipe---
<?php if (isset($_GET[$ag_get_obj])) { ?>

$(function() {  

      $(".ag_photos").swipe({
        swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
          ag_next_photos();
        },
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
          ag_prev_photos();
        },
         threshold:10
      });
	  
<?php } else { ?>	  

$(function() {  

      $(".ag_cat_photos").swipe({
        swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
          ag_cat_next_photos();
        },
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
          ag_cat_prev_photos();
        },
         threshold:10
      });	  
	  
<?php } ?>	 
 
	  $(".ag_move_menu").swipe({
        swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
          if ($(".ag_move_menu").length) { ag_menu_close(); }
        },
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
         
        },
         threshold:25
	  
      });
	  
	  
	  $("#ag_slider_block").swipe({
        swipeLeft:function(event, direction, distance, duration, fingerCount, fingerData) {
		 $(".ag_slider_next").click();
        },
		swipeRight:function(event, direction, distance, duration, fingerCount, fingerData) {
         $(".ag_slider_prev").click();
        },
         threshold:25
	  
      });

	  
	  
	  
});//*---swipe---

//*---other---
$(".ag_catpcha img").css({height: ($(".ag_catpcha label").outerHeight(true) - 9) + "px"});

$("img").css({opacity: "0", transition: "none"});


});//*---ready function---



$(window).load(function() {

ag_photo_responsitive();
ag_responsitive_blocks();

setTimeout(function() {	ag_slider(); }, 350);

ag_responsitive_footer();


if (window.location.hash) {

var ag_hash = window.location.hash.replace("#","");	
ag_hash = ag_hash.replace("_now","");
window.location.hash = "";

var ag_margin_top = $("#ag_mob_top_panel").outerHeight(true) + 18; 

ag_scloll_speed = $("#" + ag_hash).offset().top;
if (ag_scloll_speed < 100) {ag_scloll_speed = 400;}
if (ag_scloll_speed > 800) {ag_scloll_speed = 800;}
$("html, body").animate( {scrollTop: $("#" + ag_hash).offset().top - ag_margin_top}, ag_scloll_speed, "easeOutQuart");

}

setTimeout(function() { $("img").animate({opacity: "1"}, 300); }, 80);


});//*---load function---

ag_count_load_time();
</script>





<?php 
if (isset($ag_cfg_footer_code) && !empty($ag_cfg_footer_code)) {
$ag_footer_code = html_entity_decode($ag_cfg_footer_code, ENT_QUOTES, 'UTF-8');
$ag_footer_code = str_replace('::exactly::', '=', trim($ag_footer_code));
if ($ag_footer_code == '<script>'.$ag_separator[3].'</script>') {$ag_footer_code = '';}
$ag_footer_code = str_replace($ag_separator[3], "\n", $ag_footer_code);
echo $ag_footer_code;
}
?>


</body>
</html>