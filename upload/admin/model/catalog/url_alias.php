<?php

namespace Admin\Model\Catalog;

use System\Engine\Model;

class UrlAlias extends Model {

    public function getUrlAlias($keyword) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "'");

        return $query->row;
    }

}
