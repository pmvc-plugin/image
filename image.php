<?php
namespace PMVC\PlugIn\image;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\image';

class image extends \PMVC\PlugIn
{
    public function getCenter(ImageSize $size, ImageSize $cut = null)
    {
        $aSize = $size->toArray();
        if (is_null($cut)) {
            $cut = new ImageSize();
        }
        $aCut = $cut->toArray();
        $x = round($aSize['w'] / 2);
        $y = round($aSize['h'] / 2);
        $x -= round($aCut['w'] / 2);
        $y -= round($aCut['h'] / 2);
        return new Coord2D($x, $y);
    }

    public function getDistance(Coord2D $a, Coord2D $b)
    {
        $d = sqrt(pow($b->x - $a->x, 2) + pow($b->y - $a->y, 2));
        return $d;
    }

    public function absAngle($angle)
    {
        if ($angle < 0) {
            $angle = 360 + $angle;
        }
        return round($angle);
    }

    public function process(ImageSize $size, array $params, callable $callback, $startPoint = null, $moveSize = null)
    {
        if (!($startPoint instanceof Coord2D)) {
            $startPoint = new Coord2D(0, 0);
        }
        if (is_null($moveSize)) {
            $moveSize = new ImageSize(1, 1);
        }
        array_unshift($params, '');
        for (
            $xcoord = $startPoint->x, $xend = $startPoint->x + $size->w;
            $xcoord < $xend;
            $xcoord+=$moveSize->w
        ) {
            for (
                $ycoord = $startPoint->y, $yend = $startPoint->y + $size->h;
                $ycoord < $yend;
                $ycoord+=$moveSize->h
            ) {
                $params[0] = new Coord2D($xcoord, $ycoord);
                call_user_func_array($callback, $params);
            }
        }
    }

    public function getAngle(Coord2D $a, Coord2D $b)
    {
        $Opposite = $b->y - $a->y;
        $Adjacent = $b->x - $a->x;
        $Angle = rad2deg(atan2($Opposite, $Adjacent));
        if (
            !(0 >= $Opposite && 0 >= $Adjacent) &&
            !(0 <= $Opposite && 0 <= $Adjacent)
        ) {
            $Angle += 180;
        }
        return $this->absAngle($Angle);
    }

    public function fixedFloat($f)
    {
        return sprintf("%'9.6f", $f);
    }

    /**
     * get geo point "a", angle "angle", and dis "m"
     * return geo point "b"
     */
    public function getPointByDistance(Coord2D $pa, $angle, $len)
    {
        $angle = deg2rad($angle);
        $x2 = $len * $this->fixedFloat(cos($angle)) + $pa->x;
        $y2 = $len * $this->fixedFloat(sin($angle)) + $pa->y;
        $pb = new Coord2D($x2, $y2);
        return $pb;
    }

    public function create($input)
    {
        if (is_string($input) && is_file($input)) {
            return new ImageFile($input);
        } elseif ($input instanceof ImageSize) {
            return new ImageCanvas($input);
        } else {
            return !trigger_error(
                '[Image:create] input only could accept file or size'
            );
        }
    }

    public function isGd($maybeGd)
    {
        return (is_resource($maybeGd) &&
            'gd' === get_resource_type($maybeGd)) ||
            (is_object($maybeGd) && get_class($maybeGd) === 'GdImage');
    }

    public function getGd($maybeGd)
    {
        if ($this->isGd($maybeGd)) {
            return $maybeGd;
        } elseif (is_callable([$maybeGd, 'toGd'])) {
            return $maybeGd->toGd();
        } else {
            return false;
        }
    }

    public function getOutput($im)
    {
        return new ImageOutput($im);
    }
}
