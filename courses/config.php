<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "giftube");
if(!$connect) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}
mysqli_set_charset($connect, "utf8");

if(!$connect) {
    print('Ошибка подключения: ' . mysqli_connect_error());
}
$address_site = "https://courses.channail4.com/";
$email_admin = "admin@channail4.com";

