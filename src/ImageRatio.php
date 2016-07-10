<?php
namespace PMVC\PlugIn\image;

class ImageRatio
{
    public $newSize;
    public $origSize;
    public $maxSize;
    public $locForNewSize;
    public $locForSameSize;

    function __construct(ImageFile $file, ImageSize $dstSize)
    {
        $origSize = \PMVC\plug('image')
            ->info()
            ->getSize($file); 
        $this->newSize = clone $dstSize;
        $this->maxSize = clone $dstSize;
        $this->origSize = $origSize;
        if ($origSize->w > $origSize->h) {
            $this->locForNewSize = $this->fitX($this->newSize, $origSize);
            $this->fitX($this->maxSize, $origSize, true);
        } else {
            $this->locForNewSize = $this->fitY($this->newSize, $origSize);
            $this->fitY($this->maxSize, $origSize, true);
        }
        $same = new Coord2D(
            ($dstSize->w - $origSize->w) / 2,
            ($dstSize->h - $origSize->h) / 2
        ); 
        if ($same->x < 0) {
            if ($this->maxSize->w > $dstSize->w) {
                $same->x = -(($this->maxSize->w - $dstSize->w) / 2);
            } else {
                $same->x = 0;
            }
        }
        if ($same->y < 0) {
            if ($this->maxSize->h > $dstSize->h) {
                $same->y = -(($this->maxSize->h - $dstSize->h) / 2);
            } else {
                $same->y = 0;
            }
        }
        $this->locForSameSize = $same;
    }

    function fitX(ImageSize $newSize, ImageSize $origSize, $force=false)
    {
        $tempH = $newSize->w / ($origSize->w / $origSize->h);
        if ($tempH <= $newSize->h || $force) {
            $tempH = floor($tempH);
            $y = floor(($newSize->h - $tempH)/2);
            $newSize->h = $tempH;
            return new Coord2D(0, $y);
        } else {
            return $this->fitY($newSize, $origSize);
        }
    }

    function fitY(ImageSize $newSize, ImageSize $origSize, $force=false)
    {
        $tempW = $newSize->h * ($origSize->w / $origSize->h);
        if($tempW <= $newSize->w || $force){
            $tempW = floor($tempW);
            $x = floor(($newSize->w - $tempW)/2);
            $newSize->w = $tempW;
            return new Coord2D($x, 0);
        } else {
            return $this->fitX($newSize, $origSize);
        }
    }
}
