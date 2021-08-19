<?php
//echo phpversion(); die;
	//ini_set("error_reporting", 1);
	ini_set('display_errors',1); 
    error_reporting(E_ALL);
    function filesize_formatted($file)
    {
        $bytes = filesize($file);
    
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return '1 byte';
        } else {
            return '0 bytes';
        }
    }
    
	function compress($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}
	
	if (isset($_POST['submit'])) {
		if ($_FILES["file"]["error"] > 0) 
		{
            $error = $_FILES["file"]["error"];
        }
        else if (($_FILES["file"]["type"] == "image/gif") ||
            ($_FILES["file"]["type"] == "image/jpeg") ||
            ($_FILES["file"]["type"] == "image/png") ||
            ($_FILES["file"]["type"] == "image/pjpeg")) 
		{
            $destination_url = 'uploads/demo.jpg';
			$source_img = $_FILES["file"]["tmp_name"];
			
			$fianl_file = compress($source_img, $destination_url, 50);
			$error = "<span style='color:green'>Image Compressed successfully.</span><span style='font-size:12px'> Click on image to download </span> ";
			$original_size=$_FILES["file"]["tmp_name"];
			$original_size = filesize_formatted($original_size);
			
        }else {
            $error = "Uploaded image should be jpg or gif or png";
        }
    }
?>
<html>
    <head>
        <title>Php code compress the image</title>
    </head>
    <body>
		<fieldset class="well">
			<legend>Upload Image:</legend>
			<form action="index.php" name="img_compress" id="img_compress" method="post" enctype="multipart/form-data">
				<ul>
					<li>
						<label>Upload:</label>
							<input type="file" name="file" id="file"/>
						</li>
					<li>
						<input type="submit" name="submit" id="submit" class="submit btn-success"/>
					</li>
				</ul>
			</form>
		</fieldset>
		<br><br><br>
		<center>
            <?php
                if($_POST){
					if ($error) {
            ?>
            <h3><?php echo $error; ?></h3>
            
            <a href="uploads/demo.jpg" download>
              <img src="uploads/demo.jpg" alt="W3Schools" width="300" height="200">
            </a>
            <?php if ($original_size) { ?>
            <h4>Original  : <?php echo"<span style='color:red'>".$original_size."</span> ";  ?></h4>
            <?php } ?>
            <h4>Resized  : <?php $file = "uploads/demo.jpg";  echo "<span style='color:gray'>".filesize_formatted($file). "</span> ";  ?></h4>
            <?php }} ?>
		</center>
    </body>
</html>