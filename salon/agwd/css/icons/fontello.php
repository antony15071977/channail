<?php
header("Content-type: text/css", true);
$url = '';
$srv_host_name = $_SERVER['HTTP_HOST'];
$srv_host_name = str_replace('www.', '', $srv_host_name);
$srv_self = $_SERVER['PHP_SELF'];
$srv_self = str_replace('/css/icons/fontello.php', '', $srv_self);
$ag_protocol = 'http://';if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { $ag_protocol = 'https://'; }
$url = $ag_protocol.$srv_host_name.$srv_self;
echo '@font-face{font-family:fontello;src:url('.$url.'/css/fonts/fontello.eot?33926574);src:url('.$url.'/css/fonts/fontello.eot?33926574#iefix) format("embedded-opentype"),url('.$url.'/css/fonts/fontello.woff2?33926574) format("woff2"),url('.$url.'/css/fonts/fontello.woff?33926574) format("woff"),url('.$url.'/css/fonts/fontello.ttf?33926574) format("truetype"),url('.$url.'/css/fonts/fontello.svg?33926574#fontello) format("svg");font-weight:400;font-style:normal}';
?>