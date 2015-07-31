<?php
namespace PMVC\PlugIn\image;

class ImageCreate
{
    const gif='gif';
    const jpg='jpg';
    const png='png';

    function toGd(ImageFile $file=null)
    {
        $ext = $file->getExt(); 
        $path = $file->getPath();
        switch($ext){
        case self::gif:
           $gd_image = imagecreatefromgif($path);
            break;
        case self::jpg:
            $gd_image = imagecreatefromjpeg($path);
            break;
        case self::png:
            $gd_image = imagecreatefrompng($path);
            break;
        }
        return $gd_image;
    }
}
