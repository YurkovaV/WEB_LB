<?php
	$host = 'localhost:3305';
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
{
	if (!empty($_POST['login_reg']) && !empty($_POST['email']) && !empty($_POST['password_1']) && !empty($_POST['password_2'])) 
	{
		if ($_POST['password_1'] == $_POST['password_2'])
		{
			$login_reg = clearData($_POST['login_reg']);
			$email = clearData($_POST['email']);
			$hash_password = ($_POST['password_1']);
			try {
				$conn = new PDO($dsn, $user, $pass, $options);
				$query = "INSERT INTO USERS (LOGIN, EMAIL, PASSWORD) VALUES (:login_reg, :email, :hash_password)";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(':login_reg', $login_reg);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':hash_password', $hash_password);
				$stmt->execute();
				header("Location: index.php");
			} catch(PDOException $e) {
				echo "Сбой при вставке данных: " . $e->getMessage();
			}
		}
		else {
			echo 'Пароли не совпадают';
		}
	}
	else {
		echo 'Полностью заполните форму';
	}
}
?>

<h3>Регистрация</h3>
<table class="data_table">
	<tr>
		<td>
			<form method="POST">
			<p>Логин:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='login_reg'>
			<p>Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='email' name='email'>
			<p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='password' name='password_1'>
			<p>Повторите пароль:<input type='password' name='password_2'><br>
			<p><input type='submit' value='Зарегистрироваться'><br>
			</form>
		</td>
	</tr>
</table>
