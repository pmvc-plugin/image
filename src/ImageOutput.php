<?php
namespace PMVC\PlugIn\image;

use InvalidArgumentException;

class ImageOutput
{
    private $_gd;
    
    public static function toGd($object)
    {
        return new ImageOutput($object->toGd());
    }

    public function __construct($im)
    {
        if (\PMVC\plug('image')->isGd($im)) {
            $this->_gd = $im;
        } elseif (is_callable([$im, 'toGd'])) {
            $this->_gd = $im->toGd();
        } else {
            throw new InvalidArgumentException('[ImageOutput] Not a valid gd resource.');
        }
    }

    public function dumpPng()
    {
        header ('Content-type: image/png');
        imagepng($this->_gd);
    }

    public function savePng($f)
    {
        imagepng($this->_gd, $f);
        return $f;
    }

    public function save()
    {
        $tmp = \PMVC\plug('tmp')->file();
        return $this->savePng($tmp);
    }

    public function dump()
    {
        ob_start();
        $this->dumpPng();
        $output = ob_get_contents();
        ob_end_clean();
        imagedestroy($this->_gd);
        echo $output;
        flush();
    }
}
