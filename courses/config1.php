<?php
session_start();
$connect = mysqli_connect("localhost", "u1218120_default", "!4vLHr_t", "u1218120_default");
mysqli_set_charset($connect, "utf8");

if(!$connect) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}
$address_site = "https://courses.channail4.com/";
$email_admin = "admin@channail4.com";