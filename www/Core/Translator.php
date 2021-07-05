<?php


namespace App\Core;

use App\Repository\WebsiteConfigurationRepository;
use App\Services\User\Security;

class Translator {


    /**
     * @var
     */
    protected $language;
    /**
     * @var
     */
    protected $filePath;


    /**
     * Translator constructor.
     */
    public function __construct() {
        $this->setLocale();
        $this->setFilePath();
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function trans($key) {
        $file = $this->getFileContent();
        if($file && array_key_exists($key, $file)) {
            return $file[$key];
        }
        return null;
    }

    /**
     * @param null $locale
     * @return $this
     */
    public function setLocale($locale = null) {
        if(is_null($locale)) {
            if(Security::isConnected()) {
                $user = Security::getUser();
                $this->language = $user->getCountry();
            } else {
                $this->language = WebsiteConfigurationRepository::getDefaultLocale();
            }
        } else {
            $this->language = $locale;
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function getLocale() {
        return $this->language;
    }

    /**
     * @param null $filePath
     * @return $this
     */
    public function setFilePath($filePath = null) {
        $this->filePath = is_null($filePath) ? _TRANSLATION_PATH . $this->getLocale() . '.yml' : _TRANSLATION_PATH . $filePath . '.yml';
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFilePath() {
        return $this->filePath;
    }

    /**
     * @return false|mixed
     */
    public function getFileContent() {
        if($this->languageFileExist($this->getLocale())) {
            $file = yaml_parse_file($this->getFilePath());
            return $file;
        }
        return false;
    }

    /**
     * @param $locale
     * @return bool
     */
    public function languageFileExist($locale) {
        if(file_exists(_TRANSLATION_PATH . $locale . '.yml')) {
            return true;
        }
        return false;
    }

}