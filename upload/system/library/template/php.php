<?php

namespace System\Library\Template;

use System\Library\Template\TemplateInterface;
use System\Library\Template\Template;

final class Php extends Template implements TemplateInterface {

    /**
     * 
     * @param type $template
     * @return type
     */
    public function render($template) {


        $file = DIR_TEMPLATE . $template . '.tpl';

        if (is_file($file)) {
            extract($this->data);

            ob_start();

            require($file);

            return ob_get_clean();
        }

        trigger_error('Error: Could not load template ' . $file . '!');
        exit();
    }

}
