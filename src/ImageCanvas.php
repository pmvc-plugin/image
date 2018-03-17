<?php
namespace PMVC\PlugIn\image;

use InvalidArgumentException;
use PMVC\PlugIn\color\BaseColor;

class ImageCanvas 
{
    private $_size;
    protected $_gd;

    public function __construct($input)
    {
       if (!($input instanceof ImageSize)) {
           throw new InvalidArgumentException(
            json_encode([
                '[Image]'=>'input not a ImageSize',
                'input'=>$input
             ])
           );
       }
       $this->_size = $input;
    }

    public function getSize()
    {
        return $this->_size;
    }

    function toGd()
    {
       if (!$this->_gd) {
            $this->_gd = imagecreatetruecolor(
                $this->_size->w,
                $this->_size->h
            );
       }
       return $this->_gd; 
    }

    public function __destruct()
    {
        if (\PMVC\plug('image')->isGd($this->_gd)) {
            ImageDestroy($this->_gd);
            $this->_gd = null;
            unset($this->_gd);
        }
    }

    public function getPixel(Coord2D $point)
    {
        $rgb = imagecolorat(
            $this->toGd(),
            $point->x,
            $point->y
        );
        $red = ($rgb >> 16) & 0xff;
        $green = ($rgb >> 8) & 0xff;
        $blue = $rgb & 0xff;
        $color = \PMVC\plug('color');
        return $color->getColor($red, $green, $blue);
    }
        
    public function setPixel(Coord2D $point, BaseColor $color)
    {
        imagesetpixel(
            $this->toGd(),
            $point->x, $point->y,
            $color->toGd($this->toGd())
        );
    }
}
