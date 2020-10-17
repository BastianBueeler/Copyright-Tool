<?php
//Is not file empty load picutres and save it
if(!empty($_FILES['mainFile'] and $_FILES['copyrightFile']['error'] == UPLOAD_ERR_OK)){
	$resultfilename = "resultImageTmp";
	
	  $file_name_main = $_FILES['mainFile']['name'];
	  $file_tmp_main =$_FILES['mainFile']['tmp_name'];
	  
	  $file_name_copyright = $_FILES['copyrightFile']['name'];
	  $file_tmp_copyright =$_FILES['copyrightFile']['tmp_name'];	  
	  
	  move_uploaded_file($file_tmp_main,"uploads/".$file_name_main);
	  move_uploaded_file($file_tmp_copyright,"uploads/".$file_name_copyright);

//new size
$percent = 0.3;

//load files from server 
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

//Get new image and view it
$resultfilePath = "uploads/".$resultfilename.'.jpg';

echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	echo '<div class="img-box px-5 d-flex ml-auto">';
		echo '<img src="' . $resultfilePath . '" width="200" alt="' .  pathinfo($resultfilePath, PATHINFO_FILENAME) .'">';
		echo '<p><a href="download.php?file=' . urlencode($resultfilePath) . '">Download Image</a></p>';
	echo '</div>';

}

?>