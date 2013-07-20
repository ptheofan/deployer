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
    'import' => array(
	    'ext.giix-components.*', // giix components
    ),
    'modules'=>array(
        // uncomment the following to enable the Gii tool
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths' => array(
                'ext.giix-core', // giix generators
            ),
        ),
    ),
    'components' => array(
        // uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=deployer',
            'username' => 'root',
            'password' => '',
        ),
    ),
);