<?php
/**
 * User: Paris Theofanidis
 * Date: 19/07/2013
 * Time: 12:16 AM
 */

class StrictTypeBehaviour extends CModelBehavior {
    private $_m;

    public function setAttributes(array $attributes) {
        $this->_m = $attributes;
    }

    public function getAttributes() {
        return $this->_m;
    }

    public function __get($key) {
        die('get');
    }

    public function __set($key, $value) {
        die('set');
    }
}