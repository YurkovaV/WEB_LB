<!DOCTYPE html>
<html>
<head>
    <title>Проверка полей формы</title>
</head>
<body>
    <form method="POST">
    <table>
    <tr>
        <td><label for="name">Имя:</label></td>
        <td><input type="text" id="name" name="name" required></td>
    </tr>
    <tr>
        <td><label for="age">Возраст:</label></td>
        <td><input type="number" id="age" name="age" required></td>
    </tr>
    <tr>
        <td><label for="salary">Заработная плата:</label></td>
        <td><input type="number" id="salary" name="salary" required></td>
    </tr>
    <tr>
        <td><label for="amount">Сумма кредита:</label></td>
        <td><input type="number" id="amount" name="amount" required></td>
    </tr>
    <tr>
        <td><label for="term">Срок кредита (в месяцах):</label></td>
        <td><input type="number" id="term" name="term" required></td>
    </tr>
    <tr>
        <td><label for="rate">Процентная ставка:</label></td>
        <td><input type="number" id="rate" name="rate" required></td>
    </tr>
</table>

<input type="submit" name="submit" value="Проверить">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $age = isset($_POST['age']) ? $_POST['age'] : 0;
        $salary = isset($_POST['salary']) ? $_POST['salary'] : 0;
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 0;
        $term = isset($_POST['term']) ? $_POST['term'] : 0;
        $rate = isset($_POST['rate']) ? $_POST['rate'] : 0;

        if ($age < 18) {
            echo "Извините, вы должны быть старше 18 лет для получения кредита.";
            exit();
        }

        if ($salary < 0 || $amount < 0 || $term < 0 || $rate < 0) {
            echo "Извините, введены некорректные данные.";
            exit();
        }

        $total = $amount + ($amount * ($rate / 100));
        $monthly_payment = $total / $term;

        if ($salary >= $monthly_payment * 2) {
            echo "Поздравляем, {$name}, ваша заявка на кредит в размере {$amount} рублей на срок {$term} месяцев под {$rate}% одобрена!";
        } else {
            echo "Извините, {$name}, ваша заявка на кредит в размере {$amount} рублей на срок {$term} месяцев под {$rate}% отклонена. Ваша заработная плата не позволяет погасить кредит вовремя.";
        }
    }
    ?>
</body>
</html>