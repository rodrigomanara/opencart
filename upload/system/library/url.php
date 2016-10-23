<?php

namespace System\Library;

class Url {

    private $url;
    private $ssl;
    private $rewrite = array();

    /**
     * 
     * @param type $url
     * @param type $ssl
     */
    public function __construct($url, $ssl = '') {
        $this->url = $url;
        $this->ssl = $ssl;
    }

    /**
     * 
     * @param type $rewrite
     */
    public function addRewrite($rewrite) {
        $this->rewrite[] = $rewrite;
    }

    /**
     * 
     * @param type $route
     * @param type $args
     * @param type $secure
     * @return type
     */
    public function link($route, $args = '', $secure = false) {
        if ($this->ssl && $secure) {
            $url = $this->ssl . 'index.php?route=' . $route;
        } else {
            $url = $this->url . 'index.php?route=' . $route;
        }

        if ($args) {
            if (is_array($args)) {
                $url .= '&amp;' . http_build_query($args);
            } else {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
            }
        }

        foreach ($this->rewrite as $rewrite) {
            $url = $rewrite->rewrite($url);
        }

        return $url;
    }

}
