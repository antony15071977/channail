<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}
if (isset($_GET[$ag_get_rss])) {
header('Content-Type: text/xml; charset=UTF-8');

//RSS DATE FORMAT
$ag_p_d = date('d');
$ag_p_m = date('m');
$ag_p_y = date('Y');

$ag_p_h = '00';
$ag_p_min = '00';
$ag_p_sec = '00';

$ag_last_date = $ag_p_y.'-'.$ag_p_m .'-'.$ag_p_d;
$ag_week_day = strftime("%a", strtotime($ag_last_date));
$ag_rss_last_date = date("D, j M Y H:i:s", strtotime($ag_week_day.", ".$ag_p_d." ".date("M")." ".$ag_p_y." ".$ag_p_h.":".$ag_p_min.":".$ag_p_sec." ".date("O"))). " " .date("O");

echo '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>';

echo '<channel>';		

echo '<title>' .$ag_cfg_title. '</title>'; 
if (!empty($_GET[$ag_get_rss])) {
echo '<atom:link href="'.$srv_absolute_url.'?'.$ag_get_rss.'='.$_GET[$ag_get_rss].'" rel="self" type="application/rss+xml" />';
echo '<link>'.$srv_absolute_url.'?'.$ag_get_rss.'='.$_GET[$ag_get_rss].'</link>'; 	
} else {
echo '<atom:link href="'.$srv_absolute_url.'?'.$ag_get_rss.'" rel="self" type="application/rss+xml" />';
echo '<link>'.$srv_absolute_url.'?'.$ag_get_rss.'</link>'; 
}

echo '<description>' .$ag_cfg_description. '</description>';
echo '<language>' .$ag_lng_value. '</language>';
echo '<copyright>Сopyright '.date('Y').', '.$ag_cfg_title.'</copyright>';
echo '<lastBuildDate>'.$ag_rss_last_date.'</lastBuildDate>';	

if (!empty($_GET[$ag_get_rss])) { // cat

$ag_list_cat_rss = ag_list_cat($_GET[$ag_get_rss],'10','rss');

echo $ag_list_cat_rss;

} else { //home 

$ag_last_obj_rss = ag_last_obj('10', $ag_cfg_home_common_count, 'rss');

echo $ag_last_obj_rss;
}

echo '</channel>';
echo '</rss>';		
}
die;
?>