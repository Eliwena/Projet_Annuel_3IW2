<?php

namespace App\Core;

use App\Services\User\Security;

class View
{

    private $template = 'front'; // front ou back
    private $view; // home, 404, user, users, ....
    private $data = [];

    public function __construct($view, $template = "front"){
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function setTemplate($template){
        if(file_exists(_VIEW_PATH . 'templates/'.$template.".tpl.php")){
            $this->template = _VIEW_PATH . 'templates/'.$template.'.tpl.php';
        }else{
            Helpers::error('Le template n\'existe pas');
        }
    }

    public function getTemplate() {
        return $this->template ?? null;
    }

    public function setView($view){
        if(file_exists(_VIEW_PATH.$view.".view.php")){
            $this->view = _VIEW_PATH.$view.".view.php";
        }else{
            Helpers::error('La vue <b>' . $view . '</b> n\'existe pas');
        }
    }

    public function getView() {
        return $this->view;
    }

    public function getContent() {
        ob_start();
        extract($this->data);
        include $this->getTemplate();
        return ob_get_clean();
    }

    public function include($file, $is_template = true){
        if(file_exists(_VIEW_PATH . ($is_template ? 'templates/' : '') . $file . ".php")){
            include(_VIEW_PATH . ($is_template ? 'templates/' : '') . $file . ".php");
        }else{
            Helpers::error($file . 'not found');
        }
    }

    public function assign($options){
        if($options) {
            foreach ($options as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }

    public function __destruct(){
        Security::isConnected() ? $this->assign(['_user' => Security::getUser()]) : $this->assign(['_user' => null]);
        extract($this->data);
        return is_null($this->getTemplate()) ? null : include($this->getTemplate());
    }

}








