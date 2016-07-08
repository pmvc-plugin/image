<?php
namespace PMVC\PlugIn\image;

class ImageFile
{
    private $_path;
    public function __construct($file)
    {
       $this->_path = \PMVC\realpath($file); 
       if (empty($this->_path)) {
            return trigger_error('[ImageFile] file not exists');
       }
    }

    public function getExt()
    {
        $info = \PMVC\plug('image')
            ->info();
        return $info->getExt($this); 
    }

    public function getSize()
    {
        $info = \PMVC\plug('image')
            ->info();
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
