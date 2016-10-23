<?php

namespace System\Library;

class Language {
	private $default = 'en-gb';
	private $directory;
	private $data = array();
        
        /**
         * 
         * @param type $directory
         */
	public function __construct($directory = '') {
		$this->directory = $directory;
	}
        /**
         * 
         * @param type $key
         * @return type
         */
	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : $key);
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
         * @return type
         * @deprecated new version 3.0 <p>Please dont use the below function i'm thinking getting rid of it.</p>
         */
        public function all() {
		return $this->data;
	}
	
	// 
	/**
         * @param type $data
         * @deprecated new version 3.0 <p>Please dont use the below function i'm thinking getting rid of it.</p>
         */
        public function merge(&$data) {
		array_merge($this->data, $data);
	}
	/**
         * 
         * @param type $filename
         * @param type $data
         * @return type
         */		
	public function load($filename, &$data = array()) {
		$_ = array();

		$file = DIR_LANGUAGE . 'english/' . $filename . '.php';
		
		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . 'english/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			require($file);
		} elseif (is_file($old_file)) {
			require($old_file);
		}

		$file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';

		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . $this->default . '/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			require($file);
		} elseif (is_file($old_file)) {
			require($old_file);
		}

		$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';

		// Compatibility code for old extension folders
		$old_file = DIR_LANGUAGE . $this->directory . '/' . str_replace('extension/', '', $filename) . '.php';
		
		if (is_file($file)) {
			require($file);
		} elseif (is_file($old_file)) {
			require($old_file);
		}

		$this->data = array_merge($this->data, $_);

		return $this->data;
	}
}
