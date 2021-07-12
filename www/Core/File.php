<?php

namespace App\Core;

class File
{

    public function __construct() {}

    /**
     * @param $file
     * @param $data
     * @return bool
     * Create and write data into file
     */
    public function write($file, $data) {
        if(is_array($data)) {
            $data = serialize($data);
        }
        $this->create_dir($file);
        file_put_contents($file, $data);
        return true;
    }

    /**
     * @param $file
     * @param $data
     * @return bool
     * Append data to file
     */
    public function append($file, $data) {
        if($this->exist($file)) {
            $file = fopen($file, "a");
            fwrite($file, "\n". $data);
            fclose($file);
            return true;
        }
        return $this->write($file, $data);
    }

    /**
     * @param $file
     * @return false|mixed|string
     * read data from file
     */
    public function read($file) {
        if($this->exist($file)) {
            $file_content = file_get_contents($file);
            return $this->is_serial($file_content) ? unserialize($file_content) : $file_content;
        }
        return false;
    }

    /**
     * @param $file
     * @return bool
     * check if file exist
     */
    public function exist($file) {
        if(file_exists($file)) {
            return true;
        }
        return false;
    }

    /**
     * @param $file
     * @return bool
     * delete file
     */
    public function remove($file) {
        if($this->exist($file)) {
            unlink($file);
            return true;
        }
        return false;
    }

    //check if data is serialized

    /**
     * @param $data
     * @return bool
     * check if data is serialized
     */
    private function is_serial($data) {
        return (@unserialize($data) !== false);
    }

    /**
     * @param $file
     * @return bool
     * create file directory if not exist
     */
    private function create_dir($file) {
        $dir = dirname($file);
        if(!file_exists($file)) {
            mkdir($dir, 0777, true);
            return true;
        }
        return false;
    }

}