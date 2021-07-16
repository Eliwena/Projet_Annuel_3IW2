<?php


namespace App\Core;

use App\Repository\WebsiteConfigurationRepository;
use App\Services\Http\Session;
use App\Services\User\Security;
use \App\Services\Http\Cache;

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
    public function trans($key, array $options = null) {
        $file = $this->getContent();

        if($file && array_key_exists($key, $file)) {

            //si option %name% %2 %3 renommé par le contenu de option
            if($options && is_array($options)) {
                preg_match_all('/%\S+%/', $file[$key], $vars);
                foreach ($vars[0] as $var) {
                    $index = str_replace('%', '', $var);
                    if(array_key_exists($index, $options)) {
                        $file[$key] = str_replace($var, $options[$index], $file[$key]);
                    }
                }
            }
            return $file[$key];
        }
        return $key;
    }

    /**
     * @param null $locale
     * @return $this
     */
    public function setLocale($locale = _TRANSLATION_DEFAULT_LOCALE) {
        if(is_null($locale) && ConstantManager::envExist()) {
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
    public function getContent() {
        if(Cache::exist('__translator')) {
            return Cache::read('__translator');
        }
        if($this->languageFileExist($this->getLocale())) {
            try {
                $file = yaml_parse_file($this->getFilePath());
                Cache::write('__translator', $file);
            } catch (\Exception $translatorException) {
                Helpers::error('Erreur traduction : <b>' . $this->getLocale() . '.yml</b> ' . $translatorException->getMessage());
            }

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