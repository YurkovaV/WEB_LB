<?php
$host = 'localhost';
$user = 'mysql';
$pass = '222222';
$dbName = 'films';

$id = $_SESSION['id'];
$file_path = 'Images/';

// Подключение к базе данных MySQL
$mysqli = new mysqli($host, $user, $pass, $dbName);

if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM ITEMS WHERE TITLE='$id'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['producer']) && !empty($_POST['genre']) && !empty($_POST['developer']) && !empty($_POST['release_date']) && !empty($_POST['description'])) {
		$title = $_POST['title'];
		$total_items_result = $mysqli->query("SELECT COUNT(*) FROM ITEMS WHERE TITLE='$title'");
        $total_items = $total_items_result->fetch_row()[0];

		if ($total_items[0] = 1) {
			$producer = clearData($_POST['producer']);
			$genre = clearData($_POST['genre']);
			$developer = clearData($_POST['developer']);
			$release_date = clearData($_POST['release_date']);
			$description = clearData($_POST['description']);

			if (($title != $row['title']) || (!empty($_FILES['uploadfile']['name']))) {
                if ($title != $row['title']) {
                    rename($row['link'], $file_path . $title . '.jpg');
                }

                if (!empty($_FILES['uploadfile']['name'])) {
                    $tmp_path = 'tmp/';
                    $result = imageCheck();

                    if ($result == 1) {
                        $name = resize($_FILES['uploadfile']);
                        $uploadfile = $file_path . $name;

                        if (@copy($tmp_path . $name, $file_path . $title . '.jpg')) {
                            unlink($tmp_path . $name);
                        }
                    } else {
                        echo $result;
                        exit;
                    }
                }

				$uploadlink = $file_path . $title . '.jpg';
				$query = "UPDATE ITEMS SET TITLE='$title',PRODUCER='$producer',GENRE='$genre',DEVELOPER='$developer',RELEASE_DATE='$release_date',DESCRIPTION='$description',LINK='$uploadlink' WHERE TITLE='$id'";
			} else {
				$query = "UPDATE ITEMS SET TITLE='$title',PRODUCER='$producer',GENRE='$genre',DEVELOPER='$developer',RELEASE_DATE='$release_date',DESCRIPTION='$description' WHERE TITLE='$id'";
			}

			$mysqli->query($query) or die("Сбой при доступе к БД: " . $mysqli->error);
            header("Location: index.php?page=catalog");
            exit;

        } else {
            echo 'Такой композиции нет';
        }
    } else {
        echo 'Полностью заполните форму';
    	}
}
$mysqli->close();
?>

<center><h3>Редактировать экспонат или достопримечательность</h3></center>
<table align='center'>
    <tr>
        <td>
            <form method='POST' action='index.php?page=edit' enctype='multipart/form-data'>
                <table>
                    <tr>
                        <td>Название:</td>
                        <td><input type='text' name='title' value='<?php echo $title; ?>' /></td>
                    </tr>
                    <tr>
                        <p>Тип:&nbsp;&nbsp;&nbsp;&nbsp;<select size='10' multiple name='type'>
	                    <option value='Архитектурный памятник'>Архитектурный памятник</option>
	                    <option value='Природная достопримечательность'>Природная достопримечательность</option>
	                    <option value='Архиологический объект'>Архиологический объект</option>
	                    <option value='Религиозный объект'>Религиозный объект</option>
                        <option value='Картина'>Картина</option>
                        <option value='Скульптура'>Скульптура</option>
                        <option value='Фотография'>Фотография</option>
                        <option value='Объект прикладного искусства'>Объект прикладного искусства</option>
                        <option value='Архиологическая находка'>Архиологическая находка</option>
                        <option value='Научный экспонат'>Научный экспонат</option>
	            </select></p>
                    </tr>
                    <tr>
                        <td>Местоположение:</td>
                        <td><input type='text' name='location' value='<?php echo $location; ?>' /></td>
                    </tr>
                    <tr>
                        <td>Год:</td>
                        <td><input type='text' name='rel_date' value='<?php echo $rel_date; ?>' /></td>
                    </tr>
                    <tr>
                        <td>Описание:</td>
                        <td><textarea name='description'><?php echo $description; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Изображение:</td>
                        <td><input type='file' name='uploadfile' /></td>
                    </tr>
                </table>
                <input type='submit' value='Редактировать' />
            </form>
        </td>
    </tr>
</table>