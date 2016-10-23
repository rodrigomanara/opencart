<?php

class ControllerShippingByValueSpent extends Controller {

    private $error = array();

    /**
     * 
     * @return type
     */
    private function setUp() {


        $array = array();
        if (isset($this->request->post['ByValueSpent_'])) {

            foreach ($this->request->post['ByValueSpent_'] as $set) {

                foreach ($set['subTotal']['min'] as $key => $value) {
                    $array[$key]['subTotal']['min'] = $value;
                }
                foreach ($set['subTotal']['max'] as $key => $value) {
                    $array[$key]['subTotal']['max'] = $value;
                }
                foreach ($set['cost']['value'] as $key => $value) {
                    $array[$key]['cost']['value'] = $value;
                }
                foreach ($set['cost']['title'] as $key => $value) {
                    $array[$key]['cost']['title'] = $value;
                }
            }
        }
        $this->request->post['ByValueSpent_'] = json_encode($array);
    }

    public function index() {

        $this->language->load('shipping/ByValueSpent');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            //set up custom form 
            $this->setUp();

            $this->model_setting_setting->editSetting('ByValueSpent', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            //$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->request->post['ByValueSpent_sort_order'])) {
            $data['ByValueSpent_sort_order'] = $this->request->post['ByValueSpent_sort_order'];
        } else {
            $data['ByValueSpent_sort_order'] = $this->config->get('ByValueSpent_sort_order');
        }


        $data['heading_title'] = $this->language->get('heading_title');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');


        /*         * ***default form get values */
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_add_new_rule'] = $this->language->get('text_add_new_rule');
        $data['text_none'] = $this->language->get('text_none');

        /*         * ***Default to any function */
        $data['entry_cost'] = $this->language->get('entry_cost');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');

        /*         * ***helo */
        $data['text_help'] = $this->language->get('text_help');

        /*         * ***Title form */
        $data['text_header_rule'] = $this->language->get('text_header_rule');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_shipping'),
            'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('shipping/ByValueSpent', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('shipping/ByValueSpent', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['ByValueSpent_tax_class_id'])) {
            $data['ByValueSpent_tax_class_id'] = $this->request->post['ByValueSpent_tax_class_id'];
        } else {
            $data['ByValueSpent_tax_class_id'] = $this->config->get('ByValueSpent_tax_class_id');
        }

        //rule 1
        if (isset($this->request->post['ByValueSpent_'])) {
            $data['ByValueSpent_rule'] = $this->request->post['ByValueSpent_'];
        } else {
            $data['ByValueSpent_rule'] = $this->config->get('ByValueSpent_');
        }
        $data['ByValueSpent_rule'] = json_decode($data['ByValueSpent_rule']);

        if (isset($this->request->post['ByValueSpent_status'])) {
            $data['ByValueSpent_status'] = $this->request->post['ByValueSpent_status'];
        } else {
            $data['ByValueSpent_status'] = $this->config->get('ByValueSpent_status');
        }

        $this->load->model('localisation/tax_class');
        $data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('shipping/ByValueSpent', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'shipping/ByValueSpent')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>