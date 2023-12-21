<?php
//session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $title = isset($_GET['title']) ? clearData($_GET['title']) : '';
    $type = isset($_GET['type']) ? clearData($_GET['type']) : '';
    $location = isset($_GET['location']) ? clearData($_GET['location']) : '';
    $rel_date = isset($_GET['rel_date']) ? clearData($_GET['rel_date']) : '';
    $description = isset($_GET['description']) ? clearData($_GET['description']) : '';
    $uploadlink = isset($_GET['uploadlink']) ? clearData($_GET['uploadlink']) : '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['type']) && !empty($_POST['location']) && !empty($_POST['rel_date']) && !empty($_POST['description'])) {
        $_SESSION['Item']['title'] = clearData($_POST['title']);
        $_SESSION['Item']['type'] = clearData($_POST['type']);
        $_SESSION['Item']['location'] = clearData($_POST['location']);
        $_SESSION['Item']['rel_date'] = clearData($_POST['rel_date']);
        $_SESSION['Item']['description'] = clearData($_POST['description']);
        if (!empty($_FILES['uploadfile']['name'])) {
            $tmp_path = 'tmp/';
            $file_path = 'Images/';
            $result = imageCheck();
            if ($result == 1) {
                $name = resize($_FILES['uploadfile']);
                $uploadfile = $file_path . $name;
                if (@copy($tmp_path . $name, $file_path . $_POST['title'] . '.jpg')) {
                    $uploadlink = "Images/". $_POST['title'] . '.jpg';
                }
                unlink($tmp_path . $name);
                $_SESSION['Item']['uploadlink'] = $uploadlink;
            } else {
                echo $result;
                exit;
            }
        }
        header("Location: index.php?page=catalog");
        exit;
    } else {
        echo 'Заполните форму полностью!';
    }
}
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