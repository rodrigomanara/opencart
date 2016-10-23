<?php

namespace System\Engine;

use System\Engine\Action;
use System\Library\Template;
use System\Library\Request;

final class Loader {

    protected $registry;

    public function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     * 
     * @param type $route
     * @param type $data
     * @return boolean|\Symtem\Engine\Exception
     */
    public function controller($route, $data = array()) {
        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route);

        $output = null;

        // Trigger the pre events
        $result = $this->registry->get('event')->trigger('controller/' . $route . '/before', array(&$route, &$data, &$output));

        if ($result) {
            return $result;
        }

        if (!$output) {
            $action = new Action($route , new Request());
            $output = $action->execute($this->registry, array(&$data));
        }

        // Trigger the post events
        $result = $this->registry->get('event')->trigger('controller/' . $route . '/after', array(&$route, &$data, &$output));

        if ($output instanceof Exception) {
            return false;
        }

        return $output;
    }

    /**
     * 
     * @param type $route
     * @throws \Exception
     */
    public function model($route) {
        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route);

        // Trigger the pre events
        $this->registry->get('event')->trigger('model/' . $route . '/before', array(&$route));

        if (!$this->registry->has('model_' . str_replace(array('/', '-', '.'), array('_', '', ''), $route))) {
            $file = DIR_APPLICATION . 'model/' . $route;

            $namespace = explode("upload/", $file)[1];
            $namespace = explode("/", $namespace);

            $buildClass = array();
            foreach ($namespace as $name) {
                $buildClass[] = ucfirst($name);
            }

            $namespace = implode("\\", $buildClass);

            $reflectionClass = new \ReflectionClass($namespace);

            $proxy = new Proxy();

            foreach (get_class_methods($namespace) as $method) {
                $proxy->{$method} = $this->callback($this->registry, $route . '/' . $method);
            }

            $this->registry->set('model_' . str_replace(array('/', '-', '.'), array('_', '', ''), (string) $route), $proxy);
        }

        // Trigger the post events
        $this->registry->get('event')->trigger('model/' . $route . '/after', array(&$route));
    }

    /**
     * 
     * @param type $route
     * @param type $data
     * @return type
     */
    public function view($route, array $data = array(), $engine = null) {

        if (is_null($engine))
            $engine = $this->registry->get('config')->get('template_type');

        $output = null;

        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route);

        // Trigger the pre events
        $result = $this->registry->get('event')->trigger('view/' . $route . '/before', array(&$route, &$data, &$output));

        if ($result) {
            return $result;
        }

        if (!$output) {
            $template = new Template($engine);
          
            foreach ($data as $key => $value) {
                $template->set($key, $value);
            }
            $output = $template->render($route);
        }

        // Trigger the post events
        $result = $this->registry->get('event')->trigger('view/' . $route . '/after', array(&$route, &$data, &$output));

        if ($result) {
            return $result;
        }

        return $output;
    }

    /**
     * 
     * @param type $route
     * @throws \Exception
     */
    public function library($route) {
        // Sanitize the call
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route);

        $file = DIR_SYSTEM . 'library/' . $route . '.php';
        $class = str_replace('/', '\\', $route);

        if (is_file($file)) {
            include_once($file);

            $this->registry->set(basename($route), new $class($this->registry));
        } else {
            throw new \Exception('Error: Could not load library ' . $route . '!');
        }
    }

    /**
     * 
     * @param type $route
     * @throws \Exception
     */
    public function helper($route) {
        $file = DIR_SYSTEM . 'helper/' . preg_replace('/[^a-zA-Z0-9_\/]/', '', (string) $route) . '.php';

        if (is_file($file)) {
            include_once($file);
        } else {
            throw new \Exception('Error: Could not load helper ' . $route . '!');
        }
    }

    /**
     * 
     * @param type $route
     */
    public function config($route) {
        $this->registry->get('event')->trigger('config/' . $route . '/before', array(&$route));

        $this->registry->get('config')->load($route);

        $this->registry->get('event')->trigger('config/' . $route . '/after', array(&$route));
    }

    /**
     * 
     * @param type $route
     * @return type
     */
    public function language($route) {
        $output = null;
        $this->registry->get('event')->trigger('language/' . $route . '/before', array(&$route, &$output));
        $output = $this->registry->get('language')->load($route);
        $this->registry->get('event')->trigger('language/' . $route . '/after', array(&$route, &$output));

        return $output;
    }

    /**
     * 
     * @param type $registry
     * @param type $route
     * @return type
     */
    protected function callback($registry, $route) {
        return function($args) use($registry, &$route) {
            static $model = array();

            $output = null;

            // Trigger the pre events
            $result = $registry->get('event')->trigger('model/' . $route . '/before', array(&$route, &$args, &$output));

            if ($result) {
                return $result;
            }

            // Store the model object
            if (!isset($model[$route])) {
                $file = DIR_APPLICATION . 'model/' . substr($route, 0, strrpos($route, '/'));

                $namespace = explode("upload/", $file)[1];
                $namespace = explode("/", $namespace);

                $buildClass = array();
                foreach ($namespace as $name) {
                    $buildClass[] = ucfirst($name);
                }

                $namespace = implode("\\", $buildClass);
                $reflectionClass = new \ReflectionClass($namespace);

                $model[$route] = new $reflectionClass->name($registry);
            }

            $method = substr($route, strrpos($route, '/') + 1);

            $callable = array($model[$route], $method);

            if (is_callable($callable)) {
                $output = call_user_func_array($callable, $args);
            } else {
                throw new \Exception('Error: Could not call model/' . $route . '!');
            }

            // Trigger the post events
            $result = $registry->get('event')->trigger('model/' . $route . '/after', array(&$route, &$args, &$output));

            if ($result) {
                return $result;
            }

            return $output;
        };
    }

}
