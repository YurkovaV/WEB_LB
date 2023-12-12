<?php
	function getMenu($menu, $vertical=true)
	{
		$style = "";
		if(!$vertical)
		{
			$style = "display:inline";
		}
		echo '<ul style="list-style-type:none">';
			foreach ($menu as $link=>$href)
			{
				echo "<li style='$style'><a href=\"$href\">", $link, '</a></li>';
			}
		
		echo '</ul>';
	}

	function clearData($data)
	{
		return trim(strip_tags($data));
	}

	function imageCheck()
	{
		if ($_FILES['uploadfile']['type'] == "image/jpeg")
		{
			if ($_FILES['uploadfile']['size']<=1024000)
				return 1;
			else
				return "Размер файла не должен превышать 1000Кб";
		}
		else
			return "Файл должен иметь jpeg-расширение";
	}

	function resize($file)
    {
        global $tmp_path;
        $max_size = 250;
        $src = imagecreatefromjpeg($file['tmp_name']);
        $w_src = imagesx($src);
        $h_src = imagesy($src);
        if ($w_src > $max_size)
        {
            $ratio = $w_src/$max_size;
            $w_dest = round($w_src/$ratio);
            $h_dest = round($h_src/$ratio);
            $dest = imagecreatetruecolor($w_dest, $h_dest);
            imagecopyresampled($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
            imagejpeg($dest, $tmp_path . $file['name']);
            imagedestroy($dest);
            imagedestroy($src);
            return $file['name'];
        }
        else
        {
            imagejpeg($src, $tmp_path . $file['name']);
            imagedestroy($src);
            return $file['name'];
        }
    }
?>