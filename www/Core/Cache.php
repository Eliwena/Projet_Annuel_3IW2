<?php

namespace App\Core;

class Cache
{
    protected $cache_path = _CACHE_PATH;
    protected $filename;
    protected $file_lifetime;
    protected $duration;

    public function __construct($duration = 60) {
        $this->setDuration($duration);
    }

    public function write($name, $data) {
        if(!_CACHE_ENABLED) { return false; }
        $this->setFilename($name);
        if(is_array($data)) {
            $data = serialize($data);
        }
        if(!file_exists(_CACHE_PATH)) {
           mkdir(_CACHE_PATH, 0777, true);
        }
        file_put_contents($this->getCachePath() . $this->getFilename(), $data);
        return true;
    }

    public function read($name) {
        if(!_CACHE_ENABLED) { return false; }
        $this->setFilename($name);
        $filepath = $this->getCachePath() . $this->getFilename();
        if($this->exist($name)) {
            $filecontent = file_get_contents($filepath);
            return $this->is_serial($filecontent) ? unserialize($filecontent) : $filecontent;
        }
        return false;
    }

    public function exist($name) {
        if(!_CACHE_ENABLED) { return false; }
        $this->setFilename($name);
        $filepath = $this->getCachePath() . $this->getFilename();

        if(file_exists($filepath)) {
            $this->setFileLifetime($filepath);
            if($this->getDuration() == '*' || $this->getFileLifetime() <= $this->getDuration()) {
                return true;
            }
        }

        return false;
    }

    public function clear($name = null) {
        if(is_null($name)) {
            //get all files in cache_path
            $files = glob($this->getCachePath() . '/*');
            foreach ($files as $file) {
                //delete all file
                unlink($file);
            }
            return true;
        } else {
            $this->setFilename($name);
            $filepath = $this->getCachePath() . $this->getFilename();
            if(file_exists($filepath)) {
                unlink($filepath);
                return true;
            }
        }
        return false;
    }

    //include file and create cache with content
    public function inc($file, $key = null) {
        $key = is_null($key) ? basename($file) : $key;
        if($content = $this->read($key)) {
            return $content;
        }
        ob_start();
        require $file;
        $content = ob_get_clean();
        return $this->write($key, $content);
    }

    //check if data cached is serialized
    private function is_serial($data) {
        return (@unserialize($data) !== false);
    }

    /**
     * @return string
     */
    public function getCachePath(): string
    {
        return $this->cache_path;
    }

    /**
     * @param string $cache_path
     * @return Cache
     */
    public function setCachePath(string $cache_path): Cache
    {
        $this->cache_path = $cache_path;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return Cache
     */
    public function setFilename($filename)
    {
        $this->filename = md5($filename) . '.cache';
        return $this;
    }

    /**
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param float $duration
     * @return Cache
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @return float
     */
    public function getFileLifetime()
    {
        return $this->file_lifetime;
    }

    /**
     * @param string $file
     * @return Cache
     */
    public function setFileLifetime($file)
    {
        $this->file_lifetime = (time() - filemtime($file)) / 60; //minute
        return $this;
    }

}