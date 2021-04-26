<?php
if (!isset($ag_index)) { header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die; }
?>
</div><!-- ag main -->

<script>
//*---label active---
function ag_active(id) {
if (typeof(id) == "string") { $("#"+id).addClass("ag_active"); }
else { $(id).parent().addClass("ag_active"); } 
}
function ag_out(id) {
if (typeof(id) == "string") { $("#"+id).removeClass("ag_active"); }
else { $(id).parent().removeClass("ag_active"); }
}


function ag_responsitive() {
var ag_min_width = 800;
var ag_win_width = window.innerWidth;
var ag_win_height = $(window).outerHeight(true);

if (ag_win_width < ag_min_width) {
$("#ag_main").addClass("agMainMobile");
} else {
$("#ag_main").removeClass("agMainMobile");
}

var top_w = $(".ag_orders_tools").outerWidth(true);
var top_e_w = $(".ag_executor").outerWidth(true) + $(".ag_order_period").outerWidth(true) + $(".ag_order_search").outerWidth(true) + $(".ag_this_month_tools").outerWidth(true) + $(".ag_order_count").outerWidth(true) + $(".ag_page_num").outerWidth(true) + $(".ag_top_reserve button").outerWidth(true);

if (top_e_w > top_w && ag_win_width > ag_min_width) {
	$(".ag_top_reserve button, .ag_page_num").css({marginTop:"16px"});
	$(".ag_page_num").css({clear:"both"});
	} else {
	$(".ag_top_reserve button, .ag_page_num").removeAttr("style");
	}

var res = {
mw: ag_min_width,
ww: ag_win_width,
hw: ag_win_height	
}
}


//*---act link---
function ag_act(id) {
$(id).click();
}

//*---dialog---
function ag_dialog(id, name, text, func, icon, button) {
var buttons = "";

if (id == "") return false;

if (func == "") {func = "ag_cancel";} 

if (button == "button2") {
buttons = '<div class="ag_dialog_buttons"><button class="ag_cancel_btn ag_btn_big" onclick="ag_cancel()"><i class="icon-cancel-circle"></i><span><?php echo $ag_lng['cancel']; ?></span></button><button class="ag_action_btn ag_btn_big" onclick="'+func+'(\'' +id+ '\')"><i class="icon-ok-circle"></i><span><?php echo $ag_lng['continue']; ?></span></button><div class="clear"></div></div>';
}

if (button == "button1") {
buttons = '<div class="ag_dialog_buttons"><button class="ag_action_btn ag_btn_big" onclick="'+func+'(\'' +id+ '\')"><i class="icon-ok-circle"></i><span><?php echo $ag_lng['continue']; ?></span></button><div class="clear"></div></div>';
}

if (button == "button0") {
buttons = '<div class="ag_dialog_buttons"><button class="ag_action_btn ag_btn_big" onclick="'+func+'(\'' +id+ '\')"><i class="icon-cancel-circle"></i><span><?php echo $ag_lng['close']; ?></span></button><div class="clear"></div></div>';
}

if (button == "link_home") {
buttons = '<div class="ag_dialog_buttons"><a href="<?php echo $srv_script_absolute_url; ?>" target="_top" class="ag_action_btn ag_btn_big"><i class="icon-cancel-circle"></i><span><?php echo $ag_lng['close']; ?></span></a><div class="clear"></div></div>';
}

if (button == "link_tab") {
buttons = '<div class="ag_dialog_buttons"><a href="<?php echo $srv_script_absolute_url.$ag_tab_url; ?>" target="_top" class="ag_action_btn ag_btn_big"><i class="icon-cancel-circle"></i><span><?php echo $ag_lng['close']; ?></span></a><div class="clear"></div></div>';
}


var display_name = "";
var list_name = "";
if (name.constructor.toString().indexOf("Array") == -1) {
display_name = ""+ name +"";
} else {
for (var i = 0; i < name.length; i++) { 
list_name = 1;
display_name += "<li>"+ name[i] +"</li>";
}
}

if (list_name == 1) {
$("body").append('<div class="ag_overlay"></div><div class="ag_dialog"><div class="ag_dialog_inner"><div class="ag_title_dialog"><table><tr><td class="ag_di"><i class="'+ icon +'"></i></td><td><span>'+ text +'</span></td></tr></table></div><ul>'+ display_name +'</ul>'+ buttons +'</div></div>');
} else {
$("body").append('<div class="ag_overlay"></div><div class="ag_dialog"><div class="ag_dialog_inner"><div class="ag_title_dialog"><table><tr><td class="ag_di"><i class="'+ icon +'"></i></td><td><span>'+ text +'</span></td></tr></table></div><div class="ag_dialog_mess">'+ display_name +'</div>'+ buttons +'</div></div>');	
}


if (func == "quick_mess") { setTimeout(function() { ag_cancel(); }, id); }
else if (buttons == "") { setTimeout(function() { ag_cancel(); }, 5000); }

$(".ag_overlay").fadeIn(200);
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
$(".ag_dialog").animate( {top: "0"}, 400);
<?php } else { ?>
$(".ag_dialog").animate( {top: "50%"}, 400);
<?php } ?>
}

//*---cancel---
function ag_cancel() {
$(".ag_overlay").fadeOut(200);
setTimeout(function() { $(".ag_overlay").remove();}, 200);
$(".ag_dialog").fadeOut(400);
setTimeout(function() { $(".ag_dialog").remove(); }, 400);
}
<?php echo $ag_cl; ?>

<?php if ($ag_auth != 0) { // auth yes ?>

//*---add---
function ag_add_item() {
$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", {  add: 1 },function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); ag_width(); }, 300);
}); 


$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_update_menu.php'.$ag_tab_url.$ag_id_url; ?>", {  add_menu: 1 },function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_main_menu").html(data); }, 300);	
}); 	
}

//*---delete---
function ag_delete_item(id) {
id = id.split(',');	
$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", {  delete_item: id }, 
function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); ag_width(); }, 650);
});
ag_cancel();
ag_remove_checked();
var timeout = 400;
for (var i = 0; i < id.length; i++) {

$("#item_"+id[i]+" span, #item_"+id[i]+" div.ag_name").addClass("ag_deleted");
$("#item_"+id[i]+" div.ag_item_inner").animate({ marginLeft: "-16px" }, 300).animate({ marginLeft: "120%" }, 200);
$("#item_"+id[i]).delay(600).queue(function() { $(this).remove(); });

}

$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_update_menu.php'.$ag_tab_url.$ag_id_url; ?>", {  remove_menu: 1 },function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_main_menu").html(data); }, 300);	
}); 


if ($("#"+id)) {
$("#"+id).fadeOut(300);
setTimeout(function() { 
$("#"+id).remove();
$('#ag_coomon_search_result ul li').removeClass("ag_cange_sear_result");
var count_sear_items = 0;
$('#ag_coomon_search_result ul li').each(function(i,elem) { count_sear_items++;
if (i%2) { $("#ag_coomon_search_result ul li:eq("+i+")").addClass("ag_cange_sear_result"); }
});
$("#ag_found_info strong").text(count_sear_items);
}, 400);	
}

return false;	
}

//*---delete in search---
function ag_delete_search_item(id, dir, file, num, name) {
ag_dialog(""+id+"", name, "<?php echo $ag_lng['confirm_delete']; ?>", "ag_delete_search_item_confirm('"+id+"', '"+dir+"', '"+file+"', '"+num+"', '"+name+"')", "icon-attention ag_str_orange", "button2");
}
function ag_delete_search_item_confirm(id, dir, file, num, name) {
$.post("<?php echo $srv_script_absolute_url.'inc/ag_post.php'; ?>", {delete_item: id, delete_item_dir: dir, delete_item_file: file});
ag_cancel();
$("#"+id+""+num).css({transition: "none"});
$("#"+id+""+num).fadeOut(400);

$.post("<?php echo $srv_script_absolute_url.'inc/ag_update_menu.php'; ?>", {  remove_menu: 1 },function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_main_menu").html(data); }, 300);	
}); 

setTimeout(function() { 
$("#"+id+""+num).remove();
$('#ag_coomon_search_result ul li').removeClass("ag_cange_sear_result");
var count_sear_items = 0;
$('#ag_coomon_search_result ul li').each(function(i,elem) { count_sear_items++;
if (i%2) { $("#ag_coomon_search_result ul li:eq("+i+")").addClass("ag_cange_sear_result"); }
});
$("#ag_found_info strong").text(count_sear_items);
}, 500);	
}

//*---on item---
function ag_on_item(id) {
var ag_this_id = "<?php echo $ag_this_id; ?>";
id = id.split(',');	
$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", { id_on_off: id, status: "on" }, 
function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); }, 300);
});
for (var i = 0; i < id.length; i++) { 
$("#ag_on_off_"+id[i]).html("<span class=\"ag_act_tool\" onclick=\"ag_off_item('"+id[i]+"')\"><i class=\"icon-toggle-on\"></i><span class=\"ag_title\"><?php echo $ag_lng['on']; ?></span></span>");
if (id[i] == ag_this_id) {ag_check_this_on();}
}
ag_remove_checked();
return false;	
}

//*---off item---
function ag_off_item(id) {
var ag_this_id = "<?php echo $ag_this_id; ?>";
id = id.split(',');	
$.post("<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", { id_on_off: id, status: "off" }, 
function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); }, 300);
});
for (var i = 0; i < id.length; i++) { 
$("#ag_on_off_"+id[i]).html("<span class=\"ag_act_tool\" onclick=\"ag_on_item('"+id[i]+"')\"><i class=\"icon-toggle-off\"></i><span class=\"ag_title\"><?php echo $ag_lng['off']; ?></span></span>");
if (id[i] == ag_this_id) {ag_check_this_off();}
}
ag_remove_checked();
return false;	
}

//*---this on item---
function ag_check_this_on() {
if ($("input.ag_active_checkbox[type=checkbox]").prop("checked")) {} else {
$("input.ag_active_checkbox[type=checkbox]").click();
}	
}
//*---this off item---
function ag_check_this_off() {
$("input.ag_active_checkbox[type=checkbox]:checked").click();		
}

//*---up item---
function ag_up_item(id) {
$.post("<?php echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", { moves: id, where: "up"}, 
function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); }, 500); });



<?php if ($ag_db_settings_reverse == 1) { ?>
var h_elem = $("#item_"+id).outerHeight(true);
var dw_elem_n = $("#item_"+id).index("div.ag_item") + 1;
$("#item_"+id+" div.ag_item_inner").animate({ top: h_elem + "px" }, 250);
$(".ag_item:eq("+dw_elem_n+") div.ag_item_inner").animate({ top: "-" + h_elem + "px" }, 300);
return false;	
<?php } else { ?>
var h_elem = $("#item_"+id).outerHeight(true);
var up_elem_n = $("#item_"+id).index("div.ag_item") - 1;
$("#item_"+id+" div.ag_item_inner").animate({ top: "-" + h_elem + "px" }, 250);
$(".ag_item:eq("+up_elem_n+") div.ag_item_inner").animate({ top: h_elem + "px" }, 300);
<?php } ?>
return false;	
}

//*---down item---
function ag_down_item(id) {
$.post("<?php echo $srv_script_absolute_url.'inc/ag_post.php'.$ag_tab_url.$ag_id_url; ?>", { moves: id, where: "down"}, 
function onAjaxSuccess(data) { 
setTimeout(function() { $("#ag_list_items").html(data); }, 500); });


<?php if ($ag_db_settings_reverse == 1) { ?>
var h_elem = $("#item_"+id).outerHeight(true);
var up_elem_n = $("#item_"+id).index("div.ag_item") - 1;
$("#item_"+id+" div.ag_item_inner").animate({ top: "-" + h_elem + "px" }, 250);
$(".ag_item:eq("+up_elem_n+") div.ag_item_inner").animate({ top: h_elem + "px" }, 300);
<?php } else { ?>
var h_elem = $("#item_"+id).outerHeight(true);
var dw_elem_n = $("#item_"+id).index("div.ag_item") + 1;
$("#item_"+id+" div.ag_item_inner").animate({ top: h_elem + "px" }, 250);
$(".ag_item:eq("+dw_elem_n+") div.ag_item_inner").animate({ top: "-" + h_elem + "px" }, 300);
<?php } ?>
return false;	
}

//*---checkboxes items---
<?php $ag_moove_ch = 'right'; $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { $ag_moove_ch = 'bottom'; } ?>
function ag_remove_checked() {
ag_list_tools_close();
$(".ag_item_inner input[type=checkbox]:checked").removeAttr("checked");
$(".ag_checkbox i").removeClass("icon-check");
$(".ag_checkbox i").addClass("icon-check-empty");
$(".ag_item span, .ag_item a, .ag_item div.ag_name").removeClass("ag_checked_item");
$("div.ag_item_inner").removeClass("ag_checked_inner");
return false;
}

function ag_check_item(e) {

if ($(e).find("label input[type=checkbox].ag_items_check").prop("checked")) { 

var ch_val = $(e).find("label input[type=checkbox].ag_items_check").val(); 
$("#checkbox_"+ ch_val +" i").removeClass("icon-check-empty");
$("#checkbox_"+ ch_val +" i").addClass("icon-check");
$("#item_"+ ch_val +" span, #item_"+ ch_val +" div.ag_name").addClass("ag_checked_item");
$("#item_"+ ch_val + " div.ag_item_inner").addClass("ag_checked_inner");

} else { 

var ch_val = $(e).find("label input[type=checkbox].ag_items_check").val(); 
$("#checkbox_"+ ch_val +" i").removeClass("icon-check");
$("#checkbox_"+ ch_val +" i").addClass("icon-check-empty");
$("#item_"+ ch_val +" span, #item_"+ ch_val +" div.ag_name").removeClass("ag_checked_item");
$("#item_"+ ch_val + " div.ag_item_inner").removeClass("ag_checked_inner");

}

var n = 0;
n = $( ".ag_item_inner input[type=checkbox]:checked" ).length;
$("#ag_checked_count").html("<?php echo $ag_lng['selected_items']; ?>: <strong>" + n + "</strong>");
if (n > 0) {
ag_list_tools_open();
} else {
ag_list_tools_close();
}

}


function ag_list_tools_open() {
var ag_list_w = $("#ag_list_items").outerWidth(true);
var ag_ch_tools_h = $("#ag_checked_tools").outerHeight(true);
$("#ag_checked_tools").animate({<?php echo $ag_moove_ch; ?>: "0"}, 300); 
$("#ag_list_items div.ag_list_items_inner").css({paddingBottom: (ag_ch_tools_h + 16) + "px" });
$(".ag_list_items_bottom").css({display: "none"});	
}

function ag_list_tools_close() {
$("#ag_checked_tools").animate({<?php echo $ag_moove_ch; ?>: "-100%"}, 200);
$("#ag_list_items div.ag_list_items_inner").css({paddingBottom: "0px" });
$(".ag_list_items_bottom").css({display: "block"});	
return false;
}


//*---photos--- 
function ag_photos() {	
var phw = $(".ag_gallery_item").outerWidth(true);
var phh = (phw * 9) / 16;
$(".ag_photos_inner").css({height: phh + "px"});
$(".ag_photos_inner img").css({minHeight: phh + "px"});

var main_width = $(window).outerWidth(true);

if (main_width < 800) { 
$(".ag_gallery_item").css({width: "100%"}); 
setTimeout(function(){ 
var phwe = $(".ag_gallery_item").outerWidth(true); 
var phhe = (phwe * 9) / 16;
$(".ag_photos_inner").css({height: phhe + "px"}); 
$(".ag_photos_inner img").css({minHeight: phhe + "px"});
}, 50);
	
} else { 
$(".ag_gallery_item").css({width: "50%"}); 
setTimeout(function(){ 
var phwe = $(".ag_gallery_item").outerWidth(true); 
var phhe = (phwe * 9) / 16;
$(".ag_photos_inner").css({height: phhe + "px"}); 
$(".ag_photos_inner img").css({minHeight: phhe + "px"});
}, 50);
}

setTimeout(function(){ 
for (var i = 0; i < $(".ag_photos_inner").length; i++) {
var ag_photos_inner_height = $(".ag_photos_inner").eq(i).find("img").outerHeight(true);
if (ag_photos_inner_height > $(".ag_photos_inner").eq(i).outerHeight(true)) {
var ag_photos_inner_center_top = (ag_photos_inner_height - $(".ag_photos_inner").eq(i).outerHeight(true)) / 2;
if (ag_photos_inner_center_top < 16) {ag_photos_inner_center_top = 0;}	
$(".ag_photos_inner").eq(i).find("img").css({position: "absolute", top: "-" + ag_photos_inner_center_top + "px"});
} else { $(".ag_photos_inner").eq(i).find("img").css({position: "absolute", top: "0px"}); }
}
}, 70);
	
}//*---ag_photos---
$(document).ready(function(){ ag_photos(); ag_responsitive(); });
$(window).load(function(){ag_photos(); ag_responsitive();});
$(window).on('resize', function(event) { ag_photos(); ag_responsitive(); });	


//*---open file manager or other iframe---
function ag_open_ifm(id, cat, type) {
var ag_url_ifm = "";

if (type == "ag_item") {

if (id != "") {
var id_item = $("#input_"+id).val();
if (!id_item || id_item == "") {id_item = id;}
var id_arr = id_item.split("_");
var tab = id_arr[0];
}

if (id_item) {
if (cat) {tab = tab + "&cat=" + cat;}
ag_url_ifm = "?tab="+tab+"&id="+id_item+"&iframe"; 
id_item = null; id = null;
} else { ag_dialog("1800", "<?php echo $ag_lng['not_selected_items']; ?>.", "<?php echo $ag_lng['no_value']; ?>!", "quick_mess", "icon-attention ag_str_orange", ""); }	

} else if (type == "ag_menu") {
	
ag_url_ifm = "filemanager/dialog.php?akey=<?php echo $ag_fm_key; ?>";

} else if (type == "ag_icon") {

ag_url_ifm = "inc/icons.php?input="+id;

} else if (type == "ag_url") {
	
ag_url_ifm = cat;

} else {
	
if (id != "") {ag_url_ifm = "filemanager/dialog.php?field_id="+ id +"&type="+ type +"&relative_url=1&akey=<?php echo $ag_fm_key; ?>";}

}

setTimeout(function(){ id = null; ag_url_ifm = ""}, 100);

if (ag_url_ifm != "") {
$.colorbox({
close: "<i class=\"icon-cancel\"></i>",
iframe:true, 
transition:"elastic", 
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
fixed:true,
top:"0",
width:"100%", 
height:"100%", 
<?php } else { ?>
fixed:true,
top:"16px",
width:"80%", 
height:"90%", 
<?php } ?>
opacity:"100", 
href:ag_url_ifm
});	
id = null;
ag_url_ifm = null;
return false;
}
}


//*---images & video insert---
function responsive_filemanager_callback(field_id){ 
var type = "";
if (field_id) {
if (field_id.indexOf("video") + 1) { type = 3; }

    var url = "<?php echo $ag_data_upload_dir; ?>/" + jQuery("#" +field_id).val();		
			
	if (type == 3) { 
	$("#" + field_id).html("<video src=\""+ url +"\" controls=\"controls\"></video>"); 
    $("#input_video_" + field_id).val(url);
	
	} else { 
	$("#img_" + field_id).html("<img src=\""+ url +"\" alt=\"photo\" />"); 
	<?php if (isset($_GET['iframe']) && $ag_this_db == $ag_staff_db && $ag_user_id == $ag_this_id) { ?>
	
	parent.document.getElementById("ag_this_user_photo").innerHTML = "<img src=\""+ url +"\" alt=\"<?php if (!empty($ag_user_name)) {echo $ag_user_name;} else {echo 'Staff';} ?>\" />";
	
	<?php } ?>
	ag_photos();
	}
	$("#input_" + field_id).val(url); 
	setTimeout(function(){ $("#cboxClose").click();  }, 70);	
	setTimeout(function(){ $(field_id).click();  }, 100);
	
}

}

//*---reset images & video---
function reset_img(img_id) {
var type = "";
if(img_id.indexOf('video') + 1) {type = 3;}
$("#input_"+img_id).val("");
if (type == 3) { 
$("#"+ img_id).html("<img src=\"img/no_video.png\" alt=\"no video\" />"); 
} else {
$("#img_"+ img_id).html("<img src=\"img/no_photo.png\" alt=\"no photo\" />");	
}
}

//*---only digital input sp---
function ag_swingPrice(obj) {
if (this.ST) return; var ov = obj.value;
var ovrl = ov.replace (/-?\d*\.?\d*\%?/, '').length; 
this.ST = true;
if (ovrl > 0) {obj.value = obj.lang; ag_swingPriceError(obj); return}
obj.lang = obj.value; this.ST = null;
}
function ag_swingPriceError(obj) {
if (!this.OBJ) { this.OBJ = obj; $(obj).parent().css({background:'pink'}); $(obj).css({background:'pink'}); this.TIM = setTimeout(ag_swingPriceError, 100)}
else { $(this.OBJ).parent().removeAttr('style'); $(this.OBJ).removeAttr('style'); clearTimeout(this.TIM); this.ST = null; ag_swingPrice(this.OBJ); this.OBJ = null}
}


//*--- phone check ---
function ag_phone_check(obj) {
if (this.ST) return; var ov = obj.value;
//*--- var ovrl = ov.replace (/[+]\d*/, '').length; ---
var ovrl = ov.replace (/\d*/, '').length;
this.ST = true;
if (ovrl > 0) {obj.value = obj.lang; ag_phone_checkError(obj); return}
obj.lang = obj.value; this.ST = null;
}
function ag_phone_checkError(obj) {
if (!this.OBJ) { this.OBJ = obj; $(obj).parent().css({background:'pink'}); $(obj).css({background:'pink'}); this.TIM = setTimeout(ag_phone_checkError, 100)}
else {$(this.OBJ).parent().removeAttr('style'); $(this.OBJ).removeAttr('style'); clearTimeout(this.TIM); this.ST = null; ag_phone_check(this.OBJ); this.OBJ = null}
}


//*---only digital input---
function ag_onlyDigital(obj) {
if (this.ST) return; var ov = obj.value;
var ovrl = ov.replace (/\d*/, '').length; this.ST = true;
if (ovrl > 0) {obj.value = obj.lang; ag_onlyDigitalError(obj); return}
obj.lang = obj.value; this.ST = null;
}
function ag_onlyDigitalError(obj) {
if (!this.OBJ) { this.OBJ = obj; $(obj).parent().css({background:'pink'}); $(obj).css({background:'pink'}); this.TIM = setTimeout(ag_onlyDigitalError, 100)}
else {$(this.OBJ).parent().removeAttr('style'); $(this.OBJ).removeAttr('style'); clearTimeout(this.TIM); this.ST = null; ag_onlyDigital(this.OBJ); this.OBJ = null}
}

//*---only digital input f---
function ag_onlyDigital_fraction(obj) {
if (this.ST) return; var ov = obj.value;
var ovrl = ov.replace (/\d*\.?\d*/, '').length; this.ST = true;
if (ovrl > 0) {obj.value = obj.lang; ag_onlyDigitalError_fraction(obj); return}
obj.lang = obj.value; this.ST = null;
}
function ag_onlyDigitalError_fraction(obj) {
if (!this.OBJ) { this.OBJ = obj; $(obj).parent().css({background:'pink'}); $(obj).css({background:'pink'}); this.TIM = setTimeout(ag_onlyDigitalError_fraction, 100)}
else { $(this.OBJ).parent().removeAttr('style'); $(this.OBJ).removeAttr('style'); clearTimeout(this.TIM); this.ST = null; ag_onlyDigital_fraction(this.OBJ); this.OBJ = null}
}

//*---number input---
function ag_number_up(inp_id) {
var ag_number = $("#"+inp_id).val();
if (!ag_number) {ag_number = 0;}
ag_number = parseFloat(ag_number);
$("#"+inp_id).val(ag_number+1);
}

function ag_number_down(inp_id) {
var ag_number = $("#"+inp_id).val();
if (!ag_number) {ag_number = 0;}
ag_number = parseFloat(ag_number);
if (ag_number > 1) {
$("#"+inp_id).val(ag_number-1);	
} else { $("#"+inp_id).val(0); }
}

//*---number fraction input---
function ag_number_fraction_up(inp_id) {
var ag_number = $("#"+inp_id).val();
if (!ag_number) {ag_number = 0.0;}
ag_number = parseFloat(ag_number);
$("#"+inp_id).val(ag_number+0.5);
}

function ag_number_fraction_down(inp_id) {
var ag_number = $("#"+inp_id).val();
if (!ag_number) {ag_number = 0.0;}
ag_number = parseFloat(ag_number);
if (ag_number > 1) {
$("#"+inp_id).val(ag_number-0.5);	
} else { $("#"+inp_id).val(0); }
}



//*---width height left-right area---
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { ?>
function ag_width() {
var ag_win_w = $("body").outerWidth(true);
var ag_win_h = $(window).height();	

var ag_work_h = ag_win_h - ($("#ag_top").outerHeight(true) + $("#ag_top_tools").outerHeight(true));
$("#ag_edit_block").css({height: ag_work_h + "px", maxHeight: ag_work_h + "px"});

var ag_right_w = $("#ag_list_items").outerWidth(true);
ag_win_w = $("body").outerWidth(true);
var ag_left_w = ag_win_w - ag_right_w;

$("#ag_save_btn_top").css({marginRight: (ag_right_w) + "px"});

<?php if (!isset($_GET['iframe'])) { ?>
$("#ag_edit_block").css({width: ag_left_w + "px"});
var ag_list_w_p = $("#ag_list_items").outerWidth(true);
$("#ag_top_btn").css({right: (ag_list_w_p + 16) + "px"});
<?php } else { ?>

<?php } // iframe ?>
}
$(document).ready(function(){ ag_width(); });
$(window).on('resize', function(event) { ag_width(); });	
<?php } ?>

//*---main menu---
function ag_open_menu() {
var ag_tabs_menu_w = $("#ag_tabs_menu").outerWidth(true);
$("#ag_tabs_menu").animate({left: "0px"}, 300);	
$("#ag_open_menu").fadeOut(200);
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
$("#ag_close_menu").animate({right: "0px"}, 300);
<?php } else { ?>
$("#ag_close_menu").animate({left: (ag_tabs_menu_w + 16) + "px"}, 300);
<?php } ?>
}
function ag_close_menu() {
$("#ag_tabs_menu").animate({left: "-100%"}, 200);
$("#ag_open_menu").fadeIn(400);
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
$("#ag_close_menu").animate({right: "-100%"}, 200);	
<?php } else { ?>
$("#ag_close_menu").animate({left: "-100%"}, 200);	
<?php } ?>
}
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { } else { ?>
$("#ag_open_menu").hover(function(){
ag_open_menu();	
});
$("#ag_top, #ag_top_tools, #ag_edit_block").click(function(){
ag_close_menu();	
});

<?php } ?>



//*---mobile list menu---
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
function ag_open_list() {
$("#ag_list_items").animate({right: "0px"}, 400);	
$("#ag_open_list").animate({top: "-100%"}, 400);
$("#ag_close_list").fadeIn(400);
}
function ag_close_list() {
$("#ag_list_items").animate({right: "-100%"}, 200);
$("#ag_open_list").animate({top: "16px"}, 400);
$("#ag_close_list").fadeOut(400);	
}
$("#ag_top, #ag_top_tools, .ag_title_element, .ag_not_select_item").click(function(){
ag_close_list();
});
<?php if(!isset($ag_item_count)) {$ag_item_count = 0;} if ($ag_item_count > 0 && !isset($_GET['id']) && !isset($_GET['common_search']) && !isset($_GET['filter'])) { ?>
setTimeout(function(){ ag_open_list(); }, 1700);
<?php } ?>
<?php } ?>

//*---user info---
function ag_close_user_info() {
$(".ag_user_info_inner").fadeOut(300);
}
function ag_open_user_info() {
$(".ag_user_info_inner").fadeIn(300);
}

var ag_user_photo_w = $(".ag_this_user_photo").outerWidth(true);
var ag_user_photo_h = (ag_user_photo_w * 9) / 16;
$(".ag_this_user_photo").css({height: ag_user_photo_h + "px", overflow: "hidden"});



//*---filter---
function ag_filter(input, sear_id, sear_name, db_name) {
$("#"+input+" span").text(sear_name);
$("#"+input).find(" + ul li").removeClass("ag_this_filter");
document.location.href="<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.$ag_tab_url.'&filter_query='; ?>"+sear_id+"&filter="+db_name;
}

var ag_filter_opt = 0;
function ag_filter_select_view(filter_id, num) {
$("#"+filter_id+" div.ag_filter_list").fadeIn(300);	
ag_active(filter_id + " .ag_filter_inner");

$("#ag_search_inp_filter_"+num).focus(function() {
ag_filter_opt = 1;
});
$("#reset_search_filter_"+num).click(function() {
$("#ag_search_inp_filter_"+num).val("");
ag_filter_opt = 0;
$("#"+ filter_id +" div.ag_filter_inner").blur();
});
$("#ag_content_search_list_filter_"+num).click(function() {
ag_filter_opt = 0;
$("#"+ filter_id +" div.ag_filter_inner").blur();
});
return ag_filter_opt;
}


function ag_filter_select_hidden(filter_id) {
setTimeout(function(){ ag_filter_select_blur_time(filter_id); }, 100);
ag_out(filter_id + " .ag_filter_inner");		
}

function ag_filter_select_blur_time(filter_id) {
if (ag_filter_opt == 0)  { $("#"+filter_id+" div.ag_filter_list").fadeOut(140); }
}

function ag_save_item() {
$("#ag_save_btn_bottom").click();	
}

//*---search in list---
$(".agt_search_next").css("display", "none");
function ag_search_in_list(input, list, cont, btn, btnn) {

var check_val = $("#"+input).val(); if (check_val.length < 3) { 
ag_dialog("1500", "<ul><li><?php echo $ag_lng['empty_query']; ?></li></ul>", "<?php echo $ag_lng['abort']; ?>", "ag_cancel", "icon-attention ag_str_orange", "button0");
return false; 
}
var search = $("#"+input),
content = $("#"+cont),
matches = "",
matches = $(), 
index = 0;	

var agt_search_go = $("#"+btn);

content.find("span").removeClass("ag_this_found");
content.find("span").removeClass("match");

if (search.val().length >= 3) {
$("#"+btnn).fadeIn(300);
$("#"+btn).css({display: "none"});
content.highlight(search.val(), function(found) {
matches = found;
if (matches.length && content.is(":not(:animated)")){ scroll(0); }
});
} 


function scroll(i) { index = i; 
$(".match").removeClass("ag_this_found");
if (list == "ag_list_items_block") { 
content.scrollTo(matches.eq(i).closest("div.ag_item"), 600, { axis:"y" } ); 
} else { content.scrollTo(matches.eq(i).parent(), 300, { axis:"y" } ); }
matches.eq(i).addClass("ag_this_found");
}	
function scrollNext() { 
if (list == "ag_list_items_block") { matches.length && scroll( (index + 2) % matches.length ); }
else { matches.length && scroll( (index + 1) % matches.length ); }
}
$("#"+btnn).click(function(){ scrollNext(); });

var ag_found_count = content.find(".match").length;

var reset_list_sear = setInterval(function(){
    var curVal = search.val();
    var prevVal  = check_val || null;

if (prevVal != curVal) {
$("#"+btnn).css({display: "none"});
$("#"+btn).fadeIn(300);
matches = $();
content.find("span").removeClass("ag_this_found");
content.find("span").removeClass("match");
ag_found_count = 0;
clearInterval(reset_list_sear);
}

}, 100);

$("#"+btnn).html('<?php echo $ag_lng['next_search']; ?><i class="icon-forward-circled"></i>');	

if (ag_found_count == 0) { $("#"+btnn).html('<span class="ag_disabled"><?php echo $ag_lng['not_found_list']; ?></span>'); }
if (list == "ag_list_items_block") { if (ag_found_count == 2) {$("#"+btnn).html('<?php echo $ag_lng['end_found_list']; ?>');} }
else {if (ag_found_count == 1) {$("#"+btnn).html('<?php echo $ag_lng['end_found_list']; ?>');}}

}


//*---config tabs menu---
$(".ag_cfg_element").css({display: "none"});
function ag_cfg_tabs(id_tab) {
$(".ag_cfg_tab").removeClass("ag_this_cfg_tab");
$(".ag_cfg_element").css({display: "none"});	
$("."+id_tab).fadeIn(160);
$("#ag_cfg_settings").attr("action","?settings&cfgtab="+id_tab);
$("#"+id_tab).addClass("ag_this_cfg_tab");
var el_tab_count = $("div.ag_cfg_element:visible").length;	

for (var i = 0; i < el_tab_count; i++) { 
if (i%2) { $("div.ag_cfg_element:visible:eq("+i+")").addClass("ag_cfg_element_second"); }
}

}

var ag_top_margin = $("#ag_top").outerHeight(true);
function ag_cfg_tabs_mob_open() {
$("#ag_cfg_tabs").stop().animate({top: (ag_top_margin + 8) + "px"}, 250).animate({top: ag_top_margin + "px"}, 100);
$("#ag_cfg_tabs_mob_open").fadeOut(300);
$("#ag_cfg_tabs_mob_close").fadeIn(300);	
}
function ag_cfg_tabs_mob_close() {
$("#ag_cfg_tabs").stop().animate({top: "-100%"}, 300);
$("#ag_cfg_tabs_mob_open").fadeIn(300);
$("#ag_cfg_tabs_mob_close").fadeOut(300);
}
$(document).mouseup(function (e) {
var ag_cl_el = $(".ag_cfg_tabs_mob");
if (!ag_cl_el.is(e.target) && ag_cl_el.has(e.target).length === 0) {	
setTimeout(function(){ ag_cfg_tabs_mob_close(); }, 200);
}
});

<?php


if (isset($ag_ERROR)) {
$error_mess_str = '';
foreach ($ag_ERROR as $error_mess) {
$error_mess_str .= '<li>' .$error_mess. '</li>';
}

echo '
ag_dialog("3000", "<ul>' .$error_mess_str. '</ul>", "'.$ag_lng['error'].'", "ag_cancel", "icon-roadblock ag_str_red", "button0");
';	
}

if (isset($ag_WARING)) {
$waring_mess_str = '';
foreach ($ag_WARING as $waring_mess) {
$waring_mess_str .= '<li>' .$waring_mess. '</li>';
}

echo '
ag_dialog("3000", "<ul>' .$waring_mess_str. '</ul>", "'.$ag_lng['waring'].'!", "ag_cancel", "icon-exclamation ag_str_orange", "button0");
';	
}

if (!isset($ag_ERROR)) { 
foreach ($ag_data as $n => $val) { 
if (isset($_GET['id']) && isset($val['id']) && $_GET['id'] == $val['id']) { 

if (isset($val['title'])) {$val['name'] = $val['title'];}
if (!isset($val['name'])) {$val['name'] = $ag_lng['no_name'];}

echo '
$(document).ready(function(){
var done_id = window.location.hash.replace("#","");	
if (done_id != "") {
if (done_id.indexOf("item_") == 0) { } else {
ag_dialog(1800, \'' .$val['name']. '\', \''.$ag_lng['done'].'.\', \'quick_mess\', \'icon-ok-3 ag_str_green\', \'\');
window.location.hash = "item_" + done_id;
}
}
});
';
}
}
}// isset ag_ERROR

?>

<?php } // auth none ------------------------------------------------- ?>

//*---logout---
function ag_logout() {
document.location.href="<?php echo $srv_script_absolute_url; ?>?logout";
}
//*---reload---
function ag_reload(time) {
document.location.href="<?php $ag_id_url = str_replace('&amp;', '&', $ag_id_url); $ag_tab_url = str_replace('&amp;', '&', $ag_tab_url); echo $srv_script_absolute_url.$ag_tab_url.$ag_id_url; ?>";
}

<?php if (isset($ag_first_open) && !isset($_GET['tab']) && !isset($_GET['settings'])) { ?>
ag_dialog("ag_firsst_open", '<div><?php echo $ag_lng['firsst_open']; ?></div>', "<?php echo $ag_lng['hello']; ?>", "ag_cancel", "icon-chat ag_str_green", "button1");
<?php } ?>

</script>



</body>
</html>