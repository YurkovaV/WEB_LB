<?php
$link = mysqli_connect("localhost:3306", "root", "222222", "museum");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['title']) && !empty($_POST['type']) && !empty($_POST['location']) && !empty($_POST['rel_date']) && !empty($_POST['description'])) {
        $title = clearData($_POST['title']);
        // Параметры подключения к MySQL
        $host = 'localhost:3306';
        $user = 'root';
        $pass = '222222';
        $dbName = 'museum';
        $mysqli = new mysqli($host, $user, $pass, $dbName);
        // Проверка подключения
        if ($mysqli->connect_error) {
            die("Ошибка подключения: " . $mysqli->connect_error);
        }
        $total_items_result = $mysqli->query("SELECT COUNT(*) FROM ITEMS WHERE TITLE='$title'");
        $total_items = $total_items_result->fetch_row();
        if ($total_items[0] < 1) {
        $title = clearData($_POST['title']);
        $type = clearData($_POST['type']);
        $location = clearData($_POST['location']);
        $rel_date = clearData($_POST['rel_date']);
        $description = str_replace("'", "''", $_POST['description']);
			$description = preg_replace("~(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}".
			"(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|".
			"org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?".
			"!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&".
			"?+=\~/-]*)?(?:#[^ '\"&<>]*)?~i",'',$description);

        if (!empty($_FILES['uploadfile']['name'])) {
            $tmp_path = 'tmp/';
            $file_path = 'Images/';
            $result = imageCheck(); 

            if ($result == 1) {
                $name = resize($_FILES['uploadfile']); 
                $uploadfile = $file_path . $name;

                if (@copy($tmp_path . $name, $file_path . $title . '.jpg')) { 
                    $uploadlink = "Images/" . $title . '.jpg'; 
                }

                unlink($tmp_path . $name);
            } else {
                echo $result;
                exit;
            }
        }}

        $query = "INSERT INTO ITEMS (TITLE,TYPE,LOCATION,REL_DATE,DESCRIPTION,UPLOADLINK) VALUES ('$title','$type','$location','$rel_date','$description','$uploadlink')";
            if ($mysqli->query($query) === true) {
                header("Location: index.php?page=catalog");
            } else {
                echo "Ошибка при выполнении запроса: " . $mysqli->error;
            }
            $mysqli->close();
        } else {
            echo 'Такой экспонат уже добавлен';
        }
    } else {
        echo 'Полностью заполните форму';
}
?>

<h3>Добавить экспонат или достопримечательность</h3>
<table align='center'>
    <tr>
        <td>
            <form method='POST' action='index.php?page=add' enctype='multipart/form-data'>
                <p>Название: <input type='text' name='title'></p>
                <p>Тип:&nbsp;&nbsp;&nbsp;&nbsp;<select size='10' multiple name='type'>
                    <option value='Архитектурный памятник'>Архитектурный памятник</option>
                    <option value='Природная достопримечательность'>Природная достопримечательность</option>
                    <option value='Архиологический объект'>Архиологический объект</option>
                    <option value='Религиозный объект'>Религиозный объект</option>
                    <option value='Картина'>Картина</option>
                    <option value='Скульптура'>Скульптура</option>
                    <option value='Фотография'>Фотография</option>
                    <option value='Объект прикладного искусства'>Объект прикладного искусства</option>
                    <option value='Археологическая находка'>Археологическая находка</option>
                    <option value='Научный экспонат'>Научный экспонат</option>
                </select></p>
                <p>Местоположение:&nbsp;&nbsp;<input type='text' name='location'></p>
                <p>Год:&nbsp;&nbsp;<input type='text' name='rel_date'></p>
                Изображение: <input type='file' name='uploadfile'>
                <p>Описание: <textarea name='description'></textarea></p>
                <input type='submit' value='Добавить'>
            </form>
        </td>
    </tr>
</table>