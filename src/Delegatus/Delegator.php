<?php

/**
 * @license See LICENSE in source root
 * @version 0.1.0
 * @since   0.1.0
 */

namespace Delegatus;

use Delegatus\Exception\MethodNotFoundException;

trait Delegator {

    private $_delegates = [];

    /**
     * @param array $methods
     * @param object $object
     * @throws Exception\MethodNotFoundException
     */
    protected function delegateToObject(array $methods, $object) {
        foreach ($methods as $method) {
            if (!method_exists($object, $method)) {
                $msg = sprintf('Could not find "%s" method on delegate of type "%s"', $method, get_class($object));
                throw new MethodNotFoundException($msg);
            }
            $this->_delegates[$method] = [$object, $method];
        }
    }

    /**
     * @param array $methods
     * @param callable $cb
     */
    protected function delegateToCallable(array $methods, callable $cb) {
        foreach ($methods as $method) {
            $this->_delegates[$method] = $cb;
        }
    }

    /**
     * @param $method
     * @param array $args
     * @return mixed
     * @throws Exception\MethodNotFoundException
     */
    function __call($method, array $args) {
        if (array_key_exists($method, $this->_delegates)) {
            return call_user_func_array($this->_delegates[$method], $args);
        }

        throw new MethodNotFoundException(sprintf('Could not find "%s" method.', $method));
    }

}
