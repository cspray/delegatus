<?php

/**
 * @license See LICENSE in source root
 * @version 0.1.0
 * @since   0.1.0
 */

namespace Delegatus\Unit;

use Delegatus\Stub\FooDelegator;
use Delegatus\Stub\FooService;
use Delegatus\Stub\InvalidDelegator;
use PHPUnit_Framework_TestCase as UnitTestCase;

class DelegatorTest extends UnitTestCase {

    private function getFooDelegator() {
        $service = new FooService();
        return new FooDelegator($service);
    }

    private function getInvalidDelegator() {
        $service = new FooService();
        return new InvalidDelegator($service);
    }

    function testMethodNotDelegatedThrowsException() {
        $delegator = $this->getFooDelegator();
        $this->setExpectedException('Delegatus\\Exception\\MethodNotFoundException', 'Could not find "bar" method.');
        $delegator->bar();
    }

    function testMethodDelegatedReturnsValue() {
        $delegator = $this->getFooDelegator();
        $actual = $delegator->foo();
        $this->assertEquals('foo', $actual);
    }

    function testDelegateDoesNotHaveMethodThrowsException() {
        $msg = 'Could not find "notFound" method on delegate of type "Delegatus\\Stub\\FooService"';
        $this->setExpectedException('Delegatus\\Exception\\MethodNotFoundException', $msg);
        $this->getInvalidDelegator();
    }


} 
