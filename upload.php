<?php
//Fileupload
if(!empty($_FILES['mainFile'] and $_FILES['copyrightFile']['error'] == UPLOAD_ERR_OK)){
	$resultfilename = "resultImageTmp";
	
	  $file_name_main = $_FILES['mainFile']['name'];
	  $file_tmp_main =$_FILES['mainFile']['tmp_name'];
	  
	  $file_name_copyright = $_FILES['copyrightFile']['name'];
	  $file_tmp_copyright =$_FILES['copyrightFile']['tmp_name'];	  
	  
	  move_uploaded_file($file_tmp_main,"uploads/".$file_name_main);
	  move_uploaded_file($file_tmp_copyright,"uploads/".$file_name_copyright);

//calculate new size
$percent = 0.3;

$mainfilePath = "uploads/".$file_name_main;
$stampResize = "uploads/".$file_name_copyright;

$image = imagecreatefromjpeg("uploads/".$file_name_main);
$stamp = imagecreatefromjpeg("uploads/".$file_name_copyright);

list($width, $height) = getimagesize($stampResize);
$newwidth = $width * $percent;
$newheight = $height * $percent;

$thumb = imagecreatetruecolor($newwidth, $newheight);

imagecopyresized($thumb, $stamp, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

$x = imagesx($thumb);
$y = imagesy($thumb);

//Put watermark on image
imagecopymerge($image, $thumb, imagesx($image) - $x, imagesy($image) - $y, 0, 0, imagesx($thumb), imagesy($thumb), 50);

imagejpeg($image, 'uploads/'.$resultfilename.'.jpg');

unlink($mainfilePath);
unlink($stampResize);

$resultfilePath = "uploads/".$resultfilename.'jpg';
    
	echo '<div class="img-box">';
		echo '<img src="' . $resultImage . '" width="200" alt="' .  pathinfo($resultfilePath, PATHINFO_FILENAME) .'">';
		echo '<p><a href="download.php?file=' . urlencode($resultfilePath) . '">Download Image</a></p>';
	echo '</div>';

}

?>