<?php
namespace PMVC\PlugIn\image;

class ImageRatio
{
    public $dstSize;
    public $maxSize;
    public $newSize;
    public $origSize;
    public $locForMaxSize;
    public $locForNewSize;
    public $locForOrigSize;

    function __construct(ImageSize $origSize, ImageSize $dstSize)
    {
        $this->newSize = clone $dstSize;
        $this->maxSize = clone $dstSize;
        $this->dstSize = $dstSize;
        $this->origSize = $origSize;
        if ($origSize->w > $origSize->h) {
            $this->locForNewSize = $this->fitX($this->newSize, $origSize);
            $this->fitX($this->maxSize, $origSize, true);
        } else {
            $this->locForNewSize = $this->fitY($this->newSize, $origSize);
            $this->fitY($this->maxSize, $origSize, true);
        }
        $this->locForMaxSize = $this->getLocForSame($dstSize, $this->maxSize, $this->maxSize);
        $this->locForOrigSize = $this->getLocForSame($dstSize, $origSize, $this->maxSize);
    }

    function getLocForSame(ImageSize $dstSize, ImageSize $origSize, ImageSize $maxSize)
    {
        $same = new Coord2D(
            ($dstSize->w - $origSize->w) / 2,
            ($dstSize->h - $origSize->h) / 2
        ); 
        if ($same->x < 0) {
            if ($maxSize->w > $dstSize->w) {
                $same->x = -(($maxSize->w - $dstSize->w) / 2);
            } else {
                $same->x = 0;
            }
        }
        if ($same->y < 0) {
            if ($maxSize->h > $dstSize->h) {
                $same->y = -(($maxSize->h - $dstSize->h) / 2);
            } else {
                $same->y = 0;
            }
        }
        return $same;
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
