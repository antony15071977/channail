<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {die;}
header('Content-Type: text/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<?xml-stylesheet type="text/xsl" href="'.$srv_absolute_url.'?sitemap=xml"; ?>';
echo '<!--  generated-on="'.date('d').'.'.date('m').'.'.date('Y').' 00:00"  -->';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$ag_timezone = date('O');
$ag_timezone = $ag_timezone[0].$ag_timezone[1].$ag_timezone[2].':'.$ag_timezone[3].$ag_timezone[4];
$ag_lastmod = ''.date('Y').'-'.date('m').'-'.date('d').'T00:00:00'.$ag_timezone.'';

echo '<url>
<loc>'.$srv_absolute_url.'</loc>
<lastmod>'.$ag_lastmod.'</lastmod>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>';

echo ag_site_map('xml');

echo '</urlset>';
die();
?>