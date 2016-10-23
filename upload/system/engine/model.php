<?php

namespace System\Engine;


abstract class Model {
	protected $registry;
        /**
         * 
         * @param type $registry
         */
	public function __construct($registry) {
		$this->registry = $registry;
	}
        /**
         * 
         * @param type $key
         * @return type
         */
	public function __get($key) {
		return $this->registry->get($key);
	}
        /**
         * 
         * @param type $key
         * @param type $value
         */
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}