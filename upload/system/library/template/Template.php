<?php


namespace System\Library\Template;

abstract class  Template{
    
    protected $data = array();
    
       /**
     * 
     * @param type $key
     * @param type $value
     * @return \System\Library\Template\Twig
     */
    public function set($key, $value) {
        $this->data[$key] = $value;

    }

	   
}