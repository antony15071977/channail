<?php
if (isset($_POST["name"]) && isset($_POST["email"]) ) { 

	//Принимаем данные POST-запроса и записываем значения в переменные

	$name = $_POST['name'];
	$email = $_POST['email'];
	$comment = $_POST['comment'];

	if (isset($_FILES['avatar']['name'])) {
		if (!empty($_FILES['avatar']['name'])) {
			$tmp_name = $_FILES['avatar']['tmp_name'];
			$file = $_FILES['avatar']['name'];
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file_type = finfo_file($finfo, $tmp_name);
				
			if (($file_type == "image/gif") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/pjepg")) {
				function send_mail($mail_to, $thema, $msg, $path) { 
					 // Вспомогательная функция для отправки почтового сообщения с вложением
					 // Параметры - адрес получателя, тема письма, текст письма, путь к загруженному файлу
					 if ($path) {  
					  $fp = fopen($path,"rb");   
					  if (!$fp) { print "Cannot open file"; exit(); }   
					  $file = fread($fp, filesize($path));   
					  fclose($fp);   
					 }  
					 $name = basename($path); // в этой переменной надо сформировать имя файла (без пути)  
					 $EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
					 $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.  
					 $headers    = "MIME-Version: 1.0;$EOL";   
					 $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";  
					 $headers   .= "From: review@channail4.com";  
					 $multipart  = "--$boundary$EOL";
					 $multipart .= "\n\n$msg\n\n";
					 $multipart .= $EOL; // раздел между заголовками и телом html-части 
					 $multipart .=  "$EOL--$boundary$EOL";   
					 $multipart .= "Content-Type: application/octet-stream; name=\"$name\"$EOL";   
					 $multipart .= "Content-Transfer-Encoding: base64$EOL";   
					 $multipart .= "Content-Disposition: attachment; filename=\"$name\"$EOL";   
					 $multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла 
					 $multipart .= chunk_split(base64_encode($file));   
					 $multipart .= "$EOL--$boundary--$EOL";   
					 if (!mail($mail_to, $thema, $multipart, $headers)) { //если не письмо не отправлено
					  return false;           
					 }  
					 else { // если письмо отправлено
					  return true;  
					 }  
					 exit;  
					}

					$picture = ""; 
					 // Если поле выбора вложения не пустое - закачиваем его на сервер 
					 if (!empty($_FILES['avatar']['tmp_name'])) { // Закачиваем файл 
					  $path = 'avatar/'.$_FILES['avatar']['name']; 
					  if (copy($_FILES['avatar']['tmp_name'], $path)) $picture = $path; 
					 } 
					 $thm = "ОТЗЫВ С САЙТА"; //Тема письма
					 $msg = "
Вам поступил на модерацию отзыв с сайта оффлайн-курсов https://channail4.com/courses/ от:\n
Имя: $name\n
E-mail: $email\n
Отзыв: $comment\n
Фото того, кто оставил отзыв, во вложении.
После модерации отправьте его, пожалуйста, разработчику на i.avraamy2@gmail.com
"; //Текст сообщения
					 // $mail_to = 'i.avraamy2@gmail.com'; //Адрес получателя
					 $mail_to = 'channail4school@yandex.ru'; // Куда отправляем
					// Отправляем почтовое сообщение 
					 if(empty($picture)) mail($mail_to, $thm, $msg); 
					 else send_mail($mail_to, $thm, $msg, $picture);
					 echo json_encode(array(
            		'result'    => 'success'
        		));	
			} else {
				echo json_encode(array(
            		'result'    => 'error'
        		));	
			}
		}
	} else {
		echo json_encode(array(
            'result'    => 'error'
        	));
		exit();
	}
} else {
	echo json_encode(array(
        'result'    => 'error'
        	));
	exit();
}
?>