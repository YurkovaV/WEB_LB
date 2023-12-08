<title>Переворот строки и сортировка</title>
<body>
    <h3>Переворот строки и сортировка:</h3>
    <form method="post">
        <label for="string">Введите строку:</label>
        <input type="text" name="string" id="string">
        <button type="submit">Перевернуть и отсортировать</button>
    </form>

    <?php
    function reverseString($string) {
        $reversedString = '';
        for ($i = strlen($string) - 1; $i >= 0; $i--) {
            $reversedString .= $string[$i];
        }
        return $reversedString;
    }

    function customSort(&$array) {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array[$i] > $array[$j]) {
                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                }
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $string = $_POST['string'];
        $reversedString = reverseString($string);

        $array = str_split($reversedString);
        customSort($array);
        $sortedString = implode('', $array);

        echo '<p>Перевернутая строка: ' . $reversedString . '</p>';
        echo '<p>Отсортированная строка: ' . $sortedString . '</p>';
    }
    ?>
</body>
