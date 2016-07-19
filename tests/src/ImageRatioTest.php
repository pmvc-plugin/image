<?php
namespace PMVC\PlugIn\image;

use PHPUnit_Framework_TestCase;

class ImageRatioTest extends PHPUnit_Framework_TestCase
{
    function testImageRatio()
    {
        $newW = 1000;
        $newH = 1000;
        $ratio = new ImageRatio(
            new ImageFile(__DIR__.'/../resource/demo.jpg'),
            new ImageSize($newW, $newH)
        );
        $this->assertEquals(
            $newW,
            $ratio->newSize->w + $ratio->locForNewSize->x*2
        );
        $this->assertEquals(
            $newH,
            $ratio->newSize->h + $ratio->locForNewSize->y*2
        );
        $this->assertEquals(
            $newW,
            $ratio->origSize->w + $ratio->locForOrigSize->x*2
        );
        $this->assertEquals(
            $newH,
            $ratio->origSize->h + $ratio->locForOrigSize->y*2
        );
        $this->assertTrue($ratio->newSize->w <= $newW);
        $this->assertTrue($ratio->newSize->h <= $newH);
    }
}
