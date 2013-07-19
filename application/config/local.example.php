<?php
/**
 * User: Paris Theofanidis
 * Date: 20/07/2013
 * Time: 1:37 AM
 */

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

return array(
    'components' => array(
        // uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=deployer',
            'username' => 'root',
            'password' => '',
        ),
    ),
);