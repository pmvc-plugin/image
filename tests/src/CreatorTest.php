<?php
namespace PMVC\PlugIn\image;

use PMVC\TestCase;

class CreatorTest extends TestCase
{
    function testCreateFromFile()
    {
        $file = __DIR__.'/../resource/demo.jpg';
        $new = \PMVC\plug('image')->create($file);
        $this->assertTrue($new instanceof ImageFile);
        $this->assertEquals('jpg', $new->getExt());
    }

    function testCreateFromSize()
    {
        $pObj = \PMVC\plug('image');
        $size = new ImageSize(500, 500);
        $new = $pObj->create($size);
        $this->assertTrue($new instanceof ImageCanvas);
        $this->assertTrue($pObj->isGd($new->toGd()));
    }
}
