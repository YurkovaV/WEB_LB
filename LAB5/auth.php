<?php
$user = 'root';
$pass = '222222';
$host = 'localhost:3306';
$database = 'museum';

$link = mysqli_connect($host, $user, $pass, $database);
?>

<style>
    a.button {
        display: inline-block;
        color: #fff;
        padding: 12px;
        border-radius: 3px;
        text-decoration: none;
        font-family: Tahoma;
        font-size: 18px;
        line-height: 1;
        font-weight: 70;
    }
</style>

<?php
echo "<form method='POST'>
    <p>Войдите, чтобы получить больше функций</p>
        <p>Логин:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='login'><br>
        <p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='password' name='password'><br>
        <p><input type='submit' value='Войти'> <a href='index.php?page=reg' class='button'>Зарегистрироваться</a><br>
</form>";

if (isset($_POST['LOGIN']) && isset($_POST['PASSSWORD'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM USERS WHERE LOGIN='$login'";
    $result = mysqli_query($link, $query);

    if ($result) {
        $row = mysqli_fetch_row($result);
        if ($row && $login == $row[0] && $password == $row[1]) {
            session_start();
            $_SESSION['user_login'] = $_POST['LOGIN'];
            header("Location: index.php");
            exit;
        } else {
            echo "Вы неправильно ввели логин или пароль <br><br>";
        }
    } else {
        echo "Ошибка при выполнении запроса: " . mysqli_error($link);
    }
}

if (isset($_GET['logout'])) {
	session_start();
	session_destroy();
	header("Location: index.php");
	exit;
}
if (isset($_REQUEST[session_name()]))
	if (isset($_SESSION['user_login']) and $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
exit;
?>