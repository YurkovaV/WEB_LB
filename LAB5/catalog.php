<button onclick="location.href='index.php?page=add';" class="add_button" style="margin-left:900px;">Добавить</button>
<form method="POST" style="display: inline;">
    <input id="delete" type="submit" class="del_button" name="delete" value="Удалить" style="margin-left:10px;">
</form>
<form method="GET" action="catalog.php" style="display: inline;">
    <input type="text" name="search" placeholder="Поиск">
    <input type="submit" value="Искать">
</form>

<?php
$host = 'localhost:3306';
$user = 'root';
$pass = '222222';
$dbName = 'museum';

$mysqli = new mysqli($host, $user, $pass, $dbName);

// Функция для очистки входных данных пользователя
function sanitizeInput($input)
{
    return $input ? $input : '';
}

// Функция для формирования SQL-запроса для сортировки и поиска
function generateQuery($orderBy, $searchTerm, $mysqli)
{
    $query = "SELECT * FROM ITEMS";

    if ($searchTerm && mb_strlen($searchTerm) >= 2 && !preg_match('/^\d+$/', $searchTerm)) {
        // Разделяем поисковую строку на слова
        $searchWords = preg_split('/\s+/', $searchTerm);

        // Фильтруем слова, состоящие только из цифр
        $searchWords = array_filter($searchWords, function($word) {
            return !preg_match('/^\d+$/', $word);
        });

        // Если есть слова для поиска, добавляем их к запросу
        if (!empty($searchWords)) {
            $searchTerms = array_map(function($word) use ($mysqli) {
                return "TITLE LIKE '%" . $mysqli->real_escape_string($word) . "%' OR TYPE LIKE '%" . $mysqli->real_escape_string($word) . "%'";
            }, $searchWords);

            $query .= " WHERE " . implode(" OR ", $searchTerms);
        }
    }

    $query .= " ORDER BY $orderBy";

    return $query;
}

// Функция для отображения ссылок пагинации
function displayPagination($currentPage, $totalPages)
{
    echo "<div style='margin-top: 10px;'>Страницы: ";
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'active' : '';
        echo "<a class='$activeClass' href='index.php?page=catalog&sort=1&pageNum=$i'>$i</a> ";
    }
    echo "</div>";
}

// Обработка сортировки
$sort = isset($_GET['sort']) ? $_GET['sort'] : '1';
$sortColumns = [
    1 => 'TITLE',
    2 => 'TYPE',
    3 => 'LOCATION',
    4 => 'REL_DATE',
    5 => 'DESCRIPTION',
    6 => 'UPLOADLINK'
];
$orderBy = isset($sortColumns[$sort]) ? $sortColumns[$sort] : 'TITLE';

// Обработка пагинации
$recordsPerPage = 10;
$currentPage = isset($_GET['pageNum']) ? (int)$_GET['pageNum'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Обработка поиска
$searchTerm = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$query = generateQuery($orderBy, $searchTerm, $mysqli);
$query .= " LIMIT $offset, $recordsPerPage";

$result = $mysqli->query($query);

if (!$result) {
    die("Сбой при доступе к БД: " . $mysqli->error);
}

// Отображение заголовков таблицы
echo "<table class='data_table' border='1' style='margin-top: 20px;'>
    <tr>
        <th width='5%'></th>
        <th width='15%'><a href='index.php?page=catalog&sort=1'>Название</a></th>
        <th width='15%'><a href='index.php?page=catalog&sort=2'>Тип</a></th>
        <th width='15%'><a href='index.php?page=catalog&sort=3'>Местоположение</a></th>
        <th width='10%'><a href='index.php?page=catalog&sort=4'>Год</a></th>
        <th width='30%'><a href='index.php?page=catalog&sort=5'>Описание</a></th>
        <th width='10%'><a href='index.php?page=catalog&sort=6'>Изображение</a></th>
    </tr>";

// Отображение записей
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td><input type='checkbox' name='cbs[]'></td>
        <td>" . $row['TITLE'] . "</td>
        <td>" . $row['TYPE'] . "</td>
        <td>" . $row['LOCATION'] . "</td>
        <td>" . $row['REL_DATE'] . "</td>
        <td>" . $row['DESCRIPTION'] . "</td>
        <td><img src='" . $row['UPLOADLINK'] . "'></td>
    </tr>";
}

echo "</table>";

// Отображение ссылок пагинации
$query = generateQuery($orderBy, $searchTerm, $mysqli);
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM ($query) AS subquery";
$totalRecordsResult = $mysqli->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

displayPagination($currentPage, $totalPages);

$mysqli->close();
?>