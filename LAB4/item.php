<?php
$host = 'localhost:3305';
$user = 'root';
$pass = '222222';
$dbName = 'museum';

$mysqli = new mysqli($host, $user, $pass, $dbName);

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

function sanitize($input, $mysqli) {
    return $mysqli->real_escape_string($input);
}

if(!isset($_SESSION)) { 
    session_start(); 
} 

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
    $id = sanitize($_GET['id'], $mysqli);

    $query = "SELECT * FROM ITEMS WHERE TITLE='$id'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc();

        echo "<br>
        &nbsp;&nbsp;&nbsp;<a href='index.php?page=edit&id'>Редактировать</a>&nbsp;&nbsp;&nbsp;<a href='index.php?page=catalog'>Каталог</a>
        <br><br>
        <table border='1' width='80%'>
            <tr>
                <th width='20%' bgcolor='#8080ff'>Название</th>
                <td colspan='2' width='40%' style='padding:0px 0px 0px 5px;'>{$row['title']}</td>
                <td rowspan='6' width='100%'><img src='{$row['image']}' ></td>
            </tr>
            <tr>
                <th width='12%' bgcolor='#8080ff'>Режиссер</th>
                <td colspan='2' style='padding:0px 0px 0px 5px;'>{$row['producer']}</td>
            <tr>
                <th width='12%' bgcolor='#8080ff'>Жанр</th>
                <td colspan='2' style='padding:0px 0px 0px 5px;'>{$row['genre']}</td>
            </tr>
            <tr>
                <th width='12%' bgcolor='#8080ff'>Студия</th>
                <td colspan='2' style='padding:0px 0px 0px 5px;'>{$row['developer']}</td>
            </tr>
            <tr>
                <th width='4%' bgcolor='#8080ff'>Год</th>
                <td colspan='2' style='padding:0px 0px 0px 5px;'>{$row['release_date']}</td>
            </tr>
            <tr height='250'>
                <th width='20%' bgcolor='#8080ff'>Описание</th>
                <td colspan='2' style='padding:0px 0px 0px 5px;'>{$row['description']}</td>
            </tr>
        </table>";
    } else {
        echo "Ошибка при выполнении запроса: " . $mysqli->error;
    }

    $result->free_result(); 
}


$mysqli->close();
?>
<br>
