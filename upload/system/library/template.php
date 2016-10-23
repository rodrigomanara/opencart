<?php

namespace System\Library;


use System\Library\Template\Php;
use System\Library\Template\Twig;

class Template {

    private $adaptor;
    /**
     * 
     * @param type $adaptor
     * @throws \Exception
     */
    public function __construct($adaptor) {
        $class = ucfirst($adaptor);
        
        $ReflectionClass = new \ReflectionClass("System\\Library\\Template\\" .$class);
        
        if ($ReflectionClass) {
           return  $this->adaptor = new $ReflectionClass->name();
        } else {
            throw new \Exception('Error: Could not load template adaptor ' . $adaptor . '!');
        }
    }
    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function set($key, $value) {
        $this->adaptor->set($key, $value);
    }
    /**
     * 
     * @param type $template
     * @return type
     */
    public function render($template) {
        return $this->adaptor->render($template);
    }

}
