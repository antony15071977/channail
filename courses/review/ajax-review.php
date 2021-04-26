<?php
//Для начала проверим есть ли данные в полях name и email, что бы не слать совсем пустые формы :)
//Если всё в порядке, то работаем дальше
if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["comment"]) ) { 
require_once('../config.php');
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }
    if ($data) {
        $types = '';
        $stmt_data = [];
        foreach ($data as $value) {
            $type = 's';
            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }
            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }
        $values = array_merge([$stmt, $types], $stmt_data);
        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }
    return $stmt;
}
//Принимаем данные POST-запроса и записываем значения в переменные

$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

//Теперь давайте настроим куда отправляем и откуда

$my_email = 'Channail4office@yandex.ua'; // Куда отправляем
// $my_email = 'i.avraamy2@gmail.com'; 
$sender_email = '<review@channail4.com>'; // От кого отправляем
$title = "ОТЗЫВ С САЙТА"; 
$sql = "INSERT INTO commentos (dt_add, name, comment_text) VALUES (NOW(), ?, ?)";
            $stmt = db_get_prepare_stmt($connect, $sql, [$name, $comment]);
            $res = mysqli_stmt_execute($stmt);
            if (!$res) {
                $error = mysqli_error($connect);
                print($error);
            }
            $last_id = mysqli_insert_id($connect);
            //Составляем заголовок письма
                    $subject = "Новый комментарий на сайте ".$_SERVER['HTTP_HOST'];
                    //Устанавливаем кодировку заголовка письма и кодируем его
                    $subject = "=?utf-8?B?".base64_encode($subject).
                    "?=";
                    //Составляем тело сообщения
            $message = 'Здравствуйте!<br/><br/>Сегодня '.date("d.m.Y", time()).
            ' пользователем '.$name.' (e-mail: '.$email.') был оставлен комментарий на сайте <a href="'.$address_site.
            '">'.$_SERVER['HTTP_HOST'].
            '</a>.
            А вот и сам Комменарий: '.$comment.'<br>
            Чтобы одобрить и опубликовать его, нажмите на ссылку <a href="'.$address_site.'review/comment-moderation.php?ok='.$last_id.'">"ОДОБРИТЬ"</a>.
            Чтобы удалить его безвозвратно, нажмите на ссылку <a href="'.$address_site.'review/comment-moderation.php?del='.$last_id.'">"УДАЛИТЬ"</a>.
            Чтобы отредактировать и потом опубликовать его, нажмите на ссылку <a href="'.$address_site.'review/comment-moderation.php?comment='.$comment.'&id='.$last_id.'">"РЕДАКТИРОВАТЬ"</a>.
            ';
            //Составляем дополнительные заголовки для почтового сервиса mail.ru
            $headers = "FROM: $sender_email\r\nReply-to: $sender_email\r\nContent-type: text/html; charset=utf-8\r\n";
            //Отправляем сообщение с ссылкой для подтверждения регистрации на указанную почту и проверяем отправлена ли она успешно или нет. 
            if (!mail($my_email, $subject, $message, $headers)) {
                print("<p class='mesage_error'>Ошибка при отправлении письма с ссылкой подтверждения. Попробуйте еще раз.</p>");
                exit();
            }
     echo json_encode(array(
    'result'    => 'success'
)); 

} else {
    echo json_encode(array(
        'result'    => 'error'
       ));
    exit();
    }

?>