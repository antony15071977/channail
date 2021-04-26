<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
header('Content-type: text/html; charset=utf-8');
$ag_index = 1;
include ('../../inc/host.php');
if (!file_exists('../../inc/db_conf.php')) {
	$srv_absolute_url = str_replace('/apanel/inc', '', $srv_absolute_url);
	//header("Location: ".$srv_absolute_url); die;
	}
include ('../../inc/db_conf.php');

$ag_data_dir = '../../'.$ag_data_dir;
include ($ag_data_dir. '/'. $ag_config); 
if (!empty($ag_cfg_time_zone)) { $ag_cfg_time_zone = str_replace('_', '/', $ag_cfg_time_zone); date_default_timezone_set($ag_cfg_time_zone); } 
include ('../../'.$ag_cfg_lng);// LNG


function ag_ip_info($ag_check_ip='') {
$my_mess = '';
$return = array();
if (empty($ag_check_ip)) {$ag_check_ip = $_SERVER['REMOTE_ADDR']; $my_mess = 'Is my IP address';}
$ag_country = '';
$ag_city = '';
$ag_country_code = '';
$ag_latitude = '';
$ag_longitude = '';

if (file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ag_check_ip."")) {
	
$ag_ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ag_check_ip.""));
$ag_country_code = strtolower($ag_ip_details->geoplugin_countryCode);
$ag_country = $ag_ip_details->geoplugin_countryName;
$ag_city = $ag_ip_details->geoplugin_city;
$ag_latitude = $ag_ip_details->geoplugin_latitude;
$ag_longitude = $ag_ip_details->geoplugin_longitude;
}

$return['country_code'] = strtoupper($ag_country_code);
$return['country'] = $ag_country;
$return['city'] = $ag_city;
$return['mess'] = $my_mess;
$return['latitude'] = $ag_latitude;
$return['longitude'] = $ag_longitude;
return $return;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>IP GEO INFO</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow"/>
<style>
body {color: #232325; font-family: Arial, Tahoma; background:#e7e7e9; font-size:16px; width:100%; margin:0; padding:0; display:block;}
a, a:visited { color:#575759; text-decoration:underline; outline:none; }
a:hover { color:#000; text-decoration:underline; }
table{border-collapse:collapse;border-spacing:0;width:100%;margin:0;padding:0}
table tr td{background:#fff}
table tr:nth-child(2n) td {background:#f9f9fb}
table th{background:none;padding:16px;font-weight:400;text-align:left;color:#413d51;font-size:120%}
table td{background:none;box-shadow:none;padding:16px}
table td,table th{border:#d9d9db 1px solid}
div.ag_mob_table {
width:100%;
max-width:100%; 
height:auto; 
overflow-y: hidden;
overflow-x: auto; 
margin:0 0 0 0; padding:0;
background:#fff;
}
div.ag_mob_table table {width:100%;}
#ag_main {padding:32px;}
ul {padding:8px; margin:0 auto; width:auto;}
ul li {padding:8px 8px;}
ul li span{color:#b7b7ba}
</style>
</head>

<body>
<div id="ag_main">
<div class="ag_mob_table">

<?php
$ip = '';
$ipinfo = array();
$info = '';
if(isset($_GET['ip'])) {$ip = $_GET['ip']; }
$ipinfo = ag_ip_info($ip);

foreach ($ipinfo as $k => $v) {

if (!empty($v) && $k != 'latitude' && $k != 'longitude') {$info .= '<li><span>'.$ag_lng[$k].':</span> '.$v.'</li>';}
	
}
 



//===============================================================================================
if (!empty($info)) {$info = '<ul>'.$info.'</ul>';} else {$info = '<ul><li>No data...</li></ul>';}

echo $info;
?>





<?php if (!empty($ipinfo['latitude']) && !empty($ipinfo['longitude'])) { 

//координаты
$ag_map_point = ''.$ipinfo['latitude'].', '.$ipinfo['longitude'].'';
//описание точки (адрес, название)
$ag_map_descr = $ip.' | '.$ipinfo['country'].' | '.$return['city'];
//координаты для оцентровки (не обязательно)
$ag_map_center = '';
if (empty($ag_map_center)) {$ag_map_center = $ag_map_point;}
?>
	
<script src="//api-maps.yandex.ru/2.0/?load=package.standard,package.geoObjects&lang=ru-RU" type="text/javascript"></script>
<script>
    function init() {
      var myMap = new ymaps.Map('map', {
        center: [<?php echo $ag_map_point; ?>],
        zoom: 12
      })
    myMap.behaviors.disable('scrollZoom');
    myMap.behaviors.disable('drag');
    }
    ymaps.ready(init);
    function init () {
        var myMap = new ymaps.Map("map", {
          //Центр карты
                center: [<?php echo $ag_map_center; ?>],
                zoom: 12
            });
        // Создаем метку с помощью вспомогательного класса.
        myPlacemark1 = new ymaps.Placemark([<?php echo $ag_map_point; ?>], {
            // Свойства.
            // Содержимое иконки, балуна и хинта.
            iconContent: '',
            balloonContent: '<?php echo $ag_map_descr; ?>',
            hintContent: '<?php echo $ag_map_descr; ?>'
        }),
        myMap.behaviors
        // Отключаем часть включенных по умолчанию поведений:
        //  - drag - перемещение карты при нажатой левой кнопки мыши;
        //  - magnifier.rightButton - увеличение области, выделенной правой кнопкой мыши.
        .disable(['drag', 'rightMouseButtonMagnifier']);
        myMap.controls
        // Список типов карты
            .add('typeSelector')
            // Кнопка изменения масштаба - компактный вариант
            // Расположим её справа
            .add('smallZoomControl', { left: 10, top: 10 }) ;
            // Стандартный набор кнопок не включаем!
            //.add('mapTools');
        // Добавляем все метки на карту.
        myMap.geoObjects
        .add(myPlacemark1);
    }
</script>
<div class="ag_map">
<div class="ag_map_inner">
<div id="map" style="height:493px; width:100%;"></div>
</div>
</div>	
<?php } ?>


</div>
</div>
</body>
</html>