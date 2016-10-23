<?php

namespace System\Library;

class Cache {

    /**
     *
     * @var type 
     */
    private $adaptor;

    /**
     * 
     * @param type $adaptor
     * @param type $expire
     * @throws \Exception
     */
    public function __construct($adaptor, $expire = 3600) {
        $class = 'Cache\\' . $adaptor;

        if (class_exists($class)) {
            $this->adaptor = new $class($expire);
        } else {
            throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
        }
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function get($key) {
        return $this->adaptor->get($key);
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public function set($key, $value) {
        return $this->adaptor->set($key, $value);
    }

    /**
     * 
     * @param type $key
     * @return type
     */
    public function delete($key) {
        return $this->adaptor->delete($key);
    }

}
