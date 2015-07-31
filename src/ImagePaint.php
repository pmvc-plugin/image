<?php
namespace PMVC\PlugIn\image;
use PMVC\PlugIn\color\BaseColor;

class ImagePaint
{
    private $im = null;
        
    public function __construct(ImageSize $size=null)
    {
        if (!empty($size)) {
            $this->im = imagecreatetruecolor($size->w, $size->h);
        }
    }

    public function __destruct()
    {
        imagedestroy($this->im);
        $this->im = null;
    }

    public function setImage(ImageFile $im)
    {
        $this->im = $im->toGd();
    }
        
    public function getPixel(CoordPoint $point)
    {
        $rgb = imagecolorat($this->im, $point->x, $point->y);
        $red = ($rgb >> 16) & 0xff;
        $green = ($rgb >> 8) & 0xff;
        $blue = $rgb & 0xff;
        return new BaseColor($red, $green, $blue);
    }
        
    public function setPixel(CoordPoint $point, BaseColor $color)
    {
        imagesetpixel($this->im, $point->x, $point->y, $color->toGd($this->im));
    }
        
    public function fillRect(CoordPoint $point, ImageSize $size, BaseColor $color)
    {
        imagefilledrectangle(
            $this->im,
            $point->x,
            $point->y,
            $point->x + $size->w,
            $point->y + $size->h,
            $color->toGd($this->im)
        );
    }

    public function fillCircle(CoordPoint $point, $radius, BaseColor $color)
    {
        imagefilledellipse(
            $this->im, 
            $point->x, 
            $point->y, 
            $radius * 2, 
            $radius * 2, 
            $color->toGd($this->im)
        );
    }
        
    public function overlayPixel(CoordPoint $point, BaseColor $color, $alpha)
    {
        $existing = $this->getPixel($point);
        $newColor = $color->getClone()->setAlpha($existing,$alpha);
        $this->setPixel($point, $newColor);
    }

    public function overlayRect(CoordPoint $point, ImageSize $size, BaseColor $color, $alpha)
    {
        for ($xcoord = $point->x; $xcoord < $point->x + $size->w; $xcoord++) {
            for ($ycoord = $point->y; $ycoord < $point->y + $size->h; $ycoord++) {
                $this->overlayPixel(new CoordPoint($xcoord, $ycoord), $color, $alpha);
            }
        }
    }
        
    public function outputPNG()
    {
        imagepng($this->im);
    }
}
