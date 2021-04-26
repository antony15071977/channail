<?php // AgWD NOV 2016 (c) www.agwd.ru | autor: Шаклеин Максим (Shaklein Maksim) (c)
if (!isset($ag_index)) {header("HTTP/1.0 404 Not Found"); header("Location: http://".$_SERVER['HTTP_HOST']); die;}

$ag_default_period = 1095;

$ag_orders_db = array('id','number_order','service','title','category','date','time','spots','price','currency','first_name','family_name','email','phone','comment','staffs','payment','payment_important','added','changed','status');
$ag_orders_dir = 'orders';
$ag_order_data_file = date('m_Y');


//имена свойств для json расписания
$s_date = 'date'; //дата
$s_time = 'time'; //время начала
$s_time_end = 'time_end'; //время окончания
$s_free = 'is_free'; //показатель свободно/занято (true/false)
$s_price = 'price'; //цена
$s_currency = 'currency'; //обозначение валюты
$s_currency_sign = 'currency_sign'; //знак валюты
$s_currency_position = 'currency_position'; //позиция знака валюты
$s_custom = 'your_slot_id'; //произвольный параметр
$s_weekday = 'weekday'; // день недели 
$s_spots = 'spots'; // кол-во мест
$s_count_spots = 'count_spots'; // признак подсчёта стоимости по кол-ву мест
$success = 'success'; //результат


//поля формы (имя:тип:обязательное-1/необязательное-0)
$ag_booking_inputs = array(
'first_name:text:1',
'family_name:text:0',
'phone:phone:1',
'email:email:1',
'comment:textarea:0',
'source:hidden:0',
'md5:hidden:0',
'date:hidden:1',
'time:hidden:1', //Important
'spots:hidden:0',
'price:hidden:0', //Important
'your_slot_id:hidden:0',
);

$ag_order_status = array(
'0' => 'os_off',
'1' => 'os_on',
'2' => 'os_confirm',
'3' => 'os_paid',
);



if(!isset($_GET['orders']) && !isset($ag_no_create_order_dir)) {
if (file_exists($ag_orders_dir)) {

if (file_exists($ag_orders_dir.'/'.$ag_order_data_file.$agt)) {	} else {
$ag_order_file_create = fopen($ag_orders_dir.'/'.$ag_order_data_file.$agt, "w"); // create data file
fwrite($ag_order_file_create, '');
fclose ($ag_order_file_create);
}

	
} else {
if (!mkdir($ag_orders_dir, 0755, true)) { $ag_ERROR['make_data_dir'] = 'Error make directory ('.$ag_orders_dir.')'; } //create data dir	
}


//===============HTACCESS
$agt_ht = str_replace('.', '', $agt);
$data_add_htaccess = '<FilesMatch ".(htaccess|htpasswd|'.$agt_ht.'|php|html|log|sh)$">
 Order Allow,Deny
 Deny from all
</FilesMatch>';
if (file_exists($ag_orders_dir.'/.htaccess')) {  } else {
$htaccess_file_create = fopen($ag_orders_dir.'/.htaccess', "w"); // create data file
fwrite($htaccess_file_create, "$data_add_htaccess");
fclose ($htaccess_file_create);	
}
}// get orders




$ag_all_orders = array();
if (file_exists($ag_orders_dir)) {
$ag_all_orders = ag_file_list($ag_orders_dir, $agt); // files orders periods
}



//-------------------IMPORTANT PAY STATUS

$ag_check_order_data = array();	

$time_this_d = date('d');
$time_this_mon = date('m');
$time_this_y = date('Y');
$time_this = date('H:i:s');


$ag_this_date_time = new DateTime("$time_this_y-$time_this_mon-$time_this_d $time_this");

if (!empty($ag_all_orders)) {
foreach ($ag_all_orders as $ag_order_data_files) {
	
$ag_file_per_check_a = explode('/', $ag_order_data_files['name']);
$ag_file_per_check_a = array_diff($ag_file_per_check_a, array(''));
$ag_file_per_check = array_pop($ag_file_per_check_a); 
$ag_file_per_check = str_replace($agt, '', $ag_file_per_check); 
$ag_file_per_check_d = date("m_Y", strtotime($ag_file_per_check));	
$ag_this_per_check_d = date("m_Y", strtotime($time_this_mon.'_'.$time_this_y));	

if ($ag_file_per_check_d >= $ag_this_per_check_d) {
	
if (file_exists($ag_order_data_files['name'])) {$ag_check_order_data = ag_read_data($ag_order_data_files['name']);}

foreach ($ag_check_order_data as $no => $cord) {
	
$time_added = '00:00:00';
$time_added_d = date('d');
$time_added_mon = date('m');
$time_added_y = date('Y');


if (isset($cord['payment_important']) && !empty($cord['payment_important']) && isset($cord['status']) && $cord['status'] == 1) {
if (isset($cord['added'])) {

$add_data_a = explode('::', $cord['added']);
if (isset($add_data_a[3])) { $time_added = $add_data_a[3]; }
if (isset($add_data_a[0])) { $time_added_d = $add_data_a[0]; }
if (isset($add_data_a[1])) { $time_added_mon = $add_data_a[1]; }
if (isset($add_data_a[2])) { $time_added_y = $add_data_a[2]; }

}

$ag_order_date_time = new DateTime("$time_added_y-$time_added_mon-$time_added_d $time_added");
$ag_order_date_time = $ag_order_date_time->add(new DateInterval('PT'.$cord['payment_important'].'M'));



 

if ($ag_this_date_time > $ag_order_date_time) {
	
//$ag_order_data_files['name'] // $no

if (file_exists($ag_order_data_files['name'])) {	

$ag_tmo_change = date('H:i:s', strtotime($time_added.' + '.$cord['payment_important'].' min')); 
$ag_str_sep_add_info = '::';
$ag_user_id = $ag_lng['sys'];
$change_info = $time_added_d.$ag_str_sep_add_info.$time_added_mon.$ag_str_sep_add_info.$time_added_y.$ag_str_sep_add_info.$ag_tmo_change.$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['SERVER_ADDR']; 



//replace
$ag_contents = file_get_contents($ag_order_data_files['name']);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$no])) {
$ag_new_line = $ag_contents[$no];

// change info
$ag_new_line = str_replace('status'.$ag_separator[1].'1', 'status'.$ag_separator[1].'0', $ag_new_line);	
$old_cd = ag_str_cat($ag_new_line, 'changed'.$ag_separator[1].'', ''.$ag_separator[0].'');
$ag_new_line = str_replace($old_cd, 'changed'.$ag_separator[1].''.$ag_separator[0].'', $ag_new_line);
$ag_new_line = str_replace('changed'.$ag_separator[1].'', 'changed'.$ag_separator[1].''.$change_info, $ag_new_line);	
// change info

$ag_contents[$no] = $ag_new_line;
if (is_writable($ag_order_data_files['name'])) {
	
   if (!$ag_handle = fopen($ag_order_data_files['name'], 'wb')) { $ag_change_error = $ag_lng['error_open_file']; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_change_error = $ag_lng['error_open_file']; }
   fclose($ag_handle);
    
}
}


}// file_exists ag_order_data_files




}// end time





}// payment_important & status
	
}// foreach ag_check_order_data

}// check current period

}// foreach ag_all_orders
}// !empty ag_all_orders
//-------------------/IMPORTANT PAY STATUS    









//-------------------CONFIRM
if (isset($_GET[$ag_get_confirm])) {
$ag_confirm_num = htmlspecialchars($_GET[$ag_get_confirm], ENT_QUOTES, 'UTF-8');
$ag_confirm_num = (int)$ag_confirm_num;






$ag_found_order = 0;
$ag_status_order = 0;

// for pay
$ag_id_order = '';
$ag_service_order = '';
$ag_payer_name_order = '';
$ag_payer_mail_order = '';
$ag_payer_phone_order = '';
$ag_summ_order = '';
$ag_curr_order = '';
$ag_comment_order = '';
$ag_title_order = '';



$ag_confirm_order_data = array();	
foreach ($ag_all_orders as $ag_order_data_files) {

if (file_exists($ag_order_data_files['name'])) {$ag_confirm_order_data = ag_read_data($ag_order_data_files['name']);}

$ag_confirm_order_data = array_reverse($ag_confirm_order_data, true);

foreach ($ag_confirm_order_data as $n => $cod) {
	
	if (isset($cod['number_order']) && $cod['number_order'] == $ag_confirm_num) {
		
		if (isset($cod['status'])) {$ag_status_order = $cod['status'];}
		if (isset($cod['date'])) {  if (date("Y-m-d", strtotime($cod['date'])) < date("Y-m-d", strtotime(date('Y-m-d')))) {$ag_status_order = 0;} }
		
		if (isset($cod['payment_important']) && !empty($cod['payment_important']) && $cod['payment_important'] != '0') {$ag_pi_order = 1;} 
		
		// for pay
		if (isset($cod['id'])) {$ag_id_order = $cod['id'];}
		if (isset($cod['first_name'])) {$ag_payer_name_order = $cod['first_name'];}
		if (isset($cod['family_name']) && !empty($cod['family_name'])) {$ag_payer_name_order .= ' '.$cod['family_name'];}
		if (isset($cod['email'])) {$ag_payer_mail_order = $cod['email'];}
		if (isset($cod['phone'])) {$ag_payer_phone_order = $cod['phone'];}
		if (isset($cod['price'])) {$ag_summ_order = $cod['price'];}
		if (isset($cod['currency'])) {$ag_curr_order = $cod['currency'];}
		if (isset($cod['comment'])) {$ag_comment_order = $cod['comment'];}
		if (isset($cod['title'])) {$ag_title_order = $cod['title'];}
		if (isset($cod['service'])) {$ag_service_order = $cod['service'];}
		
		$ag_found_order = 1;  
		$ag_num_order_line = $n; 
		$ag_order_data_file = $ag_order_data_files['name'];
		break;
		
	} 
}

}



$ag_confirm_serv_data = array();
$ag_id_payments = array();
$ag_payments_data = array();
$ag_select_payment = '';

if (file_exists($ag_data_dir.'/service'.$agt)) {$ag_confirm_serv_data = ag_read_data($ag_data_dir.'/service'.$agt);}

foreach ($ag_confirm_serv_data as $csrv) {
if (isset($csrv['id']) && $csrv['id'] == $ag_service_order && isset($csrv['status']) && $csrv['status'] == '1')	{
	
if (isset($csrv['payments'])) { $ag_id_payments = explode($ag_separator[2], $csrv['payments']); }// payments	
	
break;	
}// id && status
}//foreach ag_confirm_serv_data

$ag_pay_link = '';
if (!empty($ag_id_payments)) {
$ag_pay_link = '<a href='.$srv_absolute_url.'?'.$ag_get_confirm.'='.$ag_confirm_num.'&'.$ag_get_pay.' class="ag_button">'.$ag_lng['pay_order_now'].'</a>';	
}

	

if(!isset($_GET[$ag_get_pay])) {
if ($ag_found_order == 0 || $ag_status_order == 0){
	
$ag_title_confirm = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['error_order_confirm']);	
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-cancel-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_display_confirm .= '</div>';
	
} 
}





if ($ag_found_order == 1 && $ag_status_order > 1){
$ag_display_order_status = $ag_lng['error_not_specified'];	
if (isset($ag_order_status[$ag_status_order])) {
$ag_display_order_status = $ag_order_status[$ag_status_order];
if (isset($ag_lng[$ag_display_order_status])) {$ag_display_order_status = $ag_lng[$ag_display_order_status];}
}	
$ag_title_confirm = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['before_order_confirm']);
$ag_title_confirm = str_replace('%n', '&laquo;'.$ag_display_order_status.'&raquo;', $ag_title_confirm);		


$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-ok-circle"></i></div>';
if (!empty($ag_pay_link)) {
	if ($ag_status_order == 3) {
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';		
	} else {
$ag_display_confirm .= '<div class="ag_error_404_link">'.$ag_pay_link.'</div>';
	}
} else {
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
}
$ag_display_confirm .= '</div>';

}


if (isset($ag_pi_order) && !isset($_GET[$ag_get_pay])) {
header("Location: ".$srv_absolute_url."?".$ag_get_confirm."=".$ag_confirm_num."&".$ag_get_pay);
}


// replace status
if ($ag_found_order == 1 && $ag_status_order == 1 && !isset($_GET[$ag_get_pay]) && !isset($ag_pi_order)) {


if (isset($ag_order_data_file) && isset($ag_num_order_line)) {


$ag_order_lines = array(); 
if (file_exists($ag_order_data_file)) {	
$ag_fp = fopen($ag_order_data_file, "r+");
flock ($ag_fp,LOCK_EX); 
if (filesize($ag_order_data_file) != 0) { $ag_order_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_order_data_file))); } 
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp); 
}// 


$ag_str_sep_add_info = '::';
$ag_user_id = $ag_lng['client'];
$change_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR']; 

if (isset($ag_order_lines[$ag_num_order_line])) {

// change info
$ag_new_line = str_replace('status'.$ag_separator[1].'1', 'status'.$ag_separator[1].'2', $ag_order_lines[$ag_num_order_line]);	
$old_cd = ag_str_cat($ag_new_line, 'changed'.$ag_separator[1].'', ''.$ag_separator[0].'');
$ag_new_line = str_replace($old_cd, 'changed'.$ag_separator[1].''.$ag_separator[0].'', $ag_new_line);
$ag_new_line = str_replace('changed'.$ag_separator[1].'', 'changed'.$ag_separator[1].''.$change_info, $ag_new_line);	
// change info


//replace
$ag_contents = file_get_contents($ag_order_data_file);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$ag_num_order_line])) {

$ag_contents[$ag_num_order_line] = $ag_new_line;
if (is_writable($ag_order_data_file)) {
	
   if (!$ag_handle = fopen($ag_order_data_file, 'wb')) { $ag_change_error = $ag_lng['error_open_file']; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_change_error = $ag_lng['error_open_file']; }
   fclose($ag_handle);
    
}
}




}// isset line


if (isset($ag_change_error)) {
	
$ag_title_confirm = $ag_change_error;	
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-cancel-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
//$ag_display_confirm .= 'file: '.$ag_order_data_file.' line:'.$ag_num_order_line;
$ag_display_confirm .= '</div>';	
	
} else {

$ag_title_confirm = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['done_order_confirm']);	
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-ok-circle"></i></div>';
if (!empty($ag_pay_link)) {
$ag_display_confirm .= '<div class="ag_error_404_link">'.$ag_pay_link.'</div>';
} else {
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
}
$ag_display_confirm .= '</div>';


//---------- sent mail status confirm
$ag_mess_t = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['done_order_confirm']);
$ag_mess_pt = '<h4>'.str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['done_order_confirm']).'</h4>';
$ag_order_confirm_link = $srv_absolute_url.'?'.$ag_get_confirm.'='.$ag_confirm_num;
$ag_mess_pt .= '<hr /><a href="'.$ag_order_confirm_link.'">'.$ag_order_confirm_link.'</a>';
if (!empty($ag_payer_mail_order)) {
ag_sent_mail($ag_payer_mail_order, '', '', $ag_mess_t, $ag_mess_pt, $ag_cfg_a_color, '');
}
//----------
	
}// no error	
	
	
}// file & line 	

	
}// status found && NO PAY
	
	
	
	
//=====================================================================================PAYMENT PAGE	
if (isset($_GET[$ag_get_pay])) {	
	
	
	
if ($ag_status_order == 3) {
	
$ag_display_order_status = $ag_lng['error_not_specified'];	
if (isset($ag_order_status[$ag_status_order])) {
$ag_display_order_status = $ag_order_status[$ag_status_order];
if (isset($ag_lng[$ag_display_order_status])) {$ag_display_order_status = $ag_lng[$ag_display_order_status];}
}	
$ag_title_confirm = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['before_order_confirm']);
$ag_title_confirm = str_replace('%n', '&laquo;'.$ag_display_order_status.'&raquo;', $ag_title_confirm);			
	
	
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-ok-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_display_confirm .= '</div>';


} else if ($ag_status_order == 0 || $ag_found_order == 0) {
	
$ag_title_confirm = str_replace('%s', '№ '.$ag_confirm_num.'', $ag_lng['error_order_confirm']);	

$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-cancel-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_display_confirm .= '</div>';


} else { // not payed order

/*
$ag_id_order = '';
$ag_service_order = '';
$ag_payer_name_order = '';
$ag_payer_mail_order = '';
$ag_payer_phone_order = '';
$ag_summ_order = '';
$ag_curr_order = '';
$ag_comment_order = '';
$ag_title_order = '';
*/
$ag_payment_form = '';
if (strpos($ag_summ_order, '.') === false) { 
$ag_summ_order = $ag_summ_order.'.00';
} else {
$ag_summ_order_a = explode('.', $ag_summ_order);
if (isset($ag_summ_order_a[1]) && strlen($ag_summ_order_a[1]) == 1) {$ag_summ_order = $ag_summ_order.'0';}	
}

//payment methods
if (file_exists($ag_data_dir.'/payment'.$agt)) {$ag_payments_data = ag_read_data($ag_data_dir.'/payment'.$agt);}


foreach ($ag_id_payments as $ag_pay_id) {
//$ag_select_payment = '';
foreach ($ag_payments_data as $ag_payment) {
if (isset($ag_payment['id']) && $ag_payment['id'] == $ag_pay_id && isset($ag_payment['status']) && $ag_payment['status'] == '1') {

$ag_alias_payment = '';
$ag_title_payment = '';
$ag_logo_payment = '';
	
if (isset($ag_payment['alias'])) {	$ag_alias_payment = $ag_payment['alias'];  }
if (isset($ag_payment['title'])) {	$ag_title_payment = $ag_payment['title'];  }
if (isset($ag_payment['logo'])) {	$ag_logo_payment = $ag_payment['logo'];  }



$ag_spc = '';
if (!empty($_GET[$ag_get_pay]) && $_GET[$ag_get_pay] == $ag_alias_payment) {
	
$ag_spc = ' class="ag_selected_payment"';

// payment form
$ag_payment_action = '';
$ag_payment_method = '';

$ag_summ_n = '';
$ag_curr_n = '';
$ag_numb_n = '';
$ag_idid_n = '';
$ag_mail_n = '';
$ag_desc_n = '';
$ag_comm_n = '';
$ag_retu_n = '';

if (isset($ag_payment['form_action'])) { $ag_payment_action = $ag_payment['form_action']; }
if (isset($ag_payment['form_method'])) { $ag_payment_method = $ag_payment['form_method']; }
if (empty($ag_payment_method)) {$ag_payment_method = 'POST';}
if (!empty($ag_payment_action)) {

$ag_payment_form = '<form action="'.$ag_payment_action.'" method="'.$ag_payment_method.'" id="ag_pay_form">';

if (isset($ag_payment['input_price']) && !empty($ag_payment['input_price'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_price'].'" value="'.$ag_summ_order.'" data-type="number" />';
$ag_summ_n = $ag_payment['input_price'];
}

if (isset($ag_payment['input_currency']) && !empty($ag_payment['input_currency'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_currency'].'" value="'.$ag_curr_order.'" />'; 
$ag_curr_n = $ag_payment['input_currency'];
}

if (isset($ag_payment['input_number']) && !empty($ag_payment['input_number'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_number'].'" value="'.$ag_confirm_num.'" />'; 
$ag_numb_n = $ag_payment['input_number'];
}

if (isset($ag_payment['input_id']) && !empty($ag_payment['input_id'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_id'].'" value="'.$ag_id_order.'" />'; 
$ag_idid_n = $ag_payment['input_id'];
}

if (isset($ag_payment['input_payer_mail']) && !empty($ag_payment['input_payer_mail'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_payer_mail'].'" value="'.$ag_payer_mail_order.'" />'; 
$ag_mail_n = $ag_payment['input_payer_mail'];
}

if (isset($ag_payment['input_desc']) && !empty($ag_payment['input_desc'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_desc'].'" value="'.$ag_title_order.'" />'; 
$ag_desc_n = $ag_payment['input_desc'];
}

if (isset($ag_payment['input_comment']) && !empty($ag_payment['input_comment'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_comment'].'" value="'.$ag_comment_order.'" />'; 
$ag_comm_n = $ag_payment['input_comment'];
}

if (isset($ag_payment['input_return']) && !empty($ag_payment['input_return'])) { 
$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['input_return'].'" value="'.$srv_absolute_url.'?'.$ag_get_pay.'='.$ag_alias_payment.'" />'; 
$ag_retu_n = $ag_payment['input_return'];
}

$ag_ic_arr = array();
if (isset($ag_payment['inputs_custom']) && !empty($ag_payment['inputs_custom'])) { 
$ag_pinput_custum_a = explode($ag_separator[2], $ag_payment['inputs_custom']);

foreach ($ag_pinput_custum_a as $ag_cinput) {
$ag_cinput_a = explode('::', $ag_cinput);
if (isset($ag_cinput_a[0]) && !empty($ag_cinput_a[0]) && isset($ag_cinput_a[1])) {
$ag_payment_form .= '<input type="hidden" name="'.$ag_cinput_a[0].'" value="'.$ag_cinput_a[1].'" />'; 
$ag_ic_arr[$ag_cinput_a[0]] = $ag_cinput_a[1];
}
}
}

$ag_ic_arr[$ag_summ_n] = $ag_summ_order;
$ag_ic_arr[$ag_curr_n] = $ag_curr_order;
$ag_ic_arr[$ag_numb_n] = $ag_confirm_num;
$ag_ic_arr[$ag_idid_n] = $ag_id_order;
$ag_ic_arr[$ag_mail_n] = $ag_payer_mail_order;
$ag_ic_arr[$ag_desc_n] = $ag_title_order;
$ag_ic_arr[$ag_comm_n] = $ag_comment_order;
$ag_ic_arr[$ag_retu_n] = $srv_absolute_url.'?'.$ag_get_pay.'='.$ag_alias_payment;


if (isset($ag_payment['md5_signature_name']) && !empty($ag_payment['md5_signature_name']) && isset($ag_payment['md5_signature']) && !empty($ag_payment['md5_signature'])) { 
$ag_md5_signature = '';
$ag_md5_signature_arr_n = array();
$ag_md5_signature_arr_v = array();
foreach ($ag_ic_arr as $ic_name => $ic_val) {

if (!empty($ic_name) && strpos($ag_payment['md5_signature'], '('.$ic_name.')') === false) { $ag_md5_signature = ''; } else {	
$ag_md5_signature_arr_n[] = '('.$ic_name.')';
$ag_md5_signature_arr_v[] = $ic_val;
}
}

$ag_md5_signature = str_replace($ag_md5_signature_arr_n, $ag_md5_signature_arr_v, $ag_payment['md5_signature']);
$ag_md5_signature = md5($ag_md5_signature);

$ag_payment_form .= '<input type="hidden" name="'.$ag_payment['md5_signature_name'].'" value="'.$ag_md5_signature.'" />'; 
}



$ag_payment_form .= '</form>';
$ag_payment_form .= '<script>$(document).ready(function(){ $("#ag_pay_form").submit(); });</script>';
}// action no empty

}

$ag_select_payment .= '<li tabindex="-1" data-name="'.$ag_alias_payment.'" onclick="ag_select_payment(this)"'.$ag_spc.'>';
$ag_select_payment .= '<div class="ag_select_payment" id="'.$ag_payment['id'].'">';
//$ag_select_payment .= '<p>';
if (!empty($ag_logo_payment)) { 
$ag_select_payment .= '<p><img src="'.$ag_data_dir.'/'.$ag_upload_name.''.$ag_logo_payment.'" alt="'.$ag_title_payment.'" title="'.$ag_title_payment.'" /></p>';
} else {
$ag_select_payment .= '<p><span>'.$ag_title_payment.'</span></p>';	
}
//$ag_select_payment .= '</p>';
$ag_select_payment .= '</div>';
$ag_select_payment .= '</li>';


}// id && status
}// foreach ag_payments_data
}// foreach ag_id_payments

$ag_title_confirm = $ag_lng['pay_order']. ' № '.$ag_confirm_num;		
	
$ag_display_confirm = '<div class="ag_error_404_content ag_post_item" id="ag_payment_page">';
$ag_display_confirm .= '<div class="ag_payment_inner">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';

$ag_display_confirm .= '<table>';
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['summ'].':</span></td><td>'.$ag_summ_order.' '.$ag_curr_order.'</td></tr>';
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['service'].':</span></td><td>'.$ag_title_order.'</td></tr>';
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['on_name'].':</span></td><td>'.$ag_payer_name_order.'</td></tr>';
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['email'].':</span></td><td>'.$ag_payer_mail_order.'</td></tr>';
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['phone'].':</span></td><td>'.$ag_payer_phone_order.'</td></tr>';
if (!empty($ag_comment_order)) {
$ag_comment_order = str_replace($ag_separator[3], '<br />', $ag_comment_order);
$ag_display_confirm .= '<tr><td><span>'.$ag_lng['comment'].'</span></td><td>'.$ag_comment_order.'</td></tr>';
}
$ag_display_confirm .= '</table>';

if (!empty($ag_select_payment)) { 
$ag_display_confirm .= '<h3>'.$ag_lng['select_payment'].'</h3>';
$ag_display_confirm .= '<ul class="ag_payment_list">'.$ag_select_payment.'</ul>'; 
$ag_display_confirm .= '<div class="ag_clear"></div>'; 
}


//display payment methods

//$srv_absolute_url


if (!empty($ag_select_payment)) {
$ag_display_confirm .= '<div class="ag_error_404_link"><span class="ag_button" tabindex="-1" onclick="ag_gotopay()">' .$ag_lng['pay']. '</span></div>';
} else {
$ag_display_confirm .= '<div class="ag_error_404_link"></div>';	
}

$ag_display_confirm .= '</div>';	
$ag_display_confirm .= '</div>';
	
if (!empty($ag_select_payment)) { 
$ag_display_confirm .= '
<input type="hidden" id="ag_sel_pay" />
     <script>
	 
     function ag_select_payment(e) {
	 $("ul.ag_payment_list li").removeClass("ag_selected_payment"); 
	 $(e).addClass("ag_selected_payment");  
	 $("#ag_sel_pay").val($(e).attr("data-name"));
     }
	 
	 function ag_gotopay() {
	 var ag_sel_pay	= $("#ag_sel_pay").val(); 
	 if (!ag_sel_pay) {alert("'.$ag_lng['error_select_payment'].'"); return false;}
	 window.location="'.$srv_absolute_url.'?'.$ag_get_confirm.'='.$ag_confirm_num.'&'.$ag_get_pay.'=" + ag_sel_pay;	 
	 }
	 $(document).ready(function(){
	 if ($("ul.ag_payment_list li").length == 1) {  setTimeout(function(){$("ul.ag_payment_list li").eq(0).click();},400); }
	 setInterval(function() {window.location = "'.$_SERVER['REQUEST_URI'].'";}, 60000);
	 });
    </script>';
	

	
}	
$ag_display_confirm .= $ag_payment_form;
	
$ag_display_confirm = ag_return_html($ag_display_confirm);	
}

	
}	
	
	
	
}// get confirm
//-------------------/CONFIRM








//-------------------PAY REQUEST
if (isset($_GET[$ag_get_pay]) && !isset($_GET[$ag_get_confirm])) {	

header('Access-Control-Allow-Origin: *');

$ag_payments_data = array();

$ag_post_payment_id = 'false';

$ag_check_ostatus = '';

$ag_num_order_pay = '';
$ag_mail_mclient = '';

if (file_exists($ag_data_dir.'/payment'.$agt)) {$ag_payments_data = ag_read_data($ag_data_dir.'/payment'.$agt);}



$ag_alias_payment = '';
$ag_title_payment = '';
$ag_logo_payment = '';

foreach ($ag_payments_data as $ag_payment) {
//if (isset($ag_payment['status']) && $ag_payment['status'] == '1') {


	
if (isset($ag_payment['alias'])) {	$ag_alias_payment = $ag_payment['alias'];  }


if (!empty($_GET[$ag_get_pay]) && $_GET[$ag_get_pay] == $ag_alias_payment) {

if (isset($ag_payment['input_id'])) { $ag_post_payment_id = $ag_payment['input_id'];  }
if (isset($ag_payment['title'])) {	$ag_title_payment = $ag_payment['title'];  }
if (isset($ag_payment['logo'])) {	$ag_logo_payment = $ag_payment['logo'];  }

break;
}



//}// id status
}// foreach ag_payments_data


unset($ag_n_line);
unset($ag_f_name);

if (isset($_POST[$ag_post_payment_id])) {

$ag_rquest_order_data = array();
foreach ($ag_all_orders as $ag_order_data_files) {
if (file_exists($ag_order_data_files['name'])) {$ag_rquest_order_data = ag_read_data($ag_order_data_files['name']);}

foreach ($ag_rquest_order_data as $no => $cord) {

if (isset($cord['id']) && $cord['id'] == $_POST[$ag_post_payment_id]) {
$ag_n_line = $no;	
$ag_f_name = $ag_order_data_files['name'];
if (isset($cord['status'])) {$ag_check_ostatus = $cord['status'];}
if (isset($cord['number_order'])) {$ag_num_order_pay = $cord['number_order'];}
if (isset($cord['email'])) {$ag_mail_mclient = $cord['email'];}
break;
}// id order = post
	
}// foreach ag_rquest_order_data
}// foreach ag_all_orders


}// post order id




//replase status
if (isset($ag_n_line) && isset($ag_f_name)) {
	
if ($ag_check_ostatus == '3') {
	
$ag_display_order_status = $ag_lng['error_not_specified'];	
if (isset($ag_order_status[$ag_check_ostatus])) {
$ag_display_order_status = $ag_order_status[$ag_check_ostatus];
if (isset($ag_lng[$ag_display_order_status])) {$ag_display_order_status = $ag_lng[$ag_display_order_status];}
}	
$ag_title_confirm = str_replace('%s', '№ '.$ag_num_order_pay.'', $ag_lng['before_order_confirm']);
$ag_title_confirm = str_replace('%n', '&laquo;'.$ag_display_order_status.'&raquo;', $ag_title_confirm);		

$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-wallet"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_display_confirm .= '</div>';	
	
	
	
} else { //--------------------------------------REPLASE
	



	
$ag_order_lines = array(); 
if (file_exists($ag_f_name)) {	
$ag_fp = fopen($ag_f_name, "r+");
flock ($ag_fp,LOCK_EX); 
if (filesize($ag_f_name) != 0) { $ag_order_lines = preg_split("~\r*?\n+\r*?~", fread($ag_fp, filesize($ag_f_name))); } 
flock ($ag_fp,LOCK_UN);
fclose ($ag_fp); 
}// 


$ag_str_sep_add_info = '::';
$ag_user_id = $ag_title_payment;
$change_info = date('d').$ag_str_sep_add_info.date('m').$ag_str_sep_add_info.date('Y').$ag_str_sep_add_info.date('H:i:s').$ag_str_sep_add_info.$ag_user_id.$ag_str_sep_add_info.$_SERVER['REMOTE_ADDR']; 

if (isset($ag_order_lines[$ag_n_line])) {


$ag_new_line = $ag_order_lines[$ag_n_line];


$ag_new_line = str_replace('payment'.$ag_separator[1].'', 'payment'.$ag_separator[1].'', $ag_order_lines[$ag_n_line]);	


$ag_new_line = str_replace('status'.$ag_separator[1].$ag_check_ostatus, 'status'.$ag_separator[1].'3', $ag_order_lines[$ag_n_line]);
	
usleep(200000);
	
// change info
$old_cd = ag_str_cat($ag_new_line, 'changed'.$ag_separator[1].'', ''.$ag_separator[0].'');
$ag_new_line = str_replace($old_cd, 'changed'.$ag_separator[1].''.$ag_separator[0].'', $ag_new_line);
$ag_new_line = str_replace('changed'.$ag_separator[1].'', 'changed'.$ag_separator[1].''.$change_info, $ag_new_line);	
// change info

//replace
$ag_contents = file_get_contents($ag_f_name);
$ag_contents = explode("\n", $ag_contents);
if (isset($ag_contents[$ag_n_line])) {

$ag_contents[$ag_n_line] = $ag_new_line;
if (is_writable($ag_f_name)) {
	
   if (!$ag_handle = fopen($ag_f_name, 'wb')) { $ag_change_error = $ag_lng['error_open_file']; }             
   if (fwrite($ag_handle, implode("\n", $ag_contents)) === FALSE) { $ag_change_error = $ag_lng['error_open_file']; }
   fclose($ag_handle);
    
}
}





$ag_title_confirm = str_replace('%s', '№ '.$ag_num_order_pay.'', $ag_lng['done_order_pay']);
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-wallet"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
$ag_display_confirm .= '</div>';	

}	

//---------- sent mail status pay
$ag_mess_t = str_replace('%s', '№ '.$ag_num_order_pay.'', $ag_lng['done_order_pay']);
$ag_mess_pt = '<h4>'.str_replace('%s', '№ '.$ag_num_order_pay.'', $ag_lng['done_order_pay']).'</h4>';
$ag_order_confirm_link = $srv_absolute_url.'?'.$ag_get_confirm.'='.$ag_num_order_pay.'&amp;'.$ag_get_pay;
$ag_mess_pt .= '<hr /><a href="'.$ag_order_confirm_link.'">'.$ag_order_confirm_link.'</a>';
if (!empty($ag_mail_mclient)) {
ag_sent_mail($ag_mail_mclient, '', '', $ag_mess_t, $ag_mess_pt, $ag_cfg_a_color, '');
}
//----------
	
}// REPLASE
	
	
} // line & file


if (isset($_POST[$ag_post_payment_id]) && !isset($ag_n_line) && !isset($ag_f_name)) {

$ag_title_confirm = $ag_lng['error_order_pay_not_found'];
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-cancel-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
//$ag_display_confirm .= 'file: '.$ag_order_data_file.' line:'.$ag_num_order_line;
$ag_display_confirm .= '</div>';	
	
}// not found order


if (isset($ag_change_error)) {

$ag_title_confirm = $ag_change_error;	
$ag_display_confirm = '<div class="ag_error_404_content">';
$ag_display_confirm .= '<h2 class="ag_error_404_title">' .$ag_title_confirm. '</h2>';
$ag_display_confirm .= '<div class="ag_error_404_icon"><i class="icon-cancel-circle"></i></div>';
$ag_display_confirm .= '<div class="ag_error_404_link"><a href="' .$srv_absolute_url. '" class="ag_button">' .$ag_lng['to_home']. '</a></div>';
//$ag_display_confirm .= 'file: '.$ag_order_data_file.' line:'.$ag_num_order_line;
$ag_display_confirm .= '</div>';	

}



$ag_display_confirm = ag_return_html($ag_display_confirm);	

	
} //get pay no confirm







?>