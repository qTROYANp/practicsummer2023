<?
    $filename='../../'.$_POST['filename'];


	if(file_exists($filename))
	{

        unlink($filename);

	}
    else
    {
        $json['error']="Файл не найден!";
    }

    echo json_encode($json);

?>
