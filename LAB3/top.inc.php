<?php
session_start();
?>
<div class="top">Основной каталог</div>
<table >
	<tr>
		<td colspan="2" class="top_left"> 
		<?php
		if (!empty($_SESSION['user_login']))
			echo "С возвращением, <b>{$_SESSION['user_login']}</b> <a href='index.php?logout=true'>(Выход)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		?>
		</td>
	</tr>
</table>