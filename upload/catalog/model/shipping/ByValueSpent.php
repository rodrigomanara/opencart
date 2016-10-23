<?php

class ModelShippingByValueSpent extends Model {

    function getQuote($address) {
        $this->language->load('shipping/ByValueSpent');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('ByValueSpent_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");
        
        if (!$this->config->get('ByValueSpent_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $quote_data = array();
        $method_data = array();

        if ($status) {

            $subtotal = $this->cart->getSubTotal();

            /** *** rules ***** */
            $rules = $this->config->get('ByValueSpent_');
            $rules = json_decode($rules);
            
            foreach ($rules as $rule) {

                if ((float)$subtotal >= (float)$rule->subTotal->min  and (float)$subtotal <= (float)$rule->subTotal->max) {
                    $quote_data['ByValueSpent'] = array(
                        'code' => 'ByValueSpent.ByValueSpent',
                        'title' => $this->language->get('text_description'),
                        'cost' => $rule->cost->value,
                        'tax_class_id' => $this->config->get('ByValueSpent_tax_class_id'),
                        'text' => $this->currency->format(
                                    $this->tax->calculate($rule->cost->value
                                            , $this->config->get('ByValueSpent_tax_class_id')
                                            , $this->config->get('config_tax'))
                                            , $this->session->data['currency']
                                )
                        
                    );
                }
            }


            $method_data = array();

            if ($quote_data) {
                
                $method_data = array(
                    'code' => 'ByValueSpent',
                    'title' => $this->language->get('text_title'),
                    'quote' => $quote_data,
                    'sort_order' => $this->config->get('ByValueSpent_sort_order'),
                    'error' => FALSE
                );
            }

            return $method_data;
        }
    }

}

?>
