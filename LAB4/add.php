<?php
$link = mysqli_connect("localhost:3305", "root", "222222", "museum");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['TITLE']) && !empty($_POST['TYPE']) && !empty($_POST['LOCATION']) && !empty($_POST['REL_DATE']) && !empty($_POST['DESCRIPTION'])) {
        $_SESSION['Item']['TITLE'] = clearData($_POST['TITLE']);
        $_SESSION['Item']['TYPE'] = clearData($_POST['TYPE']);
        $_SESSION['Item']['LOCATION'] = clearData($_POST['LOCATION']);
        $_SESSION['Item']['REL_DATE'] = clearData($_POST['REL_DATE']);
        $_SESSION['Item']['DESCRIPTION'] = clearData($_POST['DESCRIPTION']);

        if (!empty($_FILES['uploadfile']['name'])) {
            $tmp_path = 'tmp/';
            $file_path = 'Images/';
            $result = imageCheck();

            if ($result == 1) {
                $name = resize($_FILES['uploadfile']);
                $uploadfile = $file_path . $name;

                if (@copy($tmp_path . $name, $file_path . $_POST['TITLE'] . '.jpg')) {
                    $uploadlink = "Images/" . $_POST['TITLE'] . '.jpg';
                }

                unlink($tmp_path . $name);
                $_SESSION['Item']['UPLOADLINK'] = $uploadlink;
            } else {
                echo $result;
                exit;
            }
        }

        // Сохранение данных в базу данных
        $sql = "INSERT INTO items (TITLE, TYPE, LOCATION, REL_DATE, DESCRIPTION, UPLOAD_LINK) VALUES ('" . $_SESSION['Item']['TITLE'] . "', '" . $_SESSION['Item']['TYPE'] . "', '" . $_SESSION['Item']['LOCATION'] . "', '" . $_SESSION['Item']['REL_DATE'] . "', '" . $_SESSION['Item']['DESCRIPTION'] . "', '" . $_SESSION['Item']['UPLOADLINK'] . "')";

        // Выполнение SQL-запроса
        if (mysqli_query($link, $sql)) {
            echo "Данные успешно добавлены в базу данных.";
        } else {
            echo "Ошибка при выполнении запроса: " . mysqli_error($link);
        }

        // Закрытие соединения с базой данных
        mysqli_close($link);

        header("Location: index.php?page=catalog");
        exit;
    } else {
        echo 'Заполните форму полностью!';
    }
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
                    <option value='Архиологический объект'>Археологический объект</option>
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
