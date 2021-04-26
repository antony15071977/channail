<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

if(!isset($ag_get_schedule)) {$ag_get_schedule = 'schedule';}
if(!isset($ag_get_confirm)) {$ag_get_confirm = 'confirm';}
if(!isset($ag_get_pay)) {$ag_get_pay = 'pay';}

$ag_is_mob = 0;
if (file_exists('inc/mobile_detect/mobile_detect.php')) {
include ('inc/mobile_detect/mobile_detect.php'); 
$mob_detect = new Mobile_Detect; if ($mob_detect->isMobile()) {
$ag_is_mob = 1;	
}
}

if (!function_exists('mb_strrpos')) {
	function mb_strrpos($str, $find, $c) {
		if (empty($str) || empty($str)) { return false; }
		return strrpos($str, $find);
	}
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'ag_mail/Exception.php';
require_once 'ag_mail/PHPMailer.php';
require_once 'ag_mail/SMTP.php';


if(!isset($ag_cfg_smtp)) { $ag_cfg_smtp = ''; }
if(!isset($ag_cfg_smtp_port)) { $ag_cfg_smtp_port = ''; }
if(!isset($ag_cfg_smtp_server)) { $ag_cfg_smtp_server = ''; }
if(!isset($ag_cfg_smtp_username)) { $ag_cfg_smtp_username = ''; }
if(!isset($ag_cfg_smtp_password)) { $ag_cfg_smtp_password = ''; }

function ag_smtpmail($to='', $subject='', $message='', $attachment='', $smtp_from='') {

global $ag_cfg_smtp_port;
global $ag_cfg_smtp_server;
global $ag_cfg_smtp_username;
global $ag_cfg_smtp_password;


if (!empty($ag_cfg_smtp_port) && !empty($ag_cfg_smtp_server) && !empty($ag_cfg_smtp_username) && !empty($ag_cfg_smtp_password)) { 

if (empty($smtp_from)) {
$smtp_from = $_SERVER['HTTP_HOST'];
$smtp_from = str_replace('www.', '', $smtp_from);	
}

$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';

// Настройки SMTP
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

$mail->Host = "ssl://".$ag_cfg_smtp_server;
$mail->Port = $ag_cfg_smtp_port;
$mail->Username = $ag_cfg_smtp_username;
$mail->Password = $ag_cfg_smtp_password;

// От кого
$mail->setFrom($ag_cfg_smtp_username, $smtp_from);        

// Кому
$mail->addAddress($to, '');

// Тема письма
$mail->Subject = $subject;

// Тело письма
$body = $message;
$mail->msgHTML($body);

// Приложение
if (!empty($attachment) && file_exists($attachment)) {
$mail->addAttachment ($attachment);
}

$mail->send();

}
}//ag_smtpmail




// file list
function ag_file_list($dir, $type='') {
    // massive return
    $retval = array();

if (file_exists($dir)) {
    // add slash to end
    if (substr($dir, -1) != '/') $dir .= '/';

    // path to dir and read file
    $d = @dir($dir) or die();
    while(false !== ($entry = $d->read())) {

      // skip hidden files
      if ($entry[0] == ".") continue;

	  
if (is_readable($dir.$entry)) {
if (!preg_match("/\index.php$/", $dir.$entry)) { //not include Index.php


if (!empty($type) && $type != 'dir') { // only type
$type = str_replace('.', '', $type);
$type_arr = explode('.', $dir.$entry);
$type_file = array_pop($type_arr);
if ($type == $type_file && !is_dir($dir.$entry)) {

        $retval[] = array(
          'name' => $dir.$entry,
          'size' => filesize($dir.$entry),
          'lastmod' => filemtime($dir.$entry)
        );
}
}// only type 

if (!empty($type) && $type == 'dir') { // only dir
if (is_dir($dir.$entry)) { // dir
	
        $retval[] = array(
          'name' => $dir.$entry.'/',
          'size' => 0,
          'lastmod' => filemtime($dir.$entry)
         );
}
}// only dir

if (empty($type)) { //not type (all files)

$retval[] = array(
          'name' => $dir.$entry,
          'size' => filesize($dir.$entry),
          'lastmod' => filemtime($dir.$entry)
       );	

} //empty type (all files)
} //index.php


}// is_readable

}// while
$d->close();
}// file_exists
return $retval;
}// file list






//apanel

$ag_apanel_link = '';
function ag_apanel($ap_path = '') { 
if (empty($ap_path)) {$ap_path = '.';}
$ag_apanel_dir = '';
$disdir = array('data', 'js', 'lang', 'inc', 'errors', 'themes', 'css', 'img');

$objects = ag_file_list($ap_path, 'dir');

foreach ($objects as $dir) {
$objects_dir = ag_file_list($dir['name'], '.php'); 
foreach ($objects_dir as $file) {
$file_a = explode('/', $file['name']);
$file_a = array_diff($file_a, array(''));
$file_d = array_pop($file_a);
if ($file_d == 'detect.php') { 
	$ag_apanel_dir = $dir['name'];
	}
break;	
}

}

return  strval($ag_apanel_dir);
}// ag_apanel

$ag_apanel_link = ag_apanel();
if (empty($ag_apanel_link)) { $ag_apanel_link = ag_apanel('../'); }
if (empty($ag_apanel_link)) { $ag_apanel_link = 'apanel'; }

$ag_apanel_link = str_replace('/', '', $ag_apanel_link);
$ag_apanel_link = str_replace('.', '', $ag_apanel_link);


if (!isset($_POST['ag_date'])) {
if (!file_exists($ag_data_dir) && !file_exists('../'.$ag_data_dir)) {
if (strpos($srv_absolute_url, $ag_apanel_link) === false) { 
if (!isset($ag_this_p)) {
header("Location: ".$srv_absolute_url.$ag_apanel_link);
}
}
}
}

function ag_read_file($ag_file_dat) {
$data_lines_file = array();
//if (function_exists('file')) {} else {return $data_lines_file; exit;} 
if (file_exists($ag_file_dat)) {
/*	
$ag_file_read = fopen($ag_file_dat, "rb"); 
if (filesize($ag_file_dat) != 0) { // !0
flock($ag_file_read, LOCK_SH); 
$data_lines_file = preg_split("~\r*?\n+\r*?~", fread($ag_file_read, filesize($ag_file_dat)));
flock($ag_file_read, LOCK_UN); 
fclose($ag_file_read); 
}// file size !0
*/
if (filesize($ag_file_dat) != 0) { // !0
$data_lines_file = file($ag_file_dat);
}// file size !0
}
return $data_lines_file;
}// ag_read_file

if(!isset($ag_cl)) {unset($ag_index);}

function ag_read_data($ag_file_dat) {

global $ag_separator;

if (isset($ag_separator[0])) { $ag_db_seporator = $ag_separator[0]; } else {die;}
if (isset($ag_separator[1])) { $ag_db_seporator_index = $ag_separator[1]; } else {die;}
if (isset($ag_separator[2])) { $ag_db_seporator_array = $ag_separator[2]; } else {die;}

$ag_data = array();

$data_lines_file = array();
if (!empty($ag_file_dat)) {
$data_lines_file = ag_read_file($ag_file_dat);
}// empty

if (!empty($data_lines_file)) {
foreach ($data_lines_file as $nl => $ag_line) {

$data_lines_file = explode($ag_db_seporator, $ag_line);
foreach ($data_lines_file as $index_value) {
$data_lines_file = explode($ag_db_seporator_index, $index_value);
if (isset($data_lines_file[0]) && isset($data_lines_file[1])) { $ag_data[$nl][$data_lines_file[0]] = $data_lines_file[1]; }

}// foreach data_lines_file 2
}// foreach data_lines_file 1
}// !empty data_lines_file
return $ag_data;
}//---------/ function ag_read_data
if(!isset($ag_salt)) {unset($ag_index);}
function ag_exit($url) {
session_destroy();
$url = str_replace('index.php', '', $url);
header("Location: ".$url);	
}


//----------------------------------- MAIL SENT

function ag_sent_mail($email, $name, $from, $teme, $message, $tcolor, $other) {

global $ag_protocol;

global $ag_cfg_smtp;
global $ag_cfg_smtp_port;
global $ag_cfg_smtp_server;
global $ag_cfg_smtp_username;
global $ag_cfg_smtp_password;

$smtp = 0;

if ($ag_cfg_smtp == 1 && !empty($ag_cfg_smtp_port) && !empty($ag_cfg_smtp_server) && !empty($ag_cfg_smtp_username) && !empty($ag_cfg_smtp_password)) {
$smtp = 1;
} 

	
$addr = $_SERVER['HTTP_HOST'];
$addr = str_replace('www.', '', $addr);
if (empty($from) || $from == '' || $from == ' ') { $from = 'noreply@'.$addr; }
if (empty($tcolor)) { $tcolor = '#FC8F1A';}
if (empty($other)) { $other = 'IP: '.$_SERVER['REMOTE_ADDR'];}
if (empty($name)) { $name = $addr;}

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "Content-type:text/html;charset=utf-8 \r\n"; 
$headers .= "From: ".$name." <".$from.">\r\n"; // from
$headers .= "X-Mailer: PHPMailer ".phpversion()."\r\n";

$message_body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="font-family: Arial, Verdana, Tahoma; font-size:16px; color:#000; background:#fff;">';


$message_body .= '<table style="border:0; border-collapse:collapse; margin: 0; width:100%; font-size:16px;"><tbody>';
$message_body .= '<tr><td colspan="2" style="border: 0; background:'.$tcolor.'; padding:28px; vertical-align:top;">
<h3 style="color:#fff; margin: 0; padding:0; font-weight:normal; font-size:18px;">'.$teme.'</h3></td></tr>';
$message_body .= '<tr><td colspan="2" style="border: 0; background:#f5f5f7; padding:28px; color:#000; vertical-align:top;">
'.$message.'</td></tr>';

$back_url = $ag_protocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$back_url = str_replace('/index.php', '', $back_url);

$message_body .= '<tr style="background:#E7E7Ea; border-top: #d9d9db 1px solid; color:#474A59;">
<td style="border: 0; padding:28px; vertical-align:top;">
<div style=""><small>'.date("d.m.Y H:i").'</small></div></td>
<td style="border: 0; padding:28px; vertical-align:top;">
<div style="text-align:right;"><small>' .$other. '</small> &bull; <a href="' .$back_url. '" style="color:#000;">' .$back_url. '</a></div></td>
</tr>';

$message_body .= '</tbody></table></body></html>';

$teme = $teme. ' - '.$_SERVER['HTTP_HOST'];

if(is_array($email)) {
	
foreach ($email as $emails) {

if (!empty($emails)) { 
if ($smtp == 1) {
ag_smtpmail($emails, $teme, $message_body, '', $name);	usleep(250000); 
} else {
mail($emails, $teme, $message_body, $headers); usleep(250000); 
}
} // send
}// foreach email

} else {	
if ($smtp == 1) {
ag_smtpmail($email, $teme, $message_body, '', $name);	
} else {
mail($email, $teme, $message_body, $headers); // send		
}
}



} //mail



//delete dir
function ag_del_dir( $path ) {
 
 if ( file_exists( $path ) AND is_dir( $path ) ) {

    $dir = opendir($path);
    while ( false !== ( $element = readdir( $dir ) ) ) {

      if ( $element != '.' AND $element != '..' )  {
        $tmp = $path . '/' . $element;
        chmod( $tmp, 0777 );
      
        if ( is_dir( $tmp ) ) {
         ag_del_dir( $tmp );
    
        } else {
          unlink( $tmp );
       }
     }
   }

    closedir($dir);
	
   if ( file_exists( $path ) ) {
     rmdir( $path );
   }
 }
}




// translit for alias
function ag_rus_translit($string, $reg) {


if ($reg = 'small') {    

$converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'ts',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '',  'ы' => 'y',   'ъ' => '',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		
		' ' => '-',



'А' => 'a',   'Б' => 'b',   'В' => 'v',

        'Г' => 'g',   'Д' => 'd',   'Е' => 'e',

        'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',

        'И' => 'i',   'Й' => 'y',   'К' => 'k',

        'Л' => 'l',   'М' => 'm',   'Н' => 'n',

        'О' => 'o',   'П' => 'p',   'Р' => 'r',

        'С' => 's',   'Т' => 't',   'У' => 'u',

        'Ф' => 'f',   'Х' => 'h',   'Ц' => 'ts',

        'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sch',

        'Ь' => '',  'Ы' => 'y',   'Ъ' => '',

        'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya',
		
        //' ' => '-',
    );
	
} else {


    $converter = array(

        'а' => 'a',   'б' => 'b',   'в' => 'v',

        'г' => 'g',   'д' => 'd',   'е' => 'e',

        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',

        'и' => 'i',   'й' => 'y',   'к' => 'k',

        'л' => 'l',   'м' => 'm',   'н' => 'n',

        'о' => 'o',   'п' => 'p',   'р' => 'r',

        'с' => 's',   'т' => 't',   'у' => 'u',

        'ф' => 'f',   'х' => 'h',   'ц' => 'ts',

        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',

        'ь' => '',  'ы' => 'y',   'ъ' => '',

        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

	
'А' => 'A',   'Б' => 'B',   'В' => 'V',

        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',

        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',

        'И' => 'I',   'Й' => 'Y',   'К' => 'K',

        'Л' => 'L',   'М' => 'M',   'Н' => 'N',

        'О' => 'O',   'П' => 'P',   'Р' => 'R',

        'С' => 'S',   'Т' => 'T',   'У' => 'U',

        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'Ts',

        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',

        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',

        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',	

		
        //' ' => '-',
    );
}
    return strtr($string, $converter);

}// translit for alias




//str cat
function ag_str_cat($string, $from, $to){
$prepared = substr ($string, stripos ($string, $from));
$returned = substr ($prepared, 0, (stripos($prepared, $to) - strlen($prepared) + strlen($to)));
return $returned;
}

//remove js comment
function ag_remove_js_comments($html) {
$html_str = '';	
$comm_s = '//*';
if (strpos($html, $comm_s) === false) { return $html; } else {
$html_arr = explode($comm_s, $html);
foreach ($html_arr as $str) {
$html_str .= $str;	
}
return preg_replace('/---(.*?)---/', '', $html_str);
}
}


function ag_close_tags($content)
    {
		/*
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        //$ignored_tags = array('br', 'hr', 'img', 'audio', 'video', 'input');
        $allow_tags = array('strong', 'i', 'b', 'u', 'small', 'span', 'p', 'div', 'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'ul', 'ol', 'li');
        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $allow_tags))
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat('</'.$tag.'>', $count_not_closed);
        }
 */
        return $content;
    }


//html
function ag_return_html($html) {

$html = ag_remove_js_comments($html);
$html = preg_replace("|[\r\n]+|", "", $html); 
$html = preg_replace("|[\n]+|", "", $html);
$html = preg_replace('/[\s]{2,}/', ' ', $html);		
$html = str_replace('<table', '<div class="ag_mob_table"><table', $html);	
$html = str_replace('</table>', '</table></div>', $html);	


$html = preg_replace_callback('|<script>(.+)</script>|iU', function($matches){
	$matches[1] = preg_replace('/[\s]{2,}/', ' ', $matches[1]);	
	$matches[1] = preg_replace('/\s/', ' ', $matches[1]);
	$matches[1] = str_replace('; ', ';', $matches[1]);
	$matches[1] = str_replace(': ', ':', $matches[1]);
	$matches[1] = str_replace(', ', ',', $matches[1]);
    $matches[1] = str_replace('} ', '}', $matches[1]);
	$matches[1] = str_replace('{ ', '{', $matches[1]);
	$matches[1] = str_replace(' }', '}', $matches[1]);
	$matches[1] = str_replace(' {', '{', $matches[1]);
	$matches[1] = str_replace('{ ', '{', $matches[1]);
	$matches[1] = str_replace('+ ', '+', $matches[1]);
	$matches[1] = str_replace(' +', '+', $matches[1]);
	$matches[1] = str_replace('- ', '-', $matches[1]);
	$matches[1] = str_replace(' -', '-', $matches[1]);
	$matches[1] = str_replace(' *', '*', $matches[1]);
	$matches[1] = str_replace('* ', '*', $matches[1]);
	$matches[1] = str_replace('/ ', '/', $matches[1]);
	$matches[1] = str_replace(' /', '/', $matches[1]);
	$matches[1] = str_replace(' >', '>', $matches[1]);
	$matches[1] = str_replace('> ', '>', $matches[1]);
	$matches[1] = str_replace(' <', '<', $matches[1]);
	$matches[1] = str_replace('< ', '<', $matches[1]);
	$matches[1] = str_replace('= ', '=', $matches[1]);
	$matches[1] = str_replace(' =', '=', $matches[1]);
	$matches[1] = str_replace('if ', 'if', $matches[1]);
	return '<script>'.$matches[1].'</script>';
}, $html,-1,$count);

$html = preg_replace_callback('|<style>(.+)</style>|iU', function($matches){
	$matches[1] = preg_replace('/[\s]{2,}/', ' ', $matches[1]);	
	$matches[1] = preg_replace('/\s/', ' ', $matches[1]);
	$matches[1] = str_replace('; ', ';', $matches[1]);
	$matches[1] = str_replace(': ', ':', $matches[1]);
	$matches[1] = str_replace(', ', ',', $matches[1]);
	$matches[1] = str_replace('} ', '}', $matches[1]);
	$matches[1] = str_replace(' }', '}', $matches[1]);
	$matches[1] = str_replace('{ ', '{', $matches[1]);
	$matches[1] = str_replace(' {', '{', $matches[1]);	
	return '<style>'.$matches[1].'</style>';
}, $html,-1,$count);

$html = str_replace('[:br:]', "\n", $html);

return $html;
}


//----------------------------------- REFRESH
function ag_refresh($url, $time) {
$noscript_time = 0;	
if ($time > 1000) { $noscript_time = $time[0]; }
if (!empty($url)) {
$refresh = '<script>setTimeout("document.location.href=\'' .$url. '\'", ' .$time. ');</script>';
$refresh .= '<noscript><meta http-equiv="refresh" content="' .$noscript_time. '; url=' .$url. '"></noscript>';
echo $refresh; }
} //refresh

function ag_sorta($a, $b) {
if ($a['added'] > $b['added'])
return 1;
}   


function ag_auth() {

$this_staff = array();

global $ag_data_dir;	
global $agt;
global $ag_separator;
global $ag_lng;	
global $srv_host_name;

$ag_auth_data = array();
$ag_users_id = '';
$ag_users_login = '';
$ag_users_hash = '';
$ag_users_status = '';
$ag_users_access = '';
$ag_users_name = '';
$ag_users_mail = '';
$ag_users_phone = '';



$ag_uagent = '';
$ag_userip = '';

$session_per = $srv_host_name;
$ag_sub_domain = 'none';
if (strpos($srv_host_name, '.') === false) { } else {
$srv_host_name_a = explode('.', $srv_host_name);
if (isset($srv_host_name_a[0])) {$ag_sub_domain = $srv_host_name_a[0];}
array_pop($srv_host_name_a);
$session_per = array_pop($srv_host_name_a);
}
$session_per = $ag_sub_domain.$session_per.date('d.m.Y');
$session_per = crypt(sha1($session_per), substr($session_per,0,2));


$ag_uagent = '';
if (isset($_SERVER['HTTP_USER_AGENT'])) { $ag_uagent = $_SERVER['HTTP_USER_AGENT']; }
$ag_userip = $_SERVER['REMOTE_ADDR'];

$ag_uagent_check = crypt(sha1($ag_uagent), substr($ag_uagent,0,2));
$ag_userip_check = crypt(sha1($ag_userip), substr($ag_userip,0,2));


if (!isset($_SESSION['ag_uagent'.$session_per])) {$_SESSION['ag_uagent'.$session_per] = $ag_uagent_check;}
if (!isset($_SESSION['ag_userip'.$session_per])) {$_SESSION['ag_userip'.$session_per] = $ag_userip_check;}




if (isset($_SESSION['ag_login'.$session_per]) && isset($_SESSION['ag_passw'.$session_per])) {
	


if (file_exists($ag_data_dir.'/staff'.$agt)) { $ag_auth_data = ag_read_data($ag_data_dir.'/staff'.$agt); }

foreach ($ag_auth_data as $aval) {
if (isset($aval['id'])) {$ag_users_id = $aval['id'];}
if (isset($aval['login'])) {$ag_users_login = crypt(sha1($aval['login']), substr($aval['login'],0,2));}
if (isset($aval['hash'])) {$ag_users_hash = crypt(sha1($aval['hash']), substr($aval['hash'],0,2));}
if (isset($aval['name'])) {$ag_users_name = $aval['name'];}
if (isset($aval['access'])) {$ag_users_access = $aval['access'];}
if (isset($aval['email'])) {$ag_users_mail = $aval['email'];}
if (isset($aval['phone_formated'])) {$ag_users_phone = $aval['phone_formated'];}
if (isset($aval['status'])) {$ag_users_status = $aval['status'];}




if (
$_SESSION['ag_login'.$session_per] == $ag_users_login && 
$_SESSION['ag_passw'.$session_per] == $ag_users_hash &&
$_SESSION['ag_uagent'.$session_per] == $ag_uagent_check &&
$_SESSION['ag_userip'.$session_per] == $ag_userip_check &&
$ag_users_status == '1') { 
$this_staff['id'] = $ag_users_id; 
$this_staff['access'] = $ag_users_access; 
$this_staff['name'] = $ag_users_name; 
$this_staff['phone'] = $ag_users_phone;
$this_staff['email'] = $ag_users_mail;
break; } 

}

}	
return $this_staff;	
}// ag_auth



function ag_log($data=array(), $file='') {
	if (empty($file) || !empty($file) && !is_string($file)) { $file = 'log.txt'; }
	if (is_array($data) || is_object($data)) { 
		$data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); 
	} else {
		if (empty($data)) { $data = 'EMPTY';}
	}
	$content = '';
	if (file_exists($file)) {
		$content = PHP_EOL . '---------------------------------------------' . PHP_EOL . $data . PHP_EOL . ' - ' . date('d.m.Y H:i:s');
		$create = fopen($file, "a+");
		flock ($create, LOCK_EX);
		fputs($create, $content);
		flock ($create,LOCK_UN);
		fclose ($create);
	} else {
		$content = $data . PHP_EOL . ' - ' . date('d.m.Y H:i:s');
		$create = fopen($file, "w");
		fwrite($create, $content);
		fclose ($create);
	}
	if (file_exists($file)) { chmod($file, 0644); return true; }
	return false;
}
?>