<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = clearData($_POST['login']);
    $password = clearData($_POST['password']);
    session_start();
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_login'] = $login;
    header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_REQUEST[session_name()])) {
    if (isset($_SESSION['user_login']) and $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) {
        return;
    } else {
        ?>
        <table align="center" style="margin-left:40px">
            <tr>
                <td>
                    <h3>Вход:</h3>
                    <form method="POST">
                        <p>Логин:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"
                                                                                              name="login"><br>
                        <p>Пароль:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password"><br>
                        <p><input type="submit"><br>
                    </form>
                </td>
            </tr>
        </table>
        <?php
    }
}
exit;
?>