<?php
include_once "zoomifyhelper.php";

// absolute system path to images dir
$imagepath = "/full/system/path/to/zoomify-image-php/images/";
$imageurl = "images/";

$zoomifyObject = new zoomify($imagepath);

// settings 
$zoomifyObject->_debug = 0; //set to 1 to see output
$zoomifyObject->_filegroup = "user"; // name of group to write files as

//probably won't have to change these
$zoomifyObject->_filemode = '664';
$zoomifyObject->_dirmode = '2775';


	if($_POST["action"] == "process") {
		echo "<p>Processing all files in $imagepath ...</p>";

		$zoomifyObject->processImages();

		echo "<p>Finished processing all files in $imagepath.</p>";
	}
?>

<h1>Zoomify Processor</h1>

<form action="example.php" method="post">

	<input type="hidden" value="process" name="action" />
	<input type="submit" value=" Begin Processing of Images >> " />

</form>

<h1>Zoomify Inspector</h1>
<p>Below is a list of converted images.  If there are none yet, you may need to convert them.

<hr>

<?php

$zoomifyObject->listZoomifiedImages($imageurl);
?>