<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

//=================================== EDIT
if (isset($_GET['id'])) {

if (file_exists($ag_file_name)) {
if (filesize($ag_file_name) != 0) {
$ag_lines = array();
	
$ag_fp = fopen($ag_file_name, "r+");
flock ($ag_fp,LOCK_EX); 
$ag_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_file_name)));		

$ag_edit_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

// check ID as number line
foreach ($ag_lines as $n => $line) {
$line_arr = explode($ag_separator[0], $line);	
foreach ($line_arr as $values) {
$values	= explode($ag_separator[1], $values);	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'id') { if ($values[1] == $ag_edit_id) {
	$ag_edit_line = $n;
} } 
}
}
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp);
}// file != 0


} else { $ag_ERROR['file_exists'] = $ag_lng['error_file_exists']. ' - ' .$ag_file_name; } // file_exists


if (isset($_POST['ag_replace'])) {

$ag_line_data = '';
foreach ($ag_values_db as $name) {

if (isset($name) && !empty($name)) {
if (isset($_POST[$name])) {

if (is_array($_POST[$name])) {


//array => array
foreach ($_POST[$name] as $pn => $ag_paa) {
if (is_array($ag_paa)) { 
$ag_paa = array_diff($ag_paa, array(''));
$ag_paa = array_diff($ag_paa, array('---'));
$ag_paa = array_unique($ag_paa);
$ag_paa_r = array();
foreach ($ag_paa as $pna => $paa) {  
$paa = str_replace('::', '', trim($paa)); 
$ag_paa_r[$pna] = $paa; 
}

$_POST[$name][$pn] = implode('::', $ag_paa_r); 

}
}



if ($name != 'schedule') {
$_POST[$name] = array_diff($_POST[$name], array(''));
$_POST[$name] = array_diff($_POST[$name], array('---'));
$_POST[$name] = array_unique($_POST[$name]);
}



$_POST[$name] = implode($ag_separator[2], $_POST[$name]); 

$_POST[$name] = htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8');
$_POST[$name] = str_replace(array($ag_separator[0], $ag_separator[1]), '', trim($_POST[$name])); //separator
$_POST[$name] = str_replace($ag_data_upload_dir, '', trim($_POST[$name])); //upload dir
$_POST[$name] = preg_replace('/\\\\+/', '', $_POST[$name]); 
$_POST[$name] = preg_replace("|[\r\n]+|", " ", $_POST[$name]); 
$_POST[$name] = preg_replace("|[\n]+|", " ", $_POST[$name]);


} else { // poost array

if ($name == 'content' || $name == 'eula_text') { $_POST[$name] = str_replace('../', '[site_url]', $_POST[$name]); }
if (strpos($name, 'content') === false) {} else { $_POST[$name] = str_replace('../', '[site_url]', $_POST[$name]); }

$_POST[$name] = htmlspecialchars($_POST[$name], ENT_QUOTES, 'UTF-8');

$_POST[$name] = str_replace($ag_data_upload_dir, '', trim($_POST[$name])); //upload dir

$_POST[$name] = str_replace($ag_separator, '', trim($_POST[$name])); //separator


foreach ($ag_separator as $ag_separators_str) {
if (isset($ag_separators_str[0]) && isset($ag_separators_str[1]) && isset($ag_separators_str[2])) {
$_POST[$name] = str_replace($ag_separators_str[0].$ag_separators_str[1], '', trim($_POST[$name])); //separator fragment 1	
$_POST[$name] = str_replace($ag_separators_str[1].$ag_separators_str[2], '', trim($_POST[$name])); //separator fragment 2	
}
}	

$_POST[$name] = preg_replace('/\\\\+/', '', $_POST[$name]); 
$_POST[$name] = preg_replace("|[\r\n]+|", $ag_separator[3], $_POST[$name]); 
$_POST[$name] = preg_replace("|[\n]+|", $ag_separator[3], $_POST[$name]);	


	
if ($name == 'hash') { 
if (isset($_POST['pass'])) { 
$_POST[$name] = sha1($_POST['pass']); 
}
}// pass hash	

// changepass
if (isset($_POST['changepass']) && !empty($_POST['changepass'])) { 
$_POST['pass'] = $_POST['changepass']; 
$_POST['hash'] = sha1($_POST['changepass']);
} 
// changepass

if ($name == 'access') { if (empty($_POST[$name])) { $_POST[$name] = sizeof($ag_access_levels); } } // no select access level

}// poost no array

}// isset post name
}// isset name type



//changed actual data
if ($name == 'changed') {
$str_sep = '::';
if (!isset($ag_ERROR) && isset($_POST[$name])) {
$_POST[$name] = date('d').$str_sep.date('m').$str_sep.date('Y').$str_sep.date('H:i:s').$str_sep.$ag_user_id.$str_sep.$_SERVER['REMOTE_ADDR'];
}
}

//uncnown
if (!isset($_POST[$name])) { $_POST[$name] = ''; }


$ag_line_data .= $name.$ag_separator[1].$_POST[$name].$ag_separator[0]; 
}// foreach ag_values_db

if ($ag_edit_id == $ag_user_id) { $ag_this_access = 1; }
if ($ag_this_access != 1) {  $ag_ERROR['access'] = $ag_lng['access_denied'];  }	//this user access


// found line
$ag_founder_id = 0;

$found_line_arr = explode($ag_separator[0], $ag_line_data);
foreach ($found_line_arr as $values) {
$values	= explode($ag_separator[1], $values);
if (isset($values[0]) && isset($values[1]) && $values[0] == 'id') {$ag_founder_id = $values[1];}
if ($ag_user_id != $ag_founder_id) {	
if (isset($values[0]) && isset($values[1]) && $values[0] == 'access' && $values[1] == 'founder') { 
unset($ag_edit_line); $ag_ERROR['access'] = $ag_lng['access_denied']; } //founder off!	
}
}// user not founder




}// isset post ag_replace



// replace
if (isset($ag_edit_line) && isset($ag_line_data) && !empty($ag_line_data) && !isset($ag_ERROR)) { 

$ag_contents = file_get_contents($ag_file_name);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$ag_edit_line])) {
$ag_contents[$ag_edit_line] = $ag_line_data;

if (is_writable($ag_file_name)) {
	
   if (!$ag_handle = fopen($ag_file_name, 'wb')) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. ' - ' .$ag_file_name; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_ERROR['open_file'] = $ag_lng['error_open_file']. ' - ' .$ag_file_name; }
   fclose($ag_handle);
 
}
}

//files in dir
if (isset($ag_db_settings[$ag_this_db])) { 
if (isset($ag_db_settings[$ag_this_db]['files'])) { 
$ag_db_settings_files = explode('|', $ag_db_settings[$ag_this_db]['files']); 

foreach ($ag_db_settings_files as $fs_name_type) {
$fs_name_type_arr = explode('-', $fs_name_type);
if (isset($fs_name_type_arr[0])) {$fs_name = $fs_name_type_arr[0];}
if (isset($fs_name_type_arr[1])) {$fs_type = $fs_name_type_arr[1];}

if (isset($_POST[$fs_name]) && isset($fs_name) && isset($fs_type)) {
$ag_file_dir = $ag_data_dir.'/'.$ag_this_db.'/'.$fs_name.'_'.$ag_edit_id.'.'.$fs_type;	

$ag_file_dir_content = html_entity_decode($_POST[$fs_name], ENT_QUOTES, 'UTF-8'); 
$ag_file_dir_content = str_replace($ag_separator[3], chr(13).chr(10), $ag_file_dir_content);

//if (is_writable($ag_file_dir)) {} else {}
$ag_file_dir_create = fopen($ag_file_dir, "w"); // create data file
chmod($ag_file_dir, 0755);
fwrite($ag_file_dir_create, $ag_file_dir_content);
fclose ($ag_file_dir_create);	
}
	
}// foreach ag_db_settings_files
}// isset files settings
}// isset settings this db



unset($ag_line_data);
unset($ag_contents);
unset($_POST['ag_replace']);

}//--replace done

}// isset get id
?>