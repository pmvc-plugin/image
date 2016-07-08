<?php
namespace PMVC\PlugIn\image;

class ImageRatio
{
    public $newSize;
    public $origSize;
    public $locForSameSize;
    public $locForNewSize;

    function __construct(ImageFile $file, ImageSize $newSize)
    {
        $origSize = \PMVC\plug('image')
            ->info()
            ->getSize($file); 
        $this->newSize = $newSize;
        $this->origSize = $origSize;
        $this->locForSameSize = new Coord2D(
            ($newSize->w - $origSize->w) / 2,
            ($newSize->h - $origSize->h) / 2
        ); 
        if ($origSize->w > $origSize->h) {
            $this->locForNewSize = $this->fitX($newSize, $origSize);
        } else {
            $this->locForNewSize = $this->fitY($newSize, $origSize);
        }
    }

    function fitX(ImageSize $newSize, ImageSize $origSize)
    {
        $temp = $newSize->w / ($origSize->w / $origSize->h);
        if ($temp <= $newSize->w) {
            $temp = floor($temp);
            $y = floor(($newSize->h - $temp)/2);
            $newSize->h = $temp;
            return new Coord2D(0, $y);
        } else {
            return $this->fitY($newSize, $origSize);
        }
    }

    function fitY(ImageSize $newSize, ImageSize $origSize)
    {
        $temp = $newSize->h * ($origSize->w / $origSize->h);
        if($temp <= $newSize->h){
            $temp = floor($temp);
            $x = floor(($newSize->w - $temp)/2);
            $newSize->w = $temp;
            return new Coord2D($x, 0);
        } else {
            return $this->fitX($newSize, $origSize);
        }
    }
}
