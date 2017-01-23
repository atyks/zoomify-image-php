<?php

/****************************************************************************************
Class Name: zoomify

Author: Justin Henry, http://greengaloshes.cc

Purpose: This class contains methods to support the use of the ZoomifyFileProcessor
class.  The ZoomifyFileProcessor class is a port of the ZoomifyImage python script to a
PHP class.  The original python script was written by Adam Smith, and was ported to
PHP (in the form of ZoomifyFileProcessor) by Wes Wright.

Both tools do the about same thing - that is, they convert images into a format
that can be used by the "zoomify" image viewer.

This class provides an interface for performing "batch" conversions using the
ZoomifyFileProcessor class.  It also provides methods for inspecting resulting
processed images.

****************************************************************************************/

require_once("ZoomifyFileProcessor.php");

class zoomify
{
    public $_debug ;
    public $_filemode ;
    public $_dirmode ;
    public $_filegroup ;
    public $_imagepath ;

    //*****************************************************************************
    // constructor
    // initialize process, set class vars
    public function zoomify($imagepath)
    {
        $this->_imagepath = $imagepath;
    }

    //*****************************************************************************
    //takes path to a directory
    //prints list of links to a zoomified image
    public function listZoomifiedImages($dir)
    {
        if ($dh = @opendir($dir)) {
            while (false !== ($filename = readdir($dh))) {
                if (($filename != ".") && ($filename != "..") && (is_dir($dir.$filename."/"))) {
                    echo "<a href=\"viewer.php?file=" . $filename . "&path=" . $dir ."\">$filename</a><br>\n";
                }
            }
        } else {
            return false;
        }
    }

    //*****************************************************************************
    //takes path to a directory
    //returns an array containing each entry in the directory
    public function getDirList($dir)
    {
        if ($dh = @opendir($dir)) {
            while (false !== ($filename = readdir($dh))) {
                if (($filename != ".") && ($filename != "..")) {
                    $filelist[] = $filename;
                }
            }

            sort($filelist);

            return $filelist;
        } else {
            return false;
        }
    }

    //*****************************************************************************
    //takes path to a directory
    //returns an array w/ every file in the directory that is not a dir
    public function getImageList($dir)
    {
        $filelist = array();
        if ($dh = @opendir($dir)) {
            while (false !== ($filename = readdir($dh))) {
                if (($filename != ".") && ($filename != "..") && (!is_dir($dir.$filename."/"))) {
                    if(exif_imagetype($dir . "/" . $filename) != IMAGETYPE_JPEG) {
                        continue;
                    }

                    $filelist[] = $filename;
                }
            }

            sort($filelist);

            return $filelist;
        } else {
            return false;
        }
    }

    //*****************************************************************************
    // run the zoomify converter on the specified file.
    // check to be sure the file hasn't been converted already
    // set the perms appropriately
    public function zoomifyObject($filename, $path)
    {
        $converter = new ZoomifyFileProcessor();
        $converter->_debug = $this->_debug;
        $converter->_filemode = octdec($this->_filemode);
        $converter->_dirmode = octdec($this->_dirmode);
        $converter->_filegroup = $this->_filegroup;

        $trimmedFilename = pathinfo($filename, PATHINFO_FILENAME);

        if (!file_exists($path . $trimmedFilename)) {
            $converter->ZoomifyProcess($path . $filename);
        }
    }

    //*****************************************************************************
    // list the specified directory
    public function processImages()
    {
        $objects = $this->getImageList($this->_imagepath);

        if($objects !== false) {
            foreach ($objects as $object) {
                $this->zoomifyObject($object, $this->_imagepath);
            }
        }
        else {
            return(false);
        }
    }
}
