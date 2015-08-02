<?php
namespace PMVC\PlugIn\image;

class Region 
{
    public $per_w;
    public $per_h;
    public $lt;
    public $size;
    function __construct(
        CoordPoint $lt,
        CoordPoint $rt,
        CoordPoint $lb,
        ImageSize $newsize
    ) {
        $width =  $rt->x - $lt->x;
        $height =  $lb->y - $lt->y;
        $this->per_w = $width / $newsize->w;
        $this->per_h = $height / $newsize->h;
        $this->lt = $lt;
        $this->size = $newsize;
    }

    function getNewXY(CoordPoint $point)
    {
        $x = ($point->x - $this->lt->x) / $this->per_w; 
        $y = ($point->y - $this->lt->y) / $this->per_h; 
        $new =  new CoordPoint($this->flot($x),$this->flot($y));
        if ($this->inRegion($new)) {
            return $new;
        } else {
            return false;
        }
    }

    function flot($flot){
        return sprintf("%' 9.6f",$flot);
    }

    function inRegion(CoordPoint $point){
        return
            $point->x >= 0 &&
            $point->y >= 0 &&    
            $point->x <= $this->size->w &&
            $point->y <= $this->size->h;
    }
}
