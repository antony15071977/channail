<?php
// хешМД5 для ссылки КУПИТЬ
// MerchantLogin:OutSum:InvId:Пароль#1:shp_item=
// https://i-leon.ru/tools/md5
// вместо InvId стваить 0
$mrh_pass2 = "baj8gmZ2NbVcJ7COP4S9";
// чтение параметров
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["shp_item"];
$crc = $_REQUEST["SignatureValue"];
$crc = strtoupper($crc);
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:shp_item=$shp_item"));
//проверка секретного ключа
if ($my_crc !=$crc) {
      echo "bad sign\n";
      exit();
    }
//массив ссылок на продажу
$array_links = [
    20 => array("Курс «Марафон перфекциониста»", 5000),
    21 => array("Курс «Марафон перфекциониста»", 30000),
    27 => array("Курс «Марафон перфекциониста»", 15000),
    28 => array("Курс «Марафон перфекциониста»", 18000),
    29 => array("Курс «Марафон перфекциониста»", 38000),

];

if(!empty($_POST["OutSum"]) && !empty($_POST["EMail"]) ){ // если был POST и переданы данные
    $order_number = $_POST["shp_item"];
    $link = $array_links[$order_number] [0];
        //Надо добавить проверку на сумму платежа
        //если оплата правильная, можно отсылать письмо с ссылкой
    $summ = $array_links[$order_number] [1];
    $paid = $_POST["OutSum"];
    if ($paid >= $summ) {
            //Теперь давайте настроим куда отправляем и откуда
            $to_email = $_POST["EMail"];
            // Куда отправляем
            $sender_email = '<CHANNAIL4.ONLINE@CHANNAIL4.COM>';// От кого отправляем
            $title = "Поздравляем с бронированием курса от Channail4!"; 
            $title2 = "У Вас новая бронь на курс";
            $title3 = "Поздравляем с полной оплатой курса от Channail4!"; 
            $title4 = "У Вас полностью оплатили ранее забронированный курс";  

            //Сообщение, которое приходит на почту со всеми нужными нам данными:

            $mes = "
            Поздравляю!
            Только что Вы приобрели доступ к урокам на учебной платформе Channail4.\n
            Свяжитесь с нашим администратором с помощью этой электронной почты Channail4office@yandex.ua для записи на забронированный Вами $link.\n
            -------------------------------\n
            
            Если Вас интересует более подробная информация по нашим курсам, пожалуйста, свяжитесь с нами!\n
            Channail4office@yandex.ua
            ";
            $mes2 = "
            Поздравляю!
            Только что за $paid рублей у Вас забронировали доступ к урокам на учебной платформе Channail4.\n
            Свяжитесь с Вашим покупателем с помощью этой электронной почты $to_email для записи на приобретенную им бронь $link.\n
            -------------------------------\n          
            
            ";
            $mes3 = "
            Поздравляю!
            Только что Вы оплатили полный доступ к урокам на учебной платформе Channail4.\n
            Вами оплачен $link.\n
            -------------------------------\n
            
            Если Вас интересует более подробная информация по нашим курсам, пожалуйста, свяжитесь с нами!\n
            Channail4office@yandex.ua
            ";
            $mes4 = "
            Поздравляю!
            Только что за $paid рублей у Вас полностью оплатили $link на учебной платформе Channail4.\n
            Свяжитесь с Вашим покупателем с помощью этой электронной почты $to_email для записи на приобретенный им $link.\n
            -------------------------------\n
            ";
             $to_email2 = 'Channail4office@yandex.ua';
            //$to_email2 = 'i.avraamy2@gmail.com';

             // признак успешно проведенной операции
            echo "OK$inv_id\n";
            //Всё, теперь можно отправлять письмо на почту
            if ($order_number == 20) {
                $send = mail ($to_email,$title,$mes,"Content-type:text/plain; charset = utf-8\r\nFrom:$sender_email");
                $send2 = mail ($to_email2,$title2,$mes2,"Content-type:text/plain; charset = utf-8\r\nFrom:$sender_email");
            }
            else {
                $send3 = mail ($to_email,$title3,$mes3,"Content-type:text/plain; charset = utf-8\r\nFrom:$sender_email");
                $send4 = mail ($to_email2,$title4,$mes4,"Content-type:text/plain; charset = utf-8\r\nFrom:$sender_email");
            }

            
        }
        else {
            header("Location:sorry.html");
        }
    }

?>