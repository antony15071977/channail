<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}


function ag_multi_media($type, $name, $id, $value, $options, $upload, $user, $class, $users, $access) {
	

	
global $ag_separator;
global $ag_lng;
global $ag_lng_monts_r;
global $ag_lng_monts;
global $ag_lng_days;
global $ag_mob;

$ag_img_dir = $upload;
global $ag_upload_name;
global $ag_mob_images;
if ($ag_mob == 1) { $ag_img_dir = str_replace($ag_upload_name, $ag_mob_images, $upload); }

if (isset($ag_separator[0])) { $ag_db_seporator = $ag_separator[0]; } else {die;}
if (isset($ag_separator[1])) { $ag_db_seporator_index = $ag_separator[1]; } else {die;}
if (isset($ag_separator[2])) { $ag_db_seporator_array = $ag_separator[2]; } else {die;}
if (isset($ag_separator[3])) { $ag_br = $ag_separator[3]; } else {die;}
if (isset($ag_separator[4])) { $ag_str_seporator = $ag_separator[4]; } else {die;}	




if ($access != 1) { 
$_POST[$name] = $value; 
$ag_img_noaccess = '<img src="img/no_photo.png" alt="no photo" class="ag_img_noaccess" />';



echo '<div class="ag_form_element" id="element_' .$id. '">';
echo '<div id="' .$id. '" class="for_gallery for_gallery_noaccess">';
echo '<div id="label_' .$id. '">';

if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) {
if(file_exists($ag_img_dir.$values)) { $ag_img_noaccess = '<img src="' .$ag_img_dir.$values. '" alt="' .$name. '" class="ag_img_noaccess" />';}

echo '<div class="ag_gallery_item" id="' .$id.$n. '"><div class="ag_photos_inner">';
echo '<div id="img_' .$id.$n. '" class="ag_insert_img">'.$ag_img_noaccess.'</div>';
echo '<div class="clear"></div>
</div></div>'; // ag_photo_inner ag_gallery_item 


}
}
}


echo '</div>'; // label
echo '<div class="clear"></div>';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-lock-2 ag_disabled"></i></span>
</span>';

echo '</div>'; // for_photo
echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element


} else { //access



$value_arr = array();

if (isset($_POST[$name])) { $value_arr = $_POST[$name]; }

echo '<div class="ag_form_element" id="gallery_' .$id. '">';
echo '<div class="for_gallery" id="' .$id. '" tabindex="-1" onfocus="ag_active(\'' .$id. '\')" onblur="ag_out(\'' .$id. '\')">
<div id="label_' .$id. '">';

$count_elements = 0;
$n = 0;

if (!empty($value)) {
$value_arr = explode($ag_db_seporator_array, $value);
foreach ($value_arr as $n => $values) {
if (!empty($values)) { $count_elements++;

echo '<div class="ag_gallery_item" id="' .$id.$n. '" onclick="active' .$id. '()"><div class="ag_photos_inner">';
echo '<input type="hidden" name="' .$name. '[' .$n. ']" value="' .$upload.$values. '" class="' .$class. '" id="input_' .$id.$n. '" />';
echo '<div id="img_' .$id.$n. '" class="ag_insert_img" onclick="ag_open_ifm(\'' .$id.$n. '\', \'\', 1)"></div>';
echo '<div class="ag_tools_photo">';

echo '<span onclick="reset_img' .$id. '(\'' .$id.$n. '\')" class="ag_reset_img ag_btn_small"><i class="icon-block"></i><span>' .$ag_lng['remove']. '</span></span>
<span onclick="ag_open_ifm(\'' .$id.$n. '\', \'\', 1)" tabindex="-1" class="ag_add_img ag_btn_small"><i class="icon-upload-4"></i><span>' .$ag_lng['choice']. '</span></span>
<div class="clear"></div>
</div>';


echo '<script>';
if(file_exists($ag_img_dir.$values)) {
echo '
var val_img = $("#input_' .$id.$n. '").val();
if (val_img == "" || val_img == "img/no_photo.png") { $("#img_' .$id.$n. '").html("<img src=\"img/no_photo.png\" alt=\"' .$name. '\" />"); }
else { 
val_img = val_img.replace("'.$upload.'","'.$ag_img_dir.'");
$("#img_' .$id.$n. '").html("<img src=\""+ val_img +"\" alt=\"' .$name. '\" />"); 
}
'; 
} else {
echo ' $("#img_' .$id.$n. '").html("<img src=\"img/no_photo.png\" alt=\"no photo\" />"); ';	
}// file_exists
echo '</script>';

echo '<div class="clear"></div>
</div></div>'; // ag_photo_inner ag_gallery_item 


}// no empty values
}//foreach value
}// no empty value


if ($count_elements == 0) {
$n = 0;
echo '<div class="ag_gallery_item" id="' .$id.$n. '" onclick="active' .$id. '()"><div class="ag_photos_inner">';
echo '<input type="hidden" name="' .$name. '[' .$n. ']" value="" class="' .$class. '" id="input_' .$id.$n. '" />';
echo '<div id="img_' .$id.$n. '" class="ag_insert_img" onclick="ag_open_ifm(\'' .$id.$n. '\', \'\', 1)"><img src="img/no_photo.png" alt="' .$name. '" /></div>';
echo '<div class="ag_tools_photo">
<span onclick="reset_img' .$id. '(\'' .$id.$n. '\')" class="ag_reset_img ag_btn_small"><i class="icon-block"></i><span>' .$ag_lng['remove']. '</span></span>
<span onclick="ag_open_ifm(\'' .$id.$n. '\', \'\', 1)" tabindex="-1" class="ag_add_img ag_btn_small"><i class="icon-upload-4"></i><span>' .$ag_lng['choice']. '</span></span>
<div class="clear"></div>
</div>';
echo '<div class="clear"></div>
</div></div>'; // ag_photo_inner ag_gallery_item 

}// empty value

echo '</div>'; // photos
echo '<div class="clear"></div>';
echo '<span class="element_tools">
<span class="ag_icon_element"><i class="icon-picture-5"></i></span>
</span>';
echo '</div>'; // for_gallery



echo '<div class="ag_add_element" tabindex="-1" onfocus="ag_active(\'' .$id. '\')" onblur="ag_out(\'' .$id. '\')" onclick="add_element_' .$id. '()" title="' .$ag_lng['add']. '"><span><i class="icon-plus-circled"></i></span></div>';


$ag_append = '';
$ag_append .= '<div class=\"ag_gallery_item\" id=\"' .$id. '"+' .$id. '_num+"\" onclick=\"active' .$id. '()\"><div class=\"ag_photos_inner\" style=\"opacity:0;\">';
$ag_append .= '<input type=\"hidden\" name=\"' .$name. '["+' .$id. '_num+"]\" value=\"\" class=\"' .$class. '\" id=\"input_' .$id. '"+' .$id. '_num+"\" />';
$ag_append .= '<div id=\"img_' .$id. '"+' .$id. '_num+"\" class=\"ag_insert_img\" onclick=\"ag_open_ifm(\'' .$id. '"+' .$id. '_num+"\', \'\', 1)\"><img src=\"img/no_photo.png\" alt=\"' .$name. '\" /></div>';
$ag_append .= '<div class=\"ag_tools_photo\">
<span onclick=\"reset_img' .$id. '(\'' .$id. '"+' .$id. '_num+"\')\" class=\"ag_reset_img ag_btn_small\"><i class=\"icon-block\"></i><span>' .$ag_lng['remove']. '</span></span>
<span onclick=\"ag_open_ifm(\'' .$id. '"+' .$id. '_num+"\', \'\', 1)\" tabindex=\"-1\" class=\"ag_add_img ag_btn_small\"><i class=\"icon-upload-4\"></i><span>' .$ag_lng['choice']. '</span></span>
<div class=\"clear\"></div>
</div>';
$ag_append .= '<div class=\"clear\"></div>';
$ag_append .= '</div></div>'; // ag_photo_inner ag_gallery_item 

$ag_append = preg_replace("|[\r\n]+|", "", $ag_append); 
$ag_append = preg_replace("|[\n]+|", "", $ag_append);



echo '<script>

//*---add---
var ' .$id. '_num = ' .$n. ';

function add_element_' .$id. '() {
' .$id. '_num = ' .$id. '_num + 1;
$("#label_' .$id. '").append("' .$ag_append. '");
ag_photos();
$("#' .$id. '" + ' .$id. '_num + " div.ag_photos_inner").animate({opacity: "1"}, 400);
setTimeout(function() { $("#img_' .$id. '" + ' .$id. '_num).click(); }, 500);
}

//*---remove---
function reset_img' .$id. '(id) {
$("#"+id).fadeOut(400);
setTimeout(function() { $("#"+id).remove(); }, 500);
}
function active' .$id. '() {$("#' .$id. '").focus();}
</script>';


echo '<div class="clear"></div>';
echo '</div>'; // ag_form_element
}// access


}
?>