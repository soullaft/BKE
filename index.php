<?php
//Включаем буферизацию
ob_start();
//Если есть данные о логине и пароле, то это значит, что пользователь авторизовался
//т.е переходим на главную страницу
if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
{
    //Редирект на main.php
    header('Location: main.php');
}
else
{
    //Редирект на login.php
    header("Location: login.php");
}
//Выключаем буферизацию
ob_end_flush();
?>