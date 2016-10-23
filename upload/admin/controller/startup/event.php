<?php

namespace Admin\Controller\Startup;


use System\Engine\AdminController as Controller;
use System\Library\Log;
use System\Engine\Action;

class Event extends Controller {

    /**
     * 
     */
    public function index() {
        // Add events from the DB
        $this->load->model('extension/event');

        $results = $this->model_extension_event->getEvents();

        foreach ($results as $result) {
            if ((substr($result['trigger'], 0, 6) == 'admin/') && $result['status']) {
                $this->event->register(substr($result['trigger'], 6), new Action($result['action'] , new \System\Library\Request()));
            }
        }
    }

}
