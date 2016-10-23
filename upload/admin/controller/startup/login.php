<?php

namespace Admin\Controller\Startup;

use System\Engine\AdminController as Controller;
use System\Library\Cart\User;
use System\Engine\Action;
use System\Library\Request;

class Login extends Controller {

    public function index() {
        $route = isset($this->request->get['route']) ? $this->request->get['route'] : '';

        $ignore = array(
            'common/login',
            'common/forgotten',
            'common/reset'
        );

        // User
        $this->registry->set('user', new User($this->registry), new Request());

        if (!$this->user->isLogged() && !in_array($route, $ignore)) {
            return new Action('common/login');
        }

        if (isset($this->request->get['route'])) {
            $ignore = array(
                'common/login',
                'common/logout',
                'common/forgotten',
                'common/reset',
                'error/not_found',
                'error/permission'
            );

            if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
                return new Action('common/login', new Request());
            }
        } else {
            if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
                return new Action('common/login', new Request());
            }
        }
    }

}
