<form method="post">
	<b>Задание №1.</b><br>
	Вывести на монитор список всех файлов в текущем каталоге с расширением TXT в обратном алфавитном порядке имён. Вывод списка файлов должен приостанавливаться, когда заполняется экран дисплея.<br><br>
  	Ответ: <input name="answer1" type="text" size="100" maxlength="255"><br><br>
	<b>Задание №2.</b><br>
	Загрузить таблицу набора символов с номером 863 цветного графического адаптера.<br><br>
  	Ответ: <input name="answer2" type="text" size="100" maxlength="255"><br><br>
	<b>Задание №3.</b><br>
	Произвести сортировку содержимого файла text1.txt, находящегося в текущем каталоге, с записью отсортированных данных в новый файл textsort.txt.<br><br>
  	Ответ: <input name="answer3" type="text" size="100" maxlength="255"><br><br>
	<b>Задание №4.</b><br>
	Вывести на монитор информацию о состоянии всех модулей в памяти и внутренних драйверов.<br><br>
  	Ответ: <input name="answer4" type="text" size="100" maxlength="255"><br><br>
	<b>Задание №5.</b><br>
	Вывести на стандартное устройство печати содержимое файла book.txt.<br><br>
  	Ответ: <input name="answer5" type="text" size="100" maxlength="255"><br><br>
  	<input type="submit" value="Ответить" style="margin:10px">
</form><br>
<?php
// Проверка ответов после отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$correct = 0;
	for ($i=1; $i<=5; $i++) {
		$answer[] = stripslashes($_POST["answer".$i]);	
	}

	// Паттерны для проверки ответов
	$patterns = array(
		'/^(dir +\*.txt\/o:-n\/p|dir +\*.txt\/o-n\/p|dir +\*.txt\/p\/o:-n)$/i',
		'/^graftabl +863$/i',
		'/^(sort +text1.txt \/o +textsort.txt|sort \/o +textsort.txt +text1.txt)$/i',
		'/^(Mem \/d|mem \/debug)$/i',
		'/^Print \/d:prn +book.txt$/i'
	);

	// Проверка ответов с использованием регулярных выражений
	foreach ($patterns as $index => $pattern) {
		if (preg_match($pattern, $answer[$index])) {
			$correct++;
		}
	}

	// Оценка результатов
	switch($correct) {
		case '5': $estimation = 5; break;
		case '4': $estimation = 4; break;
		case '3': $estimation = 3; break;
		default: $estimation = 2;
	}	

	// Вывод результатов
	echo "<table border='1'><tr>
	<th>Правильных ответов </th>
	<td>$correct&nbsp;</td></tr>
	<tr><th>Оценка<br></th>
	<td>$estimation&nbsp;&nbsp;&nbsp;<br></td>
	</tr></table><br>";
}	
?>