<?php

namespace System\Engine;

use System\Library\Request;

class Action {

    private $request;
    private $id;
    private $route;
    private $method = 'index';

    /**
     * 
     * @param type $route
     */
    public function __construct($route, Request $request) {
        $this->request = $request;
        $this->id = $route;

        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route));

        // Break apart the route
        while ($parts) {
            $file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';

            if (is_file($file)) {
                $this->route = implode('/', $parts);

                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    /**
     * 
     * @return type
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    private function fixNameSpace() {

        $namespace = ucfirst(preg_replace('/[^a-zA-z0-9]|(index)|(php)/', '', $this->request->server['PHP_SELF']));
        $namespace .= DIRECTORY_SEPARATOR . "Controller" . DIRECTORY_SEPARATOR;


        $route = array();
        $fixroute = explode("/", $this->route);
        foreach ($fixroute as $value) {
            $route[] = ucfirst($value);
        }
        $this->route = implode("/", $route);


        if (preg_match('/[_]/', $this->route)) {

            $fix = explode("_", $this->route);
            foreach ($fix as $value) {
                $namespace .= ucfirst($value);
            }
        } else {
            $namespace.= ucfirst($this->route);
        }

        $namespace = str_replace("/", "\\", $namespace);

        return $namespace;
    }

    /**
     * 
     * @param type $registry
     * @param array $args
     * @return \Exception
     */
    public function execute($registry, array $args = array()) {


        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            return new \Exception('Error: Calls to magic methods are not allowed!');
        }

        if (!is_null($this->route)) {
            $namespace = $this->fixNameSpace();
            $reflection = new \ReflectionClass($namespace);

            if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
                return call_user_func_array(array(new $reflection->name($registry), $this->method), $args);
            } else {
                return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
            }
        }
    }

}
