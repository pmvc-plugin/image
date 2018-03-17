<?php
namespace PMVC\PlugIn\image;

use InvalidArgumentException;

class ImageOutput
{
    private $_im;
    
    public static function toGd($object)
    {
        return new ImageOutput($object->toGd());
    }

    public function __construct($im)
    {
        $this->_im = $im;
    }

    private function _toGd()
    {
        $gd = \PMVC\plug('image')->getGd($this->_im);
        if (empty($gd)) {
            throw new InvalidArgumentException(
                json_encode([
                    'ImageOutput' => 'Not a valid gd resource.',
                    'maybe' => $im
                ])
            );
        }
        return $gd;
    }

    private function _dumpPng()
    {
        header ('Content-type: image/png');
        imagepng($this->_toGd());
    }

    private function _savePng($f)
    {
        imagepng($this->_toGd(), $f);
        return $f;
    }

    public function save()
    {
        $tmp = \PMVC\plug('tmp')->file();
        return $this->_savePng($tmp);
    }

    public function dump()
    {
        ob_start();
        $this->_dumpPng();
        $output = ob_get_contents();
        ob_end_clean();
        unset($this->_im);
        echo $output;
        flush();
    }
}
