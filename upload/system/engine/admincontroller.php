<?php

namespace System\Engine;

use System\Engine\AbstractController;

/**
 * @author Rodrigo Manara <me@rodrigomanara.co.uk>
 */
abstract class AdminController extends AbstractController {

    /**
     *
     * @var string 
     */
    protected $engine = null, $view = null;

    /**
     *
     * @var type 
     */
    private $data = array();

    /**
     * get List
     * @param array $data
     */
    protected function setList(array $data = array()) {

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * @throws Exception
     */
    public function view() {

        if (is_null($this->view)) {
            throw new Exception('view is not setup');
        } else {
            $view = $this->load->view($this->view, $this->data, $this->engine);
            // clean set some memroy free
            unset($this->data, $this->view, $this->engine);
            $this->response->setOutput($view);
        }
    }

}
