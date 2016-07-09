<?php
namespace PMVC\PlugIn\image;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\ImageCreate';

class ImageCreate
{
    const gif='gif';
    const jpg='jpg';
    const png='png';

    function __invoke()
    {
        return $this;
    }

    function toGd(ImageFile $file = null, ImageSize $size = null)
    {
        if (is_null($file)) {
            if (is_null($size)) {
                return !trigger_error('[ImageCreate] Need defined size for empty image');
            }
            return imagecreatetruecolor($size->w, $size->h);
        }
        $ext = $file->getExt(); 
        $path = $file->getPath();
        switch($ext){
        case self::gif:
            $gdImage = imagecreatefromgif($path);
            break;
        case self::jpg:
            $gdImage = imagecreatefromjpeg($path);
            break;
        case self::png:
            $gdImage = imagecreatefrompng($path);
            break;
        }
        return $gdImage;
    }
}
