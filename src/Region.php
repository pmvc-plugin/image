<?php
namespace PMVC\PlugIn\image;

class Region
{
    private $per_w;
    private $per_h;
    private $lt;
    private $size;

    function __construct(
        Coord2D $lt,
        Coord2D $rt,
        Coord2D $lb,
        ImageSize $newsize
    ) {
        $width =  $rt->x - $lt->x;
        $height =  $lb->y - $lt->y;
        $this->per_w = $width / $newsize->w;
        $this->per_h = $height / $newsize->h;
        $this->lt = $lt;
        $this->size = $newsize;
    }

    function getNewXY(Coord2D $point, Coord2D $adjust=null)
    {
        $x = ($point->x - $this->lt->x) / $this->per_w; 
        $y = ($point->y - $this->lt->y) / $this->per_h; 
        $new =  new Coord2D($x, $y);
        if ($this->inRegion($new)) {
            if ($adjust) {
                $new->x = $new->x + $adjust->x;
                $new->y = $new->y + $adjust->y;
                $new->x = $this->fixRegion($new->x, $this->size->w);
                $new->y = $this->fixRegion($new->y, $this->size->h);
            }
            return $new;
        } else {
            return false;
        }
    }

    function fixRegion($num,$max)
    {
        if (0>$num) {
            $num = 0;
        } elseif ($num > $max) {
            $num = $max;
        }
        $num = \PMVC\plug('image')->fixedFloat($num);
        return $num;
    }

    function inRegion(Coord2D $point)
    {
        return
            $point->x >= 0 &&
            $point->y >= 0 &&    
            $point->x <= $this->size->w &&
            $point->y <= $this->size->h;
    }
}
