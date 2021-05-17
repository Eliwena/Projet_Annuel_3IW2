<?php

namespace App\Core;

class View
{

    private $template; // front ou back
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
            Framework::error('Le template n\'existe pas');
        }
    }

    public function getTemplate() {
        return $this->template ?? null;
    }

    public function setView($view){
        if(file_exists("Views/".$view.".view.php")){
            $this->view = "Views/".$view.".view.php";
        }else{
            Framework::error('La vue n\'existe pas');
        }
    }

    public function getView() {
        return $this->view;
    }

    //$view->assign("pseudo", $pseudo);
    public function assign($key, $value){
        $this->data[$key] = $value;
    }


    public function __destruct(){
        // $this->data = ["pseudo" => "Prof"] ------> $pseudo = "Prof";
        extract($this->data);
        return is_null($this->getTemplate()) ? null : include($this->getTemplate());
    }

}








