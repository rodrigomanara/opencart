<?php

namespace System\Library\Template;

use Twig_Loader_Filesystem;
use Twig_Environment;
use System\Library\Template\TemplateInterface;
use System\Library\Template\Template;
use Symfony\Component\Finder\Finder;

final class Twig extends Template implements TemplateInterface {

 
    
    /**
     * 
     * @param type $template
     * @return type
     */
    public function render($template) {
        
        $loader = new Twig_Loader_Filesystem(DIR_TEMPLATE);
        $twig = new Twig_Environment($loader, array(
            'cache' => DIR_CACHE,
            'debug' => true,
        ));
        
        return $twig->render($template . '.html.twig' , $this->data);
    }

}
