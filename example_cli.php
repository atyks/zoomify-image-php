<?php
    set_time_limit(0);
    include_once "zoomifyhelper.php";

    // absolute system path to images dir
    $imagepath = "/full/system/path/to/zoomify-image-php/images/";

    $zoomifyObject = new zoomify($imagepath);

    // settings
    $zoomifyObject->_debug = 0; //set to 1 to see output
    $zoomifyObject->_filegroup = "user"; // name of group to write files as

    //probably won't have to change these
    $zoomifyObject->_filemode = '664';
    $zoomifyObject->_dirmode = '2775';
    $zoomifyObject->processImages();
