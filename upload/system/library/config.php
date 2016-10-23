<?php

namespace System\Library;

class Config {

    private $data = array();

    /**
     * 
     * @param type $key
     * @return type
     */
    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }

    /**
     * 
     * @param type $key
     * @param type $value
     */
    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function has($key) {
        return isset($this->data[$key]);
    }

    /**
     * 
     * @param type $filename
     */
    public function load($filename) {
        $file = DIR_CONFIG . $filename . '.php';

        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);
        } else {
            trigger_error('Error: Could not load config ' . $filename . '!');
            exit();
        }
    }

}
