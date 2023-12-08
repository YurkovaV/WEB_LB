<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set('Europe/Moscow');
	include "lib.inc.php";
?>
<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<title>Каталог музеев</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="head"><a href="index.html"><img src="hd.jpg" height="400" width="2300"></a></div>
	<div class="top">
		<?php include "top.inc.php" ?>
	</div>
	<div class="menu">
		<?php 
			include "menu.inc.php";
		?>
	</div>
	<div class="content">
		<p>Приветствуем Вас на нашем сайте!!</p>
		<p>В нашем каталоге вы найдете информацию о различных музеях со всего мира. Мы собрали для вас подробные
			описания и фотографии, чтобы помочь вам выбрать интересующий вас музей для посещения</p>
		<p>После выбора музея, вы можете получить дополнительную информацию о его расположении, часах работы, билетах и
			возможности проведения экскурсий.</p>
		<p> Мы также предоставляем ссылки на официальные веб-сайты музеев для
			получения более подробной информации</p>
		<hr><br>
		<p>Ссылки на ресурсы:</p>
		<p>
			<a href="https://dzen.ru/a/X3BohWOyXQTNsdY3">
			  <img src="first.jpg" alt="Женщины эпохи возрождения" width="21%" height="21%">
			</a>
			<a href="https://lektsii.org/12-79307.html">
			  <img src="third.jpg" alt="Феномен культуры Возрождения" width="12%" height="12%">
			</a>
			<a href="https://arzamas.academy/mag/353-reness">
			  <img src="two.jpg" alt="Факты о Ренессансе" width="23%" height="23%">
			</a>
		</p>
	</div>
	<div class="bottom">
		<?php include "bottom.inc.php" ?>
		&copy; Copyright 2020. РГРТУ АСУ. Все права защищены.
	</div>
</body>

</html>
