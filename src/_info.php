<?php
namespace PMVC\PlugIn\image;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ImageInfo';

class ImageInfo
{
    private $_images_info = array();

    function __invoke()
    {
        return $this;
    }

    function get(ImageFile $file)
    {
        $path = $file->getPath();
        if (empty($this->_images_info[$path])) {
            $this->_images_info[$path] = 
                getimagesize($path);
        }
        return $this->_images_info[$path];
    }

    function getExt(ImageFile $file)
    {
        $image = $this->get($file);
        $type = ImageExt::$types[$image[2]];
        return $type;
    }

    function getSize(ImageFile $file)
    {
        $image = $this->get($file);
        return new ImageSize($image[0],$image[1]); 
    }
}

class ImageExt
{
    public static $types = array(
        1 => 'gif'
        ,2 => 'jpg'
        ,3 => 'png'
        ,4 => 'swf'
        ,5 => 'psd'
        ,6 => 'bmp'
        ,7 => 'tif' //(intel byte order)
        ,8 => 'tif' //(motorola byte order)
        ,9 => 'jpc'
        ,10 => 'jp2'
        ,11 => 'jpx'
        ,12 => 'jb2'
        ,13 => 'swc'
        ,14 => 'iff'
        ,15 => 'wbmp'
        ,16 => 'xbm'
    );
}
