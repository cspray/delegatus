<?php

/**
 * @license See LICENSE in source root
 * @version 0.1.0
 * @since   0.1.0
 */

namespace Delegatus;

use Delegatus\Exception\MethodNotFoundException;

trait Delegator {

    private $delegates = [];

    /**
     * @param $object
     * @param array $methods
     * @throws Exception\MethodNotFoundException
     */
    protected function delegate($object, array $methods) {
        foreach ($methods as $method) {
            if (!method_exists($object, $method)) {
                $msg = sprintf('Could not find "%s" method on delegate of type "%s"', $method, get_class($object));
                throw new MethodNotFoundException($msg);
            }
            $this->delegates[$method] = $object;
        }
    }

    /**
     * @param $method
     * @param array $args
     * @return mixed
     * @throws Exception\MethodNotFoundException
     */
    function __call($method, array $args) {
        if (array_key_exists($method, $this->delegates)) {
            $delegate = $this->delegates[$method];
            return call_user_func_array([$delegate, $method], $args);
        }

        throw new MethodNotFoundException(sprintf('Could not find "%s" method.', $method));
    }

}
