<?php

namespace System\Engine;

final class Registry {
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
}