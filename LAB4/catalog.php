<button onclick="location.href='index.php?page=add';" class="add_button" style="margin-left:900px;">Добавить</button>
<form method="POST" style="display: inline;">
    <input type="submit" class="del_button" name="delete" value="Удалить" style="margin-left:10px;">
</form>
<table class="data_table" border="1" style="margin-top: 20px;">
    <tr>
        <th width="5%"></th>
        <th width="15%">Название</th>
        <th width="15%">Тип</th>
        <th width="15%">Местоположение</th>
        <th width="10%">Год</th>
        <th width="30%">Описание</th>
        <th width="10%">Изображение</th>
    </tr>

    <?php
    $host = 'localhost:3305';
    $user = 'root';
    $pass = '222222';
    $dbName = 'museum';

    $mysqli = new mysqli($host, $user, $pass, $dbName);

    if ($mysqli->connect_error) {
        die('Ошибка подключения (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        if (isset($_POST['cbs']) && !empty($_POST['cbs'])) {
            $idsToDelete = implode(',', array_map('intval', $_POST['cbs']));
            $deleteQuery = "DELETE FROM ITEMS WHERE ID IN ($idsToDelete)";
            $deleteResult = $mysqli->query($deleteQuery);

            if ($deleteResult) {
                echo "Выбранные записи успешно удалены.";
            } else {
                echo "Ошибка при удалении записей: " . $mysqli->error;
            }
        } else {
            echo "Выберите записи для удаления.";
        }
    }

    $query = "SELECT * FROM ITEMS ORDER BY TITLE";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Сбой при доступе к БД: " . $mysqli->error);
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td><input type='checkbox' name='cbs[]' value='" . $row['TITLE'] . "'></td>
            <td>" . $row['TYPE'] . "</td>
            <td>" . $row['LOCATION'] . "</td>
            <td>" . $row['REL_DATE'] . "</td>
            <td>" . $row['DESCRIPTION'] . "</td>
            <td><img src='" . $row['IMAGE_PATH'] . "'></td>
        </tr>";
    }
    ?>
</table>