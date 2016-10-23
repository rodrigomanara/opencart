<?php

namespace Admin\Controller\Event;

use System\Engine\AdminController as Controller;

class Theme extends Controller {

    public function index(&$view, &$data) {
        // This is only here for compatibility with old templates
        if (substr($view, -3) == 'tpl') {
            $view = substr($view, 0, -3);
        }
    }

}
