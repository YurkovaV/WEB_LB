<!-- <button onclick="location.href='index.php?page=add';" style="margin-left:40px">Добавить</button>
<br><br> -->

<button onclick="location.href='index.php?page=add';" class="add_button" style="margin-left:900px;">Добавить</button>
<form method="POST" style="display: inline;">
    <input id="delete" type="submit" class="del_button" name="delete" value="Удалить" style="margin-left:10px;">
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
    $title = "";
    $type = "";
    $location = "";
    $rel_date = "";
    $description = "";
    $uploadlink = "";

    if (isset($_POST['delete']) && isset($_POST['cbs']))
    {
        unlink($_SESSION['Item']['uploadlink']);
        unset($_SESSION['Item']);
        header("Location: index.php?page=catalog");
    }

    if (!empty($_SESSION['Item']))
    {
        $title = $_SESSION['Item']['title'];
        $type = $_SESSION['Item']['type'];
        $location = $_SESSION['Item']['location'];
        $rel_date = $_SESSION['Item']['rel_date'];
        if (!empty($_SESSION['Item']['uploadlink']))
            $uploadlink = $_SESSION['Item']['uploadlink'];
        $description = $_SESSION['Item']['description'];
    }

    echo "<tr>
        <td>
           <form method='POST'>
           <input type='checkbox' name='cbs[]' value=$title />
        </td>
        <td><a href='index.php?page=item&title=$title&type=$type&location=$location&rel_date=$rel_date&description=$description&uploadlink=$uploadlink'>$title</a></td>
        <td>$type</td>
        <td>$location</td>
        <td>$rel_date</td>
        <td>$description</td></tr>
    </table></form>";
    ?>