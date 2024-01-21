<?php
// Параметры подключения
$host = 'localhost:3305';
$user = 'root';
$pass = '222222';
$database = 'cafe';

// Создание соединения с базой данных
$link = new mysqli($host, $user, $pass, $database);

// Проверка соединения
if ($link->connect_error) {
    die("Ошибка подключения: " . $link->connect_error);
}

// Создание таблицы Dishes вместо Menu
$query = "CREATE TABLE IF NOT EXISTS Dishes (
    dish_id INT AUTO_INCREMENT PRIMARY KEY,
    dish_name VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    price DECIMAL(8, 2) NOT NULL
)";
$link->query($query) or die("Ошибка при создании таблицы Dishes: " . $link->error);

// Создание таблицы Customers
$query = "CREATE TABLE IF NOT EXISTS Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20)
)";
$link->query($query) or die("Ошибка при создании таблицы Customers: " . $link->error);

echo 'База данных успешно создана!</br></br>';
echo 'Структура базы данных:</br>';
getTableInfo($link);

// Изменение структуры таблицы Dishes
$query = "ALTER TABLE Dishes ADD is_vegetarian BOOLEAN DEFAULT FALSE";
$link->query($query) or die("Ошибка при изменении структуры таблицы Dishes: " . $link->error);

// Изменение структуры таблицы Customers
$query = "ALTER TABLE Customers DROP COLUMN phone";
$link->query($query) or die("Ошибка при изменении структуры таблицы Customers: " . $link->error);

echo '</br>Измененная структура базы данных:</br>';
getTableInfo($link);

// Заполнение таблиц данными
$query = "INSERT INTO Dishes (dish_name, category, price, is_vegetarian) VALUES 
    ('Паста Болоньезе', 'Горячие блюда', 250.00, FALSE),
    ('Салат Цезарь', 'Холодные закуски', 150.00, TRUE),
    ('Суп гороховый', 'Первые блюда', 100.00, TRUE)";
$link->query($query) or die("Ошибка при заполнении таблицы Dishes: " . $link->error);

$query = "INSERT INTO Customers (first_name, last_name, email) VALUES 
    ('Иван', 'Иванов', 'ivan@example.com'),
    ('Петр', 'Петров', 'petr@example.com')";
$link->query($query) or die("Ошибка при заполнении таблицы Customers: " . $link->error);

echo '</br>Таблицы успешно заполнены данными!</br>';
echo '</br>Содержимое таблиц:</br>';

getTableContent($link, 'SELECT * FROM Dishes');
// Вместо 'Customers' используем запрос для вывода содержимого таблицы Customers
getTableContent($link, 'SELECT * FROM Customers');

// Запрос №1
echo "</br>Запрос №1:</br>";
$query = "SELECT dish_name, price FROM Dishes WHERE is_vegetarian = TRUE";
getTableContent($link, $query);

// Запрос №2
echo "</br>Запрос №2:</br>";
$query = "SELECT first_name, last_name, email FROM Customers";
getTableContent($link, $query);

echo '</br>База данных успешно обработана!</br><br>';

// Закрытие соединения с базой данных
$link->close();

?>

<?php
// Функция для вывода структуры таблицы
function getTableInfo($link) {
    $result = $link->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $table = $row[0];
        echo "</br>Таблица $table:</br>";
        echo "<table border='1' width='60%'>
                <tr>
                    <th>Название поля</th>
                    <th>Тип данных</th>
                </tr>";
        $fields = $link->query("DESCRIBE $table");
        while ($field = $fields->fetch_assoc()) {
            echo "<tr>
                    <td>{$field['Field']}</td>
                    <td>{$field['Type']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}

// Функция для вывода содержимого таблицы или результата запроса
function getTableContent($link, $queryOrTable) {
    if (is_string($queryOrTable)) {
        $result = $link->query($queryOrTable) or die("Ошибка при выполнении запроса: " . $link->error);
    } else {
        $result = $link->query("SELECT * FROM $queryOrTable") or die("Ошибка при доступе к БД: " . $link->error);
    }

    $table = is_string($queryOrTable) ? "Результат запроса" : $queryOrTable;
    echo "</br>Таблица $table:</br><table border='1' width='60%'>
        <tr>
            <th width='30%'>Название поля</th>
            <th width='15%'>Тип данных</th>
            <th width='55%'>Значение</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $field => $value) {
            $fieldInfo = $result->fetch_field();
            echo "<tr>
                    <td>$field</td>
                    <td>" . ($fieldInfo ? $fieldInfo->type : '') . "</td>
                    <td>$value</td>
                  </tr>";
        }
    }
    echo "</table>";
}
?>