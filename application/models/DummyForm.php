<?php
/**
 * User: Paris Theofanidis
 * Date: 19/07/2013
 * Time: 12:22 AM
 */

class DummyForm extends CModel {

    public function behaviors() {
        return array(
            'StrictTypeBehaviour' => array(
                'class' => 'ext.StrictTypeBehaviour',
                'attributes' => array(
                    'var1' => array('instanceof', 'class' => 'DateTimeEx', 'autoGenerate' => true)
                )
            ),
        );
    }

    public function attributeNames() {

    }
}