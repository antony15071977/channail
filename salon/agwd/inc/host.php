<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

// redirect to HTTPS ($ag_ssl = 1) // редирект на HTTPS ($ag_ssl = 1)
$ag_ssl = 0;


// Кто я и где я нахожусь...
$srv_host_name = $_SERVER['HTTP_HOST'];
$srv_host_name = str_replace('www.', '', $srv_host_name);
$ag_protocol = 'http://';
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { $ag_protocol = 'https://'; }
$srv_script_absolute_url = $ag_protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; 
$srv_script_absolute_url = str_replace('www.', '', $srv_script_absolute_url);
$srv_script_relative_url = $_SERVER['PHP_SELF'];
$srv_sru_arr = array();
$srv_sru_arr = explode('/', $srv_script_relative_url);
$srv_sru_arr = array_diff($srv_sru_arr, array(''));
$srv_script_name = array_pop($srv_sru_arr);
$srv_current_path = str_replace($srv_script_name, '', $srv_script_relative_url);
$srv_absolute_url = str_replace($srv_script_name, '', $srv_script_absolute_url);
if ($srv_current_path == '/') {$srv_current_path = '';}

// $srv_host_name - текущий домен
// $srv_script_absolute_url - абсолютный путь к текущему скрипту
// $srv_script_relative_url - относительный путь к текущему скрипту
// $srv_script_name - имя скрипта
// $srv_current_path - путь к текущей директории относительно корня
// $srv_absolute_url - абсолютный путь к текущей директории


// redirect www or https (beta)
$ag_check_protocol = explode('/', $srv_absolute_url);
$ag_full_url = explode('/', $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$ag_no_protocol_url = '';
foreach ($ag_full_url as $nuf => $ag_url_frag) {
if ($nuf == sizeof($ag_full_url) - 1) { $ag_no_protocol_url .= $ag_url_frag; } else { $ag_no_protocol_url .= $ag_url_frag.'/'; }
}
$rwww_arr = explode('.', $_SERVER['HTTP_HOST']);

if (isset($rwww_arr[0]) && $rwww_arr[0] == 'www') { 
$ag_no_protocol_url = str_replace('www.', '', $ag_no_protocol_url);
header('HTTP/1.1 301 Moved Permanently'); header("Location: ".$ag_protocol.$ag_no_protocol_url.""); 

} else {

if (isset($ag_check_protocol[0]) && $ag_check_protocol[0] == 'http:' && $ag_ssl == 1) { 
$ag_no_protocol_url = str_replace('www.', '', $ag_no_protocol_url);
header('HTTP/1.1 301 Moved Permanently'); header("Location: https://".$ag_no_protocol_url.""); 
}

}// www or https
?>