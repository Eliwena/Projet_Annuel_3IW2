<?php

namespace App\Services\File;

use App\Core\File;

class FileManager {

    /**
     * @param $file
     * @param $data
     * @return bool
     * Create and write data into file
     */
    public static function write($file, $data) {
        $fileCore = new File();
        return $fileCore->write($file, $data);
    }

    /**
     * @param $file
     * @param $data
     * @return bool
     * Append data to file
     */
    public static function append($file, $data) {
        $fileCore = new File();
        return $fileCore->append($file, $data);
    }

    /**
     * @param $file
     * @return false|mixed|string
     * read data from file
     */
    public static function read($file) {
        $fileCore = new File();
        return $fileCore->read($file);
    }

    /**
     * @param $file
     * @return bool
     * check if file exist
     */
    public static function exist($file) {
        $fileCore = new File();
        return $fileCore->exist($file);
    }

    /**
     * @param $file
     * @return bool
     * delete file
     */
    public static function remove($file) {
        $fileCore = new File();
        return $fileCore->remove($file);
    }
}