<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $title = clearData($_GET['title']);
    $type = clearData($_GET['type']);
    $location = clearData($_GET['location']);
    $rel_date = clearData($_GET['rel_date']);
    $description = clearData($_GET['description']);
    $uploadlink = clearData($_GET['uploadlink']);
}
?>
<br>
&nbsp;&nbsp;&nbsp;<a href="index.php?page=edit">Редактировать</a>&nbsp;&nbsp;&nbsp;<a href="index.php?page=catalog">Каталог</a>
<br><br>
<table border="1" width="80%">
    <tr>
        <th width="20%" bgcolor="#8080ff">Название</th>
        <td colspan="2" width="40%" style="padding:0px 0px 0px 5px;"><?= $title ?></td>
        <td rowspan="10" width="100%"><img src="<?= $uploadlink ?>" ></td>
    </tr>
    <tr>
        <th width="15%" bgcolor="#8080ff">Тип</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $type ?></td>
    </tr>
    <tr>
        <th width="15%" bgcolor="#8080ff">Местоположение</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $location ?></td>
    </tr>
    <tr>
        <th width="15%" bgcolor="#8080ff">Год</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $rel_date ?></td>
    </tr>
    <tr>
        <th width="15%" bgcolor="#8080ff">Описание</th>
        <td colspan="2" style="padding:0px 0px 0px 5px;"><?= $description ?></td>
    </tr>
</table>
