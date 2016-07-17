<?php
namespace PMVC\PlugIn\image;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\image';

class image extends \PMVC\PlugIn
{
    public function getCenter(ImageSize $size, ImageSize $cut=null)
    {
        $aSize = $size->toArray();
        if (is_null($cut)){
            $cut = new ImageSize();
        }
        $aCut = $cut->toArray();
        $x = round($aSize['w'] / 2);
        $y = round($aSize['h'] / 2);
        $x -= round($aCut['w'] / 2);
        $y -= round($aCut['h'] / 2);
        return new Coord2D($x,$y);
    }

    public function getDistance(Coord2D $a, Coord2D $b)
    {
        $d = sqrt ( 
             pow(($b->x - $a->x),2) +
             pow(($b->y - $a->y),2)
        );
        return $d;
    }

    public function absAngle($angle)
    {
        if ($angle<0) {
            $angle = 360 + $angle;
        }
        return round($angle);
    }

    public function process (
        ImageSize $size,
        $params,
        $callback,
        $point = null
    ) {
        if (!($point instanceof Coord2D)) {
            $point = new Coord2D(0, 0);
        }
        array_unshift($params, '');
        for ( $xcoord = $point->x,
               $xend = $point->x + $size->w;
              $xcoord < $xend;
              $xcoord++
            ) {
            for ($ycoord = $point->y,
                  $yend = $point->y + $size->h;
                 $ycoord < $yend;
                 $ycoord++
                ) {
                $params[0] = new Coord2D($xcoord, $ycoord);
                call_user_func_array(
                    $callback,
                    $params
                );
            }
        }
    }

    public function getAngle(Coord2D $a, Coord2D $b)
    {
        $Opposite = $b->y - $a->y;
        $Adjacent = $b->x - $a->x;
        $Angle = rad2deg(atan2($Opposite,$Adjacent));
        if (!(0>=$Opposite && 0>=$Adjacent)
            && !(0<=$Opposite && 0<=$Adjacent)
           ) {
           $Angle+=180;
        }
        return $this->absAngle($Angle);
    }

    public function flot($flot){
        return sprintf("%' 9.6f",$flot);
    }

    /**
     * get geo point "a", angle "angle", and dis "m"
     * return geo point "b"
     */
    public function getPointByDistance(
        Coord2D $pa,
        $angle,
        $len
    ) {
        $angle = deg2rad($angle);
        $x2 = $len * $this->flot(cos($angle)) + $pa->x;
        $y2 = $len * $this->flot(sin($angle)) + $pa->y; 
        $pb = new Coord2D($x2,$y2);
        return $pb;
    }

    public function getImageCreator()
    {
        if (empty($this->_creator)) {
            $this->_creator = new ImageCreate(); 
        }
        return $this->_creator;
    }

    public function create($input)
    {
        if ($input instanceof ImageFile) {
            return $this->creator()->toGd($input);
        } elseif ($input instanceof ImageSize) {
            return $this->creator()->toGd(null, $input);
        } else {
            return !trigger_error('[Image:create] input only could accept file or size');
        }
    }

    public function toImage($f)
    {
        return new ImageFile($f);
    }

    public function isGd($gd)
    {
        return is_resource($gd) &&
            'gd'===get_resource_type($gd);
    }
}
