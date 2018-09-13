<?php
//Включаем буферизацию
ob_start();
//подключаем файл connection.php
require_once 'connection.php';
//Открываем подключение
$connection = mysqli_connect($host, $user, $password, $database) 
or die("Error" . mysqli_erro($connection));

require_once 'templates/main.html';

$query = "SELECT Sotrud.Id_sotrud, Sotrud.surName_Sotrud, Sotrud.Name_Sotrud, 
Sotrud.Otchestvo_sotrud, Sotrud.Korpus_and_Kabinet, Technique.Name_Technique, 
Technique.Information_Technique, TechniqueDate.Time_TO FROM Sotrud 
INNER JOIN Technique ON Sotrud.Id_Technique = Technique.Id_Technique 
INNER JOIN TechniqueDate ON Technique.ID_To = TechniqueDate.ID_TO";

$result = mysqli_query($connection, $query) or die("Ошибка".mysqli_error($connection));

if($result)
{
echo("<div class=\"maintable\">");
//Выводим таблицу
echo("<table class=\"sort\" id=\"tbl\" border=\"1\" cellpadding=\"2\">");

//Верхняя часть таблицы

echo("<thead>");

echo("<tr>");

echo("<th>Идентификатор</th>");
echo("<th>Фамилия</th>");
echo("<th>Имя</th>");
echo("<th>Отчество</th>");
echo("<th>Корпус и кабинет</th>");
echo("<th>Имя техники</th>");
echo("<th>Информация о технике</th>");
echo("<th>Дата обслуживания</th>");


//Закрываем верхнюю часть таблицы
echo("</tr>");

echo("</thead>");
echo("<tbody>");
// получаем количество полученных строк
$rows = mysqli_num_rows($result);
for($i = 0; $i < $rows; ++$i)
{
    $row = mysqli_fetch_row($result);
    //Выводим строку
    echo("<tr>");
    for($j = 0; $j < 8; ++$j) 
        echo("<td>".$row[$j]."</td>");
    echo("</tr>");
}
echo("</tbody>");
echo("</table>");
echo("</div>");
}

if(!isset($_COOKIE['login']) && !isset($_COOKIE['password']))
{
    header('Location: login.php');
}
//Если администратор добавил пользователя
if(isset($_REQUEST['adduserbtn']))
{
    unset($query);
    unset($result);
    //Экранируем символы
    $surName = htmlentities(mysqli_real_escape_string($connection, $_REQUEST['surname']));
    $name = htmlentities(mysqli_real_escape_string($connection, $_REQUEST['name']));
    $midName = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['middlename']));
    $room = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['room']));
    $techname = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['techname']));
    $techinfo = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['techdesc']));
    $dateob = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['datepick']));

    //Добавляем новую дату в таблицу TechniqueDate
    $addNewDate = "INSERT INTO TechniqueDate(TIME_TO) VALUES ('$dateob')";

    //Выполняем добавление даты
    $resultAddDate = mysqli_query($connection, $addNewDate) or die("Ошибка".mysqli_error($connection));
    
    //Получаем ID даты
    $newDateID = "SELECT MAX(ID_TO) FROM TechniqueDate";

    //Выполняем команду получения ID
    $getnewID = mysqli_query($connection, $newDateID) or die("Ошибка".mysqli_error($connection));
    
    //Последнее ID в таблице
    $id = mysqli_fetch_row($getnewID);

    //Строка добавления сведения о технике в таблицу Technique
    $addNewTech = "INSERT INTO Technique(Name_Technique,Information_Technique, ID_To) 
    VALUES('$techname', '$techinfo', $id[0])";

    //выполняем добавление техники
    $addTech = mysqli_query($connection, $addNewTech) or die("Ошибка".mysqli_error($connection));


    $newTechID = "SELECT MAX(Id_Technique) FROM Technique";

    //Получаем последний ID в таблице Technique
    $getNewTechId = mysqli_query($connection, $newTechID) or die("Ошибка".mysqli_error($connection));
    
    //Последний ID
    $newTech = mysqli_fetch_row($getNewTechId);


    //Строка добавления пользователя
    $addUserQuery = "INSERT INTO Sotrud(surName_Sotrud, Name_Sotrud, Otchestvo_sotrud, Id_Technique, Korpus_and_Kabinet)
    VALUES('$surName', '$name', '$midName', $newTech[0], '$room')";

    //Добавляем пользователя
    $addUserExecute = mysqli_query($connection, $addUserQuery) or die("Ошибка".mysqli_error($connection));

    header('Location: main.php');
}
if(isset($_REQUEST['delUser']))
{
    $id = $_REQUEST['delUser'];
    $query = "DELETE FROM Sotrud WHERE Id_sotrud = $id";
    $deleteUser = mysqli_query($connection, $query) or die("Ошибка".mysqli_error($connection));
    header('Location: main.php');
}
if(isset($_REQUEST['editButton']))
{
    $surName = htmlentities(mysqli_real_escape_string($connection, $_REQUEST['newSurname']));
    $name = htmlentities(mysqli_real_escape_string($connection, $_REQUEST['newName']));
    $midName = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['newMiddlename']));
    $room = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['newRoom']));
    $techname = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['newTechName']));
    $techinfo = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['newInfoTech']));
    $dateob = htmlentities(mysqli_real_escape_string($connection,$_REQUEST['newDatepick']));

    $id = $_REQUEST['users'];
    if($id != null || $id != "")
    {
        $updateUserData = "UPDATE Sotrud SET surName_Sotrud = '$surName', Name_Sotrud = '$name', Otchestvo_sotrud = '$midName',
        Korpus_and_Kabinet = '$room' WHERE Id_sotrud = $id";

        $result = mysqli_query($connection, $updateUserData) or die("Ошибка".mysqli_error($connection));

        $getIdTech = "SELECT Id_Technique FROM Sotrud WHERE Id_sotrud = $id";

        $result = mysqli_query($connection, $getIdTech) or die("Ошибка".mysqli_error($connection));

        $idTech = mysqli_fetch_row($result);

        $updateDetails = "UPDATE Technique SET Name_Technique = '$techname', Information_Technique = '$techinfo' WHERE Id_Technique = $idTech[0]";

        $result = mysqli_query($connection, $updateDetails) or die("Ошибка".mysqli_error($connection));

        $getIdTO = "SELECT ID_To FROM Technique WHERE Id_Technique = $idTech[0]";

        $result = mysqli_query($connection, $getIdTO) or die("Ошибка".mysqli_error($connection));

        $idTO = mysqli_fetch_row($result);

        $updateTO = "UPDATE TechniqueDate SET Time_TO = '$dateob' WHERE ID_TO = $idTO[0]";

        $result = mysqli_query($connection, $updateTO) or die("Ошибка".mysqli_error($connection));

        header('Location: main.php');
    }
}

if(isset($_REQUEST["exitButton"]))
{
    setcookie("login", "", time()-3600);
    setcookie("password", "", time()-3600);

    header('Location: main.php');
}
//закрываем подключение
mysqli_close($connection);

//Выключаем буферизацию
ob_end_flush();
?>