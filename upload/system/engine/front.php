<?php

namespace System\Engine;

use System\Engine\Action;

final class Front {

    private $registry;
    private $pre_action = array();
    private $error;

    /**
     * 
     * @param type $registry
     */
    public function __construct($registry) {
        $this->registry = $registry;
    }

    /**
     * 
     * @param \Symtem\Engine\Action $pre_action
     */
    public function addPreAction(Action $pre_action) {
        $this->pre_action[] = $pre_action;
    }

    /**
     * 
     * @param \Symtem\Engine\Action $action
     * @param \Symtem\Engine\Action $error
     */
    public function dispatch(Action $action, Action $error) {
        $this->error = $error;

        foreach ($this->pre_action as $pre_action) {
            $result = $this->execute($pre_action);

            if ($result instanceof Action) {
                $action = $result;

                break;
            }
        }

        while ($action instanceof Action) {
            $action = $this->execute($action);
        }
    }

    /**
     * 
     * @param \Symtem\Engine\Action $action
     * @return \Symtem\Engine\Action
     */
    private function execute(Action $action) {
        $result = $action->execute($this->registry);

        if ($result instanceof Action) {
            return $result;
        }

        if ($result instanceof Exception) {
            $action = $this->error;

            $this->error = null;

            return $action;
        }
    }

}
