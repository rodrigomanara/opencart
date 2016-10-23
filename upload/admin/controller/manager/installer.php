<?php

namespace Admin\Controller\Manager;

use System\Engine\AdminController as Controller;

/**
 * @author Rodrigo Manara <me@rodrigomanara.co.uk>
 */
class Installer extends Controller {

    public function index() {
        $this->load->language('user/user');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('user/user');

        $this->getList();
    }

    public function getList() {

        $this->view = 'manager/installer';
        $this->engine = 'twig';
        
        $data = array();
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->setList($data);
        $this->view();
    }

    public function upload() {
        
    }

    public function decompress() {
        
    }

    public function finder() {
        
    }

}
