<?php
namespace PMVC\PlugIn\image;

use InvalidArgumentException;

class ImageOutput
{
    protected $_gd;
    use TraitImageCanvas;

    public function __construct($im)
    {
        $this->_gd = $im;
    }

    protected function toGd()
    {
        $gd = \PMVC\plug('image')->getGd($this->_gd);
        if (empty($gd)) {
            throw new InvalidArgumentException(
                json_encode([
                    'ImageOutput' => 'Not a valid gd resource.',
                    'maybe' => $this->_gd
                ])
            );
        }
        return $gd;
    }

    private function _dumpPng()
    {
        header ('Content-type: image/png');
        imagepng($this->toGd());
    }

    private function _savePng($f)
    {
        imagepng($this->toGd(), $f);
        return $f;
    }

    public function save()
    {
        $tmp = \PMVC\plug('tmp')->file();
        return $this->_savePng($tmp);
    }

    public function dump()
    {
        $this->_dumpPng();
        flush();
    }
}
