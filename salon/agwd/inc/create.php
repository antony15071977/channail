<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

$ag_data_dir = '../'.$ag_data_dir; //apanel
$ag_data_upload_dir = $ag_data_dir.'/'.$ag_upload_name; //apanel

if (file_exists($ag_data_dir)) { } else {
if (!mkdir($ag_data_dir, 0755, true)) { $ag_ERROR['make_data_dir'] = 'Error make directory ('.$ag_data_dir.')'; } //create data dir
}

$ag_data_conf_files_str = '';
foreach ($ag_db as $check_files => $val) {
$ag_cr_line = '';

if (file_exists($ag_data_dir.'/'.$check_files.$agt)) {
if (filesize($ag_data_dir.'/'.$check_files.$agt) == 0) {
	

$ag_file_create = fopen($ag_data_dir.'/'.$check_files.$agt, "w"); // create data file
//create admin
if (in_array('login', $val) && in_array('pass', $val) && in_array('hash', $val)) {
foreach ($val as $a_index) {
$a_coll = '';
if ($a_index == 'id') {$a_coll = $check_files.'_'.date('d_m_Y_H_i_s').'_00'; } 
if ($a_index == 'login') {$a_coll = 'admin';}	
if ($a_index == 'pass') {$a_coll = 'admin';}
if ($a_index == 'hash') {$a_coll = 'd033e22ae348aeb5660fc2140aec35850c4da997';}
if ($a_index == 'name') {$a_coll = 'Administrator';}
if ($a_index == 'access') {$a_coll = 'founder';}
if ($a_index == 'status') {$a_coll = '1';}
if ($a_index == 'added') {$a_coll = date('d').'::'.date('m').'::'.date('Y').'::'.date('H:i:s').'::'.$check_files.'_'.date('d_m_Y_H_i_s').'_00::'.$_SERVER['REMOTE_ADDR']; }
$ag_cr_line .= $a_index.$ag_separator[1].$a_coll.$ag_separator[0];
}	
}
fwrite($ag_file_create, $ag_cr_line);
fclose ($ag_file_create);	
	
	
}// 0 size
} else { //create file

if (!in_array($check_files, $ag_db_dir)) {
$ag_file_create = fopen($ag_data_dir.'/'.$check_files.$agt, "w"); // create data file
//create admin
if (in_array('login', $val) && in_array('pass', $val) && in_array('hash', $val)) {
foreach ($val as $a_index) {
$a_coll = '';
if ($a_index == 'id') {$a_coll = $check_files.'_'.date('d_m_Y_H_i_s').'_00'; } 
if ($a_index == 'login') {$a_coll = 'admin';}	
if ($a_index == 'pass') {$a_coll = 'admin';}
if ($a_index == 'hash') {$a_coll = 'd033e22ae348aeb5660fc2140aec35850c4da997';}
if ($a_index == 'name') {$a_coll = 'Administrator';}
if ($a_index == 'access') {$a_coll = 'founder';}
if ($a_index == 'status') {$a_coll = '1';}
if ($a_index == 'added') {$a_coll = date('d').'::'.date('m').'::'.date('Y').'::'.date('H:i:s').'::'.$check_files.'_'.date('d_m_Y_H_i_s').'_00::'.$_SERVER['REMOTE_ADDR']; }
$ag_cr_line .= $a_index.$ag_separator[1].$a_coll.$ag_separator[0];
}	
}
fwrite($ag_file_create, $ag_cr_line);
fclose ($ag_file_create);	
}// !in array ag_db_dir

}

$ag_data_conf_files_str .= $check_files.$ag_separator[0];
}


// delete odd files
$ag_data_conf_files_str .= $ag_data_conf_files_str.$ag_separator[0].str_replace('.php', '', $ag_config);
$ag_data_conf_files_arr = explode($ag_separator[0], $ag_data_conf_files_str);

$ag_data_file_check = ag_file_list($ag_data_dir);
foreach($ag_data_file_check as $found_dfiles) {
  $ag_data_files = $found_dfiles['name'];
  $ag_data_files = str_replace(array($ag_data_dir, '/'), '', $ag_data_files);
  
  $ag_a_name = explode('.', $ag_data_files);
  $ag_r_name = array_pop($ag_a_name);
  $ag_f_name = str_replace('.'.$ag_r_name, '', $ag_data_files);
  
  if (!is_dir($ag_data_dir. '/' .$ag_data_files)) { 
  if (!empty($ag_f_name) && !in_array($ag_f_name, $ag_data_conf_files_arr)) {  
 
  if (file_exists($ag_data_dir.'/'.$ag_data_files)) {
	chmod($ag_data_dir.'/'.$ag_data_files, 0755);
	unlink($ag_data_dir.'/'.$ag_data_files);
  }
  
  }
  }
}
// delete odd files



//===============CONFIG
$data_add_config = '<?php'."\r\n";
foreach ($ag_config_array as $conf_name => $conf_val) {
$conf_val_arr = explode($ag_separator[0], $conf_val);
$ag_config_value = '';
if (isset($conf_val_arr[0])) { $ag_config_value = $conf_val_arr[0]; }
$data_add_config .= '$' .$conf_name. ' = "' .$ag_config_value. '";'."\r\n";
}
$data_add_config .= '?>';

if (file_exists($ag_data_dir.'/'.$ag_config)) { 
if (filesize($ag_data_dir.'/'.$ag_config) == 0) {
$config_file_create = fopen($ag_data_dir.'/'.$ag_config, "w"); // create data file
fwrite($config_file_create, "$data_add_config");
fclose ($config_file_create);
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
header("Location: ".$srv_script_absolute_url);	
}
} else {
$config_file_create = fopen($ag_data_dir.'/'.$ag_config, "w"); // create data file
fwrite($config_file_create, "$data_add_config");
fclose ($config_file_create);
$srv_script_absolute_url = str_replace('index.php', '', $srv_script_absolute_url);
header("Location: ".$srv_script_absolute_url);
}


//===============HTACCESS
$agt_ht = str_replace('.', '', $agt);
$data_add_htaccess = '<FilesMatch ".(htaccess|htpasswd|'.$agt_ht.'|php|html|log|sh)$">
 Order Allow,Deny
 Deny from all
</FilesMatch>';
if (file_exists($ag_data_dir.'/.htaccess')) {  } else {
$htaccess_file_create = fopen($ag_data_dir.'/.htaccess', "w"); // create data file
fwrite($htaccess_file_create, "$data_add_htaccess");
fclose ($htaccess_file_create);	
}
if(!isset($ag_salt)) {unset($ag_index);}

//===============UPLOAD
if(file_exists($ag_data_upload_dir) && is_dir($ag_data_upload_dir)) {  

//upload_subdir
$ag_upload_subdir = array('photos', 'documents', 'music', 'video'); //create folder
foreach ($ag_upload_subdir as $ndn => $dirname) {
if(file_exists($ag_data_upload_dir.'/'.$dirname) && is_dir($ag_data_upload_dir.'/'.$dirname)) {  
} else {
if (!mkdir($ag_data_upload_dir.'/'.$dirname, 0755, true)) {
$ag_ERROR['make_data_dir'.$ndn] = 'Error make directory (' .$dirname. ')'; }
}
}// foreach upload_subdir

} else {
if (!mkdir($ag_data_upload_dir, 0755, true)) {
$ag_ERROR['make_data_dir'] = 'Error make directory ('.$ag_upload_name.')'; }
}

$srv_current_path_arr = explode('/',$srv_current_path);
array_pop($srv_current_path_arr);
$ag_adm_dir = '';
if (isset($srv_current_path_arr[(sizeof($srv_current_path_arr) - 1)])) {$ag_adm_dir = $srv_current_path_arr[(sizeof($srv_current_path_arr) - 1)];}


//===============DB DIR
$ag_db_files_dirs = '';
$ag_db_files_dirs_arr = array();
if(!isset($ag_cl)) {unset($ag_index);}
if (isset($ag_db_settings)) {
foreach ($ag_db_settings as $ag_fdirs => $ag_fdirs_sett) {
if (isset($ag_fdirs_sett['files'])) { $ag_db_files_dirs .= $ag_fdirs.$ag_separator[0]; }
}	
}
$ag_db_files_dirs_arr = explode($ag_separator[0], $ag_db_files_dirs);
array_pop($ag_db_files_dirs_arr);

$ag_all_dir = $ag_db_dir + $ag_db_files_dirs_arr;

foreach ($ag_all_dir as $ag_dir_db => $ag_dir_name) {
if(file_exists($ag_data_dir.'/'.$ag_dir_name) && is_dir($ag_data_dir.'/'.$ag_dir_name)) {  
} else {
if (!mkdir($ag_data_dir.'/'.$ag_dir_name, 0755, true)) {
$ag_ERROR['make_data_db_dir'] = 'Error make directory (' .$ag_dir_name. ')'; }
}
// delete odd dir
$ag_data_dir_check = ag_file_list($ag_data_dir, 'dir');
	foreach ($ag_data_dir_check as $found_ddir) {
	if (isset($found_ddir['name'])) {
		$ag_data_dirs = $found_ddir['name'];
		$ag_data_dirs = str_replace(array($ag_data_dir, '/'), '', $ag_data_dirs);
		//echo $ag_data_dirs;
		if (!in_array($ag_data_dirs, $ag_all_dir) && $ag_data_dirs != $ag_upload_name && $ag_data_dirs != $ag_thumbs_name && $ag_data_dirs != $ag_mob_images && $ag_data_dirs != $ag_dir_name) {
		if (file_exists($ag_data_dir.'/'.$ag_data_dirs) && is_dir($ag_data_dir.'/'.$ag_data_dirs)) {
			ag_del_dir($ag_data_dir.'/'.$ag_data_dirs); // delete odd dir
		}	
		}
	}
	}
// delete odd dir
}


//===============ROBOTS
$ag_robots_file = '../robots.txt';
$ag_sitemap_url = str_replace('/'.$ag_adm_dir, '', $srv_absolute_url);

$data_add_robots = 'User-Agent: *
Allow: /
Host: ' .$srv_host_name. '
Sitemap: ' .$ag_sitemap_url. '?sitemap=xml';

if (file_exists('../robots.txt')) { 

$ag_robots = file_get_contents($ag_robots_file);
//echo $ag_robots;

if (preg_match('/'. $srv_host_name .'/', $ag_robots))  {} else {
$robots_file_create = fopen($ag_robots_file, "w"); // change data file
fwrite($robots_file_create, "$data_add_robots");
fclose ($robots_file_create);	
}// current host not found

 } else {
	 
$robots_file_create = fopen($ag_robots_file, "w"); // create new data file
fwrite($robots_file_create, "$data_add_robots");
fclose ($robots_file_create);	
}
?>