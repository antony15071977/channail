<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


$ag_db_settings_reverse = 0; // db settings revers default

if (isset($ag_db_settings[$ag_this_db])) { 
if (isset($ag_db_settings[$ag_this_db]['revers'])) { $ag_db_settings_reverse = $ag_db_settings[$ag_this_db]['revers']; }
}
if ($ag_db_settings_reverse == 1) { $ag_data = array_reverse($ag_data, true); } // inverse data lines



$ag_item_count = 0;

$ag_new_list_items = '';
$ag_new_list_items .=  '<div class="ag_list_items_inner" id="ag_items_area">';


foreach ($ag_data as $n => $val) { if (!empty($val)) {$ag_item_count++;}
if (isset($val['id'])) {
$ag_item_status = '';
if (isset($val['status'])) {$ag_item_status = $val['status'];}	
if (isset($val['title'])) {$val['name'] = $val['title'];}
if (!isset($val['name'])) {$val['name'] = $ag_lng['no_name'];}



$ag_last_item_class = '';
if ($ag_db_settings_reverse == 1) {
if ($n == 0) {$ag_last_item_class = ' ag_last_item';}
} else {
if ($n == sizeof($ag_data) - 1) {$ag_last_item_class = ' ag_last_item';}
}
$ag_new_list_items .=  '<div class="ag_item' .$ag_last_item_class. '" id="item_' .$val['id']. '">';
$ag_new_list_items .=  '<div class="ag_item_inner">';

// name item
$ag_new_list_items .=  '<div class="ag_name_item">';


$ag_sn_left = '';
$ag_sn_right = '';
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { 
$ag_sn_left = '<span class="ag_sn_left" tabindex="-1"><i class="icon-left-open"></i></span>';
$ag_sn_right = '<span class="ag_sn_right" tabindex="-1"><i class="icon-right-open"></i></span>';
}


//-------------------------USERS ACCESS LEVELS
$ag_list_user_access = '';
$ag_title_level_acces = '';
$ag_icon_access = '';
$ag_founder_item = 0;

if ($ag_this_db == $ag_staff_db && isset($ag_users) && isset($ag_access_levels)) {
$ag_list_user_access = '';
$ag_title_level_acces = $ag_lng['user'];
foreach ($ag_users as $nu => $ag_user) {
if (isset($ag_user['id']) && isset($ag_user['access'])) {
if ($val['id'] == $ag_user['id']) { $ag_list_user_access = $ag_user['access']; } // this user access
}// isset id & access
}// foreach ag_users
$ag_icon_access = '<i class="icon-user-5"></i>';

if ($ag_list_user_access == 1) {
$ag_icon_access = '<i class="icon-star-5"></i>';
if (isset($ag_access_levels[$ag_list_user_access]['name']) && isset($ag_lng[$ag_access_levels[$ag_list_user_access]['name']])) {$ag_title_level_acces = $ag_lng[$ag_access_levels[$ag_list_user_access]['name']];}
}
if ($ag_list_user_access == 2) {
$ag_icon_access = '<i class="icon-pencil-7"></i>';
if (isset($ag_access_levels[$ag_list_user_access]['name']) && isset($ag_lng[$ag_access_levels[$ag_list_user_access]['name']])) {$ag_title_level_acces = $ag_lng[$ag_access_levels[$ag_list_user_access]['name']];}
}
if ($ag_list_user_access == 3) {
$ag_icon_access = '<i class="icon-user-5"></i>';
if (isset($ag_access_levels[$ag_list_user_access]['name']) && isset($ag_lng[$ag_access_levels[$ag_list_user_access]['name']])) {$ag_title_level_acces = $ag_lng[$ag_access_levels[$ag_list_user_access]['name']];}
}
if ($ag_list_user_access == 'founder') {
$ag_icon_access = '<i class="icon-cog-7"></i>'; 
$ag_title_level_acces = $ag_lng['founder'];
$ag_founder_item = 1;
}
}// staff db
//-------------------------USERS ACCESS LEVELS



$ag_check_on = '';
$ag_check_off = '';
if (isset($ag_this_id) && $ag_this_id == $val['id']) {

$ag_check_on = '; ag_check_this_on()';
$ag_check_off = '; ag_check_this_off()';
$ag_new_list_items .=  '<div class="ag_name ag_this_item">'.$ag_sn_left.'<span class="ag_name_str" title="'.$ag_title_level_acces.'">'.$ag_icon_access.' ' .$val['name']. '</span>'.$ag_sn_right.'</div>'; 
} else { 
$ag_added_class = '';
if (isset($_GET['added']) && $val['id'] == $_GET['added']) {$ag_added_class = ' ag_added_item';}
$ag_new_list_items .=  '<div class="ag_name'.$ag_added_class.'">'.$ag_sn_left.'<a href="' .$ag_tab_url. '&amp;id=' .$val['id']. '#item_' .$val['id']. '" title="'.$ag_title_level_acces.'">'.$ag_icon_access.' ' .$val['name']. '</a>'.$ag_sn_right.'</div>'; }


$ag_new_list_items .=  '<div class="clear"></div>'; 
$ag_new_list_items .=  '</div>'; // ag_name_item
	

	
	

// tools item
$ag_new_list_items .=  '<div class="ag_tools_item" id="item_tools_' .$val['id']. '">';


if ($ag_founder_item == 1) {

$ag_new_list_items .= '<span class="ag_checkbox"><i class="icon-check-empty ag_disabled"></i></span>';
$ag_new_list_items .= '<span class="ag_delete"><i class="icon-cancel-2 ag_disabled"></i></span>';
$ag_new_list_items .= '<span class="ag_on_off"><i class="icon-toggle-on ag_disabled"></i></span>';
$ag_new_list_items .= '<span class="ag_up_down"><i class="icon-up-1 ag_disabled"></i></span>';
$ag_new_list_items .= '<span class="ag_up_down"><i class="icon-down-1 ag_disabled"></i></span>';

} else {	




// checkbox
$ag_new_list_items .=  '<span class="ag_checkbox" id="checkbox_' .$val['id']. '" onclick="ag_check_item(this)">
<label><input type="checkbox" name="item[' .$n. ']" value="' .$val['id']. '" class="ag_items_check" />
<span class="ag_none">' .$val['name']. '</span>
<i class="icon-check-empty"></i></label>
</span>';
// delete
$ag_new_list_items .=  '<span class="ag_delete ag_this_title" onclick="ag_dialog(\''.$val['id'].'\', \'' .$val['name']. '\', \''.$ag_lng['confirm_delete'].'!\', \'ag_delete_item\', \'icon-attention ag_str_orange\', \'button2\')"><i class="icon-cancel-2"></i><span class="ag_title">' .$ag_lng['delete']. '</span></span>';
// on/off
if ($ag_item_status == 1) {
$ag_new_list_items .=  '<span class="ag_on_off ag_this_title" id="ag_on_off_' .$val['id']. '">
<span class="ag_act_tool" onclick="ag_off_item(\''.$val['id'].'\')' .$ag_check_off. '">
<i class="icon-toggle-on"></i><span class="ag_title">' .$ag_lng['off']. '</span>
</span>
</span>';	
} else {
$ag_new_list_items .=  '<span class="ag_on_off ag_this_title" id="ag_on_off_' .$val['id']. '">
<span class="ag_act_tool" onclick="ag_on_item(\''.$val['id'].'\')' .$ag_check_on. '">
<i class="icon-toggle-off"></i><span class="ag_title">' .$ag_lng['on']. '</span>
</span> 
</span>';
}
// moove up/down
if ($ag_db_settings_reverse == 1) {

if ((sizeof($ag_data) - 1) == $n)	{
$ag_new_list_items .=  '<span class="ag_up_down"><i class="icon-up-1 ag_disabled"></i></span>';	
} else {
$ag_new_list_items .=  '<span class="ag_up_down ag_this_title" onclick="ag_down_item(\''.$val['id'].'\')" id="down_'.$val['id'].'"><i class="icon-up-1"></i><span class="ag_title">' .$ag_lng['moove_up']. '</span></span>';
}
if ($n == 0) {
$ag_new_list_items .=  '<span class="ag_up_down ag_last"><i class="icon-down-1 ag_disabled"></i></span>';		
} else {
if ($ag_this_db == $ag_staff_db && $n == 1) {
$ag_new_list_items .=  '<span class="ag_up_down"><i class="icon-up-1 ag_disabled"></i></span>';	
} else {
$ag_new_list_items .=  '<span class="ag_up_down ag_this_title" onclick="ag_up_item(\''.$val['id'].'\')" id="up_'.$val['id'].'"><i class="icon-down-1"></i><span class="ag_title">' .$ag_lng['moove_down']. '</span></span>';
}
}

} else { // true
	
if ($n == 0) {
$ag_new_list_items .=  '<span class="ag_up_down"><i class="icon-up-1 ag_disabled"></i></span>';	
} else {
if ($ag_this_db == $ag_staff_db && $n == 1) {
$ag_new_list_items .=  '<span class="ag_up_down"><i class="icon-up-1 ag_disabled"></i></span>';	
} else {
$ag_new_list_items .=  '<span class="ag_up_down ag_this_title" onclick="ag_up_item(\''.$val['id'].'\')" id="up_'.$val['id'].'"><i class="icon-up-1"></i><span class="ag_title">' .$ag_lng['moove_up']. '</span></span>';
}
}
if ((sizeof($ag_data) - 1) == $n)	{
$ag_new_list_items .=  '<span class="ag_up_down ag_last"><i class="icon-down-1 ag_disabled"></i></span>';
} else {
$ag_new_list_items .=  '<span class="ag_up_down ag_this_title ag_last" onclick="ag_down_item(\''.$val['id'].'\')" id="down_'.$val['id'].'"><i class="icon-down-1"></i><span class="ag_title">' .$ag_lng['moove_down']. '</span></span>';
}
} // ag_db_settings_reverse 


}// founder item



$ag_new_list_items .=  '<div class="clear"></div>'; 
$ag_new_list_items .=  '</div>'; // ag_tools_item


$ag_new_list_items .=  '</div>'; // ag_item_inner
$ag_new_list_items .=  '</div>'; // ag_item
}
}// foreach ag_data

$ag_new_list_items .=  '<div class="ag_list_items_bottom"></div>'; 

$ag_new_list_items .=  '<div class="clear"></div>'; 
$ag_new_list_items .=  '</div>'; // ag_list_items_inner


$ag_new_list_items = preg_replace("|[\r\n]+|", "", $ag_new_list_items); 
$ag_new_list_items = preg_replace("|[\n]+|", "", $ag_new_list_items);


echo $ag_new_list_items; // return item list


if (isset($_GET['added']) && isset($_GET['new_item_name'])) {
$_GET['added'] = htmlspecialchars($_GET['added'], ENT_QUOTES, 'UTF-8');
$_GET['new_item_name'] = htmlspecialchars($_GET['new_item_name'], ENT_QUOTES, 'UTF-8');
echo '
<script>
ag_dialog(1200, "'.$_GET['new_item_name'].'", "'.$ag_lng['item_added'].'", "quick_mess", "icon-doc-new ag_str_green", "");
$("#ag_list_items").scrollTo($("#item_'.$_GET['added'].'"), 300, { axis:"y" } ); 
</script>
';	
}

if (isset($ag_view_errors)) { echo $ag_view_errors; }
?>

<script>

//*---swing long name---
<?php $mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) { ?>
var w_name_list = $(".ag_name").outerWidth(true);


$('.ag_name').each(function(){
var w_name_a = $(this).find("a").outerWidth(true);
var w_name_s = $(this).find("span.ag_name_str").outerWidth(true);
if (w_name_a >= w_name_list || w_name_s >= w_name_list) { $(this).find("span.ag_sn_right, span.ag_sn_left").css({display: "block"}); }
});



$(".ag_name span.ag_sn_right").click(function() { 
if ($(this).prev("a").outerWidth(true) >= w_name_list) {
	var wswing = $(this).prev("a").outerWidth(true) - w_name_list;
	var speed = 8*wswing;
	if (speed < 800) {speed = 800;}
	$(this).prev("a").css({transition: 'none'});
    $(this).prev("a").animate({left: "-"+wswing+"px"}, speed); 
} 
if ($(this).prev("span").outerWidth(true) >= w_name_list) {
	var wswing = $(this).prev("span").outerWidth(true) - w_name_list;
	var speed = 8*wswing;
	if (speed < 800) {speed = 800;}
	$(this).prev("span").css({transition: 'none'});
    $(this).prev("span").animate({left: "-"+wswing+"px"}, speed); 
} 
});

$(".ag_name span.ag_sn_left").click(function() { 
if ($(this).find(" + a").outerWidth(true) >= w_name_list) {
	var wswing = $(this).find(" + a").outerWidth(true) - w_name_list;
	var speed = 8*wswing;
	if (speed < 800) {speed = 800;}
	$(this).find(" + a").css({transition: 'none'});
    $(this).find(" + a").animate({left: "0px"}, speed);
} 
if ($(this).find(" + span").outerWidth(true) >= w_name_list) {
	var wswing = $(this).find(" + span").outerWidth(true) - w_name_list;
	var speed = 8*wswing;
	if (speed < 800) {speed = 800;}
	$(this).find(" + span").css({transition: 'none'});
    $(this).find(" + span").animate({left: "0px"}, speed);
} 
});
<?php } else { ?>
var w_name_list = $(".ag_name").outerWidth(true);
$(".ag_name a, .ag_name span").hover(function() {
if ($(this).outerWidth(true) >= w_name_list) {
	var wswing = $(this).outerWidth(true) - w_name_list;
	var speed = 8*wswing;
	if (speed < 800) {speed = 800;}
	$(this).css({transition: 'none'});
    $(this).delay(300).animate({left: "-"+wswing+"px"}, speed); 
}}).mouseleave(function() {
	if ($(this).outerWidth(true) >= w_name_list) {
	$(this).stop(true,true).css({left: '0px', transition: 'all 0.5s ease-in-out'});
	}
});
<?php } ?>




</script>