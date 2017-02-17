<?php namespace App\Services\Uploader;

use Input;
use Str;
use Carbon\Carbon;
use File as FileSystem;
use App\Services\Uploader\File;

/**
 * Class Upload
 * @package Telecable\Services\Uploader
 */
class Upload {

    /**
     * @var null|File
     */
    private $file = null;

    /**
     * @var string
     */
    private $path = 'uploads';

    /**
     * @var Object
     */
    private $fileUploaded;

    /**
     * @var string
     */
    private $fileName = '';

    /**
     *
     */
    public function __construct()
    {
        $this->file = new File;
        // TODO implementar service provider para la inyeccion de dependencias
    }

    /**
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     *
     */
    protected function process()
    {
        if(Input::hasFile($this->fileName))
        {
            $path = $this->buildPath() . DIRECTORY_SEPARATOR;
            $file = $this->buildName();

            $this->file->setName($file);
            $this->file->setPath($this->path . DIRECTORY_SEPARATOR);
            $this->file->setRealPath($path);
            $this->file->setExtension($this->fileUploaded->getClientOriginalExtension());
            $this->file->setRealName($this->fileUploaded->getClientOriginalName());
            $this->file->setSize($this->fileUploaded->getSize());
            $this->file->setMimeType($this->fileUploaded->getMimeType());

            $this->fileUploaded->move($path, $file);
        }
    }


    /**
     * @param $fileName
     * @return null|File
     */
    public function save($fileName)
    {
        $this->fileName = $fileName;
        $this->fileUploaded = Input::file($this->fileName);
        $this->process();

        return $this->file;
    }

    /**
     * @return string
     */
    protected function buildName()
    {
        $filename = Str::random(32) . '-' . time() . '.' .$this->fileUploaded->getClientOriginalExtension();

        return $filename;
    }

    /**
     * @return string
     */
    protected function buildPath()
    {
        $date = Carbon::now();
        $year = $date->year;
        $month =$date->month;

        $directories = array($this->path, $year, $month);
        $realPath = public_path();
        $path = '';

        for($i = 0, $l = count($directories); $i < $l; $i++)
        {
            $path .= DIRECTORY_SEPARATOR . $directories[$i];
            $realPath .= DIRECTORY_SEPARATOR . $directories[$i];

            if ( ! FileSystem::exists($realPath))
            {
                $this->createDir($realPath);
            }

            $this->createIndex($realPath);
        }

        $this->setPath($path);

        return $realPath;
    }


    /**
     * @param $path
     */
    protected function createIndex($path)
    {
        $indexFile = $path . DIRECTORY_SEPARATOR . 'index.html';

        if ( ! FileSystem::exists($indexFile))
        {
            FileSystem::put($indexFile, '');
        }
    }

    /**
     * @param $path
     * @throws Exception
     */
    protected function createDir($path)
    {
        $dir_was_created = FileSystem::makeDirectory($path, 755);

        if( ! $dir_was_created )
        {
            throw new Exception('El directorio : ' . $path . ' no pudo ser creado');
        }
    }
}