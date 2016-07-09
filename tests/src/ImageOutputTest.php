<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class ImageOutputTest extends PHPUnit_Framework_TestCase
{
    function testImageOutput()
    {
        $pImage = \PMVC\plug('image');
        $in = $pImage->create(new ImageSize('100','100'));
        $out = (new ImageOutput($in))->save();
        $imageFile = new ImageFile($out);
        $this->assertEquals('png',$imageFile->getExt());
    }
}
