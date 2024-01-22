<?php
	$host = 'localhost:3306';
	$dbname = 'museum';
	$user = 'root';
	$pass = '222222';
	
	$dsn = "mysql:host=$host;dbname=$dbname";
	$options = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
$link = mysqli_connect("localhost", "root", "", "base");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['login_reg']) && !empty($_POST['password_new']) && !empty($_POST['password_rep']) && !empty($_POST['email']) && !empty($_POST['birthday']) && !empty($_POST['phone'])) {
        if ($_POST['password_new'] == $_POST['password_rep']) {
            $login_reg = clearData($_POST['login_reg']);
            $hash_password = md5(clearData($_POST['password_new']));
            $mail = clearData($_POST['email']);
            
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $mail)) 
			{
				echo 'Введите корректный адрес электронной почты!';
				exit;
			}
            
            $name = clearData($_POST['name']);
            $surname = clearData($_POST['surname']);
            $phone = clearData($_POST['phone']);
            
            if (!preg_match('/^((8|\+7)[\- ]?)?( ?[\- ]?)?[\d\- ]{7,12}$/', $phone)) {
                echo 'Введите корректный номер телефона!';
                exit;
            } 
            
            $birthday = clearData($_POST['birthday']);
            $host = 'localhost';
			$user = 'root';
			$pass = '';
			$dbName = 'base';
            $mysqli = new mysqli($host, $user, $pass, $dbName);

            if ($mysqli->connect_error) {
                die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }

            $query = "INSERT INTO USERS (LOGIN, PASSWORD, MAIL, NAME, SURNAME, BIRTHDAY, PHONE) VALUES ('$login_reg', '$hash_password', '$mail', '$name', '$surname', '$birthday', '$phone')";

            if ($mysqli->query($query)) {
                header("Location: index.php");
            } else {
                echo "Сбой при вставке данных: " . $mysqli->error;
            }

            $mysqli->close();
        } else {
            echo 'Пароли не совпадают!';
        }
    } else {
        echo 'Полностью заполните форму!';
    }
}
?>




<h3><span style="color: green"></span>Регистрация</h3>
<justify><p><span style="color: red">*</span> обозначены поля, обязательные для заполнения</p></justify>
<table class="data_table">
    <tr>
        <td>
        <form method="POST">
        <p><span style="color: red">*</span>Логин:<input type="text" name="login_reg" style="margin-left:100px"></p>
        <p><span style="color: red">*</span>Пароль:<input type="password" name="password_new" style="margin-left:90px"></p>
        <p><span style="color: red">*</span>Повторите пароль:<input type="password" name="password_rep"></p>
        <p><span style="color: red">*</span>Email:<input type="text" name="email" style="margin-left:105px"></p>
        <p><span style="color: red">*</span>Дата рождения:<input type="date" name="birthday" style="margin-left:45px"></p>
        <p><span style="color: red">*</span>Телефон:<input type="text" name="phone" style="margin-left:80px"></p>
        <p>Имя:<input type="text" name="name" style="margin-left:125px"></p>
        <p>Фамилия:<input type="text" name="surname" style="margin-left:83px"></p>
        <p><input type="submit" value="Зарегистрироваться"></p>
        </form>
        </td>
    </tr>
</table>