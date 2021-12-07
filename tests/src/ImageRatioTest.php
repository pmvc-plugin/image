<?php
namespace PMVC\PlugIn\image;

use PMVC\TestCase;

class ImageRatioTest extends TestCase
{
    function testImageRatio()
    {
        $newW = 1000;
        $newH = 1000;
        $inputFile = new ImageFile(__DIR__.'/../resource/demo.jpg');
        $ratio = new ImageRatio(
            $inputFile->getSize(),
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
