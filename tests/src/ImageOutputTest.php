<?php
namespace PMVC\PlugIn\image;

use PMVC\TestCase;

class ImageOutputTest extends TestCase
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
