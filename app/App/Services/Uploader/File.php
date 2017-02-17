<?php namespace App\Services\Uploader;


/**
 * Class File
 * @package App\Services\Uploader
 */
class File {

    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $path;
    /**
     * @var
     */
    private $extension;
    /**
     * @var
     */
    private $realName;
    /**
     * @var
     */
    private $realPath;
    /**
     * @var
     */
    private $size;
    /**
     * @var
     */
    private $mimetype;

    /**
     * @return string
     */
    public function getRealPath()
    {
        return $this->realPath;
    }

    /**
     * @param string $realPath
     */
    public function setRealPath($realPath)
    {
        $this->realPath = $realPath;
    }



    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @param string $mimetype
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $realName
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }


}