<?php

namespace App\Core;

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
        if(file_exists("Views/templates/".$template.".tpl.php")){
            $this->template = "Views/templates/".$template.".tpl.php";
        }else{
            Helpers::error('Le template n\'existe pas');
        }
    }

    public function getTemplate() {
        return $this->template ?? null;
    }

    public function setView($view){
        if(file_exists("Views/".$view.".view.php")){
            $this->view = "Views/".$view.".view.php";
        }else{
            Helpers::error('La vue n\'existe pas');
        }
    }

    public function getView() {
        return $this->view;
    }

    public function assign($options){
        foreach ($options as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    public function __destruct(){
        extract($this->data);
        return is_null($this->getTemplate()) ? null : include($this->getTemplate());
    }

}








