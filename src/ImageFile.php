<?php
namespace PMVC\PlugIn\image;

class ImageFile
{
    private $_path;
    public function __construct($file)
    {
       $this->_path = \PMVC\realpath($file); 
    }

    public function getExt()
    {
        $info = \PMVC\plug('image')
            ->getImageInfoObject();
        return $info->getExt($this); 
    }

    public function getSize()
    {
        $info = \PMVC\plug('image')
            ->getImageInfoObject();
        return $info->getSize($this); 
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function toGd()
    {
        $creator = \PMVC\plug('image')
            ->getImageCreator();
        return $creator->toGd($this); 
    } 
}
