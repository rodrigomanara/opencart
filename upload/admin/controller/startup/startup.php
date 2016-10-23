<?php

namespace Admin\Controller\Startup;

use System\Engine\AdminController;
use System\Library\Language;
use System\Library\Openbay;
use System\Library\Encryption;
use System\Library\Cart\Affiliate;
use System\Library\Cart\Currency;
use System\Library\Cart\Customer;
use System\Library\Cart\Tax;
use System\Library\Cart\Cart;
use System\Library\Cart\Weight;
use System\Library\Cart\Length;



class Startup extends AdminController {

    public function index() {
        // Settings
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0'");

        foreach ($query->rows as $setting) {
            if (!$setting['serialized']) {
                $this->config->set($setting['key'], $setting['value']);
            } else {
                $this->config->set($setting['key'], json_decode($setting['value'], true));
            }
        }

        // Language
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE code = '" . $this->db->escape($this->config->get('config_admin_language')) . "'");

        if ($query->num_rows) {
            $this->config->set('config_language_id', $query->row['language_id']);
        }

        // Language
        $language = new Language($this->config->get('config_admin_language'));
        $language->load($this->config->get('config_admin_language'));
        $this->registry->set('language', $language);

        // Customer
        $this->registry->set('customer', new Customer($this->registry));

        // Affiliate
        $this->registry->set('affiliate', new Affiliate($this->registry));

        // Currency
        $this->registry->set('currency', new Currency($this->registry));

        // Tax
        $this->registry->set('tax', new Tax($this->registry));

        if ($this->config->get('config_tax_default') == 'shipping') {
            $this->tax->setShippingAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
        }

        if ($this->config->get('config_tax_default') == 'payment') {
            $this->tax->setPaymentAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
        }

        $this->tax->setStoreAddress($this->config->get('config_country_id'), $this->config->get('config_zone_id'));

        // Weight
        $this->registry->set('weight', new Weight($this->registry));

        // Length
        $this->registry->set('length', new Length($this->registry));

        // Cart
        $this->registry->set('cart', new Cart($this->registry));

        // Encryption
        $this->registry->set('encryption', new Encryption($this->config->get('config_encryption')));

        // OpenBay Pro
        $this->registry->set('openbay', new Openbay($this->registry));
    }

}
