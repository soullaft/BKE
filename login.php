<?php
//Включаем буферизацию
ob_start();
//Добавляем шаблон страницы "логин"
require_once 'templates/login.html';
//Если введенные даныне поступили на сервер, то:
if(isset($_REQUEST['login']) && isset($_REQUEST['password']))
{
    //Если логин и пароль, которые ввел пользователь равны root и root:
    //В противном же случае ничего не делаем.
    if($_REQUEST['login'] == 'root' && $_REQUEST['password'] == 'root')
    {   
        //Если пользователь выбрал "Запомнить меня, то сохраняем куки на 4+ часа"
        if($_REQUEST['IsRemember'] == 'true')
        {
            setcookie('login', $_REQUEST['login'], time() + 7200);
            setcookie('password', $_REQUEST['password'], time() + 7200);
        }
        //В противном же случае на +- 20 секунд
        else
        {
            setcookie('login', $_REQUEST['login'], time() + 1000);
            setcookie('password', $_REQUEST['password'], time() + 1000);
        }
        //Редирект на index.php
        header('Location: index.php');
        }
}
//Выключаем буферизацию
ob_end_flush();
?>