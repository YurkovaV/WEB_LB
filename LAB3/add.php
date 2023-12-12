<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['title']) && !empty($_POST['description'])) {
        session_start();
        $_SESSION['Item']['title'] = clearData($_POST['title']);
		$_SESSION['Item']['type'] = clearData($_POST['type']);
		$_SESSION['Item']['location'] = clearData($_POST['location']);
		$_SESSION['Item']['rel_date'] = clearData($_POST['rel_date']);
		$_SESSION['Item']['release_date'] = clearData($_POST['release_date']);
		$_SESSION['Item']['description'] = clearData($_POST['description']);
        if (!empty($_FILES['uploadfile']['name']))
		{
			$tmp_path = 'tmp/';
			$file_path = 'Images/';
			$result = imageCheck();
			if ($result == 1)
			{
				$name = resize($_FILES['uploadfile']);
				$uploadfile = $file_path . $name;
				if (@copy($tmp_path . $name, $file_path . $_POST['title'] . '.jpg'))
					$uploadlink = "Images/". $_POST['title'] . '.jpg';
				unlink($tmp_path . $name);
				$_SESSION['Item']['uploadlink'] = $uploadlink;
			}
			else
			{
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

<center><h3>Добавить экспонат или достопримечательность</h3></center>
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
                        <option value='Архиологическая находка'>Архиологическая находка</option>
                        <option value='Научный экспонат'>Научный экспонат</option>
	            </select></p>
                <p>Местоположение:&nbsp;&nbsp;<input type='text' name='location'></p>
                <p>Год:&nbsp;&nbsp;<input type='text' name='rel_date'></p>
                <p>Изображение: <input type='file' name='uploadfile'></p>
                <p>Описание: <textarea name='description'></textarea></p>
                <input type='submit' value='Добавить'>
            </form>
        </td>
    </tr>
</table>