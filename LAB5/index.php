<?php
    ob_start();
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set('Europe/Moscow');
	include "lib.inc.php";
	if (isset($_COOKIE['dateVisit']))
	    $dateVisit = $_COOKIE['dateVisit'];
    setcookie('dateVisit', date('Y-m-d H:i:s'), time() + 0xFFFFFFF);
    $page = "";
?>
<!DOCTYPE html>
<html lang="ru">
<?php
    header('Cache-Control: no-store, no-cache, must-revalidate');
?>
<head>
	<meta charset="UTF-8">
	<title>Каталог музеев</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="head"><a href="index.html"><img src="hd.jpg" height="500" width="1500"></a></div>
	<div class="top">
		<?php include "top.inc.php" ?>
	</div>
	<div class="menu">
		<?php 
			include "menu.inc.php";
		?>
	</div>
	<div class="content">
	    <?php
		if (!empty($_GET['page']))
			$page = $_GET['page'];

		if (empty($page)) { ?>
		<p>Приветствуем Вас на нашем сайте!</p>
		<p>В нашем каталоге вы найдете информацию о различных музеях со всего мира.</p>
		<p> Мы собрали для вас подробные
			описания и фотографии, чтобы помочь вам выбрать интересующий вас музей для посещения</p>
		<p>После выбора музея, вы можете получить дополнительную информацию о его расположении, часах работы, билетах и
			возможности проведения экскурсий.</p>
		<p> Мы также предоставляем ссылки на официальные веб-сайты музеев для
			получения более подробной информации</p>
		<?php 
		include "auth.php";
		?>
		<!-- <hr><br>
				<form method="POST">
					<p>Войдите, чтобы получить больше функций</p>
					<p>Логин:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="login"><br>
						<p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password"><br>
							<p><input type="submit" value="Войти"><br>
		</form>
		<hr><br> -->
		<p>Ссылки на ресурсы:</p>
		<p>
			<a href="https://dzen.ru/a/X3BohWOyXQTNsdY3">
			  <img src="first.jpg" alt="Женщины эпохи возрождения" width="21%" height="21%">
			</a>
			<a href="https://lektsii.org/12-79307.html">
			  <img src="third.jpg" alt="Феномен культуры Возрождения" width="12%" height="12%">
			</a>
			<a href="https://arzamas.academy/mag/353-reness">
			  <img src="two.jpg" alt="Факты о Ренессансе" width="23%" height="22%">
			</a>
		</p>
		<?php } else switch ($page) {
				case 'lr1':
					include 'lab_rab1.html';
					break;
				case 'lr2':
					include 'lab_rab2.php';
					break;
				case 'lr3':
					include 'lab_rab3.php';
					break;
				case 'lr4':
					include 'lab_rab4.php';
					break;
				case 'lr5':
					include 'lab_rab5.php';
					break;
				case 'catalog':
					include 'catalog.php';
					break;
				case 'add':
					include 'add.php';
					break;
				case 'item':
					include 'item.php';
					break;
				case 'edit':
					include 'edit.php';
					break;
				case 'logout':
					include 'logout.php';
					break;
				case 'reg';
					include 'registration.php';
					break;
			}
			?>
	</div>
	<div class="bottom">
		<?php include "bottom.inc.php" ?>
		&copy; Copyright 2023. РГРТУ АСУ. Все права защищены.
	</div>
</body>
</html>
<?php
require 'auth.php';
ob_end_flush();
?>